<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 全局搜索
 * Enter description here ...
 * @author liuGC
 * @access public 
 * @version 1.0
 * @since 2012/03/24
 * @description  全局搜索Controller控制器 
 * @history <author><access><version><dateline><descrition>
 */
class Search extends MY_Controller
{
	//访问的个应用名
	private $point = array('globals', 'people', 'website', 'status', 'photo', 'album',
							 'video', 'blog', 'answer', 'event',  'field');
	//ajax请求 每次10条
	private $ajax_limit = 10;
	
	//跳转页面显示30条
	private $limit = 10;
	
	private $keyword = null;
	
	/**
	 * 搜索主方法
	 * Enter description here ...
	 * @desciption 搜索主入口方法
	 */
	public function main()
	{	
		$type = trim(strtolower($this->input->get('type')));
		if (in_array($type, $this->point))
		{
			$this->keyword = getStringSplicedByChar(trim($this->input->get_post('term')), 50, '');
			$this->assign('app_url_list', $this->getEveryAppUrlList($this->keyword));
			if ($this->isAjax() === false)
			{
				$keyword = str_replace('&', '&amp;', $this->keyword);
				$keyword = str_replace(array('"',"'"), array('&quot;','&#039;'), $keyword);
				$this->assign('keyword', $keyword);
				$this->assign('user_name', $this->user['username']);
				$this->assign('user_avatar', get_avatar($this->uid));
				$this->assign('user_url', DEV_DUANKOU_ROOT.'main/?action_dkcode='.$this->dkcode);
			}
			$this->load->helper('Search');
			$this->load->model('globalmodel');
			$this->$type();
			exit;
		}
		echo "<script type='text/javascript'>window.location.href=\"".DEV_DUANKOU_ROOT."main/?c=search&m=main&type=globals&init=".time()."\"</script>";
		exit;
	}
	
	
	/**
	 * 头部输入框搜索
	 * 
	 * Enter description here ...
	 */
	protected function field()
	{
		if ($this->keyword  == null)
		{
			echo json_encode(array($this->lastRow()));
			exit;
		}
		$result = call_soap("search", "Global", "getPeopleAndWebsite", array($this->keyword , $this->uid));
		if ($result)
		{
			$result['list'] = $this->getResultInfoPeopleAndWebsite(json_decode($result['people']), json_decode($result['website']));
			GlobalModel::setAddKeys('src', array('user_dkcode'=>'getUserAvatar', 'web_id'=>'getWebpageFace'));
			GlobalModel::setAddKeys('url', array('user_dkcode'=>'getUserHomePageUrl', 'web_id'=>'getWebpageUrl'));	
			GlobalModel::setUpdateKeys('id', array('user_id','web_id'));
			GlobalModel::setUpdateKeys('value', array('userinfo_user_name', 'name'));
			GlobalModel::setUpdateKeys('label', array('userinfo_user_name', 'name'));
			GlobalModel::setUpdateKeys('fans_count', array('fansCount'));
			GlobalModel::setDeleteKeys(array('user_id', 'userinfo_user_name', 'user_dkcode','web_id', 'name','fansCount'));
			GlobalModel::parseSolrResult($result);
			$return = GlobalModel::getResultByArray();
		
			array_push($return, $this->lastRow($this->keyword , count($result['list'])));
			echo json_encode($return);
		}else{
			echo json_encode(array($this->lastRow($this->keyword , 0)));
		}
		exit;
	}
	
	/**
	 * 主页面全部搜索
	 * 
	 * Enter description here ...
	 */
	protected function globals()
	{
		//ajax 操作
		if ($this->isAjax())
		{  
			if ($this->keyword  != null)
			{   
				$type = $this->input->post('app');
				$page = $this->input->post('page') > 0  ? $this->input->post('page') : 1;
				$start =($page - 1)*10 + 2;
				$ajax_request = $this->getSearchListInfo($this->keyword , $start, 10, $type);
				$data['list'] = $ajax_request->response->docs;
				$data['total'] = $ajax_request->response->numFound;
				$this->getInfoByGlobalModel($data, $type);
				$data['data']=GlobalModel::getResultByArray();
				$data['last'] = GlobalModel::isLastPage($page,10,2);
				$data['state'] = 1;
				unset($data['list']);
				echo json_encode($data);
				exit;
			}
		}else{	
			//跳转页面操作
			$result = array();
			if ($this->keyword  == null )
			{   
				$this->assign('isEmpty', true);
				$this->assign('keyword', $this->keyword );
				$this->display('search/index.html');
				exit;
			}

			$result = call_soap('search', 'Global', 'getEachApplication', array($this->keyword , $this->uid));
			
			if ($result !== false && count($result) > 0)
			{
				foreach ($result as $key => $val)
				{
					$result[$key]['list'] = json_decode($result[$key]['list']);
					$this->getInfoByGlobalModel($result[$key], $result[$key]['type']);
					$result[$key]['list'] = GlobalModel::getResultByArray();
				}
				
				$this->assign('globals',  $result);
				$this->assign('isEmpty', false);
				$this->display("search/index.html");
			}else{
				$this->assign('isEmpty', true);
				$this->display('search/index.html');
			}
		}
	}
	
	/**
	 * 主页面video搜索
	 * 
	 * Enter description here ...
	 */
	protected function video()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(6);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('total', 0);
				$this->assign('isEmpty', true);
				$this->display('search/video.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 6);
				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('video', 'video', 6, $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/video.html');
				}
			}	
		}	
	}
	
	/**
	 * 主页面album搜索
	 * 
	 * Enter description here ...
	 */
	protected function album()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(5);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('total', 0);				
				$this->assign('isEmpty', true);
				$this->display('search/album.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 5);
				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('album', 'album', 5, $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/album.html');
				}
			}	
		}			
	}
	
	/**
	 * 主页面相片搜索
	 * 
	 * Enter description here ...
	 */
	protected function photo()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(4);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('total', 0);				
				$this->assign('isEmpty', true);
				$this->display('search/photo.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 4);
				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('photo', 'photo', 4, $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/photo.html');
				}
			}	
		}		
	}
	
	/**
	 * 主页面网页搜索
	 * 
	 * Enter description here ...
	 */
	protected function website()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(2);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('total', 0);				
				$this->assign('isEmpty', true);
				$this->display('search/webpage.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword, 0, $this->limit, 2);
				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('webpage', 'webpage', 2, $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/webpage.html');
				}
			}	
		}			
	}
	
	/**
	 * 主页面时间线搜索
	 * 
	 * Enter description here ...
	 */
	protected function status()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(3);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{   
				$this->assign('total', 0);				
				$this->assign('isEmpty', true);
				$this->display('search/status.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 3);

				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('status', 'status', 3, $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/status.html');
				}
			}	
		}		
	}
	
	/**
	 * 主页面人名搜索
	 * 
	 * Enter description here ...
	 */
	protected function people()
	{	
		if ($this->isAjax())
		{
			$this->showAjaxResponse(1);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('isEmpty', true);
				$this->assign('total', 0);
				$this->display('search/user.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 1);

				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('people', 'user', 1,  $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/user.html');
				}
			}	
		}
	}
			
	/**
	 * 主页面活动搜索
	 * 
	 * Enter description here ...
	 */
	protected function event()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(9);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('isEmpty', true);
				$this->assign('total', 0);
				$this->display('search/activity.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 9);
				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('event', 'activity', 9,  $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/activity.html');
				}
			}	
		}	
	}
	
	/**
	 * 主页面博客搜索
	 * 
	 * Enter description here ...
	 */
	protected function blog()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(7);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('total', 0);
				$this->assign('isEmpty', true);
				$this->display('search/blog.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 7);
				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('blog', 'blog', 7, $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/blog.html');
				}
			}	
		}			
	}
	
	/**
	 * 主页面问答搜索
	 * 
	 * Enter description here ...
	 */
	protected function answer()
	{
		if ($this->isAjax())
		{
			$this->showAjaxResponse(8);
		}else{
			$return=array();
			if ($this->keyword  == null)
			{
				$this->assign('total', 0);
				$this->assign('isEmpty', true);
				$this->display('search/ask.html');
			}else{
				$return = $this->getSearchListInfo($this->keyword , 0, $this->limit, 8);
				if (isset($return->response->numFound) && $return->response->numFound > 0)
				{
					$this->showLocationInfo('ask', 'ask', 8, $return);
				}else{
					$this->assign('total', 0);
					$this->assign('isEmpty', true);
					$this->display('search/ask.html');
				}
			}	
		}		
	}
	
	protected function showAjaxResponse($app_no)
	{
			$page = $this->input->post('page') > 0  ? $this->input->post('page') : 1;
			$start =($page - 1)*$this->ajax_limit + $this->limit;
			$return = $this->getSearchListInfo($this->keyword , $start, $this->ajax_limit, $app_no);
			$result['list']=$return->response->docs;
			$result['total'] = $return->response->numFound;
			$this->getInfoByGlobalModel($result, $app_no);
			$data['data'] = GlobalModel::getResultByArray();
			$data['last'] = GlobalModel::isLastPage($page, $this->ajax_limit, $this->limit);
			$data['state'] = count($data['data']) > 0 ? 1 : 0;
			echo json_encode($data);
			exit;		
	}
	
	protected function showLocationInfo($var_name, $app_name , $app_no,$return)
	{
			$result['list']=$return->response->docs;
			$result['total'] = $return->response->numFound;
			$this->getInfoByGlobalModel($result, $app_no);
			$this->assign('is_last_page', GlobalModel::isLastPage(1, $this->limit));
			$this->assign($var_name,GlobalModel::getResultByArray());
			$this->assign('total', $return->response->numFound);
			$this->assign('isEmpty', false);
			$this->display('search/'.$app_name.'.html');
	}
	
	/**
	 * 头部搜索框
	 * 
	 * Enter description here ...
	 * @param array $people 人名的数据
	 * @param array $website 网页的数据
	 */
	protected function getResultInfoPeopleAndWebsite($people=array(), $website=array())
	{
		$people_length = count($people);
		$website_length = count($website);

		if ($people_length >=4 && $website_length >= 4)
		{
			return array_merge(array_slice($people, 0, 4) , array_slice($website, 0, 4));
		}
		
		if ($people_length >= 4 && $website_length < 4)
		{
			return array_merge(array_slice($people, 0, 8 - $website_length) , $website);
		}
		
		if ($people_length < 4 && $website_length >= 4)
		{	
			return array_merge($people , array_slice($website, 0, 8 - $people_length));
		}
		
		return array_merge($people, $website);
	}
	
	/**
	 * 每个模块的搜索
	 * 
	 * Enter description here ...
	 * @param string $keyword 搜索的关键词
	 * @param int $start 搜索的起始页
	 * @param int $limit 搜索显示的条数
	 * @param int $type 搜索的板块
	 */
	private function getSearchListInfo($keyword, $start, $limit, $type)
	{
		$arguments = $type != 1 ? array($keyword, $start, $limit, true) : array($keyword, $this->uid, $start, $limit, true);
		switch ($type)
		{
			case 1:
				$return = call_soap('search', 'Global', 'getPeopleList', $arguments);
				break;
			case 2:
				$return = call_soap('search', 'Global', 'getWebPageList', $arguments);	
				break;			
			case 3:
				$return = call_soap('search', 'Global', 'getStatusList', $arguments);
				break;
			case 4:
				$return = call_soap('search', 'Global', 'getPhotoList', $arguments);
				break;
			case 5:
				$return =  call_soap('search', 'Global', 'getAlbumList', $arguments);
				break;
			case 6:
				$return = call_soap('search', 'Global', 'getVideoList', $arguments);
				break;
			case 7:
				$return = call_soap('search', 'Global', 'getBlogList', $arguments);
				break;
			case 8:
				$return = call_soap('search', 'Global', 'getQuestionAndAnswerList', $arguments);
				break;
			case 9:
				$return = call_soap('search', 'Global', 'getEventList', $arguments);
				break;
		}
		return json_decode($return);
	}
	
	/**
	 * 获取搜索数据并转换为前端可用的格式
	 * 
	 * Enter description here ...
	 * @param array $result 搜索一个应用的数据
	 * @param int $type 应用的类型值(1-9)
	 */
	protected function getInfoByGlobalModel($result, $type )
	{
		if (!class_exists('GlobalModel'))
		{
			$this->load->model('GlobalModel');
		}
				//给SEARCHHELPER中的当前用户ID赋值
				GlobalModel::setCurrentUserID($this->uid);
		switch ($type)
		{
			case 1://人名
				$result['list'] = $this->getRelationByArray($result['list'], 1);
				GlobalModel::setAddKeys('url', array('user_dkcode'=>'getUserHomePageUrl'));
				GlobalModel::setAddKeys('img', array('user_id'=>'getUserAvatar'));
				GlobalModel::setUpdateKeys('name_txt', array('userinfo_user_name'));
				GlobalModel::setUpdateKeys('uid', array('user_id'));
				GlobalModel::setAddKeys('self',array('user_id'=>'belongToMe'));
				GlobalModel::setDeleteKeys(array('userinfo_user_name', 'user_id', 'user_dkcode'));
				break;
			case 2://网页
				GlobalModel::setAddKeys('url', array('web_id'=>'getWebpageUrl'));	
				GlobalModel::setAddKeys('img', array('web_id'=>'getWebpageCoverFace'));
				GlobalModel::setAddKeys('self',array('web_id'=>'belongToMe'));
				GlobalModel::setUpdateKeys('f_uid', array('user_id'));
				GlobalModel::setUpdateKeys('fans_count', array('fansCount'));
				GlobalModel::setAddKeys('relation', array('web_id'=>'getRelationBetweenWebpageAndUser'));
				GlobalModel::setDeleteKeys(array('user_id', 'fansCount'));				
				break;
			case 3://状态
				GlobalModel::setAddKeys('url', array('user_dkcode'=>'getStatusPageUrl'));
				GlobalModel::setAddKeys('time', array('createTime'=>'getStatusTime'));
				GlobalModel::setAddKeys('text', array('status_type'=>'getStatusContentLength'));
				GlobalModel::setAddKeys('img', array('user_id'=>'getUserAvatar'));		
				GlobalModel::setAddKeys('fulltext', array('content'=>'getStatusContentFullText'));
				GlobalModel::setUpdateKeys('name_txt', array('status_name'));
				GlobalModel::setDeleteKeys(array('user_id', 'content', 'status_type', 'create_time', 'user_dkcode', 'status_name'));		
				break;
			case 4://图片
				GlobalModel::setAddKeys('img', array('file_name'=>'getImageUrl'));
				GlobalModel::setAddKeys('url', array('album_id'=>'getImagePageUrl'));
				GlobalModel::setAddKeys('name_txt', array('name'=>'getPhotoTitle'));
				GlobalModel::setAddKeys('fullname',array('name'=>'getPhotoFullName'));
				GlobalModel::setAddKeys('fulltext', array('description'=>'getPhotoDescriptionFullText'));
				GlobalModel::setAddKeys('text', array('description'=>'getPhotoDescriptionLength'));
				GlobalModel::setDeleteKeys(array('id', 'description','name', 'user_dkcode', 'file_name', 'photo_type', 'album_id'));				
				break;
			case 5://相册
				GlobalModel::setAddKeys('url', array('id'=>'getAlbumPageUrl'));
				GlobalModel::setAddKeys('img', array('id'=>'getAlbumCoverPhotoUrl'));
				GlobalModel::setAddKeys('fullname', array('name'=>'getAlbumFullName'));
				GlobalModel::setAddKeys('name_txt', array('name'=>'getAlbumTitle'));
				GlobalModel::setAddKeys('fulltext', array('description'=>'getAlbumDescriptionFullText'));
				GlobalModel::setUpdateKeys('count', array('photo_count'));
				GlobalModel::setAddKeys('text', array('description'=>'getAlbumDescriptionLenth'));
				GlobalModel::setDeleteKeys(array('id', 'description', 'user_dkcode','name', 'file_name', 'photo_type', 'id','photo_count'));
				break;
			case 6://视频
				GlobalModel::setAddKeys('url', array('id'=>'getVideoPageUrl'));
				GlobalModel::setAddKeys('text', array('discription'=>'getVideoDescriptionLength'));
				GlobalModel::setAddKeys('fulltext', array('discription'=>'getVideoDescriptionFullText'));
				GlobalModel::setAddKeys('img', array('id'=>'getVideoCoverPhotoUrl'));
				GlobalModel::setAddKeys('name_txt', array('title'=>'getVideoTitleLength'));
				GlobalModel::setAddKeys('fullname', array('title'=>'getVideoFullName'));
				GlobalModel::setDeleteKeys(array('discription', 'title', 'id', 'video_pic'));				
				break; 
			case 7://博客
				GlobalModel::setAddKeys('url', array('id'=>'getBlogArticlePageUrl'));
				GlobalModel::setAddKeys('text', array('summary'=>'getBlogArticleContentLength'));
				GlobalModel::setAddKeys('fulltext', array('summary'=>'getBlogContentFullText'));
				GlobalModel::setAddKeys('name_txt', array('title'=>'getBlogArticleTitleLength')); //文章标题
				GlobalModel::setAddKeys('fullname', array('title'=>'getBlogFullName'));
				GlobalModel::setUpdateKeys('author', array('user_name'));
				GlobalModel::setAddKeys('authorUrl', array('user_id'=>'getUserHomePageUrl'));
				GlobalModel::setDeleteKeys(array('user_name','summary', 'user_id', 'title', 'id'));	
				break;
			case 8://问答
				GlobalModel::setAddKeys('name_txt', array('title'=>'getQuestionAndAnswerName'));
				GlobalModel::setAddKeys('fullname', array('title'=>'getQAFullName'));
				GlobalModel::setAddKeys('ask', array('id'=>'getQuestionAndAnswerContent'));
				GlobalModel::setAddKeys('url', array('id'=>'getQuestionAndAnswerPageUrl'));			
				GlobalModel::setDeleteKeys(array('id', 'ask_option_list', 'title', 'multiple', 'total_votes'));
				break;
			case 9://活动
				GlobalModel::setAddKeys('fullname', array('name'=>'getEventFullName'));
				GlobalModel::setAddKeys('name_txt', array('name'=>'getEventTitle'));
				GlobalModel::setAddKeys('fulltext', array('starttime'=>'getEventStartTime'));
				GlobalModel::setAddKeys('url', array('id'=>'getEventPageUrl'));
				GlobalModel::setAddKeys('time', array('starttime'=>'getEventStartTime'));
				GlobalModel::setAddKeys('img', array('id'=>'getEventCoverUrl'));		
				GlobalModel::setDeleteKeys(array('id', 'starttime', 'fdfs_filename','name'));		
				break;				
		} 
		GlobalModel::parseSolrResult($result, $type);
	}
	
	/**
	 * 头部搜索最后显示行
	 * 
	 * Enter description here ...
	 * @param string $keyword 关键字
	 * @param string $type 搜索模块
	 */
	protected function lastRow($keyword=" ", $num=0)
	{	
		
		$format = str_replace('&', '&amp;', getStringSplicedByChar($keyword, 32, '**'));
		$format = str_replace(array('<','>'), array('&lt;','&gt;'),$format);
		return array(
		         'id' => 0,
		         'label' => '<b>查看更多有关 "'.$format.'" 的结果<u></u></b><i>显示前 '.$num.' 个结果</i>',
		         'src' => '',
		         'url' => WEB_ROOT.'main/?c=search&m=main&type=globals&term='.urlencode($keyword).'&init='.time(),
		         'value' => $format
		            );
	}
	/**
	 * 搜索页面下拉列表访问地址
	 * 
	 * Enter description here ...
	 * @param string $keyword 关键字
	 */
	protected function getEveryAppUrlList($keyword = null)
	{
		$path = WEB_ROOT.'main/?c=search&m=main&type=';
		$keyword = urlencode(trim($keyword));
		$keyword = $keyword == null ? '' : str_replace(array('"',"'"), array('&quot;','&#039;'), $keyword);
		$rand = '&init='.str_shuffle(str_repeat(time(), 2));
		$return = array(
				'globals' => $path.'globals&term='.$keyword.$rand,
				'people' => $path.'people&term='.$keyword.$rand,
				'website' => $path.'website&term='.$keyword.$rand,
				'status' =>$path.'status&term='.$keyword.$rand,
				'photo' =>$path.'photo&term='.$keyword.$rand,
				'album' =>$path.'album&term='.$keyword.$rand,
				'video' =>$path.'video&term='.$keyword.$rand,
				'blog' =>$path.'blog&term='.$keyword.$rand,
				'answer' =>$path.'answer&term='.$keyword.$rand,
				'event' =>$path.'event&term='.$keyword.$rand,
				);
		return $return;
	}
	
	public function getRelationByArray($array, $type=1,$name='user_id', $type_name ='type', $prefix='u',$relation='relation')
	{
		$relation_id = array();
		foreach ($array as  $val)
		{
			$relation_id[$val->$type_name][] = $val->$name;
		}

		$result = call_soap('social', 'Social',  'getMultiRelationStatus', array($this->uid, $relation_id[$type]));

		foreach ($array as $key => $val)
		{
			if ($val->$type_name == $type)
			{   
				$user_key = $prefix.$val->$name;
				$val->$relation = $result[$user_key];
				$array[$key]=$val;
			}
		}
		return $array;
	}
	
//	private function filterSubtleChar($keyword)
//	{
//		$search = '';
//		$replace = '';
//		$subject = $keyword;
//		$keyword = str_replace($search, $replace, $subject);
//		return $keyword;
//	}
}
?>
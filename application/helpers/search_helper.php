<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 全局搜索数组元素处理方法
 * Enter description here ...
 * @author liuGC
 * @access public
 * @version 1.0
 * @dateline 2012/03/28
 * @history <author><access><version><dateline>
 *
 */
class SearchHelper {
	//个人地址
	const PERSONAL_PATH=DEV_DUANKOU_ROOT;
	//网页地址
	const WEB_PATH = WEB_DUANKOU_ROOT;
	
	private $current_user_id = null;
	
	private $is_transfer = false;
	
	public function __construct($current_user_id = null){
		$this->current_user_id = $current_user_id;
	}
	
	//获取人名主页地址
	public function getUserHomePageUrl($user_data = array())
	{
		$path = self::PERSONAL_PATH.'main/';
		$query_string['action_dkcode'] = isset($user_data['user_dkcode']) ? $user_data['user_dkcode'] : '';
		$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;
	}
	
	//获取头像
	public function getUserAvatar($user_data = array())
	{
		$is_web = isset($user_data['person_web_type']) ? $user_data['person_web_type'] : false;
		$user_id = isset($user_data['user_id']) ? $user_data['user_id'] : '';
		$web_id = isset($user_data['web_id']) ? $user_data['web_id'] : '';
		if ($user_data['type'] == 3 && $is_web == 1)
				return get_webavatar($user_id, 'm', $web_id);
		return get_avatar($user_data['user_id'], 'm');
	}
	 
	//获取网页主页地址
	public function getWebpageUrl($webinfo)
	{
		$path = self::WEB_PATH.'main/';
		$query_string['web_id'] = isset($webinfo['web_id']) ? $webinfo['web_id'] : '';
		$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;
	}
	
	//是否为自己创建的网页
	public function belongToMe($info)
	{	
		$user_id = isset($info['user_id']) ? $info['user_id'] : '';
		return ($user_id == $this->current_user_id) ? true : false;
	}
	
	public function getWebpageFace($webinfo)
	{
		$web_id = isset($webinfo['web_id']) ? $webinfo['web_id'] : '';
		$user_id = isset($webinfo['user_id']) ? $webinfo['user_id'] : '';
		return get_webavatar($user_id, 's', $web_id);
	}
	
	public function getWebpageCoverFace($webinfo)
	{
		$web_id = isset($webinfo['web_id']) ? $webinfo['web_id'] : '';
		$user_id = isset($webinfo['user_id']) ? $webinfo['user_id'] : '';
		
		return get_webavatar($user_id, 'm', $web_id);		
	}
	
	public function getRelationBetweenWebpageAndUser($webinfo)
	{
		$web_id = isset($webinfo['web_id']) ? $webinfo['web_id'] : '';
	 	$boolean = call_soap('social', 'Webpage', 'isFollowing', array($this->current_user_id, $web_id));
	 	return $boolean ? '1' : '0';
	}
	
	//获取图片的地址
	public function getImageUrl($image_data = array())
	{
		$filename = isset($image_data['file_name']) ? $image_data['file_name'] : '';
		$type = isset($image_data['photo_type']) ? $image_data['photo_type'] : '';
		$group = isset($image_data['groupname']) ? $image_data['groupname'] : '';
		return $this->getThumbImageUrl($filename, $type, 'f', $group);
	}
	
	//获取图片网页地址
	public function getImagePageUrl($image_data = array())
	{
		$is_web = $image_data['person_web_type'] == 1 ? true : false;
		$path = self::PERSONAL_PATH.'single/album/index.php';
		$album['c'] = $photo['c'] = 'index';
		$album['m']='photoLists';
		$album['albumid'] = isset($image_data['album_id']) ? $image_data['album_id'] : '';
		$photo['m']='photoInfo';
		$photo['photoid'] = isset($image_data['id']) ? $image_data['id'] : '';

		if (!$is_web)
		{
			$album['action_dkcode'] = $photo['action_dkcode'] = isset($image_data['user_dkcode']) ? $image_data['user_dkcode'] : '';
		}else{
			$path = self::WEB_PATH.'web/album/index.php';
			$album['web_id'] = $photo['web_id'] = $photo_id['web_id'] = isset($image_data['web_id']) ? $image_data['web_id'] : '';
			$album['c']= $photo['c'] = 'photo';
			$album['m']='index';
			$photo['m']='get';
		}
		
		$photo_path = $this->getLocationOfAPPURL($path, $photo);
		$album['iscomment'] = 1;
		$album['jumpurl'] = urlencode($photo_path);
		$album_photo_path = $this->getLocationOfAPPURL($path, $album);
		return $album_photo_path;
	}
	
	//图片标题  solr转换字符已处理
	public function getPhotoTitle($photo_data = array())
	{
		if (isset($photo_data['name']))
		{			
			$name = $this->is_transfer ? $this->transferSpecialChar($photo_data['name']) : $photo_data['name'];
			$return = getStringSplicedByChar($name, 12, '......');
			$return = htmlspecialchars($return);
			return $return;
		}else{
			return '';
		}
	}
	
	//截取图片描述 solr转换字符未做处理
	public function getPhotoDescriptionLength($image_data = array())
	{
		if (isset($image_data['description']))
		{
			$discription = $this->transferSpecialChar($image_data['description']);			
			$return = getStringSplicedByChar($discription, 50, '......');
			return htmlspecialchars($return);
		}else{
			return '';
		}	
	}
	
	//获取状态页面地址
	public function getStatusPageUrl($status_data = array())
	{
		$is_web = $status_data['person_web_type'] == 1 ? true : false;
		if (!$is_web)
		{
			$path = (self::PERSONAL_PATH/*self::WEB_PATH*/).'main/';
			$query_string['action_dkcode'] = isset($status_data['user_dkcode']) ? $status_data['user_dkcode'] : '';
		}else{
			$path = self::WEB_PATH.'main/';
			$query_string['web_id'] = isset($status_data['web_id']) ? $status_data['web_id'] : '';
		}
		
		$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;
	}
	
	//状态发布时间
	public function getStatusTime($status_data = array())
	{
		return isset($status_data['createTime']) ? date('m', $status_data['createTime']).'月'.date('d', $status_data['createTime']).'日' : '';
	}
	
	//获取状态文字  solr转换字符已处理
	public function getStatusContentLength($status_data = array())
	{
		$content = isset($status_data['content']) ? $status_data['content'] : '';
	
		if ($content != '')
		{
			$content = $this->is_transfer ? $this->transferSpecialChar($content, false) : $content;
			$return = getStringSplicedByChar($content, 15, '......');
			$return=htmlspecialchars($return);
			return $return;
		}else{
			return '';
		}	
	}
	
	//获取相册封面地址
	public function getAlbumCoverPhotoUrl($album_data=array())
	{
		if (isset($album_data['file_name']) && isset($album_data['photo_type']))
		{
			return $this->getThumbImageUrl($album_data['file_name'], $album_data['photo_type'], 'f', $album_data['groupname']);
		}else{
			return self::PERSONAL_PATH.'misc/img/default/album_default.png';
		}
	}
	
	//获取相册地址
	public function getAlbumPageUrl($album_data =array())
	{
		$is_web = $album_data['person_web_type'] == 1 ? true : false;
		if (!$is_web)
		{
			$path = self::PERSONAL_PATH.'single/album/index.php';
			$query_string['c'] = 'index';
			$query_string['m'] = 'photoLists';
			$query_string['albumid'] = isset($album_data['id']) ? $album_data['id'] : '';
			$query_string['action_dkcode'] = isset($album_data['user_dkcode']) ? $album_data['user_dkcode'] : '';
		}else{
			$path = self::WEB_PATH.'web/album/index.php';
			$query_string['c'] = 'photo';
			$query_string['m'] = 'index';
			$query_string['albumid'] = isset($album_data['id']) ? $album_data['id'] : '';
			$query_string['web_id'] = isset($album_data['web_id']) ? $album_data['web_id'] : '';			
		}
			$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;	
	}
	
	//相册描述 solr转换字符未处理
	public function getAlbumDescriptionLenth($album_data = array())
	{
		$description = isset($album_data['description']) ? trim($album_data['description']) : '';
		if ($description != null)
		{
			$description = $this->transferSpecialChar($description);
			$return = getStringSplicedByChar($description, 50, '......');
			return htmlspecialchars($return);
		}else{
			return '';
		}
	}
	
	public function getAlbumTitle($album_data=array())
	{
		$title = isset($album_data['name']) ? $album_data['name'] : '';
		if ($title != null)
		{
			$title = $this->is_transfer ? $this->transferSpecialChar($title) : $title;
			$return = getStringSplicedByChar($title, 12, '......');
			$return = htmlspecialchars($return);
			return $return;
		}else{
			return '';
		}
	}
	
	//获取视频封面
	public function getVideoCoverPhotoUrl($video_data = array())
	{
		if (isset($video_data['video_pic'])){
			return config_item('video_pic_domain').$video_data['video_pic'];
		}else
			return '#';
	}
	
	//获取视频地址 
	public function getVideoPageUrl($video_data = array())
	{
		$is_web = $video_data['person_web_type'] == 1 ? true : false;
		$query_string['c']='video';
		$query_string['m']='player_video';
		$query_string['vid'] = isset($video_data['id']) ? $video_data['id'] : '';
		if (!$is_web)
		{
			$path = self::PERSONAL_PATH.'single/video/';
		}else{
			$path = self::WEB_PATH.'web/video/';
			$query_string['web_id'] = isset($video_data['web_id']) ? $video_data['web_id'] : '';
		}
		$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;
	}
	
	//视频描述 solr转换字符未做处理
	public function getVideoDescriptionLength($video_data = array())
	{
		$description = isset($video_data['discription']) ? $video_data['discription'] : '';
		if ($description != null)
		{
			$description = $this->transferSpecialChar($description);
			$return = getStringSplicedByChar($description, 50, '......');
			return htmlspecialchars($return);
		}else{
			return '';
		}
	}
	
	//视频标题  solr转换字符已处理
	public function getVideoTitleLength($video_data = array())
	{
		$title = isset($video_data['title']) ? $video_data['title'] : '';
		if ($title != null)
		{
			$title = $this->is_transfer ? $this->transferSpecialChar($title) : $title;
			$return = getStringSplicedByChar($title, 12, '......');
			$return = htmlspecialchars($return);
			return $return;
		}else{
			return '';
		}
	}
	
	//获取博客页面
	public function getBlogArticlePageUrl($blog_data = array())
	{
		$path = self::PERSONAL_PATH.'single/blog/';
		$query_string['c'] = 'blog';
		$query_string['m'] = 'main';
		$query_string['id'] = isset($blog_data['id']) ? $blog_data['id'] : '';
		$query_string['action_dkcode'] = isset($blog_data['user_dkcode']) ? $blog_data['user_dkcode'] : '';
		$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;
	}
	
	//博客文章标题 solr转换字符已做处理
	public function getBlogArticleTitleLength($blog_data = array())
	{
		$title = isset($blog_data['title']) ? $blog_data['title'] : '';
		if ($title != null)
		{
			$title = $this->is_transfer ? $this->transferSpecialChar($title) : $title;
			$return = getStringSplicedByChar($title, 12, '......');
			$return = htmlspecialchars($return);
			return $return;
		}else{
			return '';
		}	
	}
	
	//博客文章内容  solr转换字符未做处理
	public function getBlogArticleContentLength($blog_data = array())
	{
		$summary = isset($blog_data['summary']) ? $blog_data['summary'] : '';
		if ($summary != null)
		{
			$summary = $this->transferSpecialChar($summary);
			$summary = str_replace('&nbsp;', ' ', $summary);
			$preg = '/\{img\_\d{3}\}/i';
			$summary = preg_replace($preg, '', $summary);
			$return = htmlSubString($summary, 140);
			return $return[1] ? $return[0].'......' : $return[0];
		}else{
			return '';
		}	
		
	}
	
	//问答标题 转换字符已做处理
	public function getQuestionAndAnswerName($qa_data =array())
	{
		$title = isset($qa_data['title']) ? $qa_data['title'] : '';
		if ($title != null)
		{
			$title = $this->is_transfer ? $this->transferSpecialChar($title, false) : $title;
			$return = getStringSplicedByChar($title, 12, '......');
			$return = htmlspecialchars($return);
			return $return;
		}else{
			return '';
		}
	}
	
	//问答内容  转换字符未做处理
	public function getQuestionAndAnswerContent($qa_data = array())
	{
		$array = array();
		//单选还是多选
		$array['type'] = (int)$qa_data['multiple'] ;
		//是否显示更多连接
		if (!isset($qa_data['ask_option_list']))  
		{
			$array['more_link'] = false;
			$array['list']=array();
			return $array;
		}
		//计算投票总数
		if($array['type'] == 0)
		{
			$total_votes = isset($qa_data['totalVotes']) ? $qa_data['totalVotes'] : 0;
		}else{
			$total_votes = $this->getMaxValueByCheckbox($qa_data['ask_option_list']);
		}
		//问答显示内容
		foreach ($qa_data['ask_option_list'] as $key => $val)
		{
			$val = json_decode($val);
			if ($key > 3)
			{
				$array['more_link'] = true;
				unset($array['list'][3]);
				break;
			}else{
				$array['more_link'] = false;
			}
			$title = isset($val->option_message) ? $val->option_message : '';
			if ($title != null)
			{
				$title = $this->transferSpecialChar($title, false);
				$return = getStringSplicedByChar($title, 12, '......');
				$return = htmlspecialchars($return);
			}else{
				$fulltext = '';
				$return = '';
			}
			//计算百分比
			$percent = $total_votes == 0 ? 0 : $val->option_votes*100/$total_votes;
			$array['list'][$key] = array('name'=>$return, 
											 'fulltext'=>htmlspecialchars($title), 
											 'percent'=>$percent);
		}
		return $array;
	}
	
	//获取问答地址
	public function getQuestionAndAnswerPageUrl($qa_data = array())
	{
		$path = self::PERSONAL_PATH.'single/ask/';
		$dkcode = isset($qa_data['user_dkcode']) ? $qa_data['user_dkcode'] : '';
		$query_string['c'] = 'ask';
		$query_string['from'] = 'notice';
		$query_string['m'] = 'detail';
		$query_string['action_dkcode'] = $dkcode;
		$query_string['poll_id'] = isset($qa_data['id']) ? $qa_data['id'] : '';
		$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;
	}
	
	//活动标题 没有转换
	public function getEventTitle($event_data = array())
	{
		$title = isset($event_data['name']) ? $event_data['name'] : '';
		if ($title != null)
		{
			$return = getStringSplicedByChar($title, 12, '......');
			$return = htmlspecialchars($return);
			return $return;
		}else{
			return '';
		}
	}
	
	//获取活动地址
	public function getEventPageUrl($event_data = array())
	{
		$is_web = $event_data['person_web_type'] == 1 ? true : false;
		$query_string['c']='event';
		$query_string['m']='detail';
		if (!$is_web)
		{
			$path = self::PERSONAL_PATH.'single/event/';
			$query_string['id'] = isset($event_data['id']) ? $event_data['id'] : '';
		}else{
			$path = self::WEB_PATH.'web/event/';
			$query_string['id'] = isset($event_data['id']) ? $event_data['id'] : '';
			$query_string['web_id'] = isset($event_data['web_id']) ? $event_data['web_id'] : '';
		}
		$http_path = $this->getLocationOfAPPURL($path, $query_string);
		return $http_path;
	}
	
	//获取活动封面图
	public function getEventCoverUrl($event_data = array())
	{
		if (isset($event_data['fdfs_group']) && isset($event_data['fdfs_filename']) && !empty($event_data['fdfs_group']))
		{
			return "http://".config_item('fastdfs_host')."/".$event_data['fdfs_group']."/".$event_data['fdfs_filename'];
		}else{
			return self::PERSONAL_PATH.'misc/img/default/event.jpg';
		}
	}
	//活动开始时间
	public function getEventStartTime($status_data = array())
	{
		if (isset($status_data['starttime']))
		{
			$cut = strstr($status_data['starttime'], '.');
			$dt =str_replace($cut, '', $status_data['starttime']);
			$cut_str = substr($dt, strpos($dt, '-')+1);
			$cut_str=explode(' ', $cut_str);
			$md = explode('-', $cut_str[0]);
			$month = preg_replace('/^0/', '', $md[0]).'月';
			$day = preg_replace('/^0/', '', $md[1]).'日';
			return $month.$day.' '.$cut_str[1];
		}else{
			return '';
		}
	}
	
	public function getPhotoFullName($photo)
	{
		$name = isset($photo['name']) ? $photo['name'] : '';
		return htmlspecialchars($name);					
	}
	
	public function getAlbumFullName($album)
	{
		$name = isset($album['name']) ? $album['name'] : '';
		return htmlspecialchars($name);				
	}
	
	public function getVideoFullName($video)
	{
		$name = isset($video['title']) ? $video['title'] : '';
		return htmlspecialchars($name);			
	}
	
	public function getBlogFullName($blog)
	{
		$name = isset($blog['title']) ? $blog['title'] : '';
		return htmlspecialchars($name);	
	}
	
	public function getQAFullName($qa)
	{
		$name = isset($qa['title']) ? $qa['title'] : '';
		return htmlspecialchars($name);		
	}
	
	public function getEventFullName($event)
	{
		$name = isset($event['name']) ? $event['name'] : '';
		return htmlspecialchars($name);	
	}
	
	public function getStatusContentFullText($status)
	{
		$fulltext = isset($status['content']) ? $status['content'] : '';
		return htmlspecialchars($fulltext);		
	}
	
	public function getPhotoDescriptionFullText($photo)
	{
		$fulltext = isset($photo['description']) ? $photo['description'] : '';
		return $fulltext;	
	}
	
	public function getAlbumDescriptionFullText($album)
	{
		$fulltext = isset($album['description']) ? $album['description'] : '';
		return $fulltext;			
	}
	
	public function getBlogContentFullText($blog)
	{
		$fulltext = isset($blog['summary']) ? $blog['summary'] : '';
		$fulltext = str_replace(array("'",'"'), array("&#039;","&quot;"), $fulltext);
		$fulltext = strip_tags($fulltext);
		$preg = '/\{img\_\d{3}\}/i';
		$fulltext = preg_replace($preg, '', $fulltext);
		return $fulltext;						
	}	
	
	public function getVideoDescriptionFullText($video)
	{
		return isset($video['discription']) ? $video['discription'] : '';			
	}
	
	//生成缩略图地址
	private function getThumbImageUrl($filename, $ext='gif', $thumb ='f', $group = 'group2') 
	{
		$filename = null == $thumb ? $filename : $filename."_".$thumb;
		return "http://".config_item('fastdfs_host')."/".$group."/".$filename.".".$ext;
	}
	
	private function getLocationOfAPPURL($path, $query_string)
	{
		$query = null;
		foreach ($query_string as $key => $val)
		{
			if ($query == null)
			{
				$query = $key.'='.$val;
			}else{
				$query.= '&'.$key.'='.$val;
			}
		}
		return $path.'?'.$query;
	}
	
	private function getMaxValueByCheckbox($data)
	{
		$total_votes = 0;
		foreach ($data as $val)
		{
			$val = json_decode($val);
			$option_votes = isset($val->option_votes) ? $val->option_votes : 0;
			$total_votes = $option_votes > $total_votes ? $option_votes : $total_votes;
		}
		return $total_votes;
	}
	
	private function transferSpecialChar($html, $single=true)
	{
		$html = str_replace('&gt;', '>', $html);
		$html = str_replace('&lt;', '<', $html);
		$html = str_replace('&quot;', '"', $html);
		$html = str_replace('&amp;', '&', $html);
		if ($single)
			$html = str_replace("&#039;", "'", $html);
		return $html;	
	}
}
?>
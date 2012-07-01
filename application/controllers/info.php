<?php
/**
* [ Duankou Inc ]
* Created on 2012-3-7
* @author fbbin
* The filename : info.php   10:03:45
*/
class Info extends MY_Controller
{
	
	const PERMISION_CUSTOM = -1;
	const PERMISION_PUBLIC = 1;
	const TOPIC_FROM_INFO = 1;
	
	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	public function test()
	{
		print_r(getUserInfo($this->uid)); 
	}
	
	/**
	 * @author fbbin
	 * @desc 时间线或者信息流发布数据操作方法
	 * @param 前端需要提交的参数列表：
	 * @param content 用户填写的内容
	 * @param type 当前数据的格式:info/album/video
	 * @param timestr 选择的发布时间:格式：2012-03-02 08:15:54
	 * @param permission 当前数据实体设置的权限(int)
	 */
	public function doPost()
	{
		$data = array('uid'=>$this->uid, 'uname'=>$this->username, 'dkcode'=>$this->dkcode, 'title'=>date('Y-m-d H:i:s'), 'from'=>self::TOPIC_FROM_INFO, 'dateline'=>time());
		//数据类型:info/album/video
		$data['type'] = P('type');
		if( !in_array($data['type'], array('info', 'album', 'video')) )
		{
			return $this->dump( L('unknow_style_content'));
		}
		//内容处理
		$data['content'] = preg_replace('/\s+/', ' ', P('content'));
		if( $data['content'] == '' && $data['type'] == 'info' ) // || filter($data['content'], 2)
		{
			return $this->dump( L('message_error') );
		}
		$data['content'] = autoLink( msubstr($data['content'], 0, 140, 'utf-8', false) );
		$data['ctime'] = preg_replace_callback('/(?P<year>\d{4})(-?)(?P<mon>\d{0,2})(-?)(?P<day>\d{0,2})/', function ($match)
		{
			!$match['mon'] && $match['mon'] = 1;
			!$match['day'] && $match['day'] = 1;
			return mktime(date('H'),date('i'),date('s'),$match['mon'],$match['day'],$match['year']);
		}, P('timestr')?:date('Y-m-d') );
		$parseMethod = '_parse'.ucfirst($data['type']).'Data';
		$data = array_merge($data, $this->$parseMethod());
		$data['permission'] = P('permission');
		if( ! $data['permission'] )
		{
			return $this->dump(L('unenable_permission'));
		}
		//自定义情况下处理成员列表
		$relations = array();
		if( ! in_array($data['permission'], array(1,3,4,8)) )
		{
			$relations = explode(',', $data['permission']);
			$data['permission'] = self::PERMISION_CUSTOM;
			if( empty($relations) )
			{
				return $this->dump(L('relations_empty'));
			}
		}
		$result = $this->call(array($data, $relations));
		if( $result === false )
		{
			return $this->dump(L('operation_fail'));
		}
		$data['permission'] == self::PERMISION_PUBLIC && call_soap('search','RelationIndex', 'addOrUpdateStatusInfo', array($result));
		unset($data);
		return $this->dump(L('operation_success'), true, array('data'=>json_decode($result)));
	}
	
	/**
	 * @author fbbin
	 * @desc 时间线或者信息流转发数据操作方法
	 * @param 前端需要提交的参数列表：
	 * @param content 用户填写的内容
	 * @param tid 当前信息实体
	 * @param fid 原信息实体
	 * @param reply_author 是否评论给原作者 UID
	 * @param reply_now 是否评论给当前作者 UID
	 */
	public function doShare()
	{
		$this->load->model('TimelineModel');
		$data = array('uid'=>$this->uid, 'dkcode'=>$this->dkcode, 'permission'=>self::PERMISION_PUBLIC, 'uname'=>$this->username,
						'type'=>'forward', 'dateline'=>time(), 'from'=>self::TOPIC_FROM_INFO, 'ctime'=>time());
		//当前信息实体ID
		$tid = (int)P('tid');
		//如若当前信息实体被转发了两次或者以上，那么就获取原实体ID，否则就为当前ID
		$fid = (int)P('fid');
		//是否评论给原作者
		$replyAuthor = strtolower( P( 'reply_author' ) );
		//是否评论给当前作者
		$replyNow = strtolower( P( 'reply_now' ) );
		if( !($fid && $tid) )
		{
			return $this->dump( L('err_topic_id') );
		}
		if ( $tid === $fid ) 
		{
			$replyAuthor = $replyNow;$tid = $replyNow = false;
		}
		$data['fid'] = $fid;
		$infos = $this->TimelineModel->getTopic( $data['fid'] );
		if( ! $infos )
		{
			return $this->dump( L('err_topic_id'), false, array('tid'=>false) );
		}
		$data['content'] = P('content');
		$data['title'] = isset($infos['title']) ? $infos['title'] : '';
		$result = $this->call( array($data) );
		$result = json_decode($result, true);
		if( $result === false )
		{
			return $this->dump(L('operation_fail'));
		}
		//===========添加到转发列表===========
		$params = array('uid' => $data['uid'], 'content' => $data['content']);
       	call_soap('comlike','Share', 'add', array('topic', $fid, $tid, $result['tid'], $params));
       	$this->call(array($fid, 1), 'updateTopicHot');
       	//===========评论给原作者=============
      	$type = $infos['type'] != 'album' ? ($infos['type'] == 'info' ? 'topic' : $infos['type']): ($infos['photonum'] > 1 ? 'album' : 'photo');
		if( $replyAuthor && $fid )
		{
			if( $type == 'topic' )
			{
				$objectId = $infos['tid'];
			}
			elseif( $type == 'album' || $type == 'photo' )
			{
				$picurl = json_decode($infos['picurl'], true);
				$objectId = $picurl['0']['pid'];
			}
			else
			{
				$objectId = $infos['fid'];
			}
			$replyData = array('object_id'=>$objectId,'uid'=>$data['uid'],
								'username'=>$data['uname'],'src_uid'=>$replyAuthor,
								'object_type'=>$type,'usr_ip'=>get_client_ip(),
								'content'=>$data['content']);
			call_soap('comlike', 'Index', 'add_comment', array($replyData));
			unset($replyData);
		}
		//===========评论给当前作者===========
		if( $replyNow && $tid )
		{
			$replyNowData = array('object_id'=>P('object_id'),'uid'=>$data['uid'],
								'username'=>$data['uname'],'src_uid'=>$replyNow,
								'object_type'=>'forward','usr_ip'=>get_client_ip(),
								'content'=>$data['content']);
			call_soap('comlike', 'Index', 'add_comment', array($replyNowData));
			unset($replyNowData);
		}
		//===========添加转发通知==============
		if( ! $replyAuthor )
		{
			$replyAuthor = $infos['uid'];
		}
		if( $type == 'topic' || $type == 'photo')
		{
			$_static = array('topic'=>'info_frowardinfo','photo'=>'info_frowardpic');
			call_soap('ucenter', 'Notice', 'add_notice',array(1,$data['uid'],$replyAuthor,'info',$_static[$type],array('url'=>mk_url(APP_URL.'/info/view', array('tid' =>$result['tid'])))));
		}else if( $type == 'video' || $type == 'album' ) {
			$_static = array('video'=>'info_frowardvideo','album'=>'info_frowardalbum');
			call_soap('ucenter', 'Notice', 'add_notice',array(1,$data['uid'],$replyAuthor,'info',$_static[$type],array('name'=>@$result['title'],'url'=>mk_url(APP_URL.'/info/view', array('tid' =>$result['tid'])))));
		}
		unset($data, $infos);
		return $this->dump(L('operation_success'), true, array('data'=>$result));
	}
	
	/**
	 * @author fbbin
	 * @desc 移动时间轴上面的信息实体
	 * @param 前端需要提交的参数列表：
	 * @param tid 信息实体的TID
	 * @param timeStr 选择的发布时间:格式：2012-3-2
	 */
	public function doSetCtime()
	{
		$tid = (int)P('tid');
		$this->_checkPermission($tid);
		$newCtime = preg_replace_callback('/(?P<year>\d{4})(-?)(?P<mon>\d{0,2})(-?)(?P<day>\d{0,2})/', function ($match)
		{
			!$match['mon'] && $match['mon'] = 1;
			!$match['day'] && $match['day'] = 1;
			return mktime(date('H',SYS_TIME),date('i',SYS_TIME),date('s',SYS_TIME),$match['mon'],$match['day'],$match['year']);
		}, P('timeStr')?:date('Y-m-d',SYS_TIME) );
		$callStatus = $this->call(array($tid, $newCtime), 'updateTimeline');
		//更新赞模块存储时间 add by guojianhua
		call_soap("comlike","Index","update_Like",array("tid"=>$tid,"object_type"=>"info","ctime"=>$newCtime));
		
		unset($tid, $newCtime, $timeStr);
		return $callStatus ? $this->dump( L('operation_success'), true ) : $this->dump( L('operation_fail') );
	}
	
	/**
	 * @author fbbin
	 * @desc 删除一条信息实体
	 * @param tid 信息实体ID
	 */
	public function doDelTopic()
	{
		$tid = (int)P('tid');
		$topic = $this->_checkPermission( $tid );
		//删除赞表中的数据   add by 郭建华
		call_soap("comlike", "Index","delObject", array(array('object_id'=>$tid,'object_type'=>'topic')));
		$delStatus = $this->call(array($tid), 'removeTimeLine');
		//$delStatus = $this->call(array($tid), 'delInfo', 'Info');
		//删除转发列表的数据
		if($topic['type'] == 'forward')
		{
			call_soap('comlike','Share', 'del', array('topic', $tid));
		}
		
		//更新索引
		$this->call(array($tid),'deleteStatus','RelationIndex','search');
		unset($tid);
		return $delStatus ? $this->dump( L('operation_success'), true ) : $this->dump( L('operation_fail') );
	}
	
	/**
	 * @author fbbin
	 * @desc 设置一个信息实体突出显示
	 * @param tid 信息实体ID
	 * @param heightlight 1/0
	 */
	public function doUpdateHeightlight()
	{
		$tid = (int)P('tid');
		$this->_checkPermission( $tid );
		$highlight = P('highlight');
		$updateStatus = $this->call(array($tid, $highlight), 'updateTimelineHighlight');
		unset($tid, $highlight);
		return $updateStatus ? $this->dump( L('operation_success'), true ) : $this->dump( L('operation_fail') );
	}
	
	/**
	 * @author fbbin
	 * @desc 更新信息的权限
	 * @param tid 信息实体ID
	 * @param permission int/string
	 */
	public function doUpdatePermission()
	{
		$tid = (int)P('tid');
		$this->_checkPermission($tid);
		$permission = P('permission');
		$relations = array();
		if( ! in_array($permission, array(1,3,4,8)) )
		{
			$relations = explode(',', $permission);
			$permission = self::PERMISION_CUSTOM;
			if( empty($relations) )
			{
				return $this->dump(L('relations_empty'));
			}
		}
		$updateStatus = $this->call(array($tid, $permission, $relations), 'updatePermission');
		unset($tid, $permission, $relations);
		return $updateStatus ? $this->dump( L('operation_success'), true ) : $this->dump( L('operation_fail') );
	}
	
	/**
	 * @author fbbin
	 * @desc 检测是否有操作权限
	 * @param int $tid
	 */
	private function _checkPermission( $tid )
	{
		if( ! $tid )
		{
			$this->dump( L('err_topic_id') );
		}
		$this->load->model('TimelineModel');
		$topic = $this->TimelineModel->getTopic( $tid );
		if( ! $topic )
		{
			$this->dump( L('err_topic_id') );
		}
		if( $topic['uid'] != $this->uid )
		{
			$this->dump(L('permission_denied'));
		}
		return $topic;
	}
	
	/**
	 * @author yingxiaobin
	 * @param $tid
	 */
	public function view()
	{
		$tid = (int)$_GET['tid'];
		
		if (empty($tid)) {
			$this->assign('msg', array('没有相关的数据'));
			$this->assign('url', mk_url(APP_URL.'/index/index'));
			$this->display('error');
			exit();
		}
		
		// 登录者的用户信息
        $login_info['avatar_url'] = get_avatar($this->uid);
        $login_info['uid']    = $this->uid;
        $login_info['username'] = $this->user['username'];
        $login_info['url']    = mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->dkcode));
        $this->assign('login_info',$login_info);
        
        $params['webId'] = isset($_GET['web_id']) ? (int)$_GET['web_id'] : '';
        $params['tid'] = (int)$_GET['tid']; 
        $params['from'] = isset($_GET['from']) ? $_GET['from'] : '';
        $this->assign('params', $params);
        
        $this->assign('fdfsinfo', array('host'=>$this->config->item('fastdfs_host'),'group'=>$this->config->item('fastdfs_group')));
		$this->display('timeline/comment_show');
	}
	
	
	public function ajaxView()
	{
		$tid = (int)$_POST['tid'];
		if (empty($tid)) {
			toJSON(array('status' => 0, 'msg' => '传递参数不正确'));
		}
		
		$type = (isset($_POST['from']) && $_POST['from'] == 'web') ? 'Webtopic:' : 'Topic:';
		$this->load->model('TimelineModel');
		$auth = false; //是否具有权限
		
		$topic = $this->TimelineModel->getTopicByKey($type . $tid);

		if (!empty($topic)) {
			if ($topic['type'] == 'forward') {
				$topic['forward'] = $this->TimelineModel->getTopicByKey($type . $topic['fid']);
				if ($topic['forward'] && $topic['forward']['type'] == 'album') {
					$topic['forward']['picurl'] = json_decode($topic['forward']['picurl']);
				} 
				if ($topic['forward'] && $topic['forward']['type'] == 'video') {
				
					$topic['forward']['videourl'] = config_item('video_src_domain') . $topic['forward']['videourl'];
					$topic['forward']['imgurl'] = config_item('video_pic_domain') . $topic['forward']['imgurl'];
				}
				
				// 设置下原信息用户头像
				if ($type == 'Webtopic:') {
					$webId = (int)$_POST['web_id'];
					$topic['user_avartar'] = get_webavatar($topic['forward']['uid'], 's', $webId);
					$topic['web_home'] = WEB_DUANKOU_ROOT . 'main/?web_id=' . $webId;
				} else {
					$topic['user_avartar'] = get_avatar($topic['uid']);
				}
				
				
				// 判断这条信息的转发源是当前用户的
				if ($topic['forward']['uid'] == $this->uid || $topic['uid'] == $this->uid) {
					$auth = true;
				}
				
				
			} else {
				// 判断这条信息源是不是当前用户的
				if ($topic['uid'] == $this->uid) {
					$auth = true;
				}
				
				// 设置下原信息用户头像
				if ($type == 'Webtopic:') {
					$webId = isset($_POST['web_id']) ? (int)$_POST['web_id'] : 0;
					$topic['user_avartar'] = get_webavatar($topic['uid'], 's', $webId);
					$topic['web_home'] = WEB_DUANKOU_ROOT . 'main/?web_id=' . $webId;;
				} else {
					$topic['user_avartar'] = get_avatar($topic['uid']);
				}
				
				if ($topic['type'] == 'album') {
					$topic['picurl'] = json_decode($topic['picurl']);
				}
				
				if ($topic['type'] == 'video') {
					$topic['videourl'] = config_item('video_pic_domain') . $topic['videourl'];
					$topic['imgurl'] = config_item('video_src_domain') . $topic['imgurl'];
				}
			}
			
			if ($auth) {
				$topic['friendly_time'] = makeFriendlyTime($topic['ctime']);
				toJSON(array('status' => 1, 'data' => $topic));
			} else {
				toJSON(array('status' => 0, 'msg' => '没有浏览权限'));
			}
		} else {
			toJSON(array('status' => 0, 'msg' => '该信息已被删除'));
		}
	}
	
	/**
	 * @author fbbin
	 * @desc 解析信息流数据
	 */
	private function _parseInfoData()
	{
		return array();
	}
	
	/**
	 * @author fbbin
	 * @desc 解析照片的数据
	 * @param 相册数据类型额外的参数列表：
	 * @param fid 相册的ID
	 * @param pid 相片的PID
	 * @param picurl 大图地址
	 */
	private function _parseAlbumData()
	{
		$album['fid'] = P('fid');//以时间戳为相册ID
		$album['photonum'] = 1;
		$album['picurl'] = json_encode(unserialize(base64_decode(P('picurl'))));//相片的JSON数据
		$album['url'] = '';//相册地址不需要，滞空
		$album['note'] = P('note');//真实的相册ID
		return $album;
	}
	
	/**
	 * @author fbbin
	 * @desc 解析视频的数据
	 * @param 视频类型数据额外参数列表
	 * @param vid 视频ID
	 * @param videourl 视频资源地址
	 * @param imgurl 视频截图地址
	 * @param url 视频在视频模块中的链接地址
	 */
	private function _parseVideoData()
	{
		$video['fid'] = P('vid');
		$video['videourl'] = P('videourl');
		$video['imgurl'] = P('imgurl');
		$video['url'] = P('url');
		$video['width'] = P('width');
		$video['height'] = P('height');
		return $video;
	}
	
	/**
	 * @author fbbin
	 * @desc 对平台核心发起数据请求
	 * @param string $action
	 * @param array $data
	 * @param string $module
	 */
	private function call( $data = array(), $action = 'addTimeline', $module = 'Timeline', $app = 'timeline' )
	{
		if( empty($data) )
		{
			return false;
		}
		return call_soap($app, $module, $action, $data);
	}
	
	/**
	 * @author fbbin
	 * @desc 对输出进行控制
	 * @param array/string $info
	 * @param bool $status
	 * @param array $extra
	 */
	private function dump($info = '', $status = false, $extra = array())
	{
		if( is_string( $info ) )
		{
			$data = array('data'=>array(), 'status'=>(int)$status, 'info'=>$info);
		}
		elseif( is_array( $info ) )
		{
			$data = $info;
		}
		if( !empty($extra) )
		{
			$data = array_merge($data, $extra);
		}
		exit( json_encode( $data ) );
	}
	
}

?>
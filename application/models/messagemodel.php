<?php
/**
 * messagemodel
 *
 * @author        gefeichao
 * @date          2012/02/23
 * @version       1.2
 * @description   站内信
 * @history       <author><time><version><desc>
 */
class MessageModel extends MY_Model {
	
	protected  $mongo_db;
	function __construct(){
		$this->mongo_db = new Mongo_db();
	}
	
	/**
	 * 获取站内信群组id
	 * @author gefeichao
	 * @param $uid 发送者uid
	 * @param $touid 接收者uid
	 */
	function get_gid($uid, $touid) {
		if (! $uid || ! $touid) {
			return false;
		}
		$users = $uid . "," . $touid;
		$newusers = $touid . "," . $uid;
		$gid = $this->mongo_db->where_in ( 'g_list', array ($users, $newusers ) )->select ( array ('_id' ) )->get ( 'message_usergroup' );
		$gid = ( array ) $gid [0] ['_id'];
		if (! $gid) {
			return false;
		}
		return $gid [0] ['gid'];
	}
	
	
	/**
	 * 发送站内信息
	 * @access pubic
	 * @author gefeichao
	 * Enter description here ...
	 * @param  $fromuid		消息发送者uid
	 * @param  $touid		消息接受者uid
	 * @param  $message		发送消息内容
	 * @param  $files		附件信息【array】
	 */
	function add_message($fromuid = NULL, $touid = NULL, $message = NULL, $files = NULL) {
		if (! $fromuid || ! $touid || ! $message)
			return false;
		if (! $files)
			$files = "";
		$message = shtmlspecialchars($message);
		$users = $fromuid . "," . $touid;
		$newusers = $touid . "," . $fromuid;
		$str ='';
		$user = call_soap('ucenter', 'User', 'getUserList',array($users));	//获得信息
		foreach ($user as $value) {
			if(!$str){
				$str = $value['username'];
			}else{
				$str .= ','.$value['username'];
			}
		}
		 $dateline = time();
		if (strpos ( $touid, ',' )) { //多人会话、直接创建新会话
			$data = array ('g_list' => $users,'u_list'=>$str,'dateline'=>$dateline );
			$this->mongo_db->insert ( 'message_usergroup', $data );
			$gid = $this->mongo_db->where($data)->select(array('_id'))->get('message_usergroup');
			$gid = ( array ) $gid [0] ['_id'];
		} else { //否则先查看是否已有会话，如没有创建
			//根据参数获得对应 gid 
			$gid = $this->mongo_db->where_in ( 'g_list', array ($users, $newusers ) )->select ( array ('_id' ) )->get ( 'message_usergroup' );
			
			if(count($gid)>0){
				$gid = ( array ) $gid [0] ['_id'];
			} else {
				$data = array ('g_list' => $users ,'u_list'=>$str,'dateline'=>$dateline  );
				 $this->mongo_db->insert ( 'message_usergroup', $data );
				$gid = $this->mongo_db->where(array('g_list' => $users))->select(array('_id'))->get('message_usergroup');
				$gid = ( array ) $gid [0] ['_id'];
			}
			
		}
		
		$ausers = explode ( ',', $touid );
		$gid = $gid['$id'];
		
		$value = array ('is_read' => '', 'is_delete' => '', 'is_archive' => '' );
		$data = array ('gid' => $gid, 'from_uid' => $fromuid, 'to_uid' => $touid, 'message' => $message, 
		'files' => $files, 'dateline' => time (), 'operatelist' => serialize ( $value ) );
		 $this->mongo_db->insert ( 'message_info', $data );
		$messageid = $this->mongo_db->where($data)->select(array('_id'))->get('message_info');
		$messageid = ( array ) $messageid [0] ['_id'];
			foreach ( $ausers as $i ) {
				//为每一个组成员添加未读信息 
				call_soap('ucenter','Notice', 'setting',array($i,'addmsg'));
			}
			return array('gid'=>$gid,'msgid'=>$messageid['$id']);
	}
	
	/**
	 * 回复站内信
	 *
	 * @access public
	 * @author gefeichao
	 * @param $fromuid 发送者id
	 * @param $touid 接收者id
	 * @param $files 附件
	 * @param $message  内容
	 * @param $gid 会话id
	 */
	function reply_message($fromuid = NULL, $touid = NULL, $message = NULL, $files = NULL, $gid = NULL) {
		if (! $fromuid || ! $touid || ! $message || ! $gid) {
			return false;
		}
		if (! $files) {
			$files = "";
		}
		$message = shtmlspecialchars($message);
		$users = $fromuid . "," . $touid;
		$str ='';
		$user = call_soap('ucenter', 'User', 'getUserList',array($users));	//获得信息
		foreach ($user as $value) {
			if(!$str){
				$str = $value['username'];
			}else{
				$str .= ','.$value['username'];
			}
		}
		 $dateline = time();
		$sqldata = array ('g_list' => $users  ,'u_list'=>$str,'dateline'=>$dateline   );
		$this->mongo_db->where(array('_id'=> new MongoId($gid)))->update ( 'message_usergroup', $sqldata );
		$value = array ('is_read' => $fromuid, 'is_delete' => '', 'is_archive' => '' );
		$data = array ('gid' => $gid, 'from_uid' => $fromuid, 'to_uid' => $touid, 'message' => $message, 
		'files' => $files, 'dateline' => time (), 'operatelist' => serialize ( $value ) );
		$res2 = $this->mongo_db->insert ( 'message_info', $data );
		
			$ausers = explode ( ',', $touid );
			foreach ( $ausers as $i ) {
				//为每一个组成员添加未读信息 
				call_soap('ucenter','Notice', 'setting',array($i,'addmsg'));
			}
			return $gid;
	}
	
	/**
	 * 转换信息图片
	 * @author gefeichao
	 * @param $msg 信息内容
	 * @return $msg 替换后的消息内容
	 */
	function convertface($msg) {
		$faceArr = array ('[微笑]', '[撇嘴]', '[色]', '[发呆]', '[得意]', '[流泪]', '[害羞]', '[闭嘴]', '[睡]', '[大哭]', '[尴尬]', '[发怒]', '[调皮]', '[呲牙]', '[惊讶]', '[难过]', '[酷]', '[抓狂]', '[吐]', '[偷笑]', '[可爱]', '[白眼]', '[傲慢]', '[饥饿]', '[困]', '[惊恐]', '[流汗]', '[憨笑]', '[大兵]', '[奋斗]', '[咒骂]', '[疑问', '[嘘]', '[晕]', '[折磨]', '[衰]' );
		$faceArr = array_flip ( $faceArr );
		$msg = str_replace ( array ('\s', '\n' ), array ('&nbsp;', '<br/>' ), $msg );
		preg_match_all ( '/\[[^\]]*\]/', $msg, $tmp );
		foreach ( $tmp [0] as $key => $value ) {
			if (isset ( $faceArr [$value] )) {
				$pic = $faceArr [$value];
				$pic = $pic + 1;
				$msg = str_replace ( $value, '<img src="/misc/img/system/face/' . $pic . '.gif" alt="' . $value . '"/>', $msg );
			}
		}
		return $msg;
	}
	
	/**
	 * 获取站内信已存档列表
	 * @author gefeichao
	 * Enter description here ...
	 * @return $messagelist 返回消息列表
	 */
	function message_archivelist($searchkey=NULL) {
		$result = $this->mongo_db->like ( 'g_list', UID )->select ( array ('_id' ) )->get ( 'message_usergroup' );
		$sresult = array();$messagelist = array();
		
		foreach ( $result as $value ) {
			$res = (array)$value['_id'];
			if($searchkey){
			$mresult = $this->mongo_db->where ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->like ( 'message', $searchkey, 'im' )->limit ( 1 )->get ( 'message_info' );
			}else{
			$mresult = $this->mongo_db->where ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->limit ( 1 )->get ( 'message_info' );
			}	
			if ($mresult)
				$sresult [] = $mresult [0];
		} 
		if (! $sresult || count($sresult) == 0)
			return false;
		foreach ( $sresult as $value ) {
			$messagestatus = false;
			if ($value ['from_uid'] == UID) {
				$users = explode ( ',', $value ['to_uid'] );
				$userid = $users [0];
				$messagestatus = true;
			} else {
				$userid = $value ['from_uid'];
			}
			$value['g_list'] = $value ['from_uid'] .','.$value ['to_uid'];
			$value['toUser'] = $messagestatus;
			$value ['m'] = msubstr(  $value ['message'] , 0, 42);
			$value ['mess'] = msubstr( $value ['message'] , 0, 20);
			$value ['message'] =  $value ['message'] ;
			$newid = (array)$value ['_id'];
			$value ['id'] = $newid['$id'];
			$value ['userid'] = $userid;
			$value ['date'] = friendlyDate ( $value ['dateline'], 'full' );
			$value ['dateline'] = friendlyDate ( $value ['dateline'] );
			$operate = unserialize ( $value ['operatelist'] );
			if (strpos ( $operate ['is_read'], UID ) === false) {
				$value ['state'] = 1;
			} else {
				$value ['state'] = 2;
			}
			if (strpos ( $operate ['is_archive'], UID ) === false) {
				$value ['archive'] = 0;
			} else {
				$value ['archive'] = 1;
			}
			if (strpos ( $operate ['is_delete'], UID ) === false) {
				$value ['del'] = 0;
			} else {
				$value ['del'] = 1;
			}
			if ($value['archive'] == 1 && $value['del'] == 0)
            {
                $messagelist [$value ['date']] = $value;
            }
		}
		krsort ( $messagelist );
		$messagelist = array_values ( $messagelist );
		return $messagelist;
	}
	
	
	/**
	 * 获取站内信未读消息列表
	 * @author gefeichao
	 * Enter description here ...
	 * @return $messagelist 返回消息列表
	 */
	function message_unreadlist($searchkey=NULL) {
		$result = $this->mongo_db->like ( 'g_list', UID )->select ( array ('_id' ) )->get ( 'message_usergroup' );
		$sresult = array();$messagelist=array();
		
		foreach ( $result as $value ) {
			$res = (array)$value['_id'];
			if($searchkey){
			$mresult = $this->mongo_db->where ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->like ( 'message', $searchkey, 'im' )->limit ( 1 )->get ( 'message_info' );
			}else{
			$mresult = $this->mongo_db->where ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->limit ( 1 )->get ( 'message_info' );
			}	
			if ($mresult)
				$sresult [] = $mresult [0];
		} 
		if (! $sresult || count($sresult) == 0)
			return false;
		foreach ( $sresult as $value ) {
			$messagestatus = false;
			if ($value ['from_uid'] == UID) {
				$users = explode ( ',', $value ['to_uid'] );
				$userid = $users [0];
				$messagestatus = true;
			} else {
				$userid = $value ['from_uid'];
			}
			$value['g_list'] = $value ['from_uid'] .','.$value ['to_uid'];
			$value['toUser'] = $messagestatus;
			$value ['m'] = msubstr(  $value ['message'] , 0, 42);
			$value ['mess'] = msubstr( $value ['message'] , 0, 20);
			$value ['message'] =  $value ['message'] ;
			$newid = (array)$value ['_id'];
			$value ['id'] = $newid['$id'];
			$value ['userid'] = $userid;
			$value ['date'] = friendlyDate ( $value ['dateline'], 'full' );
			$value ['dateline'] = friendlyDate ( $value ['dateline'] );
			$operate = unserialize ( $value ['operatelist'] );
			if (strpos ( $operate ['is_read'], UID ) === false) {
				$value ['state'] = 1;
			} else {
				$value ['state'] = 2;
			}
			if (strpos ( $operate ['is_archive'], UID ) === false) {
				$value ['archive'] = 0;
			} else {
				$value ['archive'] = 1;
			}
			if (strpos ( $operate ['is_delete'], UID ) === false) {
				$value ['del'] = 0;
			} else {
				$value ['del'] = 1;
			}
			if ($value['state'] == 1 && $value['archive'] == 0 && $value['del'] == 0)
            {
               $messagelist [$value ['date']] = $value;
            }
		}
		krsort ( $messagelist );
		$messagelist = array_values ( $messagelist );
		return $messagelist;
	}
	
	
	/**
	 * 获取站内信收件箱列表
	 * @author gefeichao
	 * Enter description here ...
	 * @return $messagelist 返回消息列表
	 */
	function message_showmlist($searchkey=NULL) {
		$result = $this->mongo_db->like ( 'g_list', UID )->select ( array ('_id' ) )->get ( 'message_usergroup' );
		$sresult = array();$messagelist=array();
		
		foreach ( $result as $value ) {
			$res = (array)$value['_id'];
			if($searchkey){
			$mresult = $this->mongo_db->where ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->like ( 'message', $searchkey, 'im' )->limit ( 1 )->get ( 'message_info' );
			}else{
			$mresult = $this->mongo_db->where ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->limit ( 1 )->get ( 'message_info' );
			}	
			if ($mresult)
				$sresult [] = $mresult [0];
		} 
		if (! $sresult || count($sresult) == 0)
			return false;
		foreach ( $sresult as $value ) {
			$messagestatus = false;
			if ($value ['from_uid'] == UID) {
				$users = explode ( ',', $value ['to_uid'] );
				$userid = $users [0];
				$messagestatus = true;
			} else {
				$userid = $value ['from_uid'];
			}
			$value['g_list'] = $value ['from_uid'] .','.$value ['to_uid'];
			$value['toUser'] = $messagestatus;
			$value ['m'] = msubstr(  $value ['message'] , 0, 42);
			$value ['mess'] = msubstr( $value ['message'] , 0, 20);
			$value ['message'] =  $value ['message'] ;
			$newid = (array)$value ['_id'];
			$value ['id'] = $newid['$id'];
			$value ['userid'] = $userid;
			$value ['date'] = friendlyDate ( $value ['dateline'], 'full' );
			$value ['dateline'] = friendlyDate ( $value ['dateline'] );
			$operate = unserialize ( $value ['operatelist'] );
			if (strpos ( $operate ['is_read'], UID ) === false) {
				$value ['state'] = 1;
			} else {
				$value ['state'] = 2;
			}
			if (strpos ( $operate ['is_archive'], UID ) === false) {
				$value ['archive'] = 0;
			} else {
				$value ['archive'] = 1;
			}
			if (strpos ( $operate ['is_delete'], UID ) === false) {
				$value ['del'] = 0;
			} else {
				$value ['del'] = 1;
			}
		 	if ($value['archive'] == 0 && $value['del'] == 0)
            {
                $messagelist [$value ['date']] = $value;
            }
		}
		krsort ( $messagelist );
		$messagelist = array_values ( $messagelist );
		return $messagelist;
	}
	
	/**
	 * 获取站内信top列表
	 * @author gefeichao
	 * Enter description here ...
	 * @return $messagelist 返回消息列表
	 */
	function message_list_top() {
		$result = $this->mongo_db->like ( 'g_list', UID )->select ( array ('_id' ) )->get ( 'message_usergroup' );
		$sresult = array();
		$messagelist = array();
		foreach ( $result as $value1 ) {
			$res = (array)$value1['_id'];
			$mresult = $this->mongo_db->where ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->limit ( 1 )->get ( 'message_info' );
			foreach ( $mresult as $value ) {
				$messagestatus = false;
				if ($value ['from_uid'] == UID) {
					$users = explode ( ',', $value ['to_uid'] );
					$userid = $users [0];
					$messagestatus = true;
				} else {
					$userid = $value ['from_uid'];
				}
				$value['g_list'] = $value ['from_uid'] .','.$value ['to_uid'];
				$value['toUser'] = $messagestatus;
				$value ['m'] = msubstr(  $value ['message'] , 0, 42);
				$value ['mess'] = msubstr( $value ['message'] , 0, 20);
				$value ['message'] =  $value ['message'] ;
				$newid = (array)$value ['_id'];
				$value ['id'] = $newid['$id'];
				$value ['userid'] = $userid;
				$value ['date'] = friendlyDate ( $value ['dateline'], 'full' );
				$value ['dateline'] = friendlyDate ( $value ['dateline'] );
				$operate = unserialize ( $value ['operatelist'] );
				if (strpos ( $operate ['is_read'], UID ) === false) {
					$value ['state'] = 1;
				} else {
					$value ['state'] = 2;
				}
				if (strpos ( $operate ['is_archive'], UID ) === false) {
					$value ['archive'] = 0;
				} else {
					$value ['archive'] = 1;
				}
				if (strpos ( $operate ['is_delete'], UID ) === false) {
					$value ['del'] = 0;
				} else {
					$value ['del'] = 1;
				}
				if ($value ['archive'] == 0 && $value ['del'] == 0) {
						$messagelist [$value ['date']] = $value;
				}
			}
		}
		
		krsort ( $messagelist );
		$messagelist = array_values ( $messagelist );
		$topresult = array_slice($messagelist,0,5);
		return $topresult;
	}
	
	/**
	 * 获取用户已发送列表
	 * Enter description here ...
	 * @author gefeichao
	 * @return $sentmessagelist 已发送列表
	 */
	function sentmessage($searchkey = NULL) {
		$result = $this->mongo_db->like ( 'g_list', UID )->select ( '_id' )->get ( 'message_usergroup' );
		$sresult = array();$sentmessagelist=array();
		foreach ( $result as $value ) {
			$res = (array)$value['_id'];
			$boolresult = $this->mongo_db->where_and ( array ('gid' => $res['$id'], 'from_uid' => UID ) )->order_by ( array ('dateline' => - 1 ) )->select ( array ('_id') )->get ( 'message_info' );
			if($boolresult){
			if($searchkey)
			$mresult = $this->mongo_db->like ( 'message', $searchkey, 'im')->where_and ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->select ( array ('gid', 'operatelist', 'message', 'dateline', '_id', 'from_uid', 'to_uid', 'files' ) )->get ( 'message_info' );
			else
			$mresult = $this->mongo_db->where_and ( array ('gid' => $res['$id'] ) )->order_by ( array ('dateline' => - 1 ) )->select ( array ('gid', 'operatelist', 'message', 'dateline', '_id', 'from_uid', 'to_uid', 'files' ) )->get ( 'message_info' );
			
			if ($mresult)
				$sresult [] = $mresult [0];
			}
		}
		if (! $sresult) {
			return false;
		}
		foreach ( $sresult as $value ) {
			$messagestatus = false;
			if ($value ['from_uid'] == UID) {
				$users = explode ( ',', $value ['to_uid'] );
				$userid = $users [0];
				$messagestatus = true;
			} else {
				$userid = $value ['from_uid'];
			}
			$value['g_list'] = $value ['from_uid'] .','.$value ['to_uid'];
			$value['toUser'] = $messagestatus;
			$value ['m'] = msubstr( $value ['message'] , 0, 42);
			$value ['message'] =  $value ['message'] ;
			$newid = (array)$value ['_id'];
			$value ['id'] = $newid['$id'];
			$value ['userid'] = $userid;
			$value ['date'] = friendlyDate ( $value ['dateline'], 'full' );
			$value ['dateline'] = friendlyDate ( $value ['dateline']);
			$operate = unserialize ( $value ['operatelist'] );
			if (strpos ( $operate ['is_read'], UID ) === false) {
				$value ['state'] = 1;
			} else {
				$value ['state'] = 2;
			}
			if (strpos ( $operate ['is_archive'], UID ) === false) {
				$value ['archive'] = 0;
			} else {
				$value ['archive'] = 1;
			}
			if (strpos ( $operate ['is_delete'], UID ) === false) {
				$value ['del'] = 0;
			} else {
				$value ['del'] = 1;
			}
			 if ($value['archive'] == 0 && $value['del'] == 0)
            {
               $sentmessagelist [$value ['date']] = $value;
            }
			
		}
		krsort ( $sentmessagelist );
		$sentmessagelist = array_values ( $sentmessagelist );
		return $sentmessagelist;
	}
	
	/**
	 * 设置用户站内信已读、未读
	 * Enter description here ...
	 * @param  $id  信息id
	 */
	function setmessage($id = NULL) {
		if (! $id)
			return false;
		$sresult = $this->mongo_db->where ( array ('_id' => new MongoId($id )) )->select ( array ('operatelist' ) )->get ( 'message_info' );
		if(!$sresult)	return false;
		$operate = unserialize ( $sresult [0] ['operatelist'] );
		$b = array ();
		if (strpos ( $operate ['is_read'], UID ) === false) {
			if (count ( $operate ['is_read'] ) > 0) {
				$operate ['is_read'] = $operate ['is_read'] . "," . UID;
			} else {
				$operate ['is_read'] = UID;
			}
			$state = 2;
		} else {
			$a = explode ( ',', $operate ['is_read'] );
			foreach ( $a as $v ) {
				if ($v != UID) {
					$b [] = $v;
				}
			}
			$operate ['is_read'] = implode ( ',', $b );
			$state = 1;
		}
		$o = serialize ( $operate );
		
		$upstate = $this->mongo_db->where ( array ('_id' => new MongoId($id) ) )->update ( 'message_info', array ('operatelist' => $o ) );
		if ($upstate) {
			return $state;
		} else {
			return false;
		}
	}
	
	/**
	 * 设置用户站内信存档、未存档
	 * Enter description here ...
	 * @param  $id  信息id
	 */
	function setarchive($id = NULL) {
		if (! $id)
			return false;
		$operate = array();
		$sresult = $this->mongo_db->where ( array ('_id' => new MongoId($id) ) )->select ( array ('operatelist' ) )->get ( 'message_info' );
		if(!$sresult)	return false;
		$operate = unserialize ( $sresult [0] ['operatelist'] );
		$b = array ();
		if (strpos ( $operate ['is_archive'], UID ) === false) {
			if (count ( $operate ['is_archive'] ) > 0) {
				$operate ['is_archive'] = $operate ['is_archive'] . "," . UID;
			} else {
				$operate ['is_archive'] = UID;
			}
			$state = 2;
		} else {
			$a = explode ( ',', $operate ['is_archive'] );
			foreach ( $a as $v ) {
				if ($v != UID) {
					$b [] = $v;
				}
			}
			$operate ['is_archive'] = implode ( ',', $b );
			$state = 1;
		}
		$o = serialize ( $operate );
		$upstate = $this->mongo_db->where ( array ('_id' => new MongoId($id) ) )->update ( 'message_info', array ('operatelist' => $o ) );
		if ($upstate) {
			return $state;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取站内信对话信息列表
	 * Enter description here ...
	 * @param  $gid  会话id
	 */
	function showdetailmessage($gid = NULL) {
	if (! $gid)
			return false;
		$sresult = $this->mongo_db->order_by ( array ('dateline' => 1 ) )->where ( array ('gid' => $gid ) )->select ( array ('operatelist', 'message', 'dateline', '_id', 'from_uid', 'to_uid', 'files' ) )->get ( 'message_info' );
		if (! $sresult) {
			return false;
		}
		$str = '';
		foreach ($sresult as $value) {
			if(!$str){
				$str = $value['from_uid'];
			}else{
				$str .= ','.$value['from_uid'];
			}
		}
		$user = call_soap('ucenter', 'User', 'getUserList',array($str));	//获得信息

		foreach ( $sresult as $value ) {
			$userid = $value ['from_uid'];
			
			foreach($user as $item){
			
				if($value['from_uid'] == $item['uid']){
					$value ['username'] =$item['username'];
					$value ['dkcode'] = $item['dkcode'];
				}
			}
			
			$operate = unserialize ( $value ['operatelist'] );
			if (strpos ( $operate ['is_delete'], UID )) {
				continue;
			}
			if (strpos ( $operate ['is_read'], UID ) === false) {
				$this->setmessage ( $value ['_id'] );
			}
			$value ['message'] = $this->convertface ( $value ['message'] );
			
			$value ['avatarurl'] =  get_avatar( $userid );	//获取头像
			$newid = (array)$value ['_id'];
			$value ['id'] = $newid['$id'];
			$value ['userid'] = $userid;
			$value ['dateline'] = friendlyDate ( $value ['dateline'] );
			$showdmessage [] = $value;
		}
		if ($showdmessage) {
			return $showdmessage;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取某个群组成员
	 * Enter description here ...
	 * @param  $gid  会话id
	 */
	function showgroup($gid = NULL) {
		if (! $gid)
			return false;
		$sresult = $this->mongo_db->where ( array ('_id' => new MongoId($gid) ) )->select (  array ('u_list','g_list' ) )->get ( 'message_usergroup' );
		if(!$sresult)	return false;
		return $sresult [0];
	}
	
	/**
	 * 站内信搜索
	 * @author gefeichao
	 * @param $searchkey 搜索关键字
	 * @param $uid 用户uid
	 */
	function search_msg($searchkey, $gid) {
		if (! $searchkey || !$gid) {
			return false;
		}
		$values = $this->mongo_db->like ( 'message', $searchkey, 'im')->where ( array ('gid' => $gid ) )->select ( array('operatelist', 'message', 'dateline', 'mid', 'from_uid', 'to_uid', 'files' ))->get ( 'message_info' );
		if (! $values)
			return false;
		$countres = array();
		$str = '';
		foreach ($values as $value) {
			if(!$str){
				$str = $value['from_uid'];
			}else{
				$str .= ','.$value['from_uid'];
			}
		}
		$user = call_soap('ucenter', 'User', 'getUserList',array($str));	//获得信息

		foreach ( $values as $res ) {
			
			foreach($user as $item){
			
				if($value['from_uid'] == $item['uid']){
					$res ['username'] =$item['username'];
					$res ['dkcode'] = $item['dkcode'];
				}
			}
			
			$operate = unserialize ( $res ['operatelist'] );
			if (strpos ( $operate ['is_delete'], UID )) {
				continue;
			}
			
			$res ['avatarurl'] =  get_avatar( $res ['from_uid'] );
			$res ['message'] = $this->convertface ( $res ['message'] );
			$newid = (array)$res ['_id'];
			$res ['id'] = $newid['$id'];
			$res ['userid'] = $res ['from_uid'];
			$res ['dateline'] = friendlyDate ( $res ['dateline'] );
			$countres [] = $res;
		}
		return $countres;
	}
	
	/**
	 * 获取某站内信的附件信息
	 * @author gefeichao
	 * @param $id 附件id
	 */
	function get_files($id = NULL) {
		if (! $id)
			return false;
		$valstr_rel = $this->mongo_db->where ( array ('_id' => new MongoId($id) ) )->select ( array('is_image', 'group_name','orig_name','file_size','client_name', 'file_name', 'file_ext' ))->get ( 'message_fileupload' );
		if (! $valstr_rel) {
			return false;
		}
		return $valstr_rel;
	}
	
	/**
	 * 删除站内信
	 * @access  public
	 * @author gefeichao
	 * @param   $id  记录id 
	 * @param $uid  用户uid
	 * return   bool
	 */
	function del_pms($ids = NULL, $uid = NULL) {
		if (! count($ids)>0 || ! $uid) {
			return false;
		}
		$i = 0;
		
		foreach ($ids as $id){
			$sresult = $this->mongo_db->where ( array ('_id' => new MongoId($id) ) )->select ( array ('operatelist' ) )->get ( 'message_info' );
			$operate = unserialize ( $sresult [0] ['operatelist'] );
			$b = array ();
			if (strpos ( $operate ['is_delete'], UID ) === false) {
				if (count ( $operate ['is_delete'] ) > 0) {
					$operate ['is_delete'] = $operate ['is_delete'] . ',' . $uid;
				} else {
					$operate ['is_delete'] = $uid;
				}
				$state = 2;
			} else {
				$a = explode ( ',', $operate ['is_delete'] );
				foreach ( $a as $v ) {
					if ($v != $uid) {
						$b [] = $v;
					}
				}
				$operate ['is_delete'] = implode ( ',', $b );
				$state = 1;
			}
			$o = serialize ( $operate );
			$upstate = $this->mongo_db->where ( array ('_id' => new MongoId($id) ) )->update ( 'message_info', array ('operatelist' => $o ) );
			if ($upstate) {
				$i++;
			} 
		}
		return ($i>0)? true : false ;
	}
	
	
	/**
	 * 添加附件信息
	 * @access  public
	 * @author gefeichao
	 * @param   $data  附件信息 
	 * return   bool
	 */
	function addfile($data) {
		if (! $data)
			return 1;
		
 		$this->mongo_db->insert ( 'message_fileupload', $data );
		
		$file_id =  $this->mongo_db->where(array (
					'file_name' => $data['file_name'], 
					'group_name' =>$data['group_name'],
					'orig_name' => $data ['orig_name'] 
			 ))->get('message_fileupload');
		$res = (array)$file_id[0]['_id'];
		return $res['$id'];
	}
	
	
	/**
	 * 获取未读总数
	 *
	 * @author gefeichao
	 * @access public
	 * @param $uid 用户id
	 */
	function show_unread($uid) {
		if (! $uid) {
			return false;
		}
		$show_rel = $this->mongo_db->where(array('uid'=>$uid))->select(array('un_msg','un_notice','un_invite'))->get('expand');
		if(!$show_rel){
			return false;
		}
		return $show_rel;
	}
}
?>
<?php
/**
 * @desc           好友
 * @author         yaohaiqi
 * @date            2012-03-01
 * @version        $Id: friend.php 26803 2012-06-01 16:00:01Z wangy $
 * @description    好友首页\好友列表\ 通过姓名获取好友\好友显示与隐藏等
 * @history         <author><time><version><desc>
 */


class Friend extends MY_Controller {
    /**
     * 目标用户是否是本人
     * 
     * @var boolean 
     */
   // private $_self = false;

    /**
     * 构造函数
     */
    function __construct(){
	parent::__construct();
        //判断是否本人
        if (!$this->action_uid ) {
            $this->action_uid = $this->uid;
            $this->action_user = $this->user;
            $this->action_dkcode = $this->dkcode;
            $this->_self = true;
        } elseif ($this->action_uid == $this->uid) {
            $this->_self = true;
        }
	$this->load->model('friendmodel');
    }
    
    /**
     * 好友首页
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function index() {
        //当前登录用户信息        
        $login_info = array(
            'avatar_url' => get_avatar($this->user['uid']),
            'uid' => $this->uid,
            'username' => $this->user['username'],
            'url' => mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->dkcode)),
            'sessionid' => $this->sessionid,
            'host' => $this->config->item('fastdfs_host'),
            'group' => $this->config->item('fastdfs_group'),
            'is_self' => $this->_self
        );
        //当前主页用户信息
        $home_info = array(
            'self_url' => mk_url(APP_URL.'/friend/index', array('action_dkcode' => $this->dkcode)),
            'url' => mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->action_dkcode)),
            'dk_code' => $this->action_dkcode,
            'src' => get_avatar($this->action_uid,'ss'),
            'username' => $this->action_user['username']
        );
        $this->assign('action_uid',  $this->action_uid);
        $this->assign('login_info',$login_info);
        $this->assign('home_info',$home_info);
        $this->assign('sessionid',$this->sessionid);
        //视频上传录制 wangying
        $this->assign('videoname',date('YmdHis').'_'.$this->uid);
		$authcode_url = authcode('module=1','',config_item('authcode_key'));
		$this->assign('authcode_url',base64_encode($authcode_url));
		$this->assign('video_upload_url',config_item('video_upload_url'));
		$this->assign('recordurl',config_item('recordurl'));
		$this->assign('video_pic_domain',config_item('video_pic_domain'));
		$this->assign('video_src_domain',config_item('video_src_domain'));
		
        $this->display('friend/index.html');
    }
    
    /**
     * 好友首页json数据
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function friendindex() {
        $list = array();
        //获得页数
        $page = intval($this->input->post('page')) ? intval($this->input->post('page')) : 1 ;
        //获得好友数
        $NumOfFriends = $this->friendmodel->getNumOfFriends($this->_self ,$this->action_uid ,$this->uid);
        //获得好友列表
        $friends = $this->friendmodel->getFriendsindex($this->_self ,$this->action_uid ,$this->uid ,$page);
        if($friends){
            foreach($friends as $k => $v){
                $v['src'] = get_avatar($v['id'],'s');
                $v['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                $list[] = $v;
            }
        }
        //生成进入好友首页的url
        $link = mk_url(APP_URL.'/friend/friendlist', array('action_dkcode' => $this->action_dkcode));
        $data = array('num' => $NumOfFriends,'type' => 'file', 'link' => $link,'list' => $list);
        die(json_encode(array('state' => '1' ,'msg' => "success!" ,'data' =>$data)));
    }
    
    /**
     * 好友列表
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function friendlist() {
        $friendlist = array();
        //获得好友数
        $NumOfFriends = $this->friendmodel->getNumOfFriends($this->_self ,$this->action_uid ,$this->uid);
        //获得好友列表
        $friend = $this->friendmodel->getFriendsWithInfo($this->_self ,$this->action_uid ,$this->uid);
        if($friend){
            foreach($friend as $k => $v){
                $v['src'] = get_avatar($v['id'],'m');
                $v['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                $friendlist[] = $v;
             }
        }
        //当前主页用户信息
        $home_info = array(
            'self_url' => mk_url(APP_URL.'/friend/friendlist', array('action_dkcode' => $this->action_dkcode)),
            'url' => mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->action_dkcode)),
            'dk_code' => $this->action_dkcode,
            'src' => get_avatar($this->action_uid,'ss'),
            'username' => $this->action_user['username'],
            'is_self' => $this->_self,
            'NumOfFriends' => $NumOfFriends
        );
        $this->assign('home_info',$home_info);
        $this->assign('friendlist',$friendlist);
        $this->display('friend/list.html');
    }
    
    /**
     * 好友列表滑屏分页
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function getFriendByPage(){
        $list = '';
        //获得页码
        $page = intval($this->input->post('pager'));
        //获得好友列表
        $friend = $this->friendmodel->getFriendsWithInfo($this->_self ,$this->action_uid ,$this->uid ,$page);
        if($friend){
            foreach($friend as $k => $v){
                $v['src'] = get_avatar($v['id'],'m');
                $v['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                $friendlist[] = $v;
            }
        }
        //获得好友数量
        $NumOfFriends = $this->friendmodel->getNumOfFriends($this->_self ,$this->action_uid ,$this->uid);
        //判断是否为最后一页
        $last = ($NumOfFriends > $page * 27) ? false:true;
        //判断是否是主人
        if($this->_self){
            foreach($friendlist as $k => $v){
                $invisible = $v['hidden'] == 0  ?  '' : 'invisible';
                $list .=  '<li><div class="avatarBox '.$invisible.'"><a href="'.$v['href'].'"><img src="'.$v['src'].'" alt="" /></a><s id="'.$v['id'].'"></s></div><span class="uName"><a href="'.$v['href'].'">'.$v['name'].'</a></span></li>';  
            }
        }else {
            foreach($friendlist as $k => $v){
                $list .= '<li><div class="avatarBox"><a href="'.$v['href'].'"><img src="'.$v['src'].'" alt="" /></a></div><span class="uName"><a href="'.$v['href'].'">'.$v['name'].'</a></span></li>';
            }
        }
        die(json_encode(array('state' => '1' ,'msg' => 'success!' ,'last' =>$last ,'list' => $list)));
    }
    
    /**
     * 好友隐藏与显示
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function hideFriend() {
        //获得被隐藏\取消隐藏好友uid和状态
        $f_uid = $this->input->post('f_uid');
        $state = $this->input->post('visible');
        $status = $this->friendmodel->HiddenStatus($this->uid, $f_uid);
        $statebool  =  $state === 'false' ? FALSE : TRUE ;
        if($statebool == $status){
            if($state == 'false'){
                $result = $this->friendmodel->hideFriend($this->uid ,$f_uid);
                $result ? die(json_encode(array('state' => '1' ,'msg' => "success!"))):die(json_encode(array('state' => '0' ,'msg' => 'error!')));
            }else{
                $result = $this->friendmodel->unHideFriend($this->uid ,$f_uid);
                $result ? die(json_encode(array('state' => '1' ,'msg' => "success!"))):die(json_encode(array('state' => '0' ,'msg' => 'error!')));
            }

        }else{
            die(json_encode(array('state' => '1' ,'msg' => "success!")));
        }
    }
    
    /**
     * 通过姓名查找好友
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function searchFriendByName(){
        $list = '';
        $last = true;
        //获得页码和关键字
        $page = intval($this->input->post('pager')) ? intval($this->input->post('pager')) : 1 ;
        $keyword = $this->input->post('keyword');
        //获得好友列表
        if($keyword != ''){
            $getFriendByName = $this->friendmodel->getFriendByName($this->action_uid ,$keyword ,$page);
            if($getFriendByName['total'] > 0){
                foreach($getFriendByName['object'] as $k => $v){
                    $v['src'] = get_avatar($v['id'],'m');
                    $v['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                    $invisible = $v['type'] == 0  ?  '' : 'invisible';
                    $list .=  '<li><div class="avatarBox '.$invisible.'"><a href="'.$v['href'].'"><img src="'.$v['src'].'" alt="" /></a><s id="'.$v['id'].'"></s></div><span class="uName"><a href="'.$v['href'].'">'.$v['name'].'</a></span></li>';
                }
                //判断是否为最后一页
                $last = ($getFriendByName['total'] > $page * 27 ) ? false:true;
            }
        }else{
            $NumOfFriends = $this->friendmodel->getNumOfFriends(true, $this->action_uid, $this->uid);
            $getFriendByName = $this->friendmodel->getFriendsWithInfo(true, $this->action_uid, $this->uid ,$page);
            if($getFriendByName){
                 foreach($getFriendByName as $k => $v){
                    $v['src'] = get_avatar($v['id'],'m');
                    $v['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                    $invisible = $v['hidden'] == 0  ?  '' : 'invisible';
                    $list .=  '<li><div class="avatarBox '.$invisible.'"><a href="'.$v['href'].'"><img src="'.$v['src'].'" alt="" /></a><s id="'.$v['id'].'"></s></div><span class="uName"><a href="'.$v['href'].'">'.$v['name'].'</a></span></li>';
                }
            }
            $last = ($NumOfFriends > $page * 27 ) ? false:true;
        }
        die(json_encode(array('state' => '1' ,'msg' => 'success!' ,'last' =>$last ,'list' => $list)));
    }
    
    
    function groupFriends() {
        $list = array();
        //获得页数
        $page = intval($this->input->post('page')) ? intval($this->input->post('page')) : 1 ;
        //获得好友数
        $NumOfFriends = $this->friendmodel->getNumOfFriends(true,$this->action_uid ,$this->uid);
        //获得好友列表
        $friends = $this->friendmodel->getFriendsUseIntoGroup($this->action_uid ,$this->uid ,$page);
        if($friends){
            foreach($friends as $k => $v){
                $v['src'] = get_avatar($v['id'],'s');
                $v['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                $list[] = $v;
            }
        }
        //生成进入好友首页的url
        $link = mk_url(APP_URL.'/friend/friendlist', array('action_dkcode' => $this->action_dkcode));
        $data = array('num' => $NumOfFriends,'type' => 'file', 'link' => $link,'list' => $list);
        die(json_encode(array('state' => '1' ,'msg' => "success!" ,'data' =>$data)));
    }
}
?>
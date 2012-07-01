<?php
/**
 * @desc            粉丝
 * @author          yaohaiqi
 * @date             2012-03-01
 * @version         $Id: follower.php 26454 2012-05-29 09:50:57Z yaohq $
 * @description     粉丝列表\ 通过姓名获取粉丝等
 * @history          <author><time><version><desc>
 */

class Follower extends MY_Controller {
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
		$this->load->model('followermodel');
	 }
    
    /**
     * 粉丝列表
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function index() {
        //获得粉丝列表
        $followerlist = $this->followermodel->getFollowersWithInfo($this->action_uid);
        //获得粉丝数量
        $NumOfFollowers = $this->followermodel->getNumOfFollowers($this->action_uid);
        //当前主页用户信息
        $home_info = array(
            'self_url' => mk_url(APP_URL.'/follower/index', array('action_dkcode' => $this->action_dkcode)),
            'url' => mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->action_dkcode)),
            'src' => get_avatar($this->action_uid,'ss'),
            'username' => $this->action_user['username'],
            'is_self' => $this->_self,
            'NumOfFollowers' => $NumOfFollowers
        );
        $this->assign('home_info',$home_info);
        $this->assign('followerlist',$followerlist);
        $this->display('follower/list.html');
    }
    
    /**
     * 粉丝列表滑屏分页
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function getfollowerBypage() {
        $list = '';
        //获得页码和主页dkcode
        $page = intval($this->input->post('pager'));
        //获得粉丝总数量
        $NumOfFollowers = $this->followermodel->getNumOfFollowers($this->action_uid);
        //判断是否为最后一页
        $last = ($NumOfFollowers > $page * 27) ? false:true;
        //获得粉丝列表
        $followerlist = $this->followermodel->getFollowersWithInfo($this->action_uid ,$page);
        foreach($followerlist as $k => $v){
            $list .= '<li><div class="avatarBox"><a href="'.$v['href'].'"><img src="'.$v['src'].'" alt="" /></a></div><span class="uName"><a href="'.$v['dkcode'].'">'.$v['name'].'</a></span></li>';
        }
        die(json_encode(array('state' => '1' ,'msg' => 'success!' , 'last' => $last ,'list' => $list)));
    }
    
    /**
     * 通过姓名查找粉丝
     * @author	yaohaiqi
     * @date	2012/3/28
     */
    function searchFollowerByName() {
        $list = '';
        $last = true;
        //获得页码、主页dkcode和关键字
        $page = intval($this->input->post('pager')) ? intval($this->input->post('pager')) : 1 ;
        $keyword = $this->input->post('keyword');
        //获得粉丝列表
        if($keyword != ''){
            $followerlist = $this->followermodel->getFollowersByName($this->action_uid ,$keyword ,$page);
            if($followerlist['total'] > 0) {
                //判断是否为最后一页
                $last = ($followerlist['total'] > $page * 27) ? false:true;
                foreach($followerlist['object'] as $k => $v){
                    $avatar = get_avatar($v['id'],'m');
                    $href = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                    $list .= '<li><div class="avatarBox"><a href="'.$href.'"><img src="'.$avatar.'" alt="" /></a></div><span class="uName"><a href="'.$v['dkcode'].'">'.$v['name'].'</a></span></li>';
                }
            }
        }else{
            $NumOfFollowers = $this->followermodel->getNumOfFollowers($this->action_uid);
            $last = ($NumOfFollowers > $page * 27) ? false:true;
            $followerlist = $this->followermodel->getFollowersWithInfo($this->action_uid ,$page);
            if($followerlist){
                foreach($followerlist as $k => $v){
                    $avatar = get_avatar($v['id'],'m');
                    $href = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
                    $list .= '<li><div class="avatarBox"><a href="'.$href.'"><img src="'.$avatar.'" alt="" /></a></div><span class="uName"><a href="'.$v['dkcode'].'">'.$v['name'].'</a></span></li>';
                }
            }
        }
        die(json_encode(array('state' => '1' ,'msg' => 'success!' ,'last' =>$last ,'list' => $list)));
    }
}
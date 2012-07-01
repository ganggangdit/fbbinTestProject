<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 关系公共类
 *
 * @author        lanyanguang
 * @date           2012/3/19
 * @version       $Id$
 * @description   关注\取消关注 加好友\删除好友等
 * @history        <author><time><version><desc>
 */
class Api extends MY_Controller {    
    
    /**
     * 目标用户uid
     * 
     * @var int 
     */
    private $_fid;
    private $_fname;
    private $web_id;
    private $_webinfo;

    /**
     * 构造方法
     */
    function __construct() {
        parent::__construct();
        $this->load->model('apimodel');
        $this->load->model('immodel');
        
        //前置过滤并获得目标用户uid
        $this->_relationFilter();
    }
    
    /**
     * 添加关注
     * @author	lanyanguang
     * @date	2012/3/8
     */
    function addFollow() {     
        //检查是否已关注过目标用户
        /*$chk_fd =  $this->apimodel->isFollowing($this->uid, $this->_fid);
        if ($chk_fd) {
            die(json_encode(array('state' => '0', 'msg' => '您已关注过该用户了!', 'relation' => $this->apimodel->getRelationWithUser($this->uid, $this->_fid))));
        }
        */
        //添加用户关注
        $result = (int) $this->apimodel->follow($this->uid, $this->_fid);
        if ($result > 0) {
            //更新可能认识的人数据
            $this->apimodel->updateIndex($this->uid, $this->_fid);
            
            //添加关注成功 更新索引 蓝燕光 2012-04-24
            //$this->apimodel->addOneToMyFollowings($this->uid, $this->_fid);
            call_soap('search', 'RelationIndex', 'addAFansForOne', array($this->_fid));
            
            //通知IM 蓝燕光 2012-05-02
            $this->immodel->addImFollow(json_encode(array('uid'=>$this->uid, 'username'=>$this->username)), json_encode(array('uid'=>$this->_fid, 'username'=>$this->_fname)));
            
            //发送通知接口
            $notice_r = $this->apimodel->sendNotice(1, $this->uid, $this->_fid, 'dk', 'dk_guanzhu');
           
            //处理通知结果
            $this->_sendNoticeResult($notice_r, abs($result));
            
        }else{
            die(json_encode(array('state' => '1', 'msg' => '操作失败!', 'relation' => abs($result))));
        }
    }
	
    /**
     * 取消关注
     * 
     * @author	lanyanguang
     * @date    2012/3/8
     */
    function unFollow() {
        //取得操作前的关系，因为在好友邀请已发送的情况下，需要做通知数减1.
        $relation = $this->apimodel->getRelationStatus($this->uid, $this->_fid);

        //取消关注
        $result = (int) $this->apimodel->unfollow($this->uid, $this->_fid);
        
        if ($result > 0 ) {            
            //取消关注成功 更新索引 蓝燕光 2012-04-24
            //$this->apimodel->removeOneOfMyFollowings($this->uid, $this->_fid);
            call_soap('search', 'RelationIndex', 'removeAFansForOne', array($this->_fid));
                    
            //通知IM 蓝燕光 2012-05-02
            $this->immodel->delImFollow(json_encode(array('uid'=>$this->uid, 'username'=>$this->username)), json_encode(array('uid'=>$this->_fid, 'username'=>$this->_fname)));
            
            //在好友邀请已发送的情况下，需要做通知数减1.
            if($relation == 8) {
                /*---start---*/
                /*葛飞超  2012-04-13 17：10   未读请求计数 减1*/
                call_soap('ucenter', 'Notice', 'setting', array($this->uid, 'editinvite'));
                /*---end---*/
            }
            
            die(json_encode(array('state' => '1', 'msg' => '操作成功!', 'relation' => abs($result))));
        } else {
            die(json_encode(array('state' => '1', 'msg' => '操作失败!', 'relation' => abs($result))));
        }
    }
    
    /**
     * 添加好友请求
     * 
     * @author	lanyanguang
     * @date    2012/3/21
     */
    function addFriend() {
        //加为好友
        $result = (int) $this->apimodel->addFriend($this->uid, $this->_fid);
        
        if ($result > 0 ) {
            if($result == 8) {
                //只是发送邀请
                //发送好友请求统计
                call_soap('ucenter','Notice', 'setting',array($this->_fid, 'addinvite'));

                //发送通知接口
                $notice_r = $this->apimodel->sendNotice(1, $this->uid, $this->_fid, 'dk', 'dk_addfriend');

                //处理通知结果
                $this->_sendNoticeResult($notice_r, abs($result));
                
            } elseif ($result == 10) {
                //直接成为好友    
                //葛飞超  2012-04-13 17：10   未读请求计数 减1
                call_soap('ucenter', 'Notice', 'setting', array($this->uid, 'editinvite'));

                //添加好友成功 更新索引 蓝燕光 2012-04-24
                //$this->apimodel->addOneToMyFriends($this->uid, $this->_fid);

                //通知IM 蓝燕光 2012-05-02
                $this->immodel->addImFriend(json_encode(array('uid'=>$this->uid, 'username'=>$this->username)), json_encode(array('uid'=>$this->_fid, 'username'=>$this->_fname)));

                //发送通知接口
                $notice_r = $this->apimodel->sendNotice(1, $this->uid, $this->_fid, 'dk', 'dk_confirmfriend');

                //处理通知结果
                $this->_sendNoticeResult($notice_r, abs($result));
            }
        } else {
            die(json_encode(array('state' => '1', 'msg' => '操作失败!', 'relation' => abs($result))));
        }
        
        
      /*  //判断是否为熟人
        $isfld = $this->apimodel->isBothFollow($this->uid, $this->_fid);
        if (!$isfld) {
            die(json_encode(array('state' => '0', 'msg' => '您和' . $this->_fname . '已取消互相关注，不能加为好友!', 'relation' => $this->apimodel->getRelationWithUser($this->uid, $this->_fid))));
        }
        
        //判断是否是好友关系
        $chk_fd = $this->apimodel->isFriend($this->uid, $this->_fid);
        if ($chk_fd) {
            die(json_encode(array('state' => '0', 'msg' => '您和' . $this->_fname . '已经是好友了!', 'relation' => $this->apimodel->getRelationWithUser($this->uid, $this->_fid))));
        }

        //检查是否已被邀请过
        $chk_invite = $this->apimodel->hasRequested($this->uid, $this->_fid, false);
        if ($chk_invite) {
            die(json_encode(array('state' => '0', 'msg' => '您已邀请过对方了!', 'relation' => $this->apimodel->getRelationWithUser($this->uid, $this->_fid))));
        }

        //检查对方是否有邀请我成为好友
        $check_fuid_invite = $this->apimodel->hasRequested($this->_fid, $this->uid, false);
        
        //如果对方也邀请我成为好友，那么直接加为好友
        if ($check_fuid_invite) {
            //接收好友请求
            $result = $this->apimodel->approveFriendRequest($this->uid, $this->_fid);
            if ($result) {
                //获取user信息
                $user_info = $this->apimodel->getUserInfo($this->uid);
                葛飞超  2012-04-13 17：10   未读请求计数 减1
				call_soap('ucenter', 'Notice', 'setting', array($this->uid, 'editinvite'));
                
                //添加好友成功 更新索引 蓝燕光 2012-04-24
                $this->apimodel->addOneToMyFriends($this->uid, $this->_fid);
                
                //通知IM 蓝燕光 2012-05-02
                $this->immodel->addImFriend(json_encode(array('uid'=>$this->uid, 'username'=>$this->username)), json_encode(array('uid'=>$this->_fid, 'username'=>$this->_fname)));
                
                //发送通知接口
                $notice_r = $this->apimodel->sendNotice(1, $this->uid, $this->_fid, 'dk', 'dk_confirmfriend');
               
                //处理通知结果
                $this->_sendNoticeResult($notice_r);
            }    
            
        
        
        }
        
        //发送好友请求
        $result = $this->apimodel->makeFriend($this->uid, $this->_fid);
        if ($result) {            
            //发送好友请求统计
            call_soap('ucenter','Notice', 'setting',array($this->_fid, 'addinvite'));

            //发送通知接口
            $notice_r = $this->apimodel->sendNotice(1, $this->uid, $this->_fid, 'dk', 'dk_addfriend');

            //处理通知结果
            $this->_sendNoticeResult($notice_r);
        } else {
            die(json_encode(array('state' => '0', 'msg' => '操作失败!', 'relation' => $this->apimodel->getRelationWithUser($this->uid, $this->_fid))));
        }*/
    }
    
    /**
     * 删除好友
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     */
    function delFriend() {
        //如果不是好友关系，直接跳过
        /*$relation = $this->apimodel->getRelationWithUser($this->uid, $this->_fid);
        if (1 != $relation) {
            die(json_encode(array('state' => '1', 'msg' => '操作成功!', 'relation' => $relation)));
        }*/
        
        //删除好友
        $result = (int) $this->apimodel->deleteFriend($this->uid, $this->_fid);
        if ($result > 0) {  
            //删除好友成功 更新索引 蓝燕光 2012-04-24
            //$this->apimodel->removeOneOfMyFriends($this->uid, $this->_fid);
            
           //通知IM 蓝燕光 2012-05-02
           $this->immodel->delImFriend(json_encode(array('uid'=>$this->uid, 'username'=>$this->username)), json_encode(array('uid'=>$this->_fid, 'username'=>$this->_fname)));
            
            die(json_encode(array('state' => '1', 'msg' => '操作成功!', 'relation' => abs($result))));
        } else {
            die(json_encode(array('state' => '1', 'msg' => '操作失败!', 'relation' => abs($result))));
        }
    }
    
    /**
     * 添加网页关注
     * @author	lanyanguang
     * @date	2012/04/24
     */
    function addWebFollow() {  
        //网页过滤
        $this->_relationWebFilter();
        
        //检查是否已关注过目标用户
        $chk_fd =  $this->apimodel->isWebFollowing($this->uid, $this->web_id);
        if ($chk_fd) {
            die(json_encode(array('state' => '0', 'msg' => '您已关注过该网页了!')));
        }
        
        //添加网页关注
        $result = $this->apimodel->webFollow($this->uid, $this->web_id);
        if ($result !== false) {
            //更新可能认识的网页数据 addby lanyanguang 2012-05-10
            $iid = $this->apimodel->getWebIid($this->web_id);
            $this->apimodel->updateWebIndex($iid, $this->uid, $this->web_id);
            
            //处理网页关注分类
            $this->apimodel->addAttention($this->uid, $this->web_id, $result);
            
            //处理网页索引更新
            $info = array(
                'uid' => $this->uid,
                'user_name' => $this->username,
                'user_dkcode' => $this->dkcode,
                'web_id' => $this->web_id,
                'following_time' => time(),
                'fans_count' => $result,
            );
            $this->apimodel->addAFansToWeb($info);
            
            //发送通知接口
            $notice_r = $this->apimodel->sendNotice($this->web_id, $this->uid, $this->_fid, 'web', 'dk_guanzhu_web', array('name'=> $this->_webinfo['name'], 'url'=>mk_url(APP_URL.'/index/index', array('web_id' => $this->web_id), false)));
           
            //处理通知结果
            $this->_sendWebNoticeResult($notice_r);
            
        }else{
            die(json_encode(array('state' => '0', 'msg' => '操作失败!')));
        }
    }
	
    /**
     * 取消网页关注
     * 
     * @author	lanyanguang
     * @date    2012/04/24
     */
    function unWebFollow() {
        //网页过滤
        $this->_relationWebFilter();
        
        //取消网页关注
        $result = $this->apimodel->unWebFollow($this->uid, $this->web_id);
        if ($result !== false) {        
            //处理网页关注分类
            $this->apimodel->delAttention($this->uid, $this->web_id, $result);
            
            //网页部分信息流数据清除 addby lanyanguang 2012-05-25
            $iid = (array) $this->apimodel->getWebIid($this->web_id);
            call_soap('timeline','Web', 'delAttentionWeb', array($this->uid, $this->web_id, $iid));
            
            //处理网页索引更新
            $this->apimodel->deleteUserOfWeb($this->web_id, $this->uid);
            
            die(json_encode(array('state' => '1', 'msg' => '操作成功!')));
        } else {
            die(json_encode(array('state' => '0', 'msg' => '操作失败!')));
        }
    }
    
    /**
     * 发送通知
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param boolean $result
     */
    private function _sendNoticeResult($result, $relation) {
        if (8 == $result) {
            /*switch ($result) {
                case '1':
                    die(json_encode(array('state' => '0', 'msg' => "接收通知用户不存在")));
                    break;
                case '2':
                    die(json_encode(array('state' => '0', 'msg' => "通知大分类不存!")));
                    break;
                case '3':
                    die(json_encode(array('state' => '0', 'msg' => "通知小分类不存!")));
                    break;
                case '4':
                    die(json_encode(array('state' => '0', 'msg' => "当前用户不存在!")));
                    break;
                case '5':
                    die(json_encode(array('state' => '0', 'msg' => "通知信息对应分类过滤失败!")));
                    break;
                case '6':
                    die(json_encode(array('state' => '0', 'msg' => "通知小分类输入错误!")));
                    break;
                case '7':
                    die(json_encode(array('state' => '0', 'msg' => '操作失败!')));
                    break;
                case '8':
                    die(json_encode(array('state' => '1', 'msg' => '操作成功!', 'relation'=>$this->apimodel->getRelationWithUser($this->uid, $this->_fid))));
                    break;
            }*/
            die(json_encode(array('state' => '1', 'msg' => '操作成功!', 'relation' => $relation)));
        } else {
            die(json_encode(array('state' => '1', 'msg' => '通知接口出错!', 'relation' => $relation)));
        }
    }

    /**
     * 发送通知
     * 
     * @author	lanyanguang
     * @date	2012/05/04
     * @param boolean $result
     */
    private function _sendWebNoticeResult($result) {
        if (8 == $result) {
          /*  switch ($result) {
                case '1':
                    die(json_encode(array('state' => '0', 'dk_code' => "接收通知网页不存在")));
                    break;
                case '2':
                    die(json_encode(array('state' => '0', 'msg' => "通知大分类不存!")));
                    break;
                case '3':
                    die(json_encode(array('state' => '0', 'msg' => "通知小分类不存!")));
                    break;
                case '4':
                    die(json_encode(array('state' => '0', 'msg' => "当前网页不存在!")));
                    break;
                case '5':
                    die(json_encode(array('state' => '0', 'msg' => "通知信息对应分类过滤失败!")));
                    break;
                case '6':
                    die(json_encode(array('state' => '0', 'msg' => "通知小分类输入错误!")));
                    break;
                case '7':
                    die(json_encode(array('state' => '0', 'msg' => '操作失败!')));
                    break;
                case '8':
                    die(json_encode(array('state' => '1', 'msg' => '操作成功!')));
                    break;
            }*/
            die(json_encode(array('state' => '1', 'msg' => '操作成功!')));
        } else {
            die(json_encode(array('state' => '1', 'msg' => '通知接口出错!')));
        }
    }
    
    /**
     * 前置过滤并获得目标用户uid
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param int
     */
    private function _relationFilter() {
        //获取登录用户uid
        if (!$this->uid) {
            die(json_encode(array('state' => '0', 'msg' => 'session失效!', 'relation' => $this->apimodel->getRelationStatus($this->uid, $this->_fid))));
        }
        
        //获取关注目标用户的uid
        $this->_fid = $this->input->post('f_uid');

        //检查关注目标用户的uid合法性
        $chk_id = $this->apimodel->getUserInfo($this->_fid);
        if (!$chk_id) {
            die(json_encode(array('state' => '0', 'msg' => "用户ID不合法!", 'relation' => $this->apimodel->getRelationStatus($this->uid, $this->_fid))));
        }
        $this->_fname = $chk_id['username'];
    }
    
    /**
     * 前置过滤并获得目标网页uid
     * 
     * @author	lanyanguang
     * @date	2012/05/04
     * @param int
     */
    private function _relationWebFilter() {
        //获得web_id
        $this->web_id = intval($this->input->get_post('web_id'));
        
        //web_id 不存在
        if (!$this->web_id) {
            die(json_encode(array('state' => '0', 'msg' => "网页ID不存在!")));
        }
        
        //检查关注目标网页的pageid合法性
        $this->_webinfo = $this->apimodel->getWebInfo($this->web_id);
        if (!$this->_webinfo) {
            die(json_encode(array('state' => '0', 'msg' => "网页ID不合法!")));
        }
        //自己的pageid不能关注的
        if ($this->_webinfo['uid'] == $this->uid) {
            die(json_encode(array('state' => '0', 'msg' => "不能关注自己的网页!")));
        }
    }
}
/* End of file api.php */
/* Location: ./application/controllers/api.php */
<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * web 页面信息流
 * @author zhoutianliang
 */
class Webstreams extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('webstreammodel');
    }
    //动态分类信息
    public function msgActionCate() {
		           
        $tagid = abs(intval($this->input->post('tagid')));
        $limit = abs(intval($this->input->post('page')));
        $a_uid = abs(intval($this->input->post('action_uid')));
           
           //$get_tagid = array(12,13,46);
           
        $uid = $this->uid;
        if($uid != $a_uid) {
            die(json_encode(array('data'=>null,'status'=>0,'msg'=>'非法操作')));
        }//判断是不是自已
        if(empty($tagid)) {
            die(json_encode(array('data'=>null,'status'=>0,'msg'=>'非法操作')));
        }//判断tagid是不是为空

        if(empty($limit)) {
            $limit = 1;
        }
           
        die($this->webstreammodel->getWebMsg($uid,$tagid,$limit));
    }
    public function getTimeCount() {
    	$tagid = $this->input->post('tagid');
    	$action_uid = $this->input->post('action_uid');
    	$ctime = $this->input->post('ctime');
    	if(empty($tagid)) {
    		die(json_encode(array('data'=>null,'status'=>0,'msg'=>'非法操作')));
    	}
    	$uid = $this->uid;
    	if($uid!=$action_uid) {
    		die(json_encode(array('data'=>null,'status'=>0,'msg'=>'非法操作')));
    	}
    	die($this->webstreammodel->getTimeCount($uid,$tagid,$ctime));
    }   
    public function getTimeContent() {
    	$tagid = $this->input->post('tagid');
    	$action_uid = $this->input->post('action_uid');
    	$ltime = $this->input->post('ltime');
    	if(empty($tagid)) {
    		die(json_encode(array('data'=>null,'status'=>0,'msg'=>'非法操作')));
    	}
    	$uid = $this->uid;
    	if($uid!=$action_uid) {
    		die(json_encode(array('data'=>null,'status'=>0,'msg'=>'非法操作')));
    	}
    	die($this->webstreammodel->getTimeContent($uid,$tagid,$ltime));
    }
 
}

?>

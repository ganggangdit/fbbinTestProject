<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * @author 周天良
 * 信息流控制器，读关注和好友信息
 */
class Msgstreams extends MY_Controller {
    
       public function __construct() {
           parent::__construct();
           $this->load->model('msgstream');    
       }       
        /**
            * 取得关注页面的信息流
            * @param $uid int 用户ID 
            * @param $limit int 显示第几页数据 默认为第一页
            * @param $type sttring 信息类型
            */
       public function followstream($limit=1,$type='fansInfos'){
        
           if(!$this->isAjax()) {
           	   die(json_encode(array('data'=>null,'status'=>0,'msg'=>'不是ajax请求')));
           }
           if($this->uid) {
              $uid = $this->uid; //获取UID 
           }

           if($uid==false) {
             die(json_encode(array('data'=>NULL,'status'=>0)));
           }
           
           $action_uid = $this->input->post('action_uid');

           if($uid != $action_uid) { //判断是不是本人访问。如果不是就是直接返回
               
              die(json_encode(array('data'=>NULL,'status'=>0))); 
           } 
           
           $limit = isset($_POST['page']) ? intval($_POST['page']) : 1;
           
           if($limit==0){ $limit=1;}
                                                     
           
           die($this->msgstream->getAllMsg($uid,$limit,$type));
  
       }
       
       /**
        * 取得好友页面信息流
        * @param $uid int 用户ID 
        * @param $limit int 显示第几页数据 默认为第一页
        * @param $type sttring 信息类型
        */
        public function friendstream($limit=1,$type='frisInfos'){
 
        	if(!$this->isAjax()) {
        		die(json_encode(array('data'=>null,'status'=>0,'msg'=>'不是ajax请求')));
        	}
           if($this->uid) {
              $uid = $this->uid; //获取UID 
           }
           
           if($uid==false) {
             die(json_encode(array('data'=>NULL,'status'=>0)));
           }
           
           $action_uid = $this->input->post('action_uid');
           
           if($uid != $action_uid) {
               
              die(json_encode(array('data'=>NULL,'status'=>0))); 
           }
           
           $limit = isset($_POST['page']) ? intval($_POST['page']) : 1;
           
           if($limit==0){ $limit=1;}
           
           die($this->msgstream->getFriendsMsg($uid,$limit,$type));
           
       }
       /**
        * 取得关注页面好友信息流
        * @param $uid int 用户ID 
        * @param $limit int 显示第几页数据 默认为第一页
        * @param $type sttring 信息类型
        */
       public function followFriStream($limit=1,$type='fans_frisInfos'){
       	   if(!$this->isAjax()) {
       		  die(json_encode(array('data'=>null,'status'=>0,'msg'=>'不是ajax请求')));
       	   }
           if($this->uid) {
              $uid = $this->uid; //获取UID 
           }
           
           if($uid==false) {
             die(json_encode(array('data'=>NULL,'status'=>0)));
           }
           $action_uid = $this->input->post('action_uid');

           if($uid != $action_uid) {
               
              die(json_encode(array('data'=>NULL,'status'=>0))); 
           }
           $limit = isset($_POST['page']) ? intval($_POST['page']) : 1;
           
           if($limit==0){ $limit=1;}
           
           die($this->msgstream->getFansFriendsMsg($uid,$limit,$type)); 
       }
       /**
        * 取得关注页面相互关注信息流
        * @param $uid int 用户ID 
        * @param $limit int 显示第几页数据 默认为第一页
        * @param $type sttring 信息类型
        */
       public function followMutualStream($limit=1,$type='fans_bothInfos'){
        
        
       	   if(!$this->isAjax()) {
       		  die(json_encode(array('data'=>null,'status'=>0,'msg'=>'不是ajax请求')));
       	   }
           if($this->uid) {
              $uid = $this->uid; //获取UID 
           }
           
           if($uid==false) {
             die(json_encode(array('data'=>NULL,'status'=>0)));
           }
           $action_uid = $this->input->post('action_uid');

           if($uid != $action_uid) {
               
              die(json_encode(array('data'=>NULL,'status'=>0))); 
           }           
           $limit = isset($_POST['page']) ? intval($_POST['page']) : 1;
           
           if($limit==0){ $limit=1;}
           
           die($this->msgstream->getMutualFollowMsg($uid,$limit,$type)); 
           
       }
       //获取时间段的总数
       public function getTimeCount() {
       	    if(!$this->isAjax()) {
       		    die(json_encode(array('data'=>null,'status'=>0,'msg'=>'不是ajax请求')));
       	    } 
            $msgtype = null;
            $ctime   = null;
            
            $msgtype = isset($_POST['msgtype']) ? $_POST['msgtype'] : 'fans';

            $ctime   = isset($_POST['ctime'])   ? intval($_POST['ctime']) : SYS_TIME;
            
            if($this->uid) {
              $uid = $this->uid; //获取UID 
            }
           
            if($uid==false) {
             die(json_encode(array('count'=>0,'status'=>0)));
            }
            
            die($this->msgstream->getTimeCount($uid,$msgtype,$ctime));
        
       }
       //获取时间段的总数内容
       public function getTimeContent(){
       	    if(!$this->isAjax()) {
       		    die(json_encode(array('data'=>null,'status'=>0,'msg'=>'不是ajax请求')));
       	    }
            $msgtype = null;
            
            $ctime   = null;
            
            $msgtype = isset($_POST['msgtype']) ? $_POST['msgtype'] : 'fans';
            

            $ctime   = isset($_POST['ltime'])   ? intval($_POST['ltime']) : SYS_TIME;
            
                        //取得显示类型  coentent 取得所有消息内容
 
           
            if($this->uid) {
              $uid = $this->uid; //获取UID 
            }
           
            if($uid==false) {
             die(json_encode(array('data'=>null,'status'=>0)));
            }
            
            die($this->msgstream->getTimeContent($uid,$msgtype,$ctime));
        
        
       }
//        public function test() {
       	
       	
//        	    $this->msgstream->test();
       	
//        }
               
     
       
}



?>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 首页应用区设计接口
 * @author yanghsunjun
 * @version 
 */

class Menu extends MY_Controller{
	/**
     * 目标用户是否是本人
     * 
     * @var boolean 
     */
   // private $_self = false;
    
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
	}
	
	/**
   	 * 
   	 * 更改首页应用区权限
   	 * 
   	 * @author yangshunjun
   	 */
   	public function changeAppPermissions(){
   		
   		$menu_id = $this->input->post('object_id');
   		$weight = $this->input->post('permission');
   		$type = $this->input->post('type');
   		
   		//确保用户本人操作
   		if($this->_self && $type == 'app'){
   			$userlist_content = '';
   			
   			//过虑应用发现兴趣及消息权限设置
   			if($menu_id == 1 || $menu_id == 11){
   				die(json_encode(array('state' => 1)));
   			}
   			
   			if(!in_array($weight, array(1, 3, 4, 8))){
   				$userlist_content = json_encode (explode(',', $weight));
   				$weight = -1;
   			}
   			
   			//判断为自定义选择用户为空时显示公开权限
            if($weight == -1 && $userlist_content == ''){
            	$weight = 1;
            }
			$data[] = array(
				'uid' => $this->uid,
				'menu_id' => $menu_id,
				'weight' => $weight,//自定义
				'userlist_content'=> $userlist_content,
			);
			
			$user_app_list = call_soap('ucenter', 'UserMenuPurview', 'setUserMenuPruview', $data);
			if($user_app_list == true){
				die(json_encode(array('state' => 1)));
			} 
			
			die(json_encode(array('state' => 1)));
   		}
   		
   		die(json_encode(array('state' => 1)));
   	}
   	
   	/**
   	 * 更改应用区排序
   	 * 
   	 * @author yangshunjun
   	 */
    public function resetAppSort(){
    	$menu_id = $this->input->post('dataMap');
   		
   		//确保用户本人操作
   		if($this->_self && $this->uid){
   			$menid_array = explode('|', $menu_id);
   			
   			if(is_array($menid_array)){
   				$len = count($menid_array);
   				foreach($menid_array AS $key => $val){
   					$sort_data[] = array($val, $len);
   					
   					$len--;
   				}
   			}
   			
			$data = array(
			   'uid' => $this->uid,
			   'menuIdList' => $sort_data
			);
			
			$update = call_soap('ucenter', 'UserMenuPurview', 'setUserMenuOrder', $data);
			if($update === true){
				die(json_encode(array('state' => 1)));
			} 
			
			die(json_encode(array('state' => 0)));
   		}
   		
   		die(json_encode(array('state' => 0)));
    }
}
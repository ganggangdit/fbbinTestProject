<?php

/**
 * 和JS交互的头部API
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/03/23>
 */
class Topapi extends MY_Controller
{

    public function __construct()
    {
        
    	parent::__construct();
    	
        //$this->user = call_soap('ucenter', 'Passport', 'getUserInfo', array($this->uid));
    }
    
    public function action()
    {
        $html = '';
        //$html += '<script>';
        $html += 'var current_uid = ' . $this->action_dkcode;
        //$html += '</script>';
        
        echo $html;
    }

    /**
     * 获取头部未读信息条数
     * @author 
     * @date 2012-3-6
     * return json
     */
    function topUnreadCount()
    {
        $infos = $this->getUnreadCount();
        //返回json数据
        $data = array('status' => 1, 
        'data' => array('requests' => $infos['unread_friendapply'], 'messages' => $infos['unread_msg'], 'notice' => $infos['unread_notice']));
        die(json_encode($data));
    }

    /**
     * 获取头部网页信息
     * @author mawenpei<mawenpei@duankou.com>
     * @date <2012/03/15>
     */
    public function topCircleNav()
    {
        $html = $this->getWeb();
        die($html);
    }

    /**
     * 获取头部信息
     * @author mawenpei<mawenpei@duankou.com>
     * @date <2012/03/15>
     */
    public function showheader()
    {
        $message = $this->getUnreadCount();
        //$message['unread_abc'] = 0;
        //$message['unread_msg'] = 0;
        //$message['unread_notice'] = 0;
        $web = $this->getWeb();
        
        if ($this->user)
        {
            $url =  WEB_ROOT;
            $info = array('state' => 1, 'num' => array_values($message), 'app' => $web,            
            'header' => array('name' => $this->user['username'], 'url' => $url, 'img' => get_avatar($this->user['uid'], 's')), 'msg' => '');
            
            die(json_encode($info));
        }
    }

    private function getUnreadCount()
    {
        $infos = array();
        $this->load->model('messagemodel', '', TRUE);
        
        $info = $this->messagemodel->show_unread($this->user['uid']);
        if(!$info || empty($info))
        {
            $infos['unread_friendapply'] = 0;
            $infos['unread_msg'] = 0;
            $infos['unread_notice'] = 0;
            return $infos;
        }
        
        $infos['unread_friendapply'] = $info[0]['un_invite'];
        $infos['unread_msg'] = $info[0]['un_msg'];
        $infos['unread_notice'] = $info[0]['un_notice'];
        return $infos;
    }

    private function getWeb()
    {
    	$html_arr 	= null;
    	$html_arr[0]='';
    	
        $uid		= $this->user['uid'];
        $weblist	= call_soap('interest', 'Index' ,'get_webs' , array($uid) );
		$weblist	= json_decode($weblist);
		
        if(is_array($weblist)){
	        $arr 	= null;
        	foreach ($weblist as $one){
	            $one		= (array ) $one;
				$arr['url'] = WEB_DUANKOU_ROOT.'main/?web_id='.$one['aid'];
	            $arr['img'] = get_webavatar( $uid , 'ss' ,$one['aid']);
	            $arr['txt'] = $one['name'];
	            $arr['web_id'] 	= $one['aid'];
	            $html_arr[] = $arr;
	        }
        }
        
        $arr		= null;
        $arr['url'] = WEB_DUANKOU_ROOT.'main/?c=create';
        $arr['img'] = '';
        $arr['txt'] = '+';
        $arr['web_id'] = '';
        $html_arr[] = $arr;
        
        $arr 		= null;
        $arr['current'] = 1;
        $arr['url'] = WEB_ROOT.'main';
        $arr['img'] = '';
        $arr['txt'] = '首页';
        $arr['web_id'] = '';
        $html_arr[0] = $arr;
        
        return $html_arr;
        
	}
	
	
	
	
	/***
	 * 排序显示  网页
	 * **/
	public function web_order(){
		$uid		= $this->user['uid'];
		$aid		= intval( $this->input->get_post('web_id') );
		$status		= call_soap('interest', 'Index' ,'web_order' , array($uid , $aid) );
		if($status) $status = 1;
		else 		$status = 0;
		
		echo json_encode(array('status'=>$status, 'msg'=>'' ));
		die;
	} 
	
	
	
	
	
	
	
	
	
	
	
	
}

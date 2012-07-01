<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 用户设置
 * @author mawenpei
 * @date <2012/03/25>
 */
class setting extends MY_Controller 
{	
    protected $userinfo;
    public function __construct()
    {    	
    	parent::__construct();
    	$this->userinfo = $this->user;
    	$this->assign('user',$this->user);
    }
	/**
	 * 首页	  
	 */
	public function index()
	{			
		$this->settingAccount();
	}

    /**
	 * 一般设置
	 */
	public function settingAccount()
	{
	    $this->assign('login_name',$this->userinfo['username']);
	    $this->assign('login_email',$this->userinfo['email']);
	    $this->assign('login_lastupdatepwdtime',$this->userinfo['lastupdatepwdtime']);
	    $this->assign('select',$this->createSelect('0',true));
	    
	    $this->display("setting-userinfo/setting_account.html");
	}
	
	/**
	 * 检查用户是否设置了密保
	 */
	public function checkSecurity()
	{
	    $result = call_soap('ucenter','Passport','isHasSecurity',array($this->userinfo['dkcode']));
	    if($result)
	    {
	        die(json_encode(true));
	    }
	    else 
	    {
	        die(json_encode(false));
	    }
	}
	
	/**
	 * 验证密保问题
	 */
	public function verifySecurity()
	{
	    $mb_question_id = $this->input->post('question');
	    $mb_answer = $this->input->post('answer');
	    $result = call_soap('ucenter','Passport','verifyUserSecurity',array($this->userinfo['dkcode'],$mb_question_id,$mb_answer));
	    if($result)
	    {
	        die(json_encode(true));
	    }
	    else 
	    {
	        die(json_encode(false));
	    }
	}
	
	
	
	/**
	 * 验证旧密码
	 */
	public function verifyOldPasswd()
	{
		$ret = array('state'=>0,'msg'=>'密码不在存');
	    $oldpasswd = $this->input->post('old');
	    $result = call_soap('ucenter','Passport','checkUserAuth',array($this->userinfo['dkcode'],$oldpasswd));
	    if($result)
	    {
	    	$ret['state'] = 1;
	    	$ret['msg'] = '密码在存';
	        die(json_encode($ret));
	    }
	    else 
	    {
	        die(json_encode($ret));
	    }
	}
	
	/**
	 * 重置密码
	 * 成功返回json格式state 为1
	 * 失败返回json格式state为0
	 */
	public function resetPasswd()
	{
	    $oldpasswd = $this->input->post('old_pwd');
	    $pwd_new = $this->input->post('new_pwd');
	    
	    $url = mk_url('main/setting/settingAccount');
	    $ret = array('state'=>0,'url'=>$url,'msg'=>'');
	    //验证密码合法性
	    $result = call_soap('ucenter','Passport','checkUserAuth',array($this->userinfo['dkcode'],$oldpasswd));
	    if($result)
	    {
	        $change = call_soap('ucenter','Passport','resetUserPassword',array($this->userinfo['dkcode'],$pwd_new));
	        if($change)
	        {
	        	$ret['state']=1;
	        	$ret['msg']='密码修改成功';
	        	die(json_encode($ret));
	        }
	        else 
	        {
	           $ret['msg']='密码修改失败';
	           die(json_encode($ret));
	        }
	    }
	    else
	    {
			 $ret['msg']='旧密码错误';
			 die(json_encode($ret));
	    }
	    
	}
	
	/**
	 * 创建密保问题
	 */
    private function createSelect($selected='0',$setting = false)
    {
    	$list = config_item('security_list');
    	if(empty($list)) $list = array(
    		'1'=>'填写一部电影',
    		'2'=>'填写一个演员',
    		'3'=>'填写一个卡通形象',
    		'4'=>'填写一首歌曲',
    		'5'=>'填写一部电视剧'
            );
    	$setting_list = call_soap('ucenter','Passport','getUserSecurity',array($this->userinfo['dkcode']));
    	if($setting && $setting_list)
    	{
    	    $setting_list = unserialize($setting_list);
    	    $keys = array_keys($setting_list);
    	    foreach($list as $key=>$one)
    	    {
    	        if(!in_array($key,$keys)) unset($list[$key]);
    	    }
    	}
    	$html = '';
    	foreach($list as $key=>$one)
    	{
    		if($key == $selected)
    		{
    			$html .= '<option value="' . $key . '" selected>' . $one . '</option>';
    		}
    		else 
    		{
    			$html .= '<option value="' . $key . '">' . $one . '</option>';
    		}
    	}
    	return $html;
    }

	/**
	 * 安全设置
	 */
	public function settingSecurity()
	{
	    $this->assign('login_name',$this->userinfo['username']);
	    $this->assign('select',$this->createSelect());
	    $this->display("setting-userinfo/setting_security.html");
	}
	
    /**
	 * 设置密保问题
	 */
    public function setSecurity()
	{
	    $mb_question_id = $this->input->post('question');	    
	    $mb_answer = $this->input->post('answer') ? $this->input->post('answer') : $this->input->post('newanswer');
	    $mb_oldanswer = $this->input->post('oldanswer');
	    
	    $result = call_soap('ucenter','Passport','isHasSecurity',array($this->userinfo['dkcode']));
	    $result = $result ? unserialize($result) : false;

	    $ret = array('state'=>0,'msg'=>'');
	    if($result && isset($result["{$mb_question_id}"]) && !empty($result["{$mb_question_id}"]))
	    {
	        if($result["{$mb_question_id}"] != $mb_oldanswer)
	        {
	           $ret['msg'] = '密保问题的原始答案错误';
	            die(json_encode($ret));
	        }
	    }
	    if(!$mb_answer)
	    {
	        $ret['msg'] = '密保问题的答案不能为空';
	         die(json_encode($ret));
	    }
	    $result = call_soap('ucenter','Passport','setUserSecurity',array($this->userinfo['dkcode'],$mb_question_id,$mb_answer));
	    if($result)
	    {
	    	$ret['state']=1;
	         $ret['msg'] = '密保问题设置成功';
	        die(json_encode($ret));
	    }
	    else 
	    {
	        $ret['msg'] = '密保问题设置失败';
	         die(json_encode($ret));
	    }
	    
	}
	
	/**
	 * 密保问题是否存在
	 */
	public function isExistsSecurity()
	{
	    $mb_question_id = $this->input->post('question');
	    $result = call_soap('ucenter','Passport','isHasSecurity',array($this->userinfo['dkcode']));
	    $result = $result ? unserialize($result) : false;
	    if($result && isset($result["{$mb_question_id}"]) && !empty($result["{$mb_question_id}"]))
	    {
	        die(json_encode(true));
	    }
	    else 
	    {
	        die(json_encode(false));
	    }
	}
	
	/*
	 * 取得当前用户所创建的网页列表
	 * imid为一级分类id
	 * iid为二级分类id
	 * aid为网页应用的id
	 * name为网页的名字
	 */
	public function settingWeb()
	{
		 $this->assign('login_name',$this->userinfo['username']);
	     $this->display("setting-userinfo/setting_webpage.html");
	}
	
	
	/*
	 * 获取数据
	 */
	public function getWebDate(){
		$uid = $this->uid;
		
		 $web_lists = array('isend'=>true,'msg'=>'','status'=>0);
		 $web_data = array();
		
		$page = $this->input->post('page') ? $this->input->post('page') :1;
		$page_size = 30;
		$start = (((int)$page)-1)*$page_size;
		//获得给定用户uid所创建的网页，先获取30条
		 $web_list = call_soap('interest','Index','get_webs_page',array($uid,$start,$page_size));
		 
		 if(!empty($web_list) )
		 {
		 	$web_list = json_decode($web_list);
		 	if($web_list->ct>0)
		 	{
		 		$total = ceil($web_list->ct / $page_size);
				if($page <$total){
					 $web_lists['isend'] = false;
				}
				
				//取得本次加载网页的所有web_id
				$web_ids = array();
				foreach($web_list->data as $v){
					$web_ids[] = $v->aid;
				}
				//取得网页是否删除的结果集
				$is_delete = call_soap('interest','Index','get_display_web_info',array($web_ids));
				$is_delete = json_decode($is_delete,true);
				
				//拼接web的网页url
				if(defined('WEB_DUANKOU_ROOT') && WEB_DUANKOU_ROOT){
					$web_root = WEB_DUANKOU_ROOT;
				}
				if(defined( 'WEB_DUANKOU_ROOT_APP_URL') && WEB_DUANKOU_ROOT_APP_URL){
					$web_app = WEB_DUANKOU_ROOT_APP_URL;
				}
						
				if(isset($web_root) && isset($web_app)){
					$url = $web_root.$web_app.'?web_id=';
				}
				
		 		foreach ($web_list->data as $key => $val)
		 		{
		 			//获取网页图像大小为30x30 (px)
		 			$web_avatar = get_webavatar($uid,'ss',$val->aid);
		 			
		 			if(isset($is_delete[$val->aid])  && ($is_delete[$val->aid] ) ){
		 				 $del_ret = 1 ;
		 			} else{ 
		 				$del_ret = 0 ;
		 			}
		 			$fans_num = 0;
		 			$fans_num = number_format($val->fans_count, 0, '.' ,', ');
		 			if(isset($url)){
		 				$url_link = $url.$val->aid;
		 			}else{
		 				$url_link = '';
		 			}
		 			$web_data[] = array('web_name'=>$val->name, 'web_aid'=>$val->aid, 'web_imid'=>$val->imid,'fans_count'=>$fans_num,'web_avatar'=>$web_avatar,'is_info'=>$val->is_info,'is_del'=>$del_ret,'url'=>$url_link);
		 		}
		 	}
		 }	
		 
		 //判断是否有数据返回，如果有数据返回1，否则返回0
		 if(count($web_data)>0){
		 	$web_lists['status'] = 1;
		 }
		 
		 $web_lists['data']=$web_data;
		 $web_lists['page']=$page;
		 die(json_encode($web_lists)); 
	}
	
	
	//编辑网页设置
	public function editWeb(){
		$web_id = $this->input->post('web_aid');
		$uid = $this->uid;
		
		//同步网页创建者信息到网页资料中 1为同步，0不同步
		$is_synname = $this->input->post('synname') ? 1 : 0;
		
		//置顶网页1为置顶，0为不置顶
		$is_topweb = $this->input->post('topweb') ? 1: 0;
		
		$ret = array('state'=>0,'msg'=>'设置失败');
		$syn_result = 0;
		$topweb_result = 0;
		
		$syn_result= 	$this->_synName($web_id,$is_synname);
		
		if(!$syn_result ){
			die(json_encode($ret));
		}
		
		//判断用户是否选择了网页置顶
		if($is_topweb){
			$topweb_result = 	$this->_topWeb($web_id,$uid);
			if($topweb_result && $syn_result){
				$ret['state'] = 1;
				$ret['msg'] = '设置成功';
			}
		}else{
			$ret['state'] = 1;
			$ret['msg'] = '设置成功';
		}
		
		die(json_encode($ret));
	}
	
	/*
	 * $aid为网页id
	 * $is_info为是否同步创建者姓名到网页资料中0为不同步，1为同步
	 */
	public function _synName($aid=0,$is_info=0){
		if($aid<=0){
			return false;
		}
		
	 	$ret=call_soap('interest','Index','web_is_info',array($aid, $is_info));	
		if(!$ret){
			return false;
		}
		return true;
	}
	
	
	//网页置顶
	public function _topWeb($web_id = 0,$uid=0){
		if($web_id<=0 || $uid <=0){
			return false;
		}
		$status =  call_soap('interest', 'Index' ,'web_order' , array($uid , $web_id) );
		if($status) {
			$status = 1;
		}else{
			$status = 0;
		} 		
		return $status;
	}
	
	
	/*
	 * 删除网页根据传过来的网页id
	 */
	public function delWeb($aid=0){
		$web_id = $this->input->post('web_id');
		if($web_id<=0){
			return false;
		}
		//返回的状态1为成功，0为失败
		$url=mk_url('main/setting/settingWeb');
		$ret = array('state'=>0,'url'=>$url);
		
		$web_info = array();
		//检查传过来的网页是否存在
		$web_info = call_soap('interest','Index','get_web_info',array($web_id));	
		if( count($web_info)>0 ){
			
			//网页的名称
			$web_name = $web_info[0]['name'];
			//网页所属的二级分类
			$iid = $web_info[0]['iid'];
			//网页所属的一级分类
			$imid = $web_info[0]['imid'];
			
			unset($web_info);
			$infos = array('uid'=>$this->uid, 'web_id'=>$web_id, 'web_name'=>$web_name, 'iid'=>$iid,'imid'=>$imid);
			$data[0]	 ['call']	= 'del_web';
			$data[0]	 ['data']	= $infos;
			$data = json_encode($data);
			
			//禁用网页     禁用成功返回一个数字，失败返回0
			$ret_web = call_soap('interest','Index','display_web',array($web_id,$data));
			if($ret_web){
				$ret['state']=1;
			}	
			die(json_encode($ret));
			
		}
		die(json_encode($ret));
	}
	
}


<?php
/**
 * 控制器类文件
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
class MY_Controller extends CI_Controller
{
	//
	protected $sessionid = null;
	/**
	 * @var mix 模板视图引擎
	 */
    protected $view = null;
    //当前登录用户信息
    protected $uid    = null;
    protected $dkcode = null;
    protected $user   = null;
    protected $username   = null;
    //当前主页用户信息
    protected $action_uid    = null;
    protected $action_dkcode = null;
    protected $action_user   = null;
    
    protected $_self = false;
    
    /**
     * 构造函数
     */    
    public function __construct()
    {
    	parent::__construct();
    	//开启Session
    	$this->sessionid = get_sessionid();
    	//开启模板引擎
        require_cache(APPPATH . 'core' . DS . 'MY_View' . EXT);
    	$this->view = new MY_View(array('engine'=>'smarty','config'=>array()));
    	
        if(method_exists($this,'_initialize'))
        {
        	$this->_initialize();
        }
        
        // 应晓斌  调整调用接口 2012-5-25
        $this->uid = $this->checkLogin();
        //初始化用户信息
        $this->init_user();
        
    }
    
    /**
     * 初始化用户信息 
     */
    private function init_user()
    {
        $this->action_dkcode = intval($this->input->get_post('action_dkcode')); 
        if($this->action_dkcode && intval($this->action_dkcode) > 0)
        {
            $this->action_user = call_soap('ucenter','User','getUserInfo',array($this->action_dkcode,'dkcode'));
            $this->action_uid = isset($this->action_user['uid']) ? $this->action_user['uid'] : 0;
            define('ACTION_UID',$this->action_uid);
            define('ACTION_DKCODE',$this->action_dkcode);
        }
        else 
        {
        	
            define('ACTION_UID',0);
            define('ACTION_DKCODE',0);
        }
        
        $this->user = call_soap('ucenter','User','getUserInfo',array($this->uid,'uid'));
        $this->dkcode = $this->user['dkcode'];
        $this->username = $this->user['username'];
    }
    
    /**
     * 初始化网站信息
     * 
     * @author mawenpei
     * @date <2012-05-28>
     * 
     */
    public function init_site()
    {
        //加载redis驱动类
        require_cache(APPPATH . 'core' . DS . 'MY_Redis' . EXT);
        $redis = MY_Redis::getInstance();        
        $siteopt = Array();
        $siteopt = $redis->hgetall('config:siteopt');
        //赋值给模板变量
        $this->assign('siteopt',$siteopt);
         
    }
    
    /**
     * 检查是否登录
     */
    public function checkLogin()
    {
    //	$result = call_soap('ucenter','Passport', 'getLoginUID',array($this->sessionid));
	$result = $this->sys_is_login();    
	if(!$result)
    	{
			//返回ajax请求登陆状态 lvxinxin add 2012-05-29 
			if($this->isAjax()){
				die(json_encode(array('session'=>-1)));
			}
			else{
				$this->redirect(WEB_ROOT . 'front/index.php?returnurl=' . WEB_ROOT . 'main/index.php');
			}
    		
    	}
    	else 
    	{
    		return $result;    		
    	}
    }
   
public function sys_is_login(){
	static $mem;
	if(!isset($mem)){
		$mem = new Memcache();
		$config = config_item('memcache');
		$mem->addServer($config['host'],$config['port'],true,10);
	}
	return $mem->get('default_' . $this->sessionid . 'uid');
 }

 
    /**
     * 获取当前登录用户的UID
     */
    protected function getLoginUID()
    {
    	// 应晓斌  调整调用接口 2012-5-25
    	if (isset($this->uid)) {
    		return $this->uid;
    	} else {
    		return call_soap('ucenter','Passport', 'getLoginUID',array($this->sessionid));
    	}
    } 

        /**
     * 获取当前登录用户的UID
     */
    public function getLoginInfo()
    {
    	return call_soap('ucenter','Passport', 'getLoginInfo',array($this->sessionid));
    } 
    
    /**
     * 检查表单令牌是否正确
     */
    protected function _check_token()
    {
        if(!$this->isAjax())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				$token_name = config_item('token_name');
				if($this->session->userdata($token_name) != $this->input->post($token_name))
				{
					show_error('表单验证失败');
				}
			}
			
		}
    }
    
    
    /**
     * 获取模板文件的内容
     * 
     * @access protected
     * @param string $templateFile 模板文件名
     * @param string $charset 模板的字符集,默认是utf-8
     * @param string $contentType 输出类型,默认是text/html
     * @return string 返回模板内容
     */
    public function fetch($templateFile = '', $charset = 'utf-8', $contentType = 'text/html')
    {
        return $this->view->fetch($templateFile,$charset,$contentType);
    }
    
    /**
     * 模板变量赋值
     * @param string $name 模板中变量的名称
     * @param mix $value 用来替换模板中变量的值
     */
    public function assign($name,$value='')
    {
        $this->view->assign($name,$value);
    }
    
    /**
     * 加载并显示模板
     * @param string $templateFile 模板文件名
     * @param string $charset 模板的字符集,默认是utf-8
     * @param string $contentType 输出类型,默认是text/html
     */
    public function display($templateFile = '', $charset = 'utf-8', $contentType = 'text/html')
    {
        $this->view->display($templateFile,$charset,$contentType);
    }    
    
    /**
     * 是否是AJAX请求
     * 
     * @return bool
     */
    public function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']))
        {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
            {
                return true;
            }
        }
        return false;
        
    }
    
    /**
     * 
     */
    public function showmessage($msg = array(),$type = 2,$url = '',$time = 3)
    {
    	if(!is_array($msg))
    	{
    		$msg = array('info'=>$msg);
    	}
    	if(empty($url))
    	{
    		$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
    	}
    	
    	$this->assign('msg',$msg);
    	//$this->assign('type',$type);
    	$this->assign('url',$url);
    	$this->assign('time',$time);
    	if($type == 2)
    	{
    	    $this->display('error.html');
    	}
    	elseif($type == 1)
    	{
    	    $this->display('success.html');
    	}
    	die;
    }
    /**
     * 跳转到指定的模块
     * @access protected
     * @param string $url 跳转的URL表达式
     * @param array  $params 其他URL参数
     * @param int    $delay 延迟跳转的时间，单位是秒
     * @param string $msg   跳转提示信息
     */
    public function redirect($url,$params = array(),$delay = 0,$msg = '')
    {
    	$http_response_code = 302;
    	$tourl = mk_url($url,$params);
    	header("Location: " . $tourl, TRUE, $http_response_code);
    	//echo "<script>location.href = '". $tourl ."'; </script>";
    }
    
    /**
     * Ajax方式返回数据到客户端
     * 
     * @param mixed $data 要返回的数据
     * @param string $info 提示信息
     * @param boolean $status 返回的状态
     * @param string $type 返回的类型 JSON|XML|HTML|EVAL|TEXT
     * 
     */
    public function ajaxReturn($data,$info='',$status = 1,$type='json')
    {
        $result = array();
        $result['status'] = $status;
        $result['info'] = $info;
        $result['data'] = $data;
        $type = strtoupper($type);
        if($type == 'JSON')
        {
        	header("Content-Type:text/html; charset=utf-8");
        	exit(json_encode($result));
        }
        elseif($type == 'XML')
        {
        	header("Content-Type:text/xml; charset=utf-8");
        	
        }
        elseif($type == 'EVAL')
        {
        	header("Content-Type:text/html; charset=utf-8");
        	exit($data);
        }
        elseif($type == 'TEXT')
        {
        	header("Content-Type:text/html; charset=utf-8");
        	exit($data);
        }
        elseif($type == 'HTML')
        {
        	header("Content-Type:text/html; charset=utf-8");
        	exit($data);
        }
    }
} 

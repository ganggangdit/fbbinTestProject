<?php
/**
 * 视图模板类
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 * @version $Id$
 */

class MY_View
{
	
	private $tpl;
	
	protected $tVar = array();
	protected $templateFile = '';
	protected $engine = 'smarty';
	protected $config = '';
	
	public function __construct($config=array())
	{
		if(is_array($config) and count($config)>0)
		{
			$this->engine = strtolower($config['engine']);
			$this->config = $config['config'];
		}		
		$this->factory();
	}
	
	public function assign($name,$value='')
	{
		if(is_array($name))
		{
			$this->tVar = array_merge($this->tVar,$name);
		}
		elseif(is_object($name))
		{
			foreach($name as $key=>$val)
			{
				$this->tVar[$key] = $val;
			}
		}		
		else 
		{
			$this->tVar[$name] = $value;
		}
	}
	
	private function factory()
	{
	    if($this->engine == 'smarty')
		{			
			$this->tpl = CI_ViewSmarty::getInstance($this->config);					    			
		}		
	}
	
	public function fetch($templateFile = '', $charset = 'utf-8', $contentType = 'text/html',$display = false)
	{				
		if(empty($templateFile)) return;
		$this->templateFile = $templateFile;					
		$content = $this->tpl->fetch($this->templateFile,$this->tVar);
		$content = $this->templateContentReplace($content);
		if($display==true)
		{
			echo $content;
		}	
		else
		{
			return $content;
		}
	}
	
	public function display($templateFile = '', $charset = '', $contentType = 'text/html')
	{
		$this->fetch($templateFile,$charset,$contentType,true);
	}
	
	public function buildHtml()
	{
		
	}
	
    /**
     +----------------------------------------------------------
     * 模板内容替换
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $content 模板内容
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    protected function templateContentReplace($content) 
    {       
        if(preg_match('/<\/form(\s*)>/is',$content,$match)) 
        {
            // 智能生成表单令牌隐藏域
            $replace[$match[0]] = $this->buildFormToken().$match[0];
            $content = str_replace(array_keys($replace),array_values($replace),$content);
        }                
        
        return $content;
    }
	
    private function buildFormToken() 
    {
        // 开启表单验证自动生成表单令牌
        $tokenName   = config_item('token_name');
        $tokenValue = get_session($tokenName) ? get_session($tokenName) : md5(microtime(TRUE));
                
        $token   =  '<input type="hidden" name="'.$tokenName.'" value="'.$tokenValue.'" />';
        set_session($tokenName,$tokenValue);
        return $token;
    }
}


/**
 * Smarty模板引擎类
 */
class CI_ViewSmarty
{
	private static $_instance = null;
	
	private $tpl = null;
	
	private function __construct($config=array())
	{
		require_once APPPATH . 'libraries' . DS . 'Smarty' . DS . 'Smarty.class.php';
		$this->tpl = new Smarty();
		if(!is_array($config) or count($config) ==0)
		{
			$this->tpl->compile_dir = APPPATH . 'var' . DS . 'runtime' . DS . 'templates_c' . DS;
			$this->tpl->caching = false;
			$this->tpl->left_delimiter = '<!--{';
			$this->tpl->right_delimiter = '}-->';		
			$this->tpl->template_dir = APPPATH . 'views' . DS;
		}
		else
		{
			foreach($config as $key=>$val)
			{
				$this->tpl->$key = $val;
			}
		}
	}
	
	public static function getInstance($config)
	{
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self($config);
		}
		return self::$_instance;
	} 
	
	public function fetch($templateFile = '', $vars)
	{
	    if(($pos = strrpos($templateFile,'.')) === FALSE)
		{
			$ext = '.html';
		}
		else 
		{
			$ext = '';
		}
								
		$filepath = APPPATH . 'views' . DS . $templateFile . $ext;
		if(!file_exists($filepath))
		{
			show_error('Template file not found:' . $filepath);
		}
		
		$this->tpl->assign($vars);
		return $this->tpl->fetch($filepath);
		
	}
}

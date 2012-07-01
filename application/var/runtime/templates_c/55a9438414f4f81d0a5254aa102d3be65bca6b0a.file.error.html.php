<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 15:50:59
         compiled from "application/views/error.html" */ ?>
<?php /*%%SmartyHeaderCode:11391330924fc9c5e3991497-49942826%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55a9438414f4f81d0a5254aa102d3be65bca6b0a' => 
    array (
      0 => 'application/views/error.html',
      1 => 1333608246,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11391330924fc9c5e3991497-49942826',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
    'item' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc9c5e3a55ed',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc9c5e3a55ed')) {function content_4fc9c5e3a55ed($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @MISC_ROOT;?>
css/common/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/reg/reg.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/error/error.css" rel="stylesheet" type="text/css" />
<title>登陆口-端口网</title>
</head>
<body style="background-color:#E7EBF2;">

<!-- start: headerWrap 头部开始 -->
<div class="headerWrap">
	<div class="regHeader">
		<h1><a href="<?php echo @WEB_ROOT;?>
" title="Duankou">Duankou</a></h1>
	</div>
</div>
<!-- end: headerWrap 头部结束 -->

<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueBody">
			<div class="sorry">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
				<p><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</p>
				<?php } ?>
				<ul>
					<li>您可以：</li>
					<li>2、返回 <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">上一页</a></li>
					<li>3、返回 <a href="<?php echo @WEB_ROOT;?>
">首页</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- start: footer 底部开始 -->
<div class="clearfix" id="footer">
	<span class="copyRight">Duankou &copy; 2011 · <a href="#">中文(简体)</a></span>
	<span class="footerLinks"><a href="#">关于</a>·<a href="#">开放平台</a>·<a href="#">手机</a>·<a href="#">广告</a>·<a href="#">招聘</a>·<a href="#">隐私政策</a>·<a href="#">帮助中心</a></span>
</div>
<!-- end: footer 底部结束 -->
</body>
</html>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.7, created on 2012-06-05 17:09:37
         compiled from "application/views/setting-userinfo/setting_webpage.html" */ ?>
<?php /*%%SmartyHeaderCode:20143941354fc864c9479957-38638866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '697db44fadff75919693054e4545e76c89ad19b1' => 
    array (
      0 => 'application/views/setting-userinfo/setting_webpage.html',
      1 => 1338886789,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20143941354fc864c9479957-38638866',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc864c95684c',
  'variables' => 
  array (
    'user' => 0,
    'login_name' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc864c95684c')) {function content_4fc864c95684c($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/setting-userinfo/setting_userinfo.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="body clearfix">
	<div class="mainArea">
		<!--start: 网页设置头部-->
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><img src="<?php echo get_avatar($_smarty_tpl->tpl_vars['user']->value['uid'],'s');?>
" alt="" /></a></span>
			<div class="userName" id="userName">
				<span class="nameTxt"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><?php echo $_smarty_tpl->tpl_vars['login_name']->value;?>
</a></span>
				<span class="nameTxt">
					<span class="fl">系统设置</span>
				</span>
				<div class="dropMenu">
					<div class="triggerBtn"><span class="fl">网页设置</span><s></s></div>
					<div class="dropList">
						<ul class="dropListul">
							<li><a href="<?php echo mk_url('main/setting/settingAccount');?>
" class="itemAnchor"><i class="i_account"></i><span>一般</span></a></li>
							<li><a href="<?php echo mk_url('main/setting/settingSecurity');?>
" class="itemAnchor"><i class="i_security"></i><span>安全</span></a></li>
							<li><a href="<?php echo mk_url('main/notice/settingnotice');?>
" class="itemAnchor"><i class="i_notice"></i><span>通知</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--end: 网页设置头部-->
		<div class="modlueBody clearfix"  id="web_setting">
			<!--star: headerArea 网页设置标题开始-->
            <h2 class="accountTitle">系统设置  / 网页设置</h2>
      		<!--end: headerArea 网页设置标题结束--> 
      		<!--start: contentArea 网页设置具体内容开始-->
      		
	            		<div class="web-setting-side">
	            			<p class="head"><strong>网页名称</strong></p>
							<ul class="webset-info-box">
							
							</ul> 
						</div>
						
         	<!--end: contentArea 网页设置具体内容结束--> 
		</div>
	</div>
	
	<div class="sideArea">
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/timeline/scrollLoad.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/setting_userinfo/seting_web.js" type="text/javascript"></script>
</body>
</html><?php }} ?>
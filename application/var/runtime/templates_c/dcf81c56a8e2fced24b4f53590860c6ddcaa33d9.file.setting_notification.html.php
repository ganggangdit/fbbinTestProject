<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 16:21:06
         compiled from "application/views/setting-userinfo/setting_notification.html" */ ?>
<?php /*%%SmartyHeaderCode:17800439684fc87b7247e428-80057513%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dcf81c56a8e2fced24b4f53590860c6ddcaa33d9' => 
    array (
      0 => 'application/views/setting-userinfo/setting_notification.html',
      1 => 1337325618,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17800439684fc87b7247e428-80057513',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'login_username' => 0,
    'login_email' => 0,
    'userlist' => 0,
    'ul' => 0,
    'value' => 0,
    'web_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc87b72749b7',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc87b72749b7')) {function content_4fc87b72749b7($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<link href="<?php echo @MISC_ROOT;?>
css/setting-userinfo/setting_userinfo.css" type="text/css" rel="stylesheet" />
<body>

<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><img src="<?php echo get_avatar($_smarty_tpl->tpl_vars['user']->value['uid'],'s');?>
" alt="" /></a></span>
			<div class="userName" id="userName">
				<span class="nameTxt"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><?php echo $_smarty_tpl->tpl_vars['login_username']->value;?>
</a></span>
				<span class="nameTxt">
					<span class="fl">系统设置</span>
				</span>
				<div class="dropMenu">
					<div class="triggerBtn"><span class="fl">通知</span><s></s></div>
					<div class="dropList">
						<ul class="dropListul">
							<li><a href="<?php echo mk_url('main/setting/settingAccount');?>
" class="itemAnchor"><i class="i_account"></i><span>一般</span></a></li>
							<li><a href="<?php echo mk_url('main/setting/settingSecurity');?>
" class="itemAnchor"><i class="i_security"></i><span>安全</span></a></li>
							<li><a href="<?php echo mk_url('main/setting/settingWeb');?>
" class="itemAnchor"><i class="i_page"></i><span>网页设置</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="modlueBody">
			<!--start: headerArea 账户设置标题开始-->
        	<h2 class="accountTitle">系统设置  / 通知</h2>
        	<!--end: headerArea 账户设置标题结束-->
        	
        	<!--start: 通知提示设置 -->
        	<p class="noticeP">每当Duankou上有与您相关的更新时，我们会通知您。您可以设定在您使用哪些应用程序或功能时，我们需要通知您。<br />
				已发送通知到电子邮件：<strong><?php echo $_smarty_tpl->tpl_vars['login_email']->value;?>
</strong>。</p>
			<!--end: 通知提示设置 -->
			
			<!--start: 所有通知设置-->
			<div class="noticeBlock clearfix">
				<span class="noticelabel"><strong>所有通知</strong></span>
				<ul class="noticeItem" id="noticelist">
					 <?php  $_smarty_tpl->tpl_vars['ul'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ul']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ul']->key => $_smarty_tpl->tpl_vars['ul']->value){
$_smarty_tpl->tpl_vars['ul']->_loop = true;
?>
					<li>
						<div class="clearfix allNoticeList" name="<?php echo $_smarty_tpl->tpl_vars['ul']->value['value'];?>
">
							<span class="noticeItemLabel"><b class="<?php echo $_smarty_tpl->tpl_vars['ul']->value['value'];?>
 icon"></b><?php echo $_smarty_tpl->tpl_vars['ul']->value['title'];?>
</span>
							<span class="noticeItemNum"><b class="icon_ifoNum icon"></b><span><?php echo $_smarty_tpl->tpl_vars['ul']->value['count'];?>
</span></span>
							<span class="noticeItemEdit blue"><b class="icon_edit"></b>编辑</span>
						</div>
						<table class="noticeItemContent boxGray hideEle" cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td width="4%"><b class="<?php echo $_smarty_tpl->tpl_vars['ul']->value['value'];?>
 icon"></b></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['ul']->value['title'];?>
</td>
								<td><b class="icon_ifoNum"></b></td>
							</tr>
							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ul']->value['s_setting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
								<td><input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
' name="<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1){?>checked<?php }?> /></td>
							</tr>
							<?php } ?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><span class="save">保存更改</span><span class="cancel">取消</span></td>
								<td></td>
							</tr>
						</table>
					</li>
					<?php } ?>
					<?php  $_smarty_tpl->tpl_vars['ul'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ul']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['web_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ul']->key => $_smarty_tpl->tpl_vars['ul']->value){
$_smarty_tpl->tpl_vars['ul']->_loop = true;
?>
					<li>
						<div class="clearfix allNoticeList" name="<?php echo $_smarty_tpl->tpl_vars['ul']->value['value'];?>
">
							<span class="noticeItemLabel"><b class="<?php echo $_smarty_tpl->tpl_vars['ul']->value['value'];?>
 icon"></b><?php echo $_smarty_tpl->tpl_vars['ul']->value['title'];?>
</span>
							<span class="noticeItemNum"><b class="icon_ifoNum icon"></b><span><?php echo $_smarty_tpl->tpl_vars['ul']->value['count'];?>
</span></span>
							<span class="noticeItemEdit blue"><b class="icon_edit"></b>编辑</span>
						</div>
						<table class="noticeItemContent boxGray hideEle" cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td width="4%"><b class="<?php echo $_smarty_tpl->tpl_vars['ul']->value['value'];?>
 icon"></b></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['ul']->value['title'];?>
</td>
								<td><b class="icon_ifoNum"></b></td>
							</tr>
							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ul']->value['weblist0']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
								<td><input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
' name="<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1){?>checked<?php }?> /></td>
							</tr>
							<?php } ?>
							<tr>
								<td></td>
								<td class="hr" colspan="2"></td>
							</tr>
							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ul']->value['weblist1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
								<td><input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
' name="<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1){?>checked<?php }?> /></td>
							</tr>
							<?php } ?>
							<tr>
								<td></td>
								<td class="hr" colspan="2"><span></span></td>
							</tr>
							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ul']->value['weblist2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
								<td><input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
' name="<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1){?>checked<?php }?> /></td>
							</tr>
							<?php } ?>
							<tr>
								<td></td>
								<td class="hr" colspan="2"><span></span></td>
							</tr>
							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ul']->value['weblist3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
								<td><input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
' name="<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1){?>checked<?php }?> /></td>
							</tr>
							<?php } ?>
							<tr>
								<td></td>
								<td class="hr" colspan="2"><span></span></td>
							</tr>
							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ul']->value['weblist4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
								<td><input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
' name="<?php echo $_smarty_tpl->tpl_vars['value']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1){?>checked<?php }?> /></td>
							</tr>
							<?php } ?>
							<tr>
								<td width="4%"></td>
								<td width="87%"><span class="save">保存更改</span><span class="cancel">取消</span></td>
								<td></td>
							</tr>
						</table>
					</li>
					<?php } ?>
				</ul>
			</div>
			<!--end: 所有通知设置-->
		</div>
	</div>
	<div class="sideArea">
		
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/setting_userinfo/setting_userinfo.js" type="text/javascript"></script>
</body>
</html><?php }} ?>
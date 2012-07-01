<?php /* Smarty version Smarty-3.1.7, created on 2012-06-04 09:34:02
         compiled from "application/views/setting-userinfo/setting_account.html" */ ?>
<?php /*%%SmartyHeaderCode:14184224084fc84519610e44-56122148%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3389dfd402ff5be910ab729a2dd51f48560efcdf' => 
    array (
      0 => 'application/views/setting-userinfo/setting_account.html',
      1 => 1338773245,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14184224084fc84519610e44-56122148',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc84519721bf',
  'variables' => 
  array (
    'user' => 0,
    'login_name' => 0,
    'login_email' => 0,
    'login_lastupdatepwdtime' => 0,
    'select' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc84519721bf')) {function content_4fc84519721bf($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/setting-userinfo/setting_userinfo.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="body clearfix">
	<div class="mainArea">
		<!--start: 账户设置头部-->
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
					<div class="triggerBtn"><span class="fl">一般</span><s></s></div>
					<div class="dropList">
						<ul class="dropListul">
							<li><a href="<?php echo mk_url('main/setting/settingSecurity');?>
" class="itemAnchor"><i class="i_security"></i><span>安全</span></a></li>
							<li><a href="<?php echo mk_url('main/notice/settingnotice');?>
" class="itemAnchor"><i class="i_notice"></i><span>通知</span></a></li>
							<li><a href="<?php echo mk_url('main/setting/settingWeb');?>
" class="itemAnchor"><i class="i_page"></i><span>网页设置</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--end: 账户设置头部-->
		<div class="modlueBody">
			<!--star: headerArea 账户设置标题开始-->
            <h2 class="accountTitle">系统设置  / 一般</h2>
      		<!--end: headerArea 账户设置标题结束--> 
      		<!--start: contentArea 账户设置具体内容开始-->
      		<ul class="accountContent" id="accountEdit">
	            <li>
	            	<span class="accountSettingLabel"><strong>姓名</strong></span>
	            	<span class="accountSettingContent"><strong><?php echo $_smarty_tpl->tpl_vars['login_name']->value;?>
</strong></span>
	            	<span class="accountSettingEdit  blue"></span>
	            </li>
	            <li>
	            	<span class="accountSettingLabel"><strong>电子邮件</strong></span> 
	            	<span class="accountSettingContent">主要电邮：<strong><?php echo $_smarty_tpl->tpl_vars['login_email']->value;?>
</strong></span>
	            	<span class="accountSettingEdit  blue"></span> 
	            </li>
	            <li> 
	            	<div class="clearfix editItemPrw" id="pwItem">
	            		<span class="accountSettingLabel"><strong>密码</strong></span> 
	            		<span class="accountSettingContent"><?php if ($_smarty_tpl->tpl_vars['login_lastupdatepwdtime']->value){?><?php echo friendlyDate($_smarty_tpl->tpl_vars['login_lastupdatepwdtime']->value);?>
更新<?php }else{ ?>从未修改过密码<?php }?></span> 
	            		<span class="accountSettingEdit blue"><i class="icon_edit"></i>编辑</span> 
	            	</div>
	            	<!--Start 确认密保问题-->
	            	<div class="boxGray clearfix hideEle editContent" id="answerWrap">
	            		<div class="accountSettingLabel"><strong>密保问题</strong></div>
	            		<div class="accountSettingEditor">
	            			<p>在修改密码前请先回答一条保密问题</p>
	            			<ol>
	            				<li>
	            					<label>问题：</label>
	            					<select id="Question">
	            						<?php echo $_smarty_tpl->tpl_vars['select']->value;?>

	            					</select>
	            				</li>
	            				<li>
	            					<label>答案：</label>
	            					<input type="text" name="answer" id="answer" />
	            					<span class="errors" id="answerError"></span>
	            				</li>
	            			</ol>
	            			<div class="but">
	            				<span class="save" id="confirm_answer">确定</span>
	            				<span class="cancel">取消</span>
	            			</div>
	            		</div>
	            	</div>
	            	<!--End 确认密保问题-->
	            	<!--Start 修改密码-->
	            	<div class="boxGray clearfix hideEle" id="passwdWrap">
	            		<div class="accountSettingLabel"><strong>密码</strong></div>
	            		<div class="accountSettingEditor" id="pwdForm">
	            			<form action="<?php echo mk_url('main/setting/resetPasswd');?>
" name="pwdForm" method="post">
	            			<ol>
	            				<li>
	            					<label>目前有效：</label>
	            					<input type="password" name="pwd_old" value="" maxlength="20" onpaste="return false" />
	            					<span class="errors" id="pwd_old">密码错误</span>
	            				</li>
	            				<li>
	            					<label>新密码：</label>
	            					<input type="password" name="pwd_new" maxlength="20" onpaste="return false" />
	            					<span class="errors" id="pwd_new"></span>
	            				</li>
	            				<li>
	            					<label>确认新密码：</label>
	            					<input type="password" name="pwd_confirm" maxlength="20" onpaste="return false" />
	            					<span class="errors" id="pwd_confirm"></span>
	            				</li>
	            			</ol>
	            			<div class="but">
	            				<input type="hidden" name="change" value="ok" />
	            				<span class="save" id="save_pwd">确定</span>
	            				<span class="cancel">取消</span>
	            			</div>
	            			</form>
	            		</div>
	            	</div>
	            	<!--End 修改密码-->
	            </li>
	            <li> 
	            	<div class="clearfix editItem" id="languageItem">
	            		<span class="accountSettingLabel"><strong>语言</strong></span> 
	            		<span class="accountSettingContent"><strong>中文(简体)</strong></span> 
	            		<span class="accountSettingEdit blue"><i class="icon_edit"></i>编辑</span> 
	            	</div>
	            	<div class="boxGray clearfix hideEle editContent" id="lagForm">
	            		<div class="accountSettingLabel">语言</div>
	            		<div class="accountSettingEditor">
	            			<form action="" name="lagForm" method="post">
	            			<ol>
	            				<li>
	            					<label>选择主要语言：</label>
	            					<select>
	            						<option>中文(简体)</option>
	            					</select>
	            				</li>
	            			</ol>
	            			<div class="but">
	            				<span class="save" id="save_lag">确定</span>
	            				<span class="cancel">取消</span>
	            			</div>
	            			</form>
	            		</div>
	            	</div>
	            </li>
	        </ul>
         	<div class="mvm"><a>下载一份</a>你的Duankou资料</div>
         	<!--end: contentArea 账户设置具体内容结束--> 
		</div>
	</div>
	
	<div class="sideArea">
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/plug/md5/md5.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/setting_userinfo/setting_userinfo.js"></script>
</body>
</html><?php }} ?>
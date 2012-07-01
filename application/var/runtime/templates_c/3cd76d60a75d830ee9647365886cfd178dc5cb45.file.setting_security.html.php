<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 15:12:55
         compiled from "application/views/setting-userinfo/setting_security.html" */ ?>
<?php /*%%SmartyHeaderCode:11596804214fc86b77387286-04845164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3cd76d60a75d830ee9647365886cfd178dc5cb45' => 
    array (
      0 => 'application/views/setting-userinfo/setting_security.html',
      1 => 1337243452,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11596804214fc86b77387286-04845164',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'login_name' => 0,
    'select' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc86b7746cdd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc86b7746cdd')) {function content_4fc86b7746cdd($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
main/index.php"><?php echo $_smarty_tpl->tpl_vars['login_name']->value;?>
</a></span>
				<span class="nameTxt">
					<span class="fl">系统设置</span>
				</span>
				<div class="dropMenu">
					<div class="triggerBtn"><span class="fl">安全</span><s></s></div>
					<div class="dropList">
						<ul class="dropListul">
							<li><a href="<?php echo mk_url('main/setting/settingAccount');?>
" class="itemAnchor"><i class="i_account"></i><span>一般</span></a></li>
							<li><a href="<?php echo mk_url('main/notice/settingnotice');?>
" class="itemAnchor"><i class="i_notice"></i><span>通知</span></a></li>
							<li><a href="<?php echo mk_url('main/setting/settingWeb');?>
" class="itemAnchor"><i class="i_page"></i><span>网页设置</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="modlueBody">
			<!--star: headerArea 账户设置标题开始-->
            <h2 class="accountTitle">系统设置  / 安全</h2>
      		<!--end: headerArea 账户设置标题结束--> 
      		<!--start: contentArea 账户设置具体内容开始-->
      		<ul class="accountContent" id="accountEdit">
      			<li> 
	            	<div class="clearfix editItemSect" id="sectItem">
	            		<span class="accountSettingLabel"><strong>密保问题</strong></span> 
	            		<span class="accountSettingContent">设置密保问题，将帮助我们识别你的身份</span> 
	            		<span class="accountSettingEdit blue" id="pwEdit"><i class="icon_edit"></i>编辑</span> 
	            	</div>
	            	<div class="boxGray clearfix hideEle editContent" id="securityForm">
	            		<div class="accountSettingLabel"><strong>密保问题</strong></div>
	            		<div class="accountSettingEditor">
	            			<form action="<?php echo mk_url('main/setting/setSecurity');?>
" name="securityForm" method="post">
	            			<p>在修改密码前请先回答一条保密问题</p>
	            			<ol>
	            				<li>
	            					<label>问题：</label>
	            					<select id="chooseQuestion" name='question'>
	            						<?php echo $_smarty_tpl->tpl_vars['select']->value;?>

	            					</select>
	            				</li>
	            				<li class="ans">
	            					<label>答案：</label>
	            					<input type="text" name="answer" id="answerInput" maxlength="50" />
	            					<span class="errors" id="answerError">答案不能为空</span>
	            				</li>
	            				<li class="hide">
	            					<label>原始答案：</label>
	            					<input type="text" name="oldanswer" id="oldAnswer" maxlength="50" />
	            					<span class="errors" id="oldAnswerError">答案不能为空/答案错误</span>
	            				</li>
	            				<li class="hide">
	            					<label>新答案：</label>
	            					<input type="text" name="newanswer" id="newAnswer" maxlength="50" />
	            					<span class="errors" id="newAnswerError">答案不能为空</span>
	            				</li>
	            			</ol>
	            			<div class="but">
	            				<span class="save" id="save_security">确定</span>
	            				<span class="cancel">取消</span>
	            			</div>
	            			</form>
	            		</div>
	            	</div>
	           	</li>
      		</ul>
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
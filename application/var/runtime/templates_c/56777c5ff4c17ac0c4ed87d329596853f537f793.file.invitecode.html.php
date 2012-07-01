<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 10:32:14
         compiled from "application/views/invitecode/invitecode.html" */ ?>
<?php /*%%SmartyHeaderCode:11912887994fc84a03c86e89-36164029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56777c5ff4c17ac0c4ed87d329596853f537f793' => 
    array (
      0 => 'application/views/invitecode/invitecode.html',
      1 => 1338602563,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11912887994fc84a03c86e89-36164029',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc84a03e4cb9',
  'variables' => 
  array (
    'user_info' => 0,
    'invitecode_url' => 0,
    'dkcode_nums' => 0,
    'recmded_info' => 0,
    'strdata' => 0,
    'recmd_lists' => 0,
    'pagecount' => 0,
    'uid' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc84a03e4cb9')) {function content_4fc84a03e4cb9($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/invitecode/invitecode.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<?php if ($_smarty_tpl->tpl_vars['user_info']->value){?>
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['user_info']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['user_info']->value['avatar_img'];?>
" alt="" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['user_info']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['user_info']->value['username'];?>
</a></span>
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['invitecode_url']->value;?>
">邀请码</a></span>
			</div>
			<?php }?>
		</div>
		<div class="modlueBody" style=" padding-top:0px;">
			<div class="clearfix hasRightCol home" id="contentCol">
	          <!-- start:邀请码 -->
	          <div id="codeContent">
	            <div class="codeBlock">
	            	 <h3>发送邀请码<p class="fr">剩余邀请码数量: <span id="code_surplus"><?php echo $_smarty_tpl->tpl_vars['dkcode_nums']->value;?>
</span></p></h3>
	             <form name="code_form">
				  <div class="codeBlock_form">
	                <p>
	                  <label for="codeName">被邀请人姓名：</label><input id="friend_name" value="" type="text" class="friendName" name="userName" maxlength="10" maxlength="2">
					  <span class="errMsg_name"><span class="c-tipmsg">请输入被邀请人姓名</span></span>
	                </p>
	                <p>
	                  <label for="userMobile">被邀请人手机号：</label><input type="text" class="userMobile" value="" name="userMobile"  maxlength="11">
					  <span class="errMsg_mobile"><span class="c-tipmsg">请输入被邀请人手机号码</span></span>
	                </p>
	                <p class="Depressed"><span class="uiButton uiButtonConfirm"><b class="Send"  id="condSend">发送</b></span></p>
	              </div>
				  </form>
	            </div>
	            <div class="codeBlock clearfix">
	              <h3>提供邀请码给我的人</h3>
	              <ul class="codeBlock_photo clearfix">
				  <?php if ($_smarty_tpl->tpl_vars['recmded_info']->value){?>
					  <?php  $_smarty_tpl->tpl_vars['strdata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['strdata']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recmded_info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['strdata']->key => $_smarty_tpl->tpl_vars['strdata']->value){
$_smarty_tpl->tpl_vars['strdata']->_loop = true;
?>
					  <li class="item" uid="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['uid'];?>
">
						  <p class="photo"><a href="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['url'];?>
"><img alt="头像" src="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['avatar_img'];?>
" /></a></p>
						<span class="userinfo">
						    <p class="name"><a href="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['username'];?>
"><?php echo $_smarty_tpl->tpl_vars['strdata']->value['username'];?>
</a></p>
							<div class="statusBox" rel="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['is_follow'];?>
" uid="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['uid'];?>
"></div>
						  </span>
					  </li>
					  <?php } ?>
				  <?php }?>
	              </ul>
	            <div class="codeBlock clearfix">
	              <h3>我邀请成功的人</h3>
	              <ul class="codeBlock_photo clearfix" id="item_box">
				  <?php if ($_smarty_tpl->tpl_vars['recmd_lists']->value){?>
					  <?php  $_smarty_tpl->tpl_vars['strdata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['strdata']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recmd_lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['strdata']->key => $_smarty_tpl->tpl_vars['strdata']->value){
$_smarty_tpl->tpl_vars['strdata']->_loop = true;
?>
					  <li class="item" uid="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['uid'];?>
">
					   <p class="photo"><a href="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['url'];?>
"><img alt="头像" src="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['avatar_img'];?>
" /></a></p>
						<span class="userinfo">
						   <p class="name"><a href="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['username'];?>
"><?php echo $_smarty_tpl->tpl_vars['strdata']->value['username'];?>
</a></p>
							<div class="statusBox" rel="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['is_follow'];?>
" uid="<?php echo $_smarty_tpl->tpl_vars['strdata']->value['uid'];?>
"></div>
						  </span>
					  </li>
					<?php } ?>
				  <?php }?>
	              </ul>
				  <?php if ($_smarty_tpl->tpl_vars['pagecount']->value>1){?>
				  <div class="codeBottom"><a id="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" pagecount="<?php echo $_smarty_tpl->tpl_vars['pagecount']->value;?>
" href="javascript:void(0)">点击查看更多↓</a></div>
				  <?php }?>
	            </div>
	          </div>
	          <!-- end:邀请码 --> 
       		 </div>
		</div>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/plug/relation/relation.js"></script>
<script src="<?php echo @MISC_ROOT;?>
js/common/validator.js"  type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/invitecode/invitecode.js"  type="text/javascript"></script>
<script type="text/javascript">
	window.onload=function(){
			document.code_form.reset();
		}
</script>
</body>
</html>

<?php }} ?>
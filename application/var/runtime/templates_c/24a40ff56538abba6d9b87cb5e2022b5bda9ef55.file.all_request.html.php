<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:16:14
         compiled from "application/views/request/all_request.html" */ ?>
<?php /*%%SmartyHeaderCode:20083259744fc8501e9744f8-93550475%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24a40ff56538abba6d9b87cb5e2022b5bda9ef55' => 
    array (
      0 => 'application/views/request/all_request.html',
      1 => 1336034224,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20083259744fc8501e9744f8-93550475',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'avatar' => 0,
    'user' => 0,
    'friend_lists' => 0,
    'fl' => 0,
    'more' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc8501eaa72e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc8501eaa72e')) {function content_4fc8501eaa72e($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/message/request_notice.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><img src="<?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
" alt="" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</a></span>
				<span class="nameTxt">请求</span>
			</div>
		</div>
		<div class="modlueBody">
			<!--start: 请求列表box -->
			<div id="inviteContent">
				<h3 class="modlueBodyTitle"><i></i>请求</h3>
				<!--start: 请求 -->
	            <div class="invite">
	              <ul id="inviteList" class="invite_list">
	              
		          </ul>
	            </div>
				<!--end: 请求 -->
				<!--start: 可能认识的人 -->
	            <div class="mayKnow">
	              <h3>可能认识的人</h3>
	              <ul class="mayKnow_list">
	                <?php if ($_smarty_tpl->tpl_vars['friend_lists']->value){?>
					<?php  $_smarty_tpl->tpl_vars['fl'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['fl']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['friend_lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['fl']->key => $_smarty_tpl->tpl_vars['fl']->value){
$_smarty_tpl->tpl_vars['fl']->_loop = true;
?>
						<li rid="<?php echo $_smarty_tpl->tpl_vars['fl']->value['uid'];?>
" class="clearfix">
						  <span class="picHead"><a href="<?php echo @WEB_ROOT;?>
main/index.php?c=index&m=index&action_dkcode=<?php echo $_smarty_tpl->tpl_vars['fl']->value['dkcode'];?>
"><img alt="头像" src="<?php echo $_smarty_tpl->tpl_vars['fl']->value['avatarurl'];?>
"></a></span>
						  <span class="friendInfo"><a href="<?php echo @WEB_ROOT;?>
main/index.php?c=index&m=index&action_dkcode=<?php echo $_smarty_tpl->tpl_vars['fl']->value['dkcode'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['fl']->value['name'];?>
</strong></a><br><?php echo $_smarty_tpl->tpl_vars['fl']->value['sum'];?>
</span>
						  <span class="addView"><span class="btnBlue" name="reqAdd"><i></i><a href="javascript:void(0);">加关注</a></span></span>
						</li>
					<?php } ?>
					<?php }else{ ?>
						<li>暂无可能认识人列表</li>
					<?php }?>
	              </ul>
	              <?php if ($_smarty_tpl->tpl_vars['more']->value==1){?>
	              <div class="mayBottom"><a pid="2" href="javascript:void(0);">点击重换一组</a></div>
	              <?php }?>
	            </div>
				<!--end: 可能认识的人 -->
          </div>
		  <!--end: 请求列表box -->
		</div>
	</div>
	<div class="sideArea">
		广告区域
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/timeline/scrollLoad.js" type="text/javascript" ></script>
</body>
</html><?php }} ?>
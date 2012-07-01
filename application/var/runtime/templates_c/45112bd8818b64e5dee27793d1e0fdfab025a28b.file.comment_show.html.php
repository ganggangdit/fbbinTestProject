<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:56:26
         compiled from "application/views/timeline/comment_show.html" */ ?>
<?php /*%%SmartyHeaderCode:9579370644fc8598ace7492-73148845%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45112bd8818b64e5dee27793d1e0fdfab025a28b' => 
    array (
      0 => 'application/views/timeline/comment_show.html',
      1 => 1338365992,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9579370644fc8598ace7492-73148845',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login_info' => 0,
    'params' => 0,
    'fdfsinfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc8598adfee0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc8598adfee0')) {function content_4fc8598adfee0($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="http://dev.duankou.com/misc/css/plug-css/tip/jquery.tip.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/comment-easy/comment_easy.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/message/request_notice.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/timeline/info.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix">
	<div class="mainArea" id="comment_show">
		<div class="modlueBody">
			 <!-- start 信息评论详情 -->
			<div id="getInfo_box" class="clearfix" >
                    <ul class="content"></ul>
		    </div>
		  <!-- end 信息评论详情 -->
		</div>
	</div>
	<div class="sideArea">
		
	</div>
</div>
<input type='hidden' id='hd_UID' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['uid'];?>
" />
<input type='hidden' id='hd_userName' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['username'];?>
" />
<input type='hidden' id='hd_avatar' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['avatar_url'];?>
" />
<input type='hidden' id='hd_userPageUrl' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['url'];?>
" />
<input type='hidden' id='params' tid="<?php echo $_smarty_tpl->tpl_vars['params']->value['tid'];?>
" from="<?php echo $_smarty_tpl->tpl_vars['params']->value['from'];?>
" webId="<?php echo $_smarty_tpl->tpl_vars['params']->value['webId'];?>
" />
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
	var fdfsHost = "http://<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['host'];?>
";
	var fdfsGroup = "<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['group'];?>
";
</script>
<script src="http://dev.duankou.com/misc/js/plug/dk-tip/dk.tip.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/oneInfo.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/comment-easy/commentEasy.js" type="text/javascript"></script>
<script src="http://dev.duankou.com/misc/js/plug/player/AC_RunActiveContent.js" type="text/javascript" ></script>
</body>
</html><?php }} ?>
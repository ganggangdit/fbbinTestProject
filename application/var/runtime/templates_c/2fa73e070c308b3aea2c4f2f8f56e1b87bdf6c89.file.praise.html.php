<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 13:55:41
         compiled from "application/views/praise/praise.html" */ ?>
<?php /*%%SmartyHeaderCode:9321501954fc8542f7174a5-21284943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2fa73e070c308b3aea2c4f2f8f56e1b87bdf6c89' => 
    array (
      0 => 'application/views/praise/praise.html',
      1 => 1338616202,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9321501954fc8542f7174a5-21284943',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc8542f89386',
  'variables' => 
  array (
    'action_index_url' => 0,
    'avatar_url' => 0,
    'action_user_name' => 0,
    'praise_index_url' => 0,
    'isself' => 0,
    'login_info' => 0,
    'video_src_domain' => 0,
    'video_pic_domain' => 0,
    'fdfsinfo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc8542f89386')) {function content_4fc8542f89386($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."main/application/views/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/plug-css/comment-easy/comment_easy.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/praise/praise.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/timeline/info.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/tip/jquery.tip.css" type="text/css" rel="stylesheet" />
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."main/application/views/top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix" id="praiseFramwork">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['action_index_url']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['avatar_url']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['action_user_name']->value;?>
" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['action_index_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['action_user_name']->value;?>
</a></span>
				<span class="nameTxt"><span class="fl"><a class="black" href="<?php echo $_smarty_tpl->tpl_vars['praise_index_url']->value;?>
">赞</a></span></span>
			</div>
		</div>
		<div class="modlueMainBody">
			<div id="yearList" class="praiseList clearfix">
				
			</div>
			<ul id="praiseList" class="praiseList mt10 clearfix">
				<li type="1" class="on">别人赞了<?php echo $_smarty_tpl->tpl_vars['isself']->value;?>
的</li>
				<li type="2"><?php echo $_smarty_tpl->tpl_vars['isself']->value;?>
赞了个人的</li>
				<li type="3"><?php echo $_smarty_tpl->tpl_vars['isself']->value;?>
赞了网页的</li>
			</ul>
			<div id="timelineContent">
				<ol id="timelineTree" class="timelineTree clearfix">
					<div class="timelinebody">
						
					</div>
					<li id="defaultTimeBox2" name="timeBox" class="twoColumn clearfix defaultTimeBox" timeArea="">
			            <i class="spinePointer"></i>
						<div class="timelineBox" style="padding:20px;">
			            	<div class="lifeContent"><div class="lifeHeader"><a id="scrollToTop"><i class="lifeIcon_4"></i><div class="toTopText">返回顶部</div></a></div></div>
			            </div>
					</li>
				</ol>
			</div>

		</div>
		
	</div>
</div>
<!—隐藏域：-->
<input type='hidden' id='hd_UID' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['uid'];?>
" />
<input type='hidden' id='hd_userName' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['username'];?>
" />
<input type='hidden' id='hd_avatar' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['avatar_url'];?>
" />
<input type='hidden' id='hd_userPageUrl' value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['url'];?>
" />
<?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."main/application/views/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/plug/comment-easy/commentEasy.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-tip/dk.tip.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/embed-for-flash/swfobject.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/album/picViewer.js"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/flowLayout.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/scrollLoad.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/praise/praise.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/player/AC_RunActiveContent.js" type="text/javascript" ></script>
<script type="text/javascript">
//视频,视频图片url地址 by wangying 2012.6.1
function mk_videoUrl(vpath){
	var host = "<?php echo $_smarty_tpl->tpl_vars['video_src_domain']->value;?>
";
	if (vpath.indexOf(":/")<0){
		return host+vpath;
	}else{
		return vpath;
	}
}
function mk_videoImgUrl(vpath){
	var host = "<?php echo $_smarty_tpl->tpl_vars['video_pic_domain']->value;?>
";
	if (vpath.indexOf(":/")<0){
		return host+vpath;
	}else{
		return vpath;
	}
}
</script>
<script type="text/javascript">
	var fdfsHost = "<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['host'];?>
";
	var fdfsGroup = "<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['group'];?>
";
</script>

</body>
</html><?php }} ?>
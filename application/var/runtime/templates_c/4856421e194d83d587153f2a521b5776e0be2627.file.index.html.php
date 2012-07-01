<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 13:52:41
         compiled from "application/views/following/index.html" */ ?>
<?php /*%%SmartyHeaderCode:19832660864fc83be7e5ac28-37274050%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4856421e194d83d587153f2a521b5776e0be2627' => 
    array (
      0 => 'application/views/following/index.html',
      1 => 1338616327,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19832660864fc83be7e5ac28-37274050',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83be808789',
  'variables' => 
  array (
    'userinfo' => 0,
    'is_self' => 0,
    'login_info' => 0,
    'action_uid' => 0,
    'fdfsinfo' => 0,
    'video_src_domain' => 0,
    'video_pic_domain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83be808789')) {function content_4fc83be808789($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/follow/follow.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/timeline/info.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/tip/jquery.tip.css" type="text/css" rel="stylesheet" />
<link media="screen,projection" type="text/css" rel="stylesheet" href="<?php echo @MISC_ROOT;?>
css/plug-css/comment-easy/comment_easy.css">
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix" id="followerFramework">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['avatar'];?>
" alt="" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['username'];?>
</a></span>
				<span class="nameTxt"><a>关注</a></span>
			</div>
		</div>
		
		<div class="modlueMainBody">
			<div id="navWrapper"></div>
	
			<div class="timeLineTopAvatar">
				<ul id="topAvatar" class="topAvatarClose clearfix">
				</ul>
			</div>
            <?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
			<!-- <div class="timeLineTopAvatar">
				<h3>您可能认识的人</h3>	
				<ul id="mayknowAvatar" class="topAvatarClose clearfix">
				</ul>
			</div>
			<div class="timeLineTopAvatar hide">
				<h3>您可能感兴趣的网页</h3>	
				<ul id="mayknowWeb" class="topAvatarClose clearfix">
				</ul>
			</div> -->
			<div id="timelineContent">
				<div id="moredata" ctime="<?php echo @SYS_TIME;?>
" ltime="<?php echo @SYS_TIME;?>
"><a href="javascript:void(0)">有<span id="timecount">0</span>条新广播，点击查看</a></div>
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
			<?php }?>
		</div>
		
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
<input type="hidden" id="action_uid" value="<?php echo $_smarty_tpl->tpl_vars['action_uid']->value;?>
" />
<script type="text/javascript">
	var fdfsHost = "<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['host'];?>
";
	var fdfsGroup = "<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['group'];?>
";
</script>

<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/plug/comment-easy/commentEasy.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-tip/dk.tip.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/embed-for-flash/swfobject.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/album/picViewer.js"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/scrollLoad.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/flowLayout.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/follow/follownav.js" type="text/javascript"></script>
<script src="http://web.duankou.com/misc/js/plug/player/AC_RunActiveContent.js"  type="text/javascript"></script>
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

</body>
</html><?php }} ?>
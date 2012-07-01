<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 13:57:00
         compiled from "application/views/friend/index.html" */ ?>
<?php /*%%SmartyHeaderCode:6741048734fc84e11e58b67-85757322%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a6dea1bb27f567cf77f430a9fec209e9c157efe' => 
    array (
      0 => 'application/views/friend/index.html',
      1 => 1338616290,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6741048734fc84e11e58b67-85757322',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc84e1213b4f',
  'variables' => 
  array (
    'login_info' => 0,
    'home_info' => 0,
    'action_uid' => 0,
    'video_src_domain' => 0,
    'video_pic_domain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc84e1213b4f')) {function content_4fc84e1213b4f($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/follow/follow.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/comment-easy/comment_easy.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/timeline/info.css" type="text/css" rel="stylesheet" />

<link href="<?php echo @MISC_ROOT;?>
css/plug-css/tip/jquery.tip.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/JQuery-uploadify/JQuery_uploadify.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/calendar/dk_calendar.css" type="text/css" rel="stylesheet" />
<?php if (($_smarty_tpl->tpl_vars['login_info']->value['is_self']=='ture')){?>
<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix" id="friendFramwork">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['src'];?>
" alt="" /></a></span>
			<div class="userName">

				<span id="dk_code" dk="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['dk_code'];?>
" class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['home_info']->value['username'];?>
</a></span>
				<span class="nameTxt"><span class="fl"><a href="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['self_url'];?>
">好友</a></span><s></s></span>
			</div>
		</div>
            
		<div class="modlueMainBody">
			
			<div id="headerWrapper" class="timeLineTopAvatar">
			</div>
            <div id="timelineContent">
            	<div id="moredata" ctime="<?php echo @SYS_TIME;?>
" ltime="<?php echo @SYS_TIME;?>
"><a href="javascript:void(0)">有<span id="timecount">0</span>条新广播，点击查看</a></div>
				<ol id="timelineTree" class="timelineTree clearfix">
					<div class="timelinebody">
						<li id="defaultTimeBox1" name="timeBox" class="sideLeft clearfix defaultTimeBox" timeArea=""> <i class="spinePointer"></i>
							<div class="timelineBox"><?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."timeline/postBox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div>
						</li>
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
	var fdfsHost = "<?php echo $_smarty_tpl->tpl_vars['login_info']->value['host'];?>
";
	var fdfsGroup = "<?php echo $_smarty_tpl->tpl_vars['login_info']->value['group'];?>
";
</script>
<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/plug/comment-easy/commentEasy.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-textArea/jquery.textarea.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/embed-for-flash/swfobject.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/calendar/dk_calendar.js"  type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-tip/dk.tip.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/scrollLoad.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/album/picViewer.js"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/flowLayout.js" type="text/javascript"></script>

<script src="<?php echo @MISC_ROOT;?>
js/timeline/postBox.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-textarea-msgtip/jQuery-textarea-msgtip.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/friend/friend_headlist.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/embed-for-flash/swfobject.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/calendar/dk_calendar.js" type="text/javascript" ></script>
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
<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

	$(function(){

		window.location.href = webpath+'main/index.php?c=friend&m=friendlist&action_dkcode='+action_dkcode;
	});
</script>
<?php }?><?php }} ?>
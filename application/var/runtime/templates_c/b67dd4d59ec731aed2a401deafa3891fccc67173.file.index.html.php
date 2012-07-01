<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 13:51:03
         compiled from "application/views/timeline/index.html" */ ?>
<?php /*%%SmartyHeaderCode:18129048884fc83b7de74448-23388134%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b67dd4d59ec731aed2a401deafa3891fccc67173' => 
    array (
      0 => 'application/views/timeline/index.html',
      1 => 1338616202,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18129048884fc83b7de74448-23388134',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83b7e181ea',
  'variables' => 
  array (
    'action_uid' => 0,
    'action_avatar' => 0,
    'login_info' => 0,
    'action_dkcode' => 0,
    'user' => 0,
    'is_self' => 0,
    'fdfsinfo' => 0,
    'video_src_domain' => 0,
    'video_pic_domain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83b7e181ea')) {function content_4fc83b7e181ea($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/mainArea/mainArea_top.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/comment-easy/comment_easy.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/timeline/info.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/tip/jquery.tip.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/calendar/dk_calendar.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/JQuery-uploadify/JQuery_uploadify.css" type="text/css" rel="stylesheet"/>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix" id="timelienIndex">
	<input type="hidden" id="action_dkcode" value="<?php echo $_smarty_tpl->tpl_vars['action_uid']->value;?>
" />
	<input type="hidden" id="action_avatar" value="<?php echo $_smarty_tpl->tpl_vars['action_avatar']->value;?>
" />
	<input type="hidden" id="userid" value="<?php if (isset($_smarty_tpl->tpl_vars['login_info']->value['uid'])){?><?php echo $_smarty_tpl->tpl_vars['login_info']->value['uid'];?>
<?php }?>" />
	<input type="hidden" id="ac_dkcode" value="<?php if (isset($_smarty_tpl->tpl_vars['action_dkcode']->value)){?><?php echo $_smarty_tpl->tpl_vars['action_dkcode']->value;?>
<?php }?>" />
	
	<div class="mainArea">
		<div id="modlueHeader" class="modlueHeader clearfix">
			<span class="userImg"><a href="#"><img alt="" src="<?php echo get_avatar($_smarty_tpl->tpl_vars['user']->value['uid'],'ss');?>
"></a></span>
			<div class="userName" id="userName">
				<span class="nameTxt"><a href="#"><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</a></span>
				
				<div class="dropMenu" id="timelineSelect" style="display:none"></div>
				<div class="dropMenu" id="hotMonth" style="display:none" complete="false"></div>
			</div>
            <?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
            <div id="TopPostArea" class="userActions">
                <ul class="composerAttachments">
                    <li ref="0" class="s_msg act"><span><i class="uiIconP icons3 bp_currentState"></i>状态</span></li>
                    <li ref="1" class="s_photo"><span><i class="uiIconP icons1 bp_photo"></i>照片</span></li>
                    <li ref="2" class="s_video"><span><i class="uiIconP icons1 bp_video"></i>视频</span></li>
                    <!--<li ref="3" class="s_life hide"><span><i class="uiIconP icons1 bp_life"></i>人生记事</span></li>-->
                </ul>
                <div class="pointUp hide"></div>
                <div class="TopPostBox hide">
                </div>
            </div>
            <?php }?>
		</div>
		<div class="modlueMainBody"><?php echo $_smarty_tpl->getSubTemplate ("timeline/mainArea_top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("timeline/info.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div>
		<div id="sideArea">
		<ul class="timelineBar"></ul>
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

<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
	var fdfsHost = "http://<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['host'];?>
";
	var fdfsGroup = "<?php echo $_smarty_tpl->tpl_vars['fdfsinfo']->value['group'];?>
";
</script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-tip/dk.tip.js" type="text/javascript"></script>

<script src="<?php echo @MISC_ROOT;?>
js/plug/drag/drag.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-ui/dk.uploader.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/timeline.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/mainArea/mainArea_top.js" type="text/javascript"></script>

<!--start: 时间线头部模块排序 by李世君 2012-3-24-->
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-dragsort/jquery.dragsort.min.js"></script>
<script src="<?php echo @MISC_ROOT;?>
js/mainArea/mainArea_top_move.js" type="text/javascript"></script>
<!--End: 时间线头部模块排序-->
<script src="<?php echo @MISC_ROOT;?>
js/album/picViewer.js"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/postBox.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/timeline/info.js" type="text/javascript"></script>

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
<script src="<?php echo @MISC_ROOT;?>
js/plug/embed-for-flash/swfobject.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-ui/dk.UICombox.js" type="text/javascript"></script> 
<!--<script src="&lt;!&ndash;{$smarty.const.MISC_ROOT}&ndash;&gt;js/plug/jQuery-textArea/jquery.textarea.js" type="text/javascript"></script>-->
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-textarea-msgtip/jQuery-textarea-msgtip.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/comment-easy/commentEasy.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/calendar/dk_calendar.js" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-searcher/ViolenceSearch.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/friends_list/friends_list.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/mousewheel/jquery.mousewheel.js" type="text/javascript"></script>

<script src="<?php echo @MISC_ROOT;?>
js/plug/friends_list/friends_list.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/relation/relation.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	//添加关注好友关系
	var relationWrap = $('#relationWrap');
	if(relationWrap[0]) {
		relationWrap.find('div.statusBox').relation({index:true});
	}
});
</script>

<!--Flash swf文件先是处理-->
<script src="<?php echo @MISC_ROOT;?>
js/plug/swfobject/swfobject.js" type="text/javascript"></script>
</body>
</html><?php }} ?>
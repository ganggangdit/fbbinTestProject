<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 11:48:14
         compiled from "application/views/timeline/info.html" */ ?>
<?php /*%%SmartyHeaderCode:3233341764fc83b7e76d482-18041635%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '582b19f532b5fc4068b5dd0175a87f67059434de' => 
    array (
      0 => 'application/views/timeline/info.html',
      1 => 1337069626,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3233341764fc83b7e76d482-18041635',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_self' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83b7e78ad8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83b7e78ad8')) {function content_4fc83b7e78ad8($_smarty_tpl) {?><div id="timelineContent">
	<ol id="timelineTree" class="timelineTree clearfix">
		<div class="timelinebody">
		 <?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>

		
		
			<li id="defaultTimeBox1" name="timeBox" class="sideLeft clearfix defaultTimeBox" timeArea="">
	           
	            <i class="spinePointer"></i>
				<div class="timelineBox">
	                <?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."timeline/postBox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	            </div>
	          
			</li>
		
		<!--

		<li class="sideRight">
			<div class="timelineBox">
				<div class="editControl hide" style="display: none;"><span class="conWrap midLine"><a title="调整大小"><i class="conResize"></i></a></span><span class="conWrap"><a title="编辑或删除"><i class="conEdit"></i></a>
					<ul class="uiMenuInner hide">
						<li><i></i>删除帖子</li>
						<li><i></i>改换日期</li>
					</ul>
					</span>
				</div>
				
				<div class="infoContent">特殊模块<br />
					<br />
					<br />
					<br />
				</div>
			</div>
		</li>
		-->
		 <?php }?>
		 </div>
		 <li id="defaultTimeBox2" name="timeBox" class="twoColumn clearfix defaultTimeBox" timeArea="">
           
            <i class="spinePointer"></i>
			<div class="timelineBox" style="padding:20px;">
            	<div class="lifeContent"><div class="lifeHeader"><a id="scrollToTop"><i class="lifeIcon_4"></i><div class="toTopText">返回顶部</div></a></div></div>
            </div>
          
		</li>

		<li id ="addNewAction" class="clearfix"> <i class="spinePointer"></i>
			<div class="flyoutComposer">
				<div id="distributeInfoBody">
					<div class="showWhenLoading"></div>
					<ul class="composerAttachments clearfix">
						<li class="s_msg act" ref="0"><span><i class="uiIconP icons3 bp_currentState"></i>状态</span></li>
						<li class="s_photo" ref="1"><span><i class="uiIconP icons1 bp_photo"></i>照片</span></li>
						<li class="s_video" ref="2"><span><i class="uiIconP icons1 bp_video"></i>视频</span></li>
						<!--<li class="s_life" ref="3"><span><i class="uiIconP icons1 bp_life"></i>人生记事</span></li>-->
					</ul>
				</div>
			</div>
		</li>
		<span id="timelineCursor"></span>
	</ol>
	<div id="timeline_recent_more"></div>
</div>
<?php }} ?>
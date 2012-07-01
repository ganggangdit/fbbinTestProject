<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:48:48
         compiled from "application/views/notice/all_notice.html" */ ?>
<?php /*%%SmartyHeaderCode:17762708214fc857c036b538-40974530%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d6a13642449d0b922e1192c6178905ac80d409f' => 
    array (
      0 => 'application/views/notice/all_notice.html',
      1 => 1336034224,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17762708214fc857c036b538-40974530',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'type' => 0,
    'mrel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc857c045f45',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc857c045f45')) {function content_4fc857c045f45($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/message/request_notice.css" rel="stylesheet" type="text/css" />

</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><img src="<?php echo get_avatar($_smarty_tpl->tpl_vars['user']->value['uid'],'s');?>
" alt="" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</a></span>
				<div id="noticeDrop" class="dropMenu">
					<div class="triggerBtn"><span class="fl">所有通知</span><s></s></div>
					<div class="dropList">
						<ul class="dropListul checkedUl">
							<li class="current"><a  rel="0"  class="itemAnchor  select_event" href="javascript:void(0);"><i></i><span>所有通知</span></a></li>
							<li><a rel="1" class="itemAnchor select_event" href="javascript:void(0);"><i></i><span>个人首页的通知</span></a></li>
							<?php  $_smarty_tpl->tpl_vars['mrel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mrel']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mrel']->key => $_smarty_tpl->tpl_vars['mrel']->value){
$_smarty_tpl->tpl_vars['mrel']->_loop = true;
?>
							<li><a rel="<?php echo $_smarty_tpl->tpl_vars['mrel']->value['aid'];?>
" class="itemAnchor select_event" href="javascript:void(0);" title="<?php echo $_smarty_tpl->tpl_vars['mrel']->value['name'];?>
"><i></i><span><?php echo $_smarty_tpl->tpl_vars['mrel']->value['name1'];?>
</span></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
		<div class="modlueBody">
			 <!-- start 通知列表区域 -->
			<h3 class="modlueBodyTitle"><i></i>通知</h3>
		<div id="noticeContent">
				<div id="noticeContent-box">
					
	            </div>
         </div>
		  <!-- end 通知列表区域 -->
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
<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 11:50:32
         compiled from "application/views/follower/list.html" */ ?>
<?php /*%%SmartyHeaderCode:20719416494fc83c08849b34-76096172%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c68a3657d58f56224cf9baedab755e36a23b9c2b' => 
    array (
      0 => 'application/views/follower/list.html',
      1 => 1336038254,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20719416494fc83c08849b34-76096172',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'home_info' => 0,
    'followerlist' => 0,
    'flist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83c089cb5d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83c089cb5d')) {function content_4fc83c089cb5d($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<link href="<?php echo @MISC_ROOT;?>
css/follow/follow.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['src'];?>
" alt="" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['home_info']->value['username'];?>
</a></span>
				<span class="nameTxt"><span class="fl"><a href="<?php echo $_smarty_tpl->tpl_vars['home_info']->value['self_url'];?>
">粉丝列表</a></span></span>

			</div>
		</div>
		<div class="modlueBody">
			<div class="listSearch clearfix">
                                <?php if (($_smarty_tpl->tpl_vars['home_info']->value['NumOfFollowers']>0)){?>
                                    <h4>粉丝 (<?php echo $_smarty_tpl->tpl_vars['home_info']->value['NumOfFollowers'];?>
)</h4>
                                <?php }?>    
                                <?php if (($_smarty_tpl->tpl_vars['home_info']->value['is_self']=='ture')){?>
                                    <input type="text" value="请输入姓名" class="fieldWithText" ref="请输入姓名" id="searchList" /><span class="btnGray"><s></s></span>
                                <?php }?>
			</div>
			<ul class="listWrap clearfix" id="listWrap">
                            <?php  $_smarty_tpl->tpl_vars['flist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['flist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['followerlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['flist']->key => $_smarty_tpl->tpl_vars['flist']->value){
$_smarty_tpl->tpl_vars['flist']->_loop = true;
?>
				<li>
					<div class="avatarBox">
						<a href="<?php echo $_smarty_tpl->tpl_vars['flist']->value['href'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['flist']->value['src'];?>
" alt="" /></a>
					</div>
					<span class="uName">
						<a href="<?php echo $_smarty_tpl->tpl_vars['flist']->value['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['flist']->value['name'];?>
</a>
					</span>
				</li>
                            <?php } ?>    
			</ul>
                        <?php if ($_smarty_tpl->tpl_vars['home_info']->value['NumOfFollowers']>27){?> 
                            <div class="loadmore hide" id="loadmore"><a></a></div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['home_info']->value['NumOfFollowers']<1&&$_smarty_tpl->tpl_vars['home_info']->value['is_self']==true){?> 
                            <div class="blankWrap" id="nodata"><span>您还没有粉丝</span></div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['home_info']->value['NumOfFollowers']<1&&$_smarty_tpl->tpl_vars['home_info']->value['is_self']==false){?> 
                             <div class="blankWrap" id="nodata"><span>该用户还没有粉丝</span></div>
                        <?php }?>
			<div class="blankWrap hide" id="noresult"><span>未检索到任何结果，请重新输入关键字</span></div>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
$(function() {
	list.init({moreUrl:'main/follower/getfollowerBypage', searchUrl:'main/follower/searchFollowerByName'});
});
</script>
<script src="<?php echo @MISC_ROOT;?>
js/follow/followlist.js" type="text/javascript"></script>
</body>
</html><?php }} ?>
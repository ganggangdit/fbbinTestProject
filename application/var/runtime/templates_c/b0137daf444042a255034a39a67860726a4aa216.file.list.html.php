<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:25:47
         compiled from "application/views/following/list.html" */ ?>
<?php /*%%SmartyHeaderCode:21109297864fc8525bb0b303-29783222%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0137daf444042a255034a39a67860726a4aa216' => 
    array (
      0 => 'application/views/following/list.html',
      1 => 1336465692,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21109297864fc8525bb0b303-29783222',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'userinfo' => 0,
    'followings_count' => 0,
    'is_self' => 0,
    'followinglist' => 0,
    'following' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc8525bcbec5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc8525bcbec5')) {function content_4fc8525bcbec5($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<link href="<?php echo @MISC_ROOT;?>
css/follow/follow.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['avatar'];?>
" alt="" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['username'];?>
</a></span>
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['self_url'];?>
">关注列表</a></span>
			</div>
		</div>
		<div class="modlueBody">
                        
                        <?php if ($_smarty_tpl->tpl_vars['followings_count']->value){?><div class="listSearch clearfix">
						<h4>关注 (<?php echo $_smarty_tpl->tpl_vars['followings_count']->value;?>
)</h4>
				<?php if ($_smarty_tpl->tpl_vars['is_self']->value){?><input type="text" value="输入姓名" class="fieldWithText" ref="输入姓名" id="searchList" /><span class="btnGray"><s></s></span><?php }?>
			</div><?php }?>
                        
                        
                        <?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
                            <?php if ($_smarty_tpl->tpl_vars['followings_count']->value){?>
                            <ul class="listWrap clearfix" id="listWrap">
                                <?php  $_smarty_tpl->tpl_vars['following'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['following']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['followinglist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['following']->key => $_smarty_tpl->tpl_vars['following']->value){
$_smarty_tpl->tpl_vars['following']->_loop = true;
?>
                                    <li>
                                        <div class="avatarBox <?php if ($_smarty_tpl->tpl_vars['following']->value['hidden']){?>invisible<?php }?>">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['following']->value['href'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['following']->value['src'];?>
" alt="" /></a>
                                                    <s id="<?php echo $_smarty_tpl->tpl_vars['following']->value['id'];?>
"></s>
                                        </div>
                                        <span class="uName">
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['following']->value['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['following']->value['name'];?>
</a>
                                        </span>
                                    </li>
                                 <?php } ?>      
                             </ul>
                             <?php if ($_smarty_tpl->tpl_vars['followings_count']->value>27){?>
                             <div class="loadmore hide" id="loadmore"><a></a></div>
                             <?php }?>
                            <?php }else{ ?>
                             <div class="blankWrap" id="nodata"><span>您还没有关注对象</span></div>
                            <?php }?>
                        <?php }else{ ?>
                            <?php if ($_smarty_tpl->tpl_vars['followings_count']->value){?>
                            <ul class="listWrap clearfix" id="listWrap">
                                <?php  $_smarty_tpl->tpl_vars['following'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['following']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['followinglist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['following']->key => $_smarty_tpl->tpl_vars['following']->value){
$_smarty_tpl->tpl_vars['following']->_loop = true;
?>
                                    <li>
                                            <div class="avatarBox">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['following']->value['href'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['following']->value['src'];?>
" alt="" /></a>
                                            </div>
                                            <span class="uName">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['following']->value['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['following']->value['name'];?>
</a>
                                            </span>
                                    </li>
                                 <?php } ?>      
                             </ul>
                             <?php if ($_smarty_tpl->tpl_vars['followings_count']->value>27){?>
                             <div class="loadmore hide" id="loadmore"><a></a></div>
                             <?php }?>
                            <?php }else{ ?>
                             <div class="blankWrap" id="nodata"><span>该用户还没有关注对象</span></div>
                            <?php }?>
                        <?php }?>
				<div class="blankWrap hide" id="noresult"><span>未检索到任何结果，请重新输入关键字</span></div>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
$(function() {
	list.init({visibleUrl:'main/following/visibleFollowing', moreUrl:'main/following/getFollowingsByPage', searchUrl:'main/following/searchFollowingByUserName'});
});
</script>
<script src="<?php echo @MISC_ROOT;?>
js/follow/followlist.js" type="text/javascript"></script>
</body>
</html><?php }} ?>
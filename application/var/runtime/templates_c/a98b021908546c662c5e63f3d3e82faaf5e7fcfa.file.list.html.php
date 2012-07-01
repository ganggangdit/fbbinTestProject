<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 15:49:15
         compiled from "application/views/friend/list.html" */ ?>
<?php /*%%SmartyHeaderCode:19595078384fc873fb2bad97-73148534%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a98b021908546c662c5e63f3d3e82faaf5e7fcfa' => 
    array (
      0 => 'application/views/friend/list.html',
      1 => 1336125986,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19595078384fc873fb2bad97-73148534',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'home_info' => 0,
    'friendlist' => 0,
    'flist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc873fb4c141',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc873fb4c141')) {function content_4fc873fb4c141($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/follow/follow.css" rel="stylesheet" type="text/css" />
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
">好友列表</a></span></span>
			</div>
		</div>
		<div class="modlueBody">
			<div class="listSearch clearfix">
                                <?php if (($_smarty_tpl->tpl_vars['home_info']->value['NumOfFriends']>0)){?>
                                    <h4>好友 (<?php echo $_smarty_tpl->tpl_vars['home_info']->value['NumOfFriends'];?>
)</h4>
                                <?php }?>
                                <?php if (($_smarty_tpl->tpl_vars['home_info']->value['is_self']=='ture')){?>
                                    <input type="text" value="请输入姓名" class="fieldWithText" ref="请输入姓名" id="searchList" /><span class="btnGray"><s></s></span>
                                <?php }?>
			</div>
			<ul class="listWrap clearfix" id="listWrap">
                            <?php if (($_smarty_tpl->tpl_vars['home_info']->value['is_self']=='ture')){?>    
                                <?php  $_smarty_tpl->tpl_vars['flist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['flist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['friendlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['flist']->key => $_smarty_tpl->tpl_vars['flist']->value){
$_smarty_tpl->tpl_vars['flist']->_loop = true;
?>
                                    <li>
					<?php if (($_smarty_tpl->tpl_vars['flist']->value['hidden']==0)){?> 
                                            <div class="avatarBox" >
                                        <?php }else{ ?> 
                                            <div class="avatarBox invisible" >
                                        <?php }?>    
						<a href="<?php echo $_smarty_tpl->tpl_vars['flist']->value['href'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['flist']->value['src'];?>
" alt="" /></a>
                                                <s id="<?php echo $_smarty_tpl->tpl_vars['flist']->value['id'];?>
"></s>
					</div>
					<span class="uName">
						<a href="<?php echo $_smarty_tpl->tpl_vars['flist']->value['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['flist']->value['name'];?>
</a>
					</span>
                                    </li>
                                <?php } ?>
                             <?php }?> 
                             <?php if (($_smarty_tpl->tpl_vars['home_info']->value['is_self']==false)){?>    
                                <?php  $_smarty_tpl->tpl_vars['flist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['flist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['friendlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['flist']->key => $_smarty_tpl->tpl_vars['flist']->value){
$_smarty_tpl->tpl_vars['flist']->_loop = true;
?>
                                    <li>
					<div class="avatarBox" >
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
                             <?php }?>
                        </ul>
                        <?php if ($_smarty_tpl->tpl_vars['home_info']->value['NumOfFriends']>27){?> 
                            <div class="loadmore hide" id="loadmore"><a></a></div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['home_info']->value['NumOfFriends']<1&&$_smarty_tpl->tpl_vars['home_info']->value['is_self']=='ture'){?> 
                             <div class="blankWrap" id="nodata"><span>您还没有好友</span></div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['home_info']->value['NumOfFriends']<1&&$_smarty_tpl->tpl_vars['home_info']->value['is_self']==false){?> 
                             <div class="blankWrap" id="nodata"><span>该用户还没有好友</span></div>
                        <?php }?>
			<div class="blankWrap hide" id="noresult"><span>未检索到任何结果，请重新输入关键字</span></div>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
$(function() {
	list.init({visibleUrl:'main/friend/hideFriend', moreUrl:'main/friend/getFriendByPage', searchUrl:'main/friend/searchFriendByName'});
});
</script>
<script src="<?php echo @MISC_ROOT;?>
js/follow/followlist.js" type="text/javascript"></script><?php }} ?>
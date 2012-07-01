<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 15:19:20
         compiled from "application/views/comment/like_lists.html" */ ?>
<?php /*%%SmartyHeaderCode:14805342694fc86cf8e89375-12488454%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2638db1e6503fcee29a74c2b4e85a14b21e5fe9c' => 
    array (
      0 => 'application/views/comment/like_lists.html',
      1 => 1337068764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14805342694fc86cf8e89375-12488454',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pagecount' => 0,
    'object_id' => 0,
    'object_type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc86cf901e37',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc86cf901e37')) {function content_4fc86cf901e37($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户列表</title>
<script language="javascript" type="text/javascript">
	var WEB_ID = '';
</script>
<link href="<?php echo @MISC_ROOT;?>
css/common/base.css" rel="stylesheet" type="text/css" media="screen,projection" />

<!--以下为简洁评论样式 CSS 文件-->
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/comment-easy/comment_easy.css" rel="stylesheet" type="text/css" media="screen,projection" />
<script src="<?php echo @MISC_ROOT;?>
js/init.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/common/utils.js" type="text/javascript"></script>
<!--以下为发送好友请求JS-->
<script src="<?php echo @MISC_ROOT;?>
js/plug/relation/relation.js" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/comment-easy/comment_easy_friendRequest.js" type="text/javascript"></script>

</head>

<body>
<input type="hidden" id="hd_pageCount" value="<?php echo $_smarty_tpl->tpl_vars['pagecount']->value;?>
" />
<input type="hidden" id="hd_commentID" value="<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
" />
<input type="hidden" id="hd_pageType"  value="<?php echo $_smarty_tpl->tpl_vars['object_type']->value;?>
"/>
<div class="comment_userList" id="comment_userList">

  <ul>
  </ul>
  <?php if ($_smarty_tpl->tpl_vars['pagecount']->value!=1){?>
  <div class="more"><a href="#" id="loadMore">查看更多</a></div>
  <?php }?>
</div>
</body>
</html>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:08:17
         compiled from "application/views/comment/share_lists.html" */ ?>
<?php /*%%SmartyHeaderCode:9547274904fc84e412ad7b0-82384278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb48e4372004d292f8cd294faff540c6aebef8a3' => 
    array (
      0 => 'application/views/comment/share_lists.html',
      1 => 1334908032,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9547274904fc84e412ad7b0-82384278',
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
  'unifunc' => 'content_4fc84e4138ce3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc84e4138ce3')) {function content_4fc84e4138ce3($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户列表</title>
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
js/plug/comment-easy/commentEasy.js" type="text/javascript"></script>

<script src="<?php echo @MISC_ROOT;?>
js/plug/comment-easy/comment_easy_shareRequest.js" type="text/javascript"></script>
</head>

<body style="background-color:#ffffff;height:400px;overflow-y:auto;">
<input type="hidden" id="hd_pageCount" value="<?php echo $_smarty_tpl->tpl_vars['pagecount']->value;?>
" />
<input type="hidden" id="hd_commentID" value="<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
" />
<input type="hidden" id="hd_pageType"  value="<?php echo $_smarty_tpl->tpl_vars['object_type']->value;?>
"/>
<div class="comment_likeList" id="comment_userList">
  <ul>
  </ul>
  <?php if ($_smarty_tpl->tpl_vars['pagecount']->value!=1){?>
  <div class="more"><a href="#" id="loadMore">查看更多</a></div>
  <?php }?>
</div>
</body>
</html>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 13:46:26
         compiled from "application/views/search/photo.html" */ ?>
<?php /*%%SmartyHeaderCode:10703068094fc9a8b2c30ed6-12510935%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '247d86054aa97a41aff71cfca0186cd6bfe982ba' => 
    array (
      0 => 'application/views/search/photo.html',
      1 => 1336010856,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10703068094fc9a8b2c30ed6-12510935',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_url' => 0,
    'user_avatar' => 0,
    'user_name' => 0,
    'app_url_list' => 0,
    'keyword' => 0,
    'total' => 0,
    'isEmpty' => 0,
    'photo' => 0,
    'vo' => 0,
    'is_last_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc9a8b2df011',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc9a8b2df011')) {function content_4fc9a8b2df011($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."main/application/views/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/search/search.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."main/application/views/top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['user_url']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['user_avatar']->value;?>
" alt="" /></a></span>
			<div class="userName">
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['user_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</a></span>
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['photo'];?>
">搜索</a></span>
				<div class="dropMenu">
					<div class="triggerBtn"><span class="fl">照片</span><s></s></div>
					<div class="dropList">
						<ul class="dropListul">
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['globals'];?>
" class="itemAnchor"><i class="i_search"></i><span>全部</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['people'];?>
" class="itemAnchor"><i class="i_friend"></i><span>人名</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['website'];?>
" class="itemAnchor"><i class="i_page"></i><span>网页</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['status'];?>
" class="itemAnchor"><i class="i_status"></i><span>状态</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['album'];?>
" class="itemAnchor"><i class="i_album"></i><span>相册</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['video'];?>
" class="itemAnchor"><i class="i_video"></i><span>视频</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['blog'];?>
" class="itemAnchor"><i class="i_blog"></i><span>博客</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['answer'];?>
" class="itemAnchor"><i class="i_ask"></i><span>问答</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['event'];?>
" class="itemAnchor"><i class="i_activity"></i><span>活动</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="modlueBody">
			<h3 class="modlueBodyTitle categoryTitle" id="term" name="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
">照片(<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
)</h3>
			<?php if ($_smarty_tpl->tpl_vars['isEmpty']->value==true){?>
			<div class="noResult">未搜索到相应结果，请重新输入关键字</div>
			<?php }else{ ?>
			<div class="searchResult" id="photoResult">
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['photo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
					<li class="searchLi">
						<a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['vo']->value['img'];?>
" alt="" /></a>
						<p class="searchCont">
							<a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['vo']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['name_txt'];?>
</a>
							<span class="show" title="<?php echo $_smarty_tpl->tpl_vars['vo']->value['fulltext'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['text'];?>
</span>
						</p>
					</li>
				<?php } ?>
				</ul>
				<?php if (!$_smarty_tpl->tpl_vars['is_last_page']->value){?>
				<div class="moreResult hide">
					<a name="4" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=photo" rel="1" class="hide">查看更多照片<i></i></a>
					<span><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<?php }?>			
		</div>
	</div>
	<div class="sideArea">
		sideArea
	</div>
</div>


<?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."main/application/views/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/searchResult/searchResult.js"></script>
</body>
</html><?php }} ?>
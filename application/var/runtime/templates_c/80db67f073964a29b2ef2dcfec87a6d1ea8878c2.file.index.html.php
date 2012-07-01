<?php /* Smarty version Smarty-3.1.7, created on 2012-06-05 13:54:44
         compiled from "application/views/search/index.html" */ ?>
<?php /*%%SmartyHeaderCode:5185694544fc85176ebeda8-50521540%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '80db67f073964a29b2ef2dcfec87a6d1ea8878c2' => 
    array (
      0 => 'application/views/search/index.html',
      1 => 1338875219,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5185694544fc85176ebeda8-50521540',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc851776c874',
  'variables' => 
  array (
    'user_url' => 0,
    'user_avatar' => 0,
    'user_name' => 0,
    'app_url_list' => 0,
    'keyword' => 0,
    'isEmpty' => 0,
    'globals' => 0,
    'vo' => 0,
    'id' => 0,
    'ls' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc851776c874')) {function content_4fc851776c874($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."/main/application/views/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/search/search.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."/main/application/views/top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


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
				<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['globals'];?>
">搜索</a></span>
				<div class="dropMenu">
					<div class="triggerBtn"><span class="fl">全部</span><s></s></div>
					<div class="dropList">
						<ul class="dropListul">
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['people'];?>
" class="itemAnchor"><i class="i_friend"></i><span>人名</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['website'];?>
" class="itemAnchor"><i class="i_page"></i><span>网页</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['status'];?>
" class="itemAnchor"><i class="i_status"></i><span>状态</span></a></li>
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url_list']->value['photo'];?>
" class="itemAnchor"><i class="i_photo"></i><span>照片</span></a></li>
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
		<div class="modlueBody" id="globalSearch">
			<h3 class="modlueBodyTitle"  id="term" name="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
">全部</h3>
			<?php if ($_smarty_tpl->tpl_vars['isEmpty']->value==true){?>
			<div class="noResult">未搜索到相应结果，请重新输入关键字</div>
			<?php }else{ ?>
			<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['globals']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>	
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==1){?>
			<!-- start:people -->	
			<div class="searchResult" id="userResult">
				<h4 class="categoryTitle">人名(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<li class="searchLi">
						<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
						<p class="searchCont">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a>
						</p>
						<?php if (!$_smarty_tpl->tpl_vars['id']->value['self']){?>
						<div class="statusBox" rel="<?php echo $_smarty_tpl->tpl_vars['id']->value['relation'];?>
" uid="<?php echo $_smarty_tpl->tpl_vars['id']->value['uid'];?>
"></div>
						<?php }?>
					</li>
				<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="1" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多人名<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:people -->
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==2){?>
			<!-- start: website  -->			
			<div class="searchResult" id="pageResult">
				<h4 class="categoryTitle">网页(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['id']->value['relation']==0){?>
						<li class="searchLi">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
							<p class="searchCont">
								<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name'];?>
</a>
								<span class="show gray">粉丝数: <?php echo $_smarty_tpl->tpl_vars['id']->value['fans_count'];?>
</span>
							</p>
							<?php if (!$_smarty_tpl->tpl_vars['id']->value['self']){?>
							<div class="statusBox">
								<span class="btnBlue"><i></i><a href="javascript:void(0);" id="<?php echo $_smarty_tpl->tpl_vars['id']->value['web_id'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['id']->value['f_uid'];?>
" class="addFollow">加关注</a></span>
								<div class="dropWrap dropMenu hide">
									<div class="triggerBtn"><i class="friend"></i><span>关注</span><s></s></div>
									<div class="dropList">
										<ul class="dropListul checkedUl">
											<li><a href="javascript:void(0);" id="<?php echo $_smarty_tpl->tpl_vars['id']->value['web_id'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['id']->value['f_uid'];?>
" class="itemAnchor unFollow"><span>取消关注</span></a></li>
										</ul>
									</div>
									</div>
							</div>
							<?php }?>
						</li>
					<?php }else{ ?>
						<li class="searchLi">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
							<p class="searchCont">
								<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name'];?>
</a>
								<span class="show gray">粉丝数: <?php echo $_smarty_tpl->tpl_vars['id']->value['fans_count'];?>
</span>
							</p>
						<?php if (!$_smarty_tpl->tpl_vars['id']->value['self']){?>	
						<div class="statusBox">
							<span class="btnBlue hide"><i></i><a href="javascript:void(0);" id="<?php echo $_smarty_tpl->tpl_vars['id']->value['web_id'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['id']->value['f_uid'];?>
" class="addFollow">加关注</a></span>
							<div class="dropWrap dropMenu">
								<div class="triggerBtn"><i class="friend"></i><span>关注</span><s></s></div>
								<div class="dropList">
									<ul class="dropListul checkedUl">
										<li><a href="javascript:void(0);" id="<?php echo $_smarty_tpl->tpl_vars['id']->value['web_id'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['id']->value['f_uid'];?>
" class="itemAnchor unFollow"><span>取消关注</span></a></li>
									</ul>
								</div>
								</div>
							</div>
						<?php }?>
						</li>
					<?php }?>
					<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="2" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多网页<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:website -->
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==3){?>
			<!-- start:status -->			
			<div class="searchResult">
				<h4 class="categoryTitle">状态(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<li class="searchLi">
						<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
						<p class="searchCont">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a> <span class="gray"><?php echo $_smarty_tpl->tpl_vars['id']->value['time'];?>
</span>
							<span class="show" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fulltext'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['text'];?>
</span>
						</p>
					</li>
					<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="3" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多状态<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:status -->
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==4){?>
			<!-- start:photo -->			
			<div class="searchResult">
				<h4 class="categoryTitle">照片(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<li class="searchLi">
						<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
						<p class="searchCont">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a>
							<span class="show" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fulltext'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['text'];?>
</span>
						</p>
					</li>
				<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="4" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多照片<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:photo -->
			<?php }?>
						
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==5){?>
			<!-- start:album -->			
			<div class="searchResult">
				<h4 class="categoryTitle">相册(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<li class="searchLi">
						<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
						<p class="searchCont">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a> <span class="gray"><?php echo $_smarty_tpl->tpl_vars['id']->value['count'];?>
张</span>
							<span class="show" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fulltext'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['text'];?>
</span>
						</p>
					</li>
					<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="5" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多相册<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:album -->
			<?php }?>	
			
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==6){?>
			<!-- start:video -->			
			<div class="searchResult">
				<h4 class="categoryTitle">视频(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<li class="searchLi">
						<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
						<p class="searchCont">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a>
							<span class="show" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fulltext'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['text'];?>
</span>
						</p>
					</li>
				<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="6" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多视频<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:video -->
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==7){?>
			<!-- start:blog -->			
			<div class="searchResult">
				<h4 class="categoryTitle">博客(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<li class="searchLi">
						<h5 class="bt"><a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a></h5>
						<div class="bc" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fulltext'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['text'];?>
</div>
						<span class="gray">作者:</span> <a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['authorUrl'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['author'];?>
</a>
					</li>
				<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="7" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多博客<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:blog -->
			<?php }?>

			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==8){?>
			<!-- start:QA -->
			<div class="searchResult">
				<h4 class="categoryTitle">问答(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<?php if ($_smarty_tpl->tpl_vars['id']->value['ask']['type']==0){?>
					<li class="searchLi">
						<h5 class="bt"><a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a></h5>
						<ol class="askItem">
							<?php  $_smarty_tpl->tpl_vars['ls'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ls']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['id']->value['ask']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ls']->key => $_smarty_tpl->tpl_vars['ls']->value){
$_smarty_tpl->tpl_vars['ls']->_loop = true;
?>
							<li title="<?php echo $_smarty_tpl->tpl_vars['ls']->value['fulltext'];?>
">
								<input type="radio" name="radio" disabled="disabled" />
								<div>
									<p><?php echo $_smarty_tpl->tpl_vars['ls']->value['name'];?>
</p>
									<span style="width:<?php echo $_smarty_tpl->tpl_vars['ls']->value['percent'];?>
%;"></span>
								</div>
							</li>
							<?php } ?>
							<?php if ($_smarty_tpl->tpl_vars['id']->value['ask']['more_link']==true){?>
							<li>
								<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
">查看更多</a>
							</li>
							<?php }?>
						</ol>
					</li>
					<?php }else{ ?>
					<li class="searchLi">
						<h5 class="bt"><a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a></h5>
						<ol class="askItem">
						<?php  $_smarty_tpl->tpl_vars['ls'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ls']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['id']->value['ask']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ls']->key => $_smarty_tpl->tpl_vars['ls']->value){
$_smarty_tpl->tpl_vars['ls']->_loop = true;
?>
							<li title="<?php echo $_smarty_tpl->tpl_vars['ls']->value['fulltext'];?>
">
								<input type="checkbox" disabled="disabled" />
								<div>
									<p><?php echo $_smarty_tpl->tpl_vars['ls']->value['name'];?>
</p>
									<span style="width:<?php echo $_smarty_tpl->tpl_vars['ls']->value['percent'];?>
%;"></span>
								</div>
							</li>
						<?php } ?>
							<?php if ($_smarty_tpl->tpl_vars['id']->value['ask']['more_link']==true){?>
							<li>
								<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
">查看更多</a>
							</li>
							<?php }?>
						</ol>
					</li>
					<?php }?>
				<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="8" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多问答<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:QA -->
			<?php }?>
						
			<?php if (isset($_smarty_tpl->tpl_vars['vo']->value['type'])&&$_smarty_tpl->tpl_vars['vo']->value['type']==9){?>
			<!-- start:event -->			
			<div class="searchResult" id="activityResult">
				<h4 class="categoryTitle">活动(<?php echo $_smarty_tpl->tpl_vars['vo']->value['num'];?>
)</h4>
				<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['id']->key => $_smarty_tpl->tpl_vars['id']->value){
$_smarty_tpl->tpl_vars['id']->_loop = true;
?>
					<li class="searchLi">
						<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" class="headerImg"><img src="<?php echo $_smarty_tpl->tpl_vars['id']->value['img'];?>
" alt="" /></a>
						<p class="searchCont">
							<a href="<?php echo $_smarty_tpl->tpl_vars['id']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fullname'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['name_txt'];?>
</a>
							<span class="show" title="<?php echo $_smarty_tpl->tpl_vars['id']->value['fulltext'];?>
"><?php echo $_smarty_tpl->tpl_vars['id']->value['time'];?>
</span>
						</p>
					</li>
				<?php } ?>
				</ul>
				<?php if ($_smarty_tpl->tpl_vars['vo']->value['num']>2){?>
				<div class="moreResult">
					<a name="9" href="<?php echo @WEB_ROOT;?>
main/?c=search&m=main&type=globals" rel="1">查看更多活动<i></i></a>
					<span class="hide"><img width="16" height="7" alt="loading" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"></span>
				</div>
				<?php }?>
			</div>
			<!-- end:event -->
			<?php }?>
		<?php } ?>
		<?php }?>
		</div>
	</div>
	<div class="sideArea">
		sideArea
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ((@WEB_ROOT_SMARTY)."main/application/views/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/plug/relation/relation.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/searchResult/searchResult.js"></script>
</body>
</html><?php }} ?>
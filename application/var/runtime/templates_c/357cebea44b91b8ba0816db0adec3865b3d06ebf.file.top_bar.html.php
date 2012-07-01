<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 11:50:00
         compiled from "application/views/top_bar.html" */ ?>
<?php /*%%SmartyHeaderCode:13055476254fc83be80a7b09-38347223%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '357cebea44b91b8ba0816db0adec3865b3d06ebf' => 
    array (
      0 => 'application/views/top_bar.html',
      1 => 1337829210,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13055476254fc83be80a7b09-38347223',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83be80e5e1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83be80e5e1')) {function content_4fc83be80e5e1($_smarty_tpl) {?><div id="header">
	<div class="header">
		<div class="topBar clearfix">
			<!-- start LOGO 通知 、站内信、请求、导航、搜索  -->
			<div class="nav_box clearfix">
				<h1 id="logo"><a href="<?php echo @WEB_ROOT;?>
" title="首页">duankou</a></h1>
				<!-- Start 通知 、站内信、请求 -->
				<div id="jewelContainer" class="msg_box">
					<div id="requestsJewel" class="jewel dropMenu" dataContent="requestsFlyout">
						<a class="jewelButton triggerBtn" href="javascript:void(0)">
							<span id="requestsCountWrapper" class="jewelCount"><span id="requestsCountValue">0</span></span>
						</a>
						<div id="requestsFlyout" class="jewelFlyout dropList">
							<div class="clearfix uiHeaderBottomBorder jewelHeader">
								<a style="display:none;" class="fr" href="javascript:void(0);">搜索朋友</a>
								<div>
									<h3 class="uiHeaderTitle">请求</h3>
								</div>
							</div>
							<div class="invite">
								 <ul class="invite_list">
								 	
								 </ul>
							</div>
							<div class="jewelFooter">
								<a class="seeMore" href="javascript:void(0);"><span>查看所有朋友请求</span></a>
							</div>
						</div>
					</div>
					<div id="messagesJewel" class="jewel dropMenu" dataContent="messagesFlyout">
						<a class="jewelButton triggerBtn" href="javascript:void(0)">
							<span id="messagesCountWrapper" class="jewelCount" ><span id="messagesCountValue">0</span></span>
						</a>
						<div id="messagesFlyout" class="jewelFlyout dropList">
							<div class="clearfix uiHeaderBottomBorder jewelHeader">
								<a class="fr" id="jewelSendNewMessage" href="javascript:void(0);">发送新信息</a>
								<div>
									<h3 class="uiHeaderTitle">站内信</h3>
								</div>
							</div>
							<ul class="jewelItemList">
								
							</ul>
							<div class="jewelFooter">
								<a class="seeMore" href="javascript:void(0);"><span>查看所有信息</span></a>
							</div>
						</div>
					</div>
					<div id="notificationsJewel" class="jewel dropMenu" dataContent="notificationsFlyout">
						<a class="jewelButton triggerBtn" href="javascript:void(0)">
							<span id="notificationsCountWrapper" class="jewelCount"><span id="notificationsCountValue">0</span></span>
						</a>
						<div id="notificationsFlyout" class="jewelFlyout dropList">
							<div class="clearfix uiHeaderBottomBorder jewelHeader">
								<div>
									<h3 class="uiHeaderTitle">通知</h3>
								</div>
							</div>
							<ul class="noticeItemList">
								
							</ul>
						</div>
					</div>
				</div>
				<!-- End 通知 、站内信、请求 -->
				<div id="headNav" class="fl unvisible">
					<ul id="circleNav"></ul>
				</div>
				<div class="fr">
					<form action="/main/?" method="get" id="navSearch">
						<input name="c" type="hidden" value="search">
						<input name="m" type="hidden" value="main">
						<input name="type" type="hidden" value="globals"/>
						<div class="uiTypeahead">
							<input type="text" class="searchInput fl" name="term" id="globalSearch" maxlength="50" />
							<button type="submit" title="search">
								<span class="hide">搜索</span>
							</button>
							<span class="initVal" id="initval">搜索</span>
						</div>
					</form>
					<!-- Start 右侧箭头下拉-->
					<div id="pageNav" class="fl">
						<ul>
							<li>
								<a id="topUserLink" class="topNavLink tinyman" href="" title="home" rel="uid_1234">
									<img id="topUserAvatar" width="23" height="23" alt="头像" src="<?php echo @MISC_ROOT;?>
img/default/avatar_30.gif" >
									<span id="topUserInfo" class="headerTinyName"><strong></strong></span>
								</a>
							</li>
							<li id="navAccount" class="dropMenu">
								<a class="triggerBtn" id="navAccountTogger" href="javascript:void(0)"></a>
								<ul id="subNavAccount" class="dropList">
									<li><a href="<?php echo @WEB_ROOT;?>
main/index.php?c=invitecode">邀请码</a></li>
									<li class="menuDivider"></li>
									<li><a href="<?php echo @WEB_ROOT;?>
main/index.php?c=setting">系统设置</a></li>
									<li><a target="_blank" href="<?php echo @WEB_ROOT;?>
single/help/">帮助中心</a></li>
									<li><a href="#logout" onclick="logout();">退出</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<!--end 右侧箭头下拉 -->
				</div>
			</div>
			<!-- end LOGO、通知 、站内信、请求、导航、搜索  -->	
			
		</div>
	</div>
</div>

<script type="text/javascript">
	function logout() {
		//$.get(webpath + 'dksns-im-web/logout', function() {});
		window.location.href = "<?php echo @WEB_ROOT;?>
front/index.php?c=index&m=dologout";
	}
</script>
<?php }} ?>
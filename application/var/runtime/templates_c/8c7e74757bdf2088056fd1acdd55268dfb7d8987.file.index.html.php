<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 14:13:02
         compiled from "application/views/message/index.html" */ ?>
<?php /*%%SmartyHeaderCode:13737156424fc85d6e8ad5a2-71771222%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c7e74757bdf2088056fd1acdd55268dfb7d8987' => 
    array (
      0 => 'application/views/message/index.html',
      1 => 1336360874,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13737156424fc85d6e8ad5a2-71771222',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'avatar' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc85d6e991a3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc85d6e991a3')) {function content_4fc85d6e991a3($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
/css/message/request_notice.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
/css/message/messages.css" type="text/css" rel="stylesheet" />

</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix messageBody">
	<div class="mainArea">
    <!--start-->
		<div class="modlueHeader clearfix">                                 
                    <span class="userImg"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><img src="<?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
" alt="头像" /></a></span>
                    <div class="userName">
                        <span class="nameTxt"><a href="<?php echo @WEB_ROOT;?>
main/index.php"><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</a></span>
                        <span class="nameTxt"><span class="fl"><a href="<?php echo @WEB_ROOT;?>
main/index.php?c=msg&m=show_message">消息</a></span><s></s></span>
                    </div> 
					<div class="userActions">
						<span class="btnGray"><i class="uiButtonIcon plus"></i><a  id="newMessage" href="#">新信息 </a> </span>
					</div> 
        </div>        
    <!--end-->
		<div class="modlueBody">
		<!-- start: MessagingSearch 消息搜索-->
		<div class="msgTitle" id="msgTitle">
			<h3>消息</h3>
			<div id="MessagingSearch" class="fr pls">
			  <div class="searchType MessagingSearchFilter">
				<div id="searchFilterButton" class="uiSelector uiButton"><a class="uiSelectorMenu" href="#"></a></div>
				<div id="searchFilterType">
				  <ul>
					<li class="uiMenuTit">搜索：</li>
					<li><a href="#" rel='0'>未读消息</a></li>
					<li><a href="#" rel='2'>已存档消息</a></li>
					<li><a href="#" rel='6'>已发送消息</a></li>
				  </ul>
				</div>
			  </div>
			  <div id="deleteFilter"></div>
			   <form method="post" id="myform" name="myform" action="<?php echo @WEB_ROOT;?>
main/index.php?c=msg&m=show_message"><input id="MessaginSearchQuery"  name="MessaginSearchQuery" class="fieldWithText" type="text" ref="搜索消息" value="搜索消息" maxlength="50"/>
			  <input class="hide" type="submit">
			  </form>
			</div>
		</div>
		<!-- end: MessagingSearch 消息搜索--> 

    		<!-- start: contentCol-->
            <div id="contentCol" class="clearfix home">
		
              <div id="contentArea"> 
                <!-- start: MessagingMainContent 消息列表-->
                <div id="MessagingMainContent" class="clearfix">
                  <ul id="MessagingThreadlist">
                  <!-- 消息遍历开始 -->
					
                    <!-- 消息遍历结束 -->
                   
                  </ul>
                  <div id="moreMessagesButtonWrap">
                    <div class="loadingAnimation"><img src="/misc/img/system/more_loading.gif" /></div>
                    
                    <a id="moreMessagesButton" class="hide" href="javascript:void(0);" rel="1" >查看更多</a> </div>
                   
                  <div class="footerActionBar">查看：<span id="sp_noread"><a href="#" id="noRead">未读</a><ins class="whiteSpace1Word"></ins>·<ins class="whiteSpace1Word"></ins><a href="#" id="yesSave">已存档</a></span><span><a href="#" id="allInfo" class="hide">全部消息</a></span></div>
                </div>
                <!-- end: MessagingMainContent 消息列表--> 
              </div>
            </div>
            <!-- end: contentCol --> 
        </div>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/timeline/scrollLoad.js" type="text/javascript" ></script>
</body>
</html><?php }} ?>
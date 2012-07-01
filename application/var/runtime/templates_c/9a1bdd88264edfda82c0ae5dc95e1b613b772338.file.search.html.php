<?php /* Smarty version Smarty-3.1.7, created on 2012-06-02 09:47:10
         compiled from "application/views/message/search.html" */ ?>
<?php /*%%SmartyHeaderCode:15291118414fc9709e9388c8-62528214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a1bdd88264edfda82c0ae5dc95e1b613b772338' => 
    array (
      0 => 'application/views/message/search.html',
      1 => 1336360874,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15291118414fc9709e9388c8-62528214',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gid' => 0,
    'avatar' => 0,
    'user' => 0,
    'lastid' => 0,
    'searchname' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc9709ea6445',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc9709ea6445')) {function content_4fc9709ea6445($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
/css/message/request_notice.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
/css/message/messages.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix messageBody">
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
" id="hd_dataid"/>
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
				<span class="btnGray dropMenu" id="sp_btnAction">
					<div class="dropMenu ">
						<div id="relation_state" class="triggerBtn">
							<span>
							</span><s></s>
						</div>
						<div class="dropList dropListR">
							<ul class="dropListul" id="actionInfo">
								<li><a class="itemAnchor pl15" rel="1">标记为未读</a></li>
								<li><a class="itemAnchor pl15" rel="2">标记为存档</a></li>
								<li><a class="itemAnchor pl15" rel="3">删除消息</a></li>
							</ul>
						</div>
					</div>
				</span>
				<span class="btnGray" id="sp_btnBackUrl"><i class="uiButtonIcon rightArrow"></i><a href="<?php echo @WEB_ROOT;?>
main/index.php?c=msg&m=list_msg&fromid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&lastId=<?php echo $_smarty_tpl->tpl_vars['lastid']->value;?>
">消息详情 </a> </span>
			</div>  
        </div>        
    <!--end-->
		<div class="modlueBody">
			<!-- start: MessagingSearch 消息搜索-->		
			<div class="msgTitle" id="msgTitle">
				<div class="m_userName"><i></i><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</div>
				<div class="uiSearchInput fr">
				  <div class="uiTypeahead">
					<form action="<?php echo @WEB_ROOT;?>
main/index.php?c=msg&m=search_msg"  method="post">
					<input type="text" name="searchkey" id="searchkey" class="searchInput fieldWithText" ref="在此对话框中搜索" value="<?php echo $_smarty_tpl->tpl_vars['searchname']->value;?>
"  maxlength="50"/>
					<button title="搜索" type="submit"> <span class="hide">搜索</span> </button>
					<input type="hidden" name="gid" value="<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
"/>
					<input type="hidden" name="hd_lastId" value="<?php echo $_smarty_tpl->tpl_vars['lastid']->value;?>
"/>
					</form>
				  </div>
				</div>
			</div>
			<!--end-->
    		<!-- start: contentCol-->
            <div id="contentCol" class="clearfix home">
              <div id="contentArea"> 
			  
              <div class="messagingContentHeaderWrapper hide clearfix" id="actionDelete">
					<p class="fl">选择讯息来删掉。</p>
					<p class="fr">
					  <label class="uiButton uiButtonConfirm"><input value="全部删除" class="callbackBtn" id="btn_delAll" type="button"></label>
					  <label class="uiButton uiButtonConfirm inputButton disabled"><input value="删除已选" class=" " disabled="true" id="btn_delSel" type="button"></label>
					  <label class="uiButton uiButtonDepressed"><input value="取消" class="closeBtn" type="button"></label>
				    </p>
			  </div>
                <!-- start: MessagingMainContent 消息列表-->
                <div id="messagingMessages" class="clearfix">
               
                  <ul id="searchmsgInfo_list">

                  </ul>
				  <div style="text-align:center;display:none;" id="dv_allInfo"><a href="<?php echo @WEB_ROOT;?>
main/index.php?c=msg&m=list_msg&fromid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&lastId=<?php echo $_smarty_tpl->tpl_vars['lastid']->value;?>
">查看全部完整消息</a></div>
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
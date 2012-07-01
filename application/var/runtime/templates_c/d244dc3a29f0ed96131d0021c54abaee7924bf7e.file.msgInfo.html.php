<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 14:01:09
         compiled from "application/views/message/msgInfo.html" */ ?>
<?php /*%%SmartyHeaderCode:12779977654fc85aa52da380-42467344%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd244dc3a29f0ed96131d0021c54abaee7924bf7e' => 
    array (
      0 => 'application/views/message/msgInfo.html',
      1 => 1337330996,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12779977654fc85aa52da380-42467344',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gid' => 0,
    'avatar' => 0,
    'user' => 0,
    'lastid' => 0,
    'fromid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc85aa53efc4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc85aa53efc4')) {function content_4fc85aa53efc4($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
/css/message/request_notice.css" type="text/css" rel="stylesheet" />
<link href="<?php echo @MISC_ROOT;?>
/css/message/messages.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="body clearfix " id="msgInfo">
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
main/index.php?c=msg&m=show_message">消息 </a> </span>
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
				<input type="text" name="searchkey" id="searchkey" class="searchInput fieldWithText" ref="在此对话框中搜索" value="在此对话框中搜索"  maxlength="50"/>
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
            <!-- start: messagingContentWrapper 消息详细开始  -->
            <div class="messagingContentWrapper">
              <div class="messagingContentHeaderWrapper hide clearfix" id="actionDelete">
					<p class="fl">选择讯息来删掉。</p>
					<p class="fr">
					  <label class="uiButton uiButtonConfirm"><input value="全部删除" class="callbackBtn" id="btn_delAll" type="button"/></label>
					  <label class="uiButton1 uiButtonConfirm inputButton disable disabled"><input value="删除已选" id="btn_delSel" disabled="disabled"  type="button"/></label>
					  <label class="uiButton uiButtonDepressed"><input value="取消" class="closeBtn" type="button"/></label>
				    </p>
			  </div>
              <div class="clearfix">
                <div class="messagingMainContent">
                  <div id="messagingScroller"> 
                    <!-- start: messagingMessages 消息详细聊天记录开始  -->
                    <div id="messagingMessages">
                      <ul id="msgInfo_list">
                        
                      </ul>
                    </div>
                    <!-- end: messagingMessages 消息详细聊天记录结束 --> 
                  </div>
                  <!-- start: 回复消息框开始 -->
                  <div id="messaginShelf" class="">
                    <div id="messaginShelfContent">
                      <div class="messagingComposer">
                        <div class="messagingComposerForm">
                          <div>
                          <input type="hidden" id="messagesHeadline" value="<?php echo $_smarty_tpl->tpl_vars['fromid']->value;?>
"/>
                          <input type="hidden" id="messagegid" value="<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">
                            <textarea id="messagingComposerBodyText" class="messagingComposerBody fieldWithText" style="height:24px;" ref="回复" maxlength="140">回复</textarea>
                            <label class="uiButton uiButtonConfirm" id="responseButton">
                              <input type="button" value="回复" />
                            </label>
                          </div>
                          <div id="messagingComposerOptions">
                            <div class="clearfix">
                              <div class="fr">
                                <input type="checkbox" id="checkForEnter" />
                                <label  for="checkForEnter"><span class="enter"></span></label>
                              </div>
                              <ul id="attachApps">
                                <li> <a class="attachOptions attachment" id="attachFileButtonForDetailPage" href="javascript:void(0);"></a></li>
                              </ul>
                            </div>
                            <div id="attachedFilesWrap">
                              <ul id="attachedFilesForDetailPage">
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end: 回复消息框结束 --> 
                </div>
              </div>
            </div>
            <!-- end: messagingContentWrapper 消息详细结束 --> 
        </div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="<?php echo @MISC_ROOT;?>
js/timeline/scrollLoad.js" type="text/javascript" ></script>
</body>
</html><?php }} ?>
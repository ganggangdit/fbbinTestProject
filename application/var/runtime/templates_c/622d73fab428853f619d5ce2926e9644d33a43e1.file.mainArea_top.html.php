<?php /* Smarty version Smarty-3.1.7, created on 2012-06-04 16:40:57
         compiled from "application/views/timeline/mainArea_top.html" */ ?>
<?php /*%%SmartyHeaderCode:7568132594fc83b7e1e86e7-31176502%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '622d73fab428853f619d5ce2926e9644d33a43e1' => 
    array (
      0 => 'application/views/timeline/mainArea_top.html',
      1 => 1338799254,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7568132594fc83b7e1e86e7-31176502',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83b7e7594d',
  'variables' => 
  array (
    'iscover' => 0,
    'cover' => 0,
    'is_self' => 0,
    'user' => 0,
    'f_uid' => 0,
    'relation' => 0,
    'msgurl' => 0,
    'user_app_list' => 0,
    'infoUrl' => 0,
    'val' => 0,
    'v' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83b7e7594d')) {function content_4fc83b7e7594d($_smarty_tpl) {?><div class="mainAreaTop clearfix dkTimelineSection">
	<div>
		<div id="dkProfileCover">
			<div class="cover">
				
				<div id="containImg" class="coverImage <?php if (!$_smarty_tpl->tpl_vars['iscover']->value){?> hide <?php }?>">
					<a id="dkCoverImageContainer" class="coverWrap">
						<img style="width:849px; margin-left:1px;" class="photo img" style="top: 0px;" src="<?php echo $_smarty_tpl->tpl_vars['cover']->value;?>
">
						<div class="instructionWrap">
							<div class="instruction"></div>
							<span>拖动以调整封面照片</span>
						</div>
						<div id="coverBorder" class="coverBorder"></div>
						<div class="profilePicNotch"><div class="notchInner"></div></div>
					</a>
					<?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
					<div id="editCover">
						
						<span id="editCoverbnt" class="editButton"><s></s><font>更改封面</font></span>
						
					</div>
					<?php }?>
				</div>
							
				<div id="noImg" class="coverImage coverNoImage <?php if ($_smarty_tpl->tpl_vars['iscover']->value){?> hide <?php }?> ">
				
					<div class="coverEmptyWrap">
						<img class="hide" src="<?php echo @MISC_ROOT;?>
img/system/more_loading.gif"/>
					</div>
					<?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
					<div id="addCover">					
						<span id="addCoverbnt" class="addButton"><s></s><font>添加一张封面</font><b></b></span>
					</div>
					<?php }?>
				</div>
				<!--个人小头像-->
				<div class="personalSmallImgBorder" id="editPersonImg">
					<div id="personalSmallImg" class="personalSmallImg">
						<img src="<?php echo get_avatar($_smarty_tpl->tpl_vars['user']->value['uid'],'b');?>
" />
					</div>
					<?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
					<div class="editHead  hide"> 
						<span id="editPerson" class="editButton" <?php if (exist_avatar($_smarty_tpl->tpl_vars['user']->value['uid'])){?> nohead="0" <?php }else{ ?>nohead="1"<?php }?>><s></s><font>编辑个人头像</font><b></b></span>						
					</div>
					<?php }?>
				</div>
				<!-- 个人小头像-->
			</div>
			<div id="dkTimelineHeadline" class="clearfix">
				
				<!-- 个人名字和更新信息 -->
				<div class="nameAndSendMsg">
					<!-- 个人名字 -->
					<div class="personalName">
						<span id="name" href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</span>
					</div>
					<!--/个人名字-->
					<!--更新信息和活动记录-->
					<div class="actions"><?php if (!$_smarty_tpl->tpl_vars['is_self']->value){?>
                        <div id="relationWrap" class="userName relation">
                        <div uid="<?php echo $_smarty_tpl->tpl_vars['f_uid']->value;?>
" rel="<?php echo $_smarty_tpl->tpl_vars['relation']->value;?>
" class="statusBox"></div>
                        <!-- 发消息按钮 -->
							<span id="msgsnd" class="nameTxt <?php if ($_smarty_tpl->tpl_vars['relation']->value!=6&&$_smarty_tpl->tpl_vars['relation']->value!=8&&$_smarty_tpl->tpl_vars['relation']->value!=10){?>hide<?php }?>">
								<a href="<?php echo $_smarty_tpl->tpl_vars['msgurl']->value;?>
" class="fl">发消息</a>
							</span>
                        </div><?php }?>
					</div>
					<!--/更新信息和活动记录-->
				</div>
				<!--/个人名字和更新信息-->
			</div>
                    <div id="coverEditCancelArea" class="coverEditor hide">
				<div class="saveAndCancel">
					<span href="javascript:void(0);" class="btnGray png cancelBnt" style="width: auto;"><a class="uiButtonText">取消</a></span>
					<span href="javascript:void(0);" class="btnBlue png uiBntConfirm" style="width: auto;"><a class="uiButtonText">保存更改</a></span>
					
				</div>
			</div>
		</div>
		
	</div>
	<!--/如没有设封面出现的空白层-->
	<!--内容区头部导航-->
	<div class="timelineNavgationPagelet">
		
		<!--时间线按钮-->
		<div class="timelineMenu dkTimelineNavigationWrapper">
			<div class="timelineNavContent dkTimelineNavigation clearfix">
				
				<?php if ((count($_smarty_tpl->tpl_vars['user_app_list']->value['nomove'])==0&&count($_smarty_tpl->tpl_vars['user_app_list']->value['move'])==0)){?>
				<div class="noPermission">
					<div class="noPermissionTip">该用户已设置权限，只对部分人开放。</div>
				</div>
				<?php }?>
				
				<div class="menuLeft">
					<ul class="timelineNavigation clearfix menuLeftUl" id="menuLeftUl">
						<ul class="fl">
						<li class="textLinkLi" id="textLinkLi">
							<div class="timelineSummarySectionWrapper">
								<a href="<?php echo $_smarty_tpl->tpl_vars['infoUrl']->value;?>
">
								<div class="textLinkLiBorder detail">
									<div class="timelineSummarySection">
										<span class="profileFragment"><i class="live"></i>住在<span class="blue"><?php echo $_smarty_tpl->tpl_vars['user']->value['now_addr'];?>
</span></span>
										<span class="profileFragment"><i class="home"></i>来自<span class="blue"><?php echo $_smarty_tpl->tpl_vars['user']->value['home_addr'];?>
</span></span>
										<span class="profileFragment"><i class="birth"></i>生日<span class="blue"><?php if ((!empty($_smarty_tpl->tpl_vars['user']->value['birthday']))){?> <?php echo date('Y年m月d日',$_smarty_tpl->tpl_vars['user']->value['birthday']);?>
<?php }?></span></span>
									</div>
								</div>
								</a>
								<a href="<?php echo $_smarty_tpl->tpl_vars['infoUrl']->value;?>
" class="textLinkLiText">自我介绍 </a>
							</div>
						</li>
					</ul>
						<ul class="fr">
							<ul class="noMoveRange">
							<?php if ((isset($_smarty_tpl->tpl_vars['user_app_list']->value['nomove']))){?>
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_app_list']->value['nomove']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
									<?php if ((in_array($_smarty_tpl->tpl_vars['val']->value['menu_id'],array(1,2)))){?>
									<li class="photo">
										<input type="hidden" name="objInfo" value="" />
										<input type="hidden" name="objId" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_id'];?>
" />
										<span class="tab">
											<div class="imgLinkLiImg tip" url="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
">
												<div class="whiteborder">
													<div class="contentwrapper">
													<?php if (isset($_smarty_tpl->tpl_vars['val']->value['cover'])&&count($_smarty_tpl->tpl_vars['val']->value['cover'])>0){?>
														<?php if ((is_array($_smarty_tpl->tpl_vars['val']->value['cover']))){?>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value['cover']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
														<a href="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
"><img class="fans img" src="<?php if (isset($_smarty_tpl->tpl_vars['v']->value['ico'])){?><?php echo $_smarty_tpl->tpl_vars['v']->value['ico'];?>
<?php }?>" alt="<?php if (isset($_smarty_tpl->tpl_vars['v']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
<?php }?>" onerror="this.src='<?php echo @MISC_ROOT;?>
img/default/avatar_ss.gif'"></a>
														<?php } ?>
														<?php }?>
													<?php }else{ ?>
														<div class="tip" hovercard="001" href="javascript:void(0);" url="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
"><img class="" src="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_ico'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_title'];?>
" ></div>
													<?php }?>
													</div>
												</div>
											</div>
											<?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
											<div class="dropWrap dropMenu listPermission permissionMiskPar" oid="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_id'];?>
" s="<?php if (isset($_smarty_tpl->tpl_vars['val']->value['weight'])){?><?php echo $_smarty_tpl->tpl_vars['val']->value['weight'];?>
<?php }else{ ?>1<?php }?>" uid="<?php if (isset($_smarty_tpl->tpl_vars['val']->value['userlist_content'])){?><?php echo $_smarty_tpl->tpl_vars['val']->value['userlist_content'];?>
<?php }?>"><?php if ($_smarty_tpl->tpl_vars['val']->value['menu_id']==1){?><div class="permissionMisk"></div><?php }?></div>
											<?php }?>
											<span class="imgLinkLiText"> <a href="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['menu_title'];?>
</a><span class="gray"><?php if ($_smarty_tpl->tpl_vars['val']->value['nums']){?><?php echo $_smarty_tpl->tpl_vars['val']->value['nums'];?>
<?php }?></span></span>
										</span>
									</li>
									<?php }?>
								<?php } ?>
								<?php }?>
							</ul>
							<ul class="moveRange">
								<?php if ((isset($_smarty_tpl->tpl_vars['user_app_list']->value['move']))){?>
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_app_list']->value['move']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
								<span style="display:none"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_title'];?>
</span>
								<?php if ((!in_array($_smarty_tpl->tpl_vars['val']->value['menu_id'],array(1,2)))){?>
								<li class="photo <?php if ((($_smarty_tpl->tpl_vars['key']->value>3)&&$_smarty_tpl->tpl_vars['is_self']->value)){?>hide<?php }elseif((!$_smarty_tpl->tpl_vars['is_self']->value&&$_smarty_tpl->tpl_vars['key']->value>4&&count($_smarty_tpl->tpl_vars['user_app_list']->value['nomove']))){?>hide<?php }elseif((!$_smarty_tpl->tpl_vars['is_self']->value&&$_smarty_tpl->tpl_vars['key']->value>5&&!count($_smarty_tpl->tpl_vars['user_app_list']->value['nomove']))){?>hide<?php }?>">
									<input type="hidden" name="objInfo" value="" />
									<input type="hidden" name="objId" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_id'];?>
" />
									<span class="tab">
										<div class="imgLinkLiImg tip" url="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
">
											<div class="whiteborder">
												<div class="contentwrapper">
													<?php if (isset($_smarty_tpl->tpl_vars['val']->value['cover'])&&count($_smarty_tpl->tpl_vars['val']->value['cover'])>0){?>
														<?php if ((is_array($_smarty_tpl->tpl_vars['val']->value['cover']))){?>
														<div class="<?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>canmove<?php }?>" url="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
<?php if (($_smarty_tpl->tpl_vars['val']->value['menu_id']==5&&!$_smarty_tpl->tpl_vars['is_self']->value)){?>&m=friendlist<?php }?>">
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value['cover']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
														<a href="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
"><img class="fans img" src="<?php if (isset($_smarty_tpl->tpl_vars['v']->value['ico'])){?><?php echo $_smarty_tpl->tpl_vars['v']->value['ico'];?>
<?php }?>" alt="<?php if (isset($_smarty_tpl->tpl_vars['v']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
<?php }?>"onerror="this.src='<?php echo @MISC_ROOT;?>
img/default/avatar_ss.gif'"></a>
														<?php } ?>
														</div>
														<?php }?>
													<?php }else{ ?>
														<div class="tip <?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>canmove<?php }?>" hovercard="001" url="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
<?php if (($_smarty_tpl->tpl_vars['val']->value['menu_id']==5&&!$_smarty_tpl->tpl_vars['is_self']->value)){?>&m=friendlist<?php }?>"><img class="<?php if ($_smarty_tpl->tpl_vars['val']->value['menu_id']==10){?>main_event<?php }?>" src="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_ico'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_title'];?>
"></div>
													<?php }?>
												</div>
											</div>
										</div>
										
										<?php if ($_smarty_tpl->tpl_vars['is_self']->value){?>
										<div class="dropWrap dropMenu listPermission" oid="<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_id'];?>
" s="<?php if (isset($_smarty_tpl->tpl_vars['val']->value['weight'])&&$_smarty_tpl->tpl_vars['val']->value['weight']!=''){?><?php echo $_smarty_tpl->tpl_vars['val']->value['weight'];?>
<?php }else{ ?>1<?php }?>" uid="<?php if (isset($_smarty_tpl->tpl_vars['val']->value['userlist_content'])){?><?php echo $_smarty_tpl->tpl_vars['val']->value['userlist_content'];?>
<?php }?>"><?php if ($_smarty_tpl->tpl_vars['val']->value['menu_id']==11){?><div class="permissionMisk"></div><?php }?></div>
										<?php }?>
										<span class="imgLinkLiText"> <a href="<?php echo @WEB_ROOT;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['menu_url'];?>
<?php if (($_smarty_tpl->tpl_vars['val']->value['menu_id']==5&&!$_smarty_tpl->tpl_vars['is_self']->value)){?>&m=friendlist<?php }?>"><?php echo $_smarty_tpl->tpl_vars['val']->value['menu_title'];?>
</a><span class="gray <?php if ($_smarty_tpl->tpl_vars['val']->value['menu_id']==6){?>main_album<?php }?><?php if ($_smarty_tpl->tpl_vars['val']->value['menu_id']==7){?>main_video<?php }?><?php if ($_smarty_tpl->tpl_vars['val']->value['menu_id']==10){?>main_event<?php }?>"><?php if ($_smarty_tpl->tpl_vars['val']->value['nums']){?><?php echo $_smarty_tpl->tpl_vars['val']->value['nums'];?>
<?php }?></span></span>
									</span>
								</li>
								<?php }?>
								<?php } ?>
								<?php }?>
							</ul>
						</ul>
					</ul>
				</div>
				<?php if ((count($_smarty_tpl->tpl_vars['user_app_list']->value['nomove'])>0||count($_smarty_tpl->tpl_vars['user_app_list']->value['move'])>0)){?>
				<div class="menuRight">
					<div class="hideImgLinkBtn">
						<a id="seemore" href="javascript:void(0);" > <span class="linkClickSpan"><span class="text"><?php if ((intval((count($_smarty_tpl->tpl_vars['user_app_list']->value['nomove'])+count($_smarty_tpl->tpl_vars['user_app_list']->value['move']))-6)>0)){?><?php echo intval((count($_smarty_tpl->tpl_vars['user_app_list']->value['nomove'])+count($_smarty_tpl->tpl_vars['user_app_list']->value['move']))-6);?>
<?php }else{ ?>0<?php }?></span></span> </a>
					</div>
				</div>
				<?php }?>
			</div>
		</div>
		<!--/时间线按钮-->
	</div>
	<!--/内容区头部导航-->
</div>
<!--/时间线首页内容区头部-->
<?php }} ?>
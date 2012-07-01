<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 11:48:14
         compiled from "/home/web/www/new_duankou/main/application/views/timeline/postBox.html" */ ?>
<?php /*%%SmartyHeaderCode:8980879204fc83b7e78ec76-73959970%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed4f59d4dc9c2d1d1af9a3c8d05e0c40e952ba87' => 
    array (
      0 => '/home/web/www/new_duankou/main/application/views/timeline/postBox.html',
      1 => 1337942510,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8980879204fc83b7e78ec76-73959970',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login_info' => 0,
    'video_upload_url' => 0,
    'authcode_url' => 0,
    'videoname' => 0,
    'recordurl' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83b7e7f67c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83b7e7f67c')) {function content_4fc83b7e7f67c($_smarty_tpl) {?><!-- start: streamComposer 信息发布框开始-->
<div class="streamComposer">
	<div id="distributeInfoBody">
		<input type="hidden" id="currentComposerAttachment" value="0" />
		<div class="showWhenLoading"></div>
		<ul class="composerAttachments clearfix">
			<li class="s_msg act "  ref="0" ><span><i class="uiIconP icons3 bp_currentState"></i>状态</span></li>
			<li class="s_photo" ref="1" ><span><i class="uiIconP icons1 bp_photo"></i>照片</span></li>
			<li class="s_video" ref="2" ><span><i class="uiIconP icons1 bp_video"></i>视频</span></li>
			<li class="s_life hide" ref="3" ><span><i class="uiIconP icons1 bp_life"></i>人生记事</span></li>
		</ul>
		<div class="pointUp"></div>
		<div class="distributeInfoBox">
			<!-- start: distributeMsg 发表状态开始-->
			<div id="distributeMsg" class="distributeInfo txtArea" style="display:block">
				<textarea id="myStatusTextArea" class="shareInfoCont  msg" msg="写点什么吧" tmaxLength="140" isNull = 0></textarea>
				<!-- start: distributeLinked 发表链接开始-->
				
				<!-- end: distributeLinked 发表链接结束--> 
			</div>
			<!-- end: distributeMsg 状态结束--> 
			<!-- start: distributePhoto 发表照片开始-->
			<div class="distributeInfo" id="distributePhoto">
				<div class="distributeBox">
					<div id="photoUploadWay">
						<div class="clearfix">
							<div class="partChoice">
								<a href="javascript:void(0)" class="choiceButton" id="upoadPhotoFromLocal">
									<span class="choiceButtonText">上传照片</span>
									<span class="detailIntro">从硬盘</span>
								</a>
							</div>
							<div class="partChoice">
								<a class="choiceButton" href="javascript:void(0)" id="snapshotPhoto">
									<span class="choiceButtonText">拍照</span>
									<span class="detailIntro">用网络摄像头</span>
								</a>
							</div>
						</div>
					</div>
					<div class="fileOption" id="photoFileOption" style="display: none;">						
							<input type="hidden" name="type" value="3" />
							<input type="hidden" name="photo" />
							<div id="uploadPhotoPanel" style="display: none;">
								<div class="uploadButtonCont" id="flashuploaduid" flashuploaduid="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['uid'];?>
">
								<p style="float:left;"><input type="file" name="uploadPhotoFile" id="uploadPhotoButton">
								</p>
								<p>  <div style="margin:10px 0 0 5px;">从你的电脑中选择一个图像文件 </div></p>
								</div>
								<p class="hide" id="up_photo_success"><span>上传成功！</span>
                                </p>
                                <div id="photo_queueID"></div>								
							</div>
						<div style="postion:relative;" class="txtArea">
							<textarea msg="给这张照片做些说明吧" name="message" class="distributeAttachIntro fieldWithText msg" id="attachPhotoIntroduce" tmaxLength="140"></textarea>
						</div>
					</div>
					
					<div class="fileOption" id="snapshotPhotoFileOption" style="position: relative;">
						<div style="postion:relative;" class="txtArea">
							<textarea msg="给这张照片做些说明吧" name="message" class="distributeAttachIntro fieldWithText msg" id="attachCameraPhotoIntroduce" tmaxLength="140" style="color: rgb(153, 153, 153);"></textarea>
						</div>
						<div id="campz"></div>
					</div>
				</div>
			</div>
			<!-- end: distributePhoto 发表照片结束-->
			<!-- start: distributeVideo 发表视频开始-->
			<div id="distributeVideo" class="distributeInfo hide">
				<div class="distributeBox">
					<div id="videoUploadWay">
						<div class="clearfix">
							<div class="partChoice"> <a id="recordVideo" href="javascript:void(0)" class="choiceButton"> <span class="choiceButtonText">录制影片</span> <span class="detailIntro">用网路摄像头</span> </a> </div>
							<div class="partChoice"> <a id="upoadVideoFromLocal" href="javascript:void(0)" class="choiceButton"> <span class="choiceButtonText">上传视频</span> <span class="detailIntro">从硬盘</span> </a> </div>
						</div>
					</div>
					<div id="videoFileOption" class="fileOption">
                    	<input id="videoId" type="hidden" name="vid" value="">
						<input type="hidden" id="hd_video_upload_url" value="<?php echo $_smarty_tpl->tpl_vars['video_upload_url']->value;?>
"  />
						<input type="hidden" id="hd_url" value="<?php echo $_smarty_tpl->tpl_vars['authcode_url']->value;?>
"  />
						<input id="uploadDoVideoPost" type="hidden" value="/app/modules/home/views/wangxd--upload_video.php" />
						<input id="uploadedVideoId" type="hidden" value="" name="uploadedVideoId" />
						<input id="videoname" type="hidden" name="videoname" value="<?php echo $_smarty_tpl->tpl_vars['videoname']->value;?>
"/>
						<input id="recordurl" type="hidden" name="recordurl" value="<?php echo $_smarty_tpl->tpl_vars['recordurl']->value;?>
"/>
						<div id="uploadVideoFlashWrap">
							<div id="uploadVideoFlash">
                                <div class="flashContent"><p>
                                <input type="file" id="uploadify" name="uploadify"><div style="margin:10px 0 0 5px;">从你的电脑中选择一个视频文件</div>
                                </p>
                                </div>                                
                                <p class="hide" id="up_success"><span>上传成功！</span><a href="javascript:void(0)">重新上传</a>
                                </p>
                                <div id="videoQueueID"></div>
                            </div>
						</div>
						<div id="recordVideoPanel" style="display:none;">
							<input type="hidden" name="hd_v_w" id="hd_v_w"/>
							<input type="hidden" name="hd_v_h" id="hd_v_h"/>							
							<input type="hidden" name="hd_v_name" id="hd_v_name"/>
							<div id="camRecord"></div>
						</div>
						<div class="txtArea"><textarea id="attachVideoIntroduce" class="distributeAttachIntro fieldWithText msg" name="attachVideoIntroduce" msg="给这段视频做些描述吧" tmaxLength="140"></textarea>
                        <div class="hide" id="noCam">
							<h3>没有发现摄像头</h3>
							<p>没有在系统中检测到可用的摄像头，请连接摄像头后再试一次。</p>
							<p> <input type="button" class="blackBtn" value="刷新页面" id="btn_Refresh"/> </p>
						</div>
                        </div>
					</div>
				</div>
			</div>
			<!-- end: distributeVideo 发表视频结束-->
			<!-- start: distributeVideo 人生记事-->
			<div id="distributeLife" class="distributeInfo hide">
				<div class="distributeBox">
					<p style="padding:5px; color:#999;">人生记事开发中。。。</p>
				</div>
			</div>
			<!-- end: distributeVideo 人生记事-->
			<!-- start: footer -->
			<div class="footer"> 
				
				<div class="timelineDate"><input id="date_a" type="text" class="html_date" name="datetime" now="<?php echo date('Y-n-j');?>
" value="<?php echo date('Y-n-j');?>
" end_year="<?php echo date('Y-n-j');?>
" 
					begin_year="<?php if ((!empty($_smarty_tpl->tpl_vars['user']->value['birthday']))){?> <?php echo date('Y-n-j',$_smarty_tpl->tpl_vars['user']->value['birthday']);?>
<?php }else{ ?>1900-1-1<?php }?>" /></div>
				<!-- start: shareDestination 选择分享对象 -->
				
				<div class="shareIt">
					<div id="shareDestinationObjects" class="uiComboxHeaderGray">
						<div id="shareRights" oid="123" s="1" uid="" class="dropWrap dropMenu tip_up_right_black"  tip="公开">
							<input type="hidden" name="permission" value="1" />
						</div>
					</div>
					<!-- end: shareDestination 选择分享对象 -->
					<input type="hidden" value="<?php echo @WEB_ROOT;?>
single/album/?c=api&m=camera" id="camUrl" />
					<label class="uiButton uiButtonConfirm"><input type="button" id="distributeButton" value="发表" autocomplete="off" /></label>
				</div>
			</div>
			<!-- end: footer -->
		</div>
	</div>
</div>
<!-- end: streamComposer 信息发布框结束--><?php }} ?>
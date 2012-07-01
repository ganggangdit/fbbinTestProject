<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 11:51:44
         compiled from "application/views/timeline/upload_protrait.html" */ ?>
<?php /*%%SmartyHeaderCode:18276282684fc83c50507462-79591364%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07aa85f209e0ecd2d562fee890981829db63013a' => 
    array (
      0 => 'application/views/timeline/upload_protrait.html',
      1 => 1338463448,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18276282684fc83c50507462-79591364',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'avatar50' => 0,
    'username' => 0,
    'url' => 0,
    'avatar_upload' => 0,
    'js_css_v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83c5063cce',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83c5063cce')) {function content_4fc83c5063cce($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="<?php echo @MISC_ROOT;?>
css/common/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @MISC_ROOT;?>
css/reg/reg.css" rel="stylesheet" type="text/css" />
<body>
<?php echo $_smarty_tpl->getSubTemplate ("../top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<div class="body clearfix">
	<div class="mainArea">
		<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo @WEB_ROOT;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['avatar50']->value;?>
" alt=""  /></a></span>
			<div class="userName" id="userName">
				<span class="nameTxt"><a href="<?php echo @WEB_ROOT;?>
"><?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</a></span>
				<span class="nameTxt">
					<span class="fl"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">头像设置</a></span>
				</span>
			</div>
		</div>
<!-- start: regBody 注册区域主体开始 -->
		<div class="modlueBody">
			<div class="regCont">
				<h3>个人头像设定</h3>
				<div class="uploadHeader">
					<div class="uploadHeaderTop">
						<form enctype="multipart/form-data" method="post" name="upform" target="upload_target" action="<?php echo $_smarty_tpl->tpl_vars['avatar_upload']->value;?>
">
							<div id="vessel">
								<input class="hidden" type="file" name="Filedata" id="Filedata" />
								<input class="browse" id="relatedEInput" type="text"/>
								<a class="uploadBtn">浏览···</a>
							</div>
							<input type="hidden" name="switch" value='1' />
							<a onClick="checkFile();"class="mt5">本地上传 | </a><a class="mt5" id="usecamera" onClick="useCamera()">现拍图片</a>
							<span style="visibility:hidden;" id="loading_gif"><img src="<?php echo @MISC_ROOT;?>
img/system/loading.gif" align="absmiddle" />上传中，请稍侯......</span>
						</form>
					</div>
				</div>
				<iframe src="about:blank" name="upload_target" class="hide"></iframe>
				<div id="avatar_editor"></div>
			</div>
		</div>
<!-- end: regBody 注册区域主体结束 -->
	</div>

</div>
<script src="<?php echo @MISC_ROOT;?>
js/jquery.min.js?v=<?php echo @JS_VER;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/swfobject/AC_RunActiveContent.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>


<script type="text/javascript">
	//允许上传的图片类型
	var extensions = 'jpg,jpeg,gif,png';
	//保存缩略图的地址.
	var saveUrl = '<?php echo @WEB_ROOT;?>
main/index.php?c=avatar&m=avatar_save';
	//保存摄象头白摄图片的地址.
	var cameraPostUrl = '<?php echo @WEB_ROOT;?>
main/index.php?c=avatar&m=avatar_camera_save';
	//头像编辑器flash的地址.
	var editorFlaPath = '<?php echo @MISC_ROOT;?>
flash/avatarEditor.swf';
	//首页地址
	var mainRoot = '<?php echo @WEB_ROOT;?>
';
	window.hideLoading = function(){
		document.getElementById('loading_gif').style.visibility = 'hidden';
	}
	function useCamera(){
		/*var content = '<embed height="464" width="514" ';
		content +='flashvars="type=camera';
		content +='&postUrl='+encodeURIComponent(cameraPostUrl)+'&radom=1';
		content +='&redirect_url='+encodeURIComponent(mainRoot);
		content += '&saveUrl='+encodeURIComponent(saveUrl)+'&radom=1" ';
		content +='pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" ';
		content +='allowscriptaccess="always" quality="high" ';
		content +='wmode="transparent"';
		content +='src="'+editorFlaPath+'"/>';
		document.getElementById('avatar_editor').innerHTML = content;*/
		
		
		runac.AC_FL_RunContent(
			'appendTo', 'avatar_editor',
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'id','avatar',
			'width', '514',
			'height', '464',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'wmode', 'transparent',
			'allowScriptAccess','always',
			'movie', editorFlaPath.replace(/\.swf$/ig,""),
			'Flashvars','type=camera&postUrl='+encodeURIComponent(cameraPostUrl)+'&redirect_url='+encodeURIComponent(mainRoot)+'&radom=1&saveUrl='+encodeURIComponent(saveUrl)+'&radom=1',
			'style','display:block;'
		); //end AC code
	}
	
	function buildAvatarEditor(pic_id,pic_path,post_type){
		/*var content = '<embed height="464" width="514"'; 
		content+='flashvars="type='+encodeURIComponent(post_type);
		content+='&photoUrl='+encodeURIComponent(pic_path);
		content +='&redirect_url='+encodeURIComponent(mainRoot);
		content+='&photoId='+encodeURIComponent(pic_id);
		content+='&postUrl='+encodeURIComponent(cameraPostUrl);
		content+='&saveUrl='+encodeURIComponent(saveUrl)+'"';
		content+=' pluginspage="http://www.macromedia.com/go/getflashplayer"';
		content+=' type="application/x-shockwave-flash"';
		content +='wmode="transparent"';
		content+=' allowscriptaccess="always" quality="high" src="'+editorFlaPath+'"/>';
		document.getElementById('avatar_editor').innerHTML = content;*/
		
		runac.AC_FL_RunContent(
			'appendTo', 'avatar_editor',
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'id','avatar',
			'width', '514',
			'height', '464',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'wmode', 'transparent',
			'allowScriptAccess','always',
			'movie', editorFlaPath.replace(/\.swf$/ig,""),
			'Flashvars','type='+encodeURIComponent(post_type)+'&photoUrl='+encodeURIComponent(pic_path)+'&redirect_url='+encodeURIComponent(mainRoot)+'&photoId='+encodeURIComponent(pic_id)+'&postUrl='+encodeURIComponent(cameraPostUrl)+'&saveUrl='+encodeURIComponent(saveUrl),
			'style','display:block;'
		); //end AC code
	}
	
	
	
	
	/**
	  * 提供给FLASH的接口 ： 没有摄像头时的回调方法
	  */
	function noCamera(){
		alert("你没有摄像头");
	}
			
	/**
	 * 提供给FLASH的接口：编辑头像保存成功后的回调方法
	 */
	function avatarSaved(){
		//alert('头像保存成功，请继续填写个人资料');
		window.location.href = '<?php echo @WEB_ROOT;?>
'+'main/index.php';
	}
	
	/**
	  * 提供给FLASH的接口：编辑头像保存失败的回调方法, msg 是失败信息，可以不返回给用户, 仅作调试使用.
	  */
	function avatarError(msg){
		alert(msg);
		//alert("上传失败,请重试");
	}

	function checkFile(){
		var path = document.getElementById('Filedata').value;
		var ext = getExt(path);
		var re = new RegExp("(^|\\s|,)" + ext + "($|\\s|,)", "ig");
		if(extensions != '' && (re.exec(extensions) == null || ext == '')) {
			$.alert('对不起，只能上传jpg, gif, png,jpeg类型的图片');
			return false;
		}
		showLoading();
		document.upform.submit();
	}

	function getExt(path){
		return path.lastIndexOf('.') == -1 ? '' : path.substr(path.lastIndexOf('.') + 1, path.length).toLowerCase();
	}
	function showLoading(){
		document.getElementById('loading_gif').style.visibility = 'visible';
	}
	
	//模拟input：file控件
	function initFileUploads(){
		var Filedata = document.getElementById('Filedata');
		Filedata.relatedElement = document.getElementById('relatedEInput');
		Filedata.onchange = Filedata.onmouseout = function(){
			this.relatedElement.value = this.value;
			this.blur();
		}
	}
	initFileUploads();
</script>

<?php echo $_smarty_tpl->getSubTemplate ((@TEMPLATE_PATH)."footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 12:29:23
         compiled from "application/views/edit/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:2188344074fc84523daddf2-00355051%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c402e052077376ccff3d2ba9a68a918d65c74d7e' => 
    array (
      0 => 'application/views/edit/edit.html',
      1 => 1338366718,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2188344074fc84523daddf2-00355051',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link_url' => 0,
    'datas' => 0,
    's' => 0,
    'j' => 0,
    'i' => 0,
    'type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc84524cb495',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc84524cb495')) {function content_4fc84524cb495($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ((@APP_ROOT)."views/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!--start:资料编辑专用样式-->
<link href="<?php echo @MISC_ROOT;?>
css/userwiki/style_userwiki.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo @MISC_ROOT;?>
css/plug-css/tip/jquery.tip.css" rel="stylesheet" type="text/css" media="screen,projection" />
<!--end:资料编辑专用样式-->
</head>
<body>
        <?php echo $_smarty_tpl->getSubTemplate ((@APP_ROOT)."views/top_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<div class="body clearfix">
		<div class="mainArea">
			<div class="modlueHeader clearfix">
			<span class="userImg"><a href="<?php echo $_smarty_tpl->tpl_vars['link_url']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['datas']->value['image'];?>
" alt="" /></a></span>
				<div class="userName">
					<span class="nameTxt"><a href="<?php echo $_smarty_tpl->tpl_vars['link_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_name'];?>
</a></span>
					<span class="nameTxt"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>编辑资料<?php }else{ ?>查看资料<?php }?></span>
					
					
				</div>
			</div>
			<div class="modlueBody">
				<div id="wikicontentWrap" class="clearfix timelinewiki wikicontentWrap">
					<div id="timelinewikiL" class="fl">
						<!--start:教育情况-->
						<div class="dkUserwikiSection mtm" id="schoolInfo">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['edu']['object_content'])){?>
									<div type="edu" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['edu']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['edu']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4 block="education">教育情况</h4>
							</div>
                        <?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['edu']==1){?>
							<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['edu']['university'])||isset($_smarty_tpl->tpl_vars['datas']->value['edu']['primaryschool'])||isset($_smarty_tpl->tpl_vars['datas']->value['edu']['highschool'])){?>
							<ul class="uiList">
								<li>
									<div>
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><input type="text" class="custom " default="您在哪儿念的大学？" value="您在哪儿念的大学？" id="college"><?php }?>
									</div>
									
									<ul id="collegeList" block="university">
										<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['edu']['university'])){?>
										<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['edu']['university']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
										<li type="0" tid="<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['s']->value['schoolid'];?>
" class="uiListItem" pid="<?php echo $_smarty_tpl->tpl_vars['s']->value['area_id'];?>
">
											<div class="clearfix pds">
												<a class="dkSchImageBlock"><img width="50" height="50" src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon2.png"></a>
												<div class="dkContentBlock">
													<h5 class="itemHead"><span name="school_name"><?php echo $_smarty_tpl->tpl_vars['s']->value['schoolname'];?>
</span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?> <i class="dkUserwikiEditIcon mls"></i>   <span class="ui_closeBtn_box"><i class="ui_closeBtn png" style="display: none; background-position: 0px 0px;"></i></span><?php }?></h5>
													<div>
														<span class="weak_txt"><span name="school_department"><?php echo $_smarty_tpl->tpl_vars['s']->value['department'];?>
</span></span>
														<span class="weak_txt"><span name="school_year" key="<?php echo $_smarty_tpl->tpl_vars['s']->value['department'];?>
"><?php echo date('Y',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
</span>年<span name="school_month" key="<?php echo date('m',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
"><?php echo date('m',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
</span>月入学(<span key="<?php echo $_smarty_tpl->tpl_vars['s']->value['edulevel'];?>
" name="eduCation_c"><?php echo returnInfomation('school','univeristy_level',$_smarty_tpl->tpl_vars['s']->value['edulevel']);?>
</span>)</span>
														<span class="weak_txt">同班同学名字：<span name="classmate"><?php if (isset($_smarty_tpl->tpl_vars['s']->value['classmate'])){?><?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['j']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['s']->value['classmate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
$_smarty_tpl->tpl_vars['j']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['j']->value){?><?php echo $_smarty_tpl->tpl_vars['j']->value;?>
<?php }?><?php } ?><?php }?></span></span>
													</div>
												</div>
											</div>
										</li>
										<?php } ?>
										 <?php }?>
									</ul>
                                  
								</li>
								<li>
									<div>
										<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>	<input type="text" class="custom" default="您在哪儿念的中学？" value="您在哪儿念的中学？" id="highSchool"><?php }?>
									</div>
									
									<ul id="midSchoolList" block="highSchool">
										<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['edu']['highschool'])){?>
										<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['edu']['highschool']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
										<li type="1" class="uiListItem" tid="<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['s']->value['schoolid'];?>
">
											<div class="clearfix pds">
												<a class="dkSchImageBlock"><img width="50" height="50" src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon2.png"></a>
												<div class="dkContentBlock">
													<h5 class="itemHead"><span name="school_name"><?php echo $_smarty_tpl->tpl_vars['s']->value['schoolname'];?>
</span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?> <i class="dkUserwikiEditIcon mls"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png" style="display: none;"></i></span><?php }?></h5>
													<div>
														<span class="weak_txt"><span name="school_year" key="<?php echo $_smarty_tpl->tpl_vars['s']->value['starttime'];?>
"><?php echo date('Y',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
</span>年<span name="school_month" key="<?php echo date('m',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
"><?php echo date('m',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
</span>月入学(<span key="<?php echo $_smarty_tpl->tpl_vars['s']->value['edulevel'];?>
" name="eduCation_m"><?php echo returnInfomation('school','heighschool_level',$_smarty_tpl->tpl_vars['s']->value['edulevel']);?>
</span>)</span>
														<span class="weak_txt">同班同学名字：<span name="classmate"><?php if (isset($_smarty_tpl->tpl_vars['s']->value['classmate'])){?><?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['j']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['s']->value['classmate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
$_smarty_tpl->tpl_vars['j']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['j']->value){?><?php echo $_smarty_tpl->tpl_vars['j']->value;?>
<?php }?><?php } ?><?php }?></span></span>
													</div>
												</div>
											</div>
										</li>
										<?php } ?>
										<?php }?> 
									</ul>
									   
								</li>
								<li>
									<div>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><input type="text" class="custom" default="您在哪儿念的小学？" value="您在哪儿念的小学？" id="primarySchool"><?php }?>
									</div>
									
									<ul id="gradeSchoolList" block="primarySchool">
										<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['edu']['primaryschool'])){?>
										<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['edu']['primaryschool']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
										<li type="2" tid="<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
" class="uiListItem" id="<?php echo $_smarty_tpl->tpl_vars['s']->value['schoolid'];?>
">
											<div class="clearfix pds">
												<a class="dkSchImageBlock"><img width="50" height="50" src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon2.png"></a>
												<div class="dkContentBlock">
													<h5 class="itemHead"><span name="school_name"><?php echo $_smarty_tpl->tpl_vars['s']->value['schoolname'];?>
</span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?> <i class="dkUserwikiEditIcon mls"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png" style="display: none;"></i></span><?php }?></h5>
													<div>
														<span class="weak_txt"><span name="school_year" key="<?php echo $_smarty_tpl->tpl_vars['s']->value['starttime'];?>
"><?php echo date('Y',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
</span>年<span name="school_month" key="<?php echo date('m',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
"><?php echo date('m',$_smarty_tpl->tpl_vars['s']->value['starttime']);?>
</span>月入学(<span key="<?php echo $_smarty_tpl->tpl_vars['s']->value['edulevel'];?>
" name="eduCation_m"><?php echo returnInfomation('school','primaryschool',$_smarty_tpl->tpl_vars['s']->value['edulevel']);?>
</span>)</span>
														<span class="weak_txt">同班同学名字：<span name="classmate"><?php if (isset($_smarty_tpl->tpl_vars['s']->value['classmate'])){?><?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['j']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['s']->value['classmate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
$_smarty_tpl->tpl_vars['j']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['j']->value){?><?php echo $_smarty_tpl->tpl_vars['j']->value;?>
<?php }?><?php } ?><?php }?></span></span>
													</div>
												</div>
											</div>
										</li>
										<?php } ?>
										<?php }?>
									</ul>
									
								</li>
							</ul>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<ul class="uiList">
								<li>
									<div>
										<input type="text" class="custom " default="您在哪儿念的大学？" value="您在哪儿念的大学？" id="college" />
									</div>
									<ul id="collegeList" block="university"></ul>
								</li>
								<li>
									<div>
										<input type="text" class="custom" default="您在哪儿念的中学？" value="您在哪儿念的中学？" id="highSchool" />
									</div>
									<ul id="midSchoolList" block="highSchool"></ul>
								</li>
								<li>
									<div>
										<input type="text" class="custom" default="您在哪儿念的小学？" value="您在哪儿念的小学？" id="primarySchool" />
									</div>
									<ul id="gradeSchoolList" block="primarySchool"></ul>
								</li>
							</ul>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:教育情况-->

						<!--start:工作情况-->
                        <div id="jobInfo" class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['job']['object_content'])){?>
									<div type="job" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['job']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['job']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4 block="education">工作情况</h4>
							</div>
                        <?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['job']==1){?>
							<?php if (!empty($_smarty_tpl->tpl_vars['datas']->value['work'])){?>
							<ul class="uiList" block="job">
								<li>
									<div>
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><input type="text" class="custom " default="您曾经在哪儿就职？" value="您曾经在哪儿就职？" id="company"><?php }?>
									</div>
									<ul id="jobList" block="job">
                                        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['work']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
										<li id="44" tid="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" class="uiListItem" id="<?php echo $_smarty_tpl->tpl_vars['i']->value['companyid'];?>
">
											<div class="clearfix pds">
												<a class="dkSchImageBlock"><img width="50" height="50" src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon1.png"></a>
												<div class="dkContentBlock">
													<h5 class="itemHead"><span name="company"><?php echo $_smarty_tpl->tpl_vars['i']->value['company'];?>
</span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon mls"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png" style="display: none;"></i></span><?php }?></h5>
													<div>
														<span class="weak_txt"><span name="time_y_s" key="<?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>年<span name="time_m_s" key="<?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>月&mdash;&mdash;<?php if ($_smarty_tpl->tpl_vars['i']->value['endtime']!=0){?><span key="<?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
" name="time_y_e"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span> 年<span key="<?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
" name="time_m_e"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span>月<?php }else{ ?><span name="today">至今</span><?php }?></span>
														<span class="weak_txt"><span key="<?php echo $_smarty_tpl->tpl_vars['i']->value['trade'];?>
" name="industry"><?php echo returnInfomation('info','company_trade',$_smarty_tpl->tpl_vars['i']->value['trade']);?>
</span> <span name="position"><?php echo $_smarty_tpl->tpl_vars['i']->value['department'];?>
</span></span>
														<span class="weak_txt">同事名字：<span name="colleague"><?php if (isset($_smarty_tpl->tpl_vars['i']->value['workmate'])){?><?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['j']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['i']->value['workmate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
$_smarty_tpl->tpl_vars['j']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['j']->value){?><?php echo $_smarty_tpl->tpl_vars['j']->value;?>
<?php }?><?php } ?><?php }?></span></span>
													</div>
												</div>
											</div>
										</li>
                                    <?php } ?>                           
									</ul>
								</li>
							</ul>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<ul class="uiList" block="job">
								<li>
									<div>
										<input type="text" class="custom " default="您曾经在哪儿就职？" value="您曾经在哪儿就职？" id="company">
									</div>
									<ul id="jobList" block="job"></ul>
								</li>
							</ul>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						   <?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:工作情况-->
						
						<!--start:在校情况-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['school']['object_content'])){?>
									<div type="school" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['school']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['school']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4 block="education">在校情况<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i id="addAtschool" class="dkUserwikiEditIcon ml5 dkUserwikiSchoolInfo"></i><?php }?></h4>
							</div>
                        <?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['school']==1){?>
                            <?php if (!empty($_smarty_tpl->tpl_vars['datas']->value['atschool'])){?>
							<div class="clearfix uiList">
								<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon9.png" width="50" height="50" /></a>
								<div class="fl dkContentBlock">
									<ul id="schoolList" block="atSchool">
										 <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['atschool']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
										
										 <?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value['type'], null, 0);?>
										 <?php $_smarty_tpl->createLocalArrayVariable('i', null, 0);
$_smarty_tpl->tpl_vars['i']->value['type'] = returnInfomation('user','at_school_type',$_smarty_tpl->tpl_vars['type']->value);?>
										<li class="uiListItem" id="school_<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
">
											<h5 class="itemHead name"><?php echo $_smarty_tpl->tpl_vars['i']->value['type'];?>
<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon mls dkUserwikiSchoolInfo" topic="<?php if ($_smarty_tpl->tpl_vars['type']->value==3){?>duty<?php }elseif($_smarty_tpl->tpl_vars['type']->value==1){?>scholarship<?php }elseif($_smarty_tpl->tpl_vars['type']->value==2){?>award<?php }else{ ?>society<?php }?>"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png"></i></span><?php }?></h5>
											<div>
                                                                                            <?php if ($_smarty_tpl->tpl_vars['type']->value==3){?>
												<span class="weak_txt"><span class="time_y_s"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>年<span class="time_m_s"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>月——<span class="time_y_e"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span> 年<span class="time_m_e"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span>月</span>
												<span class="weak_txt"><span class="content2"><?php echo $_smarty_tpl->tpl_vars['i']->value['title'];?>
</span></span>
                                                                                            <?php }elseif($_smarty_tpl->tpl_vars['type']->value==1){?>
                                                                                                <span class="weak_txt"><span class="time_y"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>年<span class="time_m"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span> 月</span>
                                                                                                <span class="weak_txt"><span class="content0"><?php echo returnInfomation('user','at_school_scholarship',$_smarty_tpl->tpl_vars['i']->value['level']);?>
</span> <span class="content1"><?php echo returnInfomation('user','at_school_scholarship_rank',$_smarty_tpl->tpl_vars['i']->value['level2']);?>
</span></span>
                                                                                            <?php }elseif($_smarty_tpl->tpl_vars['type']->value==2){?>
                                                                                                <span class="weak_txt"><span class="time_y"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span> 年<span class="time_m"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span> 月</span>
												<span class="weak_txt"><span class="content2"><?php echo $_smarty_tpl->tpl_vars['i']->value['title'];?>
</span> 【<span class="level"><?php echo returnInfomation('user','at_school_level',$_smarty_tpl->tpl_vars['i']->value['level']);?>
</span>】</span>
                                                                                            <?php }elseif($_smarty_tpl->tpl_vars['type']->value==4){?>
                                                                                                <span class="weak_txt">于<span class="time_y_s"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>年<span class="time_m_s"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>月——<span class="time_y_e"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span> 年<span class="time_m_e"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span>月</span>
												<span class="weak_txt">内容：<span class="content2"><?php echo $_smarty_tpl->tpl_vars['i']->value['title'];?>
</span></span>
												<span class="weak_txt"><label>实践描述：</label><span class="society breakWord"><?php if (empty($_smarty_tpl->tpl_vars['i']->value['content'])){?>(未填写)<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['i']->value['content'];?>
<?php }?></span></span>
                                                                                            <?php }?>
                                                                                        </div>
										</li>
                                                                              <?php } ?>
									</ul>
								</div>
							</div>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<div class="clearfix uiList">
								<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon9.png" width="50" height="50" /></a>
								<div class="fl dkContentBlock">
									<ul id="schoolList" block="atSchool"></ul>
								</div>
							</div>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:在校情况-->
						
						
						<!--start:培训经历-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['teach']['object_content'])){?>
									<div type="teach" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['teach']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['teach']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4 block="teach">培训经历<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i id="addTrain" class="dkUserwikiEditIcon ml5 dkUserwikiTrainExperInfo"></i><?php }?></h4>
							</div>
                        <?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['teach']==1){?>
							<?php if (!empty($_smarty_tpl->tpl_vars['datas']->value['teach'])){?>
							<ul class="uiList" id="trainexperList">
                                <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['teach']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
								<li class="uiListItem" id="teach_<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
">
									<div class="clearfix pds">
										<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon3.png" width="50" height="50" /></a>
										<div class="dkContentBlock">
											<h5 class="itemHead"><span class="name"><?php echo $_smarty_tpl->tpl_vars['i']->value['subject'];?>
</span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon mls dkUserwikiTrainExperInfo"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png"></i></span><?php }?></h5>
											<div>
												<span class="weak_txt"><span class="time_y_s"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>年<span class="time_m_s"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>月——<span class="time_y_e"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span>年<span class="time_m_e"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span>月</span>
												<span class="weak_txt">培训机构：<span class="org"><?php echo $_smarty_tpl->tpl_vars['i']->value['provider'];?>
</span></span>
												<span class="weak_txt">培训地点：<span class="address"><?php echo $_smarty_tpl->tpl_vars['i']->value['address'];?>
</span></span>	
												<span class="weak_txt">获得证书：<span class="certi"><?php echo $_smarty_tpl->tpl_vars['i']->value['certificate'];?>
</span></span>
												<span class="weak_txt"><label>培训描述：</label><span class="desc  breakWord"><?php echo $_smarty_tpl->tpl_vars['i']->value['description'];?>
</span></span>
											</div>
										</div>
									</div>
								</li>
                                <?php } ?>
                            </ul>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<ul class="uiList" id="trainexperList"></ul>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:培训经历-->
						
						<!--start:语言情况-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['language']['object_content'])){?>
									<div type="language" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['language']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['language']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4 block="language">语言情况<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i id="addLan" class="dkUserwikiEditIcon ml5 dkUserwikiLanguageInfo"></i>	<?php }?></h4>
							</div>
                        <?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['language']==1){?>
							<?php if (!empty($_smarty_tpl->tpl_vars['datas']->value['language'])){?>
							<div class="clearfix uiList">
								<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon7.png" width="50" height="50" /></a>
								<div class="fl dkContentBlock">
									
									<ul id="languageList">
                                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['language']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
										<li class="uiListItem" id="language_<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
">
											<h5 class="itemHead name"><?php echo returnInfomation('user','language_type',$_smarty_tpl->tpl_vars['i']->value['type']);?>
<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon mls dkUserwikiLanguageInfo"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png"></i></span><?php }?></h5>
											<div>
												<span class="weak_txt">等级：<span class="grade"><?php echo $_smarty_tpl->tpl_vars['i']->value['level'];?>
</span> 成绩：<span class="mark"><?php if (empty($_smarty_tpl->tpl_vars['i']->value['grade'])){?>(未填写)<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['i']->value['grade'];?>
<?php }?></span></span>
												<span class="weak_txt">读写：<span class="read"><?php echo returnInfomation('user','language_rw',$_smarty_tpl->tpl_vars['i']->value['read']);?>
</span>  听说：<span class="listen"><?php echo returnInfomation('user','language_listen',$_smarty_tpl->tpl_vars['i']->value['listen']);?>
</span></span>
											</div>
										</li>
                                    <?php } ?>
									</ul>
								</div>
							</div>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<div class="clearfix uiList">
								<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon7.png" width="50" height="50" /></a>
								<div class="fl dkContentBlock">
									<ul id="languageList"></ul>
								</div>
							</div>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:语言情况-->
			
						<!--start:专业技能-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['skill']['object_content'])){?>
									<div type="skill" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['skill']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['skill']['object_content']);?>
"></div>
									<?php }?>
								</div>
								
								<h4 block="skill">专业技能<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i id="addSkill" class="dkUserwikiEditIcon ml5 dkUserwikiSkillInfo"></i>	<?php }?></h4>
							</div>
                        <?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['skill']==1){?>
							<?php if (!empty($_smarty_tpl->tpl_vars['datas']->value['skill'])){?>
							<div class="clearfix uiList">
								<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon4.png" width="50" height="50" /></a>
								<div class="fl dkContentBlock">
									<ul id="skillList">
                                        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['skill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
										<li class="uiListItem" id="skill_<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
">
											<h5 class="itemHead"> <span class="headM"><?php echo returnInfomation('user','exper_type',$_smarty_tpl->tpl_vars['i']->value['type']);?>
</span> <span class="headS"><?php if (!empty($_smarty_tpl->tpl_vars['i']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
<?php }?></span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?> <i class="dkUserwikiEditIcon mls dkUserwikiSkillInfo"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png"></i></span><?php }?></h5>
											<div>
												<span class="weak_txt">实践经验: <?php if ($_smarty_tpl->tpl_vars['i']->value['month']==0){?><span class="time_tip">(未填写)</span><?php }else{ ?><span class="time_tip"><?php echo $_smarty_tpl->tpl_vars['i']->value['month'];?>
</span>个月<?php }?> 掌握程度: <span class="deep_tip"><?php echo returnInfomation('user','exper_level',$_smarty_tpl->tpl_vars['i']->value['degree']);?>
</span></span>

											</div>
										</li>
                                        <?php } ?>
									</ul>
								</div>
							</div>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<div class="clearfix uiList">
								<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon4.png" width="50" height="50" /></a>
								<div class="fl dkContentBlock">
									<ul id="skillList"></ul>
								</div>
							</div>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:专业技能-->
                                    
                        <!--start:项目经历-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['project']['object_content'])){?>
									<div type="project" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['project']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['project']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4 block="project">项目经历<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i id="addProject" class="dkUserwikiEditIcon ml5 dkUserwikiProjectExperInfo"></i><?php }?></h4>
							</div>
						<?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['project']==1){?>
                            <?php if (!empty($_smarty_tpl->tpl_vars['datas']->value['project'])){?>
							<ul class="uiList" id="projectexperList">
								<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['project']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
								<li class="uiListItem" id="project_<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
">
									<div class="clearfix pds">
										<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon5.png" width="50" height="50" /></a>
										<div class="dkContentBlock">
											<h5 class="itemHead"><span class="name"><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon mls dkUserwikiProjectExperInfo"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png"></i></span><?php }?></h5>
											<div>
												<span class="weak_txt"><span class="time_y_s"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>年<span class="time_m_s"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>月——<span class="time_y_e"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span>年<span class="time_m_e"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['endtime']);?>
</span>月</span>
												<span class="weak_txt"><label>项目描述：</label><span class="desc breakWord"><?php echo $_smarty_tpl->tpl_vars['i']->value['description'];?>
</span></span>
												<span class="weak_txt"><label>项目职责：</label><span class="duty breakWord"><?php echo $_smarty_tpl->tpl_vars['i']->value['response'];?>
</span></span>
											</div>
										</div>
									</div>
								</li>
								<?php } ?>
							</ul>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<ul class="uiList" id="projectexperList"></ul>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:项目经历-->
						
						
						<!--start:获得证书-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['book']['object_content'])){?>
									<div type="book" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['book']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['book']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4 block="book">获得证书<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i id="addCertificate" class="dkUserwikiEditIcon ml5 dkUserwikiCertificateInfo"></i><?php }?></h4>
							</div>
						<?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['book']==1){?>
                            <?php if (!empty($_smarty_tpl->tpl_vars['datas']->value['book'])){?>
							<ul class="uiList" id="certificateList">
								<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['book']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
								<li class="uiListItem" id="book_<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
">
									<div class="clearfix pds">
										<a class="dkSchImageBlock"><img src="<?php echo @MISC_ROOT;?>
img/system/editPageIcon6.png" width="50" height="50" /></a>
										<div class="dkContentBlock">
											<h5 class="itemHead"><span class="name"><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</span><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon mls dkUserwikiCertificateInfo"></i><span class="ui_closeBtn_box"><i class="ui_closeBtn png"></i></span><?php }?></h5>
											<div>
												<span class="weak_txt c_time">于<span class="time_y"><?php echo date('Y',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>年<span class="time_m"><?php echo date('m',$_smarty_tpl->tpl_vars['i']->value['starttime']);?>
</span>月获得</span>
												<span class="weak_txt c_org">颁发机构：<span class="orgname"><?php echo $_smarty_tpl->tpl_vars['i']->value['provider'];?>
</span></span>
												<span class="weak_txt c_intr"><label>证书说明：</label><span class="intr breakWord"><?php echo $_smarty_tpl->tpl_vars['i']->value['description'];?>
</span> </span>
											</div>
										</div>
									</div>
								</li>
								<?php } ?>
							</ul>
							<?php }else{ ?>
								<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?>
							<ul class="uiList" id="certificateList"></ul>
								<?php }else{ ?>
							<div class="nodata">该用户尚未填写资料</div>
								<?php }?>
                            <?php }?>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:获得证书-->
					</div>
					<div id="timelinewikiR" class="fl">
						<!--start:基本资料-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['base']['object_content'])){?>
									<div type="base" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['base']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['base']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4>基本资料<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon ml5 dkUserwikiBacicInfo"><?php }?></i></h4>
							</div>
						<?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['base']==1){?>
							<table class="mvl dkUserwikiSectionContentTable" id="basicInfoForm">
								<tbody>
									<tr>
										<th class="label">姓名</th>
										<td class="data"><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_name'];?>
</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">性别</th>
										<td class="data" val="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['sex_val'];?>
"><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_sex'];?>
</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">出生日期</th>
										<td class="data" id="birthday"><?php if ($_smarty_tpl->tpl_vars['datas']->value['user']['usr_birthday']!=0){?><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['datas']->value['user']['usr_birthday']);?>
<?php }?></td>
									</tr>
								</tbody>
							</table>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:基本资料-->

						<!--start:私密资料-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['private']['object_content'])){?>
									<div type="private" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['private']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['private']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4>私密资料<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon ml5 dkUserwikiPrivateInfo"></i><?php }?></h4>
							</div>
						<?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['private']==1){?>
							<table class="mvl dkUserwikiSectionContentTable" id="privateInfoForm">
								<tbody>
									<tr>
										<th class="label">婚恋状况</th>
										<td class="data" val="<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['user']['ismarry'])&&$_smarty_tpl->tpl_vars['datas']->value['user']['ismarry']==0){?>-1<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['ismarry_val'];?>
<?php }?>"><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_ismarry'];?>
</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">有无儿女</th>
										<td class="data" val="<?php if ($_smarty_tpl->tpl_vars['datas']->value['user']['haschildren_val']==0){?>-1<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['haschildren_val'];?>
<?php }?>"><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_haschildren'];?>
</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">家乡</th>
										<td class="data" val="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_home_nation'];?>
"><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_home_nation'];?>
</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">现居住地</th>
										<td class="data" val="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_now_nation'];?>
"><?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['usr_now_nation'];?>
</td>
									</tr>
								</tbody>
							</table>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:私密资料-->

						<!--start:兴趣爱好-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['interest']['object_content'])){?>
									<div type="interest" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['interest']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['interest']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4>兴趣爱好<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon ml5 dkUserwikiInterestInfo"></i><?php }?></h4>
							</div>
						<?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['interest']==1){?>
							<table class="mvl dkUserwikiSectionContentTable" id="InterestInfoForm">
								<tbody>
									<tr>
										<th class="label">生活技能</th>
										<td class="data">
										<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['life_skill'])){?>
														<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['life_skill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?>
											
											
											<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">体育运动</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['sports'])){?>
														<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['sports']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?>
										<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">食物</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['foods'])){?>
														<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['foods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?><?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">书籍</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['books'])){?>
												<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['books']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
														<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

												<?php } ?>
											<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">电影</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['movies'])){?>
													<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['movies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?>
										
										<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">节目</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['programs'])){?>
												
													<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['programs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?>
										
										<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">娱乐休闲</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['entertainment'])){?>
															<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['entertainment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?>
										
											<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">业余爱好</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['hobby'])){?>
														<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['hobby']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?>
											<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">旅游去处</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['interst']['travel'])){?>
														<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value['interst']['travel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
															<?php echo $_smarty_tpl->tpl_vars['i']->value;?>

														<?php } ?>
											<?php }?></td>
									</tr>
								</tbody>
							</table>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:兴趣爱好-->

						<!--start:生活习惯-->
						<div class="dkUserwikiSection mtm">
							<div class="dkUserwikiSectionHeader">
								<div class="shareSetting fr">
									<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])&&isset($_smarty_tpl->tpl_vars['datas']->value['permission_value']['life']['object_content'])){?>
									<div type="life" class="dropWrap dropMenu dataPermission" oid="<?php echo $_smarty_tpl->tpl_vars['datas']->value['user']['uid'];?>
" s="<?php echo $_smarty_tpl->tpl_vars['datas']->value['permission_value']['life']['object_type'];?>
" uid="<?php echo join(',',$_smarty_tpl->tpl_vars['datas']->value['permission_value']['life']['object_content']);?>
"></div>
									<?php }?>
								</div>
								<h4>生活习惯<?php if (isset($_smarty_tpl->tpl_vars['datas']->value['isSelf'])){?><i class="dkUserwikiEditIcon ml5 dkUserwikiLifeInfo"></i><?php }?></h4>
							</div>
						<?php if ($_smarty_tpl->tpl_vars['datas']->value['permission']['life']==1){?>
							<table class="mvl dkUserwikiSectionContentTable" id="LifeInfoForm">
								<tbody>
									<tr>
										<th class="label">吸烟</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['life']['smoke'])){?><?php echo returnInfomation('life','smoke',$_smarty_tpl->tpl_vars['datas']->value['life']['smoke']);?>
<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">喝酒</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['life']['drink'])){?><?php echo returnInfomation('life','drink',$_smarty_tpl->tpl_vars['datas']->value['life']['drink']);?>
<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">作息习惯</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['life']['workrest'])){?><?php echo returnInfomation('life','workrest',$_smarty_tpl->tpl_vars['datas']->value['life']['workrest']);?>
<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">宗教信仰</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['life']['religion'])){?><?php echo returnInfomation('life','religion',$_smarty_tpl->tpl_vars['datas']->value['life']['religion']);?>
<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">个性</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['life']['personality'])){?><?php echo returnInfomation('life','personality',$_smarty_tpl->tpl_vars['datas']->value['life']['personality']);?>
<?php }?></td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="label">家中排行</th>
										<td class="data"><?php if (isset($_smarty_tpl->tpl_vars['datas']->value['life']['children_order'])){?><?php echo returnInfomation('life','children_order',$_smarty_tpl->tpl_vars['datas']->value['life']['children_order']);?>
<?php }?></td>
									</tr>
								</tbody>
							</table>
						<?php }else{ ?>
							<div class="nodata">该用户设置了查看权限</div>
						<?php }?>
						</div>
						<!--end:生活习惯-->
					</div>
				</div>
			</div>
		</div>
		
	</div>
    <?php echo $_smarty_tpl->getSubTemplate ((@APP_ROOT)."views/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<!--start:资料编辑专用js-->
	<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-tip/dk.tip.js" type="text/javascript"></script>
	<script defer src="<?php echo @MISC_ROOT;?>
js/userwiki/userwiki.js" type="text/javascript"></script>
	<script src="<?php echo @MISC_ROOT;?>
js/plug/setyear/setyear.js" type="text/javascript"></script>
	<script src="<?php echo @MISC_ROOT;?>
js/common/validator.js" type="text/javascript"></script>
	<script src="<?php echo @MISC_ROOT;?>
js/plug/tagpicker/tagpicker_wiki.js" type="text/javascript"></script>
	<script src="<?php echo @MISC_ROOT;?>
js/plug/area-utils/area_utils.js" type="text/javascript"></script>
	<!--end:资料编辑专用js-->
	<!--start:教育，工作数据-->
	<script src="<?php echo @MISC_ROOT;?>
js/plug/school_company/school_company.js" type="text/javascript"></script>
	<!--end:教育，工作数据-->
	<!--start:权限设置相关js-->
	<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/plug/autocomplete/autocomplete.js"></script>
	<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-searcher/ViolenceSearch.js"></script>
	<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/plug/friends_list/friends_list.js"></script>

	<script type="text/javascript">
		$(function(){
			$('div.dataPermission').each(function(){
				var _this = this;
				$(_this).dropdown({
					permission:{
						type: $(_this).attr("type"),
						url: mk_url('main/userwiki/setPermission'),
						im: true
					}
				});
			});
		})
		
	</script>
	<!--end:权限设置相关js-->
</body>
</html><?php }} ?>
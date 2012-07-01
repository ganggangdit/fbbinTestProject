<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:27:26
         compiled from "application/views/edit/school_company/department.html" */ ?>
<?php /*%%SmartyHeaderCode:6832114084fc852bec5c7e5-88268227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1059b2b83e8441243f0c4a9ed6f2371aa4489525' => 
    array (
      0 => 'application/views/edit/school_company/department.html',
      1 => 1336980986,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6832114084fc852bec5c7e5-88268227',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc852bed00be',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc852bed00be')) {function content_4fc852bed00be($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>端口网</title>
<link type="text/css" rel="stylesheet" href="<?php echo @MISC_ROOT;?>
css/common/base.css">
<link type="text/css" rel="stylesheet" href="<?php echo @MISC_ROOT;?>
css/plug-css/selectSC/selectSC.css">
</head>
<body>
<div class="selectWid" id="selectWid">
	<div class="selectCont" id="selectCont" style="height:268px;"></div>
</div>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/init.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	var parm = window.location.href.split('&parm=')[1],
		province_id = parm.split('_')[0],
		college_id = parm.split('_')[1] ;
	var SC = {
		init: function() {
			this.loadList();
			this.selectCallback();
		},
		loadList: function(val) {
			var listData = '',
				path = province_id + '.js';
			$.get(miscpath+'js/tempJS/college/1'+path, function() {
				var ul = '';
				listData = college;
				for(var i = 0, l = listData.length; i < l; i++) {
					if(listData[i].id === college_id) {
						var data = listData[i];
						for (var _i = 0, _l = data.depart.length; _i < _l; _i++) {
							ul += '<li><a title="'+data.depart[_i].college_name+'" id="'+data.depart[_i].id+'">'+data.depart[_i].college_name+'</a></li>';
						}
					}
				}
				uls = '<ul>' + ul + '</ul>';
				$('#selectCont').empty().append(uls);
			});
		},
		selectCallback: function() {
			$('#selectCont').delegate('a', 'click', function() {
				var self = this,
					inputs = window.parent.document.getElementsByTagName('input'),
					input = null,
					p_id = $('#province').val();
				for(var i = 0, len = inputs.length; i < len; i++) {
					if($(inputs[i]).hasClass('operating_info')) {
						input = inputs[i];
						break;
					}
				}

				window.parent.currentCollegeCallback(self.title, self.id, input);
				$(input).removeClass('operating_info').val(self.title).attr({'id_code': self.id});
				window.parent.document.getElementById('popUp').style.display = 'none';
				window.parent.departmentId = self.id;
			});	

		}
	};
	
	SC.init();
	
});
</script>
</body>
</html><?php }} ?>
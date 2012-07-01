<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:53:10
         compiled from "application/views/edit/school_company/post.html" */ ?>
<?php /*%%SmartyHeaderCode:6433091914fc858c6a733b6-96660789%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ce88decd931dfe8be7c4bedc13b01a4101e10ba' => 
    array (
      0 => 'application/views/edit/school_company/post.html',
      1 => 1337741676,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6433091914fc858c6a733b6-96660789',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc858c6b16ed',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc858c6b16ed')) {function content_4fc858c6b16ed($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	<div class="selectTitle" id="selectTitle">
		<span id="s_type">职位名称：</span>
		<span id="s_opts">
			<select name="position" id="position" style="width:200px;"></select>
			<select name="post" id="post" style="width:180px;"></select>
		</span>
	</div>
	<div class="selectCont" id="selectCont"></div>
</div>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/init.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/tempJS/position/position.js"></script>
<script type="text/javascript">
$(function(){
	var SC = {
		init: function() {
			this.selectInit();
			this.loadList();
			this.selectCallback();
		},
		selectInit: function(type) {
			var self = this,
				p1 = $('#position'),
				p2 = $('#post');
			var opt = '';
			for(var i = 0, l = position.length; i < l; i++) {
				opt += '<option value="'+position[i].code+'">'+position[i].name+'</option>';
			}
			p1.append(opt);
			
			var opts = '<option value="-1">全部</option>',
				child = position[0].child;
			for(var i = 0, l = child.length; i < l; i++) {
				opts += '<option value="'+child[i].code+'">'+child[i].name+'</option>';
			}
			p2.append(opts);

			p1.change(function() {
				var opt = '<option value="-1">全部</option>',
					val = $(this).val();
				for(var i = 0, l = position.length; i < l; i++) {
					if(position[i].code === val) {
						var child = position[i].child;
						for(var i = 0, l = child.length; i < l; i++) {
							opt += '<option value="'+child[i].code+'">'+child[i].name+'</option>';
						}
					}
					
				}
				p2.empty().append(opt).css('width','auto');
				self.loadList();
			});
			
			p2.change(function() {
				self.loadList();
			});
			
		},
		loadList: function() {
			var ul = '',
				p1 = $('#position').val(),
				p2 = $('#post').val();

			for(var i = 0, l = position.length; i < l; i++) {
				if(position[i].code === p1) {

					var listData = position[i];
					if(p2 === '-1') {
						for(var _i = 0, _l = listData.child.length; _i < _l; _i++) {
							ul += '<li class="selectContTitle">'+listData.child[_i].name+'</li>';
							for(var ii = 0, ll = listData.child[_i].child.length; ii < ll; ii++) {
								ul += '<li><a title="'+listData.child[_i].child[ii].name+'" id="'+listData.child[_i].child[ii].code+'">'+listData.child[_i].child[ii].name+'</a></li>';
							}
						}
					} else {
						for(var _i = 0, _l = listData.child.length; _i < _l; _i++) {
							if(listData.child[_i].code === p2) {
								for(var ii = 0, ll = listData.child[_i].child.length; ii < ll; ii++) {
									ul += '<li><a title="'+listData.child[_i].child[ii].name+'" id="'+listData.child[_i].child[ii].code+'">'+listData.child[_i].child[ii].name+'</a></li>';
								}
							}
						}
					}
					
				}
			}
			ul = '<ul>' + ul + '</ul>';
			$('#selectCont').empty().append(ul);
			$('#selectIndex').find('a').removeClass('selected').eq(0).addClass('selected');
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
				window.currentPositionCode = self.id;
			});

		}
		
	};
	
	SC.init();
	
});
</script>
</body>
</html><?php }} ?>
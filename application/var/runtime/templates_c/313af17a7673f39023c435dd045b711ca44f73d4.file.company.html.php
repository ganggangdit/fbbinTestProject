<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:52:26
         compiled from "application/views/edit/school_company/company.html" */ ?>
<?php /*%%SmartyHeaderCode:13133433224fc8589a20f040-43969282%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '313af17a7673f39023c435dd045b711ca44f73d4' => 
    array (
      0 => 'application/views/edit/school_company/company.html',
      1 => 1337741410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13133433224fc8589a20f040-43969282',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc8589a2c27d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc8589a2c27d')) {function content_4fc8589a2c27d($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
		<span id="s_type">所属行业：</span>
		<span id="s_opts">
			<select name="trade" id="trade" style="width:90px;"></select>
			<input id="addInput" type="text" class="vinput fl" msg="自定义添加公司" value="自定义添加公司" maxlength="30"/>
			<span id="addCompany" class="popBtns blueBtn closeBtn">确定</span>
		</span>
	</div>
	<div class="selectIndex" id="selectIndex">
		<a href="all" class="selected">全部</a>
		<a href="a" >A</a>
		<a href="b" >B</a>
		<a href="c" >C</a>
		<a href="d" >D</a>
		<a href="e" >E</a>
		<a href="f" >F</a>
		<a href="g" >G</a>
		<a href="h" >H</a>
		<a href="i" >I</a>
		<a href="j" >J</a>
		<a href="k" >K</a>
		<a href="l" >L</a>
		<a href="m" >M</a>
		<a href="n" >N</a>
		<a href="o" >O</a>
		<a href="p" >P</a>
		<a href="q" >Q</a>
		<a href="r" >R</a>
		<a href="s" >S</a>
		<a href="t" >T</a>
		<a href="u" >U</a>
		<a href="v" >V</a>
		<a href="w" >W</a>
		<a href="x" >X</a>
		<a href="y" >Y</a>
		<a href="z" >Z</a>
	</div>
	<div class="selectCont" id="selectCont"></div>
</div>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/init.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/tempJS/trade/trade.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/tempJS/trade/1.js"></script>
<script type="text/javascript">
$(function(){
	
	var SC = {
		cache: {
			listData: company
		},
		init: function() {
			this.selectInit();
			this.tabList();
			this.loadList();
			this.selectCallback();
		},
		selectInit: function(type) {
			var self = this,
				t = $('#trade');
			var opt = '';
			for(var i = 0, l = trade.length; i < l; i++) {
				opt += '<option value="'+trade[i].id+'">'+trade[i].trade_name+'</option>';
			}
			t.append(opt).change(function() {
				self.loadList();
			});
		},
		loadList: function(val) {
			var listData = '',
				path = $('#trade').val() + '.js',
				cache = SC.cache;
			$.get(miscpath+'js/tempJS/trade/'+path, function(data) {
				var ul = '';
				cache.listData = listData = company;
				for(var i = 0, l = listData.length; i < l; i++) {
					ul += '<li><a title="'+listData[i].company_name+'" id="'+listData[i].id+'">'+listData[i].company_name+'</a></li>';
				}
				uls = '<ul>' + ul + '</ul>';
				$('#selectCont').empty().append(uls);
				$('#selectIndex').find('a').removeClass('selected').eq(0).addClass('selected');
			});
		},
		tabList: function() {
			var cache = this.cache,
				par = $('#selectIndex');
			par.find('a').click(function() {
				if(!$(this).hasClass('selected')) {
					var listData = cache.listData,
						ul = '',
						index = $(this).attr('href');
					if(index !== 'all') {
						for(var i = 0, l = listData.length; i < l; i++) {
							if(listData[i].initial === index) {
								ul += '<li><a title="'+listData[i].company_name+'" id="'+listData[i].id+'">'+listData[i].company_name+'</a></li>';
							}
						}
					} else {
						for(var i = 0, l = listData.length; i < l; i++) {
							ul += '<li><a title="'+listData[i].company_name+'" id="'+listData[i].id+'">'+listData[i].company_name+'</a></li>';
						}
					}
					ul = '<ul>' + ul + '</ul>';
					$('#selectCont').empty().append(ul);
				}
				par.find('a').removeClass('selected');
				$(this).addClass('selected');
				return false;
			});
			
		},
		selectCallback: function() {
			$('#selectCont').delegate('a', 'click', function() {
				var self = this,
					inputs = window.parent.document.getElementsByTagName('input'),
					input = null;
				
				for(var i = 0, len = inputs.length; i < len; i++) {
					if($(inputs[i]).hasClass('operating_info')) {
						input = inputs[i];
						break;
					}
				}
				window.parent.currentCollegeCallback(self.title, self.id, input,"company");
				$(input).removeClass('operating_info').val(self.title).attr({'id_code': self.id});
				window.parent.document.getElementById('popUp').style.display = 'none';
			});
			/*以下自定义添加公司*/
			$('#addInput').focusin(function(){
				$(this).val('');
				var error_tip = $(this).parent().find('.error_tip');
				if (error_tip.length>0) {
					error_tip.remove();
				};
			}).focusout(function(){
				var value = $(this).val();
				var defaultmsg = $(this).attr('msg');
				if (value=='') {
					$(this).val(defaultmsg);
				};
			});
			function htmlspecialchars(str){
				return $('<span>').text(str).html();
		    }
			$('#addCompany').click(function(){
				var title = htmlspecialchars($(this).prev().val());
				var error_tip = $(this).parent().find('.error_tip');
				if (title.length<2) {
					if (error_tip.length==0) {
						$(this).after('<span class ="error_tip">公司名字长度为2-30个字符</span>');
					}else{
						error_tip.text('公司名字长度为2-30个字符');
					};
					return;
				}else if (title=='自定义添加公司') {
					if (error_tip.length==0) {
						$(this).after('<span class="error_tip">请输入公司名字</span>');
					}else{
						error_tip.text('请输入公司名字');
					};
					return;
				};
				var	inputs = window.parent.document.getElementsByTagName('input');
				var	input = null;
				for(var i = 0, len = inputs.length; i < len; i++) {
					if($(inputs[i]).hasClass('operating_info')) {
						input = inputs[i];
						break;
					}
				}	
				window.parent.currentCollegeCallback(title, '1', input,"company");
				$(input).removeClass('operating_info').val(title).attr({'id_code': 1});
				window.parent.document.getElementById('popUp').style.display = 'none';
			});
		}
		
	};
	
	SC.init();
	
});
</script>

</body>
</html><?php }} ?>
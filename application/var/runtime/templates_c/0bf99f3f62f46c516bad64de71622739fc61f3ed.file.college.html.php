<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:27:12
         compiled from "application/views/edit/school_company/college.html" */ ?>
<?php /*%%SmartyHeaderCode:4343521194fc852b09c59f6-41485231%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0bf99f3f62f46c516bad64de71622739fc61f3ed' => 
    array (
      0 => 'application/views/edit/school_company/college.html',
      1 => 1336977818,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4343521194fc852b09c59f6-41485231',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc852b0a882d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc852b0a882d')) {function content_4fc852b0a882d($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
		<span id="s_type">学校所在地：</span>
		<span id="s_opts">
			<select name="country" id="country">
				<option selected="selected" value="1">中国</option>
				<option value="2">澳大利亚</option>
				<option value="3">法国</option>
				<option value="4">新西兰</option>
				<option value="5">新加坡</option>
				<option value="6">英国</option>
				<option value="7">加拿大</option>
				<option value="8">美国</option>
				<option value="9">德国</option>
				<option value="10">韩国</option>
				<option value="11">日本</option>
				<option value="12">意大利</option>
				<option value="13">爱尔兰</option>
				<option value="14">荷兰</option>
				<option value="15">马来西亚</option>
				<option value="16">瑞士</option>
				<option value="17">泰国</option>
				<option value="18">乌克兰</option>
				<option value="19">南非</option>
				<option value="20">芬兰</option>
				<option value="21">瑞典</option>
				<option value="22">西班牙</option>
				<option value="23">比利时</option>
				<option value="24">挪威</option>
				<option value="25">丹麦</option>
				<option value="26">菲律宾</option>
				<option value="27">波兰</option>
				<option value="28">印度</option>
				<option value="29">奥地利</option>
				<option value="30">俄罗斯</option>
			</select>
			<select name="province" id="province">
				<option selected="selected" value="11">北京</option>
				<option value="12">天津</option>
				<option value="13">河北</option>
				<option value="14">山西</option>
				<option value="15">内蒙古</option>
				<option value="21">辽宁</option>
				<option value="22">吉林</option>
				<option value="23">黑龙江</option>
				<option value="31">上海</option>
				<option value="32">江苏</option>
				<option value="33">浙江</option>
				<option value="34">安徽</option>
				<option value="35">福建</option>
				<option value="36">江西</option>
				<option value="37">山东</option>
				<option value="41">河南</option>
				<option value="42">湖北</option>
				<option value="43">湖南</option>
				<option value="44">广东</option>
				<option value="45">广西</option>
				<option value="46">海南</option>
				<option value="50">重庆</option>
				<option value="51">四川</option>
				<option value="52">贵州</option>
				<option value="53">云南</option>
				<option value="54">西藏</option>
				<option value="61">陕西</option>
				<option value="62">甘肃</option>
				<option value="63">青海</option>
				<option value="64">宁夏</option>
				<option value="65">新疆</option>
				<option value="71">台湾</option>
				<option value="81">香港</option>
				<option value="82">澳门</option>
			</select>
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
/js/init.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
/js/tempJS/area/country.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
/js/tempJS/area/1/province.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
/js/tempJS/area/1/11.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
/js/tempJS/college/111.js"></script>
<script type="text/javascript">
$(function(){
	
	var SC = {
		cache: {
			listData: college
		},
		init: function() {
			this.selectInit();
			this.tabList();
			this.loadList();
			this.selectCallback();
		},
		selectInit: function(type) {
			var self = this,
				c = $('#country'),
				p = $('#province');
			c.change(function() {
				if($(this).val() !== '1') {
					p.empty();
					self.cache.listData = '';
					$('#selectCont').empty();
				} else {
					var opt = '';
					for(var i = 0, l = province_list.length; i < l; i++) {
						opt += '<option value="'+province_list[i].area_id+'">'+province_list[i].area_name+'</option>';
					}
					p.append(opt).val('11');
					self.loadList();
				}
			});
			
			p.change(function() {
				self.loadList();
			});
			
		},
		loadList: function(val) {
			var listData = '',
				path = $('#province').val() + '.js',
				cache = this.cache;
			$.get(miscpath+'js/tempJS/college/1'+path, function(data) {
				var ul = '';
				cache.listData = listData = college;
				for(var i = 0, l = listData.length; i < l; i++) {
					ul += '<li><a title="'+listData[i].college_name+'" id="'+listData[i].id+'">'+listData[i].college_name+'</a></li>';
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
								ul += '<li><a title="'+listData[i].college_name+'" id="'+listData[i].id+'">'+listData[i].college_name+'</a></li>';
							}
						}
					} else {
						for(var i = 0, l = listData.length; i < l; i++) {
							ul += '<li><a title="'+listData[i].college_name+'" id="'+listData[i].id+'">'+listData[i].college_name+'</a></li>';
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
					input = null,
					p_id = $('#province').val();
				for(var i = 0, len = inputs.length; i < len; i++) {
					if($(inputs[i]).hasClass('operating_info')) {
						input = inputs[i];
						break;
					}
				}
				window.parent.currentCollegeCallback(self.title, self.id, input,"college", p_id);
				$(input).removeClass('operating_info').val(self.title).attr({'id_code': self.id, 'p_id': p_id});
				window.parent.document.getElementById('popUp').style.display = 'none';
			});
		}
		
	};
	
	SC.init();
	
});
</script>
</body>
</html><?php }} ?>
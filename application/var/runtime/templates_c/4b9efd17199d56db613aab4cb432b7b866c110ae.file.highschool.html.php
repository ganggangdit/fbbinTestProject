<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 13:27:54
         compiled from "application/views/edit/school_company/highschool.html" */ ?>
<?php /*%%SmartyHeaderCode:15890416284fc852daed58d3-54506709%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b9efd17199d56db613aab4cb432b7b866c110ae' => 
    array (
      0 => 'application/views/edit/school_company/highschool.html',
      1 => 1337332288,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15890416284fc852daed58d3-54506709',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc852db04a08',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc852db04a08')) {function content_4fc852db04a08($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
			<select name="city" id="city">
				<option selected="selected" value="1101">东城</option>
				<option value="1102">西城</option>
				<option value="1103">崇文</option>
				<option value="1104">宣武</option>
				<option value="1105">朝阳</option>
				<option value="1106">丰台</option>
				<option value="1107">石景山</option>
				<option value="1108">海淀</option>
				<option value="1109">门头沟</option>
				<option value="1111">房山</option>
				<option value="1112">通州</option>
				<option value="1113">顺义</option>
				<option value="1121">昌平</option>
				<option value="1124">大兴</option>
				<option value="1126">平谷</option>
				<option value="1127">怀柔</option>
				<option value="1128">密云</option>
				<option value="1129">延庆</option>
			</select>
			<select name="district" id="district">
				<option selected="selected" value="110101">东城区</option>
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
js/init.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/tempJS/area/1/province.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/tempJS/area/1/11.js"></script>
<script type="text/javascript" src="<?php echo @MISC_ROOT;?>
js/tempJS/highschool/11.js"></script>
<script type="text/javascript">
$(function(){
	
	var SC = {
		cache: {
			listData: School
		},
		init: function() {
			this.selectInit();
			this.tabList();
			this.loadList();
			this.selectCallback();
		},
		selectInit: function(type) {
			var self = this,
				p = $('#province'),
				c = $('#city'),
				d = $('#district');
			p.change(function() {
				self.loadCity(self.loadList);
			});
			c.change(function() {
				var _opts = '',
					val = $(this).val();
				for(var i = 0, l = city_list.length; i < l; i++) {
					if(city_list[i].area_id === val) {
						var district = city_list[i].children;
						for(var _i = 0, _l = district.length; _i < _l; _i++)
						_opts += '<option value="'+district[_i].area_id+'">'+district[_i].area_name+'</option>';
					}
				}
				$('#district').empty().append(_opts);
				self.loadList();
			});
			
			d.change(function() {
				self.loadList();
			});
			
		},
		loadCity: function(callback) {
			var path = $('#province').val() + '.js';
			$.get(miscpath+'js/tempJS/area/1/'+path, function() {
				var opts = '';
				for(var i = 0, l = city_list.length; i < l; i++) {
					
					opts += '<option value="'+city_list[i].area_id+'">'+city_list[i].area_name+'</option>';
				}
				$('#city').empty().append(opts).val($('#city').children().eq(0).val());
				
				var _opts = '';
				var val = $('#city').val();
				for(var i = 0, l = city_list.length; i < l; i++) {
					if(city_list[i].area_id === val) {
						var district = city_list[i].children;
						for(var _i = 0, _l = district.length; _i < _l; _i++)
						_opts += '<option value="'+district[_i].area_id+'">'+district[_i].area_name+'</option>';
					}
				}
				$('#district').empty().append(_opts);
				callback();
			});
		},
		loadList: function(val) {
			var listData = '',
				path = $('#province').val() + '.js',
				district = $('#district').val(),
				cache = SC.cache;
			$.get(miscpath+'js/tempJS/highschool/'+path, function(data) {
				var ul = '';
				cache.listData = listData = School;
				if(district !== '-1') {
					var arr = [];
					for(var i = 0, l = listData.length; i < l; i++) {
						if(listData[i].area_id === district) {
							ul += '<li><a title="'+listData[i].school_name+'" id="'+listData[i].id+'">'+listData[i].school_name+'</a></li>';
							arr.push(listData[i]);
						}
					}
					cache.listData = arr;
				} else {
					for(var i = 0, l = listData.length; i < l; i++) {
						ul += '<li><a title="'+listData[i].school_name+'" id="'+listData[i].id+'">'+listData[i].school_name+'</a></li>';
					}
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
								ul += '<li><a title="'+listData[i].school_name+'" id="'+listData[i].id+'">'+listData[i].school_name+'</a></li>';
							}
						}
					} else {
						for(var i = 0, l = listData.length; i < l; i++) {
							ul += '<li><a title="'+listData[i].school_name+'" id="'+listData[i].id+'">'+listData[i].school_name+'</a></li>';
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
				window.parent.currentCollegeCallback(self.title, self.id, input,"highSchool");
				$(input).removeClass('operating_info').val(self.title).attr({'id_code': self.id});
				window.parent.document.getElementById('popUp').style.display = 'none';
			});
		}
	};
	
	SC.init();
	
});
</script>
</body>
</html><?php }} ?>
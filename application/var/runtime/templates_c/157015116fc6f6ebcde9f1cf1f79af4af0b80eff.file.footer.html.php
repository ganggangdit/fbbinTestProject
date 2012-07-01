<?php /* Smarty version Smarty-3.1.7, created on 2012-06-01 11:50:00
         compiled from "application/views/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:17860665954fc83be80ea219-05900020%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '157015116fc6f6ebcde9f1cf1f79af4af0b80eff' => 
    array (
      0 => 'application/views/footer.html',
      1 => 1334733664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17860665954fc83be80ea219-05900020',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'js_css_v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4fc83be8196d2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fc83be8196d2')) {function content_4fc83be8196d2($_smarty_tpl) {?><div id="footer" class="clearfix">
	<span class="copyRight">Duankou &copy; 2011 · <a href="#">中文(简体)</a></span>
	<span class="footerLinks"><a href="#">关于</a>·<a href="#">开放平台</a>·<a href="#">手机</a>·<a href="#">广告</a>·<a href="#">招聘</a>·<a href="#">隐私政策</a>·<a href="#">帮助中心</a></span>
</div>
<?php $_smarty_tpl->tpl_vars['js_css_v'] = new Smarty_variable(time(), null, 0);?>
<script src="<?php echo @MISC_ROOT;?>
js/jquery.min.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/init.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/autocomplete/autocomplete.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/common/utils.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/popUp/popUp.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/message/messages.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/dk-ui/dk.uploader.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript" ></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-searcher/ViolenceSearch.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/plug/jQuery-searcher/jQuery.searcher.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
" type="text/javascript"></script>
<script src="<?php echo @MISC_ROOT;?>
js/message/request_notice.js?v=<?php echo $_smarty_tpl->tpl_vars['js_css_v']->value;?>
"  type="text/javascript"></script><?php }} ?>
<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_scripts/be/js/jquery.nouislider.init.js' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b445891_00246586',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9a8d8c7eab8e847cd488ba90c4461a270a386fc7' => 
    array (
      0 => '/home/yiaapc5/public_html/f_scripts/be/js/jquery.nouislider.init.js',
      1 => 1433278800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b445891_00246586 (Smarty_Internal_Template $_smarty_tpl) {
?>$(document).ready(function(){
	$(document).on("dblclick", ".noUi-handle.noUi-handle-lower", function (){
		var slider = $(this).parent().parent().parent().parent().find(".noUi-target.noUi-ltr.noUi-horizontal.noUi-background");
		
		$(this).parent().parent().parent().parent().find("input").val(function() {
			var _val = this.defaultValue;
			slider.val(_val);

			return _val;
		});
	});
});<?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-24 03:34:31
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_profilejs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6035c947b305d8_00351185',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8a7f9f57be5d030ac4421932cfc7ba71f4d8d28b' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_profilejs.tpl',
      1 => 1554170220,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6035c947b305d8_00351185 (Smarty_Internal_Template $_smarty_tpl) {
?>    	$(document).ready(function() {
    		a = $(".sortings").parent().clone(true);
    		$(".sortings").parent().detach();
    		$(a).insertAfter("#ct-set-form article h3").css({"float": "right", "margin-top": "7px"});
    		$(".open-close-links").css({"margin-left": "0px", "margin-top": "-44px"});
    	});
<?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-08 09:21:09
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_privatemessage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602148d5722957_21995672',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a496735c300837542e7e29e8af3487f8af597ec5' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_privatemessage.tpl',
      1 => 1520287200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_602148d5722957_21995672 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<html>
    <head>
	<title>##TITLE##</title>
	<style>img, a { border: 0px !important; }</style>
    </head>
    <body style="background-color: #FFFFFF; margin: 20px; padding: 0px;">
	<div id="main-wrapper" style="width: 100%; float: left; min-height: 400px;">
	    <div id="logo-wrapper" style="float: left; width: 100%;">##LOGO##</div>
	    <div id="message-content" style="width: 100%; float: left; display: block;">
		<p>##USERNAME## <?php echo smarty_function_lang_entry(array('key'=>"mail.notif.txt1"),$_smarty_tpl);?>
</p>
		<p style="font-weight: bold;">##SUBJECT##</p>
		<p>##MESSAGE##</p>
		<p>##ATTACH##</p>
		<p style="text-align: center; color: #cccccc; padding-top: 15px;">&copy; ##YEAR## <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
, LLC</p>
	    </div>
	</div>
    </body>
</html><?php }
}

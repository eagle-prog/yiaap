<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:41:13
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_newupload.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c31b94ac4d7_83432136',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8391751ae3e366044515b08d6880fa2ef9623a82' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_newupload.tpl',
      1 => 1520373600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c31b94ac4d7_83432136 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<html>
    <head>
	<title>##TITLE##</title>
	<style>img, a { border: 0px !important; }</style>
    </head>
    <body style="background-color: #FFFFFF; margin: 20px; padding: 0px;">
	<div id="main-wrapper" style="float: left; width: 100%; min-height: 400px;">
	    <div id="logo-wrapper" style="float: left; width: 100%;">##LOGO##</div>
	    <div id="message-content" style="width: 100%; float: left; display: block;">
		<p><a href="##CHURL##">##USER##</a> <?php echo smarty_function_lang_entry(array('key'=>"mail.upload.email.txt1"),$_smarty_tpl);?>
 ##TYPE##:</p>
		<p>##FILE_DETAILS##</p>
		<p style="##P_STYLE##"><?php echo smarty_function_lang_entry(array('key'=>"mail.upload.email.txt2"),$_smarty_tpl);?>
</p>
		<p style="text-align: center; color: #cccccc; padding-top: 15px;">&copy; ##YEAR## <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
, LLC</p>
	    </div>
	</div>
    </body>
</html><?php }
}

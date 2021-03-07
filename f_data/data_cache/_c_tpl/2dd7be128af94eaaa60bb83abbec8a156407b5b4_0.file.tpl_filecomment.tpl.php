<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:43:10
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_filecomment.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c787e7f0c72_29649306',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2dd7be128af94eaaa60bb83abbec8a156407b5b4' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_filecomment.tpl',
      1 => 1554673860,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c787e7f0c72_29649306 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<html>
    <head>
	<title>##TITLE##</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style>img, a { border: 0px !important; } #message-content { line-height: 18px } #message-content img { width: 18px !important; height: 18px !important; display:inline-block; } </style>
    </head>
    <body style="background-color: #FFFFFF; margin: 20px; padding: 0px;">
	<div id="main-wrapper" style="float: left; width: 100%; min-height: 400px;">
	    <div id="logo-wrapper" style="float: left; width: 100%;">##LOGO##</div>
	    <div id="message-content" style="width: 100%; float: left; display: block;">
		<p><a href="##CHURL##">##USER##</a> <?php if ($_smarty_tpl->tpl_vars['comm_type']->value == "file_comment_reply") {
echo smarty_function_lang_entry(array('key'=>"post.comment.reply.file.tpl"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"post.comment.file.tpl"),$_smarty_tpl);
}?> ##FTITLE##</p>
		<p style="font-weight: bold;">##COMMENT##</p>
		<p></p>
		<p style="text-align: center; color: #cccccc; padding-top: 15px;">&copy; ##YEAR## <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
, LLC</p>
	    </div>
	</div>
    </body>
</html><?php }
}

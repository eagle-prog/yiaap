<?php
/* Smarty version 3.1.33, created on 2021-02-28 23:22:31
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_follow.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_603c25b74e0c72_01456176',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c5de4900ccd997e726bad644d0cc8c0c4866285' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_follow.tpl',
      1 => 1532898000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603c25b74e0c72_01456176 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<html>
    <head>
	<title>##TITLE##</title>
	<style>img, a { border: 0px !important; }</style>
    </head>
    <body style="background-color: #FFFFFF; margin: 20px; padding: 0px;">
	<div id="main-wrapper" style="float: left; width: 100%; min-height: 500px;">
	    <div id="logo-wrapper" style="float: left; width: 100%;">##LOGO##</div>
	    <div id="message-content" style="width: 100%; float: left; display: block;">
                <p><a href="##CHURL##">##USER##</a> <?php echo smarty_function_lang_entry(array('key'=>"follow.channel.subject"),$_smarty_tpl);?>
</p>
                <p><?php echo smarty_function_lang_entry(array('key'=>"mail.subscribe.email.f.txt1"),$_smarty_tpl);?>
 <?php echo smarty_function_lang_entry(array('key'=>"mail.subscribe.email.f.txt2"),$_smarty_tpl);?>
</p>
                <p><?php echo smarty_function_lang_entry(array('key'=>"mail.subscribe.email.f.txt3"),$_smarty_tpl);?>
</p>
                <p><?php echo smarty_function_lang_entry(array('key'=>"mail.subscribe.email.f.txt4"),$_smarty_tpl);?>
</p>
                <p><?php echo smarty_function_lang_entry(array('key'=>"email.notif.general.txt1"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
!</p>
                <p><?php echo smarty_function_lang_entry(array('key'=>"email.notif.general.txt2"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
 <?php echo smarty_function_lang_entry(array('key'=>"email.notif.general.txt3"),$_smarty_tpl);?>
</p>
		<p style="text-align: center; color: #cccccc; padding-top: 15px;">&copy; ##YEAR## <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
, LLC</p>
	    </div>
	</div>
    </body>
</html><?php }
}

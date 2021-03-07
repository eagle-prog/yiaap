<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:18:18
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_welcome.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c72aaf10801_80481764',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '736181c42d098e78ea0ce0494f3b4f4f3469f1f6' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_welcome.tpl',
      1 => 1520373600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c72aaf10801_80481764 (Smarty_Internal_Template $_smarty_tpl) {
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
		<h2>##H2##</h2>
		<p><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt16"),$_smarty_tpl);?>
</p>
		<p><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt6"),$_smarty_tpl);?>
</p>
                <p><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt7"),$_smarty_tpl);?>
</p>
                <p>
                    <ul>
                        <li><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt8"),$_smarty_tpl);?>
</li>
                        <li><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt9"),$_smarty_tpl);?>
</li>
                        <li><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt10"),$_smarty_tpl);?>
</li>
                        <li><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt11"),$_smarty_tpl);?>
</li>
                        <li><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt12"),$_smarty_tpl);?>
</li>
                    </ul>
                </p>
                <p><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt13"),$_smarty_tpl);?>
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

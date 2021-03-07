<?php
/* Smarty version 3.1.33, created on 2021-02-07 12:44:21
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_emailverification.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602026f574cd57_61099056',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '79371fc0093dae29a1a9782694839a99a179455e' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_emailverification.tpl',
      1 => 1520373600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_602026f574cd57_61099056 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<html>
    <head>
	<title>##TITLE##</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style>img, a { border: 0px !important; }</style>
    </head>
    <body style="background-color: #FFFFFF; margin: 20px; padding: 0px;">
	<div id="main-wrapper" style="float: left; width: 100%; min-height: 500px;">
	    <div id="logo-wrapper" style="float: left; width: 100%;">##LOGO##</div>
	    <div style="float: left; width:100%;"><h3><a href="##USER_LINK##"><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt0"),$_smarty_tpl);?>
</a> <?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt2"),$_smarty_tpl);?>
</h3></div>
	    <br /><br />
	    <div id="message-content" style="width: 100%; float: left; display: block;">
		<h2>##H2##</h2>
		<p><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt4"),$_smarty_tpl);?>
 <a href="##USER_LINK##"><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt1"),$_smarty_tpl);?>
</a>. <?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt5"),$_smarty_tpl);?>
</p>
		<p><a href="##USER_LINK##">##USER_LINK##</a></p>
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
		<p><?php echo smarty_function_lang_entry(array('key'=>"email.notif.general.txt2"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
 <?php echo smarty_function_lang_entry(array('key'=>"email.notif.general.txt3"),$_smarty_tpl);?>
</p>
		<p style="color: #333333;"><?php echo smarty_function_lang_entry(array('key'=>"mail.verif.notif.fe.txt14"),$_smarty_tpl);?>
</p>
		<p style="text-align: center; color: #cccccc; padding-top: 15px;">&copy; ##YEAR## <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
, LLC</p>
	    </div>
	</div>
    </body>
</html><?php }
}

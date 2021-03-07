<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:18:19
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_newmember_be.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c72ab00d344_64335578',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6743860f2ec85e9f363758d6e670251d246941ec' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_email/tpl_newmember_be.tpl',
      1 => 1520373600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c72ab00d344_64335578 (Smarty_Internal_Template $_smarty_tpl) {
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
		<h2>##H2##</h2>
		<p><?php echo smarty_function_lang_entry(array('key'=>"backend.notif.signup.new"),$_smarty_tpl);
echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
</p>
		<p>
		------------------------------------------------------<br />
		<?php echo smarty_function_lang_entry(array('key'=>"backend.notif.signup.user"),$_smarty_tpl);?>
: ##U_NAME##<br />
		<?php echo smarty_function_lang_entry(array('key'=>"backend.notif.signup.email"),$_smarty_tpl);?>
: ##U_EMAIL##<br />
		<?php echo smarty_function_lang_entry(array('key'=>"backend.notif.signup.ip"),$_smarty_tpl);?>
: ##U_IP##<br />
		------------------------------------------------------
		</p>
		<p style="text-align: center; color: #cccccc; padding-top: 15px;">&copy; ##YEAR## <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
, LLC</p>
	    </div>
	</div>
    </body>
</html><?php }
}

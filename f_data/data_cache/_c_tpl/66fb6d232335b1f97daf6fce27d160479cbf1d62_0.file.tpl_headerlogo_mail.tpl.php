<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:41:13
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_headerlogo_mail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c31b94a5cc8_31328682',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '66fb6d232335b1f97daf6fce27d160479cbf1d62' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_headerlogo_mail.tpl',
      1 => 1487109600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c31b94a5cc8_31328682 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
    <div id="vs-logo">
	<div class="left-float">
	    <a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"index"),$_smarty_tpl);?>
" class="top-logo"><img src="<?php echo $_smarty_tpl->tpl_vars['global_images_url']->value;?>
/logo-mail.png" alt="<?php echo $_smarty_tpl->tpl_vars['head_title']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['head_title']->value;?>
" height="36" /></a>
	</div>
    </div><?php }
}

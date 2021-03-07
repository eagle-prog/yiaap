<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-cancel-top.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b5146c9_51811965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ff1309e17c9b2bffcaedc48117343830cfdc2ac' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-cancel-top.tpl',
      1 => 1543356000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b5146c9_51811965 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
			<?php if (($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_servers" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_categ" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_streaming" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_banners" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_lang" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwcodes" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwads" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_fpads") && $_GET['do'] == "add") {
$_smarty_tpl->_assignInScope('cl_display', "none");
$_smarty_tpl->_assignInScope('ca_display', "block");
} else {
$_smarty_tpl->_assignInScope('cl_display', "block");
$_smarty_tpl->_assignInScope('ca_display', "none");
}?>
			<div id="cancel-link" style="display: <?php echo $_smarty_tpl->tpl_vars['ca_display']->value;?>
;">
				<a href="javascript:;" class="cancel-trigger"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.cancel"),$_smarty_tpl);?>
</span></a>
			</div>
<?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f56b7c0f3_18781447',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e9dbb84868fc75f2ad679b277ff7a2c95ac515d' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl',
      1 => 1554781560,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f56b7c0f3_18781447 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
			<div class="sidebar-nav-footer">
				<?php echo insert_footerInit(array(),$_smarty_tpl);?>
				<label>&copy; <?php echo date('Y');?>
 <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
 - <?php echo smarty_function_lang_entry(array('key'=>"frontend.rights.text"),$_smarty_tpl);?>
</label>
				<label><?php echo smarty_function_lang_entry(array('key'=>"frontend.powered.text"),$_smarty_tpl);?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
" target="_blank" rel="nofollow"><?php echo $_smarty_tpl->tpl_vars['head_title']->value;?>
</a></label>
				<p>
					<?php echo insert_socialMediaLinks(array(),$_smarty_tpl);?>
				</p>
			</div><?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_import.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6696b105_20367887',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3abb4883aa4c499f3514d71c05054dc58d8b6953' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_import.tpl',
      1 => 1485640800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6696b105_20367887 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_import"),$_smarty_tpl);?>
?t=video"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_import") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fu.grabber"),$_smarty_tpl);?>
</a></li>
<?php }
}

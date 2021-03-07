<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_live_manage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f668e0275_21232479',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '814d67e9608ee3732f02c919fbf85f56e5822ecd' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_live_manage.tpl',
      1 => 1548356760,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f668e0275_21232479 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
                                    	    <li><a href="javascript:;" id="backend-menu-entry6-sub6" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "l") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.l"),$_smarty_tpl);?>
</a></li>
<?php }
}

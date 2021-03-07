<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_live_manage_categ.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f669201d0_20450046',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '476e7cd071e96076f332413fa3e39099c8487c8a' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_live_manage_categ.tpl',
      1 => 1548356820,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f669201d0_20450046 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
                                                    <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.l"),$_smarty_tpl);?>
</a>
                                                        <?php echo insert_beFileCategories(array('type' => "live"),$_smarty_tpl);?>
                                                    </li>
<?php }
}

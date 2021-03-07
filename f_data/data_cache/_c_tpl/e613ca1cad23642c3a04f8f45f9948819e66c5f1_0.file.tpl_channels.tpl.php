<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:45:54
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_channels.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c79228bbc89_66448925',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e613ca1cad23642c3a04f8f45f9948819e66c5f1' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_channels.tpl',
      1 => 1475096400,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c79228bbc89_66448925 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript">
            var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';
            var menu_section = '<?php echo smarty_function_href_entry(array('key'=>"channels"),$_smarty_tpl);?>
';
            var fe_mask      = 'on';
        <?php echo '</script'; ?>
>
        <div class="" id="ct-wrapper">
            <?php echo smarty_function_generate_html(array('type'=>"channels_layout",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'section'=>"files",'bb'=>"1"),$_smarty_tpl);?>

        </div>

<?php }
}

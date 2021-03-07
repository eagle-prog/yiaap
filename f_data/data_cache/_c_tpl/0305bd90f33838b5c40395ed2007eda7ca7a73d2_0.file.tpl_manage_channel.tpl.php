<?php
/* Smarty version 3.1.33, created on 2021-02-07 13:55:35
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_manage_channel.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602037a745f364_32318525',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0305bd90f33838b5c40395ed2007eda7ca7a73d2' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_manage_channel.tpl',
      1 => 1461013200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_602037a745f364_32318525 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript">
            var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';
            var menu_section = '<?php echo smarty_function_href_entry(array('key'=>"manage_channel"),$_smarty_tpl);?>
';
            var fe_mask      = 'on';
        <?php echo '</script'; ?>
>
        <div class="wdmax" id="ct-wrapper">
            <?php echo smarty_function_generate_html(array('type'=>"my_channels_layout",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'section'=>"files",'bb'=>"1"),$_smarty_tpl);?>

        </div>

<?php }
}

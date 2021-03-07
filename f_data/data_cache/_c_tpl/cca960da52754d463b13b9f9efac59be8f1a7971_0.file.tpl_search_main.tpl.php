<?php
/* Smarty version 3.1.33, created on 2021-02-07 15:37:39
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_search_main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60204f93824737_64448149',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cca960da52754d463b13b9f9efac59be8f1a7971' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_search_main.tpl',
      1 => 1474491600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60204f93824737_64448149 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
        <?php echo '<script'; ?>
 type="text/javascript">
//    	    var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';
//            var menu_section = '<?php echo smarty_function_href_entry(array('key'=>"search"),$_smarty_tpl);?>
';
	<?php echo '</script'; ?>
>

	<div id="ct-wrapper" class="lb-margins">
    	    <?php echo smarty_function_generate_html(array('type'=>"search_layout",'bullet_id'=>"ct-search",'entry_id'=>"ct-search-details",'section'=>"search",'bb'=>"0"),$_smarty_tpl);?>

        </div>
<?php }
}

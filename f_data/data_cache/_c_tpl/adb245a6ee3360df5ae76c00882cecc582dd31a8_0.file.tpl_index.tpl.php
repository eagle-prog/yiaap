<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f56ae81e2_03646601',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'adb245a6ee3360df5ae76c00882cecc582dd31a8' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_index.tpl',
      1 => 1504645200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f56ae81e2_03646601 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
if ($_smarty_tpl->tpl_vars['not_found']->value) {?>
<div class="pointer left-float wdmax" id="cb-response">
<!-- NOTIFICATION CONTAINER -->
<article>
<h2 class="content-title"><i class="icon-warning"></i>Not found</h2>
<div class="line"></div>
<p class="">The requested page was not found!</p>
<br>
</article>
<!-- END NOTIFICATION CONTAINER -->
<?php } else { ?>
    <?php echo '<script'; ?>
 type="text/javascript">
        var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';
        var menu_section = '<?php echo smarty_function_href_entry(array('key'=>"index"),$_smarty_tpl);?>
';
    <?php echo '</script'; ?>
>

        <?php echo smarty_function_generate_html(array('type'=>"homepage",'bullet_id'=>"lt-bullet1",'entry_id'=>"lt-entry-details1",'section'=>'','bb'=>"0"),$_smarty_tpl);?>

<?php }
}
}

<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_body.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62ad8542_37493904',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b05174a8b60b6b36eb2bfae0604c94541e3da15e' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_body.tpl',
      1 => 1578942728,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_header/tpl_headernav.tpl' => 1,
    'file:tpl_backend/tpl_menupanel.tpl' => 1,
    'file:tpl_backend/tpl_footer.tpl' => 1,
    'file:tpl_backend/tpl_footerjs_min.tpl' => 1,
  ),
),false)) {
function content_601c2f62ad8542_37493904 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.page_display.php','function'=>'smarty_function_page_display',),));
?>
    <body class="be <?php echo $_smarty_tpl->tpl_vars['page_display']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_affiliate" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_subscriber" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_token") {?> tpl_files<?php }
if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_token") {?> backend_tpl_subscriber<?php }?> <?php if (strpos($_smarty_tpl->tpl_vars['theme_name_be']->value,'dark') === 0) {?>dark<?php }?>">
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_header/tpl_headernav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
if ($_SESSION['ADMIN_NAME'] != '') {?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php echo smarty_function_page_display(array('section'=>$_smarty_tpl->tpl_vars['page_display']->value),$_smarty_tpl);?>


        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_footerjs_min.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </body>
</html>
<?php }
}

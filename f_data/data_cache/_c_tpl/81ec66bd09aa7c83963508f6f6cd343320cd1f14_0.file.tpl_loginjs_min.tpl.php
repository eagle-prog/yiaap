<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_loginjs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62b32527_83504845',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '81ec66bd09aa7c83963508f6f6cd343320cd1f14' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_loginjs_min.tpl',
      1 => 1541455200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f62b32527_83504845 (Smarty_Internal_Template $_smarty_tpl) {
?>        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/jquery.password.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
            var full_url = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php if ($_smarty_tpl->tpl_vars['global_section']->value == "backend") {
echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php }?>';
            var main_url = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';
        <?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/login.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/login.init.js"><?php echo '</script'; ?>
>
<?php }
}

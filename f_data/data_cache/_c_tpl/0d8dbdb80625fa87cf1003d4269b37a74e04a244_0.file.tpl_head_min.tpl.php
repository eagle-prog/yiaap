<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_head_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62acd4f1_67936357',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0d8dbdb80625fa87cf1003d4269b37a74e04a244' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_head_min.tpl',
      1 => 1554597360,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f62acd4f1_67936357 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en" class="no-js">
    <head profile="http://www.w3.org/2005/10/profile">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</title>
        <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['metaname_description']->value;?>
">
        <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['metaname_keywords']->value;?>
">
        <meta name="author" content="ViewShark.com">
        <link rel="icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/favicon.png">
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url_be']->value;?>
/init0.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/icheck/blue/icheck.min.css">
	<?php echo insert_loadbecssplugins(array(),$_smarty_tpl);?>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url_be']->value;?>
/mediaqueries.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/custom.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url_be']->value;?>
/theme/<?php echo $_smarty_tpl->tpl_vars['theme_name_be']->value;?>
_backend.min.css" id="be-color">
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/flagicon/css/flag-icon.min.css">
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/jquery.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>WebFont.load({google:{families:['Roboto:300,400,500,600,700']}});<?php echo '</script'; ?>
>
    </head>
<?php }
}

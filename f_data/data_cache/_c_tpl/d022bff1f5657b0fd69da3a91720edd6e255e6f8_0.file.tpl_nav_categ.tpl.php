<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:05
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_categ.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f595097c1_29310083',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd022bff1f5657b0fd69da3a91720edd6e255e6f8' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_categ.tpl',
      1 => 1541196000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f595097c1_29310083 (Smarty_Internal_Template $_smarty_tpl) {
?>                <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels") {
echo insert_channelsMenu(array(),$_smarty_tpl);
} else {
echo insert_categoryMenu(array(),$_smarty_tpl);
}
}
}

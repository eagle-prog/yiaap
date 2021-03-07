<?php
/* Smarty version 3.1.33, created on 2021-02-10 10:19:51
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_verify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6023f997b69045_80890019',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f8ce6109182aa036539209fd6f67d59b739f48ea' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_verify.tpl',
      1 => 1470085200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6023f997b69045_80890019 (Smarty_Internal_Template $_smarty_tpl) {
?>    <div id="ct-wrapper">
    	<?php if ($_smarty_tpl->tpl_vars['error_message']->value != '') {
echo $_smarty_tpl->tpl_vars['error_message']->value;
} elseif ($_smarty_tpl->tpl_vars['notice_message']->value != '') {
echo $_smarty_tpl->tpl_vars['notice_message']->value;
}?>
    </div>
<?php }
}

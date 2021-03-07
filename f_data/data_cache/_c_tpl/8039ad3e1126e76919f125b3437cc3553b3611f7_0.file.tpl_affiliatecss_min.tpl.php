<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:43:41
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_affiliatecss_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c789d816550_39036054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8039ad3e1126e76919f125b3437cc3553b3611f7' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_affiliatecss_min.tpl',
      1 => 1547827860,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c789d816550_39036054 (Smarty_Internal_Template $_smarty_tpl) {
if (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_affiliate" && $_SESSION['USER_AFFILIATE'] == 1) || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers" && $_SESSION['USER_PARTNER'] == 1)) {?>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/icheck/blue/icheckblue.min.css"><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/datepicker/tiny-date-picker.min.css"><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/datepicker/date-range-picker.min.css">
<?php }
}
}

<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:32:32
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_notify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2fb00dee26_81454317',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea74971d149c91b966da6259fd9996cb257b8075' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_notify.tpl',
      1 => 1458684000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2fb00dee26_81454317 (Smarty_Internal_Template $_smarty_tpl) {
?>	    <?php if ($_smarty_tpl->tpl_vars['error_message']->value != '') {
$_smarty_tpl->_assignInScope('notif_class', "error");
$_smarty_tpl->_assignInScope('the_message', $_smarty_tpl->tpl_vars['error_message']->value);
} elseif ($_smarty_tpl->tpl_vars['notice_message']->value != '') {
$_smarty_tpl->_assignInScope('notif_class', "notice");
$_smarty_tpl->_assignInScope('the_message', $_smarty_tpl->tpl_vars['notice_message']->value);
}?>
	    <!-- NOTIFICATION CONTAINER -->
	    <?php if ($_smarty_tpl->tpl_vars['error_message']->value != '' || $_smarty_tpl->tpl_vars['notice_message']->value != '') {?> 
		<div class="<?php echo $_smarty_tpl->tpl_vars['notif_class']->value;?>
-message" id="<?php echo $_smarty_tpl->tpl_vars['notif_class']->value;?>
-message" onclick="$(this).replaceWith(''); $('#cb-response').replaceWith(''); $('#cb-response-wrap').replaceWith(''); resizeDelimiter();">
		    <p class="<?php echo $_smarty_tpl->tpl_vars['notif_class']->value;?>
-message-text"><?php echo $_smarty_tpl->tpl_vars['the_message']->value;?>
</p>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">$(document).ready(function(){$(document).on("click","#<?php echo $_smarty_tpl->tpl_vars['notif_class']->value;?>
-message",function(){$("#<?php echo $_smarty_tpl->tpl_vars['notif_class']->value;?>
-message").replaceWith(""); $("#cb-response").replaceWith(""); $("#cb-response-wrap").replaceWith(""); resizeDelimiter(); });});<?php echo '</script'; ?>
>
	    <?php }?> <!-- END NOTIFICATION CONTAINER -->
<?php }
}

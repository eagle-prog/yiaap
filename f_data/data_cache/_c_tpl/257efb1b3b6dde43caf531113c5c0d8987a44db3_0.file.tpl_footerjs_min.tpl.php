<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_footerjs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62b2e2c5_43050794',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '257efb1b3b6dde43caf531113c5c0d8987a44db3' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_footerjs_min.tpl',
      1 => 1541455200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_menupaneljs.tpl' => 1,
  ),
),false)) {
function content_601c2f62b2e2c5_43050794 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
	<?php echo '<script'; ?>
>var section = '<?php echo $_smarty_tpl->tpl_vars['page_display']->value;?>
';var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/';var menu_section = '<?php echo smarty_function_href_entry(array('getKey'=>"be_settings"),$_smarty_tpl);?>
';<?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/init0.min.js"><?php echo '</script'; ?>
>
<?php if ($_SESSION['ADMIN_NAME'] != '') {?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/init1.min.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/init2.min.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
>new gnMenu(document.getElementById('gn-menu'));<?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">var menuLeft = document.getElementById('cbp-spmenu-s1'),menuBottom = document.getElementById('cbp-spmenu-s4'),showLeftPush = document.getElementById('showLeftPush'),body = document.body;showBottom.onclick = function () {classie.toggle(this, 'active');classie.toggle(menuBottom, 'cbp-spmenu-open');disableOther('showBottom');};showLeftPush.onclick = function () {classie.toggle(this, 'active');classie.toggle(body, 'cbp-spmenu-push-toright');classie.toggle(menuLeft, 'cbp-spmenu-open');disableOther('showLeftPush');jQuery(window).resize();};function disableOther(button) {if (button !== 'showBottom') {classie.toggle(showBottom, 'disabled');}if (button !== 'showLeftPush') {classie.toggle(showLeftPush, 'disabled');}}<?php echo '</script'; ?>
>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupaneljs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
	<?php echo insert_loadbejsplugins(array(),$_smarty_tpl);?>
	<?php echo '<script'; ?>
 type="text/javascript">$(document).on("click", ".messages_holder", function() {notif_url = '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_dashboard"),$_smarty_tpl);?>
?s=notif';$.fancybox({ type: "ajax", minWidth: "90%", minHeight: "75%", margin: 20, href: notif_url, wrapCSS: "notifications" });});$(document).ready(function() {$("#new-notifications-nr").load('<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_dashboard"),$_smarty_tpl);?>
?s=new');});<?php echo '</script'; ?>
>
<?php }
}

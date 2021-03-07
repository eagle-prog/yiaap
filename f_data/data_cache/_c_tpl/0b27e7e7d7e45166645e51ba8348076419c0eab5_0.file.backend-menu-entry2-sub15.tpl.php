<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:46:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub15.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8f9a80b423_40185631',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0b27e7e7d7e45166645e51ba8348076419c0eab5' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub15.tpl',
      1 => 1541196000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-keep-open.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
    'file:f_scripts/be/js/jquery.nouislider.init.js' => 1,
  ),
),false)) {
function content_601e8f9a80b423_40185631 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div>
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.sys",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry1_sub4_messaging_sys",'input_value'=>$_smarty_tpl->tpl_vars['internal_messaging']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.self",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry1_sub4_messaging_self",'input_value'=>$_smarty_tpl->tpl_vars['allow_self_messaging']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.multi",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub4_messaging_multi",'input_value'=>$_smarty_tpl->tpl_vars['allow_multi_messaging']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub4.messaging.limit",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry1_sub4_messaging_limit",'input_value'=>$_smarty_tpl->tpl_vars['multi_messaging_limit']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.attch",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry1_sub4_messaging_attch",'input_value'=>$_smarty_tpl->tpl_vars['message_attachments']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.labels",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_entry1_sub4_messaging_labels",'input_value'=>$_smarty_tpl->tpl_vars['custom_labels']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.counts",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub4_messaging_counts",'input_value'=>$_smarty_tpl->tpl_vars['message_count']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.friends",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry1_sub4_messaging_friends",'input_value'=>$_smarty_tpl->tpl_vars['user_friends']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.blocked",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry1_sub4_messaging_blocked",'input_value'=>$_smarty_tpl->tpl_vars['user_blocking']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub4.messaging.approval",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_entry1_sub4_messaging_approval",'input_value'=>$_smarty_tpl->tpl_vars['approve_friends']->value,'bb'=>0),$_smarty_tpl);?>

	    </div>
	    <div class="clearfix"></div>
	    <div>
		<div class="sortings left-half"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-keep-open.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-switch-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/jquery.nouislider.init.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function () {
		$('#slider-backend_menu_entry1_sub4_messaging_limit').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['multi_messaging_limit']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 50 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_entry1_sub4_messaging_limit").Link('lower').to($("input[name='backend_menu_entry1_sub4_messaging_limit']"));
	});
	<?php echo '</script'; ?>
>
<?php }
}

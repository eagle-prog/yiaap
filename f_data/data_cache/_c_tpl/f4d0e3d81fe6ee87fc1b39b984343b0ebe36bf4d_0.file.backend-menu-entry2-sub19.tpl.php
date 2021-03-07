<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:40:01
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub19.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8e215035f9_17137850',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4d0e3d81fe6ee87fc1b39b984343b0ebe36bf4d' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub19.tpl',
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
function content_601e8e215035f9_17137850 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.be.userrec",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub2_be_userrec",'input_value'=>$_smarty_tpl->tpl_vars['backend_username_recovery']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.be.passrec",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry1_sub2_be_passrec",'input_value'=>$_smarty_tpl->tpl_vars['backend_password_recovery']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub2.be.passrec.link",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_entry1_sub2_be_passrec_link",'input_value'=>$_smarty_tpl->tpl_vars['backend_recovery_link_lifetime']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.fe.userrec",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub2_fe_userrec",'input_value'=>$_smarty_tpl->tpl_vars['allow_username_recovery']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.fe.passrec",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry1_sub2_fe_passrec",'input_value'=>$_smarty_tpl->tpl_vars['allow_password_recovery']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub2.fe.passrec.link",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry1_sub2_fe_passrec_link",'input_value'=>$_smarty_tpl->tpl_vars['recovery_link_lifetime']->value,'bb'=>0),$_smarty_tpl);?>

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
	$(document).ready(function(){
		$('#slider-backend_menu_entry1_sub2_be_passrec_link').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['backend_recovery_link_lifetime']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 100 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_entry1_sub2_be_passrec_link").Link('lower').to($("input[name='backend_menu_entry1_sub2_be_passrec_link']"));
		$('#slider-backend_menu_entry1_sub2_fe_passrec_link').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['recovery_link_lifetime']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 100 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_entry1_sub2_fe_passrec_link").Link('lower').to($("input[name='backend_menu_entry1_sub2_fe_passrec_link']"));
	});
	<?php echo '</script'; ?>
><?php }
}

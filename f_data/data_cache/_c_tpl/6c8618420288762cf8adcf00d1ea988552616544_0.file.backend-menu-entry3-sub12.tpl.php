<?php
/* Smarty version 3.1.33, created on 2021-02-06 12:23:56
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry3-sub12.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ed0ac144868_07317009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6c8618420288762cf8adcf00d1ea988552616544' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry3-sub12.tpl',
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
function content_601ed0ac144868_07317009 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="wdmax" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div class="wdmax top-bottom-padding left-float">
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub3.sessname",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry2_sub3_sessname",'input_value'=>$_smarty_tpl->tpl_vars['session_name']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub3.sesslife",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry2_sub3_sesslife",'input_value'=>$_smarty_tpl->tpl_vars['session_lifetime']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="clearfix"></div>
	    <div class="wdmax top-bottom-padding left-float">
		<div class="sortings left-half"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-keep-open.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
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
		$('#slider-backend_menu_entry2_sub3_sesslife').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['session_lifetime']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 600 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_entry2_sub3_sesslife").Link('lower').to($("input[name='backend_menu_entry2_sub3_sesslife']"));
	});
	<?php echo '</script'; ?>
><?php }
}

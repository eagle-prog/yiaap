<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:56:00
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub24.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d94c0d7a068_63600966',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a0cc67b0164bac9e607de2a436380c579f950cb' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub24.tpl',
      1 => 1541628000,
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
  ),
),false)) {
function content_601d94c0d7a068_63600966 (Smarty_Internal_Template $_smarty_tpl) {
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
	    	<?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry6.sub1.conv.prev.l",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry6_sub1_conv_prev_l",'input_value'=>$_smarty_tpl->tpl_vars['conversion_live_previews']->value,'bb'=>1),$_smarty_tpl);?>

	    	<?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch",'entry_title'=>"backend.menu.entry6.sub1.conv.prev.v",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry6_sub1_conv_prev_v",'input_value'=>$_smarty_tpl->tpl_vars['conversion_video_previews']->value,'bb'=>1),$_smarty_tpl);?>

	    	<?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry6.sub1.conv.prev.i",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry6_sub1_conv_prev_i",'input_value'=>$_smarty_tpl->tpl_vars['conversion_image_previews']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    	<?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"switch",'entry_title'=>"backend.menu.entry6.sub1.conv.prev.a",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry6_sub1_conv_prev_a",'input_value'=>$_smarty_tpl->tpl_vars['conversion_audio_previews']->value,'bb'=>1),$_smarty_tpl);?>

	    	<?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.entry6.sub1.conv.prev.d",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry6_sub1_conv_prev_d",'input_value'=>$_smarty_tpl->tpl_vars['conversion_doc_previews']->value,'bb'=>1),$_smarty_tpl);?>

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
<?php }
}

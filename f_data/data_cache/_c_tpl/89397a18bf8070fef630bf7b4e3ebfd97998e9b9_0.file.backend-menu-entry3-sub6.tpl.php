<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:35:05
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry3-sub6.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c3049526527_94145747',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89397a18bf8070fef630bf7b4e3ebfd97998e9b9' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry3-sub6.tpl',
      1 => 1543960800,
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
function content_601c3049526527_94145747 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"conversion_image_type",'entry_title'=>"backend.menu.entry3.sub6.conv.entry",'entry_id'=>"ct-entry-details2",'input_name'=>'','input_value'=>'','bb'=>0),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry6.sub1.conv.que",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry6_sub1_conv_que",'input_value'=>$_smarty_tpl->tpl_vars['conversion_image_que']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="clearfix"></div>
	    <div class="wdmax top-bottom-padding left-float">
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
                $('.icheck-box input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        });
                });
                $('#slider-thanw').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['conversion_image_from_w']->value;?>
 ], step: 1, range: { 'min': [ 100 ], 'max': [ 2000 ] }, format:wNumb({ decimals: 0 }) });
        	$("#slider-thanw").Link('lower').to($("input[name='thanw']"));
                $('#slider-thanh').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['conversion_image_from_h']->value;?>
 ], step: 1, range: { 'min': [ 100 ], 'max': [ 2000 ] }, format:wNumb({ decimals: 0 }) });
        	$("#slider-thanh").Link('lower').to($("input[name='thanh']"));
                $('#slider-tow').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['conversion_image_to_w']->value;?>
 ], step: 1, range: { 'min': [ 100 ], 'max': [ 2000 ] }, format:wNumb({ decimals: 0 }) });
        	$("#slider-tow").Link('lower').to($("input[name='tow']"));
                $('#slider-toh').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['conversion_image_to_h']->value;?>
 ], step: 1, range: { 'min': [ 100 ], 'max': [ 2000 ] }, format:wNumb({ decimals: 0 }) });
        	$("#slider-toh").Link('lower').to($("input[name='toh']"));
        });
        <?php echo '</script'; ?>
><?php }
}

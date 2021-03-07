<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:56:03
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub21.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d94c319ddd0_78042461',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '490ae719f021d343dc3fd320a31fa6d8a4eb1ef9' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub21.tpl',
      1 => 1578349528,
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
function content_601d94c319ddd0_78042461 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"grabber_functions",'entry_title'=>"backend.import.menu.grabber.functions",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_import_menu_grabber_functions",'input_value'=>'','bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"text",'entry_title'=>"backend.import.yt.api.key",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_import_yt_api_key",'input_value'=>$_smarty_tpl->tpl_vars['youtube_api_key']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"textarea",'entry_title'=>"backend.import.menu.yt.list",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_import_menu_yt_list",'input_value'=>$_smarty_tpl->tpl_vars['import_yt_channel_list']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"textarea",'entry_title'=>"backend.import.menu.vi.list",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_import_menu_vi_list",'input_value'=>$_smarty_tpl->tpl_vars['import_vi_user_list']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"textarea",'entry_title'=>"backend.import.menu.dm.list",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_import_menu_dm_list",'input_value'=>$_smarty_tpl->tpl_vars['import_dm_user_list']->value,'bb'=>1),$_smarty_tpl);?>

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
        });
        <?php echo '</script'; ?>
>
<?php }
}

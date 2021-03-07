<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:30:36
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub6.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8bec762769_09270344',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '05791bebaa46e0e2f5387e715971f910bd21b625' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub6.tpl',
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
  ),
),false)) {
function content_601e8bec762769_09270344 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div>
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>
	    
	    <div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub6.admin.user",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry2_sub6_admin_user",'input_value'=>$_smarty_tpl->tpl_vars['backend_username']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"password",'entry_title'=>"backend.menu.entry2.sub6.admin.new.pass",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry2_sub6_admin_new_pass",'input_value'=>'','bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"password",'entry_title'=>"backend.menu.entry2.sub6.admin.conf.pass",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry2_sub6_admin_conf_pass",'input_value'=>'','bb'=>0),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"switch",'entry_title'=>"backend.menu.entry2.sub4.IPaccess.be",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry2_sub4_IPaccess_be",'input_value'=>$_smarty_tpl->tpl_vars['backend_ip_based_access']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php ob_start();
$_smarty_tpl->assign('iplist' , insert_getListContent (array('from' => 'ip-backend'),$_smarty_tpl), true);
$_prefixVariable1=ob_get_clean();
echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"textarea",'entry_title'=>"backend.menu.entry2.sub4.IPlist.be",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_entry2_sub4_IPlist_be",'input_value'=>$_prefixVariable1.((string)$_smarty_tpl->tpl_vars['iplist']->value),'bb'=>1),$_smarty_tpl);?>

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

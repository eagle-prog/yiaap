<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:44:33
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub4.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8f31d395a8_20747477',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98db077fb990605f837fe9b18c15e7197e8b3050' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub4.tpl',
      1 => 1554857160,
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
function content_601e8f31d395a8_20747477 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry2.sub4.IPaccess",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry2_sub4_IPaccess",'input_value'=>$_smarty_tpl->tpl_vars['website_ip_based_access']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php ob_start();
$_smarty_tpl->assign('iplist' , insert_getListContent (array('from' => 'ip-access'),$_smarty_tpl), true);
$_prefixVariable1=ob_get_clean();
echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"textarea",'entry_title'=>"backend.menu.entry2.sub4.IPlist",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry2_sub4_IPlist",'input_value'=>$_prefixVariable1.((string)$_smarty_tpl->tpl_vars['iplist']->value),'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry2.sub4.offmode",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry2_sub4_offmode",'input_value'=>$_smarty_tpl->tpl_vars['website_offline_mode']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"offline_slides",'entry_title'=>"backend.menu.entry2.sub4.offmsg",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry2_sub4_offmsg",'input_value'=>$_smarty_tpl->tpl_vars['website_offline_message']->value,'bb'=>0),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub4.offuntil",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry2_sub4_offuntil",'input_value'=>$_smarty_tpl->tpl_vars['offline_mode_until']->value,'bb'=>1),$_smarty_tpl);?>

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
 type="text/javascript">$(document).ready(function(){$("a.sml-add").click(function(){lid=document.getElementById("url-entry-details-list").childElementCount;lid+=1;nht=ht.replace(/#NR#/g,lid).replace(/#V1#/g, '').replace(/#V2#/g, '').replace(/#V3#/g, '');$("#url-entry-details-list").append(nht);});});<?php echo '</script'; ?>
>
<?php }
}

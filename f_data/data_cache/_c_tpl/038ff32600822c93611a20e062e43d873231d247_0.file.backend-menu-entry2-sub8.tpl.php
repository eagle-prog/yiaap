<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:44:38
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub8.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8f36c01799_32699200',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '038ff32600822c93611a20e062e43d873231d247' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub8.tpl',
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
function content_601e8f36c01799_32699200 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet15",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.l",'entry_id'=>"ct-entry-details15",'input_name'=>"backend_menu_entry1_sub13_guest_browse_l",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_live']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet16",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.l",'entry_id'=>"ct-entry-details16",'input_name'=>"backend_menu_entry1_sub13_guest_view_l",'input_value'=>$_smarty_tpl->tpl_vars['guest_view_live']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.v",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry1_sub13_guest_browse_v",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_video']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.v",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry1_sub13_guest_view_v",'input_value'=>$_smarty_tpl->tpl_vars['guest_view_video']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.i",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry1_sub13_guest_browse_i",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_image']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.i",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_entry1_sub13_guest_view_i",'input_value'=>$_smarty_tpl->tpl_vars['guest_view_image']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.a",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub13_guest_browse_a",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_audio']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.a",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub13_guest_view_a",'input_value'=>$_smarty_tpl->tpl_vars['guest_view_audio']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet13",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.b",'entry_id'=>"ct-entry-details13",'input_name'=>"backend_menu_entry1_sub13_guest_browse_b",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_blog']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet14",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.b",'entry_id'=>"ct-entry-details14",'input_name'=>"backend_menu_entry1_sub13_guest_view_b",'input_value'=>$_smarty_tpl->tpl_vars['guest_view_blog']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.d",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry1_sub13_guest_browse_d",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_doc']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.d",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry1_sub13_guest_view_d",'input_value'=>$_smarty_tpl->tpl_vars['guest_view_doc']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.ch",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry1_sub13_guest_browse_ch",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_channel']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.c",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_entry1_sub13_guest_view_c",'input_value'=>$_smarty_tpl->tpl_vars['guest_view_channel']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet12",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.view.s",'entry_id'=>"ct-entry-details12",'input_name'=>"backend_menu_entry1_sub13_guest_view_s",'input_value'=>$_smarty_tpl->tpl_vars['guest_search_page']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet11",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub13.guest.browse.pl",'entry_id'=>"ct-entry-details11",'input_name'=>"backend_menu_entry1_sub13_guest_browse_pl",'input_value'=>$_smarty_tpl->tpl_vars['guest_browse_playlist']->value,'bb'=>1),$_smarty_tpl);?>

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

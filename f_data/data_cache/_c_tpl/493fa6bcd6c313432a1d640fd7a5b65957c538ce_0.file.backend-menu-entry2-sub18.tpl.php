<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:38:42
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub18.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8dd2a433a7_57162328',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '493fa6bcd6c313432a1d640fd7a5b65957c538ce' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub18.tpl',
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
function content_601e8dd2a433a7_57162328 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet0",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.fb.module",'entry_id'=>"ct-entry-details0",'input_name'=>"backend_menu_entry1_sub3_fb_module",'input_value'=>$_smarty_tpl->tpl_vars['fb_auth']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub3.fb.appid",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub3_fb_appid",'input_value'=>$_smarty_tpl->tpl_vars['fb_app_id']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub3.fb.secret",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry1_sub3_fb_secret",'input_value'=>$_smarty_tpl->tpl_vars['fb_app_secret']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.gp.module",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry1_sub3_gp_module",'input_value'=>$_smarty_tpl->tpl_vars['gp_auth']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub3.gp.appid",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_entry1_sub3_gp_appid",'input_value'=>$_smarty_tpl->tpl_vars['gp_app_id']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet11",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub3.gp.secret",'entry_id'=>"ct-entry-details11",'input_name'=>"backend_menu_entry1_sub3_gp_secret",'input_value'=>$_smarty_tpl->tpl_vars['gp_app_secret']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.fe.signin",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub3_fe_signin",'input_value'=>$_smarty_tpl->tpl_vars['frontend_signin_section']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.fe.signin.ct",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_entry1_sub3_fe_signin_ct",'input_value'=>$_smarty_tpl->tpl_vars['frontend_signin_count']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.fe.signin.rem",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry1_sub3_fe_signin_rem",'input_value'=>$_smarty_tpl->tpl_vars['login_remember']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.be.signin",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry1_sub3_be_signin",'input_value'=>$_smarty_tpl->tpl_vars['backend_signin_section']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.be.signin.ct",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry1_sub3_be_signin_ct",'input_value'=>$_smarty_tpl->tpl_vars['backend_signin_count']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub3.be.signin.rem",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry1_sub3_be_signin_rem",'input_value'=>$_smarty_tpl->tpl_vars['backend_remember']->value,'bb'=>1),$_smarty_tpl);?>

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

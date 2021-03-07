<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:55:39
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub20.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d94ab852568_70173898',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ba88df9e04555550921d907e50f93562dc2448ab' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub20.tpl',
      1 => 1544047200,
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
function content_601d94ab852568_70173898 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet0",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub1.recaptcha.key",'entry_id'=>"ct-entry-details0",'input_name'=>"backend_menu_entry1_sub1_recaptcha_key",'input_value'=>$_smarty_tpl->tpl_vars['recaptcha_site_key']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet13",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub1.captcha.l.b",'entry_id'=>"ct-entry-details13",'input_name'=>"backend_menu_entry1_sub1_captcha_l_b",'input_value'=>$_smarty_tpl->tpl_vars['signin_captcha_be']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.be.passrec.ver",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry1_sub2_be_passrec_ver",'input_value'=>$_smarty_tpl->tpl_vars['backend_password_recovery_captcha']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.be.userrec.ver",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub2_be_userrec_ver",'input_value'=>$_smarty_tpl->tpl_vars['backend_username_recovery_captcha']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet11",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub1.captcha",'entry_id'=>"ct-entry-details11",'input_name'=>"backend_menu_entry1_sub1_captcha",'input_value'=>$_smarty_tpl->tpl_vars['signup_captcha']->value,'bb'=>1),$_smarty_tpl);?>

            </div>
            <div class="vs-column half fit vs-mask">
            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub1.recaptcha.secret",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry1_sub1_recaptcha_secret",'input_value'=>$_smarty_tpl->tpl_vars['recaptcha_secret_key']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet12",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub1.captcha.l",'entry_id'=>"ct-entry-details12",'input_name'=>"backend_menu_entry1_sub1_captcha_l",'input_value'=>$_smarty_tpl->tpl_vars['signin_captcha']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.fe.passrec.ver",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry1_sub2_fe_passrec_ver",'input_value'=>$_smarty_tpl->tpl_vars['password_recovery_captcha']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.fe.userrec.ver",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub2_fe_userrec_ver",'input_value'=>$_smarty_tpl->tpl_vars['username_recovery_captcha']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub5.em.captcha",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry1_sub5_em_captcha",'input_value'=>$_smarty_tpl->tpl_vars['email_change_captcha']->value,'bb'=>1),$_smarty_tpl);?>

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
	$(function() {
		SelectList.init("backend_menu_entry1_sub2_be_passrec_lev");
		SelectList.init("backend_menu_entry1_sub2_be_userrec_lev");
		SelectList.init("backend_menu_entry1_sub1_captchalevel");
		SelectList.init("backend_menu_entry1_sub2_fe_passrec_lev");
		SelectList.init("backend_menu_entry1_sub2_fe_userrec_lev");
		SelectList.init("backend_menu_entry1_sub5_em_captcha_lev");
	});
	<?php echo '</script'; ?>
><?php }
}

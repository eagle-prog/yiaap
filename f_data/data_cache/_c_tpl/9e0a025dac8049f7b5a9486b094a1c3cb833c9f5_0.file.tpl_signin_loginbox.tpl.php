<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_auth/tpl_signin_loginbox.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62af30e4_18671159',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9e0a025dac8049f7b5a9486b094a1c3cb833c9f5' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_auth/tpl_signin_loginbox.tpl',
      1 => 1544047200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f62af30e4_18671159 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
if ($_smarty_tpl->tpl_vars['signin_captcha_be']->value == "1") {
echo '<script'; ?>
 type="text/javascript" src="https://www.google.com/recaptcha/api.js"><?php echo '</script'; ?>
><?php }?>
		    <div class="outer-border-wrapper">
			<div class="inner-wrapper center">
                            <?php if (($_smarty_tpl->tpl_vars['global_section']->value == "frontend" && $_smarty_tpl->tpl_vars['frontend_signin_section']->value == "1") || ($_smarty_tpl->tpl_vars['global_section']->value == "backend" && $_smarty_tpl->tpl_vars['backend_signin_section']->value == "1")) {?>
			    <form id="signin-form" class="user-form" method="post" action="<?php if ($_smarty_tpl->tpl_vars['global_section']->value == "frontend") {
echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signin"),$_smarty_tpl);
if ($_GET['next'] != '') {?>?next=<?php echo smarty_modifier_sanitize($_GET['next']);
}
}?>">
				<article>
					<h3 class="content-title"><i class="icon-user"></i> <?php if ($_smarty_tpl->tpl_vars['global_section']->value == "frontend") {
echo smarty_function_lang_entry(array('key'=>"frontend.signin.text8"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.login.intro.text"),$_smarty_tpl);
}?></h3>
					<div class="line"></div>
				</article>
				<?php echo $_smarty_tpl->tpl_vars['error_message']->value;?>

				<div class="row">
				    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.username"),$_smarty_tpl);?>
: </span>
				    <span class="input-signin"><input <?php echo $_smarty_tpl->tpl_vars['disabled_input']->value;?>
 type="text" class="text-input login-input" name="frontend_signin_username" /></span>
				</div>
				<div class="row">
				    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.password"),$_smarty_tpl);?>
: </span>
				    <span class="input-signin"><input <?php echo $_smarty_tpl->tpl_vars['disabled_input']->value;?>
 type="password" class="text-input" name="frontend_signin_password" onclick="this.select();" /></span>
				</div>
				<?php if (($_smarty_tpl->tpl_vars['global_section']->value == "frontend" && $_smarty_tpl->tpl_vars['login_remember']->value == "1") || ($_smarty_tpl->tpl_vars['global_section']->value == "backend" && $_smarty_tpl->tpl_vars['backend_remember']->value == "1")) {?>
				<div class="row">
					<span class="label-signin no-top-margin icheck-box"><input <?php echo $_smarty_tpl->tpl_vars['disabled_input']->value;?>
 type="checkbox" name="signin_remember" value="1" <?php if ($_POST['signin_remember']) {?>checked="checked"<?php }?> /></span>
					<span class="input-signin top-padding2"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.remember"),$_smarty_tpl);?>
</span>
				</div>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['signin_captcha_be']->value == "1") {?>
                                <div class="captcha-row">
                                    <span class="label-signin"></span>
                                    <span class="input-signin"><div class="g-recaptcha" data-sitekey="<?php echo $_smarty_tpl->tpl_vars['recaptcha_site_key']->value;?>
" style="transform:scale(0.99);-webkit-transform:scale(0.99);transf
                                </div>
                                <?php }?>
				<div class="clearfix"></div>
				<div class="row form-buttons">
				    <span class="label-signin"></span>
				    <span class="input-signin"><button <?php echo $_smarty_tpl->tpl_vars['disabled_input']->value;?>
 class="search-button form-button" value="1" name="frontend_global_submit"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signin"),$_smarty_tpl);?>
</span></button></span>
				</div>
			    </form>
                            <?php } else { ?>
				<article>
					<h3 class="content-title"><i class="icon-user"></i> <?php echo smarty_function_lang_entry(array('key'=>'frontend.signin.text11'),$_smarty_tpl);?>
</h3>
					<div class="line"></div>
				</article>
                            <?php }?>
			</div>
		    </div>
<?php }
}

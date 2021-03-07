<?php
/* Smarty version 3.1.33, created on 2021-02-26 06:04:05
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_register.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60388f55990f04_87039013',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '328e75cf1a210f554a4ea7d7e8fb2ef9fe9b7fca' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_register.tpl',
      1 => 1614319317,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_auth/tpl_payment_packlist.tpl' => 1,
  ),
),false)) {
function content_60388f55990f04_87039013 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
			<?php if ($_smarty_tpl->tpl_vars['signup_captcha']->value == "1") {
echo '<script'; ?>
 type="text/javascript" src="https://www.google.com/recaptcha/api.js"><?php echo '</script'; ?>
><?php }?>
                    <div class="outer-border-wrapper">
			<div class="inner-wrapper center">
                            <?php if ($_smarty_tpl->tpl_vars['global_signup']->value == "0" || $_smarty_tpl->tpl_vars['do_disable']->value == "yes") {?>
				<article>
                                        <h3 class="content-title"><i class="icon-user"></i> <?php echo $_smarty_tpl->tpl_vars['disabled_signup_message']->value;?>
</h3>
                                        <div class="line"></div>
                                </article>
                            <?php } else { ?>
			    <form id="register-form" class="user-form entry-form-class" method="post" action="">
				<article>
                                        <h3 class="content-title"><i class="icon-user"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.signup.h1"),$_smarty_tpl);?>
</h3>
                                        <div class="line"></div>
                                </article>
                                <?php if ($_smarty_tpl->tpl_vars['error_message']->value != '') {
echo $_smarty_tpl->tpl_vars['error_message']->value;
} elseif ($_smarty_tpl->tpl_vars['notice_message']->value != '') {
echo $_smarty_tpl->tpl_vars['notice_message']->value;
}?>
                                <?php if ($_smarty_tpl->tpl_vars['notice_message']->value == '') {?>
                <div class="row">
				    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.usertype"),$_smarty_tpl);?>
:</span>
				    <span class="input-signin"><select id="signup-usertype" name="frontend_signup_usertype"><option value='user'>User</option><option value='creator'>Creator</option><option value='business'>Business</option></select></span>
				</div>
				<div class="row">
				    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.username"),$_smarty_tpl);?>
: </span><?php if ($_smarty_tpl->tpl_vars['signup_username_availability']->value == "1") {?><span id="check-response"></span><?php }?>
				    <span class="input-signin"><input type="text" id="signup-username" class="text-input login-input" name="frontend_signin_username" value="<?php if ($_POST['frontend_signin_username']) {
echo smarty_modifier_sanitize($_POST['frontend_signin_username']);
}?>"></span>
				</div>
                                <div class="row">
				    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signup.emailadd"),$_smarty_tpl);?>
: </span>
				    <span class="input-signin"><input type="text" class="text-input login-input" name="frontend_signup_emailadd" value="<?php if ($_POST['frontend_signup_emailadd']) {
echo smarty_modifier_sanitize($_POST['frontend_signup_emailadd']);
}?>"></span>
				</div>
				<div class="row">
				    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.password"),$_smarty_tpl);?>
: </span>
				    <span class="input-signin"><input type="password" class="text-input" name="frontend_signup_setpass" onclick="this.select();" onfocus="if(this.value == '<?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.password"),$_smarty_tpl);?>
1') { this.value = ''; }" onblur="if(this.value == '') { this.value = '<?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.password"),$_smarty_tpl);?>
1'; }" <?php if ($_smarty_tpl->tpl_vars['signup_password_meter']->value == "1") {?>onkeyup="updatePasswordStrength_new(this,'passwdRating',{ 'text':2 });"<?php }?> /></span>
                                    <?php if ($_smarty_tpl->tpl_vars['signup_password_meter']->value == "1") {?>
                                        <div class="row no-top-padding">
                                            <div class="label-signup"></div>
                                            <div class="input-signup">
                                                <div id="passwdRating">
                                                    <div id="pass_meter" class="pass_meter"><div class="pass_meter_base"></div></div>
                                                    <div id="ps-rating"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
				</div>
				<div class="row">
				    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.signup.setpassagain"),$_smarty_tpl);?>
: </span>
				    <span class="input-signin"><input type="password" class="text-input" name="frontend_signup_setpassagain" onclick="this.select();" /></span>
				</div>
				<?php if ($_smarty_tpl->tpl_vars['paid_memberships']->value == "1") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_auth/tpl_payment_packlist.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['signup_captcha']->value == "1") {?>
				<div class="captcha-row">
				    <span class="label-signin"></span>
				    <span class="input-signin"><div class="g-recaptcha" data-sitekey="<?php echo $_smarty_tpl->tpl_vars['recaptcha_site_key']->value;?>
" style="transform:scale(0.99);-webkit-transform:scale(0.99);transform-origin:0 0;-webkit-transform-origin:0 0;"></div></span>
				</div>
				<?php }?>
				<div class="row form-buttons">
				    <span class="label-signin"></span>
				    <span class="input-signin">
				    	<button type="submit" class="search-button form-button submit" value="1" name="frontend_global_submit" style="width:100%"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.signup.create"),$_smarty_tpl);?>
</span></button>
				    </span>
				</div>
			    </form>
				<div class="row form-buttons">
				    <span class="label-signin"></span>
				    <span class="input-signin">
				    	<?php if ($_smarty_tpl->tpl_vars['fb_auth']->value == "1" || $_smarty_tpl->tpl_vars['gp_auth']->value == "1") {?>
				    	<div class="hr"><div class="inner"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.or"),$_smarty_tpl);?>
</div></div>
				    	<?php if ($_GET['u'] == '') {?>
				    	<center>
				    		<?php echo $_smarty_tpl->tpl_vars['fb_register']->value;?>

				    		<?php echo $_smarty_tpl->tpl_vars['gp_register']->value;?>

				    	</center>
				    	<?php } else { ?>
				    		<?php echo $_smarty_tpl->tpl_vars['fb_register']->value;?>

				    		<?php echo $_smarty_tpl->tpl_vars['gp_register']->value;?>

				    		<a href="#upopup" id="inline" class="hidden" rel="nofollow"></a>
				    		<div id="upopup" style="display: none;">
				    			<div class="lb-margins">
				    				<article>
				    					<h3 class="content-title"><i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"frontend.signup.fbusername"),$_smarty_tpl);?>
</h3>
				    					<div class="line"></div>
				    				</article>
				    				<form id="auth-register-form" class="entry-form-class">
				    					<h4><i class="icon-info"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.signup.fbcomplete"),$_smarty_tpl);?>
</h4>
				    					<input name="auth_confirm" type="hidden" value="0">
				    					<input name="auth_userid" type="hidden" class="form-control" placeholder="" value="<?php if ($_SESSION['fb_user']['id'] > 0) {
echo $_SESSION['fb_user']['id'];
} elseif ($_SESSION['gp_user']['id'] > 0) {
echo $_SESSION['gp_user']['id'];
}?>">
				    					<input name="auth_username" type="text" class="form-control" placeholder="" value="">
				    					<div class="auth-username-check-response"></div>
				    					<span class="input-signin">
				    						<button class="search-button form-button auth-check-button auth-username-check-btn" value="1" name="frontend_global_check" type="button"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.check"),$_smarty_tpl);?>
</span></button>
				    						<button class="search-button form-button apply-button" name="auth-submit-register" id="auth-register-submit" type="button"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.submit"),$_smarty_tpl);?>
</button>
				    					</span>
				    				</form>
				    			</div>
				    		</div>
				    	<?php }?>
				    	<?php }?>
				    </span>
				</div>
				<?php }?>
                            <?php }?>
			</div>
		    </div>
			<?php echo '<script'; ?>
>
                $('#register-form').captcha();
            <?php echo '</script'; ?>
>
            <style>
                #captchaInput {
                    width: 2.5em;
                    margin-left: .5em;
                    height: 1.8rem;
					padding: 5px;
                }

				#bot_label {
                    padding-right: 10px;
                }

				.captcha_div {
                    padding-top: 5px;
					padding-bottom: 20px;
                }

				.captcha_div label {
					color: #505050;
					font-family: "Roboto",sans-serif;
					font-weight: 400;
					font-size: 16px;
				}

				span.input-signin button.search-button.form-button {
                    margin-left: 0px;
                }
                
                #signup-usertype {
					background: none repeat scroll 0 0 #f5f5f5;
					border: medium none;
					box-shadow: 0 2px 3px rgb(0 0 0 / 10%) inset;
					clear: both;
					font-size: .75rem;
					margin-bottom: 5px;
					padding: 15px;
					width: 100%;
					-webkit-appearance: none;
					-moz-appearance: none;
					appearance: none;       /* Remove default arrow */
				}
				select option {
					padding: 10px!important;
					font-size: 17px;
				}
            </style><?php }
}

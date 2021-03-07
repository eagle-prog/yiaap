<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_auth/tpl_recovery.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62b14473_23150841',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '21c971ef3b4ae611faa16db3234e891cda8fac87' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_auth/tpl_recovery.tpl',
      1 => 1554341880,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f62b14473_23150841 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
			    <?php if ($_GET['s'] != '' && $_GET['id'] != '') {?>
			    <div class="login-page">
				<div class="outer-border-wrapper" style="border-top: 1px solid #d8dbdd;">
				    <form id="password-recovery-form" class="recovery-form user-form" method="post" action="">
                                            <article>
                                            	<h3 class="content-title">
                                            		<i class="icon-user"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.recovery.recovery.password"),$_smarty_tpl);?>

                                            	</h3>
                                            	<div class="line"></div>
                                            </article>
                                            <?php if ($_smarty_tpl->tpl_vars['error_message']->value != '') {
echo $_smarty_tpl->tpl_vars['error_message']->value;
} elseif ($_smarty_tpl->tpl_vars['notice_message']->value != '') {
echo $_smarty_tpl->tpl_vars['notice_message']->value;
}?>
                                            <?php if ($_smarty_tpl->tpl_vars['tpl_error_max']->value == '') {?>
				    
					<div class="">
					    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.username"),$_smarty_tpl);?>
: </span>
					    <span class="input-signin"><?php if ($_smarty_tpl->tpl_vars['global_section']->value == "frontend") {
echo $_smarty_tpl->tpl_vars['recovery_username']->value['uname'];
} else {
echo $_smarty_tpl->tpl_vars['recovery_username']->value;
}?></span>
					</div>
					<div class="">
					    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"recovery.forgot.new.password"),$_smarty_tpl);?>
: </span>
					    <span class="input-signin"><input type="password" id="recover-password-input" name="recovery_forgot_new_password" class="text-input" /></span>
					</div>
					<div class="">
					    <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"recovery.forgot.retype.password"),$_smarty_tpl);?>
: </span>
					    <span class="input-signin"><input type="password" id="reenter-password-input" name="recovery_forgot_retype_password" class="text-input" /></span>
					</div>
					<div class="form-buttons">
					    <span class="input-signin"></span>
					    <span class="input-signin">
					    	<button class="search-button form-button" name="reset_password" id="reset-password-button" type="submit" value="1"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.submit"),$_smarty_tpl);?>
</button>
					    </span>
					</div>
				    </form>
				    	    <?php }?>
				</div>
			</div>
			    <?php } else { ?>
				<?php if (($_smarty_tpl->tpl_vars['password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend")) {?> <?php $_smarty_tpl->_assignInScope('extra_l', 1);?>
				<?php } elseif (($_smarty_tpl->tpl_vars['backend_password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {
$_smarty_tpl->_assignInScope('extra_l', 3);?> <?php }?>
				<?php if (($_smarty_tpl->tpl_vars['username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend")) {?> <?php $_smarty_tpl->_assignInScope('extra_r', 2);?>
				<?php } elseif (($_smarty_tpl->tpl_vars['backend_username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {
$_smarty_tpl->_assignInScope('extra_r', 4);?> <?php }?>
				<?php echo '<script'; ?>
 type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer><?php echo '</script'; ?>
>
				<?php echo '<script'; ?>
>
      var recaptcha1;
      var recaptcha2;
      var myCallBack = function() {
      <?php if (($_smarty_tpl->tpl_vars['allow_password_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_password_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
      	<?php if (($_smarty_tpl->tpl_vars['password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
        recaptcha1 = grecaptcha.render('recaptcha1', {
          'sitekey' : '<?php echo $_smarty_tpl->tpl_vars['recaptcha_site_key']->value;?>
',
          'theme' : 'light'
        });
        <?php }?>
      <?php }?>
      <?php if (($_smarty_tpl->tpl_vars['allow_username_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_username_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
        <?php if (($_smarty_tpl->tpl_vars['username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
        recaptcha2 = grecaptcha.render('recaptcha2', {
          'sitekey' : '<?php echo $_smarty_tpl->tpl_vars['recaptcha_site_key']->value;?>
',
          'theme' : 'light'
        });
        <?php }?>
      <?php }?>
      };
    <?php echo '</script'; ?>
>


				<div class="">
                                    <div class="outer-border-wrapper" id="recover-password-mask">
                                        <form id="password-recovery-form" class="user-form" action="" method="post">
                                        <?php if (($_smarty_tpl->tpl_vars['allow_password_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_password_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
                                            <article>
                                            	<h3 class="content-title">
                                            		<i class="icon-user"></i> <?php if ($_smarty_tpl->tpl_vars['global_section']->value == "frontend") {
echo smarty_function_lang_entry(array('key'=>"recovery.forgot.password"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.recovery.forgot.password"),$_smarty_tpl);
}?>
                                            	</h3>
                                            	<div class="line"></div>
                                            	<span class="label-signin" style="line-height:20px"><?php if ($_smarty_tpl->tpl_vars['global_section']->value == "frontend") {
echo smarty_function_lang_entry(array('key'=>"recovery.forgot.pass.txt"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.recovery.forgot.pass.txt"),$_smarty_tpl);
}
if ($_smarty_tpl->tpl_vars['password_recovery_captcha']->value == "1") {
echo smarty_function_lang_entry(array('key'=>"recovery.verif.code.txt"),$_smarty_tpl);
}
echo smarty_function_lang_entry(array('key'=>"recovery.forgot.pass.txt1"),$_smarty_tpl);?>
</span>
                                            </article>
                                            <div id="recover-password-response" class=""></div>
                                            <div class="inner-wrapper center">
                                                
                                                    <div class="row">
                                                        <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.username"),$_smarty_tpl);?>
: </span>
                                                        <span class="input-signin"><input type="text" id="recover-password-input" name="rec_username" class="text-input" <?php echo $_smarty_tpl->tpl_vars['left_disabled']->value;?>
 /></span>
                                                    </div>
                                                    <?php if (($_smarty_tpl->tpl_vars['password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
                                                    	<div class="row" style="margin-top: 10px;">
                                                        	<span class="label-signin"></span>
                                                        	<span class="input-signin"><div id="recaptcha1" style="margin-top: 10px; margin-bottom: 15px; transform:scale(0.99);-webkit-transform:scale(0.99);transform-origin:0 0;-webkit-transform-origin:0 0;"></div></span>
                                                    	</div>
                                                    <?php }?>
                                                    <div class="clearfix"></div>
                                                    <div class="">
                                                        <span class="label-signin"></span>
                                                        <span class="input-signin">
                                                            <button class="search-button form-button" name="recover_password" id="recover-password-button" type="button" value="1" <?php echo $_smarty_tpl->tpl_vars['left_disabled']->value;?>
><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.submit"),$_smarty_tpl);?>
</button>
                                                        </span>
                                                    </div>
                                                </form>
                                           </div>
                                       </div>
                                        <?php } else { ?>
                                            <article>
                                            	<h3 class="content-title">
                                            		<i class="icon-user"></i> <?php echo smarty_function_lang_entry(array('key'=>'recovery.disabled.password'),$_smarty_tpl);?>

                                            	</h3>
                                            	<div class="line"></div>
                                            </article>
                                        <?php }?>        
                                    </div>

                                    
                                        <div class="outer-border-wrapper" id="recover-username-mask">
                                        <form id="username-recovery-form" class="user-form" action="" method="post">
                                            <?php if (($_smarty_tpl->tpl_vars['allow_username_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_username_recovery']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
                                            	<article>
                                            		<h3 class="content-title"><i class="icon-user"></i> <?php if ($_smarty_tpl->tpl_vars['global_section']->value == "frontend") {
echo smarty_function_lang_entry(array('key'=>"recovery.forgot.username"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.recovery.forgot.username"),$_smarty_tpl);
}?></h3>
                                            		<div class="line"></div>
                                            		<span class="label-signin" style="line-height:20px"><?php if ($_smarty_tpl->tpl_vars['global_section']->value == "frontend") {
echo smarty_function_lang_entry(array('key'=>"recovery.forgot.user.txt"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.recovery.forgot.user.txt"),$_smarty_tpl);
}
if ($_smarty_tpl->tpl_vars['username_recovery_captcha']->value == "1") {
echo smarty_function_lang_entry(array('key'=>"recovery.verif.code.txt"),$_smarty_tpl);
}
echo smarty_function_lang_entry(array('key'=>"recovery.forgot.user.txt1"),$_smarty_tpl);?>
</span>
                                            	</article>
                                            	<div id="recover-username-response" class=""></div>
                                                <div class="inner-wrapper center">
                                                        <div class="">
                                                            <span class="label-signin"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.email"),$_smarty_tpl);?>
: </span>
                                                            <span class="input-signin"><input type="text" id="recover-username-input" name="rec_email" class="text-input" <?php echo $_smarty_tpl->tpl_vars['right_disabled']->value;?>
 /></span>
                                                        </div>
                                                        <?php if (($_smarty_tpl->tpl_vars['username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
                                                        	<div class="row" style="margin-top: 10px;">
                                                        		<span class="label-signin"></span>
                                                        		<span class="input-signin"><div id="recaptcha2" style="margin-top: 10px; margin-bottom: 15px; transform:scale(0.99);-webkit-transform:scale(0.99);transform-origin:0 0;-webkit-transform-origin:0 0;"></div></span>
                                                    		</div>
                                                        <?php }?>
                                                        <div class="clearfix"></div>
                                                        <div class="">
                                                            <span class="label-signin"></span>
                                                            <span class="input-signin">
                                                                <button class="search-button form-button" name="recover_username" id="recover-username-button" type="button" value="1" <?php echo $_smarty_tpl->tpl_vars['right_disabled']->value;?>
><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.submit"),$_smarty_tpl);?>
</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </form>
                                             </div>
                                            <?php } else { ?>
                                            <article>
                                            	<h3 class="content-title">
                                            		<i class="icon-user"></i> <?php echo smarty_function_lang_entry(array('key'=>'recovery.disabled.username'),$_smarty_tpl);?>

                                            	</h3>
                                            	<div class="line"></div>
                                            </article>
                                            <?php }?>
                                        </div>
                                </div>
                            <?php }
}
}

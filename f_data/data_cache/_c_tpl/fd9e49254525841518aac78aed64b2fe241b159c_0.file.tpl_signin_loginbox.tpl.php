<?php
/* Smarty version 3.1.33, created on 2021-03-01 03:04:22
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_signin_loginbox.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_603c59b6c5eb22_99591095',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fd9e49254525841518aac78aed64b2fe241b159c' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_signin_loginbox.tpl',
      1 => 1614567839,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603c59b6c5eb22_99591095 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
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
				<input type='hidden' name="contest_redirect" value="<?php echo $_smarty_tpl->tpl_vars['contest_redirection']->value;?>
" />
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
				<?php if ($_smarty_tpl->tpl_vars['signin_captcha']->value == "1") {?>
                                <div class="captcha-row">
                                    <span class="label-signin"></span>
                                    <span class="input-signin"><div class="g-recaptcha" data-sitekey="<?php echo $_smarty_tpl->tpl_vars['recaptcha_site_key']->value;?>
" style="transform:scale(0.99);-webkit-transform:scale(0.99);transf
                                </div>
                                <?php }?>

				<div class="clearfix"></div>
				<div class="row form-buttons">
				<?php if ($_smarty_tpl->tpl_vars['fb_auth']->value == "1" || $_smarty_tpl->tpl_vars['gp_auth']->value == "1") {?>
		    		<?php echo '<script'; ?>
 type="text/javascript">
		    			function popupwindow(url, title, win, w, h) {
		    				var y = window.top.outerHeight / 2 + window.top.screenY - ( h / 2);
		    				var x = window.top.outerWidth / 2 + window.top.screenX - ( w / 2);
		    				winpop = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+y+', left='+x);
		    			}
                                <?php echo '</script'; ?>
>
                                <?php }?>
				    <span class="label-signin"></span>
				    <span class="input-signin">
					<center>
				    	<button class="search-button form-button submit" value="1" name="frontend_global_submit" style="width:100%"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signin"),$_smarty_tpl);?>
</span></button>
				    	<?php if ($_smarty_tpl->tpl_vars['fb_auth']->value == "1" || $_smarty_tpl->tpl_vars['gp_auth']->value == "1") {?><div class="hr"><div class="inner"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.or"),$_smarty_tpl);?>
</div></div><?php }?>
				    	<?php if ($_smarty_tpl->tpl_vars['fb_auth']->value == "1") {?>
				    	<a href="javascript:;" rel="nofollow" onclick="popupwindow(&quot;<?php echo $_smarty_tpl->tpl_vars['fb_loginUrl']->value;?>
&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" style="display:inline-block;padding:10px 20px;"><img src="<?php echo $_smarty_tpl->tpl_vars['global_images_url']->value;?>
/f_logo_RGB-Blue_58.png" height="32" style="display:block;margin:0 auto;margin-bottom:10px"> <span><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.fb"),$_smarty_tpl);?>
</span></a>
				    	<button class="no-display search-button form-button fb-login-button" onclick="popupwindow(&quot;<?php echo $_smarty_tpl->tpl_vars['fb_loginUrl']->value;?>
&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" type="button" value="1" name="frontend_global_fb" style="text-transform:none"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.fb"),$_smarty_tpl);?>
</span></button><?php }?>
				    	<?php if ($_smarty_tpl->tpl_vars['gp_auth']->value == "1") {?>
				    	<a href="javascript:;" rel="nofollow" onclick="popupwindow(&quot;<?php echo $_smarty_tpl->tpl_vars['gp_loginUrl']->value;?>
&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" style="display:inline-block;padding:10px 20px;"><img src="<?php echo $_smarty_tpl->tpl_vars['global_images_url']->value;?>
/google-logo.png" height="32" style="display:block;margin:0 auto;margin-bottom:10px"> <span><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.gp"),$_smarty_tpl);?>
</span></a>
				    	<button class="no-display search-button form-button gp-login-button" onclick="popupwindow(&quot;<?php echo $_smarty_tpl->tpl_vars['gp_loginUrl']->value;?>
&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" type="button" value="1" name="frontend_global_gp" style="text-transform:none"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.signin.gp"),$_smarty_tpl);?>
</span></button>
				    	<?php }?>
				    	</center>
				    	<br>
				    </span>
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
            <?php echo '<script'; ?>
>
                $('#signin-form').captcha();
                $('form#signin-form').submit(function(e) {
					var username = $('input[name="frontend_signin_username"]').val();
					var password = $('input[name="frontend_signin_password"]').val();
					$.post('/contest/_core/request.php', { username: username, password: password, reason: 'login' }, function(get) {
					    console.log(get);
					    e.preventDefault();
						if(get.error != '0')  { console.log('error'); e.preventDefault(); }
					},'json');
				})	
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
                    text-align: left;
                }
                span.input-signin button.search-button.form-button {
                    margin-left: 0px;
                }
            </style>

<?php }
}

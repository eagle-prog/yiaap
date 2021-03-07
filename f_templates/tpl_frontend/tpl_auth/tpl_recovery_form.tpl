			    {if $smarty.get.s ne "" and $smarty.get.id ne ""}
			    <div class="login-page">
				<div class="outer-border-wrapper">
				<form id="password-recovery-form" class="recovery-form user-form" method="post" action="">
					<article>
						<h3 class="content-title"><i class="icon-user"></i> {lang_entry key="recovery.password.account"}</h3>
						<div class="line"></div>
					</article>
					{if $error_message ne ""}{$error_message}{elseif $notice_message ne ""}{$notice_message}{/if}
					{if $tpl_error_max eq ""}
					<div class="">
					    <span class="label-signin">{lang_entry key="frontend.global.username"}: </span>
					    <span class="input-signin">{if $global_section eq "frontend"}{$fe_recovery_username}{else}{$recovery_username}{/if}</span>
					</div>
					<div class="">
					    <span class="label-signin">{lang_entry key="recovery.forgot.new.password"}: </span>
					    <span class="input-signin"><input type="password" id="recover-password-input" name="recovery_forgot_new_password" class="text-input" /></span>
					</div>
					<div class="">
					    <span class="label-signin">{lang_entry key="recovery.forgot.retype.password"}: </span>
					    <span class="input-signin"><input type="password" id="reenter-password-input" name="recovery_forgot_retype_password" class="text-input" /></span>
					</div>
					<div class="">
					    <span class="label-signin"></span>
					    <span class="input-signin"><button class="search-button form-button" name="reset_password" id="reset-password-button" type="submit" value="1">{lang_entry key="frontend.global.submit"}</button></span>
					</div>
					{/if}
				</form>
				</div>
			    </div>
			    {else}
				{if ($password_recovery_captcha eq "1" and $global_section eq "frontend")} {assign var=extra_l value=1}
				{elseif ($backend_password_recovery_captcha eq "1" and $global_section eq "backend")} {assign var=extra_l value=3} {/if}
				{if ($username_recovery_captcha eq "1" and $global_section eq "frontend")} {assign var=extra_r value=2}
				{elseif ($backend_username_recovery_captcha eq "1" and $global_section eq "backend")} {assign var=extra_r value=4} {/if}
				<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer></script>
				<script>
      var recaptcha1;
      var recaptcha2;
      var myCallBack = function() {ldelim}
      {if ($allow_password_recovery eq "1" and $global_section eq "frontend") or ($backend_password_recovery eq "1" and $global_section eq "backend")}
	{if ($password_recovery_captcha eq "1" and $global_section eq "frontend") or ($backend_password_recovery_captcha eq "1" and $global_section eq "backend")}
        //Render the recaptcha1 on the element with ID "recaptcha1"
        recaptcha1 = grecaptcha.render('recaptcha1', {ldelim}
          'sitekey' : '{$recaptcha_site_key}', //Replace this with your Site key
          'theme' : 'light'
        {rdelim});
        {/if}
      {/if}
      {if ($allow_username_recovery eq "1" and $global_section eq "frontend") or ($backend_username_recovery eq "1" and $global_section eq "backend")}
        {if ($username_recovery_captcha eq "1" and $global_section eq "frontend") or ($backend_username_recovery_captcha eq "1" and $global_section eq "backend")}
        //Render the recaptcha2 on the element with ID "recaptcha2"
        recaptcha2 = grecaptcha.render('recaptcha2', {ldelim}
          'sitekey' : '{$recaptcha_site_key}', //Replace this with your Site key
          'theme' : 'light'
        {rdelim});
        {/if}
      {/if}
      {rdelim};
    </script>

				<div class="">
                                    {if ($allow_password_recovery eq "1" and $global_section eq "frontend") or ($backend_password_recovery eq "1" and $global_section eq "backend")}
                                    <div class="outer-border-wrapper" id="recover-password-mask">
                                    	<form id="password-recovery-form" class="user-form" action="" method="post">
                                            <article>
                                            	<h3 class="content-title"><i class="icon-user"></i> {if $global_section eq "frontend"}{lang_entry key="recovery.forgot.password"}{else}{lang_entry key="backend.recovery.forgot.password"}{/if}&nbsp;&nbsp;<i class="icon-question" rel="tooltip" title="{if $global_section eq "frontend"}{lang_entry key="recovery.forgot.pass.txt"}{else}{lang_entry key="backend.recovery.forgot.pass.txt"}{/if}{if $password_recovery_captcha eq "1"}{lang_entry key="recovery.verif.code.txt"}{/if}{lang_entry key="recovery.forgot.pass.txt1"}"></i></h3>
                                            	<div class="line"></div>
                                            </article>
                                            <div id="recover-password-response" class=""></div>
                                            <div class="inner-wrapper center">
                                                    <div class="row">
                                                        <span class="label-signin">{lang_entry key="frontend.global.username"}: </span>
                                                        <span class="input-signin"><input type="text" id="recover-password-input" name="rec_username" class="text-input" {$left_disabled} /></span>
                                                    </div>                                                    
                                                    <div class="clearfix"></div>
                                                    <div class="">
                                                        <span class="label-signin"></span>
                                                        <span class="input-signin">
                                                            <button class="search-button form-button submit" name="recover_password" id="recover-password-button" type="button" value="1" {$left_disabled}>{lang_entry key="frontend.global.submit"}</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        {else}
                                            	<article>
                                            		<h3 class="content-title"><i class="icon-user"></i> {lang_entry key='recovery.disabled.password'}</h3>
                                            		<div class="line"></div>
                                            	</article>
                                        {/if}        
                                    </div>

                                    
                                        <div class="outer-border-wrapper" id="recover-username-mask">
                                        <form id="username-recovery-form" class="user-form" action="" method="post">
                                            {if ($allow_username_recovery eq "1" and $global_section eq "frontend") or ($backend_username_recovery eq "1" and $global_section eq "backend")}
                                            	<article>
                                            		<h3 class="content-title"><i class="icon-user"></i> {if $global_section eq "frontend"}{lang_entry key="recovery.forgot.username"}{else}{lang_entry key="backend.recovery.forgot.username"}{/if}&nbsp;&nbsp;<i class="icon-question" rel="tooltip" title="{if $global_section eq "frontend"}{lang_entry key="recovery.forgot.user.txt"}{else}{lang_entry key="backend.recovery.forgot.user.txt"}{/if}{if $username_recovery_captcha eq "1"}{lang_entry key="recovery.verif.code.txt"}{/if}{lang_entry key="recovery.forgot.user.txt1"}"></i>
                                            		<div class="line"></div>
                                            		</h3>
                                            	</article>
                                            	<div id="recover-username-response" class=""></div>
                                                <div class="inner-wrapper center">
                                                        <div class="">
                                                            <span class="label-signin">{lang_entry key="frontend.global.email"}: </span>
                                                            <span class="input-signin"><input type="text" id="recover-username-input" name="rec_email" class="text-input" {$right_disabled} /></span>
                                                        </div>                                                        
                                                        <div class="clearfix"></div>
                                                        <div class="">
                                                            <span class="label-signin"></span>
                                                            <span class="input-signin">
                                                                <button class="search-button form-button submit" name="recover_username" id="recover-username-button" type="button" value="1" {$right_disabled}>{lang_entry key="frontend.global.submit"}</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                               </form>
                                            </div>
                                            {else}
                                            	<article>
                                            		<h3 class="content-title"><i class="icon-user"></i> {lang_entry key='recovery.disabled.username'}</h3>
                                            		<div class="line"></div>
                                            	</article>
                                            {/if}
                            {/if}
            <script>
                $('#password-recovery-form').captcha();
                $('#username-recovery-form').captcha();                
            </script>
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

                span.input-signin button.search-button.form-button {
                    margin-left: 0px;
                }
            </style>
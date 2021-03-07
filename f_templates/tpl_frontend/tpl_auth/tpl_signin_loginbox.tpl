		    <div class="outer-border-wrapper">
			<div class="inner-wrapper center">
                            {if ($global_section eq "frontend" and $frontend_signin_section eq "1") or ($global_section eq "backend" and $backend_signin_section eq "1")}
			    <form id="signin-form" class="user-form" method="post" action="{if $global_section eq "frontend"}{$main_url}/{href_entry key="signin"}{if $smarty.get.next ne ""}?next={$smarty.get.next|sanitize}{/if}{/if}">
				<article>
					<h3 class="content-title"><i class="icon-user"></i> {if $global_section eq "frontend"}{lang_entry key="frontend.signin.text8"}{else}{lang_entry key="backend.login.intro.text"}{/if}</h3>
					<div class="line"></div>
				</article>
				<input type='hidden' name="contest_redirect" value="{$contest_redirection}" />
				{$error_message}
				<div class="row">
				    <span class="label-signin">{lang_entry key="frontend.signin.username"}: </span>
				    <span class="input-signin"><input {$disabled_input} type="text" class="text-input login-input" name="frontend_signin_username" /></span>
				</div>
				<div class="row">
				    <span class="label-signin">{lang_entry key="frontend.signin.password"}: </span>
				    <span class="input-signin"><input {$disabled_input} type="password" class="text-input" name="frontend_signin_password" onclick="this.select();" /></span>
				</div>
				{if ($global_section eq "frontend" and $login_remember eq "1") or ($global_section eq "backend" and $backend_remember eq "1")}
				<div class="row">
					<span class="label-signin no-top-margin icheck-box"><input {$disabled_input} type="checkbox" name="signin_remember" value="1" {if $smarty.post.signin_remember}checked="checked"{/if} /></span>
					<span class="input-signin top-padding2">{lang_entry key="frontend.signin.remember"}</span>
				</div>
				{/if}
				{if $signin_captcha eq "1"}
                                <div class="captcha-row">
                                    <span class="label-signin"></span>
                                    <span class="input-signin"><div class="g-recaptcha" data-sitekey="{$recaptcha_site_key}" style="transform:scale(0.99);-webkit-transform:scale(0.99);transf
                                </div>
                                {/if}

				<div class="clearfix"></div>
				<div class="row form-buttons">
				{if $fb_auth eq "1" or $gp_auth eq "1"}
		    		<script type="text/javascript">
		    			function popupwindow(url, title, win, w, h) {ldelim}
		    				var y = window.top.outerHeight / 2 + window.top.screenY - ( h / 2);
		    				var x = window.top.outerWidth / 2 + window.top.screenX - ( w / 2);
		    				winpop = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+y+', left='+x);
		    			{rdelim}
                                </script>
                                {/if}
				    <span class="label-signin"></span>
				    <span class="input-signin">
					<center>
				    	<button class="search-button form-button submit" value="1" name="frontend_global_submit" style="width:100%"><span>{lang_entry key="frontend.global.signin"}</span></button>
				    	{if $fb_auth eq "1" or $gp_auth eq "1"}<div class="hr"><div class="inner">{lang_entry key="frontend.global.or"}</div></div>{/if}
				    	{if $fb_auth eq "1"}
				    	<a href="javascript:;" rel="nofollow" onclick="popupwindow(&quot;{$fb_loginUrl}&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" style="display:inline-block;padding:10px 20px;"><img src="{$global_images_url}/f_logo_RGB-Blue_58.png" height="32" style="display:block;margin:0 auto;margin-bottom:10px"> <span>{lang_entry key="frontend.signin.fb"}</span></a>
				    	<button class="no-display search-button form-button fb-login-button" onclick="popupwindow(&quot;{$fb_loginUrl}&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" type="button" value="1" name="frontend_global_fb" style="text-transform:none"><span>{lang_entry key="frontend.signin.fb"}</span></button>{/if}
				    	{if $gp_auth eq "1"}
				    	<a href="javascript:;" rel="nofollow" onclick="popupwindow(&quot;{$gp_loginUrl}&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" style="display:inline-block;padding:10px 20px;"><img src="{$global_images_url}/google-logo.png" height="32" style="display:block;margin:0 auto;margin-bottom:10px"> <span>{lang_entry key="frontend.signin.gp"}</span></a>
				    	<button class="no-display search-button form-button gp-login-button" onclick="popupwindow(&quot;{$gp_loginUrl}&display=popup&quot;, &quot;winpop&quot;, &quot;winpop&quot;, &quot;560&quot;, &quot;400&quot;);" type="button" value="1" name="frontend_global_gp" style="text-transform:none"><span>{lang_entry key="frontend.signin.gp"}</span></button>
				    	{/if}
				    	</center>
				    	<br>
				    </span>
				</div>
			    </form>
                            {else}
				<article>
					<h3 class="content-title"><i class="icon-user"></i> {lang_entry key='frontend.signin.text11'}</h3>
					<div class="line"></div>
				</article>
                            {/if}
			</div>
		    </div>
            <script>
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
                    text-align: left;
                }
                span.input-signin button.search-button.form-button {
                    margin-left: 0px;
                }
            </style>


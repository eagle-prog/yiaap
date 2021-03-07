	    {assign var="access_url" value="{$main_url}"}
            {assign var="href_s" value="{href_entry key="account"}"}
            {assign var="href_m" value="{href_entry key="messages"}"}
            {assign var="href_c" value="{href_entry key="contacts"}"}
            {assign var="href_cm" value="{href_entry key="comments"}"}
            {assign var="href_sub" value="{href_entry key="subscriptions"}"}
            {assign var="lang_s" value="{lang_entry key="subnav.entry.settings"}"}
            {assign var="lang_f" value="{lang_entry key="subnav.entry.files.my"}"}

		    <div id="nav-sub">
			<ul id="nav-sub-menu">
			{if $smarty.session.USER_ID eq ""}
			    <li class="subnav-first"><a href="{$main_url}/{href_entry key="signup"}"{if $page_display eq "tpl_signup"} class="a-active"{/if}>{lang_entry key="frontend.global.signup"}</a></li>
			    <li class="sub-last"><a{if $page_display eq "tpl_recovery"} class="a-active"{/if} href="{$main_url}{if $global_section eq "backend"}/{$backend_access_url}/{href_entry key="be_service"}/{href_entry key="x_recovery"}{else}/{href_entry key="service"}/{href_entry key="x_recovery"}{/if}">{lang_entry key="frontend.global.recovery"}</a></li>
			{else}
			    {if $smarty.get.sid eq '' and $smarty.get.uid eq ''}
			    {if $page_display ne "tpl_upload" and $page_display ne "tpl_import"}
				<li class="subnav-first"><a href="{$access_url}/{$href_s}"{if $page_display eq "tpl_account"} class="a-active"{/if}>{$lang_s}</a></li>
				<li><a href="{$access_url}/{href_entry key="files"}"{if $page_display eq "tpl_files"} class="a-active"{/if}>{$lang_f}</a></li>
				{if $public_channels eq "1"}
                    		<li class=""><a href="{$main_url}/{href_entry key="user"}/{$smarty.session.USER_NAME}"{if $page_display eq "tpl_userpage" and $upage eq $smarty.session.USER_ID} class="a-active"{/if}>{lang_entry key="subnav.entry.channel.my"}</a></li>
                		{/if}
				{if $internal_messaging eq 1 or $user_blocking eq 1 or $user_friends eq 1 or $channel_comments eq 1}
				{if $global_section eq "frontend"}
				<li><a href="{$access_url}/{if $internal_messaging eq 1 and ($user_friends eq 1 or $user_blocking eq 1)}{$href_m}{elseif $internal_messaging eq 0 and ($user_friends eq 1 or $user_blocking eq 1)}{$href_c}{else}{$href_cm}{/if}"{if $page_display eq "tpl_messages"} class="a-active"{/if}>{if $internal_messaging eq 1 and ($user_friends eq 1 or $user_blocking eq 1)}{lang_entry key="subnav.entry.contacts.messages"}{elseif $internal_messaging eq 0 and ($user_friends eq 1 or $user_blocking eq 1)}{lang_entry key="subnav.entry.contacts"}{else}{lang_entry key="subnav.entry.comments"}{/if}</a></li>
				{/if}
				{/if}
				{if $global_section eq "frontend" and $user_subscriptions eq 1}
				<li class=""><a href="{$access_url}/{$href_sub}"{if $page_display eq "tpl_subs"} class="a-active"{/if}>{lang_entry key="subnav.entry.sub"}</a></li>
				{/if}
			    {else}
                                <li class="subnav-first">
                                    <a href="{$access_url}/{href_entry key="import"}?t=video"{if $page_display eq "tpl_import"} class="a-active"{/if}>{lang_entry key="backend.import.link"}</a> -
                                </li>
				{if $video_module eq 1 and $video_uploads eq 1}<li class=""><a href="{$main_url}/{href_entry key="upload"}?t=video"{if $smarty.get.t[0] eq "v" and $page_display ne "tpl_import"} class="a-active"{/if}>{lang_entry key="upload.menu.video"}</a></li>{/if}
				{if $image_module eq 1 and $image_uploads eq 1}<li class=""><a href="{$main_url}/{href_entry key="upload"}?t=image"{if $smarty.get.t[0] eq "i"} class="a-active"{/if}>{lang_entry key="upload.menu.image"}</a></li>{/if}
				{if $audio_module eq 1 and $audio_uploads eq 1}<li class=""><a href="{$main_url}/{href_entry key="upload"}?t=audio"{if $smarty.get.t[0] eq "a"} class="a-active"{/if}>{lang_entry key="upload.menu.audio"}</a></li>{/if}
				{if $document_module eq 1 and $document_uploads eq 1}<li class=""><a href="{$main_url}/{href_entry key="upload"}?t=document"{if $smarty.get.t[0] eq "d"} class="a-active"{/if}>{lang_entry key="upload.menu.document"}</a></li>{/if}
			    {/if}
			    {/if}
			{/if}
			</ul>
			<div class="left-float left-padding10 top-padding2">{insert name="langInit"}</div>
			<div id="nav-top-search" class="no-display-off right-float">
                            <form id="search-form" method="get" action="{$main_url}/{href_entry key="search"}">
                                <ul id="nav-search-menu">
                                    <li><input {$disabled_input} id="search-query" type="text" name="q" {if $page_display eq "tpl_search"}value="{$smarty.get.q|sanitize}"{else}value="{lang_entry key="frontend.global.words"}"{/if} onfocus="this.select(); if(this.value == '{lang_entry key="frontend.global.words"}') { this.value = ''; }" onblur="if(this.value == '') { this.value = '{lang_entry key="frontend.global.words"}'; }" /></li>
                                    <li><input {$disabled_input} id="search-go" type="button" name="s" value="" onclick="$('#search-form').submit();" /></li>
                                </ul>
                            </form>
                            <script type="text/javascript">$(document).ready(function(){ldelim}$('#search-form').submit(function(){ldelim}if($("#search-query").val() == '')return false;{rdelim});{rdelim});</script>
                        </div>
		    </div>

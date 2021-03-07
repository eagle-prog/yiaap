                        <header id="main_header">
                                <div class="dynamic_container">
                                        <div id="ct-header-top">
                                                <div id="logo_container">
                                                        <i class="icon icon-menu2 menu-trigger"></i>
                                                        <a class="navbar-brand" href="{$main_url}/{href_entry key="videos"}" title="{lang_entry key="frontend.global.home"}" id="logo" rel="nofollow"></a>
                                                        <span id="menu-trigger-response"></span>
                                                </div>
                                                <div id="top_actions"{if $smarty.session.USER_ID eq 0} class="no-session"{/if}>
                                                                <div class="user-thumb-xlarge top">
                                                                {if $smarty.session.USER_ID gt 0}
                                                                        <img height="32" class="own-profile-image mt" title="{$smarty.session.USER_NAME}" alt="{$smarty.session.USER_NAME}" src="{insert name="getProfileImage" assign="profileImage" for="{$smarty.session.USER_ID}"}{$profileImage}">
                                                                {else}
                                                                	<span class="own-profile-image mt no-display"></span>
                                                                	<span class="no-session-icon" onclick="$('.own-profile-image.mt').click();"><i class="mt-open"></i></span>
                                                                {/if}

                                                                        <div class="arrow_box hidden blue" id="user-arrow-box">
                                                                        {include file="tpl_frontend/tpl_header/tpl_headernav_pop.tpl"}
                                                                        </div>
                                                                </div>
                                                        {if $smarty.session.USER_ID gt 0}
                                                                <a href="javascript:;" class="top-icon top-notif" title="{lang_entry key="frontend.global.notifications"}">
                                                                        <i class="icon-notification"></i>
                                                                </a>
                                                                <div class="arrow_box hidden" id="notifications-arrow-box">
                                                                        <div class="arrow_box_pad">
                                                                                <div id="notifications-box">
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                         {/if}
                                                        {if $smarty.session.USER_ID eq 0}
                                                                <form id="top-login-form"><a class="top-login-link" href="{$main_url}/{href_entry key="signin"}" rel="nofollow">{lang_entry key="frontend.global.signin"}</a></form>
                                                        {/if}
                                                </div>
                                                <div class="search_holder{if $smarty.session.USER_ID eq 0} no-session-holder{/if}">
                                                        <div id="sb-search" class="sb-search sb-search-open">
                                                                <form method="get" action="{$main_url}/{href_entry key="search"}">
                                                                        <input class="sb-search-input" placeholder="{lang_entry key="frontend.global.searchtext"}" type="text" value="" name="q" id="search">
                                                                        <input class="sb-search-submit" type="submit" value="">
                                                                        <span class="sb-icon-search icon-search"></span>
                                                                </form>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        {if $page_display ne "tpl_view" and $website_offline_mode eq 0}
                                        <div id="ct-header-bottom" class="{if $smarty.session.sbm eq 0}no-menu{/if}">
                                                <ul id="sub-nav-bar">
                                                        <li onclick="window.location=$(this).find(&quot;a&quot;).attr(&quot;href&quot;)" class="{if $page_display eq "tpl_browse" and $type_display eq "video"}active{/if}" data-text="{lang_entry key="frontend.global.browse"}"><a href="{$main_url}/{href_entry key="{if $video_module eq 1}videos{elseif $live_module eq 1}broadcasts{elseif $image_module eq 1}images{elseif $audio_module eq 1}audios{elseif $document_module eq 1}documents{elseif $blog_module eq 1}blogs{/if}"}">{lang_entry key="frontend.global.watch"}</a></li>
                                                        <li onclick="window.location=$(this).find(&quot;a&quot;).attr(&quot;href&quot;)" class="{if $page_display eq "tpl_upload" or $page_display eq "tpl_import"}active{/if}" data-text="{lang_entry key="frontend.global.upload"}"><a href="{$main_url}/{href_entry key="upload"}" rel="nofollow">{lang_entry key="frontend.global.upload"}</a></li>
                                                </ul>
                                        </div>
                                        {/if}
                                </div>
                        </header>
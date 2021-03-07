                <div class="blue categories-container">
                	<h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-eye"></i>{lang_entry key="frontend.global.browse"} {$website_shortname}</h4>
                        <aside>
                                <nav>
                                        <ul class="accordion" id="{if $smarty.session.USER_ID eq ""}no-session-accordion2{else}session-accordion{/if}">
                                        {if $video_module eq "1"}
                                                <li class="{if $page_display eq "tpl_index"}menu-panel-entry menu-panel-entry-active{/if}"><a class="dcjq-parent{if $page_display eq "tpl_index"} active{/if}" href="{$main_url}/{href_entry key="index"}"><i class="icon-home"></i>{lang_entry key="browse.t.files"}</a></li>
                                        {/if}
                                        {if $live_module eq "1"}
                                                <li class="{if $page_display eq "tpl_browse" and $type_display eq "live"}menu-panel-entry menu-panel-entry-active{/if}"><a class="dcjq-parent{if $page_display eq "tpl_browse" and $type_display eq "live"} active{/if}" href="{$main_url}/{href_entry key="broadcasts"}"><i class="icon-live"></i>{lang_entry key="browse.l.files"}</a></li>
                                        {/if}
                                        {if $image_module eq "1"}
                                        	<li class="{if $page_display eq "tpl_browse" and $type_display eq "image"}menu-panel-entry menu-panel-entry-active{/if}"><a class="dcjq-parent{if $page_display eq "tpl_browse" and $type_display eq "image"} active{/if}" href="{$main_url}/{href_entry key="images"}"><i class="icon-image"></i>{lang_entry key="browse.i.files"}</a></li>
                                        {/if}
                                        {if $audio_module eq "1"}
                                        	<li class="{if $page_display eq "tpl_browse" and $type_display eq "audio"}menu-panel-entry menu-panel-entry-active{/if}"><a class="dcjq-parent{if $page_display eq "tpl_browse" and $type_display eq "audio"} active{/if}" href="{$main_url}/{href_entry key="audios"}"><i class="icon-audio"></i>{lang_entry key="browse.a.files"}</a></li>
                                        {/if}
                                        {if $document_module eq "1"}
                                        	<li class="{if $page_display eq "tpl_browse" and $type_display eq "document"}menu-panel-entry menu-panel-entry-active{/if}"><a class="dcjq-parent{if $page_display eq "tpl_browse" and $type_display eq "document"} active{/if}" href="{$main_url}/{href_entry key="documents"}"><i class="icon-file"></i>{lang_entry key="browse.d.files"}</a></li>
                                        {/if}
                                        {if $blog_module eq "1"}
                                                <li class="{if $page_display eq "tpl_browse" and $type_display eq "blog"}menu-panel-entry menu-panel-entry-active{/if}"><a class="dcjq-parent{if $page_display eq "tpl_browse" and $type_display eq "blog"} active{/if}" href="{$main_url}/{href_entry key="blogs"}"><i class="icon-blog"></i>{lang_entry key="browse.b.files"}</a></li>
                                        {/if}
                                        {if $public_channels eq "1"}
                                                <li class="{if $page_display eq "tpl_channels"}menu-panel-entry menu-panel-entry-active{/if}"><a class="dcjq-parent{if $page_display eq "tpl_channels"} active{/if}" href="{$main_url}/{href_entry key="channels"}"><i class="icon-users"></i>{lang_entry key="browse.ch.menu"}</a></li>
                                        {/if}
                                        </ul>
                                        <div class="clearfix"></div>
                                </nav>
                        </aside>
                </div>

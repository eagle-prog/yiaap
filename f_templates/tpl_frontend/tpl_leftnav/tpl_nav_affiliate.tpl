{if $affiliate_module eq 1 and $smarty.session.USER_AFFILIATE eq 1}
                <div class="blue categories-container">
                    <h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-coin"></i>{lang_entry key="subnav.entry.affiliate"}</h4>
                    <aside>
                        <nav>
                            <ul class="accordion" id="categories-accordion">
                            	<li id="account-menu-entry13" class="menu-panel-entry{if $smarty.get.a eq "" and $smarty.get.g eq "" and $smarty.get.o eq "" and $smarty.get.rp eq ""} menu-panel-entry-active{/if}" rel-m="{href_entry key="affiliate"}"><a class="{if $smarty.get.a eq "" and $smarty.get.g eq "" and $smarty.get.o eq "" and $smarty.get.rp eq ""}dcjq-parent active{/if}" href="{$main_url}/{href_entry key="affiliate"}"><i class="icon-user"></i>{lang_entry key="account.entry.overview"}</a></li>
                            	<li id="account-menu-entry12" class="menu-panel-entry{if $smarty.get.rp ne ""} menu-panel-entry-active{/if}" rel-m="{href_entry key="affiliate"}"><a class="{if $smarty.get.rp ne ""}dcjq-parent active{/if}" href="{$main_url}/{href_entry key="affiliate"}?rp={$smarty.session.USER_KEY|md5}"><i class="icon-paypal"></i>{lang_entry key="account.entry.payout.rep"}</a></li>
                                <li id="account-menu-entry9" class="menu-panel-entry{if $smarty.get.a ne ""} menu-panel-entry-active{/if}" rel-m="{href_entry key="affiliate"}"><a class="{if $smarty.get.a ne ""}dcjq-parent active{/if}" href="{$main_url}/{href_entry key="affiliate"}?a={$smarty.session.USER_KEY|md5}"><i class="icon-pie"></i>{lang_entry key="account.entry.act.views"}</a></li>
                                {if $affiliate_geo_maps eq 1}
                                <li id="account-menu-entry10" class="menu-panel-entry{if $smarty.get.g ne ""} menu-panel-entry-active{/if}" rel-m="{href_entry key="affiliate"}"><a class="{if $smarty.get.g ne ""}dcjq-parent active{/if}" href="{$main_url}/{href_entry key="affiliate"}?g={$smarty.session.USER_KEY|md5}"><i class="icon-globe"></i>{lang_entry key="account.entry.act.maps"}</a></li>
                                {/if}
                                <li id="account-menu-entry11" class="menu-panel-entry{if $smarty.get.o ne ""} menu-panel-entry-active{/if}" rel-m="{href_entry key="affiliate"}"><a class="{if $smarty.get.o ne ""}dcjq-parent active{/if}" href="{$main_url}/{href_entry key="affiliate"}?o={$smarty.session.USER_KEY|md5}"><i class="icon-bars"></i>{lang_entry key="account.entry.act.comp"}</a></li>
                            </ul>
                        </nav>
                    </aside>
                </div>
{/if}
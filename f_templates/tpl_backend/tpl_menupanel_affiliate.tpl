                                    <li>
                                        <a href="javascript:;"{if $page_display eq "backend_tpl_affiliate"} class="active"{/if}><i class="iconBe-pie"></i>{lang_entry key="backend.menu.sc.dashboard"}</a>
                                        <ul>
                                            <li><a href="{$main_url}/{$backend_access_url}/{href_entry key="be_affiliate"}?rp=1"{if $page_display eq "backend_tpl_affiliate" and $smarty.get.rp eq "1"} class="active"{/if}><i class="iconBe-arrow-right in-menu"></i>{lang_entry key="account.entry.act.rep"}</a></li>
                                            <li><a href="{$main_url}/{$backend_access_url}/{href_entry key="be_affiliate"}?a=1"{if $page_display eq "backend_tpl_affiliate" and $smarty.get.a eq "1"} class="active"{/if}><i class="iconBe-arrow-right in-menu"></i>{lang_entry key="account.entry.act.views"}</a></li>
                                            <li><a href="{$main_url}/{$backend_access_url}/{href_entry key="be_affiliate"}?g=1"{if $page_display eq "backend_tpl_affiliate" and $smarty.get.g eq "1"} class="active"{/if}><i class="iconBe-arrow-right in-menu"></i>{lang_entry key="account.entry.act.maps"}</a></li>
                                            <li><a href="{$main_url}/{$backend_access_url}/{href_entry key="be_affiliate"}?o=1"{if $page_display eq "backend_tpl_affiliate" and $smarty.get.o eq "1"} class="active"{/if}><i class="iconBe-arrow-right in-menu"></i>{lang_entry key="account.entry.act.comp"}</a></li>
                                        </ul>
                                    </li>


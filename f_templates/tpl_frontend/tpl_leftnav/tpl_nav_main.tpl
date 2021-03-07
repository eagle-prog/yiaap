<div class="blue categories-container 12345">
    <h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-eye"></i> {$website_shortname}</h4>    
    <aside>
        <nav>            
            <ul class="accordion" id="{if $smarty.session.USER_ID eq ""}no-session-accordion2{else}session-accordion{/if}">
                {foreach $menus as $i => $menu }
                    <li class=""><a class="dcjq-parent" href="{$menus[$i]['url']}"><i class="{$menus[$i]['icon']}"></i>{$menus[$i]['title']}</a></li>
                {/foreach}
            </ul>
            <div class="clearfix"></div>
        </nav>
    </aside>
</div>

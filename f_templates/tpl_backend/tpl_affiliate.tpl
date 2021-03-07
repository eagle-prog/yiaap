<div class="container cbp-spmenu-push">
{if $smarty.get.a ne ""}
        {include file="tpl_backend/tpl_affiliate/tpl_analytics.tpl"}
{elseif $smarty.get.g ne ""}
        {include file="tpl_backend/tpl_affiliate/tpl_maps.tpl"}
{elseif $smarty.get.o ne ""}
        {include file="tpl_backend/tpl_affiliate/tpl_bars.tpl"}
{elseif $smarty.get.rp ne ""}
        {include file="tpl_backend/tpl_affiliate/tpl_reports.tpl"}
{/if}
</div>
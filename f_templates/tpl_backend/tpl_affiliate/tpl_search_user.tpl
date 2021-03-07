<div class="search_holder_fe">
	<div id="sb-search-be" class="sb-search-fe{if $is_mobile} sb-search-open{/if}">
		<form name="user_search_form" id="user-search-form" method="get" action="">
			<input class="sb-search-input" placeholder="{lang_entry key="frontend.global.searchtext"}" type="text" value="" name="uk" id="uk" onclick="this.select()">
			<input class="sb-search-submit file-search" id="user-search-button" type="button" value="">
			<i class="icon icon-search"></i>
			<span title="{lang_entry key="account.entry.search.users"}" rel="tooltip" class="sb-icon-search-fe icon-search"></span>
		</form>
	</div>
</div>
	<script type="text/javascript">
	new UISearch(document.getElementById('sb-search-be'));
	
	$(document).ready(function(){ldelim}
	    	$("#uk").autocomplete({ldelim}
	    		showNoSuggestionNotice: true,
                	type: "post",
                	params: {ldelim}"t": $(".view-mode-type.active").attr("id").replace("view-mode-", "") {rdelim},
                	serviceUrl: "?a=1&t={$smarty.get.t|sanitize}&do=userautocomplete",
                	onSearchStart: function() {ldelim}{rdelim},
                	onSearchComplete: function(query, suggestion) {ldelim}{rdelim},
                	onSelect: function (suggestion) {ldelim}
                		if (typeof suggestion.data != 'undefined') {ldelim}
                			var u = String(window.location);
                			u = u.replace('&uk={$smarty.get.uk|sanitize}', '');
                			u = u.replace('&fk={$smarty.get.fk|sanitize}', '');

                			$("#custom-date-form").attr("action", u + '&uk='+suggestion.data);
                			$("#custom-date-form").submit();
                		{rdelim}
                	{rdelim}
        	{rdelim});
        	$("#user-search-form").submit(function(e){ldelim}e.preventDefault();{rdelim});
	{rdelim});
	</script>
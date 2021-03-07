                        <link rel="stylesheet" type="text/css" href="{$styles_url}/view.min.css">
    <div class="left-float wdmax">
	<div id="overview-userinfo">
	    <div class="statsBox">
		<article>
                	<h3 class="content-title"><i class="icon-user"></i>{lang_entry key="account.entry.account.overview"}</h3>
                	<div class="line"></div>
        	</article>
		<div class="vs-column fourths">
		    <div class="user-thumb-xlarge">
			<div><center><a href="{$main_url}/{href_entry key="channel"}/{$smarty.session.USER_KEY}/{$smarty.session.USER_NAME}"><img id="own-profile-image" title="{$smarty.session.USER_NAME}" alt="{$smarty.session.USER_NAME}" src="{insert name="getProfileImage" assign="profileImage" for="{$smarty.session.USER_ID}"}{$profileImage}"></a></center></div>
		    </div>
		    <div class="imageChange">
		    <form method="post" action="" class="entry-form-class overview-form">
                        <center>
                                {if !$smarty.session.USER_PARTNER and $smarty.session.USER_PARTNER_REQUEST}
                                <button class="save-entry-button button-grey search-button form-button usr-delete" type="button" onclick="$('.partner-request-popup').trigger('click');"><span>{lang_entry key="account.entry.btn.request.prt"}</span></button>
                                <a href="javascript:;" rel="popuprel" class="partner-request-popup hidden">{lang_entry key="account.entry.btn.request.prt"}</a>
                                {elseif $smarty.session.USER_PARTNER}
                                <button class="save-entry-button button-grey search-button form-button purge-button" type="button" onclick="$('.partner-cancel-popup').trigger('click');"><span>{lang_entry key="account.entry.btn.terminate.prt"}</span></button>
                                <a href="javascript:;" rel="popuprel" class="partner-cancel-popup hidden">{lang_entry key="account.entry.btn.terminate.prt"}</a>
                                {/if}
                        </center>
                    </form>
                    </div>
		    <div class="popupbox" id="popuprel"></div>
		    <div id="fade"></div>
		</div>
		
		<div class="vs-column three_fourths fit">
			{insert name="getUserStats" type="subs"}
		</div>
	    </div>
			<div class="clearfix"></div>
	</div>
    </div>
<script type="text/javascript">
    $(document).on("click", ".partner-request-popup", function() {ldelim}
	af_url = current_url + menu_section + "?s=account-menu-entry1&do=make-partner";
	$.fancybox({ldelim} type: "ajax", minWidth: "80%", margin: 20, href: af_url {rdelim});
    {rdelim});
{if $smarty.session.USER_PARTNER eq 1}
    $(function() {ldelim}SelectList.init("user_partner_badge");{rdelim});
    $(document).on("click", ".partner-cancel-popup", function() {ldelim}
	af_url = current_url + menu_section + "?s=account-menu-entry1&do=clear-partner";
	$.fancybox({ldelim} type: "ajax", minWidth: "80%", margin: 20, href: af_url {rdelim});
    {rdelim});
    $(document).on("change", ".badge-select-input", function() {ldelim}
        v = $(this).val();
        h = '<i id="affiliate-icon" class="'+v+'"></i>';
        $("#affiliate-icon").replaceWith(h);
        if (v == "") $("#affiliate-icon").hide();
        af_url = current_url + menu_section + "?s=account-menu-entry13&do=save-subscriber";
        $.post(af_url, $("#ct-set-form").serialize(), function(data) {ldelim}
                $("#affiliate-response").html(data);
        {rdelim});
    {rdelim});
    $(document).on("keydown", ".user-partner-paypal", function(e) {ldelim}
        var code = e.which;
        if (code == 13) {ldelim}
                e.preventDefault();
                af_url = current_url + menu_section + "?s=account-menu-entry13&do=save-subscriber";
                $.post(af_url, $("#ct-set-form").serialize(), function(data) {ldelim}
                        $("#affiliate-response").html(data);
                {rdelim});
        {rdelim}
    {rdelim});
{/if}
</script>

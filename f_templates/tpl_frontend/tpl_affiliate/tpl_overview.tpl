{if $smarty.get.a ne ""}
	{include file="tpl_frontend/tpl_affiliate/tpl_analytics.tpl"}
{elseif $smarty.get.g ne ""}
	{include file="tpl_frontend/tpl_affiliate/tpl_maps.tpl"}
{elseif $smarty.get.o ne ""}
	{include file="tpl_frontend/tpl_affiliate/tpl_bars.tpl"}
{elseif $smarty.get.rp ne ""}
	{include file="tpl_frontend/tpl_affiliate/tpl_reports.tpl"}
{else}
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
		    		<button class="save-entry-button button-grey search-button form-button purge-button" type="button" onclick="$('.affiliate-cancel-popup').trigger('click');"><span>{lang_entry key="account.entry.btn.terminate"}</span></button>
		    		<a href="javascript:;" rel="popuprel" class="affiliate-cancel-popup hidden">{lang_entry key="account.entry.btn.terminate"}</a>
		    	</center>
		    </form>
		    </div>
		    <div class="popupbox" id="popuprel"></div>
		    <div id="fade"></div>
		</div>
		
		<div class="vs-column three_fourths fit">
				<div class="account-stats">
					<div class="vs-column half sc">
						<p class="account-date"><span class="label">{lang_entry key="account.overview.date.affiliate"}</span>{$affiliate_date}</p>
						<br>
						<h3>{lang_entry key="account.overview.account.type"}</h3>
						<h2>{lang_entry key="account.overview.account.affiliate"}{if $smarty.session.USER_PARTNER} & {lang_entry key="account.overview.account.partner"}{/if} <i id="affiliate-icon" class="{$affiliate_badge}"{if $affiliate_badge eq ""} style="display: none;"{/if}></i></h2>
					</div>
					<div class="vs-column half fit sc">
					<form id="ct-set-form">
						<div id="affiliate-response"></div>
						<div class="vs-column full">
							<div class="row">
								<div class="left-float lh25 wd140"><label>{lang_entry key="account.overview.affiliate.badge"}</label></div>
								<div class="left-float selector">
									{$badge_ht}
								</div>
							</div>
						</div>
						<div class="vs-column full">
							<div class="row">
								<div class="left-float lh25 wd140"><label>{lang_entry key="account.overview.paypal.email"}</label></div>
								<div class="left-float"><input type="text" name="user_affiliate_paypal" class="user-affiliate-paypal" autocomplete="off" value="{$affiliate_email|sanitize}" onclick="this.focus(); this.select();"></div>
							</div>
						</div>
						<div class="vs-column full">
							<div class="row">
								<div class="left-float lh25 wd140"><label>{lang_entry key="account.entry.affiliate.api.key"}</label><i class="icon icon-info" rel="tooltip" title="{lang_entry key="account.overview.maps.key"}" style="vertical-align: middle; margin-left: 5px;"></i></div>
								<div class="left-float"><input type="text" name="user_affiliate_maps_key" class="user-affiliate-maps" autocomplete="off" value="{$affiliate_maps_key|sanitize}" onclick="this.focus(); this.select();"></div>
							</div>
						</div>
					</form>
					</div>
				</div>
				<div class="clearfix"></div>
		</div>
	    </div>
	<div class="clearfix"></div>
	</div>
	{$html}
	<div class="clearfix"></div>
    </div>
    <script type="text/javascript">
    $(function() {ldelim}
    	SelectList.init("user_affiliate_badge");
    {rdelim});
    $(document).on("keydown", ".user-affiliate-paypal, .user-affiliate-maps", function(e) {ldelim}
    	var code = e.which;
    	if (code == 13) {ldelim}
    		e.preventDefault();
    		af_url = current_url + menu_section + "?s=account-menu-entry13&do=save-affiliate";
    		$.post(af_url, $("#ct-set-form").serialize(), function(data) {ldelim}
    			$("#affiliate-response").html(data);
    		{rdelim});
    	{rdelim}
    {rdelim});
    $(document).on("change", ".badge-select-input", function() {ldelim}
    	v = $(this).val();
    	h = '<i id="affiliate-icon" class="'+v+'"></i>';
    	$("#affiliate-icon").replaceWith(h);
    	if (v == "") $("#affiliate-icon").hide();
    	af_url = current_url + menu_section + "?s=account-menu-entry13&do=save-affiliate";
    	$.post(af_url, $("#ct-set-form").serialize(), function(data) {ldelim}
    		$("#affiliate-response").html(data);
    	{rdelim});
    {rdelim});
    $(document).on("click", ".affiliate-cancel-popup", function() {ldelim}
        af_url = current_url + menu_section + "?s=account-menu-entry13&do=clear-affiliate";
        $.fancybox({ldelim} type: "ajax", minWidth: "80%", margin: 20, href: af_url {rdelim});
    {rdelim});
    </script>
{/if}
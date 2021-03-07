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
			<div><center><a href="{$main_url}/{href_entry key="channel"}/{$smarty.session.USER_KEY}/{$smarty.session.USER_NAME}"><img id="own-profile-image" title="{$smarty.session.USER_NAME}" alt="{$smarty.session.USER_NAME}" src="{insert name="getProfileImage" assign="profileImage" for="{$smarty.session.USER_ID}"}{$profileImage}?_={$smarty.now}"></a></center></div>
		    </div>
		    <div class="imageChange">
		    <form method="post" action="" class="entry-form-class overview-form">
		    	<center>
		    		<button class="save-entry-button button-grey search-button form-button new-image" type="button" onclick="$('.thumb-popup').trigger('click');"><span>{lang_entry key="account.image.change"}</span></button>
		    		<a href="javascript:;" rel="popuprel" class="thumb-popup hidden">{lang_entry key="frontend.global.change"}</a>
		    		{if $affiliate_module eq 1 and !$smarty.session.USER_AFFILIATE and $smarty.session.USER_AFFILIATE_REQUEST}
		    		<button class="save-entry-button button-grey search-button form-button usr-delete" type="button" onclick="$('.affiliate-request-popup').trigger('click');"><span>{lang_entry key="account.entry.btn.request"}</span></button>
                                <a href="javascript:;" rel="popuprel" class="affiliate-request-popup hidden">{lang_entry key="account.entry.btn.request"}</a>
                                {/if}
		    	</center>
		    </form>
		    </div>
		    <div class="popupbox" id="popuprel"></div>
		    <div id="fade"></div>
		</div>
		
		<div class="vs-column three_fourths fit">
			{insert name="getUserStats" type="sub"}
		</div>
		{insert name="getUserStats" type="stats"}
	    </div>
			<div class="clearfix"></div>
	</div>
    </div>
    {if $affiliate_module eq 1 and !$smarty.session.USER_AFFILIATE}
    <script type="text/javascript">
    	$(document).on("click", ".affiliate-request-popup", function() {ldelim}
    		af_url = current_url + menu_section + "?s=account-menu-entry1&do=make-affiliate";
    		$.fancybox({ldelim} type: "ajax", minWidth: "80%", margin: 20, href: af_url {rdelim});
	{rdelim});
    </script>
    {/if}

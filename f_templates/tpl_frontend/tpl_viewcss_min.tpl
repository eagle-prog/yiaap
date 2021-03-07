{if $page_display eq "tpl_view" and ($video_player eq "vjs" or $audio_player eq "vjs")}
	<link href="https://vjs.zencdn.net/5.19/video-js.min.css" rel="stylesheet">
	<link href="{$scripts_url}/shared/videojs/videojs-styles.min.css" rel="stylesheet">
	{if $vjs_advertising eq 1}
	{if $ad_client eq "ima" and $embed_src eq "local"}
	<link href="{$scripts_url}/shared/videojs/videojs.ads.min.css" rel="stylesheet">
	{elseif $ad_client eq "vast" and $embed_src eq "local"}
	<link href="{$scripts_url}/shared/videojs/videojs.vast.vpaid.button.min.css" rel="stylesheet">
	{/if}
	{if $ad_tag_comp eq 1 and $embed_src eq "local"}
	<script type='text/javascript'>var googletag = googletag || {ldelim}{rdelim};googletag.cmd = googletag.cmd || [];(function() {ldelim}var gads = document.createElement('script');gads.async = true;gads.type = 'text/javascript';gads.src = '//www.googletagservices.com/tag/js/gpt.js';var node = document.getElementsByTagName('script')[0];node.parentNode.insertBefore(gads, node);{rdelim})();</script>
	<script type='text/javascript'>googletag.cmd.push(function() {ldelim}googletag.defineSlot('{$ad_tag_comp_id}', [{$ad_tag_comp_w}, {$ad_tag_comp_h}], 'ima-companionDiv').addService(googletag.companionAds()).addService(googletag.pubads());googletag.companionAds().setRefreshUnfilledSlots(true);googletag.pubads().enableVideoAds();googletag.enableServices();{rdelim});</script>
	{/if}
	{/if}
{/if}
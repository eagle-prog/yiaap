<!DOCTYPE html>
<html lang="en">
    <head profile="http://www.w3.org/2005/10/profile">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="description" content="{insert name=getPageMeta for="description"}">
        <meta name="keywords" content="{insert name=getPageMeta for="tags"}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{insert name=getPageMeta for="title"}</title>
{if $google_webmaster ne ""}
	<meta name="google-site-verification" content="{$google_webmaster}">
{/if}
{if $yahoo_explorer ne ""}
	<meta name="y_key" content="{$yahoo_explorer}">
{/if}
{if $bing_validate ne ""}
	<meta name="msvalidate.01" content="{$bing_validate}">
{/if}
{if $page_display eq "tpl_view"}
        <meta name="description" content="{insert name=getPageMeta for="description"}" />
        <meta name="keywords" content="{insert name=getPageMeta for="tags"}" />
        <meta name="author" content="{$main_url}" />
        <meta name="copyright" content="{$website_shortname}" />
        <meta name="application-name" content="{$website_shortname}" />
        <meta name="thumbnail" content="{$media_files_url}/{$usr_key}/t/{$file_key}/1.jpg" />
        <meta property="og:title" content="{insert name=getPageMeta for="title"}" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="{$media_files_url}/{$usr_key}/t/{$file_key}/0.jpg" />
        <meta property="og:image:width" content="640" />
        <meta property="og:image:height" content="360" />
        <meta property="og:url" content="{$main_url}{$smarty.server.REQUEST_URI}" />
        <meta property="og:description" content="{insert name=getPageMeta for="description"}" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="{insert name=getPageMeta for="title"}" />
        <meta name="twitter:description" content="{insert name=getPageMeta for="description"}" />
        <meta name="twitter:image" content="{$media_files_url}/{$usr_key}/t/{$file_key}/1.jpg" />
{/if}
	<link rel="icon" type="image/png" href="{$main_url}/favicon.png">
	<link rel="stylesheet" type="text/css" href="{$styles_url}/icons.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/init.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/icomoon.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/style.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/uisearch.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/jquery.loadmask.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/account.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/tip.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/settings-accordion.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/multilevelmenu/css/component.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/autocomplete/jquery.autocomplete.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/lightbox/jquery.fancybox.css">
        <link rel="preload" href="{$scripts_url}/shared/flagicon/css/flag-icon.min.css" as="style" onload="this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{$scripts_url}/shared/flagicon/css/flag-icon.min.css"></noscript>
	<link rel="stylesheet" type="text/css" href="{$styles_url}/jquery.custom-scrollbar.css">
{if $page_display eq "tpl_signin" or $page_display eq "tpl_signup" or $page_display eq "tpl_recovery" or $page_display eq "tpl_browse" or $page_display eq "tpl_files" or $page_display eq "tpl_view" or $page_display eq "tpl_respond" or $page_display eq "tpl_files_edit" or $page_display eq "tpl_playlist" or $page_display eq "tpl_playlists" or $page_display eq "tpl_channel" or $page_display eq "tpl_manage_channel" or $page_display eq "tpl_channels" or $page_display eq "tpl_subs" or $page_display eq "tpl_upload" or $page_display eq "tpl_import" or $page_display eq "tpl_search" or $page_display eq "tpl_blogs" or $page_display eq "tpl_index"}
        <link rel="stylesheet" type="text/css" href="{$styles_url}/fwtabs.css">
{/if}
{if $page_display eq "tpl_view"}
        <link rel="image_src" href="{$media_files_url}/{$usr_key}/t/{$file_key}/1.jpg">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/owl.css">
{/if}
{if $page_display eq "tpl_view" or $page_display eq "tpl_channel"}
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/blue.css">
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
{/if}
{if $page_display eq "tpl_view" or $page_display eq "tpl_respond" or $page_display eq "tpl_comments" or $page_display eq "tpl_files_edit" or $page_display eq "tpl_playlist" or $page_display eq "tpl_blog" or ($page_display eq "tpl_channel" and ($channel_module eq {href_entry key="discussion"} or $channel_module eq {href_entry key="activity"} or $channel_module eq ""))}
	<link rel="stylesheet" type="text/css" href="{$styles_url}/view.css">
{/if}
{if $page_display eq "tpl_import"}
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/grabber/grabber.css">
{/if}
{if $page_display eq "tpl_upload" or $page_display eq "tpl_import"}
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/blue.css">
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
        <link rel="stylesheet" type="text/css" href="{$javascript_url}/uploader/jquery.plupload.queue/css/jquery.plupload.queue.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/tip.css">
{/if}
{if $page_display eq "tpl_respond" or $page_display eq "tpl_files_edit" or $page_display eq "tpl_account"}
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
{/if}
{if $page_display eq "tpl_files" or $page_display eq "tpl_messages" or $page_display eq "tpl_subs" or ($page_display eq "tpl_index" and $smarty.session.USER_ID gt 0)}
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
{/if}
{if $page_display eq "tpl_view" and $video_player eq "flow"}
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/flowplayer/minimalist.css">
{/if}
{if $page_display eq "tpl_view" and ($video_player eq "vjs" or $audio_player eq "vjs")}
	<link href="https://vjs.zencdn.net/5.19/video-js.css" rel="stylesheet">
	<link href="{$scripts_url}/shared/videojs/videojs-styles.css" rel="stylesheet">
	{if $vjs_advertising eq 1}
	{if $ad_client eq "ima" and $embed_src eq "local"}
	<link href="{$scripts_url}/shared/videojs/videojs.ads.css" rel="stylesheet">
	<link href="{$scripts_url}/shared/videojs/videojs.ima.css" rel="stylesheet">
	{elseif $ad_client eq "vmap" and $embed_src eq "local"}
	<link href="{$scripts_url}/shared/videojs/videojs.ads.css" rel="stylesheet">
	<link href="{$scripts_url}/shared/videojs/vast-button.css" rel="stylesheet">
	{elseif $ad_client eq "vast" and $embed_src eq "local"}
	<link href="{$scripts_url}/shared/videojs/videojs.vast.vpaid.min.css" rel="stylesheet">
	<link href="{$scripts_url}/shared/videojs/vast-button.css" rel="stylesheet">
	{/if}
	{if $ad_tag_comp eq 1 and $embed_src eq "local"}
	<script type='text/javascript'>var googletag = googletag || {ldelim}{rdelim};googletag.cmd = googletag.cmd || [];(function() {ldelim}var gads = document.createElement('script');gads.async = true;gads.type = 'text/javascript';gads.src = '//www.googletagservices.com/tag/js/gpt.js';var node = document.getElementsByTagName('script')[0];node.parentNode.insertBefore(gads, node);{rdelim})();</script>
	<script type='text/javascript'>googletag.cmd.push(function() {ldelim}googletag.defineSlot('{$ad_tag_comp_id}', [{$ad_tag_comp_w}, {$ad_tag_comp_h}], 'ima-companionDiv').addService(googletag.companionAds()).addService(googletag.pubads());googletag.companionAds().setRefreshUnfilledSlots(true);googletag.pubads().enableVideoAds();googletag.enableServices();{rdelim});</script>
	{/if}
	{/if}
{/if}
{if $page_display eq "tpl_index"}
	<link rel="stylesheet" type="text/css" href="{$styles_url}/home.css">
	<link rel="stylesheet" type="text/css" href="{$styles_url}/owl.css">
{/if}
{if $page_display eq "tpl_channel"}
	<link rel="stylesheet" type="text/css" href="{$styles_url}/channel.css">
	<link rel="stylesheet" type="text/css" href="{$styles_url}/channel.timeline.css">
{/if}
{if $page_display eq "tpl_channels" or ($page_display eq "tpl_search" and $smarty.get.tf eq 6)}
	<link rel="stylesheet" type="text/css" href="{$styles_url}/channel.css">
{/if}
{if $page_display eq "tpl_search"}
	<link rel="stylesheet" type="text/css" href="{$styles_url}/search.css">
{/if}
{if ($smarty.session.USER_ID eq "" and ($page_display eq "tpl_signin" or $page_display eq "tpl_signup" or $page_display eq "tpl_recovery" or $page_display eq "tpl_payment")) or ($smarty.session.USER_ID gt 0 and $page_display eq "tpl_payment")}
	{if $page_display eq "tpl_signup"}
	<link rel="stylesheet" type="text/css" href="{$styles_url}/jquery.password.css">
	{/if}
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
	<link rel="stylesheet" type="text/css" href="{$styles_url}/login.css">
{/if}
{if $page_display eq "tpl_manage_channel"}
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/cropper/cropper.min.css">
	<link rel="stylesheet" type="text/css" href="{$styles_url}/channel.manage.css">
{/if}
{if ($page_display eq "tpl_affiliate" and $smarty.session.USER_AFFILIATE eq 1) or ($page_display eq "tpl_subscribers" and $smarty.session.USER_PARTNER eq 1)}
        <link rel="stylesheet" type="text/css" href="{$styles_url}/fwtabs.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/datepicker/tiny-date-picker.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/datepicker/date-range-picker.css">
{/if}
	{if $comment_emoji eq 1 and ($page_display eq "tpl_view" or ($page_display eq "tpl_channel" and $channel_module eq {href_entry key="discussion"}))}{include file="tpl_frontend/tpl_emojionearea.css.tpl"}{/if}
        <link rel="preload" href="{$styles_url}/media_queries.css" as="style" onload="this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{$styles_url}/media_queries.css"></noscript>
	<link rel="stylesheet" type="text/css" href="{$styles_url}/theme/yt.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/theme/{$theme_name}.css" id="fe-color">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/theme/{$theme_name}_backend.css" id="be-color">

	<link rel="stylesheet" type="text/css" href="{$styles_url}/custom.css">

	<script src="{$javascript_url}/jquery-1.11.1.min.js" type="text/javascript"></script>
        <script src="{$scripts_url}/shared/webfont.js" type="text/javascript"></script>
        <script>WebFont.load({ldelim}google:{ldelim}families:['Roboto:300,400,500,600,700']{rdelim}{rdelim});</script>
    </head>

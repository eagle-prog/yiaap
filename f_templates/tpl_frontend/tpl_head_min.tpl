<!DOCTYPE html>
<html lang="en">
    <head profile="http://www.w3.org/2005/10/profile">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>{insert name=getPageMeta for="title"}</title>
        <meta name="description" content="{insert name=getPageMeta for="description"}">
        <meta name="keywords" content="{insert name=getPageMeta for="tags"}">
        {if $page_display eq "tpl_view"}{include file="tpl_frontend/tpl_headview_min.tpl"}{elseif $page_display eq "tpl_channel"}{include file="tpl_frontend/tpl_headchannel_min.tpl"}{elseif $smarty.get.next eq ""}{include file="tpl_frontend/tpl_headmain_min.tpl"}{/if}
        <link rel="icon" type="image/png" href="{$main_url}/favicon.png">
	<link rel="stylesheet" type="text/css" href="{$styles_url}/init0.min.css">
        <link rel="preload" href="{$scripts_url}/shared/flagicon/css/flag-icon.min.css" as="style" onload="this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{$scripts_url}/shared/flagicon/css/flag-icon.min.css"></noscript>
        {insert name="loadcssplugins"}
        {if $comment_emoji eq 1 and ($page_display eq "tpl_view" or ($page_display eq "tpl_channel" and $channel_module eq {href_entry key="discussion"}))}{include file="tpl_frontend/tpl_emojionearea.css.tpl"}{/if}
        <link rel="preload" href="{$styles_url}/media_queries.min.css" as="style" onload="this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{$styles_url}/media_queries.min.css"></noscript>
	<link rel="stylesheet" type="text/css" href="{$styles_url}/theme/yt.min.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/theme/{$theme_name}.min.css" id="fe-color">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/theme/{$theme_name}_backend.min.css" id="be-color">
	<link rel="stylesheet" type="text/css" href="{$styles_url}/custom.min.css">
	<script src="{$javascript_url}/jquery.min.js" type="text/javascript"></script>
    <script src="{$javascript_url}/jquery.captcha.basic.js" type="text/javascript"></script>
        <script>WebFont.load({ldelim}google:{ldelim}families:['Roboto:300,400,500,600,700']{rdelim}{rdelim});</script>
    </head>

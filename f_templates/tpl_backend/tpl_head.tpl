<!DOCTYPE html>
<html lang="en" class="no-js">
    <head profile="http://www.w3.org/2005/10/profile">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>{$page_title}</title>
        
        <meta name="description" content="{$metaname_description}">
        <meta name="keywords" content="{$metaname_keywords}">
        <meta name="author" content="ViewShark.com">
        <link rel="icon" type="image/png" href="{$main_url}/favicon.png">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/normalize.css">
{if $page_display eq "backend_tpl_dashboard" or $page_display eq "backend_tpl_analytics" or ($page_display eq "backend_tpl_subscriber" and $smarty.get.rg eq "1")}
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/dash.css">
{/if}
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/icons.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/default.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/fwtabs.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/blue.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/jquery.loadmask.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/tip.css">
{if $smarty.session.ADMIN_NAME ne ""}
	<link rel="stylesheet" type="text/css" href="{$styles_url_be}/menu.css">
	<link rel="stylesheet" type="text/css" href="{$styles_url_be}/play.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/dcaccordion.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/settings-accordion.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/jquery.nouislider.min.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/lightbox/jquery.fancybox.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/multilevelmenu/css/component.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/autocomplete/jquery.autocomplete.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url}/uisearch.css">
{else}
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/login.css">
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/jquery.password.css">
{/if}
        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/mediaqueries.css">
{if $page_display eq "backend_tpl_import"}
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/grabber/grabber.css">
{/if}
{if $page_display eq "backend_tpl_upload"}
	<link type="text/css" rel="stylesheet" href="{$javascript_url}/uploader/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen">
{/if}
{if $smarty.session.ADMIN_NAME ne ""}
{if ($video_player eq "vjs" or $audio_player eq "vjs")}
	<link href="https://vjs.zencdn.net/5.19/video-js.css" rel="stylesheet">
	<link href="{$scripts_url}/shared/videojs/videojs-styles.css" rel="stylesheet">
{/if}
{/if}
{if $page_display eq "backend_tpl_affiliate" or $page_display eq "backend_tpl_subscriber"}
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/datepicker/tiny-date-picker.css">
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/datepicker/date-range-picker.css">
<!--        <link rel="stylesheet" type="text/css" href="{$styles_url_be}/affiliate.css"> -->
{/if}
	<link rel="stylesheet" type="text/css" href="{$styles_url}/custom.css">
	<link rel="stylesheet" type="text/css" href="{$styles_url_be}/theme/{$theme_name_be}_backend.css" id="be-color">
	<link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/flagicon/css/flag-icon.min.css">
	<script type="text/javascript" src="{$javascript_url_be}/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/webfont.js"></script>
        <script>WebFont.load({ldelim}google:{ldelim}families:['Roboto:300,400,500,600,700']{rdelim}{rdelim});</script>
    </head>

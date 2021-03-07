<?php
/**************************************************************************************************
| Software Name        : ViewShark
| Software Description : High End Video, Photo, Music, Document & Blog Sharing Script
| Software Author      : (c) ViewShark
| Website              : http://www.viewshark.com
| E-mail               : info@viewshark.com
|**************************************************************************************************
|
|**************************************************************************************************
| This source file is subject to the ViewShark End-User License Agreement, available online at:
| http://www.viewshark.com/support/license/
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2013-2019 viewshark.com. All rights reserved.
|**************************************************************************************************/

define('_ISVALID', true);

include_once 'f_core/config.core.php';

include_once $class_language->setLanguageFile('frontend', 'language.home');
include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('frontend', 'language.files');
include_once $class_language->setLanguageFile('frontend', 'language.files.menu');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');
include_once $class_language->setLanguageFile('frontend', 'language.userpage');

$error_message 		= NULL;
$cfg                    = $class_database->getConfigurations('video_uploads,video_player,image_player,audio_player,document_player,public_channels,channel_bulletins,user_subscriptions,paid_memberships,file_counts,file_comments,channel_comments,file_comment_votes,file_responses,file_rating,file_favorites,file_deleting,file_delete_method,file_privacy,file_playlists,file_views,file_history,file_watchlist,file_embedding,file_social_sharing,message_count,server_path_php,thumbs_width,thumbs_height,file_comment_spam');

if (isset($_GET['ap'])) {
	$_SESSION['ap'] = (int) $_GET['ap'];

	exit;
}

if (isset($_GET['m']) or isset($_GET['n'])) {
	if (isset($_GET['m']))
		$_SESSION['sbm'] = 1;
	else
		$_SESSION['sbm'] = 0;

	exit;
}

$home			= new VHome;
$browse			= new VBrowse;

if (isset($_GET['cfg'])) {
	$html		= VHome::homeConfig();
	exit;
} elseif (isset($_GET['load'])) {
	$html		= VHome::userNotifications();
	exit;
} elseif (isset($_GET['loadall'])) {
	$html		= VHome::userNotifications(true);
	exit;
} elseif (isset($_GET['hide'])) {
	$html		= VHome::hideNotifications();
	exit;
} elseif (isset($_GET['unhide'])) {
	$html		= VHome::hideNotifications(true);
	exit;
} elseif (isset($_GET['sub'])) {
	$html		= VHome::subContent();
	exit;
} elseif (isset($_GET['categ'])) {
	$html		= VHome::categContent();
	exit;
} elseif (isset($_GET['rc'])) {
	$html		= VHome::recommend_more();
	exit;
} else if (isset($_GET["a"])) {
switch($_GET["a"]){
    case "sub":
        $act            = VChannels::chSubscribe();
    break;
    case "unsub":
        $act            = VChannels::chSubscribe(1);
    break;
    case "cb-favadd":
    case "cb-watchadd":
    default:
	$ct	= isset($_GET["a"]) ? VFiles::doActions($_GET["a"]) : NULL;
    break;
}
} elseif (isset($_GET["do"])) {
switch($_GET["do"]){
    case "act-load":
	echo $ct	= VHome::getActivity();
    break;
    case "vm":
	echo $ct	= VHome::viewMode();
    break;
    case "vm-ch":
	echo $ct	= VChannels::viewMode(1);
    break;
    case "featured-list":
    case "channel-sort":
	echo $ct	= $_GET["a"] == '' ? VHome::featuredFiles() : NULL;
    break;
    case "channel-browse":
    case "channel-list":
	echo $ct	= $_GET["a"] == '' ? VHome::listFeaturedChannels() : NULL; break;
    case "subscribe":
	echo $ct	= VHome::subscribeActions(); break;
    case "unsubscribe":
	echo $ct	= VHome::subscribeActions(1); break;
}
}
$smarty->assign('not_found', true);

$check_rd		= (isset($_GET["feature"]) and $_GET["feature"] == 'channels' and $cfg["public_channels"] == 0) ? $class_redirect->to('', VHref::getKey('index')) : NULL;
$page	 		= (!isset($_GET["do"]) and !isset($_GET["a"])) ? $class_smarty->displayPage('frontend', 'tpl_index', $error_message) : NULL;

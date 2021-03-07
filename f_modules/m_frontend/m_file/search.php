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

include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('frontend', 'language.search');
include_once $class_language->setLanguageFile('frontend', 'language.home');
include_once $class_language->setLanguageFile('frontend', 'language.userpage');
include_once $class_language->setLanguageFile('frontend', 'language.files');
include_once $class_language->setLanguageFile('frontend', 'language.files.menu');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');

$error_message 	   	= NULL;
$notice_message    	= NULL;

$cfg		   	= $class_database->getConfigurations('user_subscriptions,user_friends,user_blocking,internal_messaging,channel_views,file_counts,file_comments,channel_comments,file_comment_votes,file_responses,file_rating,file_favorites,file_deleting,file_delete_method,file_privacy,file_playlists,file_views,file_history,file_watchlist,file_embedding,file_social_sharing,message_count,server_path_php,thumbs_width,thumbs_height,video_player,channel_promo,file_promo');
$membership_check       = ($cfg["paid_memberships"] == 1 and $_SESSION["USER_ID"] > 0) ? VLogin::checkSubscription() : NULL;
$_a			= isset($_GET["a"]) ? $class_filter->clr_str($_GET["a"]) : null;
$_do			= isset($_GET["do"]) ? $class_filter->clr_str($_GET["do"]) : null;

$search			= new VSearch;

switch($_do) {
	case "autocomplete":
		VGenerate::processAutoComplete('search');
	break;
}
switch($_a) {
    case "cb-favadd":
    case "cb-watchadd":
    default:
	$ct		= $_a != '' ? VFiles::doActions($_a) : null;
    break;
    case "sub":
        $act            = VChannels::chSubscribe();
    break;
    case "unsub":
        $act            = VChannels::chSubscribe(1);
    break;
    case "cb-addfr":
    case "cb-remfr":
    case "cb-block":
    case "cb-unblock":
        $act            = VChannels::contactActions($_a);
    break;
    case "cb-msg":
        $act            = VChannels::sessionMessageName();
    break;
}

$c_section		= VSearch::c_section();
$guest_chk              = ($error_message == '' and !isset($_GET["s"]) and $_do == '' and $_a == '') ? VHref::guestPermissions('guest_search_page', VHref::getKey("search").'?q='.$class_filter->clr_str($_GET["q"])) : NULL;
$display_page	   	= (!isset($_GET["s"]) and $_do == '' and $_a == '' and !isset($_GET["v"])) ? $class_smarty->displayPage('frontend', 'tpl_search', $error_message, $notice_message) : NULL;

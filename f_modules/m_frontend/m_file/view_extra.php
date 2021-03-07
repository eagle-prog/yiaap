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
include_once $class_language->setLanguageFile('frontend', 'language.files');
include_once $class_language->setLanguageFile('frontend', 'language.files.menu');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');
include_once $class_language->setLanguageFile('frontend', 'language.userpage');
include_once $class_language->setLanguageFile('frontend', 'language.view');

$error_message 	   	= NULL;
$notice_message    	= NULL;

$cfg		   	= $class_database->getConfigurations('paid_memberships,file_counts,file_comments,channel_comments,file_comment_votes,file_responses,file_rating,file_favorites,file_deleting,file_delete_method,file_privacy,file_playlists,file_views,file_history,file_watchlist,file_embedding,file_social_sharing,message_count,server_path_php,thumbs_width,thumbs_height,user_blocking,file_flagging,file_email_sharing,file_permalink_sharing,fcc_limit,file_comment_min_length,file_comment_max_length,file_comment_spam,ucc_limit,comment_min_length,comment_max_length');
$notifier               = new VNotify;
$membership_check       = ($cfg["paid_memberships"] == 1 and $_SESSION["USER_ID"] > 0) ? VLogin::checkSubscription() : NULL;

$view                   = new VView;
$vfiles                 = new VFiles;
$vbrowse                = new VBrowse;

if (isset($_GET["c"]) and (int) $_GET["c"] > 0) {
	$class		= 'VChannelComments';
	
	new $class;
} else {
	$class		= 'VComments';
}

switch($_GET["do"]){
    case "comm-suspend"://suspend comments
    case "comm-approve"://approve comments
    case "comm-spam"://report spam
    case "comm-delete"://delete comments
    case "comm-like"://like
    case "comm-dislike"://dislike
	echo $do_load	= $class::commentActions($_GET["do"]); break;
    case "comm-load"://load/reload after posting, etc
	echo $do_load	= $class::browseComment(); break;
    case "comm-post"://post comments
    case "comm-reply"://reply comments
	echo $do_load	= $class::postComment(); break;
//    case "user-sub"://subscribe to file owner
//        echo $do_load   = VView::chSubscribe('', (int) $_POST["comm_uid"]); break;
//    case "user-unsub"://unsubscribe
//        echo $do_load   = VView::chSubscribe(1, (int) $_POST["comm_uid"]); break;

}

$display_page	   	= (!isset($_GET["s"]) and !isset($_GET["do"])) ? $class_smarty->displayPage('frontend', 'tpl_comments', $error_message, $notice_message) : NULL;

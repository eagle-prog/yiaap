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
include_once $class_language->setLanguageFile('frontend', 'language.browse');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');

$error_message 	   	= NULL;
$notice_message    	= NULL;

$cfg                    = $class_database->getConfigurations('video_player,image_player,audio_player,document_player,paid_memberships,file_counts,file_comments,channel_comments,file_comment_votes,file_responses,file_rating,file_favorites,file_deleting,file_delete_method,file_privacy,file_playlists,file_views,file_history,file_watchlist,file_embedding,file_social_sharing,message_count,server_path_php,thumbs_width,thumbs_height,file_comment_spam');
$uri	= $class_filter->clr_str($_SERVER["REQUEST_URI"]);
$a	= explode("/", $uri);
$t	= count($a);
$c	= null;

if ($a[$t-2] == $href["subscriptions"]) {
	$c = '/'.$class_filter->clr_str($a[$t-1]);
}

$logged_in	   	= VLogin::checkFrontend(VHref::getKey("subscriptions").$c);
$membership_check       = ($cfg["paid_memberships"] == 1 and $_SESSION["USER_ID"] > 0) ? VLogin::checkSubscription() : NULL;

$files                  = new VFiles;

switch($_GET["do"]){
	case "autocomplete":
		$autocomplate	= VGenerate::processAutoComplete('media_library');
	break;
	case "video-thumb"://set playlist thumb
	case "image-thumb":
	case "audio-thumb":
	case "doc-thumb":
        	$pl_thumb 	= VFiles::plThumb($_GET["a"]);
        	break;
        case "read"://mark as read
        	$read           = VMessages::readMessage();
        	break;
        case "comm-disable"://suspend comment
        case "comm-enable"://approve comment
        case "comm-delete"://delete comment
		$comm_action	= VFiles::ownCommentActions($_GET["do"]);
		break;
	case "resp-disable"://suspend comment
	case "resp-enable"://approve comment
	case "resp-delete"://delete comment
		$resp_action	= VFiles::ownResponseActions($_GET["do"]); 
		break;
}

switch($_GET["a"]){
    case "sort-video"://file type sort menu
    case "sort-image"://file type sort menu
    case "sort-audio"://file type sort menu
    case "sort-doc"://file type sort menu
	$sort_action	= VFiles::fileTypeMenu($_GET["a"]); break;
    case "cb-renable"://approve selected responses
    case "cb-rdisable"://suspend selected responses
    case "cb-rdel"://delete selected responses
	$resp_action	= VFiles::ownResponseActions($_GET["a"]); break;
    case "cb-enable"://approve selected comments
    case "cb-disable"://suspend selected comments
    case "cb-commdel"://delete selected comments
	$comm_action	= VFiles::ownCommentActions($_GET["a"]); break;
    case "cb-private"://make private
    case "cb-public"://make public
    case "cb-personal"://make personal
    case "cb-favadd"://add to fav
    case "cb-watchadd"://add to watchlist
    case "cb-watchclear"://clear from watchlist
    case "cb-favclear"://clear from fav
    case "cb-likeclear"://clear liked
    case "cb-histclear"://clear history
    case "cb-delete"://delete files
	$cb_action	= VFiles::doActions($_GET["a"]); break;
    case "video-thumb"://set playlist thumb
    case "image-thumb":
    case "audio-thumb":
    case "doc-thumb":
        $pl_thumb 	= VFiles::plThumb($_GET["a"]); break;
    case "confirm":
    	$confirm	= VFiles::doConfirm(); break;
    case "pl-sort"://reorder playlists
        $pl_sort	= VFiles::plSort(); break;
    case "pl-cfg"://playlist settings
        $pl_cfg 	= VFiles::plCfgTabs(); break;
    case "pl-new"://create new playlists
        $pl_new 	= VFiles::plCreateNew(); break;
    case "pl-add"://submit new playlists
        $pl_add 	= VFiles::plAddNew(); break;
    case "menu"://reoload playlists left menus
        $pl_menu 	= VFiles::plReloadMenu(); break;
    case "share-pl"://share playlists
	$pl_share	= VFiles::plShare(); break;
    case "embed-pl"://embed playlists
    case "email-pl"://email playlists
    case "social-pl"://social share playlists
	$pl_embed	= VFiles::plUpdateEmbed(); break;
    case "delete-pl"://delete playlist
	$pl_delete	= VFiles::plDelete(); break;
    case "update-pl"://update playlist info
	$pl_update	= VFiles::plUpdate(); break;
    case "update-order"://update playlist order
	$pl_order	= VFiles::plUpdateOrder(); break;
    case "update-thumb"://update playlist order
	$pl_order	= VFiles::plUpdateThumbnail(); break;
    case "update-privacy"://update playlist privacy
	$pl_priv	= VFiles::plUpdatePrivacy(); break;
    case "pl-mail"://email a playlist
	$pl_mail	= VFiles::plMail(); break;
    break;
    case "sub_edit"://subscription settings
        $sub_action     = VFiles::setSubSettings();
    break;
    default://add/clear from pl
	$cb_action	= (substr($_GET["a"], 0, 8) == 'cb-label') ? VFiles::doActions($_GET["a"]) : NULL; break;
}



if (isset($_GET["p"]) and (int) $_GET["p"] >= 0) {//viewmode changer/loader
	$sort		= $class_filter->clr_str($_GET["sort"]);
        $view_mode 	= (int) $_GET["m"];
        
        if (isset($_GET["pp"]) and (int) $_GET["pp"] == 1 and $sort != 'plpublic' and $sort != 'plviews' and $sort != 'titleasc' and $sort != 'titledesc') {
        	$view_mode = ($view_mode == 4) ? 1 : ($view_mode == 5 ? 2 : ($view_mode == 6 ? 3 : 1));
        }

        switch ($view_mode) {
		case 1:
		case 2:
		case 3:
	        	echo $html = (int) $_GET["m"] > 0 ? VFiles::viewMode_loader($view_mode) : null;

	        break;
	        case 4:
	        case 5:
	        case 6:
	        	$type	 = $class_filter->clr_str($_GET["t"]);
	        	
	        	$entries = VFiles::listPlaylists($type, true);
	        	
	        	$html	 = VFiles::listPlaylistMedia_content($type, $entries);
	        	
	        	echo $html;
	        break;
        }
}




if (!isset($_GET["s"]) and !isset($_GET["do"]) and !isset($_GET["p"]) and !isset($_GET["a"])) {
        $section_check = VFiles::browseInit();
        $smarty->assign('c_section', VHref::getKey("subscriptions"));

        $display_page = $class_smarty->displayPage('frontend', 'tpl_subs', $error_message, $notice_message);
}

$display_section	= ((isset($_GET["v"]) or isset($_GET["s"])) and !isset($_GET["m"]) and $_GET["a"] != 'sub_edit') ? VFiles::sectionWrap() : NULL;

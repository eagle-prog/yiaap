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
defined ('_ISVALID') or die ('Unauthorized Access!');
//var init
define('SK_INC', '0');
$cfg      		= array();
$language 		= array();
//require init
require_once 'config.cache.php';
require_once 'config.set.php';
require_once 'config.href.php';
require_once 'config.folders.php';
require_once 'config.paging.php';
require_once 'config.footer.php';
require_once 'config.smarty.php';
require_once 'config.autoload.php';
//cache dir
$ADODB_CACHE_DIR	= $cfg['db_cache_dir'];
//include init
include_once 'f_classes/class_adodb/adodb.inc.php';
include_once 'f_classes/class_mobile/Mobile_Detect.php';
include_once 'f_functions/functions.general.php';
//class init
$class_filter		= new VFilter;
$class_language 	= new VLanguage;
$class_redirect 	= new VRedirect;
$class_smarty		= new VTemplate;
$class_database 	= new VDatabase;
//database, config and lang init
$db 			= $class_database->dbConnection();
$cfg 			= $class_database->getConfigurations('affiliate_module,live_module,live_server,live_uploads,live_cast,live_chat,live_chat_server,live_chat_salt,live_vod,live_vod_server,live_hls_server,live_del,thumbs_nr,mobile_module,mobile_detection,default_language,head_title,metaname_description,metaname_keywords,website_shortname,video_module,video_uploads,image_module,image_uploads,audio_module,audio_uploads,document_module,document_uploads,activity_logging,debug_mode,website_offline_mode,website_offline_message,internal_messaging,user_friends,user_blocking,channel_comments,file_comments,paid_memberships,user_subscriptions,file_playlists,public_channels,session_name,session_lifetime,date_timezone,google_analytics,google_webmaster,yahoo_explorer,bing_validate,backend_menu_toggle,benchmark_display,facebook_link,twitter_link,gplus_link,twitter_feed,blog_module,file_favorites,file_rating,file_history,file_watchlist,file_playlists,file_comments,file_responses,custom_tagline,user_follows,file_approval,video_player,audio_player,comment_emoji,social_media_links,user_tokens,alert_description,alert_enabled,dynamic_menu');$cfg["global_salt_key"]='nad0af09j30fm93049f30m94f3mf90f04m94094m03999999999999';
//session init
VSession::init();
//check access based on IP address
VIPaccess::sectionAccess($backend_access_url);
//theme init
require 'config.theme.php';
//load some language files
include_once $class_language->setLanguageFile('frontend', 'language.footer');
if (VSession::isLoggedIn()) {
	include_once $class_language->setLanguageFile('frontend', 'language.files');
	include_once $class_language->setLanguageFile('frontend', 'language.files.menu');
}
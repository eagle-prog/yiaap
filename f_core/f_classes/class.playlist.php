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

class VPlaylist {
	private static $type;
        private static $cfg;
        private static $db;
        private static $db_cache;
        private static $dbc;
        private static $filter;
        private static $language;
        private static $href;
        private static $page;
        private static $page_end;
	private static $page_links;
	private static $smarty;

        public function __construct() {
		require 'f_core/config.href.php';

		global $cfg, $class_filter, $class_database, $db, $language, $smarty;

		self::$filter	= $class_filter;

		$_type		= self::typeInit();

		self::$type	= $_type == 'document' ? 'doc' : $_type;
		self::$cfg	= $cfg;
		self::$db	= $db;
		self::$dbc	= $class_database;
		self::$language = $language;
		self::$href	= $href;
		self::$page	= isset($_GET["page"]) ? (int) $_GET["page"] : 1;
		self::$page_end = false;
		self::$page_links = null;
		self::$smarty	= $smarty;
		
		self::$db_cache = false; //change here to enable caching
        }
	/* type init */
	function typeInit() {
		$cfg = self::$cfg;

		$type = $cfg["video_module"] == 1 ? 'video' : ($cfg["live_module"] == 1 ? 'live' : ($cfg["image_module"] == 1 ? 'image' : ($cfg["audio_module"] == 1 ? 'audio' : ($cfg["document_module"] == 1 ? 'doc' : ($cfg["blog_module"] == 1 ? 'blog' : null)))));

		switch ($_GET["sort"]) {
			case "sort-live": $type = $cfg["live_module"] == 1 ? 'live' : $type;
				break;
			case "sort-video": $type = $cfg["video_module"] == 1 ? 'video' : $type;
				break;
			case "sort-image": $type = $cfg["image_module"] == 1 ? 'image' : $type;
				break;
			case "sort-audio": $type = $cfg["audio_module"] == 1 ? 'audio' : $type;
				break;
			case "sort-doc": $type = $cfg["document_module"] == 1 ? 'doc' : $type;
				break;
			case "sort-blog": $type = $cfg["blog_module"] == 1 ? 'blog' : $type;
				break;
		}

		return $type;
	}

	/* general layout */
	function doLayout(){
		$html	 = VFiles::listPlaylists('video', false);
		
		return $html;
	}
}
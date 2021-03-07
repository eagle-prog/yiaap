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

class VSession {
    /* initialize sessions */
    public static function init() {
	global $cfg, $class_language, $class_filter, $section, $href, $class_database;

	$m	= 'files';
	$sec	= $cfg["session_lifetime"]*60;

	ini_set('display_errors', 0);
	if ($m == 'memcached') {
		new VmemcacheSessionHandler();

		ini_set('session.save_handler', 'memcached');
		ini_set('session.save_path', 'localhost:11211');
		ini_set('session.use_only_cookies', 1);
	} else {
		ini_set('session.save_handler', 'files');
		ini_set('session.save_path', $cfg["main_dir"].'/f_data/data_sessions');
		ini_set('session.use_only_cookies', 0);
	}
	ini_set('session.name', $cfg["session_name"]);
	ini_set('session.use_cookies', 1);
	ini_set('session.gc_maxlifetime', $sec);

	if (ini_get('date.timezone') == '') {
    	    ini_set('date.timezone', $cfg['date_timezone']);
    	    date_default_timezone_set($cfg['date_timezone']);
	}
	if (isset($_POST["PHPSESSID"])){
//	    session_id($class_filter->clr_str($_POST["PHPSESSID"]));
	}

	VSession::_start();
	VSession::_sessionInit();
    }
    private static function _start() {
    	session_start();
    }
    private static function _sessionInit() {
	global $cfg, $class_language, $class_filter, $section, $href;

	require 'f_core/config.backend.php';
	require 'f_core/config.language.php';

	$sec	= $cfg["session_lifetime"]*60;

	$_section       = (strstr($_SERVER['REQUEST_URI'], $backend_access_url) == true) ? 'backend' : 'frontend';
	if ($section == VHref::getKey("index") and !isset($_SERVER['HTTPS']))  {
		header("Location:".$cfg["main_url"].'/'.VHref::getKey("index"));
		exit;
	}
	/* session activity timeout check */
	if ($_section == 'frontend' and intval($_SESSION["USER_ID"]) > 0){
	    $lt 	= strtotime("-".$sec." seconds");
	    if($lt > 0 and intval($_SESSION["last_activity"]) > 0 and intval($_SESSION["last_activity"]) < $lt){
		VLogin::logoutAttempt('frontend');
	    }
	    $_SESSION["last_activity"] = time();
	}
	/* session language check */
	$_lang	 	= langTypes();
	foreach($_lang as $lk => $lv){
	    if($lv["lang_default"] == 1){
	        $_f	= $lk;
	        $_fl	= $lv["lang_flag"];
	    }
	}

	if (($_section == 'frontend' and $_SESSION["fe_lang"] == '') or ($_section == 'backend' and $_SESSION["be_lang"] == '')){//language sessions
		$_SESSION["fe_lang"]    = $_f;
		$_SESSION["fe_flag"]    = $_fl;
		$_SESSION["be_lang"]    = $_f;
		$_SESSION["be_flag"]    = $_fl;
	}
	if ($section == $href['search']) {//search filter sessions
		$q	= isset($_GET["q"]) ? $class_filter->clr_str($_GET["q"]) : null;
		$tf	= isset($_GET["tf"]) ? (int) $_GET["tf"] : 0;
		$uf	= isset($_GET["uf"]) ? (int) $_GET["uf"] : 0;
		$df	= isset($_GET["df"]) ? (int) $_GET["df"] : 0;
		$ff	= isset($_GET["ff"]) ? (int) $_GET["ff"] : 0;
		
		$_SESSION["q"]		= $q;
		$_SESSION["tf"]		= $tf;
		$_SESSION["uf"]		= $uf;
		$_SESSION["df"]		= $df;
		$_SESSION["ff"]		= $ff;
	} else {
		if (empty($_GET)) {
//			$_SESSION["q"]		= null;
//			$_SESSION["tf"]		= null;
//			$_SESSION["uf"]		= null;
//			$_SESSION["df"]		= null;
//			$_SESSION["ff"]		= null;
		}
	}
	if ($_section == 'frontend' and !isset($_SESSION["sbm"])) {
		$_SESSION["sbm"]	= 1;
	}
    }
    public static function isLoggedIn() {
    	return ((int) $_SESSION["USER_ID"] > 0 ? true : false);
    }
}
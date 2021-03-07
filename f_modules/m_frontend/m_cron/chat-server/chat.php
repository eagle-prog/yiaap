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

$main_dir = realpath(dirname(__FILE__).'/../../../../');
set_include_path($main_dir);

include_once 'filter.php';

$class_filter	= new VFilter;

//include_once $class_language->setLanguageFile('frontend', 'language.global');

$host	= array('127.0.0.1');

//echo $_SERVER["REMOTE_ADDR"];

$_POST = $HTTP_RAW_POST_DATA = file_get_contents('php://input');
//$_POST = $HTTP_RAW_POST_DATA;
$post = json_decode($_POST);


if ($_POST and in_array($_SERVER["REMOTE_ADDR"], $host)) {
    require 'cfg.php';

    $conn   = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
            }
            echo "Connected successfully\n";

    $p_chatid = $class_filter->clr_str($post->a);
    $p_fkey = $class_filter->clr_str($post->b);
    $p_nick = $class_filter->clr_str($post->c);
    $p_ip = $class_filter->clr_str($post->d);
    $p_chid = $class_filter->clr_str($post->e);
    $p_uid = $class_filter->clr_str($post->f);
    $p_cua = $class_filter->clr_str($post->g);
    $p_own = $class_filter->clr_str($post->h);
    $p_ukey = $class_filter->clr_str($post->i);
    $p_badge = $class_filter->clr_str($post->j);
    $cip = date("Y-m-d");
    $salt = $cfg["live_chat_salt"];
    $p_fp = md5($_SERVER["HTTP_USER_AGENT"] . $cip . $salt);

    $q = sprintf("SELECT `db_id` FROM `db_livechat` WHERE `channel_id`='%s' AND `chat_id`='%s' AND `stream_id`='%s' LIMIT 1;", $p_chid, $p_chatid, $p_fkey);
    $r = mysqli_query($conn, $q);
    $rn = $r->num_rows;
    if ($rn == 0) {
	$q = sprintf("INSERT INTO `db_livechat` (`chat_id`, `channel_id`, `channel_owner`, `usr_id`, `usr_key`, `stream_id`, `chat_user`, `chat_ip`, `chat_fp`, `chat_time`, `badge`, `logged_in`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
		$p_chatid, $p_chid, $p_own, $p_uid, $p_ukey, $p_fkey, $p_nick, $p_ip, $p_fp, date("Y-m-d H:i:s"), $p_badge, (substr( $p_nick, 0, 5 ) === "Guest" ? 0 : 1));
	$r = mysqli_query($conn, $q);
    } else {
	echo "found";
    }

    $q = sprintf("SELECT `db_id` FROM `db_livemods` WHERE `channel_id`='%s' LIMIT 1;", $p_chid);
    $r = mysqli_query($conn, $q);
    $rn = $r->num_rows;
    if ($rn == 0) {
	$q = sprintf("INSERT INTO `db_livemods` (`channel_id`, `mod_list`) VALUES ('%s', '[]');", $p_chid);
	$r = mysqli_query($conn, $q);
    }

    $q = sprintf("SELECT `db_id` FROM `db_livebans` WHERE `channel_id`='%s' LIMIT 1;", $p_chid);
    $r = mysqli_query($conn, $q);
    $rn = $r->num_rows;
    if ($rn == 0) {
	$q = sprintf("INSERT INTO `db_livebans` (`channel_id`, `ban_list`) VALUES ('%s', '[]');", $p_chid);
	$r = mysqli_query($conn, $q);
    }

    $q = sprintf("SELECT `db_id` FROM `db_livefollows` WHERE `channel_id`='%s' LIMIT 1;", $p_chid);
    $r = mysqli_query($conn, $q);
    $rn = $r->num_rows;
    if ($rn == 0) {
	$q = sprintf("INSERT INTO `db_livefollows` (`channel_id`, `follow_list`) VALUES ('%s', '[]');", $p_chid);
	$r = mysqli_query($conn, $q);
    }

    $q = sprintf("SELECT `db_id` FROM `db_livesubs` WHERE `channel_id`='%s' LIMIT 1;", $p_chid);
    $r = mysqli_query($conn, $q);
    $rn = $r->num_rows;
    if ($rn == 0) {
	$q = sprintf("INSERT INTO `db_livesubs` (`channel_id`, `sub_list`) VALUES ('%s', '[]');", $p_chid);
	$r = mysqli_query($conn, $q);
    }

    $q = sprintf("SELECT `db_id` FROM `db_livesettings` WHERE `channel_id`='%s' LIMIT 1;", $p_chid);
    $r = mysqli_query($conn, $q);
    $rn = $r->num_rows;
    if ($rn == 0) {
	$q = sprintf("INSERT INTO `db_livesettings` (`channel_id`) VALUES ('%s');", $p_chid);
	$r = mysqli_query($conn, $q);
    }

    $q = sprintf("SELECT `db_id` FROM `db_liveignore` WHERE `usr_id`='%s' LIMIT 1;", $p_uid);
    $r = mysqli_query($conn, $q);
    $rn = $r->num_rows;
    if ($rn == 0) {
	$q = sprintf("INSERT INTO `db_liveignore` (`usr_id`, `ignore_list`) VALUES ('%s', '[]');", $p_uid);
	$r = mysqli_query($conn, $q);
    }

    mysqli_close($conn);
}
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

$main_dir = realpath(dirname(__FILE__).'/../../../');
set_include_path($main_dir);

include_once 'f_core/config.core.php';

$host	= array('127.0.0.1');

if ($cfg["live_module"] == 0 or $cfg["live_uploads"] == 0 or !in_array($_SERVER["REMOTE_ADDR"], $host)) { header("HTTP/1.0 404 Not Found"); exit; }
$pcfg	= $class_database->getConfigurations('live_vod');
$type	= 'live';
$app	= $class_filter->clr_str($_GET["app"]);
$name	= $class_filter->clr_str($_GET["name"]);
$pwd  = $class_filter->clr_str(strrev($_GET["q"]));

$name	= str_replace(array('_360p', '_480p', '_720p', '_src', '_hls'), array('', '', '', '', ''), $name);
$apps	= array('cast', 'live', 'play', 'sbr', 'mbr', 'srv1', 'srv1-local-off', 'elive', 'esrv1');

if (!in_array($app, $apps)) { header("HTTP/1.0 404 Not Found"); exit; }

if ($name != '') {
	$q = sprintf("SELECT A.`db_id`, A.`usr_id`, A.`stream_vod`, A.`file_key`, A.`stream_live`, A.`stream_start`, A.`stream_vod`, B.`usr_key` FROM `db_%sfiles` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`stream_key`='%s' AND A.`stream_ended`='0' AND A.`stream_key_active`='1' AND A.`approved`='1' AND A.`deleted`='0' AND A.`active`='1' LIMIT 1;", $type, $name);
	$r = $db->execute($q);

	if ($r->fields["usr_id"]) {
		$db_id = $r->fields["db_id"];
		$usr_id = $r->fields["usr_id"];
		$usr_key =$r->fields["usr_key"];
		$pass = md5($usr_id.$usr_key.$cfg["global_salt_key"]);
		$check = $pass == $pwd ? true : false;
		$p = unserialize($class_database->singleFieldValue('db_accountuser', 'usr_perm', 'usr_id', (int) $usr_id));

		if ($check == 1 and $p["perm_upload_l"] == 1) {
			$ss = strtotime($r->fields["stream_start"]);
			$se = date("Y-m-d H:i:s");

			$db->execute(sprintf("UPDATE `db_accountuser` SET `usr_live`='0' WHERE `usr_id`='%s' LIMIT 1;", $usr_id));
			$db->execute(sprintf("UPDATE `db_livefiles` SET `stream_key_active`='0', `stream_live`='0', `stream_end`='%s', `stream_ended`='1', `file_duration`='%s' WHERE `db_id`='%s' AND `usr_id`='%s' LIMIT 1;", $se, abs((strtotime($se)-$ss)/60*60), $db_id, $usr_id));

			if ($r->fields["stream_vod"] == 0 or $pcfg["live_vod"] == 0) {
				//or delete video
				$db->execute(sprintf("UPDATE `db_livefiles` SET `active`='0' WHERE `file_key`='%s' LIMIT 1;", $r->fields["file_key"]));
			}
		} else {
			error_log("e:check"); header("HTTP/1.0 404 Not Found"); exit;
		}
	} else {
		header("HTTP/1.0 404 Not Found"); exit;
	}
}
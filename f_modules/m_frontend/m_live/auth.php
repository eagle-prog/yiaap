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
include_once 'f_core/f_classes/class.conversion.php';

include_once $class_language->setLanguageFile('frontend', 'language.global');

$host	= array('127.0.0.1');

if ($cfg["live_module"] == 0 or $cfg["live_uploads"] == 0 or !in_array($_SERVER["REMOTE_ADDR"], $host)) { error_log("here0"); header("HTTP/1.0 404 Not Found"); exit; }

$type	= 'live';
$app	= $class_filter->clr_str($_GET["app"]);
$name	= $class_filter->clr_str($_GET["name"]);
$pwd	= $class_filter->clr_str(strrev($_GET["q"]));

$name	= str_replace(array('_360p', '_480p', '_720p', '_src', '_hls'), array('', '', '', '', ''), $name);
$apps	= array('cast', 'live', 'play', 'sbr', 'mbr', 'srv1', 'srv2', 'srv1-local-off', 'srv2-local', 'vods', 'vods1-local', 'vods2-local', 'elive', 'esrv1', 'evods');

if ($app == 'srv1-local' or $app == 'esrv1' or $app == 'evods' or $app == 'vods' or $app == 'vods1-local') { exit; }

if (!in_array($app, $apps)) {error_log("here1"); header("HTTP/1.0 404 Not Found"); exit; }

if ($name != '') {
	$q = sprintf("SELECT A.`db_id`, A.`usr_id`, A.`stream_vod`, A.`file_key`, A.`stream_live`, B.`usr_key` FROM `db_%sfiles` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`stream_key`='%s' AND A.`stream_ended`='0' AND A.`stream_key_active`='1' AND A.`approved`='1' AND A.`deleted`='0' AND A.`active`='1' LIMIT 1;", $type, $name);
	$r = $db->execute($q);

	$usr_id = $r->fields["usr_id"];
	$usr_key = $r->fields["usr_key"];
	$pass = md5($usr_id.$usr_key.$cfg["global_salt_key"]);
	$check = $pass == $pwd ? true : false;

	if ($r->fields["stream_live"] == 1 and ($app == 'live' or $app == 'elive')) {
		error_log("e:stream_live"); header("HTTP/1.0 404 Not Found"); exit;
	} elseif ($usr_id > 0 and !$check) {
		error_log("e:check:".$pwd); header("HTTP/1.0 404 Not Found"); exit;
	} elseif (!$r->fields["db_id"]) {
/*
		$filekey = VUserinfo::generateRandomString(10);
		$embedkey = VUserinfo::generateRandomString(10);
		$db_approved = ($cfg["file_approval"] == 1 ? 0 : 1);

		$q = sprintf("SELECT A.`db_id`, A.`usr_id`, A.`stream_vod`, A.`file_key`, A.`stream_live`, A.`file_title`, A.`file_description`, A.`file_tags`, A.`file_category`, B.`usr_key` FROM `db_%sfiles` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`stream_key_old`='%s' AND A.`stream_ended`='1' AND A.`approved`='1' AND A.`deleted`='0' AND A.`active`='1' ORDER BY A.`db_id` DESC LIMIT 1;", $type, $name);
		$rs = $db->execute($q);

		if (!$rs->fields["db_id"]) {
			$ra = $db->execute(sprintf("SELECT `usr_id`, `usr_key`, `usr_user` FROM `db_accountuser` WHERE `live_key`='%s' LIMIT 1", $name));
			if (!$ra->fields["usr_id"]) {
				error_log("e:live_key"); header("HTTP/1.0 404 Not Found"); exit;
			} else {
				$usr_id = $ra->fields["usr_id"];
				$usr_key = $ra->fields["usr_key"];
				$usr_user = $ra->fields["usr_user"];
				$title = sprintf("%s Live", $usr_user);
				$descr = $title;
				$tags = $title;
				$categ = 132;//default category NEWS & POL
			}
		} else {
			$usr_id = $rs->fields["usr_id"];
			$usr_key = $rs->fields["usr_key"];
			$title = $rs->fields["file_title"];
			$descr = $rs->fields["file_description"];
			$tags = $rs->fields["file_tags"];
			$categ = $rs->fields["file_category"];
		}
		if ((int)$usr_id == 0) {
			error_log("e:no_account"); header("HTTP/1.0 404 Not Found"); exit;
		}

		$_p	= unserialize($class_database->singleFieldValue('db_accountuser', 'usr_perm', 'usr_id', $usr_id));

		$v_info = array(
			"usr_id" => $usr_id,
			"file_key" => $filekey,
			"old_file_key" => 0,
			"file_type" => 'tplb',
			"file_name" => null,
			"file_size" => null,
			"upload_date" => date("Y-m-d H:i:s"),
			"is_subscription" => (int) $cfg["paid_memberships"],
			"file_views" => 0,
			"file_comments" => 0,
			"file_responses" => 0,
			"file_like" => 0,
			"file_dislike" => 0,
			"embed_key" => $embedkey,
			"file_title" => $title,
			"file_description" => $descr,
			"file_tags" => VForm::clearTag($tags),
			"file_category" => $categ,
			"approved" => $db_approved,
			"privacy" => "public",
			"comments" => "all",
			"comment_votes" => 1,
			"rating" => 1,
			"responding" => "all",
			"embedding" => 1,
			"social" => 1,
//			"stream_live" => 1,
			"stream_key" => md5($cfg["global_salt_key"].$usr_id.'0'),
			"stream_key_active" => 1,
			"stream_vod" => $_p["perm_live_vod"],
			"stream_chat" => $_p["perm_live_chat"],
			"file_duration" => 1,
		);


		if ($_p["perm_upload_l"] == '1') {
				$do_db	= $class_database->doInsert('db_livefiles', $v_info);

				if ($db->Affected_Rows() > 0) {
					$for = 'live';
					$ct_update = $db->execute(sprintf("UPDATE `db_accountuser` SET `usr_%s_count`=`usr_%s_count`+1 WHERE `usr_id`='%s' LIMIT 1;", $for[0], $for[0], $usr_id));
					$log =($cfg["activity_logging"] == 1 and $action = new VActivity($usr_id)) ? $action->addTo('log_upload', $for.':'.$filekey) : NULL;

					$tmp_file = str_replace($cfg["main_url"], $cfg["main_dir"], VUseraccount::getProfileImage($usr_id, false));
					if ($tmp_file && is_file($tmp_file)) {
						$src_folder = $cfg["media_files_dir"].'/'.$usr_key.'/t/'.$filekey.'/';
						$conv = new VDocument();
						$conv->log_setup($filekey, false);

						if ($conv->createThumbs_ffmpeg($src_folder, '1', 320, 180, $filekey, $usr_key, $tmp_file)){}
						if ($conv->createThumbs_ffmpeg($src_folder, '0', 640, 360, $filekey, $usr_key, $tmp_file)){}

						if ($cfg["paid_memberships"] == 1) {
							$filesize	= 1024;
							$sql		= sprintf("UPDATE `db_packusers` SET `pk_usedspace`=`pk_usedspace`+%s, `pk_total_%s`=`pk_total_%s`+1 WHERE `usr_id`='%s' LIMIT 1;", $filesize, $for, $for, $usr_id);
							$db_dub		= $db->execute($sql);
						}

						$notify = VUpload::notifySubscribers(0, $for, $filekey, '', $usr_key);//notify admin
					}
				}
		}
*/
	}
}


if ($name != '') {
	$q = sprintf("SELECT A.`db_id`, A.`usr_id`, A.`stream_vod`, A.`file_key`, A.`stream_live`, B.`usr_key` FROM `db_%sfiles` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`stream_key`='%s' AND A.`stream_ended`='0' AND A.`stream_key_active`='1' AND A.`approved`='1' AND A.`deleted`='0' AND A.`active`='1' LIMIT 1;", $type, $name);
	$r = $db->execute($q);

	if ($r->fields["db_id"]) {
		$db_id = $r->fields["db_id"];
		$usr_id = $r->fields["usr_id"];
		$usr_key = $r->fields["usr_key"];
		$svod = $r->fields["stream_vod"];
		$pass = md5($usr_id.$usr_key.$cfg["global_salt_key"]);
		$check = $pass == $pwd ? true : false;

		$p = unserialize($class_database->singleFieldValue('db_accountuser', 'usr_perm', 'usr_id', (int) $usr_id));

		if ($check == 1 and $p["perm_upload_l"] == 1) {
			if (($app == 'evods' or $app == 'vods' or $app == 'vods1-local' or $app == 'vods2-local') and ($svod == 0 or $p["perm_live_vod"] == 0 or $cfg["live_vod"] == 0)){
				error_log("here3"); header("HTTP/1.0 404 Not Found"); exit;
			}
			$db->execute(sprintf("UPDATE `db_accountuser` SET `usr_live`='1' WHERE `usr_id`='%s' LIMIT 1;", $usr_id));
			$db->execute(sprintf("UPDATE `db_%sfiles` SET `stream_live`='1', `stream_start`='%s' WHERE `db_id`='%s' AND `usr_id`='%s' AND `stream_live`='0' LIMIT 1;", $type, date("Y-m-d H:i:s"), $db_id, $usr_id));

			if ($db->Affected_Rows() > 0) {
				VUpload::notifySubscribers($usr_id, $type, $r->fields["file_key"], $r->fields["usr_key"]);
			}
		} else {
			error_log("here4"); header("HTTP/1.0 404 Not Found"); exit;
		}
	} else {
		error_log("here5"); header("HTTP/1.0 404 Not Found"); exit;
	}
}
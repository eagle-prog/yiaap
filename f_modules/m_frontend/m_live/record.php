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

sleep(2);

include_once 'f_core/config.core.php';

$host	= array('127.0.0.1');

if ($cfg["live_module"] == 0 or $cfg["live_uploads"] == 0 or !in_array($_SERVER["REMOTE_ADDR"], $host)) { header("HTTP/1.0 404 Not Found"); exit; }

$type	= 'live';
$app    = $class_filter->clr_str($_GET["app"]);
$name   = $class_filter->clr_str($_GET["name"]);
$url    = $class_filter->clr_str($_GET["tcurl"]);
$_srv   = parse_url($url, PHP_URL_HOST);
$_rs    = $db->execute(sprintf("SELECT `srv_id` FROM `db_%sservers` WHERE `srv_type`='vod' AND `srv_slug`='%s' AND `srv_active`='1' LIMIT 1;", $type, $app));
$srv_id = (int) $_rs->fields["srv_id"];
$fpath  = explode("/", $class_filter->clr_str($_GET["path"]));
$fstill = explode(".", $fpath[3]);
$fname  = $fstill[0];

$name   = str_replace(array('_360p', '_480p', '_720p', '_src', '_hls'), array('', '', '', '', ''), $name);
$apps   = array('cast', 'live', 'play', 'sbr', 'mbr', 'vods', 'vods1-local', 'vods2-local', 'elive', 'evods');

if ($srv_id == 0) { header("HTTP/1.0 404 Not Found"); exit; }
if (!in_array($app, $apps)) { header("HTTP/1.0 404 Not Found"); exit; }

if ($name != '' and $fname != '') {
        $q = sprintf("SELECT A.`db_id`, A.`usr_id`, A.`stream_vod`, A.`file_key`, A.`stream_live`, B.`usr_key` FROM `db_%sfiles` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`stream_key`='%s' AND A.`approved`='1' AND A.`deleted`='0' AND A.`active`='1' LIMIT 1;", $type, $name);
        $r = $db->execute($q);

        if ($r->fields["usr_id"]) {
    		$db_id = $r->fields["db_id"];
                $usr_id = $r->fields["usr_id"];
                $usr_key = $r->fields["usr_key"];
                $svod = $r->fields["stream_vod"];

                $p      = unserialize($class_database->singleFieldValue('db_accountuser', 'usr_perm', 'usr_id', (int) $usr_id));
                $pcfg   = $class_database->getConfigurations('conversion_live_previews');

                if ($p["perm_upload_l"] == 1) {
                        if (($app == 'vods' or $app == 'evods') and ($svod == 0 or $p["perm_live_vod"] == 0 or $cfg["live_vod"] == 0)) {
                                header("HTTP/1.0 404 Not Found"); exit;
                        }
                        
                        $q = sprintf("SELECT `srv_id`, `srv_slug` FROM `db_%sservers` WHERE `srv_type`='vod' AND `srv_active`='1' ORDER BY `srv_freespace` DESC LIMIT 1;", $type);
                        $rs = $db->execute($q);
                        $vs = $rs->fields["srv_id"];

                        $q = sprintf("UPDATE `db_livefiles` SET `vod_server`='%s', `stream_key`='%s', `stream_key_old`='%s', `file_name`='%s', `has_preview`='%s' WHERE `db_id`='%s' AND `usr_id`='%s' LIMIT 1;", $vs, time(), $name, $fname, $pcfg["conversion_live_previews"], $db_id, $usr_id);

                        $db->execute($q);
                } else {
                        header("HTTP/1.0 404 Not Found"); exit;
                }
        } else {
                header("HTTP/1.0 404 Not Found"); exit;
        }
}

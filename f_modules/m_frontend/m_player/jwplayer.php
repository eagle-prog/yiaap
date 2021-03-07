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

$main_dir 	 = realpath(dirname(__FILE__).'/../../../');
set_include_path($main_dir);

include_once 'f_core/config.core.php';

$cfg[]		 = $class_database->getConfigurations('stream_server,stream_lighttpd_secure,stream_method,stream_lighttpd_url,stream_rtmp_location');

$player		 = $_GET["i"] == '' ? 'local' : 'embed';
$_cfg		 = unserialize($class_database->singleFieldValue('db_fileplayers', 'db_config', 'db_name', 'jw_'.$player));

switch($player){
    case "local":
        $usr_key         = $class_filter->clr_str($_GET["a"]);
        $file_key        = $class_filter->clr_str($_GET["b"]);
        $section         = $class_filter->clr_str($_GET["c"]);
        $is_hd           = intval($_GET["d"]);
        $ap       	 = $class_filter->clr_str($_GET["e"]);
        $autostart       = $ap == 'enabled' ? 'true' : 'false';
        $type            = $class_filter->clr_str($_GET["f"]);
        $next_file_key   = $class_filter->clr_str($_GET["g"]);
        $next_pl_key     = $class_filter->clr_str($_GET["h"]);
    break;
    case "embed":
        $str            = $class_filter->clr_str($_GET["i"]);
        $usr_key        = substr($str, 0, 12);
        $file_key       = substr($str, 12, 16);
        $section        = 'view';
        $is_hd          = 0;
        $type           = substr($str, -1);
        $ap             = $_cfg["jw_autostart"];
        $autostart       = $ap == 'enabled' ? 'true' : 'false';
    break;
}

foreach($_cfg as $k => $v){
    if($v == 'enabled'){
        $_cfg[$k] = 'true';
    }
    if($v == 'disabled'){
        $_cfg[$k] = 'false';
    }
}

switch($type){
    case "v":
	switch($cfg["stream_method"]){
	    case "":
	    case "0":
	    case "1":
    		$flv_url     = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.flv';
    		$mp4_url     = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
	    break;
	    case "2":
	        if($cfg["stream_server"] == 'lighttpd'){
        	    if($cfg["stream_lighttpd_secure"] == 1){
            		$_file_url   = VPlayers::vStreaming_url($usr_key, $file_key);
            		$flv_url     = $_file_url[0];
            		$mp4_url     = $_file_url[1];
        	    } else {
            		$flv_url     = $cfg["stream_lighttpd_url"].'/f_data/data_userfiles/user_media/'.$usr_key.'/v/'.$file_key.'.flv';
            		$mp4_url     = $cfg["stream_lighttpd_url"].'/f_data/data_userfiles/user_media/'.$usr_key.'/v/'.$file_key.'.mp4';
        	    }
    		} else {
        	    $flv_url         = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.flv';
        	    $mp4_url         = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
    		}
	    break;
	    case "3":
    		$flv_url             = $cfg["stream_rtmp_location"].'/'.$usr_key.'/v/'.$file_key.'.flv';
    		$mp4_url             = $cfg["stream_rtmp_location"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
	    break;
	}

	if($cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 1){
	    $file	 = VPlayers::vStreaming_url($usr_key, $file_key);
	    $file1	 = $file[0];
	    $file2	 = $file[1];
	} else {
	    $file1	 = $flv_url;
	    $file2	 = $mp4_url;
	}
    break;
    case "i":
	$file1	 = $cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg';
    break;
    case "a":
	$file1	 = $cfg["media_files_url"].'/'.$usr_key.'/a/'.$file_key.'.mp3';
    break;
}
$image		 = $cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg?t='.rand(0, 9999);

echo "<config>";
echo "<file>".$file1."</file>";
echo "<image>".$image."</image>";
echo "<controlbar.idlehide>".$_cfg["jw_controlbar_idle"]."</controlbar.idlehide>";
echo "<controlbar.position>".$_cfg["jw_controlbar_position"]."</controlbar.position>";
echo "<dock>".$_cfg["jw_dock"]."</dock>";
echo "<icons>".($section == 'main' ? 'true' : $_cfg["jw_icons"])."</icons>";
echo "<skin>".$_cfg["jw_skin"]."</skin>";
echo "<autostart>".$autostart."</autostart>";
echo "<bufferlength>".$_cfg["jw_buffer"]."</bufferlength>";
echo "<mute>".$_cfg["jw_mute"]."</mute>";
if($is_hd == 1){
    echo "<plugins>hd-2</plugins>";
    echo "<hd.file>".$file2."</hd.file>";
}
echo "<repeat>".$_cfg["jw_repeat"]."</repeat>";
echo "<smoothing>".$_cfg["jw_smoothing"]."</smoothing>";
echo "<stretching>".$_cfg["jw_stretching"]."</stretching>";
echo "<volume>".$_cfg["jw_volume"]."</volume>";
echo "<logo.file>".$_cfg["jw_logo_file"]."</logo.file>";
echo "<logo.link>".$_cfg["jw_logo_link"]."</logo.link>";
echo "<logo.linktarget>".$_cfg["jw_logo_linktarget"]."</logo.linktarget>";
echo "<logo.hide>".$_cfg["jw_logo_hide"]."</logo.hide>";
echo "<logo.margin>".$_cfg["jw_logo_margin"]."</logo.margin>";
echo "<logo.position>".$_cfg["jw_logo_position"]."</logo.position>";
echo "<logo.timeout>".$_cfg["jw_logo_timeout"]."</logo.timeout>";
echo "<logo.over>".$_cfg["jw_logo_over"]."</logo.over>";
echo "<logo.out>".$_cfg["jw_logo_out"]."</logo.out>";
echo "<backcolor>".$_cfg["jw_colors_backcolor"]."</backcolor>";
echo "<frontcolor>".$_cfg["jw_colors_frontcolor"]."</frontcolor>";
echo "<lightcolor>".$_cfg["jw_colors_lightcolor"]."</lightcolor>";
echo "<screencolor>".$_cfg["jw_colors_screencolor"]."</screencolor>";
echo "</config>";
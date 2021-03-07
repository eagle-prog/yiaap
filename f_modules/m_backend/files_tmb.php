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
define('_ISADMIN', true);

set_time_limit(0);

$main_dir = realpath(dirname(__FILE__).'/../../');
set_include_path($main_dir);

include_once 'f_core/config.core.php';
include_once 'f_core/f_classes/class.conversion.php';
include_once $class_language->setLanguageFile('frontend', 'language.global');

$error_message 	= NULL;
$notice_message = NULL;

if (isset($_SERVER['argv'][1]) and isset($_SERVER['argv'][2])) {
        $pcfg = $class_database->getConfigurations('thumbs_nr,log_video_conversion,thumbs_method,thumbs_width,thumbs_height,server_path_php');
        $cfg["thumbs_method"] = 'rand';

    $video_id           = $class_filter->clr_str($_SERVER['argv'][1]);
    $user_key           = $class_filter->clr_str($_SERVER['argv'][2]);
    $preview_reset           = (int)$_SERVER['argv'][3];

        $user_key        = $class_database->singleFieldValue('db_accountuser', 'usr_key', 'usr_id', $class_database->singleFieldValue('db_videofiles', 'usr_id', 'file_key', $video_id));
        $vid		 = md5($cfg["global_salt_key"].$video_id);
        $file_name_360p	 = $vid.'.360p.mp4';
        $file_name_480p	 = $vid.'.480p.mp4';
        $file_name_720p	 = $vid.'.720p.mp4';
        
        $src_folder      = $cfg["media_files_dir"].'/'.$user_key.'/v/';
        $src_360p	 = $src_folder.$file_name_360p;
        $src_480p	 = $src_folder.$file_name_480p;
        $src_720p	 = $src_folder.$file_name_720p;
        
        $src             = file_exists($src_720p) ? $src_720p : (file_exists($src_480p) ? $src_480p : (file_exists($src_360p) ? $src_360p : false));

        if($src && is_file($src)) {
        	$li          = "---------------------------------------------";
            $ls          = "\n\n".$li."\n";
            $le          = "\n".$li."\n";
            
            $conv = new VVideo();
            //$conv->log_setup($video_id, ($pcfg["log_video_conversion"] == 1 ? TRUE : FALSE));
            $conv->log_setup($video_id, FALSE);

            if ($conv->load($src)){
              if ($preview_reset == 0) {
              	$conv->log($ls.'Extracting large thumbnail (640x480)'.$le);
                $thumbs  = $conv->extract_thumbs(array($src, 'thumb'), $video_id, $user_key);
              	$conv->log($ls.'Extracting smaller thumbnails ('.$pcfg["thumbs_width"].'x'.$pcfg["thumbs_height"].')'.$le);
                $thumbs  = $conv->extract_thumbs($src, $video_id, $user_key);
                $conv->log($ls.'Extracting preview thumbnails ('.$pcfg["thumbs_width"].'x'.$pcfg["thumbs_height"].')'.$le);
                $thumbs	 = $conv->extract_preview_thumbs($src, $video_id, $user_key);
              } elseif ($preview_reset == 2) {
                $conv->log($ls.'Extracting video preview thumbnails ('.$pcfg["thumbs_width"].'x'.$pcfg["thumbs_height"].')'.$le);
                $thumbs	 = $conv->extract_preview_thumbs($src, $video_id, $user_key, 2);
              }
              if (file_exists($cfg["media_files_dir"] . "/" . $user_key . "/v/" . md5($video_id."_preview") . ".mp4")) {
                $db->execute(sprintf("UPDATE `db_videofiles` SET `thumb_preview`='1' WHERE `file_key`='%s' LIMIT 1;", $video_id));
              }
            }
        }
}

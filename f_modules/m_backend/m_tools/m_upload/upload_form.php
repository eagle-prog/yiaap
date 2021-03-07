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
include_once $class_language->setLanguageFile('frontend', 'language.upload');
include_once $class_language->setLanguageFile('frontend', 'language.account');

$upload_type	 	= $_GET["t"] != 'document' ? $class_filter->clr_str($_GET["t"]) : 'doc';
$post_name	 	= 'file';

if (isset($_GET["t"])) {
	if ($upload_type != 'video' and $upload_type != 'audio' and $upload_type != 'image' and $upload_type != 'doc') {
		header("Location: ".VHref::getKey("be_upload").'?t=video');
		exit;
	}
}

$user_key	 	= $class_filter->clr_str($_POST["assign_username"]);
$_SESSION["file_owner"] = $user_key;
$cfg             	= $class_database->getConfigurations('file_approval,conversion_'.$class_filter->clr_str($_GET["t"]).'_que,'.$class_filter->clr_str($_GET["t"]).'_limit');

$upload_file_size       = intval($_POST["UFSIZE"]);
$upload_file_limit      = $cfg[$class_filter->clr_str($_GET["t"])."_limit"]*1024*1024;

$db_id              	= VUpload::dbUpdate($upload_type, 1, '', $user_key);
$do_conversion      	= ($db_id != '' and $cfg["conversion_".$class_filter->clr_str($_GET["t"])."_que"] == 0) ? VUpload::initConversion($db_id, $upload_type, 1) : NULL;

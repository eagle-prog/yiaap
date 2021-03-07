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

$upload_type	 = $_GET["t"] != 'document' ? $class_filter->clr_str($_GET["t"]) : 'doc';
$post_name	 = 'file';
$user_id         = intval($_POST["UFUID"]);
$user_key	 = $class_filter->clr_str($_POST["UFSUID"]);

if (isset($_GET["t"])) {
	if ($upload_type != 'video' and $upload_type != 'audio' and $upload_type != 'image' and $upload_type != 'doc') {
		header("Location: ".VHref::getKey("upload").'?t=video');
		exit;
	}
}

$cfg             = $class_database->getConfigurations('file_approval,conversion_'.$class_filter->clr_str($_GET["t"]).'_que,'.$class_filter->clr_str($_GET["t"]).'_limit');

$upload_file_size       = intval($_POST["UFSIZE"]);
$upload_file_limit      = $cfg[$class_filter->clr_str($_GET["t"])."_limit"]*1024*1024;


switch ($_GET["do"]) {
    case "reload-stats":
	if($cfg["paid_memberships"] == 1){
	    echo $ht             = VUseraccount::subscriptionStats(1);
	    echo $ht             = VUpload::subscriptionCheck($upload_type, 1);
	}
    break;
}

if (($upload_file_size > $upload_file_limit) or ($cfg["paid_memberships"] == 1 and VUpload::subscriptionLimit($upload_type))){
    exit();
}

if (isset($_GET["r"])) {
        $responses      = new VResponses();
}

if (!isset($_GET["do"])) {
    $db_id              	 = VUpload::dbUpdate($upload_type, '', $user_id, $user_key);
    $do_conversion      	 = ($db_id != '' and $cfg["conversion_".$class_filter->clr_str($_GET["t"])."_que"] == 0) ? VUpload::initConversion($db_id, $upload_type) : NULL;
}

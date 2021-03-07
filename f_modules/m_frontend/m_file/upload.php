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
include_once $class_language->setLanguageFile('frontend', 'language.notifications');
include_once $class_language->setLanguageFile('frontend', 'language.account');
include_once $class_language->setLanguageFile('backend', 'language.import');

$error_message          = '';
$notice_message         = NULL;


$upload_type		= $_GET["t"] != 'document' ? $class_filter->clr_str($_GET["t"]) : 'doc';

if (isset($_GET["t"])) {
	if ($upload_type != 'video' and $upload_type != 'audio' and $upload_type != 'image' and $upload_type != 'doc') {
		header("Location: ".VHref::getKey("upload").'?t=video');
		exit;
	}
}

$uid			= (int)$_SESSION["USER_ID"];
$files			= new VFiles;

if ($_POST and $_GET["do"] == 'form-update') {
        foreach ($_POST['ekey'] as $k => $v) {
                $name   = $class_filter->clr_str($_POST['ename']);

                $sql    = sprintf("SELECT `file_key` FROM `db_%sfiles` WHERE `usr_id`='%s' AND `file_name` LIKE '%s' ORDER BY `db_id` DESC LIMIT 1;", $upload_type, $uid, $name.'%');
                $rs     = $db->execute($sql);
                $key    = $rs->fields['file_key'];


                $title = $class_filter->clr_str($_POST['c_entry_title'][$v]);
                $descr = $class_filter->clr_str($_POST['c_entry_description'][$v]);
                $tags  = VForm::clearTag($_POST['c_entry_tags'][$v]);
                $categ = (int) $_POST['c_entry_category'][$v];

                $a      = array('file_title' => $title, 'file_description' => $descr, 'file_tags' => $tags, 'file_category' => $categ);

                foreach ($a as $field => $value) {
                        if ($value != '') {
                                $db->execute(sprintf("UPDATE `db_%sfiles` SET `%s`='%s' WHERE `usr_id`='%s' AND `file_key`='%s' LIMIT 1;", $upload_type, $field, $value, $uid, $key));
                        }
                }
        }

        exit;
}

$type			= VUpload::typeInit();
$logged_in              = VLogin::checkFrontend( VHref::getKey("upload").($type != '' ? '?t='.$type : NULL) );
$cfg                    = $class_database->getConfigurations('live_uploads,video_player,audio_player,multiple_file_uploads,video_file_types,video_limit,image_file_types,image_limit,audio_file_types,audio_limit,document_file_types,document_limit,file_counts,numeric_delimiter,file_responses,upload_category,import_yt,import_dm,import_vi');
$init_cfg		= ($error_message == '' and $type != '') ? VUpload::initCFG() : NULL;
$error_message		= VUpload::verifiedEmailCheck();
$error_message		= $error_message == '' ? VUseraccount::checkPerm('upload', $type[0]) : $error_message;
$check_section		= ($error_message == '' and $_GET["t"] == '') ? VUpload::checkSection($type) : $error_message;

$membership_check       = VLogin::checkSubscription();


switch($_GET["do"]){
    case "reverify":
	$rev		= VUpload::processVerify();
    break;
    default: break;
}

if (isset($_GET["r"])) {
	$responses 	= new VResponses();
}

$smarty->assign('user_key', $_SESSION["USER_KEY"]);
$smarty->assign('perm_err', VUseraccount::checkPerm('upload', $type[0]));
$display_page		= (!isset($_GET["do"]) and !isset($_GET["cid"])) ? $class_smarty->displayPage('frontend', 'tpl_upload', $error_message, $notice_message) : NULL;

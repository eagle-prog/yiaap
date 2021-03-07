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
include_once $class_language->setLanguageFile('frontend', 'language.signin');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');

$error_message 	   	= NULL;
$notice_message    	= NULL;
$cfg			= $class_database->getConfigurations('account_email_verification');
$error_message		= $cfg["account_email_verification"] == 0 ? 'tpl_error_max' : NULL;

if ($error_message == '' and isset($_GET["sid"]) and isset($_GET["uid"])) {
    $error_message      = VRecovery::validCheck('frontend', 'verification');
    $notice_message	= ($error_message == '' and VSignup::verifyAccount()) ? $language["notif.success.verified"] : NULL;
}

$class_smarty->displayPage('frontend', 'tpl_verify', $error_message, $notice_message);

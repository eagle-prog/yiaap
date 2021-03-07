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

include_once 'f_core/config.core.php';

include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');
include_once $class_language->setLanguageFile('backend', 'language.advertising');
include_once $class_language->setLanguageFile('backend', 'language.import');
include_once $class_language->setLanguageFile('frontend', 'language.account');

$error_message 	= NULL;
$notice_message = NULL;
$logged_in      = VLogin::checkBackend( VHref::getKey("be_advertising") );

switch($_GET["do"]){
    case "file_upload":
echo	$ht	= VbeAdvertising::beAdvFileUpload();
    break;
}

$menu_entry     = ($_GET["s"] != '' and $_GET["do"] != 'file_upload') ? VMenuparse::sectionDisplay('backend', $class_filter->clr_str($_GET["s"])) : NULL;
$page    	= ($_GET["s"] == '') ? $class_smarty->displayPage('backend', 'backend_tpl_advertising', $error_message, $notice_message) : NULL;
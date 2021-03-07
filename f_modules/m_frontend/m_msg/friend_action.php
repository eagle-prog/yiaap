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
include_once $class_language->setLanguageFile('frontend', 'language.email.notif');
include_once $class_language->setLanguageFile('frontend', 'language.messages');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');

$error_message		= NULL;
$notice_message		= NULL;

$error_message		= (isset($_GET["sid"]) and isset($_GET["uid"])) ? VContacts::inviteCheck() : NULL;

$display_page		= (isset($_GET["sid"]) and isset($_GET["uid"]) and !isset($_GET["do"])) ? $class_smarty->displayPage('frontend', 'tpl_friend_action', $error_message, $notice_message) : NULL;

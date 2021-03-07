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
include_once $class_language->setLanguageFile('frontend', 'language.account');
include_once $class_language->setLanguageFile('backend', 'language.players');
include_once $class_language->setLanguageFile('backend', 'language.settings.entries');
include_once $class_language->setLanguageFile('backend', 'language.import');

$error_message 	= NULL;
$notice_message = ($_POST) ? VbeSettings::doSettings() : NULL;

$logged_in      = VLogin::checkBackend( VHref::getKey("be_players") );
$cfg            = $class_database->getConfigurations('keep_entries_open');

$menu_entry     = ($_GET["s"] != '') ? VMenuparse::sectionDisplay('backend', $class_filter->clr_str($_GET["s"])) : NULL;
$page    	= ($_GET["s"] == '') ? $class_smarty->displayPage('backend', 'backend_tpl_players', $error_message, $notice_message) : NULL;
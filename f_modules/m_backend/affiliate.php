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
| Copyright (c) 2013-2017 viewshark.com. All rights reserved.
|**************************************************************************************************/

define('_ISVALID', true);
define('_ISADMIN', true);

include_once 'f_core/config.core.php';

include_once $class_language->setLanguageFile('backend', 'language.dashboard');
include_once $class_language->setLanguageFile('backend', 'language.settings.entries');
include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('frontend', 'language.account');
include_once $class_language->setLanguageFile('frontend', 'language.files.menu');


$error_message 	= NULL;
$notice_message = NULL;
$cfg[]		= $class_database->getConfigurations('paypal_test,paypal_test_email,affiliate_module,affiliate_tracking_id,affiliate_view_id,affiliate_maps_api_key,affiliate_token_script,affiliate_payout_figure,affiliate_payout_units,affiliate_payout_currency,affiliate_payout_share');
$cfg["is_be"] 	= 1;
$logged_in      = VLogin::checkBackend( VHref::getKey("be_affiliate") );

$analytics              = false;
if (isset($_GET["a"]) or isset($_GET["g"]) or isset($_GET["o"]) or isset($_GET["rp"])) {
        $analytics      = true;

        VAffiliate::viewAnalytics();
}

if (isset($_GET["do"])) {
        switch ($_GET["do"]) {
                case "autocomplete":
                        $ac = VGenerate::processAutoComplete('account_media_be');
                break;
                case "userautocomplete":
                        $ac = VGenerate::processAutoComplete('account_user');
                break;
        }
}

if (!isset($_GET["do"])) {
	$class_smarty->displayPage('backend', 'backend_tpl_affiliate', $error_message, $notice_message);
}
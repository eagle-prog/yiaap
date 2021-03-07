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

include_once $class_language->setLanguageFile('backend',  'language.members.entries');
include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('frontend', 'language.signup');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');
include_once $class_language->setLanguageFile('frontend', 'language.email.notif');

$notice_message 	= NULL;
$cfg 			= $class_database->getConfigurations('paid_memberships,payment_methods,discount_codes,paypal_payments');

if(isset($_GET["t"]) and intval($_SESSION["USER_ID"]) > 0 and $_GET["t"] == md5($_SESSION["USER_NAME"].$_SESSION["USER_ID"])){
    $_SESSION["renew_id"] = intval($_SESSION["USER_ID"]);
} elseif(isset($_GET["t"]) and intval($_SESSION["USER_ID"]) > 0 and $_GET["t"] != md5($_SESSION["USER_NAME"].$_SESSION["USER_ID"])){
    $_SESSION["renew_id"] = '';
}

$pk_id			= (intval(base64_decode($_GET["p"])) > 0) ? intval(base64_decode($_GET["p"])) : NULL;
$user_id		= (intval(base64_decode($_GET["u"])) > 0 and $_SESSION["renew_id"] == '') ? intval(base64_decode($_GET["u"])) : (($_GET["u"] == '' and $_SESSION["renew_id"] != '') ? intval($_SESSION["renew_id"]) : intval(base64_decode($_GET["u"])));
$user_info		= $user_id > 0 ? VUserinfo::getUserInfo($user_id) : NULL;

$error_message  	= ($user_id > 0 and !VUserinfo::existingUsername($user_info["uname"]) and !VPayment::checkActivePack($pk_id)) ? 'tpl_error_max' : NULL;
$error_message 		= (($_SESSION["renew_id"]) == '' or intval($_SESSION["renew_id"]) < 1) ? 'tpl_error_max' : $error_message;

if ($error_message == '') {
    //free account update
    $notice_message 	= ($cfg["paid_memberships"] == 1 and $_GET["p"] != '' and $_GET["u"] != '' and $_POST["signup_finalize"] == 1) ? VPayment::updateFreeEntry() : $notice_message;
    $pk_free		= $class_database->singleFieldValue('db_accountuser', 'usr_free_sub', 'usr_id', $user_id);
    $memberships	= ($cfg["paid_memberships"] == 1 and $pk_free == 1) ? VPayment::getPackTypes('1') : (($cfg["paid_memberships"] == 1 and $pk_free == 0) ? VPayment::getPackTypes() : NULL);
    $pk_expire		= ($pk_id == '' and $user_id > 0) ? $db->execute(sprintf("SELECT `expire_time` FROM `db_packusers` WHERE `pk_id`='%s' AND `usr_id`='%s' LIMIT 1;", VPayment::getPackID(intval($_SESSION["renew_id"])), $user_id)) : NULL;
    $pk_expire  	= ($pk_id == '' and $user_id > 0) ? $smarty->assign('pk_expire', $pk_expire->fields["expire_time"]) : NULL;
    $q	   		= $db->execute(sprintf("SELECT * FROM db_packtypes WHERE pk_id='%s';", ($pk_id > 0 and $user_id == $_SESSION["renew_id"]) ? $pk_id : VPayment::getPackID(intval($_SESSION["renew_id"]))));
    $pk_info   		= $q->getrows();
    $smarty->assign('pk_info', $pk_info);

    if ($pk_id > 0 and $user_id > 0) {
	$pk_period 	= $class_database->singleFieldValue('db_packtypes', 'pk_period', 'pk_id', $pk_id);
	VPayment::buildSelectOptions($pk_period);
	VPayment::packWords($pk_period);
    }
    if ($_POST["frontend_membership_type"] != '') {//select different membership
	$u 		= base64_encode(intval($_SESSION["renew_id"]));
	$p 		= base64_encode(intval($_POST["frontend_membership_type_sel"]));
	$class_redirect->to('',$cfg["main_url"].'/'.VHref::getKey('renew').'?p='.$p.'&u='.$u);
    }
}

$class_smarty->displayPage('frontend', 'tpl_payment', $error_message, $notice_message);

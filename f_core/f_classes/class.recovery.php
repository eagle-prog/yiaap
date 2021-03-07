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

defined ('_ISVALID') or die ('Unauthorized Access!');

class VRecovery {
    /* validate password recovery */
    function processForm($section) {
	global $language, $class_filter, $class_database;

	$cfg		= $section == 'frontend' ? $class_database->getConfigurations('signup_min_password,signup_max_password') : NULL;
	$allowedFields  = array('recovery_forgot_new_password','recovery_forgot_retype_password');
	$requiredFields = $allowedFields;
	$new_pass	= $_POST["recovery_forgot_new_password"] != '' ? $_POST["recovery_forgot_new_password"] : NULL;
	$confirm_pass	= $_POST["recovery_forgot_retype_password"] != '' ? $_POST["recovery_forgot_retype_password"] : NULL;

        $error_message 	= ($error_message == '') ? VForm::checkEmptyFields($allowedFields, $requiredFields) : $error_message;
        $error_message  = ($section == 'frontend' and (strlen($new_pass) < $cfg["signup_min_password"] or strlen($new_pass) > $cfg["signup_max_password"] or strlen($confirm_pass) < $cfg["signup_min_password"] or strlen($confirm_pass) > $cfg["signup_max_password"]) and $error_message == '') ? $language["notif.error.invalid.pass"] : $error_message;
	$error_message 	= (md5($new_pass) != md5($confirm_pass) and $error_message == '') ? $language["notif.error.pass.nomatch"] : $error_message;

	return $error_message;
    }
    /* reset password */
    function doPasswordReset($section) {
	global $db, $class_filter;

	$hasher		= new VPasswordHash(8, FALSE);
	$enc_pass       = $class_filter->clr_str($hasher->HashPassword($_POST["recovery_forgot_new_password"]));

	switch($section) {
	    case 'frontend':
		$user_id	= intval(self::getRecoveryID($_GET["s"]));
		$q		= $db->execute(sprintf("UPDATE `db_accountuser` SET `usr_password`='%s' WHERE `usr_id`='%s' LIMIT 1;", $enc_pass, $user_id));
	    break;
	    case 'backend':
		$q		= $db->execute(sprintf("UPDATE `db_settings` SET `cfg_data`='%s' WHERE `cfg_name`='%s' LIMIT 1;", $enc_pass, 'backend_password'));
	}
	if ($db->Affected_Rows() > 0) { 
	    $update_recovery	=  self::updateRecoveryUsage();
	    return true; 
	} else return false;
    }
    /* validation of recovery link */
    function validCheck($section, $type='recovery') {
	global $cfg, $class_database, $language;
	$get 		= $_GET["s"] != '' ? $_GET["s"] : ($_GET["sid"] != '' ? $_GET["sid"] : NULL);
	$h   		= $_GET["s"] != '' ? $cfg["recovery_link_lifetime"] : ($_GET["sid"] != '' ? 24 : 1);

	if (self::getRecoveryID($get, $type) == '') { return 'tpl_error_max'; }

	$valid_time 	= strtotime('- '.$h.' hours');
	$match_time 	= strtotime(self::getRecoveryCDate());

	if ($match_time < $valid_time or self::getRecoveryStatus($get) == 0) return 'tpl_error_max'; else return '';
    }
    /* mark recovery as used */
    function updateRecoveryUsage($type='recovery') {
	global $db, $class_filter;

	$get = $_GET["s"] != '' ? $_GET["s"] : ($_GET["sid"] != '' ? $_GET["sid"] : NULL);
	$db->execute(sprintf("UPDATE `db_usercodes` SET `code_used`=`code_used`+1, `%s`='%s' WHERE `type`='%s' AND `%s`='%s' LIMIT 1;", 'use_date', date("Y-m-d H:i:s"), $type, 'pwd_id', $class_filter->clr_str($get)));
    }
    /* recovery status */
    function getRecoveryStatus($reset_id) {
	global $class_database, $class_filter;
	return $class_database->singleFieldValue('db_usercodes', 'code_active', 'pwd_id', $class_filter->clr_str($reset_id));
    }
    /* recovery create date */
    function getRecoveryCDate() {
	global $class_database, $class_filter;
	$get = $_GET["s"] != '' ? $_GET["s"] : ($_GET["sid"] != '' ? $_GET["sid"] : NULL);
	return $class_database->singleFieldValue('db_usercodes', 'create_date', 'pwd_id', $class_filter->clr_str($get));
    }
    /* get user id of recovery */
    function getRecoveryID($reset_id, $type='recovery') {
	global $class_filter, $db;
	$q = $db->execute(sprintf("SELECT `usr_id` FROM `db_usercodes` WHERE `pwd_id`='%s' AND `type`='%s' LIMIT 1;", $class_filter->clr_str($reset_id), $type));
	return $q->fields["usr_id"];
    }
    /* log recovery usage */
    function addRecoveryEntry($user_id, $reset_id, $type='', $addTo='') {
	global $db, $class_database, $cfg;

	$type 	= ($type == 'email_verification') ? 'verification' : (($type == 'invite_user' or $type == 'invite_contact') ? $type : 'recovery');
	$lg	= ($type == 'invite_user' or $type == 'invite_contact') ? 'log_frinvite' : 'log_precovery';

	$q 	= $db->execute(sprintf("UPDATE `db_usercodes` SET `%s`='%s' WHERE `type`='%s' AND `%s`='%s' %s;", 'code_active', '0', $type, 'usr_id', intval($user_id), (($type == 'invite_user' or $type == 'invite_contact') ? " AND `pwd_id`='".$reset_id."'" : NULL)));
	$q	= $db->execute(sprintf("DELETE FROM `db_usercodes` WHERE `type`='%s' AND `pwd_id`='%s' AND `code_active`='0';", $type, $reset_id));
	$i 	= array("type" => $type, "usr_id" => intval($user_id), "pwd_id" => $reset_id, "create_date" => date("Y-m-d H:i:s"));
	$q 	= $class_database->doInsert('db_usercodes', $i);

	$log 	= ($cfg["activity_logging"] == 1 and $action = new VActivity($user_id)) ? $action->addTo($lg, $addTo) : NULL;
    }
}
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

class VLogin {
    /* check subscription when logged in */
    function checkSubscription(){
	global $cfg, $backend_access_url;

	$u_id			= intval($_SESSION["USER_ID"]);
	$_section      		= (strstr($_SERVER['REQUEST_URI'], $backend_access_url) == true) ? 'backend' : 'frontend';
	if($u_id > 0 and $_section == 'frontend' and $cfg["paid_memberships"] == 1){
	    $membership_check		= VPayment::checkSubscription($u_id);
	}
    }
    /* update login activity */
    function updateOnLogin($user_id) {
	global $db, $class_filter, $cfg;
	$do_count = $cfg["frontend_signin_count"] == 1 ? ', usr_logins=usr_logins+1' : NULL;
	$db->execute(sprintf("UPDATE `db_accountuser` SET `usr_lastlogin`='%s', `usr_IP`='%s' ".$do_count." WHERE `usr_id`='%s' LIMIT 1;", date("Y-m-d H:i:s"), $class_filter->clr_str($_SERVER["REMOTE_ADDR"]), intval($user_id)));
    }
    /* log in */
    function loginAttempt($section, $username, $password, $remember = '', $redirect = 0) {
	global $db, $class_database, $cfg, $language, $class_filter, $class_redirect;

	$siteKey		= $cfg['recaptcha_site_key'];
	$secret			= $cfg['recaptcha_secret_key'];
	$class_password 	= new VPasswordHash(8, FALSE);
	switch ($section) {
	    case 'backend':
		$cfg            = $class_database->getConfigurations('backend_username,backend_password');
		$password_hash 	= $cfg["backend_password"];
		$check_username = $cfg["backend_username"];
		$session_reg1	= 'ADMIN_NAME'; 
		$session_val1	= $check_username;
		$session_reg2	= 'ADMIN_PASS'; 
		$session_val2	= $password_hash;
		break;
	    case 'frontend':
		$q		= $db->execute(sprintf("SELECT A.`usr_id`, A.`usr_key`, A.`usr_user`, A.`usr_partner`, A.`affiliate_badge`, A.`usr_affiliate`, A.`usr_password`, A.`usr_dname` FROM `db_accountuser` A WHERE A.`usr_user`='%s' AND A.`usr_status`='1' LIMIT 1;", $username));
		$password_hash  = $q->fields["usr_password"];
		$check_username = $username;
		$session_reg1   = 'USER_ID';
		$session_val1   = $q->fields["usr_id"];
		$session_reg2   = 'USER_NAME';
		$session_val2   = $check_username;
		$session_reg3   = 'USER_KEY';
		$session_val3   = $q->fields["usr_key"];
		$session_reg4	= $session_val3.'_list';
		$session_val4	= 0;
		$session_reg5   = 'USER_DNAME';
		$session_val5   = $q->fields["usr_dname"];
		$session_reg6   = 'USER_AFFILIATE';
		$session_val6   = $q->fields["usr_affiliate"];
		$session_reg7   = 'USER_BADGE';
		$session_val7   = $q->fields["affiliate_badge"];
		$session_reg8   = 'USER_PARTNER';
		$session_val8   = $q->fields["usr_partner"];
	}

	$error_message		= 0;
	if (($section == 'frontend' and $cfg['signin_captcha'] == 1) or ($section == 'backend' and $cfg['signin_captcha_be'] == 1)) {
		$captcha	= $class_filter->clr_str($_POST['g-recaptcha-response']);
		if ($captcha == '') {
			$error_message	= 1;
		} else {
			$recaptcha	= new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\CurlPost());
			$resp		= $recaptcha->verify($captcha, $_SERVER['REMOTE_ADDR']);
			if ($resp->isSuccess()) {
			} else {
				foreach ($resp->getErrorCodes() as $code) {
					$error_message = $code;
				}
			}
		}
	}
	$password_check = $class_password->CheckPassword($password, $password_hash);
	if ($username == $check_username and $password_check == 1 and !$error_message) {
	    $membership_check	     = ($cfg["paid_memberships"] == 1 and $session_val1 > 0 and $section == 'frontend') ? VPayment::checkSubscription(intval($session_val1)) : NULL;
	    $_SESSION[$session_reg1] = $session_val1;
	    $_SESSION[$session_reg2] = $session_val2;
	    if($section == 'frontend'){
		$_SESSION[$session_reg3] = $session_val3;
		$_SESSION[$session_reg4] = $session_val4;
		$_SESSION[$session_reg5] = $session_val5;
		$_SESSION[$session_reg6] = $session_val6;
		$_SESSION[$session_reg8] = $session_val8;
		if ($session_val6 == 1 || $session_val8 == 1) $_SESSION[$session_reg7] = $session_val7;
	    }
	    $login_update	     = $section == 'frontend' ? self::updateOnLogin($session_val1) : NULL;
	    $log_activity	     = ($section == 'frontend' and $cfg["activity_logging"] == 1 and $action = new VActivity($session_val1)) ? $action->addTo('log_signin') : NULL;
	    $login_remember	     = ($remember == 1) ? VLoginRemember::setLogin($section, $check_username, $password_hash) : NULL;
	    
	    if($redirect == 1) {
			$class_redirect->to('', '/contest');
	    	die;
		}
	    return true;
	} else return false;
    }
    /* log out */
    function logoutAttempt($section,$redirect=1) {
	require 'f_core/config.backend.php';
	global $class_database, $class_redirect, $cfg, $language;

	switch ($section) {
	    case 'backend':
		$redirect_to	 = $cfg["main_url"].'/'.$backend_access_url;
		$to_reset 	 = array('ADMIN_NAME','ADMIN_PASS','be_lang','be_flag','file_owner','theme_name_be');
		break;
	    case 'frontend':
		$redirect_to     = $cfg["main_url"].'/'.($redirect == 1 ? VHref::getKey('index') : VHref::getKey('signin'));
		$log_activity	 = ($cfg["activity_logging"] == 1 and $action = new VActivity(intval($_SESSION["USER_ID"]))) ? $action->addTo('log_signout') : NULL;
		$to_reset        = array($_SESSION["USER_KEY"].'_list','USER_ID','USER_KEY','USER_NAME','USER_DNAME','USER_BADGE','USER_AFFILIATE','USER_PARTNER','USER_AFFILIATE_REQUEST','USER_PARTNER_REQUEST','fe_flag','signin_captcha','recover_left','recover_right','renew_id','change_email','channel_msg','file_category','last_activity','fe_lang','viewmode_video','viewmode_image','viewmode_audio','viewmode_document','viewmode_ch','viewmode_pl','viewmode_my_video','viewmode_my_image','viewmode_my_audio','viewmode_my_document','contact','ap','views_min','views_max','subs_min','subs_max','live_chat_server','theme_name','chat_key');
	}
	VLoginRemember::clearLogin($section);

	if ($section == 'frontend') {
		self::clearChatUsername($_SESSION["USER_ID"], $_SESSION["USER_NAME"], $_SESSION["live_chat_server"]);
	}

	foreach ($to_reset as $value) {
	    $_SESSION[$value]    = NULL; unset($_SESSION[$value]);
	}

	if($redirect >= 1){
	    $class_redirect->to('', $redirect_to);
	    die;
	}
    }
    /* clear chat username entry */
    private static function clearChatUsername($uid, $uname, $lcs=false) {
        global $db, $cfg, $href, $class_filter;

        if (!isset($_SESSION["chat_key"]) and !is_array($_SESSION["chat_key"]))
                return;

        require 'f_modules/m_frontend/m_cron/chat-server/cfg.php';

        $cip = date("Y-m-d");//VServer::get_remote_ip();
        $cua = md5($_SERVER["HTTP_USER_AGENT"] . $cip . $cfg["live_chat_salt"]);
        $ck = $_SESSION["chat_key"];
        $conn   = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        foreach ($ck as $chat_key) {
        $sql = sprintf("DELETE FROM `db_livechat` WHERE `usr_id`='%s' AND `chat_id`='%s';", (int) $uid, $chat_key);
        $db->execute($sql);
        if ($db->Affected_Rows() > 0) {
                if(! $conn ) { return; }
                if (mysqli_query($conn, $sql)) {}
        }
        }
        if ($conn)
            mysqli_close($conn);
    }
    /* logged in redirect */
    function isLoggedIn($section='fe') {
	require 'f_core/config.backend.php';
	global $class_redirect, $cfg;

	if($section == 'fe' and $_SESSION["USER_ID"] > 0) {
	    return $logged_in = $_GET["next"] != '' ? $class_redirect->to('', $cfg["main_url"].'/'.(str_replace(array("-", "%"), array("?", "&"), $_GET["next"]))) : $class_redirect->to('', $cfg["main_url"].'/'.VHref::getKey("index"));
	} elseif($section == 'be' and $_SESSION["ADMIN_NAME"] == $cfg["backend_username"]) {
	    return $logged_in = $class_redirect->to('', $cfg["main_url"].'/'.$backend_access_url);
	} 
    }
    /* check if logged in on frontend */
    function checkFrontend($next = '') {
	global $cfg, $class_redirect;

        if (intval($_SESSION["USER_ID"]) < 1 and !VUserinfo::existingUsername($_SESSION["USER_NAME"])) {
    	    $class_redirect->to('', $cfg["main_url"].'/'.VHref::getKey('signin').($next != '' ? '?next='.$next : NULL));
    	    die;
        }
    }
    /* check if logged in on backend */
    function checkBackend($next = '') {
	require 'f_core/config.backend.php';
        global $class_database, $class_redirect, $cfg;

        $cfg[]	 = $class_database->getConfigurations('backend_username,backend_password');

        if (isset($_SESSION["ADMIN_NAME"]) and isset($_SESSION["ADMIN_PASS"])) {
            if ($_SESSION["ADMIN_NAME"] == $cfg["backend_username"] and $_SESSION["ADMIN_PASS"] == $cfg["backend_password"]) {
                return true;
            }
        } else {
        	$class_redirect->to('', $cfg["main_url"].'/'.$backend_access_url.'/'.VHref::getKey('be_signin').($next != '' ? '?next='.$next : NULL));
                return true;
        }
    }
}
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

class VLoginRemember extends VLogin {
    /* check if login remembered */
    function checkLogin($section) {
	global $db, $class_filter, $cfg;
	$membership	     = ($cfg["paid_memberships"] == 1) ? include_once 'class.payment.php' : NULL;

	switch ($section) {
	    case 'backend':  $check_name = 'ADMIN_NAME';
	    case 'frontend': $check_name = 'USER_NAME';
	}

        if (!isset($_SESSION[$check_name]) and isset($_COOKIE[$section."_login"])) {
            $http_user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? sha1($_SERVER["HTTP_USER_AGENT"]) : NULL;
            $remote_addr     = (isset($_SERVER["REMOTE_ADDR"]) and ip2long($_SERVER["REMOTE_ADDR"])) ? ip2long($_SERVER["REMOTE_ADDR"]) : NULL;
            $cookie          = unserialize($_COOKIE[$section."_login"]);

            if (is_array($cookie)) {
                if ($cookie[$section."_check"] == sha1($http_user_agent.$remote_addr)) {
            	    $db_user	  	  = $class_filter->clr_str($cookie[$section."_username"]);
            	    $db_pass	  	  = $class_filter->clr_str($cookie[$section."_password"]);

            	    switch ($section) {
            		case 'backend':
                	    $db_query	  = sprintf("SELECT `cfg_data` FROM `db_settings` WHERE `cfg_data`='%s' OR `cfg_data`='%s' LIMIT 2;", $db_user, $db_pass);
                	    $session_reg1 = 'ADMIN_NAME';
                	    $session_reg2 = 'ADMIN_PASS';
                	    $db_result 	  = $db->execute($db_query);
                	    if ($db->Affected_Rows() > 1) {
                		$db_info 		 = $db_result->getrows();
                    		$_SESSION[$session_reg1] = $db_info[0]["cfg_data"];
                    		$_SESSION[$session_reg2] = $db_info[1]["cfg_data"];
                    		self::setLogin($section, $db_info[0]["cfg_data"], $db_info[1]["cfg_data"]);
                	    } 
                	break;
                	case 'frontend':
                	    $db_query	  = sprintf("SELECT `usr_id`, `usr_user`, `usr_password` FROM `db_accountuser` WHERE `usr_user`='%s' AND `usr_password`='%s' LIMIT 3;", $db_user, $db_pass);
                	    $session_reg1 = 'USER_ID';
                	    $session_reg2 = 'USER_NAME';
                	    $db_result    = $db->execute($db_query);
                	    if ($db_result->recordcount() > 0) {
                		$db_info 		 = $db_result->getrows();
                		$membership     	 = ($cfg["paid_memberships"] == 1) ? VPayment::checkSubscription(intval($db_info[0]["usr_id"])) : NULL;
                		$_SESSION[$session_reg1] = $db_info[0]["usr_id"];
                    		$_SESSION[$session_reg2] = $db_info[0]["usr_user"];
                    		$login_update	     	 = self::updateOnLogin($db_info[0]["usr_id"]);
                    		$log_activity	 	 = ($cfg["activity_logging"] == 1 and $action = new VActivity(intval($db_info[0]["usr_id"]))) ? $action->addTo('log_signin') : NULL;
                    		self::setLogin($section, $db_info[0]["usr_user"], $db_info[0]["usr_password"]);
                	    }
                	break;
            	    }
                }
            }
        }
    }
    /* set remembered login */
    function setLogin($section, $username, $password) {
        $http_user_agent 	= isset($_SERVER["HTTP_USER_AGENT"]) ? sha1($_SERVER["HTTP_USER_AGENT"]) : NULL;
	$remote_addr        	= isset($_SERVER["REMOTE_ADDR"]) && ip2long($_SERVER["REMOTE_ADDR"]) ? ip2long($_SERVER["REMOTE_ADDR"]) : NULL;
        $cookie_array     	= array($section.'_username' => $username, $section.'_password' => $password, $section.'_check' => sha1($http_user_agent.$remote_addr));
        $cookie     		= serialize($cookie_array);
        setcookie($section.'_login', $cookie, time()+60*60*24*100, '/');
    }
    /* clear remembered login */
    function clearLogin($section) {
        setcookie($section.'_login', '', time()-60*60*24*100, '/');
    }
}
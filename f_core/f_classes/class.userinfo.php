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

class VUserinfo {
    /* valid username format */
    function isValidUsername($username) {
	global $cfg;

	$min_length 	= $cfg["signup_min_username"];
	$max_length 	= $cfg["signup_max_username"];
	$char_extra	= $cfg["username_format_dott"] == 1 ? '.' : NULL;
	$char_extra    .= $cfg["username_format_underscore"] == 1 ? '_' : $char_extra;
	$char_extra    .= $cfg["username_format_dash"] == 1 ? '-' : $char_extra;

	switch($cfg["username_format"]) {
	    case 'strict':
		if(!preg_match("/^[a-z0-9".$char_extra."]{".$min_length.",".$max_length."}$/i",trim($username))){
		    return false;
		}
	    break;
	    case 'loose':
		$username = self::clearString($username);
		if(strlen($username) < $min_length or strlen($username) > $max_length) { return false; }
	    break;
	}
	return true;
    }
    /* remove chars from string */
    function clearString($username) {
	global $cfg, $class_filter;
	$clear 		= array("~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "`", "=", "[", "]", "\\", "{", "}", "|", ";", "'", ",", "/", ":", '"', "<", ">", "?", " ", "\n", "\r", "\t");
	$username	= $cfg["username_format_dott"] == 0 ? str_replace(".", "", $username) : $username;
	$username	= $cfg["username_format_dash"] == 0 ? str_replace("-", "", $username) : $username;
	$username	= $cfg["username_format_underscore"] == 0 ? str_replace("_", "", $username) : $username;

	return $class_filter->clr_str(str_replace($clear, "", $username));
    }
    /* check for existing username */
    function existingUsername($username, $section = 'frontend') {
	global $db, $class_database;

	$username     = self::clearString($username);

	switch($section) {
	    case "frontend":
		$db_t = 'db_accountuser';
		$db_p = 'usr';
		$db_q = $db->execute(sprintf("SELECT `%s_id` FROM `%s` WHERE `%s_user`='%s' LIMIT 1;", $db_p, $db_t, $db_p, $username));

		if ($db_q->recordcount() > 0) return true;
		    else return false;
	    break;

	    case "backend":
		$cfg  = $class_database->getConfigurations('backend_username');
		if ($username == $cfg["backend_username"]) { return true; break; }
	    break;
	}
    }
    /* check for existing email */
    function existingEmail($email, $section = 'frontend') {
	global $db, $class_filter;

	$email = $class_filter->clr_str($email);

	switch($section) {
	    case 'frontend':
		$q = $db->execute(sprintf("SELECT `usr_id` FROM `db_accountuser` WHERE `usr_email`='%s' LIMIT 1;", $email));
		if ($q->recordcount() > 0 and $q->fields["usr_id"] > 0) return true;
		else return false;
	    break;
	    case 'backend':
		$q = $db->execute(sprintf("SELECT `cfg_name` FROM `db_settings` WHERE `cfg_data`='%s' LIMIT 1;", $email));
		if ($q->recordcount() > 0) return true;
		else return false;
	    break;
	}
    }
    /* get user id from other fields */
    function getUserID($user, $where_field = 'usr_user') {
	global $db, $class_filter;
	$user 	= $where_field == 'usr_user' ? self::clearString($user) : $class_filter->clr_str($user);
	$q 	= $db->execute(sprintf("SELECT `usr_id` FROM `db_accountuser` WHERE `".$where_field."`='%s' LIMIT 1;", $user));
	return $q->fields["usr_id"];
    }
    /* get user name from other fields */
    function getUserName($user, $where_field = 'usr_id') {
	global $db, $class_filter;
	$q 	= $db->execute(sprintf("SELECT `usr_user` FROM `db_accountuser` WHERE `".$where_field."`='%s' LIMIT 1;", $class_filter->clr_str($user)));
	return $q->fields["usr_user"];
    }
    /* get email from user id */
    function getUserEmail($user='') {
	global $db, $smarty;
	switch($user) { case '': $user=intval($_SESSION["USER_ID"]); break; default: $user=intval($user); }

	$q 	   = $db->execute(sprintf("SELECT `usr_email` FROM `db_accountuser` WHERE `usr_id`='%s' LIMIT 1;", $user));
	$usr_email = $q->fields["usr_email"];
	$smarty->assign('usr_email', $usr_email);
	return $usr_email;
    }
    /* get various user details */
    function getUserInfo($user_id) {
    	global $db;
    	
    	$uid = (int) $user_id;

    	$sql = sprintf("SELECT
            A.`usr_key`, A.`usr_user`, A.`usr_password`, A.`usr_emailextras`, A.`usr_weekupdates`,
            A.`usr_fname`, A.`usr_lname`, A.`usr_dname`,
            A.`ch_title`
            FROM
            `db_accountuser` A
            WHERE
            A.`usr_id`='%s' LIMIT 9;", $uid);

    	$u = $db->execute($sql);

    	$info["key"] 		= $u->fields["usr_key"];
    	$info["uname"] 		= $u->fields["usr_user"];
    	$info["pass"]  		= $u->fields["usr_password"];
    	$info["fname"] 		= $u->fields["usr_fname"];
    	$info["lname"] 		= $u->fields["usr_lname"];
    	$info["dname"] 		= $u->fields["usr_dname"];
    	$info["ch_title"] 	= $u->fields["ch_title"];
    	$info["mail_updates"] 	= $u->fields["usr_emailextras"];
    	$info["week_updates"] 	= $u->fields["usr_weekupdates"];

    	return $info;
    }
    /* username validation */
    function usernameVerification($username, $section = 'frontend') {
	global $cfg, $language;

	$file 	 = str_replace("\n",',', file_get_contents($cfg["list_reserved_users"]));
	$file 	 = (substr($file, -1, 1) == ',') ? substr($file, 0, -1) : $file;
	$u_array = array_map('trim', explode(',', $file));

	if (self::isValidUsername($username)) {
	    if (in_array($username, $u_array)) { return false; }
	    elseif (!self::existingUsername($username, $section)) { return true; }
	    else { return false; }
	} else { return false; }
    }
    /* birthday input validation */
    function birthdayVerification($date) {
	global $cfg;

	$c_age = self::ageFromString($date);
	if ($c_age < $cfg["signup_min_age"] or $c_age > $cfg["signup_max_age"])
	    return false;
	else return true;
    }
    /* age from date */
    function ageFromString($date) {
	if (!preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $date, $arr))
	    return false;

	$age = date("Y") - $arr[1];
	if ($arr[2] > date("m")) { $age--; }
	elseif ($arr[2] == date("m")) {
	    if ($arr[3] > date("d"))
		$age--;
	}
	return $age;
    }
    /* generate random strings */
    function generateRandomString($length = 10, $alphanumeric = false) {
	if (!$alphanumeric) {
		//$rd = $length == 10 ? 3 : 9;
		$str = join('', array_map(function($value) { return $value == 1 ? mt_rand(1, 3) : mt_rand(0, 9); }, range(1, $length)));
	} else {
		$length = 32;
		$str = '';
		
		for($i=0;$i<$length;$i++) {
		    $str .= chr((mt_rand(1, 36) <= 26) ? (($i%2) ? mt_rand(65, 90) : mt_rand(97, 122)) : mt_rand(48, 57));
		}
	}
	return $str;
    }
    /* check for available username */
    function usernameAvailability($username, $section = 'frontend') {
	global $cfg, $language;
	
	$file 		= str_replace("\n",',', file_get_contents($cfg["list_reserved_users"]));
	$file 		= (substr($file, -1, 1) == ',') ? substr($file, 0, -1) : $file;
	$u_array 	= explode(',', $file);
	$username	= $cfg["username_format"] == 'loose' ? self::clearString(trim($username)) : trim($username);
	
	if (self::usernameVerification($username)) {
	    if (in_array($username, $u_array)) { 
		echo '<font color="red">'.$language["frontend.signup.ucheck.taken"].'</font>'; die;
	    } elseif (!self::existingUsername($username, $section)) {
		echo '<font color="green">'.$language["frontend.signup.ucheck.available"].'</font>'; die;
	    } else {
		echo '<font color="red">'.$language["frontend.signup.ucheck.taken"].'</font>'; die;
	    }
	} else { 
	    echo '<font color="red">'.$language["frontend.signup.ucheck.failed"].'</font>'; die;
	}
    }
    /* truncating strings */
    function truncateString($string, $max_length) {
	return mb_strimwidth($string, 0, $max_length, '...', 'utf-8');

        if (mb_strlen($string, 'UTF-8') > $max_length){
            $string 	= mb_substr($string, 0, $max_length, 'UTF-8');
            $pos 	= mb_strrpos($string, ' ', false, 'UTF-8');
            if($pos === false) {
                return mb_substr($string, 0, $max_length, 'UTF-8').'...';
            }
            return mb_substr($string, 0, $pos, 'UTF-8').'...';
        } else {
            return $string;
        }
    }

    /* days from date */
    function timeRange($datetime) {
	global $language;

	$time	  = self::convert_datetime($datetime);
        $now	  = time();
        $interval = $now - $time;

        if($interval > 0) {
    	    $day = $interval/(60*60*24);
    	    if($day >= 1) {
    		$dd	  = floor($day);
    		$range	  = $dd.' '.($dd != 1 ? $language["frontend.global.days"] : $language["frontend.global.day"]).' '.$language["frontend.global.ago"];
    		$interval = $interval-(60*60*24*$dd);
    	    }
    	    if($interval > 0 and $range == '') {
    		$hour	= $interval/(60*60);
    		if($hour >= 1) {
    		    $hh		= floor($hour);
    		    $range	= $hh.' '.($hh != 1 ? $language["frontend.global.hours"] : $language["frontend.global.hour"]).' '.$language["frontend.global.ago"];
    		    $interval	= $interval-(60*60*$hh);
    		}
    	    }
    	    if($interval > 0 and $range == '') {
    		$min	= $interval/(60);
    		if($min >= 1) {
    		    $mm		= floor($min);
    		    $range	= $mm.' '.($mm != 1 ? $language["frontend.global.minutes"] : $language["frontend.global.minute"]).' '.$language["frontend.global.ago"];
    		    $interval	= $interval-(60*$mm);
    		}
    	    }
    	    if($interval > 0 and $range == '') {
    		$scn	= $interval;
    		$range	= $scn >= 1 ? $scn.' '.$language["frontend.global.seconds"].' '.$language["frontend.global.ago"] : $language["frontend.global.seconds.ago"];
    	    }

    	    return $range;
	}
    }
    /* unix timestamp */
    function convert_datetime($str) {
	if($str == '') return false;

	list($date, $time) = explode(' ', $str);
	list($year, $month, $day) = explode('-', $date);
	list($hour, $minute, $second) = explode(':', $time);

	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

	return $timestamp;
    } 
}
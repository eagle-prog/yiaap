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

class VActivity {
    function __construct($user_id) {
	global $class_filter;

	$this->db_track 	= 'db_trackactivity';
	$this->db_table 	= 'db_useractivity';
	$this->where_f  	= 'usr_id';
	$this->where_v  	= $user_id;
	$this->act		= '';
	$this->act_time 	= date("Y-m-d H:i:s");
	$this->act_ip   	= $class_filter->clr_str($_SERVER["REMOTE_ADDR"]);
	
//	return true;
    }
    /* add activity to db */
    function addTo($act_type, $extra='') {
	global $db, $class_filter, $class_database, $language;

	$cfg                    = $class_database->getConfigurations('log_signin,log_signout,log_precovery,log_urecovery,log_pmessage,log_frinvite,log_subscribing,log_following,log_filecomment,log_upload,log_fav,log_delete,log_rating');

	$cfg['log_channelcomment'] = 1;

	if($cfg[$act_type] == 0) { return false; }

	switch($act_type){
	    case "log_signin":
		$this->act      = 'sign in';
		break;
	    case "log_signout":
		$this->act      = 'sign out';
		break;
	    case "log_precovery":
		$this->act      = 'password recovery';
		break;
	    case "log_urecovery":
		$this->act      = 'username recovery';
		break;
	    case "log_pmessage":
		$this->act      = 'private message to '.$extra;
		break;
	    case "log_frinvite":
		$this->act      = 'friend invite to '.$extra;
		break;
	    case "log_subscribing":
		$this->act      = 'subscribes to '.$extra;
		break;
	    case "log_following":
		$this->act      = 'follows '.$extra;
		break;
	    case "log_filecomment":
		$this->act      = 'comments on '.$extra;
		break;
	    case "log_channelcomment":
		$this->act      = 'comments on '.$extra;
		break;
	    case "log_rating":
		$this->act      = $extra;
		break;
	    case "log_upload":
		$this->act      = 'upload:'.$extra;
		break;
	    case "log_fav":
		$this->act      = 'favorite:'.$extra;
		break;
	    case "log_delete":
		$this->act      = 'delete:'.$extra;
		break;
	}

	$insert_array		= array(
	    "usr_id"		=> intval($this->where_v),
	    "act_type"		=> $this->act,
	    "act_time"		=> $this->act_time,
	    "act_ip"		=> $this->act_ip
	);
	
	$act_chk		= $act_type == 'log_channelcomment' ? 'log_filecomment' : $act_type;

	$do_logging	 	= ($class_database->singleFieldValue($this->db_track, $act_chk, $this->where_f, $this->where_v) == 1) ? 1 : 0;

	if($do_logging == 1){
	    $act_q		= $db->execute(sprintf("SELECT `act_id` FROM `%s` WHERE `act_type`='%s' AND `usr_id`='%s' LIMIT 1;", $this->db_table, $this->act, intval($this->where_v)));
	    $act_check		= $act_q->fields["act_id"];
	    $db_update	 	= $act_check > 0 ? $db->execute(sprintf("UPDATE `db_useractivity` SET `act_time`='%s', `act_ip`='%s' WHERE `act_id`='%s' LIMIT 1;", date("Y-m-d H:i:s"), $this->act_ip, $act_check)) : $class_database->doInsert($this->db_table, $insert_array);
	}
    }
}
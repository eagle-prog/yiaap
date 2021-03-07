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

$main_dir 	 = realpath(dirname(__FILE__).'/../../../');

set_time_limit(0);
set_include_path($main_dir);

include_once 'f_core/config.core.php';

include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('frontend', 'language.email.notif');

$period		 = $_SERVER["argv"][1];
$db_period	 = $period == 'daily' ? 1 : ($period == 'weekly' ? 2 : 0);

if($db_period > 0){
    $sql	 = sprintf("SELECT `usr_id`, `usr_user`, `usr_email` FROM `db_accountuser` WHERE `usr_weekupdates`='%s' AND `usr_status`='1';", $db_period);
    $res	 = $db->execute($sql);

    if($res->fields["usr_id"]){
	$_i	 = array();

	while(!$res->EOF){
	    $n	 = 0;
	    $sql = sprintf("SELECT `usr_id` FROM `db_subscribers` WHERE `subscriber_id` LIKE '%s';", '%"sub_id";s:'.strlen($res->fields["usr_id"]).':"'.$res->fields["usr_id"].'";%');
	    $r	 = $db->execute($sql);

	    if($r->fields["usr_id"]){
		while(!$r->EOF){
		    $_user1 	 = $res->fields["usr_id"];
		    $_user2 	 = $r->fields["usr_id"];

		    $_i[$_user1][$n] = $_user2;

		    $r->MoveNext(); $n++;
		}
	    }

	    $res->MoveNext();
	}
	if(count($_i) > 0){
	    foreach($_i as $u => $v){
		$_mail	 = VUserinfo::getUserEmail($u);

		VNotify::queInit('email_digest', array($_mail), array(VUserinfo::getUserName($u), $v, $db_period));
	    }
	}
    }
}

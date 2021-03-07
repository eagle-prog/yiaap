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

class VUserpage {
	public static function getSubCount($uid = '') {
		global $class_database, $upage_id;

		$db_t = 0;
		$db_c = $class_database->singleFieldValue('db_subscribers', 'subscriber_id', 'usr_id', intval($uid == '' ? $upage_id : $uid));
		$db_t = $db_c != '' ? count(unserialize($db_c)) : 0;

		return $db_t;
	}
	public static function getFollowCount($uid = '') {
		global $class_database, $upage_id;

		$db_t = 0;
		$db_c = $class_database->singleFieldValue('db_followers', 'follower_id', 'usr_id', intval($uid == '' ? $upage_id : $uid));
		$db_t = $db_c != '' ? count(unserialize($db_c)) : 0;

		return $db_t;
	}
}
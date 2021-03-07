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

/* languages array */
function langTypes() {
	global $db;

	$_cache	 = false;
	$_time	 = 3600 * 6; //6 hours

	$sql	 = sprintf("SELECT `lang_id`, `lang_name`, `lang_flag`, `lang_default` FROM `db_languages` WHERE `lang_active`='1';");
	$r	 = $_cache ? $db->CacheExecute($_time, $sql) : $db->execute($sql);

	$_lang	 = array();

	if ($r->fields["lang_id"]) {
		while (!$r->EOF) {
			$_lang[$r->fields["lang_id"]] = array("lang_name" => $r->fields["lang_name"], "lang_flag" => $r->fields["lang_flag"], "lang_default" => $r->fields["lang_default"]);

			$r->MoveNext();
		}
	}

	return $_lang;
}

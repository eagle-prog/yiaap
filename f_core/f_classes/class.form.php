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

class VForm {
    /* check for empty fields */
    function checkEmptyFields($allowedFields, $requiredFields, $replace='') {
	global $language, $smarty, $cfg;

	if(is_array($replace)){
	    if($cfg["paid_memberships"] == 0){
		unset($replace["frontend_membership_type"]);
	    }
	    foreach($replace as $rv){
		$pv	 = $_POST[$rv];
		$lang	 = $language[str_replace('_', '.', $rv)];

		if(str_replace($lang, '', $pv) == '' or str_replace($lang.': ', '', $pv) == ''){
		    $_POST[$rv] = '';
		}
	    }
	}

	if (is_array($allowedFields)) {
		foreach($_POST as $key => $value) {
			if(in_array($key, $allowedFields)) {
				if(in_array($key, $requiredFields) and ($value == '' or $value == '---')) {
					$error_message = '<span class="bold">'.$language["notif.error.required.field"].'</span>&nbsp;<span class="bold underlined">'.$language[str_replace('_', '.', $key)].' </span>';
		    			break;
				}
	    		}
		}
	}
	return $error_message;
    }
    /* clear tags */
    function clearTag($tag, $url=''){
	$rep	= $url == '' ? " " : "-";
	$clear	= array("~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "`", "=", "[", "]", "\\", "{", "}", "|", ";", "'", ".", ",", "/", ":", '"', "<", ">", "?", "_", "-", "\n", "\r", "\t");
	if($url == 1){
	    $tag = html_entity_decode($tag, ENT_QUOTES, 'UTF-8');
	    $clear[] = " ";
	}
	return  preg_replace('/\s\s+/', ' ', trim(str_replace($clear, $rep, $tag)));
    }
}
?>
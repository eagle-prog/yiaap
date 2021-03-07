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

class VLanguage {
    var $language_file;
    /* include language file */
    function setLanguageFile($section, $short_filename) {
	global $cfg;

	$_l	 = $section == 'frontend' ? 'fe_lang' : 'be_lang';

	return $this->language_file = 'f_data/data_languages/'.$_SESSION[$_l].'/lang_'.$section.'/'.$short_filename.'.php';
    }
    /* get a language entry */
    function getLanguageEntry($array_key) {
	global $language;
	return $language[$array_key];
    }
}
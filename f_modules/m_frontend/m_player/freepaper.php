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

include_once 'f_core/config.core.php';
include_once $class_language->setLanguageFile('frontend', 'language.freepaper');

$ct	 	 = $class_filter->clr_str($_GET["t"]);
$ch_id		 = intval(substr($ct, 12));
$ct		 = substr($ct, 0, 12);

$th_id		 = ($ch_id > 0) ? $class_database->singleFieldValue('db_accountinfo', 'usr_theme', 'usr_id', $ch_id) : 0;
$bg_col		 = ($ch_id > 0 and $th_id > 0) ? $class_database->singleFieldValue('db_userthemes', 'th_head_div_col', 'th_id', $th_id) : '4C6D8E';


switch($ct){
    case "theme":
    case "channeltheme":
	$img	 = $cfg["global_images_url"].'/freepaper';

	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<freepaper backgroundPattern="'.$img.'/fond.png" backgroundColor="0x'.$bg_col.'" borderColor="0x000000" borderWidth="0" initialDisplay="F" initialLayout="verticallist">';
	echo '<commandBar leftImg="'.$img.'/left.png" rightImg="'.$img.'/right.png" currentImg="'.$img.'/current.png" aboutImg="'.$img.'/apropos_up.png" horizAxis="20"/>';
	echo '<buttons>';
	echo '<fitToPage upImg="'.$img.'/fit_up.png" downImg="'.$img.'/fit_down.png" overImg="'.$img.'/fit_over.png"/>';
	echo '<nextPage upImg="'.$img.'/next_up.png" downImg="'.$img.'/next_down.png" overImg="'.$img.'/next_over.png"/>';
	echo '<prevPage upImg="'.$img.'/prev_up.png" downImg="'.$img.'/prev_down.png" overImg="'.$img.'/prev_over.png"/>';
	echo '<zoomPlus upImg="'.$img.'/zoomplus_up.png" downImg="'.$img.'/zoomplus_down.png" overImg="'.$img.'/zoomplus_over.png"/>';
	echo '<zoomMinus upImg="'.$img.'/zoomminus_up.png" downImg="'.$img.'/zoomminus_down.png" overImg="'.$img.'/zoomminus_over.png"/>';
	echo '<monoPageLayout upImg="'.$img.'/monopage_up.png" downImg="'.$img.'/monopage_down.png" overImg="'.$img.'/monopage_over.png"/>';
	echo '<verticalListLayout upImg="'.$img.'/verticalList_up.png" downImg="'.$img.'/verticalList_down.png" overImg="'.$img.'/verticalList_over.png"/>';
	echo '<stackLayout upImg="'.$img.'/stack_up.png" downImg="'.$img.'/stack_down.png" overImg="'.$img.'/stack_over.png"/>';
	echo '<bookLayout upImg="'.$img.'/book_up.png" downImg="'.$img.'/book_down.png" overImg="'.$img.'/book_over.png"/>';
	echo '</buttons>';
	echo '</freepaper>';
    break;
    case "lang":
	$xml	 = array("id_avm1file","id_booklayout","id_close","id_currentPage","id_currentZoom","id_dimensions","id_docInfo","id_filenotfound","id_firstPage","id_fitToPage","id_lastPage","id_monoPageLayout","id_name","id_nextPage","id_on","id_page","id_pixels","id_prevPage","id_stackLayout","id_to","id_toFullScreen","id_toStandardSize","id_totalPages","id_verticalListLayout","id_zoomMinus","id_zoomPlus");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<ressourceStrings>';

	foreach($xml as $k => $v){
	    echo sprintf("<%s>%s</%s>", $v, $language["freepaper.".$v], $v);
	}
	echo '</ressourceStrings>';
    break;
}
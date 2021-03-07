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
| Copyright (c) 2013-2017 viewshark.com. All rights reserved.
|**************************************************************************************************/

define('_ISVALID', true);

set_time_limit(0);

$main_dir = realpath(dirname(__FILE__).'/../../../');
set_include_path($main_dir);

include_once 'f_core/config.core.php';

if ($cfg["video_module"] == 1){
	if (VAffiliate::payoutReports_custom('video'))
		VAffiliate::payoutReports('video');
}

if ($cfg["live_module"] == 1){
	if (VAffiliate::payoutReports_custom('live'))
		VAffiliate::payoutReports('live');
}

if ($cfg["image_module"] == 1){
	if (VAffiliate::payoutReports_custom('image'))
		VAffiliate::payoutReports('image');
}
if ($cfg["audio_module"] == 1){
	if (VAffiliate::payoutReports_custom('audio'))
		VAffiliate::payoutReports('audio');
}
if ($cfg["document_module"] == 1){
	if (VAffiliate::payoutReports_custom('doc'))
		VAffiliate::payoutReports('doc');
}
if ($cfg["blog_module"] == 1){
	if (VAffiliate::payoutReports_custom('blog'))
		VAffiliate::payoutReports('blog');
}

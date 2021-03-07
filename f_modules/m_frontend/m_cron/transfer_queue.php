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

set_time_limit(0);

$main_dir = realpath(dirname(__FILE__).'/../../../');
set_include_path($main_dir);

include_once 'f_core/config.core.php';
include_once 'f_core/f_classes/class.be.servers.php';

$queue	= new fileQueue();

if($cfg["video_module"] == 1 and $queue->load("video")){
    if($queue->check()){
	$queue->startTransfer();
	echo "\n";
    }
}

if($cfg["image_module"] == 1 and $queue->load("image")){
    if($queue->check()){
	$queue->startTransfer();
	echo "\n";
    }
}

if($cfg["audio_module"] == 1 and $queue->load("audio")){
    if($queue->check()){
	$queue->startTransfer();
	echo "\n";
    }
}

if($cfg["document_module"] == 1 and $queue->load("doc")){
    if($queue->check()){
	$queue->startTransfer();
	echo "\n";
    }
}

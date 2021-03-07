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

/* do not change */
$channel_url					= $cfg["main_url"].'/'.VHref::getKey("user").'/';
$customize_url					= $cfg["main_url"].'/'.VHref::getKey("account");
$upload_url					= $cfg["main_url"].'/'.VHref::getKey("upload");
/* change below */
$language["welcome.account.info"]		= 'Account Information';
$language["welcome.account.youruser"]		= 'Your username: ';
$language["welcome.account.yourpack"]		= 'Your membership: ';
$language["welcome.account.youremail"]		= 'Your email: ';

$language["welcome.account.getstarted"]		= 'Get started using ';
$language["welcome.account.customize"]		= '<a href="'.$channel_url.'">Customize</a> your channel page';
$language["welcome.account.upload"]		= '<a href="'.$upload_url.'">Upload</a> and share your media';
$language["welcome.account.prefs"]		= 'Set your <a href="'.$customize_url.'">account preferences</a>';

$language["notif.notice.signup.success"]	= 'Congratulations! You are now registered with ';


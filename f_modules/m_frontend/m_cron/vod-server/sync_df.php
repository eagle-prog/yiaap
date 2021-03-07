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
define('_SERVER_SLUG', 'vods1-local');

require 'cfg.php';

$url    = $base . '/syncdf?s=';

$df     = disk_free_space("/");
//$free   = round($df/1024/1024/1024);
$free   = $df;

$date   = date("Y-m-d");
$tk     = md5($date.$ssk);
$url    = sprintf("%s%s&a=%s&_=%s", $url, $tk, _SERVER_SLUG, $free);

$curl   = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
$data   = curl_exec($curl);
curl_close($curl);

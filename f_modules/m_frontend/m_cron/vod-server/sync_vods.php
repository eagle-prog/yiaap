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

require 'cfg.php';

$url	= $base . '/syncvods?s=';

$date	= date("Y-m-d");
$tk	= md5($date.$ssk);
$url	.= $tk;

$curl	= curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
$data	= curl_exec($curl);
curl_close($curl);

$list	= json_decode($data);

if ($list[0]) {
	foreach ($list as $filename) {
		$vod	 = $path . '/' . $filename . '.mp4';
		if (file_exists($vod))
			unlink($vod);

		$ff	= explode("-", $filename);
		$_ff	= str_replace('out', 'p', $ff[1]);

		$pv	= $path . '/' . $ff[0] . $_ff . '.mp4';
		if (file_exists($pv))
			unlink($pv);

	}
}

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

require 'cfg.php';

$cmd	= 'ls ' . $path . '/*out.mp4';

exec($cmd, $out);

if ($out[0]) {
	foreach ($out as $file) {
		if (file_exists($file)) {
			$a = explode("-", $file);
			$l = str_replace('out.mp4', 'p.mp4', $a[1]);
			$preview = $a[0] . $l;

			if (!file_exists($preview)) {
				$cmd = 'ffmpeg -y -t 30 -i '.$file.' -codec copy -movflags +faststart '.$preview;

				exec(escapeshellcmd($cmd). ' >/dev/null &');
			}
		}
	}
}

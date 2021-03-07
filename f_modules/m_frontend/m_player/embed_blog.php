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

$type		= 'blog';
$file_key	= $class_filter->clr_str($_GET[$type[0]]);
$cfg[]          = $class_database->getConfigurations('image_player,affiliate_tracking_id');
$u	 	= $db->execute(sprintf("SELECT 
					A.`usr_key`, 
					B.`usr_id`, 
					B.`file_title` 
					FROM 
					`db_accountuser` A, `db_%sfiles` B
					WHERE 
					A.`usr_id`=B.`usr_id` AND 
					B.`file_key`='%s' 
					LIMIT 1;", $type, $file_key));
$usr_key 	= $u->fields["usr_key"];
$title		= $u->fields["file_title"];
$tmb		= $cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg';

$href_key	= 'blogs';
$blog_tpl       = $cfg["media_files_dir"] . '/' . $usr_key . '/b/' . $file_key . '.tplb';
$blog_html	= null;
				
				if (file_exists($blog_tpl)) {
					$blog_html	= file_get_contents($blog_tpl);
					$parse		= preg_match_all("/\[([^]].*?)\]/", $blog_html, $matches);
					$media		= $matches[1];

					if ($media[0]) {
						foreach ($media as $media_entry) {
							$a = explode("_", $media_entry);
							
							$mtype 	= $a[1];
							$mkey	= $a[2];
							
							/* embed code player sizes */
							$ps = array();
							$ps[0]["w"] = '100%';
							$ps[0]["h"] = 500;

							switch ($mtype[0]) {
								case "l":
								case "v"://embed code for video and audio is generated from within player cfg after initialization (class.players.php)
									$vi		= sprintf("SELECT A.`file_type`, A.`embed_src`, A.`embed_key`, B.`usr_key` FROM `db_videofiles` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`file_key`='%s' LIMIT 1;", $mkey);
									$mrs		= $db->execute($vi);
									$msrc		= $mrs->fields["file_type"];
									$membed_src	= $mrs->fields["embed_src"];
									$membed_key	= $mrs->fields["embed_key"];
									$mukey		= $mrs->fields["usr_key"];
									
									if ($msrc == 'embed') {
										$mec = VPlayers::playerEmbedCodes($membed_src, array("key" => $membed_key, "ec" => VPlayers::mc_swfurl($membed_key)), $ps[0]["w"], $ps[0]["h"]);
									} else {
										$mec = '<iframe id="file-embed-' . md5($mkey) . '" type="text/html" width="' . $ps[0]["w"] . '" height="' . $ps[0]["h"] . '" src="' . $cfg["main_url"] . '/embed?v=' . $mkey . '" frameborder="0" allowfullscreen></iframe>';
									}
									break;
								case "a"://embed code for video and audio is generated from within player cfg after initialization (class.players.php)
									$mec = '<iframe id="file-embed-' . md5($mkey) . '" type="text/html" width="' . $ps[0]["w"] . '" height="' . $ps[0]["h"] . '" src="' . $cfg["main_url"] . '/embed?a=' . $mkey . '" frameborder="0" allowfullscreen></iframe>';
									break;
								case "d"://embed code for documents is generated from within player cfg after page load (class.players.php)
									$mdoc	= VGenerate::thumbSigned(array("type" => "doc", "server" => "upload", "key" => '/'.$mukey.'/d/'.$mkey.'.pdf'), $mkey, $mukey, 0, 1);
									$mec	= '<embed src="'.$mdoc.'" width="' . $ps[0]["w"] . '" height="' . $ps[0]["h"] . '">';
									break;
								case "i":
									switch ($cfg["image_player"]) {
										case "jq":
											$_js = NULL;
											//$thumb_link = VGenerate::thumbSigned($mtype, $mkey, $mukey, 0, 1, 1);
											$image_link = VGenerate::thumbSigned($mtype, $mkey, $mukey, 0, 1, 0);

											//$mec = '[url=' . $image_link . '][img=320x240]' . $thumb_link . '[/img][/url]';
											$mec = '<img src="'.$image_link.'">';
											break;
									}
									break;
							}
							
							$blog_html = str_replace("[".$media_entry."]", $mec, $blog_html);
						}
					}
				}


?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body style="">
    <div id="view-player-<?php echo $file_key; ?>"><?php echo $blog_html; ?></div>
</body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', '<?php echo $cfg["affiliate_tracking_id"]; ?>', 'auto');ga('set', 'dimension1', '<?php echo $usr_key; ?>');ga('set', 'dimension2', '<?php echo $type; ?>');ga('set', 'dimension3', '<?php echo $file_key; ?>');ga('send', {hitType: 'pageview', page: location.pathname, title: '<?php echo $title; ?>'});
</script>
</html>
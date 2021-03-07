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

$file_key	= $class_filter->clr_str($_GET["v"]);
$type		= 'video';
$u	 	= $db->execute(sprintf("SELECT 
					A.`usr_key`, 
					B.`usr_id`, 
					B.`file_title`, B.`file_tags`, SUBSTRING(B.`file_description`, 1, 200) AS `file_description`
					FROM 
					`db_accountuser` A, `db_%sfiles` B 
					WHERE 
					A.`usr_id`=B.`usr_id` AND 
					B.`file_key`='%s'
					LIMIT 1;", $type, $file_key));
if ($u->fields["usr_key"] == '') {
	$type		= 'audio';
	$u	 	= $db->execute(sprintf("SELECT 
					A.`usr_key`, 
					B.`usr_id`, 
					B.`file_title`, B.`file_tags`, SUBSTRING(B.`file_description`, 1, 200) AS `file_description`
					FROM 
					`db_accountuser` A, `db_%sfiles` B
					WHERE 
					A.`usr_id`=B.`usr_id` AND 
					B.`file_key`='%s'  
					LIMIT 1;", $type, $file_key));
}
$usr_key 	 = $u->fields["usr_key"];
if ($usr_key == '') {
	exit;
}

$vtitle		 = $u->fields["file_title"];
$vtags		 = $u->fields["file_tags"];
$vdescr		 = $u->fields["file_description"];
$vurl		 = $cfg["main_url"].'/'.VGenerate::fileHref('v', $file_key, $vtitle);
/* related files */
$rel1            = str_replace(array('_', '-', ' ', '.', ','), array('%', '%', '%', '%', '%'), $vtitle);//related string
$rel2            = str_replace(array('_', '-', ' ', '.', ','), array('%', '%', '%', '%', '%'), $vtags);//related tags
$rel1            = $rel1.'%'.$rel2;
$rdata           = $db->execute(VView::relatedSQL($type, $file_key, $rel1));//get related files


echo(header('content-type: text/xml'));
?>
<?php echo '<?'; ?>xml version="1.0" encoding="UTF-8"?>
<rss xmlns:jwplayer="http://rss.jwpcdn.com/">
    <channel>
    <title><?php echo $vtitle; ?></title>
    <description><?php echo $vdescr; ?></description>
    <link><?php echo $vurl; ?></link>
<?php
if($rdata->fields["file_key"]){
    while(!$rdata->EOF){
    $t	 = $rdata->fields["file_title"];
    $k	 = $rdata->fields["file_key"];
    $u	 = $rdata->fields["usr_key"];
    $thumb_server = $rdata->fields["thumb_server"];
    if ($type == 'video') {
    	$url = file_exists($cfg["media_files_dir"].'/'.$u.'/v/'.$k.'.720p.mp4') ? $cfg["media_files_url"].'/'.$u.'/v/'.$k.'.720p.mp4' : (file_exists($cfg["media_files_dir"].'/'.$u.'/v/'.$k.'.480p.mp4') ? $cfg["media_files_url"].'/'.$u.'/v/'.$k.'.480p.mp4' : file_exists($cfg["media_files_dir"].'/'.$u.'/v/'.$k.'.360p.mp4') ? $cfg["media_files_url"].'/'.$u.'/v/'.$k.'.360p.mp4' : $cfg["media_files_url"].'/'.$u.'/v/'.$k.'.360p.flv');
    } else {
    	$url = file_exists($cfg["media_files_dir"].'/'.$u.'/a/'.$k.'.mp4') ? $cfg["media_files_url"].'/'.$u.'/a/'.$k.'.mp4' : (file_exists($cfg["media_files_dir"].'/'.$u.'/a/'.$k.'.mp3') ? $cfg["media_files_url"].'/'.$u.'/a/'.$k.'.mp3' : null);
    }

    if ($thumb_server > 0) {
    	$tmb = VGenerate::thumbSigned($type, $k, $u, 0, 0, 1);
    } else {
    	$tmb = $cfg["media_files_url"].'/'.$u.'/t/'.$k.'/1.jpg';
    }
    echo '
    <item>
      <title>'.$t.'</title>
      <link>'.$cfg["main_url"].'/'.VGenerate::fileHref($type[0], $k, $t).'</link>
      <description>'.$rdata->fields["file_description"].'</description>
      <guid isPermalink="false">'.$file_key.'</guid>
      <jwplayer:image>'.$tmb.'</jwplayer:image>
      <jwplayer:source file="'.$url.'" type="'.$type.'/'.substr($url, -3).'" />
    </item>
    ';
	$rdata->MoveNext();
    }
}
?>
    </channel>
</rss>
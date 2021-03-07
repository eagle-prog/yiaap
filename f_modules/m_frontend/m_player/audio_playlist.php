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

$cfg		 = $class_database->getConfigurations('audio_player');
$pl_id	 	 = $class_filter->clr_str($_GET["p"]);
$res	 	 = $db->execute(sprintf("SELECT `pl_name`, `pl_files` FROM `db_audioplaylists` WHERE `pl_key`='%s' AND `pl_privacy`='public' LIMIT 1;", $pl_id));

if($res->fields["pl_files"]){
    $sql 	 = array();
    $_ar 	 = unserialize($res->fields["pl_files"]);

    if($cfg["audio_player"] == 'jw'){//playlist for jw player
	echo "<rss version=\"2.0\"\n\txmlns:jwplayer=\"http://developer.longtailvideo.com/trac/\"\n\txmlns:media=\"http://search.yahoo.com/mrss/\">\n";
	echo "\n\t<channel>\n";

	echo "\t\t<title>".$res->fields["pl_name"]."</title>\n";
	foreach($_ar as $k => $v){
    	    $uid	= $class_database->singleFieldValue('db_audiofiles', 'usr_id', 'file_key', $v);
    	    $title	= $class_database->singleFieldValue('db_audiofiles', 'file_title', 'file_key', $v);
    	    $usr_key	= $class_database->singleFieldValue('db_accountuser', 'usr_key', 'usr_id', $uid);
	    $location 	= $cfg["media_files_url"].'/'.$usr_key.'/a/'.$v.'.mp3';
    	    $thumb	= $cfg["media_files_url"].'/'.$usr_key.'/t/'.$v.'/0.jpg';

    	    echo "\n\t\t<item>\n";
    	    echo "\t\t\t<title>".$title."</title>\n";
    	    echo "\t\t\t<media:thumbnail url=\"$thumb\" />\n";
    	    echo "\t\t\t<media:content url=\"$location\" />\n";
    	    echo "\t\t</item>\n";
	}
	echo "\t</channel>\n";
	echo "</rss>";
    } elseif($cfg["audio_player"] == 'flow'){//playlist for flowplayer
	echo "<rss version=\"2.0\"\n\txmlns:media=\"http://search.yahoo.com/mrss/\"\n\txmlns:fp=\"http://flowplayer.org/fprss/\">\n";
	echo "\n\t<channel>\n";

	echo "\t\t<title>".$res->fields["pl_name"]."</title>\n";
	echo "\t\t<link>".$cfg["main_url"].'/'.VHref::getKey("playlist").'?a='.$pl_id."</link>\n";

	foreach($_ar as $k => $v){
    	    $uid	= $class_database->singleFieldValue('db_audiofiles', 'usr_id', 'file_key', $v);
    	    $title	= $class_database->singleFieldValue('db_audiofiles', 'file_title', 'file_key', $v);
    	    $descr	= $class_database->singleFieldValue('db_audiofiles', 'file_descr', 'file_key', $v);
    	    $creator	= VUserinfo::getUserName($uid);
    	    $usr_key	= $class_database->singleFieldValue('db_accountuser', 'usr_key', 'usr_id', $uid);
    	    $location 	= $cfg["media_files_url"].'/'.$usr_key.'/a/'.$v.'.mp3';
    	    $thumb	= $cfg["media_files_url"].'/'.$usr_key.'/t/'.$v.'/0.jpg';
    	    $info	= $cfg["main_url"].'/'.VHref::getKey("watch").'?a='.$v.'&amp;p='.$pl_id;

    	    echo "\n\t\t<item>\n";
    	    echo "\t\t\t<title>".$title."</title>\n";
    	    echo "\t\t\t<description>".$descr."</description>\n";
    	    echo "\t\t\t<media:credit role=\"author\">".$creator."</media:credit>\n";
    	    echo "\t\t\t<media:thumbnail url=\"$thumb\" />\n";//strange bug in flowplayer - if there are thumbnails defined, these will be played as clips
//    	    echo $k == 0 ? "\t\t\t<media:thumbnail url=\"$thumb\" />\n" : NULL;//strange bug in flowplayer - if there are thumbnails defined, these will be played as clips
    	    echo "\t\t\t<media:content url=\"$location\" type=\"audio/x-mp3\" />\n";
    	    echo "\t\t\t<link>".$info."</link>\n";
    	    echo "\t\t</item>\n";
	}
	echo "\t</channel>\n";
	echo "</rss>";
    }
}
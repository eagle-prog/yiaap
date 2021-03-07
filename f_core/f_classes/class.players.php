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
| Copyright (c) 2013-2018 viewshark.com. All rights reserved.
|**************************************************************************************************/

defined ('_ISVALID') or die ('Unauthorized Access!');

class VPlayers {
    /* embedded video players */
    function playerEmbedCodes($src, $info, $width, $height, $m='', $be=''){
        switch($src){
            case "dailymotion":
                $ec      = '<iframe width="'.$width.'" height="'.$height.'" src="https://www.dailymotion.com/embed/video/'.$info["key"].'?autoplay='.($be == '' ? 0 :1).'" frameborder="0" allowFullScreen></iframe>';
            break;
            case "youtube":
                $ec      = '<iframe class="youtube-player" type="text/html" width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$info["key"].'?wmode=opaque&autoplay='.($be == '' ? 0 : 1).'" frameborder="0" allowfullscreen></iframe>';
            break;
            case "vimeo":
                $ec      = '<iframe width="'.$width.'" height="'.$height.'" src="https://player.vimeo.com/video/'.$info["key"].'?autoplay='.($be == '' ? 0 : 1).'" frameborder="0" allowFullScreen></iframe>';
                $ec      = $m != '' ? '<iframe width="'.$width.'" height="'.$height.'" src="https://vimeo.com/m/'.$info["key"].'" frameborder="0" allowFullScreen></iframe>' : $ec;
            break;
            default://metacafe
            	$ec	 = null;
//                $ec      = '<embed flashVars="playerVars=autoPlay='.($be == '' ? 'no' : 'yes').'" src="'.$info["ec"].'" width="'.$width.'" height="'.$height.'" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_'.$info["key"].'" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>';
            break;
        }
        return $ec;
    }
    /* get metacafe swf url */
    function mc_swfurl($embed_key){
    	return;

        $metacafe_api        = 'http://www.metacafe.com/api/item/'.$embed_key;
        $r                   = file_get_contents($metacafe_api);
        $xml                 = simplexml_load_string($r, 'SimpleXMLElement', LIBXML_NOCDATA);
        $player              = $xml->xpath(" /rss/channel/item/media:content/@url ");

        return $player[0];
    }
    /* init */
    function playerInit($section){
	global $cfg, $class_filter;

	switch($section){
	    case "backend"://backend file manager
		$_id		= 'view-player';
		$_width		= '100%';
		$_height	= (isset($_GET["a"]) ? '100%' : ($cfg["video_player"] == 'flow' ? '99%' : '100%'));
	    break;
	    case "view"://view files page
		$_id		= 'view-player';
		$_width		= '100%';
		$_height	= isset($_GET["i"]) ? '530px' : (isset($_GET["a"]) ? '560px' : ($cfg["video_player"] == 'flow' ? '560px' : '560px'));
		$_height	= '100%';
	    break;
	    case "embed"://embed files
		$t		= isset($_GET["a"]) ? 'audio' : (isset($_GET["l"]) ? 'live' : 'video');
		$_id		= 'view-player-'.$class_filter->clr_str($_GET[$t[0]]);
		$_width		= '100%';
		$_height	= (($t == 'audio' and !isset($_GET["p"])) ? '100%' : '100%');
	    break;
	    case "channel"://personal channel page
	    case "channel_audio"://personal channel page
		$_id            = 'player-loader';
		$_width		= 640;
		$_height	= ((isset($_GET["a"]) and $_GET["do"] == 'load-audio') ? 445 : 445);
	    break;
	    case "edit"://editing files page
		$_id		= 'player-edit';
		$_width		= 500;
		$_height	= (isset($_GET["a"]) ? 320 : 320);
	    break;
	    case "main"://homepage player
		$_id		= $cfg["video_player"].'-player-home';
		$_width		= 352;
		$_height	= 226;
	    break;
	}
	return array($_id, $_width, $_height);
    }
    /* Flowplayer javascript */
    function FPJS($section, $usr_key='', $file_key='', $is_hd='', $next_file_key='', $next_pl_key=''){
	global $cfg, $class_filter, $class_database, $language;

	$cfg[]           = $class_database->getConfigurations('stream_method,stream_server,stream_lighttpd_key,stream_lighttpd_prefix,stream_lighttpd_url,stream_lighttpd_secure,stream_rtmp_location');
	$p		 = self::playerInit($section);
	$_vid		 = $class_filter->clr_str($_GET["v"]);
	$_img		 = $class_filter->clr_str($_GET["i"]);
	$_aud		 = $class_filter->clr_str($_GET["a"]);
	$_aud		 = $section != 'backend' ? ((strlen($_aud) > 10) ? $_aud : NULL) : $_aud;
	$_doc		 = $class_filter->clr_str($_GET["d"]);
	$_id		 = $p[0];
	$_width		 = $p[1];
	$_height	 = $p[2];

	if($usr_key == 'video'){
	    $_for	 = 'video';
	    $usr_key	 = '';
	} else $_for	 = NULL;

	$_get            = $section == 'embed' ? 'flow_embed' : 'flow_local';
        $_cfg            = unserialize($class_database->singleFieldValue('db_fileplayers', 'db_config', 'db_name', $_get));

        switch($section){
    	    case "channel":
    	    case "channel_audio":
    		global $ch_cfg;

    		$ap	 = $ch_cfg["ch_v_autoplay"];
    		$autoplay= $ap == 1 ? 'enabled' : 'disabled';
    		$autoplay= '"+(typeof($(".thumb-entry-wrap-bg").attr("rel-next")) != "undefined" ? "enabled" : "'.$autoplay.'")+"';
    	    break;
    	    case "backend":
    		$autoplay= 'enabled';
    	    break;
    	    default:
    		$autoplay= ($next_pl_key != '' and isset($_GET["p"])) ? 'enabled' : $_local["flow_autoplay"];
    	    break;
        }

	$js	 = '
	$(document).ready(function(){
	    $("#'.$_id.'").flowplayer({
		key: "'.$_cfg["flow_license"].'",
		logo: "'.$_cfg["flow_logo"].'",
		disabled: '.$_cfg["flow_disabled"].',
		engine: "'.$_cfg["flow_engine"].'",
		flashfit: '.$_cfg["flow_flashfit"].',
		fullscreen: '.$_cfg["flow_fullscreen"].',
		keyboard: '.$_cfg["flow_keyboard"].',
		muted: '.$_cfg["flow_muted"].',
		native_fullscreen: '.$_cfg["flow_native_fullscreen"].',
		'.($_cfg["flow_rtmp"] != '' ? 'rtmp: "'.$_cfg["flow_rtmp"].'",' : NULL).'
		splash: '.$_cfg["flow_splash"].',
		tooltip: '.$_cfg["flow_tooltip"].',
		analytics: "'.$_cfg["flow_analytics"].'",
		embed: false,
		swf: "'.$cfg["modules_url"].'/m_player/swf/flowplayer5.swf",
		playlist: [
		    [
		    '.self::buildFileSources('video', $file_key, $usr_key, ($section == 'channel' ? ($_for == 'video' ? 'channel' : 'channel2') : $section), 1).'
		    ]
		]
	    });
	});
	';

	$js	.= '
//	    $(document).ready(function(){
	    $(function(){
		var cs = "'.$section.'";

		if(cs == "backend"){
		    var api = $(".fancybox-wrap #view-player").data("flowplayer");
		} else {
		    var api = $("#'.$_id.'").flowplayer();
		}
		'.(($_cfg["flow_autoplay"] == '1' or ($next_file_key != '' and $next_file_key != '"+$(".thumb-entry-wrap-bg").attr("rel-next")+"' and $section == 'view') or $section == 'backend') ? 'api.load();' : NULL).'

		api.bind("seek", function(e, api) {
		    $(".flowplayer").addClass("cue0");
		});

		api.bind("cuepoint", function (e, api, cuepoint) {
		    var subtitle = cuepoint.subtitle;

		    if (subtitle) {
			$(".flowplayer").addClass("cue0");
		    }
		    if (cuepoint.subtitleEnd) {
			$(".flowplayer").addClass("cue0");
		    }
		});
		$(".flowplayer").addClass("cue0");

		api.bind("ready", function (e, api) {
		    api.volume('.($_cfg["flow_muted"] == '1' ? 0 : $_cfg["flow_volume"]).');
		});
		';

	if($section == 'view'){
	    $js	.= 'api.bind("finish", function (e, api) {';
	    $js	.= 'if($("input[name=autoplay_switch_check]").is(":checked") && "'.$next_file_key.'" == ""){
	    				u = $(".vs-column.full-thumbs.first-entry .full-details-holder a").attr("href");
	    				if (typeof u == "undefined") {
	    					u = $(".suggested-list li:first.vs-column.thirds figcaption a").attr("href");
	    					
	    					document.location = u;
	    					return false;
	    				}
	    			}
	    			if ("'.$next_file_key.'" != "") {
	    				u = "'.$cfg["main_url"].'/'.VGenerate::fileHref((($_img == '' and $_aud == '') ? 'v' : ($_aud != '' ? 'a' : 'i')), $next_file_key, '').'&p='.$next_pl_key.'";
	    			}
	    			document.location = u;
	    			return false;
	    		';
	    $js	.= '});';
	}
	$js	.= $section != '' ? '
		$(".fsrc-360p, .fsrc-480p, .fsrc-720p, .fsrc-1080p").click(function() {
		    var cSrc = $(this).attr("class").substr(-4);
		    var fSrc = api.video.url;
		    var ptime = api.video.time;
		    var pvol = api.volumeLevel;
		    var count1 = (fSrc.match(/360p/g) || []).length;
		    var count2 = (fSrc.match(/480p/g) || []).length;
		    var count3 = (fSrc.match(/720p/g) || []).length;
                    var count4 = (fSrc.match(/1080p/g) || []).length;
		    if($(this).hasClass("factive")){
			return;
		    }
		    $(".factive").removeClass("factive"); $(this).addClass("factive");

		    if($(this).hasClass("fsrc-360p")){
			var psrc = api.video.sources[0].src;
		    } else if($(this).hasClass("fsrc-480p")){
			var psrc = api.video.sources[1].src;
		    } else if($(this).hasClass("fsrc-720p")){
			var psrc = api.video.sources[2].src;
		    } else if($(this).hasClass("fsrc-1080p")){
			var psrc = api.video.sources[3].src;
		    }

		    if(typeof($(".fp-signed").html()) != "undefined"){ 
                        psrc = ($(".fp-signed").hasClass("r") ? "mp4:" : "") + $("#video-'.$file_key.'-"+cSrc).html(); 
                    } 

		    api.load(psrc, function(){api.seek(ptime);});
		    return false;
	});
		' : NULL;
	$js	.= '
	    });
	';

	return $js;
    }
    /* flowplayer subtitle file */
    function FPsubtitle($sub_file){
	global $cfg;

	$sub_dir         = $cfg["main_dir"].'/f_data/data_subtitles/';

        $sub_files       = array_values(array_diff(scandir($sub_dir), array('..', '.', '.htaccess')));

        if($sub_files[0]){
            foreach($sub_files as $k => $sub){
        	if($sub_file == md5($sub)){
        	    return $sub;
        	}
            }
        }
        return;
    }
    /* flowplayer ads */
    function fpAds($file_key, $cuepoints){
	global $db;

	$html	 = NULL;
	$cp	 = substr($cuepoints, 1);
	$cp	 = substr($cp, 0, -1);
	$cps	 = explode(",", $cp);

	if($cps[0] == '0.1'){
	    unset($cps[0]);
	    $cps = array_values($cps);
	}
	if($cps[0]){
	    foreach($cps as $k => $c){
		$ac	 = $db->execute(sprintf("SELECT A.`ad_file`, A.`ad_css`, B.`db_code` FROM `db_fpadentries` A, `db_jwadcodes` B WHERE A.`ad_file`=B.`db_key` AND A.`ad_cuepoint`='%s' ORDER BY RAND() LIMIT 1;", $c));
		$html 	.= '<div class="info info'.($k+1).'" style="'.$ac->fields["ad_css"].'">'.$ac->fields["db_code"].'</div>';
	    }
	}

	return $html;
    }
    /* flowplayer cuepoints */
    function fpCuepoints($file_key){
	global $db, $class_database;

	$fp	 = $class_database->singleFieldValue('db_videofiles', 'fp_ads', 'file_key', $file_key);
	if($fp != ''){
	    $cps = array();
	    $fps = unserialize($fp);
	    $cp	 = $db->execute(sprintf("SELECT `ad_cuepoint` FROM `db_fpadentries` WHERE `ad_active`='1' AND `ad_id` IN (%s) ORDER BY `ad_cuepoint`;", implode(',', $fps)));
	    while(!$cp->EOF){
		$cps[] = $cp->fields["ad_cuepoint"];
		$cp->MoveNext();
	    }
	}
	if($cps[0]){
	    return '[0.1,'.implode(',', $cps).']';
	} else {
	    if($file_key != ''){//find non assigned ads
		$ex	= array();
		$res	= $db->execute(sprintf("SELECT `fp_ads` FROM `db_videofiles` WHERE `file_key`!='%s' AND `fp_ads`!='';", $file_key));

		if($res->fields["fp_ads"]){//exclude these ads (already assigned)
		    while(!$res->EOF){
			$_ar = unserialize($res->fields["fp_ads"]);

			foreach($_ar as $_m){//exclude these ads (already assigned)
			    $ex[] = $_m;
			}

			$res->MoveNext();
		    }
		} else {
		    $ex[] = -1;
		}

		if($ex[0]){
		    $cps = array();
		    $cp	 = $db->execute(sprintf("SELECT `ad_cuepoint` FROM `db_fpadentries` WHERE `ad_active`='1' AND `ad_id` NOT IN (%s) ORDER BY `ad_cuepoint`;", implode(',', $ex)));
		    while(!$cp->EOF){
		        $cps[] = $cp->fields["ad_cuepoint"];
		        $cp->MoveNext();
		    }

		    if($cps[1]){
		        return '[0.1,'.implode(',', $cps).']';
		    }
		}
	    }
	}

	return '[0.1]';
    }
    /* file urls */
    function getFileUrl($type, $file_key, $usr_key){
	global $cfg, $class_database;

	$cfg[]           = $class_database->getConfigurations('stream_method,stream_server,stream_lighttpd_key,stream_lighttpd_prefix,stream_lighttpd_url,stream_lighttpd_secure,stream_rtmp_location');
    	switch($type){
	    case "l": $tbl = 'live'; $file1 = null; $file2 = null;
	    break;

	    case "v": $tbl = 'video';
    	    switch($cfg["stream_method"]){
            case "":
            case "0":
            case "1":
                $flv_url     = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.flv';
                $mp4_url     = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
            break;
            case "2":
                if($cfg["stream_server"] == 'lighttpd'){
                    if($cfg["stream_lighttpd_secure"] == 1){
                        $_file_url   = VPlayers::vStreaming_url($usr_key, $file_key);
                        $flv_url     = $_file_url[0];
                        $mp4_url     = $_file_url[1];
                    } else {
                        $flv_url     = $cfg["stream_lighttpd_url"].'/f_data/data_userfiles/user_media/'.$usr_key.'/v/'.$file_key.'.flv';
                        $mp4_url     = $cfg["stream_lighttpd_url"].'/f_data/data_userfiles/user_media/'.$usr_key.'/v/'.$file_key.'.mp4';
                    }
                } else {
                    $flv_url         = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.flv';
                    $mp4_url         = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
                }
            break;
            case "3":
                $flv_url             = $cfg["stream_rtmp_location"].'/'.$usr_key.'/v/'.$file_key.'.flv';
                $mp4_url             = $cfg["stream_rtmp_location"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
            break;
        }

        if($cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 1){
            $file        = VPlayers::vStreaming_url($usr_key, $file_key);
            $file1       = $file[0];
            $file2       = $file[1];
        } else {
            $file1       = $flv_url;
            $file2       = $mp4_url;
        }
    break;
    case "a":
	$tbl	 = 'audio';
        $file1   = $cfg["media_files_url"].'/'.$usr_key.'/a/'.$file_key.'.mp3';
        $file2	 = NULL;
    break;
    }

    return array($file1, $file2, $tbl);
    }

    function fileSources($type, $usr_key, $file_key, $srv=''){
	global $db, $class_database, $cfg;

	    $f = array();
	    $cfg[]	= $class_database->getConfigurations('stream_server,stream_method,stream_lighttpd_secure,stream_lighttpd_url,conversion_video_previews,conversion_audio_previews,conversion_live_previews');

	    $cc		= $db->execute(sprintf("SELECT `old_file_key`, `has_preview`, `file_name` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $type, $file_key));
	    $old	= $cc->fields["old_file_key"];
	    $hpv	= $cc->fields["has_preview"];

	    $previews	= (($type == 'live' and $cfg["conversion_live_previews"] == 1 and $hpv == 1) or ($type == 'video' and $cfg["conversion_video_previews"] == 1 and $hpv == 1) or ($type == 'audio' and $cfg["conversion_audio_previews"] == 1 and $hpv == 1)) ? true : false;
	    if (isset($_SESSION["USER_ID"]) and (int) $_SESSION["USER_ID"] > 0) {
	    	$vuid	= $class_database->singleFieldValue('db_'.$type.'files', 'usr_id', 'file_key', $file_key);
	    	if ($vuid > 0) {
	    		if ($vuid == (int) $_SESSION["USER_ID"])
	    			$previews = false;
	    		else {
	    			$ss = $db->execute(sprintf("SELECT `db_id`, `sub_list` FROM `db_subscriptions` WHERE `usr_id`='%s' LIMIT 1;", (int) $_SESSION["USER_ID"]));
	    			if ($ss->fields["db_id"]) {
	    				$subs = unserialize($ss->fields["sub_list"]);
	    				if (in_array($vuid, $subs)) {
	    					$sb = $db->execute(sprintf("SELECT `db_id` FROM `db_subusers` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' LIMIT 1;", (int) $_SESSION["USER_ID"], $vuid, date("Y-m-d H:i:s")));
	    					if ($sb->fields["db_id"] > 0)
	    						$previews = false;
	    					else
	    						$previews = true;
	    				}
	    			}
	    			if ($previews) {
		    			$ts = $db->execute(sprintf("SELECT `db_id` FROM `db_subtemps` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' AND `active`='1' LIMIT 1;", (int) $_SESSION["USER_ID"], $vuid, date("Y-m-d H:i:s")));

		    			if ($ts->fields["db_id"])
		    				$previews = false;
	    			}
	    		}
	    	}
	    } elseif (isset($_GET["section"]) and $_GET["section"] == 'backend' and isset($_GET["pv"])) {
	    	$previews = (bool) $_GET["pv"];
	    }
	    $previews	= !$previews ? ($old == 1 ? true : false) : $previews;

	    $rs		= $db->execute("SELECT `cfg_name`, `cfg_data` FROM `db_conversion`;");
            while(!$rs->EOF){
                $cfg[$rs->fields["cfg_name"]] = $rs->fields["cfg_data"];
                @$rs->MoveNext();
            }

	    $url        = VGenerate::fileURL($type, $file_key, 'upload');
	    $gs		= !$previews ? md5($cfg["global_salt_key"].$file_key) : $file_key;

            $f["360p"]	= array(
        		    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.360p.mp4',
        		    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.360p.webm',
        		    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.360p.ogv');
    	    $f["480p"]	= array(
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.480p.mp4',
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.480p.webm',
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.480p.ogv');
    	    $f["720p"]	= array(
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.720p.mp4',
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.720p.webm',
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.720p.ogv');
            $f["1080p"]	= array(
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.1080p.mp4',
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.1080p.webm',
    			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.1080p.ogv');

	    if(($srv->fields["lighttpd_url"] != '' and $srv->fields["lighttpd_secdownload"] == 1) or ($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 1)){
		$f["360p"] = self::vStreaming_url($usr_key, $gs, $f["360p"], $srv, $url);
		$f["480p"] = self::vStreaming_url($usr_key, $gs, $f["480p"], $srv, $url);
		$f["720p"] = self::vStreaming_url($usr_key, $gs, $f["720p"], $srv, $url);
                $f["1080p"] = self::vStreaming_url($usr_key, $gs, $f["1080p"], $srv, $url);
	    } elseif(($srv->fields["lighttpd_url"] != '' and $srv->fields["lighttpd_secdownload"] == 0) or ($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 0)){
		if($srv->fields["lighttpd_url"] != ''){
                    $cfg["stream_lighttpd_url"] = $srv->fields["lighttpd_url"];
                }

		$f["360p"][0] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["360p"][0]);
		$f["360p"][1] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["360p"][1]);
		$f["360p"][2] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["360p"][2]);
		$f["480p"][0] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["480p"][0]);
		$f["480p"][1] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["480p"][1]);
		$f["480p"][2] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["480p"][2]);
		$f["720p"][0] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["720p"][0]);
		$f["720p"][1] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["720p"][1]);
		$f["720p"][2] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["720p"][2]);
                $f["1080p"][0] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["1080p"][0]);
		$f["1080p"][1] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["1080p"][1]);
		$f["1080p"][2] = str_replace($cfg["media_files_url"], $cfg["stream_lighttpd_url"], $f["1080p"][2]);
	    }

    	    if($cfg["conversion_mp4_360p_active"] == 0){ unset($f["360p"][0]); }
    	    if($cfg["conversion_mp4_480p_active"] == 0){ unset($f["480p"][0]); }
    	    if($cfg["conversion_mp4_720p_active"] == 0){ unset($f["720p"][0]); }
            if($cfg["conversion_mp4_1080p_active"] == 0){ unset($f["1080p"][0]); }
    	    if($cfg["conversion_vpx_360p_active"] == 0){ unset($f["360p"][1]); }
    	    if($cfg["conversion_vpx_480p_active"] == 0){ unset($f["480p"][1]); }
    	    if($cfg["conversion_vpx_720p_active"] == 0){ unset($f["720p"][1]); }
            if($cfg["conversion_vpx_1080p_active"] == 0){ unset($f["1080p"][1]); }
    	    if($cfg["conversion_ogv_360p_active"] == 0){ unset($f["360p"][2]); }
    	    if($cfg["conversion_ogv_480p_active"] == 0){ unset($f["480p"][2]); }
    	    if($cfg["conversion_ogv_720p_active"] == 0){ unset($f["720p"][2]); }
            if($cfg["conversion_ogv_1080p_active"] == 0){ unset($f["1080p"][2]); }

    	    if($type == 'audio'){
    		$f 		= array();

        	$f["360p"]	= array(
        			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.mp4',
        			    $url.'/'.$usr_key.'/'.$type[0].'/'.$gs.'.mp3'
        			    );
    	    }

	return $f;
    }
    function channelSources($type, $usr_key, $file_key){
	global $db, $class_database, $cfg;

	$cfg[]           = $class_database->getConfigurations('stream_server,stream_lighttpd_secure,stream_lighttpd_url');
	$src		 = array();
	$f 		 = self::fileSources($type, $usr_key, $file_key);
	$rs              = $db->execute("SELECT `cfg_name`, `cfg_data` FROM `db_conversion`;");

        while(!$rs->EOF){
            $cfg[$rs->fields["cfg_name"]] = $rs->fields["cfg_data"];
            @$rs->MoveNext();
        }

	if(($cfg["conversion_mp4_360p_active"] == 0 and $cfg["conversion_mp4_480p_active"] == 0 and $cfg["conversion_mp4_720p_active"] == 0 and $cfg["conversion_mp4_1080p_active"] == 0) and ($cfg["conversion_vpx_360p_active"] == 0 and $cfg["conversion_vpx_480p_active"] == 0 and $cfg["conversion_vpx_720p_active"] == 0 and $cfg["conversion_vpx_1080p_active"] == 0) and ($cfg["conversion_ogv_360p_active"] == 0 and $cfg["conversion_ogv_480p_active"] == 0 and $cfg["conversion_ogv_720p_active"] == 0 and $cfg["conversion_ogv_1080p_active"] == 0) and ($cfg["conversion_flv_360p_active"] == 1 or $cfg["conversion_flv_480p_active"] == 1)){
	    return self::getFLVsrc($type, $usr_key, $file_key, 1);
	} else {
	    $url         = VGenerate::fileURL($type, $file_key, 'upload');
    	    foreach($f as $k => $v){
        	if($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 1){
        		$l0	= explode("/", $v[0]);
        		$loc0	= $cfg["media_files_dir"].'/'.$l0[6].'/'.$l0[7].'/'.$l0[8];
        		$l1	= explode("/", $v[1]);
        		$loc1	= $cfg["media_files_dir"].'/'.$l1[6].'/'.$l1[7].'/'.$l1[8];
        		$l2	= explode("/", $v[2]);
        		$loc2	= $cfg["media_files_dir"].'/'.$l2[6].'/'.$l2[7].'/'.$l2[8];
        		$l3	= explode("/", $v[3]);
        		$loc3	= $cfg["media_files_dir"].'/'.$l3[6].'/'.$l3[7].'/'.$l3[8];
                        $l4	= explode("/", $v[4]);
        		$loc4	= $cfg["media_files_dir"].'/'.$l4[6].'/'.$l4[7].'/'.$l4[8];
        	} elseif($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 0){
        		$loc0	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[0]);
        		$loc1	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[1]);
        		$loc2	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[2]);
        		$loc3	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[3]);
                        $loc4	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[4]);
        	} else {
        		$loc0	= str_replace($url, $cfg["media_files_dir"], $v[0]);
        		$loc1	= str_replace($url, $cfg["media_files_dir"], $v[1]);
        		$loc2	= str_replace($url, $cfg["media_files_dir"], $v[2]);
        		$loc3	= str_replace($url, $cfg["media_files_dir"], $v[3]);
                        $loc4	= str_replace($url, $cfg["media_files_dir"], $v[4]);
        	}

    		if(is_file($loc0)){
    		    $src[]	 = $k.'.'.substr($v[0], -3);
    		}
    		if(is_file($loc1)){
    		    $src[]	 = $k.'.'.substr($v[1], -4);
    		}
    		if(is_file($loc2)){
    		    $src[]	 = $k.'.'.substr($v[2], -3);
    		}
    		if(is_file($loc3)){
    		    $src[]	 = $k.'.'.substr($v[3], -3);
    		}
                if(is_file($loc4)){
    		    $src[]	 = $k.'.'.substr($v[4], -3);
    		}
    	    }
        }
        return implode(',', $src);
    }
    function getFLVsrc($type, $usr_key, $file_key, $ch='', $fp=''){
	global $db, $class_database, $cfg;
		$f	= array();
 		$src	= array();
		$f1	= $cfg["media_files_url"].'/'.$usr_key.'/'.$type[0].'/'.$file_key.'.360p.flv';
		$f2	= $cfg["media_files_url"].'/'.$usr_key.'/'.$type[0].'/'.$file_key.'.480p.flv';
		$f3	= $cfg["media_files_url"].'/'.$usr_key.'/'.$type[0].'/'.$file_key.'.flv';

        	$loc1	= str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $f1);
        	$loc2	= str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $f2);
        	$loc3	= str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $f3);

        	$f["360p"]	= array(
        			$cfg["media_files_url"].'/'.$usr_key.'/'.$type[0].'/'.$file_key.'.360p.flv',
        			$cfg["media_files_url"].'/'.$usr_key.'/'.$type[0].'/'.$file_key.'.flv');

    		$f["480p"]	= array(
    				$cfg["media_files_url"].'/'.$usr_key.'/'.$type[0].'/'.$file_key.'.480p.flv');

        	foreach($f as $k => $v){
        	    $loc0	= str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $v[0]);
        	    $loc1	= str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $v[1]);
		    if($ch == ''){
			if($fp == ''){
        		    $src[] 	= '{'.(file_exists($loc0) ? 'file: "'.$v[0].'",' : NULL).(file_exists($loc1) ? 'file: "'.$v[1].'",' : NULL).' label: "'.$k.'", mediaid: "'.$file_key.'" }';
        		} else {
        		    if(file_exists($loc0)){
                        	$src[] = '{ flv: "'.$v[0].'" }';
                    	    }
        		}
        	    } else {
        		if(file_exists($loc0)){
        		    $src[]   = $k.'.'.substr($v[0], -3);
        		}
        		if(file_exists($loc1)){
        		    $src[]   = $k.'.'.substr($v[1], -3);
        		}
        	    }
		}
	return implode(',', $src);
    }
	function buildFileSources($type, $file_key, $usr_key, $section, $fp=''){
	    require_once 'class.be.servers.php';
	    global $db, $class_database, $cfg;

	    $src	 = array();

	    $rs              = $db->execute("SELECT `cfg_name`, `cfg_data` FROM `db_conversion`;");
            while(!$rs->EOF){
                $cfg[$rs->fields["cfg_name"]] = $rs->fields["cfg_data"];
                @$rs->MoveNext();
            }
            
            $sql        = sprintf("SELECT 
                                                A.`server_type`, A.`lighttpd_url`, A.`lighttpd_secdownload`, A.`lighttpd_prefix`, A.`lighttpd_key`, A.`cf_enabled`, A.`cf_dist_type`,
                                                A.`cf_signed_url`, A.`cf_signed_expire`, A.`cf_key_pair`, A.`cf_key_file`, 
                                                B.`upload_server` 
                                                FROM 
                                                `db_servers` A, `db_%sfiles` B 
                                                WHERE 
                                                B.`file_key`='%s' AND 
                                                B.`upload_server` > '0' AND 
                                                A.`server_id`=B.`upload_server` LIMIT 1;", $type, $file_key);
            $srv        = $db->execute($sql);
            $cf_signed_url  = $srv->fields["cf_signed_url"];
            $cf_signed_expire = $srv->fields["cf_signed_expire"];
            $cf_key_pair    = $srv->fields["cf_key_pair"];
            $cf_key_file    = $srv->fields["cf_key_file"];


	    if(($cfg["conversion_mp4_360p_active"] == 0 and $cfg["conversion_mp4_480p_active"] == 0 and $cfg["conversion_mp4_720p_active"] == 0 and $cfg["conversion_mp4_1080p_active"] == 0) and ($cfg["conversion_vpx_360p_active"] == 0 and $cfg["conversion_vpx_480p_active"] == 0 and $cfg["conversion_vpx_720p_active"] == 0 and $cfg["conversion_vpx_1080p_active"] == 0) and ($cfg["conversion_ogv_360p_active"] == 0 and $cfg["conversion_ogv_480p_active"] == 0 and $cfg["conversion_ogv_720p_active"] == 0 and $cfg["conversion_ogv_1080p_active"] == 0) and ($cfg["conversion_flv_360p_active"] == 1 or $cfg["conversion_flv_480p_active"] == 1)){
		return self::getFLVsrc($type, $usr_key, $file_key, '', $fp);
	    } else{
		$f 		= self::fileSources($type, $usr_key, $file_key, $srv);
		$url            = VGenerate::fileURL($type, $file_key, 'upload');

        	foreach($f as $k => $v){
        	    if(($srv->fields["lighttpd_url"] != '' and $srv->fields["lighttpd_secdownload"] == 1) or ($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 1)){
        		$l0	= explode("/", $v[0]);
        		$loc0	= $cfg["media_files_dir"].'/'.$l0[6].'/'.$l0[7].'/'.$l0[8];
        		$l1	= explode("/", $v[1]);
        		$loc1	= $cfg["media_files_dir"].'/'.$l1[6].'/'.$l1[7].'/'.$l1[8];
        		$l2	= explode("/", $v[2]);
        		$loc2	= $cfg["media_files_dir"].'/'.$l2[6].'/'.$l2[7].'/'.$l2[8];
        		$l3	= explode("/", $v[3]);
        		$loc3	= $cfg["media_files_dir"].'/'.$l3[6].'/'.$l3[7].'/'.$l3[8];
                        $l4	= explode("/", $v[4]);
        		$loc4	= $cfg["media_files_dir"].'/'.$l4[6].'/'.$l4[7].'/'.$l4[8];
        	    } elseif($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 0){
        		$loc0	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[0]);
        		$loc1	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[1]);
        		$loc2	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[2]);
        		$loc3	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[3]);
                        $loc4	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[4]);
        	    } else {
        		$loc0	= str_replace($url, $cfg["media_files_dir"], $v[0]);
        		$loc1	= str_replace($url, $cfg["media_files_dir"], $v[1]);
        		$loc2	= str_replace($url, $cfg["media_files_dir"], $v[2]);
        		$loc3	= str_replace($url, $cfg["media_files_dir"], $v[3]);
                        $loc4	= str_replace($url, $cfg["media_files_dir"], $v[4]);

        		if(($srv->fields["server_type"] == 's3' or $srv->fields["server_type"] == 'ws') and $srv->fields["cf_enabled"] == 1 and $cf_signed_url == 1){
                            if($srv->fields["cf_dist_type"] == 'r' and $fp != ''){
                                $v[0] = strstr($v[0], $usr_key);
                                $v[1] = strstr($v[1], $usr_key);
                                $v[2] = strstr($v[2], $usr_key);
                                $v[3] = strstr($v[3], $usr_key);
                                $v[4] = strstr($v[4], $usr_key);
                            }

                            if($type == 'audio'){
                        	$rtmp           = $srv->fields["cf_enabled"] == 1 ? $class_database->singleFieldValue('db_servers', 'cf_dist_domain', 'server_id', $srv->fields["upload_server"]) : $class_database->singleFieldValue('db_servers', 's3_bucketname', 'server_id', $srv->fields["upload_server"]);

                        	$v[0] = strstr($v[0], $usr_key);
                            }

                            $v[0] = VbeServers::getSignedURL($v[0], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            $v[1] = VbeServers::getSignedURL($v[1], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            $v[2] = VbeServers::getSignedURL($v[2], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            $v[3] = VbeServers::getSignedURL($v[3], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            $v[4] = VbeServers::getSignedURL($v[4], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                        }
        	    }
		    if($fp == ''){
			if(($srv->fields["server_type"] == 's3' or $srv->fields["server_type"] == 'ws') and $srv->fields["cf_dist_type"] == 'r' and $type == 'video'){
                            if($k == '360p'){
                                $rtmp           = $srv->fields["cf_enabled"] == 1 ? $class_database->singleFieldValue('db_servers', 'cf_dist_domain', 'server_id', $srv->fields["upload_server"]) : $class_database->singleFieldValue('db_servers', 's3_bucketname', 'server_id', $srv->fields["upload_server"]);
                                $smilname       = $cfg["media_files_dir"].'/'.$usr_key.'/v/'.$file_key.'.smil';

                            	$v360p          = $usr_key.'/v/'.$file_key.'.360p.mp4';
                            	$v360ploc       = $cfg["media_files_dir"].'/'.$usr_key.'/v/'.$file_key.'.360p.mp4';
                            	$v480p          = $usr_key.'/v/'.$file_key.'.480p.mp4';
                            	$v480ploc       = $cfg["media_files_dir"].'/'.$usr_key.'/v/'.$file_key.'.480p.mp4';
                            	$v720p          = $usr_key.'/v/'.$file_key.'.720p.mp4';
                            	$v720ploc       = $cfg["media_files_dir"].'/'.$usr_key.'/v/'.$file_key.'.720p.mp4';
                                $v1080p         = $usr_key.'/v/'.$file_key.'.1080p.mp4';
                            	$v1080ploc      = $cfg["media_files_dir"].'/'.$usr_key.'/v/'.$file_key.'.1080p.mp4';

                            	if($cf_signed_url == 1 and $srv->fields["cf_enabled"] == 1){
                            	    $v360p      = VbeServers::getSignedURL($v360p, $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            	    $v480p      = VbeServers::getSignedURL($v480p, $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            	    $v720p      = VbeServers::getSignedURL($v720p, $cf_signed_expire, $cf_key_pair, $cf_key_file);
                                    $v1080p     = VbeServers::getSignedURL($v1080p, $cf_signed_expire, $cf_key_pair, $cf_key_file);


                                $smil           = '
<smil>
    <head>
        <meta base="rtmp://'.$rtmp.'/cfx/st/mp4/" />
    </head>
    <body>
        <switch>
            '.(is_file($v360ploc) ? '<video src="'.$v360p.'" height="360" system-bitrate="300000" width="640" />' : NULL).'
            '.(is_file($v480ploc) ? '<video src="'.$v480p.'" height="480" system-bitrate="900000" width="852" />' : NULL).'
            '.(is_file($v720ploc) ? '<video src="'.$v720p.'" height="720" system-bitrate="5000000" width="1280" />' : NULL).'
            '.(is_file($v1080ploc) ? '<video src="'.$v1080p.'" height="1080" system-bitrate="7500000" width="1920" />' : NULL).'
        </switch>
    </body>
</smil>
';

				if (!file_exists($smilname)){
                                    touch($smilname);
                                } //else {
                                    if (!$handle = fopen($smilname, 'w')) {
                                        exit;
                                    }
                                    if (fwrite($handle, $smil) === FALSE) {
                                        exit;
                                    }
                                    fclose($handle);
                                }

                                $src[]  = '{ file: "'.str_replace($cfg["media_files_dir"], $cfg["media_files_url"], $smilname).'" }';
                            }
                        } else {
                    	    if($type == 'audio' and ($srv->fields["server_type"] == 's3' or $srv->fields["server_type"] == 'ws') and $srv->fields["cf_dist_type"] == 'r' and $srv->fields["cf_enabled"] == 1){
                    		$v[0]  = 'rtmp://'.$rtmp.'/cfx/st/mp4:'.$v[0];
                    		$src[] = '{'.(is_file($loc0) ? 'file: "'.$v[0].'"' : NULL).'}';
                    	    } else {
                        	$src[] = '{'.(is_file($loc0) ? 'file: "'.$v[0].'",' : (is_file($loc3) ? 'file: "'.$v[3].'",' : NULL)).(is_file($loc1) ? 'file: "'.$v[1].'",' : NULL).(is_file($loc2) ? 'file: "'.$v[2].'",' : NULL).' label: "'.$k.'", mediaid: "'.$file_key.'" }';
                            }
                        }
                    } else {
                        if(($srv->fields["server_type"] == 's3' or $srv->fields["server_type"] == 'ws') and $srv->fields["cf_enabled"] == 1 and $srv->fields["cf_dist_type"] == 'r'){
                            if(is_file($loc0)){
                                $src[] = '{ mp4: "mp4:'.str_replace($url.'/', '', $v[0]).'" }';
                            }
        		} else {
//			if($k == '360p'){
        		    if(is_file($loc0)){
        			$src[] = '{ mp4: "'.$v[0].'" }';
        		    }
        		    if(is_file($loc3)){
                                $src[] = '{ flv: "'.$v[3].'" }';
                            }
        		    if(is_file($loc1)){
        			$src[] = '{ webm: "'.$v[1].'" }';
        		    }
        		    if(is_file($loc2)){
        			$src[] = '{ ogg: "'.$v[2].'" }';
        		    }
//        		}
			}
        	    }
		}
	    }

	    return implode($src, ',');
	}


    /* video ads */
    function getVideoAds($file_key){
	global $db, $class_database, $cfg, $language;

	$pre_str = NULL;
	$post_str = NULL;
	$acfg	 = array();
	$pcfg	 = unserialize($class_database->singleFieldValue('db_fileplayers', 'db_config', 'db_name', 'jw_local'));

	$res	 = $db->execute(sprintf("SELECT `jw_ads` FROM `db_videofiles` WHERE `file_key`='%s' LIMIT 1;", $file_key));
	$ads	 = $res->fields["jw_ads"];

	if($ads != ''){//found ads assigned to video
	    $ar	 = unserialize($ads);
	    $pre = $ar[0];
	    $post= $ar[1];
	    $client = $class_database->singleFieldValue('db_jwadentries', 'ad_client', 'ad_id', (intval($pre) > 0 ? $pre : (intval($post) > 0 ? $post : $ar[2])));
	} else {//no video ads assigned/generate a random ad
	    $pres	= array();
	    $posts	= array();
	    $mids	= array();

	    $res	= $db->execute(sprintf("SELECT `jw_ads` FROM `db_videofiles` WHERE `file_key`!='%s';", $file_key));
	    if($res->fields["jw_ads"]){
		while(!$res->EOF){
		    $_ar = unserialize($res->fields["jw_ads"]);
		    $pre = $_ar[0];
		    $post= $_ar[1];

		    if(intval($pre) > 0){//exclude these prerolls (already assigned)
			$pres[]	 = $pre;
		    }
		    if(intval($post) > 0){//exclude these postrolls (already assigned)
			$posts[] = $post;
		    }
		    if($_ar[2] != ''){

			$_mr = array();
			$_mr = $_ar;
			unset($_mr[0]);
			unset($_mr[1]);
			foreach($_mr as $_m){//exclude these midrolls (already assigned)
			    $mids[] = $_m;
			}
		    }

		    $res->MoveNext();
		}
	    } else {
		$pres[] = -1;
		$posts[] = -1;
		$mids[] = -1;
	    }
	    $ac		= array('ima', 'vast');
	    $ad_clients = array_rand($ac, 1);

	    if(count($pres) >= 0){
		$p1	= $db->execute(sprintf("SELECT `ad_id` FROM `db_jwadentries` WHERE `ad_position`='pre' AND `ad_client`='%s' AND `ad_active`='1' AND `ad_id` NOT IN (%s) ORDER BY RAND() LIMIT 1;", $ac[$ad_clients], implode(',', $pres)));
		$pre	= $p1->fields["ad_id"];
	    }
	    if(count($posts) >= 0){
		$p2	= $db->execute(sprintf("SELECT `ad_id` FROM `db_jwadentries` WHERE `ad_position`='post' AND `ad_client`='%s' AND `ad_active`='1' AND `ad_id` NOT IN (%s) ORDER BY RAND() LIMIT 1;", $ac[$ad_clients], implode(',', $posts)));
		$post	= $p2->fields["ad_id"];
	    }
	    if(count($mids) >= 0){
		$p3	= $db->execute(sprintf("SELECT `ad_id` FROM `db_jwadentries` WHERE `ad_position`='offset' AND `ad_client`='%s' AND `ad_active`='1' AND `ad_id` NOT IN (%s) ORDER BY `ad_offset` ASC;", $ac[$ad_clients], implode(',', $mids)));
		if($p3->fields["ad_id"]){

		    $ar	= array();
		    $ar[0] = 0;
		    $ar[1] = 0;

		    while(!$p3->EOF){
			$ar[] = $p3->fields["ad_id"];

			$p3->MoveNext();
		    }
		}
	    }
	    $client	= $ac[$ad_clients];
	}

	if(intval($pre) > 0){//preroll
	    $pre_res 	= $db->execute(sprintf("SELECT `ad_key`, `ad_tag`, `ad_format`, `ad_server` FROM `db_jwadentries` WHERE `ad_id`='%s' LIMIT 1;", $pre));
	    $pre_key 	= $pre_res->fields["ad_key"];
	    $pre_tag 	= $pre_res->fields["ad_tag"];
	    $pre_frm 	= $pre_res->fields["ad_format"];
	    $pre_srv 	= $pre_res->fields["ad_server"];
	    $pre_cst	= $cfg["main_url"].'/'.VHref::getKey("vast").'?v='.$pre_key;

	    $pre_str 	= sprintf("pre%s: { offset: \"pre\", tag: \"%s\" %s }", $pre_key, (($pre_srv == 'custom' and $pre_tag == 'auto') ? $pre_cst : $pre_tag), ($pre_frm == 'nonlinear' ? ', type: "nonlinear"' : NULL));
	    $acfg[]	= $pre_str;
	}
	if($ar[2] != ''){//midrolls
	    $mr	 = array();
	    $mr	 = $ar;
	    unset($mr[0]);
	    unset($mr[1]);

	    $mid_res 	= $db->execute(sprintf("SELECT `ad_key`, `ad_tag`, `ad_offset`, `ad_format`, `ad_server` FROM `db_jwadentries` WHERE `ad_id` IN (%s);", implode(',', $mr)));
	    if($mid_res->fields["ad_key"]){
		while(!$mid_res->EOF){
		    $mid_key 	= $mid_res->fields["ad_key"];
		    $mid_tag 	= $mid_res->fields["ad_tag"];
		    $mid_frm 	= $mid_res->fields["ad_format"];
		    $mid_off 	= $mid_res->fields["ad_offset"];
		    $mid_srv 	= $mid_res->fields["ad_server"];
		    $mid_cst	= $cfg["main_url"].'/'.VHref::getKey("vast").'?v='.$mid_key;

		    $mid_str 	= sprintf("mid%s: { offset: %s, tag: \"%s\" %s }", $mid_key, $mid_off, (($mid_srv == 'custom' and $mid_tag == 'auto') ? $mid_cst : $mid_tag), ($mid_frm == 'nonlinear' ? ', type: "nonlinear"' : NULL));
		    $acfg[]	= $mid_str;

		    $mid_res->MoveNext();
		}
	    }
	}
	if(intval($post) > 0){//postroll

	    $post_res 	= $db->execute(sprintf("SELECT `ad_key`, `ad_tag`, `ad_format`, `ad_server` FROM `db_jwadentries` WHERE `ad_id`='%s' LIMIT 1;", $post));
	    $post_key 	= $post_res->fields["ad_key"];
	    $post_tag 	= $post_res->fields["ad_tag"];
	    $post_frm 	= $post_res->fields["ad_format"];
	    $post_srv 	= $post_res->fields["ad_server"];
	    $post_cst	= $cfg["main_url"].'/'.VHref::getKey("vast").'?v='.$post_key;

	    $post_str 	= sprintf("post%s: { offset: \"post\", tag: \"%s\" %s }", $post_key, (($post_srv == 'custom' and $post_tag == 'auto') ? $post_cst : $post_tag), ($post_frm == 'nonlinear' ? ', type: "nonlinear"' : NULL));
	    $acfg[]	= $post_str;
	}

	$adv	 = '
	    client: "'.$client.'",
	    schedule: {
		'.implode(',', $acfg).'
	    }
	    '.($pcfg["jw_adv_msg"] != '' ? ', admessage: "'.$language[$pcfg["jw_adv_msg"]].'"' : NULL).'
	';

	return $adv;
    }
    /* build video js file sources */
	function buildVideoJSSources($type, $file_key, $usr_key, $section, $fp=''){
	    require_once 'class.be.servers.php';
	    global $db, $class_database, $cfg;

	    $src	 = array();
	    $fmt	 = array();
	    $res	 = array();

	    $rs              = $db->execute("SELECT `cfg_name`, `cfg_data` FROM `db_conversion`;");
            while(!$rs->EOF){
                $cfg[$rs->fields["cfg_name"]] = $rs->fields["cfg_data"];
                @$rs->MoveNext();
            }
            
            $sql        = sprintf("SELECT 
                                                A.`server_type`, A.`lighttpd_url`, A.`lighttpd_secdownload`, A.`lighttpd_prefix`, A.`lighttpd_key`, A.`cf_enabled`, A.`cf_dist_type`,
                                                A.`cf_signed_url`, A.`cf_signed_expire`, A.`cf_key_pair`, A.`cf_key_file`, 
                                                A.`s3_bucketname`, A.`s3_accesskey`, A.`s3_secretkey`,
                                                B.`upload_server`, B.`has_preview`
                                                FROM 
                                                `db_servers` A, `db_%sfiles` B 
                                                WHERE 
                                                B.`file_key`='%s' AND 
                                                B.`upload_server` > '0' AND 
                                                A.`server_id`=B.`upload_server` LIMIT 1;", $type, $file_key);
            $srv        = $db->execute($sql);
            $cf_signed_url  = $srv->fields["cf_signed_url"];
            $cf_signed_expire = $srv->fields["cf_signed_expire"];
            $cf_key_pair    = $srv->fields["cf_key_pair"];
            $cf_key_file    = $srv->fields["cf_key_file"];


	    if(($cfg["conversion_mp4_360p_active"] == 0 and $cfg["conversion_mp4_480p_active"] == 0 and $cfg["conversion_mp4_720p_active"] == 0 and $cfg["conversion_mp4_1080p_active"] == 0) and ($cfg["conversion_vpx_360p_active"] == 0 and $cfg["conversion_vpx_480p_active"] == 0 and $cfg["conversion_vpx_720p_active"] == 0 and $cfg["conversion_vpx_1080p_active"] == 0) and ($cfg["conversion_ogv_360p_active"] == 0 and $cfg["conversion_ogv_480p_active"] == 0 and $cfg["conversion_ogv_720p_active"] == 0 and $cfg["conversion_ogv_1080p_active"] == 0) and ($cfg["conversion_flv_360p_active"] == 1 or $cfg["conversion_flv_480p_active"] == 1)){
		return self::getFLVsrc($type, $usr_key, $file_key, '', $fp);
	    } else {
		$f 		= self::fileSources($type, $usr_key, $file_key, $srv);
		$url            = VGenerate::fileURL($type, $file_key, 'upload');

        	foreach($f as $k => $v){
        	    if(($srv->fields["lighttpd_url"] != '' and $srv->fields["lighttpd_secdownload"] == 1) or ($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 1)){
        		$l0	= explode("/", $v[0]);
        		$loc0	= $cfg["media_files_dir"].'/'.$l0[6].'/'.$l0[7].'/'.$l0[8];
        		$l1	= explode("/", $v[1]);
        		$loc1	= $cfg["media_files_dir"].'/'.$l1[6].'/'.$l1[7].'/'.$l1[8];
        		$l2	= explode("/", $v[2]);
        		$loc2	= $cfg["media_files_dir"].'/'.$l2[6].'/'.$l2[7].'/'.$l2[8];
        		$l3	= explode("/", $v[3]);
        		$loc3	= $cfg["media_files_dir"].'/'.$l3[6].'/'.$l3[7].'/'.$l3[8];
                        $l4	= explode("/", $v[4]);
        		$loc4	= $cfg["media_files_dir"].'/'.$l4[6].'/'.$l4[7].'/'.$l4[8];
        	    } elseif($cfg["stream_method"] == 2 and $cfg["stream_server"] == 'lighttpd' and $cfg["stream_lighttpd_secure"] == 0){
        		$loc0	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[0]);
        		$loc1	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[1]);
        		$loc2	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[2]);
        		$loc3	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[3]);
                        $loc4	= str_replace($cfg["stream_lighttpd_url"], $cfg["media_files_dir"], $v[4]);
        	    } else {
        		$loc0	= str_replace($url, $cfg["media_files_dir"], $v[0]);
        		$loc1	= str_replace($url, $cfg["media_files_dir"], $v[1]);
        		$loc2	= str_replace($url, $cfg["media_files_dir"], $v[2]);
        		$loc3	= str_replace($url, $cfg["media_files_dir"], $v[3]);
                        $loc4	= str_replace($url, $cfg["media_files_dir"], $v[4]);

                        $fp = 1;

        		if(($srv->fields["server_type"] == 's3' or $srv->fields["server_type"] == 'ws') and $srv->fields["cf_enabled"] == 1 and $cf_signed_url == 1){
                            if($srv->fields["cf_dist_type"] == 'r' and $fp != ''){
                                $v[0] = strstr($v[0], $usr_key);
                                $v[1] = strstr($v[1], $usr_key);
                                $v[2] = strstr($v[2], $usr_key);
                                $v[3] = strstr($v[3], $usr_key);
                                $v[4] = strstr($v[4], $usr_key);
                            }

                            if($type == 'audio'){
                        	$rtmp           = $srv->fields["cf_enabled"] == 1 ? $class_database->singleFieldValue('db_servers', 'cf_dist_domain', 'server_id', $srv->fields["upload_server"]) : $class_database->singleFieldValue('db_servers', 's3_bucketname', 'server_id', $srv->fields["upload_server"]);

                        	$v[0] = strstr($v[0], $usr_key);
                            }

                            if(($srv->fields["server_type"] == 's3' or $srv->fields["server_type"] == 'ws') and $srv->fields["cf_dist_type"] == 'r'){
                            	$s3_accesskey = $srv->fields["s3_accesskey"];
                            	$s3_secretkey = $srv->fields["s3_secretkey"];
                            	$s3_bucketname = $srv->fields["s3_bucketname"];

                            	$v[0]   = VbeServers::getS3SignedURL($s3_accesskey, $s3_secretkey, $v[0], $s3_bucketname, $cf_signed_expire, $srv->fields["server_type"]);
                            	$v[1]   = VbeServers::getS3SignedURL($s3_accesskey, $s3_secretkey, $v[1], $s3_bucketname, $cf_signed_expire, $srv->fields["server_type"]);
                            	$v[2]   = VbeServers::getS3SignedURL($s3_accesskey, $s3_secretkey, $v[2], $s3_bucketname, $cf_signed_expire, $srv->fields["server_type"]);
                            	$v[3]   = VbeServers::getS3SignedURL($s3_accesskey, $s3_secretkey, $v[3], $s3_bucketname, $cf_signed_expire, $srv->fields["server_type"]);
                            	$v[4]   = VbeServers::getS3SignedURL($s3_accesskey, $s3_secretkey, $v[4], $s3_bucketname, $cf_signed_expire, $srv->fields["server_type"]);
                            } else {
                            	$v[0] = VbeServers::getSignedURL($v[0], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            	$v[1] = VbeServers::getSignedURL($v[1], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            	$v[2] = VbeServers::getSignedURL($v[2], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            	$v[3] = VbeServers::getSignedURL($v[3], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            	$v[4] = VbeServers::getSignedURL($v[4], $cf_signed_expire, $cf_key_pair, $cf_key_file);
                            }
                        }
        	    }
        		    if(is_file($loc0)){
        			$src[] = "{ src: '".$v[0]."', type: '".$type."/mp4', label: '".$k."', res: ".str_replace('p', '', $k)." }";
        		    }
        		    if(is_file($loc1)){
        			$src[] = "{ src: '".$v[1]."', type: '".$type."/".($type == 'audio' ? "mp3" : "webm")."', label: '".$k."', res: ".str_replace('p', '', $k)." }";
        		    }
		}
	    }
	    return implode($src, ',');
	}
    /* Video.js javascript */
    function VJSJS($section, $usr_key='', $file_key='', $is_hd='', $next_file_key='', $next_pl_key=''){
    	global $cfg, $class_filter, $class_database, $language, $db, $smarty;

	$cfg[]           = $class_database->getConfigurations('stream_method,stream_server,stream_lighttpd_key,stream_lighttpd_prefix,stream_lighttpd_url,stream_lighttpd_secure,stream_rtmp_location,conversion_video_previews,conversion_live_previews,conversion_audio_previews');
        $_get		 = $section == 'embed' ? 'vjs_embed' : 'vjs_local';
        $_cfg            = unserialize($class_database->singleFieldValue('db_fileplayers', 'db_config', 'db_name', $_get));
    	
	$p		 = self::playerInit($section);
	$_vid		 = $class_filter->clr_str($_GET["v"]);
	$_id		 = $p[0];
	$_width		 = $p[1];
	$_height	 = $p[2];
	$type		 = isset($_GET["l"]) ? 'l' : (isset($_GET["v"]) ? 'v' : (isset($_GET["i"]) ? 'i' : (isset($_GET["a"]) ? 'a' : (isset($_GET["d"]) ? 'd' : NULL))));
	$backend	 = (isset($_GET["section"]) and $_GET["section"] == 'backend') ? true : false;

	if($usr_key == 'video' or $usr_key == 'live'){
	    $_for	 = 'video';
	    $usr_key	 = '';
	} else $_for	 = NULL;

        $usr_key         = $usr_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-usr")+"' : $usr_key;
        $file_key        = $file_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-key")+"' : $file_key;
        $is_hd           = $is_hd == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-q")+"' : $is_hd;

        $fsrc		 = self::getFileUrl($type, $file_key, $usr_key);
        $file1		 = $fsrc[0];
        $file2		 = $fsrc[1];
        $tbl		 = $fsrc[2];
        $ee		 = $db->execute(sprintf("SELECT `usr_id`, `old_file_key`, `embed_src`, `embed_url`, `has_preview` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $tbl, $file_key));
        $esrc		 = $ee->fields["embed_src"];
        $eurl		 = $ee->fields["embed_url"];
        $hpv		 = $ee->fields["has_preview"];
        $vuid		 = $ee->fields["usr_id"];
        $old		 = $ee->fields["old_file_key"];

        $image          = VGenerate::thumbSigned($tbl, $file_key, $usr_key);

	$flv_dir	 = str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $file1);
	$mp4_dir	 = str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $file2);

        	$is_mobile	= VHref::isMobile();
        	$src	= self::buildVideoJSSources($tbl, $file_key, $usr_key, ($section == 'channel' ? ($_for == 'video' ? 'channel' : 'channel2') : $section));


	    $previews	= (($tbl == 'live' and $cfg["conversion_live_previews"] == 1 and $hpv == 1) or ($tbl == 'video' and $cfg["conversion_video_previews"] == 1 and $hpv == 1) or ($tbl == 'audio' and $cfg["conversion_audio_previews"] == 1 and $hpv == 1)) ? true : false;

	    if (isset($_SESSION["USER_ID"]) and (int) $_SESSION["USER_ID"] > 0) {
	    	if ($vuid > 0) {
	    		if ($vuid == (int) $_SESSION["USER_ID"])
	    			$previews = false;
	    		else {
	    			$ss = $db->execute(sprintf("SELECT `db_id`, `sub_list` FROM `db_subscriptions` WHERE `usr_id`='%s' LIMIT 1;", (int) $_SESSION["USER_ID"]));
	    			if ($ss->fields["db_id"]) {
	    				$subs = unserialize($ss->fields["sub_list"]);
	    				if (in_array($vuid, $subs)) {
	    					$sb = $db->execute(sprintf("SELECT `db_id` FROM `db_subusers` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' LIMIT 1;", (int) $_SESSION["USER_ID"], $vuid, date("Y-m-d H:i:s")));
	    					if ($sb->fields["db_id"] > 0)
	    						$previews = false;
	    					else
	    						$previews = true;
	    				}
	    			}
	    			if ($previews) {
		    			$ts = $db->execute(sprintf("SELECT `db_id` FROM `db_subtemps` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' AND `active`='1' LIMIT 1;", (int) $_SESSION["USER_ID"], $vuid, date("Y-m-d H:i:s")));

		    			if ($ts->fields["db_id"])
		    				$previews = false;
	    			}
	    		}
	    	}
	    } elseif (isset($_GET["section"]) and $_GET["section"] == 'backend' and isset($_GET["pv"])) {
	    	$previews = (bool) $_GET["pv"];
	    }
	    $previews	= !$previews ? ($old == 1 ? true : false) : $previews;

        	if ($is_mobile) {
        		$csql            = sprintf("SELECT
                                                 A.`upload_server`, A.`has_preview`, A.`old_file_key`,
                                                 B.`server_type`, B.`cf_enabled`, B.`cf_signed_url`, B.`cf_signed_expire`, B.`cf_key_pair`, B.`cf_key_file`,
                                                 B.`s3_bucketname`, B.`s3_accesskey`, B.`s3_secretkey`, B.`cf_dist_type`
                                                 FROM
                                                 `db_%sfiles` A, `db_servers` B
                                                 WHERE
                                                 A.`file_key`='%s' AND
                                                 A.`upload_server`>'0' AND
                                                 A.`upload_server`=B.`server_id`
                                                 LIMIT 1", $tbl, $file_key);
        		$cf              = $db->execute($csql);
        		
        		if ($cf->fields["upload_server"] > 0) {
        		$server_type    = $cf->fields["server_type"];
        		$cf_enabled     = $cf->fields["cf_enabled"];
        		$cf_signed_url  = $cf->fields["cf_signed_url"];
        		$cf_signed_expire = $cf->fields["cf_signed_expire"];
        		$cf_key_pair    = $cf->fields["cf_key_pair"];
        		$cf_key_file    = $cf->fields["cf_key_file"];
        		$s3_bucket      = $cf->fields["s3_bucketname"];
        		$aws_access_key_id = $cf->fields["s3_accesskey"];
        		$aws_secret_key = $cf->fields["s3_secretkey"];
        		$dist_type      = $cf->fields["cf_dist_type"];
        		$old		= $cf->fields["old_file_key"];
        		$hpv		= $cf->fields["has_preview"];
        		} else {
        		$cc		= $db->execute(sprintf("SELECT `old_file_key`, `has_preview` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $tbl, $file_key));
        		$old	= $cc->fields["old_file_key"];
        		$hpv	= $cc->fields["has_preview"];
        		}

		    	$fk		= $previews ? $file_key : md5($cfg["global_salt_key"].$file_key);

        		$type_ext	= $tbl[0] == 'a' ? 'mp4' : 'mob.mp4';
        		$a_url          = VGenerate::fileURL($tbl, $file_key, 'upload').'/'.$usr_key.'/'.$tbl[0].'/'.$fk.'.'.$type_ext;
        
        		if(($server_type == 's3' or $server_type == 'ws') and $cf_enabled == 1 and $cf_signed_url == 1){
            			$file_path  = $usr_key.'/'.$type[0].'/'.$fk.'.'.$type_ext;
        
            			if(($server_type == 's3' or $server_type == 'ws') and $dist_type == 'r'){
                			$a_url   = VbeServers::getS3SignedURL($aws_access_key_id, $aws_secret_key, $file_path, $s3_bucket, $cf_signed_expire, $server_type);
            			} else {
                			$a_url   = VbeServers::getSignedURL($a_url, $cf_signed_expire, $cf_key_pair, $cf_key_file);
            			}
        		}

        		$src	= sprintf("{ src: '%s', type: 'video/mp4', label: '360p' }", $a_url);
        		$ad_client = $smarty->getTemplateVars('ad_client');

        		if ($esrc == 'local' and $_cfg["vjs_advertising"] == 1 and $ad_client == 'ima') {
        			$mob_src = "_src = '".$a_url."';";
        			//return "_src = '".$a_url."';";
        		}
        	}

        $load_preview = $previews;
        $hls = false;
        $js = '';

        if ($tbl == 'live') {
        	$sl = $db->execute(sprintf("SELECT `vod_server`, `stream_key`, `file_name`, `stream_vod`, `stream_live` FROM `db_livefiles` WHERE `file_key`='%s' LIMIT 1;", $file_key));
        	$sk = $sl->fields["stream_key"];
        	$fn = $sl->fields["file_name"];
        	$srv = $sl->fields["vod_server"];

        	if ($srv > 0 and $sl->fields["stream_live"] == 0) {//get vod server
        		$_rs = $db->execute(sprintf("SELECT `srv_host`, `srv_port`, `srv_https` FROM `db_liveservers` WHERE `srv_type`='vod' AND `srv_id`='%s' AND `srv_active`='1' LIMIT 1;", $srv));
        		if ($_rs->fields["srv_host"])
        			$cfg["live_vod_server"] = sprintf("%s://%s:%s/vod", ($_rs->fields["srv_https"] == 1 ? 'https' : 'http'), $_rs->fields["srv_host"], $_rs->fields["srv_port"]);
        		else {
        			$_rs = $db->execute(sprintf("SELECT `srv_host`, `srv_port`, `srv_https` FROM `db_liveservers` WHERE `srv_type`='vod' AND `srv_active`='1' ORDER BY RAND() LIMIT 1;"));

        			$cfg["live_vod_server"] = sprintf("%s://%s:%s/vod", ($_rs->fields["srv_https"] == 1 ? 'https' : 'http'), $_rs->fields["srv_host"], $_rs->fields["srv_port"]);
        		}
        	} elseif ($sl->fields["stream_live"] == 1) {//load balancer login here
        		$_rs = $db->execute(sprintf("SELECT `srv_host`, `srv_port`, `srv_https` FROM `db_liveservers` WHERE `srv_type`='lbs' AND `srv_active`='1' ORDER BY RAND() LIMIT 1;", $srv));
        		if ($_rs->fields["srv_host"]) {//get a free server
        			$lbs = sprintf("%s://%s:%s", ($_rs->fields["srv_https"] == 1 ? 'https' : 'http'), $_rs->fields["srv_host"], $_rs->fields["srv_port"]);

        			$vs = json_decode(VServer::curl_tt($lbs."/freeserver"));
        			$cfg["live_hls_server"] = sprintf("%s://%s:%s/hls", $vs->protocol, $vs->ip, $vs->port);
        		} else {//load a random server
        			$_rs = $db->execute(sprintf("SELECT `srv_host`, `srv_port`, `srv_https` FROM `db_liveservers` WHERE `srv_type`='stream' AND `srv_active`='1' ORDER BY RAND() LIMIT 1;"));

        			$cfg["live_hls_server"] = sprintf("%s://%s:%s/hls", ($_rs->fields["srv_https"] == 1 ? 'https' : 'http'), $_rs->fields["srv_host"], $_rs->fields["srv_port"]);
        		}
        	}

        	if ($sl->fields["stream_live"] == 0 and $sl->fields["stream_vod"] == 1 and $load_preview) {
        		$_f = explode("-", $fn);
        		$_ff = str_replace('out', 'p', $_f[1]);
        		$pn = $_f[0] . $_ff . '.mp4';

        		$hls = "'sources': [{'type':'video/mp4', 'src':'".$cfg["live_vod_server"]."/".$pn."'}],";
        		if ($mob_src != '')
        			return $mob_src = "_src = '".$cfg["live_vod_server"]."/".$pn."';";
        	} else if ($sl->fields["stream_live"] == 0 and $sl->fields["stream_vod"] == 1 and !$load_preview) {
        		$hls = "'sources': [{'type':'video/mp4', 'src':'".$cfg["live_vod_server"]."/".$fn.".mp4'}],";
        		if ($mob_src != '')
        			return $mob_src = "_src = '".$cfg["live_vod_server"]."/".$fn.".mp4';";
        	} else if ($sl->fields["stream_live"] == 1) {
        		$hls = "'sources': [{'type':'application/x-mpegURL', 'src':'".$cfg["live_hls_server"]."/".$sk."/index.m3u8'}],";
        		if ($mob_src != '')
        			return $mob_src = "_src = '".$cfg["live_hls_server"]."/".$sk."/index.m3u8';";
        	}
        }

	$colors		 = array('cyan' => '#00997a', 'default' => '#06a2cb', 'green' => '#199900', 'orange' => '#f28410', 'pink' => '#ec7ab9', 'purple' => '#b25c8b', 'red' => '#dd1e2f');
	$ccode		 = '#06a2cb';
	foreach ($colors as $cn => $cc) {
		if (strpos($cfg["theme_name"], $cn) !== false) {
			$ccode = $cc;
		}
	}
/*
    	$js		.= "
    	var player = videojs('view-player-".$file_key."', {
    						'html5':{'hlsjsConfig':{'debug': false}},
    						'controls': ".($_cfg['vjs_layout_controls'] == 1 ? 'true' : 'false').",
    						'autoplay': false,
    						'loop': ".($_cfg['vjs_loop'] == 1 ? 'true' : 'false').",
    						'muted': ".($_cfg['vjs_muted'] == 1 ? 'true' : 'false').",
    						'playbackRates': [0.5, 1, 1.5, 2],
    						".$hls."
    						".($esrc != 'local' ? "'techOrder': ['".$esrc."']," : null)."
    						".($esrc != 'local' ? "'sources': [{ 'type': 'video/".$esrc."', 'src': '".$eurl."' }], '".$esrc."': { 'ytcontrols': 1 }," : null)."
    						'plugins': {
    							'videoJsResolutionSwitcher': {
    								'default': 'high','dynamicLabel': true
    							},
    							'watermark': {
    								'image': '".$_cfg['vjs_logo_file']."',
    								'url': '".($section == 'embed' ? $cfg["main_url"].'/'.VGenerate::fileHref($tbl[0], $file_key, $title) : $_cfg['vjs_logo_url'])."',
    								'position': '".$_cfg['vjs_logo_position']."',
    								'fadeTime': '".$_cfg['vjs_logo_fade']."'
    							}
    						}
    					}, function() {
    						var ht = '<svg onclick=\"player.play()\" version=\"1.1\" id=\"play\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" height=\"100px\" width=\"100px\" viewBox=\"0 0 100 100\" enable-background=\"new 0 0 100 100\" xml:space=\"preserve\"><path class=\"stroke-solid\" fill=\"none\" stroke=\"grey\"  d=\"M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7C97.3,23.7,75.7,2.3,49.9,2.5\"/><path class=\"stroke-dotted\" fill=\"none\" stroke=\"".$ccode."\"  d=\"M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7C97.3,23.7,75.7,2.3,49.9,2.5\"/><path class=\"icon\" fill=\"".$ccode."\" d=\"M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z\"/></svg>';
                                                $(ht).insertAfter('.vjs-loading-spinner');
                                                var ht2=$('.pv-text');$(ht2).insertBefore('.vjs-control-bar').show();
    						".(!$hls ? ($esrc == 'local' ? "var player = this; window.player = player; player.updateSrc([".$src."]);" : "var player = this; player.on('resolutionchange', function(){})") : null)."
    					});";
*/
    	$js		.= "var player = videojs('view-player-".$file_key."', {'html5':{'hlsjsConfig':{'debug': false}},'controls': ".($_cfg['vjs_layout_controls'] == 1 ? 'true' : 'false').",'autoplay': ".((isset($_GET["p"]) or $_cfg['vjs_autostart'] == 1) ? 'true' : 'false').",'loop': ".($_cfg['vjs_loop'] == 1 ? 'true' : 'false').",'muted': ".($_cfg['vjs_muted'] == 1 ? 'true' : 'false').",'playbackRates': [0.5, 1, 1.5, 2],".$hls."".($esrc != 'local' ? "'techOrder': ['".$esrc."']," : null)."".($esrc != 'local' ? "'sources': [{ 'type': 'video/".$esrc."', 'src': '".$eurl."' }], '".$esrc."': { 'ytcontrols': 1 }," : null)."'plugins': {'videoJsResolutionSwitcher': {'default': 'high','dynamicLabel': true},'watermark': {'image': '".$_cfg['vjs_logo_file']."','url': '".($section == 'embed' ? $cfg["main_url"].'/'.VGenerate::fileHref($tbl[0], $file_key, $title) : $_cfg['vjs_logo_url'])."','position': '".$_cfg['vjs_logo_position']."','fadeTime': '".$_cfg['vjs_logo_fade']."'}}}, function() {var ht = '<svg onclick=\"player.play()\" version=\"1.1\" id=\"play\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" height=\"100px\" width=\"100px\" viewBox=\"0 0 100 100\" enable-background=\"new 0 0 100 100\" xml:space=\"preserve\"><path class=\"stroke-solid\" fill=\"none\" stroke=\"grey\"  d=\"M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7C97.3,23.7,75.7,2.3,49.9,2.5\"/><path class=\"stroke-dotted\" fill=\"none\" stroke=\"".$ccode."\"  d=\"M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7C97.3,23.7,75.7,2.3,49.9,2.5\"/><path class=\"icon\" fill=\"".$ccode."\" d=\"M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z\"/></svg>';$(ht).insertAfter('.vjs-loading-spinner');var ht2=$('.pv-text');$(ht2).insertBefore('.vjs-control-bar').show();".(!$hls ? ($esrc == 'local' ? "var player = this; window.player = player;".(($tbl == 'video' or !$is_mobile) ? "player.updateSrc([".$src."]);" : "") : "var player = this; player.on('resolutionchange', function(){})") : null)."});";
    	$js		.= "player.poster('".$image."');player.contextmenuUI({content: [".($_cfg['vjs_rc_text1'] != '' ? "{href: '".$_cfg['vjs_rc_link1']."',label: '".$_cfg['vjs_rc_text1']."'}," : null)."".($_cfg['vjs_rc_text2'] != '' ? "{href: '".$_cfg['vjs_rc_link2']."',label: '".$_cfg['vjs_rc_text2']."'}," : null)."".($_cfg['vjs_rc_text3'] != '' ? "{href: '".$_cfg['vjs_rc_link3']."',label: '".$_cfg['vjs_rc_text3']."'}," : null)."".($_cfg['vjs_rc_text4'] != '' ? "{href: '".$_cfg['vjs_rc_link4']."',label: '".$_cfg['vjs_rc_text4']."'}," : null)."".($_cfg['vjs_rc_text5'] != '' ? "{href: '".$_cfg['vjs_rc_link5']."',label: '".$_cfg['vjs_rc_text5']."'}" : null)."]});".(($_cfg["vjs_related"] == 1 and !$backend) ? "player.suggestedVideoEndcap({header: '".str_replace('##TYPE##', $language["frontend.global.".$tbl[0].".p.c"], $language["view.files.related.alt"])."',suggestions: getSuggested()});" : null)."".(((($load_preview or $pp->fields["old_file_key"] == 1) and file_exists($cfg['media_files_dir']."/".$usr_key."/t/".$file_key."/p/thumbnails.vtt")) or (!$load_preview and file_exists($cfg['media_files_dir']."/".$usr_key."/t/".$file_key."/p/".md5($cfg["global_salt_key"].$file_key)."/thumbnails.vtt"))) ? "player.on('loadedmetadata', function() { ".((isset($_GET["p"]) or $_cfg['vjs_autostart'] == 1) ? "player.play();" : null)."player.thumbnails({'width': '140','height': '105','basePath': '".$cfg['media_files_url']."/".$usr_key."/t/".$file_key."/p/".((!$load_preview and $pp->fields["old_file_key"] == 0) ? md5($cfg["global_salt_key"].$file_key)."/" : null)."'});});" : null)."player.on('ended', function() {".($next_file_key != '' ? "document.location = '".$cfg["main_url"].'/'.VGenerate::fileHref(($_GET["v"] != '' ? 'v' : 'a'), $next_file_key, '').'&p='.$next_pl_key."';" : "if($('input[name=autoplay_switch_check]').is(':checked')){u = $('.vs-column.full-thumbs.first-entry .full-details-holder a').attr('href');if (typeof u == 'undefined') {u = $('.suggested-list li:first.vs-column.thirds figcaption a').attr('href');}document.location = u;}")."});".($_cfg['vjs_autostart'] == 1 ? "$(document).ready(function(){ setTimeout(function(){ $('.vjs-big-play-button').click() }, 100); });" : null)."function getSuggested() {if (typeof($('.related-column .suggested-list li:first').html()) == 'undefined') {return [];}a = '[';$('.related-column .suggested-list li').each(function() {t = $(this);title = t.find('.mediaThumb').attr('alt').replace(/\|/g, '').replace(/\"/g, '\'');url = t.find('.full-details-holder h3 a').attr('href');image = t.find('.mediaThumb.loaded').attr('src');if (typeof image == 'undefined') {image = t.find('.mediaThumb').attr('data-src');}a += '{ \"title\": \"'+title+'\", \"url\": \"'+url+'\", \"image\": \"'+image+'\", \"target\": \"_self\" },';});a = a.substring(0, a.length-1);a += ']';return JSON.parse(a);}";
    	//$js		.= ($tbl == 'live' and $sl->fields["stream_live"] == 1) ? 'player.on("timeupdate", function(){if(player.currentTime()>2&&player.currentTime()<3){ $.ajax({type:"GET",url:"'.$cfg["main_url"].'/'.VHref::getKey("viewers").'?s='.$file_key.'",async:false,data:{}}).done(function(data){})}});' : null;

	if ($tbl == 'audio' and $is_mobile) {
		$js	.= '$("#view-player-'.$file_key.' audio").attr("src", "'.str_replace('.mp4', '.mp3', $a_url).'");';
	}

    	if ($is_mobile and $esrc == 'local' and $_cfg["vjs_advertising"] == 1 and $ad_client == 'ima') {
        	return $mob_src = "_src = '".$a_url."';";
        }

    	return $js;
    }
    /* JW player javascript */
    function JWJS($section, $usr_key='', $file_key='', $is_hd='', $next_file_key='', $next_pl_key=''){
        global $cfg, $class_filter, $class_database, $language, $db;

        $cfg[]           = $class_database->getConfigurations('stream_method,stream_server,stream_lighttpd_key,stream_lighttpd_prefix,stream_lighttpd_url,stream_lighttpd_secure,stream_rtmp_location');
        $_get		 = $section == 'embed' ? 'jw_embed' : 'jw_local';
        $_cfg            = unserialize($class_database->singleFieldValue('db_fileplayers', 'db_config', 'db_name', $_get));
	$p		 = self::playerInit($section);
	$_vid		 = $class_filter->clr_str($_GET["v"]);
	$_id		 = $p[0];
	$_width		 = $p[1];
	$_height	 = $p[2];
	$type		 = isset($_GET["l"]) ? 'l' : (isset($_GET["v"]) ? 'v' : (isset($_GET["i"]) ? 'i' : (isset($_GET["a"]) ? 'a' : (isset($_GET["d"]) ? 'd' : NULL))));

	if($usr_key == 'video' or $usr_key == 'live'){
	    $_for	 = 'video';
	    $usr_key	 = '';
	} else $_for	 = NULL;

        $usr_key         = $usr_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-usr")+"' : $usr_key;
        $file_key        = $file_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-key")+"' : $file_key;
        $is_hd           = $is_hd == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-q")+"' : $is_hd;

        $fsrc		 = self::getFileUrl($type, $file_key, $usr_key);
        $file1		 = $fsrc[0];
        $file2		 = $fsrc[1];
        $tbl		 = $fsrc[2];

        switch($section){
    	    case "channel":
    	    case "channel_audio":
    		global $ch_cfg;

		$ap      = $ch_cfg["ch_v_autoplay"];
    		$autoplay= $ap == 1 ? 'true' : 'false';
    	    break;
    	    case "backend":
    		$autoplay= 'true';
    	    break;
    	    default:
    		$autoplay= ($next_file_key != '' or ($next_file_key == '' and isset($_GET["p"]))) ? 'true' : ($_cfg["jw_autostart"] == '1' ? 'true' : 'false');
    	    break;
        }

	if($_GET["do"] == 'load-video' or $_GET["do"] == 'load-audio'){
            $tbl         = str_replace('load-', '', $_GET["do"]);
            $file_key    = $class_filter->clr_str($_GET[$tbl[0]]);
        }
        $image          = VGenerate::thumbSigned($tbl, $file_key, $usr_key);

	$flv_dir	 = str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $file1);
	$mp4_dir	 = str_replace($cfg["media_files_url"], $cfg["media_files_dir"], $file2);

	$js	 = 'jwplayer.key="'.$_cfg["jw_license_key"].'";';
        $js	.= '$(document).ready(function(){';
    	$js	.= 'jwplayer("'.$_id.'").setup({';
    	/* general setup, layout and behavior */
	$js	.= '
            	    width: "'.$_width.'",
            	    aspectratio: "16:9",
//                    height: "'.$_height.'",
    		    controls: "'.($_cfg["jw_layout_controls"] == '1' ? 'true' : 'false').'",
    		    skin: "'.$_cfg["jw_skin"].'",
    		    autostart: "'.$autoplay.'",
    		    fallback: "'.($_cfg["jw_fallback"] == '1' ? 'true' : 'false').'",
    		    mute: "'.($_cfg["jw_mute"] == '1' ? 'true' : 'false').'",
    		    primary: "'.$_cfg["jw_primary"].'",
    		    repeat: "'.($_cfg["jw_repeat"] == '1' ? 'true' : 'false').'",
    		    stretching: "'.$_cfg["jw_stretching"].'",
                    flashplayer: "'.$cfg["main_url"].'/f_scripts/shared/jwplayer/jwplayer.flash.swf",
                    startparam: "start",';
        $js	.= $section == 'view' ? 'wmode: "opaque",' : 'wmode: "window",';
        /* logo */
    	$js	.= 'logo: {
    			file: "'.$_cfg["jw_logo_file"].'",
    			link: "'.$_cfg["jw_logo_link"].'",
    			hide: "'.$_cfg["jw_logo_hide"].'",
    			margin: "'.$_cfg["jw_logo_margin"].'",
    			position: "'.$_cfg["jw_logo_position"].'"
    		    },
    		    abouttext: "'.$_cfg["jw_rc_text"].'",
    		    aboutlink: "'.$_cfg["jw_rc_link"].'",';
    	/* advertising plugin */
	if($_cfg["jw_adv_enabled"] == '1' and $section != 'backend' and $section != 'edit'){
	    $js .= 'advertising: { '.self::getVideoAds($file_key).' },';
	}
	/* jw analytics plugin */
	if($_cfg["jw_analytics_enabled"] == '1'){
	    $js	.= 'analytics: {
			cookies: "'.$_cfg["jw_analytics_cookies"].'"
		    },';
	}
	/* google analytics plugin */
	if($_cfg["jw_ga_enabled"] == '1'){
	    $js	.= 'ga: {
			idstring: "'.$_cfg["jw_ga_idstring"].'"
			';
	    $js	.= $_cfg["jw_ga_trackingobject"] != '' ? ', trackingobject: "'.$_cfg["jw_ga_trackingobject"].'"' : NULL;
	    $js	.= '},';
	}
	/* sharing plugin */
	if($_cfg["jw_share_enabled"] == '1'){
	    $ec = '<iframe id="file-embed-'.md5($file_key).'" type="text/html" width="560" height="315" src="'.$cfg["main_url"].'/embed?v='.$file_key.'" frameborder="0" allowfullscreen></iframe>';

	    $js	.= 'sharing: {';
	    $js	.= $_cfg["jw_share_link"] == '1' ? 'link: "'.$cfg["main_url"].'/'.VGenerate::fileHref($type[0], $file_key, $usr_key).'",' : NULL;
	    $js	.= $_cfg["jw_share_code"] == '1' ? 'code: \''.$ec.'\'' : NULL;
	    $js	.= $_cfg["jw_share_head"] != '' ? ', heading: "'.$language[$_cfg["jw_share_head"]].'"' : NULL;
	    $js	.= '},';
	}
	/* captions plugin */
	if($_cfg["jw_captions_enabled"] == '1'){
	    $js .= 'captions: {
		    back: "'.($_cfg["jw_captions_back"] == '1' ? 'true' : 'false').'",
		    color: "'.$_cfg["jw_captions_color"].'"
		    ';
	    $js	.= (intval($_cfg["jw_captions_fontsize"]) > 0) ? ',fontsize: "'.$_cfg["jw_captions_fontsize"].'"' : NULL;
	    $js .= '},';
	}
	/* loading files into a playlist */
        $js	.= 'playlist: [';
        if($section == 'embed' and isset($_GET["p"])){//embedded playlists
    	    $_pl = unserialize($class_database->singleFieldValue('db_'.$tbl.'playlists', 'pl_files', 'pl_key', $class_filter->clr_str($_GET["p"])));
    	    $_js = array();

    	    foreach($_pl as $v){
    		$u               = $db->execute(sprintf("SELECT A.`usr_key`, B.`usr_id` FROM `db_accountuser` A, `db_%sfiles` B WHERE A.`usr_id`=B.`usr_id` AND B.`file_key`='%s' LIMIT 1;", $tbl, $v));
		$usr_key         = $u->fields["usr_key"];
		$image           = VGenerate::thumbSigned($tbl, $v, $usr_key);

    		$fsrc		 = self::getFileUrl($type, $v, $usr_key);
    		$file1		 = $fsrc[0];
	        $file2		 = $fsrc[1];
    		$tbl		 = $fsrc[2];

    		$js	.= '{
        	    image: "'.$image.'",
        	    tracks: '.self::buildFileSubs($v, $section).',
        	    sources: [
        	    '.self::buildFileSources($tbl, $v, $usr_key, 'pl_embed').'
        	    ],';
    		$js	.= 'title: "'.$class_database->singleFieldValue('db_'.$tbl.'files', 'file_title', 'file_key', $v).'"';
    		$js	.= '},';
    	    }
    	    $js	 = substr($js, 0, -1);
    	    $js	.= ']';
    	    $js	.= ', listbar: { position: "right", size: 290 }';
        } else {//default loader
        	$is_mobile	= VHref::isMobile();
        	$src1	= self::buildFileSources($tbl, $file_key, $usr_key, ($section == 'channel' ? ($_for == 'video' ? 'channel' : 'channel2') : $section));
        	
        	if ($is_mobile) {
        		$cf              = $db->execute(sprintf("SELECT
                                                 A.`upload_server`,
                                                 B.`server_type`, B.`cf_enabled`, B.`cf_signed_url`, B.`cf_signed_expire`, B.`cf_key_pair`, B.`cf_key_file`,
                                                 B.`s3_bucketname`, B.`s3_accesskey`, B.`s3_secretkey`, B.`cf_dist_type`
                                                 FROM
                                                 `db_%sfiles` A, `db_servers` B
                                                 WHERE
                                                 A.`file_key`='%s' AND
                                                 A.`upload_server`>'0' AND
                                                 A.`upload_server`=B.`server_id`
                                                 LIMIT 1", $tbl, $file_key));
    
        		$server_type    = $cf->fields["server_type"];
        		$cf_enabled     = $cf->fields["cf_enabled"];
        		$cf_signed_url  = $cf->fields["cf_signed_url"];
        		$cf_signed_expire = $cf->fields["cf_signed_expire"];
        		$cf_key_pair    = $cf->fields["cf_key_pair"];
        		$cf_key_file    = $cf->fields["cf_key_file"];
        		$s3_bucket      = $cf->fields["s3_bucketname"];
        		$aws_access_key_id = $cf->fields["s3_accesskey"];
        		$aws_secret_key = $cf->fields["s3_secretkey"];
        		$dist_type      = $cf->fields["cf_dist_type"];
        		$type_ext	= 'mob.mp4';
        
        		$a_url          = VGenerate::fileURL($tbl, $file_key, 'upload').'/'.$usr_key.'/'.$tbl[0].'/'.$file_key.'.'.$type_ext;
        
        		if(($server_type == 's3' or $server_type == 'ws') and $cf_enabled == 1 and $cf_signed_url == 1){
            			$file_path  = $usr_key.'/'.$type[0].'/'.$file_key.'.'.$type_ext;
        
            			if(($server_type == 's3' or $server_type == 'ws') and $dist_type == 'r'){
                			$a_url   = VbeServers::getS3SignedURL($aws_access_key_id, $aws_secret_key, $file_path, $s3_bucket, $cf_signed_expire, $server_type);
            			} else {
                			$a_url   = VbeServers::getSignedURL($a_url, $cf_signed_expire, $cf_key_pair, $cf_key_file);
            			}
        		}

        		$src1	= '{ file: "'.$a_url.'", label: "mob", mediaid: "'.$file_key.'" }';
        	}
    	    $js	.= '{
        	    image: "'.$image.'",
        	    title: '.($section == 'embed' ? '"'.$class_database->singleFieldValue('db_'.$tbl.'files', 'file_title', 'file_key', $file_key).'"' : ($section == 'channel' ? '$("#lf-title").text()' : '$("h2.ntb:first").text()')).',
        	    tracks: '.self::buildFileSubs($file_key, $section).',
        	    sources: ['.$src1.']
        	    }]';
        }
	if($_cfg["jw_related_enabled"] == '1'){
	    $js	.= ',related: {';
	    $js	.= 'file: "'.$cfg["main_url"].str_replace('MEDIAID', $file_key, $_cfg["jw_related_file"]).'",
		    onclick: "'.$_cfg["jw_related_onclick"].'",
		    oncomplete: "'.($_cfg["jw_related_oncomplete"] == '1' ? 'true' : 'false').'"
		    ';
	    $js	.= $_cfg["jw_related_head"] != '' ? ',heading: "'.$language[$_cfg["jw_related_head"]].'"' : NULL;
	    $js	.= '}';
	}

    	$js	.= '});';
    	
    	if($cf_enabled == 1){
            $js         .= 'jwplayer("'.$_id.'").onError(function(){';
            $js         .= 'jwplayer("'.$_id.'").play();';
            $js         .= '});';
        }
	/* redirect to next video/audio in playlist (view page) */
	if($section == 'view' and $next_file_key != ''){
	    $js		.= 'jwplayer("'.$_id.'").onComplete(function(){';
	    $js		.= 'document.location = "'.$cfg["main_url"].'/'.VGenerate::fileHref(($_GET["v"] != '' ? 'v' : 'a'), $next_file_key, '').'&p='.$next_pl_key.'";';
	    $js		.= '});';
	} elseif ($section == 'view') {
	    $js		.= 'jwplayer("'.$_id.'").onComplete(function(){';
	    $js		.= 'if($("input[name=autoplay_switch_check]").is(":checked")){
	    			u = $(".vs-column.full-thumbs.first-entry .full-details-holder a").attr("href");
	    			if (typeof u == "undefined") {
	    				u = $(".suggested-list li:first.vs-column.thirds figcaption a").attr("href");
	    			}
	    			document.location = u;
	    		}';
	    $js		.= '});';
	}
	/* if there is a next video, load it (channel page) */
	if($section == 'channel' or $section == 'channel_audio'){
    	    $js     	.= 'jwplayer("'.$_id.'").onComplete(function(){';
    	    $js		.= 'if($(".load-all-pl").hasClass("channel-top-navlink-active")){';
    	    $js     	.= intval($_SESSION["USER_ID"]) == 0 ? '$(".thumb-entry-wrap-on").parent().next().children().addClass("thumb-entry-wrap-bg").click().removeClass("thumb-entry-wrap-bg"); jwplayer("'.$_id.'").play();' : NULL;
    	    $js     	.= intval($_SESSION["USER_ID"]) > 0 ? '$(".thumb-entry-wrap-on").parent().next().next().children().addClass("thumb-entry-wrap-bg").click().removeClass("thumb-entry-wrap-bg"); jwplayer("'.$_id.'").play();' : NULL;
    	    $js     	.= '}';
    	    $js     	.= '});';
    	}
        $js	.= '});';

	return $js;
    }
    /* jw file subtitles */
    function buildFileSubs($file_key, $section){
	global $cfg, $class_database, $class_filter;
	
	$type	 = isset($_GET["a"]) ? 'audio' : (isset($_GET["l"]) ? 'live' : 'video');

	$sub_dir = $cfg["main_dir"].'/f_data/data_subtitles/';
	$sub_url = $cfg["main_url"].'/f_data/data_subtitles/';

	$_cfg	 = unserialize($class_database->singleFieldValue('db_fileplayers', 'db_config', 'db_name', 'jw_'.($section == 'embed' ? 'embed' : 'local')));
	$s	 = $class_database->singleFieldValue('db_'.$type.'subs', 'jw_subs', 'file_key', $file_key);

	$js	 = '[';
	if($s != '' and $_cfg["jw_captions_enabled"] == '1'){
	    $ss	 = array();
	    $sub = unserialize($s);
	    $sub_files       = array_values(array_diff(scandir($sub_dir), array('..', '.')));

	    foreach($sub as $s => $v){
		$ss[] = '{"file":"'.self::mdcheck($s, $sub_files).'","label":"'.$v["label"].'","kind":"subtitles"'.($v["default"] == 1 ? ',"default":true' : NULL).'}';
	    }
	    $js	.= (count($ss) > 0) ? implode(',', $ss) : NULL;
	}
	$js	.= ']';

	return $js;
    }
    /* subtitles md5 check */
    function mdcheck($key, $array){
	global $cfg;

	foreach($array as $v){
	    if($key == md5($v)){
		return $cfg["main_url"].'/f_data/data_subtitles/'.$v;
	    }
	}
	return;
    }
    /* streaming settings */
    function vStreaming_url($usr_key, $file_key, $file_url='', $srv='', $url=''){
	global $cfg, $class_database;

	$loc		 = array();
	$cfg[]	 	 = $class_database->getConfigurations('stream_lighttpd_key,stream_lighttpd_prefix,stream_lighttpd_url');
	
	if($srv->fields["lighttpd_url"] != ''){
            $cfg["media_files_url"] = $url;
            $cfg["stream_lighttpd_key"] = $srv->fields["lighttpd_key"];
            $cfg["stream_lighttpd_url"] = $srv->fields["lighttpd_url"];
            $cfg["stream_lighttpd_prefix"] = $srv->fields["lighttpd_prefix"];
        }

        if($file_url[0]){
            foreach($file_url as $v){
                $file    = str_replace($cfg["media_files_url"], '', $v);
                $hex     = sprintf("%08x", time());
                $md      = md5($cfg["stream_lighttpd_key"].$file.$hex).'/'.$hex.$file;
            
                $loc[]   = $cfg["stream_lighttpd_url"].$cfg["stream_lighttpd_prefix"].$md;
            }
        }
        return $loc;
    }
    /* adobe reader pdf embedding */
    function DOCJS($section, $usr_key='', $file_key='', $is_hd='', $next_file_key='', $next_pl_key=''){
        global $cfg, $class_database, $db, $language;
            
        $p       = self::playerInit($section);
        $_id     = $p[0];
        $_w      = $p[1];
        $_h      = $p[2];

	$js	 = '';
	$vuid	 = $class_database->singleFieldValue('db_accountuser', 'usr_id', 'usr_key', $usr_key);
	$hpv	 = $class_database->singleFieldValue('db_docfiles', 'has_preview', 'file_key', $file_key);
	$ofk	 = $class_database->singleFieldValue('db_docfiles', 'old_file_key', 'file_key', $file_key);
        $usr_key = $usr_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-usr")+"' : $usr_key;
        $file_key= $file_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-key")+"' : $file_key;
        $preview = (($hpv == 1 and $cfg["conversion_doc_previews"] == 1) or $ofk) ? true : false;

        if ($preview) {
                                if ($vuid == (int) $_SESSION["USER_ID"]) {
                                        $preview = false;
                                } else {
                                        $ss = $db->execute(sprintf("SELECT `db_id`, `sub_list` FROM `db_subscriptions` WHERE `usr_id`='%s' LIMIT 1;", (int) $_SESSION["USER_ID"]));
                                        if ($ss->fields["db_id"]) {
                                                $subs = unserialize($ss->fields["sub_list"]);
                                                if (in_array($vuid, $subs)) {
                                                        $sq = sprintf("SELECT `db_id` FROM `db_subusers` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' LIMIT 1;", (int) $_SESSION["USER_ID"], $vuid, date("Y-m-d H:i:s"));
                                                        $sb = $db->execute($sq);
                                                        if ($sb->fields["db_id"])
                                                                $preview = false;
                                                }
                                        }
        
                                        if (!$subbed) {
                                                $ts = $db->execute(sprintf("SELECT `db_id` FROM `db_subtemps` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' AND `active`='1' LIMIT 1;", (int) $_SESSION["USER_ID"], $vuid, date("Y-m-d H:i:s")));
        
                                                if ($ts->fields["db_id"]) {
                                                        $preview = false;
                                                }
                                        }
                                }
                        }

                        if (isset($_GET["section"]) and $_GET["section"] == 'backend' and isset($_GET["pv"])) {
                        	$preview = (bool) $_GET["pv"];
                        }
	$gs	 = !$preview ? md5($cfg["global_salt_key"].$file_key) : $file_key;
        $src     = VGenerate::thumbSigned(array("type" => "doc", "server" => "upload", "key" => '/'.$usr_key.'/d/'.$gs.'.pdf'), $gs, $usr_key, 0, 1);

        if (VHref::isMobile()) {
		$js.= "
// If absolute URL from the remote server is provided, configure the CORS
// header on that server.
var url = '".$src."';

// Loaded via <script> tag, create shortcut to access PDF.js exports.
var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = 0.8,
    canvas = document.getElementById('the-canvas'),
    ctx = canvas.getContext('2d');

/**
 * Get page info from document, resize canvas accordingly, and render page.
 * @param num Page number.
 */
function renderPage(num) {
  pageRendering = true;
  // Using promise to fetch the page
  pdfDoc.getPage(num).then(function(page) {
    var viewport = page.getViewport(scale);
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);

    // Wait for rendering to finish
    renderTask.promise.then(function() {
      pageRendering = false;
      if (pageNumPending !== null) {
        // New page rendering is pending
        renderPage(pageNumPending);
        pageNumPending = null;
      }
    });
  });

  // Update page counters
  document.getElementById('page_num').textContent = num;
}

/**
 * If another page rendering in progress, waits until the rendering is
 * finised. Otherwise, executes rendering immediately.
 */
function queueRenderPage(num) {
  if (pageRendering) {
    pageNumPending = num;
  } else {
    renderPage(num);
  }
}

/**
 * Displays previous page.
 */
function onPrevPage() {
  if (pageNum <= 1) {
    return;
  }
  pageNum--;
  queueRenderPage(pageNum);
}
document.getElementById('prev').addEventListener('click', onPrevPage);

/**
 * Displays next page.
 */
function onNextPage() {
  if (pageNum >= pdfDoc.numPages) {
    return;
  }
  pageNum++;
  queueRenderPage(pageNum);
}
document.getElementById('next').addEventListener('click', onNextPage);

/**
 * Asynchronously downloads PDF.
 */
pdfjsLib.getDocument(url).then(function(pdfDoc_) {
  pdfDoc = pdfDoc_;
  document.getElementById('page_count').textContent = pdfDoc.numPages;

  // Initial/first page rendering
  renderPage(pageNum);
});

                ";
                return $js;
        }

        $js     .= '$(document).ready(function(){';
	$js	.= '$("#'.$p[0].'").html(\'<embed src="'.$src.'" width="100%" height="100%">\');';
	
        /* generate embed code */
        if($section == 'view'){
            $js .= 'var embedCode = $("#'.$_id.'").html();';
            $js .= 'embedCode = embedCode.replace(\'width="100%"\', \'width="\'+$(".embed-size-on").attr("rel-w")+\'"\').replace(\'height="100%"\', \'height="\'+$(".embed-size-on").attr("rel-h")+\'"\');';
            $js .= 'embedCode = embedCode.replace(\'<\', \'&lt;\');';
            $js .= 'embedCode = embedCode.replace(\'>\', \'&gt;\');';
            $js .= 'embedCode = embedCode.replace(\'navpanes=1\', \'navpanes=0\');';
            $js .= 'embedCode = embedCode.replace(\'toolbar=1\', \'toolbar=0\');';
            $js .= 'if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){embedCode = embedCode + "&lt;/object&gt;";}';
            $js .= '$("#file-share-embed").html(embedCode);';
        }
        $js     .= '});';

        return $js;
    }
    /* free paper swf embedding */
    function FREEJS($section, $usr_key='', $file_key='', $is_hd='', $next_file_key='', $next_pl_key=''){
        global $cfg, $upage_id;

        $p       = self::playerInit($section);
        $_w      = $p[1];
        $_h      = $p[2];

        $usr_key = $usr_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-usr")+"' : $usr_key;
        $file_key= $file_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-key")+"' : $file_key;

        $swf     = VGenerate::thumbSigned(array("type" => "doc", "server" => "upload", "key" => '/'.$usr_key.'/d/'.$file_key.'.swf'), $file_key, $usr_key, 0, 1);
        $fp      = $cfg["main_url"].'/f_modules/m_frontend/m_player/swf/freepaper.swf';

        $xml_p   = $section == 'channel' ? 'channeltheme'.$upage_id : 'theme';
        $xml_t   = $cfg["main_url"].'/freepaper?t='.$xml_p;
        $xml_l   = $cfg["main_url"].'/freepaper?t=lang';

        $js      = '$(document).ready(function(){';
        $js     .= 'var flashvars = {';
        $js     .= 'xmlDataPath : "'.$xml_t.'",';
        $js     .= 'langDataPath: "'.$xml_l.'",';
        $js     .= 'docURL : "'.$swf.'"';
        $js     .= '};';
        $js     .= 'var params = {';
        $js     .= 'width: "100%",';
        $js     .= 'height: "100%",';
        $js     .= 'scale: "noScale",';
        $js     .= 'allowFullScreen: "true",';
        $js     .= $section == 'backend' ? 'allowScriptAccess: "never",' : NULL;
        $js     .= $section == 'view' ? 'wmode: "opaque"' : 'wmode: "window"';
        $js     .= '};';
        $js     .= 'var attributes = {';
        $js     .= 'altContentId: "'.$p[0].'-doc",';
        $js     .= 'trace: "auto"';
        $js     .= '};';
        $js     .= 'freepaper2Obj.embedDoc(flashvars,params,attributes);';
        $js     .= '});';

	/* generate embed code */
        if($section == 'view'){
            $js .= '$(document).ready(function(){';
            $js .= 'var embedCode = \'&lt;object data="'.$fp.'" name="player'.$file_key.'" id="player'.$file_key.'" trace="auto" type="application/x-shockwave-flash" height="100%" width="100%"&gt;&lt;param name="movie" value="'.$fp.'" /&gt;&lt;param value="100%" name="width"&gt;&lt;param value="100%" name="height" /&gt;&lt;param value="noScale" name="scale" /&gt;&lt;param value="true" name="allowFullScreen" /&gt;&lt;param value="opaque" name="wmode" /&gt;&lt;param value="xmlDataPath='.$xml_t.'&amp;langDataPath='.$xml_l.'&amp;playerId=player'.$file_key.'&amp;swfURL='.$swf.'" name="flashvars" /&gt;&lt;/object&gt;\';';

            $js .= 'embedCode = embedCode.replace(\'width="100%"\', \'width="\'+$(".embed-size-on").attr("rel-w")+\'"\').replace(\'height="100%"\', \'height="\'+$(".embed-size-on").attr("rel-h")+\'"\');';
            $js .= 'embedCode = embedCode.replace(\'value="100%" name="width"\', \'value="\'+$(".embed-size-on").attr("rel-w")+\'" name=\"width\"\').replace(\'value="100%" name="height"\', \'value="\'+$(".embed-size-on").attr("rel-h")+\'" name=\"height\"\');';
            $js .= 'embedCode = embedCode.replace(\'name="width" value="100%"\', \'value="\'+$(".embed-size-on").attr("rel-w")+\'" name=\"width\"\').replace(\'name="height" value="100%"\', \'value="\'+$(".embed-size-on").attr("rel-h")+\'" name=\"height\"\');';

            $js .= 'document.getElementById("file-share-embed").innerHTML = embedCode;';
            $js .= '});';
        }
        
        return $js;
    }
    /* flex paper swf embedding : NOT USED ANYMORE, WILL BE COMPLETELY REMOVED (does not work together with jw and flow on the same page without reloading) */
    function FLEXJS($section, $usr_key='', $file_key='', $is_hd='', $next_file_key='', $next_pl_key=''){
        global $cfg;

        $p       = self::playerInit($section);
        $_w      = $p[1];
        $_h      = $p[2];

        $usr_key = $usr_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-usr")+"' : $usr_key;
        $file_key= $file_key == '' ? '"+$(".thumb-entry-wrap-bg").attr("rel-key")+"' : $file_key;

        $src     = $cfg["media_files_url"].'/'.$usr_key.'/d/'.$file_key.'.swf';
        $swf     = $cfg["main_url"].'/f_modules/m_frontend/m_player/swf/flexpaper';

        $js     .= 'var script=document.createElement("script"); script.type="text/javascript"; script.id="doc-js"; script.src="'.$cfg["javascript_url"].'/flexpaper.flash.js"; $("#player-loader").append(script);';

        $js     .= '$(document).ready(function(){';
        $js     .= 'var fp = new FlexPaperViewer(';
        $js     .= '"'.$swf.'",';
        $js     .= '"'.$p[0].'", { configure : { ';
        $js     .= 'SwfFile : escape("'.$src.'"),';
        $js     .= 'Scale : 0.6,';
        $js     .= 'ZoomTransition : "easeOut",';
        $js     .= 'ZoomTime : 0.5,';
        $js     .= 'ZoomInterval : 0.2,';
        $js     .= 'FitPageOnLoad : true,';
        $js     .= 'FitWidthOnLoad : false,';
        $js     .= 'FullScreenAsMaxWindow : false,';
        $js     .= 'ProgressiveLoading : false,';
        $js     .= 'MinZoomSize : 0.2,';
        $js     .= 'MaxZoomSize : 5,';
        $js     .= 'SearchMatchAll : false,';
        $js     .= 'InitViewMode : "Portrait",';
        $js     .= 'PrintPaperAsBitmap : false,';
        $js     .= 'ViewModeToolsVisible : true,';
        $js     .= 'ZoomToolsVisible : true,';
        $js     .= 'NavToolsVisible : true,';
        $js     .= 'CursorToolsVisible : true,';
        $js     .= 'SearchToolsVisible : true,';
        $js     .= 'localeChain: "en_US"';
        $js     .= '}});';
        $js     .= '});';

        return $js;
    }
    /* js for image viewing and slideshow */
    function imageJS($section, $pl_key=''){
        $js	 = '$(document).ready(function(){ $(".fancybox").fancybox({margin: 20}); $.fancybox.open({ minWidth: "70%", minHeight: "80%", margin: 20 }); });';

        return $js;
    }
}

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
define('_ISADMIN', true);

$main_dir 	 = realpath(dirname(__FILE__).'/../../../');
set_include_path($main_dir);

include_once 'f_core/config.core.php';

include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('backend', 'language.players');

$cfg[]           = $class_database->getConfigurations('stream_method,stream_server,stream_lighttpd_key,stream_lighttpd_prefix,stream_lighttpd_url,stream_lighttpd_secure,stream_rtmp_location');

$player          = $_GET["i"] == '' ? 'local' : 'embed';
$_cfg            = unserialize($class_database->singleFieldValue('db_fileplayers', 'db_config', 'db_name', 'flow_'.$player));

switch($player){
    case "local":
	$usr_key         = $class_filter->clr_str($_GET["a"]);
	$file_key	 = $class_filter->clr_str($_GET["b"]);
	$section	 = $class_filter->clr_str($_GET["c"]);
	$is_hd	 	 = intval($_GET["d"]);
	$ap	 	 = $class_filter->clr_str($_GET["e"]);
	$autoplay	 = $ap == 'enabled' ? 'true' : 'false';
	$type		 = $class_filter->clr_str($_GET["f"]);
	$next_file_key	 = $class_filter->clr_str($_GET["g"]);
	$next_file_key	 = $next_file_key == 'undefined' ? '' : $next_file_key;
	$next_pl_key	 = $class_filter->clr_str($_GET["h"]);
    break;
    case "embed":
	$str	 	= $class_filter->clr_str($_GET["i"]);
	$usr_key 	= substr($str, 0, 12);
	$file_key	= substr($str, 12, 16);
	$section 	= 'view';
	$is_hd	 	= 0;
	$type	 	= substr($str, -1);
	$ap		= $_cfg["flow_autoplay"];
	$autoplay	= $ap == 'enabled' ? 'true' : 'false';
    break;
}
$p               = VPlayers::playerInit($section);
$_vid            = $type == 'v' ? 1 : NULL;
$_img            = $type == 'i' ? 1 : NULL;
$_aud            = $type == 'a' ? 1 : NULL;
$_id             = $p[0];
$_width          = $p[1];
$_height         = $p[2];

foreach($_cfg as $k => $v){
    if($v == 'enabled'){
	$_cfg[$k] = 'true';
    }
    if($v == 'disabled'){
	$_cfg[$k] = 'false';
    }
}


	echo $player == 'local' ? 'var is_hd = "'.$is_hd.'"; var next_pl_key = "'.$next_pl_key.'"; var is_img = "'.$_img.'"; var is_aud = "'.$_aud.'"; var img_pl = "'.$cfg["image_player"].'";' : NULL;

	echo $player == 'local' ? 'var conf = {' : '{';

	if($_cfg["flow_key"] != ''){
	    echo '"license": "'.$_cfg["flow_key"].'",';
	}
	if($_cfg["flow_logo_url"] != ''){
	    echo '"logo": {';
	    echo '"url": "'.$_cfg["flow_logo_url"].'",';
	    echo '"fullscreenOnly": false, ';
	    echo '"top": "'.$_cfg["flow_logo_top"].'",';
	    echo '"left": "'.$_cfg["flow_logo_left"].'",';
	    echo '"bottom": "'.$_cfg["flow_logo_bottom"].'",';
	    echo '"right": "'.$_cfg["flow_logo_right"].'"';
	    echo '},';
	}
	echo '"clip": {';//begin clip property
	/* pseudostreaming */
	echo ($section != 'channel_audio' and (($_vid != '' or $_for == 'video') and $cfg["stream_method"] == 2)) ? '"provider": "'.($cfg["stream_server"] == 'apache' ? 'pseudo' : 'lighttpd').'"'.($player == 'local' ? ',' : NULL) : NULL;

	if($_aud != '' or $section == 'channel_audio'){//audio configuration
	}else{
	    switch($cfg["stream_method"]){
		case "":
		case "0":
		case "1":
		    $flv_url	 = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.flv';
		    $mp4_url	 = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
		break;
		case "2":
		    if($cfg["stream_server"] == 'lighttpd'){
			if($cfg["stream_lighttpd_secure"] == 1){
			    $_file_url	 = VPlayers::vStreaming_url($usr_key, $file_key);
			    $flv_url	 = $_file_url[0];
			    $mp4_url	 = $_file_url[1];
			} else {
			    $flv_url	 = $cfg["stream_lighttpd_url"].'/f_data/data_userfiles/user_media/'.$usr_key.'/v/'.$file_key.'.flv';
			    $mp4_url	 = $cfg["stream_lighttpd_url"].'/f_data/data_userfiles/user_media/'.$usr_key.'/v/'.$file_key.'.mp4';
			}
		    } else {
			$flv_url	 = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.flv';
			$mp4_url	 = $cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
		    }
		break;
		case "3":
		    $flv_url		 = $cfg["stream_rtmp_location"].'/'.$usr_key.'/v/'.$file_key.'.flv';
		    $mp4_url		 = $cfg["stream_rtmp_location"].'/'.$usr_key.'/v/'.$file_key.'.mp4';
		break;
	    }

	    $mp3_url	 = $cfg["media_files_url"].'/'.$usr_key.'/a/'.$file_key.'.mp3';
	    $tmb_url	 = $cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg';

	if($player == 'local'){
	    echo '"bitrates": [';
	    echo '{ "url": ((is_img == "" && is_hd != "i" && is_hd != "a") ? (("'.$cfg["stream_server"].'" == "lighttpd" && "'.$_for.'" == "video" && "'.$cfg["stream_lighttpd_secure"].'" == "1") ? vStreaming_url("'.$usr_key.'", "'.$file_key.'", 1) : "'.$flv_url.'") : (is_hd == "a" ? "'.$mp3_url.'"  : "'.$tmb_url.'")), bitrate: 800, sd: true }';
	    echo $is_hd == 1 ? ',{ "url": (is_hd == "1" ? (("'.$cfg["stream_server"].'" == "lighttpd" && "'.$_for.'" == "video" && "'.$cfg["stream_lighttpd_secure"].'" == "1") ? vStreaming_url("'.$usr_key.'", "'.$file_key.'", 2) : "'.$mp4_url.'") : ""), bitrate: 1600, hd: true }' : NULL;
	    echo ']';
	}
	}
	echo '}';//end "clip" property

if(($_vid != '' or $_img != '') and $section != 'channel_audio'){
	/* playlist */
	echo ', "playlist": [';//begin playlist
	if($_aud == '' and $section != 'channel_audio'){//no playlist splash image for audio
	    echo '{';//begin first playlist entry (splash image)
	    echo '"url": "'.$cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg?t='.rand(0, 9999).'"';
	    echo ', "scaling": "'.$_cfg["flow_scaling"].'"';
	    echo ', "autoPlay": true';
	    echo '},';//end first playlist entry (splash image)
	}
	echo '{';//begin playing file entry
	echo '"autoPlay": '.$autoplay.',';
//	echo '"autoBuffering": '.$_cfg["flow_autobuffering"].',';
	echo '"bufferLength": '.$_cfg["flow_bufferlength"].',';
	echo '"scaling": "'.$_cfg["flow_scaling"].'",';

	if($player == 'local' and ($_img != '' or $section == 'channel')){
	    echo '"duration": (((is_img != "" || $("#active-sort").val() == "sort-image") || (is_hd == "i")) ? 7 : 0),';//duration for playing images only, 7 seconds
	} elseif($player == 'embed' and $type == 'i'){
	    echo '"duration": 7,';
	}

	if($player == 'local'){
	    echo '"url": ((is_img == "" && is_aud == "" && is_hd != "i" && is_hd != "a") ? "'.$cfg["media_files_url"].'/'.$usr_key.'/v/'.$file_key.'.flv" : ((is_hd == "a" || is_aud != "") ? "'.$cfg["media_files_url"].'/'.$usr_key.'/a/'.$file_key.'.mp3" : "'.$cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg"))';
	} else {
	    echo '"url": "'.$cfg["media_files_url"].'/'.$usr_key.'/'.$type.'/'.$file_key.'.'.($type == 'v' ? 'flv' : ($type == 'i' ? 'jpg' : ($type == 'a' ? 'mp3' : NULL))).'"';
	}

	/* redirect to next video in playlist (view page) */
	if($section == 'view' and $next_file_key != ''){
	    echo ', "onFinish": function(clip){document.location = "'.$cfg["main_url"].'/'.VGenerate::fileHref((($_img == '' and $_aud == '') ? 'v' : ($_aud != '' ? 'a' : 'i')), $next_file_key, '').'&p='.$next_pl_key.'";}';
	}
	/* if there is a next video, load it (channel page) */
	if($section == 'channel' or $section == 'channel_audio'){
	    echo ', "onFinish": function(clip){';
	    echo 'if(typeof($(".thumb-entry-wrap-on").attr("rel-next")) != "undefined"){';
    	    echo (intval($_SESSION["USER_ID"]) == 0 ? '$(".thumb-entry-wrap-on").parent().next().children().addClass("thumb-entry-wrap-bg thumb-entry-wrap-on").click().removeClass("thumb-entry-wrap-bg");' : NULL);
    	    echo (intval($_SESSION["USER_ID"]) > 0 ? '$(".thumb-entry-wrap-on").parent().next().next().children().addClass("thumb-entry-wrap-bg thumb-entry-wrap-on").click().removeClass("thumb-entry-wrap-bg");' : NULL);
	    echo '}';
	    echo '}';
    	}
	echo '}';//end playing file entry
	echo ']';//end playlist
} else {
	if($_aud != '' or $section == 'channel_audio'){//audio configuration
	    echo ', "playlist": [';
	    if($player == 'local' and $next_file_key == ''){
		echo '{';//begin first playlist entry (splash image)
		echo '"url": "'.$cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg?t='.rand(0, 9999).'"';
		echo ', "scaling": "'.$_cfg["flow_scaling"].'"';
		echo ', "autoPlay": true';
		echo '},';//end first playlist entry (splash image)
	    }

	    echo '{';
	    echo '"url": "'.$cfg["media_files_url"].'/'.$usr_key.'/a/'.$file_key.'.mp3",';
	    echo '"coverImage": { "url": "'.$cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg?t='.rand(0, 9999).'" }, ';
	    echo '"autoPlay": '.$autoplay.',';
//	    echo '"autoBuffering": '.$_cfg["flow_autobuffering"].',';
	    echo '"bufferLength": '.$_cfg["flow_bufferlength"].',';
	    echo '"scaling": "'.$_cfg["flow_scaling"].'"';
	    echo '}';
	    echo ']';//end playlist
	}

	/* redirect to next video in playlist (view page) */
	if($section == 'view' and $next_file_key != ''){
	    echo ', "onFinish": function(clip){document.location = "'.$cfg["main_url"].'/'.VGenerate::fileHref((($_img == '' and $_aud == '') ? 'v' : ($_aud != '' ? 'a' : 'i')), $next_file_key, '').'&p='.$next_pl_key.'";}';
	}
	/* if there is a next video, load it (channel page) */
	if($section == 'channel' or $section == 'channel_audio'){
	    echo ', "onFinish": function(clip){';
	    echo 'if(typeof($(".thumb-entry-wrap-on").attr("rel-next")) != "undefined"){';
    	    echo (intval($_SESSION["USER_ID"]) == 0 ? '$(".thumb-entry-wrap-on").parent().next().children().addClass("thumb-entry-wrap-bg thumb-entry-wrap-on").click().removeClass("thumb-entry-wrap-bg");' : NULL);
    	    echo (intval($_SESSION["USER_ID"]) > 0 ? '$(".thumb-entry-wrap-on").parent().next().next().children().addClass("thumb-entry-wrap-bg thumb-entry-wrap-on").click().removeClass("thumb-entry-wrap-bg");' : NULL);
	    echo '}';
	    echo '}';
    	}
}
	/* plugins */
	    echo ',"canvas": {';
	    echo '"backgroundColor": "#'.$_cfg["flow_canvas_bgcol"].'",';
	    echo '"backgroundGradient": "#'.$_cfg["flow_canvas_bg_gr"].'"';
	    echo '}';

	if($section == ''){
	    echo ', play: {opacity: 0.0}';
	}
	echo ', "plugins": {';//begin plugins
	if($section == 'main'){
	    echo 'controls: null';
	} else {
	    echo '"controls": {';
	    echo '"url": "flowplayer.controls.swf",';
	    echo '"autoHide": { "enabled": false },';
	    echo '"backgroundColor": "#'.$_cfg["flow_control_bgcol"].'",';
	    echo '"backgroundGradient": "'.$_cfg["flow_control_bg_gr"].'",';
	    echo '"buttonColor": "#'.$_cfg["flow_control_button"].'",';
	    echo '"buttonOverColor": "#'.$_cfg["flow_control_button_over"].'",';
	    echo '"bufferColor": "#'.$_cfg["flow_control_bufcol"].'",';
	    echo '"bufferGradient": "'.$_cfg["flow_control_buf_gr"].'",';
	    echo '"timeColor": "#'.$_cfg["flow_control_timecol"].'",';
	    echo '"timeBgColor": "#'.$_cfg["flow_control_time_bgcol"].'",';
	    echo '"durationColor": "#'.$_cfg["flow_control_duration"].'",';
	    echo '"sliderColor": "#'.$_cfg["flow_control_slidecol"].'",';
	    echo '"sliderGradient": "'.$_cfg["flow_control_slide_gr"].'",';
	    echo '"progressColor": "#'.$_cfg["flow_control_prcol"].'",';
	    echo '"progressGradient": "'.$_cfg["flow_control_pr_gr"].'",';
	    echo '"volumeSliderColor": "#'.$_cfg["flow_control_volcol"].'",';
	    echo '"volumeSliderGradient": "'.$_cfg["flow_control_vol_gr"].'",';
	    echo '"borderRadius": "'.$_cfg["flow_control_border"].'px",';
	    echo '"tooltipColor": "#'.$_cfg["flow_control_tooltipcol"].'",';
	    echo '"tooltipTextColor": "#'.$_cfg["flow_control_tooltiptext"].'",';
	    echo '"height": '.$_cfg["flow_control_height"].',';
	    echo '"opacity": 1.0,';
	    echo '"play": '.$_cfg["flow_btn_play"].',';
	    echo '"volume": '.$_cfg["flow_btn_volume"].',';
	    echo '"mute": '.$_cfg["flow_btn_mute"].',';
	    echo '"time": '.$_cfg["flow_time"].',';
	    echo '"stop": '.$_cfg["flow_btn_stop"].',';
	    echo '"fullscreen": '.$_cfg["flow_btn_fullscreen"].',';
	    echo '"tooltips": {';
	    if($_cfg["flow_btn_tooltips"] == 'true'){
		echo '"buttons": true,';
		echo '"play": "'.$language["backend.player.flow.tips.play"].'",';
		echo '"pause": "'.$language["backend.player.flow.tips.pause"].'",';
		echo '"stop": "'.$language["backend.player.flow.tips.stop"].'",';
		echo '"mute": "'.$language["backend.player.flow.tips.mute"].'",';
		echo '"unmute": "'.$language["backend.player.flow.tips.unmute"].'",';
		echo '"fullscreen": "'.$language["backend.player.flow.tips.fs"].'",';
		echo '"fullscreenExit": "'.$language["backend.player.flow.tips.fs.exit"].'",';
		echo '"next": "'.$language["backend.player.flow.tips.next"].'",';
		echo '"previous": "'.$language["backend.player.flow.tips.prev"].'"';
	    } else {
		echo '"buttons": false';
	    }
	    echo '}';
	    echo '}';
	}
	if($section != 'channel_audio' and ($_vid != '' or $_for == 'video')){
	    if($is_hd == 1){
		echo ', "bitrateselect": {';//begin sd/hd switch
		echo '"url": "flowplayer.bitrateselect.swf",';
		echo '"hdButton": {';
		echo '"place": (is_hd == "1" ? "dock" : "none"),';
		echo '"splash": {"width": "13%", "height": "13%", "onLabel": "'.$language["frontend.global.enabled"].'", "offLabel": "'.$language["frontend.global.disabled"].'"}';
		echo '}';
		echo '} ';//end sd/hd switch
	    }
	    /* pseudostreaming */
	    if($section != 'channel_audio' and (($_vid != '' or $_for == 'video') and $cfg["stream_method"] == 2)){
		echo ', '.($cfg["stream_server"] == 'apache' ? '"pseudo"' : '"lighttpd"').': {';
		echo '"url": "flowplayer.pseudostreaming.swf"';
		echo '}';
	    }
	}
	    echo '}';//end plugins

	/* load homepage file details */
	if($section == 'main'){
	    echo ', "onLoad": function(){
				$(".feat-title").html(\'<a href="'.$cfg["main_url"].'/'.VHref::getKey("watch").'?\'+$(".thumb-selected").attr("rel-type")+\'=\'+$(".thumb-selected").attr("rel-key")+\'">\'+$(".thumb-selected .l1-full").text()+\'</a>\');
				$(".feat-descr").html("<pre>"+$(".thumb-selected .l4").text()+"</pre>");
				$(".feat-about").html($(".thumb-selected .l3").html());
				$("#feat-info").unmask();
			    }
	    ';
	}
	/* update sharing embed code */
	if($section == 'view' and $player == 'local'){
	    $u	 = $cfg["main_url"].'/'.VHref::getKey("flowplayer").'?i='.$usr_key.$file_key.'view0'.($ap == 'enabled' ? 1 : 0).$type;
	    echo ', "onLoad": function(){';
	    echo 'var embedCode = \'&lt;object width="560" height="315" id="player'.$file_key.'" name="player'.$file_key.'" data="'.$cfg["main_url"].'/f_modules/m_frontend/m_player/swf/flowplayer.swf" type="application/x-shockwave-flash"&gt;&lt;param name="movie" value="'.$cfg["main_url"].'/f_modules/m_frontend/m_player/swf/flowplayer.swf" /&gt;&lt;param name="allowfullscreen" value="true" /&gt;&lt;param name="allowScriptAccess" value="always" /&gt;&lt;param name="flashvars" value=&#39;config='.$u.'&#39; /&gt;&lt;/object&gt;\';';
	    echo 'document.getElementById("file-share-embed").innerHTML = embedCode;';
	    echo '}';
	}

	echo '}';//end conf

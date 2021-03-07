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

class VGenerate {
    private static $db_cache = false;
    
    /* get video, thumb url */
    function fileURL($type, $key, $field){
        global $db, $cfg;

        $is_mobile       = strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') ? true : false;

        $sql  = sprintf("SELECT
                                     A.`thumb_server`, A.`upload_server`,
                                     B.`server_type`, B.`url`, B.`lighttpd_url`, B.`s3_bucketname`, B.`cf_dist_type`, B.`cf_enabled`, B.`cf_dist_domain`,
                                     B.`cf_signed_url`, B.`cf_signed_expire`, B.`cf_key_pair`, B.`cf_key_file`
                                     FROM
                                     `db_%sfiles` A, `db_servers` B
                                     WHERE
                                     A.`file_key`='%s' AND
                                     A.`%s_server`=B.`server_id`
                                     LIMIT 1;", $type, $key, $field);

        $rs             = self::$db_cache ? $db->CacheExecute($cfg['cache_file_url'], $sql) : $db->execute($sql);

        $server_type    = $rs->fields["server_type"];
        $url            = $rs->fields["url"];
        $lighttpd_url   = $rs->fields["lighttpd_url"];
        $s3_bucketname  = $rs->fields["s3_bucketname"];
        $cf_enabled     = $rs->fields["cf_enabled"];
        $cf_dist_domain = $rs->fields["cf_dist_domain"];
        $cf_dist_type   = $rs->fields["cf_dist_type"];
        $cf_signed_url  = $rs->fields["cf_signed_url"];
        $cf_signed_expire = $rs->fields["cf_signed_expire"];
        $cf_key_pair    = $rs->fields["cf_key_pair"];
        $cf_key_file    = $rs->fields["cf_key_file"];

	switch($server_type){
            case "ftp": $base = ($url == '' ? $cfg["media_files_url"] : $url); break;
            case "s3":
            case "ws":
                if($cf_enabled == 0 or ($cf_enabled == 1 and $cf_dist_type == 'r' and $is_mobile)){
                    $pv = $server_type == 'ws' ? '.s3.wasabisys.com' : '.s3.amazonaws.com';
                    $base = 'https://'.$s3_bucketname.$pv;
                } elseif ($cf_enabled == 1){
                    $base = 'https://'.$cf_dist_domain;

                    if($cf_dist_type == 'r'){
                        $base = 'rtmp://'.$cf_dist_domain;
                    }
                }
            break;
            default: $base = $cfg["media_files_url"]; break;
        }
        
        return $base;
    }
    /* flowplayer signed url */
    function fpSigned($type, $vid, $ukey){
        global $db, $cfg;

        $sql         = sprintf("SELECT
                              A.`server_type`, A.`cf_enabled`, A.`cf_dist_type`, A.`cf_dist_domain`, A.`cf_signed_url`, A.`cf_signed_expire`, A.`cf_key_pair`, A.`cf_key_file`,
                              B.`upload_server`
                              FROM
                              `db_servers` A, `db_%sfiles` B
                              WHERE
                              B.`file_key`='%s' AND
                              B.`upload_server` > '0' AND
                              A.`server_id`=B.`upload_server` LIMIT 1;", $type, $vid);

            $rs          = self::$db_cache ? $db->CacheExecute($cfg['cache_signed_thumbnails'], $sql) : $db->execute($sql);
            $srv         = $db->execute($sql);

            $html        = '';

            if($srv->fields["server_type"] == 's3' and $srv->fields["cf_enabled"] == 1 and $srv->fields["cf_signed_url"] == 1){
                $cf_signed_expire = $srv->fields["cf_signed_expire"];
                $cf_key_pair    = $srv->fields["cf_key_pair"];
                $cf_key_file    = $srv->fields["cf_key_file"];

                $sources        = VPlayers::fileSources($type, $ukey, $vid);
                foreach($sources as $b => $f){
                    foreach($f as $loc){
                        $path   = $srv->fields["cf_dist_type"] == 'r' ? strstr($loc, $ukey) : $loc;
                        $html  .= '<div class="row no-display fp-signed '.$srv->fields["cf_dist_type"].'" id="'.$type.'-'.$vid.'-'.$b.'">'.VbeServers::getSignedURL($path, $cf_signed_expire, $cf_key_pair, $cf_key_file).'</div>';
                    }
                }
            }
        return $html;
    }
    /* file and thumb signed url */
    function thumbSigned($for, $file_key, $usr_key, $expires=0, $custom_policy=0, $nr=0){
        global $db, $cfg;

        if(is_array($for)){
    	    $type	= $for["type"];
    	    $srv	= $for["server"];
    	    $file	= $for["key"];
        } else {
    	    $type	= $for;
    	    $srv	= 'thumb';
        }

        $sql          	= sprintf("SELECT
                                                 A.`%s_server`,
                                                 B.`server_type`, B.`cf_enabled`, B.`cf_signed_url`, B.`cf_signed_expire`, B.`cf_key_pair`, B.`cf_key_file`
                                                 FROM
                                                 `db_%sfiles` A, `db_servers` B
                                                 WHERE
                                                 A.`file_key`='%s' AND
                                                 A.`%s_server`>'0' AND
                                                 A.`%s_server`=B.`server_id`
                                                 LIMIT 1", $srv, $type, $file_key, $srv, $srv);

        $cf		= self::$db_cache ? $db->CacheExecute($cfg['cache_signed_thumbnails'], $sql) : $db->execute($sql);

        $server_type    = $cf->fields["server_type"];
        $cf_enabled     = $cf->fields["cf_enabled"];
        $cf_signed_url  = $cf->fields["cf_signed_url"];
        $cf_signed_expire = ($expires == 0 ? $cf->fields["cf_signed_expire"] : $expires);
        $cf_key_pair    = $cf->fields["cf_key_pair"];
        $cf_key_file    = $cf->fields["cf_key_file"];

        $file_url        = $srv == 'thumb' ? VGenerate::fileURL($type, $file_key, 'thumb').'/'.$usr_key.'/t/'.$file_key.'/'.$nr.'.jpg' : VGenerate::fileURL($type, $file_key, 'upload').$file;

        if(($server_type == 's3' or $server_type == 'ws') and $cf_enabled == 1 and $cf_signed_url == 1){
            $file_url    = VbeServers::getSignedURL($file_url, $cf_signed_expire, $cf_key_pair, $cf_key_file, 0, $custom_policy);
        }
        return $file_url;
    }
    /* flowplayer bitrate select */
    function fpBitrate($a=''){
        global $cfg;

        $type = 'video';

        if($a==''){
            return '<span class="info info0"></span>';
        } else {
            $s0         = 0;
            $s1         = 0;
            $s2         = 0;
            $s3         = 0;
            $file_key   = $a[0];
            $usr_key    = $a[1];

            $f          = VPlayers::fileSources($type, $usr_key, $file_key);
            
            $url        = VGenerate::fileURL($type, $file_key, 'upload');

            foreach($f as $k => $v){
                    $loc0       = str_replace($url, $cfg["media_files_dir"], $v[0]);
                    $loc1       = str_replace($url, $cfg["media_files_dir"], $v[1]);
                    $loc2       = str_replace($url, $cfg["media_files_dir"], $v[2]);
                    $loc3       = str_replace($url, $cfg["media_files_dir"], $v[3]);
                    $loc4       = str_replace($url, $cfg["media_files_dir"], $v[4]);

                        if($k == '360p'){
                            if($s0 == 0 and (file_exists($loc0) or file_exists($loc1) or file_exists($loc2) or file_exists($loc3) or file_exists($loc4))){
                                $s0 = 1;
                            }
                        } elseif($k == '480p'){
                            if($s1 == 0 and (file_exists($loc0) or file_exists($loc1) or file_exists($loc2) or file_exists($loc4))){
                                $s1 = 1;
                            }
                        } elseif($k == '720p'){
                            if($s2 == 0 and (file_exists($loc0) or file_exists($loc1) or file_exists($loc2) or file_exists($loc4))){
                                $s2 = 1;
                            }
                        } elseif($k == '1080p'){
                            if($s3 == 0 and (file_exists($loc0) or file_exists($loc1) or file_exists($loc2) or file_exists($loc4))){
                                $s3 = 1;
                            }
                        }
            }
            $html        = '<div class="info info0">';
            $html       .= ($s0 == 1 and ($s1 == 1 or $s2 == 1)) ? '<a href="javascript:;" class="fsrc-360p factive">360p</a>' : NULL;
            $html       .= ($s1 == 1 and ($s0 == 1 or $s2 == 1)) ? '<a href="javascript:;" class="fsrc-480p">480p</a>' : NULL;
            $html       .= ($s2 == 1 and ($s0 == 1 or $s1 == 1)) ? '<a href="javascript:;" class="fsrc-720p">720p</a>' : NULL;
            $html       .= ($s3 == 1 and ($s0 == 1 or $s1 == 1)) ? '<a href="javascript:;" class="fsrc-1080p">1080p</a>' : NULL;
            $html       .= '</div>';

            return $html;
        }
    }
    /* h2 span words */
    function H2span($w, $footer=''){

	$thx     = explode(' ', $w);
	$footer	 = $footer == 1 ? 'f' : NULL;

        return '<span class="h2-left'.$footer.'">'.$thx[0].'</span><span class="h2-right'.$footer.'">'.$thx[1].'</span>';
    }
    /* generate footer copyright text */
    function footerText($ct=1){
	global $cfg, $language;
	include_once 'f_core/config.version.php';

	$html	.= $language["frontend.copyright.text"].' '.date("Y").' &copy; '.$cfg["head_title"].' '.$language["frontend.rights.text"].'<br />';
	$html	.= $ct == 1 ? $language["frontend.powered.text"].' <a href="http://www.viewshark.com">'.$version["name"].$version["major"].'.'.$version["minor"].'</a><br />' : NULL;

	return $html;
    }
    /* generate footer links and pages, including language menu */
    function footerInit(){
	global $class_filter, $cfg, $language;

	$_fp	 = footerPages();
	$_ct	 = count($_fp);
	$_t	 = $class_filter->clr_str($_GET["t"]);
	$_s	 = 1;

	
	$ht	.= '<div class="footer_menu">';
	foreach($_fp as $k => $v){
	    $hr	 = $v["page_url"] == '' ? $cfg["main_url"].'/'.VHref::getKey("page").'?t='.$k : $v["page_url"];
	    $tg	 = $v["page_open"] == 1 ? ' target="_blank"' : NULL;

	    $ht	.= '<a href="'.$hr.'" rel="nofollow"'.$tg.' class="'.($_t == $k ? 'active' : null).'">'.$v["link_name"].'</a>'.($_s < $_ct ? ' ' : null);

	    $_s	+= 1;
	}
	$ht	.= '</div>';

	echo $ht;
    }
    /* frontend language menu */
    public static function langInit() {
    	global $cfg, $language;

    	$area	 = (VTemplate::backendSectionCheck()) ? 'be' : 'fe';
    	$_lang   = langTypes();
	$_ct	 = count($_lang);

	$_ln_list= null;
	$_di	 = null;

	foreach ($_lang as $lk => $lv) {
		if (!isset($_SESSION[$area.'_lang']) and $lv['lang_default'] == 1) {
			$_ln = $lv['lang_name'];
		} elseif(isset($_SESSION[$area.'_lang'])) {
			$_ln = $_lang[$_SESSION[$area.'_lang']]['lang_name'];
		}
		$_di = $_SESSION[$area.'_lang'] == $lk ? '<i class="icon-check"></i>' : null;

		$_ln_list.= '<a href="javascript:;" class="lang-entry" rel-lang="'.$lk.'" rel="no-follow"><span class="flag-icon '.$lv["lang_flag"].'"></span> '.$lv["lang_name"].$_di.'</a>';
	}

	$html	 = '<a class="dcjq-parent a-ln" href="javascript:;" rel="nofollow"><i class="icon-earth"></i> '.$language['frontend.global.language'].': '.$_ln.'<i class="iconBe-chevron-right place-right"></i></a>';
	$html	.= '</li>';
	$html	.= '<li id="l-ln" style="display:none">';
	$html	.= '<div class="dm-wrap">';
	$html	.= '<div class="dm-head dm-head-ln"><i class="icon-arrow-left2"></i> '.$language["frontend.global.lang.select"].'</div>';
	$html	.= '<div class="ln-list">'.$_ln_list.'</div>';
	$html	.= '</div>';
	$html	.= '<div id="lang-update" style="display:none"></div>';
	$html	.= '</li>';

	$js	 = '$(".lang-entry").click(function(){';
	$js	.= '$("#siteContent").mask(" ");';
	$js	.= '$.post("'.$cfg["main_url"].'/'.VHref::getKey("language").'?t="+$(this).attr("rel-lang")+"'.($area == 'be' ? '&b=1' : null).'", function(data){';
	$js	.= '$("#lang-update").html(data);';
	$js	.= '$("#siteContent").unmask();';
	$js	.= '});';
	$js	.= '});';

	$html	.= VGenerate::declareJS('$(document).ready(function(){'.$js.'});');

	return $html;
    }
    /* backend language menu */
    public static function langInit_be() {
    	global $cfg, $language;

    	$_lang   = langTypes();
	$_ct	 = count($_lang);

	if($_ct == 0 or $_ct == 1) return false;
	
	$html	 = '<li class="main likes_holder">
			<div class="head_but head_lang likes">
			    <div class="items_count item_inactive">
				<i class="flag-icon '.$_SESSION["be_flag"].'"></i>
			    </div>
			';
    	$html	.= '<div class="">
			<div class="menu_drop">
				<div class="dl-menuwrapper" id="lang-menu-be">
					<span class="dl-trigger actions-trigger"></span>
					<ul class="dl-menu" style="display: none;">
		';

	foreach ($_lang as $lk => $lv) {
		$html	.= '
						<li>
							<a href="javascript:;" class="lang-entry" rel-lang="'.$lk.'" rel="no-follow"><span class="flag-icon '.$lv["lang_flag"].'"></span> <span class="lang-name">'.$lv["lang_name"].'</span></a>
						</li>
			';
	}
	
	$html	.= '
					</ul>
				</div>
			</div>
		</div>
		</div>
		</li>
			<div id="lang-update"></div>

    	';

	$js	 = '$(".lang-entry").click(function(){';
	$js	.= '$("#siteContent").mask(" ");';
	$js	.= '$.post("'.$cfg["main_url"].'/'.VHref::getKey("language").'?b=1&t="+$(this).attr("rel-lang"), function(data){';
	$js	.= '$("#lang-update").html(data);';
	$js	.= '$("#siteContent").unmask();';
	$js	.= '});';
	$js	.= '});';

	$html	.= VGenerate::declareJS('$(document).ready(function(){'.$js.'});');
    	
    	return $html;
    }
    /* generate page HTML, for footer links */
    function pageHTML(){
	global $class_filter, $smarty, $cfg, $class_database;

	$cfg[]	 	 = $class_database->getConfigurations('server_path_php');
	$_fp     	 = footerPages();
	$_t	 	 = $class_filter->clr_str($_GET["t"]);
	$file_path 	 = $cfg["ww_templates_dir"].'/tpl_page/'.$_fp[$_t]["page_name"];

	if (!is_file($file_path))
		return;

	if(substr($_fp[$_t]["page_name"], -3) == 'php'){
	    $_cmd	 = sprintf("%s %s", $cfg["server_path_php"], $file_path);
	    //exec($_cmd, $out);

	    $_body	 = implode("\n", $out);
	} else {
	    $_body   	 = $smarty->fetch($file_path);
	}

	return $_body;
    }
    /* generate advertising banners */
    function advHTML($a){
	global $db, $language, $class_filter;
	
	$type	 = isset($_GET["a"]) ? 'audio' : 'video';
	$q	 = null;

	if(is_array($a)){
            $f   = 0;
            $id  = $a[1];
            $c   = $db->execute(sprintf("SELECT `banner_ads` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $type, $a[2]));

            if($c->fields["banner_ads"] != ''){//video banner ads
                $ca = unserialize($c->fields["banner_ads"]);
//                foreach($ca as $v){
                    $sql = sprintf("SELECT `adv_id` FROM `db_advbanners` WHERE `adv_id` IN (%s) AND `adv_active`='1' AND `adv_group`='%s' ORDER BY RAND() LIMIT 1;", implode(',', $ca), $id);
                    $r   = $db->execute($sql);
                    if($f == 0 and $r->fields["adv_id"]){
                        $f = 1;
                        $q = sprintf("B.`adv_id`='%s' AND ", $r->fields["adv_id"]);
                    }
//                }
            	if($f == 0){
                	$id = $a[0];
            	}
            } else {//category banner ads
            	$c   = $db->execute(sprintf("SELECT 
            					A.`ct_banners`, B.`file_key` 
            					FROM 
            					`db_categories` A, `db_%sfiles` B 
            					WHERE 
            					A.`ct_id`=B.`file_category` AND 
            					B.`file_key`='%s' 
            					LIMIT 1;", $type, $a[2]));

            	if($c->fields["ct_banners"] != ''){
            		$ca = unserialize($c->fields["ct_banners"]);
//            		foreach($ca as $v){
            			$sql = sprintf("SELECT `adv_id`, `adv_group` FROM `db_advbanners` WHERE `adv_id` IN (%s) AND `adv_active`='1' AND `adv_group`='%s' ORDER BY RAND() LIMIT 1;", implode(',', $ca), ($id+10));
            			$r   = $db->execute($sql);
            			if ($f == 0 and $r->fields["adv_id"]) {
            				$f = 1;
            				$id = $r->fields["adv_group"];
            				$q = sprintf("B.`adv_id`='%s' AND ", $r->fields["adv_id"]);
            			}
//            		}
            	}

            	if($f == 0){
//                	$id = $id+10;
                	$id = $a[0];
            	}
            }
        } else {
            $id  = $a;
        }

        $html    = NULL;
        $sql     = sprintf("SELECT
                            A.`adv_name`,
                            A.`adv_description`,
                            A.`adv_width`,
                            A.`adv_height`,
                            A.`adv_class`,
                            A.`adv_style`,
                            A.`adv_rotate`,
                            A.`adv_active`,
                            B.`adv_code`,
                            B.`adv_active`
                            FROM
                            `db_advgroups` A, `db_advbanners` B
                            WHERE
                            %s
                            A.`db_id`='%s' AND
                            B.`adv_group`='%s' AND
                            A.`adv_active`='1' AND
                            B.`adv_active`='1';", $q, $id, $id);
        $ad              = $db->execute($sql);
        $ad_res          = $ad->getrows();
        $ad_total        = $ad->recordcount();

	if($ad_res[0]["adv_active"] == 0) return false;
            $ad_rotate   = $ad_res[0]["adv_rotate"];
            $key         = $ad_rotate == 1 ? rand(0, ($ad_total - 1)) : 0;

            $ad_name     = $ad_res[$key]["adv_name"];
            $ad_descr    = $ad_res[$key]["adv_description"];
            $ad_width    = $ad_res[$key]["adv_width"];
            $ad_height   = $ad_res[$key]["adv_height"];
            $ad_class    = $ad_res[$key]["adv_class"];
            $ad_style    = $ad_res[$key]["adv_style"];
            $ad_code     = $ad_res[$key]["adv_code"];
            $ad_html     = $ad_code != '' ? $ad_code : $ad_descr.' <br />'.$ad_total.' '.$language["frontend.global.banners.here"];

            $style       = ($ad_width == 0 or $ad_height == 0) ? null : 'width: '.($ad_width == '100%' ? '100%' : $ad_width.'px').'; height: '.($ad_height == '100%' ? '100%' : $ad_height.'px').'; overflow: hidden;';
            $style      .= $ad_style;

            $html       .= $id == 43 ? '<div id="footer-top-ad">' : NULL;
            $html       .= '<div class="row no-top-padding">';
            $html       .= '<div class="'.$ad_class.'" style="border: 0px solid black;'.$style.'">'.$ad_html.'</div>';
            $html       .= '</div>';

        return ($html != '' ? $html : $ad_name);
    }

    /* generate ad groups select list */
    function adGroupsList($db_id, $selected=''){
	global $db;

                switch($_GET["s"]){
            	    case "backend-menu-entry7":
            	    case "backend-menu-entry9": $db_add_query = "`db_id` > '0'"; break;

                    case "backend-menu-entry7-sub1":
                    case "backend-menu-entry9-sub1": $db_add_query = "`adv_name` LIKE 'home_promoted_%'"; break;

                    case "backend-menu-entry7-sub2":
                    case "backend-menu-entry9-sub2": $db_add_query = "`adv_name` LIKE 'browse_chan_%'"; break;

                    case "backend-menu-entry7-sub3":
                    case "backend-menu-entry9-sub3": $db_add_query = "`adv_name` LIKE 'browse_files_%'"; break;

                    case "backend-menu-entry7-sub4":
                    case "backend-menu-entry9-sub4": $db_add_query = "`adv_name` LIKE 'view_files_%'"; break;

                    case "backend-menu-entry7-sub5":
                    case "backend-menu-entry9-sub5": $db_add_query = "`adv_name` LIKE 'view_comm_%'"; break;

                    case "backend-menu-entry7-sub6":
                    case "backend-menu-entry9-sub6": $db_add_query = "`adv_name` LIKE 'view_resp_%'"; break;

                    case "backend-menu-entry7-sub7":
                    case "backend-menu-entry9-sub7": $db_add_query = "`adv_name` LIKE 'view_pl_%'"; break;

                    case "backend-menu-entry7-sub8":
                    case "backend-menu-entry9-sub8": $db_add_query = "`adv_name` LIKE 'respond_%'"; break;

                    case "backend-menu-entry7-sub9":
                    case "backend-menu-entry9-sub9": $db_add_query = "`adv_name` LIKE 'register_%'"; break;

                    case "backend-menu-entry7-sub10":
                    case "backend-menu-entry9-sub10": $db_add_query = "`adv_name` LIKE 'login_%'"; break;

                    case "backend-menu-entry7-sub11":
                    case "backend-menu-entry9-sub11": $db_add_query = "`adv_name` LIKE 'search_%'"; break;

                    case "backend-menu-entry7-sub12":
                    case "backend-menu-entry9-sub12": $db_add_query = "`adv_name` LIKE 'footer_%'"; break;

                    case "backend-menu-entry7-sub13":
                    case "backend-menu-entry9-sub13": $db_add_query = "`adv_name` LIKE 'browse_pl_%'"; break;

                    case "backend-menu-entry7-sub14":
                    case "backend-menu-entry9-sub14": $db_add_query = "`adv_name` LIKE 'per_file_%'"; break;

                    case "backend-menu-entry7-sub15":
                    case "backend-menu-entry9-sub15": $db_add_query = "`adv_name` LIKE 'per_category_%'"; break;

                    default: break;
                }
	$sql	 	 = sprintf("SELECT `db_id`, `adv_name` FROM `db_advgroups` WHERE %s AND `adv_active`='1';", $db_add_query);
	$res	 	 = $db->execute($sql);

	$html	 	 = '<i class="iconBe-chevron-down"></i><select name="adv_group_ids_'.$db_id.'" class="select-input wd350">';
	while(!$res->EOF){
	    $html	.= '<option value="'.$res->fields["db_id"].'"'.($res->fields["db_id"] == $selected ? ' selected="selected"' : NULL).'>'.$res->fields["adv_name"].'</option>';

	    @$res->MoveNext();
	}
        $html		.= '</select>';

        return $html;
    }
    /* generate video/image/audio/doc select list */
    function fileTypesList($section='fe', $selected='', $entry_id=0){
	global $cfg, $language;

	$html	 = '<select name="this_file_type_'.$entry_id.'" class="select-input wd100">';
        $html	.= (($section == 'fe' and $cfg["live_module"] == 1) or $section == 'be') ? '<option value="live"'.(($selected == 'live') ? ' selected="selected"' : (($_GET["do"] == 'add' and $_POST["this_file_type"] == 'video') ? ' selected="selected"' : NULL)).'>'.$language["frontend.global.l"].'</option>' : NULL;
	$html	.= (($section == 'fe' and $cfg["video_module"] == 1) or $section == 'be') ? '<option value="video"'.(($selected == 'video') ? ' selected="selected"' : (($_GET["do"] == 'add' and $_POST["this_file_type"] == 'video') ? ' selected="selected"' : NULL)).'>'.$language["frontend.global.v"].'</option>' : NULL;
        $html   .= (($section == 'fe' and $cfg["image_module"] == 1) or $section == 'be') ? '<option value="image"'.(($selected == 'image') ? ' selected="selected"' : (($_GET["do"] == 'add' and $_POST["this_file_type"] == 'image') ? ' selected="selected"' : NULL)).'>'.$language["frontend.global.i"].'</option>' : NULL;
        $html   .= (($section == 'fe' and $cfg["audio_module"] == 1) or $section == 'be') ? '<option value="audio"'.(($selected == 'audio') ? ' selected="selected"' : (($_GET["do"] == 'add' and $_POST["this_file_type"] == 'audio') ? ' selected="selected"' : NULL)).'>'.$language["frontend.global.a"].'</option>' : NULL;
	$html   .= (($section == 'fe' and $cfg["blog_module"] == 1) or $section == 'be') ? '<option value="blog"'.(($selected == 'blog') ? ' selected="selected"' : (($_GET["do"] == 'add' and $_POST["this_file_type"] == 'audio') ? ' selected="selected"' : NULL)).'>'.$language["frontend.global.b"].'</option>' : NULL;
        $html   .= (($section == 'fe' and $cfg["document_module"] == 1) or $section == 'be') ? '<option value="doc"'.(($selected == 'doc') ? ' selected="selected"' : (($_GET["do"] == 'add' and $_POST["this_file_type"] == 'doc') ? ' selected="selected"' : NULL)).'>'.$language["frontend.global.d"].'</option>' : NULL;
        $html	.= '</select>';

        return $html;
    }
    /* generate social bookmarks */
    function socialBookmarks($s=''){
	global $section, $href, $cfg;

	$section = $s != '' ? $s : $section;

	switch($section){
	    case "m":
                $html    = '<div class="addthis_toolbox addthis_default_style addthis_32x32_style">';
                $html   .= '<a class="addthis_button_facebook" title="'.$language["view.files.share.fb"].'"></a>';
                $html   .= '<a class="addthis_button_twitter" title="'.$language["view.files.share.tw"].'"></a>';
                $html   .= '<a class="addthis_button_instagram" title="'.$language["view.files.share.tw"].'"></a>';
                $html   .= '<a class="addthis_button_whatsapp" title="'.$language["view.files.share.tw"].'"></a>';
                $html   .= '<a class="addthis_button_google_plusone_share" title="'.$language["view.files.share.g"].'"></a>';
                $html   .= '<a class="addthis_button_pinterest_share" title="'.$language["view.files.share.g"].'"></a>';
                $html   .= '<a class="addthis_button_tumblr" title="'.$language["view.files.share.g"].'"></a>';
                $html   .= '<a class="addthis_button_gmail" title="'.$language["view.files.share.y"].'"></a>';
                $html   .= '</div>';
                $html   .= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/addthis_widget.js#pubid=xa-4eb3df4d2215c5e0"></script>';
            break;
	    case $href["watch"]:
		$html	 = '<div class="addthis_toolbox addthis_default_style addthis_32x32_style">';
		$html	.= '<a class="addthis_button_facebook" title="'.$language["view.files.share.fb"].'"></a>';
		$html	.= '<a class="addthis_button_twitter" title="'.$language["view.files.share.tw"].'"></a>';
                $html   .= '<a class="addthis_button_instagram" title="'.$language["view.files.share.tw"].'"></a>';
                $html   .= '<a class="addthis_button_whatsapp" title="'.$language["view.files.share.tw"].'"></a>';
		$html	.= '<a class="addthis_button_google_plusone_share" title="'.$language["view.files.share.g"].'"></a>';
		$html	.= '<a class="addthis_button_pinterest_share" title="'.$language["view.files.share.pin"].'"></a>';
		$html	.= '<a class="addthis_button_reddit" title="'.$language["view.files.share.rd"].'"></a>';
		$html	.= '<a class="addthis_button_gmail" title="'.$language["view.files.share.y"].'"></a>';
		$html	.= '<a class="addthis_button_yahoomail" title="'.$language["view.files.share.y"].'"></a>';
		$html	.= '<a class="addthis_button_tumblr" title="'.$language["view.files.share.tu"].'"></a>';
		$html	.= '<a class="addthis_button_wordpress" title="'.$language["view.files.share.wp"].'"></a>';
		$html	.= '<a class="addthis_button_compact" title=""></a>';
		$html	.= '</div>';
		$html	.= '<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4eb3df4d2215c5e0"></script>';
		$html	.= '<script type="text/javascript">var addthis_config = addthis_config||{};addthis_config.services_exclude = "email,print";</script>';
	    break;
	    default:
		$html	.= '<div class="addthis_toolbox addthis_default_style addthis_32x32_style right-float top-padding5 right-padding10 bottom-padding5 wd175">';
		$html	.= '<div class="row no-top-padding"><a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:action="like"></a></div>';
		$html	.= '<div class="row no-top-padding"><a class="addthis_button_tweet"></a></div>';
		$html	.= '<div class="row top-padding5"><a class="addthis_button_google_plusone" g:plusone:size="medium"></a></div>';
		$html	.= '</div>';
		$html	.= '<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e650dda71b07898"></script>';
	    break;
	}

	return $html;
    }
    /* generate file href html */
    function fileHref($type, $key, $title=''){
	require 'f_core/config.href.php';
	global $class_database;

	switch($type){
	    case "l": $tbl = 'live'; break;
            case "v": $tbl = 'video'; break;
            case "i": $tbl = 'image'; break;
            case "a": $tbl = 'audio'; break;
            case "d": $tbl = 'doc'; break;
	    case "b": $tbl = 'blog'; break;
        }

	$_title	 = $title == '' ? $class_database->singleFieldValue('db_'.$tbl.'files', 'file_title', 'file_key', $key) : $title;

	return ($cfg["file_seo_url"] == 1 ? sprintf("%s/%s/%s", $type, $key, VForm::clearTag($_title, 1)) : sprintf("%s?%s=%s", VHref::getKey("watch"), $type, $key));
    }
    /* generate/various inputs */
    function basicInput($type='', $input_name='', $input_class='', $input_value='', $input_id='', $btn_label='', $btn_rel='', $placeholder='') {
	global $language;
	$_id = $input_id != '' ? 'id="'.$input_id.'"' : NULL;

	switch($type) {
	    case "text":
	    case "text-perm":
		$read_only	= ($type == 'text-perm') ? ' readonly="readonly"' : NULL;
//		if ($type == 'text-perm') {
//			$input	= '<span style="font-size:12px">'.$input_value.' '.VFileinfo::getOwnerships($input_value).' / '.VFileinfo::getPermissions($input_value).'</span>';
//		} else {
			$input	= '<input'.$read_only.' type="'.($type == 'text-perm' ? 'hidden' : 'text').'" name="'.$input_name.'" class="'.$input_class.'" value="'.$input_value.'" '.$_id.' /> <p style="float:right;font-size:11px;margin-bottom:0px;margin-top:5px;">'.$perm_text.'</p>';
			$input .= '<div id="slider-'.$input_name.'"></div>';
//		}
		break;
	    case "file":
		$input 		= '<input type="file" name="'.$input_name.'" class="'.$input_class.'" '.$_id.' />'; break;
	    case "password":
		$input 		= '<input type="password" name="'.$input_name.'" class="'.$input_class.'" value="'.$input_value.'" '.$_id.' placeholder="'.$placeholder.'" />'; break;
	    case "textarea-on":
	    case "textarea-off":
	    case "textarea":
		$disabled 	= ($type == 'textarea-off') ? 'disabled="disabled"' : NULL;
		$input 		= '<textarea '.$disabled.' name="'.$input_name.'" class="'.$input_class.'" '.$_id.'>'.$input_value.'</textarea>'.$extra_tip; break;
	    case "button":
		$input 		= '<button'.($btn_rel != '' ? ' rel="'.$btn_rel.'"': NULL).' name="'.$input_name.'" id="btn-'.$input_id.'-'.$input_name.'" class="'.$input_class.$btn_class.'" type="button" value="'.($input_value != '' ? $input_value : 1).'" onfocus="blur();">'.$btn_label.'</button>'; break;
	}
	return $input;
    }
    /* generate on/off switches */
    function entrySwitch($entry_id, $entry_title, $sel_on, $sel_off, $sw_on, $sw_off, $input_name, $check_on, $check_off, $col_type = 'eights') {
    	global $language, $cfg;
    	
    	$input_code 	= '';

	switch($input_name){
		case "backend_menu_entry3_sub1_smtp_auth": $c_on = 'true'; $c_off = 'false'; break;
		case "backend_menu_entry1_sub7_file_opt_del":
                        $radio_check1    = $cfg["file_delete_method"] == 1 ? ' checked="checked"' : NULL;
                        $radio_check2    = $cfg["file_delete_method"] == 2 ? ' checked="checked"' : NULL;
                        $radio_check3    = $cfg["file_delete_method"] == 3 ? ' checked="checked"' : NULL;
                        $radio_check4    = $cfg["file_delete_method"] == 4 ? ' checked="checked"' : NULL;

                        $input_code     .= '<div class="icheck-box"><input type="radio" '.$radio_check1.' name="'.$input_name.'_method" value="1"><label>'.$language["backend.menu.entry1.sub7.file.opt.del.t1"].'</label><br>';
                        $input_code     .= '<input type="radio" '.$radio_check2.' name="'.$input_name.'_method" value="2"><label>'.$language["backend.menu.entry1.sub7.file.opt.del.t2"].'</label><br>';
                        $input_code     .= '<input type="radio" '.$radio_check3.' name="'.$input_name.'_method" value="3"><label>'.$language["backend.menu.entry1.sub7.file.opt.del.t3"].'</label><br>';
                        $input_code     .= '<input type="radio" '.$radio_check4.' name="'.$input_name.'_method" value="4"><label>'.$language["backend.menu.entry1.sub7.file.opt.del.t4"].'</label></div>';
                        
                        $c_on = 1; $c_off = 0;
		break;
		case "backend_menu_entry1_sub7_file_opt_down":
                        $dl_1            =  $cfg["file_download_s1"] == 1 ? 'checked="checked"' : NULL;
                        $dl_2            =  $cfg["file_download_s2"] == 1 ? 'checked="checked"' : NULL;
                        $dl_3            =  $cfg["file_download_s3"] == 1 ? 'checked="checked"' : NULL;
                        $dl_4            =  $cfg["file_download_s4"] == 1 ? 'checked="checked"' : NULL;
                        $dl_reg          =  $cfg["file_download_reg"] == 1 ? 'checked="checked"' : NULL;

                        $input_code     .= '<div class="icheck-box"><input type="checkbox" '.$dl_reg.' name="dl_reg" value="1"><label>'.$language["backend.menu.entry1.sub7.file.opt.down.reg"].'</label><br>';
                        $input_code     .= '<input type="checkbox" '.$dl_1.' name="dl_1" value="1"><label>'.$language["backend.menu.entry1.sub7.file.opt.down.s1"].'</label><br>';
                        $input_code     .= '<input type="checkbox" '.$dl_2.' name="dl_2" value="1"><label>'.$language["backend.menu.entry1.sub7.file.opt.down.s2"].'</label><br>';
                        $input_code     .= '<input type="checkbox" '.$dl_3.' name="dl_3" value="1"><label>'.$language["backend.menu.entry1.sub7.file.opt.down.s3"].'</label><br>';
                        $input_code     .= '<input type="checkbox" '.$dl_4.' name="dl_4" value="1"><label>'.$language["backend.menu.entry1.sub7.file.opt.down.s4"].'</label></div>';
                        
                        $c_on = 1; $c_off = 0;
		break;
		case "backend_menu_entry1_sub7_file_video":
			$c_on = 1; $c_off = 0;
                        $input_size = '<label>'.$language["backend.menu.members.entry2.sub1.max"].$language["frontend.sizeformat.mb"].'</label>'.VGenerate::basicInput('text', $input_name.'_size', 'backend-text-input wd70', $cfg["video_limit"], $entry_id.'-input2');
                        $input_code.= '<label>'.$language["backend.menu.members.entry2.sub1.allowed"].'</label>'.VGenerate::basicInput('text', $input_name.'_types', 'backend-text-input wd350', $cfg["video_file_types"]).$input_size;
                        $input_code.= '<div class="clearfix">&nbsp;</div>';
                        $input_code.= VbeSettings::settings_delOriginalFiles('conversion_source_video', 'video');
		break;
		case "backend_menu_entry1_sub7_file_image":
			$c_on = 1; $c_off = 0;
                        $input_size = '<label>'.$language["backend.menu.members.entry2.sub1.max"].$language["frontend.sizeformat.mb"].'</label>'.VGenerate::basicInput('text', $input_name.'_size', 'backend-text-input wd70', $cfg["image_limit"], $entry_id.'-input2');
                        $input_code.= '<label>'.$language["backend.menu.members.entry2.sub1.allowed"].'</label>'.VGenerate::basicInput('text', $input_name.'_types', 'backend-text-input wd350', $cfg["image_file_types"]).$input_size;
                        $input_code.= '<div class="clearfix">&nbsp;</div>';
                        $input_code.= VbeSettings::settings_delOriginalFiles('conversion_source_image', 'image');
                    break;
                    case "backend_menu_entry1_sub7_file_audio":
                    	$c_on = 1; $c_off = 0;
                        $input_size = '<label>'.$language["backend.menu.members.entry2.sub1.max"].$language["frontend.sizeformat.mb"].'</label>'.VGenerate::basicInput('text', $input_name.'_size', 'backend-text-input wd70', $cfg["audio_limit"], $entry_id.'-input2');
                        $input_code.= '<label>'.$language["backend.menu.members.entry2.sub1.allowed"].'</label>'.VGenerate::basicInput('text', $input_name.'_types', 'backend-text-input wd350', $cfg["audio_file_types"]).$input_size;
                        $input_code.= '<div class="clearfix">&nbsp;</div>';
                        $input_code.= VbeSettings::settings_delOriginalFiles('conversion_source_audio', 'audio');
                    break;
                    case "backend_menu_entry1_sub7_file_doc":
                    	$c_on = 1; $c_off = 0;
                        $input_size = '<label>'.$language["backend.menu.members.entry2.sub1.max"].$language["frontend.sizeformat.mb"].'</label>'.VGenerate::basicInput('text', $input_name.'_size', 'backend-text-input wd70', $cfg["document_limit"], $entry_id.'-input2');
                        $input_code.= '<label>'.$language["backend.menu.members.entry2.sub1.allowed"].'</label>'.VGenerate::basicInput('text', $input_name.'_types', 'backend-text-input wd350', $cfg["document_file_types"]).$input_size;
                        $input_code.= '<div class="clearfix">&nbsp;</div>';
                        $input_code.= VbeSettings::settings_delOriginalFiles('conversion_source_doc', 'doc');
                    break;
                    case "backend_menu_entry2_sub4_activity":
                    	$c_on = 1; $c_off = 0;
                        $opt_array  = array(
                            "log_upload"        => $language["backend.menu.entry6.sub6.log.upload"],
                            "log_filecomment"   => $language["backend.menu.entry6.sub6.log.comment"],
                            "log_rating"        => $language["backend.menu.entry6.sub6.log.rate"],
                            "log_fav"           => $language["backend.menu.entry6.sub6.log.favorite"],
                            "log_subscribing"   => $language["backend.menu.entry6.sub6.log.subscribe"],
                            "log_following"     => $language["backend.menu.entry6.sub6.log.follow"],
                            "log_pmessage"      => $language["backend.menu.entry6.sub6.log.pm"],
                            "log_frinvite"      => $language["backend.menu.entry6.sub6.log.invite"],
                            "log_delete"        => $language["backend.menu.entry6.sub6.log.delete"],
                            "log_signin"        => $language["backend.menu.entry6.sub6.log.signin"],
                            "log_signout"       => $language["backend.menu.entry6.sub6.log.signout"],
                            "log_precovery"     => $language["backend.menu.entry6.sub6.log.pr"],
                            "log_urecovery"     => $language["backend.menu.entry6.sub6.log.ur"]
                            );

                        $input_code            .= VGenerate::simpleDivWrap('row left-float', '', '');
                        $input_code            .= '<div class="icheck-box">';
                        foreach($opt_array as $key => $val){
                            $cfg_check          = $cfg[$key] == 1 ? ' checked="checked"' : NULL;
                            $input_code        .= '<input class="activity_logging_cb" type="checkbox"'.$cfg_check.' name="'.$key.'" value="1" /><label>'.$language["backend.menu.entry6.sub6.log.comp"].$val.'</label><br>';
                        }
                        $input_code            .= '</div>';
                    break;



	    default: $c_on = 1; $c_off = 0;
	}
        $input_code = '
					<div class="">
							<div class="switch_holder">
								<label class="switch switch-light" onclick="if($(this).find(\'.switch-input\').is(\':checked\')){$(\'#'.$entry_id.'-input1\').click();}else{$(\'#'.$entry_id.'-input2\').click();}">
									<input type="checkbox" class="switch-input" name="'.$input_name.'_check"'.($check_on != '' ? ' checked="checked"' : null).'>
					      				<span class="switch-label" data-on="'.$sw_on.'" data-off="'.$sw_off.'"></span>
					      				<span class="switch-handle"></span>
					    			</label>
								<div style="display: none;">
									<input type="radio" id="'.$entry_id.'-input1" name="'.$input_name.'" value="'.$c_on.'" '.$check_on.'>
									<input type="radio" id="'.$entry_id.'-input2" name="'.$input_name.'" value="'.$c_off.'" '.$check_off.'>
								</div>
							</div>
							'.($input_code != '' ? '<div class="settings_content">'.$input_code.'</div>' : null).'
					</div>
        ';

	return $input_code;
    }
    /* backend menu entries */
    function menuEntries(){
	global $cfg;

	return ($cfg["backend_menu_toggle"] == 1 ? 'block' : 'none');
    }
    /* backend menu toggle */
    function menuToggle(){
	global $cfg;

	$c1	 = $cfg["backend_menu_toggle"] == 1 ? 'tree tree_expand no-display' : 'tree tree_expand';
	$c2	 = $cfg["backend_menu_toggle"] == 1 ? 'tree tree_collapse' : 'tree tree_collapse no-display';

	return VGenerate::simpleDivWrap($c1).VGenerate::simpleDivWrap($c2);
    }
    /* build select list options */
    function selectListOptions($arr, $for){
	global $language;
	if($for == 'usr_showage'){
	    $showage	= VUseraccount::getProfileDetail($for);
	    $ck		= $showage == 1 ? $language["account.profile.age.array"][0] : $language["account.profile.age.array"][1];
	}
	foreach($arr as $val) {
	    $sel_opts  .= '<option'.(($for == 'usr_showage' and $val == $ck) ? ' selected="selected"' : NULL).' value="'.($for == 'usr_gender' ? $val[0] : (($for == 'usr_showage' and $val == $arr[0]) ? 1 : (($for == 'usr_showage' and $val == $arr[1]) ? 0 : $val))).'" '.self::selOptionCheck(VUseraccount::getProfileDetail($for), ($for == 'usr_gender' ? $val[0] : $val)).'>'.(($for == 'usr_showage' and $val == $arr[0]) ? $val : (($for == 'usr_showage' and $val == $arr[0]) ? $val : $val)).'</option>';
	}
	return $sel_opts;
    }
    /* select options checked verification */
    function selOptionCheck($check, $val) {
	return $sel = $check == $val ? ' selected="selected"' : NULL;
    }
    /* simple label and input display */
    function sigleInputEntry($type, $label_class, $label_text, $div_class, $input_name, $input_class, $input_value) {
	switch($input_name){
	    case "server_path_lame":
	    case "server_path_ffmpeg":
	    case "server_path_ffprobe":
	    case "server_path_yamdi":
	    case "server_path_qt":
	    case "server_path_unoconv":
	    case "server_path_convert":
	    case "server_path_pdf2swf":
	    case "server_path_php":
	    case "server_path_mysqldump":
	    case "server_path_tar":
	    case "server_path_gzip":
	    case "server_path_zip":
		$ht = '<p style="float: right; font-size: 11px;">'.VbeSettings::checkPath($input_name).'<p>'; break;
	    default:
		$ht = NULL; break;
	}
	return self::simpleDivWrap('row', '', self::simpleDivWrap($label_class,'',$label_text).self::simpleDivWrap($div_class,'',self::basicInput($type, $input_name, $input_class, $input_value).$ht));
    }
    /* wrapping in a div */
    function simpleDivWrap($class, $id='', $val='', $style='', $span_instead='', $rel_attr='') {
	$htm		= $span_instead == '' ? 'div' : 'span';
	$rel_attr 	= $rel_attr != '' ? ' '.$rel_attr : NULL;
	$div_id 	= $id != '' ? ' id="'.$id.'"' : NULL;
	$div_st		= $style != '' ? ' style="'.$style.'"' : NULL;

	return '<'.$htm.''.$div_st.' class="'.$class.'"'.$div_id.$rel_attr.'>'.$val.'</'.$htm.'>';
    }
    /* hidden input */
    function entryHiddenInput($db_id) {
	return '<input type="hidden" name="hc_id" value="'.$db_id.'" /><input type="checkbox" class="no-display" id="hcs-id'.$db_id.'" name="current_entry_id[]" value="'.$db_id.'">';
    }
    //notices/errors
    function noticeTpl($extra_class, $error_message = '', $notice_message = '') {
	global $smarty, $language;
	$smarty->assign('notice_message', $notice_message);
	$smarty->assign('error_message', $error_message);

	$n_tpl = VGenerate::simpleDivWrap('pointer left-float wdmax'.$extra_class, 'cb-response', $smarty->fetch("tpl_frontend/tpl_header/tpl_notify.tpl").'<div class="right-float auto-close-response no-display"><span class="auto-close-time no-display">5</span><span class="auto-close-text">'.$language["frontend.global.close.auto"].'</span></div>');

	return $n_tpl;
    }
    /* wrapping notices */
    function noticeWrap($html) {
        echo self::simpleDivWrap('pointer left-float no-top-padding wdmax section-bottom-border', 'cb-response-wrap', self::simpleDivWrap('centered', '', $html[2]));
    }

    //generate/various javascript
    function thumbJS(){
	global $class_database, $cfg;

	$cfg[]	 = $class_database->getConfigurations('thumbs_rotation');

	if($cfg["thumbs_rotation"] == 1){
	    return '<script type="text/javascript" src="'.$cfg["javascript_url"].'/jquery.thumb.js"></script>';
	}
    }
    function jqHtml($div_id, $div_ct) {
	echo self::declareJS('$("'.$div_id.'").html("'.$div_ct.'");');
    }
    function keepEntryOpen() {
	if($_POST["ct_entry"] != '') {
            $db_id      = substr($_POST["ct_entry"], 9);
            $entry_id   = 'ct-entry-details'.$db_id;
            $extra_js   = 'var p_id = $("#'.$entry_id.'").parent().attr("id"); $("#"+p_id+" > div.ct-bullet-out").addClass("ct-bullet-in"); $("#"+p_id+" > div.ct-bullet-label").addClass("bold"); $("#'.$entry_id.'").removeClass("no-display"); $("#ct_entry").val("ct-bullet'.$db_id.'");';

            echo self::declareJS($extra_js);
        }
    }
    function declareJS($code, $id='') {
	return '<script type="text/javascript"'.($id != '' ? ' id="'.$id.'"' : NULL).'> '.$code.' </script>';
    }
    function actionTooltipJS($on_class, $var_id, $off_class, $_id) {
	$extra_js = '$(".'.$on_class.'").mouseover(function() { var '.$var_id.' = $(this).attr("id"); showDiv('.$var_id.'+"'.$_id.'"); $("#"+'.$var_id.').removeClass("'.$on_class.'").addClass("'.$off_class.'"); $("#"+'.$var_id.').mouseout(function() { hideDiv('.$var_id.'+"'.$_id.'"); $("#"+'.$var_id.').removeClass("'.$off_class.'").addClass("'.$on_class.'"); }); });';

	return $extra_js;
    }
    function settingsTooltipJS($entry_id) {
	$extra_js = '$("#'.$entry_id.'-tip").mouseover(function() { showDiv("'.$entry_id.'-thetip"); $("#'.$entry_id.'-tip").removeClass("different-sub-gray").addClass("different-sub"); $("#'.$entry_id.'-tip").mouseout(function() { hideDiv("'.$entry_id.'-thetip"); $("#'.$entry_id.'-tip").removeClass("different-sub").addClass("different-sub-gray"); }); });';

	return $extra_js;
    }
    function entryTooltip($class, $pos, $id, $text) {
    	return '<span title=\''.$text.'\' rel="tooltip" class="'.$class.'"></span>';
    }
	/* generate heading text and line */
	public static function headingArticle($text, $icon) {
		$html	 = '

		<article>
                        <h3 class="content-title"><i class="'.$icon.'"></i> '.$text.'</h3>
                        <div class="line"></div>
                </article>
                ';
                
                return $html;
	}
	/* generate lightbox cancel button */
	public static function lb_Cancel($text=false) {
		global $language;

		return '<a onclick="$.fancybox.close();" href="javascript:;" class="link cancel-trigger"><span>'.(!$text ? $language["frontend.global.cancel"] : $text).'</span></a>';
	}
	/* extract blog short tags */
	public static function extract_text($string) {
		$text_outside=array();
		$text_inside=array();
		$t="";

		for ($i=0;$i<strlen($string);$i++) {
			if($string[$i]=='[' and $string[$i+1]=='m' and $string[$i+2]=='e' and $string[$i+3]=='d' and $string[$i+4]=='i' and $string[$i+5]=='a') {
				$text_outside[]=$t;
				$t="";
				$t1="";
				$i++;

				while($string[$i]!=']') {
					$t1.=$string[$i];
					$i++;
				}
				$text_inside[] = $t1;
			} else {
				if($string[$i]!=']')
					$t.=$string[$i];
				else {
					continue;
				}
			}
		}

		if($t!="")
			$text_outside[]=$t;

		return $text_inside;
	}
	/* process autocomplete requests */
        public static function processAutoComplete($section, $type = false) {
                global $class_filter, $db;

		$sql	 = false;
                $query   = $_POST ? $class_filter->clr_str($_POST["query"]) : false;
                $output  = array('query' => $query, 'suggestions' => array());
                $fields	 = array('usr_user', 'usr_key');

                switch ($section) {
                	case "search"://frontend main search
                		$files  = new VFiles;

                		$fields = array('file_title', 'file_key');
                		$type 	= $class_filter->clr_str($_POST["t"]);
                		$sql	= sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`file_title` LIKE '%s';", $type, $query.'%');

                		break;
                	case "account_media":
                                $fields = array('file_title', 'file_key');
                                $type   = $class_filter->clr_str($_POST["t"]);
                                $sql    = sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`usr_id`='%s' AND A.`file_title` LIKE '%s';", $type, (int) $_SESSION["USER_ID"], $query.'%');

                                break;
                        case "account_media_be":
                                $fields = array('file_title', 'file_key');
                                $type   = $class_filter->clr_str($_POST["t"]);
                                $sql    = sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`usr_id` > 0 AND A.`file_title` LIKE '%s';", $type, $query.'%');

                                break;
                        case "account_user":
                                $sql     = sprintf("SELECT `usr_key`, `usr_user` FROM `db_accountuser` WHERE `usr_user` LIKE '%s';", $query.'%');

                                break;
                	case "media_library"://my files / media library
                		$fields = array('file_title', 'file_key');
                		$type 	= $class_filter->clr_str($_POST["t"]);
                		$_s 	= $class_filter->clr_str($_GET["s"]);
                		
                		switch ($_s) {
                			case "file-menu-entry1":
                				$sql	 = sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`file_title` LIKE '%s';", $type, $query.'%');
                				break;
                			
                			case "file-menu-entry2"://favorites
						$db_field	= 'fav_list';
						$db_tbl		= 'favorites';
						$pg_cfg		= 'page_user_files_favorites';
						$cache_cfg	= 'cache_user_files_favorites';
						break;
						
					case "file-menu-entry3"://liked
						$db_field	= 'liked_list';
						$db_tbl		= 'liked';
						$pg_cfg		= 'page_user_files_liked';
						$cache_cfg	= 'cache_user_files_liked';
						break;
						
					case "file-menu-entry4"://history
						$db_field	= 'history_list';
						$db_tbl		= 'history';
						$pg_cfg		= 'page_user_files_history';
						$cache_cfg	= 'cache_user_files_history';
						break;
						
					case "file-menu-entry5"://watchlist
						$db_field	= 'watch_list';
						$db_tbl		= 'watchlist';
						$pg_cfg		= 'page_user_files_watchlist';
						$cache_cfg	= 'cache_user_files_watchlist';
						break;
					
					default:
						if (substr($_s, 0, 4) == 'subs' or substr($_s, 0, 4) == 'osub') {//subscribers and subscriptions
							$uid	=  (int) substr($_s, 15);

							$sql	= sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`usr_id`='%s' AND A.`file_title` LIKE '%s';", $type, $uid, $query.'%');
						}
						if (substr($_s, 0, 16) == 'file-menu-entry6') {//playlists
							$t 	= str_replace('file-menu-entry6-sub', '', $_s);
							$type	= $t[0];
							
							switch ($t[0]) {
								case "l": $type = 'live'; break;
								case "v": $type = 'video'; break;
								case "i": $type = 'image'; break;
								case "a": $type = 'audio'; break;
								case "d": $type = 'doc'; break;
								case "b": $type = 'blog'; break;
							}

							$t	= str_replace($t[0], '', $t);
							$id	= (int) $t;
							
							if ($id > 0) {
								$sql	 = sprintf("SELECT `pl_files` FROM `db_%splaylists` WHERE `pl_id`='%s' AND `usr_id`='%s' LIMIT 1;", $type, $id, (int) $_SESSION["USER_ID"]);
								$rs	 = $db->execute($sql);
								
								if ($rs->fields['pl_files'] != '') {
									$keys	= unserialize($rs->fields['pl_files']);
									$qstr	 = implode("','", $keys);
									$sql	 = sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`file_key` IN ('%s') AND A.`file_title` LIKE '%s';", $type, $qstr, $query.'%');
								} else {
									$sql = false;
								}
							}
						}
						
						break;
				}

				switch ($_s) {
                			case "file-menu-entry2":
                			case "file-menu-entry3":
                			case "file-menu-entry4":
                			case "file-menu-entry5":
                				$sql	 = sprintf("SELECT `%s` FROM `db_%s%s` WHERE `usr_id`='%s' LIMIT 1;", $db_field, $type, $db_tbl, (int) $_SESSION["USER_ID"]);
                				$rs	 = $db->execute($sql);
                				
                				if ($rs->fields[$db_field] != '') {
                					$keys 	 = unserialize($rs->fields[$db_field]);
                					$qstr	 = implode("','", $keys);
                					$sql	 = sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`file_key` IN ('%s') AND A.`file_title` LIKE '%s';", $type, $qstr, $query.'%');
                				} else {
                					$sql 	= false;
                				}
                				break;
                		}
                	break;
                	case "files":
                	case "xfer_new":
                		$fields = array('file_title', 'file_key');

                		switch ($_GET["s"]) {
                			case "backend-menu-entry6-sub1": $type = 'video'; break;
                			case "backend-menu-entry6-sub2": $type = 'image'; break;
                			case "backend-menu-entry6-sub3": $type = 'audio'; break;
                			case "backend-menu-entry6-sub4": $type = 'doc'; break;
                			case "backend-menu-entry6-sub5": $type = 'blog'; break;
					case "backend-menu-entry6-sub6": $type = 'live'; break;
                		}

                		$sql	 = sprintf("SELECT A.`file_key`, A.`file_title` FROM `db_%sfiles` A WHERE A.`file_title` LIKE '%s';", $type, $query.'%');
                	break;
                	case "xfer_list":
                		$fields = array('file_title', 'file_key');

                		$sql	 = sprintf("SELECT A.`file_key`, A.`file_title`, C.`file_key` FROM `db_%sfiles` A, `db_%stransfers` C WHERE A.`file_key`=C.`file_key` AND A.`file_title` LIKE '%s';", $type, $type, $query.'%');
                	break;
                	case "accounts":
                	case "private_message":
                		$sql     = sprintf("SELECT `usr_key`, `usr_user` FROM `db_accountuser` WHERE `usr_user` LIKE '%s';", $query.'%');
                	break;
                	case "upload":
                	case "import":
                	case "new_blog":
                		$sql     = sprintf("SELECT `usr_key`, `usr_user` FROM `db_accountuser` WHERE `usr_user` LIKE '%s' AND `usr_status`='1';", $query.'%');
                	break;
                }
        
                if ($query and $sql) {
                        $res     = $db->execute($sql);

                        if ($res->fields[$fields[0]]) {
                                $obj    = array();
                                while (!$res->EOF) {
                                        $obj[]  = array("value" => html_entity_decode($res->fields[$fields[0]]), "data" => $res->fields[$fields[1]]);
        
                                        $res->MoveNext();
                                }
        
                                $output['suggestions'] = $obj;
                        }
        
                        echo json_encode($output);
                }
        }
        /* load backend css plugins (minified) */
        public static function becssplugins() {
        	global $cfg, $href, $section, $smarty, $class_filter;

        	$html	= null;
        	$uid	= $_SESSION["ADMIN_NAME"];

        	switch ($section) {
        		case VHref::getKey("be_dashboard"):
        		case VHref::getKey("be_analytics"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url_be"].'/dash.css">';
        		break;
        		case VHref::getKey("be_affiliate"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/datepicker/tiny-date-picker.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/datepicker/date-range-picker.min.css">';
        		break;
        		case VHref::getKey("be_subscribers"):
        		case VHref::getKey("be_tokens"):
        			$html.= (isset($_GET["rg"]) and (int) $_GET["rg"] == 1) ? '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url_be"].'/dash.css">' : null;
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/datepicker/tiny-date-picker.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/datepicker/date-range-picker.min.css">';
        		break;
        		case VHref::getKey("be_upload"):
        			$html.= '<link type="text/css" rel="stylesheet" href="'.$cfg["javascript_url"].'/uploader/jquery.plupload.queue/css/jquery.plupload.queue.min.css" media="screen">';
        		break;
        		case VHref::getKey("be_import"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/grabber/grabber.min.css">';
        		break;
        	}

        	if ($uid == $cfg["backend_username"] and ($cfg["video_player"] == 'vjs' or $cfg["audio_player"] == 'vjs')) {
        		$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url_be"].'/init1.min.css">';
        		$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/lightbox/jquery.fancybox.min.css">';
        		$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/multilevelmenu/css/component.min.css">';
        		$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/autocomplete/jquery.autocomplete.min.css">';
        		$html.= '<link href="https://vjs.zencdn.net/5.19/video-js.min.css" rel="stylesheet">';
        		$html.= '<link href="'.$cfg["scripts_url"].'/shared/videojs/videojs-styles.min.css" rel="stylesheet">';
        	} elseif ($uid == '' or $uid != $cfg["backend_username"]) {
        		$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url_be"].'/login.min.css">';
        	}

        	return $html;
        }
	/* load backend javascript plugins (minified) */
        public static function bejsplugins() {
        	global $cfg, $href, $section, $smarty, $class_filter;

        	$html	= null;
        	$uid	= $_SESSION["ADMIN_NAME"];

        	if (!isset($_GET["rg"])) {
        		$html.= '<script type="text/javascript" src="'.$cfg["javascript_url_be"].'/fw.init.min.js"></script>';
        	}

        	switch ($section) {
        		case VHref::getKey("be_affiliate"):
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/datepicker/tiny-date-picker.min.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/datepicker/date-range-picker.min.js"></script>';
        			$html.= '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
        			$html.= '<script async defer src="https://maps.googleapis.com/maps/api/js?key='.$cfg["affiliate_maps_api_key"].'" type="text/javascript"></script>';
        		break;
        		case VHref::getKey("be_analytics"):
        			$html.= "<script>(function(w,d,s,g,js,fs){g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};js=d.createElement(s);fs=d.getElementsByTagName(s)[0];js.src='https://apis.google.com/js/platform.js';fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};}(window,document,'script'));</script>";
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/Chart.min.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/moment.min.js"></script>';
        			$html.= '<script type="text/javascript" src=\'https://www.google.com/jsapi?autoload={"modules": [{"name": "visualization", "packages": ["geochart","table","controls"], "version": "1"}]}\'>';
        			$html.= '<script async defer src="https://maps.googleapis.com/maps/api/js?key='.$cfg["google_analytics_maps"].'" type="text/javascript"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/view-selector2.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/date-range-selector.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/active-users.js"></script>';
        			$html.= $smarty->fetch("tpl_backend/tpl_affiliatejs_min.tpl");
        		break;
        		case VHref::getKey("be_dashboard"):
        			$html.= '<script type="text/javascript" src="'.$cfg["javascript_url_be"].'/jsapi.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/Chart.min.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/moment.min.js"></script>';
        			$html.= $smarty->fetch("tpl_backend/tpl_affiliatejs_min.tpl");
        			$html.= '<script type="text/javascript">$(document).ready(function () {$(".icheck-box input").each(function () {var self = $(this);self.iCheck({checkboxClass: "icheckbox_square-blue",radioClass: "iradio_square-blue",increaseArea: "20%"});});$(".icheck-box").toggleClass("no-display");$(".filters-loading").addClass("no-display");});</script>';
        		break;
        		case VHref::getKey("be_subscribers"):
        		case VHref::getKey("be_tokens"):
        			$html.= (isset($_GET["rg"]) and (int) $_GET["rg"] == 1) ? '<script type="text/javascript" src="'.$cfg["javascript_url_be"].'/jsapi.js"></script>' : null;
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/datepicker/tiny-date-picker.min.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/datepicker/date-range-picker.min.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/Chart.min.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["modules_url_be"].'/m_tools/m_gasp/dash/moment.min.js"></script>';
        			$html.= $smarty->fetch("tpl_backend/tpl_affiliatejs_min.tpl");
        			$html.= (isset($_GET["rg"]) and (int) $_GET["rg"] == 1) ? '<script type="text/javascript">$(document).ready(function () {$(".icheck-box input").each(function () {var self = $(this);self.iCheck({checkboxClass: "icheckbox_square-blue",radioClass: "iradio_square-blue",increaseArea: "20%"});});$(".icheck-box").toggleClass("no-display");$(".filters-loading").addClass("no-display");});</script>' : null;
        		break;
        		case VHref::getKey("be_upload"):
        			$html.= $smarty->fetch("tpl_backend/tpl_uploadjs_min.tpl");
        		break;
        		case VHref::getKey("be_import"):
        			$html.= '<script src="'.$cfg["scripts_url"].'/shared/grabber/grabber.js"></script>';
        			$html.= '<script type="text/javascript">'.$smarty->fetch("f_scripts/be/js/settings-accordion.js").'</script>';
        		break;
        		default:
        			if ($uid == '' or $uid != $cfg["backend_username"])
        				$html.= $smarty->fetch("tpl_backend/tpl_loginjs_min.tpl");
        		break;
        	}

        	if ($uid == $cfg["backend_username"] and ($cfg["video_player"] == 'vjs' or $cfg["audio_player"] == 'vjs')) {
        		$html.= '<script src="https://vjs.zencdn.net/5.19/video.min.js"></script>';
        		$html.= '<script src="'.$cfg["scripts_url"].'/shared/videojs/videojs-scripts.min.js"></script>';
//        		$html.= '<script src="https://cdn.streamroot.io/videojs-hlsjs-plugin/1/stable/videojs-hlsjs-plugin.js"></script>';
        		$html.= '<script defer async src="'.$cfg["scripts_url"].'/shared/videojs/videojs-hlsjs-plugin.js"></script>';
        	}
        	if ($uid == $cfg["backend_username"] and ($cfg["video_player"] == 'jw' or $cfg["audio_player"] == 'jw')) {
        		$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/jwplayer/jwplayer.js"></script>';
        	}

        	return $html;
        }
        /* load frontend css plugins (minified) */
        public static function cssplugins() {
        	global $cfg, $href, $section, $smarty, $class_filter, $db;

        	$html	= null;
        	$uid	= (int) $_SESSION["USER_ID"];

        	$html.= $cfg["google_webmaster"] != '' ? '<meta name="google-site-verification" content="'.$cfg["google_webmaster"].'">' : null;
        	$html.= $cfg["yahoo_explorer"] != '' ? '<meta name="y_key" content="'.$cfg["yahoo_explorer"].'">' : null;
        	$html.= $cfg["bing_validate"] != '' ? '<meta name="msvalidate.01" content="'.$cfg["bing_validate"].'">' : null;

        	switch ($section) {
        		case VHref::getKey("index"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/home.min.css">';
        			//$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/owl.min.css">';
        			$html.= $uid > 0 ? '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheckblue.min.css">' : null;
        		break;
        		case VHref::getKey("watch"):
        			//$html.= $smarty->fetch("tpl_frontend/tpl_headview_min.tpl");
        			//$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/owl.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheck.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/view.min.css">';
        			$html.= $smarty->fetch("tpl_frontend/tpl_viewcss_min.tpl");
        		break;
        		case VHref::getKey("upload"):
        		case VHref::getKey("import"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/grabber/grabber.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheck.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["javascript_url"].'/uploader/jquery.plupload.queue/css/jquery.plupload.queue.min.css">';
        		break;
        		case VHref::getKey("subscribers"):
        		case VHref::getKey("affiliate"):
        		case VHref::getKey("tokens"):
        			$html.= $smarty->fetch("tpl_frontend/tpl_affiliatecss_min.tpl");
        		break;
        		case VHref::getKey("search"):
        			$html.= (isset($_GET["tf"]) and (int) $_GET["tf"] == 6) ? '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/channel.min.css">' : null;
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/search.min.css">';
        		break;
        		case VHref::getKey("channels"):
        			$html.= $uid > 0 ? '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheckblue.min.css">' : null;
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/channel.min.css">';
        		break;
        		case VHref::getKey("channel"):
        			$cs   = $smarty->getTemplateVars('channel_module');

        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheck.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/channel.init.min.css">';
        			$html.= $cs == VHref::getKey('discussion') ? '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/view.min.css">' : null;
        		break;
        		case VHref::getKey("manage_channel"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheckblue.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/cropper/cropper.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/channel.manage.min.css">';
        		break;
        		case VHref::getKey("account"):
        		case VHref::getKey("files"):
        		case VHref::getKey("messages"):
        		case VHref::getKey("subscriptions"):
        		case VHref::getKey("following"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheckblue.min.css">';
        		break;
        		case VHref::getKey("respond"):
        		case VHref::getKey("comments"):
        		case VHref::getKey("files_edit"):
        		case VHref::getKey("playlists"):
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/view.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheckblue.min.css">';
        		break;
        		case VHref::getKey("signin"):
        		case VHref::getKey("signup"):
        		case VHref::getKey("x_recovery"):
        		case VHref::getKey("service"):
        		case VHref::getKey("renew"):
        		case VHref::getKey("x_payment"):
        			if (isset($_GET["next"])) {
                                        $n = explode('/', $class_filter->clr_str($_GET["next"]));
                                        $t = $class_filter->clr_str($n[0]);
                                        if ($t === 'v' or $t === 'i' or $t === 'a' or $t === 'd' or $t === 'b' or $t === 'l') {
                                                $k = $class_filter->clr_str($n[1]);
                                                $tp = ($t === 'v' ? 'video' : ($t === 'i' ? 'image' : ($t === 'a' ? 'audio' : ($t === 'd' ? 'doc' : ($t === 'b' ? 'blog' : ($t === 'l' ? 'live' : 'video'))))));
                                                $uu = $db->execute(sprintf("SELECT A.`usr_key` FROM `db_accountuser` A, `db_%sfiles` B WHERE A.`usr_id`=B.`usr_id` AND B.`file_key`='%s' LIMIT 1", $tp, $k));
                                                $u = $uu->fields["usr_key"];
                                                $smarty->assign('file_key', $k);
                                                $smarty->assign('usr_key', $u);
                                                $smarty->assign('media_files_url', VGenerate::fileURL($tp, $k, 'thumb'));
                                                $html.= $smarty->fetch("tpl_frontend/tpl_headview_min.tpl");
                                        }
                                }

        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/jquery.password.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["scripts_url"].'/shared/icheck/blue/icheckblue.min.css">';
        			$html.= '<link rel="stylesheet" type="text/css" href="'.$cfg["styles_url"].'/login.min.css">';
        		break;
        	}

        	return $html;
        }
        
	/* load frontend javascript plugins (minified) */
        public static function jsplugins() {
        	global $cfg, $href, $section, $smarty, $class_filter;

        	$html	= null;
        	$uid	= (int) $_SESSION["USER_ID"];

        	switch ($section) {
        		case VHref::getKey("index"):
        			//$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/min/index.init.min.js"></script>';
        			//$html.= '<script type="text/javascript">$(document).ready(function(){$("a#inline").fancybox({ minWidth: "80%",  margin: 20 });$(".main-menu-panel-entry-active").click(function(event){if ($("#session-accordion li:first").hasClass("main-menu-panel-entry-active")) {var _url = current_url + menu_section + "?cfg";$.fancybox({ type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: _url });}});});</script>';
        			$html.= '<script type="text/javascript">$(function(){$(".load-more").Lazy({moreLoader:function(element,response){p=$(".load-more").attr("rel-p");$(".load-more").mask(" ");$.get(current_url+menu_section+"?sub&p="+p,function(data){$(data).insertBefore(".load-more");$(".load-more").attr("rel-p",parseInt(p)+1);$(".load-more").unmask();thumbFade();owl=$(".view-list:not(.owl-loaded)");owl.each(function(){t=$(this);to=360;owl.on("initialized.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translated.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translate.owl.carousel",function(event){setTimeout(function(){thumbFade()},to)})});owlinit(owl);$(".load-more-sub").Lazy({threshold:300,pageLoader:function(element){p=$(".load-more-sub").attr("rel-p");$(".load-more").mask(" ");$.get(current_url+menu_section+"?sub&p="+p,function(data){$(data).insertBefore(".load-more-sub");$(".load-more-sub").attr("rel-p",parseInt(p)+1);$(".load-more").unmask();if(parseInt(p)==3){$(".load-more-sub").replaceWith(\'<div id="load-categ" rel-p="1" data-loader="moreLoader"></div>\');$("#load-categ").mask(" ");$.get(current_url+menu_section+"?categ",function(cdata){$(cdata).insertBefore("#load-categ");$("#load-categ").detach();thumbFade();owl=$(".view-list:not(.owl-loaded)");owl.each(function(){t=$(this);to=360;owl.on("initialized.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translated.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translate.owl.carousel",function(event){setTimeout(function(){thumbFade()},to)})});owlinit(owl)})}thumbFade();owl=$(".view-list:not(.owl-loaded)");owl.each(function(){t=$(this);to=360;owl.on("initialized.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translated.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translate.owl.carousel",function(event){setTimeout(function(){thumbFade()},to)})});owlinit(owl)})}})})}})});function toggleArrows(t){if(t.find(".owl-item").last().hasClass("active")&&t.find(".owl-item.active").index()==t.find(".owl-item").first().index()){t.find(".owl-nav .owl-next").addClass("off");t.find(".owl-nav .owl-prev").addClass("off")}else if(t.find(".owl-item").last().hasClass("active")){t.find(".owl-nav .owl-next").addClass("off");t.find(".owl-nav .owl-prev").removeClass("off")}else if(t.find(".owl-item.active").index()==t.find(".owl-item").first().index()){t.find(".owl-nav .owl-next").removeClass("off");t.find(".owl-nav .owl-prev").addClass("off")}else{t.find(".owl-nav .owl-next,.owl-nav .owl-prev").removeClass("off")}}var dinamicSizeSetFunction_view=function(){};function sizeInit(type){}jQuery(window).load(function(){thumbFade()});function oldSafariCSSfix(){if(isOldSafari()){var tabnr=$(".full_width .tabs nav ul li").length;var width=jQuery(".container:first").width()-32;jQuery(".tabs nav ul li").width(width/tabnr-1).css("float","left");jQuery(".tabs nav").css("width",width+1)}}jQuery(window).load(function(){oldSafariCSSfix();$(".recommended_section ul.fileThumbs li").each(function(){if($(this).is(":hidden")){$(this).detach()}})});jQuery(window).resize(function(){oldSafariCSSfix()});jQuery(document).ready(function(){var owl=$(".view-list:not(.owl-loaded)");/*owl.mouseover(function(){$(this).addClass("view-on")}).mouseout(function(){$(this).removeClass("view-on")});*/function toggleArrows(t){if(t.find(".owl-item").last().hasClass("active")&&t.find(".owl-item.active").index()==t.find(".owl-item").first().index()){t.find(".owl-nav .owl-next").addClass("off");t.find(".owl-nav .owl-prev").addClass("off")}else if(t.find(".owl-item").last().hasClass("active")){t.find(".owl-nav.owl-next").addClass("off");t.find(".owl-nav .owl-prev").removeClass("off")}else if(t.find(".owl-item.active").index()==t.find(".owl-item").first().index()){t.find(".owl-nav .owl-next").removeClass("off");t.find(".owl-nav .owl-prev").addClass("off")}else{t.find(".owl-nav .owl-next,.owl-nav .owl-prev").removeClass("off")}}owl.each(function(){t=$(this);to=360;owl.on("initialized.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translated.owl.carousel",function(event){t=$(this);toggleArrows(t)});owl.on("translate.owl.carousel",function(event){setTimeout(function(){thumbFade()},to)})});owlinit(owl)});function owlinit(owl){return;if(typeof owl.html()!=="undefined"&&!owl.hasClass("owl-loaded")){var hh=document.body.offsetWidth;var it=5;if(mobileCheck()){it=hh==360?1:(hh==640?2:it)}owl.owlCarousel({items:6,loop:false,margin:20,navSpeed:100,autoplay:false,dots:true,scrollPerPage:true,nav:true,navText:["<i class=\'iconBe iconBe-chevron-left\'></i>","<i class=\'iconBe iconBe-chevron-right\'></i>"],onInitialized:false,responsive:{0:{items:1,slideBy:1},401:{items:2,slideBy:2},560:{items:3,slideBy:3},768:{items:3,slideBy:3},769:{items:4,slideBy:4},981:{items:5,slideBy:5},1200:{items:it,slideBy:it},1564:{items:6,slideBy:6}}});$(owl).addClass("view-on");owl.on(\'changed.owl.carousel\', function (event){if(event.item.count - event.page.size == event.item.index){$(event.target).find(\'.owl-dots div:last\').addClass(\'active\').siblings().removeClass(\'active\')}});owl.on(\'translated.owl.carousel\',function(){setTimeout(function(){thumbFade()},200)})}}jQuery(document).on({click:function(){var file_key=jQuery(this).attr("rel-key");var file_type=jQuery(this).attr("rel-type");var url=_rel+"?a=cb-watchadd&for=sort-"+file_type;var _this=jQuery(this);if(_this.find(jslang["lss"]=="1"?"icon-check":"icon-warning").hasClass("icon-check")){return}_this.parent().next().mask("");_this.next().text(jslang["loading"]);jQuery.post(url,{"fileid[0]":file_key},function(result){_this.find(".icon-clock").removeClass("icon-clock").addClass(jslang["lss"]=="1"?"icon-check":"icon-warning");_this.next().text(jslang["lss"]=="1"?jslang["inwatchlist"]:jslang["nowatchlist"]);_this.parent().next().unmask()})}},".watch_later_wrap");jQuery(document).on({click:function(){t=$(this);w=getWidth();n1=24;n2=12;if(w<=1563){n1=20;n2=10}if(w<=980){n1=16;n2=8}if(w<=768){n1=12;n2=6}if(w<=560){n1=8;n2=4}t.hide();if(typeof $(".more-loaded").html()!="undefined"){$(".more-loaded").show();t.removeClass("more").addClass("less").html(jslang["showless"]).show();return}$(".more-load").css({"margin-top":"-17px","margin-right":"10px"}).mask(" ");$.get(current_url+"home?rc&rn="+n2,function(data){$(data).insertAfter("#main-view-mode-1-featured-video ul.fileThumbs").addClass("more-loaded");t.removeClass("more").addClass("less").html(jslang["showless"]).show();$(".more-load").unmask();thumbFade()})}},".more-recommended a.more");jQuery(document).on({click:function(){t=$(this);w=getWidth();n1=12;n2=24;if(w<=1563){n1=10;n2=20}if(w<=980){n1=8;n2=16}if(w<=768){n1=6;n2=12}if(w<=560){n1=4;n2=8}$(".more-loaded").hide();t.removeClass("less").addClass("more").html(jslang["showmore"])}},".more-recommended a.less");</script>';
        		break;
        		case VHref::getKey("watch"):
        			$html.= '<script type="text/javascript">var _rel = "'.$cfg["main_url"].'/'.VHref::getKey("files").'";</script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/min/view.init0.min.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/linkify/linkify.init.js"></script>';
        			if (isset($_GET["l"])) {
        				$mobile = VHref::isMobile();
        				$hh     = $mobile ? 280 : 100;
        				$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/iframe.min.js"></script>';
        				$html.= '<script>$(document).ready(function(){var h = window.innerHeight-'.$hh.';if (h > 940) h = 940;var iframe = iFrameResize({log:false, autoResize:true, heightCalculationMethod: "min", maxHeight: h, minHeight: h, scrolling: false, enablePublicMethods: true}, "#vs-chat");});$(window).on("resize", function(){var h = window.innerHeight-'.$hh.';if (h > 940) h = 940; iFrameResize({log:false, autoResize:true, heightCalculationMethod: "min", maxHeight: h, minHeight: h, scrolling: false, enablePublicMethods: true}, "#vs-chat");});</script>';
        			}
        			$html.= $smarty->fetch("tpl_frontend/tpl_viewjs_min.tpl");
        		break;
        		case VHref::getKey("upload"):
        			$error_message = $smarty->getTemplateVars('error_message');
        			if ($error_message == '') {
        				$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/uploader/plupload.full.min.js"></script>';
        				$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/uploader/jquery.plupload.queue/jquery.plupload.queue.js"></script>';
        				$html.= $smarty->fetch("tpl_frontend/tpl_file/tpl_uploadjs.tpl");
        			}
        		break;
        		case VHref::getKey("import"):
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/grabber/grabber.js"></script>';
        			$html.= '<script type="text/javascript">'.$smarty->fetch("f_scripts/be/js/settings-accordion.js").'</script>';
        		break;
        		case VHref::getKey("files"):
        			$html.= $cfg["file_playlists"] == 1 ? '<script type="text/javascript">$(document).ready(function() {new_pl_url = current_url + menu_section + "?s=file-menu-entry6&m=1&a=pl-new";$(".pl-popup").fancybox({ type: "ajax", minWidth: "80%", margin: 10, href: new_pl_url, height: "auto", autoHeight: "true", autoResize: "true", autoCenter: "true" });$(document).on("click", ".plcfg-popup", function() {cfg_pl_url = current_url + menu_section + "?s=" + $(".pl-entry.menu-panel-entry-active").attr("id") + "&m=1&a=pl-cfg";$.fancybox({ type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: cfg_pl_url });});});</script>' : null;
        			$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/jquery.sortable.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/linkify/linkify.init.js"></script>';
        		break;
        		case VHref::getKey("messages"):
        			$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/jquery.sortable.js"></script>';
        		break;
        		case VHref::getKey("files_edit"):
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/jquery.form.js"></script>';
        		break;
        		
        		case VHref::getKey("account"):
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/jquery.form.js"></script>';
        		break;
        		case VHref::getKey("browse"):
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/linkify/linkify.init.js"></script>';
        			/*jquery.jscroll.min.js*/
        			$html.= '<script type="text/javascript">!function(t){function e(){var e,i,n={height:a.innerHeight,width:a.innerWidth};return n.height||(e=r.compatMode,(e||!t.support.boxModel)&&(i="CSS1Compat"===e?f:r.body,n={height:i.clientHeight,width:i.clientWidth})),n}function i(){return{top:a.pageYOffset||f.scrollTop||r.body.scrollTop,left:a.pageXOffset||f.scrollLeft||r.body.scrollLeft}}function n(){var n,l=t(),r=0;if(t.each(d,function(t,e){var i=e.data.selector,n=e.$element;l=l.add(i?n.find(i):n)}),n=l.length)for(o=o||e(),h=h||i();n>r;r++)if(t.contains(f,l[r])){var a,c,p,s=t(l[r]),u={height:s.height(),width:s.width()},g=s.offset(),v=s.data("inview");if(!h||!o)return;g.top+u.height>h.top&&g.top<h.top+o.height&&g.left+u.width>h.left&&g.left<h.left+o.width?(a=h.left>g.left?"right":h.left+o.width<g.left+u.width?"left":"both",c=h.top>g.top?"bottom":h.top+o.height<g.top+u.height?"top":"both",p=a+"-"+c,v&&v===p||s.data("inview",p).trigger("inview",[!0,a,c])):v&&s.data("inview",!1).trigger("inview",[!1])}}var o,h,l,d={},r=document,a=window,f=r.documentElement,c=t.expando;t.event.special.inview={add:function(e){d[e.guid+"-"+this[c]]={data:e,$element:t(this)},l||t.isEmptyObject(d)||(l=setInterval(n,250))},remove:function(e){try{delete d[e.guid+"-"+this[c]]}catch(i){}t.isEmptyObject(d)&&(clearInterval(l),l=null)}},t(a).bind("scroll resize scrollstop",function(){o=h=null}),!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){h=null})}(jQuery);</script>';
        		break;
        		case VHref::getKey("channels"):
        			/*jquery.jscroll.min.js*/
        			$html.= '<script type="text/javascript">!function(t){function e(){var e,i,n={height:a.innerHeight,width:a.innerWidth};return n.height||(e=r.compatMode,(e||!t.support.boxModel)&&(i="CSS1Compat"===e?f:r.body,n={height:i.clientHeight,width:i.clientWidth})),n}function i(){return{top:a.pageYOffset||f.scrollTop||r.body.scrollTop,left:a.pageXOffset||f.scrollLeft||r.body.scrollLeft}}function n(){var n,l=t(),r=0;if(t.each(d,function(t,e){var i=e.data.selector,n=e.$element;l=l.add(i?n.find(i):n)}),n=l.length)for(o=o||e(),h=h||i();n>r;r++)if(t.contains(f,l[r])){var a,c,p,s=t(l[r]),u={height:s.height(),width:s.width()},g=s.offset(),v=s.data("inview");if(!h||!o)return;g.top+u.height>h.top&&g.top<h.top+o.height&&g.left+u.width>h.left&&g.left<h.left+o.width?(a=h.left>g.left?"right":h.left+o.width<g.left+u.width?"left":"both",c=h.top>g.top?"bottom":h.top+o.height<g.top+u.height?"top":"both",p=a+"-"+c,v&&v===p||s.data("inview",p).trigger("inview",[!0,a,c])):v&&s.data("inview",!1).trigger("inview",[!1])}}var o,h,l,d={},r=document,a=window,f=r.documentElement,c=t.expando;t.event.special.inview={add:function(e){d[e.guid+"-"+this[c]]={data:e,$element:t(this)},l||t.isEmptyObject(d)||(l=setInterval(n,250))},remove:function(e){try{delete d[e.guid+"-"+this[c]]}catch(i){}t.isEmptyObject(d)&&(clearInterval(l),l=null)}},t(a).bind("scroll resize scrollstop",function(){o=h=null}),!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){h=null})}(jQuery);</script>';
        		break;
        		case VHref::getKey("channel"):
        			$cm   = $smarty->getTemplateVars('channel_module');
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/linkify/linkify.init.js"></script>';
        			$html.= ($cfg["comment_emoji"] == 1 and $cm == '') ? '<script type="text/javascript">function lem(){var tc = $(".cbp_tmtimeline .hp-pre").length; $(".cbp_tmtimeline .hp-pre").each(function(index,value){var t=$(this);var c=t.text();var nc=emojione.toImage(c);t.html(nc);if(index===tc-1){$(".spinner.icon-spinner").hide();$(".cbp_tmtimeline .hp-pre").show();$("pre.hp-pre,.act-title span.act-list-action + span").linkify({defaultProtocol:"https",validate:{email:function(value){return false}},ignoreTags:["script","style"]});}});}</script>' : null;
        			$html.= '<script type="text/javascript">$("pre.hp-pre,.act-title span.act-list-action + span").linkify({defaultProtocol:"https",validate:{email:function(value){return false}},ignoreTags:["script","style"]});</script>';
        			$html.= '<script type="text/javascript">(function(){[].slice.call(document.querySelectorAll(".tabs")).forEach(function(el){new CBPFWTabs(el)})})();function isOldSafari(){return!!navigator.userAgent.match(" Safari/")&&!navigator.userAgent.match(" Chrome")&&(!!navigator.userAgent.match(" Version/6.0")||!!navigator.userAgent.match(" Version/5."))}function oldSafariCSSfix(){return}(function(){jQuery(document).on({click:function(){}},"#channel-tabs ul:not(#main-content ul):not(.fileThumbs) li")})();jQuery(window).load(function(){oldSafariCSSfix()});jQuery(window).resize(function(){oldSafariCSSfix()});function html2amp(str){return str.replace(/&amp;/g,"&")}</script>';
        			/*jquery.jscroll.min.js*/
        			$html.= '<script type="text/javascript">!function(t){function e(){var e,i,n={height:a.innerHeight,width:a.innerWidth};return n.height||(e=r.compatMode,(e||!t.support.boxModel)&&(i="CSS1Compat"===e?f:r.body,n={height:i.clientHeight,width:i.clientWidth})),n}function i(){return{top:a.pageYOffset||f.scrollTop||r.body.scrollTop,left:a.pageXOffset||f.scrollLeft||r.body.scrollLeft}}function n(){var n,l=t(),r=0;if(t.each(d,function(t,e){var i=e.data.selector,n=e.$element;l=l.add(i?n.find(i):n)}),n=l.length)for(o=o||e(),h=h||i();n>r;r++)if(t.contains(f,l[r])){var a,c,p,s=t(l[r]),u={height:s.height(),width:s.width()},g=s.offset(),v=s.data("inview");if(!h||!o)return;g.top+u.height>h.top&&g.top<h.top+o.height&&g.left+u.width>h.left&&g.left<h.left+o.width?(a=h.left>g.left?"right":h.left+o.width<g.left+u.width?"left":"both",c=h.top>g.top?"bottom":h.top+o.height<g.top+u.height?"top":"both",p=a+"-"+c,v&&v===p||s.data("inview",p).trigger("inview",[!0,a,c])):v&&s.data("inview",!1).trigger("inview",[!1])}}var o,h,l,d={},r=document,a=window,f=r.documentElement,c=t.expando;t.event.special.inview={add:function(e){d[e.guid+"-"+this[c]]={data:e,$element:t(this)},l||t.isEmptyObject(d)||(l=setInterval(n,250))},remove:function(e){try{delete d[e.guid+"-"+this[c]]}catch(i){}t.isEmptyObject(d)&&(clearInterval(l),l=null)}},t(a).bind("scroll resize scrollstop",function(){o=h=null}),!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){h=null})}(jQuery);</script>';
        			$html.= '<script type="text/javascript">var speed=4;function parallax(){var $slider=document.getElementById("bg-channel-image");var yPos=window.pageYOffset / speed;yPos=-yPos;var coords=\'50%\'+yPos+\'px\';$slider.style.backgroundPosition = coords;}window.addEventListener("scroll", function(){parallax();});</script>';
        		break;
        		case VHref::getKey("subscribers"):
        		case VHref::getKey("affiliate"):
        		case VHref::getKey("tokens"):
        			$html.= $smarty->fetch("tpl_frontend/tpl_affiliatejs_min.tpl");
        		break;
        		case VHref::getKey("subscriptions"):
        		case VHref::getKey("following"):
        			$html.= '<script type="text/javascript">$(document).ready(function(){$("a#inline").fancybox({ minWidth: "80%",  margin: 20 });$(".menu-panel-entry-active").click(function(event){if ($("#session-accordion li:first").hasClass("menu-panel-entry-active")) {var _url = current_url + menu_section + "?cfg";$.fancybox({ type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: _url });}});});</script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/jquery.sortable.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/linkify/linkify.init.js"></script>';
        		break;
        		case VHref::getKey("search"):
        			$html.= '<script type="text/javascript">var q = "'.$class_filter->clr_str($_GET["q"]).'";var current_url=base;var menu_section="'.(((int) $_GET["tf"] == 5 or (int) $_GET["tf"] == 7) ? VHref::getKey("files") : VHref::getKey("search")).'"; var search_menu_section="'.VHref::getKey("search").'";</script>';
				$html.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/search.init.js"></script>';
				$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/linkify/linkify.init.js"></script>';
        			/*jquery.jscroll.min.js*/
        			$html.= '<script type="text/javascript">!function(t){function e(){var e,i,n={height:a.innerHeight,width:a.innerWidth};return n.height||(e=r.compatMode,(e||!t.support.boxModel)&&(i="CSS1Compat"===e?f:r.body,n={height:i.clientHeight,width:i.clientWidth})),n}function i(){return{top:a.pageYOffset||f.scrollTop||r.body.scrollTop,left:a.pageXOffset||f.scrollLeft||r.body.scrollLeft}}function n(){var n,l=t(),r=0;if(t.each(d,function(t,e){var i=e.data.selector,n=e.$element;l=l.add(i?n.find(i):n)}),n=l.length)for(o=o||e(),h=h||i();n>r;r++)if(t.contains(f,l[r])){var a,c,p,s=t(l[r]),u={height:s.height(),width:s.width()},g=s.offset(),v=s.data("inview");if(!h||!o)return;g.top+u.height>h.top&&g.top<h.top+o.height&&g.left+u.width>h.left&&g.left<h.left+o.width?(a=h.left>g.left?"right":h.left+o.width<g.left+u.width?"left":"both",c=h.top>g.top?"bottom":h.top+o.height<g.top+u.height?"top":"both",p=a+"-"+c,v&&v===p||s.data("inview",p).trigger("inview",[!0,a,c])):v&&s.data("inview",!1).trigger("inview",[!1])}}var o,h,l,d={},r=document,a=window,f=r.documentElement,c=t.expando;t.event.special.inview={add:function(e){d[e.guid+"-"+this[c]]={data:e,$element:t(this)},l||t.isEmptyObject(d)||(l=setInterval(n,250))},remove:function(e){try{delete d[e.guid+"-"+this[c]]}catch(i){}t.isEmptyObject(d)&&(clearInterval(l),l=null)}},t(a).bind("scroll resize scrollstop",function(){o=h=null}),!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){h=null})}(jQuery);</script>';
        		break;
        		case VHref::getKey("manage_channel"):
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/jquery.form.js"></script>';
        			$html.= '<script type="text/javascript" src="'.$cfg["scripts_url"].'/shared/cropper/cropper.min.js"></script>';
        			$html.= '<script type="text/javascript">$(document).ready(function() {$(document).on("click", ".cr-popup", function() {crop_url = current_url + menu_section + "?s=channel-menu-entry3&do=edit-crop&t=" + $(this).attr("rel-photo").substr(0, 10);$.fancybox({ type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: crop_url });});$(document).on("click", ".gcr-popup", function() {crop_url = current_url + menu_section + "?s=channel-menu-entry3&do=edit-gcrop&t=" + $(this).attr("rel-photo").substr(0, 10);$.fancybox({ type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: crop_url });});$(document).on("click", ".del-popup", function() {crop_url = current_url + menu_section + "?s=channel-menu-entry3&do=delete-crop&t=" + $(this).attr("rel-photo").substr(0, 10);$.fancybox({ type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: crop_url });});});</script>';
        			$html.= isset($_GET["r"]) ? '<script type="text/javascript">(function () {[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {new CBPFWTabs(el);});})();$(document).ready(function() {$(".tabs ul li#l2").click();});</script>' : null;
        		break;
        		case VHref::getKey("signin"):
        		case VHref::getKey("signup"):
        		case VHref::getKey("x_recovery"):
        		case VHref::getKey("service"):
        		case VHref::getKey("renew"):
        		case VHref::getKey("x_payment"):
        			$html.= $smarty->fetch("tpl_frontend/tpl_signupjs_min.tpl");
        		break;
        	}

        	return $html;
        }
        public static function nrf($num) {
        	if ($num > 1000) {
        		$x		 = round($num);
        		$x_number_format = number_format($x);
        		$x_array	 = explode(',', $x_number_format);
        		$x_parts	 = array('K', 'M', 'B', 'T');
        		$x_count_parts	 = count($x_array) - 1;
        		$x_display	 = $x;
        		$x_display	 = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        		$x_display	.= $x_parts[$x_count_parts - 1];

        		return $x_display;
        	}

        	return $num;
	}
	public static function doThemeSwitch() {
    		global $class_filter, $cfg;

    		if ($_POST["c"]) {
    			$t = $class_filter->clr_str($_POST["c"]);
    			$s = (int)$_GET["be"] == 1 ? 'theme_name_be' : 'theme_name';
    			$_SESSION[$s] = $t;
    		}
        }
        public static function themeSwitch() {
    		global $language, $cfg, $backend_access_url;

		$dm         = 0;
		$_section   = (strstr($_SERVER['REQUEST_URI'], $backend_access_url) == true) ? 'backend' : 'frontend';
		$s          = $_section == 'backend' ? 'theme_name_be' : 'theme_name';

		$tn         = isset($_SESSION[$s]) ? $_SESSION[$s] : $cfg[$s];
		if (strpos($tn, 'dark') !== false) {
			$dm = 1;
		}

		$sel_on     = $dm == 1 ? 'selected' : NULL;
		$sel_off    = $dm == 0 ? 'selected' : NULL;
		$check_on   = $dm == 1 ? 'checked="checked"' : NULL;
		$check_off  = $dm == 0 ? 'checked="checked"' : NULL;
		$sw_on      = $language["frontend.global.switchoff"];
		$sw_off     = $language["frontend.global.switchon"];

    		$switch     = VGenerate::entrySwitch('theme-switch', '', $sel_on, $sel_off, $sw_on, $sw_off, 'theme_switch', $check_on, $check_off);

    		$html = '<style>.ts{float:right}.tsl .ts{float:left; margin-left:35px}.tsl{display:none}.theme-switch{margin-top:-3px;margin-right:5px}.tsl .theme-switch{margin-top:7px}.tsl .switch{margin-bottom:0}</style>
			<div class="place-right">
    				<div class="theme-switch">'.$switch.'</div>
    				<div class="clearfix"></div>
			</div>
    			<script type="text/javascript">jQuery(document).on({click:function(){var be=$("body").hasClass("be")?1:0;t=$(this);c="'.str_replace('dark', '', $cfg["theme_name"]).'";cd="";if(t.is(":checked")){cd="dark";}else{}th=cd+c;if(be==0){$("#fe-color").attr("href","'.$cfg["main_url"].'/f_scripts/fe/css/theme/"+th+".min.css");}$("#be-color").attr("href","'.$cfg["main_url"].'/f_scripts/be/css/theme/"+th+"_backend.min.css");$.post("'.$cfg["main_url"].'/'.VHref::getKey("index").'?a=color&be="+be,{c:th},function(data){if (t.is(":checked")){$("body").addClass("dark");$("#dark-mode-state-text").text("'.$language["frontend.global.on.text"].'");if(typeof $("#vs-chat").html() != "undefined") document.getElementById("vs-chat").contentWindow.postMessage({"viz":"th0","location":window.location.href},"'.$_SESSION["live_chat_server"].'");}else{$("body").removeClass("dark");$("#dark-mode-state-text").text("'.$language["frontend.global.off.text"].'");if(typeof $("#vs-chat").html() != "undefined") document.getElementById("vs-chat").contentWindow.postMessage({"viz":"th1","location":window.location.href},"'.$_SESSION["live_chat_server"].'");}});}},"input[name=theme_switch_check]");</script>';

    	    return $html;
	}
	public static function socialMediaLinks() {
                global $cfg;

                $html   = null;
                $sml    = unserialize($cfg["social_media_links"]);

                for ($i = 1;$i <= 10; $i++) {
                        if (is_array($sml) and isset($sml[$i]["title"])) {
                                $html   .= '<a href="'.$sml[$i]["url"].'" target="_blank" title="'.$sml[$i]["title"].'"><i class="'.$sml[$i]["icon"].'"></i></a>';
                        }
                }

                return $html;
	}
	public static function offlineSettings() {
                global $cfg, $class_database, $language;

                $pcfg   = $class_database->getConfigurations('offline_mode_settings');
                $sml    = unserialize($pcfg["offline_mode_settings"]);

                $input_tpl = '<div id="sm-#NR#">';
                $input_tpl.= '<div id="url-entry#NR#" class="sm-url-entry">';
                $input_tpl.= '<a href="javascript:;" onclick="$(this).parent().next().stop().slideToggle(200)">Image #NR#.</a> - ';
                $input_tpl.= '<label><a href="javascript:;" onclick="$(this).parent().parent().parent().next().stop().detach();$(this).parent().parent().parent().detach()">'.$language["frontend.global.delete.small"].'</a></label>';
                $input_tpl.= '</div>';
                $input_tpl.= '<div id="url-entry-details#NR#" class="url-entry-details" rel-id="#NR#" style="display:none">';
                $input_tpl.= VGenerate::sigleInputEntry('text', 'left-float lh25 wd140', '<label style="margin-top:0">'.$language["backend.menu.entry2.sub1.sm.url"].'</label>', 'left-float', 'sml[#NR#][url]', 'login-input', '#V2#');
                $input_tpl.= '</div>';
                $input_tpl.= '</div>';

                $input_code      = '<script type="text/javascript">var ht="'.str_replace('"', "'", $input_tpl).'"</script>';
                $input_code     .= '<a href="javascript:;" class="place-right sml-add">'.$language["backend.menu.entry2.sub1.sm.add"].'</a><div class="clearfix"></div>';
                $input_code     .= '<div id="url-entry-details-list">';
                if (isset($sml[1]["url"])) {
                        foreach ($sml as $i => $vals) {
                                $l_url          = is_array($sml) ? $sml[$i]["url"] : null;

                                $input_code     .= str_replace(array('#NR#','#V2#'), array($i,$l_url), $input_tpl);
                        }
                }
                $input_code     .= '</div>';

                return $input_code;
        }

}

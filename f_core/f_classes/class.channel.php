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

class VChannel {
	private static $cfg;
	private static $db;
	private static $db_cache;
	private static $dbc;
	private static $filter;
	private static $language;
	private static $href;
	private static $smarty;
	public static $user_key;
	public static $user_id;
	public static $user_name;
	private static $channel_name;
	private static $display_name;
	private static $ch_cfg;
	private static $ch_photos;
	private static $ch_links;
	private static $ch_channels;
	private static $usr_affiliate;
	private static $usr_partner;
	private static $affiliate_badge;
	private static $module;
	private static $valid = false;

	public function __construct() {
		global $cfg, $class_filter, $class_database, $db, $language, $smarty, $href, $section;
		
		require 'f_core/config.href.php';

		self::$cfg	= $cfg;
		self::$db	= $db;
		self::$dbc	= $class_database;
		self::$filter	= $class_filter;
		self::$language = $language;
		self::$href	= $href;
		self::$smarty	= $smarty;
		
		self::$db_cache = false; //change here to enable caching
		
		
		$adr		= $class_filter->clr_str($_SERVER["REQUEST_URI"]);
		
		if ($section == $href["channel"]) {
			if (strpos($adr, $href["channels"]) !== false) {
				$param	= array_pop(explode($href["channel"], str_replace($href["channels"], '---', $adr)));
			} else {
				$param	= array_pop(explode($href["channel"], $adr));
			}
			$e	= explode('/', $param);
			$key	= $e[1];
			$name	= $e[2];
			$module = $e[3] == '---' ? $href["channels"] : $e[3];
			$c	= self::$db_cache ? $cfg['cache_view_user_id'] : false;

			$user_id= $class_database->singleFieldValue('db_accountuser', 'usr_id', 'usr_key', $key, $c);
			
			if ($user_id > 0) {
				self::$user_id		= (int) $user_id;
				self::$user_key		= $key;
				self::$module		= $module;
				self::$valid		= true;
				
				$guest_chk       = (int) $_SESSION["USER_ID"] == 0 ? VHref::guestPermissions('guest_browse_channel', VHref::getKey("channel").'/'.$key.'/'.$name) : NULL;
				
				$smarty->assign('channel_module', $module);
				$smarty->assign('channel_key', $key);
				$smarty->assign('usr_id', self::$user_id);
				
				if ($module == VHref::getKey("broadcasts") or $module == VHref::getKey("videos") or $module == VHref::getKey("images") or $module == VHref::getKey("audios") or $module == VHref::getKey("documents"))
					$smarty->assign('c_section', VHref::getKey("browse"));
				elseif ($module == VHref::getKey("blogs"))
					$smarty->assign('c_section', VHref::getKey("blogs"));
				elseif ($module == VHref::getKey("playlists"))
					$smarty->assign('c_section', VHref::getKey("files"));
				else
					$smarty->assign('c_section', VHref::getKey("channel"));

				$c		= self::$db_cache ? $cfg['cache_channel_ch_cfg'] : false;
				$sql		= sprintf("SELECT `ch_cfg`, `ch_photos`, `ch_links`, `ch_channels`, `ch_title`, `ch_descr`, `ch_tags`, `ch_views`, `usr_partner`, `usr_affiliate`, `affiliate_badge`, `usr_joindate`, `usr_user`, `usr_dname` FROM `db_accountuser` WHERE `usr_id`='%s' LIMIT 1;", self::$user_id);
				$rs		= self::$db_cache ? $db->execute($c, $sql) : $db->execute($sql);
				
				self::$user_name	= $rs->fields["usr_user"];
				self::$display_name	= $rs->fields["usr_dname"];
				self::$usr_affiliate	= $rs->fields["usr_affiliate"];
				self::$usr_partner	= $rs->fields["usr_partner"];
				self::$affiliate_badge	= $rs->fields["affiliate_badge"];
				self::$ch_cfg	= unserialize($rs->fields["ch_cfg"]);
				self::$ch_photos= unserialize($rs->fields["ch_photos"]);
				self::$ch_links = unserialize($rs->fields["ch_links"]);
				self::$ch_channels = unserialize($rs->fields["ch_channels"]);

				self::$ch_cfg["ch_title"] = $rs->fields["ch_title"];
				self::$ch_cfg["ch_descr"] = $rs->fields["ch_descr"];
				self::$ch_cfg["ch_tags"]  = $rs->fields["ch_tags"];
				self::$ch_cfg["ch_views"] = $rs->fields["ch_views"];
				self::$ch_cfg["ch_join"]  = $rs->fields["usr_joindate"];

				self::$channel_name = (self::$ch_cfg["ch_title"] != '' ? self::$ch_cfg["ch_title"] : (self::$display_name != '' ? self::$display_name : self::$user_name));
			}
		} elseif ($section == $href["manage_channel"]) {
			$c		= self::$db_cache ? $cfg['cache_channel_ch_cfg'] : false;
			$sql		= sprintf("SELECT `ch_cfg`, `ch_photos` FROM `db_accountuser` WHERE `usr_id`='%s' LIMIT 1;", self::getUserID());
			$rs		= self::$db_cache ? $db->execute($c, $sql) : $db->execute($sql);
			
			self::$ch_cfg	= unserialize($rs->fields["ch_cfg"]);
			self::$ch_photos= unserialize($rs->fields["ch_photos"]);
			self::$user_id	= self::getUserID();
			
			self::$user_key	= $class_filter->clr_str($_SESSION["USER_KEY"]);
			self::$channel_name = $_SESSION["USER_DNAME"] != '' ? $class_filter->clr_str($_SESSION["USER_DNAME"]) : $class_filter->clr_str($_SESSION["USER_NAME"]);
		}
	}
	/* layout for channel page */
	public static function channelLayout() {
		$cfg		= self::$cfg;
		$ch_cfg		= self::$ch_cfg;
		$ch_links	= self::$ch_links;
		$language	= self::$language;
		$class_database	= self::$dbc;

		$ch_photos	= self::$ch_photos;

		$session_id	= self::getUserID();

		if (!self::$valid) {
			return VGenerate::noticeTpl('', $language["notif.error.invalid.request"], '');
		}
		if ($ch_cfg["ch_visible"] == 0) {
			return VGenerate::noticeTpl('', $language["channel.offline.message"], '');
		}

		/* user follows status */
		if ($cfg["user_follows"] == 1) {
			$sql		= sprintf("SELECT A.`follower_id`, B.`usr_followcount` FROM `db_followers` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`usr_id`='%s' LIMIT 1;", self::$user_id);
			$rs		= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_view_sub_id'], $sql) : self::$db->execute($sql);
			$sub		= $rs->fields["follower_id"];
			$e_arr		= $sub != '' ? unserialize($sub) : array();

			if (sizeof($e_arr) > 0) {
				foreach ($e_arr as $ak => $av) {
					if ($is_sub == 0 and $av["sub_id"] == $session_id) {
						$is_sub = 1;
						break;
					}
				}
			}

			$user_isfollow		 = $is_sub;
			$user_followtotal	 = $rs->fields["usr_followcount"];
		}
		$follow_txt	 = (self::$user_id == $session_id or $session_id == 0) ? $language["frontend.global.followers"] : ($is_sub == 1 ? $language["frontend.global.unfollow"] : $language["frontend.global.follow"]);
		$follow_cls	 = (self::$user_id == $session_id or $session_id == 0) ? 'no-sub' : ($is_sub == 1 ? 'unfollow-action' : 'follow-action');

		$is_sub = 0;
		/* user subscription status */
		if ($cfg["user_subscriptions"] == 1) {
			$sql		= sprintf("SELECT A.`subscriber_id`, B.`usr_subcount` FROM `db_subscribers` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`usr_id`='%s' LIMIT 1;", self::$user_id);
			$rs		= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_view_sub_id'], $sql) : self::$db->execute($sql);
			$sub		= $rs->fields["subscriber_id"];
			$e_arr		= $sub != '' ? unserialize($sub) : array();

			if (sizeof($e_arr) > 0) {
				foreach ($e_arr as $ak => $av) {
					if ($is_sub == 0 and $av["sub_id"] == $session_id) {
						$is_sub = 1;
						break;
					}
				}
			}
			if ($is_sub == 0) {
				$ts = self::$db->execute(sprintf("SELECT `db_id` FROM `db_subtemps` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' AND `active`='1' LIMIT 1;", (int) $_SESSION["USER_ID"], (int) self::$user_id, date("Y-m-d H:i:s")));
				if ($ts->fields["db_id"]) {
					$is_sub = 1;
				}
			}
			$user_issub	 = $is_sub;
			$user_subtotal	 = $rs->fields["usr_subcount"];
		}
		$sub_txt	 = (self::$user_id == $session_id or $session_id == 0) ? $language["frontend.global.subscribers"] : ($is_sub == 1 ? $language["frontend.global.unsubscribe"] : $language["frontend.global.subscribe"]);
		$sub_cls	 = (self::$user_id == $session_id or $session_id == 0) ? 'no-sub' : ($is_sub == 1 ? 'unsubscribe-button' : 'subscribe-button');
		$channel_url	 = $cfg['main_url'].'/'.VHref::getKey('channel').'/'.self::$user_key.'/'.self::$user_name;

		/* channel links */
		if (!empty($ch_links)) {
			$ch_links_html		 = '<ul>';
			foreach ($ch_links as $k => $url) {
				if ($k == 0) {
					$ch_links_html	.= '<li class="p"><a href="'.$url["url"].'" title="'.$url["title"].'" rel="me nofollow" target="_blank"><img width="16" height="16" src="https://s2.googleusercontent.com/s2/favicons?domain_url='.(self::strbefore($url["url"], '?')).'"><span>'.$url["title"].'</span></a></li>';
					$ch_links_html	.= '</ul><ul>';
				} else {
					$ch_links_html	.= '<li class="s"><a href="'.$url["url"].'" title="'.$url["title"].'" rel="me nofollow" target="_blank"><img width="16" height="16" src="https://s2.googleusercontent.com/s2/favicons?domain_url='.(self::strbefore($url["url"], '?')).'"></a></li>';
				}
			}
			$ch_links_html		.= '</ul>';
		}
		
		
		$header_image	= file_exists($cfg["profile_images_dir"].'/'.self::$user_key.'/'.self::$user_key.'-'.$ch_photos['default'].'-large.jpg') ? $cfg["profile_images_url"].'/'.self::$user_key.'/'.self::$user_key.'-'.$ch_photos['default'].'-large.jpg' : false;
		
		$_uimg	= VUseraccount::getProfileImage(self::$user_id);

		if ($is_sub) {
			$ub	= 1;
			$suid	= self::$dbc->singleFieldValue('db_accountuser', 'usr_id', 'usr_key', self::$user_key, (self::$db_cache ? self::$cfg['cache_view_sub_id'] : false));
			$sql	= sprintf("SELECT A.`db_id`, A.`expire_time`, B.`pk_name` FROM `db_subusers` A, `db_subtypes` B WHERE A.`usr_id`='%s' AND A.`usr_id_to`='%s' AND A.`pk_id`=B.`pk_id` AND A.`pk_id`>'0' LIMIT 1;", (int) $_SESSION["USER_ID"], $suid);
			$nn	= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_view_sub_id'], $sql) : self::$db->execute($sql);
			$sn	= $nn->fields["pk_name"].'<br><span class="csm"><label class="">'.self::$language["frontend.global.active.until"].'</label> '.$nn->fields["expire_time"].'</span>';
			
			if (!$nn->fields["db_id"]) {
				$ub	= 0;
				$sql	= sprintf("SELECT A.`db_id`, A.`expire_time`, B.`pk_name` FROM `db_subtemps` A, `db_subtypes` B WHERE A.`usr_id`='%s' AND A.`usr_id_to`='%s' AND A.`pk_id`=B.`pk_id` AND A.`pk_id`>'0' AND A.`expire_time`>='%s' LIMIT 1;", (int) $_SESSION["USER_ID"], $suid, date("Y-m-d H:i:s"));
				$nn	= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_view_sub_id'], $sql) : self::$db->execute($sql);
				$sn	= $nn->fields["pk_name"].'<br><span class="csm"><label class="">'.self::$language["frontend.global.active.until"].'</label> '.$nn->fields["expire_time"].'</span>';
			}
		}

		/* start layout */

		$html	= $cfg['channel_backgrounds'] == 1 ? '	<style>'.self::CSS().'</style>' : null;

		$html  .= '	
				'.($cfg['channel_backgrounds'] == 1 ? '<div id="channel-header">
					<figure>
						<div class="crop-height bg-channel-image bg-left-top" id="bg-channel-image">
							<div class="channel-logo"><img height="128" src="' . $_uimg . '" alt="'.self::$channel_name.'" title="'.self::$channel_name.'"></div>
							
							'.($header_image ? '<img height="800" src="'.$header_image.'" class="transparent">' : null).'
							
							<div class="channel-links">
								<div class="channel-links-list">
									'.$ch_links_html.'
								</div>
							</div>
						</div>
					</figure>
				</div>
				' : null).'

				'.(isset($_GET["fsn"]) ? VGenerate::noticeTpl('', '', self::$language["notif.success.subscribe"]) : null).'

				<div id="channel-subscribe">
					<div class="place-left channel-heading"><h1>'.VAffiliate::affiliateBadge(((self::$usr_affiliate == 1 or self::$usr_partner == 1) ? 1 : 0), self::$affiliate_badge).self::$channel_name.'</h1></div>
					<div class="place-right channel-subscribe-button">
						'.((self::$cfg["user_subscriptions"] == 1 or self::$cfg["user_follows"] == 1) ? '
						<div class="subscribers profile_count">
							'.(self::$cfg["user_subscriptions"] == 1 ? '
							'.($is_sub ? '<a href="javascript:;" onclick="$(\'#uu-'.self::$user_key.'\').stop().slideToggle(\'fast\')" class="sub-opt"><div class="sub-txt">'.self::$language["frontend.global.subscription"].'</div></a>' : '<a href="javascript:;" class="'.$sub_cls.' count_link ch-'.self::$user_key.'" rel-usr="'.self::$user_key.'" rel="nofollow"><div class="sub-txt sub-txt-'.self::$user_key.'"'.((int) $_SESSION["USER_ID"] == 0 ? ' rel="tooltip" title="'.self::$language["main.text.subscribe"].'"' : null).'>'.((int) $_SESSION["USER_ID"] != self::$user_id ? $sub_txt : self::$language["frontend.global.subscribers.cap"]).' '.VFiles::numFormat((int) $user_subtotal).'</div></a>').''
							: null).'
							'.(self::$cfg["user_follows"] == 1 ? '
							<a href="javascript:;" class="count_link '.$follow_cls.'" rel="nofollow">
								<div class="follow-txt">'.$follow_txt.' '.VFiles::numFormat((int) $user_followtotal).'</div>
							</a>' : null).'
						</div>
						
						<ul class="uu arrow_box" id="uu-'.self::$user_key.'" style="display: none;">
                                                                                                <li class="uu1"><i class="icon-star"></i> '.self::$language["frontend.global.sub.your"].'</li>
                                                                                                <li class="uu2"><img src="'.$_uimg.'" height="48"> <a href="'.$cfg["main_url"].'/'.VHref::getKey('channel').'/'.self::$user_key.'/'.self::$channel_name.'">'.self::$channel_name.'</a> - '.$sn.'</li>
                                                                                                <li><center>
                                                                                                        <button type="button" class="subscribe-button save-entry-button button-grey search-button form-button sub-uu" rel-usr="'.self::$user_key.'" value="1" name="upgrade_subscription"><span>'.self::$language["frontend.global.sub.upgrade"].'</span></button>
                                                                                                        '.($ub ? '<a class="unsubscribe-button cancel-trigger" rel-usr="'.self::$user_key.'" href="javascript:;"><span>'.self::$language["frontend.global.unsubscribe"].'</span></a>' : null).'
                                                                                                        </center>
                                                                                                </li>
                                                                                        </ul>

						
						' : null).'
					</div>
				</div>
				<div class="clearfix"></div>
				<div id="channel-tabs" class="">
					<nav>
						<ul class="channel-tab-list" id="l1">
							'.(($ch_cfg["ch_m_activity"] == 1 and $cfg["activity_logging"] == 1) ? '<li class="'.self::activeTabClass('activity').'"><a href="'.$channel_url.'" class="icon icon-connection"><span>'.$language["frontend.global.activity"].'</span></a></li>' : null).'
							'.($ch_cfg["ch_m_about"] == 1 ? '<li class="'.self::activeTabClass('about').'"><a href="'.$channel_url.'/'.VHref::getKey('about').'" class="icon icon-info"><span>'.$language["frontend.global.about"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_videos"] == 1 and $cfg["video_module"] == 1) ? '<li class="'.self::activeTabClass('videos').'"><a href="'.$channel_url.'/'.VHref::getKey('videos').'" class="icon icon-video"><span>'.$language["frontend.global.v.p.c"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_live"] == 1 and $cfg["live_module"] == 1) ? '<li class="'.self::activeTabClass('broadcasts').'"><a href="'.$channel_url.'/'.VHref::getKey('broadcasts').'" class="icon icon-live"><span>'.$language["frontend.global.l.p.c"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_images"] == 1 and $cfg["image_module"] == 1) ? '<li class="'.self::activeTabClass('pictures').'"><a href="'.$channel_url.'/'.VHref::getKey('images').'" class="icon icon-image"><span>'.$language["frontend.global.i.p.c"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_audios"] == 1 and $cfg["audio_module"] == 1) ? '<li class="'.self::activeTabClass('music').'"><a href="'.$channel_url.'/'.VHref::getKey('audios').'" class="icon icon-audio"><span>'.$language["frontend.global.a.p.c"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_documents"] == 1 and $cfg["document_module"] == 1) ? '<li class="'.self::activeTabClass('documents').'"><a href="'.$channel_url.'/'.VHref::getKey('documents').'" class="icon icon-file"><span>'.$language["frontend.global.d.p.c"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_blogs"] == 1 and $cfg["blog_module"] == 1) ? '<li id="ch-bl" class="'.self::activeTabClass('blogs').'"><a href="'.$channel_url.'/'.VHref::getKey('blogs').'" class="icon icon-pencil2"><span>'.$language["frontend.global.blogs"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_playlists"] == 1 and $cfg["file_playlists"] == 1) ? '<li id="ch-pl" class="'.self::activeTabClass('playlists').'"><a href="'.$channel_url.'/'.VHref::getKey('playlists').'" class="icon icon-list"><span>'.$language["frontend.global.playlists"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_discussion"] == 1 and $cfg["channel_comments"] == 1) ? '<li class="'.self::activeTabClass('discussion').'"><a href="'.$channel_url.'/'.VHref::getKey('discussion').'" class="icon icon-comments"><span>'.$language["frontend.global.discussion"].'</span></a></li>' : null).'
							<li class="'.((self::$module == VHref::getKey("channels") or self::$module == VHref::getKey("followers") or self::$module == VHref::getKey("following") or self::$module == VHref::getKey("subscribers") or self::$module == VHref::getKey("subscriptions")) ? 'tab-current' : null).'"><a href="javascript:;" onclick="$(this).parent().toggleClass(\'tab-current\'); $(\'#l2\').stop().toggle(300)" class="icon icon-plus"><span>'.$language["frontend.global.more.text"].'</span></a></li>
						</ul>
						<ul class="channel-tab-list" id="l2" style="display: '.((self::$module == VHref::getKey("channels") or self::$module == VHref::getKey("followers") or self::$module == VHref::getKey("following") or self::$module == VHref::getKey("subscribers") or self::$module == VHref::getKey("subscriptions")) ? 'table' : 'none').';">
							'.($ch_cfg["ch_m_channels"] == 1 ? '<li class="'.self::activeTabClass('channels').'"><a href="'.$channel_url.'/'.VHref::getKey('channels').'" class="icon icon-users"><span>'.$language["frontend.global.channels"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_followers"] == 1 and $cfg["user_follows"] == 1) ? '<li class="'.self::activeTabClass('followers').'"><a href="'.$channel_url.'/'.VHref::getKey('followers').'" class="icon icon-users5"><span>'.$language["frontend.global.followers.cap"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_following"] == 1 and $cfg["user_follows"] == 1) ? '<li class="'.self::activeTabClass('following').'"><a href="'.$channel_url.'/'.VHref::getKey('following').'" class="icon icon-users5"><span>'.$language["frontend.global.following.cap"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_subscribers"] == 1 and $cfg["user_subscriptions"] == 1) ? '<li class="'.self::activeTabClass('subscribers').'"><a href="'.$channel_url.'/'.VHref::getKey('subscribers').'" class="icon icon-users5"><span>'.$language["frontend.global.subscribers.cap"].'</span></a></li>' : null).'
							'.(($ch_cfg["ch_m_subscriptions"] == 1 and $cfg["user_subscriptions"] == 1) ? '<li class="'.self::activeTabClass('subscriptions').'"><a href="'.$channel_url.'/'.VHref::getKey('subscriptions').'" class="icon icon-users5"><span>'.$language["subnav.entry.sub"].'</span></a></li>' : null).'
						</ul>
					</nav>
					<div class="clearfix"></div>
					<div class="content-wrap">
						'.self::sectionModuleLoader().'
					</div>
				</div>
			';
		
		$html	.= VGenerate::declareJS('var ch_url = "'.$cfg['main_url'].'/'.VHref::getKey('channel').'/'.self::$user_key.'/'.self::$user_name.'"; var ch_id = "'.self::$user_key.'";');
		/* subscribe/unsubscribe action */
                if ($cfg["user_subscriptions"] == 1 or $cfg["user_follows"] == 1) {
			$html		.= '<form id="user-files-form" method="post" action=""><input type="hidden" name="uf_vuid" value="'.self::$user_id.'" /></form>';
			$ht_js		 = 'c_url = "'.$cfg["main_url"].'/'.VHref::getKey('watch').'";';
			if ($cfg["user_subscriptions"] == 1) {
                        $ht_js          .= '$(document).on("click", ".unsubscribe-action", function(e){';
                        $ht_js		.= 'if($("#sub-wrap .sub-txt:first").text()=="'.self::$language["frontend.global.unsubscribed"].'")return;';
                        $ht_js          .= '$("#sub-wrap .sub-txt:first").text("'.self::$language["frontend.global.loading"].'");';
                        $ht_js          .= '$.post("?do=user-unsubscribe", $("#user-files-form").serialize(), function(data){';
                        $ht_js          .= '$("#sub-wrap .sub-txt:first").text("'.self::$language["frontend.global.unsubscribed"].'");';
                        $ht_js          .= '});';
                        $ht_js          .= '});';
                        }
                        if ($cfg["user_follows"] == 1) {
                        $ht_js          .= '$(document).on("click", ".follow-action", function(e){';
                        $ht_js          .= '$(".follow-txt").text("'.self::$language["frontend.global.loading"].'");';
                        $ht_js          .= '$.post(c_url+"?do=user-follow", $("#user-files-form").serialize(), function(data){';
                        $ht_js          .= '$(".follow-txt").text("'.self::$language["frontend.global.followed"].'");';
                        $ht_js          .= '});';
                        $ht_js          .= '});';
                        $ht_js          .= '$(document).on("click", ".unfollow-action", function(e){';
                        $ht_js          .= '$(".follow-txt").text("'.self::$language["frontend.global.loading"].'");';
                        $ht_js          .= '$.post(c_url+"?do=user-unfollow", $("#user-files-form").serialize(), function(data){';
                        $ht_js          .= '$(".follow-txt").text("'.self::$language["frontend.global.unfollowed"].'");';
                        $ht_js          .= '});';
                        $ht_js          .= '});';
                        }
                }
                $html   .= '<script type="text/javascript">$(function(){'.$ht_js.'});</script>';


		return $html;
	}
	/* update channel views number */
	public static function updateViews() {
		$upage_id	= self::$user_id;
		
		if ($upage_id > 0) {
			$view		= new VView;

			VView::updateViewLogs('channel', $upage_id);
		}
	}

	/* generate content for each section module */
	private static function sectionModuleLoader() {
		global $class_smarty;
		
		switch (self::$module) {
			case "":
			case self::$href["activity"]:
				$display_page	= self::activityTimeline();

				break;

			case self::$href["broadcasts"]:
			case self::$href["videos"]:
			case self::$href["images"]:
			case self::$href["audios"]:
			case self::$href["documents"]:
			case self::$href["blogs"]:
				$browse = new VBrowse;
				$files	= new VFiles;
					$display_page = VBrowse::browseLayout();

				break;

			case self::$href["playlists"]:
				$playlist	= new VPlaylist;
				$files		= new VFiles;

				$display_page	= VFiles::listPlaylists();
				
				break;

			case self::$href["comments"]:
			case self::$href["discussion"]:
				$view		= new VView;
				$browse		= new VBrowse;
				$ch		= new VChannel;
				$comm		= new VChannelComments;

				$type		= 'channel';
				$ht_js		= 'var comm_sec = "' . VHref::getKey("see_comments") . '"; var comm_url = "' . self::$cfg["main_url"] . '/"+comm_sec+"?' . $type[0] . '=' . self::$user_id . '"; var m_loading = "";';
				/* comment loading, submit replies */
				$ht_js 		.= 'function commentLazyLoad(){if (!$("#comment-loader").hasClass("loaded")){var t = $("#comment-loader-before");t.html(\'<center><span style="display: block; font-size: 14px;"><i class="spinner icon-spinner"></i> '.self::$language["view.files.comm.loading"].'</span></center>\');setTimeout(function () {$.post(comm_url+"&do=comm-load", {comm_type: "'.$type.'", comm_uid: "'.self::$user_id.'"}, function(data){t.replaceWith(\'<div id="comment-load" class="border-wrapper">\'+data+\'</div>\');t.html(data);$("#comment-loader-before").detach();});},100);}}if (!$("#comment-loader").hasClass("loaded")){commentLazyLoad();}';
				$ht_js		.= '$(function(){$(document).on({click: function (e) {var f1 = $(this).attr("id").substr(3); if($("#r-"+f1).val() != ""){$("#' . $type . '-comment"+f1).mask(m_loading);$.post(comm_url+"&do=comm-reply", $("#comm-reply-form"+f1).serialize(), function(data){$("#comment-load").html(data);$("#r-"+f1).val("");$("#' . $type . '-comment"+f1).unmask();$("#comm-post-response").insertBefore("#"+f1);});}}},".reply-comment-button");});';

				$html	 = VGenerate::simpleDivWrap('', 'comment-loader-before', '');
				$html	.= VGenerate::simpleDivWrap('', 'comment-loader', '');
				$html	.= VGenerate::declareJS($ht_js);

				$display_page	= $html;

				break;

			case self::$href["about"]:
				$display_page	= self::aboutPage();

				break;

			case self::$href["subscribers"]:
				$display_page	= self::userList(self::$href["subscribers"]);

				break;

			case self::$href["subscriptions"]:
				$display_page	= self::userList(self::$href["subscriptions"]);

				break;

			case self::$href["followers"]:
				$display_page	= self::userList(self::$href["followers"]);

				break;

			case self::$href["following"]:
				$display_page	= self::userList(self::$href["following"]);

				break;

			case self::$href["channels"]:
				$display_page	= self::userList(self::$href["channels"]);

				break;
		}
		
		$html	= '<section id="section-'.(self::$module == '' ? self::$href["activity"] : self::$module).'" class="content-current">'.$display_page.'</section>';
		
		return $html;
	}
	/* channel page - subscribers, subscriptions */
	private static function userList($type) {
		$db		= self::$db;
		$class_database = self::$dbc;
		$cfg		= self::$cfg;
		$language	= self::$language;
		
		switch ($type) {
			case self::$href["channels"]:
				$h3s	= self::$ch_channels["uc_title"];
				$ch	= self::$ch_channels["uc_names"];
				$ic	= 'icon-users';
				
				
				if (!empty($ch)) {
					$ids		= array();
					$is_sub_array	= array();
					
					foreach ($ch as $u) {
						$ids[] = $class_database->singleFieldValue('db_accountuser', 'usr_id', 'usr_user', $u);
					}
					
					if (!empty($ids)) {
						foreach ($ids as $id) {
							$rs	= $db->execute(sprintf("SELECT `subscriber_id` FROM `db_subscribers` WHERE `usr_id`='%s' LIMIT 1;", $id));
							
							if ($rs->fields["subscriber_id"]) {
								$s	= unserialize($rs->fields["subscriber_id"]);
								
								if (!empty($s)) {
									foreach ($s as $ar) {
										if ($ar["sub_id"] == self::getUserID()) {
											$is_sub_array[] = $id;
										}
									}
								}
							}
						}
					}
				}
				break;
			
			case self::$href["subscribers"]:
			case self::$href["followers"]:
				$ic	= 'icon-users5';
				$h3s	= $language["frontend.global.".$type.".cap"];
				if ($type == self::$href["subscribers"])
					$rs	= $db->execute(sprintf("SELECT `db_id`, `subscriber_id` FROM `db_subscribers` WHERE `usr_id`='%s' LIMIT 1;", self::$user_id));
				else
					$rs	= $db->execute(sprintf("SELECT `db_id`, `follower_id` FROM `db_followers` WHERE `usr_id`='%s' LIMIT 1;", self::$user_id));

				if ($rs->fields["db_id"]) {
					$s	= $type == self::$href["subscribers"] ? unserialize($rs->fields["subscriber_id"]) : unserialize($rs->fields["follower_id"]);
					
					if (!empty($s)) {
						$ids		= array();
						$is_sub_array	= array();
						
						foreach ($s as $ar) {
							$ids[] = $ar["sub_id"];
							
							if (!empty($ids)) {
								foreach ($ids as $id) {
									if ($type == self::$href["subscribers"])
										$rs = $db->execute(sprintf("SELECT `db_id`, `subscriber_id` FROM `db_subscribers` WHERE `usr_id`='%s' LIMIT 1;", $id));
									else
										$rs = $db->execute(sprintf("SELECT `db_id`, `follower_id` FROM `db_followers` WHERE `usr_id`='%s' LIMIT 1;", $id));

									if ($rs->fields["db_id"]) {
										$s = $type == self::$href["subscribers"] ? unserialize($rs->fields["subscriber_id"]) : unserialize($rs->fields["follower_id"]);

										if (!empty($s)) {
											foreach ($s as $ar) {
												if ($ar["sub_id"] == self::$user_id) {
													$is_sub_array[] = $id;
												}
											}
										}
									}
								}
							}
						}
					}
				}
				
				break;
			
			case self::$href["subscriptions"]:
			case self::$href["following"]:
				$ic	= 'icon-users5';
				$h3s	= $type == self::$href["subscriptions"] ? $language["subnav.entry.sub"] : $language["frontend.global.following.cap"];
				$s      = 0;
				$sub_ar = array();
				$e_arr  = array();
				$ids	= array();
				$is_sub_array = array();

				if ($type == self::$href["subscriptions"]) 
					$sub	= $db->execute(sprintf("SELECT `usr_id`, `subscriber_id` FROM `db_subscribers` WHERE `db_active`='1' AND `usr_id`!='%s' AND `subscriber_id`!='';", self::$user_id));
				else
					$sub	= $db->execute(sprintf("SELECT `usr_id`, `follower_id` FROM `db_followers` WHERE `db_active`='1' AND `usr_id`!='%s' AND `follower_id`!='';", self::$user_id));

				$subs	= $sub->getrows();

				for ($i = 0; $i < count($subs); $i++) {
					$sub_ar[$i] = $type == self::$href["subscriptions"] ? unserialize($subs[$i]["subscriber_id"]) : unserialize($subs[$i]["follower_id"]);
				}

				foreach ($sub_ar as $val) {
					foreach ($val as $vl) {
						if ($vl["sub_id"] == self::$user_id) {
							$e_arr[$s]["sub_id"] = $subs[$s]["usr_id"];
							$ids[]	= $subs[$s]["usr_id"];
							$is_sub_array[] = $subs[$s]["usr_id"];
						}
					}
					$s = $s + 1;
				}

				break;
		}
		
		if (empty($ids)) {
			return;
		}
		
		$html_li	= null;
		
		$sql     = sprintf("SELECT A.`usr_id`, A.`usr_key`, A.`usr_user`, A.`usr_partner`, A.`usr_affiliate`, A.`affiliate_badge`, A.`usr_dname`, A.`ch_views`, A.`ch_title` FROM `db_accountuser` A WHERE A.`usr_status`='1' AND A.`usr_id` IN (%s);", implode(',', $ids));
						
		$res	 = $db->execute($sql);
		
		if ($res->fields["usr_id"]) {
			$count	= 1;
			
			while (!$res->EOF) {
				$usr_key	 = $res->fields["usr_key"];
				$img_file        = $cfg["profile_images_dir"].'/'.$usr_key.'/'.$usr_key.'.jpg';
                                $img_url         = $cfg["profile_images_url"].'/'.$usr_key.'/'.$usr_key.'.jpg';
                                $def_url         = $cfg["profile_images_url"].'/default.jpg';
                                $bg_url          = file_exists($img_file) ? $img_url : $def_url;

                                $h3              = ($res->fields["usr_dname"] != '' ? $res->fields["usr_dname"] : ($res->fields["ch_title"] != '' ? $res->fields["ch_title"] : $res->fields["usr_user"]));
				$is_sub		 = in_array($res->fields["usr_id"], $is_sub_array) ? true : false;
				$a_cls		 = $is_sub ? 'unsub-action' : 'sub-action';
				$a_txt		 = $is_sub ? 'unsubscribe' : 'subscribe';
				$col_cls	 = 'fifths';
                
                                $html_li        .= '
							<div class="vs-column '.$col_cls.'">
							    <li>
								<div class="ch-item" style="background-image: url('.$bg_url.');">
								    <div class="ch-info">
									<h3>'.VAffiliate::affiliateBadge((($res->fields["usr_affiliate"] == 1 or $res->fields["usr_partner"] == 1) ? 1 : 0), $res->fields["affiliate_badge"]).$h3.'</h3>
									<span class="ch-views-nr">'.$res->fields["ch_views"].' '.($res->fields["ch_views"] == 1 ? $language["frontend.global.view"] : $language["frontend.global.views"]).'</span>
									<p><a href="'.$cfg["main_url"].'/'.VHref::getKey('channel').'/'.$usr_key.'/'.$res->fields["usr_user"].'">'.$language["main.text.view.channel"].'</a></p>
								    </div>
								</div>
								<form id="user-files-form-'.$usr_key.'" method="post" action="">
									<input type="hidden" name="uf_vuid" value="'.$res->fields["usr_id"].'">
								</form>
							    </li>
							</div>
						';

				$res->MoveNext();
				
				$count	+= 1;
			}
		}
		
		$html		= '	<article>
						<h2 class="content-title"><i class="'.$ic.'"></i>'.$h3s.'</h2>
						<div class="line"></div>
					</article>
					<div class="channels_section">
						<div class="container">
							<ul class="ch-grid">
								'.$html_li.'
							</ul>
						</div>
					</div>
				';
                $html   .= '<script type="text/javascript">$(function(){'.$ht_js.'});</script>';

		return $html;
	}
	/* channel page - about section */
	private static function aboutPage() {
		$cfg		= self::$cfg;
		$db		= self::$db;
		$class_database	= self::$dbc;
		$language	= self::$language;
		$ch_cfg		= self::$ch_cfg;
		$ch_links	= self::$ch_links;
		
		$sub_count	= self::subCount();
		
		if (!empty($ch_links)) {
			$ch_links_html		 = '<ul>';
			foreach ($ch_links as $k => $url) {
				$c		 = ($k%2 == 0) ? 'vs-column half' : 'vs-column half fit';
				$ch_links_html	.= '<li class="s '.$c.'"><a href="'.$url["url"].'" title="'.$url["title"].'" rel="me nofollow" target="_blank"><img width="16" height="16" src="https://s2.googleusercontent.com/s2/favicons?domain_url='.(self::strbefore($url["url"], '?')).'"><span>'.$url["title"].'</span></a></li>';
			}
			$ch_links_html		.= '</ul>';
		}

		if (self::getUserID() > 0) {
			$upage_id	= self::getUserID();
			$upage_user	= self::$user_name;
			$fr_chk		= $db->execute(sprintf("SELECT `ct_friend` from `db_usercontacts` WHERE `usr_id`='%s' AND `ct_username`='%s' LIMIT 1;", $upage_id, $upage_user));
			$is_fr		= $fr_chk->fields["ct_friend"];
			$is_fr		= $is_fr == 1 ? 1 : 0;
			$is_sub		= 0;
			$is_bl		= VContacts::getBlockStatus($upage_id, $upage_user);

			$is_bl_sub	= VContacts::getBlockStatus(self::$user_id, $_SESSION["USER_NAME"]);
			$bl_sub		= VContacts::getBlockCfg('bl_subscribe', $upage_id, $_SESSION["USER_NAME"]);
			$sub		= $class_database->singleFieldValue('db_subscribers', 'subscriber_id', 'usr_id', $upage_id);
			$cls_friend	= ' profile-friend-' . ($is_fr == 1 ? 'remove' : 'add');
			$cls_block	= ' profile-' . ($is_bl == 1 ? 'unblock' : 'block');

			if ($sub != '') {
				$sub_ar = unserialize($sub);
				foreach ($sub_ar as $val) {
					if ($val["sub_id"] == $upage_id) {
						$is_sub = 1;
						break;
					}
				}
			}
			$ht = '';
		}
		
		$profile_html		 = null;
		
		if ($ch_cfg["ch_profile_details"] == 1) {
			

			$profile_fields	 = array('usr_id', 'usr_name', 'usr_description', 'usr_website', 'usr_birthday', 'usr_showage', 'usr_gender', 'usr_relation', 'usr_phone', 'usr_fax', 'usr_town', 'usr_city', 'usr_zip', 'usr_country', 'usr_occupations', 'usr_companies', 'usr_schools', 'usr_interests', 'usr_movies', 'usr_music', 'usr_books');
			$profile_labels	 = array(0, $language["upage.text.owner"], 'usr_description', 'usr_website', $language["account.profile.personal.bday"], 'usr_showage', $language["account.profile.personal.gender"], $language["account.profile.personal.rel"], $language["account.profile.about.phone"], $language["account.profile.about.fax"], $language["account.profile.location.town"], $language["account.profile.location.city"], $language["account.profile.location.zip"], $language["account.profile.location.country"], $language["account.profile.job.occup"], $language["account.profile.job.companies"], $language["account.profile.education"], $language["account.profile.interests"], $language["account.profile.interests.movies"], $language["account.profile.interests.music"], $language["account.profile.interests.books"]);
			$profile_icons	 = array(0, 'icon-user', '', '', 'iconBe-calendar2', 'iconBe-calendar2', 'icon-tag', 'icon-heart2', 'icon-rss', 'icon-rss', 'icon-globe', 'icon-globe', 'icon-globe', 'icon-globe', 'icon-gear', 'icon-gear', 'icon-group', 'icon-group', 'icon-camera2', 'icon-music', 'icon-books');

			$sql		 = sprintf("SELECT %s FROM `db_accountuser` WHERE `usr_id`='%s' LIMIT 1;", str_replace('usr_name', 'CONCAT(usr_fname, " ", usr_lname) AS usr_name', implode(',', $profile_fields)), self::$user_id);
			$profile_info	 = self::$db_cache ? $db->execute($cfg["cache_channels_about"], $sql) : $db->execute($sql);

			if ($profile_info->fields['usr_id']) {
				unset($profile_fields[0]);

				foreach ($profile_fields as $i => $key) {
					$label		 = $profile_labels[$i];
					$label		 = ($label == 'usr_description' or $label == 'usr_website') ? '&nbsp;' : $label;
					$value		 = $profile_info->fields[$key];

					if ($label == 'usr_showage' and $value == 1) {
						$label	 = $language["account.profile.personal.age"];
						$bdate	 = $profile_info->fields['usr_birthday'];
						$value	 = $bdate != '0000-00-00' ? VUserinfo::ageFromString($bdate) : '---';
					} elseif ($label == 'usr_showage' and $value == 0) {
						$value	 = null;
					} elseif ($label == $language["account.profile.personal.bday"] and $value != '0000-00-00') {
						$value	 = strftime("%b %u, %G", strtotime($value));
					}
					
					$value		 = $key == 'usr_website' ? '<a href="'.$value.'" target="_blank">'.$value.'</a>' : $value;

					if ($value != '' and $value != '---' and $value != '0000-00-00') {
						$profile_html	.= '<div class="profile-row">';
						$profile_html	.= '<div class="vs-column half"><i class="'.$profile_icons[$i].'"></i> <span class="label">'.$label.'</span></div>';
						$profile_html	.= '<div class="vs-column half fit">'.$value.'</div>';
						$profile_html	.= '<div class="clearfix"></div>';
						$profile_html	.= '</div>';
					}
				}
			}
		}
		
		$links		 = null;
		$js		 = null;
		
		if (self::getUserID() > 0 and self::getUserID() != self::$user_id) {
			$links	 	.= '<form id="user-actions-form" method="post" action="">';
			$links		.= $cfg["user_friends"] == 1 ? '<button onfocus="blur();" value="1" type="button" class="button-grey search-button form-button save-entry-button friend-action profile-action'.$cls_friend.'" name="add2fr" rel="tooltip" title="'.($is_fr == 1 ? $language["upage.text.profile.rem.friend"] : $language["upage.text.profile.add.friend"]).'"></button>' : null;
			$links		.= $cfg["user_blocking"] == 1 ? '<button onfocus="blur();" value="1" type="button" class="button-grey search-button form-button save-entry-button block-user profile-action'.$cls_block.'" name="add2fr" rel="tooltip" title="'.($is_bl == 1 ? $language["upage.text.profile.unblock.user"] : $language["upage.text.profile.block.user"]).'"></button>' : null;
			$links		.= $cfg["internal_messaging"] == 1 ? '<button onfocus="blur();" value="1" type="button" class="button-grey search-button form-button save-entry-button priv-msg profile-action'.($upage_id > 0 ? ' profile-message' : NULL).'" name="add2fr" rel="tooltip" title="'.$language["upage.text.profile.send.message"].'"></button>' : null;
			$links		.= VGenerate::simpleDivWrap('left-float no-display', '', '<input type="hidden" name="user-actions-submitted" value="1">');
			$links		.= '</form>';
			
			$js             .= '$(".profile-message").click(function(){'.(self::sessionMessageName($upage_user)).' var tlink = "'.$cfg["main_url"].'/'.VHref::getKey("messages").'?src=upage" + "&amp;" + "mid='.strtoupper(VUserinfo::generateRandomString()).'"; window.location.href = html2amp(tlink); return false;});';
			$js             .= '$(".profile-friend-add").click(function(){ $("#section-about").mask(" "); $.post("?a=cb-addfr", $("#user-actions-form").serialize(), function(data) { $("#action-response").html(data); $("#section-about").unmask(); }); });';
			$js             .= '$(".profile-friend-remove").click(function(){ $("#section-about").mask(" "); $.post("?a=cb-remfr", $("#user-actions-form").serialize(), function(data) { $("#action-response").html(data); $("#section-about").unmask(); }); });';
			$js             .= '$(".profile-block").click(function(){ $("#section-about").mask(" "); $.post("?a=cb-block", $("#user-actions-form").serialize(), function(data) { $("#action-response").html(data); $("#section-about").unmask(); }); });';
			$js             .= '$(".profile-unblock").click(function(){ $("#section-about").mask(" "); $.post("?a=cb-unblock", $("#user-actions-form").serialize(), function(data) { $("#action-response").html(data); $("#section-about").unmask(); }); });';
		}
		$d	= preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $ch_cfg["ch_descr"]);
		
		$html	= '	
				<div class="vs-column '.($profile_html != '' ? 'half' : 'full').'">
					<article><h2 class="content-title"><i class="icon-info"></i>'.$language["upage.text.about"].'</h2><div class="line"></div></article>
					<div id="action-response"></div>
					<div class="clearfix"></div>
					<div>
						<div class="vs-column half">
							<span><i class="icon-users"></i> '.$sub_count.' '.($sub_count == 1 ? $language["frontend.global.subscriber"] : $language["frontend.global.subscribers"]).'&nbsp;&nbsp;<i class="icon-eye"></i> '.$ch_cfg["ch_views"].' '.($ch_cfg["ch_views"] == 1 ? $language["frontend.global.view"] : $language["frontend.global.views"]).'</span><br>
							<span><i class="iconBe-calendar2"></i> '.$language["frontend.global.since"].' '.strftime("%b %e, %G", strtotime($ch_cfg["ch_join"])).'</span>
						</div>
						<div class="vs-column half fit">
							<div class="place-right">
								'.$links.'
							</div>
						</div>
						<div class="clearfix"></div><br>
						<pre>'.$d.'</pre><br>
						<div class="about-links">
							'.$ch_links_html.'
						</div>
					</div>
				</div>
				'.($profile_html != '' ? '
				<div class="vs-column half fit">
					<article><h2 class="content-title"><i class="icon-profile"></i>'.$language["upage.text.profile"].'</h2><div class="line"></div></article>
					<div class="profile-info-wrap">
						'.$profile_html.'
					</div>
				</div>
				' : null).'
			';
		$html	.= '<div class="clearfix"></div>';

		$html	.= $js != '' ? VGenerate::declareJS($js) : null;

		
		return $html;
	}
	/* store name to be set when message sending */
	private static function sessionMessageName($from){
		$_SESSION["channel_msg"] = $from;
	}
	/* user actions (add/remove friend, block/unblock */
	public static function userActions($action) {
		//global $db, $class_database;
		$db		= self::$db;
		$class_database	= self::$dbc;

		$ct_user	= self::$user_name;
		$ct_uid		= self::getUserID();
		$ct		= $db->execute(sprintf("SELECT `ct_id` FROM `db_usercontacts` WHERE `usr_id`='%s' AND `ct_username`='%s' AND `ct_active`='1' LIMIT 1;", $ct_uid, $ct_user));
		$ct_id		= $ct->fields["ct_id"];

		switch ($action) {
			case "cb-remfr":
			case "cb-block":
			case "cb-unblock":
				$update_id = $ct_id;
				
				break;
			case "cb-addfr":
				if ($ct_id > 0) {
					$update_id	= $ct_id;
				} else {
					$block_db	= serialize(array("bl_files" => 1, "bl_channel" => 1, "bl_comments" => 1, "bl_messages" => 1, "bl_subscribe" => 1));
					$update_ar	= array("usr_id" => $ct_uid, "pwd_id" => VUserinfo::generateRandomString(10), "ct_name" => "", "ct_username" => $ct_user, "ct_email" => "", "ct_datetime" => date("Y-m-d H:i:s"), "ct_block_cfg" => $block_db);
					$update_do	= $class_database->doInsert('db_usercontacts', $update_ar);
					$update_id	= $db->Insert_ID();
				}
				
				break;
		}
		if ($update_id > 0) {
			$do_action = VContacts::ctAction($action, array($update_id), 1);
		}
	}

	/* get subscriber count */
	private static function subCount() {
		$t	= 0;
		$db	= self::$db;
		
		$rs	= $db->execute(sprintf("SELECT `subscriber_id` FROM `db_subscribers` WHERE `usr_id`='%s' LIMIT 1;", self::$user_id));
		
		if ($rs->fields["subscriber_id"]) {
			$s	= unserialize($rs->fields["subscriber_id"]);
			
			$t	= count($s);
		}
		
		return $t;
	}
	/* check module and set active tab */
	private static function activeTabClass($check) {
		return ($check == self::$module ? 'tab-current' : (($check == 'activity' && self::$module == '') ? 'tab-current' : null));
	}
	/* activity timeline */
	private static function activityTimeline() {
		$cfg	= self::$cfg;
		$db	= self::$db;
		$ch_uid	= self::$user_id;
		$language	= self::$language;
		$class_database = self::$dbc;
		$allow_cfg	= $ch_uid == self::getUserID() ? 1 : 0;
		
		$row    = unserialize($class_database->singleFieldValue('db_accountuser', 'ch_rownum', 'usr_id', $ch_uid));
                $ev     = $db->execute(sprintf("SELECT * FROM `db_trackactivity` WHERE `usr_id`='%s' LIMIT 1;", $ch_uid));
                $db_ar1 = $ev->getrows();
    
                $bl_db  = $cfg["channel_bulletins"] == 1 ? " OR `act_type` LIKE '%bulletin%' ": NULL;
                $bl_db .= ($cfg["video_module"] == 1 and $cfg["file_favorites"] == 1 and $db_ar1[0]["log_fav"] == 1) ? " OR `act_type` LIKE 'favorite:video%' ": NULL;
		$bl_db .= ($cfg["live_module"] == 1 and $cfg["file_favorites"] == 1 and $db_ar1[0]["log_fav"] == 1) ? " OR `act_type` LIKE 'favorite:live%' ": NULL;
                $bl_db .= ($cfg["image_module"] == 1 and $cfg["file_favorites"] == 1 and $db_ar1[0]["log_fav"] == 1) ? " OR `act_type` LIKE 'favorite:image%' ": NULL;
                $bl_db .= ($cfg["audio_module"] == 1 and $cfg["file_favorites"] == 1 and $db_ar1[0]["log_fav"] == 1) ? " OR `act_type` LIKE 'favorite:audio%' ": NULL;
                $bl_db .= ($cfg["document_module"] == 1 and $cfg["file_favorites"] == 1 and $db_ar1[0]["log_fav"] == 1) ? " OR `act_type` LIKE 'favorite:doc%' ": NULL;
		$bl_db .= ($cfg["blog_module"] == 1 and $cfg["file_favorites"] == 1 and $db_ar1[0]["log_fav"] == 1) ? " OR `act_type` LIKE 'favorite:blog%' ": NULL;
    
                $bl_db .= ($cfg["video_module"] == 1 and $cfg["video_uploads"] == 1 and $db_ar1[0]["log_upload"] == 1) ? " OR `act_type` LIKE 'upload:video%' ": NULL;
		$bl_db .= ($cfg["live_module"] == 1 and $cfg["live_uploads"] == 1 and $db_ar1[0]["log_upload"] == 1) ? " OR `act_type` LIKE 'upload:live%' ": NULL;
                $bl_db .= ($cfg["image_module"] == 1 and $cfg["image_uploads"] == 1 and $db_ar1[0]["log_upload"] == 1) ? " OR `act_type` LIKE 'upload:image%' ": NULL;
                $bl_db .= ($cfg["audio_module"] == 1 and $cfg["audio_uploads"] == 1 and $db_ar1[0]["log_upload"] == 1) ? " OR `act_type` LIKE 'upload:audio%' ": NULL;
                $bl_db .= ($cfg["document_module"] == 1 and $cfg["document_uploads"] == 1 and $db_ar1[0]["log_upload"] == 1) ? " OR `act_type` LIKE 'upload:doc%' ": NULL;
		$bl_db .= ($cfg["blog_module"] == 1 and $db_ar1[0]["log_upload"] == 1) ? " OR `act_type` LIKE 'upload:blog%' ": NULL;

                $bl_db .= ($cfg["video_module"] == 1 and $cfg["file_rating"] == 1 and $db_ar1[0]["log_rating"] == 1) ? " OR `act_type` LIKE '%like:video%' ": NULL;
		$bl_db .= ($cfg["live_module"] == 1 and $cfg["file_rating"] == 1 and $db_ar1[0]["log_rating"] == 1) ? " OR `act_type` LIKE '%like:live%' ": NULL;
                $bl_db .= ($cfg["image_module"] == 1 and $cfg["file_rating"] == 1 and $db_ar1[0]["log_rating"] == 1) ? " OR `act_type` LIKE '%like:image%' ": NULL;
                $bl_db .= ($cfg["audio_module"] == 1 and $cfg["file_rating"] == 1 and $db_ar1[0]["log_rating"] == 1) ? " OR `act_type` LIKE '%like:audio%' ": NULL;
                $bl_db .= ($cfg["document_module"] == 1 and $cfg["file_rating"] == 1 and $db_ar1[0]["log_rating"] == 1) ? " OR `act_type` LIKE '%like:doc%' ": NULL;
		$bl_db .= ($cfg["blog_module"] == 1 and $cfg["file_rating"] == 1 and $db_ar1[0]["log_rating"] == 1) ? " OR `act_type` LIKE '%like:blog%' ": NULL;
		
                $bl_db .= ($cfg["user_subscriptions"] == 1 and $db_ar1[0]["log_subscribing"] == 1) ? " OR `act_type` LIKE 'subscribes%' " : NULL;
                $bl_db .= ($cfg["user_follows"] == 1 and $db_ar1[0]["log_following"] == 1) ? " OR `act_type` LIKE 'follows%' " : NULL;
                $bl_db .= (($cfg["channel_comments"] == 1 or $cfg["file_comments"] == 1) and $db_ar1[0]["log_filecomment"] == 1) ? " OR `act_type` LIKE 'comments%' " : NULL;

                $sql	= sprintf("SELECT `act_type`, `act_time`, `act_ip`, `act_visible`, `act_id` FROM `db_useractivity` WHERE `usr_id`='%s' AND `act_visible`='1' AND `act_deleted`='0' AND (%s) ORDER BY `act_id` DESC LIMIT %s;", $ch_uid, substr($bl_db, 3), $row["r_activity"]);
		$rs	= self::$db_cache ? $db->CacheExecute($cfg['cache_channel_activity'], $sql) : $db->execute($sql);
                $db_ar2 = $rs->getrows();

		$usr_user	= self::$display_name != '' ? self::$display_name : (self::$channel_name != '' ? self::$channel_name : self::$user_name);
		$log_options	= array();
		$user_activity	= array();
		$user_actions	= array();

		foreach ($db_ar1[0] as $key => $val) {
			if (!is_numeric($key)) {
				$log_options[$key] = $val;
			}
		}
		$log_options["share_rating_bad"] = 1;



		if ($cfg["channel_bulletins"] == 1) {
			$log_options["public_bulletin"] = 1;
			$type	= 'bulletin';
			
			$islogged	= self::getUserID() > 0 ? true : false;
			
			$html		= '
				<div class="page_holder" id="' . $type . '-comm-wrapper">
					<article>
						<h2 class="content-title">
							<i class="icon-connection"></i>'.$language["frontend.global.recent.activity"].'
						</h2>
						'.($allow_cfg == 1 ? '<div class="btn-group viewType pull-right"><button onclick="$(\'#ntm\').stop().slideToggle();" rel="tooltip" type="button" value="new" id="new-playlist" class="viewType_btn viewType_btn-default" title="'.$language["main.text.new.timeline"].'"><i class="iconBe-plus"></i></button></div>' : null).'
						<div class="line"></div>
					</article>
					' . VGenerate::simpleDivWrap('', 'comm-post-response', '') . '

					' . (($islogged and $allow_cfg == 1) ? '
					<div id="ntm" style="display: none;">
						<form id="public-bulletin-form" method="post" action="" class="entry-form-class">
							<input type="text" name="bulletin_text" class="no-border white-bg wd90p bulletin_text" value="'.$usr_user.': ">
							<input type="text" name="bulletin_file" class="left-float text-input bulletin_file" id="bulletin-file" placeholder="'.$language["main.text.file.url"].'">

							<div class="comments_actions">
								<button value="1" type="button" class="post-bulletin-act" id="btn-1-bulletin_text" name="post-bulletin-act"><i class="icon-bubbles2"></i> '.$language["frontend.global.post"].'</button>
								<a href="javascript:;" class="comm-cancel-action" rel="nofollow" onclick="$(\'#ntm\').stop().slideToggle();">' . $language["frontend.global.cancel"] . '</a>
							</div>

							'.VGenerate::simpleDivWrap('left-float no-display', '', '<input type="hidden" name="hide_activity" value="" class="hide_activity_val">').'
							'.VGenerate::simpleDivWrap('left-float no-display', 'hide-activity-response', '').'

							<div class="clearfix"></div>
						</form>
					</div>
					' : null);
			
			if ($allow_cfg == 1) {
				$pb_js		 = '$(".bulletin_text").focus(function(){var pb_val = $(this).val(); if(pb_val == "'.$usr_user.': ") {$(this).val("");}});';
				$pb_js		.= '$(".bulletin_text").focusout(function(){var pb_val = $(this).val(); if(pb_val == "") {$(this).val("'.$usr_user.': ");}});';
				$pb_js		.= '$(".post-bulletin-act").click(function(){';
				$pb_js		.= 'if($(".bulletin_text").val().length > 3 && $(".bulletin_text").val() != "'.$usr_user.': "){';
				$pb_js		.= 'var do_bul="?a=postbulletin"; var do_form = $("#public-bulletin-form").serialize();';
				$pb_js		.= '$("#ntm").mask(" "); $.post(do_bul, do_form, function(data){ $("#comm-post-response").html(data); location.reload(); }); }';
				$pb_js		.= '});enterSubmit("#public-bulletin-form input", "#btn-1-bulletin_text");';
				
				$pb_js		.= '$(".hide-activity").click(function(){';
				$pb_js		.= '	$(".hide_activity_val").val($(this).attr("id"));
							do_action="?a=hideuseractivity";
							do_form = $("#public-bulletin-form").serialize();
							$("#liwrap-"+$(".hide_activity_val").val()).mask(" ");
							$.post(do_action, do_form, function(data){
								$("#hide-activity-response").html(data);
								$("#liwrap-"+$(".hide_activity_val").val()).replaceWith("");
							});
						';
				$pb_js		.= '});';

				$html		.= VGenerate::declareJS('$(document).ready(function(){'.$pb_js.'});');
			}

		}

	
		$html	.= '<form id="hide-activity-form" method="post" action="">';
		$html	.= '	<ul class="cbp_tmtimeline">';
		
		foreach($db_ar2 as $key => $val) {
			$vals	= explode(" ", $val[0]);
			$vabl	= explode(":", $val[0]);

			$html               .= $vabl[0] == 'bulletin' ? self::listUserActivities('public_bulletin', $log_options, $vabl, $usr_user, $val) : NULL;
			$html               .= ($vabl[0] == 'upload' and $class_database->singleFieldValue('db_'.$vabl[1].'files', 'approved', 'file_key', $vabl[2]) == 1) ? self::listUserActivities('share_upload', $log_options, $vabl, $usr_user, $val) : NULL;
			$html               .= $vabl[0] == 'like' ? self::listUserActivities('share_rating', $log_options, $vabl, $usr_user, $val) : NULL;
			$html               .= $vabl[0] == 'dislike' ? self::listUserActivities('share_rating_bad', $log_options, $vabl, $usr_user, $val) : NULL;
			$html               .= $vabl[0] == 'favorite' ? self::listUserActivities('share_fav', $log_options, $vabl, $usr_user, $val) : NULL;
			$html               .= $vals[0] == 'comments' ? self::listUserActivities('share_filecomment', $log_options, $vals, $usr_user, $val) : NULL;
			$html               .= $vals[0] == 'subscribes' ? self::listUserActivities('share_subscribing', $log_options, $vals, $usr_user, $val) : NULL;

		}
		
		$html	.= 	'</ul>';
		$html	.= '</form>';
		
		return $html;
	}
	/* list specific user activities */
	private static function listUserActivities($log_key, $log_options, $vals, $usr_user, $val) {
		$db		= self::$db;
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_database	= self::$dbc;
		$upage_id	= self::$user_id;
		$allow_cfg	= $upage_id == self::getUserID() ? 1 : 0;

		$act_time	= VUserinfo::timeRange($val[1]);
		$act_hour	= strftime("%H:%M", strtotime($val[1]));
		$act_visible	= $val[3];
		$act_id		= $val[4];
		$act_file	= $language["frontend.global." . $vals[1][0] . ".a"];
		
		switch ($log_key) {
			case "public_bulletin":
				$cmp_val	= 'bulletin';
				$ico_class	= 'icon-comments';
				$txt_comm	= self::buildBulletinText($vals);
				$act_text_after = $vals[1];
				
				break;
			
			case "share_upload":
				switch ($vals[1][0]) {
					case "l": $ic = 'icon-live'; break;
					case "v": $ic = 'icon-video'; break;
					case "i": $ic = 'icon-image'; break;
					case "a": $ic = 'icon-audio'; break;
					case "d": $ic = 'icon-file'; break;
					case "b": $ic = 'icon-pencil2'; break;
				}
				$cmp_val	= 'upload';
				$ico_class	= $ic;
				$act_text	= ' ' . $language["upage.act.upload"] . ' ' . $act_file;
				$act_text_after = '';
				
				break;
			
			case "share_fav":
				$cmp_val	= 'favorite';
				$ico_class	= 'icon-heart';
				$act_text	= ' ' . $language["upage.act.favorite"] . ' ' . $act_file;
				$act_text_after = '';
				
				break;
			
			case "share_rating":
				$cmp_val	= 'like';
				$ico_class	= 'icon-thumbs-up';
				$act_text	= ' ' . $language["upage.act.like"] . ' ' . $act_file;
				$act_text_after = '';
				
				break;
			
			case "share_rating_bad":
				$cmp_val	= 'dislike';
				$ico_class	= 'icon-thumbs-up2';
				$act_text	= ' ' . $language["upage.act.dislike"] . ' ' . $act_file;
				$act_text_after = '';
				
				break;
			
			case "share_filecomment":
				$ae		= explode(":", $vals[2]);

				if ($ae[2] != '' and $ae[0] != 'channel') {
					$ft = $ae[0];
					$fk = $ae[1];
					$tt = $class_database->singleFieldValue('db_' . $ft . 'files', 'file_title', 'file_key', $fk);
					if ($tt == '')
						return false;
					
					$act_file = '<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($ft[0], $fk, $tt) . '" title="' . $tt . '" class="normal-link-col linkified">' . VUserinfo::truncateString($tt, 50) . '</a>';
					$txt_comm = '<div class="top-padding5"><center><i class="spinner icon-spinner" style="font-size:20px"></i></center><pre class="hp-pre">' . $class_database->singleFieldValue('db_' . $ft . 'comments', 'c_body', 'c_key', $ae[2]) . '</pre></div>';
				} else {
					$i		= sprintf("SELECT A.`usr_user`, A.`usr_key`, A.`usr_dname`, A.`ch_title` FROM `db_accountuser` A WHERE A.`usr_id`='%s' LIMIT 1;", $ae[1]);
					$r		= self::$db_cache ? $db->CacheExecute($cfg['cache_channel_activity'], $i) : $db->execute($i);
					$usr_usr	= $r->fields["usr_user"];
					$usr_dname	= $r->fields["usr_dname"];
					$usr_title	= $r->fields["ch_title"];
					$usr_key	= $r->fields["usr_key"];
					
					$u = $usr_dname != '' ? $usr_dname : ($usr_title != '' ? $usr_title : $usr_usr);
					
					$act_text_after = ('<a href="' . $cfg["main_url"] . '/' . VHref::getKey("channel") . '/' . $usr_key . '/' .$usr_usr. '" class="normal-link-col linkified">' . $u . '</a>') . $language["upage.text.comm.pr"];
					$txt_comm = '<div class="top-padding5"><center><i class="spinner icon-spinner"></i></center><pre class="hp-pre">' . $class_database->singleFieldValue('db_channelcomments', 'c_body', 'c_key', $ae[2]) . '</pre></div>';
				}
				$cmp_val	= 'comments';
				$ico_class	= 'icon-comment';
				$act_text	= ' ' . $language["upage.act.comment"] . ' ' . $act_file;
				
				break;
				
			case "share_subscribing":
				$i		= sprintf("SELECT A.`usr_user`, A.`usr_key`, A.`usr_dname`, A.`ch_title` FROM `db_accountuser` A WHERE A.`usr_user`='%s' LIMIT 1;", $vals[2]);
				$r		= self::$db_cache ? $db->CacheExecute($cfg['cache_channel_activity'], $i) : $db->execute($i);
				$usr_usr	= $r->fields["usr_user"];
				$usr_dname	= $r->fields["usr_dname"];
				$usr_title	= $r->fields["ch_title"];
				$usr_key	= $r->fields["usr_key"];

				$u = $usr_dname != '' ? $usr_dname : ($usr_title != '' ? $usr_title : $usr_usr);
					
				$cmp_val	= 'subscribes';
				$ico_class	= 'icon-users5';
				$act_text	= ' ' . $language["upage.act.subscribe"] . ' ';
				$act_text_after = ('<a href="' . $cfg["main_url"] . '/' . VHref::getKey("channel") . '/' .$usr_key . '/' . $vals[2] . '" class="normal-link-col linkified">' . $u . '</a>');
				
				break;
		}
		switch ($log_key) {
			case "share_upload":
			case "share_fav":
			case "share_rating":
			case "share_rating_bad":
				$f_info		= self::getFileInfo($vals[2]);

				switch (self::typeFromKey(VFiles::keyCheck($vals[2]))) { case "l": $tbl='live'; break; case "v": $tbl='video'; break; case "i": $tbl='image'; break; case "a": $tbl='audio'; break; case "d": $tbl='doc'; break; default: $tbl='video'; }

				$tmb_url	= VGenerate::fileURL($tbl, $vals[2], 'thumb') . VBrowse::thumbnail($f_info["ukey"], $vals[2], $thumb_server = 0, $nr = 1, $force_type = false);

				$txt_comm	= '	<div class="act-tmb"><img src="'.$tmb_url.'" height="90" alt="'.$f_info["title"].'"></div>
							<div class="act-about">
								<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref(self::typeFromKey(VFiles::keyCheck($vals[2])), VFiles::keyCheck($vals[2]), $f_info["title"]) . '" id="file' . $vals[2] . '" class="normal-link-col linkified">' . VUserinfo::truncateString($f_info["title"], 70) . '</a>
								<br>
								<pre class="hp-pre">' . (VUserinfo::truncateString($f_info["description"], 350)) . '</pre>
							</div>
							<div class="clearfix"></div>
						';
				
				break;
		}

		$act_text	= '<span class="' . ($log_key != 'public_bulletin' ? '' : NULL) . '">' . $act_text . '</span>';
		$act_text_after = '<span class="' . ($log_key != 'public_bulletin' ? '' : NULL) . '">' . $act_text_after . '</span>';
		$ht_cnd		= ($log_options[$log_key] == 1 and $vals[0] == $cmp_val) ? 1 : 0;

		$txt = '
			<div class="act-title">
				<span class="act-list-user">' . VAffiliate::affiliateBadge(((self::$usr_affiliate == 1 or self::$usr_partner == 1) ? 1 : 0), self::$affiliate_badge) . $usr_user . ($cmp_val == 'bulletin' ? '<span class="">:</span> ' : NULL) . '</span>
				<span class="act-list-action">' . $act_text . '</span>';
		$txt .=		$act_text_after;
		$txt .=	'</div>';

		$close = null;
		
		if ($allow_cfg == 1) {
			$close = '<div class="tips-f"><i rel="tooltip" title="'.$language["main.text.hide.timeline"].'" class="icon-times act-display hide-activity" id="ua'.$act_id.'"></i></div>';
		}
		
		
		$html	= ($act_visible == 1 and $ht_cnd == 1 ) ? 
			'			<li id="liwrap-ua'.$act_id.'">
							<time class="cbp_tmtime" datetime="'.$val[1].'"><span>'.$act_time.'</span><span>'.$act_hour.'</span></time>
							<div class="cbp_tmicon cbp_tmicon-phones"><i class="'.$ico_class.'"></i></div>
							
							<div class="cbp_tmlabel">
								<h2>'.$txt.$close.'</h2>
								'.$txt_comm.'
							</div>
						</li>
			' : null;

		return $html;
	}
	/* posting public bulletin */
	public static function postBulletin() {
		$class_filter	= self::$filter;
		$class_database = self::$dbc;
		$db		= self::$db;
		$language	= self::$language;
		$ch_cfg		= self::$ch_cfg;
		$cfg		= self::$cfg;
		$ch_uid		= self::$user_id;
		$allow_cfg	= $ch_uid == self::getUserID() ? 1 : 0;
		
		if ($allow_cfg == 0) {
			return;
		}

		$section	= 'ch-user-activity';
		$bull_text	= $class_filter->clr_str($_POST["bulletin_text"]);
		$bull_time	= date("Y-m-d H:i:s");
		$db_arr		= array("usr_id" => self::getUserID(), "act_type" => "bulletin:" . $bull_text, "act_time" => $bull_time, "act_ip" => $class_filter->clr_str($_SERVER['REMOTE_ADDR']));

		$main_len	= strlen($cfg["main_url"]);
		/* checking file url */
		$ch_file_url	= $class_filter->clr_str($_POST["bulletin_file"]);

		if (substr($ch_file_url, 0, $main_len) == $cfg["main_url"]) {
			$url_arr	= parse_url($ch_file_url);
			if ($cfg["file_seo_url"] == 1) {
				$a		= explode("/", $url_arr["path"]);
				$b		= count($a);
				$file_key	= $a[$b-2];
				$tbl		= $a[$b-3];
				$new_key	= $tbl."=".$file_key;
			} else {
				$new_key	= substr($url_arr["query"], 0, 18);
				$new_info	= explode("=", $new_key);
				$tbl		= $new_info[0];
				$file_key	= $new_info[1];
			}

			switch ($tbl) {
				case "l": $db_tbl = 'live';
					break;
				case "v": $db_tbl = 'video';
					break;
				case "i": $db_tbl = 'image';
					break;
				case "a": $db_tbl = 'audio';
					break;
				case "d": $db_tbl = 'doc';
					break;
				case "b": $db_tbl = 'blog';
					break;
			}
			$m	= $tbl == 'd' ? 'document' : $db_tbl;
			$_uid	= $class_database->singleFieldValue('db_' . $db_tbl . 'files', 'usr_id', 'file_key', $file_key);
			$_sql	= sprintf("SELECT `usr_id` FROM `db_%sfiles` WHERE `file_key`='%s' AND `privacy`%s AND `approved`='1' AND `deleted`='0' AND `active`='1' LIMIT 1;", $db_tbl, $file_key, ($_uid == $_SESSION["USER_ID"] ? "!='personal'" : "='public'"));
			$dbc	= $db->execute($_sql);

			if ($cfg[$m . "_module"] == 1 and $dbc->fields["usr_id"] == $_uid) {
				$db_arr["act_type"] = "bulletin:" . $bull_text . ":" . $new_key;
			}
		}

		$do_db = ($bull_text != '' and strlen($bull_text) > 3) ? $class_database->doInsert('db_useractivity', $db_arr) : NULL;
		$db_id = $db->Insert_ID();
	}
	 /* building bulletin text */
	private static function buildBulletinText($vals) {
		$cfg		= self::$cfg;
		$class_database = self::$dbc;

		$ct		= count($vals);

		if ($vals[$ct - 1] != '') {
			$v = explode("=", $vals[$ct - 1]);
			$t = $v[0];
			$k = $v[1];

			switch ($t) {
				case "l": $db_tbl = 'live';
					break;
				case "v": $db_tbl = 'video';
					break;
				case "i": $db_tbl = 'image';
					break;
				case "a": $db_tbl = 'audio';
					break;
				case "d": $db_tbl = 'doc';
					break;
				case "b": $db_tbl = 'blog';
					break;
			}
			$title = $class_database->singleFieldValue('db_' . $db_tbl . 'files', 'file_title', 'file_key', $k);
		}

		if ($title) {
			$f_info		= self::getFileInfo($k);
				$tmb_url	= $cfg["media_files_url"] .'/'. VBrowse::thumbnail($f_info["ukey"], $k, $thumb_server = 0, $nr = 1, $force_type = false);
				
				$tmb	= '	<div class="act-tmb"><img src="'.$tmb_url.'" height="90" alt="'.$f_info["title"].'"></div>
							<div class="act-about">
								<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref(self::typeFromKey(VFiles::keyCheck($k)), VFiles::keyCheck($k), $f_info["title"]) . '" id="file' . $k . '" class="normal-link-col linkified">' . VUserinfo::truncateString($f_info["title"], 70) . '</a>
								<br>
								<pre class="hp-pre">' . (VUserinfo::truncateString($f_info["description"], 350)) . '</pre>
							</div>
							<div class="clearfix"></div>
						';
		}

		return $tmb;
	}
	/* hiding activity */
	public static function hideActivity() {
		$db		= self::$db;
		$uid		= self::getUserID();
		$upage_id	= self::$user_id;
		$allow_cfg	= $upage_id == self::getUserID() ? 1 : 0;
		
		if ($allow_cfg == 0) {
			return;
		}

		$db_id		= intval(substr($_POST["hide_activity"], 2));
		$db_sel		= sprintf("SELECT `act_type` FROM `db_useractivity` WHERE `usr_id`='%s' AND `act_id`='%s' LIMIT 1;", $uid, $db_id);
		$db_do		= $db->execute($db_sel);
		$db_action	= explode(":", $db_do->fields["act_type"]);
		$db_update	= sprintf("UPDATE `db_useractivity` SET `act_visible`='0' WHERE `usr_id`='%s' AND `act_id`='%s' AND `act_visible`='1' LIMIT 1;", $uid, $db_id);
		$db_exec	= $db_update;

		$db->execute($db_exec);
	}
	/* get title, descr from key */
	private static function getFileInfo($fkey) {
		//global $db, $cfg;
		$db	 = self::$db;
		$cfg	 = self::$cfg;
		$mod_arr = array("live" => "live", "video" => "video", "image" => "image", "audio" => "audio", "doc" => "document", "blog" => "blog");
		
		foreach ($mod_arr as $key => $val) {
			if ($cfg[$val . "_module"] == 1) {
				$i  = sprintf("SELECT A.`file_title`, A.`file_description`, B.`usr_key` FROM `db_%sfiles` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`file_key`='%s' LIMIT 1;", $key, $fkey);
				$rs = self::$db_cache ? $db->CacheExecute($cfg['cache_channel_activity'], $i) : $db->execute($i);

				if ($rs->fields["file_title"] != '') {
					return array("ukey" => $rs->fields["usr_key"], "title" => $rs->fields["file_title"], "description" => $rs->fields["file_description"], "type" => $key);
				}
			}
		}
	}
	/* file type from key */
	private static function typeFromKey($key){
		$for	 = self::getFileInfo($key);

		return $for["type"][0];
	}
	/* layout for manage channels */
	public static function manageLayout() {
		$html	= !isset($_GET["r"]) ? self::manage_general() : self::manage_art();

		return $html;
	}
	/* manage channel - general setup */
	public static function manage_general() {
		$db		 = self::$db;
		$cfg		 = self::$cfg;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		
		$ch_cfg		 = self::$ch_cfg;
		$user_key	 = self::$user_key;
		$display_name	 = self::$channel_name;
		
		$info		 = self::getGeneralSetup();
		$types		 = self::getChannelTypes();
		$types_html	 = null;
		
		$channel_url	 = $cfg["main_url"].'/'.VHref::getKey('channel').'/'.$user_key.'/'.$_SESSION["USER_NAME"];
		
		if ($types->fields["ct_id"]) {
			while (!$types->EOF) {
				$types_html	.= '<option value="'.$types->fields["ct_id"].'"'.($types->fields["ct_id"] == $info->fields["ch_type"] ? ' selected="selected"' : null).'>'.$types->fields["ct_name"].'</option>';

				$types->MoveNext();
			}
		}
		
		$html	= '	
				<article>
					<h3 class="content-title"><i class="icon-cog"></i>'.$language["manage.channel.menu.general"].'</h3>
					<div class="line"></div>
				</article>
				<div id="save_channel_response"></div>
				<form id="save_channel_form" class="entry-form-class" method="post" action="">
					<label for="ch_url">'.$language["manage.channel.general.url"].'</label>
					<a href="'.$channel_url.'" target="_blank" style="word-break:break-word">'.$channel_url.'</a><br>
					
					<label for="ch_title">'.$language["manage.channel.general.title"].'</label>
					<input type="text" name="ch_title" id="ch_title" value="'.$info->fields["ch_title"].'">
					
					<label for="ch_tags">'.$language["manage.channel.general.tags"].'</label>
					<input type="text" name="ch_tags" id="ch_tags" value="'.$info->fields["ch_tags"].'">
					
					<label for="ch_descr">'.$language["manage.channel.general.descr"].'</label>
					<textarea name="ch_descr" id="ch_descr">'.$info->fields["ch_descr"].'</textarea>
					
					<label for="ch_type">'.$language["manage.channel.general.type"].'</label>
					<div class="selector"><select name="ch_type" id="ch_type">'.$types_html.'</select></div>
					
					<label for="ch_visible">'.$language["manage.channel.general.visible"].'</label>
					<div class="icheck-box">
						<input type="radio" name="ch_visible" id="ch_visible" value="1"'.($ch_cfg["ch_visible"] == 1 ? ' checked="checked"' : null).'><label>'.$language["frontend.global.yes"].'</label>
						<input type="radio" name="ch_visible" id="ch_visible" value="0"'.($ch_cfg["ch_visible"] == 0 ? ' checked="checked"' : null).'><label>'.$language["frontend.global.no"].'</label>
					</div>
					<br>
					
					<button value="1" type="button" class="save-entry-button button-grey search-button form-button" id="save_channel" name="save_channel"><span>'.$language["manage.channel.btn.update"].'</span></button>
				</form>';
		
		
		$html	.= '	<script type="text/javascript">
					$(function() {
						SelectList.init("ch_type");
					});
					
					$(document).ready(function() {
						$("#save_channel").on("click", function() {
							var menu_id = "channel-menu-entry1";
							var url	= current_url + menu_section + "?s=" + menu_id + "&do=save_channel";
							
							$("#siteContent").mask("");

							jQuery.post(url, $("#save_channel_form").serialize(), function(data) {
								$("#save_channel_response").html(data);
								$("#siteContent").unmask("");
							});
						});
						
						$(".icheck-box input").each(function () {
							var self = $(this);

							self.iCheck({
								checkboxClass: "icheckbox_square-blue",
								radioClass: "iradio_square-blue",
								increaseArea: "20%"
								//insert: \'<div class="icheck_line-icon"></div><label>\' + label_text + \'</label>\'
							});
						});
					});

				</script>';
		
		
		return $html;
	}
	/* manage channel - channel art */
	public static function manage_art() {
		$db		 = self::$db;
		$cfg		 = self::$cfg;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		
		$html		 = '	<div id="manage-art-response" class=""></div>
					<article>
						<h3 class="content-title"><i class="icon-quill"></i>'.$language["manage.channel.menu.art"].'</h3>
						<div class="line"></div>
					</article>
					

					<div class="tabs tabs-style-topline">
					<div>
						<nav>
							<ul>
							    <li><a href="#section-upload" class="icon icon-upload" rel="nofollow"><span>'.$language['manage.channel.tab.upload'].'</span></a></li>
							    <li id="l2"><a href="#section-manage" class="icon icon-images" rel="nofollow"><span>'.$language['manage.channel.tab.my'].'</span></a></li>
							    <li><a href="#section-gallery" class="icon icon-search" rel="nofollow"><span>'.$language['manage.channel.tab.gallery'].'</span></a></li>
							</ul>
						</nav>
						<div class="content-wrap">
							<section id="section-upload" class="content-current">'.self::manage_art_upload().'</section>
							<section id="section-manage">'.self::manage_art_own().'</section>
							<section id="section-gallery">'.self::manage_art_gallery().'</section>
						</div>
					</div>
					</div>

					'.(!isset($_GET['r']) ? '
					<script type="text/javascript">
						(function () {
							[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {
								new CBPFWTabs(el);
							});
						})();
					</script>
					' : null).'
				';
		
		return $html;
	}
	/* manage channel art - photo upload tab content */
	private static function manage_art_upload() {
		$language	 = self::$language;
		
		$html		 = '
					
					<form id="fedit-image-form" method="post" enctype="multipart/form-data" class="entry-form-class">
						<div class="left-float left-align wdmax row" id="upload-response"></div>
						<div class="left-float left-align wdmax">
							<div class="row">
								<p class="thumb-text">'.$language["manage.channel.upload.txt1"].'</p>
							</div>
							<div id="overview-userinfo-file" class="row">
								<div class="left-float left-padding25 hiddenfile">
									<input type="file" onchange="$(\'#fedit-image-form\').one().submit();" size="30" id="fedit-image" name="fedit_image">
									<input type="hidden" name="fedit-form-param" value="0">
								</div>
								<center>
									<button class="save-entry-button button-grey search-button form-button new-image first" type="button" onclick="$(\'#fedit-image\').trigger(\'click\');"><span>'.$language["manage.channel.upload.txt2"].'</span></button>
								</center>
								<br>
								<p class="thumb-text">'.$language["manage.channel.upload.txt3"].'</p>
							</div>
						</div>
						<input name="crop_data" type="hidden" value="">
					</form>
					
					<script type="text/javascript">
						$(document).ready(function() {
							var options = {
								target: "#upload-response",
								beforeSubmit: showRequest,
								success: showResponse,
								url: current_url + menu_section + "?s=channel-menu-entry3&do=upload"
							}
							
							function showRequest() {
								$("#fedit-image-form").mask(" ");
								if (typeof($(".error-message-text").html()) == "undefined") {
									$(".thumb-text").removeClass("hidden");
									$(".new-image.first").removeClass("hidden");
									$(".inline_button.second").addClass("hidden");
								}
							}
							function showResponse() {
								$("#fedit-image-form").unmask();
								if (typeof($(".error-message-text").html()) == "undefined") {
									$(".thumb-text").addClass("hidden");
									$(".new-image.first").addClass("hidden");
									$(".inline_button.second").removeClass("hidden");
								}
							}
							
							$(document).on("submit", "#fedit-image-form", function() {
								$(this).ajaxSubmit(options);
								return false;
							});

						});
					</script>
			    ';
		
		return $html;
	}
	/* manage channel art - own uploaded files tab content */
	private static function manage_art_own() {
		$cfg		 = self::$cfg;
		$user_key	 = self::$user_key;
		
		$ch_photos	 = self::$ch_photos;
		
		$base_dir	 = $cfg["profile_images_dir"] . '/' . $user_key . '/';
		$base_url	 = $cfg["profile_images_url"] . '/' . $user_key . '/';
		
		if (empty($ch_photos['list'])) {
			return;
		}
		
		$html		= '	<ul id="channel-own-photos">';
		foreach ($ch_photos['list'] as $nr => $file) {
			$filename = sprintf("%s-%s-small.jpg", $user_key, $file);
			$class	 = (($nr%2) == 0) ? 'vs-column half' : 'vs-column half fit';
			
			$html	.= '		<li id="li-'.$file.'" class="'.$class.'">
							<div class="place-left">
								<img src="'.$base_url.$filename.'" class="'.($ch_photos['default'] == $file ? 'own' : null).'">
							</div>
							<div id="channel-crop-actions">
								<div class="btn-group viewType">
									<button type="button" class="viewType_btn viewType_btn-default cr-popup" rel-photo="'.$file.'" rel="tooltip" title="'.self::$language["manage.channel.edit.ch.header"].'">
										<span style="margin: 0px 5px;" class="icon-pencil"></span>
									</button>
									<button type="button" class="viewType_btn viewType_btn-default del-popup" rel-photo="'.$file.'" rel="tooltip" title="'.self::$language["manage.channel.del.ch.header"].'">
										<span style="margin: 0px 5px;" class="iconBe-x"></span>
									</button>
								</div>
							</div>
						</li>
				';
		}
		$html		.= '	<ul>';
			
		
		return $html;
	}
	/* manage channel art - gallery tab content */
	private static function manage_art_gallery() {
		$cfg		 = self::$cfg;
		$user_key	 = self::$user_key;
		
		$ch_photos	 = self::$ch_photos;
		
		$base_dir	 = $cfg["profile_images_dir"] . '/gallery/';
		$base_url	 = $cfg["profile_images_url"] . '/gallery/';
		
		$html		 = '	<ul id="channel-art-photos">';
		for ($i = 1; $i <= 12; $i++) {
			$filename = sprintf("%s-tmb.jpg", ($i >= 10 ? $i : '0'.$i));
			$class	 = (($i%3) == 0) ? 'vs-column thirds' : 'vs-column thirds fit';
			
			$html	.= '		<li id="li-'.$i.'" class="'.$class.'">
							<div class="place-left">
								<img src="'.$base_url.$filename.'" class="'.($ch_photos['default'] == $file ? 'own' : null).'">
							</div>
							<div id="channel-crop-actions" class="btn-group viewType">
								<button type="button" class="viewType_btn viewType_btn-default gcr-popup" rel-photo="'.$i.'" rel="tooltip" title="'.self::$language["manage.channel.edit.ch.header"].'">
									<span style="margin: 0px 5px;" class="icon-pencil"></span>
								</button>
							</div>
						</li>
				';
		}
		$html		.= '	<ul>';
			
		
		return $html;
	}
	/* manage channel - delete image crop - confirmation html */
	public static function html_delete_crop() {
		$cfg		 = self::$cfg;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		$user_key	 = self::$user_key;
		
		$image		 = $class_filter->clr_str($_GET["t"]);
		
		$filename	 = sprintf("%s-%s-src.jpg", $user_key, $image);
		
		$html		 = '
					<form action="" method="post" class="entry-form-class lb-margins" id="delete-crop-form">
						<article>
							<h3 class="content-title"><i class="icon-check"></i>'.$language["manage.channel.del.ch.header"].'</h3>
							<div class="line"></div>
						</article>

						<div class="" id="crop-delete-response"></div>
						<div class="row no-top-padding">'.$language["manage.channel.delete.txt1"].'</div>
						<div class="row">'.$language["manage.channel.delete.txt2"].'</div>
						<br>
						<div class="row">
							<button onfocus="blur();" value="1" type="button" class="save-entry-button button-grey search-button form-button crop-delete" id="btn-1-crop_delete" name="playlist_delete"><span>'.$language["manage.channel.delete.txt3"].'</span></button>
							<a class="link cancel-trigger" href="javascript:;" onclick="$.fancybox.close();"><span>'.$language["frontend.global.cancel"].'</span></a>
						</div>
					</form>
					
					<script type="text/javascript">
						$(document).ready(function() {
							$(".crop-delete").on("click", function() {
								var menu_id = "channel-menu-entry3";
								var url	= current_url + menu_section + "?s=" + menu_id + "&do=delete";

								$(".fancybox-wrap").mask("");

								jQuery.post(url, {t: "'.$image.'"}, function(data) {
									if (data > 0) {
										$(".fancybox-close").click();
										$("#li-'.$image.'").detach();
										
										//$("#crop-delete-response").html(data);
									} else {
										$("#crop-delete-response").html(data);
									}
									$(".fancybox-wrap").unmask("");
								});
							});
						});
					</script>
				';
		
		return $html;
	}
	/* manage channel - delete image crop - do delete operation */
	private static function entry_delete_crop() {
		$cfg		 = self::$cfg;
		$db		 = self::$db;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		$user_key	 = self::$user_key;
		$ch_photos	 = self::$ch_photos;
		
		$deleted	 = 0;
		
		if ($_POST) {
			$image	 = $class_filter->clr_str($_POST["t"]);
			
			$filename= sprintf("%s-%s-src.jpg", $user_key, $image);
			
			$large_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$image.'-large.jpg';
			$mid_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$image.'-mid.jpg';
			$small_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$image.'-small.jpg';
			$channel_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$image.'-ch.jpg';
			$src_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$image.'-src.jpg';
			
			$files	 = array($large_file, $mid_file, $small_file, $channel_file, $src_file);
			
			foreach ($files as $file) {
				if (file_exists($file)) {
					if (unlink($file)) {
						$deleted += 1;
					}
				} else {
					
				}
			}
			
			if ($deleted > 0) {
				$unset	= 0;
				
				foreach ($ch_photos['list'] as $k => $file) {
					if ($file == $image) {
						unset($ch_photos['list'][$k]);
						
						$unset += 1;
					}
				}
				
				if ($unset > 0) {
					$ch_photos['list'] = array_values($ch_photos['list']);
				}
				
				if ($ch_photos['default'] == $file) {
					$ch_photos['default'] = $ch_photos['list'][0];
				}
				
				if ($unset > 0) {
					$db->execute(sprintf("UPDATE `db_accountuser` SET `ch_photos`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($ch_photos), self::getUserID()));
				}
			}
		}
		
		echo $deleted;
	}
	/* manage channel - adjust image crop */
	public static function edit_crop() {
		$cfg		 = self::$cfg;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		$user_key	 = self::$user_key;
		
		$image		 = $class_filter->clr_str($_GET["t"]);
		
		$gallery	 = $_GET["do"] == 'edit-gcrop' ? true : false;
		
		if ($gallery) {
			$filename	 = sprintf("%s.jpg", ($image >= 10 ? $image : '0'.$image));

			$tmp_file	 = $cfg["profile_images_dir"].'/gallery/'.$filename;
			$tmp_img	 = $cfg["profile_images_url"].'/gallery/'.$filename;
		} else {
			$filename	 = sprintf("%s-%s-src.jpg", $user_key, $image);

			$tmp_file	 = $cfg["profile_images_dir"].'/'.$user_key.'/'.$filename;
			$tmp_img	 = $cfg["profile_images_url"].'/'.$user_key.'/'.$filename;
		}
		
		if (file_exists($tmp_file) and filesize($tmp_file) > 0) {
					echo '
						<form id="fedit-image-form" class="entry-form-class" method="post" enctype="multipart/form-data">
						<article>
							<h3 class="content-title"><i class="icon-pencil"></i>'.$language["manage.channel.edit.ch.header"].'</h3>
							<div class="line"></div>
						</article>
						<div class="left-float left-align wdmax row" id="upload-response"></div>
						<div class="vs-column full">
						<div style="height: 360px;">
							<div class="cropper">
								<img height="350" src="'.$tmp_img.'?t='.rand(1, 9999).'" alt="">
							</div>
						</div>
						</div>
						<div class="clearfix"></div>
						<div class="vs-column full edit-crop-buttons">
						<article>
						    <div class="c-tools">
						    <center>
						    <a href="javascript:;" class="c-zoomin"><i class="icon-zoomin"></i></a>
						    <a href="javascript:;" class="c-zoomout"><i class="icon-zoomout"></i></a>
						    <a href="javascript:;" class="c-moveup"><i class="icon-arrow-up"></i></a>
						    <a href="javascript:;" class="c-movedown"><i class="icon-arrow-down"></i></a>
						    <a href="javascript:;" class="c-moveleft"><i class="icon-arrow-left"></i></a>
						    <a href="javascript:;" class="c-moveright"><i class="icon-arrow-right"></i></a>
						    </center>
						    </div><br>
						    <div class="line"></div>
						    <div class="clearfix"></div>
						    <div class="vs-column full">
						    	<center>
								<button value="1" type="button" class="save-entry-button button-grey search-button form-button" id="update" name="save_crop"><span>'.$language["manage.channel.edit.btn1"].'</span></button>
								'.(!$gallery ? '
								<button value="1" type="button" class="save-entry-button crop-default button-grey search-button form-button" id="default" name="save_crop"><span>'.$language["manage.channel.edit.btn2"].'</span></button>
								' : null).'
								<a href="#" class="link cancel-trigger" onclick="$.fancybox.close()"><span>'.$language["frontend.global.cancel"].'</span></a>
							</center>
						    </div>
                                                </article>
						</div>
						<div class="clearfix"></div>
						</div>
						<input name="crop_data" type="hidden" value="">
						<input id="crop-string" type="hidden" value="'.$image.'">
						</form>
					';
					
					echo '	<script type="text/javascript" src="'.$cfg['scripts_url'].'/shared/cropper/cropper.init.min.js"></script>';
				}
	}
	/* manage channel - channel modules */
	public static function manage_modules() {
		$db		 = self::$db;
		$cfg		 = self::$cfg;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		$smarty		 = self::$smarty;
		
		$ch_cfg		 = self::$ch_cfg;
		$user_key	 = self::$user_key;
		$display_name	 = self::$channel_name;
		
		$channel_url	 = $cfg["main_url"].'/'.VHref::getKey('channel').'/'.$user_key.'/'.$display_name;
		
		$html	= '	
				<article>
					<h3 class="content-title"><i class="icon-cogs2"></i>'.$language["manage.channel.menu.modules"].'</h3>
					<div class="line"></div>
				</article>
				<div id="save_channel_response"></div>
				<div id="channel-mod-tabs" class="">
					<nav>
						<div class="vs-column half">
							'.self::ac_list('about').'
							'.($cfg["activity_logging"] == 1 ? self::ac_list('activity') : null).'
							'.($cfg["live_module"] == 1 ? self::ac_list('live') : null).'	
							'.($cfg["video_module"] == 1 ? self::ac_list('videos') : null).'
							'.($cfg["image_module"] == 1 ? self::ac_list('images') : null).'
							'.($cfg["audio_module"] == 1 ? self::ac_list('audios') : null).'
							'.($cfg["document_module"] == 1 ? self::ac_list('documents') : null).'
							'.($cfg["blog_module"] == 1 ? self::ac_list('blogs') : null).'
							'.($cfg["file_playlists"] == 1 ? self::ac_list('playlists') : null).'
						</div>
						<div class="vs-column half fit">
							'.($cfg["public_channels"] == 1 ? self::ac_list('channels') : null).'
							'.($cfg["user_follows"] == 1 ? self::ac_list('followers') : null).'
							'.($cfg["user_follows"] == 1 ? self::ac_list('following') : null).'
							'.($cfg["user_subscriptions"] == 1 ? self::ac_list('subscribers') : null).'
							'.($cfg["user_subscriptions"] == 1 ? self::ac_list('subscriptions') : null).'
							'.($cfg["channel_comments"] == 1 ? self::ac_list('discussion') : null).'
						</div>
					</nav>
					<div class="clearfix"></div>
					<div class="content-wrap"></div>
				</div>
				<form id="save_channel_form" class="entry-form-class" method="post" action="">
					<br>
					<button value="1" type="button" class="save-entry-button button-grey search-button form-button" id="save_channel" name="save_channel"><span>'.$language["manage.channel.btn.update"].'</span></button>
				</form>';
		
		$html	.= '	<script type="text/javascript">'.$smarty->fetch('f_scripts/be/js/settings-accordion.js').'</script>';
		$html	.= '	<script type="text/javascript">
					$(document).ready(function() {
						$("#save_channel").on("click", function() {
							var menu_id = "channel-menu-entry2";
							var url	= current_url + menu_section + "?s=" + menu_id + "&do=save_channel";
							
							$("#siteContent").mask("");

							jQuery.post(url, $(".entry-form-class").serialize(), function(data) {
								$("#save_channel_response").html(data);
								$("#siteContent").unmask("");
							});
						});
					});
				</script>
				';
						
		
		return $html;
	}
	/* generate accordions for channel modules */
	private static function ac_list($for) {
		$class_database	 = self::$dbc;
		$language	 = self::$language;
		$ch_cfg		 = self::$ch_cfg;
		
		$body		 = false;
		
		
		switch ($for) {
			case "home":
				$heading	= $language["frontend.global.home"];
				
				break;
			
			case "activity":
				$heading	= $language["frontend.global.activity"];
				$section	= 'ch-user-activity';
				
				$rowcfg		= unserialize($class_database->singleFieldValue('db_accountuser', 'ch_rownum', 'usr_id', self::getUserID()));
				
				$body		= '	<form id="'.$section.'-save-form" method="post" action="" class="entry-form-class">
								<label>'.$language["manage.channel.activity.cfg"].'</label>
								<input type="text" name="'.str_replace("-", "_", $section.'-cfglist').'" class="text-input wd50 grayText" value="'.$rowcfg['r_activity'].'" />
							</form>';
				
				break;
			
			case "videos":
			case "live":
			case "broadcasts":
			case "images":
			case "audios":
			case "documents":
			case "blogs":
				$heading	= $language["frontend.global.".$for[0].".p.c"];
				
				break;
			
			case "playlists":
				$heading	= $language["frontend.global.playlists"];
				
				break;
			
			case "channels":
				$heading	= $language["frontend.global.channels"];
				$users		= null;
				
				$rowcfg		= unserialize($class_database->singleFieldValue('db_accountuser', 'ch_channels', 'usr_id', self::getUserID()));
				
				if (is_array($rowcfg["uc_names"]) and count($rowcfg["uc_names"]) > 0) {
					foreach ($rowcfg["uc_names"] as $unames) {
						$users .= $unames."\n";
					}
				}
				
				$body		= '	<form id="ch-user-channels-save-form" method="post" action="" class="entry-form-class">
								<label>'.$language["manage.channel.channels.heading"].'</label>
								'.VGenerate::basicInput('text', 'ch_user_channel_title', 'text-input wdmax', $rowcfg["uc_title"]).'
								
								<label>'.$language["manage.channel.channels.text"].'</label>
								'.VGenerate::basicInput('textarea', 'ch_user_channel_names', 'textarea-input wdmax h100', $users).'
							</form>';
				
				break;
			
			case "subscribers":
				$heading	= $language["frontend.global.subscribers.cap"];
				
				break;
			
			case "subscriptions":
				$heading	= $language["subnav.entry.sub"];
				
				break;
			
			case "followers":
				$heading	= $language["frontend.global.followers.cap"];
				
				break;
			
			case "following":
				$heading	= $language["frontend.global.following.cap"];
				
				break;
			
			case "discussion":
				$heading	= $language["frontend.global.discussion"];
				
				$body		= '	<form id="ch-user-comments-save-form" method="post" action="" class="entry-form-class">
								<label>'.$language["manage.channel.comm.who"].'</label>
								<div class="icheck-box">
									<input type="radio" name="ch_comm_perm" value="free"'.($ch_cfg["ch_comm_perms"] == 'free' ? ' checked="checked"' : null).'><label>'.$language["manage.channel.comm.opt.all"].'</label><br>
									<input type="radio" name="ch_comm_perm" value="appr"'.($ch_cfg["ch_comm_perms"] == 'appr' ? ' checked="checked"' : null).'><label>'.$language["manage.channel.comm.opt.appr"].'</label><br>
									<input type="radio" name="ch_comm_perm" value="fronly"'.($ch_cfg["ch_comm_perms"] == 'fronly' ? ' checked="checked"' : null).'><label>'.$language["manage.channel.comm.opt.friends.only"].'</label><br>
									<input type="radio" name="ch_comm_perm" value="custom"'.($ch_cfg["ch_comm_perms"] == 'custom' ? ' checked="checked"' : null).'><label>'.$language["manage.channel.comm.opt.friends"].'</label>
								</div>
								<br>
								<label>'.$language["manage.channel.comm.spam"].'</label>
								<div class="icheck-box">
									<input type="radio" name="ch_comm_spam" value="1"'.($ch_cfg["ch_comm_perms"] == 1 ? ' checked="checked"' : null).'><label>'.$language["manage.channel.comm.spam.yes"].'</label><br>
									<input type="radio" name="ch_comm_spam" value="0"'.($ch_cfg["ch_comm_perms"] == 0 ? ' checked="checked"' : null).'><label>'.$language["manage.channel.comm.spam.no"].'</label>
								</div>
							</form>
							
							<script type="text/javascript">
								$(".icheck-box input").each(function () {
									var self = $(this);

									self.iCheck({
										checkboxClass: "icheckbox_square-blue",
										radioClass: "iradio_square-blue",
										increaseArea: "20%"
										//insert: \'<div class="icheck_line-icon"></div><label>\' + label_text + \'</label>\'
									});
								});
							</script>
						';
				
				
				
				break;
			
			case "about":
				$heading	= $language["frontend.global.about"];
				
				$ch_descr	= $class_database->singleFieldValue('db_accountuser', 'ch_descr', 'usr_id', self::getUserID());
				$rowcfg		= unserialize($class_database->singleFieldValue('db_accountuser', 'ch_links', 'usr_id', self::getUserID()));
				
				
				$body		= '	
							<form id="ch-user-about-save-form" method="post" action="" class="entry-form-class">
								<label>'.$language["manage.channel.general.descr"].'</label>
								<textarea name="ch_descr" id="ch_descr">'.$ch_descr.'</textarea>
								<label>'.$language["manage.channel.general.links"].'</label>
								<ul>
									<li>
										<input type="text" name="channel_link_title[]" value="'.$rowcfg[0]['title'].'" placeholder="'.$language["manage.channel.about.title"].'">
										<input type="text" name="channel_link_url[]" value="'.$rowcfg[0]['url'].'" placeholder="'.$language["manage.channel.about.url"].'">
									</li>
									<li>
										<input type="text" name="channel_link_title[]" value="'.$rowcfg[1]['title'].'" placeholder="'.$language["manage.channel.about.title"].'">
										<input type="text" name="channel_link_url[]" value="'.$rowcfg[1]['url'].'" placeholder="'.$language["manage.channel.about.url"].'">
									</li>
									<li>
										<input type="text" name="channel_link_title[]" value="'.$rowcfg[2]['title'].'" placeholder="'.$language["manage.channel.about.title"].'">
										<input type="text" name="channel_link_url[]" value="'.$rowcfg[2]['url'].'" placeholder="'.$language["manage.channel.about.url"].'">
									</li>
									<li>
										<input type="text" name="channel_link_title[]" value="'.$rowcfg[3]['title'].'" placeholder="'.$language["manage.channel.about.title"].'">
										<input type="text" name="channel_link_url[]" value="'.$rowcfg[3]['url'].'" placeholder="'.$language["manage.channel.about.url"].'">
									</li>
								</ul>
								<span class="icheck-box"><input type="checkbox" name="ch_profile_details" value="1"'.($ch_cfg["ch_profile_details"] == 1 ? ' checked="checked"' : null).'></span>
								<label>'.$language["manage.channel.general.profile"].'</label>
								<div class="clearfix"></div>
							</form>
						';
				
				break;
			
		}
		
		$input_name	= 'channel_module_'.$for;
		
		$html	 = '
				<ul class="responsive-accordion responsive-accordion-default bm-larger">
					<li>
						<div class="responsive-accordion-head">
							<div class="place-left">
								<span>'.$heading.'</span>
								'.($body ? '
								<i style="display: inline;" class="fa fa-chevron-down responsive-accordion-plus fa-fw iconBe-chevron-down"></i>
								<i style="display: none;" class="fa fa-chevron-up responsive-accordion-minus fa-fw iconBe-chevron-up"></i>
								' : null).'
							</div>
							<div class="place-right">
								<form class="entry-form-class">
								<div class="switch_holder">
									<label class="switch switch-light">
										<input type="checkbox" name="'.$input_name.'_check" class="switch-input"'.($ch_cfg["ch_m_".$for] == 1 ? ' checked="checked"' : null).'>
										<span data-off="off" data-on="on" class="switch-label"></span>
										<span class="switch-handle"></span>
									</label>
									<div style="display: none;">
										<input type="radio" value="1" name="'.$input_name.'"'.($ch_cfg["ch_m_".$for] == 1 ? ' checked="checked"' : null).'>
										<input type="radio" value="0" name="'.$input_name.'"'.($ch_cfg["ch_m_".$for] == 0 ? ' checked="checked"' : null).'>
									</div>
								</div>
								</form>
							</div>
						</div>
						'.($body ? '
						<div style="display: none;" class="responsive-accordion-panel">
							<div class="">
								'.$body.'
							</div>
						</div>
						' : null).'
					</li>
				</ul>';
		
		return $html;
	}
	/* post/save channel configurations */
	public static function postChanges($for) {
		$db			= self::$db;
		$class_database		= self::$dbc;
		$class_filter		= self::$filter;
		$ch_cfg			= self::$ch_cfg;
		$language		= self::$language;
		
		$update			= false;
		$links			= 0;
		
		if (!$_POST) {
			return;
		}
		
		switch ($for) {
			case "ch_setup":
				$ch_array		= VArraySection::getArray("channel_setup_tab");
				$ch_cfg["ch_visible"]	= (int) $_POST["ch_visible"] == 1 ? 1 : 0;

				$update			= true;
				$updated		= 0;
				
				break;
			
			case "ch_modules":
				/* update activity */
				if (isset($_POST["ch_user_activity_cfglist"])) {
					$ch_activity		= (int) $_POST["ch_user_activity_cfglist"];
					
					$sel_name		= str_replace("-", "_", 'ch-user-activity');
					
					$rowcfg			= unserialize($class_database->singleFieldValue('db_accountuser', 'ch_rownum', 'usr_id', self::getUserID()));
					$rowcfg["r_activity"]	= $ch_activity > 0 ? $ch_activity : $rowcfg['r_activity'];
					
					$db->execute(sprintf("UPDATE `db_accountuser` SET `ch_rownum`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($rowcfg), self::getUserID()));
					
					if ($db->Affected_Rows() > 0) {
						$updated	+= 1;
					}
				}
				/* update featured channels */
				if (isset($_POST["ch_user_channel_title"]) or isset($_POST["ch_user_channel_names"])) {
					$_db			= array();
					$_users			= array();

					$ch_title		= $class_filter->clr_str($_POST["ch_user_channel_title"]);
					$ch_names		= explode("\n", $class_filter->clr_str($_POST["ch_user_channel_names"]));
					
					$_db["uc_title"]	= $ch_title;

					if (count($ch_names) > 0) {
						foreach ($ch_names as $key => $uname) {
							$uname  = str_replace(chr(13), "", $uname);

							if (VUserinfo::existingUsername($uname) and ! in_array($uname, $_users)) {
								$_users[$key] = $uname;
							}
						}
						$_db["uc_names"] = array_values(array_unique($_users));
						
						$db->execute(sprintf("UPDATE `db_accountuser` SET `ch_channels`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($_db), self::getUserID()));
						
						if ($db->Affected_Rows() > 0) {
							$updated	+= 1;
						}
					}
				}
				/* update comment permissions */
				if (isset($_POST["ch_comm_perm"])) {
					$ch_comm_perm		 = $class_filter->clr_str($_POST["ch_comm_perm"]);
					$ch_cfg["ch_comm_perms"] = $ch_comm_perm;
					
					$update			 = true;
				}
				/* update comment spam reporting */
				if (isset($_POST["ch_comm_spam"])) {
					$ch_comm_spam		 = (int) $_POST["ch_comm_spam"];
					$ch_cfg["ch_comm_spam"]	 = $ch_comm_spam;
					
					$update			 = true;
				}
				/* update channel description */
				if (isset($_POST["ch_descr"])) {
					$ch_descr		 = $class_filter->clr_str($_POST["ch_descr"]);
					
					$db->execute(sprintf("UPDATE `db_accountuser` SET `ch_descr`='%s' WHERE `usr_id`='%s' LIMIT 1;", $ch_descr, self::getUserID()));
					
					if ($db->Affected_Rows() > 0) {
						$updated	+= 1;
					}
				}
				
				/* update personal details in channel page */
				if ((int) $_POST["ch_profile_details"] != $ch_cfg["ch_profile_details"]) {
					$profile_details		 = (int) $_POST["ch_profile_details"];
					$ch_cfg["ch_profile_details"]	 = $profile_details;
					
					$update				 = true;
				}
				/* update custom links */
				for ($i = 0; $i < 4; $i++) {
					if ($_POST["channel_link_title"][$i] != '' or $_POST["channel_link_url"][$i] != '') {
						$ch_links[]		 = array();
					
						if ($_POST["channel_link_title"][$i] != '' and $_POST["channel_link_url"][$i] == '') {
							return VGenerate::noticeTpl('', $language["manage.channel.error.2"], '');
						} elseif ($_POST["channel_link_url"][$i] != '' and $_POST["channel_link_title"][$i] == '') {
							return VGenerate::noticeTpl('', $language["manage.channel.error.3"], '');
						}
					
						$url			= parse_url($class_filter->clr_str($_POST["channel_link_url"][$i]));
						
						if (!isset($url['scheme'])) {
							$url['scheme']	= 'http';
						}
						
						if ($url['scheme'] == 'http' or $url['scheme'] == 'https') {
							$host		= $url['host'];
							
							if (!$host) {
								return VGenerate::noticeTpl('', $language["manage.channel.error.4"], '');
							}
				
							$ch_links[$i]['title']	= $class_filter->clr_str($_POST["channel_link_title"][$i]);
							$ch_links[$i]['url']	= $url['scheme'] . '://' . $host . $url['path'] . ($url['query'] != '' ? '?'.$url['query'] : null);
						} else {
							return VGenerate::noticeTpl('', $language["manage.channel.error.1"], '');
						}
						
						$links	+= 1;
					}
				}
				
				
				
				/* update module sections */
				$mod				 = array('ch_m_home'		=> 'channel_module_home',
									'ch_m_activity'		=> 'channel_module_activity',
									'ch_m_videos'		=> 'channel_module_videos',
									'ch_m_live'		=> 'channel_module_live',
									'ch_m_images'		=> 'channel_module_images',
									'ch_m_audios'		=> 'channel_module_audios',
									'ch_m_documents'	=> 'channel_module_documents',
									'ch_m_playlists'	=> 'channel_module_playlists',
									'ch_m_blogs'		=> 'channel_module_blogs',
									'ch_m_channels'		=> 'channel_module_channels',
									'ch_m_subscribers'	=> 'channel_module_subscribers',
									'ch_m_subscriptions'	=> 'channel_module_subscriptions',
									'ch_m_followers'	=> 'channel_module_followers',
									'ch_m_following'	=> 'channel_module_following',
									'ch_m_discussion'	=> 'channel_module_discussion',
									'ch_m_about'		=> 'channel_module_about'
								);
				
				foreach ($mod as $m => $module) {
					$ch_cfg[$m]		 = isset($_POST[$module."_check"]) ? 1 : 0;
					
					$update			 = true;
				}
				
				
				break;

			case "ch_art":
				if (isset($_GET["do"])) {
					switch ($_GET["do"]) {
						case "upload":
							self::processUpload();
							break;
						
						case "save":
							self::saveUpload();
							break;
						
						case "save_crop":
							$crop_id	= $class_filter->clr_str($_GET["t"]);
					
							self::saveUpload($crop_id);
							break;
						
						case "save_default":
							$crop_id	= $class_filter->clr_str($_GET["t"]);
					
							self::saveDefault($crop_id);
							break;
						
						case "delete":
							self::entry_delete_crop();
							break;
					}
				}
		}
		
		if ($update) {
			$ch_array[0]["ch_cfg"]	 = serialize($ch_cfg);

			$success		 = $class_database->entryUpdate('db_accountuser', $ch_array[0]) ? VGenerate::noticeTpl('', '', $language["notif.success.request"]) : null;
			
			if ($success) {
				$updated	+= 1;
			}
		}
		
		if ($links > 0) {
			$db->execute(sprintf("UPDATE `db_accountuser` SET `ch_links`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($ch_links), self::getUserID()));

			if ($db->Affected_Rows() > 0) {
				$updated	+= 1;
			}
		}
		
		if ($updated > 0) {
			return VGenerate::noticeTpl('', '', $language["notif.success.request"]);
		}
		
		return false;
	}
	/* set cropped image as default */
	private static function saveDefault($crop_id) {
		$db		 = self::$db;
		$ch_photos	 = self::$ch_photos;
		$language	 = self::$language;
		
		if ($_POST) {
			$ch_photos['default'] = $crop_id;
			
			$db->execute(sprintf("UPDATE `db_accountuser` SET `ch_photos`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($ch_photos), self::getUserID()));

			if ($db->Affected_Rows() > 0) {
				echo VGenerate::noticeTpl('', '', $language["notif.success.request"]);
			}
		}
	}
	/* process new photo upload */
	private static function processUpload() {
		$cfg		 = self::$cfg;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		$user_key	 = self::$user_key;
		
		echo '<span class="no-display">1</span>'; //the weirdest fix EVER, but jquery form plugin fails without it...
		
		$upload_file_name         = $class_filter->clr_str($_FILES["fedit_image"]["tmp_name"]);
		list($width, $height)	  = getimagesize($upload_file_name);
		$upload_file_size         = (int) $_FILES["fedit_image"]["size"];
		$upload_file_limit        = $cfg["channel_bg_max_size"]*1024*1024;
		$upload_file_type         = strtoupper(VFileinfo::getExtension($_FILES["fedit_image"]["name"]));
		$upload_allowed           = explode(',', strtoupper($cfg["channel_bg_allowed_extensions"]));
		
		$error_message            = $upload_file_size > $upload_file_limit ? $language["account.error.filesize"] : NULL;
		$error_message		  = ($width < 1920 and $height < 1080) ? $language["manage.channel.upload.err1"] : $error_message;
		$error_message		  = ($width > 2560 and $height > 1440) ? $language["manage.channel.upload.err2"] : $error_message;
		$error_message            = ($error_message == '' and !in_array($upload_file_type, $upload_allowed)) ? $language["account.error.allowed"] : $error_message;
		if ($error_message == '') {
                	if (strpos($upload_file_name, '.php') !== false or strpos($upload_file_name, '.pl') !== false or strpos($upload_file_name, '.asp') !== false or strpos($upload_file_name, '.htm') !== false or strpos($upload_file_name, '.cgi') !== false or strpos($upload_file_name, '.py') !== false or strpos($upload_file_name, '.sh') !== false or strpos($upload_file_name, '.cin') !== false) {
                        	$error_message  = $language["account.error.allowed"];
                	}
        	}

		echo $show_error          = $error_message != '' ? VGenerate::noticeTpl('', $error_message, '') : NULL;
		
		if ($error_message == '') {
			$tmp_file	  = $cfg["profile_images_dir"].'/'.$user_key.'/tmp_'.$user_key.'.jpg';
			$new_file	  = $cfg["profile_images_dir"].'/'.$user_key.'/new_'.$user_key.'.jpg';
			$tmp_img	  = $cfg["profile_images_url"].'/'.$user_key.'/tmp_'.$user_key.'.jpg';
			
			if (file_exists($tmp_file)) { @unlink($tmp_file); }
			if (file_exists($new_file)) { @unlink($new_file); }
			
			if (rename($upload_file_name, $tmp_file)) {
				chmod($tmp_file, 0644);
				if (filesize($tmp_file) > 0) {
					echo '	
						<article>
							<h3 class="content-title"><i class="icon-pencil"></i>'.$language["manage.channel.edit.ch.header"].'</h3>
							<div class="line"></div>
						</article>

						<div class="vs-column full" style="margin-bottom: 1em;">
							<div style="height: 360px;">
								<div class="cropper">
									<img height="350" src="'.$tmp_img.'?t='.rand(1, 9999).'" alt="">
								</div>
							</div>
						</div>
						<article>
						    <div class="c-tools">
						    <center>
						    <a href="javascript:;" class="c-zoomin"><i class="icon-zoomin"></i></a>
						    <a href="javascript:;" class="c-zoomout"><i class="icon-zoomout"></i></a>
						    <a href="javascript:;" class="c-moveup"><i class="icon-arrow-up"></i></a>
						    <a href="javascript:;" class="c-movedown"><i class="icon-arrow-down"></i></a>
						    <a href="javascript:;" class="c-moveleft"><i class="icon-arrow-left"></i></a>
						    <a href="javascript:;" class="c-moveright"><i class="icon-arrow-right"></i></a>
						    </center>
						    </div><br>
						    <div class="line"></div>
                                                </article>
						<div class="clearfix"></div>
						<div class="vs-column full">
						    <div class="vs-column half">
								<div class="place-left">
									<button value="1" type="button" class="save-entry-button button-grey search-button form-button" id="done" name="btn_save"><span>'.$language["manage.channel.edit.btn1"].'</span></button>
								</div>
							</div>
							<div class="vs-column half fit">
								<div class="place-right">
									<button value="1" type="button" class="save-entry-button crop-upload button-grey search-button form-button" name="btn_upload" onclick="$(\'#fedit-image\').trigger(\'click\');"><span>'.$language["manage.channel.edit.btn3"].'</span></button>
								</div>
							</div>
						    </div>
						</div>
						<div class="clearfix"></div>
					';
					
					echo '	<script type="text/javascript" src="'.$cfg['scripts_url'].'/shared/cropper/cropper.init.min.js"></script>';
				}
			}
		}
	}
	//resize and crop image by center
	private static function resize_crop_image($max_width, $max_height, $source_file, $dst_file, $quality = 99) {
		$imgsize	= getimagesize($source_file);
		$width		= $imgsize[0];
		$height		= $imgsize[1];
		$mime		= $imgsize['mime'];

		switch ($mime) {
			case 'image/gif':
				$image_create	= "imagecreatefromgif";
				$image		= "imagegif";
				break;

			case 'image/png':
				$image_create	= "imagecreatefrompng";
				$image		= "imagepng";
				$quality	= 9;
				break;

			case 'image/jpeg':
				$image_create	= "imagecreatefromjpeg";
				$image		= "imagejpeg";
				$quality	= 99;
				break;

			default:
				return false;
				break;
		}

		$dst_img	= imagecreatetruecolor($max_width, $max_height);
		$src_img	= $image_create($source_file);

		$width_new	= $height * $max_width / $max_height;
		$height_new	= $width * $max_height / $max_width;
		//if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
		if ($width_new > $width) {
			//cut point by height
			$h_point = (($height - $height_new) / 2);
			//copy image
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
		} else {
			//cut point by width
			$w_point = (($width - $width_new) / 2);
			imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
		}

		$image($dst_img, $dst_file, $quality);

		if ($dst_img)
			imagedestroy($dst_img);
		if ($src_img)
			imagedestroy($src_img);
	}

	/* process/save cropped image */
	private static function saveUpload($crop_id = false) {
		$cfg		 = self::$cfg;
		$db		 = self::$db;
		$ch_photos	 = self::$ch_photos;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		$user_key	 = self::$user_key;
		
		$crop_update	 = true;
		$crop_data	 = $_POST ? $class_filter->clr_str($_POST['crop_data']) : false;
		
		if ($_POST and $crop_data and $crop_update) {
			$crop_data	= str_replace(array('data:', 'base64,'), '', $crop_data);
			$arr		= explode(';', $crop_data);
			$ext		= (isset($arr['0'])) ? self::mime_to_ext($arr['0']) : false;
			$data		= (isset($arr['1'])) ? base64_decode($arr['1']) : false;

			if ($ext && $data) {
				$timestamp		= (!$crop_id || $crop_id < 24) ? time() : $crop_id;
				$new_file		= $cfg["profile_images_dir"].'/'.$user_key.'/new_'.$user_key.'.jpg';
				//$tmp_file		= (($crop_id < 24 or ($_POST and $_GET["do"] != 'save')) ? $cfg["profile_images_dir"].'/gallery/'.($crop_id >= 10 ? $crop_id : '0'.$crop_id).'.jpg' : $cfg["profile_images_dir"].'/'.$user_key.'/tmp_'.$user_key.'.jpg');
				$tmp_file		= ($crop_id < 24 and $_GET["do"] != 'save') ? $cfg["profile_images_dir"].'/gallery/'.($crop_id >= 10 ? $crop_id : '0'.$crop_id).'.jpg' : $cfg["profile_images_dir"].'/'.$user_key.'/tmp_'.$user_key.'.jpg';
				$large_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$timestamp.'-large.jpg';
				$mid_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$timestamp.'-mid.jpg';
				$small_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$timestamp.'-small.jpg';
				$channel_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$timestamp.'-ch.jpg';
				$src_file		= $cfg["profile_images_dir"].'/'.$user_key.'/'.$user_key.'-'.$timestamp.'-src.jpg';
				
				file_put_contents($new_file, $data);
				
				$image = VImage::load($new_file);
				
				$image->resizeToWidth_base(2120);
				$image->save($large_file);
				$image->resizeToWidth_base(1057);
				$image->save($mid_file);
				$image->resizeToWidth_base(532);
				$image->save($small_file);
				
				if (!$crop_id || $crop_id < 24) {
					if ($crop_id < 24) {
						copy($tmp_file, $src_file);
					} else {
						rename($tmp_file, $src_file);
					}
					if (filesize($small_file) > 0) {
						$ch_photos['default']	= $timestamp;
						$ch_photos['list'][]	= $timestamp;

						$db->execute(sprintf("UPDATE `db_accountuser` SET `ch_photos`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($ch_photos), self::getUserID()));

						if ($db->Affected_Rows() > 0) {
							echo VGenerate::noticeTpl('', '', $language["notif.success.request"]);

							if (file_exists($new_file)) {
								unlink($new_file);
							}
						}
					}
				} else {
					//if (file_exists($new_file)) {
					if (filesize($small_file) > 0) {
						echo VGenerate::noticeTpl('', '', $language["notif.success.request"]);
							
						unlink($new_file);
					}
				}
				
				self::resize_crop_image(560, 224, $src_file, $channel_file);
			}
		}
	}
	/* get extension from mime type */
	private static function mime_to_ext($mime) {
		$mimes = array(
		    'image/jpeg' => 'jpg',
		    'image/pjpeg' => 'jpg',
		    'image/png' => 'png',
		    'image/x-png' => 'png',
		    'image/tiff' => 'tif',
		    'image/gif' => 'gif'
		);

		return (isset($mimes[$mime])) ? $mimes[$mime] : false;
	}
	/* get general setup values */
	private static function getGeneralSetup() {
		$db	= self::$db;
		
		$sql	= sprintf("SELECT `ch_title`, `ch_tags`, `ch_descr`, `ch_type` FROM `db_accountuser` WHERE `usr_id`='%s' LIMIT 1;", self::getUserID());
		
		$res	= $db->execute($sql);
		
		return $res;
	}
	/* get channel types */
	private static function getChannelTypes() {
		$db	= self::$db;
		
		$sql	= sprintf("SELECT `ct_id`, `ct_name` FROM `db_categories` WHERE `ct_type`='channel' AND `ct_active`='1';");
		
		$res	= self::$db_cache ? $db->CacheExecute(self::$cfg['cache_channel_channeltypes'], $sql) : $db->execute($sql);
		
		return $res;
	}
	/* my user id */
	private static function getUserID() {
		return (int) $_SESSION["USER_ID"];
	}
	/* channel page header css */
	private static function CSS() {
		$cfg		= self::$cfg;
		$ch_photos	= self::$ch_photos;
		$header_image	= file_exists($cfg["profile_images_dir"].'/'.self::$user_key.'/'.self::$user_key.'-'.$ch_photos['default'].'-large.jpg') ? true : false;

		$css	= '
.channel-links{top:262px}
.channel-logo img {
    background-color: #fff;
    border-radius: 100%;
    display: block;
    max-width: 128px;
    margin: 10px 0px 0px 10px;
    opacity: .5;
}
.crop-height {
    max-height: 300px;
    overflow: hidden;
    position: relative;
}
.bg-channel-image {
    '.($header_image ? 'background-image: url('.$cfg["profile_images_url"].'/'.self::$user_key.'/'.self::$user_key.'-'.$ch_photos['default'].'-large.jpg);' : null).'
    -ms-background-position-x: center;
    -ms-background-position-y: top;
    background-position: center top;
    background-repeat: no-repeat;
    background-size: contain;
}
.invisible { visibility: hidden; }
.transparent {zoom: 1;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";filter: alpha(opacity=0);opacity: 0;}
@media(max-width:768px) {
.bg-channel-image{'.($header_image ? 'background-image: url('.$cfg["profile_images_url"].'/'.self::$user_key.'/'.self::$user_key.'-'.$ch_photos['default'].'-mid.jpg);' : null).'}
.crop-height{max-height:180px}
.channel-links{top:137px;right:0}
}';
		return $css;
	}
	/* return string before string */
	private static function strbefore($string, $substring) {
		$pos = strpos($string, $substring);
		if ($pos === false)
			return $string;
		else
			return(substr($string, 0, $pos));
	}
}

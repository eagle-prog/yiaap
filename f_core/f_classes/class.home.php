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

class VHome {
	private static $cfg;
	private static $db;
	private static $db_cache;
	private static $dbc;
	private static $filter;
	private static $class_language;
	private static $language;
	private static $href;
	private static $home_cfg = false;
	private static $mod = array('live', 'video', 'image', 'audio', 'document', 'blog');

	public function __construct($_type = false) {
		require 'f_core/config.href.php';

		global $cfg, $class_filter, $class_database, $db, $language, $class_language;

		self::$cfg	= $cfg;
		self::$db	= $db;
		self::$dbc	= $class_database;
		self::$filter	= $class_filter;
		self::$language = $language;
		self::$class_language = $class_language;
		self::$href	= $href;
		
		if ((int) $_SESSION["USER_ID"] > 0) {
			self::$home_cfg	= unserialize($class_database->singleFieldValue('db_accountuser', 'home_cfg', 'usr_id', (int) $_SESSION["USER_ID"]));
		}

		self::$db_cache = false; //change here to enable caching
	}
	/* get sub paging content */
	public static function subContent() {
		$cfg		= self::$cfg;
		$language	= self::$language;
		$page		= (int) $_GET['p'];
		
		$channels	= self::getFeaturedChannels($page);

		$html		= null;

		if ($channels->fields["usr_id"]) {
			foreach ($channels as $channel) {
				$html	.= self::featuredMedia('video', $channel);
			}
//			$html	.= '<div class="load-more-sub" data-loader="pageLoader" rel-p="3"></div>';
		}
		$html	.= '<div class="load-more-sub" data-loader="pageLoader" rel-p="'.($page+1).'"></div>';
		echo $html;
	}
	/* category content */
	public static function categContent() {
		$cfg		= self::$cfg;
		$language	= self::$language;
		
		$html		= null;

		if (self::$home_cfg and is_array(self::$home_cfg)) {
			$hcfg = self::$home_cfg;

			if ($hcfg["categories"]["module"] == 1) {
				foreach (self::$mod as $module) {
					if ($cfg[$module.'_module'] == 1) {
						$categ	= unserialize($hcfg["categories"][$module."_categories"]);
						
						if (is_array($categ)) {
							foreach ($categ as $ct_id) {
								$html	.= self::featuredMedia($module, 'categ', $ct_id);
							}
						}
					}
				}
			}

			echo $html;
		}
	}
	/* content layout */
	public static function doLayout() {
		$cfg		= self::$cfg;
		$language	= self::$language;

		$channels	= self::getFeaturedChannels();
		$categories	= self::getFeaturedCategories();
		
		// Alert Management
		$alertjs = '<script>
			$(document).ready(function(){
				if($("#site_alert").length > 0) {
					var newAlert = $("#site_alert").text();
					var currentAlert = localStorage.getItem("alert_description");
					var alertShow = localStorage.getItem("alert_show");
					var alertUpdated = localStorage.getItem("alert_updated");

					if(!currentAlert) {
						localStorage.setItem("alert_description", newAlert);
						localStorage.setItem("alert_show", 1);
					} else {
						if(newAlert == currentAlert) {
							if(alertShow == 1) {
								$("#site_alert").css("display", "block");
							} else {
								$("#site_alert").css("display", "none");
							}
						} else {
							$("#site_alert").css("display", "block");
							localStorage.setItem("alert_description", newAlert);
							localStorage.setItem("alert_show", 1);
						}
					}
				}

				$("span.alert-close").on("click", function() {
					localStorage.setItem("alert_show", 0);
					$("#site_alert").css("display", "none");
				})
			})
		</script>';

		$alert = $cfg['alert_enabled'] == 1? '<div id="site_alert" style="padding: 10px; background: #06a2cb; border-radius: 5px; text-align: center; color: white; position:relative; margin:25px 0px">'.$cfg['alert_description'].'<span class="icon icon-close alert-close" style="position:absolute; right:2px; top:4px; cursor: pointer"></span></div>' . $alertjs : '';

		$html		= '
		<div id="home-content">'
		    . $alert
			.VGenerate::advHTML(1).'

			'.(isset($_GET["fsn"]) ? VGenerate::noticeTpl('', '', $language["notif.success.subscribe"]) : null).'

			'.($cfg['live_module'] == 1 ? self::featuredMedia('live', 0) : null).'
			
			'.($cfg['video_module'] == 1 ? self::featuredMedia('video', 1) : null).'

			'.($cfg['video_module'] == 1 ? self::featuredMedia('video', 0) : null).'

			'.VGenerate::advHTML(2);

		if ($channels->fields["usr_id"]) {
			foreach ($channels as $channel) {
				$html	.= self::featuredMedia('video', $channel);
			}
		}
		if ($categories->fields["ct_id"]) {
			foreach ($categories as $categ) {
//			echo $categ["ct_id"];
				$html	.= self::featuredMedia('video', 0, $categ["ct_id"]);
			}
		}
		$html	.= '<div class="load-more" data-loader="moreLoader" rel-p="2"></div>';
		$html	.= '
		</div>
		';
		
		/* subscribe/unsubscribe action */
                if ($cfg["user_subscriptions"] == 1) {
                        $ht_js           = 'c_url = "'.$cfg["main_url"].'/'.VHref::getKey('watch').'?a";';
                        $ht_js          .= '$(document).on("click", ".unsubscribe-action", function(e){';
                        $ht_js          .= 'rel = $(this).attr("rel-usr"); if (rel === "'.$_SESSION["USER_KEY"].'") return;';
                        $ht_js		.= 'if($("#sub-wrap .sub-txt:first").text()=="'.$language["frontend.global.unsubscribed"].'")return;';
                        $ht_js          .= '$("#sub-wrap .sub-txt:first").text("'.$language["frontend.global.loading"].'");return;';
                        $ht_js          .= '$.post(c_url+"?do=user-unsubscribe", $("#user-files-form").serialize(), function(data){';
                        $ht_js          .= '$("#sub-wrap .sub-txt:first").text("'.$language["frontend.global.unsubscribed"].'");';
                        $ht_js          .= '});';
                        $ht_js          .= '});';
                }
		/* follow/unfollow action */
                if ($cfg["user_follows"] == 1) {
                        $ht_js          .= 'c_url = "'.$cfg["main_url"].'/'.VHref::getKey('watch').'?a";';
                        $ht_js          .= '$(document).on("click", ".follow-action", function(e){';
                        $ht_js          .= 'rel = $(this).attr("rel-usr"); if (rel === "'.$_SESSION["USER_KEY"].'") return;';
                        $ht_js          .= '$(".follow-txt-"+rel).text("'.$language["frontend.global.loading"].'");';
                        $ht_js          .= '$.post(c_url+"&do=user-follow", $("#user-files-form-"+rel).serialize(), function(data){';
                        $ht_js          .= '$(".follow-txt-"+rel).text("'.$language["frontend.global.followed"].'");';
                        $ht_js          .= '});';
                        $ht_js          .= '});';
                        $ht_js          .= '$(document).on("click", ".unfollow-action", function(e){';
                        $ht_js          .= 'rel = $(this).attr("rel-usr"); if (rel === "'.$_SESSION["USER_KEY"].'") return;';
                        $ht_js          .= '$(".follow-txt-"+rel).text("'.$language["frontend.global.loading"].'");';
                        $ht_js          .= '$.post(c_url+"&do=user-unfollow", $("#user-files-form-"+rel).serialize(), function(data){';
                        $ht_js          .= '$(".follow-txt-"+rel).text("'.$language["frontend.global.unfollowed"].'");';
                        $ht_js          .= '});';
                        $ht_js          .= '});';
                }

                        $html   .= $ht_js != '' ? '
                                <script type="text/javascript">
                                        $(function(){'.$ht_js.'});
                                </script>
                        ' : null;
		
		return $html;
	}
	private static function getFeaturedCategories($page = 1) {
		$db	 = self::$db;
		$language= self::$language;
		$cfg	 = self::$cfg;
		$uid	 = (int) $_SESSION["USER_ID"];
		$html	 = null;

		$rs	 = $db->execute(sprintf("SELECT `ct_id`, `ct_name`, `ct_type` FROM `db_categories` WHERE `ct_featured`='1' AND `ct_active`='1';"));
/*
		if ($rs->fields["ct_id"]) {
			while (!$rs->EOF) {
				$ct_id = $rs->fields["ct_id"];
				$ct_name = $rs->fields["ct_name"];
				$ct_type = $rs->fields["ct_type"];

				$rs->MoveNext();
			}
		}
*/
		return $rs;
	}
	private static function getFeaturedChannels($page = 1) {
		$db	 = self::$db;
		$language= self::$language;
		$cfg	 = self::$cfg;
		$uid	 = (int) $_SESSION["USER_ID"];

		if (self::$home_cfg and is_array(self::$home_cfg)) {
			$ids	 = false;
			$hcfg	 = self::$home_cfg;

			if ($hcfg["channels"]["module"] == 0) {
				return;
			}

			if ($hcfg["channels"]["subscriptions"] == 1) {//get my subscriptions user ids
				$rs	= $db->execute(sprintf("SELECT `usr_id` FROM `db_subscribers` WHERE `subscriber_id` LIKE '%s';", '%"sub_id";i:'.$uid.';%'));
				if ($rs->fields['usr_id']) {
					if (!is_array($ids)) {
						$ids	= array();
					}
//					$ids	= array();

					while (!$rs->EOF) {
						$ids[]	= $rs->fields["usr_id"];
						
						$rs->MoveNext();
					}
				}
			}

			if ($hcfg["channels"]["follows"] == 1) {//get my follows user ids
				$rs	= $db->execute(sprintf("SELECT `usr_id` FROM `db_followers` WHERE `follower_id` LIKE '%s';", '%"sub_id";i:'.$uid.';%'));
				if ($rs->fields['usr_id']) {
					if (!is_array($ids)) {
						$ids	= array();
					}
//					$ids	= array();

					while (!$rs->EOF) {
						if (!in_array($rs->fields["usr_id"], $ids))
							$ids[]	= $rs->fields["usr_id"];
						
						$rs->MoveNext();
					}
				}
			}

			if ($hcfg["channels"]["extra"] == 1) {//get user ids from supplied list
				$unames	 = array();
				$ulist	 = explode("\n", $hcfg["channels"]["extra_list"]);

				foreach ($ulist as $name) {
					if ($name[2] != '') {
						$unames[] = "'".self::$filter->clr_str(trim($name))."'";
					}
				}
				$tt	 = count($unames);
				
				if ($tt > 0) {
					$rs	= $db->execute(sprintf("SELECT `usr_id` FROM `db_accountuser` WHERE `usr_user` IN (%s) ORDER BY FIND_IN_SET(`usr_user`, '%s');", implode(",", $unames), str_replace("'", '', implode(",", $unames))));

					if ($rs->fields['usr_id']) {
						if (!is_array($ids)) {
							$ids	= array();
						}

						while (!$rs->EOF) {
							if (!in_array($rs->fields["usr_id"], $ids)) {
								$ids[]	= $rs->fields["usr_id"];
							}
						
							$rs->MoveNext();
						}
					}
				}
			}
			
			if (is_array($ids)) {
				$_q	= sprintf("AND A.`usr_id` IN (%s)", implode(',', $ids));
			}
		} else {
			$_q	 = "AND A.`usr_featured`='1'";
		}
		
		if ($page) {
		    switch ($page) {
			case 3:
			    $lim = "5, 5";
			    break;

			case 2:
			    $lim = "1, 4";
			    break;

			default:
			    $lim = "0, 1";
			    break;
		    }
		}
		
		$sql	 = sprintf("SELECT
					A.`usr_id`, A.`usr_key`, A.`usr_user`, A.`usr_affiliate`, A.`usr_partner`,
					A.`usr_dname`, A.`ch_views`, A.`ch_title`, A.`affiliate_badge`
					FROM 
					`db_accountuser` A
					WHERE 
					A.`usr_status`='1'
					%s
					%s
					LIMIT %s;", $_q, ($uid > 0 ? (is_array($ids) ? "ORDER BY FIND_IN_SET(A.`usr_id`, '".implode(',', $ids)."')" : null) : null), $lim);
		
		$res	 = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_home_featured_channels'], $sql) : self::$db->execute($sql);

		if ($res->fields["usr_id"]) {
			return $res;
		}
	}
	/* recommended more */
	public static function recommend_more() {
		echo self::featuredMedia('video');
	}
	/* list media content 
	 * $ares = true trending
	 * $ares = false recommended/featured
	 * $ares = array subscriptions/featured channels
	 */
	private static function featuredMedia($type = 'video', $ares = false, $ct_id = false) {
		$cfg	 = self::$cfg;
		$db	 = self::$db;
		$language= self::$language;

		switch ($type[0]) {
			case "l": $href_key = 'broadcasts'; break;
			case "v": $href_key = 'videos'; break;
			case "i": $href_key = 'images'; break;
			case "a": $href_key = 'audios'; break;
			case "d": $href_key = 'documents'; break;
			case "b": $href_key = 'blogs'; break;
		}

		$_o = ((int) $_SESSION["USER_ID"] > 0 and !$ct_id) ? "ORDER BY RAND()" : null;
		$_o = null;
		if (is_array($ares)) {
			//$is_sub_array	 = array();

			$usr_key	 = $ares["usr_key"];
			$_q		 = sprintf("AND %sB.`usr_id`='%s'%s", ((int) $_SESSION["USER_ID"] == 0 ? "(" : null), $ares["usr_id"], ((int) $_SESSION["USER_ID"] == 0 ? ")" : null));
			$_o		 = "ORDER BY B.`upload_date` DESC";
			
			if (self::$home_cfg and is_array(self::$home_cfg)) {//list channels content
				$hcfg	 = self::$home_cfg;
					
				if ($hcfg["channels"]["module"] == 0) {
					return;
				}
				
				$type	 = $hcfg["channels"]["content_type"];
				
				switch ($hcfg["channels"]["display"]) {
					default:
					case "uploads":
						$_o	= "ORDER BY B.`upload_date` DESC";
						break;
					case "views":
						$_o	= "ORDER BY B.`file_views` DESC";
						break;
					case "likes":
						$_o	= "ORDER BY B.`file_like` DESC";
						break;
					case "random":
						$_o	= "ORDER BY RAND()";
						break;
				}
				
				$featured	 = $hcfg["channels"]["filter_featured"] == 1 ? true : false;
				$promoted	 = $hcfg["channels"]["filter_promoted"] == 1 ? true : false;
				
				if ($featured or $promoted) {
					$_f	 = $featured ? "B.`is_featured`='1' " : null;
					$_p	 = $promoted ? "B.`is_promoted`='1' " : null;
					$_q	.= sprintf(" AND (%s %s %s)) ", $_f, (($featured and $promoted) ? "OR" : null), $_p);
				} else {
					$_q	.= ') ';
				}
			}

			$usr_affiliate	 = $ares["usr_affiliate"];
			$usr_partner	 = $ares["usr_partner"];
			$usr_affiliate	 = ($usr_affiliate == 1 or $usr_partner == 1) ? 1 : 0;
			$af_badge	 = $ares["affiliate_badge"];

			$_user		 = ($ares["usr_dname"] != '' ? $ares["usr_dname"] : ($ares["ch_title"] != '' ? $ares["ch_title"] : $ares["usr_user"]));
			$_heading	 = '<a href="'.$cfg["main_url"].'/'.VHref::getKey("channel").'/'.$usr_key.'/'.$ares["usr_user"].'/'.VHref::getKey($href_key).'">'.$_user.VAffiliate::affiliateBadge($usr_affiliate, $af_badge).'</a>';
			$img_file	 = $cfg["profile_images_dir"].'/'.$usr_key.'/'.$usr_key.'.jpg';
			$img_url	 = $cfg["profile_images_url"].'/'.$usr_key.'/'.$usr_key.'.jpg';
			$def_url	 = $cfg["profile_images_url"].'/default.jpg';
			$bg_url		 = file_exists($img_file) ? $img_url : $def_url;

			$_icon		 = '<img alt="'.$_user.'" title="'.$_user.'" height="32" src="'.$bg_url.'" />';

			if ($cfg["user_follows"] == 1) {
				$is_sub_array	 = array();
				$sql		 = sprintf("SELECT A.`follower_id`, B.`usr_followcount` FROM `db_followers` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`usr_id`='%s' LIMIT 1;", $ares["usr_id"]);
				$rs		 = self::$db_cache ? $db->CacheExecute($cfg['cache_home_subs_follows'], $sql) : $db->execute($sql);

				if ($rs->fields["follower_id"]) {
					$s = unserialize($rs->fields["follower_id"]);

					if (!empty($s)) {
						foreach ($s as $ar) {
							if ($ar["sub_id"] == (int) $_SESSION["USER_ID"]) {
								$is_sub_array[] = $ares["usr_id"];
							}
						}
						$user_followtotal	 = $rs->fields["usr_followcount"];
					}
				}

				$is_follow = in_array($ares["usr_id"], $is_sub_array) ? true : false;
				$f_cls = (int) $_SESSION["USER_ID"] > 0 ? ($is_follow ? 'unfollow-action' : 'follow-action') : 'sub-login';
				$f_txt = $is_follow ? $language["frontend.global.unfollow"] : (($ares["usr_id"] == (int) $_SESSION["USER_ID"]) ? $language["frontend.global.followers"] : $language["frontend.global.follow"]);
			}

			if ($cfg["user_subscriptions"] == 1) {
				$is_sub_array	 = array();
				$sql		 = sprintf("SELECT A.`subscriber_id`, B.`usr_subcount` FROM `db_subscribers` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`usr_id`='%s' LIMIT 1;", $ares["usr_id"]);
				$rs		 = self::$db_cache ? $db->CacheExecute($cfg['cache_home_subs_follows'], $sql) : $db->execute($sql);

				if ($rs->fields["subscriber_id"]) {
					$s = unserialize($rs->fields["subscriber_id"]);

					if (!empty($s)) {
						foreach ($s as $ar) {
							if ($ar["sub_id"] == (int) $_SESSION["USER_ID"]) {
								$is_sub_array[] = $ares["usr_id"];
							}
						}
						$user_subtotal	 = $rs->fields["usr_subcount"];
					}
				}

				$is_sub = in_array($ares["usr_id"], $is_sub_array) ? true : false;
				if ($is_sub == 0) {
					$ts = self::$db->execute(sprintf("SELECT `db_id` FROM `db_subtemps` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `pk_id`>'0' AND `expire_time`>='%s' AND `active`='1' LIMIT 1;", (int) $_SESSION["USER_ID"], $ares["usr_id"], date("Y-m-d H:i:s")));
					if ($ts->fields["db_id"]) {
						$is_sub = true;
					}
				}
				$a_cls = (int) $_SESSION["USER_ID"] > 0 ? ($is_sub ? 'unsubscribe-button' : 'subscribe-button') : 'sub-login';
				$a_txt = $is_sub ? $language["frontend.global.unsubscribe"] : (($ares["usr_id"] == (int) $_SESSION["USER_ID"]) ? $language["frontend.global.subscribers"] : $language["frontend.global.subscribe"]);

				if ($is_sub) {
					$ub	= 1;
					$suid	= self::$dbc->singleFieldValue('db_accountuser', 'usr_id', 'usr_key', $usr_key, (self::$db_cache ? $cfg['cache_home_subs_follows'] : false));
					$sql	= sprintf("SELECT A.`db_id`, A.`expire_time`, B.`pk_name` FROM `db_subusers` A, `db_subtypes` B WHERE A.`usr_id`='%s' AND A.`usr_id_to`='%s' AND A.`pk_id`=B.`pk_id` AND A.`pk_id`>'0' LIMIT 1;", (int) $_SESSION["USER_ID"], $suid);
					$nn	= self::$db_cache ? $db->CacheExecute($cfg['cache_home_subs_follows'], $sql) : $db->execute($sql);
					$sn	= $nn->fields["pk_name"].'<br><span class="csm"><label class="">'.self::$language["frontend.global.active.until"].'</label> '.$nn->fields["expire_time"].'</span>';

					if (!$nn->fields["db_id"]) {
						$ub	= 0;
						$sql	= sprintf("SELECT A.`db_id`, A.`expire_time`, B.`pk_name` FROM `db_subtemps` A, `db_subtypes` B WHERE A.`usr_id`='%s' AND A.`usr_id_to`='%s' AND A.`pk_id`=B.`pk_id` AND A.`pk_id`>'0' AND A.`expire_time`>='%s' LIMIT 1;", (int) $_SESSION["USER_ID"], $suid, date("Y-m-d H:i:s"));
						$nn	= self::$db_cache ? $db->CacheExecute($cfg['cache_home_subs_follows'], $sql) : $db->execute($sql);
						$sn	= $nn->fields["pk_name"].'<br><span class="csm"><label class="">'.self::$language["frontend.global.active.until"].'</label> '.$nn->fields["expire_time"].'</span>';
					}
				}
			}

			$sub_html	= '
									<div class="place-right channel-subscribe-button">
										'.(($cfg["user_subscriptions"] == 1 or $cfg["user_follows"] == 1) ? '
										<div class="subscribers profile_count">
											'.($cfg["user_subscriptions"] == 1 ? '
											'.($is_sub ? '<a href="javascript:;" onclick="$(\'#uu-'.$usr_key.'\').stop().slideToggle(\'fast\')" class="sub-opt"><div class="sub-txt">'.$language["frontend.global.subscription"].'</div></a>' : '<a href="javascript:;" class="'.$a_cls.' count_link ch-'.$usr_key.'" rel-usr="'.$usr_key.'" rel="nofollow"><div class="sub-txt sub-txt-'.$usr_key.'"'.((int) $_SESSION["USER_ID"] == 0 ? ' rel="tooltip" title="'.$language["main.text.subscribe"].'"' : null).'>'.((int) $_SESSION["USER_ID"] != $ares["usr_id"] ? $a_txt : $language["frontend.global.subscribers.cap"]).' '.VFiles::numFormat((int) $user_subtotal).'</div></a>').'
											' : null).'
											'.($cfg["user_follows"] == 1 ? '
											<a href="javascript:;" class="'.$f_cls.' count_link ch-'.$usr_key.'" rel-usr="'.$usr_key.'" rel="nofollow">
												<div class="follow-txt follow-txt-'.$usr_key.'"'.((int) $_SESSION["USER_ID"] == 0 ? ' rel="tooltip" title="'.$language["main.text.follow"].'"' : null).'>'.((int) $_SESSION["USER_ID"] != $ares["usr_id"] ? $f_txt : $language["frontend.global.followers.cap"]).' '.VFiles::numFormat((int) $user_followtotal).'</div>
											</a>
											' : null).'
											<form id="user-files-form-'.$usr_key.'" method="post" action="">
												<input type="hidden" name="uf_vuid" value="'.$ares["usr_id"].'" />
											</form>
										</div>
										' : null).'
											<ul class="uu arrow_box" id="uu-'.$usr_key.'" style="display: none;">
												<li class="uu1"><i class="icon-star"></i> '.$language["frontend.global.sub.your"].'</li>
												<li class="uu2">'.str_replace('32', '48', $_icon).' <a href="'.self::$cfg["main_url"].'/'.VHref::getKey('channel').'/'.$usr_key.'/'.$ares["usr_user"].'">'.$_user.'</a> - '.$sn.'</li>
												<li><center>
													<button type="button" class="subscribe-button save-entry-button button-grey search-button form-button sub-uu" rel-usr="'.$usr_key.'" value="1" name="upgrade_subscription"><span>'.$language["frontend.global.sub.upgrade"].'</span></button>
													'.($ub ? '<a class="unsubscribe-button cancel-trigger" rel-usr="'.$usr_key.'" href="javascript:;"><span>'.$language["frontend.global.unsubscribe"].'</span></a>' : null).'
													</center>
												</li>
											</ul>
									</div>
									';
			$default_section = 'channel-'.$usr_key;
			$main_section	 = 'channel_section';
		} else {
			if ((int) $_SESSION["USER_ID"] > 0 and !$ares) {
				$_q		 = "AND B.`is_featured`='1' ";
				if (self::$home_cfg and is_array(self::$home_cfg)) {
					$hcfg	 = self::$home_cfg;
					if ($hcfg["recommended"]["module"] == 1) {
						$type		 = $hcfg["recommended"]["content_type"];
						$_r		 = self::recommend($type);
						$_q		 = $_r["q"];

						switch ($hcfg["recommended"]["display"]) {
							default:
							case "relevance":
								$_o = "ORDER BY FIND_IN_SET(B.`file_key`, ".(str_replace("','", ",", $_r["l"])).")";
								break;
							case "uploads":
								$_o = "ORDER BY B.`upload_date` DESC";
								break;
							case "views":
								$_o = "ORDER BY B.`file_views` DESC";
								break;
							case "likes":
								$_o = "ORDER BY B.`file_like` DESC";
								break;
							case "random":
								$_o = "ORDER BY RAND()";
								break;
						}
					} else {
						return;
					}
				}
			} elseif((int) $_SESSION["USER_ID"] > 0 and $ares == 'categ') {
				$_q		 = "AND B.`is_featured`='1' ";
				
				if (self::$home_cfg and is_array(self::$home_cfg)) {
					$hcfg	 = self::$home_cfg;
					
					if ($hcfg["categories"]["module"] == 1) {
						switch ($hcfg["categories"]["display"]) {
							default:
							case "uploads":
								$_o = "ORDER BY B.`upload_date` DESC";
								break;
							case "views":
								$_o = "ORDER BY B.`file_views` DESC";
								break;
							case "likes":
								$_o = "ORDER BY B.`file_like` DESC";
								break;
							case "random":
								$_o = "ORDER BY RAND()";
								break;
						}
						$sql		= sprintf("SELECT `ct_name`, `ct_icon`, `ct_slug` FROM `db_categories` WHERE `ct_type`='%s' AND `ct_active`='1' AND `ct_id`='%s' LIMIT 1;", $type, $ct_id);
						$rs		= $db->execute($sql);
						$_cticon	= $rs->fields["ct_icon"];
						$_ctslug	= $rs->fields["ct_slug"];
						$_heading	= '<a href="'.$cfg["main_url"].'/'.VHref::getKey($href_key).'/'.$_ctslug.'">'.$rs->fields["ct_name"].'</a>';
						
						$default_section = 'category';
						$main_section	 = 'channel_section category_section';
						
						$featured	 = $hcfg["categories"]["filter_featured"] == 1 ? true : false;
						$promoted	 = $hcfg["categories"]["filter_promoted"] == 1 ? true : false;

						if ($featured or $promoted) {
							$_f	 = $featured ? "B.`is_featured`='1' " : null;
							$_p	 = $promoted ? "B.`is_promoted`='1' " : null;
							$_pq	 = sprintf("AND (%s %s %s)", $_f, (($featured and $promoted) ? "OR" : null), $_p);
						}
						
						$_q		 = sprintf("%s AND B.`file_category`='%s' ", $_pq, $ct_id);
					}
				}
			} else {
				$_q		 = (($ct_id > 0 and !$ares) ? null : ($type != 'live' ? "AND B.`is_featured`='1' ORDER BY RAND() " : null));
				//$_q		 = (($ct_id > 0 and !$ares) ? "AND B.`file_category`='".$ct_id."' ORDER BY B.`db_id` DESC " : ($type != 'live' ? "AND B.`is_featured`='1' ORDER BY RAND() " : null));
				//$_q		 = "AND B.`is_featured`='1' ORDER BY RAND() ";
			}
			
			if (!$ares) {
				$_heading	 = ($type == 'live' ? '<i class="icon-live"></i>'.$language["frontend.global.live.now"] : $language["frontend.global.recommended"]);
				if ($ct_id > 0) {
					$csql	 = $db->execute(sprintf("SELECT `ct_name`, `ct_icon`, `ct_type`, `ct_slug` FROM `db_categories` WHERE `ct_id`='%s' LIMIT 1;", $ct_id));
					switch ($csql->fields["ct_type"]) {
						case "video": $u = self::$href["videos"]; break;
						case "live": $u = self::$href["broadcasts"]; break;
						case "image": $u = self::$href["images"]; break;
						case "audio": $u = self::$href["audios"]; break;
						case "document": $u = self::$href["documents"]; break;
						case "blog": $u = self::$href["blogs"]; break;
					}
					$_heading	 = '<i class="'.$csql->fields["ct_icon"].'"></i><a href="'.$cfg["main_url"].'/'.$u.'/'.$csql->fields["ct_slug"].'">'.$csql->fields["ct_name"].'</a>';
				}
				$default_section = 'featured';
				$main_section	 = 'featured_section recommended_section';
			} elseif ($ares and $ares !== 'categ') {
				$_q		 = "AND (B.`upload_date` BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()) AND B.`file_views` > 0 ORDER BY RAND() ";
				$_heading	 = $language["frontend.global.trending"];
				$default_section = 'recommended';
				$main_section	 = 'featured_section';
				$_icon		 = 'icon-fire';
				
				if (self::$home_cfg and is_array(self::$home_cfg)) {
					$hcfg	 = self::$home_cfg;
					
					if ($hcfg["trending"]["module"] == 1) {
						if (in_array($hcfg["trending"]["content_type"], self::$mod)) {
							$type		 = $hcfg["trending"]["content_type"];
							$time		 = $hcfg["trending"]["time"];
							$interval	 = $time > 0 ? $time : false;
							$featured	 = $hcfg["trending"]["filter_featured"] == 1 ? true : false;
							$promoted	 = $hcfg["trending"]["filter_promoted"] == 1 ? true : false;
							
							$min_views	 = $hcfg["trending"]["min_views"];
							$min_likes	 = $hcfg["trending"]["min_likes"];
							
							$_dq		 = ($interval ? "AND (B.`upload_date` BETWEEN DATE_SUB(NOW(), INTERVAL ".$interval." DAY) AND NOW())" : null);
							
							if ($min_views > 0 or $min_likes > 0) {
								$_v	 = $min_views >= 0 ? "B.`file_views` >= ".$min_views : null;
								$_l	 = $min_likes >= 0 ? "B.`file_like` >= ".$min_likes : null;
								$_fq	 = sprintf("AND (%s %s %s)", $_v, (($min_views >= 0 or $min_likes >= 0) ? $hcfg["trending"]["operand"] : null), $_l);
							}
							
							if ($featured or $promoted) {
								$_f	 = $featured ? "B.`is_featured`='1' " : null;
								$_p	 = $promoted ? "B.`is_promoted`='1' " : null;
								$_pq	 = sprintf("AND (%s %s %s)", $_f, (($featured and $promoted) ? "OR" : null), $_p);
							}
							
							switch ($hcfg["trending"]["display"]) {
								default:
								case "uploads":
									$_o = "ORDER BY B.`upload_date` DESC";
									break;
								case "views":
									$_o = "ORDER BY B.`file_views` DESC";
									break;
								case "likes":
									$_o = "ORDER BY B.`file_like` DESC";
									break;
								case "random":
									$_o = "ORDER BY RAND()";
									break;
							}

							$_q		 = sprintf("%s %s %s", $_dq, $_fq, $_pq);//final trending query
						}
					} else {
						return;
					}
				}
			}
			
			$_icon		 = '<i class="'.(($ares and $ares !== "categ") ? 'icon-fire' : ($ares == 'categ' ? $_cticon : ($type == 'doc' ? 'icon-file' : ($type == 'blog' ? 'icon-pencil2' : 'icon-'.$type)))).'"></i>';
			$sub_html	 = null;
		}
		
		if (isset($_GET['rc']) and isset($_GET['rn'])) {
			$nr	= (int) $_GET['rn'];
			$lim	= sprintf("%s, %s", $nr, $nr);
		} else {
			$lim	= ($ct_id > 0) ? 5 : 10;
		}

		$_q		.= ($ct_id > 0 and !$ares) ? "AND B.`file_category`='".$ct_id."' ORDER BY B.`db_id` DESC " : null;

		$sql	 = sprintf("SELECT 
			    B.`file_key`, B.`old_file_key`, B.`old_key` AS `fkey`, B.`file_title`, B.`thumb_preview`,
			    B.`file_hd`, B.`file_views`, B.`file_duration`, B.`file_comments`, B.`file_like`, B.`upload_date`, B.`thumb_server`, B.`stream_live`,
			    C.`usr_affiliate`, C.`usr_partner`, C.`affiliate_badge`, C.`usr_id`, C.`usr_key`, C.`old_usr_key`, C.`old_key` AS `ukey`, C.`usr_user`, C.`usr_dname`, C.`ch_title`
			    FROM 
			    `db_%sfiles` B, `db_accountuser` C
			    WHERE 
			    B.`usr_id`=C.`usr_id` AND 
			    ".($type == 'live' ? "B.`stream_live`='1' AND" : null)."
			    B.`privacy`='public' AND 
			    B.`approved`='1' AND 
			    B.`deleted`='0' AND 
			    B.`active`='1' 
			    %s %s LIMIT %s;", $type, $_q, $_o, (!$ares ? $lim : 5));

		$res	 = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_home_featured_media'], $sql) : self::$db->execute($sql);

		if (!$res->fields["file_key"])
			return;

		if (isset($_GET['rc']) and isset($_GET['rn'])) {
			$user_watchlist  = VBrowse::watchlistEntries($type);

			$html		 = VBrowse::viewMode1($res, $user_watchlist, $type, (!$ares ? true : false));

			return $html;
		}
		
		$html	 = '	<div class="clearfix"></div>
				<section class="'.$main_section.' '.$default_section.'_'.$href_key.'">
				    <div class="container">
					<article>
						<h2 class="content-title">
							'.$_icon.'<span class="heading">'.$_heading.'</span>
						</h2>
						'.$sub_html.'
					</article>
					<article>
					    <div id="main-view-mode-1-'.$default_section.'-'.$type.'" class="homeContent '.$default_section.' '.$type.'">
						<div id="main-view-mode-1-'.$default_section.'-'.$type.'-list">
			';
	
		if ($res->fields["file_key"]) {
			$user_watchlist  = VBrowse::watchlistEntries($type);

			$html		.= VBrowse::viewMode1($res, $user_watchlist, $type, (!$ares ? true : false));
		}
		/*
		if (!$ares) {
			$html	.= '
						<div class="more-load place-right"></div>
						<div class="more-recommended"><a href="javascript:;" rel="nofollow" class="more">'.$language["main.text.show.more"].'</a></div>
				';
		}
		*/
		$html	.= '		        </div>
					    </div>
					</article>
				    </div>
				</section>';
		
		$html	.= '<div class="clearfix"></div>';
		$html	.= '<div class="line"></div>';
		
		return $html;
	}
	/* home config popup */
	public static function homeConfig() {
		$language	= self::$language;
		
		if ($_POST and isset($_GET["save"])) {
			self::homeForms(self::$filter->clr_str($_POST["home_section"]));
			
			exit;
		}
		
		$trending	= self::homeTabContent('trending');
		$recommended	= self::homeTabContent('recommended');
		$channels	= self::homeTabContent('channels');
		$categories	= self::homeTabContent('categories');
		
		$html		= '
				<div class="lb-margins">
					<article>
						<h3 class="content-title"><i class="icon-home"></i>'.$language["main.text.customize"].'</h3>
						<div class="line"></div>
					</article>

					<div class="tabs hometabs tabs-style-topline">
						<nav>
							<ul id="home-tabs">
								'.('<li><a href="#section-home-trending" class="icon icon-fire" rel="nofollow"><span>'.$language["frontend.global.trending"].'</span></a></li>').'
								'.('<li><a href="#section-home-recommended" class="icon icon-video" rel="nofollow"><span>'.$language["frontend.global.recommended"].'</span></a></li>').'
								'.('<li><a href="#section-home-channels" class="icon icon-users" rel="nofollow"><span>'.$language["frontend.global.channels"].'</span></a></li>').'
								'.('<li><a href="#section-home-categories" class="icon icon-menu2" rel="nofollow"><span>'.$language["frontend.global.categories"].'</span></a></li>').'
							</ul>
						</nav>
						<div id="home-response"></div>
						<div class="content-wrap">
							<section id="section-home-trending">
								<div>'.$trending.'</div>
							</section>
							<section id="section-home-recommended">
								<div>'.$recommended.'</div>
							</section>
							<section id="section-home-channels">
								<div>'.$channels.'</div>
							</section>
							<section id="section-home-categories">
								<div>'.$categories.'</div>
							</section>
						</div>
					</div>
				</div>
			';
		
		$ht_js	  = '	(function() {[].slice.call(document.querySelectorAll(".tabs.hometabs")).forEach(function (el) {new CBPFWTabs(el);});})();';
		$ht_js	 .= '
				$(".icheck-box input").each(function () {
					var self = $(this);
					self.iCheck({
						checkboxClass: "icheckbox_square-blue",
						radioClass: "iradio_square-blue",
						increaseArea: "20%"
					});
				});
				
				$(".hometabs .save-entry-button").click(function() {
					t = $(this);
					f = "#" + t.parent().parent().attr("id");
					u = current_url + menu_section + "?cfg&save";
					
					$(".fancybox-inner").mask(" ");
					$.post( u, $( f ).serialize(), function(data){
						$("#home-response").html(data);
						$(".fancybox-inner").unmask();
					});
					
				});
		';

	
		$html	 .= VGenerate::declareJS('$(document).ready(function(){'.$ht_js.'});');
		
		echo $html;
	}
	/* process config forms */
	private static function homeForms($type) {
		$db		= self::$db;
		$cfg		= self::$cfg;
		$home_cfg	= self::$home_cfg;
		$class_filter	= self::$filter;
		$language	= self::$language;
		
		$type_cfg	= $home_cfg[$type];
		
		switch ($type) {
			case "trending":
				$type_cfg["module"]		= (int) $_POST[$type."_module"];
				$type_cfg["content_type"]	= $class_filter->clr_str($_POST["content_type_".$type]);
				$type_cfg["time"]		= (int) $_POST[$type."_time_range"];
				$type_cfg["min_views"]		= (int) $_POST[$type."_min_views"];
				$type_cfg["min_likes"]		= (int) $_POST[$type."_min_likes"];
				$type_cfg["operand"]		= $class_filter->clr_str($_POST[$type."_operand"]);
				$type_cfg["display"]		= $class_filter->clr_str($_POST[$type."_display"]);
				$type_cfg["filter_featured"]	= (int) $_POST[$type."_include_featured"];
				$type_cfg["filter_promoted"]	= (int) $_POST[$type."_include_promoted"];
				
				$home_cfg[$type]		= $type_cfg;
				
				break;
			
			case "recommended":
				$type_cfg["module"]		= (int) $_POST[$type."_module"];
				$type_cfg["content_type"]	= $class_filter->clr_str($_POST["content_type_".$type]);
				$type_cfg["recommended_history"]= $class_filter->clr_str($_POST["recommended_history"]);
				$type_cfg["recommended_likes"]	= $class_filter->clr_str($_POST["recommended_likes"]);
				$type_cfg["recommended_favorites"]= $class_filter->clr_str($_POST["recommended_favorites"]);
				$type_cfg["time"]		= (int) $_POST[$type."_time_range"];
				$type_cfg["min_views"]		= (int) $_POST[$type."_min_views"];
				$type_cfg["min_likes"]		= (int) $_POST[$type."_min_likes"];
				$type_cfg["operand"]		= $class_filter->clr_str($_POST[$type."_operand"]);
				$type_cfg["display"]		= $class_filter->clr_str($_POST[$type."_display"]);
				$type_cfg["filter_featured"]	= (int) $_POST[$type."_include_featured"];
				$type_cfg["filter_promoted"]	= (int) $_POST[$type."_include_promoted"];
				
				$home_cfg[$type]		= $type_cfg;
				
				break;
			
			case "channels":
				$type_cfg["module"]		= (int) $_POST[$type."_module"];
				$type_cfg["content_type"]	= $class_filter->clr_str($_POST["content_type_".$type]);
				$type_cfg["subscriptions"]	= (int) $_POST[$type."_subscriptions"];
				$type_cfg["follows"]		= (int) $_POST[$type."_follows"];
				$type_cfg["extra"]		= (int) $_POST[$type."_extra"];
				$type_cfg["extra_list"]		= $class_filter->clr_str($_POST[$type."_extra_list"]);
				$type_cfg["display"]		= $class_filter->clr_str($_POST[$type."_display"]);
				$type_cfg["filter_featured"]	= (int) $_POST[$type."_include_featured"];
				$type_cfg["filter_promoted"]	= (int) $_POST[$type."_include_promoted"];
				
				$home_cfg[$type]		= $type_cfg;
				
				break;
			
			case "categories":
				$type_cfg["module"]		= (int) $_POST[$type."_module"];
				$type_cfg["live_".$type]	= serialize($_POST["content_type_live_".$type]);
				$type_cfg["video_".$type]	= serialize($_POST["content_type_video_".$type]);
				$type_cfg["image_".$type]	= serialize($_POST["content_type_image_".$type]);
				$type_cfg["audio_".$type]	= serialize($_POST["content_type_audio_".$type]);
				$type_cfg["doc_".$type]		= serialize($_POST["content_type_doc_".$type]);
				$type_cfg["blog_".$type]	= serialize($_POST["content_type_blog_".$type]);
				$type_cfg["display"]		= $class_filter->clr_str($_POST[$type."_display"]);
				$type_cfg["filter_featured"]	= (int) $_POST[$type."_include_featured"];
				$type_cfg["filter_promoted"]	= (int) $_POST[$type."_include_promoted"];
				
				$home_cfg[$type]		= $type_cfg;
				
				break;
		}
		
		$rs		= $db->execute(sprintf("UPDATE `db_accountuser` SET `home_cfg`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($home_cfg), (int) $_SESSION["USER_ID"]));
		
		if ($db->Affected_Rows() > 0) {
			echo VGenerate::noticeTpl('', '', $language["notif.success.request"]);
		}
	}
	/* generate tab config content */
	private static function homeTabContent($type) {
		$html		= null;
		
		$language	= self::$language;
		$cfg		= self::$cfg;
		$home_cfg	= self::$home_cfg;
		
		$type_cfg	= $home_cfg ? $home_cfg[$type] : array();
		
		switch ($type) {
			case "trending":
				$check_module_on	= $type_cfg["module"] == 1 ? ' checked="checked"' : null;
				$check_module_off	= $type_cfg["module"] == 0 ? ' checked="checked"' : null;
				$check_operand_and	= $type_cfg["operand"] == 'and' ? ' checked="checked"' : null;
				$check_operand_or	= $type_cfg["operand"] == 'or' ? ' checked="checked"' : null;
				$check_display_uploads	= $type_cfg["display"] == 'uploads' ? ' checked="checked"' : null;
				$check_display_views	= $type_cfg["display"] == 'views' ? ' checked="checked"' : null;
				$check_display_likes	= $type_cfg["display"] == 'likes' ? ' checked="checked"' : null;
				$check_display_random	= $type_cfg["display"] == 'random' ? ' checked="checked"' : null;
				$check_filter_featured	= $type_cfg["filter_featured"] == 1 ? ' checked="checked"' : null;
				$check_filter_promoted	= $type_cfg["filter_promoted"] == 1 ? ' checked="checked"' : null;
				
				$html	= '
						<form class="entry-form-class" id="home-trending-form">
							<h5>'.$language["main.text.heading.trending"].'</h5>
							<div class="icheck-box">
								<input'.$check_module_on.' type="radio" value="1" name="trending_module" class=""><label>'.$language["frontend.global.enable"].'</label>
								<input'.$check_module_off.' type="radio" value="0" name="trending_module" class=""><label>'.$language["frontend.global.disable"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.content"].'</h5>
							<div class="icheck-box">
								'.self::homeHTML('trending').'
							</div>
							
							<h5>'.$language["main.text.heading.time"].'</h5>
							<div>
								<label>'.$language["main.text.last.days"].'</label>
								<div><input type="text" name="trending_time_range" value="'.$type_cfg["time"].'"></div>
							</div>
							

							<h5>'.$language["main.text.heading.display.tip"].'</h5>
							<div>
								<label>'.$language["main.text.min.views"].'</label>
								<div><input type="text" name="trending_min_views" value="'.$type_cfg["min_views"].'"></div>
								<div class="icheck-box">
									<input'.$check_operand_and.' type="radio" value="and" name="trending_operand" class=""><label>'.$language["frontend.global.and"].'</label>
									<input'.$check_operand_or.' type="radio" value="or" name="trending_operand" class=""><label>'.$language["frontend.global.or"].'</label>
								</div>
								<label>'.$language["main.text.min.likes"].'</label>
								<div><input type="text" name="trending_min_likes" value="'.$type_cfg["min_likes"].'"></div>
							</div>
							
							<h5>'.$language["main.text.heading.sort"].'</h5>
							<div class="icheck-box">
								<input'.$check_display_uploads.' type="radio" value="uploads" name="trending_display" class=""><label>'.$language["main.text.recent.uploads"].'</label>
								<input'.$check_display_views.' type="radio" value="views" name="trending_display" class=""><label>'.$language["main.text.most.views"].'</label>
								<input'.$check_display_likes.' type="radio" value="likes" name="trending_display" class=""><label>'.$language["main.text.most.likes"].'</label>
								<input'.$check_display_random.' type="radio" value="random" name="trending_display" class=""><label>'.$language["main.text.random"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.filter"].'</h5>
							<div class="icheck-box">
								<input'.$check_filter_featured.' type="checkbox" value="1" name="trending_include_featured" class=""><label>'.$language["main.text.only.featured"].'</label>
								<input'.$check_filter_promoted.' type="checkbox" value="1" name="trending_include_promoted" class=""><label>'.$language["main.text.only.promoted"].'</label>
							</div>
							<br>
							<div class="save-button-row">
								<button name="save_changes_btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span>'.$language["frontend.global.savechanges"].'</span></button>
								<a class="link cancel-trigger" href="javascript:;" onclick="$(\'.close-lightbox\').click()"><span>'.$language["frontend.global.cancel"].'</span></a>
								<input type="hidden" name="home_section" value="'.$type.'">
							</div>
						</form>
					';
				break;
			
			case "recommended":
				$check_module_on	= $type_cfg["module"] == 1 ? ' checked="checked"' : null;
				$check_module_off	= $type_cfg["module"] == 0 ? ' checked="checked"' : null;
				$check_based_history	= $type_cfg["recommended_history"] == 1 ? ' checked="checked"' : null;
				$check_based_likes	= $type_cfg["recommended_likes"] == 1 ? ' checked="checked"' : null;
				$check_based_favorites	= $type_cfg["recommended_favorites"] == 1 ? ' checked="checked"' : null;
				$check_operand_and	= $type_cfg["operand"] == 'and' ? ' checked="checked"' : null;
				$check_operand_or	= $type_cfg["operand"] == 'or' ? ' checked="checked"' : null;
				$check_display_relevance= $type_cfg["display"] == 'relevance' ? ' checked="checked"' : null;
				$check_display_uploads	= $type_cfg["display"] == 'uploads' ? ' checked="checked"' : null;
				$check_display_views	= $type_cfg["display"] == 'views' ? ' checked="checked"' : null;
				$check_display_likes	= $type_cfg["display"] == 'likes' ? ' checked="checked"' : null;
				$check_display_random	= $type_cfg["display"] == 'random' ? ' checked="checked"' : null;
				$check_filter_featured	= $type_cfg["filter_featured"] == 1 ? ' checked="checked"' : null;
				$check_filter_promoted	= $type_cfg["filter_promoted"] == 1 ? ' checked="checked"' : null;
				
				$html	= '
						<form class="entry-form-class" id="home-recommended-form">
							<h5>'.$language["main.text.heading.recommended"].'</h5>
							<div class="icheck-box">
								<input'.$check_module_on.' type="radio" value="1" name="recommended_module" class=""><label>'.self::$language["frontend.global.enable"].'</label>
								<input'.$check_module_off.' type="radio" value="0" name="recommended_module" class=""><label>'.self::$language["frontend.global.disable"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.content"].'</h5>
							<div class="icheck-box">
								'.self::homeHTML('recommended').'
							</div>
							
							<h5>'.$language["main.text.heading.recommend.on"].'</h5>
							<div class="icheck-box">
								<input'.$check_based_history.' type="checkbox" value="1" name="recommended_history" class=""><label>'.$language["main.text.my.history"].'</label>
								<input'.$check_based_likes.' type="checkbox" value="1" name="recommended_likes" class=""><label>'.$language["main.text.my.likes"].'</label>
								<input'.$check_based_favorites.' type="checkbox" value="1" name="recommended_favorites" class=""><label>'.$language["main.text.my.favorites"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.time"].'</span></h5>
							<div>
								<label>'.$language["main.text.last.days"].'</label>
								<div><input type="text" name="recommended_time_range" value="'.$type_cfg["time"].'"></div>
							</div>
							

							<h5>'.$language["main.text.heading.display.tip"].'</h5>
							<div>
								<label>'.$language["main.text.min.views"].'</label>
								<div><input type="text" name="recommended_min_views" value="'.$type_cfg["min_views"].'"></div>
								<div class="icheck-box">
									<input'.$check_operand_and.' type="radio" value="and" name="recommended_operand" class=""><label>'.self::$language["frontend.global.and"].'</label>
									<input'.$check_operand_or.' type="radio" value="or" name="recommended_operand" class=""><label>'.self::$language["frontend.global.or"].'</label>
								</div>
								<label>'.$language["main.text.min.likes"].'</label>
								<div><input type="text" name="recommended_min_likes" value="'.$type_cfg["min_likes"].'"></div>
							</div>
							
							<h5>'.$language["main.text.heading.sort"].'</h5>
							<div class="icheck-box">
								<input'.$check_display_relevance.' type="radio" value="relevance" name="recommended_display" class=""><label>'.$language["main.text.relevance"].'</label>
								<input'.$check_display_uploads.' type="radio" value="uploads" name="recommended_display" class=""><label>'.$language["main.text.recent.uploads"].'</label>
								<input'.$check_display_views.' type="radio" value="views" name="recommended_display" class=""><label>'.$language["main.text.most.views"].'</label>
								<input'.$check_display_likes.' type="radio" value="likes" name="recommended_display" class=""><label>'.$language["main.text.most.likes"].'</label>
								<input'.$check_display_random.' type="radio" value="random" name="recommended_display" class=""><label>'.$language["main.text.random"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.filter"].'</h5>
							<div class="icheck-box">
								<input'.$check_filter_featured.' type="checkbox" value="1" name="recommended_include_featured" class=""><label>'.$language["main.text.only.featured"].'</label>
								<input'.$check_filter_promoted.' type="checkbox" value="1" name="recommended_include_promoted" class=""><label>'.$language["main.text.only.promoted"].'</label>
							</div>
							
							<br>
							<div class="save-button-row">
								<button name="save_changes_btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span>'.$language["frontend.global.savechanges"].'</span></button>
								<a class="link cancel-trigger" href="javascript:;" onclick="$(\'.close-lightbox\').click()"><span>'.$language["frontend.global.cancel"].'</span></a>
								<input type="hidden" name="home_section" value="'.$type.'">
							</div>
						</form>
					';
				break;
			
			case "channels":
				$check_module_on	= $type_cfg["module"] == 1 ? ' checked="checked"' : null;
				$check_module_off	= $type_cfg["module"] == 0 ? ' checked="checked"' : null;
				$check_subscriptions	= $type_cfg["subscriptions"] == 1 ? ' checked="checked"' : null;
				$check_follows		= $type_cfg["follows"] == 1 ? ' checked="checked"' : null;
				$check_extra		= $type_cfg["extra"] == 1 ? ' checked="checked"' : null;
				$check_display_uploads	= $type_cfg["display"] == 'uploads' ? ' checked="checked"' : null;
				$check_display_views	= $type_cfg["display"] == 'views' ? ' checked="checked"' : null;
				$check_display_likes	= $type_cfg["display"] == 'likes' ? ' checked="checked"' : null;
				$check_display_random	= $type_cfg["display"] == 'random' ? ' checked="checked"' : null;
				$check_filter_featured	= $type_cfg["filter_featured"] == 1 ? ' checked="checked"' : null;
				$check_filter_promoted	= $type_cfg["filter_promoted"] == 1 ? ' checked="checked"' : null;
				
				$html	= '
						<form class="entry-form-class" id="home-channels-form">
							<h5>'.$language["main.text.heading.channels"].'</h5>
							<div class="icheck-box">
								<input'.$check_module_on.' type="radio" value="1" name="channels_module" class=""><label>'.self::$language["frontend.global.enable"].'</label>
								<input'.$check_module_off.' type="radio" value="0" name="channels_module" class=""><label>'.self::$language["frontend.global.disable"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.content"].'</h5>
							<div class="icheck-box">
								'.self::homeHTML('channels').'
							</div>
							
							<h5>'.$language["main.text.heading.include"].'</h5>
							<div class="icheck-box">
								<input'.$check_subscriptions.' type="checkbox" value="1" name="channels_subscriptions" class=""><label>'.$language["main.text.my.subscriptions"].'</label><br>
								<input'.$check_follows.' type="checkbox" value="1" name="channels_follows" class=""><label>'.$language["main.text.my.follows"].'</label><br>
								<input'.$check_extra.' type="checkbox" value="1" name="channels_extra" class=""><label>'.$language["main.text.other.channels"].'</label>
								<textarea name="channels_extra_list">'.$type_cfg["extra_list"].'</textarea>
							</div>
							
							<h5>'.$language["main.text.heading.sort"].'</h5>
							<div class="icheck-box">
								<input'.$check_display_uploads.' type="radio" value="uploads" name="channels_display" class=""><label>'.$language["main.text.recent.uploads"].'</label>
								<input'.$check_display_views.' type="radio" value="views" name="channels_display" class=""><label>'.$language["main.text.most.views"].'</label>
								<input'.$check_display_likes.' type="radio" value="likes" name="channels_display" class=""><label>'.$language["main.text.most.likes"].'</label>
								<input'.$check_display_random.' type="radio" value="random" name="channels_display" class=""><label>'.$language["main.text.random"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.filter"].'</h5>
							<div class="icheck-box">
								<input'.$check_filter_featured.' type="checkbox" value="1" name="channels_include_featured" class=""><label>'.$language["main.text.only.featured"].'</label>
								<input'.$check_filter_promoted.' type="checkbox" value="1" name="channels_include_promoted" class=""><label>'.$language["main.text.only.promoted"].'</label>
							</div>
							
							<br>
							<div class="save-button-row">
								<button name="save_changes_btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span>'.$language["frontend.global.savechanges"].'</span></button>
								<a class="link cancel-trigger" href="javascript:;" onclick="$(\'.close-lightbox\').click()"><span>'.$language["frontend.global.cancel"].'</span></a>
								<input type="hidden" name="home_section" value="'.$type.'">
							</div>
						</form>
					';
				break;
			
			case "categories":
				$check_module_on	= $type_cfg["module"] == 1 ? ' checked="checked"' : null;
				$check_module_off	= $type_cfg["module"] == 0 ? ' checked="checked"' : null;
				$check_display_uploads	= $type_cfg["display"] == 'uploads' ? ' checked="checked"' : null;
				$check_display_views	= $type_cfg["display"] == 'views' ? ' checked="checked"' : null;
				$check_display_likes	= $type_cfg["display"] == 'likes' ? ' checked="checked"' : null;
				$check_display_random	= $type_cfg["display"] == 'random' ? ' checked="checked"' : null;
				$check_filter_featured	= $type_cfg["filter_featured"] == 1 ? ' checked="checked"' : null;
				$check_filter_promoted	= $type_cfg["filter_promoted"] == 1 ? ' checked="checked"' : null;
				
				$html	= '
						<form class="entry-form-class" id="home-categories-form">
							<h5>'.$language["main.text.heading.categories"].'</h5>
							<div class="icheck-box">
								<input'.$check_module_on.' type="radio" value="1" name="categories_module" class=""><label>'.self::$language["frontend.global.enable"].'</label>
								<input'.$check_module_off.' type="radio" value="0" name="categories_module" class=""><label>'.self::$language["frontend.global.disable"].'</label>
							</div>
							
							'.($cfg["live_module"] == 1 ? '
							<h5>'.$language["frontend.global.categ.l"].' (<a href="javascript:;" onclick="$(\'.home-live-categ\').toggleClass(\'hidden\')">select</a>)</h5>
							<div class="icheck-box">
								'.self::homeHTML('live_categories').'
							</div>
							' : null).'
								
							'.($cfg["video_module"] == 1 ? '
							<h5>'.$language["frontend.global.categ.v"].' (<a href="javascript:;" onclick="$(\'.home-video-categ\').toggleClass(\'hidden\')">select</a>)</h5>
							<div class="icheck-box">
								'.self::homeHTML('video_categories').'
							</div>
							' : null).'
							
							'.($cfg["image_module"] == 1 ? '
							<h5>'.$language["frontend.global.categ.i"].' (<a href="javascript:;" onclick="$(\'.home-image-categ\').toggleClass(\'hidden\')">select</a>)</h5>
							<div class="icheck-box">
								'.self::homeHTML('image_categories').'
							</div>
							' : null).'
							
							'.($cfg["audio_module"] == 1 ? '
							<h5>'.$language["frontend.global.categ.a"].' (<a href="javascript:;" onclick="$(\'.home-audio-categ\').toggleClass(\'hidden\')">select</a>)</h5>
							<div class="icheck-box">
								'.self::homeHTML('audio_categories').'
							</div>
							' : null).'
							
							'.($cfg["document_module"] == 1 ? '
							<h5>'.$language["frontend.global.categ.d"].' (<a href="javascript:;" onclick="$(\'.home-doc-categ\').toggleClass(\'hidden\')">select</a>)</h5>
							<div class="icheck-box">
								'.self::homeHTML('doc_categories').'
							</div>
							' : null).'
							
							'.($cfg["blog_module"] == 1 ? '
							<h5>'.$language["frontend.global.categ.b"].' (<a href="javascript:;" onclick="$(\'.home-blog-categ\').toggleClass(\'hidden\')">select</a>)</h5>
							<div class="icheck-box">
								'.self::homeHTML('blog_categories').'
							</div>
							' : null).'
							
							<h5>'.$language["main.text.heading.display"].'</h5>
							<div class="icheck-box">
								<input'.$check_display_uploads.' type="radio" value="uploads" name="categories_display" class=""><label>'.$language["main.text.recent.uploads"].'</label>
								<input'.$check_display_views.' type="radio" value="views" name="categories_display" class=""><label>'.$language["main.text.most.views"].'</label>
								<input'.$check_display_likes.' type="radio" value="likes" name="categories_display" class=""><label>'.$language["main.text.most.likes"].'</label>
								<input'.$check_display_random.' type="radio" value="random" name="categories_display" class=""><label>'.$language["main.text.random"].'</label>
							</div>
							
							<h5>'.$language["main.text.heading.filter"].'</h5>
							<div class="icheck-box">
								<input'.$check_filter_featured.' type="checkbox" value="1" name="categories_include_featured" class=""><label>'.$language["main.text.only.featured"].'</label>
								<input'.$check_filter_promoted.' type="checkbox" value="1" name="categories_include_promoted" class=""><label>'.$language["main.text.only.promoted"].'</label>
							</div>
							
							<br>
							<div class="save-button-row">
								<button name="save_changes_btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span>'.$language["frontend.global.savechanges"].'</span></button>
								<a class="link cancel-trigger" href="javascript:;" onclick="$(\'.close-lightbox\').click()"><span>'.$language["frontend.global.cancel"].'</span></a>
								<input type="hidden" name="home_section" value="'.$type.'">
							</div>
						</form>
					';
				break;
		}
		
		return $html;
	}
	/* generate content type radio buttons */
	private static function homeHTML($for) {
		$html		= null;
		
		$language	= self::$language;
		$cfg		= self::$cfg;
		$home_cfg	= self::$home_cfg;
		
		switch ($for) {
			case "live_categories":
			case "video_categories":
			case "image_categories":
			case "audio_categories":
			case "doc_categories":
			case "blog_categories":
				$type_cfg	= $home_cfg ? $home_cfg['categories'] : array();
				$tbl	= 'db_' . str_replace('_', '', $for);
				$type	= str_replace('_categories', '', $for);
				
				$db	= self::$db;
				
				$sql	= sprintf("SELECT `ct_id`, `ct_name` FROM `db_categories` WHERE `ct_type`='%s' AND `ct_active`='1' ORDER BY `ct_name`;", $type);
				$rs	= self::$db_cache ? $db->CacheExecute(self::$cfg['cache_home_promoted'], $sql) : $db->execute($sql);
				
				if ($rs->fields["ct_id"]) {
					while (!$rs->EOF) {
						$a		 = unserialize($type_cfg[$for]);
						$check_on	 = (is_array($a) and in_array($rs->fields["ct_id"], $a)) ? ' checked="checked"' : null;
						
						$html		.= '<span class="home-'.$type.'-categ hidden"><input'.$check_on.' type="checkbox" value="'.$rs->fields["ct_id"].'" name="content_type_'.$for.'[]" class=""><label>'.$rs->fields["ct_name"].'</label></span>';
						
						$rs->MoveNext();
					}
				}
				
				break;
			
			default:
				$type_cfg	= $home_cfg ? $home_cfg[$for] : array();
				$modules	= self::$mod;

				foreach ($modules as $module) {
					$module_name	= $module . '_module';

					if (self::$cfg[$module_name] == 1) {
						$check_on= $type_cfg["content_type"] == $module ? ' checked="checked"' : null;

						$html	.= '<input'.$check_on.' type="radio" value="'.$module.'" name="content_type_'.$for.'" class=""><label>'.self::$language["frontend.global.".$module[0].".p.c"].'</label>';
					}
				}
				
				break;
		}
		
		return $html;
	}
	/* recommend videos */
	private static function recommend($type) {
		$db	 = self::$db;
		$cfg	 = self::$cfg;
		$hcfg	 = self::$home_cfg;

		if (VSession::isLoggedIn()) {
			if (in_array($hcfg["recommended"]["content_type"], self::$mod)) {
				$usr_id		 = (int) $_SESSION["USER_ID"];
				$fields		 = array();
				$tables		 = array();
				$where		 = array();
				
				$type		 = $hcfg["recommended"]["content_type"];
				$rhistory	 = $hcfg["recommended"]["recommended_history"];
				$rlikes		 = $hcfg["recommended"]["recommended_likes"];
				$rfavorites	 = $hcfg["recommended"]["recommended_favorites"];
				
				$fields[]	 = $rhistory == '1' ? "A.`history_list`" : "A.`usr_id`";
				$fields[]	 = $rlikes == '1' ? "B.`liked_list`" : "B.`usr_id`";
				$fields[]	 = $rfavorites == '1' ? "C.`fav_list`" : "C.`usr_id`";
				
				$tables[]	 = sprintf("`db_%shistory` A", $type);
				$tables[]	 = sprintf("`db_%sliked` B", $type);
				$tables[]	 = sprintf("`db_%sfavorites` C", $type);
				
				$where[]         = "A.`usr_id`='".$usr_id."'";
                                $where[]         = "B.`usr_ud`='".$usr_id."'";
                                $where[]         = "C.`usr_id`='".$usr_id."'";

				$time		 = $hcfg["recommended"]["time"];
				$interval	 = $time > 0 ? $time : false;
				$featured	 = $hcfg["recommended"]["filter_featured"] == 1 ? true : false;
				$promoted	 = $hcfg["recommended"]["filter_promoted"] == 1 ? true : false;

				$min_views	 = $hcfg["recommended"]["min_views"];
				$min_likes	 = $hcfg["recommended"]["min_likes"];

				$_dq		 = ($interval ? "AND (D.`upload_date` BETWEEN DATE_SUB(NOW(), INTERVAL " . $interval . " DAY) AND NOW())" : null);

				if ($min_views > 0 or $min_likes > 0) {
					$_v	 = $min_views > 0 ? "D.`file_views` >= " . $min_views : null;
					$_l	 = $min_likes > 0 ? "D.`file_like` >= " . $min_likes : null;
					$_fq	 = sprintf("AND (%s %s %s)", $_v, (($min_views > 0 and $min_likes > 0) ? $hcfg["recommended"]["operand"] : null), $_l);
				}

				if ($featured or $promoted) {
					$_f	 = $featured ? "D.`is_featured`='1' " : null;
					$_p	 = $promoted ? "D.`is_promoted`='1' " : null;
					$_pq	 = sprintf("AND (%s %s %s)", $_f, (($featured and $promoted) ? "OR" : null), $_p);
				}

				$_q		 = sprintf("%s %s %s", $_dq, $_fq, $_pq);//almost final recommended query
			}
			
			if ($rhistory == '1') {
                                $hq     = sprintf("SELECT %s FROM %s WHERE %s LIMIT 1;", $fields[0], $tables[0], $where[0]);
                                $hr     = $db->execute($hq);
                                $h      = $hr->fields["history_list"];
                        }
                        if ($rlikes == '1') {
                                $hq     = sprintf("SELECT %s FROM %s WHERE %s LIMIT 1;", $fields[1], $tables[1], $where[1]);
                                $hr     = $db->execute($hq);
                                $l      = $hr->fields["liked_list"];
                        }
                        if ($rfavorites == '1') {
                                $hq     = sprintf("SELECT %s FROM %s WHERE %s LIMIT 1;", $fields[2], $tables[2], $where[2]);
                                $hr     = $db->execute($hq);
                                $f      = $hr->fields["fav_list"];
                        }

			$_a		= array();
			
			if ($h != '') { $_a[]	= 'h'; }
			if ($l != '') { $_a[]	= 'l'; }
			if ($f != '') { $_a[]	= 'f'; }
			
			$k = !empty($_a) ? array_rand($_a) : 0;
			$v = $_a[$k];

			if ($h and $v == 'h') {//recommend based on history
				$filekey	= array();
				$views		= array();
				$history	= unserialize($h);
				
				$ch		= 1;
				
				foreach ($history as $key => $row) {
					if ($ch <= 10) {
						$filekey[$key]	= $row[0];
						$views[$key]	= $row[1];
					
						$ch		= $ch+1;
					}
				}

				if ($ch <= 10) {
					array_multisort($views, SORT_DESC, $history);
				}
				
				return self::recommended_arrays($type, $history, $_q);
			}
			
			
			if ($l and $v == 'l') {//recommend based on likes
				$liked		= unserialize($l);
				
				return self::recommended_arrays($type, $liked, $_q);
			}
			
			if ($f and $v == 'f') {//recommend based on favorites
				$fav		= unserialize($f);

				return self::recommended_arrays($type, $fav, $_q);
			}
		}
	}
	/* recommended arrays */
	private static function recommended_arrays($type, $list, $_q) {
		$r_list		= array();

		if (is_array($list[0])) {
			foreach ($list as $most_viewed) {
				$file_key	= $most_viewed[0];
				$keys		= self::relatedSQL($type, $file_key, $_q);

				if (is_array($keys)) {
					$r_list[] = $keys;
				}
			}
		} elseif (is_array($list)) {
			$ch		= 1;
			
			if ($ch <= 10) {
				foreach ($list as $file_key) {
					$keys		= self::relatedSQL($type, $file_key, $_q);

					if (is_array($keys)) {
						$r_list[] = $keys;
					}

					$ch		= $ch+1;
				}
			}
		}

		$recommended_list = array_map("unserialize", array_unique(array_map("serialize", $r_list)));

		$q = array();

		foreach ($recommended_list as $entry) {
			foreach ($entry as $key) {
				$q[] = "'" . $key . "'";
			}
		}

		if ($q[0] != '') {
			$results = array();
			$results["l"] = implode(",", $q);
			$results["q"] = sprintf("AND B.`file_key` IN (%s)", $results["l"]);

			return $results;
		}
	}
	/* related files query */
	private static function relatedSQL($type, $vid, $extra_query = '') {
		$db		 = self::$db;
		$cfg		 = self::$cfg;
		$hcfg		 = self::$home_cfg;
		
		if (is_array($vid)) {
			$vid	 = $vid[0];
		}

		$trs		 = $db->execute(sprintf("SELECT `file_title`, `file_tags` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $type, $vid));
		$vtitle		 = $trs->fields["file_title"];
		$vtags		 = $trs->fields["file_tags"];
		
		$rstr1		 = str_replace(array('_', '-', ' ', '.', ','), array('%', '%', '%', '%', '%'), $vtitle);//related string
		$rstr2		 = str_replace(array('_', '-', ' ', '.', ','), array('%', '%', '%', '%', '%'), $vtags);//related tags;
		$rel		 = $rstr1.'%'.$rstr2;
		
		switch ($hcfg["recommended"]["display"]) {
			default:
			case "relevance":
				$_o = "ORDER BY `Relevance` DESC";
				break;
			case "uploads":
				$_o = "ORDER BY D.`upload_date` DESC";
				break;
			case "views":
				$_o = "ORDER BY D.`file_views` DESC";
				break;
			case "likes":
				$_o = "ORDER BY D.`file_like` DESC";
				break;
			case "random":
				$_o = "ORDER BY RAND()";
				break;
		}

		$rsql		 = "SELECT 
					B.`usr_key`,
					D.`privacy`, 
					D.`file_key`,
					MATCH(D.`file_title`,D.`file_tags`) 
					AGAINST ('" . $rel . "') as `Relevance` FROM
					`db_accountuser` B, `db_" . $type . "files` D 
					WHERE MATCH (D.`file_title`,D.`file_tags`) 
					AGAINST('" . $rel . "' IN BOOLEAN MODE) AND 
					D.`file_key`!='" . $vid . "' AND 
					D.`active`='1' AND 
					D.`approved`='1' AND 
					D.`deleted`='0' AND 
					D.`privacy`='public' AND 
					D.`usr_id`=B.`usr_id`
					".$extra_query."
					ORDER BY `Relevance` DESC 
					LIMIT 2;";
		
		$rs		 = $db->execute($rsql);
		
		$keys		 = false;
		
		if ($rs->fields["file_key"]) {
			$keys	 = array();
			
			while (!$rs->EOF) {
				$keys[]	 = $rs->fields["file_key"];
				
				$rs->MoveNext();
			}
		}
		
		return $keys;
	}
	/* user notifications list */
	public static function userNotifications($show_hidden = false) {
		$html		= null;
		$uid		= (int) $_SESSION["USER_ID"];
		
		$db		= self::$db;
		$cfg		= self::$cfg;
		$class_filter	= self::$filter;
		$page		= isset($_GET["p"]) ? (int) $_GET["p"] : 1;
		$ids		= array();

		if ($uid > 0) {
			if ($cfg["user_subscriptions"] == 1) {
				$rs	= $db->execute(sprintf("SELECT `usr_id` FROM `db_subscribers` WHERE `subscriber_id` LIKE '%s';", '%"sub_id";i:'.$uid.';%'));
				if ($rs->fields["usr_id"]) {
					while (!$rs->EOF) {
						$ids[] = $rs->fields["usr_id"];

						$rs->MoveNext();
					}
				}
			}

			if ($cfg["user_follows"] == 1) {
				$rs	= $db->execute(sprintf("SELECT `usr_id` FROM `db_followers` WHERE `follower_id` LIKE '%s';", '%"sub_id";i:'.$uid.';%'));
				if ($rs->fields["usr_id"]) {
					while (!$rs->EOF) {
						if (!in_array($rs->fields["usr_id"], $ids))
							$ids[] = $rs->fields["usr_id"];

						$rs->MoveNext();
					}
				}
			}

			if ($page == 1) {
				$html	= '
					<p class="notification-entries-heading">
						'.self::$language["frontend.global.notifications"].'
						<i class="icon-eye-blocked hidden-notifications'.($show_hidden ? ' active' : null).'" rel="tooltip" title="'.self::$language["frontend.global.notification.toggle"].'"></i>
					</p>
				';
			}
			if (isset($ids[0])) {
				$html	.= self::userActivity($ids, $show_hidden);
				if ($page == 1) {
					$html	.= '
						<div class="line toggle-off"></div>
						<div id="more-results">
							<center>
								<a href="javascript:;" rel="nofollow">
									<span class="info-toggle notifications-more" rel-page="2">'.self::$language["frontend.global.load.more"].'</span>
								</a>
							</center>
						</div>
					';
				}
			}
		}
		
		echo $html;
	}
	/* generate subscriber activity */
	private static function userActivity($ids, $show_hidden) {
		$html		= null;
		$cfg		= self::$cfg;
		$db		= self::$db;
		$class_filter	= self::$filter;
		$class_database	= self::$dbc;
		$class_language = self::$class_language;
		$language	= self::$language;
		$usr_id		= (int) $_SESSION["USER_ID"];
		$page		= isset($_GET["p"]) ? (int) $_GET["p"] : 1;
		$lim		= 10;
		$page_lim	= $page > 1 ? sprintf("%s, %s", ($lim*($page-1)), $lim) : $lim;

		include_once $class_language->setLanguageFile('frontend', 'language.channel');

		$_q		= null;
		$fids 		= array();
		foreach ($ids as $id) {
		//self::$db_cache
			$s1		= sprintf("SELECT `subscriber_id` FROM `db_subscribers` WHERE `usr_id`='%s' AND `subscriber_id` != 'a:0:{}' LIMIT 1;", $id);
			$s2		= sprintf("SELECT `follower_id` FROM `db_followers` WHERE `usr_id`='%s' AND `follower_id` != 'a:0:{}' LIMIT 1;", $id);

			$qrs		= $cfg["user_subscriptions"] == 1 ? (self::$db_cache ? $db->CacheExecute($cfg['cache_user_files_subs_follows'], $s1) : $db->execute($s1)) : array();
			$frs		= $cfg["user_follows"] == 1 ? (self::$db_cache ? $db->CacheExecute($cfg['cache_user_files_subs_follows'], $s2) : $db->execute($s2)) : array();

			if ($qrs->fields["subscriber_id"] or $frs->fields["follower_id"]) {
				$a	= array();
				$subs	= $qrs->fields["subscriber_id"] ? unserialize($qrs->fields["subscriber_id"]) : array();
				$fsubs	= $frs->fields["follower_id"] ? unserialize($frs->fields["follower_id"]) : array();
				
				foreach ($subs as $sub) {
					$_q .= sprintf("(A.`usr_id`='%s'%s) OR ", $id, ($sub["sub_type"] == 'files' ? " AND A.`act_type` LIKE 'upload%'" : null));
					$fids[] = $id;
				}
				foreach ($fsubs as $sub) {
					if (!in_array($id, $fids))
						$_q .= sprintf("(A.`usr_id`='%s'%s) OR ", $id, ($sub["sub_type"] == 'files' ? " AND A.`act_type` LIKE 'upload%'" : null));
				}
			} else {
				$_q	.= sprintf("A.`usr_id`='%s' AND", $id);
			}
		}

		if (substr($_q, -3) == "OR ") {
			$_q	 = "(".substr($_q, 0, -3).")";
			$_q	.= " AND ";
		}

		$ex	= array();

		$sql		= sprintf("SELECT `act_id` FROM `db_notifications_hidden` WHERE `usr_id`='%s';", $usr_id);
		$res		= $db->execute($sql);

		if ($res->fields["act_id"]) {
			while (!$res->EOF) {
				$ex[]	= $res->fields["act_id"];
				$res->MoveNext();
			}
		}
		
		$sql		= sprintf("SELECT
						A.`act_id` AS `db_id`, A.`usr_id`, A.`act_type`, A.`act_time`,
						B.`usr_key`, B.`usr_user`,
						B.`usr_dname`, B.`ch_title`
						FROM
						`db_useractivity` A, `db_accountuser` B
						WHERE
						%s
						%s
						A.`usr_id`=B.`usr_id` AND
						A.`act_visible`='1' AND
						A.`act_deleted`='0'
						GROUP BY A.`act_id`
						ORDER BY A.`act_id` DESC LIMIT %s;", (($ex[0] != '' and !$show_hidden) ? "A.`act_id` NOT IN (".implode(",", $ex).") AND" : null), $_q, $page_lim);
		
		$rs		= $db->execute($sql);
		
		if ($rs->fields["db_id"]) {
			global $smarty;

			if ($cfg["comment_emoji"] == 1) {
				$html	.= '<script type="text/javascript">var tc = $(".user-activity-entry pre:not(.pcsd)").length;$(".user-activity-entry pre:not(.pcsd)").each(function(index,value){var t=$(this);var c=t.text();var nc=emojione.toImage(c);t.html(nc).addClass("pcsd");});</script>';
			}

			$html	.= $page == 1 ? '<div id="notifications-box-scroll">' : null;
			$html	.= $page == 1 ? '<div id="notifications-box-list">' : null;
			while (!$rs->EOF) {
				$act_id		= $rs->fields["db_id"];
				$user_id	= $rs->fields["usr_id"];
				$user_key	= $rs->fields["usr_key"];
				$user_uname	= $rs->fields["usr_user"];
				$user_dname	= $rs->fields["usr_dname"];
				$user_chtitle	= $rs->fields["ch_title"];
				$user_name	= $user_dname != '' ? $user_dname : ($user_chtitle != '' ? $user_chtitle : $user_uname);
				
				$act_type	= $rs->fields["act_type"];
				$act_time	= VUserinfo::timeRange($rs->fields["act_time"]);
				$action		= explode(":", $act_type);

				switch ($action[0]) {
					case "bulletin":
						$action_text	 = '<p>';
						$action_text	.= $user_name . ' '.$language["upage.act.".$action[0]];
						$action_text	.= '</p>';

						$action_text	.= '<p style="margin-top: 7px;">';
						$action_text	.= '<span class="black">'.$action[1].'</span>';
						$action_text	.= '</p>';
						
						$action_text	.= '<p>';
						$action_text	.= '<form class="entry-form-class"><label>'.$act_time.'</label></form>';
						$action_text	.= '</p>';
						break;

					case "upload":
					case "like":
					case "dislike":
					case "favorite":
						$i		 = $db->execute(sprintf("SELECT A.`file_title`, C.`usr_key` FROM `db_%sfiles` A, `db_accountuser` C WHERE A.`usr_id`=C.`usr_id` AND A.`file_key`='%s' LIMIT 1;", $action[1], $action[2]));
						$title		 = $i->fields["file_title"];
						$user_key	 = $i->fields["usr_key"];
						$url		 = $cfg["main_url"].'/'.VGenerate::fileHref($action[1][0], $action[2], $title);
						$action_thumb	 = VGenerate::thumbSigned($action[1], $action[2], $user_key, (3600 * 24), 0, 1);
						
						$action_text	 = '<p>';
						$action_text	.= $user_name . ' '.$language["upage.act.".$action[0]].' '.$language["frontend.global.".$action[1][0].".a"];
						$action_text	.= '<br><a href="'.$url.'">'.$title.'</a>';
						$action_text	.= '</p>';
						
						$action_text	.= '<p>';
						$action_text	.= '<form class="entry-form-class"><label>'.$act_time.'</label></form>';
						$action_text	.= '</p>';
						
						break;
					
					default:
						$_x		 = explode(" ", $action[0]);

						switch ($_x[0]) {
							case "comments":
								$action_text	 = null;
								if ($_x[2] == 'channel') {
									$i	 = $db->execute(sprintf("SELECT B.`c_body`, B.`c_replyto`, C.`usr_id`, C.`usr_user`, C.`usr_key`, C.`usr_dname`, C.`ch_title` FROM `db_%scomments` B, `db_accountuser` C WHERE B.`c_key`='%s' AND B.`c_usr_id`=C.`usr_id` LIMIT 1;", $_x[2], $action[2]));
									$title	 = $i->fields["ch_title"] != '' ? $i->fields["ch_title"] : ($i->fields["usr_dname"] != '' ? $i->fields["usr_dname"] : $i->fields["usr_user"]);
									$user_key= $i->fields["usr_key"];
									$url	 = $cfg["main_url"].'/'.VHref::getKey('channel').'/'.$user_key.'/'.$i->fields["usr_user"];
									$action_thumb	 = VUserAccount::getProfileImage($i->fields["usr_id"]);
								} else {
									$i	 = $db->execute(sprintf("SELECT A.`file_title`, B.`c_body`, B.`c_replyto`, C.`usr_key` FROM `db_%sfiles` A, `db_%scomments` B, `db_accountuser` C WHERE A.`file_key`=B.`file_key` AND A.`usr_id`=C.`usr_id` AND B.`c_key`='%s' LIMIT 1;", $_x[2], $_x[2], $action[2]));
									$title	 = $i->fields["file_title"];
									$user_key= $i->fields["usr_key"];
									$url	 = $cfg["main_url"].'/'.VGenerate::fileHref($_x[2][0], $action[1], $title);
									$action_thumb	 = VGenerate::thumbSigned($_x[2], $action[1], $user_key, (3600 * 24), 0, 1);
								}
								$comment	 = $i->fields["c_body"];

								$action_text	.= '<p>';
								$action_text	.= $user_name . ' '.($i->fields["c_replyto"] == '0' ? $language["upage.act.comment"] : $language["upage.act.reply"]);
								$action_text	.= ' <a href="'.$url.'">'.$title.'</a>';
								$action_text	.= '<br><br><pre><span class="black">'.$comment.'</span></pre>';
								$action_text	.= '</p>';

								$action_text	.= '<p>';
								$action_text	.= '<form class="entry-form-class"><label>'.$act_time.'</label></form>';
								$action_text	.= '</p>';

								break;

							case "subscribes":
							case "follows":
								$usr_id		 = $class_database->singleFieldValue('db_accountuser', 'usr_id', 'usr_user', ($_x[0] == 'subscribes' ? $_x[2] : $_x[1]));
								$action_text	 = null;
								$action_thumb	 = null;
								
								if ($usr_id > 0) {
									$_uinfo		 = VUserinfo::getUserInfo($usr_id);
									$_user_uname	 = $_uinfo["uname"];
									$_user_dname	 = $_uinfo["dname"];
									$_user_chtitle	 = $_uinfo["ch_title"];
									$_user_key	 = $_uinfo["key"];
									$_user_name	 = $_user_dname != '' ? $_user_dname : ($_user_chtitle != '' ? $_user_chtitle : $_user_uname);
									
									$title		 = $_user_name;
									$url		 = $cfg["main_url"].'/'.VHref::getKey("channel").'/'.$_user_key.'/'.$_user_uname;
									
									$action_text	.= '<p>';
									$action_text	.= $user_name . ' '.($_x[0] == 'subscribes' ? $language["upage.act.subscribe"] : $language["upage.act.follow"]);
									$action_text	.= ' <a href="'.$url.'">'.$title.'</a>';
									$action_text	.= '</p>';

									$action_text	.= '<p>';
									$action_text	.= '<form class="entry-form-class"><label>'.$act_time.'</label></form>';
									$action_text	.= '</p>';
								}
								break;
						}
						break;
				}
				
				
				
				$html	.= '
					<div class="user-sub-activity'.(in_array($act_id, $ex) ? ' is-hidden' : null).'" id="a'.$act_id.'">
						<div class="place-left user-activity-side-left">
							<div class="user-activity-entry">
								<div class="user-thumb-xlarge top">
									<a href="'.$cfg["main_url"].'/'.VHref::getKey("channel").'/'.$user_key.'/'.$user_uname.'">
										<img height="48" class="own-profile-image" title="'.$user_name.'" alt="'.$user_name.'" src="'.VUseraccount::getProfileImage($user_id).'">
									</a>
								</div>
							</div>
						</div>
						<div class="user-activity-entry user-activity-text">'.$action_text.'</div>
						<i class="icon-'.(in_array($act_id, $ex) ? 'undo2' : 'times').' '.(in_array($act_id, $ex) ? 'unhide' : 'hide').'-entry" rel-nr="'.$act_id.'" rel="tooltip" title="'.(in_array($act_id, $ex) ? $language["frontend.global.notification.restore"] : $language["frontend.global.notification.hide"]).'"></i>
						'.($action_thumb != '' ? '
						<div class="place-right user-activity-side-right">
							<div class="user-activity-entry">
								<a href="'.$url.'"><img src="'.$action_thumb.'" height="48" /></a>
							</div>
						</div>
						' : null).'
						<div class="clearfix"></div>
						<div class="line"></div>
					</div>
					';
				
				$rs->MoveNext();
			}
			$html	.= $page == 1 ? '</div>' : null;
			$html	.= $page == 1 ? '</div>' : null;
		}
		
		return $html;
	}
	/* hide notifications from list */
	public static function hideNotifications($unhide = false) {
		$usr_id	= (int) $_SESSION["USER_ID"];
		
		if (!$unhide and $_POST and $usr_id > 0) {
			$act_id	= (int) $_POST["i"];
			
			$ins	= array("act_id" => $act_id, "usr_id" => $usr_id);
			
			$res	= self::$dbc->doInsert("db_notifications_hidden", $ins);
			
			if ($res) {
				echo 1;
			} else {
				echo 0;
			}
		} elseif ($unhide and $_POST and $usr_id > 0) {
			$act_id	= (int) $_POST["i"];
			
			$sql	= sprintf("DELETE FROM `db_notifications_hidden` WHERE `act_id`='%s' AND `usr_id`='%s' LIMIT 1;", $act_id, $usr_id);
			
			$res	= self::$db->execute($sql);
			
			if (self::$db->Affected_Rows() > 0) {
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	/* get my subs/follows count */
        public static function getSubCount($follow_count = false) {
                global $class_database, $cfg;

                $user_id        = (int) $_SESSION["USER_ID"];
                $sub_cache      = self::$db_cache ? $cfg["cache_view_sub_id"] : false;

                if (!$follow_count and $cfg["user_subscriptions"] == 1) {
                        return $class_database->singleFieldValue('db_accountuser', 'usr_subcount', 'usr_id', $user_id, $sub_cache);
                } elseif ($follow_count and $cfg["user_follows"] == 1) {
                        return $class_database->singleFieldValue('db_accountuser', 'usr_followcount', 'usr_id', $user_id, $sub_cache);
                }
        }
}
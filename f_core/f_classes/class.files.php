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

class VFiles {
        private static $type;
        private static $cfg;
        private static $db;
        private static $db_cache;
        private static $dbc;
        private static $filter;
        private static $language;
        private static $href;
        private static $page;
        private static $page_end;
	private static $page_links;
	private static $section;
	private static $smarty;
	private static $subscription_section = false;
	private static $subscription_private = true;
	private static $subscription_type;
	private static $playlist_limit = 10;
        private static $viewMode1_limit = 12;
        private static $viewMode2_limit = 12;
        private static $viewMode3_limit = 6;
	
        public function __construct() {
		require 'f_core/config.href.php';

		global $cfg, $class_filter, $class_database, $db, $language, $smarty, $section, $href;

		self::$cfg	= $cfg;
		self::$db	= $db;
		self::$dbc	= $class_database;
		self::$filter	= $class_filter;
		self::$language = $language;
		self::$href	= $href;
		$_s		= isset($_GET["s"]) ? self::$filter->clr_str($_GET["s"]) : null;
		self::$section	= isset($_GET["pp"]) ? $href["playlists"] : $section;
		self::$page	= isset($_GET["page"]) ? (int) $_GET["page"] : 1;
		self::$page_end = false;
		self::$page_links = null;
		self::$smarty	= $smarty;
		
		$_type		= self::browseType();

		self::$type	= $_type == 'document' ? 'doc' : $_type;
		
		self::$db_cache = false; //change here to enable caching
        }
        /* browse type */
        public static function browseType() {
		if (isset($_GET["s"])) {
			$_s	= self::$filter->clr_str($_GET["s"]);
			
			if (strlen($_s) > 16 and substr($_s, 0, 16) == 'file-menu-entry6') {
				$_r	= str_replace('file-menu-entry6-sub', '', $_s);
				
				switch ($_r[0]) {
					case "l": return 'live';
					case "v": return 'video';
					case "i": return 'image';
					case "a": return 'audio';
					case "d": return 'doc';
					case "b": return 'blog';
				}
			}
		}
		
		$adr		= self::$filter->clr_str($_SERVER["REQUEST_URI"]);
		
		if (self::$section == self::$href["blogs"] or (self::$section == self::$href["search"] and (int) $_GET["tf"] == 7) or (self::$section == self::$href["channel"] and strpos($adr, self::$href["blogs"]) !== false)) {
			return 'blog';
		}
		
		return isset($_GET["t"]) ? self::$filter->clr_str($_GET["t"]) : (isset($_GET["l"]) ? 'live' : (isset($_GET["v"]) ? 'video' : (isset($_GET["i"]) ? 'image' : (isset($_GET["a"]) ? 'audio' : (isset($_GET["d"]) ? 'doc' : (isset($_GET['b']) ? 'blog' : 'video'))))));
        }
	
        /* browse redirect check */
        public static function browseInit() {
		$p_t	= self::browsetype();
		$type	= $p_t;
		$rd_to	= $type;

		if ($type == '') {
			$rd_to = (($type == '' and self::$cfg["live_module"] == 1) ? 'live' : 
			(($type == '' and self::$cfg["video_module"] == 1) ? 'video' : 
			(($type == '' and self::$cfg["image_module"] == 1) ? 'image' : 
			(($type == '' and self::$cfg["audio_module"] == 1 ? 'audio' : 
			(($type == '' and self::$cfg["document_module"] == 1 ? 'document' : NULL)))))));
		}

		$guest_for = ($p_t == '' ? $rd_to : $p_t);
		$guest_chk = $_SESSION["USER_ID"] == '' ? VHref::guestPermissions('guest_browse_' . ($guest_for == 'document' ? 'doc' : $guest_for), VHref::getKey("browse") . '?t=' . $guest_for) : NULL;

		if ($p_t === '' or ( $p_t != '' and self::$cfg[$p_t . "_module"] == 0)) {
			header("Location: " . self::$cfg["main_url"] . '/' . VHref::getKey("browse") . '?t=' . $rd_to);
		}
		
		return $rd_to;
	}

	/* browse files layout */

	public static function browseLayout() {
	global $section;
		$res_media	= self::getMedia();
		$res_watchlist	= self::watchlistEntries();

		$html .= self::typeFilters();
		$html .= '<div id="main-content" class="tabs tabs-style-topline">';
		$html .= self::tabs(self::$type);
		$html .= self::$cfg["video_module"] == 1 ? self::listMedia($res_media, $res_watchlist) : null;
		$html .= self::$cfg["live_module"] == 1 ? self::listMedia(array(), array(), 'live', $hidden = true) : null;
		$html .= self::$cfg["image_module"] == 1 ? self::listMedia(array(), array(), 'image', $hidden = true) : null;
		$html .= self::$cfg["audio_module"] == 1 ? self::listMedia(array(), array(), 'audio', $hidden = true) : null;
		$html .= self::$cfg["document_module"] == 1 ? self::listMedia(array(), array(), 'doc', $hidden = true) : null;
		$html .= self::$cfg["blog_module"] == 1 ? self::listMedia(array(), array(), 'blog', $hidden = true) : null;
		$html .= '</div>';

		$html .= '<script type="text/javascript"> $(document).ready(function() { var hash = window.location.hash; if (typeof hash !== "undefined" && hash.length > 1) { var f = "video"; var t = hash.replace("#", ""); if (t !== "l" && t !== "v" && t !== "i" && t !== "a" && t !== "d" && t !== "b") return; switch (t) { case "l": f = "live"; break; case "v": f = "video"; break; case "i": f = "image"; break; case "a": f = "audio"; break; case "d": f = "doc"; break; case "b": f = "blog"; break; default: f = "video"; break; } setTimeout(function(){ $("#view-mode-"+f).trigger("click"); }, 250); } }); </script> ';
/*
		$html .= empty($_GET) ? '<script type="text/javascript">
			jQuery(document).on({
                                  click: function(event) {
                                        event.preventDefault();
                                        event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);
                                        var _t = $(this);
                                        var t=_t.parent();
                                        var f=0;
                                        var h=_t.find("a").attr("href").replace("#section-", "");
                                        var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");

                                        //t.find("li").each(function(){
                                        $("#"+vm+"-content .content-current .mp-sort-by li").each(function(){
                                                var tt=$(this);
                                                if(tt.hasClass("iss")) {
                                                        f+=1;
                                                }
                                        });
                                        if (f == 0) {
                                                t.addClass("issm");
                                                $("body").addClass("hissm");
                                                t.find("li").addClass("iss").stop().slideDown("fast");
                                        } else {
                                                t.find("li").removeClass("iss").stop().slideUp("fast");
                                                t.removeClass("issm");
                                                $("body").removeClass("hissm");
                                                $(".loadmask, .loadmask-msg").detach();
     
                                                t.find("li:first-of-type").stop().slideDown(10, function(){
                                                        var tc=$("#main-content li.tab-current a").attr("href").replace("#section-", "");
                                                        if (h !== tc) {
                                                        	$("#"+vm+"-content section").removeClass("content-current");
                                                        	$("#section-"+h).addClass("content-current");

                                                                $("#main-content.tabs>nav").find("a[href=#section-"+h+"]").parent().click();
                                                        }
                                                });
                                                $("#"+vm+"-content .mp-sort-by").each(function(){
                                                        var t=$(this);
                                                        t.prepend(t.find("a[href=#section-"+h+"]").parent());
                                                });
                                        }
                                }}, ".content-current .mp-sort-by li");

                                jQuery(document).on({
                                  click: function(event) {
                                        var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");
                                        //var t = $(".content-current .mp-sort-by");
                                        var t = $("#"+vm+"-content .content-current .mp-sort-by");

                                        t.find("li").removeClass("iss").stop().slideUp("fast");
                                        t.removeClass("issm");
                                        $("body").removeClass("hissm");
                                        t.find("li:first-of-type").stop().slideDown(10);
                                }}, "body.hissm");

                         </script>
' : null;
*/
		return $html;
	}

	/* file key checking */
	function fileKeyCheck($type, $key, $return = '') {
		$sql	= sprintf("SELECT `usr_id`, `privacy`, `approved` FROM `db_%sfiles` WHERE `file_key`='%s' AND `active`='1' AND `deleted`='0' LIMIT 1;", $type, $key);
		$f_rs	= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_key_check'], $sql) : self::$db->execute($sql);
		$f_uid	= $f_rs->fields["usr_id"];
		$f_pr	= $f_rs->fields["privacy"];
		$f_app	= $f_rs->fields["approved"];
		$uid	= (int) $_SESSION["USER_ID"];

		if ($f_app == 1 or ($f_app == 0 and $f_uid == $uid)) {
			if ($f_pr == 'public' or ( $f_pr == 'private' and $f_uid == $uid) or ( $f_pr == 'personal' and $f_uid == $uid)) {
				if ($return == 1) {
					return 1;
				}
				
				$q .= "(A.`file_key` = '" . $key . "' AND A.`privacy`='public' AND A.`approved`='1') OR ";
			} elseif ($f_pr == 'private' and $f_uid != $uid) {
				$bl_stat	= VContacts::getBlockStatus($f_uid, $_SESSION["USER_NAME"]);
				$bl_opt		= VContacts::getBlockCfg('bl_files', $f_uid, $_SESSION["USER_NAME"]);
				$f_is		= VContacts::getFriendStatus($f_uid);

				if ($f_is == 1 and ( $bl_stat == 0 or ( $bl_stat == 1 and $bl_opt == 0))) {
					if ($return == 1) {
						return 1;
					}
					$q .= "(A.`file_key` = '" . $key . "' AND A.`privacy`!='personal') OR ";
				}
			}
		} else {
			$q = '';
			
			if ($return == 1) {
				return 0;
			}
		}

		return $q;
	}

	/* get database entries for main entries */
        private static function getMedia($viewMode_id = null) {
		$type		= self::$type;
		$sort		= self::$filter->clr_str($_GET["sort"]);
		$categ_query1	= null;
		$categ_query2	= null;
		$categ_query3	= null;
		$ct_slug	= null;
		$q		= null;

		if (isset($_GET["c"])) {
			$ct_slug = self::$filter->clr_str($_GET["c"]);
			$categ_query1 = ', E.`ct_name`';
			$categ_query2 = ', `db_categories` E';
			$categ_query3 = "AND (E.`ct_slug`='" . $ct_slug . "' AND A.`file_category`=E.`ct_id`)";
		}

		$ct_today = $ct_slug === 'today' ? 1 : 0;
		$get_type = self::typeFromPlaylist();

		if ($ct_today == 1) {
			$q = sprintf(" AND A.`last_viewdate`='%s' ", date('Y-m-d'));
		}

		$_s		= isset($_GET["s"]) ? substr($_GET["s"], 0, 16) : VHref::currentSection();

		if ($viewMode_id == '' and isset($_SESSION[$type."_vm"]))
			$viewMode_id = (int) $_SESSION[$type."_vm"];

		switch ($viewMode_id) {
			default:
			case "1":
				$des = null;
				$lim = self::$viewMode1_limit;
				break;
			case "2":
				$des = 'SUBSTRING(A.`file_description`, 1, 40) as `file_description`, ';
				$lim = self::$viewMode3_limit;
				break;
		}

		switch ($_s) {
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
				$pg_cfg		= (substr($_REQUEST["s"], 0, 4) == 'subs' or substr($_REQUEST["s"], 0, 4) == 'osub' or substr($_REQUEST["s"], 0, 4) == 'fsub') ? 'page_user_subscriptions_list' : 'page_user_files_uploads';
				break;
		}
		
		switch ($_s) {
			case "file-menu-entry1":
			default:
				$uid		= (int) $_SESSION["USER_ID"];
				$uri		= self::$filter->clr_str($_SERVER["REQUEST_URI"]);
				$a		= explode("/", $uri);
				$t		= count($a);

				if (substr($_s, 0, 4) == 'subs' or substr($_s, 0, 4) == 'osub' or substr($_s, 0, 4) == 'fsub' or $a[$t-2] == self::$href["subscriptions"] or $a[$t-2] == self::$href["following"]) {
					$_ss	= self::$filter->clr_str($_GET["s"]);
					$uid	= ($a[$t-2] == self::$href["subscriptions"] or $a[$t-2] == self::$href["following"]) ? self::$dbc->singleFieldValue('db_accountuser', 'usr_id', 'usr_key', self::$filter->clr_str($a[$t-1]), (self::$db_cache ? self::$cfg['cache_key_check'] : false)) : (substr($_s, 0, 4) == 'subs' ? str_replace('subs-menu-entry', '', $_ss) : (substr($_s, 0, 4) == 'fsub' ? str_replace('fsub-menu-entry', '', $_ss) : str_replace('osub-menu-entry', '', $_ss)));

					self::$subscription_section	= true;
					self::$subscription_type	= $a[$t-2] == self::$href["subscriptions"] ? 'subs' : ($a[$t-2] == self::$href["following"] ? 'fsub' : substr($_s, 0, 4));

					$bl_stat	= VContacts::getBlockStatus($uid, $_SESSION["USER_NAME"]);
					$bl_opt		= VContacts::getBlockCfg('bl_files', $uid, $_SESSION["USER_NAME"]);
					$f_is		= VContacts::getFriendStatus($uid);

					if ($f_is == 1 and ($bl_stat == 0 or ($bl_stat == 1 and $bl_opt == 0))) {
						self::$subscription_private = true;
					} else {
						self::$subscription_private = false;
					}
					
					$pg_cfg		= 'page_user_subscriptions_list';
				}
				
				$q		.= sprintf(" AND A.`usr_id`='%s' ", $uid);
				
				break;
			case "file-menu-entry2":
			case "file-menu-entry3":
			case "file-menu-entry4":
			case "file-menu-entry5":
			case "file-menu-entry6":
				if (strlen($get_type[0]) > 2){
					$db_field	= $get_type[1];
					$db_tbl		= $get_type[2];
					$pl_q		= $get_type[4];
				}

				if (isset($_GET["pp"]) and (int) $_GET["pp"] == 1) {
					$sql	= sprintf("SELECT `%s` FROM `db_%s%s` WHERE `usr_id` > 0 %s LIMIT 1;", $db_field, self::$type, $db_tbl, $pl_q);
				} else {
					$sql	= sprintf("SELECT `%s` FROM `db_%s%s` WHERE `usr_id`='%s' %s LIMIT 1;", $db_field, self::$type, $db_tbl, self::getUserID(), $pl_q);
				}
				
				$f_sql	= self::$db_cache ? self::$db->CacheExecute(self::$cfg[$cache_cfg], $sql) : self::$db->execute($sql);
				$f_list = $f_sql->fields[$db_field];

				if ($f_list != '') {
					$qq	= null;
					$for	= explode("-", $_GET["s"]);
					$f_arr	= unserialize($f_list);

					for ($i = 0; $i < count($f_arr); $i++) {
						$ck  = is_array($f_arr[$i]) ? $f_arr[$i][0] : $f_arr[$i];
						$qq .= self::fileKeyCheck($type, $ck);
					}
					$q .= $qq != '' ? " AND (" . substr($qq, 0, -3) . ")" : NULL;
					$pg_cfg = $for[2] == 'entry6' ? 'page_user_files_playlists' : $pg_cfg;
				} else {
					$q .= " AND A.`file_key`='0' ";
				}
				
				break;
		}

		$sql_1		= null;
		$sql_2		= null;
		$search_order	= false;
		
		if (isset($_GET["sq"]) and strlen($_GET["sq"]) >= 4){
			$squery = trim($_GET["sq"]);
			$rel	= str_replace(
					array('_', '-', ' ', '.', ',', '(', ')', '!', '@', '#', '$', '%', '^', '&', '*', ':', ';', "'", '"', '[', ']', '{', '}', '?', '|', '●'),
					array('%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%', '%'), $squery);

//					array('+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+'), $squery);
/*
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= rtrim($rel, '+');
*/
			$rel	= str_replace('%%', '%', $rel);
			$rel	= str_replace('%%', '%', $rel);
			$rel	= str_replace('%%', '%', $rel);
			$rel	= str_replace('%%', '%', $rel);
			$rel	= rtrim($rel, '%');
			$rel	= self::$filter->clr_str($rel);

			$sql_1	= ", MATCH(`file_title`, `file_tags`) AGAINST ('".$rel."') AS `Relevance` ";
			$sql_2	= "MATCH(`file_title`,`file_tags`) AGAINST('".$rel."' IN BOOLEAN MODE) AND ";

			$search_order = true;
		}

		switch ($sort) {
			case "public":
			case "plpublic":
			case "":
				$by = $search_order ? "`Relevance` DESC" : "A.`db_id` DESC";
				$qd = "AND A.`privacy`='public' ORDER BY " . $by;
				
				$q .= $_s == 'file-menu-entry6' ? (is_array($f_arr) ? sprintf("AND A.`privacy`='public' ORDER BY FIND_IN_SET(A.`file_key`, '%s')", implode(',', $f_arr)) : $qd) : $qd;
				break;

			case "private":
				$by = $search_order ? "`Relevance` DESC" : "A.`file_title` ASC";
				
				$q .= "AND A.`privacy`='private' ORDER BY " . $by;
				break;

			case "personal":
				$by = $search_order ? "`Relevance` DESC" : "A.`file_title` ASC";
				
				$q .= "AND A.`privacy`='personal' ORDER BY " . $by;
				break;

			case "recent":
				$q .= "ORDER BY A.`db_id` DESC";
				break;

			case "featured":
				$by = $search_order ? "`Relevance` DESC" : "A.`file_title` ASC";
				
				$q .= "AND A.`is_featured`='1' ORDER BY " . $by;
				break;

			case "promoted":
				$by = $search_order ? "`Relevance` DESC" : "A.`file_title` ASC";
				
				$q .= "AND A.`is_promoted`='1' ORDER BY " . $by;
				break;

			case "views":
//			case "plviews":
				$q .= "AND A.`file_views` > '0' ORDER BY A.`file_views` DESC";
				break;

			case "likes":
				$q .= "AND A.`file_like` > '0' ORDER BY A.`file_like` DESC";
				break;

			case "comments":
				$q .= "AND A.`file_comments` > '0' ORDER BY A.`file_comments` DESC";
				break;

			case "favorites":
				$q .= "AND A.`file_favorite` > '0' ORDER BY A.`file_favorite` DESC";
				break;

			case "responses":
				$q .= "AND A.`file_responses` > '0' ORDER BY A.`file_responses` DESC";
				break;
		}


		$total_sql	= sprintf("SELECT COUNT(*) AS `total`,
				    A.`file_key`,
				    D.`usr_id`
				    %s
				    %s
				    FROM 
				    `db_%sfiles` A, `db_accountuser` D %s
				    WHERE 
				    %s
				    A.`approved`='1' AND 
				    A.`deleted`='0' AND 
				    A.`active`='1' AND 
				    A.`usr_id`=D.`usr_id` 
				    %s %s", $categ_query1, $sql_1, $type, $categ_query2, $sql_2, $categ_query3, $q);

		$total_res	= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_main'], $total_sql) : self::$db->execute($total_sql);
		$total		= $total_res->fields["total"];
		
		$pages                  = new VPagination;
		$pages->items_total     = $total;
		$pages->mid_range       = 10;
		$pages->items_per_page  = isset($_GET["ipp"]) ? (int) $_GET["ipp"] : $lim;
		$pages->paginate();
		
		if (isset($_GET["pp"]) and (int) $_GET["pp"] == 1) {
			$pages->limit = null;
		}

		$sql		= sprintf("SELECT 
				    A.`file_key`, A.`file_views`, A.`file_duration`, A.`file_like`, A.`file_comments`, A.`thumb_server`, A.`upload_date`, A.`stream_live`,
				    A.`file_title`, A.`file_name`, A.`thumb_preview`, %s 
				    D.`usr_dname`, 
				    D.`usr_id`, D.`usr_key`, D.`usr_user`, D.`usr_partner`, D.`usr_affiliate`, D.`affiliate_badge`, D.`ch_title` %s
				    %s
				    FROM 
				    `db_%sfiles` A, `db_accountuser` D %s
				    WHERE 
				    %s
				    A.`deleted`='0' AND 
				    A.`active`='1' AND 
				    A.`usr_id`=D.`usr_id`
				    %s %s %s", $des, $categ_query1, $sql_1, $type, $categ_query2, $sql_2, $categ_query3, $q, $pages->limit);

		$res		= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_main'], $sql) : self::$db->execute($sql);
		
		if (!isset($_GET["pp"])) {
			$page_of        = (($pages->high+1) > $total) ? $total : ($pages->high+1);
			$results_text	= $pages->getResultsInfo($page_of, $total, 'left');
			$paging_links   = $pages->getPaging($total, 'right');

			self::$page_links = $paging_links != '' ? '<div id="paging-bottom" class="left-float wdmax paging-top-border paging-bg">'.$paging_links.$results_text.'</div>' : null;
		}
		

		return $res;
	}

	/* get user session id */
	private static function getUserID() {
		return (int) $_SESSION["USER_ID"];
	}
        /* get watchlist entries for logged in user */
        private static function watchlistEntries() {
		$uid = (int) $_SESSION["USER_ID"];

		if (self::$cfg["file_watchlist"] == 1 and $uid > 0) {
			$sql = sprintf("SELECT `watch_list` FROM `db_%swatchlist` WHERE `usr_id`='%s' LIMIT 1", self::$type, $uid);

			$res = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_main'], $sql) : self::$db->execute($sql);

			if ($res->fields["watch_list"]) {
				return array_values(unserialize($res->fields["watch_list"]));
			}
		}
	}

	/* file type filters */
        private static function typeFilters() {
		$mm_entry	 = VHref::currentSection();

		$text		 = self::$cfg["live_module"] == 1 ? '<span class="section-h3" id="live-h3"><i class="icon-live"></i>' . self::typeLangReplace(self::$language["files.menu.l.up"]) . '</span>' : null;
		$text		.= self::$cfg["video_module"] == 1 ? '<span class="section-h3" id="video-h3"><i class="icon-video"></i>' . self::typeLangReplace(self::$language["files.menu.v.up"]) . '</span>' : null;
		$text		.= self::$cfg["image_module"] == 1 ? '<span class="section-h3" id="image-h3" style="display: none;"><i class="icon-image"></i>' . self::typeLangReplace(self::$language["files.menu.i.up"]) . '</span>' : null;
		$text		.= self::$cfg["audio_module"] == 1 ? '<span class="section-h3" id="audio-h3" style="display: none;"><i class="icon-audio"></i>' . self::typeLangReplace(self::$language["files.menu.a.up"]) . '</span>' : null;
		$text		.= self::$cfg["document_module"] == 1 ? '<span class="section-h3" id="doc-h3" style="display: none;"><i class="icon-file"></i>' . self::typeLangReplace(self::$language["files.menu.d.up"]) . '</span>' : null;
		$text		.= self::$cfg["blog_module"] == 1 ? '<span class="section-h3" id="blog-h3" style="display: none;"><i class="icon-pencil2"></i>' . self::typeLangReplace(self::$language["files.menu.b.up"]) . '</span>' : null;
		
		switch ($mm_entry) {
			case "":
			case "file-menu-entry1":
				$ct_class 	= 'ct-upload';
				$text 		= '<i class="icon-upload"></i>'.self::$language['files.menu.myfiles.type'];
				break;
			
			case "file-menu-entry2":
				$ct_class 	= 'ct-favorite';
				$text 		= '<i class="icon-heart"></i>'.self::$language['files.menu.myfav.type'];
				break;
			
			case "file-menu-entry3":
				$ct_class 	= 'ct-like';
				$text = '<i class="icon-thumbs-up"></i>'.self::$language['files.menu.liked.type'];
				break;
			
			case "file-menu-entry4":
				$ct_class 	= 'ct-history';
				$text = '<i class="icon-history"></i>'.self::$language['files.menu.history.type'];
				break;
			
			case "file-menu-entry5":
				$ct_class 	= 'ct-watchlist';
				$text = '<i class="icon-clock"></i>'.self::$language['files.menu.watch.type'];
				break;
				
			case "file-menu-entry7":
				$ct_class 	= 'ct-comment';
				break;
				
			case "file-menu-entry8":
				$ct_class 	= 'ct-response';
				break;
			
			default:
				$ct_class 	= self::$subscription_section ? 'ct-subscription' : 'ct-playlist';
				break;
		}
		
		$hide_sort	= false;
		$_s		= VHref::currentSection();
		
		if (self::$subscription_section) {
			if (substr($_s, 0, 4) == 'subs' or substr($_s, 0, 4) == 'osub' or substr($_s, 0, 4) == 'fsub') {
				$_ss		= $_s;
				$usr_id		= substr($_s, 0, 4) == 'subs' ? str_replace('subs-menu-entry', '', $_ss) : (substr($_s, 0, 4) == 'fsub' ? str_replace('fsub-menu-entry', '', $_ss) : str_replace('osub-menu-entry', '', $_ss));
				$usr_key	= self::$dbc->singleFieldValue('db_accountuser', 'usr_key', 'usr_id', $usr_id, (self::$db_cache ? self::$cfg['cache_key_check'] : false));
			} 
			$uinfo		= VUserinfo::getUserInfo($usr_id);
			$user		= $uinfo["dname"] != '' ? $uinfo["dname"] : ($uinfo["ch_title"] != '' ? $uinfo["ch_title"] : $uinfo["uname"]);
			$ch_url		= self::$cfg["main_url"] . '/' . VHref::getKey("channel") . '/' . $usr_key . '/' . $uinfo["uname"];
			$text		= '<a href="'.$ch_url.'"><img alt="'.$user.'" title="'.$user.'" src="'.VUseraccount::getProfileImage($usr_id).'" height="32"></a><span class="heading"><a href="'.$ch_url.'">'.$user.'</a></span>';
			$ct_class	= 'ct-subscription';
		}
		if (isset($_GET["s"])) {
			$pl_back= null;
			$_s	= self::$filter->clr_str($_GET["s"]);

			if (strlen($_s) > 16 and substr($_s, 0, 16) == 'file-menu-entry6') {
				$_r	= str_replace('file-menu-entry6-sub', '', $_s);
				
				switch ($_r[0]) {
					case "l":
					case "v":
					case "i":
					case "a":
					case "d":
					case "b":
						$hide_sort	 = true;
						$pl_back	 = self::$section == self::$href["playlists"] ? '<div class="edit-back"><a href="javascript:;" onclick="if(typeof($(\'.filter-link\').html()) !== \'undefined\'){location.href=window.location.href}else{location.href=\''.self::$cfg["main_url"].'/'.VHref::getKey('files').'/'.VHref::getKey('playlists').'\'}" rel="nofollow"><i class="icon-arrow-left3" rel="tooltip" title="'.self::$language["files.text.pl.back"].'"></i></a></div>' : null;
						$text		 = '	
									<i class="icon-list"></i>
									<span id="playlist-title">'.self::$language['files.menu.mypl2'] .' <i class="iconBe-chevron-right"></i> <span class="pt">'. self::$dbc->singleFieldValue('db_'.self::$type.'playlists', 'pl_name', 'pl_id', str_replace($_r[0], '', $_r)).'</span></span>
								';
						
						$cfg_pl		 = !isset($_GET["pp"]) ? '	
										<button class="viewType_btn viewType_btn-default plcfg-popup" value="new" id="cfg-playlist" type="button" rel="tooltip" title="'.self::$language["playlist.menu.pl.setup"].'">
											<span><i class="icon-cog" style="margin: 0px 5px;"></i>'.self::$language["playlist.menu.pl.setup"].'</span>
										</button>
								' : null;
				}
			}
			
			if ($_s == 'file-menu-entry7' and self::$cfg['file_comments'] == 1) {
				$menu_li	 = '<li class="count file-action" id="cb-enable"><a href="javascript:;">'.self::$language["contacts.invites.approve"].'</a></li>';
				$menu_li	.= '<li class="count file-action" id="cb-disable"><a href="javascript:;">'.self::$language["contacts.comments.approve"].'</a></li>';
				$menu_li	.= '<li class="count file-action" id="cb-commdel"><a href="javascript:;">'.self::$language["frontend.global.delete.sel"].'</a></li>';
			}
			if ($_s == 'file-menu-entry8' and self::$cfg['file_responses'] == 1) {
				$menu_li	 = '<li class="count file-action" id="cb-renable"><a href="javascript:;">'.self::$language["contacts.invites.approve"].'</a></li>';
				$menu_li	.= '<li class="count file-action" id="cb-rdisable"><a href="javascript:;">'.self::$language["contacts.comments.approve"].'</a></li>';
				$menu_li	.= '<li class="count file-action" id="cb-rcommdel"><a href="javascript:;">'.self::$language["frontend.global.delete.sel"].'</a></li>';
			}
		}

		$html = '
                                    <div id="view-type-content" class="'.$ct_class.'">
                                        <article>
					    '.$pl_back.'
					    '.(isset($_GET["ch"]) ? '<div class="line"></div>' : null).'
					    
                                            <h3 class="content-title no-display1 htf">
                                            	' . $text . '
                                            	<div class="pull-right" rel="tooltip" title="Show/hide all filters"><i class="toggle-all-filters icon icon-eye2" onclick="$(\'section.inner-search, section.filter.tft, section.action\').toggle()"></i></div>
                                            </h3>
						<section class="inner-search">
						'.(!isset($_GET["pp"]) ? '<div>'.self::$smarty->fetch('tpl_frontend/tpl_file/tpl_search_inner.tpl').'</div>' : null).'
						</section>
						<div class="clearfix"></div>
						<div class="line nlb top"></div>
                                            <section class="filter tft" style="float:left">
                                                <div class="promo loadmask-img pull-left"></div>
                                                <div class="btn-group viewType pull-right'.($hide_sort ? ' hidden' : null).'">
                                                    ' . ((self::$cfg["video_module"] == 1) ? '<button rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.v.p.c"], self::$language["files.menu.show.type"]).'" type="button" id="view-mode-video" class="viewType_btn viewType_btn-default view-mode-type video'.((self::$type == 'video' or self::$type == '') ? ' active' : null).'"><span><i class="icon-video"></i><span class="hst">'.self::$language["frontend.global.v.p.c"].'</span></span></button>' : null) . '
                                                    ' . ((self::$cfg["live_module"] == 1) ? '<button rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.l.p.c"], self::$language["files.menu.show.type"]).'" type="button" id="view-mode-live" class="viewType_btn viewType_btn-default view-mode-type live'.(self::$type == 'live' ? ' active' : null).'"><span><i class="icon-live"></i><span class="hst">'.self::$language["frontend.global.l.p.c"].'</span></span></button>' : null) . '
                                                    ' . ((self::$cfg["image_module"] == 1) ? '<button rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.i.p.c"], self::$language["files.menu.show.type"]).'" type="button" id="view-mode-image" class="viewType_btn viewType_btn-default view-mode-type image'.(self::$type == 'image' ? ' active' : null).'"><span><i class="icon-image"></i><span class="hst">'.self::$language["frontend.global.i.p.c"].'</span></span></button>' : null) . '
                                                    ' . ((self::$cfg["audio_module"] == 1) ? '<button rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.a.p.c"], self::$language["files.menu.show.type"]).'" type="button" id="view-mode-audio" class="viewType_btn viewType_btn-default view-mode-type audio'.(self::$type == 'audio' ? ' active' : null).'"><span><i class="icon-audio"></i><span class="hst">'.self::$language["frontend.global.a.p.c"].'</span></span></button>' : null) . '
                                                    ' . ((self::$cfg["document_module"] == 1) ? '<button type="button" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.d.p.c"], self::$language["files.menu.show.type"]).'" id="view-mode-doc" class="viewType_btn viewType_btn-default view-mode-type doc'.(self::$type == 'doc' ? ' active' : null).'"><span><i class="icon-file"></i><span class="hst">'.self::$language["frontend.global.d.p.c"].'</span></span></button>' : null) . '
						    ' . ((self::$cfg["blog_module"] == 1) ? '<button type="button" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.b.p.c"], self::$language["files.menu.show.type"]).'" id="view-mode-blog" class="viewType_btn viewType_btn-default view-mode-type blog'.(self::$type == 'blog' ? ' active' : null).'"><span><i class="icon-pencil2"></i><span class="hst">'.self::$language["frontend.global.b.p.c"].'</span></span></button>' : null) . '
                                                </div>
                                                '.($hide_sort ? '
                                                <div class="btn-group viewType pull-right" style="margin-bottom:0">
                                                	<button style="max-width:70px" type="button" rel="tooltip" title="" id="view-mode-blog" class="viewType_btn viewType_btn-default view-mode-type-pl" onclick="if(typeof($(\'.filter-link\').html()) !== \'undefined\'){location.href=window.location.href}else{location.href=\''.self::$cfg["main_url"].'/'.VHref::getKey('files').'/'.VHref::getKey('playlists').'\'}"><span><i class="icon-arrow-left3"></i>'.self::$language["files.text.pl.back"].'</span></button>
                                                </div>
                                                ' : null).'
                                            </section>
					    '.(!isset($_GET["pp"]) ? '
					    <section class="action">
						<div class="menu-drop">
							<div class="btn-group viewType pull-right">
								'.(($_s == '' or $_s == 'file-menu-entry1') ? '
								    <button class="viewType_btn viewType_btn-default up-popup" value="new" id="new-upload" type="button" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.".self::$type[0].".c"], self::$language["files.menu.add.new"]).'"><span><i class="icon-plus"></i>'.str_replace('##TYPE##', self::$language["frontend.global.".self::$type[0].".c"], self::$language["files.menu.add.new"]).'</span></button>
								' : null).'
								' . $cfg_pl . '
								'.(self::$subscription_section ? '
								<button id="subs-popup" class="viewType_btn viewType_btn-default subs-popup" value="new" type="button" onclick="$(\'#inline\').trigger(\'click\');" rel="tooltip" title="'.($_s[0] == 's' ? self::$language["files.text.subs.opt.1"] : self::$language["files.text.subs.opt.1f"]).'">
										<span><i class="icon-cog"></i>'.($_s[0] == 's' ? self::$language["files.text.subs.opt.1"] : self::$language["files.text.subs.opt.1f"]).'</span>
								</button>
								<a href="#subs-data" id="inline" class="hidden" rel="nofollow"></a>
								<div style="display: none;">
									<div id="subs-data">'.self::subsConfig().'</div>
								</div>
								' : null).'
								<button type="button" id="edit-mode" class="viewType_btn viewType_btn-default active" rel="tooltip" title="'.self::$language["files.text.act.edit"].'" onclick="$(this).toggleClass(\'active\'); $(\'#\'+$(\'.content-current .main-view-mode-\'+$(\'.view-mode-type.active\').attr(\'id\').replace(\'view-mode-\', \'\')+\'.active\').attr(\'id\')+\'-list .thumbs-wrappers\').stop().slideToggle();"><span><i class="icon-pencil"></i>'.self::$language["files.text.act.edit"].'</span></button>
								<button type="button" id="select-mode" class="viewType_btn viewType_btn-default" rel="tooltip" title="'.self::$language["files.text.act.all"].'" onclick="if ($(this).hasClass(\'active\')) { $(this).removeClass(\'active\'); $(\'#\'+$(\'.content-current .main-view-mode-\'+$(\'.view-mode-type.active\').attr(\'id\').replace(\'view-mode-\', \'\')+\'.active\').attr(\'id\')+\'-list .thumbs-wrappers .list-check\').prop(\'checked\', false); $(\'#\'+$(\'.content-current .main-view-mode-\'+$(\'.view-mode-type.active\').attr(\'id\').replace(\'view-mode-\', \'\')+\'.active\').attr(\'id\')+\'-list .thumb-selected\').removeClass(\'thumb-selected\'); } else { $(this).addClass(\'active\'); $(\'#\'+$(\'.content-current .main-view-mode-\'+$(\'.view-mode-type.active\').attr(\'id\').replace(\'view-mode-\', \'\')+\'.active\').attr(\'id\')+\'-list .thumbs-wrappers .list-check\').prop(\'checked\', true); $(\'#\'+$(\'.content-current .main-view-mode-\'+$(\'.view-mode-type.active\').attr(\'id\').replace(\'view-mode-\', \'\')+\'.active\').attr(\'id\')+\'-list .thumbs-wrapper\').addClass(\'thumb-selected\'); }"><span><i class="icon-checkbox-checked"></i>'.self::$language["files.text.act.all"].'</span></button>
								<div id="entry-action-buttons" class="dl-menuwrapper" rel="tooltip" title="'.self::$language["files.text.act.sel"].'"'.($hide_sort ? ' style="margin-right: 0px;"' : null).'>
									<span class="dl-trigger actions-trigger nbfr"><i class="icon-menu"></i> Selection Actions</span>
									<ul class="dl-menu">
										' . ((!isset($_GET["pp"]) and self::$cfg["file_privacy"] == 1 and ($mm_entry == '' or $mm_entry == 'file-menu-entry1')) ? '<li class="count file-action" id="cb-public"><a href="javascript:;"><i class="icon-home"></i> ' . self::$language["files.action.public"] . '</a></li>' : null) . '
										' . ((self::$cfg["file_privacy"] == 1 and ($mm_entry == '' or $mm_entry == 'file-menu-entry1')) ? '<li class="count file-action" id="cb-private"><a href="javascript:;"><i class="icon-key"></i> ' . self::$language["files.action.private"] . '</a></li>' : null) . '
										' . ((!isset($_GET["pp"]) and self::$cfg["file_privacy"] == 1 and ($mm_entry == '' or $mm_entry == 'file-menu-entry1')) ? '<li class="count file-action" id="cb-personal"><a href="javascript:;"><i class="icon-lock"></i> ' . self::$language["files.action.personal"] . '</a></li>' : null) . '
										' . ((self::$cfg["file_favorites"] == 1 and ($mm_entry != 'file-menu-entry2' or !isset($_GET["s"]))) ? '<li class="count file-action" id="cb-favadd"><a href="javascript:;"><i class="icon-heart"></i> ' . self::$language["files.action.fav.add"] . ' [<i class="iconBe-plus f10"></i>]</a></li>' : null) . '
										' . (self::$cfg["file_favorites"] == 1 ? '<li class="count file-action" id="cb-favclear"><a href="javascript:;"><i class="icon-heart"></i> ' . self::$language["files.action.fav.clear"] . ' [<i class="iconBe-minus f10"></i>]</a></li>' : null) . '
										' . ((self::$cfg["file_rating"] == 1 and $mm_entry == "file-menu-entry3") ? '<li class="count file-action" id="cb-likeclear"><a href="javascript:;"><i class="icon-thumbs-up"></i> ' . self::$language["files.action.liked.clear"] . ' [<i class="iconBe-minus f10"></i>]</a></li>' : null) . '
										' . ((self::$cfg["file_history"] == 1 and $mm_entry == "file-menu-entry4") ? '<li class="count file-action" id="cb-histclear"><a href="javascript:;"><i class="icon-history"></i> ' . self::$language["files.action.hist.clear"] . ' [<i class="iconBe-minus f10"></i>]</a></li>' : null) . '
										' . ((self::$cfg["file_watchlist"] == 1 and $mm_entry == "file-menu-entry5") ? '<li class="count file-action" id="cb-watchclear"><a href="javascript:;"><i class="icon-clock"></i> ' . self::$language["files.action.watch.clear"] . ' [<i class="iconBe-minus f10"></i>]</a></li>' : null) . '
										' . ((self::$cfg["file_playlists"] == 1 and self::$cfg["live_module"] == 1) ? VMessages::addToLabel('tpl_pl', 'live') : null) . '
										' . ((self::$cfg["file_playlists"] == 1 and self::$cfg["video_module"] == 1) ? VMessages::addToLabel('tpl_pl', 'video') : null) . '
										' . ((self::$cfg["file_playlists"] == 1 and self::$cfg["image_module"] == 1) ? VMessages::addToLabel('tpl_pl', 'image') : null) . '
										' . ((self::$cfg["file_playlists"] == 1 and self::$cfg["audio_module"] == 1) ? VMessages::addToLabel('tpl_pl', 'audio') : null) . '
										' . ((self::$cfg["file_playlists"] == 1 and self::$cfg["document_module"] == 1) ? VMessages::addToLabel('tpl_pl', 'doc') : null) . '
										' . ((self::$cfg["file_playlists"] == 1 and self::$cfg["blog_module"] == 1) ? VMessages::addToLabel('tpl_pl', 'blog') : null) . '
										' . $menu_li . '
										' . ((self::$cfg["file_deleting"] == 1 and ($mm_entry == "file-menu-entry1" or $mm_entry == '')) ? '<li class="count file-action hidden" id="cb-delete"><a href="javascript:;"><i class="icon-times"></i> ' . self::$language["frontend.global.delete.sel"] . '</a></li>' : null) . '
										' . ((self::$cfg["file_deleting"] == 1 and ($mm_entry == "file-menu-entry1" or $mm_entry == '')) ? '<li class="" onclick="if (!$(\'.content-current .thumbs-wrapper\').hasClass(\'thumb-selected\')) {$(\'#cb-delete\').click()} else {$.fancybox({type: \'ajax\', minWidth: \'50%\', minHeight: \'55%\', margin: 20, href: \''.self::$cfg["main_url"].'/'.VHref::getKey("files").'?a=confirm&k=selected\'});}" id="cb-delete-confirm"><a href="javascript:;"><i class="icon-times"></i> ' . self::$language["frontend.global.delete.sel"] . '</a></li>' : null) . '
									</ul>
								</div>
							</div>
						</div>
					    </section>
					    ' : null).'
					    <div class="clearfix"></div>
					    <div class="line nlb bottom"></div>
                                        </article>
                                    </div>
                                    
                ';

		return $html;
	}

	/* list available media files */
        private static function listMedia($entries, $user_watchlist, $type = false, $hidden = false) {
		$type 		= !$type ? self::$type : $type;
		$category       = isset($entries->fields["ct_name"]) ? $entries->fields["ct_name"] : false;
		$title_category = $category ? ' <i class="iconBe-chevron-right"></i> '.$category : null;
		$default_viewMode = (int) $_SESSION[self::$type."_vm"] > 0 ? (int) $_SESSION[self::$type."_vm"] : 1;
		$default_viewMode = 1;
		$content        = $entries->fields["file_key"] ? self::viewMode_loader($default_viewMode, $entries, $user_watchlist) : VGenerate::simpleDivWrap('no-content', '', self::$language["frontend.global.results.none"]);

		$html   =	'<div id="' . $type . '-content"' . ($hidden ? ' style="display: none;"' : null) .'>
						<div class="content-wrap">
						    <section id="section-public-' . $type . '">
							<article>
							    <h3 class="content-title no-display"><i class="icon-clock-o"></i>'.self::typeLangReplace(self::$language["files.menu.recent.type"], $type).'</h3>
							    <div class="sort-by">
							    	<div class="place-left lsp">'.self::$language["files.menu.sort.by"].'</div>
							    	<div class="place-left">:</div>
							    	<div class="place-left mp-sort-options">
							    		'.self::tabs($type, 1).'
							    	</div>
							    	<div class="clearfix"></div>
							    </div>
							    <section class="filter">
								<div class="main loadmask-img pull-left"></div>
								<div class="btn-group viewType pull-right vmtop">
								    <button type="button" id="main-view-mode-1-public-' . $type . '" value="public" class="viewType_btn vexc viewType_btn-default main-view-mode-' . $type . ''.($default_viewMode == 1 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view2"].'"><span class="icon-thumbs-with-details"></span></button>
								    <button type="button" id="main-view-mode-2-public-' . $type . '" value="public" class="viewType_btn vexc viewType_btn-default main-view-mode-' . $type . ''.($default_viewMode == 2 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view3"].'"><span class="icon-full-details"></span></button>
								</div>
							    </section>
							    <div class="line"></div>
							</article>
							<div class="row mview" id="main-view-mode-1-public-' . $type . '-list"'.($default_viewMode == 2 ? ' style="display: none"' : null).'>
							    	' . ($default_viewMode == 1 ? $content : null) . '
							</div>

							<div class="row mview" id="main-view-mode-2-public-' . $type . '-list"'.($default_viewMode == 1 ? ' style="display: none"' : null).'>
								' . ($default_viewMode == 2 ? $content : null) . '
							</div>

							<div class="row mview" id="main-view-mode-3-public-' . $type . '-list" style="display: none;">
							</div>
						    </section>

						    ' . ((!isset($_GET["pp"]) and self::$cfg["file_privacy"] == 1 and self::$subscription_private) ? self::tabSection_loader('private-' . $type, $category) : null) . '
						    ' . ((!isset($_GET["pp"]) and self::$cfg["file_privacy"] == 1 and !self::$subscription_section) ? self::tabSection_loader('personal-' . $type, $category) : null) . '
						    ' . (self::tabSection_loader('promoted-' . $type, $category)) . '
						    ' . (self::tabSection_loader('featured-' . $type, $category)) . '
						    ' . (self::tabSection_loader('views-' . $type, $category)) . '
						    ' . (self::$cfg["file_favorites"] == 1 ? self::tabSection_loader('favorites-' . $type, $category) : null) . '
						    ' . (self::$cfg["file_rating"] == 1 ? self::tabSection_loader('likes-' . $type, $category) : null) . '
						    ' . (self::$cfg["file_comments"] == 1 ? self::tabSection_loader('comments-' . $type, $category) : null) . '
						    ' . (self::$cfg["file_responses"] == 1 ? self::tabSection_loader('responses-' . $type, $category) : null) . '
						    <input type="hidden" id="tab-'.$type.'" value="public-'.$type.'">

						</div><!-- /content-wrap -->
				</div><!-- /' . $type . '-content -->';

		return $html;
        }
	
        /* viewmode loader */
        public static function viewMode_loader($viewMode_id, $entries = false, $user_watchlist = false) {
		$entries = (isset($_GET["p"]) and (int) $_GET["p"] == 1) ? self::getPromoted($viewMode_id) : (!$entries ? self::getMedia($viewMode_id) : $entries);
		$section = $entries ? (isset($_GET["sort"]) ? self::$filter->clr_str($_GET["sort"]) : 'public') : false;

		if (!$section)
			return;

		if (!$user_watchlist) {
			$user_watchlist = self::watchlistEntries();
		}

		$method  = "viewMode" . $viewMode_id;
		$content = $entries->fields["file_key"] ? self::$method($entries, $user_watchlist) : VGenerate::simpleDivWrap('no-content', '', self::$language["frontend.global.results.none"]);
		
		$content.= self::$page_links;
		
		return $content;
	}

	/* grid viewmode */
        private static function viewMode1($entries, $user_watchlist) {
		if ($entries->fields["file_key"]) {
			$li_loop	= null;
			$mm_entry	= isset($_GET["s"]) ? self::$filter->clr_str($_GET["s"]) : null;
			$duration_show	= (self::$type === 'audio' or self::$type === 'video' or self::$type === 'live') ? 1 : 0;
			$pl_id		= (int) substr($mm_entry, 21);
			$mobile		= VHref::isMobile();

			foreach ($entries as $entry) {
				$title		= $entries->fields["file_title"];
				$user		= $entries->fields["usr_user"];
				$displayname	= $entries->fields["usr_dname"];
				$chname		= $entries->fields["ch_title"];
				$user		= $displayname != '' ? $displayname : ($chname != '' ? $chname : $user);
				$file_key	= $entries->fields["file_key"];
				$file_name	= $entries->fields["file_name"];
				$usr_key	= $entries->fields["usr_key"];
				$usr_id		= $entries->fields["usr_id"];
				$thumb_server	= $entries->fields["thumb_server"];
				$is_live	= (self::$type == 'live' and $entries->fields["stream_live"] == 1) ? true : false;
				$datetime	= VUserinfo::timeRange($entries->fields["upload_date"]);
				$duration	= VFiles::fileDuration($entries->fields["file_duration"]);
				$views		= VFiles::numFormat($entries->fields["file_views"]);
				$likes		= VFiles::numFormat($entries->fields["file_like"]);
				$comments	= VFiles::numFormat($entries->fields["file_comments"]);
				$url		= self::$cfg["main_url"] . '/' . VGenerate::fileHref(self::$type[0], $file_key, $title); // title="'.$f_title_full.'"';
				$url		.= $pl_id > 0 ? '&p='.self::$dbc->singleFieldValue('db_'.self::$type.'playlists', 'pl_key', 'pl_id', $pl_id, (self::$db_cache ? self::$cfg['cache_files_playlist_key'] : false)) : null;
				$ch_url		= self::$cfg["main_url"].'/'.VHref::getKey("channel").'/'.$usr_key.'/'.$entries->fields["usr_user"];
				$def_thumb	= self::$cfg["global_images_url"].'/default-thumb.png';
				$vpv		= $entries->fields["thumb_preview"];
				$file_exists	= file_exists(self::$cfg["upload_files_dir"].'/'.$usr_key.'/'.self::$type[0].'/'.html_entity_decode($file_name, ENT_QUOTES, 'UTF-8'));

				if ($duration_show == 1 and $duration == '00:00') {
					//$conv		= VFileinfo::get_progress($file_key);
					$conv		= !$file_exists ? '<span style="font-size: 12px; line-height: 20px; margin: 5px; text-align: left; float: left;">'.self::$language["files.text.nofile.err"].'</span>' : VFileinfo::get_progress($file_key);
					$conv_class	= ' converting';
					$thumbnail	= '<img class="mediaThumb" src="'.$def_thumb.'" alt="'.$title.'">';
				} else {
					$conv		= null;
					$conv_class	= null;
					$img_src	= (self::$type == 'blog' and !file_exists(self::$cfg["media_files_dir"].'/'.$usr_key.'/t/'.$file_key.'/1.jpg')) ? self::$cfg["global_images_url"] . '/default-blog.png' : self::thumbnail($usr_key, $file_key, $thumb_server);
					$thumbnail	= '<img height="122" class="mediaThumb" src="'.$def_thumb.'" data-src="'.$img_src.'" alt="'.$title.'" onclick="window.location=\''.$url.'\'">';
				}

				if (self::$cfg["file_watchlist"] == 1) {
					if (is_array($user_watchlist) and in_array($file_key, $user_watchlist)) {
						$watchlist_icon = 'icon-check';
						$watchlist_text = self::$language["files.menu.watch.in"];
						$watchlist_info = null;
					} else {
						$watchlist_icon = 'icon-clock';
						$watchlist_text = self::$language["files.menu.watch.later"];
						$watchlist_info = ' rel-key="' . $file_key . '" rel-type="' . self::$type . '"';
					}
				}



		$li_loop.= '            <li class="vs-column fourths small-thumbs">
						<div class="thumbs-wrapper">
						' . (self::$cfg["file_watchlist"] == 1 ? '
							<div class="watch_later">
							    <div class="watch_later_wrap"' . $watchlist_info . '>
								<div class="watch_later_holder">
								    <i class="' . $watchlist_icon . '"></i>
								</div>
							    </div>
							    <span>' . $watchlist_text . '</span>
							</div>
							    ' : null) . '
							<figure class="effect-smallT' . $conv_class . '">
							    <i class="play-btn" onclick="window.location=\''.$url.'\'"></i>
							    ' . $thumbnail . '
							    '.(!$mobile ? '
							    <div style="display:none;position:absolute;top:0;width:100%;height:100%" class="vpv">
								<a href="' . $url . '" class="no-display">' . $title . '</a>
								'.($vpv ? '
                                                                <video loop playsinline="true" muted="true" style="width:100%;height:100%" id="pv'.$file_key.rand(9999,999999999).'" rel-u="'.$usr_key.'" rel-v="'.md5($file_key.'_preview').'" onclick="window.location=\''.$url.'\'">
                                                                        <source src="'.self::$cfg["previews_url"].'/default.mp4" type="video/mp4"></source>
                                                                </video>
                                                                ' : null).'
							    </div>
							    ' : null).'
							' . ($duration_show == 1 ? '
							<div class="caption-more">
							    <span class="time-lenght'.($is_live ? ' t-live' : null).'">'.($is_live ? self::$language["frontend.global.live"] : $duration.$conv).'</span>
							</div>
							' : null) . '
							</figure>
							<h2><a href="'.$url.'">' . $title . '</a></h2>
							<div class="profile_image">
							    <div class="profile_wrap">
								<span class="channel_name" onclick="window.location=\''.$ch_url.'\'">' . VAffiliate::affiliateBadge((($entries->fields["usr_affiliate"] == 1 or $entries->fields["usr_partner"] == 1) ? 1 : 0), $entries->fields["affiliate_badge"]) . $user . '</span>
							    </div>
							</div>

							<div class="caption">
                                                            <div class="vs-column">
                                                                <span class="views-number">'.$views.' '.($views == 1 ? self::$language["frontend.global.view"] : self::$language["frontend.global.views"]).'</span>
                                                                <span class="i-bullet"></span>
                                                                <span class="views-number">'.$datetime.'</span>
                                                            </div>
                                                        </div>
						</div>
							<div class="vwrap">
								<div class="thumbs-wrappers" style="display: '.((self::$section == self::$href["files"] or self::$section == self::$href["subscriptions"] or self::$section == self::$href["following"]) ? 'block' : 'none').';">
									<div class="vs-column full">
										<a href="javascript:;" onclick="$(this).parent().parent().parent().prev().toggleClass(\'thumb-selected\'); if (!$(\'#entry-action-buttons\').hasClass(\'dl-highlight\')) {$(\'#entry-action-buttons\').addClass(\'dl-highlight\')}else{$(\'#entry-action-buttons\').removeClass(\'dl-highlight\')} if ($(this).next().is(\':checked\')) {$(this).next().prop(\'checked\', false)} else {$(this).next().prop(\'checked\', true)}"><i class="icon-check"></i> '.self::$language["frontend.global.select"].'</a>
										<input type="checkbox" class="list-check hidden" id="file-check'.$file_key.'" value="'.$file_key.'" name="fileid[]" />
									'.(($usr_id == (int) $_SESSION["USER_ID"] and ($mm_entry == 'file-menu-entry1' or $mm_entry == '')) ? '
										<a href="'.self::$cfg["main_url"].'/'.VHref::getKey("files_edit").'?fe=1&'.self::$type[0].'='.$file_key.'"><i class="icon-pencil"></i> '.self::$language["frontend.global.edit"].'</a>
										<a href="javascript:;" onclick="$.fancybox({type: \'ajax\', minWidth: \'50%\', minHeight: \'55%\', margin: 20, href: \''.self::$cfg["main_url"].'/'.VHref::getKey("files").'?a=confirm&t='.self::$type.'&k='.$file_key.'\'});"><i class="icon-times"></i> '.self::$language["frontend.global.delete"].'</a>
									' : null).'
									</div>
								</div>
							</div>
					</li>';
			}
		}

		$html = '   <ul class="fileThumbs big clearfix">
			        ' . $li_loop . '
			    </ul>';

		return $html;
	}

	/* list viewmode */
        private static function viewMode2($entries, $user_watchlist) {
		if ($entries->fields["file_key"]) {
			$li_loop	= null;
			$mm_entry	= isset($_GET["s"]) ? self::$filter->clr_str($_GET["s"]) : null;
			$duration_show	= (self::$type === 'audio' or self::$type === 'video' or self::$type === 'live') ? 1 : 0;
			$pl_id		= (int) substr($mm_entry, 21);
			$mobile		= VHref::isMobile();

			foreach ($entries as $entry) {
				$title		= $entries->fields["file_title"];
				$description	= $entries->fields["file_description"];
				$user		= $entries->fields["usr_user"];
				$displayname	= $entries->fields["usr_dname"];
				$chname		= $entries->fields["ch_title"];
				$user		= $displayname != '' ? $displayname : ($chname != '' ? $chname : $user);
				$file_key	= $entries->fields["file_key"];
				$file_name	= $entries->fields["file_name"];
				$usr_key	= $entries->fields["usr_key"];
				$usr_id		= $entries->fields["usr_id"];
				$thumb_server	= $entries->fields["thumb_server"];
				$is_live	= (self::$type == 'live' and $entries->fields["stream_live"] == 1) ? true : false;
				$datetime	= VUserinfo::timeRange($entries->fields["upload_date"]);
				$duration	= VFiles::fileDuration($entries->fields["file_duration"]);
				$views		= VFiles::numFormat($entries->fields["file_views"]);
				$likes		= VFiles::numFormat($entries->fields["file_like"]);
				$comments	= VFiles::numFormat($entries->fields["file_comments"]);
				$url		= self::$cfg["main_url"] . '/' . VGenerate::fileHref(self::$type[0], $file_key, $title); // title="'.$f_title_full.'"';
				$url		.= $pl_id > 0 ? '&p='.self::$dbc->singleFieldValue('db_'.self::$type.'playlists', 'pl_key', 'pl_id', $pl_id, (self::$db_cache ? self::$cfg['cache_files_playlist_key'] : false)) : null;
				$def_thumb	= self::$cfg["global_images_url"].'/default-thumb.png';
				$vpv		= $entries->fields["thumb_preview"];
				$file_exists	= file_exists(self::$cfg["upload_files_dir"].'/'.$usr_key.'/'.self::$type[0].'/'.html_entity_decode($file_name, ENT_QUOTES, 'UTF-8'));

				if ($duration_show == 1 and $duration == '00:00') {
					$conv		= !$file_exists ? '<span style="font-size: 12px; line-height: 20px; margin: 5px; text-align: left; float: left;">'.self::$language["files.text.nofile.err"].'</span>' : VFileinfo::get_progress($file_key);
					$conv_class	= ' converting';
					$thumbnail	= '<img class="mediaThumb" src="'.$def_thumb.'" alt="'.$title.'">';
				} else {
					$conv		= null;
					$conv_class	= null;
					$img_src	= (self::$type == 'blog' and !file_exists(self::$cfg["media_files_dir"].'/'.$usr_key.'/t/'.$file_key.'/1.jpg')) ? self::$cfg["global_images_url"] . '/default-blog.png' : self::thumbnail($usr_key, $file_key, $thumb_server);
					$thumbnail	= '<img height="183" class="mediaThumb" src="'.$def_thumb.'" data-src="'.$img_src.'" alt="'.$title.'" onclick="window.location=\''.$url.'\'">';
				}

				if (is_array($user_watchlist) and in_array($file_key, $user_watchlist)) {
					$watchlist_icon = 'icon-check';
					$watchlist_text = self::$language["files.menu.watch.in"];
					$watchlist_info = null;
				} else {
					$watchlist_icon = 'icon-clock';
					$watchlist_text = self::$language["files.menu.watch.later"];
					$watchlist_info = ' rel-key="' . $file_key . '" rel-type="' . self::$type . '"';
				}



				$li_loop.= '    <li class="vs-column full-thumbs">
							<div class="thumbs-wrapper">
								' . (self::$cfg["file_watchlist"] == 1 ? '
							    <div class="watch_later">
								<div class="watch_later_wrap"' . $watchlist_info . '>
								    <div class="watch_later_holder">
									<i class="' . $watchlist_icon . '"></i>
								    </div>
								</div>
								<span>' . $watchlist_text . '</span>
							    </div>
								' : null) . '
							    <figure class="effect-fullT' . $conv_class . '">
							        <i class="play-btn" onclick="window.location=\''.$url.'\'"></i>
								' . $thumbnail . '
								' . ($duration_show == 1 ? '
								<div class="caption-more">
								    <span class="time-lenght'.($is_live ? ' t-live' : null).'">'.($is_live ? self::$language["frontend.global.live"] : $duration.$conv).'</span>
								</div>
								' : null) . '
								'.(!$mobile ? '
								<div style="display:none;position:absolute;top:0;width:100%;height:100%" class="vpv">
								    <a href="' . $url . '">' . $title . '</a>
								'.($vpv ? '
                                                                <video loop playsinline="true" muted="true" style="width:100%;height:100%" id="pv'.$file_key.rand(9999,999999999).'" rel-u="'.$usr_key.'" rel-v="'.md5($file_key.'_preview').'" onclick="window.location=\''.$url.'\'">
                                                                        <source src="'.self::$cfg["previews_url"].'/default.mp4" type="video/mp4"></source>
                                                                </video>
                                                                ' : null).'
								</div>
								' : null).'
							    </figure>

							    <div class="full-details-holder">
								<h2><a href="'.$url.'">' . $title . '</a></h2>
								<p>' . nl2br($description). '</p>
                                                            <div class="vs-column pd">
                                                                <span class="views-number">'.$views.' '.($views == 1 ? self::$language["frontend.global.view"] : self::$language["frontend.global.views"]).'</span>
                                                                <span class="i-bullet"></span>
                                                                <span class="views-number">'.$datetime.'</span>
                                                            </div>
							    </div>
							</div>
							<div class="vwrap">
								<div class="thumbs-wrappers" style="display: '.((self::$section == self::$href["files"] or self::$section == self::$href["subscriptions"] or self::$section == self::$href["following"]) ? 'block' : 'none').';">
									<div class="vs-column thirds">
										<a href="javascript:;" onclick="$(this).parent().parent().parent().prev().toggleClass(\'thumb-selected\'); if (!$(\'#entry-action-buttons\').hasClass(\'dl-highlight\')) {$(\'#entry-action-buttons\').addClass(\'dl-highlight\')}else{$(\'#entry-action-buttons\').removeClass(\'dl-highlight\')} if ($(this).next().is(\':checked\')) {$(this).next().prop(\'checked\', false)} else {$(this).next().prop(\'checked\', true)}"><i class="icon-check"></i> '.self::$language["frontend.global.select"].'</a>
										<input type="checkbox" class="list-check hidden" id="file-check'.$file_key.'" value="'.$file_key.'" name="fileid[]" />
									'.(($usr_id == (int) $_SESSION["USER_ID"] and ($mm_entry == 'file-menu-entry1' or $mm_entry == '')) ? '
										<a href="'.self::$cfg["main_url"].'/'.VHref::getKey("files_edit").'?fe=1&'.self::$type[0].'='.$file_key.'"><i class="icon-pencil"></i> '.self::$language["frontend.global.edit"].'</a>
										<a href="javascript:;" onclick="$.fancybox({type: \'ajax\', minWidth: \'50%\', minHeight: \'55%\', margin: 20, href: \''.self::$cfg["main_url"].'/'.VHref::getKey("files").'?a=confirm&t='.self::$type.'&k='.$file_key.'\'});"><i class="icon-times"></i> '.self::$language["frontend.global.delete"].'</a>
									' : null).'
									</div>
								</div>
							</div>
						</li>';
			}
		}

		$html = '   <ul class="fileThumbs big clearfix">
			        ' . $li_loop . '
			    </ul>';

		return $html;
	}

	/* generate thumbnail url location */
        public static function thumbnail($usr_key, $file_key, $thumb_server = 0, $rand = true) {
		if ($thumb_server > 0) {
			$expires	= 0;
			$custom_policy	= 0;
			$nr		= 1;

			return VGenerate::thumbSigned(self::$type, $file_key, $usr_key, $expires, $custom_policy, $nr);
		}

		return self::$cfg["media_files_url"] . '/' . $usr_key . '/t/' . $file_key . '/0.jpg'.($rand ? '?_='.rand(1,100000) : null);
	}

	/* lazy load more */
        private static function loadMore($viewMode, $section) {
		$html = '                       
						<div class="btn-group load-more-group">
                                                    <button class="more-button" id="main-view-mode-'.$viewMode.'-'.$section.'-'.self::$type.'-more" rel-page="2">
                                                        <span class="load-more loadmask-img">'.self::$language["frontend.global.loading"].'</span>
                                                        <span class="load-more-text"><i class="iconBe-plus"></i></span>
                                                    </button>
                                                    <a href="" class="nextSelector"></a>
                                                </div>
			';
        
		return $html;
        }
        /* sorting tabs */
        private static function tabs($type, $nonav = false) {
		$html = (!$nonav ? '<nav style="display:none">' : null).'
                                            <ul'.($nonav ? ' class="mp-sort-by"' : null).'>
                                                '.('<li><a href="#section-public-'.$type.'" class="icon icon-clock-o" rel="nofollow"><span>'.self::$language["files.menu.recent"].'</span></a></li>').'
                                                '.((!isset($_GET["pp"]) and self::$cfg["file_privacy"] == 1 and self::$subscription_private) ? '<li><a href="#section-private-'.$type.'" class="icon icon-key" rel="nofollow"><span>'.self::$language["files.menu.private"].'</span></a></li>' : null).'
                                                '.((!isset($_GET["pp"]) and self::$cfg["file_privacy"] == 1 and !self::$subscription_section) ? '<li><a href="#section-personal-'.$type.'" class="icon icon-lock" rel="nofollow"><span>'.self::$language["files.menu.personal"].'</span></a></li>' : null).'
                                                '.('<li><a href="#section-promoted-'.$type.'" class="icon icon-bullhorn" rel="nofollow"><span>'.self::$language["files.menu.promoted"].'</span></a></li>').'
                                                '.('<li><a href="#section-featured-'.$type.'" class="icon icon-star" rel="nofollow"><span>'.self::$language["files.menu.featured"].'</span></a></li>').'
                                                '.('<li><a href="#section-views-'.$type.'" class="icon icon-eye" rel="nofollow"><span>'.self::$language["files.menu.viewed"].'</span></a></li>').'
                                                '.(self::$cfg["file_favorites"] == 1 ? '<li><a href="#section-favorites-'.$type.'" class="icon icon-heart" rel="nofollow"><span>'.self::$language["files.menu.favorited.own"].'</span></a></li>' : null).'
                                                '.(self::$cfg["file_rating"] == 1 ? '<li><a href="#section-likes-'.$type.'" class="icon icon-thumbs-up" rel="nofollow"><span>'.self::$language["files.menu.most.liked.own"].'</span></a></li>' : null).'
                                                '.(self::$cfg["file_comments"] == 1 ? '<li><a href="#section-comments-'.$type.'" class="icon icon-comment" rel="nofollow"><span>'.self::$language["files.menu.commented.own"].'</span></a></li>' : null).'
                                                '.(self::$cfg["file_responses"] == 1 ? '<li><a href="#section-responses-'.$type.'" class="icon icon-comments" rel="nofollow"><span>'.self::$language["files.menu.responded.own"].'</span></a></li>' : null).'
                                            </ul>'.
                                        (!$nonav ? '</nav>' : null);

		return $html;
        }
	/* sorting tabs */
        private static function pl_tabs($type, $nonav = false) {
		$section	= self::$section;
		$href		= self::$href;
		
		switch ($section) {
				case $href["playlists"]:
				case $href["channel"]:
				case $href["search"]:
					$hide	 = true;
					
					break;
				
				default:
					$hide	 = (self::$subscription_section or !self::$subscription_private) ? true : false;
					
					break;
				
		}
		$html = (!$nonav ? '<nav style="display:none">' : null).'
						<ul'.($nonav ? ' class="mp-sort-by"' : null).'>
							'.((isset($_SESSION["q"]) and $_SESSION["q"] != '') ? '<li><a href="#section-relevance-'.$type.'" class="icon icon-search" rel="nofollow"><span>'.self::$language["search.text.rel"].'</span></a></li>' : null).'
							'.('<li><a href="#section-plpublic-'.$type.'" class="icon icon-clock-o" rel="nofollow"><span>'.(!$hide ? self::$language["files.menu.public"] : self::$language["files.menu.recent"]).'</span></a></li>').'
							'.(!$hide ? '<li><a href="#section-private-'.$type.'" class="icon icon-key" rel="nofollow"><span>'.self::$language["files.menu.private"].'</span></a></li>' : null).'
							'.(!$hide ? '<li><a href="#section-personal-'.$type.'" class="icon icon-lock" rel="nofollow"><span>'.self::$language["files.menu.personal"].'</span></a></li>' : null).'
							'.('<li><a href="#section-plviews-'.$type.'" class="icon icon-eye" rel="nofollow"><span>'.self::$language["files.menu.viewed"].'</span></a></li>').'
							'.('<li><a href="#section-titleasc-'.$type.'" class="icon icon-text-height" rel="nofollow"><span>'.self::$language["playlist.menu.title.asc"].'</span></a></li>').'
							'.('<li><a href="#section-titledesc-'.$type.'" class="icon icon-text-height" rel="nofollow"><span>'.self::$language["playlist.menu.title.desc"].'</span></a></li>').'
						</ul>
			'.(!$nonav ? '</nav>' : null);

		return $html;
        }
        private static function typeLangReplace($src, $type = false) {
        	$type	= !$type ? self::$type[0] : $type[0];
		
		return str_replace('##TYPE##', self::$language["frontend.global.".$type.".p.c"], $src);
        }
	private static function pl_typeLangReplace($src, $type = false) {
        	$type	= !$type ? self::$type[0] : $type[0];
		
		return str_replace('##TYPE##', self::$language["frontend.global.".$type.".c"], $src);
        }
        /* tab section loader */
        public static function tabSection_loader($tabSection, $category = false) {
		$title_category		= $category ? ' <i class="iconBe-chevron-right"></i> ' . $category : null;
		$typeSection		= explode("-", $tabSection);
		$type			= $typeSection[1];
		$switchSection		= str_replace('-' . $type, '', $tabSection);

		switch ($switchSection) {
			case "public":
				$title	= self::typeLangReplace(self::$language["files.menu.public.type"], $type);
				$icon	= 'clock-o';
				break;

			case "private":
				$title	= self::typeLangReplace(self::$language["files.menu.private.type"], $type);
				$icon	= 'key';
				break;

			case "personal":
				$title	= self::typeLangReplace(self::$language["files.menu.personal.type"], $type);
				$icon	= 'lock';
				break;

			case "promoted":
				$title	= self::typeLangReplace(self::$language["files.menu.promoted.type"], $type);
				$icon	= 'bullhorn';
				break;

			case "featured":
				$title	= self::typeLangReplace(self::$language["files.menu.featured.type"], $type);
				$icon	= 'star';
				break;

			case "views":
				$title	= self::typeLangReplace(self::$language["files.menu.viewed.type"], $type);
				$icon	= 'eye';
				break;

			case "likes":
				$title	= self::typeLangReplace(self::$language["files.menu.most.liked.type"], $type);
				$icon	= 'thumbs-up';
				break;

			case "comments":
				$title	= self::typeLangReplace(self::$language["files.menu.commented.type"], $type);
				$icon	= 'comment';
				break;

			case "favorites":
				$title	= self::typeLangReplace(self::$language["files.menu.favorited.type"], $type);
				$icon	= 'heart';
				break;

			case "responses":
				$title	= self::typeLangReplace(self::$language["files.menu.responded.type"], $type);
				$icon	= 'comments';
				break;
		}

		$html = '                   <section id="section-' . $tabSection . '">
                                                <article>
                                                    <h3 class="content-title no-display"><i class="icon-' . $icon . '"></i>' . $title . $title_category . '</h3>
                                                    <div class="sort-by">
                                                    	<div class="place-left lsp">Sort by</div>
                                                    	<div class="place-left">:</div>
                                                    	<div class="place-left mp-sort-options">
                                                    		'.self::tabs($type, 1).'
                                                    	</div>
                                                    	<div class="clearfix"></div>
                                                    </div>
                                                    <section class="filter">
                                                        <div class="main loadmask-img pull-left"></div>
                                                        <div class="btn-group viewType pull-right vmtop">
                                                            <button type="button" id="main-view-mode-1-' . $tabSection . '" value="' . str_replace('-' . $type, "", $tabSection) . '" class="viewType_btn vexc viewType_btn-default main-view-mode-' . $type . ' active" rel="tooltip" title="'.self::$language["files.menu.view2"].'"><span class="icon-thumbs-with-details"></span></button>
                                                            <button type="button" id="main-view-mode-2-' . $tabSection . '" value="' . str_replace('-' . $type, "", $tabSection) . '" class="viewType_btn vexc viewType_btn-default main-view-mode-' . $type . '" rel="tooltip" title="'.self::$language["files.menu.view3"].'"><span class="icon-full-details"></span></button>
                                                        </div>
                                                    </section>
                                                    <div class="clearfix"></div>
                                                    <div class="line"></div>
                                                </article>

                                                <div class="row mview" id="main-view-mode-1-' . $tabSection . '-list">
                                                </div>

                                                <div class="row mview" id="main-view-mode-2-' . $tabSection . '-list" style="display: none">
                                                </div>

                                                <div class="row mview" id="main-view-mode-3-' . $tabSection . '-list" style="display: none;">
                                                </div>
                                            </section>';

		return $html;
	}
	/* playlist tab section loader */
        public static function pl_tabSection_loader($tabSection, $category = false) {
		$title_category		= $category ? ' <i class="iconBe-chevron-right"></i> ' . $category : null;
		$typeSection		= explode("-", $tabSection);
		$type			= $typeSection[1];
		$switchSection		= str_replace('-' . $type, '', $tabSection);

		switch ($switchSection) {
			case "plpublic":
				$title	= self::pl_typeLangReplace(self::$language["playlist.section.title.public"], $type);
				$icon	= 'clock-o';
				break;

			case "private":
				$title	= self::pl_typeLangReplace(self::$language["playlist.section.title.private"], $type);
				$icon	= 'key';
				break;

			case "personal":
				$title	= self::pl_typeLangReplace(self::$language["playlist.section.title.personal"], $type);
				$icon	= 'lock';
				break;

			case "plviews":
				$title	= self::pl_typeLangReplace(self::$language["playlist.section.title.views"], $type);
				$icon	= 'eye';
				break;
			
			case "titleasc":
				$title	= self::pl_typeLangReplace(self::$language["playlist.section.title.titleasc"], $type);
				$icon	= 'text-height';
				break;
			
			case "titledesc":
				$title	= self::pl_typeLangReplace(self::$language["playlist.section.title.titledesc"], $type);
				$icon	= 'text-height';
				break;

		}

		$html = '                   <section id="section-' . $tabSection . '">
                                                <article>
                                                    <h3 class="content-title no-display"><i class="icon-' . $icon . '"></i>' . $title . $title_category . '</h3>
                                                    <div class="sort-by">
                                                    	<div class="place-left lsp">'.self::$language["files.menu.sort.by"].'</div>
                                                    	<div class="place-left">:</div>
                                                    	<div class="place-left mp-sort-options">
                                                    		'.self::pl_tabs($type, 1).'
                                                    	</div>
                                                    	<div class="clearfix"></div>
                                                    </div>
                                                    <section class="filter">
                                                        <div class="main loadmask-img pull-left"></div>
                                                        <div class="btn-group viewType pull-right">
                                                            <button type="button" id="main-view-mode-1-' . $tabSection . '" value="' . str_replace('-' . $type, "", $tabSection) . '" class="viewType_btn viewType_btn-default vexc main-view-mode-' . $type . ' active" rel="tooltip" title="'.self::$language["files.menu.view2"].'"><span class="icon-thumbs"></span></button>
                                                            <button type="button" id="main-view-mode-2-' . $tabSection . '" value="' . str_replace('-' . $type, "", $tabSection) . '" class="viewType_btn viewType_btn-default vexc main-view-mode-' . $type . '" rel="tooltip" title="'.self::$language["files.menu.view3"].'"><span class="icon-full-details"></span></button>
                                                        </div>
                                                    </section>
                                                    <div class="clearfix"></div>
                                                    <div class="line"></div>
                                                </article>

                                                <div class="row mview" id="main-view-mode-1-' . $tabSection . '-list">
                                                </div>

                                                <div class="row mview" id="main-view-mode-2-' . $tabSection . '-list" style="display: none">
                                                </div>

                                                <div class="row mview" id="main-view-mode-3-' . $tabSection . '-list" style="display: none;">
                                                </div>
                                            </section>';

		return $html;
	}
	
	/* confirm deleting lightbox */
	public static function doConfirm() {
		$language	= self::$language;
		$class_filter	= self::$filter;
		
		$file_key	= $class_filter->clr_str($_GET["k"]);
		
		switch ($file_key) {
			case "selected":
				$ask	= $language["notif.confirm.delete.multi"];
				$js_do	= '$(\'#cb-delete\').click(); $.fancybox.close();';
				$js_no	= '$(\'#\'+$(\'.main-view-mode-\'+$(\'.view-mode-type.active\').attr(\'id\').replace(\'view-mode-\', \'\')+\'.active\').attr(\'id\')+\'-list .list-check\').prev().click(); $.fancybox.close();';
				
				break;
			
			default:
				$type	= $class_filter->clr_str($_GET["t"]);
				$ask	= str_replace('##TYPE##', self::$language["frontend.global.".$type[0]], $language["notif.confirm.delete.type"]);
				$js_do	= '$(\'#\'+$(\'.main-view-mode-\'+$(\'.view-mode-type.active\').attr(\'id\').replace(\'view-mode-\', \'\')+\'.active\').attr(\'id\')+\'-list #file-check'.$file_key.'\').prev().click(); $(\'#cb-delete\').click(); $.fancybox.close();';
				$js_no	= '$.fancybox.close();';
				
				break;
		}
		
		$html	= '
				<form id="delete-confirm-form" action="" method="post" class="entry-form-class">
					<article>
						<h3 class="content-title"><i class="iconBe-check"></i> '.$language["files.action.del.confirm"].'</h3>
						<div class="line"></div>
					</article>

					<div class="clearfix"></div>
					<h4>'.$ask.'</h4>
					<div class="clearfix"></div>
					<br>
					<div class="row" id="delete-button-row">
						<button onclick="'.$js_do.'" name="delete_btn" id="delete-btn" class="save-entry-button button-grey search-button form-button delete-button" type="button" value="1"><span>'.$language["frontend.global.doit"].'</span></button>
						<a class="link cancel-trigger" href="javascript:;" onclick="'.$js_no.'"><span>'.$language["frontend.global.cancel"].'</span></a>
					</div>
				</form>
			    ';
		
		echo $html;
	}

	/* inner section */
	function sectionWrap(){
		self::$smarty->assign('page_display', 'tpl_files');
		self::$smarty->display('tpl_frontend/tpl_file/tpl_files.tpl');
	}
	/* subscription options */
	private static function subsConfig() {
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_filter	= self::$filter;
		$class_database	= self::$dbc;

		$_s		= VHref::currentSection();
		$sub_id		= (int) substr($_s, 15);
		$sub_usr	= $_s[0] == 's' ? $class_database->singleFieldValue('db_subscribers', 'subscriber_id', 'usr_id', $sub_id) : ($_s[0] == 'f' ? $class_database->singleFieldValue('db_followers', 'follower_id', 'usr_id', $sub_id) : null);
		$is		= false;

		if ($sub_usr != '') {
			$sub_arr = unserialize($sub_usr);
			
			foreach ($sub_arr as $key => $val) {
				if ($val["sub_id"] == $_SESSION["USER_ID"]) {
					$is		= true;
					$sub_type	= $val["sub_type"];
					$mail_uploads	= $val["mail_new_uploads"];
				}
			}
		}
		if (!$is) {
			$ts	= self::$db->execute(sprintf("SELECT `db_id`, `expire_time` FROM `db_subtemps` WHERE `usr_id`='%s' AND `usr_id_to`='%s' AND `active`='1' LIMIT 1;", (int) $_SESSION["USER_ID"], $sub_id));

			$html  = '<div class="lb-margins">';
			$html .= '<article><h3 class="content-title"><i class="icon-warning"></i>'.($_s[0] == 's' ? $language["files.text.subs.edit"] : $language["files.text.follow.edit"]).'</h3><div class="line"></div></article>';
			$html .= '<p>'.($ts->fields["db_id"] ? $language["files.text.unsub.warn3"].$ts->fields["expire_time"] : $language["notif.error.invalid.request"]).'</p>';
			$html .= '</div>';

			return $html;
		}

		$html  = '<div class="lb-margins">';
		$html .= '<article><h3 class="content-title"><i class="icon-pencil"></i>'.($_s[0] == 's' ? $language["files.text.subs.edit"] : $language["files.text.follow.edit"]).'</h3><div class="line"></div></article>';
		$html .= '<div id="subs-tab-edit-option" class="no-display-off">';
		$html .= '<div id="subs-tab-edit-response"></div>';
		$html .= '<form name="subcription_setup_form" class="entry-form-class" id="sub-form" method="post" action="">';
		$html .= '<div class="icheck-box">';
		if ($_s[0] == 's' or $_s[0] == 'f') {
			$html .= '<div class="no-display1">';
			$html .= '<label>' . $language["files.text.subs.include"] . '</label><br>';
			$html .= '<input' . ($sub_type == 'all' ? ' checked="checked"' : NULL) . ' type="radio" value="all" name="sub_options" />';
			$html .= '<label>' . $language["files.text.subs.opt.all"] . '<span class="subs-option-username"></span></label>';
			$html .= '<br>';
			$html .= '<input' . ($sub_type == 'files' ? ' checked="checked"' : NULL) . ' type="radio" value="files" name="sub_options" />';
			$html .= '<label>' . $language["files.text.subs.opt.files"] . '<span class="subs-option-username"></span></label>';
			$html .= '<br>';
			$html .= '</div>';

			$html .= '<input' . ($mail_uploads == 1 ? ' checked="checked"' : NULL) . ' type="checkbox" value="1" name="sub_upload_email" />';
			$html .= '<label>' . $language["files.text.subs.opt.uploads"] . '</label>';
			$html .= '<br>';
			$html .= '<input type="radio" value="unsub" name="sub_options" />';
			$html .= '<label>' . ($_s[0] == 's' ? $language["files.text.subs.opt.unsub"] : $language["frontend.global.unfollow"]) . ' <span class="subs-option-username"></span></label>';
		} else {
			$html .= '<input type="checkbox" value="unsub2" name="sub_options" />';
			$html .= '<label>' . $language["files.text.subs.cancel"] . '<span class="subs-option-username"></span></label>';
		}
		$html .= '</div><br>';
		$html .= VGenerate::simpleDivWrap('row left-float top-bottom-padding', '', VGenerate::basicInput('button', 'subs_config_save', 'save-entry-button button-grey search-button form-button save-subs-config', '', 1, '<span>'.$language["frontend.global.savechanges"].'</span>') . ' <a class="link cancel-trigger" href="javascript:;" onclick="$(\'.fancybox-close\').click();"><span>' . $language["frontend.global.cancel"] . '</span></a>');
		$html .= '<div class="row no-display"><input type="hidden" name="sub_for" value="' . $sub_id . '" /></div>';
		$html .= '</form>';
		$html .= '</div>';
		$html .= '</div>';

		$ht_js  = '
				$(".save-subs-config").on("click", function(){
					var the_url = "' . $cfg["main_url"] . '/' . ($_s[0] == 's' ? VHref::getKey("subscriptions") : VHref::getKey("following")) . ($_s != '' ? '?s=' . $_s . '&a=sub_edit' : '?a=sub_edit') . '";
					var the_form = "#sub-form";
					$("#subs-tab-edit-option").mask(" ");
					
					$.post(the_url, $(the_form).serialize(), function(data){
						$("#subs-tab-edit-response").html(data);
						$("#subs-tab-edit-option").unmask();
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

			';
		$ht_js .= '$(".subs-option-username").html($("#sub' . ($_s[0] == 's' ? '1' : '2') . '-menu li.menu-panel-entry-active span.mm").text());';

		$html	.= VGenerate::declareJS('$(document).ready(function(){' . $ht_js . '});');
		
		return $html;
	}

	/* save subscription settings, inc. unsubscribe */
	public static function setSubSettings() {
		$db		= self::$db;
		$class_database	= self::$dbc;
		$class_filter	= self::$filter;
		$language	= self::$language;

		$_s		= $class_filter->clr_str($_GET["s"]);
		$sub_type	= $class_filter->clr_str($_POST["sub_options"]);
		$new_uploads	= (int) $_POST["sub_upload_email"];
		$sub_for	= $_s[0] == 'o' ? (int) $_SESSION["USER_ID"] : (int) $_POST["sub_for"];

		$sub_db		= $_s[0] == 's' ? $class_database->singleFieldValue('db_subscribers', 'subscriber_id', 'usr_id', $sub_for) : $class_database->singleFieldValue('db_followers', 'follower_id', 'usr_id', $sub_for);
		$sub_arr	= unserialize($sub_db);

		$u_js = '$(".menu-panel-entry-active").replaceWith("");';
		$u_js .= 'wrapLoad(current_url+menu_section+"?s="+$("#menu-panel-wrapper>div").attr("id"));';
		$u_js .= '$("#"+$("#menu-panel-wrapper>div").attr("id")).addClass("menu-panel-entry-active");';
		$u_js .= 'var h2t = $("#"+$("#menu-panel-wrapper>div").attr("id")+">span.bold").text(); h2t = h2t == "" ? $("a.active").html() : h2t;';
		$u_js .= '$("h2").text(h2t);';

		foreach ($sub_arr as $key => $val) {
			if ($sub_arr[$key]["sub_id"] == substr($_GET["s"], 15) and $sub_type == 'unsub2') {
				unset($sub_arr[$key]);
				echo VGenerate::declareJS('$(document).ready(function(){' . $u_js . '});');
			}
			if ($sub_arr[$key]["sub_id"] == $_SESSION["USER_ID"] and $sub_type != 'unsub2') {
				if ($sub_type == 'unsub') {
					unset($sub_arr[$key]);
					echo VGenerate::declareJS('$(document).ready(function(){' . $u_js . '});');
				} else {
					$sub_arr[$key]["sub_type"] = $sub_type;
					$sub_arr[$key]["mail_new_uploads"] = $new_uploads;
				}
			}
		}

		$sub_sql	= $_s[0] == 's' ? sprintf("UPDATE `db_subscribers` SET `subscriber_id`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($sub_arr), $sub_for) : sprintf("UPDATE `db_followers` SET `follower_id`='%s' WHERE `usr_id`='%s' LIMIT 1;", serialize($sub_arr), $sub_for);
		$sub_update	= $db->execute($sub_sql);

		if ($db->Affected_Rows() > 0) {
                        if ($sub_type == 'unsub') {
                                if ($_s[0] == 's') {
                                        $db->execute(sprintf("UPDATE `db_accountuser` SET `usr_subcount`=`usr_subcount`-1 WHERE `usr_id`='%s' LIMIT 1;", $sub_for));
                                } else {
                                        $db->execute(sprintf("UPDATE `db_accountuser` SET `usr_followcount`=`usr_followcount`-1 WHERE `usr_id`='%s' LIMIT 1;", $sub_for));
                                }
                        }
                        echo VGenerate::noticeTpl(' no-top-padding wd97p', '', $language["notif.success.request"]);
                }
	}

	
	
	/* browse file comments (when managing files) */
	public static function fileComments() {
		$db		= self::$db;
		$class_filter	= self::$filter;
		$language	= self::$language;
		$cfg		= self::$cfg;

		$entry_id	= 'ct-entry-details1';
		$type		= self::$type;
		$sort		= $class_filter->clr_str($_GET["a"]);
		$_do		= $class_filter->clr_str($_GET["do"]);
		
		if ($_do == 'cr-approved' or $_do == 'cr-suspended' or $_do == 'cr-today' or $_do == 'cr-recent') {
			$sort = $_do;
		}

		switch ($sort) {
			case "cr-approved":
			default:
				$sort_sql = "AND A.`c_approved`='1' ORDER BY A.`c_datetime` DESC";
				break;
			case "cr-suspended":
				$sort_sql = "AND A.`c_approved`='0' ORDER BY A.`c_datetime` DESC";
				break;
			case "cr-today":
				$sort_sql = sprintf("AND A.`c_datetime` LIKE '%s'", date("Y-m-d") . '%');
				break;
			case "cr-recent":
				$sort_sql = "ORDER BY A.`c_datetime` DESC";
				break;
		}

		$sql = sprintf("SELECT 
				    A.`file_key`, A.`c_usr_id`, A.`c_key`, A.`c_body`, A.`c_datetime`, A.`c_approved`, A.`c_seen`, 
				    B.`usr_id`, 
				    C.`usr_user`, C.`usr_key`, C.`usr_partner`, C.`usr_affiliate`, C.`affiliate_badge`, 
				    B.`file_title`,
				    C.`usr_dname`, C.`ch_title`
				    FROM `db_%scomments` A, `db_%sfiles` B, `db_accountuser` C
				    WHERE 
				    A.`file_key`=B.`file_key` 
				    AND B.`usr_id`='%s' 
				    AND A.`c_active`='1' 
				    AND A.`c_usr_id`=C.`usr_id` %s ", $type, $type, intval($_SESSION["USER_ID"]), $sort_sql);
		$res = $db->execute($sql);

		if ($res) {
			$do		= 0;
			$db_count	= $res->recordcount();
			$pages		= new VPagination;
			
			$pages->items_total	= $db_count;
			$pages->mid_range	= 5;
			$pages->items_per_page  = isset($_GET["ipp"]) ? (int) $_GET["ipp"] : $cfg["page_user_files_comments"];
			$pages->paginate();

			$res		= $db->execute($sql . $pages->limit . ';');
			$page_of	= (($pages->high + 1) > $db_count) ? $db_count : ($pages->high + 1);
			$results_text	= $pages->getResultsInfo($page_of, $db_count, 'left');
			$paging_links	= $pages->getPaging($db_count, 'right');


			$html = '<div class="entry-list">';
			$html .= '<form id="gen-file-actions" class="entry-form-class" method="post" action="">';
			$html .= '<ul class="responsive-accordion responsive-accordion-default bm-larger">';
			while (!$res->EOF) {
				$date		= strftime("%b %d, %Y, %H:%M %p", strtotime($res->fields["c_datetime"]));
				$user		= $res->fields["usr_user"];
				$name		= $res->fields["usr_dname"] != '' ? $res->fields["usr_dname"] : ($res->fields["ch_title"] != '' ? $res->fields["ch_title"] : $res->fields["usr_user"]);
				$usr_key	= $res->fields["usr_key"];
				$uid		= $res->fields["c_usr_id"];
				$_info          = VUserinfo::getUserInfo($uid);
                                $name           = $_info["dname"] != '' ? $_info["dname"] : ($_info["ch_title"] != '' ? $_info["ch_title"] : $_info["uname"]);
				$title		= $res->fields["file_title"];
				$db_id		= $res->fields["c_key"];
				$msg		= $res->fields["c_body"];
				$seen		= 1;
				$new_msg	= $seen == 0 ? ' new-message' : NULL;


				$html .= '<li class="cr-tabs">';
				$html .= '<div class="left-float ct-entry wd94p bottom-border" id="ct-bullet1-' . $db_id . '">';
				$html .= '<div class="responsive-accordion-head">';
				$html .= '<div class="place-left icheck-box ct"><input type="checkbox" name="entryid[]" value="' . $db_id . '" class="list-check"></div>';
				$html .= '<div class="responsive-accordion-title">';
				$html .= VGenerate::simpleDivWrap('entry-number ct-bullet-label-off place-left right-padding10' . $new_msg, '', $language["frontend.global.from"] . ' <a href="' . $cfg["main_url"] . '/' . VHref::getKey("channel") . '/' . $usr_key . '/' . $user . '">' . VAffiliate::affiliateBadge((($res->fields["usr_affiliate"] == 1 or $res->fields["usr_partner"] == 1) ? 1 : 0), $res->fields["affiliate_badge"]) . $name . '</a>');
				$html .= VGenerate::simpleDivWrap('entry-title ct-bullet-label-off place-left right-padding10' . $new_msg, '', '<span class="greyed-out">' . $language["files.text.comment.on"] . '</span><span class="">"' . $title . '"</span>');
				$html .= VGenerate::simpleDivWrap('entry-type ct-bullet-label-off place-left greyed-out' . $new_msg, '', '[' . $date . ']');

				$actions = '<a href="javascript:;"><i title="' . $language["frontend.global.delete"] . '" rel="tooltip" class="delete-grey" id="ic3-' . $entry_id . '-' . $db_id . '"></i></a>';
				
				switch ($res->fields["c_approved"]) {
					case "1":
						$tt_class = 'icon-tag';
						$actions.= '<a href="javascript:;"><i title="' . $language["frontend.global.suspend.cap"] . '" rel="tooltip" class="disable-grey" id="ic2-' . $entry_id . '-' . $db_id . '"></i></a>';
						break;
					case "0":
						$tt_class = 'icon-tag';
						$actions.= '<a href="javascript:;"><i title="' . $language["frontend.global.approve"] . '" rel="tooltip" class="enable-grey" id="ic1-' . $entry_id . '-' . $db_id . '"></i></a>';
						break;
				}

				$html .= '<div class="place-right expand-entry">';
				$html .= '<i class="fa fa-chevron-down responsive-accordion-plus fa-fw iconBe-chevron-down" style="display: inline;"></i>';
				$html .= '<i class="fa fa-chevron-up responsive-accordion-minus fa-fw iconBe-chevron-up" style="display: none;"></i>';
				$html .= '</div>';//end responsive-accordion-title

				$html .= '</div>';
				$html .= '</div>'; //end responsive-accordion-head
				$html .= '<div class="responsive-accordion-panel" style="display: none;">';

				$html .= '<div class="ct-entry-details-off" id="' . $entry_id . '-' . $db_id . '">';
				$html .= '<div id="' . $entry_id . $db_id . '-actions" class="ct-entry-action-buttons">' . $actions . '</div>';
				$html .= VGenerate::simpleDivWrap('place-left-off wdmax msg-body', '', VGenerate::simpleDivWrap('wd90 place-left left-padding15 no-top-padding', '', '<div class="user-thumb-large-off"><a href="' . $cfg["main_url"] . '/' . VHref::getKey("channel") . '/' . $usr_key . '/' . $user . '"><img src="' . VUseraccount::getProfileImage($uid) . '" alt="" height="60" /></a></div>') . VGenerate::simpleDivWrap('msg-body', '', '<pre>' . $msg . '</pre>'));
				$html .= '<div class="clearfix"></div>';
				$html .= '</div>'; //end ct-entry-details
				$html .= '</div>'; //end responsive-accordion-panel
				$html .= '</div>'; //end ct-entry 
				$html .= '</li>';

				@$res->MoveNext();
				$do += 1;
			}
			$html .= '</ul>';
			$html .= $db_count == 0 ? VGenerate::simpleDivWrap('no-content', '', $language["files.text.no.comments"]) : NULL;
			$html .= $db_count > 0 ? '<div id="paging-bottom" class="paging-top-border paging-bg ">' . $paging_links . $results_text . '</div>' : NULL;
			$html .= VGenerate::simpleDivWrap('no-display', '', '<input type="hidden" name="section_subject_value" class="section_subject_value" value="' . $db_id . '" />');
			$html .= '</form>';
			$html .= '</div>';
		}
		
		return $html;
	}
	/* browse file responses (when managing files) */
	public static function fileResponses() {
		$db		= self::$db;
		$class_filter	= self::$filter;
		$language	= self::$language;
		$cfg		= self::$cfg;


		$entry_id	= 'ct-entry-details1';
		$type		= self::$type;

		$sort		= $class_filter->clr_str($_GET["a"]);
		$_do		= $class_filter->clr_str($_GET["do"]);
		
		if ($_do == 'cr-approved' or $_do == 'cr-suspended' or $_do == 'cr-today' or $_do == 'cr-recent') {
			$sort = $_do;
		}

		$sql = sprintf("SELECT 
				    A.`file_responses`, 
				    B.`file_key`, B.`file_title` 
				    FROM `db_%sresponses` A, `db_%sfiles` B 
				    WHERE 
				    A.`file_key`=B.`file_key` 
				    AND B.`usr_id`='%s' ", $type, $type, (int) $_SESSION["USER_ID"]);
		$rs = $db->execute($sql);

		if ($rs) {
			$t_arr	= array();
			$v_arr	= array();
			$_arr	= array();
			$resp	= $rs->getrows();

			if (count($resp) == 0)
				return VGenerate::simpleDivWrap('left-float wdmax center all-paddings5 no-content', '', $language["files.text.no.responses"]);
			else {
				foreach ($resp as $k => $v) {
					$_arr = unserialize($v[0]);

					$v_arr[$v["file_key"]] = array("file_title" => $v["file_title"], "usr_id" => "", "date" => "", "active" => "");
					foreach ($_arr as $key => $val) {
						if ((($sort == 'cr-approved' or $sort == '') and $val["active"] == 1) or ( $sort == 'cr-suspended' and $val["active"] == 0) or ( $sort == 'cr-today' and ( substr($val["date"], 0, 10) == date("Y-m-d")))) {
							$q .= " (B.`file_key`='" . $val["file_key"] . "' AND B.`usr_id`=C.`usr_id`) OR ";
							$t_arr[$val["file_key"]] = strtotime($val["date"]);

							$v_arr[$val["file_key"]]["usr_id"] = $val["usr_id"];
							$v_arr[$val["file_key"]]["date"] = $val["date"];
							$v_arr[$val["file_key"]]["active"] = $val["active"];
						}
					}
				}
				$q = $q != '' ? ' AND (' . substr($q, 0, -4) . ')' : ' AND B.`usr_id`=\'0\'';
				$sql = sprintf("SELECT 
					    B.`usr_id`, 
					    C.`usr_user`, C.`usr_key`, C.`usr_partner`, C.`usr_affiliate`, C.`affiliate_badge`,
					    B.`file_title`, B.`file_key`,
					    C.`usr_dname`, C.`ch_title`
					    FROM `db_%sfiles` B, `db_accountuser` C
					    WHERE 
					    B.`usr_id`=C.`usr_id` 
					    %s ", $type, $q);
				$res = $db->execute($sql);
			}

			$do			= 0;
			$db_count		= $res->recordcount();
			$pages			= new VPagination;
			
			$pages->items_total	= $db_count;
			$pages->mid_range	= 5;
			$pages->items_per_page	= isset($_GET["ipp"]) ? (int) $_GET["ipp"] : $cfg["page_user_files_responses"];
			$pages->paginate();

			$res			= $db->execute($sql . $pages->limit . ';');
			$pg_count		= $res->recordcount();
			$page_of		= (($pages->high + 1) > $db_count) ? $db_count : ($pages->high + 1);
			$results_text		= $pages->getResultsInfo($page_of, $db_count, 'left');
			$paging_links		= $pages->getPaging($db_count, 'right');

			arsort($t_arr);

			$html = '<div class="entry-list">';
			$html .= '<form id="gen-file-actions" class="entry-form-class" method="post" action="">';
			$html .= '<ul class="responsive-accordion responsive-accordion-default bm-larger">';
			while (!$res->EOF) {
				$db_id		= $res->fields["file_key"];
				$rt		= $db->execute(sprintf("SELECT `file_key` FROM `db_%sresponses` WHERE `file_responses` LIKE '%s' LIMIT 1;", $type, '%s:10:"' . $db_id . '"%'));
				$date		= $v_arr[$db_id]["date"];
				$date		= strftime("%b %d, %Y, %H:%M %p", strtotime($date));
				$uid		= $v_arr[$db_id]["usr_id"];
//echo				$rtitle		= $v_arr[$rt->fields["file_key"]]["file_title"];
				$title		= $res->fields["file_title"];
				$user		= VUserinfo::getUserName($uid);
				$msg		= $res->fields["file_key"];
				$name		= $res->fields["usr_dname"] != '' ? $res->fields["usr_dname"] : ($res->fields["ch_title"] != '' ? $res->fields["ch_title"] : $res->fields["usr_user"]);
				$u_key		= $res->fields["usr_key"];
				$info		= VFiles::getFileInfo($rt->fields["file_key"]);
				$rtitle		= $info["title"];
				$f_title	= '<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $msg, $title) . '&rs='.md5(date("Y-m-d")).'" class="file-title">' . $title . '</a>';
//				$f_descr	= VGenerate::simpleDivWrap('response-descr', '', '<pre>' . $info["description"] . '</pre>');
				$seen		= 1;
				$new_msg	= $seen == 0 ? ' new-message' : NULL;

				$htm = '<li class="cr-tabs">';
				$htm .= '<div class="left-float ct-entry wd94p bottom-border" id="ct-bullet1-' . $db_id . '">';
				$htm .= '<div class="responsive-accordion-head">';
				$htm .= '<div class="place-left icheck-box ct"><input type="checkbox" name="entryid[]" value="' . $db_id . '" class="list-check"></div>';
				$htm .= '<div class="responsive-accordion-title">';
				$htm .= VGenerate::simpleDivWrap('entry-number ct-bullet-label-off place-left right-padding10' . $new_msg, '', $language["frontend.global.from"] . ' <a href="' . $cfg["main_url"] . '/' . VHref::getKey("channel") . '/' . $u_key . '/' . $user . '">' . VAffiliate::affiliateBadge((($res->fields["usr_affiliate"] == 1 or $res->fields["usr_partner"]) ? 1 : 0), $res->fields["affiliate_badge"]) . $name . '</a>');
				$htm .= VGenerate::simpleDivWrap('entry-title ct-bullet-label-off place-left right-padding10' . $new_msg, '', '<span class="greyed-out">' . $language["files.text.response.to"] . '</span><span class="">"' . $rtitle . '"</span>');
				$htm .= VGenerate::simpleDivWrap('entry-type ct-bullet-label-off place-left greyed-out' . $new_msg, '', '[' . $date . ']');

				$actions = '<a href="javascript:;"><i title="' . $language["frontend.global.delete"] . '" rel="tooltip" class="delete-grey" id="ic3-' . $entry_id . '-' . $db_id . '"></i></a>';

				switch ($v_arr[$db_id]["active"]) {
					case "1":
						$tt_class = 'icon-tag';
						$actions.= '<a href="javascript:;"><i title="' . $language["frontend.global.suspend.cap"] . '" rel="tooltip" class="disable-grey" id="ic2-' . $entry_id . '-' . $db_id . '"></i></a>';
						break;
					case "0":
						$tt_class = 'icon-tag';
						$actions.= '<a href="javascript:;"><i title="' . $language["frontend.global.approve"] . '" rel="tooltip" class="enable-grey" id="ic1-' . $entry_id . '-' . $db_id . '"></i></a>';
						break;
				}
				$htm .= '<div class="place-right expand-entry">';
				$htm .= '<i class="fa fa-chevron-down responsive-accordion-plus fa-fw iconBe-chevron-down" style="display: inline;"></i>';
				$htm .= '<i class="fa fa-chevron-up responsive-accordion-minus fa-fw iconBe-chevron-up" style="display: none;"></i>';
				$htm .= '</div>';//end responsive-accordion-title

				$htm .= '</div>';
				$htm .= '</div>'; //end responsive-accordion-head
				$htm .= '<div class="responsive-accordion-panel" style="display: none;">';
				$htm .= '<div class="ct-entry-details-off" id="' . $entry_id . '-' . $db_id . '">';
				$htm .= '<div id="' . $entry_id . $db_id . '-actions" class="ct-entry-action-buttons">' . $actions . '</div>';
				$htm .= VGenerate::simpleDivWrap('place-left-off wdmax msg-body', '', '<div class="place-left response-thumb"><a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $msg, $title) . '&rs='.md5(date("Y-m-d")).'"><img src="' . VGenerate::thumbSigned(self::$type, $msg, $u_key) . '" height="80" alt="'.$title.'"></a></div>' . VGenerate::simpleDivWrap('ct-entries', '', $f_title));
				$htm .= '<div class="clearfix"></div>';
				$htm .= '</div>';
				$htm .= '</div>';
				$htm .= '</div>';
				$htm .= '</li>';

				$n_arr[$db_id] = $htm;

				@$res->MoveNext();
				$do += 1;
			}
			
			if (count($t_arr) > 0) {
				foreach ($t_arr as $vk => $vv) {
					$html .= $n_arr[$vk];
				}
			}
			$html .= '</ul>';
			$html .= $db_count == 0 ? VGenerate::simpleDivWrap('left-float wdmax center all-paddings5 no-content', '', $language["files.text.no.responses"]) : NULL;
			$html .= $db_count > 0 ? '<div id="paging-bottom" class="left-float wdmax paging-top-border paging-bg">' . $paging_links . $results_text . '</div>' : NULL;
			$html .= VGenerate::simpleDivWrap('no-display', '', '<input type="hidden" name="section_subject_value" class="section_subject_value" value="' . $db_id . '" />');
			$html .= '</form>';
			$html .= '</div>';
		}
		
		return $html;
	}
	/* comment actions (when browsing comments/own files) */
	public static function ownCommentActions($action) {
		$db		= self::$db;
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_filter	= self::$filter;

		$err		= 0;
		$type		= self::$type;
		$c_key		= $class_filter->clr_str($_POST["section_subject_value"]);

		switch ($action) {
			case "comm-disable":
			case "comm-enable":
				$notice		= 1;
				$sql		= sprintf("UPDATE `db_%scomments` SET `c_approved`='%s' WHERE `c_key`='%s' LIMIT 1;", $type, ($action == 'comm-disable' ? 0 : 1), $c_key);
				break;
			case "comm-delete":
				$notice		= 1;
				$sql		= sprintf("DELETE FROM `db_%scomments` WHERE `c_key`='%s' LIMIT 1;", $type, $c_key);
				$rk		= $db->execute(sprintf("SELECT `file_key` FROM `db_%scomments` WHERE `c_key`='%s' LIMIT 1;", $type, $c_key));
				$ru		= $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_comments`=`file_comments`-1 WHERE `file_key`='%s' LIMIT 1;", $type, $rk->fields["file_key"]));
				break;
			case "cb-disable":
			case "cb-enable":
			case "cb-commdel":
				$notice = 1;
				if (is_array($_POST["entryid"]) and count($_POST["entryid"]) > 0) {
					foreach ($_POST["entryid"] as $k => $v) {
						$v = $class_filter->clr_str($v);
						if ($action == 'cb-commdel') {
							$rk = $db->execute(sprintf("SELECT `file_key` FROM `db_%scomments` WHERE `c_key`='%s' LIMIT 1;", $type, $v));
							$ru = $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_comments`=`file_comments`-1 WHERE `file_key`='%s' LIMIT 1;", $type, $rk->fields["file_key"]));
						}
						$q .= "`c_key`='" . $v . "' OR ";
					}
					$q = substr($q, 0, -4);
				} else {
					$err = 1;
				}
				$sql = $action != 'cb-commdel' ? sprintf("UPDATE `db_%scomments` SET `c_approved`='%s' WHERE (%s);", $type, ($action == 'cb-disable' ? 0 : 1), $q) : sprintf("DELETE FROM `db_%scomments` WHERE (%s);", $type, $q);
				break;
		}
		$res = $db->execute($sql);
		$upd = $db->Affected_Rows();

		if ($upd > 0) {
			if ($cfg["activity_logging"] == 1) {
				if ($action == 'comm-enable' or $action == 'cb-enable') {
					$dbu = $db->execute("UPDATE `db_useractivity` SET `act_deleted`='0' WHERE `act_type` LIKE '%" . $c_key . "%';");
				} else {
					$dbu = $db->execute("UPDATE `db_useractivity` SET `act_deleted`='1' WHERE `act_type` LIKE '%" . $c_key . "%';");
				}
			}
		}
		if ($upd > 0 and $notice == 1) {
			echo $html = VGenerate::noticeWrap(array('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"])));
			echo $js = VGenerate::declareJS('$("#cb-response-wrap").insertBefore("#gen-file-actions");');
		} else {
			if ($err == 1)
				echo $html = VGenerate::noticeWrap(array('', '', VGenerate::noticeTpl('', $language["notif.no.multiple.select"], '')));
			
			echo $js = VGenerate::declareJS('$("#cb-response-wrap").insertBefore("#gen-file-actions");');
		}
	}
	/* response actions (when browsing responses/own files) */
	public static function ownResponseActions($action) {
		$db		= self::$db;
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_filter	= self::$filter;

		$err		= 0;
		$upd		= 0;
		$type		= self::$type;
		$c_key		= $class_filter->clr_str($_POST["section_subject_value"]);

		switch ($action) {
			case "resp-disable":
			case "resp-enable":
			case "resp-delete":
				$notice	= 1;
				$update = $db->execute(self::updateResponseArray($type, $c_key, $action));
				$upd	+= 1;
				break;
			case "cb-rdisable":
			case "cb-renable":
			case "cb-rdel":
				$notice = 1;
				if (is_array($_POST["entryid"]) and count($_POST["entryid"]) > 0) {
					foreach ($_POST["entryid"] as $k => $v) {
						$v = $class_filter->clr_str($v);
						$update = $db->execute(self::updateResponseArray($type, $v, $action));
						if ($db->Affected_Rows() > 0) {
							$notice += 1;
							$upd	+= 1;
						}
					}
				} else {
					$err = 1;
				}
				break;
		}

		if ($upd > 0 and $notice > 0) {
			echo $html = VGenerate::noticeWrap(array('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"])));
			echo $js = VGenerate::declareJS('$("#cb-response-wrap").insertBefore("#gen-file-actions");');
		} else {
			if ($err == 1)
				echo $html = VGenerate::noticeWrap(array('', '', VGenerate::noticeTpl('', $language["notif.no.multiple.select"], '')));
			
			echo $js = VGenerate::declareJS('$("#cb-response-wrap").insertBefore("#gen-file-actions");');
		}
	}
	/* comments and responses top section */
	public static function CR_tophtml($for = 'comments') {
		$type		= self::$type;
		$_s		= VHref::currentSection();

		if ($_s) {
			if ($_s == 'file-menu-entry7' and self::$cfg['file_comments'] == 1) {
				$text	 = str_replace('##TYPE##', self::$language['frontend.global.'.self::$type[0].'.c'], self::$language['files.menu.type.comm']);
				$rep	 = self::$language["files.menu.type.comm"];
				
				$menu_li = '<li class="count file-action" id="cb-enable"><a href="javascript:;">' . self::$language["contacts.invites.approve"] . '</a></li>';
				$menu_li.= '<li class="count file-action" id="cb-disable"><a href="javascript:;">' . self::$language["contacts.comments.approve"] . '</a></li>';
				$menu_li.= '<li class="count file-action" id="cb-commdel"><a href="javascript:;">' . self::$language["frontend.global.delete.sel"] . '</a></li>';
			}
			if ($_s == 'file-menu-entry8' and self::$cfg['file_responses'] == 1) {
				$text	 = str_replace('##TYPE##', self::$language['frontend.global.'.self::$type[0].'.c'], self::$language['files.menu.type.resp']);
				$rep	 = self::$language["files.menu.type.resp"];
				
				$menu_li = '<li class="count file-action" id="cb-renable"><a href="javascript:;">' . self::$language["contacts.invites.approve"] . '</a></li>';
				$menu_li.= '<li class="count file-action" id="cb-rdisable"><a href="javascript:;">' . self::$language["contacts.comments.approve"] . '</a></li>';
				$menu_li.= '<li class="count file-action" id="cb-rcommdel"><a href="javascript:;">' . self::$language["frontend.global.delete.sel"] . '</a></li>';
			}
		} else
			return;
		
		
		$html = '
                                    <div id="view-type-content" class="'.($_s == 'file-menu-entry7' ? 'ct-comment' : 'ct-response').'">
                                        <article>
                                            <h3 class="content-title no-display1">
                                            	<i class="icon-'.($type == 'doc' ? 'file' : ($type == 'blog' ? 'pencil2' : $type)).'"></i>' . $text . '
                                            </h3>
                                            <div class="clearfix"></div>
                                            <div class="line nlb top"></div>
                                            <section class="filter" style="float:left">
                                                <div class="promo loadmask-img pull-left"></div>
                                                <div class="btn-group viewType pull-right">
                                                    ' . (self::$cfg["video_module"] == 1 ? '<button type="button" id="view-mode-video" class="viewType_btn viewType_btn-default view-mode-type video'.((self::$type == 'video' or self::$type == '') ? ' active' : null).'" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.v.c"], $rep).'"><span><i class="icon-video"></i>'.str_replace('##TYPE##', self::$language["frontend.global.v.c"], $rep).'</span></button>' : null) . '
                                                    ' . (self::$cfg["live_module"] == 1 ? '<button type="button" id="view-mode-live" class="viewType_btn viewType_btn-default view-mode-type live'.(self::$type == 'live' ? ' active' : null).'" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.l.c"], $rep).'"><span><i class="icon-live"></i>'.str_replace('##TYPE##', self::$language["frontend.global.l.c"], $rep).'</span></button>' : null) . '
                                                    ' . (self::$cfg["image_module"] == 1 ? '<button type="button" id="view-mode-image" class="viewType_btn viewType_btn-default view-mode-type image'.(self::$type == 'image' ? ' active' : null).'" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.i.c"], $rep).'"><span><i class="icon-image"></i>'.str_replace('##TYPE##', self::$language["frontend.global.i.c"], $rep).'</span></button>' : null) . '
                                                    ' . (self::$cfg["audio_module"] == 1 ? '<button type="button" id="view-mode-audio" class="viewType_btn viewType_btn-default view-mode-type audio'.(self::$type == 'audio' ? ' active' : null).'" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.a.c"], $rep).'"><span><i class="icon-audio"></i>'.str_replace('##TYPE##', self::$language["frontend.global.a.c"], $rep).'</span></button>' : null) . '
                                                    ' . (self::$cfg["document_module"] == 1 ? '<button type="button" id="view-mode-doc" class="viewType_btn viewType_btn-default view-mode-type doc'.(self::$type == 'doc' ? ' active' : null).'" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.d.c"], $rep).'"><span><i class="icon-file"></i>'.str_replace('##TYPE##', self::$language["frontend.global.d.c"], $rep).'</span></button>' : null) . '
						    ' . (self::$cfg["blog_module"] == 1 ? '<button type="button" id="view-mode-blog" class="viewType_btn viewType_btn-default view-mode-type blog'.(self::$type == 'blog' ? ' active' : null).'" rel="tooltip" title="'.str_replace('##TYPE##', self::$language["frontend.global.b.c"], $rep).'"><span><i class="icon-pencil2"></i>'.str_replace('##TYPE##', self::$language["frontend.global.b.c"], $rep).'</span></button>' : null) . '
                                                </div>
                                            </section>
                                        </article>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="line nlb bottom"></div>
                ';
		
		$_do	= (isset($_GET["do"]) and ($_GET["a"] != 'cr-approved' and $_GET["a"] != 'cr-suspended' and $_GET["a"] != 'cr-today')) ? self::$filter->clr_str($_GET["do"]) : ((isset($_GET["a"]) and ($_GET["a"] == 'cr-approved' or $_GET["a"] == 'cr-suspended' or $_GET["a"] == 'cr-today')) ? self::$filter->clr_str($_GET["a"]) : null);
		
		$html	.= '
				<div class="tabs tabs-style-topline list-cr-tabs">
					<div class="content-wrap tpl-messages" id="main-content">
						<nav style="display:none">
							<ul class="cr-tabs">
								<li'.(($_do == 'cr-approved' or $_do == '') ? ' class="tab-current"' : null).'><a href="#section-approved-'.$type.'-'.$for.'" class="icon icon-check" rel="nofollow"><span>'.self::$language["files.text.ct.sort.approved"].'</span></a></li>
								<li'.($_do == 'cr-suspended' ? ' class="tab-current"' : null).'><a href="#section-suspended-'.$type.'-'.$for.'" class="icon icon-pause" rel="nofollow"><span>'.self::$language["files.text.ct.sort.suspended"].'</span></a></li>
								<li'.($_do == 'cr-today' ? ' class="tab-current"' : null).'><a href="#section-today-'.$type.'-'.$for.'" class="icon icon-clock-o" rel="nofollow"><span>'.self::$language["files.text.ct.sort.today"].'</span></a></li>
							</ul>
						</nav>
						<div class="sort-by">
							<div class="place-left lsp">'.self::$language["files.menu.sort.by"].'</div>
							<div class="place-left">:</div>
							<div class="place-left mp-sort-options">
							<ul class="cr-tabs2 mp-sort-by">
								<li'.(($_do == 'cr-approved' or $_do == '') ? ' class="tab-current"' : null).'><a href="#section-approved-'.$type.'-'.$for.'" class="icon icon-check" rel="nofollow"><span>'.self::$language["files.text.ct.sort.approved"].'</span></a></li>
								<li'.($_do == 'cr-suspended' ? ' class="tab-current"' : null).'><a href="#section-suspended-'.$type.'-'.$for.'" class="icon icon-pause" rel="nofollow"><span>'.self::$language["files.text.ct.sort.suspended"].'</span></a></li>
								<li'.($_do == 'cr-today' ? ' class="tab-current"' : null).'><a href="#section-today-'.$type.'-'.$for.'" class="icon icon-clock-o" rel="nofollow"><span>'.self::$language["files.text.ct.sort.today"].'</span></a></li>
							</ul>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="line"></div>
			';
		
		$html	.= '
				<div class="section-top-bar">
					<div class="sortings">'.self::$smarty->fetch("tpl_backend/tpl_settings/ct-save-top.tpl").'</div>
					<div class="page-actions">'.self::$smarty->fetch("tpl_backend/tpl_settings/ct-save-open-close.tpl").'</div>
					<div class="clearfix"></div>
				</div>
			';
		
		$html	.= self::CR_sectioncontent($for, $_do);
		
		$html	.= '		</div>';
		$html	.= '	</div>';
		
		
		
		$html	.=	self::$smarty->fetch("tpl_backend/tpl_settings/ct-switch-js.tpl").'
				'.self::$smarty->fetch("tpl_backend/tpl_settings/ct-actions-js.tpl").'
				<script type="text/javascript">'.self::$smarty->fetch("f_scripts/be/js/settings-accordion.js").'</script>
			';
		
		$html	.= '
				<script type="text/javascript">
					$(document).ready(function () {
						$(".icheck-box input").each(function () {
							var self = $(this);
							self.iCheck({
								checkboxClass: "icheckbox_square-blue",
								radioClass: "iradio_square-blue",
								increaseArea: "20%"
								//insert: \'<div class="icheck_line-icon"></div><label>\' + label_text + \'</label>\'
							});
						});
						
						//$(".icheck-box input").on("ifChecked", function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop("checked", true); });
						//$(".icheck-box input").on("ifUnchecked", function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop("checked", false); });

						$(".icheck-box input.list-check").on("ifChecked", function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop("checked", true); });
						$(".icheck-box input.list-check").on("ifUnchecked", function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop("checked", false); });
						
						$("#check-all").on("ifChecked", function(event){ $(".icheck-box.ct input").iCheck("check"); });
						$("#check-all").on("ifUnchecked", function(event){ $(".icheck-box.ct input").iCheck("uncheck"); });
					});

					jQuery(document).ready(function(){$(".list-cr-tabs .mp-sort-by li.tab-current").each(function(){var t=$(this);$(".cr-tabs2.mp-sort-by").prepend(t.find("a").parent());});});
					</script>
			';
/*
		$html .= empty($_POST) ? '<script type="text/javascript">
			jQuery(document).on({
                                  click: function(event) {
                                        event.preventDefault();
                                        event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);
                                        var _t = $(this);
                                        var t=_t.parent();
                                        var f=0;
                                        var h=_t.find("a").attr("href").replace("#section-", "");
                                        //var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");

                                        $(".list-cr-tabs .mp-sort-by li").each(function(){
                                                var tt=$(this);
                                                if(tt.hasClass("iss")) {
                                                        f+=1;
                                                }
                                        });
                                        if (f == 0) {
                                                t.addClass("issm");
                                                $("body").addClass("hissm");
                                                t.find("li").addClass("iss").stop().slideDown("fast");
                                        } else {
                                                t.find("li").removeClass("iss").stop().slideUp("fast");
                                                t.removeClass("issm");
                                                $("body").removeClass("hissm");
                                                $(".loadmask, .loadmask-msg").detach();
     
                                                t.find("li:first-of-type").stop().slideDown(10, function(){
                                                        var tc=$("#main-content li.tab-current a").attr("href").replace("#section-", "");

                                                        if (h !== tc) {
                                                        	$(".list-cr-tabs section").removeClass("content-current");
                                                        	$("#section-"+h).addClass("content-current");

                                                                //$("#main-content.content-wrap>nav").find("a[href=#section-"+h+"]").parent().click();
                                                        }
                                                });

                                                $(".list-cr-tabs .mp-sort-by").each(function(){
                                                        var t=$(this);
                                                        t.prepend(t.find("a[href=#section-"+h+"]").parent());
                                                });
                                        }
                                }}, ".list-cr-tabs-off .mp-sort-by li");

                                jQuery(document).on({
                                  click: function(event) {
                                        //var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");
                                        var t = $(".list-cr-tabs .mp-sort-by");
                                        //var t = $("#"+vm+"-content .content-current .mp-sort-by");

                                        t.find("li").removeClass("iss").stop().slideUp("fast");
                                        t.removeClass("issm");
                                        $("body").removeClass("hissm");
                                        t.find("li:first-of-type").stop().slideDown(10);
                                }}, "body-off.hissm");

                         </script>
' : null;
*/
		return $html;
    }
	/* content filler for comments and responses */
	private static function CR_sectioncontent($for, $filter) {
		$type	 = self::$type;
		$list	 = $for == 'comments' ? self::fileComments() : self::fileResponses();
		
		$ht	= '            
                                                <div class="row mview" id="main-view-mode-approved-' . $type . '-' . $for . '-list" style="display: '.(($filter == '' or $filter == 'cr-approved') ? 'block' : 'none').';">
							' . (($filter == '' or $filter == 'cr-approved') ? $list : null). '
                                                </div>
						<div class="row mview" id="main-view-mode-suspended-' . $type . '-' . $for . '-list" style="display: '.($filter == 'cr-suspended' ? 'block' : 'none').';">
							' . ($filter == 'cr-suspended' ? $list : null). '
                                                </div>
						<div class="row mview" id="main-view-mode-today-' . $type . '-' . $for . '-list" style="display: '.($filter == 'cr-today' ? 'block' : 'none').';">
							' . ($filter == 'cr-today' ? $list : null). '
                                                </div>
                                        
			';
		
		$html	= '             <section id="section-approved-' . $type . '-' . $for . '"'.(($filter == '' or $filter == 'cr-approved') ? ' class="content-current"' : null).'>'.(($filter == '' or $filter == 'cr-approved') ? $ht : null).'</section>
					<section id="section-suspended-' . $type . '-' . $for . '"'.($filter == 'cr-suspended' ? ' class="content-current"' : null).'>'.($filter == 'cr-suspended' ? $ht : null).'</section>
					<section id="section-today-' . $type . '-' . $for . '"'.($filter == 'cr-today' ? ' class="content-current"' : null).'>'.($filter == 'cr-today' ? $ht : null).'</section>
			';

		return $html;
	}
	/* get contacts when sharing playlists */
	private static function plShare_listContacts() {
		$db	 = self::$db;

		$ct_rs	 = $db->execute(sprintf("SELECT `ct_username`, `ct_email` FROM `db_usercontacts` WHERE `usr_id`='%s' AND `ct_blocked`='0' AND `ct_active`='1';", self::getUserID()));
		
		if ($ct_rs) {
			while (!$ct_rs->EOF) {
				$ct_mail = $ct_rs->fields["ct_email"];
				$ct_user = $ct_rs->fields["ct_username"];
				$html .= $ct_mail != '' ? '<div class="row top-padding5"><a href="javascript:;" class="add-contact" rel="' . $ct_mail . '"><i class="icon-envelope"></i> ' . $ct_mail . '</a></div>' : NULL;
				$html .= $ct_user != '' ? '<div class="row top-padding5"><a href="javascript:;" class="add-contact" rel="' . $ct_user . '"><i class="icon-user"></i> ' . $ct_user . '</a></div>' : NULL;
				
				@$ct_rs->MoveNext();
			}
		}

		$ht_js = 'var pl_to = ""; $(".add-contact").click(function(){pl_to = $("#share_pl_to").val(); var pl_added = pl_to.indexOf($(this).attr("rel")); if(pl_added == -1){ $("#share_pl_to").val($("#share_pl_to").val()+$(this).attr("rel")+","); } });';

		$html  = '<div class="left-float wdmax left-padding10">' . $html . '</div>';
		$html .= VGenerate::declareJS($ht_js);

		return $html;
	}

    /* playlist embed code */
    function playlistEmbedCode($type, $pl_key){
	$cfg	 = self::$cfg;
	$class_database = self::$dbc;

	$_w	 = 800;
	$_h	 = 480;

	$dbf     = unserialize($class_database->singleFieldValue('db_'.$type.'playlists', 'pl_files', 'pl_key', $pl_key));
        $file_key= $dbf[0];
	
	if($type == 'video' or $type == 'audio' or ($type == 'image' and $cfg["image_player"] == 'flow')){//embed code for video playlists and flowplayer image playlists, audio playlists
	    if(($type == 'video' and $cfg["video_player"] == 'flow') or ($type == 'image' and $cfg["image_player"] == 'flow') or ($type == 'audio' and $cfg["audio_player"] == 'flow')){
		$width	 = $_w;
		$height	 = $_h;
		$swf	 = $cfg["main_url"].'/f_modules/m_frontend/m_player/swf/flowplayer.swf';
		$cts	 = $cfg["main_url"].'/f_modules/m_frontend/m_player/swf/flowplayer.controls-tube.swf';
		$pl	 = $cfg["main_url"].'/'.$type.'_playlist?p='.$pl_key;
		$ec      = '<iframe id="playlist-embed-'.md5($pl_key).'" type="text/html" width="'.$width.'" height="'.$height.'" src="'.$cfg["main_url"].'/embed?p='.$pl_key.'&v='.$file_key.'" frameborder="0" allowfullscreen></iframe>';
		$ec	 = NULL;
	    } elseif((($type == 'video' or $type == 'live') and $cfg["video_player"] == 'jw') or ($type == 'audio' and $cfg["audio_player"] == 'jw')){//embed code for jw video and audio playlists
		$width	 = $_w;
		$height	 = $_h;
		$swf	 = $cfg["main_url"].'/f_modules/m_frontend/m_player/swf/jwplayer.swf';
		$pl	 = $cfg["main_url"].'/'.$type.'_playlist?p='.$pl_key;
		$ec      = '<iframe id="playlist-embed-'.md5($pl_key).'" type="text/html" width="'.$width.'" height="'.$height.'" src="'.$cfg["main_url"].'/embed?p='.$pl_key.'&'.$type[0].'='.$file_key.'" frameborder="0" allowfullscreen></iframe>';
	    }
	} elseif($type == 'image' and ($cfg["image_player"] == 'jq' or $cfg["image_player"] == 'jw')){//embed code for jw and jq image playlists
	    $width	 = $_w;
	    $height	 = $_h;
	    $swf	 = $cfg["main_url"].'/f_modules/m_frontend/m_player/swf/image_playlist.swf';
	    $pl		 = $cfg["main_url"].'/image_playlist?p='.$pl_key.'&transition=flash&shuffle=false&rotatetime=5';

	    $ec	 	 = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$width.'" height="'.$height.'" id="'.$type.'_playlist" name="'.$type.'_playlist">';
	    $ec		.= '<param name="movie" value="'.$swf.'" />';
	    $ec		.= '<!--[if !IE]>-->';
	    $ec		.= '<object type="application/x-shockwave-flash" data="'.$swf.'" width="'.$width.'" height="'.$height.'" id="'.$type.'_playlist" name="'.$type.'_playlist">';
	    $ec		.= '<param name="movie" value="'.$swf.'"/>';
	    $ec		.= '<!--<![endif]-->';
	    $ec		.= '<param name="allowfullscreen" value="true">';
	    $ec		.= '<param name="allowscriptaccess" value="always">';
	    $ec		.= '<param name="flashvars" value="file='.$pl.'">';
	    $ec		.= '<embed src="'.$swf.'" width="'.$width.'" height="'.$height.'" allowscriptaccess="always" allowfullscreen="true" flashvars="file='.$pl.'" />';
	    $ec		.= '<!--[if !IE]>-->';
	    $ec		.= '</object>';
	    $ec		.= '<!--<![endif]-->';
	    $ec		.= '</object>';
	}
	return $ec;
    }
    /* playlist setup tabs */
    function plCfgTabs(){
	$cfg		= self::$cfg;
	$db		= self::$db;
	$language	= self::$language;
	$class_filter	= self::$filter;

	$user_id	= self::getUserID();
	$db_tbl		= self::$type;
	$_s		= $class_filter->clr_str($_GET["s"]);
	$pl_id		= (int) substr($_s, 21);

	$sql		= sprintf("SELECT `pl_key`, `pl_name`, `pl_files`, `pl_descr`, `pl_tags`, `pl_privacy`, `pl_embed`, `pl_email`, `pl_social`, `pl_thumb`  FROM `db_%splaylists` WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, $user_id, $pl_id);
	$pl_db		= $db->execute($sql);
	/* playlist details */
	$edit	  = '<div id="playlist-tab-edit-option" class="form-margins">';
	$edit    .= '<form id="update-playlist-form" class="entry-form-class" method="post" action="">';
	$edit    .= '<div id="update-playlist-response" class=""></div>';
	$edit	 .= VGenerate::sigleInputEntry('text', '', '<label>'.$language["files.action.new.title"].'</label>', 'left-float', 'playlist_title', 'login-input', $pl_db->fields["pl_name"]);
	$edit	 .= VGenerate::sigleInputEntry('textarea-on', '', '<label>'.$language["files.action.new.descr"].'</label>', 'left-float', 'playlist_descr', 'ta-input', $pl_db->fields["pl_descr"]);
	$edit	 .= VGenerate::sigleInputEntry('text', '', '<label>'.$language["files.action.new.tags"].'</label>', 'left-float', 'playlist_tags', 'login-input', $pl_db->fields["pl_tags"]);
	$edit	 .= '<div class="row"><div class="">&nbsp;</div><div class="left-float">'.VGenerate::basicInput('button', 'playlist_details', 'save-entry-button button-grey search-button form-button playlist-update', '', 1, '<span>'.$language["frontend.global.savechanges"].'</span>').'</div></div>';
	$edit    .= '</form>';
	$edit	 .= '</div>';
	/* playlist privacy */
	$privacy  = '<div id="playlist-tab-privacy-option" class="form-margins">';
	$privacy .= '<form id="update-privacy-form" class="entry-form-class" method="post" action="">';
	$privacy .= '<div id="update-privacy-response" class=""></div>';
	$privacy .= '<div class="icheck-box">';
	$privacy .= '<input type="radio" class="file-set-input" value="public" name="option_privacy"'.($pl_db->fields["pl_privacy"] == 'public' ? ' checked="checked"' : NULL).'><label>'.$language["files.text.public"].'</label><br>';
	$privacy .= '<input type="radio" class="file-set-input" value="private" name="option_privacy"'.($pl_db->fields["pl_privacy"] == 'private' ? ' checked="checked"' : NULL).'><label>'.$language["files.text.private"].'</label><br>';
	$privacy .= '<input type="radio" class="file-set-input" value="personal" name="option_privacy"'.($pl_db->fields["pl_privacy"] == 'personal' ? ' checked="checked"' : NULL).'><label>'.$language["files.text.personal"].'</label>';
	$privacy .= '</div>';
	$privacy .= '<div class="row"><div class="">&nbsp;</div><div class="left-float">'.VGenerate::basicInput('button', 'playlist_privacy', 'save-entry-button button-grey search-button form-button playlist-privacy', '', 1, '<span>'.$language["frontend.global.savechanges"].'</span>').'</div></div>';
	$privacy .= '</form>';
	$privacy .= '</div>';
	/* share playlist */
	$share	  = '<div id="playlist-tab-share-option" class="form-margins">';
	$share   .= '<form id="embed-playlist-form" class="entry-form-class" method="post" action="">';
	$share	 .= '<div id="playlist-embed-response" class=""></div>';
	$share	 .= '<label>'.$language["files.text.pl.share.url"].'</label>';
	$share	 .= '<div class="row no-top-padding left-float wdmax"><input type="text" value="'.$cfg["main_url"].'/'.VHref::getKey("playlist").'?'.$db_tbl[0].'='.$pl_db->fields["pl_key"].'" class="login-input" name="playlist_url" readonly="readonly" onclick="this.focus();this.select();" /><div class="place-right right-margin10"><button value="1" type="button" rel="popuprel" class="save-entry-button button-grey search-button form-button playlist-page" id="btn-1-playlist_page" name="playlist_page" onclick="window.open(\''.$cfg["main_url"].'/'.VHref::getKey("playlist").'?'.$db_tbl[0].'='.$pl_db->fields["pl_key"].'\');"><span>'.$language["files.text.pl.share.page"].'</span></button></div></div>';
	$share	 .= '<div class="row bottom-border right-margin10 top-bottom-padding"></div>';
	if($db_tbl[0] != 'd' and $db_tbl[0] != 'b'){
		if ($cfg["video_player"] == 'jw'){
			$share	 .= '<label>'.$language["files.text.pl.share.emb1"].'</label>';
			$share	 .= '<div class="row no-top-padding left-float wdmax">';
			$share	 .= '<div class="left-float">'.sprintf('<input type="text" value=\'%s\' class="login-input" name="playlist_embed" readonly="readonly" onclick="this.focus();this.select();" />', self::playlistEmbedCode($db_tbl, $pl_db->fields["pl_key"])).'</div>';
			$share	 .= '</div>';
		}
	//$share	 .= '<div class="row icheck-box">';
	//$share	 .= '<input class="playlist-embed" type="checkbox" name="allow_playlist_embed" value="1"'.($pl_db->fields["pl_embed"] == 1 ? ' checked="checked"' : NULL).($cfg["video_player"] == 'flow' ? ' disabled="disabled"' : NULL).' />';
	//$share	 .= '<label>'.$language["files.text.pl.share.emb2"].'</label></div>';
	}
	$share	 .= '<div class="row icheck-box">';
	$share	 .= '<input class="playlist-email" type="checkbox" name="allow_playlist_email" value="1"'.($pl_db->fields["pl_email"] == 1 ? ' checked="checked"' : NULL).' />';
	$share	 .= '<label>'.$language["files.text.pl.share.email"].'</label></div>';
	
	$share	 .= '<div class="row icheck-box">';
	$share	 .= '<input class="playlist-social" type="checkbox" name="allow_playlist_social" value="1"'.($pl_db->fields["pl_social"] == 1 ? ' checked="checked"' : NULL).' />';
	$share	 .= '<label>'.$language["files.text.pl.share.social"].'</label></div>';
	$share	 .= '<div class="row"><div class="">&nbsp;</div><div class="left-float">'.VGenerate::basicInput('button', 'playlist_share', 'save-entry-button button-grey search-button form-button playlist-share', '', 1, '<span>'.$language["frontend.global.savechanges"].'</span>').'</div></div>';
	$share	 .= '</form>';
	$share	 .= '</div>';
	/* delete playlist */
	$delete	  = '<div id="playlist-tab-delete-option" class="form-margins">';
	$delete	 .= '<form id="delete-playlist-form" class="entry-form-class" method="post" action="">';
	$delete	 .= '<div id="playlist-delete-response" class=""></div>';
	$delete	 .= '<div class="row no-top-padding">'.$language["files.text.pl.del.txt1"].'<span class="pt bold"></span>?';
	$delete  .= VGenerate::declareJS('$(".pt").html($("#'.$_s.'>span.bold").html());');
	$delete	 .= '</div>';
	$delete	 .= '<div class="row">'.$language["files.text.pl.del.txt2"].'</div><br>';
	$delete	 .= '<div class="row">'.VGenerate::basicInput('button', 'playlist_delete', 'save-entry-button button-grey search-button form-button playlist-delete', '', 1, '<span>'.$language["files.text.pl.del.yes"].'</span>').'</div>';
	$delete	 .= '</form>';
	$delete	 .= '</div>';
	
	$p	  = $pl_db->fields["pl_files"];
	$pl	  = $p != '' ? unserialize($p) : null;
	
	/* playlist order */
	$order	  = '<div id="playlist-tab-order-option" class="form-margins">';
	$order   .= '<form id="update-order-form" class="entry-form-class" method="post" action="">';
	$order   .= '<div id="update-order-response" class=""></div>';
	if (is_array($pl)) {
		$o1	 = array();
		$o2	 = array();
		foreach ($pl as $k => $pl_key) {
			$o1[] = $pl_key;
			$o2[] = sprintf("'%s'", $pl_key);
		}

		$pl_sql	 = sprintf("SELECT 
					A.`file_key`, A.`thumb_server`, A.`file_title`, C.`usr_key`
					FROM 
					`db_%sfiles` A, `db_accountuser` C
					WHERE 
					A.`usr_id`=C.`usr_id` AND 
					A.`file_key` IN (%s) 
					ORDER BY FIND_IN_SET(A.`file_key`, '%s') 
					LIMIT %s;", $db_tbl, implode(',', $o2), implode(',', $o1), count($pl));
					
		
		$rs	 = $db->execute($pl_sql);
		
		if ($rs->fields["file_key"]) {
			$k	 = 1;
			$thumbs	 = array();
			
			$order	.= '<ol class="vertical">';
			while (!$rs->EOF) {
				$thumbs[]= self::thumbnail($rs->fields["usr_key"], $rs->fields["file_key"], $rs->fields["thumb_server"], false);
				$order	.= '<li><input type="hidden" name="pl_order[]" value="'.$rs->fields["file_key"].'"><i class="icon-numbered-list"></i> '.$rs->fields["file_title"].'</li>';
				
				$rs->MoveNext();
				$k += 1;
			}
			$order	.= '</ol>';
		}
	}
	$order	 .= '<div class="row"><div class="">&nbsp;</div><div class="">'.VGenerate::basicInput('button', 'playlist_order', 'save-entry-button button-grey search-button form-button playlist-order', '', 1, '<span>'.$language["frontend.global.savechanges"].'</span>').'</div></div>';
	$order	 .= '</form>';
	$order	 .= '</div>';
	/* playlist thumb */
	$thumb	  = '<div id="playlist-tab-thumb-option" class="form-margins">';
	$thumb   .= '<form id="playlist-thumb-form" class="entry-form-class" method="post" action="">';
	$thumb   .= '<div id="playlist-thumb-response" class=""></div>';
	if ($thumbs[0] != '') {
		$thumb .= '<ul class="pl-thumb">';
		foreach ($thumbs as $i => $tmb) {
			$img = str_replace($cfg["main_url"], $cfg["main_dir"], $tmb);
			$thumb .= file_exists($img) ? '<li rel-key="'.$o1[$i].'"><div class="thumbs-wrapper'.($pl_db->fields["pl_thumb"] == $o1[$i] ? ' thumb-selected' : null).'"><img class="" height="97" src="' . $tmb . '" alt="' . self::$language["frontend.global.loading"] . '"></div></li>' : null;
		}
		$thumb .= '</ul>';
	}
	$thumb	 .= '<div class="clearfix"><div class="">&nbsp;</div><div class="left-float">'.VGenerate::basicInput('button', 'playlist_thumb', 'save-entry-button button-grey search-button form-button playlist-thumb', '', 1, '<span>'.$language["frontend.global.savechanges"].'</span>').'</div></div>';
	$thumb	 .= '<div><input type="hidden" id="new-thumb" name="new_thumb" value="'.$pl_db->fields["pl_thumb"].'"></div>';
	$thumb   .= '</form>';
	$thumb	 .= '</div>';
	
	
	
	$ht_js	  = '(function() {[].slice.call(document.querySelectorAll(".tabs.pltabs")).forEach(function (el) {new CBPFWTabs(el);});})();';
	
	$ht_js	 .= '$(function() { $("ol.vertical").sortable(); });';
	
	$ht_js	 .= '$(".icheck-box input").each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: "icheckbox_square-blue",
                                radioClass: "iradio_square-blue",
                                increaseArea: "20%"
			    });
			});
	';
	
	$ht_js	 .= '$("#section-pl-thumb li").click(function(){
				t = $(this);
				if (t.hasClass("thumb-selected")) {
					return;
				}
				t.parent().find(".thumb-selected").removeClass("thumb-selected");
				t.addClass("thumb-selected");
				$("#new-thumb").val(t.attr("rel-key"));
			});';
	$ht_js	 .= '$(".playlist-thumb").click(function(){
			$("#section-pl-thumb").mask(" ");
			$.post(current_url + menu_section + "?s='.$_s.'&m=1&for=sort-'.$db_tbl.'&a=update-thumb", $("#playlist-thumb-form").serialize(), function(data){
				$("#playlist-thumb-response").html(data);
				$("#section-pl-thumb").unmask();
			});
		     });';
	
	$ht_js	 .= 'enterSubmit("#update-playlist-form input", "#btn-1-playlist_details"); 
		     $(".playlist-update").click(function(){
			$("#section-pl-edit").mask(" ");
			$.post(current_url + menu_section + "?s='.$_s.'&m=1&for=sort-'.$db_tbl.'&a=update-pl", $("#update-playlist-form").serialize(), function(data){
				$("#update-playlist-response").html(data);
				$(".pt").text( $("input[name=\'playlist_title\']").val() );
				$("#section-pl-edit").unmask();
			});
		     });';
	
	$ht_js	 .= 'enterSubmit("#update-privacy-form input", "#btn-1-playlist_privacy"); 
		     $(".playlist-privacy").click(function(){
			$("#section-pl-privacy").mask(" ");
			$.post(current_url + menu_section + "?s='.$_s.'&m=1&for=sort-'.$db_tbl.'&a=update-privacy", $("#update-privacy-form").serialize(), function(data){
				$("#update-privacy-response").html(data);
				$("#section-pl-privacy").unmask();
			});
		     });';
	
	$ht_js	 .= 'enterSubmit("#update-share-form input", "#btn-1-playlist_share"); 
		     $(".playlist-share").click(function(){
			$("#section-pl-share").mask(" ");
			$.post(current_url + menu_section + "?s='.$_s.'&m=1&for=sort-'.$db_tbl.'&a=embed-pl", $("#embed-playlist-form").serialize(), function(data){
				$("#playlist-embed-response").html(data);
				$("#section-pl-share").unmask();
			});
		     });';
	
	$ht_js	 .= '$(".playlist-order").click(function(){
			$("#section-pl-order").mask(" ");
			$.post(current_url + menu_section + "?s='.$_s.'&m=1&for=sort-'.$db_tbl.'&a=update-order", $("#update-order-form").serialize(), function(data){
				$("#update-order-response").html(data);
				$("#section-pl-order").unmask();
			});
		     });';
	
	$ht_js	 .= '$(document).one("click", ".playlist-delete", function(){
			$("#section-pl-delete").mask(" ");
			$.post(current_url + menu_section + "?s='.$_s.'&m=1&for=sort-'.$db_tbl.'&a=delete-pl", $("#delete-playlist-form").serialize(), function(data){
				$("#playlist-delete-response").html(data);
				$("#section-pl-delete").unmask("");
				$(".fancybox-close").click();
			});
		     });';
	
	$html = '<div class="lb-margins">
			<article>
				<h3 id="ph" class="content-title"><script type="text/javascript">$(document).ready(function(){$("#ph").html(\'<i class="icon-list"></i>\' + $("#playlist-title").html())});</script></h3>
				<div class="line"></div>
			</article>

			<div class="tabs pltabs tabs-style-topline">
				<nav>
                                        <ul id="pl-tabs">
                                                '.('<li><a href="#section-pl-edit" class="icon icon-profile" rel="nofollow"><span>'.self::$language["files.text.pl.tab.edit"].'</span></a></li>').'
						'.('<li><a href="#section-pl-order" class="icon icon-numbered-list" rel="nofollow"><span>'.self::$language["files.menu.order"].'</span></a></li>').'
						'.('<li><a href="#section-pl-thumb" class="icon icon-thumbs" rel="nofollow"><span>'.self::$language["files.list.thumb"].'</span></a></li>').'
						'.('<li><a href="#section-pl-privacy" class="icon icon-key" rel="nofollow"><span>'.self::$language["files.text.pl.tab.privacy"].'</span></a></li>').'
						'.('<li><a href="#section-pl-share" class="icon icon-rss" rel="nofollow"><span>'.self::$language["files.text.pl.tab.share"].'</span></a></li>').'
						'.('<li><a href="#section-pl-delete" class="icon icon-times" rel="nofollow"><span>'.self::$language["files.text.pl.tab.delete"].'</span></a></li>').'
                                        </ul>
                                </nav>
				<div class="content-wrap">
					<section id="section-pl-edit">
						<div>'.$edit.'</div>
					</section>
					<section id="section-pl-order">
						<div>'.$order.'</div>
					</section>
					<section id="section-pl-thumb">
						<div>'.$thumb.'</div>
					</section>
					<section id="section-pl-privacy">
						<div>'.$privacy.'</div>
					</section>
					<section id="section-pl-share">
						<div>'.$share.'</div>
					</section>
					<section id="section-pl-delete">
						<div>'.$delete.'</div>
					</section>
				</div>
			</div>
		</div>
			';
	
	$html	 .= VGenerate::declareJS('$(document).ready(function(){'.$ht_js.'});');

	echo $html;
    }
	/* update playlist entries order */
	public static function plUpdateOrder() {
		$db		= self::$db;
		$language	= self::$language;
		$class_filter	= self::$filter;

		$for		= $class_filter->clr_str($_GET["for"]);
		$_s		= $class_filter->clr_str($_GET["s"]);
		
		$db_tbl		= substr($for, 5);
		$pl_id		= (int) substr($_s, 21);

		$list		= isset($_POST["pl_order"]) ? $_POST["pl_order"] : null;

		if (is_array($list)) {
			$clean = array_map ( array($class_filter, 'clr_str') , $list);

			$sql	= sprintf("UPDATE `db_%splaylists` SET `pl_files`='%s' WHERE `pl_id`='%s' LIMIT 1;", $db_tbl, serialize($list), $pl_id);
			
			$res	= $db->execute($sql);
			
			if ($db->Affected_Rows() > 0) {
				echo VGenerate::simpleDivWrap('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"]));
				exit;
			}
		}
	}
	/* update playlist entries order */
	public static function plUpdateThumbnail() {
		$db		= self::$db;
		$language	= self::$language;
		$class_filter	= self::$filter;

		$for		= $class_filter->clr_str($_GET["for"]);
		$_s		= $class_filter->clr_str($_GET["s"]);
		
		$db_tbl		= substr($for, 5);
		$pl_id		= (int) substr($_s, 21);

		$tmb		= isset($_POST["new_thumb"]) ? $class_filter->clr_str($_POST["new_thumb"]) : false;

		if ($tmb) {
			$sql	= sprintf("UPDATE `db_%splaylists` SET `pl_thumb`='%s' WHERE `pl_id`='%s' LIMIT 1;", $db_tbl, $tmb, $pl_id);
			
			$res	= $db->execute($sql);
			
			if ($db->Affected_Rows() > 0) {
				echo VGenerate::simpleDivWrap('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"]));
				exit;
			}
		}
	}

	/* email/share a file/playlist */
	function plMail() {
		$cfg		= self::$cfg;
		$db		= self::$db;
		$class_database = self::$dbc;
		$class_filter	= self::$filter;
		$language	= self::$language;
		$href		= self::$href;
		$section	= self::$section;

		$_to		= $section == $href["watch"] ? $_POST["file_share_mailto"] : $_POST["share_pl_to"];
		$send_to	= $_to != '' ? explode(",", $_to) : NULL;
		$clear_arr	= array();

		if ($send_to != '') {
			foreach ($send_to as $key => $val) {
				if ($val != '' and strpos($val, "@"))
					$clear_arr[$key] = $class_filter->clr_str($val);
				elseif ($val != '') {
					$user_id = VUserinfo::getUserID($class_filter->clr_str($val));
					if ($user_id > 0)
						$clear_arr[$key] = VUserinfo::getUserEmail($user_id);
				}
			}
		}

		if (empty($clear_arr)) {
			echo VGenerate::noticeTpl('', $language["notif.error.invalid.request"], '');
		} else {
			$mail_do = VNotify::queInit(($section == $href["watch"] ? 'file_share' : 'pl_share'), $clear_arr, '');

			if ($section == $href["watch"]) {
				echo VGenerate::noticeTpl('', '', $language["notif.success.request"]);
				echo VGenerate::declareJS('$(".file-share-mailto").val("");');
			}
		}
	}

	/* subscriptions */
	public static function userSubs($total = '') {
		$db		 = self::$db;
		$cfg		 = self::$cfg;
		$language	 = self::$language;
		$uid		 = (int) $_SESSION["USER_ID"];

		$usr_ids	 = array();
		$sub_ids	 = array();
		$follow_ids	 = array();

	if ($cfg["user_subscriptions"] == 1) {
		$ff		 = 0;
		$sql		 = sprintf("SELECT `db_id`, `usr_id` FROM `db_subscribers` WHERE `subscriber_id` != 'a:0:{}' AND `subscriber_id` LIKE '%s';", '%"sub_id";i:'.$uid.';%');
		$rs		 = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_user_files_subs_follows'], $sql) : self::$db->execute($sql);
		if (!$rs->fields["db_id"]) {
			$ff	 = 1;
			$sql	 = sprintf("SELECT `db_id`, `usr_id_to` FROM `db_subtemps` WHERE `usr_id`='%s' AND `pk_id`>'0' AND `active`='1';", $uid);
			$rs	 = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_user_files_subs_follows'], $sql) : self::$db->execute($sql);
		}
		/* my subscriptions */
		$html		 = '<div class="blue categories-container">';
		$html		.= '<h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-users5"></i>'.$language["files.menu.subscriptions"].'</h4>';
		$html		.= '<aside>';
		$html		.= '<nav>';
		$html		.= '<ul class="sort-nav-menu accordion" id="sub1-menu">';
		
		if ($rs->fields["db_id"]) {
			$sub_key = 'off';
			
			if (self::$subscription_section) {
				$uri	= self::$filter->clr_str($_SERVER["REQUEST_URI"]);
				$a	= explode("/", $uri);
				$t	= count($a);
				$sub_key= $a[$t-1];
			}
			while (!$rs->EOF) {
				$usr_id	= $ff ? $rs->fields["usr_id_to"] : $rs->fields["usr_id"];
				$usr_key= self::$dbc->singleFieldValue('db_accountuser', 'usr_key', 'usr_id', $usr_id);

				if (VUserinfo::getUserID($usr_id, 'usr_id') > 0) {
					if ($total == '') {
						$ui	 = VUserinfo::getUserInfo($usr_id);
						$count	 = $cfg["file_counts"] == 1 ? '&nbsp;<span class="right-float mm-count" id="subs-menu-entry' . $usr_id . '-count">' . self::subFileCounts(self::listFiles(1, $usr_id)) . '</span>' : NULL;
						$html	.= '<li class="menu-panel-entry'.($sub_key == $usr_key ? ' menu-panel-entry-active' : null).'" rel-m="'.VHref::getKey('subscriptions').'" rel-usr="'.$usr_key.'" id="subs-menu-entry' . $usr_id . '">';
						$html	.= '<a href="javascript:;" class="'.($sub_key == $usr_key ? 'dcjq-parent active' : null).'">';
						$html	.= '<img src="'.VUseraccount::getProfileImage($usr_id).'" height="24">';
						$html	.= '<span class="mm">';
						$html	.= ($ui['dname'] != '' ? $ui['dname'] : ($ui['ch_title'] != '' ? $ui['ch_title'] : $ui['uname']));
						$html	.= VAffiliate::getAffiliateBadge($usr_key);
						$html	.= '</span>';
						$html	.= '</a>';
						$html	.= $count;
						$html	.= '</li>';

						$usr_ids[] = $usr_id;
						$sub_ids[] = $usr_id;
					} else {
						$js	.= '$("#subs-menu-entry' . $usr_id . '-count").html("' . self::subFileCounts(self::listFiles(1, $usr_id)) . '");';
						$js	.= '$("#osub-menu-entry' . $usr_id . '-count").html("' . self::subFileCounts(self::listFiles(1, $usr_id)) . '");';
						$js	.= '$("#fsub-menu-entry' . $usr_id . '-count").html("' . self::subFileCounts(self::listFiles(1, $usr_id)) . '");';
					}
				}
				
				@$rs->MoveNext();
			}
			if (!isset($sub_ids[0])) {
				$html	.= '<li id="subs-menu-entry0"><a href="javascript:;"><span><center>'.$language["files.text.no.subscription"].'</center></span></a></li>';
			}
//			echo $ht = '</ul><br />';

			if ($total == 1 and $js != '') {
				return $js;
			}
		} else {
			$html	.= '<li id="subs-menu-entry0"><a href="javascript:;"><span><center>'.$language["files.text.no.subscription"].'</center></span></a></li>';
		}
		$html		.= '</ul>';
		$html		.= '</nav>';
		$html		.= '</aside>';
		$html		.= '</div>';
	}

	if ($cfg["user_follows"] == 1) {
		$sql		 = sprintf("SELECT `db_id`, `usr_id` FROM `db_followers` WHERE `follower_id` != 'a:0:{}' AND `follower_id` LIKE '%s';", '%"sub_id";i:'.$uid.';%');
		$rs		 = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_user_files_subs_follows'], $sql) : self::$db->execute($sql);

		$html		.= '<div class="blue categories-container">';
		$html		.= '<h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-users5"></i>'.$language["files.menu.follows"].'</h4>';
		$html		.= '<aside>';
		$html		.= '<nav>';
		$html		.= '<ul class="sort-nav-menu accordion" id="sub2-menu">';

		if ($rs->fields["db_id"]) {
			$sub_key = 'off';

			if (self::$subscription_section) {
				$uri	= self::$filter->clr_str($_SERVER["REQUEST_URI"]);
				$a	= explode("/", $uri);
				$t	= count($a);
				$sub_key= $a[$t-1];
			}
			while (!$rs->EOF) {
				$usr_id	= $rs->fields["usr_id"];
				$usr_key= self::$dbc->singleFieldValue('db_accountuser', 'usr_key', 'usr_id', $usr_id);

				if (VUserinfo::getUserID($usr_id, 'usr_id') > 0 and !in_array($rs->fields["usr_id"], $usr_ids)) {
					if ($total == '') {
						$ui	 = VUserinfo::getUserInfo($usr_id);
						$count	 = $cfg["file_counts"] == 1 ? '&nbsp;<span class="right-float mm-count" id="fsub-menu-entry' . $usr_id . '-count">' . self::subFileCounts(self::listFiles(1, $usr_id)) . '</span>' : NULL;
						$html	.= '<li class="menu-panel-entry'.($sub_key == $usr_key ? ' menu-panel-entry-active' : null).'" rel-m="'.VHref::getKey('following').'" rel-usr="'.$usr_key.'" id="fsub-menu-entry' . $usr_id . '">';
						$html	.= '<a href="javascript:;" class="'.($sub_key == $usr_key ? 'dcjq-parent active' : null).'">';
						$html	.= '<img src="'.VUseraccount::getProfileImage($usr_id).'" height="24">';
						$html	.= '<span class="mm">';
						$html	.= ($ui['dname'] != '' ? $ui['dname'] : ($ui['ch_title'] != '' ? $ui['ch_title'] : $ui['uname']));
						$html	.= VAffiliate::getAffiliateBadge($usr_key);
						$html	.= '</span>';
						$html	.= '</a>';
						$html	.= $count;
						$html	.= '</li>';

						$usr_ids[] = $usr_id;
						$follow_ids[] = $usr_id;
					} else {
						$js	.= '$("#subs-menu-entry' . $usr_id . '-count").html("' . self::subFileCounts(self::listFiles(1, $usr_id)) . '");';
						$js	.= '$("#osub-menu-entry' . $usr_id . '-count").html("' . self::subFileCounts(self::listFiles(1, $usr_id)) . '");';
						$js	.= '$("#fsub-menu-entry' . $usr_id . '-count").html("' . self::subFileCounts(self::listFiles(1, $usr_id)) . '");';
					}
				}
				
				@$rs->MoveNext();
			}
			if (!isset($follow_ids[0])) {
				$html	.= '<li id="subs-menu-entry0"><a href="javascript:;"><span><center>'.$language["files.text.no.following"].'</center></span></a></li>';
			}
//			echo $ht = '</ul><br />';

			if ($total == 1 and $js != '') {
				return $js;
			}
		} else {
			$html	.= '<li id="subs-menu-entry0"><a href="javascript:;"><span><center>'.$language["files.text.no.following"].'</center></span></a></li>';
		}
		$html		.= '</ul>';
		$html		.= '</nav>';
		$html		.= '</aside>';
		$html		.= '</div>';
	}

//		$html	.= '</div>';

		if ($total == 2 and $js != '') {
			return $js;
		}
		
		return $html;
	}

	/* update privacy settings */
	function plUpdatePrivacy() {
		$db		= self::$db;
		$language	= self::$language;
		$class_filter	= self::$filter;
		
		$for		= $class_filter->clr_str($_GET["for"]);
		$_s		= $class_filter->clr_str($_GET["s"]);
		$db_tbl		= substr($for, 5);
		$pl_id		= (int) substr($_s, 21);

		$pl_priv	= $class_filter->clr_str($_POST["option_privacy"]);

		$query		= $db->execute(sprintf("UPDATE `db_%splaylists` SET `pl_privacy`='%s' WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, $pl_priv, self::getUserID(), $pl_id));

		if ($db->Affected_Rows() > 0) {
			echo VGenerate::simpleDivWrap('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"]));
			exit;
		}
	}

	/* update embed settings */
	function plUpdateEmbed() {
		$db		= self::$db;
		$language	= self::$language;
		$class_filter	= self::$filter;
		
		$for		= $class_filter->clr_str($_GET["for"]);
		$_s		= $class_filter->clr_str($_GET["s"]);
		$db_tbl		= substr($for, 5);
		$pl_id		= (int) substr($_s, 21);
		
		$pl_embed	= (int) $_POST["allow_playlist_embed"];
		$pl_email	= (int) $_POST["allow_playlist_email"];
		$pl_social	= (int) $_POST["allow_playlist_social"];

		$query = $db->execute(sprintf("UPDATE `db_%splaylists` SET `pl_embed`='%s', `pl_email`='%s', `pl_social`='%s' WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, $pl_embed, $pl_email, $pl_social, self::getUserID(), $pl_id));

		if ($db->Affected_Rows() > 0) {
			echo VGenerate::simpleDivWrap('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"]));
			exit;
		}
	}

	/* saving playlist details */
	function plUpdate() {
		$db		= self::$db;
		$language	= self::$language;
		$class_filter	= self::$filter;
		
		$for		= $class_filter->clr_str($_GET["for"]);
		$_s		= $class_filter->clr_str($_GET["s"]);

		$pl_array = array(
			"pl_name"	=> $class_filter->clr_str($_POST["playlist_title"]),
			"pl_descr"	=> $class_filter->clr_str($_POST["playlist_descr"]),
			"pl_tags"	=> $class_filter->clr_str($_POST["playlist_tags"])
		);
		
		$db_tbl = substr($for, 5);
		$pl_id	= (int) substr($_s, 21);

		if ($pl_array["pl_name"] == '') {
			echo VGenerate::simpleDivWrap('', '', VGenerate::noticeTpl('', $language["files.text.pl.details.err"], ''));
			exit;
		}

		foreach ($pl_array as $dbf => $val) {
			$q .= "`" . $dbf . "` = '" . $val . "', ";
		}
		
		$query = sprintf("UPDATE `db_%splaylists` SET %s WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, substr($q, 0, -2), self::getUserID(), $pl_id);
		$pl_db = $db->execute($query);
		
		if ($db->Affected_Rows() > 0) {
			echo VGenerate::declareJS('$("#' . $_s . '>span.normal").html("' . $pl_array["pl_name"] . '"); $(".cb-label-add, .cb-label-clear").html("' . $pl_array["pl_name"] . '");');
			echo VGenerate::simpleDivWrap('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"]));
			exit;
		}
	}

	/* deleting a playlist */
	function plDelete() {
		$db		= self::$db;
		$class_filter	= self::$filter;
		$language	= self::$language;
		
		$for		= $class_filter->clr_str($_GET["for"]);
		$_s		= $class_filter->clr_str($_GET["s"]);
		
		$db_tbl		= substr($for, 5);
		$pl_id		= (int) substr($_s, 21);

		$db_sql		= $db->execute(sprintf("DELETE FROM `db_%splaylists` WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, self::getUserID(), $pl_id));

		if ($db->Affected_Rows() > 0) {
			$ht_js = '$("#file-menu-entry6-sub' . $db_tbl[0] . $pl_id . '").detach(); $("#file-menu-entry6.menu-panel-entry").click();';

			echo VGenerate::declareJS('$(document).ready(function(){' . $ht_js . '});');
			echo VGenerate::simpleDivWrap('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"]));
			exit;
		}
	}

    /* create new playlists */
    function plAddNew(){
	$class_database = self::$dbc;
	$class_filter	= self::$filter;
	$smarty		= self::$smarty;
	$language	= self::$language;
	$db		= self::$db;
	
	$error		= false;
	
	$pl_title	= $class_filter->clr_str($_POST["add_new_title"]);
	$pl_descr	= $class_filter->clr_str($_POST["add_new_descr"]);
	$pl_tags	= $class_filter->clr_str($_POST["add_new_tags"]);
	$pl_date	= date("Y-m-d H:i:s");
	
	if ($pl_title == '') {
		$error = $language["notif.error.required.field"].$language["files.action.new.title"];
	} else if ($pl_tags == '') {
		$error = $language["notif.error.required.field"].$language["files.action.new.tags"];
	}
	
	if ($error) {
		echo VGenerate::noticeTpl('', $error, '');
	}
	
	if (!$error) {
		$pl_array	= array("usr_id"	=> self::getUserID(),
					"pl_key"	=> strtoupper(VUserinfo::generateRandomString(10)),
					"pl_name"	=> $pl_title,
					"pl_descr"	=> $pl_descr,
					"pl_tags"	=> $pl_tags,
					"pl_date"	=> $pl_date
					);
		$post_type	= $class_filter->clr_str($_POST["add_new_type"]);

		$db_tbl		= 'db_'.($_GET["s"] == 'file-menu-entry6' ? $post_type : substr($_GET["for"], 5)).'playlists';

		if ($pl_array["pl_name"] == '') return false;

		$db_update	= $class_database->doInsert($db_tbl, $pl_array);
		$db_id		= $db->Insert_ID();

		if($db_id > 0){
			echo VGenerate::declareJS('$(document).ready(function(){$("#add-new-label-form").get(0).reset();});');
			echo VGenerate::noticeTpl('', '', $language["notif.success.request"]);
			echo '<form id="reload-form" method="post" action=""><div class="no-display"><input type="hidden" name="do_reload" value="1"><input type="submit" name="do_submit" value="1"></div></form>';
			
			$ht_js	= '$("#reload-form").submit();';
			echo VGenerate::declareJS('$(document).ready(function(){' . $ht_js . '});');
		}
	}
    }
    /* determine type if a playlist menu entry is clicked */
    function typeFromPlaylist(){
	$href		= self::$href;
	$section	= self::$section;

	if ($section == $href["browse"]) return false;

	$for		= explode("-", $_GET["s"]);

	if($for[2] == 'entry6') {
	    $db_field 	= 'pl_files';
	    $db_tbl	= 'playlists';
	    $pl_id	= substr($for[3], 3);
	    $pl_type	= $pl_id[0];
	    $pl_id	= substr($pl_id, 1);
	    $pl_q	= sprintf("AND `pl_id`='%s'", $pl_id);
	    
	    switch($pl_type){
                case "l": $type = 'live'; break;
                case "v": $type = 'video'; break;
                case "i": $type = 'image'; break;
                case "a": $type = 'audio'; break;
                case "d": $type = 'doc'; break;
		case "b": $type = 'blog'; break;
            }

	    return array($type, $db_field, $db_tbl, $pl_id, $pl_q);
	} else return false;
    }
	/* list available media files */
        private static function listPlaylistMedia($entries, $user_watchlist, $type = false, $hidden = false) {
		$href		= self::$href;
		$section	= self::$section;
		
		$type 		= !$type ? self::$type : $type;
		$category       = isset($entries->fields["ct_name"]) ? $entries->fields["ct_name"] : false;
		$title_category = $category ? ' <i class="iconBe-chevron-right"></i> '.$category : null;
		$content	= $entries->fields["pl_id"] ? self::listPlaylistMedia_content($type, $entries) : VGenerate::simpleDivWrap('no-content', '', self::$language["frontend.global.results.none"]);
		$default_section= (isset($_SESSION["q"]) and $_SESSION["q"] != '') ? 'relevance' : 'plpublic';

		switch ($section) {
				case $href["playlists"]:
				case $href["channel"]:
				case $href["search"]:
					$hide	 = true;
					
					break;
				
				default:
					$hide	 = false;
					
					break;
				
		}
		$html   =	'<div id="' . $type . '-content"' . ($hidden ? ' style="display: none;"' : null) .'>
						' . self::pl_tabs($type) . '

						<div class="content-wrap">
						    <section id="section-'.$default_section.'-' . $type . '">
							<article>
							    <h3 class="content-title no-display"><i class="'.($default_section == 'relevance' ? 'icon-search' : 'icon-clock-o').'"></i>'.($default_section == 'relevance' ? self::pl_typeLangReplace(self::$language["playlist.section.title.relevant"], $type) : self::pl_typeLangReplace((!$hide ? self::$language["playlist.section.title.public"] : self::$language["playlist.section.title.recent"]), $type)).'</h3>
							    <div class="sort-by">
							    	<div class="place-left lsp">Sort by</div>
							    	<div class="place-left">:</div>
							    	<div class="place-left mp-sort-options">
							    		'.self::pl_tabs($type, 1).'
							    	</div>
							    	<div class="clearfix"></div>
							    </div>
							    <section class="filter">
								<div class="main loadmask-img pull-left"></div>
								<div class="btn-group viewType pull-right vmtop">
								    <button type="button" id="main-view-mode-1-'.$default_section.'-' . $type . '" value="'.$default_section.'" class="viewType_btn viewType_btn-default vexc main-view-mode-' . $type . ' active" rel="tooltip" title="'.self::$language["files.menu.view2"].'"><span class="icon-thumbs"></span></button>
								    <button type="button" id="main-view-mode-2-'.$default_section.'-' . $type . '" value="'.$default_section.'" class="viewType_btn viewType_btn-default vexc main-view-mode-' . $type . '" rel="tooltip" title="'.self::$language["files.menu.view3"].'"><span class="icon-full-details"></span></button>
								</div>
							    </section>
							    <div class="line"></div>
							</article>
							'.VGenerate::advHTML(45).'
							<div class="row mview" id="main-view-mode-1-'.$default_section.'-' . $type . '-list">
							    ' . $content . '
							</div>

							<div class="row mview" id="main-view-mode-2-'.$default_section.'-' . $type . '-list" style="display: none">
							</div>

							<div class="row mview" id="main-view-mode-3-'.$default_section.'-' . $type . '-list" style="display: none;">
							</div>
							'.VGenerate::advHTML(46).'
						    </section>

						    ' . ((isset($_SESSION["q"]) and $_SESSION["q"] != '') ? self::pl_tabSection_loader('plpublic-' . $type, $category) : null) . '
						    ' . ((self::$cfg["file_privacy"] == 1 and !$hide) ? self::pl_tabSection_loader('private-' . $type, $category) : null) . '
						    ' . ((self::$cfg["file_privacy"] == 1 and !$hide) ? self::pl_tabSection_loader('personal-' . $type, $category) : null) . '
						    ' . (self::pl_tabSection_loader('plviews-' . $type, $category)) . '
						    ' . (self::pl_tabSection_loader('titleasc-' . $type, $category)) . '
						    ' . (self::pl_tabSection_loader('titledesc-' . $type, $category)) . '
						    <input type="hidden" id="tab-'.$type.'" value="plpublic-'.$type.'">

						</div><!-- /content-wrap -->
				</div><!-- /' . $type . '-content -->';

		return $html;
        }
	
	/* list my playlists template */
	function listPlaylists($type = 'video', $return_db_object = false){
		$db		= self::$db;
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_filter	= self::$filter;
		$class_database = self::$dbc;
		$href		= self::$href;
		$section	= self::$section;

		$c		= 0;
		$usr_id		= (int) $_SESSION["USER_ID"];
		$user		= $_SESSION["USER_NAME"];
		$sort		= isset($_GET["sort"]) ? $class_filter->clr_str($_GET["sort"]) : null;
		$page		= isset($_GET["page"]) ? (int) $_GET["page"] : 1;
		$lim		= self::$playlist_limit;
		$q		= null;
		$ch		= false;

		switch ($section) {
				case $href["playlists"]:
				case $href["channel"]:
				case $href["search"]:
					$qq	= " AND `pl_privacy`='public' ";
					break;
				default:
					$qq	= null;
					break;
		}
		
		$adr		= self::$filter->clr_str($_SERVER["REQUEST_URI"]);

		if (strpos($adr, self::$href["channel"]) !== FALSE) {
			$c	 = new VChannel;
			$q	.= sprintf(" AND B.`usr_key`='%s' ", VChannel::$user_key);
			$ch	 = true;
		} elseif (isset($_GET["u"])) {
			$q	.= sprintf(" AND B.`usr_key`='%s' ", self::$filter->clr_str($_GET["u"]));
			$ch	 = true;
		}
		
		$sql_1		 = null;
		$sql_2		 = null;
		$search_order	 = false;
		if (isset($_SESSION["q"]) and $_SESSION["q"] != '') {
			$rel	 = str_replace(array('_', '-', ' ', '.', ','), array('+', '+', '+', '+', '+'), $_SESSION["q"]);
			$sql_1	 = ", MATCH(`pl_name`, `pl_tags`) AGAINST ('".$rel."') AS `Relevance` ";
			$sql_2	 = " AND MATCH(`pl_name`, `pl_tags`) AGAINST('".$rel."' IN BOOLEAN MODE)";
			$search_order = true;
			$search_uf = (int) $_SESSION["uf"];
			
			switch ($search_uf) {
				case "1"://last hour
					$q	.= sprintf(" AND `pl_date` >= DATE_SUB(NOW(), INTERVAL 1 HOUR) ");
					break;
				case "2"://today
					$q	.= sprintf(" AND DATE(`pl_date`) = DATE(NOW()) ");
					break;
				case "3"://this week
					$q	.= sprintf(" AND YEARWEEK(`pl_date`) = YEARWEEK(NOW()) ");
					break;
				case "4"://this month
					$q	.= sprintf(" AND `pl_date` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ");
					break;
				case "5"://this year
					$q	.= sprintf(" AND YEAR(`pl_date`) = YEAR(NOW()) ");
					break;
			}
		}

		switch ($sort) {
			case "titleasc": $q .= $qq."ORDER BY `pl_name` ASC";
				break;
			case "titledesc": $q .= $qq."ORDER BY `pl_name` DESC";
				break;
			case "plviews": $q .= $qq."ORDER BY `pl_views` DESC";
				break;
			case "plpublic": $q .= "AND `pl_privacy`='public' ORDER BY `pl_id` DESC";
				break;
			case "private": $q .= !$ch ? "AND `pl_privacy`='private'" : null;
				break;
			case "personal": $q .= !$ch ? "AND `pl_privacy`='personal'" : null;
				break;
			default: $q .= !$search_order ? $qq."ORDER BY `pl_id` DESC" : $qq."ORDER BY `Relevance` DESC";
		}
		if($cfg[($type == 'doc' ? 'document' : $type)."_module"] == 1){
			$type	 = $type == 'document' ? 'doc' : $type;
			
			switch ($section) {
				case $href["playlists"]:
				case $href["channel"]:
				case $href["search"]:
					$db_sql  = sprintf("SELECT B.`usr_key`, COUNT(A.`pl_id`) AS `total` %s FROM `db_%splaylists` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`pl_active`='1' AND A.`pl_files` != '' %s %s;", $sql_1, $type, $sql_2, $q);
					$db_sql_t= $db->execute($db_sql);
					
					break;
				default:
					$db_sql_t= $db->execute(sprintf("SELECT COUNT(`pl_id`) AS `total` FROM `db_%splaylists` WHERE `usr_id`='%s' AND `pl_active`='1' %s;", $type, $usr_id, $q));
					
					break;
			}
			
			
			$total	 = $db_sql_t->fields["total"];
			
			$pages1                  = new VPagination;
			$pages1->items_total     = $total;
			$pages1->mid_range	 = 10;
			$pages1->items_per_page  = isset($_GET["ipp"]) ? (int) $_GET["ipp"] : $lim;
			$pages1->paginate();

			switch ($section) {
				case $href["playlists"]:
				case $href["channel"]:
				case $href["search"]:
					$hide	 = true;
					$h3	 = '<i class="icon-list"></i>'.$language["files.menu.mypl"];
					$db_sql	 = sprintf("SELECT 
										A.`pl_id`, A.`usr_id`, A.`pl_key`, A.`pl_name`, A.`pl_views`, A.`pl_descr`, 
										A.`pl_privacy`, A.`pl_date`, A.`pl_thumb`, A.`pl_files`, B.`usr_key`, B.`usr_user`,
										B.`usr_partner`, B.`usr_affiliate`, B.`affiliate_badge`,
										B.`usr_dname`, B.`ch_title`
										%s
										FROM 
										`db_%splaylists` A, `db_accountuser` B 
										WHERE 
										A.`usr_id`=B.`usr_id` AND 
										A.`pl_files` != '' AND 
										A.`pl_active`='1' 
										%s %s %s;", $sql_1, $type, $sql_2, $q, $pages1->limit);
					$db_sql	 = $db->execute($db_sql);
					
					break;
				
				default:
					$hide	 = false;
					$h3	 = '<i class="icon-list"></i>'.$language["files.menu.mypl2"];
					$db_sql	 = sprintf("SELECT
								A.`usr_id`, A.`pl_id`, A.`pl_key`, A.`pl_name`, A.`pl_views`, A.`pl_descr`, A.`pl_privacy`, A.`pl_date`, A.`pl_thumb`, A.`pl_files`,
								B.`usr_key`, B.`usr_user`, B.`usr_partner`, B.`usr_affiliate`, B.`affiliate_badge`,
								B.`usr_dname`, B.`ch_title`
								FROM
								`db_%splaylists` A, `db_accountuser` B
								WHERE
								A.`usr_id`='%s' AND
								A.`usr_id`=B.`usr_id` AND 
								A.`pl_active`='1' %s %s;", $type, $usr_id, $q, $pages1->limit);
					$db_sql	 = $db->execute($db_sql);
					
					break;
			}
			
			if (!$hide) {
				$page_of        = (($pages1->high+1) > $total) ? $total : ($pages1->high+1);
				$results_text	= $pages1->getResultsInfo($page_of, $total, 'left');
				$paging_links   = $pages1->getPaging($total, 'right');
			}
		
			self::$page_links = (!$hide and $paging_links != '') ? '<div id="paging-bottom" class="left-float wdmax paging-top-border paging-bg">'.$paging_links.'<div>&nbsp;</div></div>' : null;
			
			if ($hide) {
				if ($page * $lim >= $total) {
					self::$page_end = true;
				}
			}
		}
		
		if ($return_db_object)
			return $db_sql;

		$html = '
                                    <div id="view-type-content" class="ct-playlist">
					'.(($_POST and (int) $_POST["do_reload"] == 1) ? VGenerate::noticeTpl('', '', self::$language["files.text.new.pl"]) : null).'
                                        <article>
                                            <h3 class="content-title">
                                            	' . $h3 . '
                                            	<div class="pull-right" rel="tooltip" title="Show/hide all filters"><i class="toggle-all-filters icon icon-eye2" onclick="$(\'section.inner-search, section.filter.tft, section.action\').toggle()"></i></div>
                                            </h3>
                                            <div class="clearfix"></div>
                                            <div class="line nlb top"></div>
                                            <section class="filter tft" style="float:left">
                                                <div class="promo loadmask-img pull-left"></div>
                                                <div class="btn-group viewType pull-right">
                                                    ' . ($cfg["video_module"] == 1 ? '<button type="button" id="view-mode-video" class="viewType_btn viewType_btn-default view-mode-type video active" rel="tooltip" title="'.str_replace('##TYPE##', $language["frontend.global.v.c"], self::$language["files.menu.type.lists"]).'"><span><i class="icon-video"></i>'.str_replace('##TYPE##', $language["frontend.global.v.c"], self::$language["files.menu.type.lists"]).'</span></button>' : null) . '
                                                    ' . ($cfg["live_module"] == 1 ? '<button type="button" id="view-mode-live" class="viewType_btn viewType_btn-default view-mode-type live" rel="tooltip" title="'.str_replace('##TYPE##', $language["frontend.global.l.c"], self::$language["files.menu.type.lists"]).'"><span><i class="icon-live"></i>'.str_replace('##TYPE##', $language["frontend.global.l.c"], self::$language["files.menu.type.lists"]).'</span></button>' : null) . '
                                                    ' . ($cfg["image_module"] == 1 ? '<button type="button" id="view-mode-image" class="viewType_btn viewType_btn-default view-mode-type image" rel="tooltip" title="'.str_replace('##TYPE##', $language["frontend.global.i.c"], self::$language["files.menu.type.lists"]).'"><span><i class="icon-image"></i>'.str_replace('##TYPE##', $language["frontend.global.i.c"], self::$language["files.menu.type.lists"]).'</span></button>' : null) . '
                                                    ' . ($cfg["audio_module"] == 1 ? '<button type="button" id="view-mode-audio" class="viewType_btn viewType_btn-default view-mode-type audio" rel="tooltip" title="'.str_replace('##TYPE##', $language["frontend.global.a.c"], self::$language["files.menu.type.lists"]).'"><span><i class="icon-audio"></i>'.str_replace('##TYPE##', $language["frontend.global.a.c"], self::$language["files.menu.type.lists"]).'</span></button>' : null) . '
                                                    ' . ($cfg["document_module"] == 1 ? '<button type="button" id="view-mode-doc" class="viewType_btn viewType_btn-default view-mode-type doc" rel="tooltip" title="'.str_replace('##TYPE##', $language["frontend.global.d.c"], self::$language["files.menu.type.lists"]).'"><span><i class="icon-file"></i>'.str_replace('##TYPE##', $language["frontend.global.d.c"], self::$language["files.menu.type.lists"]).'</span></button>' : null) . '
						    ' . ($cfg["blog_module"] == 1 ? '<button type="button" id="view-mode-blog" class="viewType_btn viewType_btn-default view-mode-type blog" rel="tooltip" title="'.str_replace('##TYPE##', $language["frontend.global.b.c"], self::$language["files.menu.type.lists"]).'"><span><i class="icon-pencil2"></i>'.str_replace('##TYPE##', $language["frontend.global.b.c"], self::$language["files.menu.type.lists"]).'</span></button>' : null) . '
                                                </div>
                                            </section>
                                            <section class="action dh-off">
						'.(!$hide ? '
						<div class="btn-group viewType">
						    <button class="viewType_btn viewType_btn-default pl-popup" value="new" id="new-playlist" type="button" rel="tooltip" title="'.self::$language["files.action.new"].'"><span><i class="icon-plus"></i>'.self::$language["files.action.new"].'</span></button>
						</div>
						' : null).'
					    </section>
                                            <div class="clearfix"></div>
                                            <div class="line nlb bottom"></div>
                                        </article>
                                    </div>
                                    <div class="clearfix"></div>
                ';
	
		$html	.= '<div id="main-content" class="tabs tabs-style-topline">';
		$html	.= $cfg["video_module"] == 1 ? self::listPlaylistMedia($db_sql, $user_watchlist = null, 'video', $hidden = false) : null;
		$html	.= $cfg["live_module"] == 1 ? self::listPlaylistMedia(array(), array(), 'live', $hidden = true) : null;
		$html	.= $cfg["image_module"] == 1 ? self::listPlaylistMedia(array(), array(), 'image', $hidden = true) : null;
		$html	.= $cfg["audio_module"] == 1 ? self::listPlaylistMedia(array(), array(), 'audio', $hidden = true) : null;
		$html	.= $cfg["document_module"] == 1 ? self::listPlaylistMedia(array(), array(), 'doc', $hidden = true) : null;
		$html	.= $cfg["blog_module"] == 1 ? self::listPlaylistMedia(array(), array(), 'blog', $hidden = true) : null;
		$html	.= '</div>';

		$ht_js	 = '$(document).ready(function(){thumbFade(); $(".playlist-edit-action-off").click(function(){var sub_id = $(this).attr("id"); wrapLoad(current_url + menu_section + "?s=file-menu-entry6-" + sub_id + "&for=sort-" + $("#"+sub_id+"_type").val()); $("#file-menu-entry6-"+sub_id).addClass("menu-panel-entry-sub-active"); });';
		$ht_js	.= '(function () {[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {new CBPFWTabs(el);});})(); });';
/*
		$html .= empty($_GET) ? '<script type="text/javascript">
			jQuery(document).on({
                                  click: function(event) {
                                        event.preventDefault();
                                        event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);
                                        var _t = $(this);
                                        var t=_t.parent();
                                        var f=0;
                                        var h=_t.find("a").attr("href").replace("#section-", "");
                                        var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");

                                        //t.find("li").each(function(){
                                        $("#"+vm+"-content .content-current .mp-sort-by li").each(function(){
                                                var tt=$(this);
                                                if(tt.hasClass("iss")) {
                                                        f+=1;
                                                }
                                        });
                                        if (f == 0) {
                                                t.addClass("issm");
                                                $("body").addClass("hissm");
                                                t.find("li").addClass("iss").stop().slideDown("fast");
                                        } else {
                                                t.find("li").removeClass("iss").stop().slideUp("fast");
                                                t.removeClass("issm");
                                                $("body").removeClass("hissm");
                                                $(".loadmask, .loadmask-msg").detach();
     
                                                t.find("li:first-of-type").stop().slideDown(10, function(){
                                                        var tc=$("#main-content li.tab-current a").attr("href").replace("#section-", "");
                                                        if (h !== tc) {
                                                        	$("#"+vm+"-content section").removeClass("content-current");
                                                        	$("#section-"+h).addClass("content-current");

                                                                $("#main-content.tabs>nav").find("a[href=#section-"+h+"]").parent().click();
                                                        }
                                                });
                                                $("#"+vm+"-content .mp-sort-by").each(function(){
                                                        var t=$(this);
                                                        t.prepend(t.find("a[href=#section-"+h+"]").parent());
                                                });
                                        }
                                }}, ".content-current .mp-sort-by li");

                                jQuery(document).on({
                                  click: function(event) {
                                        var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");
                                        //var t = $(".content-current .mp-sort-by");
                                        var t = $("#"+vm+"-content .content-current .mp-sort-by");

                                        t.find("li").removeClass("iss").stop().slideUp("fast");
                                        t.removeClass("issm");
                                        $("body").removeClass("hissm");
                                        t.find("li:first-of-type").stop().slideDown(10);
                                }}, "body.hissm");

                         </script>
' : null;
*/
		$html	.= VGenerate::declareJS($ht_js);

		return $html;
	}
	
	public static function plCreateNew() {
		self::$smarty->display('tpl_frontend/tpl_file/tpl_addplaylist.tpl');
	}
	/* content list playlists */
	function listPlaylistMedia_content($type, $db_sql) {
		$db		= self::$db;
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_filter	= self::$filter;
		$class_database = self::$dbc;

		$viewMode_id	= (int) $_GET["m"];
		
		$html  = (!isset($_GET["page"]) or !isset($_GET["pp"])) ? '<ul class="fileThumbs big clearfix">' : null;


		if ($cfg[($type == 'doc' ? 'document' : $type)."_module"] == 1){
			$c	= 0;

			if ($db_sql) {
				while (!$db_sql->EOF) {
					$pkey	= $db_sql->fields["pl_key"];
					$thumb	= $db_sql->fields["pl_thumb"];
					$title	= $db_sql->fields["pl_name"];
					$views	= $db_sql->fields["pl_views"];
					$usr_id	= $db_sql->fields["usr_id"];
					$chname	= $db_sql->fields["ch_title"];
					$datetime	= VUserinfo::timeRange($db_sql->fields["pl_date"]);
					$displayname	= $db_sql->fields["usr_dname"];
					$username	= $db_sql->fields["usr_user"];
					
					$user		= $displayname != '' ? $displayname : ($chname != '' ? $chname : $username);
					
					$thumbnail = '<img src="'.$cfg["global_images_url"] . '/default-playlist.png" alt="'.$title.'">';
					$def_thumb = $cfg["global_images_url"] . '/default-playlist.png';

					if ($thumb > 0) {
						$psql		= sprintf("SELECT 
										A.`usr_id`, A.`usr_key`, A.`usr_user`, B.`file_key`, B.`thumb_server`, A.`usr_dname`, A.`ch_title`
										FROM 
										`db_accountuser` A, `db_%sfiles` B
										WHERE 
										A.`usr_id`=B.`usr_id` AND 
										B.`file_key`='%s' 
										LIMIT 1;", $type, $thumb);
						
						$p		= $db->execute($psql);
						$p_usr_id	= $p->fields["usr_id"];
						$p_usr_key	= $p->fields["usr_key"];
						$displayname	= $p->fields["usr_dname"];
						$username	= $p->fields["usr_user"];
						$p_tmb_srv	= $p->fields["thumb_server"];
						
						$thumbnail	= '<img class="mediaThumb" height="'.(($viewMode_id == 4 or $viewMode_id == 0) ? 120 : 185).'" src="'.$def_thumb.'" data-src="' . self::thumbnail($p_usr_key, $thumb, $p_tmb_srv) . '" alt="' . $title . '">';
					}
					
					$total	= 0;

					$url	= 'javascript:;';

					if ($db_sql->fields["pl_files"] != '') {
						$pl_files	= unserialize($db_sql->fields["pl_files"]);
						$total		= self::finalDBcount($type, $pl_files);
						
						if ($viewMode_id == 6) {
							$sql	= sprintf("SELECT
										A.`file_title`, A.`file_key`, A.`file_duration` 
										FROM 
										`db_%sfiles` A 
										WHERE 
										A.`file_key` IN ('%s') 
										ORDER BY FIND_IN_SET(A.`file_key`, '%s')
										LIMIT 5", $type, implode("','", $pl_files), implode(',', $pl_files));
							
							$plist	= $db->execute($sql);
						}
					}

					if (isset($pl_files[0]) and (!isset($_SESSION["USER_ID"]) || (int) $_SESSION["USER_ID"] == 0 || $usr_id != (int)$_SESSION["USER_ID"])) {
						$url = $cfg["main_url"].'/'.VGenerate::fileHref($type[0], $pl_files[0], '').'&p='.$pkey;
						//$oc = null;
						$oc = ' onclick="window.location=\''.$url.'\';return false;"';
					} else {
						$oc = ' onclick="$(\'#categories-accordion .menu-panel-entry-active\').removeClass(\'menu-panel-entry-active\'); $(\'#file-menu-entry6-sub'.$type[0].$db_sql->fields["pl_id"].'\').click()"';
					}

					if ($viewMode_id == 4 or $viewMode_id == 0) {
						$html	.= '	<li class="vs-column fourths small-thumbs">
									<div class="thumbs-wrapper">
										<figure class="effect-smallT"'.$oc.'>
										    <i class="play-btn" onclick="$(\'#categories-accordion .menu-panel-entry-active\').removeClass(\'menu-panel-entry-active\'); $(\'#file-menu-entry6-sub'.$type[0].$db_sql->fields["pl_id"].'\').click();"></i>
										    ' . $thumbnail . '
										<div class="caption-more">
										    <span class="time-lenght">' . $total . ' ' . ($total == 1 ? $language["frontend.global." . $type[0]] : $language["frontend.global." . $type[0] . ".p"]) . '</span>
										</div>
										</figure>
										<h2><a href="'.$url.'" onclick="$(\'#categories-accordion .menu-panel-entry-active\').removeClass(\'menu-panel-entry-active\'); $(\'#file-menu-entry6-sub'.$type[0].$db_sql->fields["pl_id"].'\').click();">' . $title . '</a></h2>
										<div class="profile_image">
										    <div class="profile_wrap">
											<span class="channel_name">' . VAffiliate::affiliateBadge((($db_sql->fields["usr_affiliate"] == 1 or $db_sql->fields["usr_partner"] == 1) ? 1 : 0), $db_sql->fields["affiliate_badge"]) . $user . '</span>
										    </div>
										</div>

										<div class="caption">
                                                            <div class="vs-column">
                                                                <span class="views-number">'.$views.' '.($views == 1 ? self::$language["frontend.global.view"] : self::$language["frontend.global.views"]).'</span>
                                                                <span class="i-bullet"></span>
                                                                <span class="views-number">'.$datetime.'</span>
                                                            </div>
                                                        </div>

									</div>
								</li>';
					} else {
						if ($plist->fields["file_title"]) {
							$description	= '<ul class="playlist-entries">';
							while (!$plist->EOF) {
								$description .= '<li>
											<a href="'.$cfg["main_url"].'/'.VGenerate::fileHref($type[0], $plist->fields["file_key"], '').'&p='.$pkey.'" class="place-left">'.$plist->fields["file_title"].'</a>
											'.(($type[0] == 'v' or $type[0] == 'a' or $type[0] == 'l') ? '<span class="place-right playlist-file-duration">'.VFiles::fileDuration($plist->fields["file_duration"]).'</span>' : null).'
											<span class="clearfix"></span>
										</li>';
								
								$plist->MoveNext();
							}
							$description	.= '</ul>';
						}

						$html	.= '    <li class="vs-column full-thumbs">
									<div class="thumbs-wrapper">
									    <figure class="effect-fullT">
									        <i class="play-btn" onclick="window.location=\''.$url.'\'"></i>
										' . $thumbnail . '
										<div class="caption-more">
										    <span class="time-lenght">' . $total . ' ' . ($total == 1 ? $language["frontend.global." . $type[0]] : $language["frontend.global." . $type[0] . ".p"]) . '</span>
										</div>
										<figcaption>
										    <a href="' . $url . '" rel="nofollow" onclick="$(\'#categories-accordion .menu-panel-entry-active\').removeClass(\'menu-panel-entry-active\'); $(\'#file-menu-entry6-sub'.$type[0].$db_sql->fields["pl_id"].'\').click()">' . $title . '</a>
										    <div class="profile_image">
											<div class="profile_wrap">
										    <img src="' . VUseraccount::getProfileImage($usr_id) . '" alt="' . $user . '">
										    <span class="channel_name">' . $user . '</span>
											</div>
										    </div>
										</figcaption>	
									    </figure>

									    <div class="caption">
										<div class="vs-column thirds">
										    <i class="icon-eye2"></i>
										    <span class="views-number">' . $views . '</span>
										</div>
									    </div>

									    <div class="full-details-holder">
										<h2>' . $title . '</h2>
										' . $description . '
									    </div>
									</div>
								</li>';

					}


					@$db_sql->MoveNext();
				}
				
				
				if (self::$section == self::$href["playlists"] or self::$section == self::$href["channel"] or self::$section == self::$href["search"]) {
					$sct		= isset($_GET["sort"]) ? $class_filter->clr_str($_GET["sort"]) : (self::$section == self::$href["search"] ? 'relevance' : 'plpublic');
					$viewMode_id	= ($viewMode_id == 0 or $viewMode_id == 4) ? 1 : 3;

					if (self::$page_end) {
						$js = 'if (typeof($) != "undefined") { setTimeout(function () { $("#main-view-mode-' . $viewMode_id . '-' . $sct . '-' . $type . '-more").detach(); }, 200); }';
						$html .= VGenerate::declareJS('$(document).ready(function(){' . $js . '});');
					} else {
						$html .= ((isset($_GET["p"]) and (int) $_GET["p"] == 0 and ! isset($_GET["page"])) or ! isset($_GET["p"])) ? self::loadMore($viewMode_id, $sct) : null;
					}
				}
			}
			
			if ($db_sql->recordcount() > 0) {
				$c = 1;
			}
		}
		$html .= $c == 0 ? '<li class="top-bottom-padding center"><div class="no-content">' . $language["frontend.global.results.none"] . '</div></li>' : NULL;
		$html .= (!isset($_GET["page"]) or !isset($_GET["pp"])) ? '</ul>' : null;
		$html .= (self::$section != self::$href["playlists"] and self::$section != self::$href["channel"]) ? self::$page_links : null;

		return $html;
	}

	 /* playlist details template */
	function listPlaylistDetails(){
		$cfg		 = self::$cfg;
		$db		 = self::$db;
		$class_database	 = self::$dbc;
		$class_filter	 = self::$filter;
		$language	 = self::$language;

		$s		 = 0;
		$mod_array	 = array("l" => "live", "v" => "video", "i" => "image", "a" => "audio", "d" => "doc", "b" => "blog");
		
		foreach ($mod_array as $key => $val) {
			if (strlen($_GET[$key]) >= 10 and $s == 0) {
				$db_tbl = $val;
				$db_val = $class_filter->clr_str($_GET[$key]);
				$s	= 1;
			}
		}

		$sql 	 = sprintf("SELECT 
								A.`pl_id`, A.`usr_id`, A.`pl_key`, A.`pl_name`, A.`pl_descr`, A.`pl_privacy`, A.`pl_views`, 
								A.`pl_files`, A.`pl_thumb`, A.`pl_embed`, A.`pl_email`, A.`pl_social`, A.`pl_date`,
								B.`usr_user`, B.`usr_key`, B.`usr_dname`, B.`usr_affiliate`, B.`usr_partner`, B.`affiliate_badge`
								FROM 
								`db_%splaylists` A, `db_accountuser` B
								WHERE 
								A.`usr_id`=B.`usr_id` AND 
								A.`pl_key`='%s' 
								LIMIT 1;", $db_tbl, $db_val);

		$q_result 	 = $db->execute($sql);

		$u_id		 = $q_result->fields["usr_id"];
		/* check privacy */
		if (($q_result->fields["pl_privacy"] == 'personal' and self::getUserID() != $u_id) or $q_result->fields["pl_name"] == '') {
			return VGenerate::noticeTpl('', $language["notif.error.invalid.request"], '');
		} elseif ($q_result->fields["pl_privacy"] == 'private' and self::getUserID() != $u_id) {
			$fq = $db->execute(sprintf("SELECT `ct_id` FROM `db_usercontacts` WHERE `usr_id`='%s' AND `ct_username`='%s' AND `ct_friend`='1' AND `ct_blocked`='0' AND `ct_active`='1' LIMIT 1;", $u_id, $_SESSION["USER_NAME"]));
			
			if ($fq->fields["ct_id"] == '')
				return VGenerate::noticeTpl('', $language["notif.error.invalid.request"], '');
		}
		/* update views */
		if (self::getUserID() != $u_id) {
			$_ip = $class_filter->clr_str($_SERVER["REMOTE_ADDR"]);
			
			$db->execute(sprintf("UPDATE `db_%splaylists` SET `pl_views`=`pl_views`+1 WHERE `pl_key`='%s' LIMIT 1;", $db_tbl, $db_val));
		}

		$u_user		= $q_result->fields["usr_user"];
		$d_user		= $q_result->fields["usr_dname"];
		$u_name		= $d_user != '' ? $d_user : $u_user;
		$u_files	= $q_result->fields["pl_files"];
		$f_array	= unserialize($u_files);
		$f_count	= $u_files != '' ? self::finalDBcount($db_tbl, $f_array) : 0;
		$p_views	= $q_result->fields["pl_views"];
		$u_key		= $q_result->fields["usr_key"];
		$p_key		= $q_result->fields["pl_key"];
		$thumb		= $q_result->fields["pl_thumb"];
		$thumb		= $thumb == '' ? $f_array[0] : $thumb;
		$pl_name	= $q_result->fields["pl_name"];
		$pl_date	= $q_result->fields["pl_date"];
		$f_title	= $class_database->singleFieldValue('db_' . $db_tbl . 'files', 'file_title', 'file_key', $thumb, (self::$db_cache ? $cfg['cache_playlist_details_tmbsrv'] : false));
		$p_embed	= $q_result->fields["pl_embed"];
		$p_social	= $q_result->fields["pl_social"];
		$p_email	= $q_result->fields["pl_email"];
		$usr_affiliate	= $q_result->fields["usr_affiliate"];
		$usr_partner	= $q_result->fields["usr_partner"];
		$usr_affiliate	= ($usr_affiliate == 1 or $usr_partner == 1) ? 1 : 0;
		$af_badge	= $q_result->fields["affiliate_badge"];

		if (self::fileKeyCheck($db_tbl, $thumb, 1) == 1 and $class_database->singleFieldValue('db_' . $db_tbl . 'files', 'deleted', 'file_key', $thumb, (self::$db_cache ? $cfg['cache_playlist_details_deleted'] : false)) == '0') {
			$tmb_srv = $class_database->singleFieldValue('db_' . $db_tbl . 'files', 'thumb_server', 'file_key', $thumb, (self::$db_cache ? $cfg['cache_playlist_details_tmbsrv'] : false));
			$tmb_img = '<img class="mediaThumb-playlist" src="' . self::thumbnail($u_key, $thumb, $tmb_srv) . '" alt="' . $pl_name . '">';
		} else {
			$tmb_img = '<img class="mediaThumb-playlist" src="' . $cfg["global_images_url"] . '/default-playlist.png" alt="' . $pl_name . '">';
		}
		
		$adv		= VGenerate::simpleDivWrap('', '', VGenerate::advHTML(28));
		/* embed tab */
		if ($db_tbl[0] == 'i' or (($db_tbl[0] == 'v' or $db_tbl[0] == 'l') and $cfg["video_player"] == 'jw') or ($db_tbl[0] == 'a' and $cfg["audio_player"] == 'jw')) {
		$embed_html	 = '<form class="entry-form-class"><label>'.$language["files.text.pl.share.emb1"].'</label><div class="place-right"><a class="comm-cancel-action js-textareacopybtn" rel="nofollow" href="javascript:;"><i class="iconBe-copy"></i>'.self::$language["frontend.global.copy"].'</a></div></form>';
		$embed_html	.= (!isset($_GET["d"]) and $cfg["video_player"] == 'jw' and ($p_embed == 1 or $q_result->fields["usr_id"] == self::getUserID())) ? '<form class="entry-form-class"><div id="embed_code_wrap" class="">'.sprintf('<input type="text" class="js-copytextarea" readonly="readonly" name="playlist_embed_code" value=\'%s\' onclick="this.select();this.focus();" />', self::playlistEmbedCode($db_tbl, $p_key)).'</div></form>' : NULL;
		} else $embed_html = null;
		/* email tab */
		$email_html	 = '<form id="share-playlist-form" class="entry-form-class" method="post" action="">';
		$email_html	.= '<div class="left-float wdmax" id="share-playlist-response"></div>';
		$email_html	.= '<div class="place-left-off">';
		$email_html	.= '<label class="place-left">'.$language["mail.share.pl.mailto.email.txt.tip"].'</label>';

		if (self::getUserID() > 0) {
			$email_html	.= '<div class="place-right" style="width: 200px; max-height: 200px; padding-left: 20px; margin-bottom: 20px;">';
			$email_html	.= '<div class=""><label class="pl-share-label" onclick="$(\'#pl-share-ct-list\').stop().slideToggle(\'fast\')">'.$language["files.text.pl.share.myct"].' <i class="iconBe-chevron-down"></i></label></div>';
			$email_html	.= '<div class="" id="pl-share-ct-list" style="display:none">'.self::plShare_listContacts().'</div>';
			$email_html	.= '</div>';
		}

		$email_html	.= '<div class="clearfix"></div>';
		$email_html	.= '<textarea name="share_pl_to" id="share_pl_to" class="ta-input" rows="1" cols="1"></textarea>';
		$email_html	.= '<label>'.$language["mail.share.pl.mailto.email.msg"].'</label>';
		$email_html	.= '<textarea name="share_pl_msg" class="ta-input" rows="1" cols="1"></textarea>';
		$email_html	.= VGenerate::basicInput('button', 'playlist_send', 'symbol-button button-grey search-button form-button post-share-email playlist-send', '', 1, '<i class="icon-'.($db_tbl == 'doc' ? 'file' : $db_tbl).'"></i> <span>'.$language["frontend.global.send"].'</span>');
		$email_html	.= '</div>';
		$email_html	.= '<div><input type="hidden" name="h_pl_type" id="h_pl_type" value="'.$db_tbl[0].'" /></div>';
		$email_html	.= '<div><input type="hidden" name="h_pl_pid" id="h_pl_pid" value="'.$q_result->fields["pl_id"].'" /></div>';
		$email_html	.= '</form>';
		/* permalink tab */
		$perma_html	 = '<form class="entry-form-class"><label>'.$language["files.text.pl.share.url"].'</label><div class="place-right"><a class="comm-cancel-action js-textareacopybtn-p2" rel="nofollow" href="javascript:;"><i class="iconBe-copy"></i>'.self::$language["frontend.global.copy"].'</a></div></form>';
		$perma_html	.= '<form class="entry-form-class"><div id="embed_code_wrap" class="">'.sprintf('<input type="text" class="js-copytextarea-p2" readonly="readonly" name="playlist_embed_code" value=\'%s\' onclick="this.select();this.focus();" />', $cfg["main_url"].'/'.VHref::getKey("playlist").'?'.$db_tbl[0].'='.$p_key).'</div></form>';

		$js		 = '$(".cancel-plshare").click(function(){$("#fade , #popuprel").hide();});';
		if ($db_tbl[0] == 'v' or $db_tbl[0] == 'i' or $db_tbl[0] == 'a' or $db_tbl[0] == 'l') {
			$js	.= ($db_tbl[0] == 'i' or (($db_tbl[0] == 'v' or $db_tbl[0] == 'l') and $cfg["video_player"] == 'jw') or ($db_tbl[0] == 'a' and $cfg["audio_player"] == 'jw')) ? 'var copyTextareaBtn = document.querySelector(\'.js-textareacopybtn\'); copyTextareaBtn.addEventListener(\'click\', function(event) { var copyTextarea = document.querySelector(\'.js-copytextarea\'); copyTextarea.select(); try { var successful = document.execCommand(\'copy\'); } catch (err) {} });' : null;
			$js	.= 'var copyTextareaBtn = document.querySelector(\'.js-textareacopybtn-p2\'); copyTextareaBtn.addEventListener(\'click\', function(event) { var copyTextarea = document.querySelector(\'.js-copytextarea-p2\'); copyTextarea.select(); try { var successful = document.execCommand(\'copy\'); } catch (err) {} });';
		}

		
		$html		= '
			<div id="edit-wrapper">
				<div class="page_holder_off playlist_holder">
					<article>
						<h3 class="content-title"><i class="icon-' . ($db_tbl == 'doc' ? 'file' : ($db_tbl == 'blog' ? 'pencil2' : $db_tbl)) . '"></i> ' . $language["files.text.pl.details.top1"] . '</h3>
						<div class="line"></div>
					</article>
					'.VGenerate::advHTML(29).'
					<div class="video_player_holder_comments">
						<div id="pl-save-response"></div>
						<div class="vs-column thirds image-holder">
							<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($db_tbl[0], $thumb, $f_title) . '&p='.$q_result->fields["pl_key"].'" rel="nofollow">'.$tmb_img.'</a>
							'.VGenerate::advHTML(30).'
						</div>
						<div class="vs-column two_thirds fit">
							<h2>'.$pl_name.'</h2>
							<ul class="playlist-info">
								<li class="entry"><a href="'.$cfg["main_url"].'/'.VHref::getKey('channel').'/'.$u_key.'/'.$u_user.'">'.VAffiliate::affiliateBadge($usr_affiliate, $af_badge).$u_name.'</a></li>
								<li class="entry">'.$f_count.' '.($f_count != 1 ? $language["frontend.global.".$db_tbl[0].".p"] : $language["frontend.global.v"]).'</li>
								<li class="entry">'.$p_views.' '.($p_views != 1 ? $language["frontend.global.views"] : $language["frontend.global.view"]).'</li>
								<li class="entry">'.$language["frontend.global.created"].' '.VUserinfo::timeRange($pl_date).'</li>
							</ul>
							<div class="clearfix"></div><br>
							'.(($db_tbl[0] == 'v' or $db_tbl[0] == 'i' or $db_tbl[0] == 'a' or $db_tbl[0] == 'l') ? '<div class="vs-column thirds"><button onfocus="blur();" onclick="window.location=&quot;'.$cfg["main_url"].'/'.VGenerate::fileHref($db_tbl[0], $f_array[0], $f_title).'&p='.$db_val.'&quot;" value="1" type="button" class="button-grey search-button form-button save-button button-blue thumb-popup" name="btn_play_all"><i class="icon-play"></i> <span>'.$language["frontend.global.play.all"].'</span></button></div>' : null).'
							<div class="vs-column thirds"><button onfocus="blur();" value="1" type="button" class="button-grey search-button form-button save-button button-blue thumb-popup pl-share" name="btn_share"><i class="icon-share"></i> <span>'.$language["frontend.global.share"].'</span></button></div>
							<div class="vs-column thirds fit"><button onfocus="blur();" value="1" type="button" class="button-grey search-button form-button save-button button-blue thumb-popup pl-save" name="btn_save"><i class="iconBe-plus"></i> <span>'.$language["frontend.global.save"].'</span></button></div>
							<div class="clearfix"></div>
							<div class="tabs tabs-style-topline" style="display: none;">
								<nav>
									<ul>
										'.(($p_embed == 1 and ($db_tbl[0] == 'i' or (($db_tbl[0] == 'v' or $db_tbl[0] == 'l') and $cfg["video_player"] == 'jw') or ($db_tbl[0] == 'a' and $cfg["audio_player"] == 'jw'))) ? '<li><a href="#section-embed" class="icon icon-embed" rel="nofollow"><span>'.$language["view.files.share.embed"].'</span></a></li>' : null).'
										'.($p_social == 1 ? '<li><a href="#section-social" class="icon icon-facebook" rel="nofollow"><span>'.$language["view.files.share.social"].'</span></a></li>' : null).'
										'.('<li><a href="#section-perma" class="icon icon-link" rel="nofollow"><span>'.$language["view.files.permalink"].'</span></a></li>').'
										'.($p_email == 1 ? '<li><a href="#section-embed" class="icon icon-envelope" rel="nofollow"><span>'.$language["view.files.share.email"].'</span></a></li>' : null).'
									</ul>
								</nav>
								<div class="content-wrap">
									'.(($p_embed == 1 and ($db_tbl[0] == 'i' or (($db_tbl[0] == 'v' or $db_tbl[0] == 'l') and $cfg["video_player"] == 'jw') or ($db_tbl[0] == 'a' and $cfg["audio_player"] == 'jw'))) ? '
									<section id="section-embed">
										<article>
											<div>
												'.$embed_html.'
											</div>
										</article>
									</section>
									' : null).'
									'.($p_social == 1 ? '
									<section id="section-social">
										<article>
											<div>
												'.VGenerate::socialBookmarks(self::$href["watch"]).'
											</div>
										</article>
									</section>
									' : null).'
									<section id="section-perma">
										<article>
											<div>
												'.$perma_html.'
											</div>
										</article>
									</section>
									'.($p_email == 1 ? '
									<section id="section-email">
										<article>
											<div>
												'.$email_html.'
											</div>
										</article>
									</section>
									' : null).'
								</div>
							</div>
						</div>
						
						<div class="clearfix"></div>
					</div>
					<div class="content-wrap-off">
						'.VGenerate::advHTML(32).'
						<section id="section-main">
							<article>
								'.self::playlistDetailsEntries($db_tbl, $f_count, $u_name, $f_array).'
							</article>
						</section>
						'.VGenerate::advHTML(34).'
					</div>
				</div>
			</div>
		';
		
		$html		.= '<script type="text/javascript" src="'.$cfg["javascript_url"].'/fwtabs.js"></script>';
		
		
		$js		.= '	$(document).ready(function() {
			
						(function () {
							[].slice.call(document.querySelectorAll(\'.tabs\')).forEach(function (el) {
								new CBPFWTabs(el);
							});
						})();
						

						$(".pl-save").on("click", function() {
							$(".video_player_holder_comments").mask(" ");
							url = current_url + menu_section + "?a=save";
							
							$.post(url, {"type": "'.$db_tbl.'", "key": "'.$p_key.'"}, function(data) {
								$("#pl-save-response").html(data);
								$(".video_player_holder_comments").unmask();
							});
						});
					});';
		
		$js	.= '	$(".playlist-send").on("click", function() {
					if($("#share_pl_to").val() != "") {
						$(".video_player_holder_comments").mask(" ");
						$.post("'.$cfg["main_url"].'/'.VHref::getKey("playlist").'?a=pl-mail", $("#share-playlist-form").serialize(), function(data){
							$("#pl-save-response").html(data);
							$(".video_player_holder_comments").unmask();
						});
					}
				});';
		
		$js	.= '	$(".pl-share").on("click", function(e) {
					$(".tabs").stop(true, true).slideToggle(300);
				});';
		
		$html		.= VGenerate::declareJS($js);
		
		
		return $html;
	}
	/* save playlist */
	public static function savePlaylist() {
		$cfg		 = self::$cfg;
		$db		 = self::$db;
		$class_database	 = self::$dbc;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		
		if ((int) $_SESSION["USER_ID"] == 0) {
			echo VGenerate::noticeTpl('', $language["files.text.pl.details.guest"], '');
			return;
		}
		
		if ($_POST) {
			$type	 = $class_filter->clr_str($_POST["type"]);
			$key	 = $class_filter->clr_str($_POST["key"]);
			
			$sql	 = sprintf("SELECT `usr_id`, `pl_files`, `pl_name`, `pl_descr`, `pl_tags`, `pl_thumb` FROM `db_%splaylists` WHERE `pl_key`='%s' LIMIT 1;", $type, $key);
			$res	 = $db->execute($sql);
			
			$pl	 = $res->fields["pl_files"];
			
			if ($res->recordcount() == 0) {
				echo VGenerate::noticeTpl('', $language["notif.error.invalid.request"], '');
			} elseif ($res->fields["usr_id"] == self::getUserID()) {
				echo VGenerate::noticeTpl('', $language["playlist.save.error3"], '');
			} elseif ($pl == '') {
				echo VGenerate::noticeTpl('', $language["playlist.save.error1"], '');
			} else {
				$my	= array('usr_id'	=> self::getUserID(),
						'pl_key'	=> strtoupper(VUserinfo::generateRandomString(10)),
						'pl_name'	=> $res->fields["pl_name"],
						'pl_descr'	=> $res->fields["pl_descr"],
						'pl_tags'	=> $res->fields["pl_tags"],
						'pl_thumb'	=> $res->fields["pl_thumb"],
						'pl_date'	=> date("Y-m-d H:i:s"),
						'pl_files'	=> $res->fields["pl_files"]
					);
				
				if ($class_database->doInsert('db_'.$type.'playlists', $my)) {
					echo VGenerate::noticeTpl('', '', $language["notif.success.request"]);
				} else {
					echo VGenerate::noticeTpl('', $language["playlist.save.error2"], '');
				}
			}
		}
	}
	/* list of files when viewing playlist details */
	function playlistDetailsEntries($type, $files_count, $u_name, $pl_files, $privacy = '') {
		$cfg		 = self::$cfg;
		$db		 = self::$db;
		$class_database	 = self::$dbc;
		$class_filter	 = self::$filter;
		$language	 = self::$language;
		
		$pl_id	= $class_filter->clr_str($_GET[$type[0]]);
		
		if ($pl_files[0] == '') {
			return;
		}
		
		$sql	= sprintf("SELECT 
					B.`file_title`, B.`file_key`, B.`file_duration`, B.`thumb_server`, B.`file_views`,
					C.`usr_key`, C.`usr_user`, C.`usr_dname`, C.`usr_affiliate`, C.`usr_partner`, C.`affiliate_badge`
					FROM 
					`db_%sfiles` B, `db_accountuser` C
					WHERE 
					B.`usr_id`=C.`usr_id` AND 
					B.`file_key` IN ('%s') 
					ORDER BY FIND_IN_SET(B.`file_key`, '%s')
					LIMIT %s", $type, implode("','", $pl_files), implode(',', $pl_files), $files_count);

		$rs	= $db->execute($sql);

		if ($rs->fields["file_key"]) {
			$c	 = 1;

			$html	 = '<ul id="playlist-entries-list">';
			while (!$rs->EOF) {
				$title	 = $rs->fields["file_title"];
				$u_key	 = $rs->fields["usr_key"];
				$u_user	 = $rs->fields["usr_user"];
				$d_user	 = $rs->fields["usr_dname"];
				$f_key	 = $rs->fields["file_key"];
				$tmb_srv = $rs->fields["thumb_server"];
				$usr_affiliate	= $rs->fields["usr_affiliate"];
				$usr_partner	= $rs->fields["usr_partner"];
				$usr_affiliate	= ($usr_affiliate == 1 or $usr_partner == 1) ? 1 : 0;
				$af_badge	= $rs->fields["affiliate_badge"];
				$p_views = VFiles::numFormat($rs->fields["file_views"]);
				$dur	 = VFiles::fileDuration($rs->fields["file_duration"]);
				$_name	 = $d_user != '' ? $d_user : $u_user;
				
				$html	.= '	<li class="entry">
							<div class="pl-thumb-holder">
								<a href="'.$cfg["main_url"].'/'.VGenerate::fileHref($type[0], $f_key, $title).'&p='.$pl_id.'" rel="nofollow">
									<div class="place-left pl-entry-nr">'.$c.'</div>
									<img class="mediaThumb" src="' . self::thumbnail($u_key, $f_key, $tmb_srv) . '" alt="' . $title . '">
								</a>
							</div>
							<div class="pl-entry-info">
								<a class="entry-title" href="'.$cfg["main_url"].'/'.VGenerate::fileHref($type[0], $f_key, $title).'&p='.$pl_id.'">'.$title.'</a>
								<ul class="playlist-info entries-list">
									<li><a href="'.$cfg["main_url"].'/'.VHref::getKey('channel').'/'.$u_key.'/'.$u_user.'">'.$_name.VAffiliate::affiliateBadge($usr_affiliate, $af_badge).'</a></li>
									<li>'.$p_views.' '.($p_views != 1 ? $language["frontend.global.views"] : $language["frontend.global.view"]).'</li>
									'.(($type[0] == 'v' or $type[0] == 'a' or $type[0] == 'l') ? '<li class="pl-entry-nr-duration">'.$dur.'</li>' : null).'
								</ul>
							</div>
							<div class="clearfix"></div>
						</li>'
					;
				
				$c	+= 1;
				$rs->MoveNext();
			}
			$html	.= '<ul>';
		}
		
		return $html;
		
		
		

		//$s = 1;
/*
		for ($i = 0; $i < count($files_array); $i++) {
			$v_key	 = $files_array[$i];
			$rs	 = $db->execute(sprintf("SELECT `usr_id`, `privacy`, `approved`, `deleted` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $v_key));
			$u_user	 = $u_name;
			$u_id	 = $rs->fields["usr_id"];
			$privacy = $rs->fields["privacy"];
			$approved= $rs->fields["approved"];
			$deleted = $rs->fields["deleted"];

			if (self::fileKeyCheck($db_tbl, $v_key, 1) == 1) {
				$html .= '<div class="left-float wdmax top-padding5">';
				$html .= '<div class="left-float all-paddings10 bold font16 greyed-out wd30 right-align">' . ($s) . '.</div>';
				$html .= '<div class="no-display"><input type="checkbox" class="list-check" id="file-check' . $v_key . '" value="' . $v_key . '" name="fileid[]" /></div>';
				$html .= self::fileThumb($v_key);

				$href = $deleted == 0 ? $cfg["main_url"] . '/' . VGenerate::fileHref($db_tbl[0], $v_key, '') . '&p=' . $class_filter->clr_str($_GET[$db_tbl[0]]) : 'javascript:;';

				$html .= '<div class="top-padding5"><a href="' . $href . '" class="file-title lh20">' . VUserinfo::truncateString(self::getPlEntryTitle($db_tbl, $v_key), 50) . '</a></div>';

				$ev = self::getPlEntryViews($db_tbl, $v_key);

				$html .= '<div class="top-padding5"><span class="greyed-out font11">' . $language["frontend.global.by"] . '</span> <a href="' . $cfg["main_url"] . '/' . VHref::getKey("user") . '/' . $u_user . '" class="u-line font11">' . $u_user . '</a> <span class="greyed-out">|</span> <span class="greyed-out font11">' . $ev . ' ' . ($ev != 1 ? $language["frontend.global.views"] : $language["frontend.global.view"]) . '</span></div>';
				$html .= $deleted == 0 ? '<div class="top-padding5">' . ($privacy == 'private' ? '<span class="italic bottom-border-dotted cl-private">' . $language["frontend.global.private"] . '</span>' : ($privacy == 'personal' ? '<span class="italic bottom-border-dotted cl-personal">' . $language["frontend.global.personal"] . '</span>' . ($approved == 0 ? '<span class="greyed-out"> | </span>' : NULL) : NULL)) . ($approved == 0 ? ($privacy == 'private' ? '<span class="greyed-out no-display1"> | </span>' : NULL) . '<span class="italic bottom-border-dotted cl-pending">' . $language["frontend.global.pending"] . '</span>' : NULL) . '</div>' : '<div class="top-padding5 err-red">' . $language["frontend.global.deleted"] . '</div>';
				$html .= '</div>';

				$s += 1;
			}
		}

		return $html;*/
	}
	/* get title, descr from key */
	public static function getFileInfo($fkey) {
		$db	 = self::$db;
		$cfg	 = self::$cfg;

		$mod_arr = array("live" => "live", "video" => "video", "image" => "image", "audio" => "audio", "doc" => "document", "blog" => "blog");
		
		foreach ($mod_arr as $key => $val) {
			if ($cfg[$val . "_module"] == 1) {
				$sql	= sprintf("SELECT `file_title`, `file_description` FROM `%s` WHERE `file_key`='%s';", 'db_' . $key . 'files', $fkey);
				$rs	= $db->execute($sql);
				$rs	= self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_view_template_file_info'], $sql) : self::$db->execute($sql);

				if ($rs->fields["file_title"] != '') {
					return array("title" => $rs->fields["file_title"], "description" => $rs->fields["file_description"], "type" => $key);
				}
			}
		}
	}

    /* number format */
    function numFormat($for){
    	return VGenerate::nrf($for);
    }
    /* number format */
    function numFormat2($for){
    	return number_format($for, 0, '', ',');
    }
    /* playlists thumb menu */
    function addToPl($key, $margin='', $extra=''){
	$db		= self::$db;
	$language	= self::$language;
	$cfg		= self::$cfg;
	$class_database = self::$dbc;
	$upage_id	= null;
	$href		= self::$href;
	$section	= self::$section;

	if($_GET["do"] == 'reload' or intval($_SESSION["USER_ID"]) == 0) { return false; }
	$cfg[]			 = $class_database->getConfigurations("file_counts");
	$key     		 = $extra == '' ? $key : $key.$extra;
	$key			 = strlen($key) == 12 ? substr($key, 0, -1) : $key;
	$key     		 = ($section == $href["browse"] or $section == $href["search"]) ? substr($key, 0, -1) : $key;
	$menu_db		 = $class_database->singleFieldValue('db_filetypemenu', 'value', 'usr_id', intval($_SESSION["USER_ID"]));
	$type                    = $margin == '' ? substr($_GET["for"], 5) : '';
	$type			 = ($type == '' and $section == $href["files"] and $menu_db != '' and $cfg[($menu_db != 'doc' ? $menu_db : 'document')."_module"] == 1) ? $menu_db : $type;
	$type			 = $type == '' ? ((substr($_GET["for"], 0, 4) == 'sort') ? substr($_GET["for"], 5) : $type) : $type;
	$type			 = $type == '' ? (($_GET["l"] != '' or $_GET["t"] == 'live') ? '' : (($_GET["v"] != '' or $_GET["t"] == 'video') ? 'video' : (($_GET["i"] != '' or $_GET["t"] == 'image') ? 'image' : (($_GET["a"] != '' or $_GET["t"] == 'audio') ? 'audio' : (($_GET["d"] != '' or $_GET["t"] == 'doc' or $_GET["t"] == 'document') ? 'doc' : NULL))))) : $type;
        $db_tbl                  = $type == '' ? ($cfg["video_module"] == 1 ? 'video' : ($cfg["image_module"] == 1 ? 'image' : ($cfg["audio_module"] == 1 ? 'audio' : ($cfg["document_module"] == 1 ? 'doc' : ($cfg["live_module"] == 1 ? 'live' : null))))) : $type;
        $lb_sql			 = sprintf("SELECT `pl_id`, `pl_name`, `pl_files` FROM `db_%splaylists` WHERE `usr_id`='%s';", $db_tbl, intval($_SESSION["USER_ID"]));
        $lb                      = $db->execute($lb_sql);
        $lb_add                  = $language["files.action.pl.add"];
        $lb_array                = $lb->getrows();
        $lb_count                = count($lb_array);
	$pl_space 		 = '&nbsp;&nbsp;&gt;';

        if ($lb_count    > 0) {
    	    for($i=0; $i < $lb_count; $i++){
    		$u_files	 = $lb_array[$i][2];
    		$p_total	 = $cfg["file_counts"] == 1 ? ' ('.($u_files != '' ? self::finalDBcount($db_tbl, unserialize($u_files)) : 0).')' : NULL;
    		$li_add         .= '<li class="addto-action-trigger cb-label-add" id="cb-label-add'.$lb_array[$i][0].'" onclick="$(\'#file-check'.$key.'\').attr(\'checked\', true);"><a href="javascript:;" rel="nofollow"><i class="icon-list"></i> '.(VUserinfo::truncateString($lb_array[$i][1], 17)).$p_total.'</a></li>';
    	    }

    	    return '<ul class="dl-menu">'.$li_add.'</ul>';
    	}
    }
    /* duration from seconds */
    function fileDuration($seconds_count){
	$delimiter  = ':';

	return ($seconds_count > 3600 ? gmdate("H:i:s", $seconds_count) : gmdate("i:s", $seconds_count));

	$seconds = $seconds_count % 60;
	$min	 = floor($seconds_count/60);
	$minutes = $min >= 60 ? ($min-60) : $min;
	$hours   = $min >= 60 ? ceil($min/60)  : floor($seconds_count/3600);

	$seconds = str_pad($seconds, 2, "0", STR_PAD_LEFT);
	$minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT).$delimiter;
	$hours	 = $hours > 0 ? str_pad($hours, 2, "0", STR_PAD_LEFT).$delimiter : '';

	return $hours.$minutes.$seconds;
    }
    /* add to favorites and playlists queries */
    function favplSQL($t, $db_tbl='', $usr_id='', $type='', $sel_count='', $pl_id='', $pl_act=''){
	$db		= self::$db;
	$class_filter	= self::$filter;

	switch($t){
	    case "fav":
		$db_field = 'fav_list';
		$db_t = 'favorites';
	    break;
	    case "pl":
		$db_field = 'pl_files';
		$db_t = 'playlists';
	    break;
	    case "liked":
		$db_field = 'liked_list';
		$db_t = 'liked';
	    break;
	    case "hist":
		$db_field = 'history_list';
		$db_t = 'history';
	    break;
	    case "watch":
		$db_field = 'watch_list';
		$db_t = 'watchlist';
	    break;
	}
	$f_sql		= sprintf("SELECT `%s` FROM `db_%s%s` WHERE `usr_id`='%s' %s LIMIT 1;", $db_field, $db_tbl, $db_t, $usr_id, ($t == 'pl' ? "AND `pl_id`='".$pl_id."'" : NULL));
	$fav_q 		= $db->execute($f_sql);
	$fav_list	= $fav_q->fields[$db_field];
	$fav_arr	= $fav_list != '' ? unserialize($fav_list) : array();
	$fav_count	= count($fav_arr);

	for($i=0; $i<$sel_count; $i++){
	    $post_key	= $class_filter->clr_str($_POST["fileid"][$i]);
	    $post_key	= strlen($post_key) > 10 ? substr($post_key, 0, -1) : $post_key;

	    if($t != 'pl'){
		if(($type == 'cb-favadd' or $type == 'cb-watchadd') and !in_array($post_key, $fav_arr)) {
		    $fav_arr[count($fav_arr)] = $post_key;
		    /* increment favorited count */
		    $db_nr	 = $type == 'cb-favadd' ? $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_favorite`=`file_favorite`+1 WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $post_key)) : NULL;
		} elseif(($type == 'cb-favclear' or $type == 'cb-likeclear' or $type == 'cb-watchclear') and in_array($post_key, $fav_arr)) {
		    unset($fav_arr[array_search($post_key, $fav_arr)]);
		    /* decrement favorited count */
		    $db_nr	 = $type == 'cb-favclear' ? $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_favorite`=`file_favorite`-1 WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $post_key)) : NULL;
		} elseif($type == 'cb-histclear') {
			foreach ($fav_arr as $ii => $_h) {
				if (in_array($post_key, $_h)) {
					unset($fav_arr[$ii]);
				}
			}
		}
	    } elseif($t == 'pl'){
		if($pl_act == 'add' and !in_array($post_key, $fav_arr)){
		    $fav_arr[count($fav_arr)]	= $post_key;
		} elseif($pl_act == 'clear' and in_array($post_key, $fav_arr)){
		    unset($fav_arr[array_search($post_key, $fav_arr)]);
		}
	    }
	}

	switch(count($fav_arr)){
	    case "0":
		$db_arr	= NULL;
		$sql	= ($t == 'fav' or $t == 'liked' or $t == 'hist' or $t == 'watch') ? sprintf("DELETE FROM `db_%s%s` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $db_t, $usr_id) : sprintf("UPDATE `db_%splaylists` SET `pl_files`='' WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, $usr_id, $pl_id);
	    break;
	    default:
		$fav_arr = array_values($fav_arr);
		$db_arr	 = serialize($fav_arr);
		$sql 	 = ($t == 'fav' or $t == 'liked' or $t == 'hist' or $t == 'watch') ? sprintf("INSERT INTO `db_%s%s` (`usr_id`, `%s`) VALUES ('%s', '%s') ON DUPLICATE KEY UPDATE `%s`='%s'", $db_tbl, $db_t, $db_field, $usr_id, $db_arr, $db_field, $db_arr) : $sql = sprintf("UPDATE `db_%splaylists` SET `pl_files`='%s' WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, $db_arr, $usr_id, $pl_id);
	    break;
	}
	return $sql;
    }
    /* delete file from server */
    function fileDelete($del_arr, $db_tbl, $usr_key=''){
	$db		 = self::$db;
	$cfg		 = self::$cfg;
	$class_database  = self::$dbc;

	if($cfg["file_deleting"] == 0) return false;
	$user_key	 = $usr_key == '' ? $_SESSION["USER_KEY"] : $usr_key;

	$user_m		 = $cfg["media_files_dir"].'/'.$user_key.'/'.$db_tbl[0].'/';
	$user_u		 = $cfg["upload_files_dir"].'/'.$user_key.'/'.$db_tbl[0].'/';
	$user_t		 = $cfg["media_files_dir"].'/'.$user_key.'/t/';
	$user_v		 = $cfg["channel_views_dir"].'/'.$user_key.'/'.$db_tbl[0].'/';
	$del_total	 = count($del_arr);

	if($del_total > 0){
	    foreach($del_arr as $vval){
		$views_dir	= $user_v.$vval;
		VFileinfo::doDelete($views_dir);
	    }
	}

	if($del_total > 0 and ($cfg["file_delete_method"] == 2 or $cfg["file_delete_method"] == 4)){
	    foreach($del_arr as $val){
	    	$fval		= md5($cfg["global_salt_key"].$val);
		$src_file	= $user_u.($class_database->singleFieldValue('db_'.$db_tbl.'files', 'file_name', 'file_key', $val));
		$flv_file 	= $user_m.$val.($db_tbl == 'video' ? '.flv' : ($db_tbl == 'image' ? '.jpg' : ($db_tbl == 'audio' ? '.mp3' : ($db_tbl == 'doc' ? '.pdf' : ($db_tbl == 'blog' ? '.tplb' : '.txx')))));
		$mp3_file	= $user_m.$fval.'.mp3';
		$mp4a_file	= $user_m.$fval.'.mp4';
		$gif_file 	= $user_m.$val.'.gif';
		$gifa_file 	= $user_m.$fval.'.gif';
		$png_file 	= $user_m.$val.'.png';
		$pnga_file 	= $user_m.$fval.'.png';
		$jpgf_file 	= $user_m.$fval.'.jpg';
		$mp4_file 	= $user_m.$val.'.mp4';
		$mob_file 	= $user_m.$val.'.mob.mp4';
		$mob_filef 	= $user_m.$fval.'.mob.mp4';
		$swf_file 	= $user_m.$val.'.swf';
		$mp4_360p       = $user_m.$val.'.360p.mp4';
		$mp4_360pf      = $user_m.$fval.'.360p.mp4';
                $mp4_480p       = $user_m.$val.'.480p.mp4';
                $mp4_480pf      = $user_m.$fval.'.480p.mp4';
                $mp4_720p       = $user_m.$val.'.720p.mp4';
                $mp4_720pf      = $user_m.$fval.'.720p.mp4';
                $mp4_1080p      = $user_m.$val.'.1080p.mp4';
                $mp4_1080pf     = $user_m.$fval.'.1080p.mp4';
                $mp4_prv        = $user_m.md5($val."_preview").'.mp4';
                $vpx_360p       = $user_m.$val.'.360p.webm';
                $vpx_480p       = $user_m.$val.'.480p.webm';
                $vpx_720p       = $user_m.$val.'.720p.webm';
                $vpx_1080p      = $user_m.$val.'.1080p.webm';
                $ogv_360p       = $user_m.$val.'.360p.ogv';
                $ogv_480p       = $user_m.$val.'.480p.ogv';
                $ogv_720p       = $user_m.$val.'.720p.ogv';
                $ogv_1080p      = $user_m.$val.'.1080p.ogv';
                
		$tmb_dir  	= $user_t.$val;

		if ($db_tbl != 'blog') {
			$do_array	= array(
						$src_file, $gif_file, $gifa_file, $png_file, $pnga_file, $jpgf_file, $mp4_file, $mp4_prv, $mob_file, $mob_filef, $swf_file, $mp4_360p, $mp4_360pf, $mp4_480p, $mp4_480pf, $mp4_720p, $mp4_720pf, $mp4_1080p, $mp4_1080pf,
						$vpx_360p, $vpx_480p, $vpx_720p, $vpx_1080p, $ogv_360p, $ogv_480p, $ogv_720p, $ogv_1080p
					);
			
			foreach ($do_array as $delete_file) {
				VFileinfo::doDelete($delete_file);
			}
                }

		VFileinfo::doDelete($mp3_file);
		VFileinfo::doDelete($mp4a_file);
		VFileinfo::doDelete($flv_file);
		VFileinfo::doDelete($tmb_dir);
	    }
	}
	if (!is_dir($user_m)) {
		mkdir($user_m);
		chmod($user_m, 0777);
	}
	if (!is_dir($user_u)) {
		mkdir($user_u);
		chmod($user_u, 0777);
	}
    }
    /* delete from other user's favorites,playlists,history,liked,watchlist */
    /* to be added later, needs much attention, can result in unpredictable behavior */
    function fileDeleteOther($db_tbl, $_key, $_from){
	if(is_array($_key)){
	    foreach($_key as $val){
		self::fileDeleteOther_action($db_tbl, $val, $_from);
	    }
	} else {
	    self::fileDeleteOther_action($db_tbl, $_key, $_from);
        }
    }
    function fileDeleteOther_action($db_tbl, $_key, $_from){
	$db	 = self::$db;

        $fsql    = "SELECT A.`usr_id`, B.`usr_key` FROM `db_".$db_tbl.$_from[0]."` A, `db_accountuser` B WHERE A.`usr_id`=B.`usr_id` AND A.`".$_from[1]."` LIKE '%".$_key."%'";
        $fres    = $db->execute($fsql);

        if($fres){
            while(!$fres->EOF){
                $usr_id          = $fres->fields["usr_id"];
                $usr_key         = $fres->fields["usr_key"];
                $del_arr         = array($_key);

                $del_other       = VFiles::clearFavPl($del_arr, $db_tbl, $usr_id, $usr_key);

                $fres->MoveNext();
            }
        }
    }
    /* delete also from favorites, playlists, liked, history, user activity, message attch.... when deleting files */
    function clearFavPl($del_arr, $db_tbl, $usr_id='', $usr_key=''){
	$db	 = self::$db;
	$dbc	 = self::$dbc;
	$cfg	 = self::$cfg;

	$sql_ar	 = array();
	$usr_id	 = $usr_id == '' ? intval($_SESSION["USER_ID"]) : $usr_id;

	if($cfg["file_delete_method"] == 1)
	    return false;

	if($cfg["file_delete_method"] == 2 or $cfg["file_delete_method"] == 4){
	    $do_del	 = self::fileDelete($del_arr, $db_tbl, $usr_key);
	}

	if($cfg["file_delete_method"] == 3 or $cfg["file_delete_method"] == 4){
	    if($cfg["file_favorites"] == 1){//delete from favorites
		$f_sql	 = sprintf("SELECT `fav_list` FROM `db_%sfavorites` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		$f_q	 = $db->execute($f_sql);
		$f_r	 = $f_q->fields("fav_list");
	    }
	    if($cfg["file_history"] == 1){//delete from history
		$h_sql	 = sprintf("SELECT `history_list` FROM `db_%shistory` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		$h_q	 = $db->execute($h_sql);
		$h_r	 = $h_q->fields("history_list");
	    }
	    if($cfg["file_rating"] == 1){//delete from liked
		$l_sql	 = sprintf("SELECT `liked_list` FROM `db_%sliked` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		$l_q	 = $db->execute($l_sql);
		$l_r	 = $l_q->fields("liked_list");
	    }
	    if($cfg["file_watchlist"] == 1){//delete from watchlist
		$w_sql	 = sprintf("SELECT `watch_list` FROM `db_%swatchlist` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		$w_q	 = $db->execute($w_sql);
		$w_r	 = $w_q->fields("watch_list");
	    }

	if ($db_tbl != 'blog') {
	$p_sql	 = sprintf("SELECT `pl_id`, `pl_files` FROM `db_%splaylists` WHERE `usr_id`='%s'", $db_tbl, $usr_id);
	$p_q	 = $db->execute($p_sql);
	$p_r	 = $p_q->getrows();

	/* delete from playlists */
	for($i = 0; $i < count($p_r); $i++){
	$p_arr = $p_r[$i]["pl_files"] != '' ? unserialize($p_r[$i]["pl_files"]) : NULL;
	    if(count($p_arr) > 0){
		foreach($del_arr as $uval){
		    if(is_array($p_arr) and in_array($uval, $p_arr)){
			unset($p_arr[array_search($uval, $p_arr)]);
		    }
		}
		$p_arr 	= array_values($p_arr);
		$sql 	= sprintf("UPDATE `db_%splaylists` SET `pl_files`='%s' WHERE `usr_id`='%s' AND `pl_id`='%s' LIMIT 1;", $db_tbl, ((count($p_arr) > 0) ? serialize($p_arr) : NULL), $usr_id, $p_r[$i]["pl_id"]);
		$db->execute($sql);
echo		$do_js	= $usr_key == '' ? VGenerate::declareJS('$("#file-menu-entry6-sub'.$db_tbl[0].$p_r[$i]["pl_id"].'-count").html("'.count($p_arr).'")') : NULL;
	    }
	}
	}

	if(count($del_arr) > 0 and ($cfg["file_delete_method"] == 3 or $cfg["file_delete_method"] == 4)){
	    $f_arr = $f_r != '' ? unserialize($f_r) : NULL;
	    $l_arr = $l_r != '' ? unserialize($l_r) : NULL;
	    $h_arr = $h_r != '' ? unserialize($h_r) : NULL;
	    $w_arr = $w_r != '' ? unserialize($w_r) : NULL;

	    foreach($del_arr as $val){
		/* db count nr */
		$db_ct	 = $db->execute(sprintf("UPDATE `db_accountuser` SET `usr_%s_count`=`usr_%s_count`-1 WHERE `usr_id`='%s' LIMIT 1;", $db_tbl[0], $db_tbl[0], $usr_id));
		$cl_msg	 = $db->execute("UPDATE `db_messaging` SET `msg_".$db_tbl."_attch`='0' WHERE `msg_".$db_tbl."_attch`='".$val."';");
		/* delete from favorites */
		if(is_array($f_arr) and in_array($val, $f_arr)){
		    unset($f_arr[array_search($val, $f_arr)]); $f_arr = array_values($f_arr);
		    $sql = (count($f_arr) > 0) ? sprintf("UPDATE `db_%sfavorites` SET `fav_list`='%s' WHERE `usr_id`='%s'", $db_tbl, serialize($f_arr), $usr_id) : sprintf("DELETE FROM `db_%sfavorites` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		    $db->execute($sql);
echo		    $do_js = $usr_key == '' ? VGenerate::declareJS('$("#file-menu-entry2-count").html("'.count($f_arr).'");') : NULL;
		}
		/* delete from liked */
		if(is_array($l_arr) and in_array($val, $l_arr)){
		    unset($l_arr[array_search($val, $l_arr)]); $l_arr = array_values($l_arr);
		    $sql = (count($l_arr) > 0) ? sprintf("UPDATE `db_%sliked` SET `liked_list`='%s' WHERE `usr_id`='%s'", $db_tbl, serialize($l_arr), $usr_id) : sprintf("DELETE FROM `db_%sliked` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		    $db->execute($sql);
echo		    $do_js = $usr_key == '' ? VGenerate::declareJS('$("#file-menu-entry3-count").html("'.count($l_arr).'");') : NULL;
		}
		/* delete from history */
		if(is_array($h_arr) and in_array($val, $h_arr)){
		    unset($h_arr[array_search($val, $h_arr)]); $h_arr = array_values($h_arr);
		    $sql = (count($h_arr) > 0) ? sprintf("UPDATE `db_%shistory` SET `history_list`='%s' WHERE `usr_id`='%s'", $db_tbl, serialize($h_arr), $usr_id) : sprintf("DELETE FROM `db_%shistory` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		    $db->execute($sql);
echo		    $do_js = $usr_key == '' ? VGenerate::declareJS('$("#file-menu-entry4-count").html("'.count($h_arr).'");') : NULL;
		}
		/* delete from watchlist */
		if(is_array($w_arr) and in_array($val, $w_arr)){
		    unset($w_arr[array_search($val, $w_arr)]); $w_arr = array_values($w_arr);
		    $sql = (count($w_arr) > 0) ? sprintf("UPDATE `db_%swatchlist` SET `watch_list`='%s' WHERE `usr_id`='%s'", $db_tbl, serialize($w_arr), $usr_id) : sprintf("DELETE FROM `db_%swatchlist` WHERE `usr_id`='%s' LIMIT 1;", $db_tbl, $usr_id);
		    $db->execute($sql);
echo		    $do_js = $usr_key == '' ? VGenerate::declareJS('$("#file-menu-entry5-count").html("'.count($w_arr).'");') : NULL;
		}
		/* delete from remote servers */
		$rq	 = $db->execute(sprintf("SELECT `upload_server`, `thumb_server` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $val));
		if ($rq->fields["upload_server"] > 0 or $rq->fields["thumb_server"] > 0) {
			VbeServers::remoteDelete($val, $db_tbl);
                        $r = $db->execute(sprintf("UPDATE `db_%sfiles` SET `upload_server`='0', `thumb_server`='0' WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $val));
		}
		/* delete from responses, comments, ratings, subtitles, payouts */
		$pu	 = $db->execute(sprintf("DELETE FROM `db_%spayouts` WHERE `file_key`='%s';", $db_tbl, $val));
		$ru	 = $db->execute(sprintf("DELETE FROM `db_%sresponses` WHERE `file_key`='%s';", $db_tbl, $val));
		$cu	 = $db->execute(sprintf("DELETE FROM `db_%scomments` WHERE `file_key`='%s';", $db_tbl, $val));
		$cu	 = $db->execute(sprintf("DELETE FROM `db_%srating` WHERE `file_key`='%s';", $db_tbl, $val));
		$cu	 = $db->execute(sprintf("DELETE FROM `db_%sque` WHERE `file_key`='%s';", $db_tbl, $val));
		$cu      = $db->execute(sprintf("DELETE FROM `db_%ssubs` WHERE `file_key`='%s';", $db_tbl, $val));
		$cu      = $db->execute(sprintf("DELETE FROM `db_%stransfers` WHERE `file_key`='%s';", $db_tbl, $val));
		$cu	 = $db->execute(sprintf("UPDATE `db_%splaylists` SET `pl_thumb`='' WHERE `pl_thumb`='%s';", $db_tbl, $val));
		$cu 	 = $db_tbl === 'video' ? $db->execute(sprintf("DELETE FROM `db_%sdl` WHERE `file_key`='%s';", $db_tbl, $val)) : null;
		/* add live temp */
		if ($db_tbl == 'live') {
			$fn = $dbc->singleFieldValue('db_livefiles', 'file_name', 'file_key', $val);
			if ($fn != '') {
				$db->execute(sprintf("INSERT INTO `db_%stemps` (`file_key`, `date`) VALUES ('%s', '%s');", $db_tbl, $fn, date("Y-m-d H:i:s")));
			}
		}
		$rc	 = $db->execute("SELECT `file_key`, `file_responses` FROM `db_".$db_tbl."responses` WHERE `file_responses` LIKE '%".$val."%' LIMIT 1;");
		if($rc->fields["file_responses"] != ''){
		    $f		 = NULL;
		    $r_arr	 = array();
		    $r_key	 = $rc->fields["file_key"];
		    $r_arr	 = unserialize($rc->fields["file_responses"]);
		    foreach($r_arr as $rk => $rv){
			if($rv["file_key"] == $val){
			    $f	 = $rk;
			}
		    }
		    if($f >= 0){
			unset($r_arr[$f]);
			$r_arr 	 = array_values($r_arr);

			$r_t 	 = count($r_arr);
			if($r_t == 0){
			    $db->execute(sprintf("DELETE FROM `db_%sresponses` WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $r_key));
			    $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_responses`='0' WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $r_key));
			} else {
			    $db->execute(sprintf("UPDATE `db_%sresponses` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $db_tbl, serialize($r_arr), $r_key));
			    $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $r_t, $r_key));
			}
		    }
		}
	    }
	}
	}
    }
    /* update responses array */
    function updateResponseArray($type, $key, $action){
	$db	 = self::$db;

	$sql	 = sprintf("SELECT `file_key`, `file_responses` FROM `db_%sresponses` WHERE `file_responses` LIKE '%s' LIMIT 1;", $type, '%s:10:"'.$key.'"%');
	$rt      = $db->execute($sql);
	$fk	 = $rt->fields["file_key"];

	if($rt->fields["file_responses"] != ''){
	    $resp = unserialize($rt->fields["file_responses"]);
	    foreach($resp as $rk => $rv){
		if($rv["file_key"] == $key){
		    if($action == 'resp-disable' or $action == 'resp-enable' or $action == 'cb-rdisable' or $action == 'cb-renable'){
			$resp[$rk]["active"] = ($action == 'resp-disable' or $action == 'cb-rdisable') ? 0 : 1;
		    } elseif($action == 'resp-delete' or $action == 'cb-rdel'){
			unset($resp[$rk]);
		    }
		}
	    }
	    $resp = array_values($resp);
	    $tres = count($resp);
	    $unr  = ($action == 'resp-delete' or $action == 'cb-rdel') ? $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $type, $tres, $fk)) : NULL;
return	    $upq  = $tres > 0 ? sprintf("UPDATE `db_%sresponses` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $type, serialize($resp), $fk) : sprintf("DELETE FROM `db_%sresponses` WHERE `file_key`='%s' LIMIT 1;", $type, $fk);
	}
    }
    /* file checkbox actions */
    function doActions($type){
	$db		 = self::$db;
	$cfg		 = self::$cfg;
	$class_database  = self::$dbc;
	$language	 = self::$language;
	$class_filter	 = self::$filter;
	$href		 = self::$href;
	$section	 = self::$section;
	$upage_id	 = null;

	$sel_count 	 = isset($_POST["fileid"]) ? (int) count($_POST["fileid"]) : 0;
	$sort_type	 = $class_filter->clr_str($_GET["for"]);
	$sort_type	 = ($section == $href["files"] and isset($_GET["t"])) ? 'sort-'.$class_filter->clr_str($_GET["t"]) : $sort_type;
	$sort_type	 = $section == $href["watch"] ? 'sort-'.$class_filter->clr_str($_POST["uf_type"]) : $sort_type;
	$sort_type	 = $section == $href["see_responses"] ? 'sort-'.$class_filter->clr_str($_POST["resp_type"]) : $sort_type;
	$sort_type	 = $section == $href["index"] ? 'sort-'.$class_filter->clr_str($_POST["sort_type"]) : $sort_type;
	$sort_type	 = $section == $href["search"] ? 'sort-video' : $sort_type;
	$db_tbl		 = substr($sort_type, 5);
	$usr_id		 = self::getUserID();
	
	if ($usr_id == 0) {
		return;
	}

	switch($type){
	    case "comm-disable": $sql = sprintf("UPDATE `db_%scomments` SET `c_active`='0' WHERE `c_key`='%s' LIMIT 1;", $db_tbl, ''); break;
	    case "cb-private": $sql = sprintf("UPDATE `db_%sfiles` SET `privacy`='private' WHERE `usr_id`='%s' AND (##KEYS##) LIMIT %s;", $db_tbl, $usr_id, $sel_count); break;
	    case "cb-public": $sql = sprintf("UPDATE `db_%sfiles` SET `privacy`='public' WHERE `usr_id`='%s' AND (##KEYS##) LIMIT %s;", $db_tbl, $usr_id, $sel_count); break;
	    case "cb-personal": $sql = sprintf("UPDATE `db_%sfiles` SET `privacy`='personal' WHERE `usr_id`='%s' AND (##KEYS##) LIMIT %s;", $db_tbl, $usr_id, $sel_count); break;
	    case "cb-favadd":
	    case "cb-watchadd":
	    case "cb-watchclear":
	    case "cb-favclear":
	    case "cb-likeclear":
	    case "cb-histclear":
		$sql = self::favplSQL(($type == 'cb-likeclear' ? 'liked' : ($type == 'cb-histclear' ? 'hist' : (($type == 'cb-watchadd' or $type == 'cb-watchclear') ? 'watch' : 'fav'))), $db_tbl, $usr_id, $type, $sel_count);
	    break;
	    case "cb-delete":
		if($cfg["paid_memberships"] == 1 and ($cfg["file_delete_method"] == 2 or $cfg["file_delete_method"] == 4)){
		    $sql_sub = sprintf("SELECT `file_size` FROM `db_%sfiles` WHERE `usr_id`='%s' AND (##KEYS##)", $db_tbl, $usr_id);
		}
		switch($cfg["file_delete_method"]){
		    case "1":
		    case "2":
			$sql = sprintf("UPDATE `db_%sfiles` SET `deleted`='1' WHERE `usr_id`='%s' AND (##KEYS##)", $db_tbl, $usr_id);
		    break;
		    case "3":
		    case "4":
			$sql = sprintf("DELETE `files` FROM `db_%sfiles` AS `files` 
				WHERE `files`.`usr_id` = '%s' AND (##KEYS##)", $db_tbl, $usr_id);
		    break;
		}
	    break;
	    default:
		$chk_for	= ($section != $href["see_responses"] and $section != $href["user"]) ? $_GET["a"] : $_GET["do"];

		if(substr($chk_for, 0, 8) == 'cb-label'){
		    $type	= 'cb-label';
		    $do_arr	= explode("-", $chk_for);
		    if(substr($do_arr[2], 0, 3) == 'add'){
			$pl_id	= intval(substr($do_arr[2], 3));
			$pl_act	= 'add';
		    } elseif(substr($do_arr[2], 0, 5) == 'clear'){
			$pl_id	= intval(substr($do_arr[2], 5));
			$pl_act	= 'clear';
		    }

		    $sql 	= self::favplSQL('pl', $db_tbl, $usr_id, $type, $sel_count, $pl_id, $pl_act);
		}
	    break;
	}

	if($sel_count > 0){
	    $db_whr_field = 'file_key';

	    if($type == 'cb-private' or $type == 'cb-public' or $type == 'cb-personal'){
		for($i=0; $i<$sel_count; $i++) { $q .= "`".$db_whr_field."` = '".$class_filter->clr_str($_POST["fileid"][$i])."' OR "; }
	    }elseif($type == 'cb-delete'){
		$dbf     = ($type == 'cb-delete' and ($cfg["file_delete_method"] == 1 or $cfg["file_delete_method"] == 2)) ? NULL : "`files`.";
		for($i=0; $i<$sel_count; $i++) {
		    $del_arr[$i] = $class_filter->clr_str($_POST["fileid"][$i]);
		    $q .= $dbf."`".$db_whr_field."` = '".$class_filter->clr_str($_POST["fileid"][$i])."' OR ";
		    $q1.= $cfg["paid_memberships"] == 1 ? "(".$dbf."`".$db_whr_field."` = '".$class_filter->clr_str($_POST["fileid"][$i])."' AND `is_subscription`='1') OR " : NULL;
		}
	    }
	    if($type == 'cb-delete'){
	    	foreach ($del_arr as $dfk) {
	    		// delete from remote servers
	    		$rq = $db->execute(sprintf("SELECT `upload_server`, `thumb_server` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $dfk));
	    		if ($rq->fields["upload_server"] > 0 or $rq->fields["thumb_server"] > 0) {
	    			VbeServers::remoteDelete($dfk, $db_tbl);
	    			$r = $db->execute(sprintf("UPDATE `db_%sfiles` SET `upload_server`='0', `thumb_server`='0' WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $dfk));
	    			$r = $db->execute(sprintf("DELETE FROM `db_%stransfers` WHERE `file_key`='%s' LIMIT 1;", $db_tbl, $dfk));
	    		}
	    	}
	    }

    	    $wh_sql 	 = substr($q, 0, -3);
    	    $sql	 = str_replace("##KEYS##", $wh_sql, $sql);
    	    /* delete from subscription used space */
    	    if($type == 'cb-delete' and $cfg["paid_memberships"] == 1 and ($cfg["file_delete_method"] == 2 or $cfg["file_delete_method"] == 3 or $cfg["file_delete_method"] == 4)){
    		$wh_sql1 = substr($q1, 0, -3);
		$sql_sub = str_replace('`files`.', '', str_replace("##KEYS##", $wh_sql1, $sql_sub));
    		$rsub	 = $db->execute($sql_sub);
    		if($rsub){
    		    while(!$rsub->EOF){
    		    	$_q	= sprintf("UPDATE `db_packusers` SET `pk_usedspace`=`pk_usedspace` - %s, `pk_total_%s`=`pk_total_%s` - 1 WHERE `usr_id`='%s' AND (`pk_usedspace` > 0 OR `pk_total_%s` > 0) LIMIT 1;", $rsub->fields["file_size"], $db_tbl, $db_tbl, $usr_id, $db_tbl);
    			$db->execute($_q);

    			@$rsub->MoveNext();
    		    }
    		}
    	    }
    	    if($type == 'cb-delete'){
    		//delete from own entries
    		$del_fav	= self::clearFavPl($del_arr, $db_tbl);
    		//delete from other user's entries
        	$del_other   	= self::fileDeleteOther($db_tbl, $del_arr, array(0 => "favorites", 1 => "fav_list"));
        	$del_other   	= self::fileDeleteOther($db_tbl, $del_arr, array(0 => "history", 1 => "history_list"));
        	$del_other   	= self::fileDeleteOther($db_tbl, $del_arr, array(0 => "liked", 1 => "liked_list"));
        	$del_other   	= self::fileDeleteOther($db_tbl, $del_arr, array(0 => "watchlist", 1 => "watch_list"));
            }

    	    $do_action	 = $db->execute($sql);
    	    if($do_action){
		if($cfg["activity_logging"] == 1 and ($type == 'cb-favadd' or $type == 'cb-delete')){
		    $action = new VActivity($usr_id);
		    for($i=0; $i<$sel_count; $i++){
			$action->addTo(($type == 'cb-favadd' ? 'log_fav' : 'log_delete'), $db_tbl.':'.self::keyCheck($class_filter->clr_str($_POST["fileid"][$i])));
			$dbu	 = $type == 'cb-delete' ? $db->execute("UPDATE `db_useractivity` SET `act_deleted`='1' WHERE `act_type` LIKE '%".$class_filter->clr_str($_POST["fileid"][$i])."%';") : NULL;
		    }
		}
		$pl_ct	 = ($type == 'cb-private' or $type == 'cb-public' or $type == 'cb-personal') ? self::getPlTypes('file-menu-entry6', 0) : NULL;
		if($upage_id == ''){
echo 			$html	 = VGenerate::noticeWrap(array('', '', VGenerate::noticeTpl('', '', $language["notif.success.request"], '')));
		}
		if($upage_id == '' and ($pl_act == 'add' or $pl_act == 'clear')){
		    $c_pl	 = substr($_GET["s"], 21);
		    $ht_js 	.= '$("#file-menu-entry6-sub'.$db_tbl[0].$pl_id.'-count").html("'.self::fileCount(array($db_tbl, $pl_id)).'");';
		    $ht_js 	.= '$("#file-menu-entry6-sub'.$db_tbl[0].$c_pl.'-count").html("'.self::fileCount(array($db_tbl, $c_pl)).'");';
		}
echo   		$js	 = ($upage_id == '' and $section != $href["watch"] and $section != $href["browse"]) ? VGenerate::declareJS($ht_js) : NULL;
    	    }
	    if($section != $href["see_responses"]){
		return true;
	    }
	} else {
echo 		$html	 = VGenerate::noticeWrap(array('', '', VGenerate::noticeTpl('', $language["notif.no.multiple.select"], '')));
	    return false;
	}
    }
    /* db id check */
    function keyCheck($key){
	$new_key	 = strlen($key) > 10 ? substr($key, 0, -1) : $key;

	return $new_key;
    }
    /* get db file count */
    function fileCountDB($get_array){
	$db	 = self::$db;
	$cfg	 = self::$cfg;

	if($get_array["db_fields"] != 'total'){
	    $sql 	 = sprintf("SELECT `%s` FROM `db_%s%s` WHERE %s", $get_array["db_select"], $get_array["db_tbl"], $get_array["db_from"], $get_array["db_where"]);
	} else {
	    $sql	 = sprintf("SELECT `file_key` FROM `db_%sfiles` WHERE %s", $get_array["db_tbl"], $get_array["db_where"]);
	    $res	 = $db->execute($sql);
	    if($res){
		$s	 = 0;
		while(!$res->EOF){
		    $key = $res->fields["file_key"];
		    $dbf = "AND `deleted`='0' AND `active`='1'";
		    $del = $db->execute(sprintf("SELECT `usr_id` FROM `db_%sfiles` WHERE %s AND `file_key`='%s' %s LIMIT 1;", $get_array["db_tbl"], $get_array["db_where"], $key, $dbf));
		    if($del->recordcount() > 0) $s+=1;
		    @$res->MoveNext();
		}
	    }
	}

	$rs	 	 = $db->execute($sql);
	$rs_db	 	 = $get_array["db_fields"] != 'total' ? $rs->fields[$get_array["db_fields"]] : NULL;
	$total   	 = $get_array["db_fields"] != 'total' ? ($rs_db == '' ? 0 : self::finalDBcount($get_array["db_tbl"], unserialize($rs_db))) : $s;

	return $total;
    }
    /* get final db count, check private or inactive or not approved files */
    function finalDBcount($db_tbl, $file_array){
	$db	 = self::$db;

	foreach($file_array as $val){
	    $q		.= self::fileKeyCheck($db_tbl, $val);
	}
	$q	 = $q != '' ? $q : "(A.`approved`='1' AND A.`deleted`='0') OR ";
	$sql	 = sprintf("SELECT A.`db_id`, A.`usr_id`, A.`file_key`, A.`privacy`, A.`approved`, A.`active` FROM `db_%sfiles` A WHERE A.`active`='1' %s AND A.`usr_id`>'0' AND ", $db_tbl, "");
	$cq 	 = $q != '' ? $sql.' ('.substr($q, 0, -3).')' : substr($sql, 0, -4);
	$rs	 = $db->execute($cq);

	return $rs->recordcount();
    }
    /* count files */
    function fileCount($for, $type=''){
	$cfg		= self::$cfg;
	$db		= self::$db;
	$class_database = self::$dbc;
	$href		= self::$href;
	$section	= self::$section;

	$usr_id		= intval($_SESSION["USER_ID"]);
	$type		= $type == '' ? substr($_GET["for"], 5) : $type;

	$menu_db 	= $class_database->singleFieldValue('db_filetypemenu', 'value', 'usr_id', $usr_id);
	$type		= ($section == $href["files"] and $menu_db != '' and $cfg[($menu_db != 'doc' ? $menu_db : 'document')."_module"] == 1) ? $menu_db : $type;
	$db_tbl 	= $type == '' ? ($cfg["video_module"] == 1 ? 'video' : ($cfg["live_module"] == 1 ? 'live' : ($cfg["image_module"] == 1 ? 'image' : ($cfg["audio_module"] == 1 ? 'audio' : ($cfg["document_module"] == 1 ? 'doc' : NULL))))) : $type;

	switch($for){
	    case "file-menu-entry1"://files
		$get_array = array("db_select" => "count(`db_id`) AS `total`", "db_tbl" => $db_tbl, "db_from" => "files", "db_where" => "`usr_id`='".$usr_id."'", "db_fields" => "total");
	    break;
	    case "file-menu-entry2"://favorites
		$get_array = array("db_select" => "fav_list", "db_tbl" => $db_tbl, "db_from" => "favorites", "db_where" => "`usr_id`='".$usr_id."'", "db_fields" => "fav_list");
	    break;
	    case "file-menu-entry3"://liked
		$get_array = array("db_select" => "liked_list", "db_tbl" => $db_tbl, "db_from" => "liked", "db_where" => "`usr_id`='".$usr_id."'", "db_fields" => "liked_list");
	    break;
	    case "file-menu-entry4"://history
		$get_array = array("db_select" => "history_list", "db_tbl" => $db_tbl, "db_from" => "history", "db_where" => "`usr_id`='".$usr_id."'", "db_fields" => "history_list");
	    break;
	    case "file-menu-entry5"://watchlist
		$get_array = array("db_select" => "watch_list", "db_tbl" => $db_tbl, "db_from" => "watchlist", "db_where" => "`usr_id`='".$usr_id."'", "db_fields" => "watch_list");
	    break;
	    case "file-menu-entry7"://file comments
		$sql	   = sprintf("SELECT A.`c_id`, B.`usr_id` FROM `db_%scomments` A, `db_%sfiles` B WHERE A.`file_key`=B.`file_key` AND B.`usr_id`='%s';", $db_tbl, $db_tbl, $usr_id);
		$rs	   = $db->execute($sql);
		return $rs->recordcount();
	    break;
	    case "file-menu-entry8"://file responses
		$sql     = sprintf("SELECT 
                                    A.`file_responses`, 
                                    B.`file_key`, B.`file_title` 
                                    FROM `db_%sresponses` A, `db_%sfiles` B 
                                    WHERE 
                                    A.`file_key`=B.`file_key` 
                                    AND B.`usr_id`='%s'", $db_tbl, $db_tbl, $usr_id);
		$rs	 = $db->execute($sql);
		$t	 = $rs->recordcount();
		$r	 = $rs->getrows();
		$tt	 = 0;

		for($i=0; $i<$t; $i++){
		    $tt	+= count(unserialize($r[$i]["file_responses"]));
		}
		return $tt;
	    break;
	    default://playlists
		$get_array = array("db_select" => "pl_files", "db_tbl" => $db_tbl, "db_from" => "playlists", "db_where" => "`usr_id`='".$usr_id."' AND `pl_id`='".(is_array($for) ? $for[1] : substr($_GET["s"], 21))."'", "db_fields" => "pl_files");
	    break;
	}
	$total 		 = self::fileCountDB($get_array);

	return $total;
    }
    /* get playlists types */
    function getPlTypes($id, $do_return=1){
	$cfg		 = self::$cfg;
	$db		 = self::$db;
	$language	 = self::$language;

	$s		 = 0;
	$pl_total	 = 0;
	$usr_id		 = (int) $_SESSION["USER_ID"];
	$for		 = array('live'=>'live', 'video'=>'video', 'image'=>'image', 'audio'=>'audio', 'document'=>'doc', 'blog'=>'blog');

	$html	 = '<div style="display: none;">';
	$html	.= '<ul class="sort-nav inner-menu" style="display: none;">';
	foreach($for as $key => $val){
	    if($cfg[$key.'_module'] == 1){
		    if (self::$section == self::$href["playlists"] or self::$section == self::$href["channel"] or self::$section == self::$href["search"]) {
			$pl_sql	 = sprintf("SELECT `pl_id`, `pl_name`, `pl_date`, `pl_files` FROM `db_%splaylists` WHERE `pl_active`='1' AND `pl_privacy`='public' ORDER BY `pl_id` ASC;", $val);
		    } else {
			$pl_sql	 = sprintf("SELECT `pl_id`, `pl_name`, `pl_date`, `pl_files` FROM `db_%splaylists` WHERE `usr_id`='%s' AND `pl_active`='1' ORDER BY `pl_id` ASC;", $val, $usr_id);
		    }
		$pl	 = $db->execute($pl_sql);
		$pl_arr  = $pl->getrows();
		$pl_nr	 = count($pl_arr);
		if($pl_nr > 0){
		    for($i=0; $i<$pl_nr; $i++){
			if($pl_arr[$i][3] != ''){
			    $pl_count = $cfg["file_counts"] == 1 ? self::finalDBcount($val, unserialize($pl_arr[$i][3])) : 0;
			} else $pl_count = 0;
			if($do_return == 0){
			}
			$html	.= '<li id="'.$id.'-sub'.$key[0].$pl_arr[$i][0].'" class="menu-panel-entry-sub pointer pl-entry">';
			$html	.= '<span class="bold no-display">'.$pl_arr[$i][1].'</span><a href="javascript:;"><span class="normal mm">'.VUserinfo::truncateString($pl_arr[$i][1], 35).'</span></a> '.($cfg["file_counts"] == 1 ? '<span class=""><span id="'.$id.'-sub'.$key[0].$pl_arr[$i][0].'-count" class="right-float mm-count">'.$pl_count.'</span></span>' : NULL);
			$html	.= '</li>';
			$s	 = $s+1;
		    }
		}
		$pl_total	+= $pl_nr;
	    }
	}
	$html	.= '</ul>';
	$html	.= '</div>';

	if($do_return == 1) return $html;
    }
    /* user playlists nav menu entries */
    function userPlaylists($for){
	$cfg = self::$cfg;

	if($cfg["file_playlists"] == 0) return false;

	return self::getPlTypes($for);
    }
    /* file settings contents */
    function fileSettingsHTM($type, $val, $readonly = false){
	$language		= self::$language;

	switch($type){
	    case "option_title":
		$opt_type       = 1;
		$label 		= $language["files.text.file.title"];
		$info_array	= array(0 => "file_title");
	    break;
	    case "option_descr":
		$opt_type       = 1;
		$label 		= $language["files.text.file.descr"];
		$info_array	= array(0 => "file_descr");
	    break;
	    case "option_tags":
		$opt_type       = 1;
		$label 		= $language["files.text.file.tags"];
		$info_array     = array(0 => "file_tags");
	    break;
	    case "option_stream_server":
		$opt_type       = 1;
		$label 		= $language["files.text.stream.server"];
		$info_array     = array(0 => "stream_server", 1 => "readonly");
	    break;
	    case "option_stream_name":
		$opt_type       = 1;
		$label 		= $language["files.text.stream.name"];
		$info_array     = array(0 => "stream_key", 1 => "readonly");
	    break;
	    case "option_categ":
		$opt_type       = 1;
		$label 		= $language["files.text.file.categ"];
		$info_array     = array(0 => "file_category");
	    break;
	    case "option_privacy":
		$opt_type	= 2;
		$lang_array 	= array("public" => $language["files.text.public"], "private" => $language["files.text.private"], "personal" => $language["files.text.personal"]);
	    break;
	    case "option_comments":
		$opt_type	= 2;
		$lang_array 	= array("all" => $language["files.text.comments.auto"], "fronly" => $language["files.text.comments.fronly"], "approve" => $language["files.text.comments.approve"], "none" => $language["files.text.comments.none"]);
	    break;
	    case "option_votes":
		$opt_type	= 2;
		$lang_array     = array("1" => $language["files.text.comments.vote.all"], "0" => $language["files.text.comments.vote.none"]);
	    break;
	    case "option_spam":
		$opt_type	= 2;
		$lang_array     = array("1" => $language["files.text.comments.spam.all"], "0" => $language["files.text.comments.spam.none"]);
	    break;
	    case "option_responses":
		$opt_type	= 2;
		$lang_array     = array("all" => $language["files.text.responses.all"], "approve" => $language["files.text.responses.approve"], "none" => $language["files.text.responses.none"]);
	    break;
	    case "option_rating":
		$opt_type	= 2;
		$lang_array     = array("1" => $language["files.text.rating.all"], "0" => $language["files.text.rating.none"]);
	    break;
	    case "option_embed":
		$opt_type	= 2;
		$lang_array     = array("1" => $language["files.text.embed.all"], "0" => $language["files.text.embed.none"]);
	    break;
	    case "option_social":
		$opt_type	= 2;
		$lang_array     = array("1" => $language["files.text.social.share"], "0" => $language["files.text.social.none"]);
	    break;
	    case "option_chat":
		$opt_type	= 2;
		$lang_array     = array("1" => $language["files.text.live.chat"], "0" => $language["files.text.live.chat.none"]);
	    break;
	    case "option_vod":
		$opt_type	= 2;
		$lang_array     = array("1" => $language["files.text.live.vod"], "0" => $language["files.text.live.vod.none"]);
	    break;
	    case "option_thumbnail":
		$opt_type	= 2;
	    break;
	}
	switch($opt_type){
	    case "2":
		$cls0		= 'bottom-border-only1';
		$cls1		= 'file-option-trg';
		$cls2		= 'ct-bullet-out';
		$cls3		= 'no-display';
		$cls4		= 'greyed-out';
	    break;
	    case "1":
		$cls0		= 'no-bottom-border';
		$cls1		= 'file-option-cls';
		$cls2		= 'ct-bullet-in';
		$cls3		= '';
		$cls4		= 'bold';
	    break;
	}

	$ht_ct	.= $opt_type == 1 ? self::fileSettingsInfo($info_array, $val) : self::fileSettingsTypes($type, $lang_array, $val);

	$html	.= '<div id="'.$type.'">';
	$html	.= '<div class="settings-wrapper">';
	$html	.= '<label class="">'.$label.'</label>';
	$html	.= '</div>';
	$html	.= '<div class="settings-wrapper">'.$ht_ct.'</div>';
	$html	.= '</div>';

	return $html;
    }
    /* html category select */
    function fileCategorySelect($for, $_ct_id='', $db_id=0){
	include 'f_core/config.backend.php';
	
	$db		= self::$db;
	$class_database = self::$dbc;
	$class_filter	= self::$filter;

	switch($for){
	    case "file_edit":
		$key	 = isset($_GET["l"]) ? 'l'.$class_filter->clr_str($_GET["l"]) : (isset($_GET["v"]) ? 'v'.$class_filter->clr_str($_GET["v"]) : (isset($_GET["i"]) ? 'i'.$class_filter->clr_str($_GET["i"]) : (isset($_GET["a"]) ? 'a'.$class_filter->clr_str($_GET["a"]) : (isset($_GET["d"]) ? 'd'.$class_filter->clr_str($_GET["d"]) : (isset($_GET["b"]) ? 'b'.$class_filter->clr_str($_GET["b"]) : (null))))));
		$s_id	 = 'edit_category';
	    break;
	    case "upload":
		$key	 = $class_filter->clr_str($_GET["t"]);
		$s_id	 = 'upload_category';
	    break;
	    case "backend":
		$key	 = $_ct_id[0];
		$s_id	 = 'file_category';
	    break;
	}

	switch($key[0]){
            case "l": $tbl = 'live'; break;
            case "v": $tbl = 'video'; break;
            case "i": $tbl = 'image'; break;
            case "a": $tbl = 'audio'; break;
            case "d": $tbl = 'doc'; break;
	    case "b": $tbl = 'blog'; break;
        }

	
	$fortmp	 = $for;
	$for	 = (strpos($_SERVER['REQUEST_URI'], $backend_access_url)) ? 'backend' : $for;
	$ct_id	 = $for != 'backend' ? $class_database->singleFieldValue('db_'.$tbl.'files', 'file_category', 'file_key', ($for == 'upload' ? $key : substr($key, 1))) : substr($_ct_id, 1);
	$ct_name = $class_database->singleFieldValue('db_categories', 'ct_name', 'ct_id', $ct_id);
	$ct	 = $db->execute(sprintf("SELECT `ct_id`, `ct_name`, `ct_lang` FROM `db_categories` WHERE `ct_type`='%s' AND `ct_active`='1';", $tbl));
        $js	 = $for != 'backend' ? 'onchange="$(\'#input-loc\').val(this.value);$(\'#input-loc-tmp\').val(this.options[this.selectedIndex].text);"' : NULL;
        $n	 = $for != 'backend' ? 'file_category_sel' : 'file_category_'.$db_id;
	$ht	.= '<select id="'.$s_id.'" name="'.$n.'" '.$js.' class="signup-select select-input category-select">';
	
	if($ct){
	    $s	 = 0;
	    while(!$ct->EOF) {
	    	$ct_lang = unserialize($ct->fields["ct_lang"]);
	    	$ct_src  = $_SESSION["fe_lang"] != 'en_US' ? ($ct_lang[$_SESSION["fe_lang"]] != '' ? $ct_lang[$_SESSION["fe_lang"]] : $ct->fields["ct_name"]) : $ct->fields["ct_name"];
		if($for == 'upload' and $s == 0){
		    $_SESSION["file_category"] = $ct->fields["ct_id"];
		}
		$ht	.= '<option value="'.$ct->fields["ct_id"].'"'.($ct->fields["ct_id"] == $ct_id ? ' selected="selected"' : NULL).'>'.VUserinfo::truncateString($ct_src, 30).'</option>';
		$ct->MoveNext();
		$s	+= 1;
	    }
	}
	
	$ht	.= '</select>';
	
	return $ht;
    }
	/* html file details (title, descr, tags, categ) */
	function fileSettingsInfo($info_array, $val) {
		$class_filter	= self::$filter;
		$ht_cls		= null;

		switch ($info_array[0]) {
			case "stream_server":
				$ro   = $info_array[1] == 'readonly' ? 'readonly="readonly" onclick="this.select()"' : null;
				$srv  = VServer::getFreeServer('bcast');
				$html = VGenerate::simpleDivWrap($ht_cls, '', '<input type="text" name="files_text_stream_server" class="login-input" value="' . $srv . '" '.$ro.'/>');
				break;
			case "stream_key":
				$hashed = strrev(md5($_SESSION["USER_ID"].$_SESSION["USER_KEY"].self::$cfg["global_salt_key"]));
				$ro   = $info_array[1] == 'readonly' ? 'readonly="readonly" onclick="this.select()"' : null;
				$html = VGenerate::simpleDivWrap($ht_cls, '', '<input type="text" name="files_text_stream_name" class="login-input" value="' . $val . '?q='.$hashed.'" '.$ro.'/>');
				break;
			case "file_title":
				$html = VGenerate::simpleDivWrap($ht_cls, '', '<input type="text" name="files_text_file_title" class="login-input" value="' . $val . '" />');
				break;
			case "file_descr":
				$html = VGenerate::simpleDivWrap($ht_cls, '', '<textarea name="file_descr" class="ta-input" rows="1" cols="1">' . $val . '</textarea>');
				break;
			case "file_tags":
				$html = VGenerate::simpleDivWrap($ht_cls, '', '<input type="text" name="file_tags" class="login-input" value="' . $val . '" />');
				break;
			case "file_category":
				$html = VGenerate::simpleDivWrap('selector fe', '', self::fileCategorySelect('file_edit'));
				break;
		}

		return $html;
	}

	/* html radio check options */
	function fileSettingsTypes($type, $lang_array, $val) {
		$class_filter	= self::$filter;
		$class_database = self::$dbc;
		$cfg		= self::$cfg;
		$language	= self::$language;
		

		if ($type != 'option_thumbnail') {
			foreach ($lang_array as $key => $vals) {
				$html .= '	<div class="icheck-box">
							<input type="radio"' . ($val == $key ? 'checked="checked"' : NULL) . ' name="' . $type . '" value="' . $key . '" class="file-set-input" />
							<label>' . $vals . '</label>
						</div>
					';
			}
		} elseif ($type == 'option_thumbnail' and $val[0] != 'i') {
			$key		= $class_filter->clr_str($_GET[$val[0]]);
			$usr_key	= $class_filter->clr_str($_SESSION["USER_KEY"]);
			$thumb_server	= $class_database->singleFieldValue('db_'.self::$type.'files', 'thumb_server', 'file_key', $key);
			$thumbnail	= '<img height="185" class="mediaThumb" src="' . self::thumbnail($usr_key, $key, $thumb_server) . '?t='.rand(0,99999).'">';

			$html .= VGenerate::simpleDivWrap('', '', $thumbnail);
			$html .= VGenerate::simpleDivWrap('vs-column fifths-off update-button', '', '<button onfocus="blur();" value="1" type="button" class="button-grey search-button form-button save-button button-blue thumb-popup" name="save_changes"><i class="icon-upload"></i> <span>'.$language["files.text.edit.thumb"].'</span></button>');

			$js = '$(".thumb-popup").click(function(){';
			$js .= 'var popupid = $(this).attr("rel");';
			$js .= '$("#popuprel").mask(" ");';
			$js .= '$("#popuprel").load("' . $cfg["main_url"] . '/' . VHref::getKey("files_edit") . '?fe=1&' . $val[0] . '=' . $key . '&do=thumb", function(){';
			$js .= '$("#popuprel").unmask();';
			$js .= '});';
			$js .= '});';

			$html .= VGenerate::declareJS('$(document).ready(function(){' . $js . '});');
		}

		return $html;
	}

	/* checks for saving */
	function saveEditCheck($post_arr, $cfg_arr) {
		foreach ($cfg_arr as $key => $val) {
			if ($cfg_arr[$key] == 0) {
				unset($post_arr[$key]);
			}
		}

		unset($post_arr["file_title"]);
		unset($post_arr["file_description"]);
		unset($post_arr["file_tags"]);
		unset($post_arr["file_category"]);
		unset($post_arr["stream_server"]);
		unset($post_arr["stream_key"]);
		unset($post_arr["stream_chat"]);
		unset($post_arr["stream_vod"]);

		return $post_arr;
	}
	/* insert media into blogs */
	public static function blog_insertMedia() {
		$language	= self::$language;
		$cfg		= self::$cfg;
		$class_filter	= self::$filter;
		$db		= self::$db;
		
		$type		= $class_filter->clr_str($_GET["t"]);
		$bkey		= $class_filter->clr_str($_GET["b"]);
		
		$js		= "$.fancybox.close(); if (typeof($('.blog-media-select li.thumb-selected').html()) != 'undefined') { tinymce.activeEditor.insertContent('[media_".$type."_'+$('.blog-media-select li.thumb-selected').attr('rel-key')+']'); }";
		
		
		$html = '<div class="lb-margins">
				<article>
					<h3 class="content-title"><i class="icon-'.($type == 'doc' ? 'file' : $type).'"></i>'.str_replace('##TYPE##', $language["frontend.global.".$type[0]], $language["files.text.insert.url.type"]).'</h3>
					<div class="line"></div>
				</article>

				<div class="tabs pltabs tabs-style-topline">
					<nav>
						<ul id="pl-tabs">
							'.('<li><a href="#section-own" class="icon icon-upload" rel="nofollow"><span>'.$language["files.text.insert.from.up"].'</span></a></li>').'
							'.('<li><a href="#section-fav" class="icon icon-heart" rel="nofollow"><span>'.$language["files.text.insert.from.fav"].'</span></a></li>').'
							'.('<li><a href="#section-search" class="icon icon-link" rel="nofollow"><span>'.$language["files.text.insert.from.url"].'</span></a></li>').'
						</ul>
					</nav>
					<div class="content-wrap">
						<section id="section-own">
							<div>
								'.self::blog_mediaList($type, false).'
								<div class="clearfix"></div>
								<center>
									<button value="1" type="submit" class="button-grey search-button form-button save-button save-entry-button" name="save_changes" onclick="'.$js.'">
										<span>'.$language["files.text.insert.url.sel"].'</span>
									</button>
									<a class="link cancel-trigger" href="javascript:;" onclick="$(\'.close-lightbox\').click()"><span>'.$language["frontend.global.cancel"].'</span></a>
								</center>
							</div>
						</section>
						<section id="section-fav">
							<div>
								'.self::blog_mediaList($type, true).'
								<div class="clearfix"></div>
								<center>
									<button value="1" type="submit" class="button-grey search-button form-button save-button save-entry-button" name="save_changes" onclick="'.$js.'">
										<span>'.$language["files.text.insert.url.sel"].'</span>
									</button>
									<a class="link cancel-trigger" href="javascript:;" onclick="$(\'.close-lightbox\').click()"><span>'.$language["frontend.global.cancel"].'</span></a>
								</center>
							</div>
						</section>
						<section id="section-search">
							<div>
								<form method="post" action="" class="entry-form-class">
									<label>'.str_replace('##TYPE##', $language["frontend.global.".$type[0]], $language["files.text.insert.url.text"]).'</label>
									<input name="bulletin_file" class="left-float text-input bulletin_file" id="bulletin-file" type="text" onclick="$(this).focus(); $(this).select();">
									<button value="1" type="button" class="button-grey search-button form-button save-button save-entry-button find-url" name="save_changes">
										<span>'.$language["frontend.global.findit"].'</span>
									</button>
								</form>
								<div id="find-url-response"></div>
							</div>
						</section>
					</div>
				</div>
			</div>
			';
		
		$ht_js	 = '(function() {[].slice.call(document.querySelectorAll(".tabs.pltabs")).forEach(function (el) {new CBPFWTabs(el);});})();';
		$ht_js	.= '
				$(".find-url").on("click", function() {
					url = current_url + menu_section + "?fe=1&b='.$bkey.'&do=find&t='.$type.'";
					$(".fancybox-inner").mask(" ");
					$.post(url, $(".entry-form-class").serialize(), function(data) {
						$("#find-url-response").html(data);
						$(".fancybox-inner").unmask();
					});
				});
				$( "#bulletin-file" ).on( "keydown", function(event) {
					if(event.which == 13) {
						event.preventDefault();
						$(".find-url").click();
					}
				});
			';
	
		$html	.= VGenerate::declareJS('$(document).ready(function(){'.$ht_js.'});');

		echo $html;
	}
	/* search by url for inserting into blogs */
	public static function blog_findMedia() {
		$language	= self::$language;
		$cfg		= self::$cfg;
		$class_filter	= self::$filter;
		$class_database	= self::$dbc;
		$db		= self::$db;
		
		$type		= $class_filter->clr_str($_GET["t"]);
		
		
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
			
			if ($db_tbl != $type) {
				echo '<p>'.$language["frontend.global.results.none"].'</p>';
				exit;
			}
			
			$_uid	= $class_database->singleFieldValue('db_' . $db_tbl . 'files', 'usr_id', 'file_key', $file_key);
			$_sql	= sprintf("SELECT
						B.`usr_key`,
						C.`thumb_server`,
						C.`file_title`
						FROM
						`db_accountuser` B, `db_%sfiles` C
						WHERE
						C.`usr_id`=B.`usr_id` AND
						C.`file_key`='%s' AND
						C.`privacy`%s AND
						C.`approved`='1' AND
						C.`deleted`='0' AND
						C.`active`='1'
						LIMIT 1;", $db_tbl, $file_key, ($_uid == $_SESSION["USER_ID"] ? "!='personal'" : "='public'"));
			
			$dbc	= $db->execute($_sql);

			if ($cfg[$m . "_module"] == 1 and $_uid > 0 and $dbc->fields["usr_id"] == $_uid) {
				$usr_key	= $dbc->fields["usr_key"];
				$thumb_server	= $dbc->fields["thumb_server"];
				$title		= $dbc->fields["file_title"];
				
				$img_src	= self::thumbnail($usr_key, $file_key, $thumb_server);
				
				$thumbnail	= '<img class="mediaThumb" src="'.$img_src.'" alt="'.$title.'" rel="tooltip" title="'.$title.'">';
				
				$js		= "$.fancybox.close(); if (typeof($('#find-url-response .vs-column').html()) != 'undefined') { tinymce.activeEditor.insertContent('[media_".$db_tbl."_".$file_key."]'); }";
				
				echo $html	= '
							<div class="vs-column fourths">'.$thumbnail.'</div>
							<div class="vs-column three_fourths fit">
								<div>'.$title.'</div>
								<div>
									<button value="1" type="button" class="button-grey search-button form-button save-button save-entry-button add-url" name="save_changes" onclick="'.$js.'">
										<span>'.$language["files.text.insert.add.to"].'</span>
									</button>
								</div>
							</div>
							<div class="clearfix"></div>
						';
			} else {
				echo '<p>'.$language["frontend.global.results.none"].'</p>';
			}
		} else {
			echo '<p>'.$language["frontend.global.results.none"].'</p>';
		}
	}
	/* adding new blog */
	public static function newBlog() {
		$language	= self::$language;
		$cfg		= self::$cfg;
		$for		= self::$type;
		$class_filter	= self::$filter;
		$class_database	= self::$dbc;
		$db		= self::$db;
		
		$blog_response	= isset($_GET["r"]) ? true : false;
		
		if ($cfg[$for."_module"] == 1) {
			if ($_POST) {
				$title	= $class_filter->clr_str($_POST["add_new_title"]);
				$descr	= $class_filter->clr_str($_POST["add_new_descr"]);
				$tags	= $class_filter->clr_str($_POST["add_new_tags"]);
				$categ	= (int) $_POST["file_category_sel"];

				$error	= VUseraccount::checkPerm('upload', $for[0]);
				$error  = $cfg["paid_memberships"] == 1 ? VUpload::subscriptionCheck($for, '') : $error;
				$error	= $error != '' ? $error : ($title == '' ? $language["notif.error.required.field"].$language["files.text.file.title"] : ($tags == '' ? $language["notif.error.required.field"].$language["files.text.file.tags"] : ($categ == 0 ? $language["notif.error.required.field"].$language["files.text.file.categ"] : false)));
				if ($for == 'live') {
					$sql = sprintf("SELECT `db_id`, `file_key` FROM `db_livefiles` WHERE `stream_key`='%s' AND `active`='1' LIMIT 1;", md5($cfg["global_salt_key"].$usr_id.SK_INC));
					$ss  = $db->execute($sql);
					if ($ss->fields["db_id"])
						$error = $language["notif.error.live.exist"].' <a href="'.$cfg["main_url"].'/'.VHref::getKey("files_edit").'?fe=1&l='.$ss->fields["file_key"].'">'.$language["frontend.global.here"].'</a>.';
				}

				if ($error) {
					echo VGenerate::noticeTpl('', $error, '');
				} else {
					$db_tbl_info    = 'db_'.$for.'files';
					$fileext        = 'tplb';
					$filekey        = VUserinfo::generateRandomString(10);
					$embedkey       = VUserinfo::generateRandomString(10);
					$usr_id		= (int) $_SESSION["USER_ID"];
					$usr_key	= $class_filter->clr_str($_SESSION["USER_KEY"]);
					$db_approved    = ($cfg["file_approval"] == 1 ? 0 : 1);
	
					$v_info = array(
						"usr_id" => $usr_id,
						"file_key" => $filekey,
						"old_file_key" => 0,
						"file_type" => $fileext,
						"file_name" => null,
						"file_size" => null,
						"upload_date" => date("Y-m-d H:i:s"),
						"is_subscription" => (int) $cfg["paid_memberships"],
						"file_views" => 0,
						"file_comments" => 0,
						"file_responses" => 0,
						"file_like" => 0,
						"file_dislike" => 0,
						"embed_key" => $embedkey,
						"file_title" => $title,
						"file_description" => $descr,
						"file_tags" => VForm::clearTag($tags),
						"file_category" => $categ,
						"approved" => $db_approved,
						"privacy" => "public",
						"comments" => "all",
						"comment_votes" => 1,
						"rating" => 1,
						"responding" => "all",
						"embedding" => 1,
						"social" => 1
					);
					
					$do_db	= $class_database->doInsert($db_tbl_info, $v_info);
					
					if ($db->Affected_Rows() > 0) {
						/* file count */
						$ct_update	= $db->execute(sprintf("UPDATE `db_accountuser` SET `usr_%s_count`=`usr_%s_count`+1 WHERE `usr_id`='%s' LIMIT 1;", $for[0], $for[0], $usr_id));
						/* activity */
						$log		=($cfg["activity_logging"] == 1 and $action = new VActivity($usr_id)) ? $action->addTo('log_upload', $for.':'.$filekey) : NULL;
						/* end if broadcast details */
						if ($for == 'live') {
							$_p	= unserialize($class_database->singleFieldValue('db_accountuser', 'usr_perm', 'usr_id', $usr_id));
							if ($_p["perm_upload_l"] == '1') {
								$db->execute(sprintf("UPDATE `db_livefiles` SET `stream_key`='%s', `stream_key_active`='1', `stream_vod`='%s', `stream_chat`='%s', `file_duration`='1' WHERE `file_key`='%s' LIMIT 1;", md5($cfg["global_salt_key"].$usr_id.SK_INC), $_p["perm_live_vod"], $_p["perm_live_chat"], $filekey));
							}

							$tmp_file = str_replace($cfg["main_url"], $cfg["main_dir"], VUseraccount::getProfileImage($usr_id, false));
							if ($tmp_file && is_file($tmp_file)) {
								$src_folder = $cfg["media_files_dir"].'/'.$usr_key.'/t/'.$filekey.'/';
								$conv = new VDocument();
								$conv->log_setup($filekey, false);

								if ($conv->createThumbs_ffmpeg($src_folder, '1', 320, 180, $filekey, $usr_key, $tmp_file)){}
								if ($conv->createThumbs_ffmpeg($src_folder, '0', 640, 360, $filekey, $usr_key, $tmp_file)){}
							}

							if ($cfg["paid_memberships"] == 1) {
								$filesize	= 1024;
								$sql		= sprintf("UPDATE `db_packusers` SET `pk_usedspace`=`pk_usedspace`+%s, `pk_total_%s`=`pk_total_%s`+1 WHERE `usr_id`='%s' LIMIT 1;", $filesize, $for, $for, $usr_id);
								$db_dub		= $db->execute($sql);
							}

							$notify = VUpload::notifySubscribers(0, $for, $filekey, '', $usr_key);//notify admin

							$js	= '
								window.location="'.$cfg["main_url"].'/'.VHref::getKey("files_edit").'?fe=1&l='.$filekey.'";
								$.fancybox.close();
								//$("#file-search-button").click();
							';

							echo VGenerate::declareJS($js);

							return;
						}

						/* copy blog file */
						$blog_file	= $cfg["ww_templates_dir"] . '/tpl_page/tpl_blog.tpl';
						$blog_tmb	= $cfg["global_images_dir"] . '/default-blog.png';
						
						if (file_exists($blog_file)) {
							$dst_file	= $cfg["media_files_dir"] . '/' . $usr_key . '/b/' . $filekey . '.tplb';
							$dst_dir	= $cfg["media_files_dir"] . '/' . $usr_key . '/t/' . $filekey;
							$dst_tmb	= $dst_dir . '/1.jpg';
							$dst_tmb_0	= $dst_dir . '/0.jpg';
							
							if (copy($blog_file, $dst_file)) {
								if (mkdir($dst_dir, 0777)) {
									copy($blog_tmb, $dst_tmb);
									copy($blog_tmb, $dst_tmb_0);
									
									if (!$blog_response) {
										$js	= '
												$.fancybox.close();
												$("#file-search-button").click();
										';
									
										echo VGenerate::declareJS($js);
									} else {
										$responses = new VResponses;
										
										VResponses::submitResponse(1, $filekey);
										
										$js	= '
												$("#add-new-title-input").replaceWith("<p>'.$title.'</p>");
												$("#add-new-descr-input").replaceWith("<p>'.$descr.'</p>");
												$("#add-new-tags-input").replaceWith("<p>'.$tags.'</p>");
												$("#add-new-categ-input").replaceWith("<p>'.$class_database->singleFieldValue('db_categories', 'ct_name', 'ct_id', $categ).'</p>");
												$(\'<p><a href="'.$cfg["main_url"].'/'.VHref::getKey('files_edit').'?fe=1&b='.$filekey.'">'.$language["frontend.global.click"].'</a> '.$language["respond.text.file.blog.e"].'</p>\').insertAfter("#add-new-blog-response");
											';
										
										echo VGenerate::declareJS($js);
									}
									if($cfg["paid_memberships"] == 1){
										$filesize	= 1024;
										$sql		= sprintf("UPDATE `db_packusers` SET `pk_usedspace`=`pk_usedspace`+%s, `pk_total_%s`=`pk_total_%s`+1 WHERE `usr_id`='%s' LIMIT 1;", $filesize, $for, $for, $usr_id);
										$db_dub		= $db->execute($sql);
									}


									$notify	= $db_approved == 1 ? VUpload::notifySubscribers($usr_id, $for, $filekey, '', $usr_key) : VUpload::notifySubscribers(0, $for, $filekey, '', $usr_key);

									echo VGenerate::noticeTpl('', '', ($db_approved == 1 ? $language["respond.text.approved"] : $language["notif.success.request"]));
								}
								
								
							}
						} else {
							echo VGenerate::noticeTpl('', $language["notif.error.invalid.request"], '');
						}
					}

				}
			} else {
				$isv	= $class_database->singleFieldValue('db_accountuser', 'usr_verified', 'usr_id', (int)$_SESSION["USER_ID"]);
				if ($isv == 0) {
					echo VGenerate::declareJS('window.location="'.$cfg["main_url"].'/'.VHref::getKey("upload").'?t=video";');
					exit;
				}
				$categ	= VGenerate::simpleDivWrap('selector fe', '', self::fileCategorySelect('upload'));
				
				$html	= '	
					<div class="lb-margins">
						<form id="add-new-'.$for.'-form" method="post" action="" class="entry-form-class">
							<article>
								<h3 class="content-title"><i class="icon-'.($for == 'blog' ? 'pencil2' : $for).'"></i>'.str_replace('##TYPE##', $language["frontend.global.".$for[0].".c"], $language["files.menu.add.new"]).'</h3>
								<div class="line"></div>
							</article>
							<div id="add-new-'.$for.'-response" class=""></div>
							<label>'.$language["files.text.file.title"].' '.$language["frontend.global.required"].'</label>
							<input type="text" name="add_new_title" id="add-new-title-input" class="login-input">
							<label>'.$language["files.text.file.descr"].'</label>
							<textarea name="add_new_descr" id="add-new-descr-input" class="login-input"></textarea>
							<label>'.$language["files.text.file.tags"].' '.$language["frontend.global.required"].'</label>
							<input type="text" name="add_new_tags" id="add-new-tags-input" class="login-input">
							<label>'.$language["files.text.file.categ"].' '.$language["frontend.global.required"].'</label>
							<div id="add-new-categ-input">
								<div>'.$categ.'</div>
								<div class="row" id="save-button-row">
									<button name="add_new_'.$for.'_btn" id="add-new-'.$for.'-btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span>'.$language["frontend.global.savenew"].'</span></button>
									<a class="link cancel-trigger" href="#" onclick="$(\'.fancybox-close\').click();"><span>'.$language["frontend.global.cancel"].'</span></a>
								</div>
								<label id="nl">'.$language["frontend.global.required.items"].'</label>
							</div>
						</form>
					</div>
				';
				
				$html	.= '<script type="text/javascript"> $(function() { SelectList.init("file_category_sel"); enterSubmit("#add-new-'.$for.'-form input", "#add-new-'.$for.'-btn"); }); </script>';
			
				echo $html;
			}
		}
	}
	/* lists of files to insert into blogs */
	private static function blog_mediaList($type=false, $favorites=false) {
		$language	= self::$language;
		$cfg		= self::$cfg;
		$for		= !$type ? self::$type : $type;
		$class_filter	= self::$filter;
		$db		= self::$db;
		$uid		= (int) $_SESSION["USER_ID"];
		
		$html		= null;
		
		if ($favorites) {
			$fsql	= sprintf("SELECT `fav_list` FROM `db_%sfavorites` WHERE `usr_id`='%s' LIMIT 1;", $for, $uid);
			$frs	= $db->execute($fsql);
			
			if ($frs->fields["fav_list"] != '') {
				$fav	= unserialize($frs->fields["fav_list"]);
				$qq	= null;
				
				foreach ($fav as $fk) {
					$qq .= self::fileKeyCheck($for, $fk);
				}
				$q	= $qq != '' ? " AND (" . substr($qq, 0, -3) . ")" : null;
			} else {
				$q	= " AND A.`usr_id`='0' ";
			}
		}
		
		$sql		= sprintf("SELECT
						A.`thumb_server`, A.`file_key`, A.`file_title`, D.`usr_key`
						FROM
						`db_%sfiles` A, `db_accountuser` D
						WHERE
						A.`usr_id`=D.`usr_id` AND
						A.`privacy`!='personal' AND
						A.`active`='1' AND
						A.`approved`='1' AND
						A.`deleted`='0' AND
						A.`usr_id`='%s'
						%s
						GROUP BY A.`file_key`;", $for, (int) $_SESSION["USER_ID"], $q);
		
		$rs		= $db->execute($sql);
		
		if ($rs->fields["file_key"]) {
			$s	 = 1;
				
			$html	.= '<ul class="blog-media-select">';
			while (!$rs->EOF) {
				$title		= $rs->fields["file_title"];
				$file_key	= $rs->fields["file_key"];
				$usr_key	= $rs->fields["usr_key"];
				$thumb_server	= $rs->fields["thumb_server"];
				
				$img_src	= self::thumbnail($usr_key, $file_key, $thumb_server);
				$thumbnail	= '<img class="mediaThumb" src="'.$img_src.'" alt="'.$title.'" rel="tooltip" title="'.$title.'">';
				
				$html	.= '<li rel-key="'.$file_key.'" class="vs-column fifths'.($s%5 == 0 ? ' fit' : null).'" onclick="$(\'.content-current .blog-media-select li\').removeClass(\'thumb-selected\'); $(this).addClass(\'thumb-selected\')">'.$thumbnail.'</li>';
				
				$rs->MoveNext();
				$s	+= 1;
			}
			$html	.= '</ul>';
		} else {
			$html	.= '<p>'.$language["frontend.global.results.none"].'</p>';
		}
		
		return $html;
	}

	/* saving edited info */
	function saveEdit() {
		$language	= self::$language;
		$cfg		= self::$cfg;
		$for		= self::$type;
		$class_filter	= self::$filter;
		$db		= self::$db;

		$file_key	= $class_filter->clr_str($_GET[$for[0]]);
		$form_fields	= VArraySection::getArray('edit_file');
		$allowedFields	= $form_fields[1];
		$requiredFields = $form_fields[2];
		$error_message	= VForm::checkEmptyFields($allowedFields, $requiredFields);
		$notice_message = '';
		$u		= 0;

		if ($error_message == '') {
			if ($for[0] == 'b' and $cfg["blog_module"] == 1 and isset($_POST["blog_html"])) {
				$usr_key	= $class_filter->clr_str($_SESSION["USER_KEY"]);
				$blog_tpl	= $cfg["media_files_dir"] . '/' . $usr_key . '/b/' . $file_key . '.tplb';
				$blog_html	= urldecode($_POST["blog_html"]);
				
				if (!file_exists($blog_tpl)) {
					touch($blog_tpl);
				}
				if (file_exists($blog_tpl)) {
					if (file_put_contents($blog_tpl, $blog_html)) {
						$u = 1;
					}
				}
				
			}
			$array_check = array(
			    "privacy"		=> $cfg["file_privacy"],
			    "comments"		=> $cfg["file_comments"],
			    "comment_votes"	=> $cfg["file_comment_votes"],
			    "comment_spam"	=> $cfg["file_comment_spam"],
			    "rating"		=> $cfg["file_rating"],
			    "responding"	=> $cfg["file_responses"],
			    "embedding"		=> $cfg["file_embedding"],
			    "social"		=> $cfg["file_social_sharing"]
			);

			$file_tags	= VForm::clearTag($form_fields[0]["file_tags"]);
			$allowed_meta	= array("file_title" => $form_fields[0]["file_title"], "file_description" => $form_fields[0]["file_description"], "file_tags" => $file_tags, "file_category" => $form_fields[0]["file_category"]);

			if ($for[0] == 'l') {
				$_perm	= unserialize(self::$dbc->singleFieldValue('db_accountuser', 'usr_perm', 'usr_id', (int) $_SESSION["USER_ID"]));

				$_chat	= ($cfg["live_chat"] == 1 and $_perm["perm_live_chat"] == 1) ? $form_fields[0]["stream_chat"] : 0;
				$_vod	= ($cfg["live_vod"] == 1 and $_perm["perm_live_vod"] == 1) ? $form_fields[0]["stream_vod"] : 0;

				$allowed_live = array("stream_chat" => $_chat, "stream_vod" => $_vod);
			}

			$allowed_perm	= self::saveEditCheck($form_fields[0], $array_check);

			foreach ($allowed_meta as $key => $val) {
				$q .= sprintf("C.`%s`='%s', ", $key, $val);
			}
			foreach ($allowed_perm as $key => $val) {
				$q .= sprintf("C.`%s`='%s', ", $key, $val);
			}
			if ($for[0] == 'l' and is_array($allowed_live)) {
				foreach ($allowed_live as $key => $val) {
					$q .= sprintf("C.`%s`='%s', ", $key, $val);
				}
			}
			$sql_loop	= substr($q, 0, -2);
			$sql		= sprintf("UPDATE `db_%sfiles` C SET %s WHERE C.`usr_id`='%s' AND C.`file_key`='%s';", $for, $sql_loop, (int)$_SESSION["USER_ID"], $file_key);
			$db_do		= $db->execute($sql);
			
			if ($db->Affected_Rows() > 0) {
				$notice_message = $language["notif.success.request"];
				echo VGenerate::declareJS('$("h1").html("' . $allowed_meta["file_title"] . '"); $("input[name=\"file_tags\"]").val("' . $file_tags . '");');
			}
			$notice_message = ($db->Affected_Rows() > 0 or $u > 0) ? $language["notif.success.request"] : NULL;
		}
		echo $html		= ($error_message != '' or $notice_message != '') ? VGenerate::noticeTpl('', $error_message, $notice_message) : NULL;
	}

	/* editing files layout */
    function fileEdit(){
	$cfg		 = self::$cfg;
	$language	 = self::$language;
	$class_database	 = self::$dbc;
	$class_filter	 = self::$filter;
	$db		 = self::$db;

	$p		 = VPlayers::playerInit('edit');
	$_id		 = $p[0];
	$_width		 = $p[1];
	$_height	 = $p[2];
	$usr_key         = $class_filter->clr_str($_SESSION["USER_KEY"]);
	$type		 = self::$type;
	$file_key        = $class_filter->clr_str($_GET[$type[0]]);
	$usr_id		 = (int) $_SESSION["USER_ID"];
	$_perm		 = unserialize(self::$dbc->singleFieldValue('db_accountuser', 'usr_perm', 'usr_id', $usr_id));

	$sql	 = sprintf("SELECT 
			    C.`file_title`, C.`file_description`, C.`file_tags`, 
			    C.`privacy`, C.`comments`, C.`comment_votes`, C.`comment_spam`, C.`rating`, C.`responding`, C.`embedding`, C.`social`, C.`approved`,
			    C.`stream_server`, C.`stream_key`, C.`stream_live`, C.`stream_ended`, C.`stream_chat`, C.`stream_vod`, C.`file_comments`, C.`file_like`, C.`file_dislike`, C.`file_views`, C.`file_hd`, C.`file_name`, C.`file_size`, C.`last_viewdate`, C.`upload_date`, %s 
			    D.`usr_id`, D.`usr_key` 
			    FROM 
			    `db_%sfiles` C, `db_accountuser` D 
			    WHERE 
			    C.`usr_id`=D.`usr_id` AND 
			    C.`file_key`='%s' AND 
			    C.`usr_id`='%s' AND 
			    D.`usr_key`='%s' LIMIT 1;", ($type ? "C.`embed_key`, C.`embed_src`," : NULL), $type, $file_key, $usr_id, $usr_key);
	
	$res	 = $db->execute($sql);
	
	$usr_key = $res->fields["usr_key"];

        $pl_ht           = null;
	$about_html	 = null;
	$thumb_html	 = null;
	$privacy_html	 = null;
	$comm_html	 = null;
	$commv_html	 = null;
	$comms_html	 = null;
	$rate_html	 = null;
	$response_html	 = null;
	$embed_html	 = null;
	$social_html	 = null;
	$views_html	 = null;
	$live_html	 = null;
	if ($res->fields["file_title"] == '' or $res->fields["usr_key"] == '') {
                return $html = VGenerate::noticeTpl('', str_replace('##TYPE##', $language["frontend.global.".$type[0].".c"], $language["files.text.notfound"]), '');
        }
	if ($type[0] == 'b') {
		$blog_tpl  = $cfg["media_files_dir"] . '/' . $usr_key . '/b/' . $file_key . '.tplb';
		$blog_html = file_exists($blog_tpl) ? file_get_contents($blog_tpl) : null;
	}
	// about html
	$about_html	.= '<form class="entry-form-class" method="post" action="">';
	$about_html	.= self::fileSettingsHTM("option_title", $res->fields["file_title"]);
	$about_html	.= self::fileSettingsHTM("option_descr", $res->fields["file_description"]);
	$about_html	.= self::fileSettingsHTM("option_tags", $res->fields["file_tags"]);
	$about_html	.= self::fileSettingsHTM("option_categ", 1);
	$about_html	.= '</form>';
	$about_html	.= VGenerate::declareJS('$(function(){SelectList.init("file_category_sel");});');

	if ($type[0] == 'l') {//live html
		$live_html	.= '<form class="entry-form-class" method="post" action="">';
		$live_html	.= VUseraccount::checkPerm('upload', $type[0]) != '' ? VGenerate::noticeTpl('', $language["files.text.no.live"], '') : null;
		$live_html	.= '<div id="option_stream_status"><div class="settings-wrapper"><label class="">'.$language["files.text.stream.status"].'</label> <span class="'.($res->fields["stream_live"] == 1 ? 't-green' : 't-red').'">'.(($res->fields["stream_live"] == 1 ? $language["frontend.global.live"] : $language["frontend.global.offline"])).'</span></div></div>';
		$live_html	.= $res->fields["stream_ended"] == '0' ? self::fileSettingsHTM("option_stream_server", $cfg["live_server"], true) : null;
		$live_html	.= $res->fields["stream_ended"] == '0' ? self::fileSettingsHTM("option_stream_name", $res->fields["stream_key"]) : null;
		$live_html	.= ($cfg["live_chat"] == 1 and $_perm["perm_live_chat"] == 1) ? self::fileSettingsHTM("option_chat", $res->fields["stream_chat"]) : null;
		$live_html	.= ($cfg["live_vod"] == 1 and $_perm["perm_live_vod"] == 1) ? self::fileSettingsHTM("option_vod", $res->fields["stream_vod"]) : null;
		$live_html	.= '</form>';
		if ($res->fields["stream_ended"] == '0') {
			$live_js	.= 'aa = "'.$cfg["live_server"].'"; bb = "'.$cfg["live_cast"].'";';
			$live_js	.= '$(".icheck-box input[name=option_vod]:first").on("ifChecked", function(event){if ($(this).is(":checked")) $("input[name=files_text_stream_server]").val(aa); });';
			$live_js	.= '$(".icheck-box input[name=option_vod]:first").on("ifUnchecked", function(event){if (!$(this).is(":checked")) $("input[name=files_text_stream_server]").val(bb); });';
			$live_html	.= VGenerate::declareJS('$(document).ready(function(){'.$live_js.'});');
		}
	}
	if ($cfg["file_thumb_change"] == 1 and $type[0] != 'i') {//thumb html
		$thumb_html	.= '<form class="entry-form-class" method="post" action="">';
		$thumb_html	.= self::fileSettingsHTM("option_thumbnail", $type);
		$thumb_html	.= '</form>';
	}
	if ($cfg["file_privacy"] == 1) {//privacy html
		$privacy_html	.= '<form class="entry-form-class" method="post" action="">';
		$privacy_html	.= self::fileSettingsHTM("option_privacy", $res->fields["privacy"]);
		$privacy_html	.= '</form>';
	}
	if ($cfg["file_comments"] == 1) {//comments html
		$comm_html	.= '<form class="entry-form-class" method="post" action="">';
		$comm_html	.= self::fileSettingsHTM("option_comments", $res->fields["comments"]);
		$comm_html	.= '</form>';
	}
	if ($cfg["file_comment_votes"] == 1) {//comment votes html
		$commv_html	.= '<form class="entry-form-class" method="post" action="">';
		$commv_html	.= self::fileSettingsHTM("option_votes", $res->fields["comment_votes"]);
		$commv_html	.= '</form>';
	}
	if ($cfg["file_comment_spam"] == 1) {//comment spam votes html
		$comms_html	.= '<form class="entry-form-class" method="post" action="">';
		$comms_html	.= self::fileSettingsHTM("option_spam", $res->fields["comment_spam"]);
		$comms_html	.= '</form>';
	}
	if ($cfg["file_rating"] == 1) {//rating html
		$rate_html	.= '<form class="entry-form-class" method="post" action="">';
		$rate_html	.= self::fileSettingsHTM("option_rating", $res->fields["rating"]);
		$rate_html	.= '</form>';
	}
	if ($cfg["file_responses"] == 1) {//responses html
		$response_html	.= '<form class="entry-form-class" method="post" action="">';
		$response_html	.= self::fileSettingsHTM("option_responses", $res->fields["responding"]);
		$response_html	.= '</form>';
	}
	if ($cfg["file_embedding"] == 1) {//embed html
		$embed_html	.= '<form class="entry-form-class" method="post" action="">';
		$embed_html	.= self::fileSettingsHTM("option_embed", $res->fields["embedding"]);
		$embed_html	.= '</form>';
	}
	if ($cfg["file_social_sharing"] == 1) {//social sharing html
		$social_html	.= '<form class="entry-form-class" method="post" action="">';
		$social_html	.= self::fileSettingsHTM("option_social", $res->fields["social"]);
		$social_html	.= '</form>';
	}
	if ($cfg["affiliate_module"] == 1) {//views html
                $views_html     .= '<form class="entry-form-class" method="post" action="">';
                $views_html     .= '<p><a href="'.$cfg["main_url"].'/'.VHref::getKey("account").'?a='.md5($_SESSION["USER_KEY"]).'&fk='.$file_key.'" target="_blank"><i class="icon-pie"></i> '.$language["account.entry.act.views"].'</a></p>';
                $views_html     .= '<p><a href="'.$cfg["main_url"].'/'.VHref::getKey("account").'?g='.md5($_SESSION["USER_KEY"]).'&fk='.$file_key.'" target="_blank"><i class="icon-globe"></i> '.$language["account.entry.act.maps"].'</a></p>';
                $views_html     .= '<p><a href="'.$cfg["main_url"].'/'.VHref::getKey("account").'?o='.md5($_SESSION["USER_KEY"]).'&fk='.$file_key.'" target="_blank"><i class="icon-bars"></i> '.$language["account.entry.act.comp"].'</a></p>';
                $views_html     .= '</form>';
        }
        $btn_text	 = ($type[0] == 'l' and $res->fields["stream_ended"] == 0 and $res->fields["stream_live"] == 0) ? $language["frontend.global.publish.live"] : $language["frontend.global.saveupdate"];
	
	$html		 = '	<div id="title-wrapper-off">
					<article>
						<h3 class="content-title"><i class="icon-'.($type == 'doc' ? 'file' : ($type == 'blog' ? 'pencil2' : $type)).'"></i>'.$res->fields["file_title"].'</h3>
						<div class="edit-back"><a href="'.self::$cfg["main_url"].'/'.VHref::getKey('files').'#'.$type[0].'"><i class="icon-arrow-left3" rel="tooltip" title="'.$language["files.text.edit.back"].'"></i></a></div>
						<div class="line"></div>
					</article>
				</div>
				<div class="clearfix"></div>

				<div id="options-wrapper">
					<div class="clearfix"></div>
					<div id="main-content" class="tabs tabs-style-topline">
						<nav>
							<ul>
								'.($type[0] == 'l' ? '<li><a href="#section-live" class="icon icon-live" rel="nofollow"><span>'.$language["files.option.live"].'</span></a></li>' : null).'
								'.('<li><a href="#section-meta" class="iconBe iconBe-info" rel="nofollow"><span>'.$language["files.option.about"].'</span></a></li>').'
								'.($type[0] == 'b' ? '<li><a href="#section-blog" class="icon icon-pencil2" rel="nofollow"><span>'.$language["files.option.blog"].'</span></a></li>' : null).'
								'.(($cfg["file_thumb_change"] == 1 and $type[0] != 'i') ? '<li><a href="#section-thumb" class="icon icon-thumbs" rel="nofollow"><span>'.$language["files.option.thumb"].'</span></a></li>' : null).'
								'.($cfg["file_privacy"] == 1 ? '<li><a href="#section-privacy" class="icon icon-key" rel="nofollow"><span>'.$language["files.option.privacy"].'</span></a></li>' : null).'
								'.($cfg["file_comments"] == 1 ? '<li><a href="#section-comm" class="icon icon-comment" rel="nofollow"><span>'.$language["files.option.comments"].'</span></a></li>' : null).'
								'.($cfg["file_comment_votes"] == 1 ? '<li><a href="#section-comm-v" class="iconBe iconBe-plus" rel="nofollow"><span>'.$language["files.option.comment.vote"].'</span></a></li>' : null).'
								'.($cfg["file_comment_spam"] == 1 ? '<li><a href="#section-comm-s" class="icon icon-spam" rel="nofollow"><span>'.$language["files.option.comment.spam"].'</span></a></li>' : null).'
								'.($cfg["file_rating"] == 1 ? '<li><a href="#section-rate" class="icon icon-thumbs-up" rel="nofollow"><span>'.$language["files.option.rating"].'</span></a></li>' : null).'
								'.($cfg["file_responses"] == 1 ? '<li><a href="#section-respond" class="icon icon-comments" rel="nofollow"><span>'.$language["files.option.video.response"].'</span></a></li>' : null).'
								'.($cfg["file_embedding"] == 1 ? '<li><a href="#section-embed" class="icon icon-embed" rel="nofollow"><span>'.$language["files.option.embed"].'</span></a></li>' : null).'
								'.($cfg["file_social_sharing"] == 1 ? '<li><a href="#section-social" class="icon icon-facebook" rel="nofollow"><span>'.$language["files.option.social.share"].'</span></a></li>' : null).'
							</ul>
						</nav>
						<div class="content-wrap">
							<div id="submit-response">'.($res->fields["approved"] == 0 ? VGenerate::noticeTpl('', str_replace('##TYPE##', $language["frontend.global.".$type[0]], $language["files.text.pending.appr"]), '') : null).'</div>
							'.($type[0] == 'l' ? '
							<section id="section-live" class="content-current">
								<article>
									<h3 class="content-title"><i class="icon-live"></i> '.$language["files.option.live"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<p><i class="icon-question"></i> '.str_replace('##URL##', '<a href="'.$cfg["main_url"].'/'.VHref::getKey("page").'?t=page-live" target="_blank">'.$language["frontend.global.live.streaming"].'</a>', $language["files.text.live.help"]).'</p>
									<div>'.$live_html.'</div>
								</article>
							</section>
							' : null).'
							<section id="section-meta" class="'.($type[0] != 'l' ? 'content-current' : null).'">
								<article>
									<h3 class="content-title"><i class="iconBe-info"></i> '.$language["files.option.about"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$about_html.'</div>
								</article>
							</section>
							'.($type[0] == 'b' ? '
							<section id="section-blog">
								<article>
									<h3 class="content-title"><i class="icon-pencil2"></i> '.$language["files.option.blog"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>
										<div id="blog-edit" class="d-editable">
											'.$blog_html.'
										</div>
									</div>
								</article>
							</section>
							' : null).'
							'.(($cfg["file_thumb_change"] == 1 and $type[0] != 'i') ? '
							<section id="section-thumb">
								<article>
									<h3 class="content-title"><i class="icon-thumbs"></i>'.$language["files.option.thumb"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$thumb_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_privacy"] == 1 ? '
							<section id="section-privacy">
								<article>
									<h3 class="content-title"><i class="icon-key"></i>'.$language["files.option.privacy"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$privacy_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_comments"] == 1 ? '
							<section id="section-comm">
								<article>
									<h3 class="content-title"><i class="icon-comment"></i>'.$language["files.option.comments"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$comm_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_comment_votes"] == 1 ? '
							<section id="section-comm-v">
								<article>
									<h3 class="content-title"><i class="iconBe-plus"></i> '.$language["files.option.comment.vote"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$commv_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_comment_spam"] == 1 ? '
							<section id="section-comm-s">
								<article>
									<h3 class="content-title"><i class="icon-spam"></i>'.$language["files.option.comment.spam"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$comms_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_rating"] == 1 ? '
							<section id="section-rate">
								<article>
									<h3 class="content-title"><i class="icon-thumbs-up"></i>'.$language["files.option.rating"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$rate_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_responses"] == 1 ? '
							<section id="section-respond">
								<article>
									<h3 class="content-title"><i class="icon-comments"></i>'.$language["files.option.video.response"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$response_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_embedding"] == 1 ? '
							<section id="section-embed">
								<article>
									<h3 class="content-title"><i class="icon-embed"></i>'.$language["files.option.embed"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$embed_html.'</div>
								</article>
							</section>
							' : null).'
							'.($cfg["file_social_sharing"] == 1 ? '
							<section id="section-social">
								<article>
									<h3 class="content-title"><i class="icon-facebook"></i>'.$language["files.option.social.share"].'</h3>
									<div class="line"></div>
								</article>
								<article>
									<div>'.$social_html.'</div>
								</article>
							</section>
							' : null).'
							<div class="vs-column fifths-off update-button">
								<button onfocus="blur();" value="1" type="submit" class="button-grey search-button form-button save-button button-blue save-entry-button" name="save_changes">
									<span>'.$btn_text.'</span>
								</button>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				';
	$html	.= '
			<script type="text/javascript">
                                $(window).resize(function() {
                                        dinamicSizeSetFunction_menu();
                                });
                                $(function() {
                                        dinamicSizeSetFunction_menu();
                                });
                        </script>
	';
	$html	.= VGenerate::declareJS('$(document).ready(function(){' . $ht_js . '});');
	
	return $html;
    }
	/* changing thumb image, uploading */
	function thumbChange_upload() {
		$cfg		= self::$cfg;
		$class_filter	= self::$filter;
		$language	= self::$language;

		echo '<span class="no-display">1</span>'; //the weirdest fix EVER, but jquery form plugin fails without it...

		$type			= self::$type;
		$key			= $class_filter->clr_str($_GET[$type[0]]);
		$upload_file_name	= $class_filter->clr_str($_FILES["fedit_image"]["tmp_name"]);
		$upload_file_size	= intval($_FILES["fedit_image"]["size"]);
		$upload_file_limit	= 2 * 1024 * 1024;
		$upload_file_type	= strtoupper(VFileinfo::getExtension($_FILES["fedit_image"]["name"]));
		$upload_allowed		= explode(',', strtoupper('gif,jpeg,jpg,png'));

		$error_message		= $upload_file_size > $upload_file_limit ? $language["account.error.filesize"] : NULL;
		$error_message		= ($error_message == '' and ! in_array($upload_file_type, $upload_allowed)) ? $language["account.error.allowed"] : $error_message;
		if ($error_message == '') {
                	if (strpos($upload_file_name, '.php') !== false or strpos($upload_file_name, '.pl') !== false or strpos($upload_file_name, '.asp') !== false or strpos($upload_file_name, '.htm') !== false or strpos($upload_file_name, '.cgi') !== false or strpos($upload_file_name, '.py') !== false or strpos($upload_file_name, '.sh') !== false or strpos($upload_file_name, '.cin') !== false) {
                        	$error_message  = $language["account.error.allowed"];
                	}
        	}
		echo $show_error	= $error_message != '' ? VGenerate::noticeTpl('', $error_message, '') : NULL;

		if ($error_message == '') {
			$ukey		= $class_filter->clr_str($_SESSION["USER_KEY"]);
			$mdir		= $cfg["media_files_dir"];
			
			$tmp_file	= $mdir . '/' . $ukey . '/t/' . $key . '/tmp_src.jpg';
			$_file		= $mdir . '/' . $ukey . '/t/' . $key . '/tmp_1.jpg';
			$tmp_img	= $cfg["media_files_url"] . '/' . $ukey . '/t/' . $key . '/tmp_src.jpg';

			if (file_exists($tmp_file)) {
				@unlink($tmp_file);
			}
			if (rename($upload_file_name, $tmp_file)) {
				$src_folder      = $cfg["media_files_dir"].'/'.$ukey.'/t/'.$key.'/';

				switch ($type[0]) {
					case "l":
					case "v":
					case "a":
					case "d":
					case "b":
						$class = "VDocument";

						if ($tmp_file && is_file($tmp_file)) {
							$conv = new $class();
							$conv->log_setup($key, false);

							if ($conv->createThumbs_ffmpeg($src_folder, 'tmp_1', 320, 200, $key, $ukey, $tmp_file)) {
							}
						}
						break;

					case "i": break;
				}
			}

			if (filesize($tmp_file) > 0) {
				chmod($tmp_file, 0644);
				
				$image_replace = '<div class=\"row left-float left-padding25\"><input type=\"hidden\" name=\"fedit_image_temp\" value=\"' . $type[0] . '\" /><img height=\"185\" src=\"' . $tmp_img . '?t=' . time() . '\" alt=\"\" title=\"\" /></div>';
				$input_replace = '$("#overview-userinfo-file").replaceWith("' . $image_replace . '");';
				echo '<script type="text/javascript" src="' . $cfg["javascript_url"] . '/jquery-1.11.1.min.js"></script>'; //stupid IE fix
				echo '<script type="text/javascript" src="' . $cfg["javascript_url"] . '/jquery.loadmask.js"></script>'; //stupid IE fix
				echo '<script type="text/javascript" src="' . $cfg["javascript_url"] . '/jquery.easing.js"></script>'; //stupid IE fix
				echo '<script type="text/javascript" src="' . $cfg["scripts_url"] . '/shared/jquery.form.js"></script>'; //stupid IE fix
				echo '<script type="text/javascript" src="' . $cfg["scripts_url"] . '/shared/icheck/icheck.js"></script>'; //stupid IE fix
				echo '<script type="text/javascript" src="' . $cfg["scripts_url"] . '/shared/lightbox/jquery.fancybox.js"></script>'; //stupid IE fix
				echo $do_replace = $error_message == '' ? VGenerate::declareJS('$(document).ready(function(){' . $input_replace . '});') : NULL;
			}
		}
	}

	/* save changed thumbnail image */
	function thumbChange_save() {
		$db		 = self::$db;
		$cfg		 = self::$cfg;
		$class_filter	 = self::$filter;
		$class_database	 = self::$dbc;

		if ($_POST) {
			$key		= $class_filter->clr_str($_GET[$_POST["fedit_image_temp"]]);
			$user_key	= $class_filter->clr_str($_SESSION["USER_KEY"]);
			$image_from	= $class_filter->clr_str($_POST["fedit_image_action"]);

			switch ($image_from) {
				case "new":
					$tmp_src	= $cfg["media_files_dir"] . '/' . $user_key . '/t/' . $key . '/tmp_src.jpg';
					$tmp_file	= $cfg["media_files_dir"] . '/' . $user_key . '/t/' . $key . '/tmp_1.jpg';
					$dst_file	= $cfg["media_files_dir"] . '/' . $user_key . '/t/' . $key . '/1.jpg';
					$dst_url	= $cfg["media_files_url"] . '/' . $user_key . '/t/' . $key . '/1.jpg';

					if (file_exists($tmp_file) and rename($tmp_file, $dst_file)) {
						$_file0		 = $cfg["media_files_dir"] . '/' . $user_key . '/t/' . $key . '/0.jpg';
						$src_folder      = $cfg["media_files_dir"].'/'.$user_key.'/t/'.$key.'/';
				
						switch (self::$type[0]) {
							case "l":
							case "v":
							case "a":
							case "d":
							case "b":
								$class = "VDocument";

								if ($tmp_src && is_file($tmp_src)) {
									$conv = new $class();
									$conv->log_setup($key, false);
									$conv->createThumbs_ffmpeg($src_folder, 0, 640, 360, $key, $user_key, $tmp_src);
									if ($conv->createThumbs_ffmpeg($src_folder, 1, 320, 240, $key, $user_key, $tmp_src)) {
										$sql	= sprintf("SELECT `thumb_server`, `embed_src` FROM `db_%sfiles` WHERE `file_key`='%s' LIMIT 1;", self::$type, $key);
										$get	= $db->execute($sql);
										$src	= $get->fields["embed_src"];
										$tmb_id	= $get->fields["thumb_server"];

										if ($tmb_id > 0) {
											$send_thumbs	= $src == 'local' ? 1 : 2;
											$cmd = sprintf("%s %s/f_modules/m_frontend/m_file/transfer.php %s %s %s %s %s", '/usr/local/bin/php', $cfg["main_dir"], self::$type, $key, $user_key, $tmb_id, $send_thumbs);
											exec(escapeshellcmd($cmd). ' >/dev/null &');
										}
									}
								}
								break;

							case "i": break;
						}
						
						@unlink($tmp_src);

						echo VGenerate::declareJS('$("#option_thumbnail img.mediaThumb").replaceWith("<img class=\"mediaThumb\" height=\"185\" title=\"\" alt=\"\" src=\"' . $dst_url . '?t=' . rand(0, 9999) . '\" />"); $(".fancybox-overlay.fancybox-overlay-fixed").hide().detach();');
					} else {
						echo VGenerate::noticeTpl('', 'No file selected', '');
					}
					break;
					
				case "default":
					$type	= self::$type;
					$key	= $class_filter->clr_str($_GET[$type[0]]);
					
					$src_folder      = $cfg["media_files_dir"].'/'.$user_key.'/t/'.$key.'/';
					
					switch ($type[0]) {
						case "a": $src = $cfg["global_images_dir"] . '/audio.png'; break;
						case "d": $src = $cfg["global_images_dir"] . '/document.gif'; break;
						case "b": $src = $cfg["global_images_dir"] . '/default-blog.png'; break;
						case "l": $src = $cfg["global_images_dir"] . '/default-live.png'; break;
					}
					
					$dst0	= $cfg["media_files_dir"] . '/' . $user_key . '/t/' . $key . '/0.jpg';
					$dst1	= $cfg["media_files_dir"] . '/' . $user_key . '/t/' . $key . '/1.jpg';
					
					switch ($type[0]) {
						case "v":
							$class = "VVideo";

							$file_name_360p = $key.'.360p.mp4';
							$file_name_480p = $key.'.480p.mp4';
							$file_name_720p = $key.'.720p.mp4';
							
							$src_folder      = $cfg["media_files_dir"].'/'.$user_key.'/v/';
							$src_360p	 = $src_folder.$file_name_360p;
							$src_480p	 = $src_folder.$file_name_480p;
							$src_720p	 = $src_folder.$file_name_720p;
							$src             = file_exists($src_720p) ? $src_720p : (file_exists($src_480p) ? $src_480p : (file_exists($src_360p) ? $src_360p : false));
							$cfg[]           = $class_database->getConfigurations('thumbs_nr,log_video_conversion,thumbs_method');
							$cfg["thumbs_method"] = 'rand';

							
							if ($src && is_file($src)) {
								$conv = new $class();
								
								if ($conv->load($src)) {
									$conv->log_setup($key, false);
									$conv->extract_thumbs(array($src, 'thumb'), $key, $user_key);//large thumb
									$conv->extract_thumbs($src, $key, $user_key);//small
								}
							}

							break;
						case "d":
						case "a":
							$class = "VDocument";

							if ($src && is_file($src)) {
								$conv = new $class();
								$conv->log_setup($key, false);

								if ($conv->createThumbs_ffmpeg($src_folder, 1, 320, 200, $key, $user_key, $src)) {
								}
								if ($conv->createThumbs_ffmpeg($src_folder, 0, 640, 360, $key, $user_key, $src)) {
								}
							}
							break;

						case "i": break;
					}
					
					$dst_url = $cfg["media_files_url"] . '/' . $user_key . '/t/' . $key . '/1.jpg';

					echo VGenerate::declareJS('$("#option_thumbnail img.mediaThumb").replaceWith("<img class=\"mediaThumb\" height=\"185\" title=\"\" alt=\"\" src=\"' . $dst_url . '?t=' . rand(0, 9999) . '\" />"); $(".fancybox-overlay.fancybox-overlay-fixed").hide().detach();');
					
					break;
			}
		}
	}
	/* cancel changing thumbnail */
	function thumbChange_cancel() {
		$cfg			= self::$cfg;
		$class_filter		= self::$filter;

		if ($_POST) {
			$tmp_file	= $class_filter->clr_str($_POST["fedit_image_temp"]);
			$tmp_get	= $class_filter->clr_str($_GET[$tmp_file]);
			$ukey		= $class_filter->clr_str($_SESSION["USER_KEY"]);
			$mdir		= $cfg["media_files_dir"];

			$tmp_path_1	= $mdir . '/' . $ukey . '/t/' . $tmp_get . '/tmp_src.jpg';
			$tmp_path_2	= $mdir . '/' . $ukey . '/t/' . $tmp_get . '/tmp_0.jpg';
			$tmp_path_3	= $mdir . '/' . $ukey . '/t/' . $tmp_get . '/tmp_1.jpg';

			if (file_exists($tmp_path_1)) {
				@unlink($tmp_path_1);
			}
			if (file_exists($tmp_path_2)) {
				@unlink($tmp_path_2);
			}
			if (file_exists($tmp_path_3)) {
				@unlink($tmp_path_3);
			}
		}
	}

}
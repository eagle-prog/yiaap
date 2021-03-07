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

class VBrowse {
    private static $type;
    private static $cfg;
    
    private static $db;
    private static $db_cache;
    private static $dbc;
    private static $filter;
    private static $language;
    private static $href;
    private static $section;
    
    private static $page;
    private static $page_end;

    private static $viewMode1_limit = 20;
    private static $viewMode2_limit = 20;
    private static $viewMode3_limit = 10;
    private static $promoted_viewMode1_limit = 5;
    private static $promoted_viewMode2_limit = 5;
    private static $promoted_viewMode3_limit = 5;
    
    public function __construct($_type = false) {
    	require 'f_core/config.href.php';
    	
        global $cfg, $class_filter, $class_database, $db, $language, $section;
        
        $_type		= !$_type ? self::browseType() : $_type;
        self::$type     = $_type == 'document' ? 'doc' : $_type;
        self::$cfg      = $cfg;
        self::$db       = $db;
        self::$dbc      = $class_database;
        self::$filter   = $class_filter;
        self::$language = $language;
        self::$href	= $href;
	self::$section	= ($section == '' ? $href["browse"] : $section);
        self::$page     = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
        self::$page_end = false;

        self::$db_cache = false; //change here to enable caching
    }
    /* browse type */
    public static function browseType(){
 	return VTemplate::browseType();
    }
    /* browse redirect check */
    public static function browseInit(){
	$p_t		 = self::browsetype();
	$p_t		 = $p_t == 'broadcasts' ? 'live' : $p_t;
	$type            = $p_t;
	$rd_to		 = $type;

	$_SESSION["q"]	= null;
	$_SESSION["tf"]	= null;
	$_SESSION["uf"]	= null;
	$_SESSION["df"]	= null;
	$_SESSION["ff"]	= null;

	if($type == ''){
    	    $rd_to           = ($type == '' and self::$cfg["video_module"] == 1) ? 'video' : (($type == '' and self::$cfg["live_module"] == 1) ? 'live' : (($type == '' and self::$cfg["image_module"] == 1) ? 'image' : (($type == '' and self::$cfg["audio_module"] == 1 ? 'audio' : (($type == '' and self::$cfg["document_module"] == 1 ? 'document' : ($type == '' and self::$cfg["blog_module"] == 1 ? 'blog' : null)))))));
        }

        $guest_for       = ($p_t == '' ? $rd_to : $p_t);
	switch ($guest_for) {
		case "live": $u = self::$href["broadcasts"]; break;
		case "video": $u = self::$href["videos"]; break;
		case "image": $u = self::$href["images"]; break;
		case "audio": $u = self::$href["audios"]; break;
		case "doc":
		case "document":  $u = self::$href["documents"]; break;
		case "blog": $u = self::$href["blogs"]; break;
	}
        $guest_chk       = $_SESSION["USER_ID"] == '' ? VHref::guestPermissions('guest_browse_'.($guest_for == 'document' ? 'doc' : $guest_for), $u) : NULL;

        if($p_t === '' or ($p_t != '' and self::$cfg[$p_t."_module"] == 0)) {
            header("Location: ".self::$cfg["main_url"].'/'.VHref::getKey("index"));
        }
        return $rd_to;
    }
	/* browse files layout */
	public static function browseLayout($force_type = false) {
		if ($force_type) {
			switch ($force_type) {
				case self::$href["broadcasts"]: self::$type = 'live'; break;
				case self::$href["videos"]: self::$type = 'video'; break;
				case self::$href["images"]: self::$type = 'image'; break;
				case self::$href["audios"]: self::$type = 'audio'; break;
				case self::$href["documents"]: self::$type = 'doc'; break;
				case self::$href["blogs"]: self::$type = 'blog'; break;
			}
		}
		$res_promoted	= self::$cfg["file_promo"] == 1 ? self::getPromoted() : null;
		$res_live	= self::$type == 'live' ? self::getPromoted(1, 'livenow') : null;
		$res_media	= self::getMedia();
		$res_watchlist  = self::watchlistEntries();

		$html	.= self::$type == 'live' ? self::listPromoted($res_live, $res_watchlist, 'livenow') : null;//streams live now
// 		$html	.= (self::$cfg["file_promo"] == 1 and $res_promoted->fields["file_key"]) ? self::listPromoted($res_promoted, $res_watchlist) : (!$force_type ? (self::$section == self::$href['channel'] ? '<article>' : null).'<h3 class="content-title"><span id="' . self::$type . '-h3" class="section-h3"><i class="icon-' . (self::$type[0] == 'd' ? 'file' : self::$type) . '"></i>' . self::$language["subnav.entry.files.my"] . '</span></h3>'.(self::$section == self::$href['channel'] ? '<div class="line"></div></article>' : null) : null);

		$html	.= self::listMedia($res_media, $res_watchlist);

		return $html;
	}

	/* category file count */
    public static function categoryCount($type, $ct_id, $mobile='', $be=''){
	$_u	 = $_GET["u"] != '' ? sprintf("AND C.`usr_id`='%s'", self::$dbc->singleFieldValue('db_accountuser', 'usr_id', 'usr_key', self::$filter->clr_str(substr($_GET["u"], 1)))) : NULL;

        $sql	 = sprintf("SELECT 
			    C.`file_key`, 
			    COUNT(*) AS `total` 
			    FROM 
			    `db_%sfiles` C 
			    WHERE 
			    C.`file_category` = '%s' %s AND 
			    C.`approved` = '1' AND 
			    C.`deleted` = '0' AND 
			    C.`active` = '1' %s %s;", $type, $ct_id, ($be == '' ? "AND C.`privacy` = 'public'" : NULL), ($mobile == 1 ? "AND C.`file_mobile`='1'" : NULL), $_u);
	
        $res	 = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_categories_menu'], $sql) : self::$db->execute($sql);

	return VFiles::numFormat($res->fields["total"]);
    }
    /* build url from type */
    private static function baseUrl() {
    	switch (self::$type[0]) {
    		case "l":
    			$key = 'broadcasts';
    			break;
		case "v":
    			$key = 'videos';
    			break;
    		case "i":
    			$key = 'images';
    			break;
    		case "a":
    			$key = 'audios';
    			break;
    		case "d":
    			$key = 'documents';
    			break;
    		case "b":
    			$key = 'blogs';
    			break;
    	}
    	
    	return self::$cfg["main_url"] . '/' . self::$href[$key];
    }
    /* category nav menu */
    public static function categoryMenu($type = false) {
        $type            = !$type ? self::$type : $type;
        $get             = self::$filter->clr_str($_GET["c"]);
        $sql             = sprintf("SELECT `ct_id`, `ct_name`, `ct_lang`, `ct_slug`, `ct_icon` FROM `db_categories` WHERE `ct_type`='%s' AND `sub_id`='0' AND `ct_active`='1' AND `ct_menu`='1' ORDER BY `ct_name` ASC;", $type);
        $ct		 = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_categories_menu'], $sql) : self::$db->execute($sql);

	$html		 = VGenerate::advHTML(13);
        if($ct){
            $html .= '
                <div class="blue categories-container">
                    <h4 class="categories-menu-title left-menu-h4"><i class="icon-'.self::$type.'"></i>'.self::$language["frontend.global.bestof"].'</h4>
                    <aside>
                        <nav>
                            <ul class="accordion" id="categories-accordion">
                                <li'.($get == 'today' ? ' class="dcjq-parent-li"' : null).'><a href="'.self::baseUrl($type).'/today" class="'.($get == 'today' ? 'dcjq-parent selected active' : null).'" rel-name="today"><i class="icon-clock-o"></i>'.self::$language["browse.file.picks"].'</a></li>
                                #LI_LOOP#
                            </ul>
                        </nav>
                    </aside>
                </div>
                ';

	    while(!$ct->EOF){
		$db_id	 = $ct->fields["ct_id"];
                $ct_slug = $ct->fields["ct_slug"];
                $ct_icon = $ct->fields["ct_icon"];
                $ct_lang = unserialize($ct->fields["ct_lang"]);
                $ct_src	 = $_SESSION["fe_lang"] != 'en_US' ? ($ct_lang[$_SESSION["fe_lang"]] != '' ? $ct_lang[$_SESSION["fe_lang"]] : $ct->fields["ct_name"]) : $ct->fields["ct_name"];
		$ct_name = VUserinfo::truncateString($ct_src, 30);
                $count   = (self::$cfg["file_counts"] == 1 ? ' ('.self::categoryCount($type, $db_id).')' : null);
                $class   = $get == $ct_slug ? 'dcjq-parent selected active' : null;

                $sub_menu= false;

                $sub_active	  = array();
                $sub_active[$db_id] = ($get === $ct_slug) ? 1 : 0;

                $sq	 = self::$db->execute(sprintf("SELECT `ct_name`, `ct_lang`, `ct_slug`, `ct_icon` FROM `db_categories` WHERE `ct_type`='%s' AND `sub_id`='%s' AND `sub_id`>'0';", $type, $db_id));
                if ($sq->fields["ct_slug"]) {
                	$lsm		  = false;
                	$class		 .= ' sub-categ';
                	$dsp		  = 'none';
                	$dsi		  = 'xp-down iconBe-chevron-down';
//                	$sub_menu	  = '<ul class="inner-menu">';
                	$sub_menu	  = '</li>';

                	while (!$sq->EOF) {
                		//$sub_id   = $sq->fields["ct_id"];
                		$sub_name = $sq->fields["ct_name"];
                		$sub_lang = unserialize($sq->fields["ct_lang"]);
                		$sub_src  = $_SESSION["fe_lang"] != 'en_US' ? ($sub_lang[$_SESSION["fe_lang"]] != '' ? $sub_lang[$_SESSION["fe_lang"]] : $sub_name) : $sub_name;
                		$sub_name = $sub_src;
                		$sub_slug = $sq->fields["ct_slug"];
                		$sub_icon = $sq->fields["ct_icon"];
                		$sub_active[$db_id] = ($get === $sub_slug) ? 2 : 0;
                		$sub_class= $get === $sub_slug ? 'dcjq-parent-off selected active' : null;

                		if ($sub_active[$db_id] == 2) {
                			$dsp = 'block';
                			$dsi = 'xp-up iconBe-chevron-up';
                		}
//                		$sub_menu.= '<li class="sub-categ-li" rel-p="'.$ct_slug.'" style="display:'.($lsm ? 'block' : 'none').'"><a href="'.self::baseUrl($type).'/'.$sub_slug.'" class="'.$sub_class.'" rel-name="'.$sub_slug.'"><i class="'.$sub_icon.'"></i>'.$sub_name.'</a></li>';
                		$sub_menu.= '<li class="sub-categ-li" rel-p="'.$ct_slug.'" style="display:##DSP##"><a href="'.self::baseUrl($type).'/'.$sub_slug.'" class="'.$sub_class.'" rel-name="'.$sub_slug.'"><i class="'.$sub_icon.'"></i>'.$sub_name.'</a></li>';

                		$sq->MoveNext();
                	}
                	$sub_menu	 .= '<li>';
//                	$sub_menu	 .= '</ul>';
                }
		if ($sub_menu)
			$sub_menu = str_replace('##DSP##', $dsp, $sub_menu);

                $li_loop.= '    <li class="'.($sub_active[$db_id] == 1 ? 'dcjq-parent-li' : ($sub_active[$db_id] == 2 ? 'dcjq-current-parent-off' : null)).'"><a href="'.self::baseUrl($type).'/'.$ct_slug.'" class="'.$class.'" rel-name="'.$ct_slug.'"><i class="'.$ct_icon.'"></i>'.$ct_name.$count.'</a>
                			'.($sub_menu ? '<i class="xp-sm '.$dsi.'"></i>'.$sub_menu : null).'
                                </li>';

		@$ct->MoveNext();
	    }
	}
	$html		.= '<script type="text/javascript">$(document).ready(function(){$(".xp-sm").on("click",function(){t=$(this);pr=t.prev().attr("rel-name");if(t.hasClass("xp-down")){$("#categories-accordion li[rel-p="+pr+"]").stop().show("fast", function(){$(".sidebar-container").customScrollbar("resize", true)});t.removeClass("xp-down").addClass("xp-up").removeClass("iconBe-chevron-down").addClass("iconBe-chevron-up");t.prev().addClass("sub-active");}else if(t.hasClass("xp-up")){$("#categories-accordion li[rel-p="+pr+"]").stop().hide("fast", function(){$(".sidebar-container").customScrollbar("resize", true)});t.removeClass("xp-up").addClass("xp-down").removeClass("iconBe-chevron-up").addClass("iconBe-chevron-down");t.prev().removeClass("sub-active");}});$("a.sub-categ-off").mouseenter(function(){t=$(this);pr=t.attr("rel-name");$("#categories-accordion li[rel-p="+pr+"]").stop().show("fast");}).mouseleave(function(){t=$(this);pr=t.attr("rel-name");$("#categories-accordion li[rel-p="+pr+"]").stop().hide("fast");});});</script>';
	$html		.= VGenerate::advHTML(14);

	return str_replace('#LI_LOOP#', $li_loop, $html);
    }
    /* get database entries for promoted */
    private static function getPromoted($viewMode_id = null, $for = false) {
        $type           = self::$type;
	$q		= null;
        $categ_query1   = null;
        $categ_query2   = null;
        $categ_query3   = null;
	
	$sql_1		= null;
	$sql_2		= null;
	$search_order	= false;
	
	if (isset($_SESSION["q"]) and $_SESSION["q"] != '') {
			$squery = trim($_SESSION["q"]);
			$rel	= str_replace(
					array('_', '-', ' ', '.', ',', '(', ')', '!', '@', '#', '$', '%', '^', '&', '*', ':', ';', "'", '"', '(', ')', '[', ']', '{', '}', '?', '|', '●'),
					array('+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+'), $squery);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= rtrim($rel, '+');
			$rel	= self::$filter->clr_str($rel);
			$rel	= str_replace('+', '%', $rel);

			$sql_1	= ", MATCH(A.`file_title`, A.`file_tags`) AGAINST ('".$rel."') AS `Relevance` ";
			$sql_2	= "MATCH(A.`file_title`, A.`file_tags`) AGAINST('".$rel."' IN BOOLEAN MODE) AND ";
			
			$search_order = true;
	}
        
        if (isset($_GET["c"])) {
            $ct_slug      = self::$filter->clr_str($_GET["c"]);
            $categ_query1 = ', E.`ct_name`';
            $categ_query2 = ', `db_categories` E';
            $categ_query3 = "AND (E.`ct_slug`='".$ct_slug."' AND A.`file_category`=E.`ct_id`)";
        }

        switch($viewMode_id) {
            default:
            case "1":
                $des = null;
                $lim = self::$promoted_viewMode1_limit;
                break;
            
            case "3":
            	$des = null;
                $lim = self::$promoted_viewMode2_limit;
                break;

            case "2":
                $des = 'SUBSTRING(A.`file_description`, 1, 200) as `file_description`, ';
                $lim = self::$promoted_viewMode3_limit;
                break;
        }
	
	$adr		 = self::$filter->clr_str($_SERVER["REQUEST_URI"]);
	
//	if (strpos($adr, self::$href["channel"]) !== FALSE) {
	if (self::$section == self::$href["channel"]) {
		$c	 = new VChannel;
		$q	.= sprintf(" AND D.`usr_key`='%s' ", VChannel::$user_key);
	} elseif (isset($_GET["u"])) {
		$q	.= sprintf(" AND D.`usr_key`='%s' ", self::$filter->clr_str($_GET["u"]));
	}
	
	if (isset($_SESSION["uf"]) and (int) $_SESSION["uf"] > 0) {//search filter upload date
		$search_uf = (int) $_SESSION["uf"];
		
		switch ($search_uf) {
			case "1"://last hour
				$q	.= sprintf(" AND A.`upload_date` >= DATE_SUB(NOW(), INTERVAL 1 HOUR) ");
				break;
			case "2"://today
				$q	.= sprintf(" AND DATE(A.`upload_date`) = DATE(NOW()) ");
				break;
			case "3"://this week
				$q	.= sprintf(" AND YEARWEEK(A.`upload_date`) = YEARWEEK(NOW()) ");
				break;
			case "4"://this month
				$q	.= sprintf(" AND A.`upload_date` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ");
				break;
			case "5"://this year
				$q	.= sprintf(" AND YEAR(A.`upload_date`) = YEAR(NOW()) ");
				break;
		}
	}
	if (isset($_SESSION["df"]) and (int) $_SESSION["df"] > 0) {//search filter duration
		$search_df = (int) $_SESSION["df"];
		
		switch ($search_df) {
			case "1"://short
				$q	.= sprintf(" AND A.`file_duration` < 600 ");
				break;
			case "2"://average
				$q	.= sprintf(" AND A.`file_duration` BETWEEN 600 AND 1200 ");
				break;
			case "3"://long
				$q	.= sprintf(" AND A.`file_duration` > 1200 ");
				break;
		}
	}
	if (isset($_SESSION["ff"]) and (int) $_SESSION["ff"] > 0) {//search filter features
		$search_ff = (int) $_SESSION["ff"];
		
		switch ($search_ff) {
			case "1"://sd/static
			case "4":
				$q	.= sprintf(" AND A.`file_hd` = '0' AND A.`file_type` != 'embed' ");
				break;
			case "2"://hd/animated
			case "5":
				$q	.= sprintf(" AND A.`file_hd` = '1' AND A.`file_type` != 'embed' ");
				break;
			case "3"://embedded
				$q	.= sprintf(" AND A.`file_type` = 'embed' ");
				break;
		}
	}
        $sql	 = sprintf("SELECT 
				    A.`file_key`, A.`file_views`, A.`file_duration`, A.`file_like`, A.`file_comments`, A.`thumb_server`, A.`upload_date`,
				    A.`stream_live`, A.`thumb_preview`,
				    A.`file_title`, %s  
				    D.`usr_dname`, D.`ch_title`, 
				    D.`usr_partner`, D.`usr_affiliate`, D.`affiliate_badge`, D.`usr_id`, D.`usr_key`, D.`usr_user` %s %s
				    FROM 
				    `db_%sfiles` A, `db_accountuser` D %s
				    WHERE
				    %s
				    A.`usr_id`=D.`usr_id` AND
				    ".($for == 'livenow' ? "A.`stream_live`='1' AND A.`stream_ended`='0' AND" : null)."
				    ".(!$for ? "A.`is_promoted`='1' AND" : null)."
				    A.`privacy`='public' AND
				    A.`approved`='1' AND
				    A.`deleted`='0' AND
				    A.`active`='1'
				    %s %s ORDER BY RAND() LIMIT %s", $des, $categ_query1, $sql_1, $type, $categ_query2, $sql_2, $categ_query3, $q, $lim);

        $res = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_promoted'], $sql) : self::$db->execute($sql);
        
        return $res;
    }
    /* get database entries for main entries */
    private static function getMedia($viewMode_id = null) {
        $type            = self::$type;
        $sort            = self::$filter->clr_str($_GET["sort"]);
        $categ_query1    = null;
        $categ_query2    = null;
        $categ_query3    = null;
        $ct_slug         = null;
        $q               = null;
	
	$sql_1		= null;
	$sql_2		= null;
	$search_order	= false;
	
	if (isset($_SESSION["q"]) and $_SESSION["q"] != '') {
			$squery = trim($_SESSION["q"]);
			$rel	= str_replace(
					array('_', '-', ' ', '.', ',', '(', ')', '!', '@', '#', '$', '%', '^', '&', '*', ':', ';', "'", '"', '(', ')', '[', ']', '{', '}', '?', '|', '●'),
					array('+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+', '+'), $squery);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= str_replace('++', '+', $rel);
			$rel	= rtrim($rel, '+');
			$rel	= self::$filter->clr_str($rel);
			$rel	= str_replace('+', '%', $rel);

			$sql_1	= ", MATCH(A.`file_title`, A.`file_tags`) AGAINST ('".$rel."') AS `Relevance` ";
			$sql_2	= "MATCH(A.`file_title`, A.`file_tags`) AGAINST('".$rel."' IN BOOLEAN MODE) AND ";

			$search_order = true;
	}
        
        if (isset($_GET["c"])) {//categories
            $ct_slug      = self::$filter->clr_str($_GET["c"]);

            if ($ct_slug != 'today') {
            	$categ_query1 = ', E.`ct_name`';
            	$categ_query2 = ', `db_categories` E';
            	$categ_query3 = "AND (E.`ct_slug`='".$ct_slug."' AND A.`file_category`=E.`ct_id`)";
            }
        }
        
        $ct_today	 = $ct_slug === 'today' ? 1 : 0;

	if ($ct_today == 1) {//today's picks
            $q .= sprintf(" AND A.`last_viewdate`='%s' ", date('Y-m-d'));
	}
        
        switch ($viewMode_id) {
            default:
            case "1":
                $des = null;
                $lim = self::$viewMode1_limit;
                break;
            case "3":
        	$des = null;
                $lim = self::$viewMode2_limit;
                break;
            case "2":
                $des = 'SUBSTRING(A.`file_description`, 1, 200) as `file_description`, ';
                $lim = self::$viewMode3_limit;
                break;
        }

	$adr		= self::$filter->clr_str($_SERVER["REQUEST_URI"]);

	if (self::$section == self::$href["channel"]) {
		$c	 = new VChannel;
		$q	.= sprintf(" AND D.`usr_key`='%s' ", VChannel::$user_key);
	} elseif (isset($_GET["u"])) {
		$q	.= sprintf(" AND D.`usr_key`='%s' ", self::$filter->clr_str($_GET["u"]));
	}
	
	if (isset($_SESSION["uf"]) and (int) $_SESSION["uf"] > 0) {//search filter upload date
		$search_uf = (int) $_SESSION["uf"];
		
		switch ($search_uf) {
			case "1"://last hour
				$q	.= sprintf(" AND A.`upload_date` >= DATE_SUB(NOW(), INTERVAL 1 HOUR) ");
				break;
			case "2"://today
				$q	.= sprintf(" AND DATE(A.`upload_date`) = DATE(NOW()) ");
				break;
			case "3"://this week
				$q	.= sprintf(" AND YEARWEEK(A.`upload_date`) = YEARWEEK(NOW()) ");
				break;
			case "4"://this month
				$q	.= sprintf(" AND A.`upload_date` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ");
				break;
			case "5"://this year
				$q	.= sprintf(" AND YEAR(A.`upload_date`) = YEAR(NOW()) ");
				break;
		}
	}
	if (isset($_SESSION["df"]) and (int) $_SESSION["df"] > 0) {//search filter duration
		$search_df = (int) $_SESSION["df"];
		
		switch ($search_df) {
			case "1"://short
				$q	.= sprintf(" AND A.`file_duration` < 600 ");
				break;
			case "2"://average
				$q	.= sprintf(" AND A.`file_duration` BETWEEN 600 AND 1200 ");
				break;
			case "3"://long
				$q	.= sprintf(" AND A.`file_duration` > 1200 ");
				break;
		}
	}
	if (isset($_SESSION["ff"]) and (int) $_SESSION["ff"] > 0) {//search filter features
		$search_ff = (int) $_SESSION["ff"];
		
		switch ($search_ff) {
			case "1"://sd/static
			case "4":
				$q	.= sprintf(" AND A.`file_hd` = '0' AND A.`file_type` != 'embed' ");
				break;
			case "2"://hd/animated
			case "5":
				$q	.= sprintf(" AND A.`file_hd` = '1' AND A.`file_type` != 'embed' ");
				break;
			case "3"://embedded
				$q	.= sprintf(" AND A.`file_type` = 'embed' ");
				break;
		}
	}

        switch ($sort) {
            case "live":
		    $q	.= "AND A.`stream_live`='1'";
		    break;

            case "recent":
		    $q	.= ($type == 'live' ? "AND A.`stream_live`='0' AND A.`stream_ended`='1' " : null)."ORDER BY A.`db_id` DESC";
		    break;

	    case "relevance":
		    $q	.= "ORDER BY `Relevance` DESC";
		    break;

            case "":
		//$q	.= $search_order ? "ORDER BY `Relevance` DESC" : (self::$section == self::$href["broadcasts"] ? "AND A.`stream_live`='1'" : "ORDER BY A.`db_id` DESC");
		$q	.= $search_order ? "ORDER BY `Relevance` DESC" : ($type == 'live' ? "AND A.`stream_live`='0' AND A.`stream_ended`='1' "  : null)."ORDER BY A.`db_id` DESC";
                break;

            case "featured":
                $q     .= "AND A.`is_featured`='1' ORDER BY RAND()";
                break;

	    case "promoted":
                $q     .= "AND A.`is_promoted`='1' ORDER BY RAND()";
                break;

            case "views":
                $q     .= "AND A.`file_views` > '0' ORDER BY A.`file_views` DESC";
                break;

            case "likes":
                $q     .= "AND A.`file_like` > '0' ORDER BY A.`file_like` DESC";
                break;

            case "comments":
                $q     .= "AND A.`file_comments` > '0' ORDER BY A.`file_comments` DESC";
                break;

            case "favorites":
                $q     .= "AND A.`file_favorite` > '0' ORDER BY A.`file_favorite` DESC";
                break;

            case "responses":
                $q     .= "AND A.`file_responses` > '0' ORDER BY A.`file_responses` DESC";
                break;
        }
        $page       = self::$page;
        $lim_start  = $page > 1 ? (($page * $lim) - $lim) : 0;
        $lim_end    = $lim;
        
        $lim_sql    = sprintf("%s, %s", $lim_start, $lim_end);
        
        $total_sql  = sprintf("SELECT COUNT(*) AS `total`,
				    A.`file_key`,
				    D.`usr_id`
				    %s %s
				    FROM 
				    `db_%sfiles` A, `db_accountuser` D %s
				    WHERE 
				    %s 
				    A.`usr_id`=D.`usr_id` AND
				    ".($type == 'live' ? "A.`stream_ended`='1' AND" : null)."
				    A.`privacy`='public' AND 
				    A.`approved`='1' AND 
				    A.`deleted`='0' AND 
				    A.`active`='1' 
				    %s %s", $categ_query1, $sql_1, $type, $categ_query2, $sql_2, $categ_query3, $q);
        
        $total_res  = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_main'], $total_sql) : self::$db->execute($total_sql);
        $total      = $total_res->fields["total"];
        
        $sql        = sprintf("SELECT 
				    A.`file_key`, A.`file_views`, A.`file_duration`, A.`file_like`, A.`file_comments`, A.`thumb_server`, A.`upload_date`,
				    A.`stream_live`, A.`thumb_preview`,
				    A.`file_title`, %s  
				    D.`usr_dname`, D.`ch_title`,
				    D.`usr_partner`, D.`usr_affiliate`, D.`affiliate_badge`, D.`usr_id`, D.`usr_key`, D.`usr_user` %s %s
				    FROM 
				    `db_%sfiles` A, `db_accountuser` D %s
				    WHERE 
				    %s 
				    A.`usr_id`=D.`usr_id` AND
				    ".($type == 'live-off' ? "A.`stream_ended`='1' AND " : null)."
				    A.`privacy`='public' AND 
				    A.`approved`='1' AND 
				    A.`deleted`='0' AND 
				    A.`active`='1' 
				    %s %s LIMIT %s", $des, $categ_query1, $sql_1, $type, $categ_query2, $sql_2, $categ_query3, $q, $lim_sql);

        $res = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_main'], $sql) : self::$db->execute($sql);

        if ($lim_start + $lim >= $total) {
            self::$page_end = true;
        }
        
        return $res;
    }
    /* get watchlist entries for logged in user */
    public static function watchlistEntries($for = false) {
        $uid = (int) $_SESSION["USER_ID"];
	
	$type = !$for ? self::$type : $for;
		
        
        if (self::$cfg["file_watchlist"] == 1 and $uid > 0) {
            $sql = sprintf("SELECT `watch_list` FROM `db_%swatchlist` WHERE `usr_id`='%s' LIMIT 1", $type, $uid);
            
            $res = self::$db_cache ? self::$db->CacheExecute(self::$cfg['cache_browse_main'], $sql) : self::$db->execute($sql);
            
            if ($res->fields["watch_list"]) {
                return array_values(unserialize($res->fields["watch_list"]));
            }
        }
    }
    /* generate thumbnail url location */
    public static function thumbnail($usr_key, $file_key, $thumb_server = 0, $nr = 0, $force_type = false) {
    	if ($thumb_server > 0) {
    		$expires 	= 0;
    		$custom_policy 	= 0;

    		return VGenerate::thumbSigned(($force_type ? $force_type : self::$type), $file_key, $usr_key, $expires, $custom_policy, $nr);
    	}

        return self::$cfg["media_files_url"] . '/' . $usr_key . '/t/' . $file_key . '/' . $nr . '.jpg';
    }
    /* grid viewmode */
    public static function viewMode1($entries, $user_watchlist, $type = false, $exclude = false) {
	if ($type) {
		self::$type = $type;
	}
        if ($entries->fields["file_key"]) {
            $li_loop        = null;
            $duration_show  = (self::$type === 'audio' or self::$type === 'video' or self::$type === 'live') ? 1 : 0;
            $mobile	 = VHref::isMobile();

            foreach ($entries as $entry) {
                $title      = $entries->fields["file_title"];
                $user       = $entries->fields["usr_user"];
                $displayname= $entries->fields["usr_dname"];
		$chname	    = $entries->fields["ch_title"];
		$user	    = $displayname != '' ? $displayname : ($chname != '' ? $chname : $user);
                $file_key   = $entries->fields["file_key"];
                $usr_key    = $entries->fields["usr_key"];
                $usr_id     = $entries->fields["usr_id"];
                $usr_affiliate	= $entries->fields["usr_affiliate"];
                $usr_partner	= $entries->fields["usr_partner"];
                $usr_affiliate	= ($usr_affiliate == 1 or $usr_partner == 1) ? 1 : 0;
                $af_badge	= $entries->fields["affiliate_badge"];
                $thumb_server = $entries->fields["thumb_server"];
                $is_live    = (self::$type == 'live' and $entries->fields["stream_live"] == 1) ? true : false;
                $datetime   = VUserinfo::timeRange($entries->fields["upload_date"]);
                $duration   = VFiles::fileDuration($entries->fields["file_duration"]);
                $views      = VFiles::numFormat($entries->fields["file_views"]);
                $likes      = VFiles::numFormat($entries->fields["file_like"]);
                $comments   = VFiles::numFormat($entries->fields["file_comments"]);
                $url        = self::$cfg["main_url"].'/'.VGenerate::fileHref(self::$type[0], $file_key, $title);// title="'.$f_title_full.'"';
                $ch_url	    = self::$cfg["main_url"].'/'.VHref::getKey("channel").'/'.$usr_key.'/'.$entries->fields["usr_user"];
                $def_thumb	= self::$cfg["global_images_url"].'/default-thumb.png';
                $vpv		= $entries->fields["thumb_preview"];

                if ($duration_show == 1 and $duration == '00:00') {
                	$conv		= VFileinfo::get_progress($file_key);
                	$conv_class	= ' converting';
                	$thumbnail	= null;
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
                        $watchlist_info = ' rel-key="'.$file_key.'" rel-type="'.self::$type.'"';
                    }
                }

//                $vpv	 = file_exists(self::$cfg["media_files_dir"].'/'.$usr_key.'/v/'.md5($file_key.'_preview').'.mp4');

                $li_loop.= '                    <li class="vs-column fourths small-thumbs">
                                                    <div class="thumbs-wrapper">
                                                    '.(self::$cfg["file_watchlist"] == 1 ? '
                                                        <div class="watch_later">
                                                            <div class="watch_later_wrap"'.$watchlist_info.'>
                                                                <div class="watch_later_holder">
                                                                    <i class="'.$watchlist_icon.'"></i>
                                                                </div>
                                                            </div>
                                                            <span>'.$watchlist_text.'</span>
                                                        </div>
                                                    ' : null).'
                                                        <figure class="effect-smallT'.$conv_class.'">
                                                            <i class="play-btn" onclick="window.location=\''.$url.'\'"></i>
                                                            '.$thumbnail.'
                                                            '.(!$mobile ? '
                                                            <div style="display:none;position:absolute;top:0;width:100%;height:100%" class="vpv">
                                                                <a href="'.$url.'" class="no-display">'.$title.'</a>
                                                                '.($vpv ? '
                                                                <video loop playsinline="true" muted="true" style="width:100%;height:100%" id="pv'.$file_key.rand(9999,999999999).'" rel-u="'.$usr_key.'" rel-v="'.md5($file_key.'_preview').'" oncontextmenu="return false;" onclick="window.location=\''.$url.'\'">
                                                                	<source src="'.self::$cfg["previews_url"].'/default.mp4" type="video/mp4"></source>
                                                                </video>
                                                                ' : null).'
                                                            </div>
                                                            ' : null).'
                                                        '.($duration_show == 1 ? '
                                                        <div class="caption-more">
                                                            <span class="time-lenght'.($is_live ? ' t-live' : null).'">'.($is_live ? self::$language["frontend.global.live"] : $duration.$conv).'</span>
                                                        </div>
                                                        ' : null).'
                                                        </figure>
                                                        <h3><a href="'.$url.'">'.$title.'</a></h3>
                                                        <div class="profile_image">
                                                            <div class="profile_wrap">
                                                                <span class="channel_name" onclick="window.location=\''.$ch_url.'\'">'.VAffiliate::affiliateBadge($usr_affiliate, $af_badge).$user.'</span>
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
            }
        }
        
        if (self::$page > 1) {
            return $li_loop;
        }
        
        $html = '                           <ul class="fileThumbs big clearfix'.(!$exclude ? ' view-list' : null).'">
                                                '.$li_loop.'
                                            </ul>';
        
        return $html;
    }
    /* list viewmode */
    private static function viewMode2($entries, $user_watchlist) {
        if ($entries->fields["file_key"]) {
            $li_loop            = null;
            $duration_show      = (self::$type === 'audio' or self::$type === 'video' or self::$type === 'live') ? 1 : 0;
            $mobile	 = VHref::isMobile();
            foreach ($entries as $entry) {
                $title          = $entries->fields["file_title"];
                $description    = $entries->fields["file_description"];
                $user           = $entries->fields["usr_user"];
                $displayname	= $entries->fields["usr_dname"];
		$chname		= $entries->fields["ch_title"];
		$user		= $displayname != '' ? $displayname : ($chname != '' ? $chname : $user);
                $file_key       = $entries->fields["file_key"];
                $usr_key        = $entries->fields["usr_key"];
                $usr_id         = $entries->fields["usr_id"];
                $thumb_server	= $entries->fields["thumb_server"];
                $is_live	= (self::$type == 'live' and $entries->fields["stream_live"] == 1) ? true : false;
                $datetime	= VUserinfo::timeRange($entries->fields["upload_date"]);
                $duration       = VFiles::fileDuration($entries->fields["file_duration"]);
                $views          = VFiles::numFormat($entries->fields["file_views"]);
                $likes          = VFiles::numFormat($entries->fields["file_like"]);
                $comments       = VFiles::numFormat($entries->fields["file_comments"]);
                $url            = self::$cfg["main_url"].'/'.VGenerate::fileHref(self::$type[0], $file_key, $title);// title="'.$f_title_full.'"';
                $ch_url		= self::$cfg["main_url"].'/'.VHref::getKey("channel").'/'.$usr_key.'/'.$entries->fields["usr_user"];
                $def_thumb	= self::$cfg["global_images_url"].'/default-thumb.png';
                $vpv		= $entries->fields["thumb_preview"];

                if ($duration_show == 1 and $duration == '00:00') {
                	$conv		= VFileinfo::get_progress($file_key);
                	$conv_class	= ' converting';
                	$thumbnail	= null;
                } else {
                	$conv		= null;
                	$conv_class	= null;
			$img_src	= (self::$type == 'blog' and !file_exists(self::$cfg["media_files_dir"].'/'.$usr_key.'/t/'.$file_key.'/1.jpg')) ? self::$cfg["global_images_url"] . '/default-blog.png' : self::thumbnail($usr_key, $file_key, $thumb_server);
			$thumbnail	= '<img height="183" class="mediaThumb" src="'.$def_thumb.'" data-src="'.$img_src.'" alt="'.$title.'" onclick="window.location=\''.$url.'\'">';
                }

		if (self::$cfg["file_watchlist"] == 1) {
                	if (is_array($user_watchlist) and in_array($file_key, $user_watchlist)) {
                    		$watchlist_icon = 'icon-check';
                    		$watchlist_text = self::$language["files.menu.watch.in"];
                    		$watchlist_info = null;
                	} else {
                    		$watchlist_icon = 'icon-clock';
                    		$watchlist_text = self::$language["files.menu.watch.later"];
                    		$watchlist_info = ' rel-key="'.$file_key.'" rel-type="'.self::$type.'"';
                	}
                }

                //$vpv	 = file_exists(self::$cfg["media_files_dir"].'/'.$usr_key.'/v/'.md5($file_key.'_preview').'.mp4');


                $li_loop.= '                    <li class="vs-column full-thumbs">
                                                    <div class="thumbs-wrapper">
                                                    '.(self::$cfg["file_watchlist"] == 1 ? '
                                                        <div class="watch_later">
                                                            <div class="watch_later_wrap"'.$watchlist_info.'>
                                                                <div class="watch_later_holder">
                                                                    <i class="'.$watchlist_icon.'"></i>
                                                                </div>
                                                            </div>
                                                            <span>'.$watchlist_text.'</span>
                                                        </div>
                                                    ' : null).'
                                                        <figure class="effect-fullT'.$conv_class.'">
                                                            <i class="play-btn" onclick="window.location=\''.$url.'\'"></i>
                                                            '.$thumbnail.'
                                                            '.($duration_show == 1 ? '
                                                            <div class="caption-more">
                                                                <span class="time-lenght'.($is_live ? ' t-live' : null).'">'.($is_live ? self::$language["frontend.global.live"] : $duration.$conv).'</span>
                                                            </div>
                                                            ' : null).'
                                                            '.(!$mobile ? '
                                                            <div style="display:none;position:absolute;top:0;width:100%;height:100%" class="vpv">
                                                                <a href="'.$url.'" class="no-display">'.$title.'</a>
                                                                '.($vpv ? '
                                                                <video loop playsinline="true" muted="true" style="width:100%;height:100%" id="pv'.$file_key.rand(9999,999999999).'" rel-u="'.$usr_key.'" rel-v="'.md5($file_key.'_preview').'" oncontextmenu="return false;" onclick="window.location=\''.$url.'\'">
                                                                	<source src="'.self::$cfg["previews_url"].'/default.mp4" type="video/mp4"></source>
                                                                </video>
                                                                ' : null).'
                                                            </div>
                                                            ' : null).'
                                                        </figure>

                                                        <div class="full-details-holder">
                                                            <h2><a href="'.$url.'">'.$title.'</a></h2>
                                                            <p>'.nl2br($description).'</p>
                                                            <div class="vs-column pd">
                                                                <span class="views-number">'.$views.' '.($views == 1 ? self::$language["frontend.global.view"] : self::$language["frontend.global.views"]).'</span>
                                                                <span class="i-bullet"></span>
                                                                <span class="views-number">'.$datetime.'</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>';
            }
        }
        
        if (self::$page > 1) {
            return $li_loop;
        }
        
        $html = '                           <ul class="fileThumbs big clearfix">
                                                '.$li_loop.'
                                            </ul>';
        
        return $html;
    }
    /* viewmode loader */
    public static function viewMode_loader($viewMode_id, $entries = false, $user_watchlist = false) {
        $entries = (isset($_GET["p"]) and (int) $_GET["p"] == 1) ? self::getPromoted($viewMode_id) : self::getMedia($viewMode_id);
        $section = $entries ? (isset($_GET["sort"]) ? self::$filter->clr_str($_GET["sort"]) : ((isset($_SESSION['q']) and $_SESSION['q'] != '') ? 'relevance' : 'recent')) : false;

        if (!$section)
            return;

        if (!$user_watchlist) {
            $user_watchlist = self::watchlistEntries();
        }

        $method  = "viewMode" . $viewMode_id;
        $content = $entries->fields["file_key"] ? self::$method($entries, $user_watchlist) : VGenerate::simpleDivWrap('no-content', '', self::$language["frontend.global.results.none"]);

        if (self::$page_end) {
        	if (isset($_GET["m"])) {
        		$js       = 'if (typeof($) != "undefined") { setTimeout(function () { $("#main-view-mode-'.$viewMode_id.'-'.$section.'-more").detach(); }, 200); }';
        		$content .= VGenerate::declareJS('$(document).ready(function(){'.$js.'});');
        	}
        } else {
            $content .= ((isset($_GET["p"]) and (int) $_GET["p"] == 0 and !isset($_GET["page"])) or !isset($_GET["p"])) ? self::loadMore($viewMode_id, $section) : null;
        }

        return $content;
    }
    /* tab section loader */
    public static function tabSection_loader($tabSection, $category = false) {
//    	$default_viewMode = (int) $_SESSION[self::$type."_vm"] > 0 ? (int) $_SESSION[self::$type."_vm"] : 1;
    	$default_viewMode = 1;
        $title_category = $category ? ' <i class="iconBe-chevron-right"></i> '.$category : null;
        
        switch($tabSection) {
	    case "recent":
                $title  = self::typeLangReplace(self::$language["files.menu.recent.type"]);
                $icon   = 'clock-o';
                break;
	
	    case "live":
                $title  = self::typeLangReplace(self::$language["files.menu.live.type"]);
                $icon   = 'live';
                break;
	
	    case "relevance":
                $title  = self::typeLangReplace(self::$language["files.menu.relavant.type"]);
                $icon   = 'search';
                break;
	
            case "featured":
                $title  = self::typeLangReplace(self::$language["files.menu.featured.type"]);
                $icon   = 'star';
                break;
	
	    case "promoted":
                $title  = self::typeLangReplace(self::$language["files.menu.promoted.type"]);
                $icon   = 'bullhorn';
                break;
            
            case "views":
                $title  = self::typeLangReplace(self::$language["files.menu.viewed.type"]);
                $icon   = 'eye';
                break;
            
            case "likes":
                $title  = self::typeLangReplace(self::$language["files.menu.most.liked.type"]);
                $icon   = 'thumbs-up';
                break;
            
            case "comments":
                $title  = self::typeLangReplace(self::$language["files.menu.commented.type"]);
                $icon   = 'comment';
                break;
            
            case "favorites":
                $title  = self::typeLangReplace(self::$language["files.menu.favorited.type"]);
                $icon   = 'heart';
                break;
            
            case "responses":
                $title  = self::typeLangReplace(self::$language["files.menu.responded.type"]);
                $icon   = 'comments';
                break;
        }
        
        $html = '                           <section id="section-'.$tabSection.'">
                                                <article>
                                                    <h2 class="content-title"><i class="icon-'.$icon.'"></i>'.$title.$title_category.'</h2>
                                                    <section class="filter">
                                                        <div class="main loadmask-img pull-left"></div>
                                                        <div class="btn-group viewType vmtop pull-right">
                                                            <button type="button" id="main-view-mode-1-'.$tabSection.'" value="'.$tabSection.'" class="viewType_btn viewType_btn-default main-view-mode '.self::$type.''.($default_viewMode == 1 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view2"].'"><span class="icon-thumbs-with-details"></span></button>
                                                            <button type="button" id="main-view-mode-2-'.$tabSection.'" value="'.$tabSection.'" class="viewType_btn viewType_btn-default main-view-mode '.self::$type.''.($default_viewMode == 2 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view3"].'"><span class="icon-full-details"></span></button>
                                                        </div>
                                                    </section>
                                                    <div class="line"></div>
                                                </article>
                                                
                                                <div class="row mview" id="main-view-mode-1-'.$tabSection.'-list"'.($default_viewMode == 2 ? ' style="display: none"' : null).'>
                                                </div>

                                                <div class="row mview" id="main-view-mode-2-'.$tabSection.'-list"'.($default_viewMode == 1 ? ' style="display: none"' : null).'>
                                                </div>

                                                <div class="row mview" id="main-view-mode-3-'.$tabSection.'-list" style="display: none;">
                                                </div>
                                            </section>';
        
        return $html;
    }
    /* list promoted entries */
    private static function listPromoted($entries, $user_watchlist, $livenow=false) {
        $category       = isset($entries->fields["ct_name"]) ? $entries->fields["ct_name"] : false;
        $title_category = $category ? ' <i class="iconBe-chevron-right"></i> '.$category : null;
        $default_viewMode = (int) $_SESSION[self::$type."_pvm"] > 0 ? (int) $_SESSION[self::$type."_pvm"] : 1;
        $default_viewMode = 1;
        $fn = 'viewMode'.$default_viewMode;
        $content        = $entries->fields["file_key"] ? self::$fn($entries, $user_watchlist) : (!$livenow ? VGenerate::simpleDivWrap('no-content', '', self::$language["frontend.global.results.none"]) : false);

	if ($content !== false) {
        	$html = '
                                    <div id="promo-content">
                                        <article>
                                            <h2 class="content-title"><i class="'.($livenow ? 'icon-live' : 'icon-bullhorn').'"></i>'.($livenow ? self::$language["frontend.global.live.now"] : self::typeLangReplace(self::$language["frontend.global.promoted"])).$title_category.'</h2>
                                            '.(self::$section != self::$href["broadcasts"] ? '
                                            <section class="filter">
                                                <div class="promo loadmask-img pull-left"></div>
                                                <div class="btn-group viewType vmtop pull-right">
                                                    <button type="button" id="promo-view-mode-1" class="viewType_btn viewType_btn-default promo-view-mode '.self::$type.''.($default_viewMode == 1 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view2"].'"><span class="icon-thumbs-with-details"></span></button>
                                                    <button type="button" id="promo-view-mode-2" class="viewType_btn viewType_btn-default promo-view-mode '.self::$type.''.($default_viewMode == 2 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view3"].'"><span class="icon-full-details"></span></button>
                                                </div>
                                            </section>
                                            ' : null).'
                                            <div class="line"></div>
                                        </article>
                                        '.VGenerate::advHTML(56).'
                                        <div class="row pview" id="promo-view-mode-1-list"'.($default_viewMode == 2 ? ' style="display: none"' : null).'>
                                        	' . ($default_viewMode == 1 ? $content : null) . '
                                        </div>

                                        <div class="row pview" id="promo-view-mode-2-list"'.($default_viewMode == 1 ? ' style="display: none"' : null).'>
                                        	' . ($default_viewMode == 2 ? $content : null) . '
                                        </div>

                                        <div class="row pview" id="promo-view-mode-3-list" style="display: none;">
                                        </div>
                                        '.VGenerate::advHTML(57).'
                                    </div>
                ';
        }
        return $html;
    }
    /* sorting tabs */
    private static function tabs() {
        $html = '                       <nav>
                                            <ul>
						'.((isset($_SESSION["q"]) and $_SESSION["q"] != '') ? '<li><a href="#section-relevance" class="icon icon-search" rel="nofollow"><span>'.self::$language["files.menu.relevance"].'</span></a></li>' : null).'
						'.(((isset($_SESSION["q"]) and $_SESSION["q"] != '' and isset($_GET["tf"]) and (int) $_GET["tf"] == 8)) ? '<li><a href="#section-live" class="icon icon-live" rel="nofollow"><span>'.self::$language["files.menu.live"].'</span></a></li>' : null).'
						'.((isset($_SESSION["q"]) and $_SESSION["q"] != '') ? '<li><a href="#section-promoted" class="icon icon-bullhorn" rel="nofollow"><span>'.self::$language["files.menu.promoted"].'</span></a></li>' : null).'
						'.('<li><a href="#section-recent" class="icon icon-clock-o" rel="nofollow"><span>'.self::$language["files.menu.recent"].'</span></a></li>').'
                                                '.('<li><a href="#section-featured" class="icon icon-star" rel="nofollow"><span>'.self::$language["files.menu.featured"].'</span></a></li>').'
                                                '.('<li><a href="#section-views" class="icon icon-eye" rel="nofollow"><span>'.self::$language["files.menu.viewed"].'</span></a></li>').'
                                                '.(self::$cfg["file_rating"] == 1 ? '<li><a href="#section-likes" class="icon icon-thumbs-up" rel="nofollow"><span>'.self::$language["files.menu.most.liked"].'</span></a></li>' : null).'
                                                '.(self::$cfg["file_comments"] == 1 ? '<li><a href="#section-comments" class="icon icon-comment" rel="nofollow"><span>'.self::$language["files.menu.commented"].'</span></a></li>' : null).'
                                                '.(self::$cfg["file_favorites"] == 1 ? '<li><a href="#section-favorites" class="icon icon-heart" rel="nofollow"><span>'.self::$language["files.menu.favorited"].'</span></a></li>' : null).'
                                                '.(self::$cfg["file_responses"] == 1 ? '<li><a href="#section-responses" class="icon icon-comments" rel="nofollow"><span>'.self::$language["files.menu.responded"].'</span></a></li>' : null).'
                                            </ul>
                                        </nav>';
        
        return $html;
    }
    /* list available media files */
    private static function listMedia($entries, $user_watchlist) {
        $category       = isset($entries->fields["ct_name"]) ? $entries->fields["ct_name"] : false;
        $title_category = $category ? ' <i class="iconBe-chevron-right"></i> '.$category : null;
        $default_viewMode = (int) $_SESSION[self::$type."_vm"] > 0 ? (int) $_SESSION[self::$type."_vm"] : 1;
        $default_viewMode = 1;
        $content        = $entries->fields["file_key"] ? self::viewMode_loader($default_viewMode, $entries, $user_watchlist) : VGenerate::simpleDivWrap('no-content', '', self::$language["frontend.global.results.none"]);
	//$default_section= (isset($_SESSION["q"]) and $_SESSION["q"] != '') ? 'relevance' : (self::$section == self::$href["broadcasts"] ? 'live' : 'recent');
	$default_section= (isset($_SESSION["q"]) and $_SESSION["q"] != '') ? 'relevance' : 'recent';

        $html = '                   <div id="main-content" class="tabs tabs-style-topline">
                                        ' . self::tabs() . '

                                        <div class="content-wrap">
                                            <section id="section-'.$default_section.'" class="content-current">
                                                <article>
                                                    <h2 class="content-title"><i class="'.((isset($_SESSION["q"]) and $_SESSION["q"] != '') ? 'icon-search' : (self::$section == self::$href["broadcasts"] ? 'icon-live' : 'icon-clock-o')).'"></i>'.self::typeLangReplace(((isset($_SESSION["q"]) and $_SESSION["q"] != '') ? self::$language["files.menu.relevant.type"] : (self::$section == self::$href["broadcasts-off"] ? self::$language["files.menu.live.type"] : self::$language["files.menu.recent.type"]))).$title_category.'</h2>
                                                    <section class="filter">
                                                        <div class="main loadmask-img pull-left"></div>
                                                        <div class="btn-group viewType vmtop pull-right">
                                                            <button type="button" id="main-view-mode-1-'.$default_section.'" value="'.$default_section.'" class="viewType_btn viewType_btn-default main-view-mode'.($default_viewMode == 1 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view2"].'"><span class="icon-thumbs-with-details"></span></button>
                                                            <button type="button" id="main-view-mode-2-'.$default_section.'" value="'.$default_section.'" class="viewType_btn viewType_btn-default main-view-mode'.($default_viewMode == 2 ? ' active' : null).'" rel="tooltip" title="'.self::$language["files.menu.view3"].'"><span class="icon-full-details"></span></button>
                                                        </div>
                                                    </section>
                                                    <div class="line"></div>
                                                </article>
                                                '.VGenerate::advHTML(58).'
                                                <div class="row mview" id="main-view-mode-1-'.$default_section.'-list"'.($default_viewMode == 2 ? ' style="display: none"' : null).'>
                                                    	' . ($default_viewMode == 1 ? $content : null) . '
                                                </div>

                                                <div class="row mview" id="main-view-mode-2-'.$default_section.'-list"'.($default_viewMode == 1 ? ' style="display: none"' : null).'>
                                                	' . ($default_viewMode == 2 ? $content : null) . '
                                                </div>

                                                <div class="row mview" id="main-view-mode-3-'.$default_section.'-list" style="display: none;">
                                                </div>
                                                '.VGenerate::advHTML(59).'
                                            </section>
                                            ' . ((isset($_SESSION["q"]) and $_SESSION["q"] != '' and (isset($_GET["tf"]) and (int) $_GET["tf"] == 8)) ? self::tabSection_loader('live', $category) : null) . '
					    ' . ((isset($_SESSION["q"]) and $_SESSION["q"] != '') ? self::tabSection_loader('promoted', $category) : null) . '
					    ' . (((isset($_SESSION["q"]) and $_SESSION["q"] != '') or self::$section == self::$href["broadcasts-off"]) ? self::tabSection_loader('recent', $category) : null) . '
                                            ' . self::tabSection_loader('featured', $category) . '
                                            ' . self::tabSection_loader('views', $category) . '
                                            ' . self::tabSection_loader('likes', $category) . '
                                            ' . self::tabSection_loader('comments', $category) . '
                                            ' . self::tabSection_loader('favorites', $category) . '
                                            ' . self::tabSection_loader('responses', $category) . '
                                        </div><!-- /content-wrap -->
                                    </div><!-- /tabs -->';
        
        return $html;
    }
    private static function loadMore($viewMode, $section) {
        $html = '                               <div class="btn-group load-more-group">
                                                    <button class="more-button" id="main-view-mode-'.$viewMode.'-'.$section.'-more" rel-page="2">
                                                        <span class="load-more loadmask-img">'.self::$language["frontend.global.loading"].'</span>
                                                        <span class="load-more-text"><i class="iconBe-plus"></i></span>
                                                    </button>
                                                    <a href="" class="nextSelector" rel="nofollow"></a>
                                                </div>
                                                ';
        
        return $html;
    }
    private static function typeLangReplace($src) {
        return str_replace('##TYPE##', self::$language["frontend.global.".self::$type[0].".p.c"], $src);
    }
}
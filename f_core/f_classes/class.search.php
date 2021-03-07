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

class VSearch {
	private static $cfg;
	private static $db;
	private static $db_cache;
	private static $dbc;
	private static $filter;
	private static $language;
	private static $href;
	private static $smarty;
	private static $search_type;
	
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
		
		self::$search_type = self::$href["videos"];
		
		self::$db_cache = false; //change here to enable caching
	}
	public static function c_section() {
		$class_filter	= self::$filter;
		$smarty		= self::$smarty;
		$filter_type	= isset($_GET["tf"]) ? (int) ($_GET["tf"]) : 0;

		switch ($filter_type) {
			case 0:
			case 1:
				self::$search_type = self::$href["videos"];
				break;
			case 2:
				self::$search_type = self::$href["images"];
				break;
			case 3:
				self::$search_type = self::$href["audios"];
				break;
			case 4:
				self::$search_type = self::$href["documents"];
				break;
			case 5:
				self::$search_type = self::$href["playlists"];
				break;
			case 6:
				self::$search_type = self::$href["channels"];
				break;
			case 7:
				self::$search_type = self::$href["blogs"];
				break;
			case 8:
				self::$search_type = self::$href["broadcasts"];
				break;
		}

		$smarty->assign('c_section', self::$search_type);
	}
	/* search page layout */
	public static function searchLayout() {
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_filter	= self::$filter;

		$filter_type	= isset($_GET["tf"]) ? (int) ($_GET["tf"]) : 0;
		$filter_upload	= isset($_GET["uf"]) ? (int) ($_GET["uf"]) : 0;
		$filter_dur	= isset($_GET["df"]) ? (int) ($_GET["df"]) : 0;
		$filter_feat	= isset($_GET["ff"]) ? (int) ($_GET["ff"]) : 0;
		
		switch ($filter_type) {
			case 0:
			case 1:
				self::$search_type = self::$href["videos"];
				break;
			case 2:
				self::$search_type = self::$href["images"];
				break;
			case 3:
				self::$search_type = self::$href["audios"];
				break;
			case 4:
				self::$search_type = self::$href["documents"];
				break;
			case 5:
				self::$search_type = self::$href["playlists"];
				break;
			case 6:
				self::$search_type = self::$href["channels"];
				break;
			case 7:
				self::$search_type = self::$href["blogs"];
				break;
			case 8:
				self::$search_type = self::$href["broadcasts"];
				break;
		}

		$filter_type_array = array(
			1 => $language["frontend.global.v.p.c"],
			2 => $language["frontend.global.i.p.c"],
			3 => $language["frontend.global.a.p.c"],
			4 => $language["frontend.global.d.p.c"],
			5 => $language["frontend.global.playlists"],
			6 => $language["frontend.global.channels"],
			7 => $language["frontend.global.blogs"],
			8 => $language["frontend.global.l.p.c"],
		);
		if ($cfg["video_module"] == 0) { unset($filter_type_array[1]); }
		if ($cfg["image_module"] == 0) { unset($filter_type_array[2]); }
		if ($cfg["audio_module"] == 0) { unset($filter_type_array[3]); }
		if ($cfg["document_module"] == 0) { unset($filter_type_array[4]); }
		if ($cfg["file_playlists"] == 0) { unset($filter_type_array[5]); }
		if ($cfg["public_channels"] == 0) { unset($filter_type_array[6]); }
		if ($cfg["blog_module"] == 0) { unset($filter_type_array[7]); }
		if ($cfg["live_module"] == 0) { unset($filter_type_array[8]); }

		$filter_upload_array	= array(
			1 => $language["search.text.date.hour"],
			2 => $language["search.text.date.day"],
			3 => $language["search.text.date.week"],
			4 => $language["search.text.date.month"],
			5 => $language["search.text.date.year"]
		);
		
		$filter_dur_array	= array(
			1 => $language["search.text.dur.short"],
			2 => $language["search.text.dur.average"],
			3 => $language["search.text.dur.long"]
		);
		
		$filter_feat_array	= array(
			1 => $language["search.text.feat.sd"],
			2 => $language["search.text.feat.hd"],
			3 => $language["search.text.feat.embed"],
			4 => $language["search.text.feat.static"],
			5 => $language["search.text.feat.anim"]
		);
		$html	= '
				<article class="sf">
                                        <div class="vs-column thirds">
                                        	<h3 class="content-title"><i class="icon-search"></i> '.$language["search.h1.search"].' "'.htmlspecialchars_decode($_SESSION["q"]).'"</h3>
                                        </div>
					<div class="vs-column two_thirds fit">
						<div class="place-right">
							<a class="filter-link" href="javascript:;" onclick="$(\'#search-filters-wrap\').stop().slideToggle(); $(this).toggleClass(\'active\');" rel="nofollow">'.$language["search.text.filters"].' <i class="iconBe-chevron-down"></i></a>
							'.(($filter_type > 0) ? '<a class="filter-tag" href="javascript:;" rel="nofollow" rel-val="'.$filter_type.'" rel-type="tf">'.$filter_type_array[$filter_type].' <i class="icon-times"></i></a>' : null).'
							'.(($filter_upload > 0) ? '<a class="filter-tag" href="javascript:;" rel="nofollow" rel-val="'.$filter_upload.'" rel-type="uf">'.$filter_upload_array[$filter_upload].' <i class="icon-times"></i></a>' : null).'
							'.(($filter_dur > 0) ? '<a class="filter-tag" href="javascript:;" rel="nofollow" rel-val="'.$filter_dur.'" rel-type="df">'.$filter_dur_array[$filter_dur].' <i class="icon-times"></i></a>' : null).'
							'.(($filter_feat > 0) ? '<a class="filter-tag" href="javascript:;" rel="nofollow" rel-val="'.$filter_feat.'" rel-type="ff">'.$filter_feat_array[$filter_feat].' <i class="icon-times"></i></a>' : null).'
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="search-filters-wrap" style="display: none;">
						<div id="search-filters">
							<div class="vs-column fourths">
								<h4>'.$language["search.text.type"].'</h4>
								<ul>
									'.($cfg["live_module"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="8"><i class="icon-live"></i> '.$filter_type_array[8].($filter_type == 8 ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									'.($cfg["video_module"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="1"><i class="icon-video"></i> '.$filter_type_array[1].(($filter_type == 0 or $filter_type == 1) ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									'.($cfg["image_module"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="2"><i class="icon-image"></i> '.$filter_type_array[2].($filter_type == 2 ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									'.($cfg["audio_module"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="3"><i class="icon-audio"></i> '.$filter_type_array[3].($filter_type == 3 ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									'.($cfg["document_module"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="4"><i class="icon-file"></i> '.$filter_type_array[4].($filter_type == 4 ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									'.($cfg["blog_module"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="7"><i class="icon-pencil2"></i> '.$filter_type_array[7].($filter_type == 7 ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									'.($cfg["public_channels"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="6"><i class="icon-users"></i> '.$filter_type_array[6].($filter_type == 6 ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									'.($cfg["file_playlists"] == 1 ? '<li><a href="javascript:;" rel="nofollow" class="filter-type" rel-val="5"><i class="icon-list"></i> '.$filter_type_array[5].($filter_type == 5 ? ' <i class="icon-check"></i>' : null).'</a></li>' : null).'
									
								</ul>
								<span id="filter-type-val" class="no-display" rel="nofollow">'.$filter_type.'</span>
							</div>
							<div class="vs-column fourths">
								<h4>'.$language["search.text.date"].'</h4>
								<ul>
									<li><a href="javascript:;" rel="nofollow" class="filter-upload" rel-val="1"><i class="icon-history"></i> '.$filter_upload_array[1].($filter_upload == 1 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-upload" rel-val="2"><i class="icon-history"></i> '.$filter_upload_array[2].($filter_upload == 2 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-upload" rel-val="3"><i class="icon-history"></i> '.$filter_upload_array[3].($filter_upload == 3 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-upload" rel-val="4"><i class="icon-history"></i> '.$filter_upload_array[4].($filter_upload == 4 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-upload" rel-val="5"><i class="icon-history"></i> '.$filter_upload_array[5].($filter_upload == 5 ? ' <i class="icon-check"></i>' : null).'</a></li>
								</ul>
								<span id="filter-upload-val" class="no-display" rel="nofollow">'.$filter_upload.'</span>
							</div>
							<div class="vs-column fourths">
								<h4>'.$language["search.text.duration"].'</h4>
								<ul>
									<li><a href="javascript:;" rel="nofollow" class="filter-dur'.(($filter_type != 0 and $filter_type != 1 and $filter_type != 3 and $filter_type != 8) ? ' filter-off' : null).'" rel-val="1"><i class="icon-stopwatch"></i> '.$filter_dur_array[1].($filter_dur == 1 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-dur'.(($filter_type != 0 and $filter_type != 1 and $filter_type != 3 and $filter_type != 8) ? ' filter-off' : null).'" rel-val="2"><i class="icon-stopwatch"></i> '.$filter_dur_array[2].($filter_dur == 2 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-dur'.(($filter_type != 0 and $filter_type != 1 and $filter_type != 3 and $filter_type != 8) ? ' filter-off' : null).'" rel-val="3"><i class="icon-stopwatch"></i> '.$filter_dur_array[3].($filter_dur == 3 ? ' <i class="icon-check"></i>' : null).'</a></li>
								</ul>
								<span id="filter-dur-val" class="no-display" rel="nofollow">'.$filter_dur.'</span>
							</div>
							<div class="vs-column fourths fit">
								<h4>'.$language["search.text.features"].'</h4>
								<ul>
									<li><a href="javascript:;" rel="nofollow" class="filter-feat'.(($filter_type != 0 and $filter_type != 1) ? ' filter-off' : null).'" rel-val="1"><i class="icon-laptop"></i> '.$filter_feat_array[1].($filter_feat == 1 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-feat'.(($filter_type != 0 and $filter_type != 1) ? ' filter-off' : null).'" rel-val="2"><i class="icon-screen"></i> '.$filter_feat_array[2].($filter_feat == 2 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-feat'.(($filter_type != 0 and $filter_type != 1) ? ' filter-off' : null).'" rel-val="3"><i class="icon-embed"></i> '.$filter_feat_array[3].($filter_feat == 3 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-feat'.($filter_type != 2 ? ' filter-off' : null).'" rel-val="4"><i class="icon-stop"></i> '.$filter_feat_array[4].($filter_feat == 4 ? ' <i class="icon-check"></i>' : null).'</a></li>
									<li><a href="javascript:;" rel="nofollow" class="filter-feat'.($filter_type != 2 ? ' filter-off' : null).'" rel-val="5"><i class="icon-play"></i> '.$filter_feat_array[5].($filter_feat == 5 ? ' <i class="icon-check"></i>' : null).'</a></li>
								</ul>
								<span id="filter-feat-val" class="no-display" rel="nofollow">'.$filter_feat.'</span>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
                                        <div class="line"></div>
                                </article>
				<div class="clearfix"></div>
				'.self::sectionModuleLoader().'
			';
		return $html;
	}
	/* generate content for each search type */
	private static function sectionModuleLoader() {
//	self::$search_type;
		switch (self::$search_type) {
			case self::$href["videos"]:
			case self::$href["broadcasts"]:
			case self::$href["images"]:
			case self::$href["audios"]:
			case self::$href["documents"]:
			case self::$href["blogs"]:
				$browse		= new VBrowse;
				$files		= new VFiles;
				$display_page	= VBrowse::browseLayout(self::$search_type);
				
				break;

			case self::$href["playlists"]:
				$playlist	= new VPlaylist;
				$files		= new VFiles;
					
				$display_page	= VFiles::listPlaylists();
				$display_page  .= '<input type="hidden" id="ch-pl" class="tab-current" value="1">';
				
				break;

			case self::$href["channels"]:
				$channels	= new VChannels;
				$display_page	= VChannels::doLayout();
				
				break;
		}

		self::$smarty->assign('search_section', self::$search_type);
		
		$html	= '<section id="section-'.self::$search_type.'" class="content-current">'.$display_page.'</section>';
		
		return $html;
	}
	public static function getSearchSection() {
		return self::$search_type;
	}
}
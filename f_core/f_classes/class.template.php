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

//class VTemplate {
class VTemplate {
    /* browse type */
    function browseType(){
        global $class_filter, $href;

        if (isset($_GET["t"]) and !preg_match('/page/', $_GET["t"])) {
            return $class_filter->clr_str($_GET["t"]);
        }
        $request_uri     = $class_filter->clr_str($_SERVER['REQUEST_URI']);

        if(strpos($request_uri, $href["broadcasts"])){
            $p_t         = 'live';
        } elseif(strpos($request_uri, $href["videos"])){
            $p_t         = 'video';
        } elseif(strpos($request_uri, $href["images"])){
            $p_t         = 'image';
        } elseif(strpos($request_uri, $href["audios"])){
            $p_t         = 'audio';
        } elseif(strpos($request_uri, $href["documents"])){
            $p_t         = 'document';
        } elseif(strpos($request_uri, $href["blogs"])){
            $p_t         = 'blog';
        } else {
        	$p_t         = 'video';
        }

        return $p_t;
    }
    /* displaying pages */
    function displayPage($area = '', $section = '', $error_message = '', $notice_message = '') {
	require 'f_core/config.backend.php';
	global $language, $smarty, $cfg;

	$body_layout	 = self::bodyLayout($section);
	$assign_section  = $section != '' ? $smarty->assign('tpl_include', $section) : NULL;
	$assign_error  	 = $error_message == 'tpl_error_max' ? self::maxErrorAssign() : NULL;
	$assign_error  	 = ($error_message != '' and $error_message != 'tpl_error_max') ? $smarty->assign('error_message', VGenerate::noticeTpl('', $error_message, '')) : NULL;
	$assign_notice   = $notice_message != '' ? $smarty->assign('notice_message', VGenerate::noticeTpl('', '', $notice_message)) : NULL;
	$area		 = (self::backendSectionCheck()) ? 'backend' : $area;
	if($cfg["benchmark_display"] == 1){
	    Vbnchmark::start('global_load');
	}

	$smarty->assign('backend_url', $cfg["main_url"].'/'.$backend_access_url);
	$smarty->assign('backend_access_url', $backend_access_url);
	$smarty->assign('global_section', $area);
	$smarty->assign('page_display', $section);
	$smarty->assign('menus', unserialize($cfg["dynamic_menu"]));
	if($section == 'tpl_browse'){
	    $smarty->assign('type_display', self::browseType());
	}
	switch($section){
	    case "tpl_userpage": $extra_title_text = VUserpage::getUID(1); break;
	    default: $extra_title_text = $area == 'backend' ? $language["backend.menu.admin.panel"] : ''; break;
	}
	$smarty->assign('page_title', $extra_title_text.$language[$section.'.title'] . ' - ' . $cfg["head_title"]);

	//$smarty->display('tpl_'.$area.'/tpl_head.tpl');
	$smarty->display('tpl_'.$area.'/tpl_head_min.tpl');
	$smarty->display('tpl_'.$area.'/tpl_body.tpl');

	if($cfg["benchmark_display"] == 1){
	    $load = Vbnchmark::get('global_load');

	    $_SESSION["bm_loadtime"] = $load["time"];
	    $_SESSION["bm_loadmem"]  = $load["memory"];
	}
    }
    /* load body layout based on sections */
    function bodyLayout($section) {
	global $smarty;

	switch($section){
	    case 'tpl_account':
	    case 'tpl_messages':
	    case 'tpl_files':
	    case 'tpl_subs':
//	    case 'tpl_browse':
	    case 'backend_tpl_messages':
	    case 'backend_tpl_members':
	    case 'backend_tpl_settings':
	    case 'backend_tpl_files':
	    case 'backend_tpl_players':
	    case 'backend_tpl_advertising':
		$smarty->assign('layout_type', 'two');
	    break;
	    default:
		$smarty->assign('layout_type', 'one');
	}
    }
    /* check if section is backend */
    function backendSectionCheck() { 
    	global $href;
	require 'f_core/config.backend.php';

	$request_uri = $_SERVER["REQUEST_URI"];
	$query_string = $_SERVER["QUERY_STRING"];
	$section_array = explode('/', trim($request_uri, '/'));

	if (strpos($request_uri, $href["channel"]) or strpos($query_string, $href["channel"]))
		return false;

	return in_array($backend_access_url, $section_array);
    }
    /* trigger invalid request error display */
    function maxErrorAssign() {
	global $language, $smarty;
	$smarty->assign('error_message', VGenerate::noticeTpl('', $language["notif.error.invalid.request"], ''));
	$smarty->assign('tpl_error_max', 1);
    }
    /* display template */
    function displayTemplate($section = '', $template_file = '', $error_message = '', $notice_message = '') {
	global $smarty;

	$assign_error  = $error_message != '' ? $smarty->assign('error_message', $error_message) : NULL;
	$assign_notice = $motice_message != '' ? $smarty->assign('notice_message', $notice_message) : NULL;

	$smarty->display('tpl_'.$section.'/'.$template_file.'.tpl');
    }
}
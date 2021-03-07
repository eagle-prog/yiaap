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

include_once $cfg["class_files_dir"] . '/class_smarty/Smarty.class.php';

$smarty 		= new Smarty;
$smarty->compile_check 	= true;
$smarty->debugging 	= false;
$smarty->template_dir 	= $cfg["templates_dir"];
$smarty->cache_dir 	= $cfg["smarty_cache_dir"];
$smarty->compile_dir 	= $cfg["smarty_cache_dir"];
//$smarty->allow_php_tag  = false;

$smarty->assign('main_dir', $cfg["main_dir"]);
$smarty->assign('main_url', $cfg["main_url"]);
$smarty->assign('scripts_url', $cfg["scripts_url"]);
$smarty->assign('modules_url', $cfg["modules_url"]);
$smarty->assign('modules_url_be', $cfg["modules_url_be"]);
$smarty->assign('styles_url', $cfg["styles_url"]);
$smarty->assign('javascript_dir', $cfg["javascript_dir"]);
$smarty->assign('javascript_url', $cfg["javascript_url"]);
$smarty->assign('styles_url_be', $cfg["styles_url_be"]);
$smarty->assign('javascript_url_be', $cfg["javascript_url_be"]);
$smarty->assign('global_images_url', $cfg["global_images_url"]);
$smarty->assign('media_files_url', $cfg["media_files_url"]);
$smarty->assign('profile_images_url', $cfg["profile_images_url"]);
$smarty->assign('logging_dir', $cfg["logging_dir"]);
//$smarty->assign('theme_name', $cfg["theme_name"]);
$smarty->assign('is_mobile', (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') ? true : (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') ? true : (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') ? true : false))));

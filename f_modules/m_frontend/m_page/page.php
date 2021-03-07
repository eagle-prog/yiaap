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

include_once 'f_core/config.core.php';

include_once $class_language->setLanguageFile('frontend', 'language.global');

$error_message 	   	= NULL;
$notice_message    	= NULL;

switch($_GET["do"]){
    case "contact"://footer contact form
	include_once $class_language->setLanguageFile('frontend', 'language.notifications');

	$email_check 	= new VValidation;
	$name	 	= $class_filter->clr_str($_POST["ft_name"]);
	$email	 	= $class_filter->clr_str($_POST["ft_email"]);
	$msg	 	= $class_filter->clr_str($_POST["ft_msg"]);
	$ip	 	= $class_filter->clr_str($_SERVER["REMOTE_ADDR"]);

	$error_message 	= (!isset($name) or $name == $language["frontend.global.name"]) ? $language["notif.error.invalid.request"] : NULL;
	$error_message 	= (!$email_check->checkEmailAddress($email) and $error_message == '') ? $language["notif.error.invalid.request"] : $error_message;
	$error_message 	= (strlen($msg) < 10 or !isset($msg) or $msg == $language["frontend.global.message.text"]) ? $language["notif.error.invalid.request"] : $error_message;

	if($error_message == ''){
	    $notifier		= new VNotify;

	    VNotify::queInit('contact', array($email), '');

	    $_SESSION["contact"]	 = $ip;

	    echo VGenerate::declareJS('$(document).ready(function(){$(".ft_button").replaceWith("'.$language["footer.contact.thank.note"].'");});');
	} else {
	    echo '<a href="javascript:;" class="ft_err" onclick="$(this).detach();">'.$error_message.'</a>';
	}
    break;
    default://display static pages
	$class_smarty->displayPage('frontend', 'tpl_page', $error_message, $notice_message);
    break;
}
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

$main_dir       = realpath(dirname(__FILE__) . '/../../../');
set_include_path($main_dir);

include_once 'f_core/config.core.php';

include_once $class_language->setLanguageFile('frontend', 'language.global');
include_once $class_language->setLanguageFile('frontend', 'language.account');
include_once $class_language->setLanguageFile('frontend', 'language.email.notif');
include_once $class_language->setLanguageFile('frontend', 'language.notifications');
include_once $class_language->setLanguageFile('frontend', 'language.signup');

$cfg		   	= $class_database->getConfigurations('affiliate_tracking_id,affiliate_view_id,affiliate_maps_api_key,affiliate_token_script,affiliate_payout_share,affiliate_payout_currency,affiliate_payout_units,affiliate_payout_figure,affiliate_module,affiliate_requirements_min,affiliate_requirements_type,paypal_log_file,paypal_logging,paypal_test,paypal_email,paypal_test_email,user_subscriptions,channel_views,affiliate_geo_maps');

$ipn_check		= ($_POST and isset($_GET["do"]) and $_GET["do"] == 'ipn') ? true : false;
$logged_in              = !$ipn_check ? VLogin::checkFrontend(VHref::getKey('affiliate')) : null;
$affiliate_check	= !$ipn_check ? VAffiliate::userCheck() : null;
$membership_check       = (!$ipn_check and $cfg["paid_memberships"] == 1 and (int) $_SESSION["USER_ID"] > 0) ? VLogin::checkSubscription() : NULL;


if ($cfg["affiliate_module"] == 1 and $ipn_check) {//validate ipn
	$p	= new VPaypalAffiliate;
	$p->paypal_url = $cfg["paypal_test"] == 1 ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

	if ($p->validate_ipn()) {
		$ipn_info	= explode('|', urldecode($p->ipn_data["item_number"]));
		$type		= $ipn_info[0];
		$id		= $ipn_info[1];

		switch ($type) {
                	default:
                	case "l": $db_tbl = "live"; break;
			case "v": $db_tbl = "video"; break;
                	case "i": $db_tbl = "image"; break;
                	case "a": $db_tbl = "audio"; break;
                	case "d": $db_tbl = "doc"; break;
                	case "b": $db_tbl = "blog"; break;
        	}

        	$db->execute(sprintf("UPDATE `db_%spayouts` SET `p_paid`='1', `p_paydate`='%s' WHERE `p_id`='%s' LIMIT 1;", $db_tbl, date("Y-m-d H:i:s"), $id));

        	if ($db->Affected_Rows() > 0) {
        		$notifier               = new VNotify;
                        $website_logo           = $smarty->fetch($cfg["templates_dir"].'/tpl_frontend/tpl_header/tpl_headerlogo.tpl');
                        $cfg                    = $class_database->getConfigurations('backend_email,backend_username,affiliate_payout_currency');
                        $i			= $db->execute(sprintf("SELECT
                        						A.`file_key`, A.`p_views`, A.`p_amount_shared`, A.`p_startdate`, A.`p_enddate`,
                        						B.`file_title`,
                        						C.`usr_email`, C.`usr_user`
                        						FROM
                        						`db_%spayouts` A, `db_%sfiles` B, `db_accountuser` C
                        						WHERE
                        						A.`file_key`=B.`file_key` AND
                        						A.`usr_key`=C.`usr_key` AND
                        						C.`usr_id`=B.`usr_id` AND
                        						A.`p_id`='%s'
                        						LIMIT 1;", $db_tbl, $db_tbl, $id));
                        /* user notification */
                        $notifier->msg_subj	= str_replace($cfg["website_shortname"], '', $language["payment.notification.subject.be"]).$cfg["website_shortname"];
                        $_replace               = array(
                            '##TITLE##'         => $language["payment.notification.subject.be"],
                            '##LOGO##'          => $website_logo,
                            '##H2##'            => $language["recovery.forgot.password.h2"].$i->fields["usr_user"].',',
                            '##TITLE##'     	=> $i->fields["file_title"],
                            '##TIMEFRAME##'     => $i->fields["p_startdate"].' - '.$i->fields["p_enddate"],
                            '##VIEWS##'   	=> $i->fields["p_views"],
                            '##AMOUNT##'	=> $i->fields["p_amount_shared"].' '.$cfg["affiliate_payout_currency"],
                            '##YEAR##'          => date('Y')
                        );
                        $notifier->dst_mail     = $i->fields["usr_email"];
                        $notifier->dst_name     = $i->fields["usr_user"];
                        $notifier->Mail('frontend', 'payment_affiliate', $_replace);
                        $_output[]     = $cfg["backend_username"].' -> payment_affiliate -> '.$notifier->dst_mail.' -> '.date("Y-m-d H:i:s");
                        $log_mail		= '.mailer.log';
                        VServer::logToFile($log_mail, implode("\n", $_output));
        	}
	} else die("not valid");
}

if (!isset($_GET["s"]) and !isset($_GET["do"])) {
	$up		= $class_database->singleFieldValue('db_accountuser', 'affiliate_custom', 'usr_id', (int) $_SESSION["USER_ID"]);
	$uperm		= $up != '' ? unserialize($up) : null;

	if (isset($uperm["maps"]))
		$cfg["affiliate_geo_maps"] = $uperm["maps"];

	$smarty->assign('affiliate_geo_maps', $cfg["affiliate_geo_maps"]);
}

$analytics              = false;
if ((isset($_GET["a"]) and $_GET["a"] == md5($_SESSION["USER_KEY"])) or (isset($_GET["g"]) and $_GET["g"] == md5($_SESSION["USER_KEY"])) or (isset($_GET["o"]) and $_GET["o"] == md5($_SESSION["USER_KEY"])) or (isset($_GET["rp"]) and $_GET["rp"] == md5($_SESSION["USER_KEY"]))) {
	if (isset($_GET["g"]) and $_GET["g"] == md5($_SESSION["USER_KEY"]) and $cfg["affiliate_geo_maps"] == 0) {
		header("Location: ".$cfg["main_url"].'/'.VHref::getKey("affiliate"));
		exit;
	}
        $analytics      = true;
        VAffiliate::viewAnalytics();
} else {
	if (!isset($_GET["do"])) {
		VAffiliate::accountStats();
	}
}
if (isset($_GET["do"])) {
        switch ($_GET["do"]) {
                case "autocomplete":
                        $ac = VGenerate::processAutoComplete('account_media');
                break;
                case "clear-affiliate":
                	echo $html = VAffiliate::affiliateRequest();
                break;
                case "clear-affiliate-email":
                	$html = $_POST ? VAffiliate::affiliateRequestEmail() : null;
                break;
                case "save-affiliate":
                	echo $html = $_POST ? VAffiliate::affiliateProfile() : null;
                break;
        }
}

if (!isset($_GET["s"]) and !isset($_GET["do"]))
	$smarty->assign('c_section', VHref::getKey("affiliate"));

$display_page           = (!isset($_GET["s"]) and !isset($_GET["do"])) ? $class_smarty->displayPage('frontend', 'tpl_affiliate', $error_message, $notice_message) : NULL;

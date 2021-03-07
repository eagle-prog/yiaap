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

class VUpload {
    /* update db on upload */
    function dbUpdate($type, $be='', $up_id='', $up_key=''){
	global $class_filter, $class_database, $cfg, $db;

	$type		= $type == 'document' ? 'doc' : $type;
	$db_tbl_info 	= 'db_'.$type.'files';
	$db_tbl_perm 	= 'db_'.$type.'files';
	$db_tbl_que 	= 'db_'.$type.'que';
	$db_approved	= ($cfg["file_approval"] == 1 ? 0 : 1);
	if ($up_key == '') {
		$up_key = $class_database->singleFieldValue('db_accountuser', 'usr_key', 'usr_id', ((int) $up_id > 0 ? $up_id : $_SESSION["USER_ID"]));
	}
	$usr_id         = $be == '' ? $up_id : $class_database->singleFieldValue('db_accountuser', 'usr_id', 'usr_key', $up_key);

	$filesrc        = (preg_match('/"/', $_POST["UFNAME"]) or preg_match('/`/', $_POST["UFNAME"])) ? str_replace(array('"', '`'), array("'", "'"), $_POST["UFNAME"]) : $_POST["UFNAME"];
	$filename       = $class_filter->clr_str($filesrc);
	$nfilename      = $class_filter->clr_str($_POST["UFSIZE"] . '.' . strtolower(pathinfo($filesrc, PATHINFO_EXTENSION)));
	$ufilename	= time().'.'.strtolower(pathinfo($filesrc, PATHINFO_EXTENSION));
        $filesize       = intval($_POST["UFSIZE"]);
        $filecateg      = $be == '' ? intval($_POST["file_category_sel"]) : intval($_POST["file_category_0"]);

        $filepath       = $cfg["upload_files_dir"].'/'.$up_key.'/'.$type[0].'/'.html_entity_decode($nfilename, ENT_QUOTES, 'UTF-8');
        $ufilepath      = $cfg["upload_files_dir"].'/'.$up_key.'/'.$type[0].'/'.html_entity_decode($ufilename, ENT_QUOTES, 'UTF-8');

        if (strpos($filename, '.php') !== false or strpos($filename, '.pl') !== false or strpos($filename, '.asp') !== false or strpos($filename, '.htm') !== false or strpos($filename, '.cgi') !== false or strpos($filename, '.py') !== false or strpos($filename, '.sh') !== false or strpos($filename, '.cin') !== false) { return; }
        if (strpos($nfilename, '.php') !== false or strpos($nfilename, '.pl') !== false or strpos($nfilename, '.asp') !== false or strpos($nfilename, '.htm') !== false or strpos($nfilename, '.cgi') !== false or strpos($nfilename, '.py') !== false or strpos($nfilename, '.sh') !== false or strpos($nfilename, '.cin') !== false) { return; }

        if (!file_exists($filepath) or filesize($filepath) <= 16) {
                error_log('{"jsonrpc php" : "2.0", "error" : {"code": 108, "message": "Connection failure when uploading. Please check your connection and again."}, "id" : "id"}');
                return '';
        } elseif (file_exists($filepath) and filesize($filepath) >= 16) {
        	if(rename($filepath, $ufilepath)) {
        		$filepath = $ufilepath;
        		$nfilename = $ufilename;
        	}
        }

	$filetitle	= substr($filename, 0, strrpos($filename,'.'));
	$filetitle	= str_replace("%20", " ", $filetitle);

	$fileext	= VFileinfo::getEXtension($filename);
	$filekey	= VUserinfo::generateRandomString(10);
	$embedkey       = VUserinfo::generateRandomString(10);

	if (strtolower($filename) === 'image.jpg') {
		$new_filename	= 'image_'.time().'.jpg';
		$src	= $cfg["upload_files_dir"].'/'.$up_key.'/i/'.$filename;
		$dst	= $cfg["upload_files_dir"].'/'.$up_key.'/i/'.$new_filename;
		
		if (rename($src, $dst)) {
			$nfilename = $new_filename;
		}
	}

	$v_info		= array(
				"usr_id"	=> $usr_id,
				"file_key"	=> $filekey,
				"old_file_key"	=> 0,
				"file_type"	=> $fileext,
				"file_name"	=> str_replace(strtoupper($fileext), strtolower($fileext), $nfilename),
				"file_size"	=> $filesize,
				"upload_date"	=> date("Y-m-d H:i:s"),
				"is_subscription" => ($be == '' ? intval($cfg["paid_memberships"]) : 0), 
				"file_views"	=> 0,
				"file_comments"	=> 0,
				"file_responses"=> 0,
				"file_like"	=> 0,
				"file_dislike"	=> 0,
				"embed_key"     => $embedkey,
				"file_title" 	=> $filetitle, 
				"file_description" => $filetitle, 
				"file_tags" 	=> VForm::clearTag($filetitle), 
				"file_category" => $filecateg,
				"approved"	=> $db_approved,
				"privacy"	=> "public",
				"comments"	=> "all",
				"comment_votes"	=> 1,
				"rating"	=> 1,
				"responding"	=> "all",
				"embedding"	=> 1,
				"social"	=> 1
			);

	if($cfg["conversion_".($type == 'doc' ? 'document' : $type)."_que"] == 1){
	    $v_que	= array(
				"file_key"	=> $filekey,
				"usr_key"	=> $up_key
			);
	}

	if($cfg["paid_memberships"] == 1 and $be == ''){
	    $sql	= sprintf("UPDATE `db_packusers` SET `pk_usedspace`=`pk_usedspace`+%s, `pk_usedbw`=`pk_usedbw`+%s, `pk_total_%s`=`pk_total_%s`+1 WHERE `usr_id`='%s' LIMIT 1;", $filesize, $filesize, $type, $type, $usr_id);
	    $db_dub	= $db->execute($sql);
	}

	$do_db			= $class_database->doInsert($db_tbl_info, $v_info);

	if($cfg["conversion_".($type == 'doc' ? 'document' : $type)."_que"] == 1){
	    $class_database->doInsert($db_tbl_que, $v_que);
	    $db->execute(sprintf("UPDATE `%s` SET `approved`='0' WHERE `file_key`='%s' LIMIT 1;", $db_tbl_perm, $filekey));
	}

	if($db->Affected_Rows() > 0){
	    /* file count */
	    $ct_update		= $db->execute(sprintf("UPDATE `db_accountuser` SET `usr_%s_count`=`usr_%s_count`+1 WHERE `usr_id`='%s' LIMIT 1;", $type[0], $type[0], $usr_id));
	    /* responses */
	    if($_GET["r"] != ''){
		$r_key		= $class_filter->clr_str($_GET["r"]);
		if(strlen($r_key) == 10){
		    $db_resp	= VResponses::submitResponse(1, $filekey);
		}
	    }
	    $success		= $filekey;
	} else $success		= NULL;
	$log                 	= ($cfg["activity_logging"] == 1 and $action = new VActivity($usr_id)) ? $action->addTo('log_upload', $type.':'.$filekey) : NULL;

	return $success;
    }
    /* conversion process init */
    function initConversion($db_id, $conversion_type, $be=''){
	$function	 = 'do'.ucfirst($conversion_type).'Conversion';

	$start		 = $db_id != '' ? self::$function($db_id, $be) : NULL;
    }
    /* start video conversion */
    function doVideoConversion($db_id, $be=''){
	global $class_database, $cfg, $db, $class_filter;

	if($be == '' and ($_SESSION["USER_KEY"] == '' or strlen($db_id) != 10)) return false;

	$cfg[]	 	 = $class_database->getConfigurations('server_path_php');
	$user_key	 = $be == '' ? $class_filter->clr_str($_SESSION["USER_KEY"]) : $_SESSION["file_owner"];
	$cmd 	 	 = $cfg["server_path_php"].' '.$cfg["main_dir"].'/f_modules/m_frontend/m_file/convert_video.php '.$db_id.' '.$user_key.' '.$be;

	exec(escapeshellcmd($cmd). ' >/dev/null &');
    }
    /* start image conversion */
    function doImageConversion($db_id, $be=''){
        global $class_database, $cfg, $db, $class_filter;
        
        if($be == '' and ($_SESSION["USER_KEY"] == '' or strlen($db_id) != 10)) return false;
            
        $cfg[]           = $class_database->getConfigurations('server_path_php');
        $user_key        = $be == '' ? $class_filter->clr_str($_SESSION["USER_KEY"]) : $_SESSION["file_owner"];
        $cmd             = $cfg["server_path_php"].' '.$cfg["main_dir"].'/f_modules/m_frontend/m_file/convert_image.php '.$db_id.' '.$user_key.' '.$be;

        exec(escapeshellcmd($cmd). ' >/dev/null &');
    }
    /* start audio conversion */
    function doAudioConversion($db_id, $be=''){
        global $class_database, $cfg, $db, $class_filter;

        if($be == '' and ($_SESSION["USER_KEY"] == '' or strlen($db_id) != 10)) return false;

        $cfg[]           = $class_database->getConfigurations('server_path_php');
        $user_key        = $be == '' ? $class_filter->clr_str($_SESSION["USER_KEY"]) : $_SESSION["file_owner"];
        $cmd             = $cfg["server_path_php"].' '.$cfg["main_dir"].'/f_modules/m_frontend/m_file/convert_audio.php '.$db_id.' '.$user_key.' '.$be;

        exec(escapeshellcmd($cmd). ' >/dev/null &');
    }
    /* start document conversion */
    function doDocConversion($db_id, $be=''){
        global $class_database, $cfg, $db, $class_filter;

        if($be == '' and ($_SESSION["USER_KEY"] == '' or strlen($db_id) != 10)) return false;

        $cfg[]           = $class_database->getConfigurations('server_path_php');
        $user_key        = $be == '' ? $class_filter->clr_str($_SESSION["USER_KEY"]) : $_SESSION["file_owner"];
        $cmd             = $cfg["server_path_php"].' '.$cfg["main_dir"].'/f_modules/m_frontend/m_file/convert_doc.php '.$db_id.' '.$user_key.' '.$be;

        exec(escapeshellcmd($cmd). ' >/dev/null &');
    }
    /* notifying subscribers and admin of new uploads */
    function notifySubscribers($usr_id, $type, $filekey, $be_mail='', $be=''){
	global $db, $class_database, $language, $cfg;

	$cfg[]			= $class_database->getConfigurations('backend_notification_upload,backend_email');
	$main_be	 	= ($cfg["backend_notification_upload"] == 1 and $be_mail == '') ? VNotify::queInit('new_upload_be', array($cfg["backend_email"]), $type[0].$filekey, ($be != '' ? $class_database->singleFieldValue('db_accountuser', 'usr_user', 'usr_key', $be) : NULL)) : NULL;

	if($usr_id == 0) return false;

	$usr_array		= array();
	$sub_ids		= array();
	if ($cfg["user_subscriptions"] == 1) {
		$subs			= $class_database->singleFieldValue('db_subscribers', 'subscriber_id', 'usr_id', $usr_id);
		$subs_array		= $subs != '' ? unserialize($subs) : NULL;

		if($subs != ''){
		    foreach($subs_array as $key => $val){
			if($val["mail_new_uploads"] == 1){
			    $usr_array[] = VUserinfo::getUserEmail($val["sub_id"]);
			    $sub_ids[] = $val["sub_id"];
			}
		    }
		}
	}

	if ($cfg["user_follows"] == 1) {
		$subs			= $class_database->singleFieldValue('db_followers', 'follower_id', 'usr_id', $usr_id);
		$subs_array		= $subs != '' ? unserialize($subs) : NULL;

		if($subs != ''){
		    foreach($subs_array as $key => $val){
			if($val["mail_new_uploads"] == 1 and !in_array($val["sub_id"], $sub_ids)){
			    $usr_array[] = VUserinfo::getUserEmail($val["sub_id"]);
			}
		    }
		}
	}

	if(isset($usr_array[0])){
	    $mail_do     = VNotify::queInit('new_upload', $usr_array, $type[0].$filekey, VUserinfo::getUserName($usr_id));
	}
    }
    /* check subscription limits */
    function subscriptionLimit($type){
	global $db, $class_filter;

	$uid		 = intval($_SESSION["USER_ID"]);
	$t		 = $type == 'document' ? 'doc' : $type;
	$res		 = $db->execute(sprintf("SELECT A.`pk_total_%s`, B.`pk_%slimit` FROM `db_packusers` A, `db_packtypes` B WHERE A.`pk_id`=B.`pk_id` AND A.`usr_id`='%s' LIMIT 1;", $t, $t[0], $uid));

	if($res->fields["pk_".$t[0]."limit"] > 0 and $res->fields["pk_total_".$t] >= $res->fields["pk_".$t[0]."limit"])
	    return true;
	else return false;
    }
    /* check subscription limits */
    public static function subscriptionCheck($m, $q=''){
	global $db, $smarty, $language;

	$m		 = $m != 'document' ? $m : 'doc';
	$arr	 	 = array();
	$sql		 = sprintf("SELECT A.`pk_usedspace`, A.`pk_usedbw`, A.`pk_total_%s`, B.`pk_space`, B.`pk_bw`, B.`pk_%slimit` FROM `db_packusers` A, `db_packtypes` B WHERE A.`usr_id`='%s' AND A.`pk_id`=B.`pk_id`;", $m, $m[0], intval($_SESSION["USER_ID"]));
	$rs	 	 = $db->execute($sql);

	$pk_usedspace 	 = $rs->fields["pk_usedspace"]/(1024*1024);
	$pk_usedbw	 = $rs->fields["pk_usedbw"]/(1024*1024);
	$pk_filenr	 = $rs->fields["pk_total_".$m];

	$pk_space	 = $rs->fields["pk_space"];
	$pk_bw		 = $rs->fields["pk_bw"];
	$pk_limit	 = $rs->fields["pk_".$m[0]."limit"];

	$err1		 = str_replace('##TYPE##', $language["frontend.global.".$m[0]], $language["upload.err.msg.9"]).' '.$pk_limit.' '.$language["upload.err.msg.12"];
	$err2		 = $language["upload.err.msg.10"];
	$err3		 = $language["upload.err.msg.11"];

	$error_message	 = ($pk_limit > 0 and $pk_filenr >= $pk_limit) ? $err1 : (($pk_space > 0 and $pk_usedspace >= $pk_space) ? $err3 : (($pk_bw > 0 and $pk_usedbw >= $pk_bw) ? $err2 : NULL));

	if($q == ''){
	    $smarty->assign('error_message', $error_message);
	    if ($error_message != '') {
	    	return $error_message;
	    }
	} else {
	    if($error_message != ''){
		$js      = 'var uploader = $("#uploader").pluploadQueue(); uploader.splice(); $(".plupload_buttons").detach(); $(".plupload_wrapper.plupload_scroll").next().detach(); $(".plupload_droptext").html("'.$error_message.'");';

		echo VGenerate::declareJS($js);
	    }
	}
    }
    /* upload cfg */
    function initCFG($be=''){
	global $cfg, $smarty, $class_filter, $class_database, $db, $language;

	$get_type	    = $class_filter->clr_str($_GET["t"]);

	$sub_check	    = ($be == '' and $cfg["paid_memberships"] == 1) ? self::subscriptionCheck($get_type) : NULL;
        $types              = array();
        $allowed_types      = explode(",", $cfg[($get_type == 'doc' ? 'document' : $get_type)."_file_types"]);

	foreach($allowed_types as $key => $val){
    	    $types[$key]    = $val;
	}
	$types_js           =  '('.implode(", ", $types).')';
	$types_cfg          =  implode(",", $types);

	if($be == 1){
	    $chk	    = $db->execute("SELECT `usr_key`, `usr_user` FROM `db_accountuser` WHERE `usr_status`='1' ORDER BY `usr_user` LIMIT 1;");
	    $smarty->assign('user_list', VbeSettings::username_selectList());
	    $err	    = $chk->fields["usr_key"] == '' ? $smarty->assign("error_message", $language["upload.err.msg.13"]) : NULL;
	}

	$smarty->assign("allowed_file_types", $types_js);
	$smarty->assign("allowed_file_cfg", $types_cfg);
	$smarty->assign("file_limit", $cfg[($get_type == 'doc' ? 'document' : $get_type)."_limit"]);
	$smarty->assign("file_category", VFiles::fileCategorySelect('upload'));
	$smarty->assign("upload_session", session_id());

	if($be == '' and $cfg["paid_memberships"] == 1){
	    $sql             = sprintf("SELECT A.`pk_id`, A.`pk_usedspace`, A.`pk_usedbw`, A.`pk_total_%s`, 
                                            B.`pk_space`, B.`pk_bw`, B.`pk_%slimit` 
                                            FROM `db_packusers` A, `db_packtypes` B WHERE A.`usr_id`='%s' AND A.`pk_id`=B.`pk_id` AND B.`pk_active`='1';", ($get_type == 'document' ? 'doc' : $get_type), $get_type[0], intval($_SESSION["USER_ID"]));
            $rs		= $db->execute($sql);
	    $pk_space   = $rs->fields["pk_space"];
            $pk_space_u = $rs->fields["pk_usedspace"];
            $pk_bw      = $rs->fields["pk_bw"];
            $pk_bw_u    = $rs->fields["pk_usedbw"];

            $units      = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $sp_power   = $pk_space_u > 0 ? floor(log($pk_space_u, 1024)) : 3;
            $bw_power   = $pk_bw_u > 0 ? floor(log($pk_bw_u, 1024)) : 3;

	    $s		= 1024;
            if($sp_power == 2){
                $s      = (1024 * 1024);
            } elseif($sp_power == 3){
                $s      = (1024 * 1024 * 1024);
            }
            $b		= 1024;
            if($bw_power == 2){
                $b      = (1024 * 1024);
            } elseif($bw_power == 3){
                $b      = (1024 * 1024 * 1024);
            }

            $_fsp       = ($pk_space - round($pk_space_u/$s));
            $_fbw       = ($pk_bw - round($pk_bw_u/$b));

	    $smarty->assign("subscription_limit", $rs->fields["pk_".$get_type[0]."limit"]);
	    $smarty->assign("subscription_used", $rs->fields["pk_total_".($get_type == 'document' ? 'doc' : $get_type)]);
	    $smarty->assign("subscription_bw", $_fbw);
	    $smarty->assign("subscription_space", $_fsp);
	    $smarty->assign("the_stats", VUseraccount::subscriptionStats());
	}
    }
    /* more checks */
    function checkRdr($section){
	global $cfg;

	$sect_arr	 = array("video", "image", "audio", "document");
	if($section != '') unset($sect_arr[$section]);

	foreach($sect_arr as $key => $val){
	    if($cfg[$val."_module"] == 1 and $cfg[$val."_uploads"] == 1) return '?t='.$val;
	}
    }
    /* checking allowed functions */
    function checkSection($section){
	global $cfg;

 	$rd_to	 	= self::checkRdr($section);
	$hd_to		= $rd_to != '' ? $cfg["main_url"]."/".VHref::getKey("upload").$rd_to : $cfg["main_url"]."/".VHref::getKey("account");

	header("Location: ".$hd_to); exit;
    }
    /* type init */
    function typeInit(){
	global $cfg, $class_filter;

	$sect_arr	 = array("video", "image", "audio", "document");
	if($section != '') unset($sect_arr[$section]);

	foreach($sect_arr as $key => $val){
	    if($cfg[$val."_module"] == 1 and $cfg[$val."_uploads"] == 1) return $val;
	}
    }
    /* checking for verified email */
    function verifiedEmailCheck(){
	global $db, $language, $smarty;

	$usr_id	  = intval($_SESSION["USER_ID"]);
	$res	  = $db->execute(sprintf("SELECT `usr_email`, `usr_verified` FROM `db_accountuser` WHERE `usr_id`='%s' LIMIT 1;", $usr_id));
	$usr_ver  = $res->fields["usr_verified"];
	$usr_mail = $res->fields["usr_email"];

	if($usr_ver == 0){
	    $smarty->assign('usr_verified', $usr_ver);
	    $smarty->assign('usr_mail', $usr_mail);
	    $smarty->assign('c_rand', rand(1,9999));
	}
    }
    /* process sending verification email */
    function processVerify(){
	global $cfg, $language, $class_filter;

	$user_email	 = $class_filter->clr_str($_POST["verify_email"]);
	$error_message 	 = $_POST["verification_captcha"] != $_SESSION["signin_captcha"] ? $language["upload.err.msg.8"] : NULL;
	$notice_message	 = $error_message == '' ? $language["notif.success.request"] : NULL;
echo	$notice_js	 = $error_message == '' ? VGenerate::declareJS('$("#c-image").attr("src", "'.$cfg["main_url"].'/'.VHref::getKey("captcha").'?t='.rand(1,9999).'"); $("#verification-captcha").val("");') : NULL;
	$notification	 = $error_message == '' ? VNotify::queInit('account_email_verification', array($user_email), '') : NULL;

	echo  VGenerate::noticeTpl(' no-top-padding', $error_message, $notice_message);
    }
}
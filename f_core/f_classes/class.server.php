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

class VServer {
	/* curl get */
	public static function curl_tt($url){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}
	/* get free server */
	public static function getFreeServer($type='stream') {
		global $db;

		switch ($type) {
			case "bcast":
				$t	= 'lbb';
				$tt	= 'cast';
				$c	= 'freebcastserver';
				$adr	= 'rtmp://##HOST##/live';
				break;

			case "stream":
				$t	= 'lbs';
				$tt	= 'stream';
				$c	= 'freeserver';
				$adr	= '##PROTOCOL##://##HOST##:##PORT##';
				break;

			case "chat":
				$t	= 'lbc';
				$tt	= 'chat';
				$c	= 'freeserver';
				$adr	= '##PROTOCOL##://##HOST##:##PORT##';
				break;
		}

		$sql	= sprintf("SELECT `srv_id`, `srv_host`, `srv_port`, `srv_https` FROM `db_liveservers` WHERE `srv_type`='%s' AND `srv_active`='1' ORDER BY RAND() LIMIT 1;", $t);
		$rs	= $db->execute($sql);

		if ($rs->fields["srv_id"]) {//load balancer found, get most free server
			$srv_host	= $rs->fields["srv_host"];
			$srv_port	= $rs->fields["srv_port"];
			$srv_https	= $rs->fields["srv_https"];

			$lb_srv		= sprintf("%s://%s:%s/%s", ($srv_https ? 'https' : 'http'), $srv_host, $srv_port, $c);
			$vs		= json_decode(VServer::curl_tt($lb_srv));

			if (isset($vs->ip)) {
				$server		= str_replace(array('##PROTOCOL##', '##HOST##', '##PORT##'), array($vs->protocol, $vs->ip, $vs->port), $adr);
			}
		} else {//without load balancer, get a random server
			$sql	= sprintf("SELECT `srv_id`, `srv_host`, `srv_port`, `srv_https` FROM `db_liveservers` WHERE `srv_type`='%s' AND `srv_active`='1' ORDER BY RAND() LIMIT 1;", $tt);
			$rs	= $db->execute($sql);

			if ($rs->fields["srv_id"]) {
				$srv_host	= $rs->fields["srv_host"];
				$srv_port	= $rs->fields["srv_port"];
				$srv_https	= $rs->fields["srv_https"] == 1 ? 'https' : 'http';

				$server		= str_replace(array('##PROTOCOL##', '##HOST##', '##PORT##'), array($srv_https, $srv_host, $srv_port), $adr);
			} else
				$server		= $adr;
		}

		return $server;
	}
    /* memory */
    function get_memory(){
	foreach(file('/proc/meminfo') as $ri)
	    $m[strtok($ri, ':')] = strtok('');

	$i	 = '<div class="left-float">Memory usage: </div>';
	$i	.= '<div class="left-float left-padding10">';
	$i	.= 'MemTotal: '.$m['MemTotal']."<br />";
	$i	.= 'MemFree: '.$m['MemFree']."<br />";
	$i	.= 'Buffers: '.$m['Buffers']."<br />";
	$i	.= 'Cached: '.$m['Cached'];
	$i	.= '</div>';

	return $i;
    }
    /* remote IP */
    function get_remote_ip() {
    	return self::get_ip();
    	include_once 'class_ipify/autoload.php';
    	return Ipify\Ip::get();
    }
    /* remote IP */
    function get_ip() {
    	global $class_filter;
    	if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) )
    		$ip = $_SERVER['HTTP_CLIENT_IP'];
    	elseif( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
    		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    	else
    		$ip = $_SERVER['REMOTE_ADDR'];

    	return $class_filter->clr_str($ip);
    }
    function get_ip_old() {
	global $class_filter;
	return $class_filter->clr_str($_SERVER['SERVER_ADDR']);
    }
    /* log file */
    function logToFile($path, $str) {
	global $cfg;

	$wm 		 = 'w';
	switch($path){
	    case ".mailer.log":
		$ddir	 = 'log_mail/'.date("Y.m.d").'/';
	    break;
	    default:
		$ddir	 = NULL;
	    break;
	}
	$full_path	 = $cfg["logging_dir"].'/'.$ddir.$path;
	$file_dir 	 = dirname($full_path);

	if(!file_exists($full_path)) @touch($full_path);

	if($ddir != '' and !is_dir($cfg["logging_dir"].'/'.$ddir)) @mkdir($cfg["logging_dir"].'/'.$ddir);
	if(!is_dir($file_dir) or !is_writable($file_dir)) return false;

	if(is_file($full_path) && is_writable($full_path)) $wm = 'a';

	if(!$handle = fopen($full_path, $wm)) return false;

	if(fwrite($handle, $str. "\n") === FALSE) return false;

	@fclose($handle);
    }
    /* background process */
    function bgProcess($cmd){
	exec($cmd.'>/dev/null &');
    }
}

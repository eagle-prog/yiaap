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

class VResponses {
	public static $type;
	public static $file_key;
	private static $cfg;
	private static $db;
	private static $db_cache;
	private static $dbc;
	private static $filter;
	private static $language;

	public function __construct($_type = false) {
		require 'f_core/config.href.php';

		global $cfg, $class_filter, $class_database, $db, $language;

		self::$filter	= $class_filter;
		
		$_type		= !$_type ? self::responseType() : $_type;
		self::$type	= $_type == 'document' ? 'doc' : $_type;
		self::$cfg	= $cfg;
		self::$db	= $db;
		self::$dbc	= $class_database;
		self::$language = $language;
		self::$file_key	= !isset($_GET["r"]) ? self::$filter->clr_str($_GET[$_type[0]]) : self::$filter->clr_str($_GET["r"]);

		self::$db_cache = false; //change here to enable caching
	}
	
	/* get response type */
	public static function responseType() {
		if (isset($_GET["t"])) {
			return self::$filter->clr_str($_GET["t"]);
		}
		return (isset($_GET["l"]) ? 'live' : (isset($_GET["v"]) ? 'video' : (isset($_GET["i"]) ? 'image' : (isset($_GET["a"]) ? 'audio' : (isset($_GET["d"]) ? 'doc' : (isset($_GET["b"]) ? 'blog' : null))))));
	}

	/* response page layout */
	public function responseLayout() {
		$cfg		= self::$cfg;
		$db		= self::$db;
		$class_filter	= self::$filter;
		$language	= self::$language;
		$type		= self::$type;
		$f_key		= self::$file_key;

		$sql = sprintf("SELECT 
				A.`usr_key`, A.`usr_id`, B.`file_responses`, B.`file_title`, B.`responding` 
				FROM 
				`db_accountuser` A, `db_%sfiles` B
				WHERE 
				A.`usr_id`=B.`usr_id` AND 
				B.`file_key`='%s' AND 
				A.`usr_id`=B.`usr_id` LIMIT 1;", $type,  $f_key);
		
		$res		= $db->execute($sql);
		$perm		= $res->fields["responding"];
		$vuid		= $res->fields["usr_id"];
		/* check blocking */
		$f_is		= VContacts::getFriendStatus($vuid); //am I friend
		$bl_stat	= VContacts::getBlockStatus($vuid, $_SESSION["USER_NAME"]); //am I blocked
		$bl_opt		= VContacts::getBlockCfg('bl_comments', $vuid, $_SESSION["USER_NAME"]); //is commenting/responding access blocked
		/* error out if needed */
		$err_msg	= ((int)$_SESSION["USER_ID"] != $vuid and $bl_stat == 1 and $bl_opt == 1) ? $language["notif.error.blocked.request"] : ((($cfg["file_responses"] == 1 and $perm == 'none') or $cfg["file_responses"] == 0) ? $language["notif.error.invalid.request"] : ($res->fields["usr_key"] == '' ? $language["notif.error.invalid.request"] : NULL));
		
		if ($err_msg != '') {
			return VGenerate::noticeTpl('', $err_msg, '');
		}

		$usr_key	= $res->fields["usr_key"];
		$f_url		= $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $f_key, '');
		$m		= $vuid == (int)$_SESSION["USER_ID"] ? 0 : self::countInactiveResponses($type, $f_key);

		$ht_js		 = '$(".submit-response").click(function(){';
		$ht_js		.= 'var t = $(this); var m_loading = "";var c_url = "' . $cfg["main_url"] . '/' . VHref::getKey("respond") . '?' . $type[0] . '=' . $f_key . '";$("#response-list").mask(m_loading); t.find("i").removeClass("iconBe-floppy-disk").addClass("spinner icon-spinner");';
		$ht_js		.= '$.post(c_url+"&do=submit-response", $("#submit-response-form").serialize(), function(data){';
		$ht_js		.= '$("#submit-ajax-response").html(data);';
		$ht_js		.= '$("#response-list").unmask(); t.find("i").addClass("iconBe-floppy-disk").removeClass("spinner icon-spinner"); $(".response-entry.selected").detach();';
		$ht_js		.= '});';
		$ht_js		.= '});';
		if ($type[0] == 'b') {
			$ht_js	.= '$(".upload-response").click(function(){
				url = current_url + "'.VHref::getKey("files").'" + "?do=new-blog&t=blog&r='.$f_key.'";
				$.fancybox({type: "ajax", margin: 10, minWidth: "80%", href: url, height: "auto", autoHeight: "true", autoResize: "true", autoCenter: "true", afterClose: function(){$(".mce-container, .mce-tinymce-inline, .mce-tooltip").detach()}});
			});
			jQuery(document).on({
                click: function () {
                        url = current_url + "'.VHref::getKey("files").'" + "?do=new-blog&t=blog&r='.$f_key.'";
     
                        $(".lb-margins").mask(" ");
                        $.post(url, $("#add-new-blog-form").serialize(), function(data) {
                                $("#add-new-blog-response").html(data);
                                $(".lb-margins").unmask();
                        });
                }
        }, "#add-new-blog-btn");

			';
		} else {
			$ht_js	.= '$(".upload-response").click(function(){location.href="' . $cfg["main_url"] . '/' . VHref::getKey("upload") . '?t=' . ($type != 'doc' ? $type : 'document') . '&r=' . $f_key . '";});';
		}
		$ht_js		.= '
					$(".icheck-box input").each(function () {
						var self = $(this);
						self.iCheck({
							checkboxClass: "icheckbox_square-blue",
							radioClass: "iradio_square-blue",
							increaseArea: "20%"
						//insert: "<div class=\"icheck_line-icon\"></div><label>" + label_text + "</label>"
						});
					});
					
					$(".response-entry").click(function() {
						$(".response-entry").removeClass("selected");
						var t = $(this);
						t.find("input").iCheck("check", function(){ t.addClass("selected"); });
					});
			';
		
		$f_title	= $res->fields["file_title"];
		
		$thumb1		= VGenerate::thumbSigned($type, $f_key, $usr_key, 0, 1, 1);
		$thumb2		= $type[0] == 'v' ? VGenerate::thumbSigned($type, $f_key, $usr_key, 0, 1, 2) : $thumb1;
		$thumb3		= $type[0] == 'v' ? VGenerate::thumbSigned($type, $f_key, $usr_key, 0, 1, 3) : $thumb1;
		
		$rhtml		= '
				<div class="page_holder">
					<article>
						<h3 class="content-title">' . $language["respond.text.to"] . $f_title . ' <span class="responses-info">' . ($res->fields["file_responses"] - $m) . $language["respond.text.sofar"] . '</span></h2>
						<div class="line"></div>
					</article>
					' . VGenerate::advHTML(35) . '
					<div class="video_player_holder_comments">
						<div class="vs-column thirds"><a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $f_key, $f_title) . '" rel="nofollow"><img alt="' . $f_title . '" src="' . $thumb1 . '" width="33%"></a></div>
						<div class="vs-column thirds sm-thumb"><a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $f_key, $f_title) . '" rel="nofollow"><img alt="' . $f_title . '" src="' . $thumb2 . '" width="33%"></a></div>
						<div class="vs-column thirds sm-thumb fit"><a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $f_key, $f_title) . '" rel="nofollow"><img alt="' . $f_title . '" src="' . $thumb3 . '" width="33%"></a></div>
						<div class="clearfix"></div>
					</div>
					' . VGenerate::advHTML(36) . '
					<div class="tabs tabs-style-topline">
						<nav>
							<ul>
								<li><a href="#section-select" class="icon icon-checkmark-circle" rel="nofollow"><span>'.$language["frontend.global.select"] . ' ' . $language["frontend.global." . $type[0]].'</span></a></li>
								<li><a href="#section-upload" class="icon '.($type[0] != 'b' ? 'icon-upload' : 'icon-pencil2').'" rel="nofollow"><span>'.($type[0] != 'b' ? $language["frontend.global.upload"] . ' ' . $language["frontend.global." . $type[0]] : $language["respond.text.new.blog"]).'</span></a></li>
							</ul>
						</nav>
						<div class="content-wrap">
							<section id="section-select">
								<article>
									<div>
										<h3 class="video-content-title with-lines"><i class="icon-checkmark-circle"></i>'.($type[0] != 'b' ? $language["respond.text.choose"] : $language["respond.text.choose.b"]).'</h3>
										'.VGenerate::simpleDivWrap('left-float wd320 paging-bg1 top-padding15', 'response-select', self::responseSelect($type, $f_key)).'
									</div>
								</article>
							</section>
							<section id="section-upload">
								<article>
									<div>
										<h3 class="video-content-title with-lines"><i class="'.($type[0] != 'b' ? 'icon-upload' : 'icon-pencil2').'"></i>'.($type[0] != 'b' ? str_replace('##TYPE##', $language["frontend.global." . $type[0]], $language["respond.text.upload"]) : $language["respond.text.start.blog"]).'</h3>
										<p class="inform">'.str_replace('##TYPE##', $language["frontend.global." . $type[0]], ($type[0] != 'b' ? $language["respond.text.start.txt"] : $language["respond.text.start.txt.b"])).'</p>
										<button name="save_response" id="btn-1-save_response" class="upload-response symbol-button" type="button" value="1"><i class="'.($type[0] != 'b' ? 'icon-upload' : 'icon-pencil2').'"></i> '.$language["respond.text.start"].'</button>
									</div>
								</article>
							</section>
						</div>
						' . VGenerate::simpleDivWrap('', '', VGenerate::advHTML(26)) . '
					</div>
				</div>
		';

		$html		 = VGenerate::declareJS('var c_url = "on";');
		$html		.= VGenerate::simpleDivWrap('', '', VGenerate::advHTML(27));
		$html		.= VGenerate::simpleDivWrap('', '', $rhtml);
		

		$html		.= VGenerate::declareJS('$(document).ready(function(){' . $ht_js . '});');

		return $html;
	}
	
	/* file response select */
	function responseSelect($type, $f_key) {
		$db		= self::$db;
		$language	= self::$language;

		$sql		= sprintf("SELECT 
					A.`file_title`, A.`file_key` 
					FROM 
					`db_%sfiles` A
					WHERE A.`usr_id`='%s' 
					AND A.`file_key`!='%s' 
					AND A.`privacy`!='personal' 
					AND A.`approved`='1' 
					AND A.`deleted`='0' 
					AND A.`active`='1'
					ORDER BY A.`file_title`;", $type, (int)$_SESSION["USER_ID"], $f_key);
		
		$res		= self::$db_cache ? $db->execute($cfg['cache_respond_file_list'], $sql) : $db->execute($sql);
		
		if ($res) {
			while (!$res->EOF) {
				$r_key	= $res->fields["file_key"];
				$chk	= self::isOtherResponse($type, $f_key, $r_key) ? '<span class="is-used">(u)</span>' : NULL;
				
				if (!self::isResponse($type, $f_key, $r_key)) {
					$opt.= VGenerate::simpleDivWrap('response-entry', '', '<input type="radio" name="response_key" class="" value="' . $r_key . '"><label>' . $res->fields["file_title"] . ' ' . $chk . '</label>');
				}

				@$res->MoveNext();
			}
		} else {
			$opt	 = 'none';
		}
		$file_select = $opt;

		$html = '<form id="submit-response-form" method="post" action="">';
		$html.= '<div id="submit-ajax-response"></div>';
		$html.= '<p class="inform">'.str_replace('##TYPE##', $language["frontend.global." . $type[0]], $language["respond.text.select"]).'</p>';
		$html.= VGenerate::simpleDivWrap('all-paddings10', '', VGenerate::simpleDivWrap('icheck-box', 'response-list', $file_select, 'overflow: auto;'));
		$html.= '<p class="inform indicate">'.$language["respond.text.indicates"].'</p>';
		$html.= VGenerate::simpleDivWrap('left-padding10 bottom-padding10', '', VGenerate::basicInput('button', 'save_response', 'submit-response symbol-button', '', '1', '<i class="iconBe-floppy-disk"></i>'.$language["respond.text.submit"]));
		$html.= VGenerate::simpleDivWrap('no-display', '', '<input type="hidden" name="f_type" value="' . $type . '" />');
		$html.= '</form>';

		return $html;
	}
	
	/* submit a new response */
	public static function submitResponse($upload = '', $file_key = '') {
		$class_database	= self::$dbc;
		$db		= self::$db;
		$class_filter	= self::$filter;
		$language	= self::$language;

		switch ($upload) {
			case "1":
				$type	= $class_filter->clr_str($_GET["t"]);
				$type	= $type == 'document' ? 'doc' : $type;
				$r_key	= $class_filter->clr_str($file_key);
				$f_key	= $class_filter->clr_str($_GET["r"]);
				$r_date = date("Y-m-d H:i:s");
				break;
			default:
				$type	= $class_filter->clr_str($_POST["f_type"]);
				$f_key	= $class_filter->clr_str($_GET[$type[0]]);
				$r_key	= $class_filter->clr_str($_POST["response_key"]);
				$r_date = date("Y-m-d H:i:s");
				break;
		}
		
		if (strlen($r_key) == 10) {
			$f		= 0;
			$db_nr		= 0;
			$main_arr	= array();

			$sql		= sprintf("SELECT 
							A.`file_responses`, 
							B.`usr_id`, B.`responding` 
							FROM 
							`db_%sresponses` A, `db_%sfiles` B 
							WHERE 
							A.`file_key`='%s' 
							AND A.`file_key`=B.`file_key` LIMIT 1;", $type, $type, $f_key);
			$res		= $db->execute($sql);
			$resp		= $res->fields["file_responses"];
			$usr_id		= $res->fields["usr_id"];
			$usr_id		= $usr_id == '' ? $class_database->singleFieldValue('db_' . $type . 'files', 'usr_id', 'file_key', $f_key) : $usr_id;
			$resp_perm	= ($res->fields["responding"] == 'all' or $usr_id == $_SESSION["USER_ID"]) ? 1 : 0;
			$resp_arr	= array("usr_id" => intval($_SESSION["USER_ID"]), "file_key" => $r_key, "date" => $r_date, "active" => $resp_perm);
			/* check if selected file is already response, and remove/update keys and totals */
			$eres		= $db->execute("SELECT `file_key`, `file_responses` FROM `db_" . $type . "responses` WHERE `file_key`!='" . $f_key . "' AND `file_responses` LIKE '%" . $r_key . "%' LIMIT 1;");
			$efr		= $eres->fields["file_responses"];

			if ($efr != '') {
				$eresp	= unserialize($efr);
				foreach ($eresp as $ekey => $eval) {
					if ($eval["file_key"] == $r_key) {
						unset($eresp[$ekey]);
						
						$db_total = count($eresp);
						$db_array = $db_total > 0 ? $db->execute(sprintf("UPDATE `db_%sresponses` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $type, serialize($eresp), $eres->fields["file_key"])) : $db->execute(sprintf("DELETE FROM `db_%sresponses` WHERE `file_key`='%s' LIMIT 1;", $type, $eres->fields["file_key"]));
					}
				}
				$db_count = $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $type, $db_total, $eres->fields["file_key"]));
			}

			/* no existing responses */
			if ($resp == '') {
				$main_arr[0]	= $resp_arr;
				$db_q		= $class_database->doInsert('db_' . $type . 'responses', array("file_key" => $f_key, "file_responses" => serialize($main_arr)));
				$db_nr		= 1;
				$db_total	= 1;
			} else { /* existing responses */
				$db_arr		= unserialize($resp);
				$resp_ct	= count($db_arr);

				if ($resp_ct > 0) {
					foreach ($db_arr as $key => $val) {
						if ($val["file_key"] == $r_key) {
							$f = 1;
						} else {
							$f = 0;
						}
					}

					if ($f == 0) {
						$db_arr[$resp_ct] = $resp_arr;
						$db_sql		= sprintf("UPDATE `db_%sresponses` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $type, serialize($db_arr), $f_key);
						$db_q		= $db->execute($db_sql);
						$db_nr		= 1;
						$db_total	= count($db_arr);
					}
				}
			}
			echo $do_notice = $db->Affected_Rows() > 0 ? VGenerate::noticeTpl('', '', ($resp_perm == 0 ? $language["respond.text.approved"] : $language["notif.success.request"])) : NULL;
			$db_total = $db_nr == 1 ? $db->execute(sprintf("UPDATE `db_%sfiles` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $type, $db_total, $f_key)) : NULL;
			/* mailing */
			if ($db_nr == 1 and $class_database->singleFieldValue('db_accountuser', 'usr_mail_filecomment', 'usr_id', $usr_id) == 1) {
				$mail_do = VNotify::queInit(($upload == '' ? 'file_response' : 'file_response_upload'), array(VUserinfo::getUserEmail($usr_id)), ($upload == '' ? '' : $r_key));
			}
		}
	}

	/* upload new response */
	public static function uploadResponse() {
		$cfg		= self::$cfg;
		$db		= self::$db;
		$class_filter	= self::$filter;
		$language	= self::$language;
		$type		= self::$type;

		$type_db	= $type == 'document' ? 'doc' : $type;
		$r_key		= $class_filter->clr_str($_GET["r"]);

		$sql		= sprintf("SELECT 
					A.`file_title`, A.`responding` 
					FROM `db_%sfiles` A
					WHERE A.`file_key`='%s' 
					AND A.`approved`='1' 
					AND A.`deleted`='0' 
					AND A.`active`='1' 
					LIMIT 1;", $type_db, $r_key);

		$res		= $db->execute($sql);
		$r_title	= $res->fields["file_title"];
		$r_url		= '<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $r_key, $r_title) . '" rel="nofollow">' . $r_title . '</a>';
		$r_perm		= $res->fields["responding"];
		$r_text		= $r_perm == 'approve' ? '. ' . $language["upload.text.r.approved"] : NULL;

		if ($r_title != '' and $r_perm != 'none' and $cfg["file_responses"] == 1) {
			$ht_js = '$(".notice-message-text").click(function(){$(this).replaceWith("");});';

			$html = VGenerate::simpleDivWrap('notice-message-text', '', $language["upload.text.responding"] . $r_url . $r_text, '');
			$html.= VGenerate::declareJS('$(document).ready(function(){' . $ht_js . '});');
		} else {
			header("Location:" . $cfg["main_url"] . '/' . VHref::getKey("upload") . '?t=' . $type);
		};

		return $html;
	}

	/* count inactive responses */
	public static function countInactiveResponses($type, $key) {
		$db	= self::$db;

		$t	= 0;
		$res	= $db->execute(sprintf("SELECT `file_responses` FROM `db_%sresponses` WHERE `file_key`='%s' LIMIT 1;", $type, $key));
		$resp	= $res->fields["file_responses"];

		if ($resp != '') {
			$resp_arr = unserialize($resp);
			
			foreach ($resp_arr as $k => $v) {
				if ($v["active"] == 0) {
					$t += 1;
				}
			}
		}
		return $t;
	}

	/* responses when viewing files */
	function viewFileResponses($type, $vres, $vuid, $like_arr = '') {
		$cfg		= self::$cfg;
		$db		= self::$db;
		$language	= self::$language;
		$class_filter	= self::$filter;
		$f_key		= self::$file_key;
		$htitle		= str_replace('##TYPE##', $language["frontend.global." . $type[0].".c"], $language["view.files.responses"]);

		if ($vres == '' and isset($_GET["rs"])) {
			$ss	= sprintf("SELECT `file_key` FROM `db_%sresponses` WHERE `file_responses` LIKE '%s';", $type, '%"file_key";s:10:"'.$f_key.'"%');
			$rr	= $db->execute($ss);

			if ($rr->fields["file_key"]) {
				$vr	= array();
				$ir	= 0;
				while (!$rr->EOF) {
					$vr[$ir]["file_key"] = $rr->fields["file_key"];
					$vr[$ir]["active"] = 1;
					$vr[$ir]["usr_id"] = 1;

					$ir+=1;
					$rr->MoveNext();
				}
				$vres	= serialize($vr);

				$htitle = str_replace('##TYPE##', $language["frontend.global.".$type[0].".c"], $language["view.files.response.to"]);
			}
		} elseif ($vres == '' and !isset($_GET["rs"])) {
			return false;
		}

		$res		= unserialize($vres);
		$r_count	= count($res);
		/* remove inactive responses */
		if (isset($res[0]["usr_id"])) {
			$f_arr	= array();

			foreach ($res as $k => $v) {
				$q .= "C.`file_key`='" . $v["file_key"] . "' OR ";

				if ($v["active"] == 0 and $vuid != $_SESSION["USER_ID"])
					$f_arr[] = $k;
			}

			if (count($f_arr) > 0) {
				foreach ($f_arr as $fv) {
					unset($res[$fv]);
				}

				$res	 = array_values($res);
				$r_count = count($res);
//				$q	 = '';
				
				foreach ($res as $kr => $kv) {
					$q .= "C.`file_key`='" . $kv["file_key"] . "' OR ";
				}
			}
			$q = $q != '' ? "AND (" . substr($q, 0, -4) . ")" : "AND C.`file_key`='0'";
		} else
			$q = "AND B.`file_key`='0'";

		if ($vuid == (int)$_SESSION["USER_ID"]) {
			$t = "!='personal'";
		} else {
			if ((int)$_SESSION["USER_ID"] > 0) {
				$f_is		= VContacts::getFriendStatus($vuid); //am I friend
				$bl_stat	= VContacts::getBlockStatus($vuid, $_SESSION["USER_NAME"]); //am I blocked
				$bl_opt		= VContacts::getBlockCfg('bl_files', $vuid, $_SESSION["USER_NAME"]); //is file access blocked
				
				if ($f_is == 1 and ( $bl_stat == 0 or ( $bl_stat == 1 and $bl_opt == 0))) {
					$t = "!='personal'";
				} else {
					$t = "='public'";
				}
			} else {
				$t = "='public'";
			}
		}

		$sql		= sprintf("SELECT 
						A.`usr_user`, A.`usr_id`, A.`usr_key`,
						A.`usr_dname`, 
						C.`file_title`, C.`file_key`,
						C.`file_views`, C.`file_duration`, C.`upload_date`, C.`file_comments`, C.`file_favorite`,
						C.`privacy`, C.`responding`, C.`approved`, C.`deleted`, C.`active` 
						FROM 
						`db_accountuser` A, `db_%sfiles` C
						WHERE 
						A.`usr_id`=C.`usr_id` 
						%s 
						AND C.`privacy`%s 
						AND C.`approved`='1' 
						%s
						AND C.`active`='1';", $type, $q, $t, (($cfg["file_delete_method"] == 3 or $cfg["file_delete_method"] == 4) ? "AND C.`deleted`='0' " : NULL));
		$rdb		= self::$db_cache ? $db->execute($cfg['cache_view_response_entries'], $sql) : $db->execute($sql);
		$r_count	= $rdb->recordcount();
		$pnr		= 1;
		$duration_show	= ($type === 'audio' or $type === 'video' or $type === 'live') ? 1 : 0;

		if ($r_count == 0)
			return false;

		$html  = '<div id="playlist-loader" class="border-wrapper">
				<div class="playlist_holder">
					<h3 class="">'.$htitle.'<br>&nbsp;</h3>
					'.VGenerate::simpleDivWrap('', 'resp-response').'
					<form id="resp-clear-form" method="post" action=""><input type="hidden" name="resp_clear" id="resp-clear" value="" /><input type="hidden" name="resp_type" id="resp-type" value="'.$type.'" /></form>

					<ul class="fileThumbs big clearfix playlist-items">
						##LI_LOOP##
					</ul>
				</div>
			</div>';
		
		
		if ($rdb->fields["file_key"]) {
			if (self::$cfg["file_watchlist"] == 1) {
				$user_watchlist		= VBrowse::watchlistEntries();
			}
			
			$li_loop = null;
			

			while (!$rdb->EOF) {
				$v		= $rdb->fields["file_key"];
				$usr_key	= $rdb->fields["usr_key"];
				$usr_id		= $rdb->fields["usr_id"];
				$_user		= $rdb->fields["usr_user"];
				$_duser		= $rdb->fields["usr_dname"];
				$_cuser		= $rdb->fields["ch_title"];
				$_user		= $_duser != '' ? $_duser : ($_cuser != '' ? $_cuser : $_user);
				$title		= $rdb->fields["file_title"];
				//$descr		= $rdb->fields["file_description"];
				$tmb_url	= VGenerate::thumbSigned($type, $v, $usr_key, 0, 1, 1);
				$key		= $v;
				$_dur		= VFiles::fileDuration($rdb->fields["file_duration"]);
				$datetime	= VUserinfo::timeRange($rdb->fields["upload_date"]);
				$_views		= $rdb->fields["file_views"];
				$_comm		= $rdb->fields["file_comments"];
				$_fav		= $rdb->fields["file_favorite"];
				
				
				$html	.= VGenerate::simpleDivWrap('no-display', '', '<form class="entry-form-class"><input type="checkbox" class="list-check" id="file-check'.$v.'" value="'.$v.'" name="fileid[]" /></form>');
		
				switch ($type) {
					case "live":
						$current = $v != $f_key ? 0 : 1;
						$a_href = $current == 0 ? $cfg["main_url"] . '/' . VGenerate::fileHref('l', $v, $title) : 'javascript:;';
						break;
					case "video":
						$current = $v != $f_key ? 0 : 1;
						$a_href = $current == 0 ? $cfg["main_url"] . '/' . VGenerate::fileHref('v', $v, $title) : 'javascript:;';
						break;
					case "audio":
						$current = $v != $f_key ? 0 : 1;
						$a_href = $current == 0 ? $cfg["main_url"] . '/' . VGenerate::fileHref('a', $v, $title) : 'javascript:;';
						break;
					case "image":
						$current = $v != $f_key ? 0 : 1;
						$a_href = $current == 0 ? $cfg["main_url"] . '/' . VGenerate::fileHref('i', $v, $title) : 'javascript:;';
						break;
					case "document":
					case "doc":
						$current = $v != $f_key ? 0 : 1;
						$a_href = $current == 0 ? $cfg["main_url"] . '/' . VGenerate::fileHref('d', $v, $title) : 'javascript:;';
						break;
					case "blog":
						$current = $v != $f_key ? 0 : 1;
						$a_href = $current == 0 ? $cfg["main_url"] . '/' . VGenerate::fileHref('b', $v, $title) : 'javascript:;';
						break;
				}
				
				if ($cfg["file_watchlist"] == 1) {
					if (is_array($user_watchlist) and in_array($v, $user_watchlist)) {
						$watchlist_icon = 'icon-check';
						$watchlist_text = $language["files.menu.watch.in"];
						$watchlist_info = null;
					} else {
						$watchlist_icon = 'icon-clock';
						$watchlist_text = $language["files.menu.watch.later"];
						$watchlist_info = ' rel-key="' . $v . '" rel-type="' . self::$type . '"';
					}
				}
				
				
				$li_loop.= '                    <li class="vs-column full-thumbs pp-li">
                                                    <div class="thumbs-wrapper">
                                                    <div class="pl-nr">'.($_GET[$type[0]] == $key ? '<i class="icon-play6"></i>' : $pnr).'</div>
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
                                                            <img src="' . $tmb_url . '" alt="' . $title . '">
                                                            <figcaption>
                                                                <a href="'.$a_href.'&rs='.md5(date("Y-m-d")).'">'.$title.'</a>
                                                            </figcaption>
                                                            '.($duration_show == 1 ? '
                                                            <div class="caption-more">
                                                                <span class="time-lenght'.($is_live ? ' t-live' : null).'">'.($is_live ? self::$language["frontend.global.live"] : $_dur.$conv).'</span>
                                                            </div>
                                                            ' : null).'
                                                        </figure>
                                                        <div class="full-details-holder">
                                                            <h2><a href="'.$a_href.'&rs='.md5(date("Y-m-d")).'">'.$title.'</a></h2>
                                                            <div class="vs-column-off pd">
                                                                <span class="views-number">'.VFiles::numFormat($_views).' '.($_views == 1 ? self::$language["frontend.global.view"] : self::$language["frontend.global.views"]).'</span>
                                                                <span class="i-bullet"></span>
                                                                <span class="views-number">'.$datetime.'</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>';
			$pnr += 1;
			$rdb->MoveNext();
			}
		}
	
		return str_replace('##LI_LOOP##', $li_loop, $html);
	}

	/* delete a response */
	public static function delResponse($for = '') {
		$class_filter	= self::$filter;
		$db		= self::$db;
		$language	= self::$language;

		if (!$_POST) return;

		$type		= $class_filter->clr_str($_POST["resp_type"]);
		$file_key	= $class_filter->clr_str($_GET[$type[0]]);
		$del_key	= $class_filter->clr_str($_POST["resp_clear"]);

		if ($file_key == '' or $del_key == '')
			return false;

		$sql		= sprintf("SELECT 
						A.`usr_id`, B.`file_responses` 
						FROM `db_%sfiles` A, `db_%sresponses` B 
						WHERE 
						A.`file_key`=B.`file_key` 
						AND B.`file_key`='%s' LIMIT 1;", $type, $type, $file_key);

		$res		= $db->execute($sql);
		$_uid		= $res->fields["usr_id"];
		$_resp		= $res->fields["file_responses"];

		if ($_uid == $_SESSION["USER_ID"] and $_resp != '') {
			$f	= NULL;
			$_arr	= unserialize($_resp);
			
			foreach ($_arr as $ak => $av) {
				if ($av["file_key"] == $del_key)
					$f = $ak;
			}

			if ($f >= 0) {
				unset($_arr[$f]);
				
				$_arr	= array_values($_arr);
				$_narr	= serialize($_arr);
				$do_db	= (count($_arr) == 0) ? $db->execute(sprintf("DELETE FROM `db_%sresponses` WHERE `file_key`='%s' LIMIT 1;", $type, $file_key)) : $db->execute(sprintf("UPDATE `db_%sresponses` SET `file_responses`='%s' WHERE `file_key`='%s' LIMIT 1;", $type, $_narr, $file_key));
				$db->execute(sprintf("UPDATE `db_%sfiles` SET `file_responses`=`file_responses`-1 WHERE `file_key`='%s' LIMIT 1;", $type, $file_key));

				return $for == '' ? self::viewFileResponses($type, $_narr, $_uid) : self::seeAllResponses();
			}
		}
	}

	/* check if key is already response */
	public static function isResponse($type, $f_key, $r_key) {
		$db	= self::$db;

		$sql	= "SELECT `db_id` FROM `db_" . $type . "responses` WHERE `file_key`='" . $f_key . "' AND `file_responses` LIKE '%" . $r_key . "%';";
		$res	= $db->execute($sql);

		if ($res->recordcount() > 0)
			return true;
		else
			return false;
	}

	/* check if key is response for other files */
	public static function isOtherResponse($type, $f_key, $r_key) {
		$db	= self::$db;

		$sql	= "SELECT `db_id` FROM `db_" . $type . "responses` WHERE `file_key`!='" . $f_key . "' AND `file_responses` LIKE '%" . $r_key . "%';";
		$res	= $db->execute($sql);

		if ($res->recordcount() > 0)
			return true;
		else
			return false;
	}
}
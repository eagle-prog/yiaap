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

/* file comments */
class VChannelComments extends VView {
	private static $db_cache;
	private static $user_id;
	private static $ch_cfg;
	
	public function __construct() {
		self::$db_cache = false; //change here to enable caching
		
		$adr		= self::$filter->clr_str($_SERVER["REQUEST_URI"]);
		
		if (strpos($adr, self::$href["channel"]) !== FALSE) {
			$c	 = new VChannel;
			$ch	 = true;
			
			$user_id = VChannel::$user_id;
		} elseif (isset($_GET["c"])) {
			$ch	 = true;
			
			$user_id = (int) $_GET["c"];
		}
		
		self::$user_id	 = $user_id;

		$ch		 = self::getChannelConf($user_id);
		self::$ch_cfg	 = unserialize($ch[0]["ch_cfg"]);
	}
	private static function getChannelConf($id) {
		$db	= self::$db;
		
		$rs	= $db->execute(sprintf("SELECT `ch_title`, `ch_tags`, `ch_type`, `ch_cfg` FROM `db_accountuser` WHERE `usr_id`='%s' AND `usr_status`='1' LIMIT 1;", $id));
		
		return $rs->getrows();
	}
	/* comments section */
	function commLayout($type, $vuid, $msg_arr = '', $like_arr = '') {
		$cfg		= self::$cfg;
		$language	= self::$language;
		$class_filter	= self::$filter;
		$class_database = self::$dbc;
		$href		= self::$href;
		$section	= self::$section;
		$f_key		= self::$user_id;
		
		$cfg["file_comment_spam"] = 1;

		$islogged	= (int) $_SESSION["USER_ID"] > 0 ? true : false;

		/* js stuff */
		$ht_js		= 'var comm_sec = "' . VHref::getKey("see_comments") . '";';
		$ht_js		.= 'var comm_url = "' . $cfg["main_url"] . '/"+comm_sec+"?' . $type[0] . '=' . $vuid . '"; var m_loading = "";';
		/* pagination links */
		$page_nr	= (int) $_GET["page"] > 1 ? (int) $_GET["page"] : 1;
		$ht_js		.= '$(".comm-page-link").click(function(){ var pid = $(this).attr("id").substr(1); var comm_link = comm_url + "&do=comm-load&page="+pid; $("#list-' . $type . '-comments").mask(m_loading); $.post(comm_link, $("#comm-post-form").serialize(), function(data) { $("#comment-load").html(data); $("#list-' . $type . '-comments").unmask(); }); });';
		$ht_js		.= '$(".comm-page-prev").click(function(){ var comm_link = comm_url + "&do=comm-load&page=' . ($page_nr - 1) . '"; $("#list-' . $type . '-comments").mask(m_loading); $.post(comm_link, $("#comm-post-form").serialize(), function(data) { $("#comment-load").html(data); $("#list-' . $type . '-comments").unmask(); }); });';
		$ht_js		.= '$(".comm-page-next").click(function(){ var comm_link = comm_url + "&do=comm-load&page=' . ($page_nr + 1) . '"; $("#list-' . $type . '-comments").mask(m_loading); $.post(comm_link, $("#comm-post-form").serialize(), function(data) { $("#comment-load").html(data); $("#list-' . $type . '-comments").unmask(); }); });';
		/* mouse over comments */
		$ht_js		.= '$(".comment_h").mouseover(function(){var c_key = $(this).find(".comm-actions-hkey:first").text(); $("#comm-actions2-over"+c_key).removeClass("no-display"); $(this).addClass("comment-bg-on");}).mouseout(function(){var c_key = $(this).find(".comm-actions-hkey:first").text();$("#comm-actions2-over"+c_key).addClass("no-display");$(this).removeClass("comment-bg-on");});';
		/* if logged in */
		if ($islogged) {
			/* click on comment box */
			$ht_js .= '$(".comm-input-action").click(function(){if($(".comm-input-action").val() == "' . $language["view.files.respond.channel"] . '"){$(this).val("");}$(".comm-switch").removeClass("comm-hide");$(this).removeClass("h50");});';
			/* click on cancel posting comment */
			$ht_js .= '$(".comm-cancel-action").click(function(){$(".comm-input-action").val("' . $language["view.files.respond.channel"] . '");$(".comm-switch2").addClass("comm-hide");$(".comm-input-action").addClass("h50");$("#comm-char-remaining").html("' . $cfg["comment_max_length"] . '");});';
			/* update comment limit */
			//$ht_js .= '$(".comm-input-action").keyup(function(){var rem = ' . $cfg["comment_max_length"] . '-$(this).val().length; $("#comm-char-remaining").html(rem > 0 ? rem : 0); if(rem < 1){$("#comm-char-remaining").parent().addClass("err-red");}else{$("#comm-char-remaining").parent().removeClass("err-red");}});';
			//$ht_js .= '$(document).on("keyup", ".comm-reply-action", function (){var rid = $(this).attr("id").substr(2); var rem = ' . $cfg["comment_max_length"] . '-$(this).val().length; $("#comm-char-remaining"+rid).html(rem > 0 ? rem : 0); if(rem < 1){$("#comm-char-remaining"+rid).parent().addClass("err-red");}else{$("#comm-char-remaining"+rid).parent().removeClass("err-red");}});';
			/* click to post comment */
			$ht_js .= '$(".post-comment-button").click(function(){if($(".comm-input-action").val() != ""){var t = $(this); t.find("i").addClass("spinner icon-spinner");$("#ntm").mask("");$.post(comm_url+"&do=comm-post", $("#comm-post-form").serialize(), function(data){$("#comment-load").html(data);$(".comm-input-action").val(""); t.find("i").removeClass("spinner icon-spinner");});}});';
			$ht_js .= 'var pag="&page=' . $page_nr . '";';
			/* approve */
			$ht_js .= '$(".comm-approve").click(function(){';
			$ht_js .= 'var f1 = $(this).parent().parent().next().text(); var f2 = $("#comm-post-form").serialize(); var frm = "c_key="+f1+"&"+f2;';
			$ht_js .= 'var t = $(this); t.find("i").addClass("spinner icon-spinner");';
			$ht_js .= '$.post(comm_url+"&do=comm-approve"+pag, frm, function(data){';
			$ht_js .= '$("#comment-load").html(data);'; // $(".comm-input-action").val("");';
			$ht_js .= 't.find("i").removeClass("spinner icon-spinner");';
			$ht_js .= '});});';
			/* suspend */
			$ht_js .= '$(".comm-suspend").click(function(){';
			$ht_js .= 'var f1 = $(this).parent().parent().next().text(); var f2 = $("#comm-post-form").serialize(); var frm = "c_key="+f1+"&"+f2;';
			$ht_js .= 'var t = $(this); t.find("i").removeClass("icon-lock").addClass("spinner icon-spinner");';
			$ht_js .= '$.post(comm_url+"&do=comm-suspend"+pag, frm, function(data){';
			$ht_js .= '$("#comment-load").html(data);'; // $(".comm-input-action").val("");';
			$ht_js .= 't.find("i").removeClass("spinner icon-spinner");';
			$ht_js .= '});});';
			/* spam */
			if ($cfg["file_comment_spam"] == 1) {
				$ht_js .= '$(".comm-spam").click(function(){';
				$ht_js .= 'var f1 = $(this).parent().parent().next().text(); var f2 = $("#comm-post-form").serialize(); var frm = "c_key="+f1+"&"+f2;';
				$ht_js .= 'var t = $(this); t.find("i").removeClass("icon-lock").addClass("spinner icon-spinner");';
				$ht_js .= '$.post(comm_url+"&do=comm-spam"+pag, frm, function(data){';
				$ht_js .= '$("#comment-load").html(data);'; // $(".comm-input-action").val("");';
				$ht_js .= 't.find("i").addClass("icon-lock").removeClass("spinner icon-spinner");';
				$ht_js .= '});});';
			}
			/* delete */
			$ht_js .= '$(".comm-delete").click(function(){var message = "' . $language["view.files.comm.confirm"] . '";var answer = confirm(message);if(answer){';
			$ht_js .= 'var f1 = $(this).parent().parent().next().text(); var f2 = $("#comm-post-form").serialize(); var frm = "c_key="+f1+"&"+f2;';
			$ht_js .= 'var t = $(this); t.find("i").removeClass("icon-times").addClass("spinner icon-spinner");';
			$ht_js .= '$.post(comm_url+"&do=comm-delete"+pag, frm, function(data){';
			$ht_js .= '$("#comment-load").html(data);'; // $(".comm-input-action").val("");';
			$ht_js .= 't.find("i").addClass("icon-times").removeClass("spinner icon-spinner");';
			$ht_js .= '});}return false;});';
			/* click on comment actions menu */
			$ht_js .= '$(".single-comm-action").click(function(){if($(this).next().next().hasClass("no-display")){$(this).addClass("topnav-button-active");$(this).next().next().removeClass("no-display");}else{$(this).removeClass("topnav-button-active");$(this).next().next().addClass("no-display");}});';
			/* reply to comm */
			$ht_js .= '$(".comm-reply").click(function(){';
			$ht_js .= 'var f1 = $(this).parent().next().text();';
			$ht_js .= 'var ct = "' . $cfg["comment_max_length"] . '"; var ht = \'<div class="comment-reply cr-\'+f1+\'"><span id="cp-pos\'+f1+\'" class="cp-pos">0</span><div class="comment_left_char tfr"><p class="rem_char reply_char"><span class="greyed-out comm-switch\'+f1+\'"><span id="comm-char-remaining\'+f1+\'">\'+(ct-($(".comm-own"+f1+">a").html().length+3))+\'</span> ' . $language["view.files.comm.char"] . '</span></p></div><form class="entry-form-class" id="comm-reply-form\'+f1+\'"><input type="hidden" name="comm_reply" value="\'+f1+\'" /><input type="hidden" name="comm_type" value="' . $type . '" /><input type="hidden" name="comm_uid" value="' . $vuid . '" /><textarea name="file_comm_text" id="r-\'+f1+\'" class="textarea-input comm-reply-action" rows="1" cols="1">@\'+$(".comm-own"+f1+">a").text().trim()+\': </textarea><div class="comm-switch\'+f1+\'"><div class="comments_actions main_comments_actions" style="display:none"><a class="comm-cancel-action comm-cancel-reply" href="javascript:;" onclick="$(&quot;.cr-\'+f1+\'&quot;).replaceWith(&quot;&quot;);">' . $language["frontend.global.cancel"] . '</a><button onfocus="blur();" value="1" type="button" class="search-button reply-comment-button symbol-button" id="pr-\'+f1+\'" name="post_file_comment"><span>' . $language["frontend.global.reply"] . '</span></button></div></div></form></div>\';';
			$ht_js .= 'if(!$(".cr-"+f1).html()){$(ht).insertAfter("#comm-actions2-over"+f1);} $("#c-menu"+f1+".single-comm-action").click();';
			/* reply emoji */
			if ($cfg["comment_emoji"] == 1) {
				$ht_js .= 'var el = $("#r-"+f1).emojioneArea({pickerPosition:"bottom",hidePickerOnBlur:true,shortnames:false,saveEmojisAs:"shortname",searchPosition:"top",tones:false});';
				$ht_js .= 'var vn="ps"+f1;var vn=new PerfectScrollbar(".cr-"+f1+" .emojionearea-scroll-area");';
				$ht_js .= '$(".cr-"+f1+" .emojionearea-editor").attr("id","cp-wrap"+f1);';
				//$ht_js .= '$(".cr-"+f1+" .emojionearea-editor").on("mousedown mouseup keydown keyup", getCurrentCursorPosition);';//beta
				//$ht_js .= '$(".cr-"+f1+" .emojionearea-button").on("click", setCurrentCursorPosition);';//beta
				$ht_js .= 'el[0].emojioneArea.on("focus", function(){$(".cr-"+f1+" .emojionearea-filters").addClass("arrow_box");$(".cr-"+f1+" .emojionearea-editor").attr("id","cp-wrap"+f1);$(".cr-"+f1+" .main_comments_actions,.cr-"+f1+" .emojionearea-button").show()});';
				$ht_js .= 'el[0].emojioneArea.setText("@"+$(".comm-own"+f1+">a").text().trim()+": ");';
			}
			$ht_js .= '});';
			/* comment like */
			$ht_js .= '$(".comm-like-action").click(function(){';
			$ht_js .= 'var f1 = $(this).parent().next().html(); var f2 = $("#comm-post-form").serialize(); var frm = "c_key="+f1+"&"+f2;';
			$ht_js .= 'var t = $(this); t.find("i").removeClass("icon-thumbs-up").addClass("spinner icon-spinner");';
			$ht_js .= '$.post(comm_url+"&do=comm-like"+pag, frm, function(data){';
			$ht_js .= '$("#comment-load").html(data);'; // $(".comm-input-action").val("");';
			$ht_js .= 't.find("i").addClass("icon-thumbs-up").removeClass("spinner icon-spinner");';
			$ht_js .= '});});';
			$ht_js .= '$(".comm-dislike-action").click(function(){';
			$ht_js .= 'var f1 = $(this).parent().next().html(); var f2 = $("#comm-post-form").serialize(); var frm = "c_key="+f1+"&"+f2;';
			$ht_js .= 'var t = $(this); t.find("i").removeClass("icon-thumbs-up2").addClass("spinner icon-spinner");';
			$ht_js .= '$.post(comm_url+"&do=comm-dislike"+pag, frm, function(data){';
			$ht_js .= '$("#comment-load").html(data);'; // $(".comm-input-action").val("");';
			$ht_js .= 't.find("i").addClass("icon-thumbs-up2").removeClass("spinner icon-spinner");';
			$ht_js .= '});});';
		}
		/* show/hide replies */
		$ht_js .= '$(".comm-toggle-replies").on("click", function(){var t = $(this); var _id = t.attr("id").substr(3); $("#"+_id+" > .response_holder").stop().slideToggle(300, function(){t.find("i").toggleClass("iconBe-chevron-up iconBe-chevron-down");}); });';
		$ht_js .= '$(".comm-toggle-replies").each(function(){var t = $(this); var _id = t.attr("id").substr(3); if (typeof($("#"+_id+" .response_holder").html()) == "undefined"){t.detach();}});';
		/* hide all replies on page load */
		$ht_js .= '$(".comments_activity").each(function(){var t = $(this); var _id = t.attr("id"); if (!t.hasClass("response") && typeof($("#"+_id+" > .response_holder").html()) !== "undefined") {$("#"+_id+" > .response_holder").hide();} });';
		/* load more comments */
		$ht_js .= '$(".more-comments").click(function(){ var t = $(this); var page = parseInt(t.attr("rel-page")); var pagenext = page+1; $.post(comm_url+"&do=comm-more&page="+pagenext, frm, function(data){}); });';
		/* emoji */
		if ($cfg["comment_emoji"] == 1) {
			$ht_js .= 'var el = $(".comm-input-action").emojioneArea({placeholder:"'.$language["view.files.add.comm"].'",pickerPosition:"bottom",hidePickerOnBlur:true,shortnames:false,saveEmojisAs:"shortname",searchPosition:"top",tones:false});';
			$ht_js .= 'if(typeof el[0]!="undefined"){var ps1=new PerfectScrollbar(".emojionearea-scroll-area");el[0].emojioneArea.on("focus",function(){$("#ntm .emojionearea-filters").addClass("arrow_box");$("#ntm .emojionearea-editor").attr("id","cp-wrap");$("#ntm .main_comments_actions,#ntm .emojionearea-button").show()})}';
			$ht_js .= 'var tc = $(".comment_h p:not(.posted_on)").length; $(".comment_h p:not(.posted_on)").each(function(index,value){if(index===tc-1){$(\'#list-' . $type . '-comments,#ntm\').show();$(\'#list-' . $type . '-comments-load\').hide()}var t=$(this);var c=t.text();var nc=emojione.toImage(c);t.html(nc)});';
		}
		/* linkify comments */
		$ht_js .= '$(".comment_h p,p.p-info").linkify({defaultProtocol:"https",validate:{email:function(value){return false}},ignoreTags:["script","style"]});';
		/* caret positioning (BETA) */
		//$ht_js .= 'function createRange(node, chars, range) {if (!range) {range = document.createRange();range.selectNode(node);range.setStart(node, 0);}if (chars.count === 0) {range.setEnd(node, chars.count);} else if (node && chars.count >0) {if (node.nodeType === Node.TEXT_NODE) {if (node.textContent.length < chars.count) {chars.count -= node.textContent.length;} else {range.setEnd(node, chars.count);chars.count = 0;}} else {for (var lp = 0; lp < node.childNodes.length; lp++) {range = createRange(node.childNodes[lp], chars, range);if (chars.count === 0) {break;}}}}return range}function setCurrentCursorPosition() {var parentId = "cp-wrap";var posId = "cp-pos";if (typeof $(".comment-bg-on .comm-reply-action").html() != "undefined") {var parentId = $(".comment-bg-on .comm-reply-action .emojionearea-editor").attr("id");var posId = parentId.replace("cp-wrap", "cp-pos");}var chars = $("#"+posId).text();if (chars >= 0) {var selection = window.getSelection();range = createRange(document.getElementById(parentId).parentNode, { count: chars });if (range) {range.collapse(false);selection.removeAllRanges();selection.addRange(range);}}}function isChildOf(node, parentId) {while (node !== null) {if (node.id === parentId) {return true;}node = node.parentNode;}return false}function getCurrentCursorPosition() {var parentId = "cp-wrap";var posId = "cp-pos";if (typeof $(".comment-bg-on .comm-reply-action").html() != "undefined") {var parentId = $(".comment-bg-on .comm-reply-action .emojionearea-editor").attr("id");var posId = parentId.replace("cp-wrap", "cp-pos");}var selection = window.getSelection();var charCount = 0;var node;if (selection.focusNode) {if (isChildOf(selection.focusNode, parentId)) {node = selection.focusNode; charCount = selection.focusOffset;while (node) {if (node.id === parentId) {break;}if (node.previousSibling) {node = node.previousSibling;charCount += node.textContent.length;} else {node = node.parentNode;if (node === null) {break}}}}}$("#"+posId).text(charCount)}';
		//$ht_js .= '$("#ntm .emojionearea-editor").on("mousedown mouseup keydown keyup", getCurrentCursorPosition);$("#ntm .emojionearea-button").on("click", setCurrentCursorPosition);';

		/* comm post response */
		$html		= '
				<div class="page_holder comm_wrapper" id="' . $type . '-comm-wrapper">
					<article>
						<h3 class="content-title with-lines-off">
							<i class="icon-comments"></i>' . $language["view.files.comm.all"] . '
						</h3>
						<div class="line no-display1"></div>
					</article>
					' . VGenerate::simpleDivWrap('', 'comm-post-response', VGenerate::noticeTpl('', $msg_arr[1], $msg_arr[0])) . '

					' . ($islogged ? '
					<div id="ntm" style="display:block">
					<form id="comm-post-form" method="post" action="" class="entry-form-class">
						<div class="usr_img">
							<img width="50" height="50" alt="' . $c_usr . '" src="' . VUseraccount::getProfileImage((int)$_SESSION["USER_ID"]) . '">
						</div>
						<div class="comment_h_wrap">
						' . VGenerate::basicInput('textarea', 'file_comm_text', 'comm-input-action') . '
						' . VGenerate::simpleDivWrap('no-display', '', '<input type="hidden" name="comm_type" value="' . $type . '" /><input type="hidden" name="comm_uid" value="' . $vuid . '" />') . '

						<div class="comments_actions main_comments_actions" style="display:none">
							<a href="javascript:;" class="comm-cancel-action" rel="nofollow" onclick="$(\'#ntm .emojionearea-editor\').text(\'\');$(\'#ntm .main_comments_actions,#ntm .emojionearea-button\').hide();">' . $language["frontend.global.cancel"] . '</a>
							<button value="1" type="button" class="post-comment-button" id="btn-1-post_file_comment" name="post_file_comment">'.$language["view.files.comm.btn"].'</button>
						</div>
						</div>
						<span id="cp-pos" class="cp-pos">0</span>
					</form>
					</div>
					' : '	<div class="comments_signin"><a href="' . $cfg["main_url"] . '/' . VHref::getKey("signin") . '?next=' . VGenerate::fileHref($type[0], $f_key) . '" rel="nofollow">' . $language["frontend.global.signin"] . '</a> ' . $language["frontend.global.or"] . ' <a href="' . $cfg["main_url"] . '/' . VHref::getKey("signup") . '" rel="nofollow">' . $language["frontend.global.createaccount"] . '</a> ' . $language["view.files.comm.post"]) . '</div>
						<div class="clearfix"></div>
						<form id="comm-post-form" method="post" action="" class="entry-form-class">
							' . VGenerate::simpleDivWrap('no-display', '', '<input type="hidden" name="comm_type" value="' . $type . '" /><input type="hidden" name="comm_uid" value="' . $vuid . '" />') . '
						</form>

					' . VGenerate::simpleDivWrap('', 'list-' . $type . '-comments', VChannelComments::listFileComments($type, $vuid)) . '
		';

		$html .= $cfg["comment_emoji"] == 1 ? '<script type="text/javascript" src="'.$cfg['scripts_url'].'/shared/emoji/emojionearea.min.js"></script>' : null;

		$html .= VGenerate::declareJS('$(document).ready(function(){' . $ht_js . '});function opencheck(k){$(".comments_activity").each(function(){var t = $(this); var _id = t.attr("id"); if (t){ if (typeof(t.find("#"+k).html()) != "undefined") {setTimeout(function () {$("#"+_id+" > .response_holder").css("display", "block"); $("#"+_id+" .comm-toggle-replies").find("i").removeClass("iconBe-chevron-down").addClass("iconBe-chevron-up"); }, 1);} } }); }');

		return $html;
	}

	/* listing comments */
	function listFileComments($type, $vuid, $getReplies = false) {
		$db		= self::$db;
		$class_filter	= self::$filter;
		$cfg		= self::$cfg;
		$language	= self::$language;
		$section	= self::$section;
		$href		= self::$href;
		$file_key	= self::$file_key;
		
		$ch_cfg		= self::$ch_cfg;

		$edit		= $vuid == (int) $_SESSION["USER_ID"] ? 1 : 0;
		/* paging */
		$cpp		= 15;
		$page_nr	= isset($_GET["page"]) ? (int) $_GET["page"] : 1;
		$s_from		= !$getReplies ? ($page_nr - 1) * $cpp : 0;

		$reply_t	= !$getReplies ? "`c_replyto`=''" : sprintf("`c_replyto`='%s'", $getReplies["replyto"]);
		$reply_s	= !$getReplies ? "A.`c_replyto`=''" : sprintf("A.`c_replyto`='%s'", $getReplies["replyto"]);

		$ttotal_sql	= sprintf("SELECT COUNT(*) AS `total` FROM `db_%scomments` WHERE `file_key`='%s' %s AND `c_active`='1'", $type, $file_key, ($edit == 1 ? "" : "AND `c_approved`='1'"));
		$total_sql	= sprintf("SELECT COUNT(*) AS `total` FROM `db_%scomments` WHERE %s AND `file_key`='%s' %s AND `c_active`='1'", $type, $reply_t, $vuid, ($edit == 1 ? "" : "AND `c_approved`='1'"));
		$comm_sql	= sprintf("SELECT 
				    A.`c_usr_id`, A.`c_key`, A.`c_body`, A.`c_datetime`, A.`c_approved`, A.`c_rating`, A.`c_replyto`,
				    B.`usr_user`, B.`usr_id`, B.`usr_key`, B.`usr_partner`, B.`usr_affiliate`, B.`affiliate_badge`,
				    B.`usr_dname`,
				    B.`ch_title`
				    FROM `db_%scomments` A, `db_accountuser` B
				    WHERE 
				    %s 
				    AND A.`file_key`='%s' 
				    %s 
				    AND A.`c_active`='1' 
				    AND A.`c_usr_id`=B.`usr_id` 
				    ORDER BY `c_id` 
				    DESC 
				    LIMIT %s, %s;", $type, $reply_s, $vuid, ($edit == 1 ? "" : "AND A.`c_approved`='1' "), $s_from, $cpp);
		
		$comm_db	= self::$db_cache ? $db->CacheExecute($cfg['cache_view_comments'], $comm_sql) : $db->execute($comm_sql);
		$ttotal_db	= self::$db_cache ? $db->CacheExecute($cfg['cache_view_comments'], $ttotal_sql) : $db->execute($ttotal_sql);
		$total_db	= self::$db_cache ? $db->CacheExecute($cfg['cache_view_comments'], $total_sql) : $db->execute($total_sql);
		$total_nr	= $total_db->fields["total"];
		$ttotal_nr	= (int) $ttotal_db->fields["total"];
		$comm_rs	= $comm_db->getrows();

		$pages		= ceil($total_nr / $cpp);

		if ($total_nr > 0) {
			$html	= null;

			foreach ($comm_rs as $key => $val) {
				$c_key		= $val["c_key"];
				$c_body		= $val["c_body"];
				$c_usr_name	= $val["usr_user"];
				$c_usr_key	= $val["usr_key"];
				$c_dusr		= $val["usr_dname"];
				$ch_usr		= $val["ch_title"];
				$c_usr		= $c_dusr != '' ? $c_dusr : ($ch_usr != '' ? $ch_usr : $c_usr);
				$c_replyto	= $val["c_replyto"];

				$val["comment_votes"] = 1;
				$cfg["file_comment_votes"] = 1;
				$val["comment_spam"] = 1;

				$c_date		= VUserinfo::timeRange($val["c_datetime"]);
				$c_date		= $c_date != '' ? $c_date : $language["frontend.global.now"];
				$usr_lnk	= $cfg["main_url"] . '/' . VHref::getKey("channel") . '/' . $c_usr_key . '/' . $c_usr_name;

				/* user thumbnail */
				$cfg["file_comments_avatar"] = 1;
				$more_menu	= false;
				$more_ht	= '<ul id="" class="accordion cacc">';
				$thumb_ht	= $cfg["file_comments_avatar"] == 1 ? VGenerate::simpleDivWrap('comment-user', '', '<a href="' . $cfg["main_url"] . '/' . VHref::getKey("user") . '/' . VUserinfo::getUserName($val["c_usr_id"]) . '" rel="nofollow"><img class="" title="" alt="" src="' . VUseraccount::getProfileImage($val["c_usr_id"]) . '" width="50" height="45" /></a>') : NULL;
				/* delete link */
				$delete_ht	= ($edit == 1 or $val["c_usr_id"] == $_SESSION["USER_ID"]) ? 1 : NULL;
				/* spam link */
				$spam_ht	= (((int) $_SESSION["USER_ID"] > 0 and $val["c_usr_id"] != (int) $_SESSION["USER_ID"] and $val["comment_spam"] == 1) ? ($delete_ht != '' ? '<span class="row"></span>' : NULL) . '<a href="javascript:;" rel="nofollow" class="white-bg comm-spam comm-action-entry">' . $language["upage.text.comm.spam.action"] . '</a>' : NULL);
				$ht_spam	= ($ch_cfg["ch_comm_spam"] == 1) ? self::spamCommentCount($type, $val["c_key"]) : 0;
				$ht_spam_link	= ($ch_cfg["ch_comm_spam"] == 1 and $ht_spam > 0 and $val["comment_spam"] == 1) ? '<div class="comm-spam-thumb left-float left-margin5"></div><div class="left-float left-padding3"><span class="">' . $language["view.files.comm.reports"] . '</span> <a href="javascript:;" rel="nofollow" class="' . ($ht_spam > 0 ? 'show-spamrep' : NULL) . '" id="sr' . $val["c_key"] . '" onclick="$(\'#spam-rep-' . $c_key . '\').toggle();">[' . $ht_spam . ']</a></div>' : NULL;

				/* comment voting */
				$vote_ht	= null;
				if ($val["comment_votes"] == 1 and $cfg["file_comment_votes"] == 1) {
					$vote_ht .= '<button title="' . $language["frontend.global.like"] . '" type="button" class="comm-like-action" id="cd-' . $c_key . '" rel="tooltip"><i class="icon-thumbs-up"></i><span>&nbsp;</span></button>';
					$vote_ht .= '<button title="' . $language["frontend.global.dislike"] . '" type="button" class="comm-dislike-action" id="cl-' . $c_key . '" rel="tooltip"><i class="icon-thumbs-up2"></i><span>&nbsp;</span></button>';
				}
				/* reply */
				if ($_SESSION["USER_ID"] > 0) {
					$vote_ht .= '<button title="' . $language["frontend.global.reply"] . '" type="button" class="search-button comm-action-entry comm-reply" id="cr-' . $c_key . '"><span>' . $language["frontend.global.reply"] . '</span></button>';
				}
				/* approve, suspend */
				if ($edit == 1) {
					$_label = ($val["c_approved"] == 0 ? $language["frontend.global.approve"] : $language["frontend.global.suspend.cap"]);
					$_class = ($val["c_approved"] == 0 ? 'comm-approve' : 'comm-suspend');
					$more_ht .= '<li><button title="' . $_label . '" type="button" class="search-button comm-action-entry ' . $_class . '" id="cs-' . $c_key . '" rel="tooltip-off"><i class="icon-' . ($val["c_approved"] == 0 ? 'check' : 'power-off') . '"></i><span>' . $_label . '</span></button></li>';
					$more_menu = true;
				}
				/* delete */
				if ($edit == 1 or $val["c_usr_id"] == $_SESSION["USER_ID"]) {
					$more_ht .= '<li><button title="' . $language["frontend.global.delete"] . '" type="button" class="search-button comm-action-entry comm-delete" id="d' . $c_key . '" rel="tooltip-off"><i class="icon-times"></i><span>' . $language["frontend.global.delete"] . '</span></button></li>';
					$more_menu = true;
				}
				/* spam */
				if ($_SESSION["USER_ID"] > 0 and $val["c_usr_id"] != $_SESSION["USER_ID"] and $val["comment_spam"] == 1) {
					$more_ht .= '<li><button title="' . $language["frontend.global.spam"] . '" type="button" class="search-button comm-action-entry comm-spam" id="s' . $c_key . '" rel="tooltip-off"><i class="icon-lock"></i><span>' . $language["view.files.comm.btn.spam.rep"] . ' (' . $ht_spam . ')</span></button></li>';
					$more_menu = true;
				}
				$more_ht	 .= '</ul>';

				if ($ht_spam > 0) {
				}
				/* spam reports */
				$spam_rep = (($edit == 1 )) ? VGenerate::simpleDivWrap('', 'wrapsr' . $c_key, self::listSpamReports($c_key, $type)) : VGenerate::simpleDivWrap('no-display', '', '');
				/* comm key form */
				$ckey_ht = '<div class="no-display comm-actions-hkey">' . $c_key . '</div>';
				/* all actions */
				$comm_actions = $_SESSION["USER_ID"] > 0 ? VGenerate::simpleDivWrap('ucls-links', '', '<div class="">' . $vote_ht . '</div>' . $ckey_ht) : NULL;
				$more_actions = $_SESSION["USER_ID"] > 0 ? VGenerate::simpleDivWrap('ucls-links', '', $more_ht . $ckey_ht) : NULL;
				$more_actions .= $_SESSION["USER_ID"] > 0 ? VGenerate::simpleDivWrap('yy-bg spam-rep-list', 'spam-rep-' . $c_key, $spam_rep, 'display: none;') : NULL;
				$add = '';
				/* comment html */
				if ($val["comment_votes"] == 1 and $cfg["file_comment_votes"] == 1) {
					$c_rate = $val["c_rating"] != '' ? unserialize($val["c_rating"]) : '';
					if ($c_rate != '') {
						foreach ($c_rate as $k => $v) {
							$add .= $v;
						}
						$t_rate = self::calculateString($add);
					} else {
						$t_rate = 0;
					}
				}

				$html .= '	' . (($c_replyto > 0 ? '<div class="response_holder">' : null)) . '
					<div id="' . $c_key . '" class="comments_activity' . ($c_replyto > 0 ? ' response' : null) . '" rel-resp="' . $c_replyto . '">
						<div class="usr_img">
							<a href="' . $usr_lnk . '" rel="nofollow"><img width="50" height="50" alt="' . $c_usr . '" src="' . VUseraccount::getProfileImage($val["c_usr_id"]) . '"></a>
							' . ($t_rate != 0 ? '<div class="comment-rating ' . ($t_rate > 0 ? 'conf-green' : 'err-red') . '">(' . ($t_rate > 0 ? '+' . $t_rate : $t_rate) . ')</div>' : null) . '
						</div>
						<div class="comment_h" id="' . $type . '-comment' . $c_key . '">
							<div class="comm-own-holder comm-own' . $c_key . '">
								<a href="' . $usr_lnk . '">' . VAffiliate::affiliateBadge((($val["usr_affiliate"] == 1 or $val["usr_partner"] == 1) ? 1 : 0), $val["affiliate_badge"]) . $c_usr . '</a>
								<span class="posted_on">' . $c_date . '</span>
							</div>
							<p class="comm-body">' . trim($c_body) . '</p>
							<div class="clearfix"></div>
							<div class="likes_holder">
								<div class="comment-wrap comment-bg' . ($val["c_usr_id"] == intval($_SESSION["USER_ID"]) ? ' my-comm' : NULL) . '">
									<div class="comm-over-off" id="comm-actions-main' . $c_key . '">' . $comm_actions . '</div>
									<div class="no-display1 comm-over-off" id="comm-actions2-over' . $c_key . '" style="display:block">
									'.($more_menu ? '
										<span class="no-session-icon place-right" onclick="if($(\'#comment-actions-dd'.$c_key.'\').is(\':visible\')){$(\'#comment-actions-dd'.$c_key.'\').hide()}else{$(\'.comment-actions-dd\').hide();$(\'#comment-actions-dd'.$c_key.'\').show()}"><i class="mt-open"></i></span>
									' : null).'
									</div>
									'.($more_menu ? '
										<div class="comment-actions-dd" id="comment-actions-dd'.$c_key.'" style="display:none">
										<div class="blue">
										'.$more_actions.'
										</div>
										</div>
									' : null).'

									' . ($c_replyto == '0' ? '<div class="clearfix"></div><div class="comm-replies-show"><button id="cs-' . $c_key . '" class="search-button comm-toggle-replies" type="button" title="' . $language["view.files.replies.toggle"] . '"><i class="iconBe-chevron-down"></i><span>' . $language["view.files.replies"] . '</span></button><button id="xx-' . $c_key . '" class="search-button comm-toggle-replies-quick no-display" type="button" title="' . $language["view.files.replies.toggle"] . '"><i class="iconBe-chevron-down"></i><span>' . $language["view.files.replies"] . '</span></button></div>' : null) . '
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						' . VChannelComments::listFileComments($type, $vuid, array("replyto" => $c_key)) . '
					</div>
					' . (($c_replyto > 0 ? '</div>' : null)) . '
					';

				echo ((isset($_POST["c_key"]) and $class_filter->clr_str($_POST["c_key"]) == $c_key) ? VGenerate::declareJS('opencheck("' . $c_key . '");') : null);

				if (($key + 1) == $cpp) {
					break;
				}
			}

			/* pagination links */
			if ($pages > 1 and ! $getReplies and (int) $_SESSION["USER_ID"] > 0) {
				$p = 10; //number of page links to show
				$j = ($page_nr >= $p) ? (floor($page_nr / $p) * $p) : 1;
				$j_gt = ($page_nr >= $p) ? ((floor($page_nr / $p) * $p) + ($p - 1)) : ($p - 1);

				$pag = '<center><span class="' . ($page_nr != 1 ? 'comm-page-prev pointer' : 'comm-page-start') . ' left-float">' . ($page_nr != 1 ? '<a class="comm-cancel-action prev-user-comm1 paginate paginate-prev" href="javascript:;">' . $language["frontend.global.previous"] . '</a>' : '<span class="inactive">' . $language["frontend.global.previous"] . '</span>') . '</span></center>';

				$pag .= '<span class="' . ($page_nr != $pages ? 'comm-page-next pointer' : 'comm-page-end') . ' left-float">' . ($page_nr != $pages ? '<a class="comm-cancel-action next-user-comm1 paginate paginate-next" href="javascript:;">' . $language["frontend.global.next"] . '</a>' : '<span class="inactive">' . $language["frontend.global.next"] . '<span>') . '</span>';
			}
			$html	.= ($total_nr > 0 and $pag != '' and ! $getReplies) ? VGenerate::simpleDivWrap('row wdmax left-float comm-pag', '', $pag) : NULL;
		}
		$html		.= !$getReplies ? VGenerate::declareJS('var tt = ' . $ttotal_nr . '; if(tt < 10){$("#total-comm-nr").parent().addClass("no-display");}else{$("#total-comm-nr").html("' . $ttotal_nr . '");}') : null;

		return $html;
	}

	/* see all comments (on separate page) */
	function seeAllComments_OFF() {
		$cfg		= self::$cfg;
		$db		= self::$db;
		$class_database = self::$dbc;
		$class_filter	= self::$filter;
		$language	= self::$language;
		$type		= self::$type;

		$mod		= $type == 'doc' ? 'document' : $type;

		if ($cfg[$mod . "_module"] == 0)
			return false;

		$f_key		= self::$file_key;
		$vuid		= $class_database->singleFieldValue('db_' . $type . 'files', 'usr_id', 'file_key', $f_key);
		$sql		= sprintf("SELECT 
					A.`c_usr_id`, B.`usr_key`, B.`usr_user`, D.`file_title`, D.`thumb_server` 
					FROM `db_%scomments` A, `db_accountuser` B, `db_%sfiles` D 
					WHERE 
					A.`file_key`='%s' 
					AND A.`file_key`=D.`file_key` 
					AND A.`file_key`=E.`file_key` 
					AND (B.`usr_id`=A.`c_usr_id` OR A.`c_usr_id`='') 
					AND B.`usr_id`='%s' 
					LIMIT 1;", $type, $type, $f_key, $vuid);

		$res		= $db->execute($sql);
		
		if ($res->fields["c_usr_id"] == '') {
			$sql	= sprintf("SELECT 
				    B.`usr_key` , B.`usr_user` , D.`file_title`, D.`thumb_server` 
				    FROM `db_accountuser` B, `db_%sfiles` D, 
				    WHERE 
				    D.`file_key`='%s' 
				    AND B.`usr_id`=D.`usr_id` 
				    AND B.`usr_id`='%s' 
				    LIMIT 1", $type, $f_key, $vuid);
			$res	= $db->execute($sql);
		}

		$usr_key	= $res->fields["usr_key"];

		if ($res->fields["comments"] == 'none' or $usr_key == '')
			return VGenerate::noticeTpl('', $language["notif.error.invalid.request"], '');

		$thumb_server	= $res->fields["thumb_server"];
		$f_title	= $res->fields["file_title"];

		$rhtml		= '
				<div class="page_holder">
					<div id="title-wrapper">
						' . $f_title . '
						<div class="line"></div>
					</div>
					<div class="video_player_holder_comments">
						<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $f_key, $res->fields["file_title"]) . '" rel="nofollow"><img alt="' . $f_title . '" src="' . VBrowse::thumbnail($usr_key, $f_key, $thumb_server) . '" width="33%"></a>
						<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $f_key, $res->fields["file_title"]) . '" rel="nofollow"><img alt="' . $f_title . '" src="' . VBrowse::thumbnail($usr_key, $f_key, $thumb_server, 2) . '" width="33%"></a>
						<a href="' . $cfg["main_url"] . '/' . VGenerate::fileHref($type[0], $f_key, $res->fields["file_title"]) . '" rel="nofollow"><img alt="' . $f_title . '" src="' . VBrowse::thumbnail($usr_key, $f_key, $thumb_server, 3) . '" width="33%"></a>
					</div>
				</div>
		';

		$html		 = VGenerate::declareJS('var c_url = "on";');
		$html		.= VGenerate::simpleDivWrap('', '', VGenerate::advHTML(23));
		$html		.= VGenerate::simpleDivWrap('', '', $rhtml);
		$html		.= VGenerate::simpleDivWrap('', '', VGenerate::advHTML(24));
		$html		.= VGenerate::simpleDivWrap('', 'comment-load', VComments::commLayout($type, $vuid));


		return $html;
	}

	/* count comment spams */
	function spamCommentCount($type, $c_key) {
		$class_database = self::$dbc;

		$db_s		= $class_database->singleFieldValue('db_' . $type . 'comments', 'c_spam', 'c_key', $c_key);

		return $db_count = $db_s == '' ? 0 : count(unserialize($db_s));
	}

	/* list spam reports */
	function listSpamReports($c_key, $type) {
		$cfg		= self::$cfg;
		$class_database = self::$dbc;

		$i		= 0;
		$db_t		= 'db_' . $type . 'comments';
		$db_s		= $class_database->singleFieldValue($db_t, 'c_spam', 'c_key', $c_key);
		$db_arr		= unserialize($db_s);

		if (is_array($db_arr)) {
			foreach ($db_arr as $key => $val) {
				$i	= $i + 1;
				$usr	= VUserinfo::getUserName($key);
				$html  .= VGenerate::simpleDivWrap('left-float row bottom-border-dotted top-padding5', '', VGenerate::simpleDivWrap('left-float', '', $i . '.') . '<a class="left-float nodecoration font11" href="' . $cfg["main_url"] . '/' . VHref::getKey('user') . '/' . $usr . '">' . VUserinfo::truncateString($usr, 10) . '</a><span class="left-padding10 right-float">' . VUserinfo::timeRange($val) . '</span>');
			}
		}

		return $html;
	}

	/* votes from string */
	function calculateString($mathString) {
		$mathString	= trim($mathString);
		$mathString	= preg_replace('[^0-9\+-\*\/\(\) ]', '', $mathString);
		$compute	= create_function("", "return (" . $mathString . ");");

		return 0 + $compute();
	}

	/* check for consecutive comment limit */
	function commentCheck($type) {
		$db		= self::$db;
		$cfg		= self::$cfg;
		$class_filter	= self::$filter;

		$match		= 0;
		$file_key	= self::$user_id;
		$upage_id	= (int) $_SESSION["USER_ID"];
		$e_sql		= sprintf("SELECT `c_usr_id` FROM `db_%scomments` WHERE `file_key`='%s' AND `c_active`='1' ORDER BY `c_id` DESC LIMIT %s;", $type, $file_key, $cfg["fcc_limit"]);
		$chk		= self::$db_cache ? $db->CacheExecute($cfg['cache_view_comments_c_usr_id'], $e_sql) : $db->execute($e_sql);

		if ($chk) {
			while (!$chk->EOF) {
				if ($chk->fields["c_usr_id"] == $upage_id) {
					$match = $match + 1;
				}
				@$chk->MoveNext();
			}
		}

		return $match;
	}

	/* post comment on files */
	function postComment() {
		$class_database		= self::$dbc;
		$class_filter		= self::$filter;
		$cfg			= self::$cfg;
		$db			= self::$db;
		$language		= self::$language;
		$ch_cfg			= self::$ch_cfg;

		if ($cfg["channel_comments"] == 0)
			return false;

		$can_post		= 0;
		$type			= $class_filter->clr_str($_POST["comm_type"]);
		$file_key		= self::$user_id;
		$comment		= $class_filter->clr_str($_POST["file_comm_text"]);
		$comment_len		= strlen($comment);
		$upage_id		= (int) $_POST["comm_uid"];
		/* comment permissions */
		$fr_db			= $db->execute(sprintf("SELECT `ct_id` FROM `db_usercontacts` WHERE `usr_id`='%s' AND `ct_username`='%s' AND `ct_friend`='1' AND `ct_active`='1' LIMIT 1;", $upage_id, $_SESSION["USER_NAME"]));
		$am_fr			= ($fr_db->fields["ct_id"] > 0) ? 1 : 0;
		$am_fr			= ($_SESSION["USER_ID"] > 0 and $_SESSION["USER_ID"] == $upage_id) ? 1 : $am_fr;

		switch ($ch_cfg["ch_comm_perms"]) {
			case "free": $c_approved = 1;
				break;
			case "appr": $c_approved = 0;
				break;
			case "fronly":
			case "custom": $c_approved = $am_fr == 1 ? 1 : 0;
				break;
		}
		
		/* get block status */
		$is_bl			= VContacts::getBlockStatus($upage_id, $_SESSION["USER_NAME"]);
		/* check if blocked, but comments allowed */
		$bl_sub			= VContacts::getBlockCfg('bl_comments', $upage_id, $_SESSION["USER_NAME"]);
		/* determine if user can post */
		if ($_SESSION["USER_ID"] > 0 and ( $is_bl == 0 or ( $is_bl == 1 and $bl_sub == 0)))
			$can_post	= 1;
		/* comment checks */
		$error_message		= $can_post == 0 ? $language["notif.error.blocked.request"] : ((($comment_len < $cfg["comment_min_length"]) or ( $comment_len > $cfg["comment_max_length"])) ? $language["notif.error.invalid.request"] : ((self::commentCheck($type) >= $cfg["ucc_limit"]) ? $language["upage.text.comm.limit"] : NULL));
		/* add comment entry */
		if ($error_message == '') {
			$c_key		= VUserinfo::generateRandomString(10);
			$comm_arr	= array("file_key" => $upage_id,
			    "c_usr_id"	=> (int) $_SESSION["USER_ID"],
			    "c_key"	=> $c_key,
			    "c_body"	=> $comment,
			    "c_datetime" => date("Y-m-d H:i:s"),
			    "c_approved" => $c_approved
			);
			if ($_GET["do"] == 'comm-reply') {
				$comm_arr["c_replyto"] = $class_filter->clr_str($_POST["comm_reply"]);
			}
			$db_entry	= $class_database->doInsert('db_' . $type . 'comments', $comm_arr);
			$db_id		= $db->Insert_ID();
			$notice_message = $c_approved == 1 ? $language["notif.success.request"] : $language["upage.text.comm.posted.appr"];
			/* log comments */
			$log		= ($cfg["activity_logging"] == 1 and $action = new VActivity($_SESSION["USER_ID"])) ? $action->addTo('log_channelcomment', $type . ':' . $file_key . ':' . $c_key) : NULL;
			/* mailing */
			if ($class_database->singleFieldValue('db_accountuser', 'usr_mail_chancomment', 'usr_id', $upage_id) == 1) {
				$mail_do = VNotify::queInit('channel_comment', array(VUserinfo::getUserEmail($upage_id)), $db_id);
			}
			if ($_GET["do"] == 'comm-reply') {
                                $mail_do = VNotify::queInit('channel_comment_reply', array(VUserinfo::getUserEmail($class_database->singleFieldValue('db_' . $type . 'comments', 'c_usr_id', 'c_key', $comm_arr["c_replyto"]))), $db_id);

                                $cu = $db->execute(sprintf("SELECT `c_usr_id` FROM `db_%scomments` WHERE `c_key`='%s' LIMIT 1;", $type, $class_database->singleFieldValue('db_' . $type . 'comments', 'c_replyto', 'c_key', $comm_arr["c_replyto"])));
                                if ($cu->fields["c_usr_id"] > 0) {
                                        $ci = $db->execute(sprintf("SELECT `c_usr_id` FROM `db_%scomments` WHERE `file_key`='%s' AND `c_replyto`='' LIMIT 1;", $type, $file_key));
                                        if ($ci->fields["c_usr_id"] > 0) {
                                                $mail_do = VNotify::queInit('channel_comment_reply', array(VUserinfo::getUserEmail($ci->fields["c_usr_id"])), $db_id);
                                        }
                                }
                        }
		}
		return VChannelComments::commLayout($type, $upage_id, array($notice_message, $error_message));
	}

	/* comment actions (when viewing files) */
	function commentActions($act) {
		$class_filter	= self::$filter;
		$db		= self::$db;
		$cfg		= self::$cfg;

		$type		= $class_filter->clr_str($_POST["comm_type"]);
		$c_key		= $class_filter->clr_str($_POST["c_key"]);

		switch ($act) {
			case "comm-suspend":
			case "comm-approve": $sql = sprintf("UPDATE `db_%scomments` SET `c_approved`='%s' WHERE `c_key`='%s' LIMIT 1;", $type, ($act == 'comm-approve' ? '1' : '0'), $c_key);
				break;
			case "comm-delete": $sql = sprintf("DELETE FROM `db_%scomments` WHERE `c_key`='%s' LIMIT 1;", $type, $c_key);
				break;
			case "comm-spam":
			case "comm-like":
			case "comm-dislike":
				$t_str	= null;
				$c_uid	= intval($_SESSION["USER_ID"]);
				$c_arr	= array();
				$db_c	= $db->execute(sprintf("SELECT `%s` FROM `db_%scomments` WHERE `c_key`='%s' AND `c_active`='1' LIMIT 1;", ($act == 'comm-spam' ? 'c_spam' : 'c_rating'), $type, $c_key));
				$c_spam = $db_c->fields[($act == 'comm-spam' ? 'c_spam' : 'c_rating')];

				if ($c_spam != '') {
					$c_arr = unserialize($c_spam);
					if ($c_arr[$c_uid] == '') {
						$c_arr[$c_uid] = $act == 'comm-spam' ? date("Y-m-d H:i:s") : ($act == 'comm-like' ? '+1' : '-1');
					}
				} else {
					$c_arr[$c_uid] = $act == 'comm-spam' ? date("Y-m-d H:i:s") : ($act == 'comm-like' ? '+1' : '-1');
				}
				if ($act == 'comm-like' or $act == 'comm-dislike') {
					$add	= null;
					//$c_rate = unserialize($c_arr);
					foreach ($c_arr as $k => $v) {
						$add .= $v;
					}
					$t_rate = self::calculateString($add);
					$t_str	= sprintf(", `c_rating_value`='%s'", $t_rate);
				}
				
				$c_db = $db->execute(sprintf("UPDATE `db_%scomments` SET `%s`='%s' %s WHERE `c_key`='%s' LIMIT 1;", $type, ($act == 'comm-spam' ? 'c_spam' : 'c_rating'), serialize($c_arr), $t_str, $c_key));
				break;
		}

		$db->execute($sql);
		if ($db->Affected_Rows() > 0) {
			if ($act == 'comm-delete') {
			}
			if ($cfg["activity_logging"] == 1) {
				if ($act == 'comm-approve') {
					$db->execute("UPDATE `db_useractivity` SET `act_deleted`='0' WHERE `act_type` LIKE '%" . $c_key . "%';");
				} elseif ($act == 'comm-suspend' or $act == 'comm-delete') {
					$db->execute("UPDATE `db_useractivity` SET `act_deleted`='1' WHERE `act_type` LIKE '%" . $c_key . "%';");
				}
			}
		}

		return self::browseComment();
	}

	/* browsing comments */
	function browseComment() {
		$class_filter	= self::$filter;

		$type		= $class_filter->clr_str($_POST["comm_type"]);
		$upage_id	= intval($_POST["comm_uid"]);

		return VChannelComments::commLayout($type, $upage_id);
	}

}
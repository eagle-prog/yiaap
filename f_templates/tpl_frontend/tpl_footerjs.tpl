        <script type="text/javascript">var base='{$main_url}/';var _rel="{$main_url}/{$c_section}";var current_url=base;var menu_section='{$c_section}';</script>
        <script type="text/javascript" src="{$javascript_url}/modernizr.custom.63321.js"></script>
        <script type="text/javascript" src="{$javascript_url}/breakpoints.js"></script>
        <script type="text/javascript" src="{$javascript_url}/breakpoint-binds.js"></script>
        <script type="text/javascript" src="{$javascript_url}/responsive-menu.js"></script>
        <script type="text/javascript" src="{$javascript_url}/classie.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.cookie.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.easing.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.loadmask.js"></script>
        <script type="text/javascript" src="{$javascript_url}/fwtabs.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/lightbox/jquery.fancybox.js"></script>
        <script type="text/javascript" src="{$javascript_url}/menu-parse.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/multilevelmenu/js/jquery.dlmenu.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/autocomplete/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="{$javascript_url_be}/tip.js"></script>
	<script type="text/javascript" src="{$javascript_url}/jquery.truncator.js"></script>
	<script type="text/javascript" src="{$javascript_url}/ytmenu.js"></script>
	<script type="text/javascript" src="{$javascript_url}/jquery.custom-scrollbar.js"></script>
	<script type="text/javascript" src="{$javascript_url}/jquery.custom-scrollbar.init.js"></script>

        <script type="text/javascript">var jslang = new Array();jslang["lss"] = '{if $smarty.session.USER_ID gt 0}1{else}0{/if}';jslang["loading"] = '{lang_entry key="frontend.global.loading"}';jslang["inwatchlist"] = '{lang_entry key="files.menu.watch.in"}';jslang["nowatchlist"] = '{lang_entry key="files.menu.watch.login"}';jslang["showmore"]='{lang_entry key="main.text.show.more"}';jslang["showless"]='{lang_entry key="main.text.show.less"}';</script>

{if $page_display eq "tpl_browse" or $page_display eq "tpl_index" or $page_display eq "tpl_view" or $page_display eq "tpl_files" or $page_display eq "tpl_channels" or ($page_display eq "tpl_search" and ($smarty.get.tf eq 6 or $smarty.get.tf eq 7)) or $page_display eq "tpl_playlists" or $page_display eq "tpl_blogs" or ($page_display eq "tpl_channel" and ($channel_module eq {href_entry key="broadcasts"} or $channel_module eq {href_entry key="videos"} or $channel_module eq {href_entry key="images"} or $channel_module eq {href_entry key="audios"} or $channel_module eq {href_entry key="documents"} or $channel_module eq {href_entry key="playlists"} or $channel_module eq {href_entry key="blogs"})) or $page_display eq "tpl_subs" or $page_display eq "tpl_search"}
	<script type="text/javascript" src="{$scripts_url}/shared/linkify/linkify.init.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.hoverIntent.min.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.dcaccordion.min.js"></script>
        {if $page_display eq "tpl_browse" or $page_display eq "tpl_channels" or $page_display eq "tpl_blogs" or $page_display eq "tpl_view" or $page_display eq "tpl_index"}
        <script type="text/javascript" src="{$javascript_url}/jquery.dcaccordion.browse.init.js"></script>
        {else}
        <script type="text/javascript" src="{$javascript_url}/jquery.dcaccordion.init.js"></script>
        {/if}
        {if $page_display ne "tpl_index" and $page_display ne "tpl_view"}
        <script type="text/javascript" src="{$javascript_url}/zepto.min.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.lazy.min.js"></script>
        {/if}
{/if}

{if $page_display eq "tpl_browse" or $page_display eq "tpl_blogs" or ($page_display eq "tpl_search" and ($smarty.get.tf eq "" or $smarty.get.tf eq "1" or $smarty.get.tf eq "2" or $smarty.get.tf eq "3" or $smarty.get.tf eq "4" or $smarty.get.tf eq "7" or $smarty.get.tf eq "8")) or ($page_display eq "tpl_channel" and ($channel_module eq {href_entry key="broadcasts"} or $channel_module eq {href_entry key="videos"} or $channel_module eq {href_entry key="images"} or $channel_module eq {href_entry key="audios"} or $channel_module eq {href_entry key="documents"} or $channel_module eq {href_entry key="blogs"}))}
	<script type="text/javascript" src="{$javascript_url}/fwtabs.init.js"></script>
        <script type="text/javascript" src="{$javascript_url}/browse.init.js"></script>
{elseif $page_display eq "tpl_channels" or ($page_display eq "tpl_search" and $smarty.get.tf eq 6)}
	<script type="text/javascript" src="{$javascript_url}/fwtabs.channels.init.js"></script>
	<script type="text/javascript" src="{$javascript_url}/channels.init.js"></script>
{elseif $page_display eq "tpl_files" or ($page_display eq "tpl_search" and $smarty.get.tf eq "5") or $page_display eq "tpl_playlists" or $page_display eq "tpl_subs" or ($page_display eq "tpl_channel" and $channel_module eq {href_entry key="playlists"})}
	<script type="text/javascript" src="{$javascript_url}/fwtabs.files.init.js"></script>
	<script type="text/javascript" src="{$javascript_url}/files.init.js"></script>
{/if}
        
{if $page_display eq "tpl_files_edit" or $page_display eq "tpl_files" or $page_display eq "tpl_subs"}
	<script type="text/javascript">
		var f_lang = new Array();
		f_lang["add_new"] = '{lang_entry key="files.menu.add.new"}';
		f_lang["l"] = '{lang_entry key="frontend.global.l.c"}';
                f_lang["v"] = '{lang_entry key="frontend.global.v.c"}';
		f_lang["i"] = '{lang_entry key="frontend.global.i.c"}';
		f_lang["a"] = '{lang_entry key="frontend.global.a.c"}';
		f_lang["d"] = '{lang_entry key="frontend.global.d.c"}';
		f_lang["b"] = '{lang_entry key="frontend.global.b.c"}';
		f_lang["upload"] = '{$main_url}/{href_entry key="upload"}';
	</script>
{/if}

{if $page_display eq "tpl_upload" and $error_message eq ""}
	<script type="text/javascript">
        var upload_lang = new Array();
            upload_lang["h1"] = '{lang_entry key="upload.text.h1.select"}';
            upload_lang["h2"] = '{lang_entry key="upload.text.h2.select"}';
            upload_lang["category"] = '{lang_entry key="upload.text.categ"}';
            upload_lang["username"] = '{lang_entry key="upload.text.user"}';
            upload_lang["assign"] = '{lang_entry key="upload.text.assign.tip"}';
            upload_lang["tip"] = '{lang_entry key="upload.text.categ.tip"}';
            upload_lang["utip"] = '{lang_entry key="upload.text.user.tip"}';
            upload_lang["filename"] = '{lang_entry key="upload.text.filename"}';
            upload_lang["size"] = '{lang_entry key="upload.text.size"}';
            upload_lang["status"] = '{lang_entry key="upload.text.status"}';
            upload_lang["drag"] = '{lang_entry key="upload.text.drag"}';
            upload_lang["select"] = '{lang_entry key="upload.text.select"}';
            upload_lang["start"] = '{lang_entry key="upload.text.btn.start"}';
        </script>
	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
        <script type="text/javascript" src="{$javascript_url}/uploader/plupload.full.min.js"></script>
        <script type="text/javascript" src="{$javascript_url}/uploader/jquery.plupload.queue/jquery.plupload.queue.js"></script>
        {include file="tpl_frontend/tpl_file/tpl_uploadjs.tpl"}
{/if}

{if $page_display eq "tpl_import"}
	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/grabber/grabber.js"></script>
        <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
{/if}

{if $page_display eq "tpl_account" or $page_display eq "tpl_files_edit"}
	<script type="text/javascript" src="{$scripts_url}/shared/jquery.form.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {ldelim}
        	$('.uinfo-entry').mouseover(function(){ldelim}$(this).addClass("y-bg");{rdelim}).mouseout(function(){ldelim}$(this).removeClass("y-bg");{rdelim});
        	
        	url = {if $page_display eq "tpl_account"}current_url + menu_section + '?s=account-menu-entry1&do=loading'{else}'{$main_url}/{$c_section}?fe=1&{$file_type}={$file_key}&do=thumb'{/if};
            	$(".thumb-popup").fancybox({ldelim} type: "ajax", margin: 20, minWidth: "70%", href: url, height: "auto", autoHeight: "true", autoResize: "true", autoCenter: "true" {rdelim});
        {rdelim});
        </script>
{/if}

{if $page_display eq "tpl_view"}
	<script type="text/javascript">var _rel = "{$main_url}/{href_entry key="files"}";</script>
	<script type="text/javascript" src="{$javascript_url}/owl.min.js"></script>
        <script type="text/javascript" src="{$javascript_url}/zepto.min.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="{$javascript_url}/jquery.dcaccordion.min.js"></script>
	<script type="text/javascript" src="{$javascript_url}/jquery.jscroll.min.js"></script>
	<script type="text/javascript" src="{$javascript_url}/fwtabs.view.init.js"></script>
	<script type="text/javascript" src="{$javascript_url}/view.init.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/linkify/linkify.init.js"></script>
{if $comment_emoji eq 1}
        <script src="https://cdn.jsdelivr.net/npm/emojione@4.0.0/lib/js/emojione.min.js"></script>
{/if}
	{if $smarty.get.l ne ""}
	{if $is_mobile}
	<script src="{$scripts_url}/shared/nosleep.min.js"></script>
	<script>
		var noSleep = new NoSleep();
		function enableNoSleep(){ldelim}noSleep.enable();document.removeEventListener('click',enableNoSleep,false);{rdelim}
		document.addEventListener('click', enableNoSleep, false);
	</script>
	{/if}
	<script type="text/javascript" src="{$scripts_url}/shared/iframe.min.js"></script>
	<script>
		$(document).ready(function(){ldelim}
		var h = window.innerHeight-100
		if (h > 940) h = 940
		var iframe = iFrameResize({ldelim}log:false, autoResize:true, heightCalculationMethod: 'min', maxHeight: h, minHeight: h, scrolling: false, enablePublicMethods: true{rdelim}, '#vs-chat');
		{rdelim});
		$(window).on("resize", function(){ldelim}
		var h = window.innerHeight-100
		if (h > 940) h = 940
		iFrameResize({ldelim}log:false, autoResize:true, heightCalculationMethod: 'min', maxHeight: h, minHeight: h, scrolling: false, enablePublicMethods: true{rdelim}, '#vs-chat');
		{rdelim});
	</script>
	{/if}
	<script type="text/javascript">
		{literal}
		$(document).ready(function(){$('div.showSingle-lb').on('click', function(e){t=$(this);s=t.attr('target');$.fancybox.open({href  : '#div-'+s,type : 'inline',opts : {afterShow : function( instance, current ) {}},margin: 0, minWidth:'50%',maxWidth:'90%',maxHeight:'100%'});});});
		{/literal}
	</script>
{/if}

{if $smarty.session.USER_ID gt 0 and ($page_display eq "tpl_view" or $page_display eq "tpl_channel" or $page_display eq "tpl_channels" or $page_display eq "tpl_index")}
	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script>
		$(document).on("click", ".unsubscribe-button", function() {ldelim}
			var cd = "{$smarty.session.USER_KEY}";
		{if $page_display eq "tpl_view"}
			var cc = "{$usr_key}"; act_url = current_url + menu_section + "?{$file_type[0]}={$file_key}&do=unsub-option";
		{elseif $page_display eq "tpl_index" or $page_display eq "tpl_channels"}
			var cc = $(this).attr("rel-usr"); act_url = "?do=unsub-option&u="+cc;
		{else}
			var cc = "{$channel_key}"; act_url = "?a=&do=unsub-option";
		{/if}
			if (cc !== cd) $.fancybox({ldelim} type: "ajax", minWidth: "80%", minHeight: "50%", margin: 20, href: act_url {rdelim});
		{rdelim});

		$(document).on("click", ".subscribe-button", function() {ldelim}
			var cd = "{$smarty.session.USER_KEY}";
		{if $page_display eq "tpl_view"}
			var cc = "{$usr_key}"; act_url = current_url + menu_section + "?{$file_type[0]}={$file_key}&do=sub-option";
		{elseif $page_display eq "tpl_index" or $page_display eq "tpl_channels"}
			var cc = $(this).attr("rel-usr"); act_url = "?do=sub-option&u="+$(this).attr("rel-usr");
		{else}
			var cc = "{$channel_key}"; act_url = "?a=&do=sub-option";
		{/if}
			if (cc !== cd) $.fancybox({ldelim} type: "ajax", minWidth: "80%", minHeight: "50%", margin: 20, href: act_url {rdelim});
		{rdelim});
	</script>
{/if}

{if (($page_display eq "tpl_view") and ($smarty.get.v ne "" or $smarty.get.a ne "" or $smarty.get.l ne ""))}
	{if (($smarty.get.v ne "" or $smarty.get.l ne "") and $video_player eq "vjs" and ($embed_src eq "local" or $embed_src eq "youtube")) or ($smarty.get.a ne "" and $audio_player eq "vjs")}
	<script src="https://vjs.zencdn.net/5.19/video.js"></script>
	<script>var logo="{$logo_file}";var logohref="{$logo_href}";</script>
	{if $vjs_advertising eq 1 and !$is_subbed}
	<script>var fk='{$file_key}';{if $ad_skip}var ad_skip='{$ad_skip}';{/if}var ad_client='{$ad_client}';var adTagUrl='{$ad_tag_url}';var compjs='{if $is_mobile}ads.mob{else}{if $ad_tag_comp eq "1"}ads.comp{else}ads{/if}{/if}';</script>
	{if $ad_client eq "ima" and $embed_src eq "local"}
	<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
	<script src="{$scripts_url}/shared/videojs/videojs.ads.js"></script>
	<script src="{$scripts_url}/shared/videojs/videojs.ima.js"></script>
	{elseif $ad_client eq "vmap" and $embed_src eq "local"}
	<script src="{$scripts_url}/shared/videojs/videojs.ads.js"></script>
	<script src="{$scripts_url}/shared/videojs/vast-client.js"></script>
	<script src="{$scripts_url}/shared/videojs/vmap-client.js"></script>
	<script src="{$scripts_url}/shared/videojs/videojs-ad-scheduler.js"></script>
	<script src="{$scripts_url}/shared/videojs/ads.vmap.js"></script>
	{elseif $ad_client eq "vast" and $embed_src eq "local" and !$is_subbed}
	<script src="{$scripts_url}/shared/videojs/videojs_5.vast.vpaid.min.js"></script>
	<script src="{$scripts_url}/shared/videojs/ads.vast.js"></script>
	{/if}
	{/if}
	<script src="{$scripts_url}/shared/videojs/videojs-scripts.js"></script>
	<script src="https://cdn.streamroot.io/videojs-hlsjs-plugin/1/stable/videojs-hlsjs-plugin.js"></script>
	{else}
        <script type="text/javascript" src="{$scripts_url}/shared/{if ($video_player eq "jw" and $smarty.get.v ne "") or ($audio_player eq "jw" and $smarty.get.a ne "")}jwplayer{else}flowplayer{/if}/{if ($video_player eq "jw" and $smarty.get.v ne "") or ($audio_player eq "jw" and $smarty.get.a ne "")}jwplayer{else}flowplayer5{/if}.js"></script>
        {/if}
{/if}

{if $image_player eq "jq" and (($page_display eq "tpl_view" and $smarty.get.i ne "") or ($page_display eq "tpl_files_edit" and $smarty.get.i ne "")) or $page_display eq "tpl_files"}
	{if $page_display eq "tpl_files" and $file_playlists eq "1"}
	<script type="text/javascript">
	$(document).ready(function() {ldelim}
		new_pl_url = current_url + menu_section + '?s=file-menu-entry6&m=1&a=pl-new';
		$(".pl-popup").fancybox({ldelim} type: "ajax", minWidth: "80%", margin: 20, href: new_pl_url, height: "auto", autoHeight: "true", autoResize: "true", autoCenter: "true" {rdelim});

		$(document).on("click", ".plcfg-popup", function() {ldelim}
			cfg_pl_url = current_url + menu_section + '?s=' + $(".pl-entry.menu-panel-entry-active").attr("id") + '&m=1&a=pl-cfg';
			
			$.fancybox({ldelim} type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: cfg_pl_url {rdelim});
		{rdelim});
	{rdelim});
	</script>
	{/if}
{/if}

{if $page_display eq "tpl_view" and ($smarty.get.v ne "" or $smarty.get.l ne "")}
        <script type="text/javascript">
        {if $smarty.get.l ne ""}
        window.addEventListener('message',function(e){ldelim}if(e.origin!=="{$live_chat_server}")return;var task=e.data['task'];if(typeof task!='undefined'){ldelim}switch(task){ldelim}case 'showchat':$('#vs-chat-wrap iframe').css('display','block');$('#vs-chat-wrap i.spinner').detach();var th=$("body").hasClass("dark")?"th0":"th1";document.getElementById("vs-chat").contentWindow.postMessage({ldelim}"viz":th,"location":window.location.href{rdelim},"{$live_chat_server}");break;case 'disconnect':window.location='{$main_url}/{href_entry key="signout"}';break;{rdelim}{rdelim}{rdelim});
        {/if}

        {if $video_player eq "vjs" and ($embed_src eq "local" or $embed_src eq "youtube")}{insert name=getVJSJS usr_key=$usr_key file_key=$file_key file_hd=$hd next=$next pl_key=$pl_key}
        {elseif $video_player eq "jw" and $embed_src eq "local"}{insert name=getJWJS usr_key=$usr_key file_key=$file_key file_hd=$hd next=$next pl_key=$pl_key}
        {elseif $video_player eq "flow" and $embed_src eq "local"}{insert name=getFPJS usr_key=$usr_key file_key=$file_key file_hd=$hd next=$next pl_key=$pl_key}
        {/if}</script>
{elseif ($page_display eq "tpl_view" and $smarty.get.i ne "")}
        <script type="text/javascript">{insert name=getImageJS pl_key=$smarty.get.p|sanitize}</script>
{elseif $page_display eq "tpl_view" and $smarty.get.a ne ""}
        <script type="text/javascript">
        {if $audio_player eq "vjs"}{insert name=getVJSJS usr_key=$usr_key file_key=$file_key file_hd=$hd next=$next pl_key=$pl_key}
        {elseif $audio_player eq "jw"}{insert name=getJWJS usr_key=$usr_key file_key=$file_key file_hd=0 next=$next pl_key=$pl_key}
        {elseif $audio_player eq "flow"}{insert name=getFPJS usr_key=$usr_key file_key=$file_key file_hd=0 next=$next pl_key=$pl_key}
        {/if}</script>
{elseif $page_display eq "tpl_view" and $smarty.get.d ne ""}
        <script type="text/javascript">{insert name=getDOCJS usr_key=$usr_key file_key=$file_key file_hd=0 next=$next pl_key=$pl_key}</script>
{/if}

{if $page_display eq "tpl_files_edit" or $page_display eq "tpl_respond"}
	<script type="text/javascript" src="{$scripts_url}/shared/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">var _u = current_url + menu_section + '?fe=1&{$file_type}={$file_key}';{if $live_module eq "1"}var lm=1;{/if}{if $video_module eq "1"}var vm=1;{/if}{if $image_module eq "1"}var im=1;{/if}{if $audio_module eq "1"}var am=1;{/if}{if $document_module eq "1"}var dm=1;{/if}</script>
	<script type="text/javascript" src="{$javascript_url}/tinymce.init.js"></script>
{/if}

{if $page_display eq "tpl_respond" or $page_display eq "tpl_files_edit"}
	<script type="text/javascript" src="{$javascript_url}/fwtabs.view.init.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
{/if}

{if $page_display eq "tpl_account" or ($page_display eq "tpl_index" and $smarty.session.USER_ID gt 0)}
	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
{/if}

{if $page_display eq "tpl_files" or $page_display eq "tpl_messages" or $page_display eq "tpl_subs"}
	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
	<script type="text/javascript" src="{$javascript_url}/jquery.sortable.js"></script>
{/if}

{if $page_display eq "tpl_index"}
	<script type="text/javascript">var _rel = "{$main_url}/{href_entry key="files"}";</script>
	<script type="text/javascript" src="{$javascript_url}/owl.min.js"></script>
        <script type="text/javascript" src="{$javascript_url}/zepto.min.js"></script>
        <script type="text/javascript" src="{$javascript_url}/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="{$javascript_url}/jquery.jscroll.home.init.js"></script>
	<script type="text/javascript" src="{$javascript_url}/home.init.js"></script>
{/if}

{if $page_display eq "tpl_channel"}
	<script type="text/javascript" src="{$scripts_url}/shared/linkify/linkify.init.js"></script>
	<script type="text/javascript" src="{$javascript_url}/channel.init.js"></script>
{if $comment_emoji eq 1 and $channel_module eq {href_entry key="discussion"}}
        <script src="https://cdn.jsdelivr.net/npm/emojione@4.0.0/lib/js/emojione.min.js"></script>
{/if}
{/if}

{if $page_display eq "tpl_signin" or $page_display eq "tpl_signup" or $page_display eq "tpl_recovery" or $page_display eq "tpl_payment"}
	{if $paid_memberships eq "1" and ($page_display eq "tpl_payment" or $page_display eq "tpl_signup")}
		<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
		<script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
		<script type="text/javascript">
			$(function() {ldelim}
				SelectList.init("frontend_membership_type_sel");
				SelectList.init("pk_period_sel");
			{rdelim});
		</script>
	{/if}
	{if $page_display eq "tpl_signup"}
	<script type="text/javascript" src="{$javascript_url_be}/jquery.password.js"></script>
	{if ($fb_auth eq "1" and $smarty.session.fb_user['id'] gt 0) or ($gp_auth eq "1" and $smarty.session.gp_user['id'] gt 0)}
		<script type="text/javascript">$(document).ready(function() {ldelim}$("a#inline").fancybox({ldelim} minWidth: "80%",  margin: 20 {rdelim});$('#inline').trigger('click');{rdelim});</script>
	{/if}
	<script type="text/javascript">{include file="tpl_frontend/tpl_auth/tpl_oauthjs.tpl"}</script>
	{/if}

	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script type="text/javascript" src="{$javascript_url_be}/login.js"></script>
	<script type="text/javascript" src="{$javascript_url}/login.init.js"></script>
	<script type="text/javascript">var full_url = '{$main_url}/';var main_url = '{$main_url}/';

	{if $page_display eq "tpl_recovery" or $page_display eq "tpl_signup"}
		$(".login-page .tabs ul li:first").removeClass("tab-current");
	{/if}
	</script>
{/if}

{if $page_display eq "tpl_search"}
	<script type="text/javascript">var q = "{$smarty.get.q|sanitize}";var current_url=base;var menu_section='{if ($smarty.get.tf eq 5 or $smarty.get.tf eq 7)}{href_entry key="files"}{else}{href_entry key="search"}{/if}'; var search_menu_section='{href_entry key="search"}';</script>
	<script type="text/javascript" src="{$javascript_url}/search.init.js"></script>
{/if}

{if $page_display eq "tpl_subs" or $page_display eq "tpl_index"}
	<script type="text/javascript">
		$(document).ready(function() {ldelim}
			$("a#inline").fancybox({ldelim} minWidth: "80%",  margin: 20 {rdelim});
			$(".menu-panel-entry-active").click(function(event){ldelim}
				if ($('#session-accordion li:first').hasClass('menu-panel-entry-active')) {ldelim}
					var _url = current_url + menu_section + "?cfg";
					$.fancybox({ldelim} type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: _url {rdelim});
				{rdelim}
			{rdelim});
		{rdelim});
	</script>
{/if}

{if $page_display eq "tpl_manage_channel"}
	<script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/jquery.form.js"></script>
	<script type="text/javascript" src="{$scripts_url}/shared/cropper/cropper.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {ldelim}
			$(document).on("click", ".cr-popup", function() {ldelim}
				crop_url = current_url + menu_section + "?s=channel-menu-entry3&do=edit-crop&t=" + $(this).attr("rel-photo").substr(0, 10);

				$.fancybox({ldelim} type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: crop_url {rdelim});
			{rdelim});
			$(document).on("click", ".gcr-popup", function() {ldelim}
				crop_url = current_url + menu_section + "?s=channel-menu-entry3&do=edit-gcrop&t=" + $(this).attr("rel-photo").substr(0, 10);

				$.fancybox({ldelim} type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: crop_url {rdelim});
			{rdelim});
			
			$(document).on("click", ".del-popup", function() {ldelim}
				crop_url = current_url + menu_section + "?s=channel-menu-entry3&do=delete-crop&t=" + $(this).attr("rel-photo").substr(0, 10);

				$.fancybox({ldelim} type: "ajax", minWidth: "80%", minHeight: "80%", margin: 20, href: crop_url {rdelim});
			{rdelim});
		{rdelim});
	</script>
	{if $smarty.get.r}
	<script type="text/javascript">
		(function () {
			[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {
				new CBPFWTabs(el);
			});
		})();
		$(document).ready(function() {ldelim}
			$(".tabs ul li#l2").click();
		{rdelim});
	</script>
	{/if}
{/if}

{if ($page_display eq "tpl_affiliate" and $smarty.session.USER_AFFILIATE eq 1) or ($page_display eq "tpl_subscribers" and $smarty.session.USER_PARTNER eq 1)}
        <script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/datepicker/tiny-date-picker.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/datepicker/date-range-picker.js"></script>
        {if $page_display eq "tpl_affiliate"}
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={$affiliate_maps_api_key}" type="text/javascript"></script>
        {literal}<script type="text/javascript">(function () {[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {new CBPFWTabs(el);});})();</script>{/literal}
        {/if}
        {if $page_display eq "tpl_subscribers" and $smarty.get.rp ne ""}
        	{literal}<script type="text/javascript">(function () {[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {new CBPFWTabs(el);});})();</script>{/literal}
        {elseif $page_display eq "tpl_subscribers" and $smarty.get.rg ne ""}
        	<script type="text/javascript" src="{$javascript_url_be}/jsapi.js"></script>
        	<script type="text/javascript" src="{$modules_url_be}/m_tools/m_gasp/dash/Chart.min.js"></script>
        	<script type="text/javascript" src="{$modules_url_be}/m_tools/m_gasp/dash/moment.min.js"></script>
        	<script type="text/javascript">
            var ecount = new Array; var scount = new Array; var tcount = new Array;

            var twcount = new Array;
            twcount["total"] = 0;
            twcount["shared"] = {$twshared};
            twcount["earned"] = 0;
            var lwcount = new Array;
            lwcount["total"] = 0;
            lwcount["shared"] = {$lwshared};
            lwcount["earned"] = 0;
            var tw1 = {$tw2};var sw1 = {$sw2};var ew1 = {$ew2};var tw2 = {$tw1};var sw2 = {$sw1};var ew2 = {$ew1};var lws = {$lws};var tws = {$tws};

            $(document).ready(function () {ldelim}
                $('.icheck-box input').each(function () {ldelim}
                        var self = $(this);
                        self.iCheck({ldelim}
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                //insert: '<div class="icheck_line-icon"></div><label>' + label_text + '</label>'
                        {rdelim});
                {rdelim});
                $(".icheck-box").toggleClass("no-display");
                $(".filters-loading").addClass("no-display");
        {rdelim});

        </script>
	<script type="text/javascript" src="{$javascript_url}/subdashboard.js"></script>

        {/if}
{/if}
	<script type="text/javascript" src="{$javascript_url}/jquery.init.js"></script>
        <script type="text/javascript">function init() {ldelim}window.addEventListener('scroll', function (e) {ldelim}var distanceY = window.pageYOffset || document.documentElement.scrollTop,shrinkOn = 0,header = document.querySelector("header");if (distanceY > shrinkOn) {ldelim}classie.add(header, "smaller");{rdelim} else {ldelim}if (classie.has(header, "smaller")) {ldelim}classie.remove(header, "smaller");{rdelim}{rdelim}{rdelim});{rdelim}window.onload = init();</script>
        <script type="text/javascript">$(document).ready(function() {ldelim}$("#search").keydown(function(){ldelim}$("#search").autocomplete({ldelim}type: "post",params: {ldelim}"t": "{if $video_module eq 1}video{elseif $live_module eq 1}live{elseif $image_module eq 1}image{elseif $audio_module eq 1}audio{elseif $document_module eq 1}doc{/if}" {rdelim},serviceUrl: current_url + "{href_entry key="search"}" +"?do=autocomplete",onSearchStart: function() {ldelim}{rdelim},onSelect: function (suggestion) {ldelim}$(".sb-search-submit").trigger("click");{rdelim}{rdelim});{rdelim});{rdelim});</script>
{if $comment_emoji eq 1}
        <script type="text/javascript">$(document).ready(function(){ldelim}
        var s=document.createElement("script");
        s.type="text/javascript";
        s.src="https://cdn.jsdelivr.net/npm/emojione@4.0.0/lib/js/emojione.min.js";
        s.addEventListener('load',function(e){ldelim}
                {if ($page_display eq "tpl_channel" and $channel_module eq "")}lem();{/if}
                {if $page_display eq "tpl_files" and $smarty.get.s eq ""}
                        {literal}var tc = $(".cr-tabs .msg-body pre").length; $(".cr-tabs .msg-body pre").each(function(index,value){var t=$(this);var c=t.text();var nc=emojione.toImage(c);t.html(nc);if(index===tc-1){$(".spinner.icon-spinner").hide();$(".cr-tabs .msg-body pre").show()}});{/literal}
                {/if}
        {rdelim},false);
        document.head.appendChild(s);
        {rdelim});</script>
{/if}

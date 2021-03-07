{if (($page_display eq "tpl_view") and ($smarty.get.v ne "" or $smarty.get.a ne "" or $smarty.get.l ne ""))}
	{if (($smarty.get.v ne "" or $smarty.get.l ne "") and $video_player eq "vjs" and ($embed_src eq "local" or $embed_src eq "youtube")) or ($smarty.get.a ne "" and $audio_player eq "vjs")}
	<script src="https://vjs.zencdn.net/5.19/video.min.js"></script>
	<script>var logo="{$logo_file}";var logohref="{$logo_href}";</script>
	{if $vjs_advertising eq 1 and !$is_subbed}
	<script>var fk='{$file_key}';{if $ad_skip}var ad_skip='{$ad_skip}';{/if}var ad_client='{$ad_client}';var adTagUrl='{$ad_tag_url}';var compjs='{if $is_mobile}ads.mob{else}{if $ad_tag_comp eq "1"}ads.comp{else}ads{/if}{/if}';</script>
	{if $ad_client eq "ima" and $embed_src eq "local"}
	<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
	<script src="{$scripts_url}/shared/videojs/min/ima.min.js"></script>
	{elseif $ad_client eq "vast" and $embed_src eq "local" and !$is_subbed}
	<script src="{$scripts_url}/shared/videojs/min/videojs_5.vast.vpaid.min.js"></script>
	{/if}
	{/if}
	<script src="{$scripts_url}/shared/videojs/videojs-scripts.min.js"></script>
	{if $smarty.get.l ne ""}
	<script src="{$scripts_url}/shared/videojs/videojs-hlsjs-plugin.js"></script>
        <script src="{$scripts_url}/shared/nosleep.min.js"></script>
        <script>
        	{if $is_mobile}var noSleep = new NoSleep();function enableNoSleep(){ldelim}noSleep.enable();document.removeEventListener('click',enableNoSleep,false);{rdelim}document.addEventListener('click', enableNoSleep, false);{/if}
        	window.addEventListener('message',function(e){ldelim}if(e.origin!=="{$live_chat_server}")return;var task=e.data['task'];if(typeof task!='undefined'){ldelim}switch(task){ldelim}case 'fixedchat':$('.inner-block.with-menu').addClass('pfixedoff');break;case 'nofixedchat':$('.inner-block.with-menu').removeClass('pfixedoff');$("html,body").animate({ldelim}scrollTop:0{rdelim},"fast");break;case 'showchat':$('#vs-chat-wrap iframe').css('display','block');$('#vs-chat-wrap i.spinner').detach();var th=$("body").hasClass("dark")?"th0":"th1";document.getElementById("vs-chat").contentWindow.postMessage({ldelim}"viz":th,"location":window.location.href{rdelim},"{$live_chat_server}");break;case 'disconnect':window.location='{$main_url}/{href_entry key="signout"}';break;{rdelim}{rdelim}{rdelim});
        </script>
	{/if}
	{else}
        <script type="text/javascript" src="{$scripts_url}/shared/{if ($video_player eq "jw" and $smarty.get.v ne "") or ($audio_player eq "jw" and $smarty.get.a ne "")}jwplayer{else}flowplayer{/if}/{if ($video_player eq "jw" and $smarty.get.v ne "") or ($audio_player eq "jw" and $smarty.get.a ne "")}jwplayer{else}flowplayer5{/if}.js"></script>
        {/if}
{/if}
{if $page_display eq "tpl_view" and ($smarty.get.v ne "" or $smarty.get.l ne "")}
        <script type="text/javascript">
        {if $video_player eq "vjs" and ($embed_src eq "local" or $embed_src eq "youtube")}{insert name=getVJSJS usr_key=$usr_key file_key=$file_key file_hd=$hd next=$next pl_key=$pl_key}
        {elseif $video_player eq "jw" and $embed_src eq "local"}{insert name=getJWJS usr_key=$usr_key file_key=$file_key file_hd=$hd next=$next pl_key=$pl_key}
        {/if}</script>
{elseif ($page_display eq "tpl_view" and $smarty.get.i ne "")}
        <script type="text/javascript">{insert name=getImageJS pl_key=$smarty.get.p|sanitize}</script>
{elseif $page_display eq "tpl_view" and $smarty.get.a ne ""}
        <script type="text/javascript">
        {if $audio_player eq "vjs"}{insert name=getVJSJS usr_key=$usr_key file_key=$file_key file_hd=$hd next=$next pl_key=$pl_key}
        {elseif $audio_player eq "jw"}{insert name=getJWJS usr_key=$usr_key file_key=$file_key file_hd=0 next=$next pl_key=$pl_key}
        {/if}</script>
{elseif $page_display eq "tpl_view" and $smarty.get.d ne ""}
        <script type="text/javascript">{insert name=getDOCJS usr_key=$usr_key file_key=$file_key file_hd=0 next=$next pl_key=$pl_key}</script>
{/if}
	<script type="text/javascript">{literal}$(document).ready(function(){$('div.showSingle-lb').on('click',function(e){mw='50%';t=$(this);s=t.attr('target');switch(s){case 'report':mw='70%';break;};$.fancybox.open({href:'#div-'+s,type:'inline',afterLoad:function(){$('.tooltip').hide()},opts:{onComplete:function(){}},margin:0,minWidth:'50%',maxWidth:'95%',maxHeight:'90%'});});});{/literal}</script>

    <body class="fe media-width-768 is-fw{if $page_display eq "tpl_files_edit"} tpl_files_edit{elseif $page_display eq "tpl_subs"} tpl_files{/if}{if $theme_name|strpos:'dark'===0} dark{/if}">
        <div id="wrapper" class="{$page_display}{if $page_display ne "tpl_files" and $page_display ne "tpl_index"} tpl_files{/if}{if $page_display eq "tpl_channels"} tpl_browse{/if}{if $page_display eq "tpl_tokens"} tpl_subscribers{/if}{if $smarty.session.sbm eq 0} g5{/if}">
            {include file="tpl_frontend/tpl_header/tpl_headernav_yt.tpl"}
            <div class="spacer"></div>
            {include file="tpl_frontend/tpl_body_main.tpl"}
            <div class="push"></div>
        </div>
        {include file="tpl_frontend/tpl_footer.tpl"}{include file="tpl_frontend/tpl_footerjs_min.tpl"}
    </body>
{if $page_display eq "tpl_view" and $smarty.get.l ne "" and $is_live eq 1}<script type="text/javascript">var int=self.setInterval(lv,60000);function lv(){ldelim}if(typeof player!=="undefined" && player.currentTime() > 0 && !player.paused() && !player.ended()){ldelim}var u="{$main_url}/{href_entry key="viewers"}?s={$file_key}";$.get(u,function(){ldelim}{rdelim});{rdelim}{rdelim}</script>{/if}
{if $google_analytics ne ""}
    <script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', '{$google_analytics}']);_gaq.push(['_trackPageview']);(function(){ldelim}var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);{rdelim})();</script>
{/if}
{if $page_display eq "tpl_view" and $affiliate_module eq 1 and $affiliate_tracking_id ne "UA-" and $usr_key != $smarty.session.USER_KEY}
    <script>(function(i,s,o,g,r,a,m){ldelim}i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ldelim}(i[r].q=i[r].q||[]).push(arguments){rdelim},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m){rdelim})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');function gainit(){ldelim}ga('create','{$affiliate_tracking_id}','auto');ga('set','dimension1','{$usr_key}');ga('set','dimension2','{$file_type}');ga('set','dimension3','{$file_key}');ga('send',{ldelim}hitType:'pageview',page:location.pathname,title:'{$file_title|escape:'dec'}'{rdelim});{rdelim}{if $file_type eq "video" or $file_type eq "live" or $file_type eq "audio"}if(typeof player!=="undefined"){ldelim}player.on('timeupdate',function(){ldelim}if(player.currentTime()>5&&player.currentTime()<5.2&&typeof($(".vjs-ads-label").html())=="undefined"){ldelim}gainit();{rdelim}{rdelim});{rdelim}{else}gainit();{/if}</script>
{/if}
</html>
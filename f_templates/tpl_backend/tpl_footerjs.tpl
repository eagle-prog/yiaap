        <script type="text/javascript" src="{$javascript_url_be}/modernizr.custom.js"></script>
        <script type="text/javascript" src="{$javascript_url_be}/common.js"></script>
{if $smarty.session.ADMIN_NAME ne ""}
        <script type="text/javascript" src="{$javascript_url_be}/init.js"></script>
        <script type="text/javascript" src='{$javascript_url_be}/jquery.cookie.js'></script>
        <script type="text/javascript" src='{$javascript_url_be}/jquery.hoverIntent.minified.js'></script>
        <script type="text/javascript" src='{$javascript_url_be}/jquery.dcjqaccordion.2.7.min.js'></script>
        <script type="text/javascript" src="{$javascript_url_be}/jquery.highlight.js"></script>
        <script type="text/javascript" src="{$javascript_url_be}/jquery.form.js"></script>
        <script type="text/javascript" src="{$javascript_url_be}/menu-parse.js"></script>
{/if}
        <script>
            var section = '{$page_display}';
{if $page_display eq "backend_tpl_analytics"}
            {literal}
            (function(w,d,s,g,js,fs){
              g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
              js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
              js.src='https://apis.google.com/js/platform.js';
              fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
            }(window,document,'script'));
            {/literal}
{/if}
        </script>
{if $page_display eq "backend_tpl_dashboard" or ($page_display eq "backend_tpl_subscriber" and $smarty.get.rg eq "1")}
        <script type="text/javascript" src="{$javascript_url_be}/jsapi.js"></script>
{/if}
{if $page_display eq "backend_tpl_dashboard" or $page_display eq "backend_tpl_analytics" or ($page_display eq "backend_tpl_subscriber" and $smarty.get.rg eq "1")}
        <script type="text/javascript" src="{$modules_url_be}/m_tools/m_gasp/dash/Chart.min.js"></script>
        <script type="text/javascript" src="{$modules_url_be}/m_tools/m_gasp/dash/moment.min.js"></script>
{/if}
{if $page_display eq "backend_tpl_analytics"}
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={ldelim}'modules':[{ldelim}'name':'visualization','version':'1.1','packages':['geochart']{rdelim}]{rdelim}"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key={$google_analytics_maps}" type="text/javascript"></script>
        <script type="text/javascript" src="{$modules_url_be}/m_tools/m_gasp/dash/view-selector2.js"></script>
        <script type="text/javascript" src="{$modules_url_be}/m_tools/m_gasp/dash/date-range-selector.js"></script>
        <script type="text/javascript" src="{$modules_url_be}/m_tools/m_gasp/dash/active-users.js"></script>
{/if}
{if $page_display eq "backend_tpl_dashboard"}
        <script type="text/javascript">
            var lcount = new Array; var vcount = new Array; var icount = new Array; var acount = new Array; var dcount = new Array; var bcount = new Array;var this_week_live = '{$this_week_live}';var this_week_video = '{$this_week_video}';var this_week_image = '{$this_week_image}';var this_week_audio = '{$this_week_audio}';var this_week_doc = '{$this_week_doc}';var this_week_blog = '{$this_week_blog}';var last_week_live = '{$last_week_live}';var last_week_video = '{$last_week_video}';var last_week_image = '{$last_week_image}';var last_week_audio = '{$last_week_audio}';var last_week_doc = '{$last_week_doc}';var last_week_blog = '{$last_week_blog}';var this_week_users = '{$this_week_users}';var last_week_users = '{$last_week_users}';var this_year_earnings = '{$this_year_earnings}';var last_year_earnings = '{$last_year_earnings}';lcount["total"] = '{$lcount[0]}';lcount["active"] = '{$lcount[1]}';lcount["inactive"] = '{$lcount[2]}';lcount["pending"] = '{$lcount[3]}';lcount["flagged"] = '{$lcount[4]}';lcount["featured"] = '{$lcount[5]}';lcount["public"] = '{$lcount[6]}';lcount["private"] = '{$lcount[7]}';lcount["personal"] = '{$lcount[8]}';lcount["mob"] = '{$lcount[9]}';lcount["hd"] = '{$lcount[10]}';lcount["embed"] = '{$lcount[11]}';lcount["promoted"] = '{$lcount[12]}';vcount["total"] = '{$vcount[0]}';vcount["active"] = '{$vcount[1]}';vcount["inactive"] = '{$vcount[2]}';vcount["pending"] = '{$vcount[3]}';vcount["flagged"] = '{$vcount[4]}';vcount["featured"] = '{$vcount[5]}';vcount["public"] = '{$vcount[6]}';vcount["private"] = '{$vcount[7]}';vcount["personal"] = '{$vcount[8]}';vcount["mob"] = '{$vcount[9]}';vcount["hd"] = '{$vcount[10]}';vcount["embed"] = '{$vcount[11]}';vcount["promoted"] = '{$vcount[12]}';icount["total"] = '{$icount[0]}';icount["active"] = '{$icount[1]}';icount["inactive"] = '{$icount[2]}';icount["pending"] = '{$icount[3]}';icount["flagged"] = '{$icount[4]}';icount["featured"] = '{$icount[5]}';icount["public"] = '{$icount[6]}';icount["private"] = '{$icount[7]}';icount["personal"] = '{$icount[8]}';icount["mob"] = '{$icount[9]}';icount["promoted"] = '{$icount[10]}';acount["total"] = '{$acount[0]}';acount["active"] = '{$acount[1]}';acount["inactive"] = '{$acount[2]}';acount["pending"] = '{$acount[3]}';acount["flagged"] = '{$acount[4]}';acount["featured"] = '{$acount[5]}';acount["public"] = '{$acount[6]}';acount["private"] = '{$acount[7]}';acount["personal"] = '{$acount[8]}';acount["mob"] = '{$acount[9]}';acount["promoted"] = '{$acount[10]}';dcount["total"] = '{$dcount[0]}';dcount["active"] = '{$dcount[1]}';dcount["inactive"] = '{$dcount[2]}';dcount["pending"] = '{$dcount[3]}';dcount["flagged"] = '{$dcount[4]}';dcount["featured"] = '{$dcount[5]}';dcount["public"] = '{$dcount[6]}';dcount["private"] = '{$dcount[7]}';dcount["personal"] = '{$dcount[8]}';dcount["mob"] = '{$dcount[9]}';dcount["promoted"] = '{$dcount[10]}';bcount["total"] = '{$bcount[0]}';bcount["active"] = '{$bcount[1]}';bcount["inactive"] = '{$bcount[2]}';bcount["pending"] = '{$bcount[3]}';bcount["flagged"] = '{$bcount[4]}';bcount["featured"] = '{$bcount[5]}';bcount["public"] = '{$bcount[6]}';bcount["private"] = '{$bcount[7]}';bcount["personal"] = '{$bcount[8]}';bcount["mob"] = '{$bcount[9]}';bcount["promoted"] = '{$bcount[10]}';
        </script>
        <script type="text/javascript" src="{$javascript_url_be}/dashboard.js"></script>
{elseif $page_display eq "backend_tpl_subscriber" and $smarty.get.rg eq "1"}
        <script type="text/javascript">
            var ecount = new Array; var scount = new Array; var tcount = new Array;

            var twcount = new Array;
            twcount["total"] = {$twtotal};
            twcount["shared"] = {$twshared};
            twcount["earned"] = {$twearned};
            var lwcount = new Array;
            lwcount["total"] = {$lwtotal};
            lwcount["shared"] = {$lwshared};
            lwcount["earned"] = {$lwearned};

            var tw1 = {$tw2};var sw1 = {$sw2};var ew1 = {$ew2};var tw2 = {$tw1};var sw2 = {$sw1};var ew2 = {$ew1};var lws = {$lws};var tws = {$tws};
        </script>
	<script type="text/javascript" src="{$javascript_url_be}/subdashboard.js"></script>
{elseif $page_display eq "backend_tpl_analytics"}
	<script type="text/javascript">
		var gapi_client_id='{$google_analytics_api}';
		var gapi_view_id='{$google_analytics_view}';
	</script>
        <script type="text/javascript" src="{$javascript_url_be}/analytics-graph.js"></script>
{/if}

        <script type="text/javascript">
            var current_url  = '{$main_url}/{$backend_access_url}/';
            var menu_section = '{href_entry getKey="be_settings"}';
        </script>

	<script type="text/javascript" src="{$javascript_url_be}/classie.js"></script>
        <script type="text/javascript" src="{$javascript_url_be}/jquery.loadmask.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/icheck/icheck.js"></script>
{if $smarty.get.rg eq 0}
        <script type="text/javascript" src="{$javascript_url_be}/fwtabs.js"></script>
        <script type="text/javascript" src="{$javascript_url_be}/fwtabs.init.js"></script>
{/if}
{if $smarty.session.ADMIN_NAME eq ""}
        <script type="text/javascript" src="{$javascript_url_be}/jquery.password.js"></script>
        <script type="text/javascript">
            var full_url = '{$main_url}/{if $global_section eq "backend"}{$backend_access_url}/{/if}';
            var main_url = '{$main_url}/';
        </script>
	<script type="text/javascript" src="{$javascript_url_be}/login.js"></script>
	<script type="text/javascript" src="{$javascript_url}/login.init.js"></script>
{/if}
{if $smarty.session.ADMIN_NAME ne ""}
	<script type="text/javascript" src="{$javascript_url_be}/gnmenu.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/select.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/lightbox/jquery.fancybox.js"></script>
        <script type="text/javascript" src="{$javascript_url_be}/jquery.nouislider.all.min.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/multilevelmenu/js/jquery.dlmenu.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/autocomplete/jquery.autocomplete.js"></script>
{if $video_player eq "jw" or $audio_player eq "jw"}
        <script type="text/javascript" src="{$scripts_url}/shared/jwplayer/jwplayer.js"></script>
{/if}

{if $video_player eq "vjs" or $audio_player eq "vjs"}
	<script src="https://vjs.zencdn.net/5.19/video.min.js"></script>
	<script src="{$scripts_url}/shared/videojs/videojs-scripts.js"></script>
	<script src="https://cdn.streamroot.io/videojs-hlsjs-plugin/1/stable/videojs-hlsjs-plugin.js"></script>
{/if}

{/if}
{if $page_display eq "backend_tpl_dashboard" or ($page_display eq "backend_tpl_subscriber" and $smarty.get.rg eq "1")}
	<script type="text/javascript">
	$(document).ready(function () {ldelim}
                $('.icheck-box input').each(function () {ldelim}
                        var self = $(this);
                        self.iCheck({ldelim}
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        {rdelim});
                {rdelim});
                $(".icheck-box").toggleClass("no-display");
                $(".filters-loading").addClass("no-display");
        {rdelim});
        </script>
{/if}
{if $smarty.session.ADMIN_NAME ne ""}
        <script>
            new gnMenu(document.getElementById('gn-menu'));
        </script>

        <script type="text/javascript">
            var menuLeft = document.getElementById('cbp-spmenu-s1'),
                    menuBottom = document.getElementById('cbp-spmenu-s4'),
                    showLeftPush = document.getElementById('showLeftPush'),
                    body = document.body;

            showBottom.onclick = function () {
                classie.toggle(this, 'active');
                classie.toggle(menuBottom, 'cbp-spmenu-open');
                disableOther('showBottom');
            };
            showLeftPush.onclick = function () {
                classie.toggle(this, 'active');
                classie.toggle(body, 'cbp-spmenu-push-toright');
                classie.toggle(menuLeft, 'cbp-spmenu-open');
                disableOther('showLeftPush');
                jQuery(window).resize();
            };

            function disableOther(button) {
                if (button !== 'showBottom') {
                    classie.toggle(showBottom, 'disabled');
                }
                if (button !== 'showLeftPush') {
                    classie.toggle(showLeftPush, 'disabled');
                }
            }
        </script>
        {include file="tpl_backend/tpl_menupaneljs.tpl"}
{/if}
{if $page_display eq "backend_tpl_upload"}
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
	<script type="text/javascript" src="{$javascript_url}/uploader/plupload.full.min.js"></script>
	<script type="text/javascript" src="{$javascript_url}/uploader/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	{include file="tpl_backend/tpl_uploadjs.tpl"}
{/if}
{if $page_display eq "backend_tpl_import"}
	<script src="{$scripts_url}/shared/grabber/grabber.js"></script>
	<script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
{/if}
{if $page_display eq "backend_tpl_affiliate" or $page_display eq "backend_tpl_subscriber"}
        <script type="text/javascript" src="{$scripts_url}/shared/datepicker/tiny-date-picker.js"></script>
        <script type="text/javascript" src="{$scripts_url}/shared/datepicker/date-range-picker.js"></script>
        {if $page_display eq "backend_tpl_affiliate"}
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={$affiliate_maps_api_key}" type="text/javascript"></script>
        {/if}
{/if}
	<script src="{$javascript_url_be}/tip.js"></script>
	<script type="text/javascript">
		$(document).on("click", ".messages_holder", function() {ldelim}
			notif_url = '{$backend_url}/{href_entry key="be_dashboard"}?s=notif';
			$.fancybox({ldelim} type: "ajax", minWidth: "90%", minHeight: "75%", margin: 20, href: notif_url, wrapCSS: "notifications" {rdelim});
		{rdelim});
		$(document).ready(function() {ldelim}
			$("#new-notifications-nr").load('{$backend_url}/{href_entry key="be_dashboard"}?s=new');
		{rdelim});
	</script>

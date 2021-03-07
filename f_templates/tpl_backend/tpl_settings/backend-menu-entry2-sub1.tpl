	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div>
		<div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    {generate_html bullet_id="ct-bullet4" input_type="text" entry_title="backend.menu.entry2.sub4.shortname" entry_id="ct-entry-details4" input_name="backend_menu_entry2_sub4_shortname" input_value=$website_shortname bb=1}
	    {generate_html bullet_id="ct-bullet1" input_type="text" entry_title="backend.menu.entry2.sub1.headtitle" entry_id="ct-entry-details1" input_name="backend_menu_entry2_sub1_headtitle" input_value=$head_title bb=1}
	    {generate_html bullet_id="ct-bullet2" input_type="textarea" entry_title="backend.menu.entry2.sub1.metadesc" entry_id="ct-entry-details2" input_name="backend_menu_entry2_sub1_metadesc" input_value=$metaname_description bb=1}
	    {generate_html bullet_id="ct-bullet3" input_type="textarea" entry_title="backend.menu.entry2.sub1.metakeywords" entry_id="ct-entry-details3" input_name="backend_menu_entry2_sub1_metakeywords" input_value=$metaname_keywords bb=1}
	    {generate_html bullet_id="ct-bullet5" input_type="text" entry_title="backend.menu.entry2.sub1.google.an" entry_id="ct-entry-details5" input_name="backend_menu_entry2_sub1_google_an" input_value=$google_analytics bb=1}
	    {generate_html bullet_id="ct-bullet9" input_type="text" entry_title="backend.menu.entry2.sub1.google.an.api" entry_id="ct-entry-details9" input_name="backend_menu_entry2_sub1_google_an_api" input_value=$google_analytics_api bb=1}
	    {generate_html bullet_id="ct-bullet13" input_type="text" entry_title="backend.menu.entry2.sub1.google.an.view" entry_id="ct-entry-details13" input_name="backend_menu_entry2_sub1_google_an_view" input_value=$google_analytics_view bb=1}
	    {generate_html bullet_id="ct-bullet14" input_type="text" entry_title="backend.menu.entry2.sub1.google.an.maps" entry_id="ct-entry-details14" input_name="backend_menu_entry2_sub1_google_an_maps" input_value=$google_analytics_maps bb=1}
	    </div>
	    <div class="vs-column half fit vs-mask">
	    {generate_html bullet_id="ct-bullet6" input_type="text" entry_title="backend.menu.entry2.sub1.google.web" entry_id="ct-entry-details6" input_name="backend_menu_entry2_sub1_google_web" input_value=$google_webmaster bb=1}
	    {generate_html bullet_id="ct-bullet14" input_type="text" entry_title="backend.menu.entry2.sub1.tagline" entry_id="ct-entry-details14" input_name="backend_menu_entry2_sub1_tagline" input_value=$custom_tagline bb=0}
	    {generate_html bullet_id="ct-bullet7" input_type="text" entry_title="backend.menu.entry2.sub1.yahoo" entry_id="ct-entry-details7" input_name="backend_menu_entry2_sub1_yahoo" input_value=$yahoo_explorer bb=1}
	    {generate_html bullet_id="ct-bullet8" input_type="text" entry_title="backend.menu.entry2.sub1.bing" entry_id="ct-entry-details8" input_name="backend_menu_entry2_sub1_bing" input_value=$bing_validate bb=0}
	    {generate_html bullet_id="ct-bullet13" input_type="social_media_links" entry_title="backend.menu.entry2.sub1.sm.links" entry_id="ct-entry-details13" input_name="backend_menu_entry2_sub1_sm_links" input_value=$social_media_links bb=0}
	    {generate_html bullet_id="ct-bullet23" input_type="site_alert" entry_title="backend.menu.entry2.sub1.alert" entry_id="ct-entry-details23" input_name="" input_value=$alert_description bb=0}
	    {generate_html bullet_id="ct-bullet24" input_type="dynamic_menu" entry_title="backend.menu.entry2.sub1.dynamic.menu" entry_id="ct-entry-details24" input_name="backend_menu_entry2_sub1_dynamic_menu" input_value=$dynamic_menu bb=0}
	    </div>
	    <div class="clearfix"></div>
	    <div>
		<div class="sortings left-half">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-keep-open.tpl"}</div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	{include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
        <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
        <script type="text/javascript">{literal}$(document).ready(function(){$("a.sml-add").click(function(){lid=document.getElementById("url-entry-details-list").childElementCount;lid+=1;nht=sm_ht.replace(/#NR#/g,lid).replace(/#V1#/g, '').replace(/#V2#/g, '').replace(/#V3#/g, '');$("#url-entry-details-list").append(nht);}); $("a.dml-add").click(function(){lid=document.getElementById("url-entry-menu-list").childElementCount;lid+=1;nht=dm_ht.replace(/#NR#/g,lid).replace(/#V1#/g, '').replace(/#V2#/g, '').replace(/#V3#/g, '');$("#url-entry-menu-list").append(nht);});});{/literal}</script>

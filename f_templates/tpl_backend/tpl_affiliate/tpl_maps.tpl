<link rel="stylesheet" type="text/css" href="{$styles_url_be}/affiliate.css">
<!--<link rel="stylesheet" type="text/css" href="{$styles_url}/custom.css">-->
<link rel="stylesheet" href="{$scripts_url}/shared/countryselect/css/countrySelect.css">
<style id="be-affiliate-style">
.u-chart {ldelim}width:100%;min-height:400px;{rdelim}
#video_table_sort_div.u-chart,#image_table_sort_div.u-chart,#audio_table_sort_div.u-chart,#document_table_sort_div.u-chart,#blog_table_sort_div.u-chart {ldelim}min-height:auto;{rdelim}
.u-chart g text{ldelim}font-size:14px;font-family:Ubuntu;line-height:50px;stroke-width:0px;{rdelim}
.google-visualization-table-table td, .google-visualization-table-th {ldelim}font-family:Ubuntu;{rdelim}
.dark .gapi-analytics-data-chart .google-visualization-table-table {ldelim} background: #232323; color: #ccc; {rdelim}
.dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-odd, .dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-even {ldelim} background: #232323; border-top: 1px solid #111; {rdelim}
.dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-over {ldelim} background: #131313; border-top: 1px solid #111; {rdelim}
.dark .country-select .country-list {ldelim}background:#131313;{rdelim}
.dark .country-select .country-list .country.highlight{ldelim}background:#343434;{rdelim}
h3.content-filter{ldelim}width:10%;color:#888;font-size:14px;{rdelim}
.content-filters li{ldelim}float:left;font-size:14px;margin-left:10px;{rdelim}
.content-filters i{ldelim}font-size:11px;{rdelim}
.content-filters a, .load-info i{ldelim}color:#888;{rdelim}
.filter-text{ldelim}font-size:14px;font-weight:normal;margin-left:10px;padding:10px 0;display:inline-block{rdelim}
.content-filters {ldelim}vertical-align:middle;display:inline-block;line-height:47px;{rdelim}
.content-filters.continent-filters{ldelim}vertical-align:super;line-height:1.2;{rdelim}
.country-select{ldelim}vertical-align:top;{rdelim}
#country-region-form{ldelim}position: absolute;z-index:99;background: rgb(245, 245, 245);{rdelim}
#country-region-form input{ldelim}border: 0;background: rgb(245, 245, 245);color: #505050{rdelim}
#entry-action-buttons2 span{ldelim}min-width:230px;font-size: 14px;margin:0;padding: 2px 7px;margin-top:3px;background: rgb(245, 245, 245);color:#000;{rdelim}
#entry-action-buttons2.dl-menuwrapper li.dl-back:after, #entry-action-buttons2.dl-menuwrapper li > a:not(:only-child):after {ldelim}line-height:24px;{rdelim}
#entry-action-buttons2.dl-menuwrapper.dl-menuwrapper > .dl-submenu {ldelim}width:25%;{rdelim}
#entry-action-buttons2.dl-menuwrapper ul {ldelim}background:#ddd;min-width:230px;{rdelim}
#entry-action-buttons2.dl-menuwrapper{ldelim}margin-top:-3px;{rdelim}
.gapi-analytics-data-chart-styles-table-td{ldelim}font-size:14px !important;{rdelim}
h3.content-title{ldelim}width: 40%;{rdelim}
.view-mode-filters{ldelim}margin-right: 10px;{rdelim}
.tfb{ldelim}font-weight: bold !important;{rdelim}
.sb-search-input{ldelim}border:0;{rdelim}
svg > g:last-child > g:last-child {ldelim}pointer-events: none;{rdelim}
#country-search-dots, #continent-search-dots{ldelim}float: right; display: inline-block; width: 30px;{rdelim}
#continent-search-dots{ldelim}margin-top: 19px;{rdelim}
#country-search-dots{ldelim}margin-top: 5px;{rdelim}
.load-info{ldelim}float: right;display: inline-block;width: 20px;margin-top: 7px;{rdelim}
.loadmask-msg div:before{ldelim}font-size: 14px;{rdelim}
#view-limits input{ldelim}max-width: 50px; padding: 0 5px;margin-bottom: 0; height: 32px; margin-right: 10px; margin-top: 7px;{rdelim}
#time-sort-filters{ldelim}margin-bottom:25px;{rdelim}
.toggle-all-filters {ldelim}display: inline-block;margin-top: 20px;margin-right: 15px;cursor:pointer;display: none;{rdelim}
#search-boxes{ldelim}float:right{rdelim}
.be .dl-menuwrapper li.dl-back:after, .be .dl-menuwrapper li > a:not(:only-child):after{ldelim}top:initial;{rdelim}
{literal}@media (max-width:1310px){#search-boxes{width: 100%; display: inline-block; margin-top:-7px; margin-bottom:3px; float: none;}}{/literal}
{literal}@media (max-width:960px){#lb-wrapper .rep-wrap{display: block; width: 100%;margin-top: -20px;}#lb-wrapper .greyed-out{margin-left: 30px;}}{/literal}
{literal}@media (max-width:920px){.sb-search-fe.sb-search-open{width: calc(100% - 20px)}#search-boxes .inner-search{width:100%}#sb-search-fe{margin-bottom:auto;}.inner-search,.search_holder_fe{width:auto}}{/literal}
{literal}@media (max-width:860px){.content-filters li{line-height:30px}#time-sort-filters h3.content-title.content-filter{display: none}#time-sort-filters section.filter{float: left;}.toggle-all-filters{display: block;}section.filter,section.inner-search,#search-boxes,section.action{display:none;}h3.content-title{width: 100%; display: inline-block;}#search-boxes{margin-top:0}a[rel-def-off="1"]{display:none;}}{/literal}
{literal}@media (max-width:470px){#sb-search-be{margin-right:10px}}{/literal}


{literal}@media (max-width:860px){a[rel-def-off="1"]{display:none;}}{/literal}
</style>
<script src="{$scripts_url}/shared/countryselect/js/countrySelect.min.js"></script>
{literal}
<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>
{/literal}

{$tpl_html}

<div class="vs-column half">
	<h3 class="content-title"><i class="icon-eye"></i>{lang_entry key="account.entry.views.continent"}</h3>
	<div id="continent-search-dots"></div>
	<div class="load-info" id="load-info-continent"><i class="icon-info" rel="tooltip" title="{lang_entry key="account.entry.maps.loading"}"></i></div>
	<div class="clearfix"></div>
	<div class="line" style="margin-bottom:0"></div>
	<div>
		<div id="continent-search-wrap" style="display: block;">{$tpl_continent_filters}</div>
		<div id="continent-search-load" style="max-width: 150px; position: absolute;">&nbsp;</div>
	</div>
	<div id="geo-container" class="u-chart"></div>
</div>

<div class="vs-column half fit">
	<h3 class="content-title"><i class="icon-eye"></i>{lang_entry key="account.entry.views.country"}</h3>
	<div id="country-search-dots">&nbsp;</div>
	<div class="load-info" id="load-info-country"><i class="icon-info" rel="tooltip" title="{lang_entry key="account.entry.maps.loading"}"></i></div>
	<div class="clearfix"></div>
	<div class="line" style="margin-bottom:0"></div>
	<div>
		<div id="country-search-wrap" style="display: block;">{include file="tpl_backend/tpl_affiliate/tpl_maps_countries.tpl"}</div>
		<div id="country-search-load" style="max-width: 150px; position: absolute;">&nbsp;</div>
	</div>
	<div id="country-container" class="u-chart"></div>
</div>

<div class="vs-column full">
	<div id="pagetitle-container" class="u-chart"></div>
</div>
<div class="clearfix"></div>


<script>

{include file="tpl_backend/tpl_affiliate/tpl_analytics_js.tpl"}

gapi.analytics.ready(function() {ldelim}
	var col_bg = $("body").hasClass("dark") ? "#232323" : "#fff"
        var col_lb = $("body").hasClass("dark") ? "#fff" : "#000"
	gapi.analytics.auth.authorize({ldelim}'serverAuth':{ldelim}'access_token':'{$tpl_token}'{rdelim}{rdelim});

	$("#continent-search-wrap").show();
	$("#continent-search-load").hide();
	$("#continent-search-load").unmask();

	$("#entry-action-buttons2").show();
	$("#entry-action-buttons2").dlmenu();


	$("#country_selector").countrySelect({ldelim}
                                defaultCountry: "{if $smarty.get.c ne ""}{$smarty.get.c|sanitize}{elseif $smarty.post.custom_country ne ""}{$smarty.post.custom_country|sanitize}{else}xx{/if}",
                                /*onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],*/
                                preferredCountries: ['xx', 'us', 'ca', 'gb']
                        {rdelim});
        $("#country-search-wrap").show(); $("#country-search-load").show(); $("#country-search-load").unmask();
	$("#country_selector").show();

	$("#country_selector").on("change", function() {ldelim}
		var countryData = $("#country_selector").countrySelect("getSelectedCountryData");
		var v = countryData.iso2 == 'xx' ? '' : countryData.iso2;
		$("#custom-country").val(v);
		var u = '{$backend_url}/{href_entry key="be_affiliate"}?{if $smarty.get.a ne ""}a={$smarty.get.a|sanitize}{elseif $smarty.get.g ne ""}g={$smarty.get.g|sanitize}{/if}&t='+$('.view-mode-type.active').attr('rel-t') + '&f=' + $('.content-filters li a.active').attr('rel-t') + '&c=' + countryData.iso2{if $smarty.get.r ne ""}+'&r={$smarty.get.r|sanitize}'{/if};
		u += '{if $smarty.get.fk ne ""}&fk={$smarty.get.fk|sanitize}{/if}';
		u += '{if $smarty.get.uk ne "" and $smarty.get.fk eq ""}&uk={$smarty.get.uk|sanitize}{/if}';

		if ($('.content-filters li a.active').attr('rel-t') == 'date' || $('.content-filters li a.active').attr('rel-t') == 'range') {ldelim}
			/*$("#custom-date-form").submit();*/
			$('#custom-date-form').attr('action', u).submit();
		{rdelim} else {ldelim}
			window.location = u;
		{rdelim}
	{rdelim});
	$("#country_selector").on("focus", function() {ldelim}
	$(this).select();
	{rdelim});




  var geo = new gapi.analytics.googleCharts.DataChart({ldelim}
    reportType: 'ga',
    query: {ldelim}
      'dimensions': 'ga:country',
      'metrics': 'ga:uniquePageviews,ga:users',
      'start-date': '{$sd}',
      'end-date': '{$ed}',
      'filters': '{if $user_filter|count_characters > 2}ga:dimension1=={$user_filter|sanitize};{/if}ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}',
     'ids': "ga:{$affiliate_view_id}"
    {rdelim},
    chart: {ldelim}
      type: 'GEO',
      container: 'geo-container',
      options:{ldelim}
      'zoomLevel': 9,
      'region':'{if $smarty.get.r ne ""}{$smarty.get.r|sanitize}{else}world{/if}',
        'showTooltip': true,
        'showInfoWindow': true,
        'useMapTypeControl': true,
        'enableScrollWheel':true,
/*       'displayMode': 'markers',*/
      	'width': '100%',
      	'chartArea':{ldelim}'width': '100%', 'height': '100%'{rdelim},
      	'fontName': 'Ubuntu',
      	'backgroundColor':col_bg,
        'legend':{ldelim}'position': 'top', 'textStyle': {ldelim}color: col_lb, 'fontSize': 16{rdelim}{rdelim},
      {rdelim}
    {rdelim}
  {rdelim});
  geo.execute();

geo.on("success", function() {ldelim}
	$("#continent-search-dots").unmask();
	$("#load-info-continent").hide();
{rdelim});


  var ct = new gapi.analytics.googleCharts.DataChart({ldelim}
    reportType: 'ga',
    query: {ldelim}
      'dimensions': 'ga:city',
/*     'metrics': 'ga:pageviews,ga:uniquePageviews',*/
      'metrics': 'ga:uniquePageviews,ga:users',
      'start-date': '{$sd}',
      'end-date': '{$ed}',
      'filters': '{if $user_filter|count_characters > 2}ga:dimension1=={$user_filter|sanitize};{/if}ga:dimension2=={$file_type}{if $smarty.get.c ne "" and $smarty.get.c ne "xx"};ga:countryIsoCode=={$smarty.get.c|sanitize|upper}{elseif $smarty.post.custom_country ne ""};ga:countryIsoCode=={$smarty.post.custom_country|sanitize|upper}{/if}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}',
     'ids': "ga:{$affiliate_view_id}"
    {rdelim},
    chart: {ldelim}
      type: 'GEO',
      container: 'country-container',
      options:{ldelim}
      'zoomLevel': 1,
        'showTooltip': true,
        'showInfoWindow': true,
        'useMapTypeControl': true,
        'enableScrollWheel': true,
        'enableRegionInteractivity': true,
        'displayMode': 'markers',
        {if ($smarty.get.c ne "" and $smarty.get.c ne "xx") or $smarty.post.custom_country ne ""}
      	'region': '{if $smarty.get.c ne "" and $smarty.get.c ne "xx"}{$smarty.get.c|sanitize|upper}{elseif $smarty.post.custom_country ne ""}{$smarty.post.custom_country|sanitize|upper}{else}US{/if}',
      	'resolution': 'provinces',
      	{/if}
      	'width': '100%',
      	'chartArea':{ldelim}'width': '100%', 'height': '100%'{rdelim},
      	'fontName': 'Ubuntu',
      	'backgroundColor':col_bg,
        'legend':{ldelim}'position': 'top', 'textStyle': {ldelim}color: col_lb, 'fontSize': 16{rdelim}{rdelim},
      {rdelim}
    {rdelim}
  {rdelim});
  ct.execute();

ct.on("success", function() {ldelim}
	$("#country-search-dots").unmask();
	$("#load-info-country").hide();
{rdelim});


var pagetitle = new gapi.analytics.googleCharts.DataChart({ldelim}
    reportType: 'ga',
    query: {ldelim}
      'dimensions': 'ga:pageTitle',
      'metrics': 'ga:users,ga:pageviews,ga:uniquePageviews',
      'start-date': '{$sd}',
      'end-date': '{$ed}',
      'filters': '{if $user_filter|count_characters > 2}ga:dimension1=={$user_filter|sanitize};{/if}ga:dimension2=={$file_type}{if $smarty.get.r ne "" and $smarty.get.r ne "world" and (($smarty.get.c eq "" or $smarty.get.c eq "xx") and $smarty.post.custom_country eq "")};ga:{if $smarty.get.r eq "002" or $smarty.get.r eq "019" or $smarty.get.r eq "142" or $smarty.get.r eq "150" or $smarty.get.r eq "009"}continentId{else}subContinentCode{/if}=={$smarty.get.r|sanitize}{elseif $smarty.get.c ne "" and $smarty.get.c ne "xx"};ga:countryIsoCode=={$smarty.get.c|sanitize|upper}{elseif $smarty.post.custom_country ne ""};ga:countryIsoCode=={$smarty.post.custom_country|sanitize|upper}{/if}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}',
     'ids': "ga:{$affiliate_view_id}",
/*    'max-results':2,*/
/*    'start-index':3*/
    {rdelim},
    chart: {ldelim}
      type: 'TABLE',
      container: 'pagetitle-container',
      options:{ldelim}
        'width': '100%',
        'sort':'enable',
        'chartArea':{ldelim}'width': '100%', 'height': '90%'{rdelim},
        'fontName': 'Ubuntu'
      {rdelim}
    {rdelim}
  {rdelim});

pagetitle.execute();

pagetitle.on("success", function(result) {ldelim}
	uv_t = result.response.totalsForAllResults['ga:uniquePageviews'];
	pv_t = result.response.totalsForAllResults['ga:pageviews'];
	us_t = result.response.totalsForAllResults['ga:users'];

	if ($('.google-visualization-table-table > tbody > tr:last').hasClass('gapi-analytics-data-chart-styles-table-tr-even')) {ldelim}
		trc = 'gapi-analytics-data-chart-styles-table-tr-odd';
	{rdelim} else {ldelim}
		trc = 'gapi-analytics-data-chart-styles-table-tr-even';
	{rdelim}
	tdnr = 'gapi-analytics-data-chart-styles-table-td google-visualization-table-td-number tfb';
	tdc = 'gapi-analytics-data-chart-styles-table-td tfb';

	$('.google-visualization-table-table tbody').append('<tr class="'+trc+'"><td class="'+tdc+'">{lang_entry key="account.entry.tbl.total"}</td><td class="'+tdnr+'">'+us_t+'</td><td class="'+tdnr+'">'+pv_t+'</td><td class="'+tdnr+'">'+uv_t+'</td></tr>');

	$('.google-visualization-table-table th').click(function() {ldelim}
		$('.google-visualization-table-table tbody').append('<tr class="'+trc+'"><td class="'+tdc+'">{lang_entry key="account.entry.tbl.total"}</td><td class="'+tdnr+'">'+us_t+'</td><td class="'+tdnr+'">'+pv_t+'</td><td class="'+tdnr+'">'+uv_t+'</td></tr>');
	{rdelim});
{rdelim});

window.addEventListener('orientationchange', doOnOrientationChange);
function doOnOrientationChange(){ldelim}geo.execute();ct.execute();pagetitle.execute();{rdelim}

/*var width=$(window).width(),height=$(window).height();
window.onresize = function(){ldelim}if($(window).width()!=width&&$(window).height()!=height){ldelim}geo.execute();ct.execute();pagetitle.execute();{rdelim}{rdelim};*/

{rdelim});
</script>
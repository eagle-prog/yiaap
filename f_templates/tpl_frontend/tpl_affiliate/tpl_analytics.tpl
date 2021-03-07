<style>
.u-chart {ldelim}width:100%;min-height:400px;{rdelim}
#video_table_sort_div.u-chart,#image_table_sort_div.u-chart,#audio_table_sort_div.u-chart,#document_table_sort_div.u-chart,#blog_table_sort_div.u-chart {ldelim}min-height:auto;{rdelim}
.u-chart g text{ldelim}font-size:14px;font-family:Ubuntu;line-height:50px;{rdelim}
.google-visualization-table-table td, .google-visualization-table-th {ldelim}font-family:Ubuntu;{rdelim}
.dark .gapi-analytics-data-chart .google-visualization-table-table { background: #232323; color: #ccc; }
.dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-odd, .dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-even { background: #232323; border-top: 1px solid #444; }
.dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-over { background: #131313; border-top: 1px solid #444; }
h3.content-filter{ldelim}width:10%;color:#888;font-size:14px;{rdelim}
.content-filters li{ldelim}float:left;font-size:14px;margin-left:10px;line-height:47px{rdelim}
.content-filters i{ldelim}font-size:11px;{rdelim}
.filter-text{ldelim}font-size:14px;font-weight:normal;margin-left:0px;padding:10px 0;display:inline-block{rdelim}
.content-filters {ldelim}vertical-align: middle;display: inline-block;line-height:47px;{rdelim}
.gapi-analytics-data-chart-styles-table-td{ldelim}font-size:14px !important;{rdelim}
h3.content-title{ldelim}width: 40%;{rdelim}
.view-mode-filters{ldelim}margin-right: 10px;{rdelim}
.tfb{ldelim}font-weight: bold !important;{rdelim}
.sb-search-input{ldelim}border:0;{rdelim}
svg > g:last-child > g:last-child {ldelim}pointer-events: none;{rdelim}
.toggle-all-filters {ldelim}display: inline-block;margin-top: 20px;margin-right: 0px !important;cursor:pointer;display: none;width:30px;text-align:right{rdelim}
#time-sort-filters{ldelim}border-bottom: 1px solid #f0f0f0;{rdelim}
#search-boxes{ldelim}float:right{rdelim}
{literal}@media (max-width:1310px){#sb-search-fe{margin-right:0;}#search-boxes{width: 100%; display: inline-block; margin-top:-7px; margin-bottom:3px; float: none;}}{/literal}
{literal}@media (max-width:960px){#lb-wrapper .rep-wrap{display: block; width: 100%;margin-top: -20px;}#lb-wrapper .greyed-out{margin-left: 30px;}}{/literal}
{literal}@media (max-width:920px){#search-boxes .inner-search{width:67%}#sb-search-fe{margin-bottom:auto;}.inner-search{width:auto}}{/literal}
{literal}@media (max-width:860px){#time-sort-filters h3.content-title.content-filter{display: none}#time-sort-filters section.filter{float: left;}.toggle-all-filters{display: block;}section.filter,section.inner-search,#search-boxes{display:none;}h3.content-title{width: 100% !important; display: inline-block;}#search-boxes{margin-top:0}a[rel-def-off="1"]{display:none;}}{/literal}
{literal}@media (max-width:470px){#sb-search-be{margin-right:10px}}{/literal}
{literal}@media (max-width:375px){#search-boxes .inner-search{width:50%}}{/literal}
#view-limits input{ldelim}max-width: 50px; padding: 0 5px;margin-bottom: 0; height: 32px; margin-left: 10px; margin-top: 7px;{rdelim}
</style>

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
<div class="vs-column full">
	<div id="chart-line-container" class="u-chart"></div>
</div>
<div class="vs-column half">
	<h3 class="content-title"><i class="icon-eye"></i>{lang_entry key="account.entry.views.nr"}</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
	<div id="chart-views-container" class="u-chart"></div>
</div>
<div class="vs-column half fit">
	<h3 class="content-title"><i class="icon-eye"></i>{lang_entry key="account.entry.views.device"}</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
	<div id="device-pie-container" class="u-chart"></div>
</div>
<div class="vs-column full">
	<div id="timeline-container" class="u-chart"></div>
</div>
<div class="clearfix"></div>
<script>

{include file="tpl_frontend/tpl_affiliate/tpl_analytics_js.tpl"}

gapi.analytics.ready(function() {ldelim}
	var col_bg = $("body").hasClass("dark") ? "#232323" : "#fff"
	var col_lb = $("body").hasClass("dark") ? "#fff" : "#000"
	gapi.analytics.auth.authorize({ldelim}'serverAuth':{ldelim}'access_token':'{$tpl_token}'{rdelim}{rdelim});

  var dataChart1 = new gapi.analytics.googleCharts.DataChart({ldelim}
    query: {ldelim}
      'ids': 'ga:{$affiliate_view_id}',
      'start-date': '{$sd}',
      'end-date': '{$ed}',
      'metrics': 'ga:users,ga:uniquePageviews',
      'dimensions': 'ga:date',
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}',
    {rdelim},
    chart: {ldelim}
      'container': 'chart-line-container',
      'type': 'LINE',
      'options': {ldelim}
        'backgroundColor':col_bg,
        'legend':{ldelim}'position': 'top', 'textStyle': {ldelim}color: col_lb, 'fontSize': 16{rdelim}{rdelim},
        'fontName': 'Ubuntu',
        'width': '100%',
        'chartArea':{ldelim}'width': '100%', 'height': '80%'{rdelim}
      {rdelim}
    {rdelim}
  {rdelim});
  dataChart1.execute();
  
  dataChart1.on("success", function() {ldelim}
  	$("text").each(function() {ldelim}
  		t = $(this);
  		v = t.html();
  		
  		if (v == 'Jan 1') {ldelim}
  			t.html($(".content-filters li a.active").text());
  		{rdelim}
  	{rdelim});
  {rdelim});

  var dataChart2 = new gapi.analytics.googleCharts.DataChart({ldelim}
    query: {ldelim}
      'ids': 'ga:{$affiliate_view_id}',
      'start-date': '{$sd}',
      'end-date': '{$ed}',
      'metrics': 'ga:uniquePageviews',
      'dimensions': 'ga:pageTitle',
      'sort': '-ga:uniquePageviews',
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}',
//      'max-results': 1000
    {rdelim},
    chart: {ldelim}
      'container': 'chart-views-container',
      'type': 'PIE',
      'options': {ldelim}
        'backgroundColor':col_bg,
        'legend':{ldelim}'position': 'top', 'textStyle': {ldelim}color: col_lb, 'fontSize': 16{rdelim}{rdelim},
        'width': '100%',
        'pieHole': 4/9,
        'fontName': 'Ubuntu',
        'pieSliceText': 'value-and-percentage',
        'chartArea':{ldelim}'width': '100%', 'height': '80%'{rdelim}
      {rdelim}
    {rdelim}
  {rdelim});
  dataChart2.execute();
  
  var timeline = new gapi.analytics.googleCharts.DataChart({ldelim}
    reportType: 'ga',
    query: {ldelim}
      'dimensions': 'ga:pageTitle',
      'metrics': 'ga:users,ga:pageviews,ga:uniquePageviews',
      'start-date': '{$sd}',
      'end-date': '{$ed}',
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}',
     'ids': "ga:{$affiliate_view_id}"
    {rdelim},
    chart: {ldelim}
      type: 'TABLE',
      container: 'timeline-container',
      options:{ldelim}
      	'width': '100%',
      	'chartArea':{ldelim}'width': '100%', 'height': '90%'{rdelim},
      	'fontName': 'Ubuntu'
      {rdelim}
    {rdelim}
  {rdelim});
  timeline.execute();

timeline.on("success", function(result) {ldelim}
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

  var devPie = new gapi.analytics.googleCharts.DataChart({ldelim}
    query: {ldelim}
      'ids': 'ga:{$affiliate_view_id}',
      'start-date': '{$sd}',
      'end-date': '{$ed}',
      'dimensions': 'ga:deviceCategory',
      'metrics': 'ga:uniquePageviews',
      'sort': '-ga:uniquePageviews',
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}',
//      'max-results': 1000
    {rdelim},
    chart: {ldelim}
      'container': 'device-pie-container',
      'type': 'PIE',
      'options': {ldelim}
        'backgroundColor':col_bg,
        'legend':{ldelim}'position': 'top', 'textStyle': {ldelim}color: col_lb, 'fontSize': 16{rdelim}{rdelim},
        'width': '100%',
        'pieHole': 4/9,
        'fontName': 'Ubuntu',
        'pieSliceText': 'percentage',
        'chartArea':{ldelim}'width': '100%', 'height': '80%'{rdelim}
      {rdelim}
    {rdelim}
  {rdelim});
  devPie.execute();

window.addEventListener('orientationchange', doOnOrientationChange);
function doOnOrientationChange() {ldelim}dataChart1.execute();dataChart2.execute();timeline.execute();devPie.execute();{rdelim}

//var width=$(window).width(),height=$(window).height();
//window.onresize = function(){ldelim}if($(window).width()!=width&&$(window).height()!=height){ldelim}dataChart1.execute();dataChart2.execute();timeline.execute();devPie.execute();{rdelim}{rdelim};

{rdelim});
</script>

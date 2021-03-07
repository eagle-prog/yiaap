<?php
/* Smarty version 3.1.33, created on 2021-02-23 14:59:26
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_analytics.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6035184e0e76e4_65155307',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9b5c15a0d3d9b69ea664a7bab91ea68a84a26ddb' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_analytics.tpl',
      1 => 1566906420,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_affiliate/tpl_analytics_js.tpl' => 1,
  ),
),false)) {
function content_6035184e0e76e4_65155307 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url_be']->value;?>
/affiliate.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/custom.css">-->
<style id="be-affiliate-style">
.u-chart {width:100%;min-height:400px;}
#video_table_sort_div.u-chart,#image_table_sort_div.u-chart,#audio_table_sort_div.u-chart,#document_table_sort_div.u-chart,#blog_table_sort_div.u-chart {min-height:auto;}
.u-chart g text{font-size:14px;font-family:Ubuntu;line-height:50px;}
.google-visualization-table-table td, .google-visualization-table-th {font-family:Ubuntu;}
.dark .gapi-analytics-data-chart .google-visualization-table-table { background: #232323; color: #ccc; }
.dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-odd, .dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-even { background: #232323; border-top: 1px solid #111; }
.dark .gapi-analytics-data-chart .gapi-analytics-data-chart-styles-table-tr-over { background: #131313; border-top: 1px solid #111; }
h3.content-filter{width:10%;color:#888;font-size:14px;}
.content-filters li{float:left;font-size:14px;margin-left:10px;}
.content-filters i{font-size:11px;}
.content-filters a{color:#888;}
.filter-text{font-size:14px;font-weight:normal;margin-left:10px;padding:10px 0;display:inline-block}
.content-filters {vertical-align: middle;display: inline-block;line-height: 47px;}
.gapi-analytics-data-chart-styles-table-td{font-size:14px !important;}
h3.content-title{width: 40%;}
.view-mode-filters{margin-right: 10px;}
.tfb{font-weight: bold !important;}
.sb-search-input{border:0;}
svg > g:last-child > g:last-child {pointer-events: none;}
.loadmask-msg div:before{font-size: 14px;}
#view-limits input{max-width: 50px; padding: 0 5px;margin-bottom: 0; height: 32px; margin-right: 10px; margin-top: 7px;}
#time-sort-filters{margin-bottom:25px;}
.toggle-all-filters {display: inline-block;margin-top: 20px;margin-right: 15px;cursor:pointer;display: none;}
#search-boxes{float:right}
@media (max-width:1310px){#search-boxes{width: 100%; display: inline-block; margin-top:-7px; margin-bottom:3px; float: none;}}
@media (max-width:960px){#lb-wrapper .rep-wrap{display: block; width: 100%;margin-top: -20px;}#lb-wrapper .greyed-out{margin-left: 30px;}}
@media (max-width:920px){.sb-search-fe.sb-search-open{width: calc(100% - 20px)}#search-boxes .inner-search{width:100%}#sb-search-fe{margin-bottom:auto;}.inner-search,.search_holder_fe{width:auto}}
@media (max-width:860px){.content-filters li{line-height:30px}#time-sort-filters h3.content-title.content-filter{display: none}#time-sort-filters section.filter{float: left;}.toggle-all-filters{display: block;}section.filter,section.inner-search,#search-boxes,section.action{display:none;}h3.content-title{width: 100%; display: inline-block;}#search-boxes{margin-top:0}a[rel-def-off="1"]{display:none;}}
@media (max-width:470px){#sb-search-be{margin-right:10px}}
</style>



<?php echo '<script'; ?>
>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
<?php echo '</script'; ?>
>


<?php echo $_smarty_tpl->tpl_vars['tpl_html']->value;?>

<div class="vs-column full">
	<div id="chart-line-container" class="u-chart"></div>
</div>
<div class="vs-column half">
	<h3 class="content-title"><i class="icon-eye"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.views.nr"),$_smarty_tpl);?>
</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
	<div id="chart-views-container" class="u-chart"></div>
</div>
<div class="vs-column half fit">
	<h3 class="content-title"><i class="icon-eye"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.views.device"),$_smarty_tpl);?>
</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
	<div id="device-pie-container" class="u-chart"></div>
</div>
<div class="vs-column full">
	<div id="timeline-container" class="u-chart"></div>
</div>
<div class="clearfix"></div>
<?php echo '<script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_affiliate/tpl_analytics_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

gapi.analytics.ready(function() {
	var col_bg = $("body").hasClass("dark") ? "#232323" : "#fff"
	var col_lb = $("body").hasClass("dark") ? "#fff" : "#000"
	gapi.analytics.auth.authorize({'serverAuth':{'access_token':'<?php echo $_smarty_tpl->tpl_vars['tpl_token']->value;?>
'}});

  var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'start-date': '<?php echo $_smarty_tpl->tpl_vars['sd']->value;?>
',
      'end-date': '<?php echo $_smarty_tpl->tpl_vars['ed']->value;?>
',
      'metrics': 'ga:users,ga:uniquePageviews',
      'dimensions': 'ga:date',
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
',
    },
    chart: {
      'container': 'chart-line-container',
      'type': 'LINE',
      'options': {
        'backgroundColor':col_bg,
        'legend':{'position': 'top', 'textStyle': {color: col_lb, 'fontSize': 16}},
        'fontName': 'Ubuntu',
        'width': '100%',
        'chartArea':{'width': '100%', 'height': '80%'}
      }
    }
  });
  dataChart1.execute();
  
  dataChart1.on("success", function() {
  	$("text").each(function() {
  		t = $(this);
  		v = t.html();
  		
  		if (v == 'Jan 1') {
  			t.html($(".content-filters li a.active").text());
  		}
  	});
  });


  var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'start-date': '<?php echo $_smarty_tpl->tpl_vars['sd']->value;?>
',
      'end-date': '<?php echo $_smarty_tpl->tpl_vars['ed']->value;?>
',
      'metrics': 'ga:uniquePageviews',
      'dimensions': 'ga:pageTitle',
      'sort': '-ga:uniquePageviews',
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
',
/*     'max-results': 1000*/
    },
    chart: {
      'container': 'chart-views-container',
      'type': 'PIE',
      'options': {
        'backgroundColor':col_bg,
        'legend':{'position': 'top', 'textStyle': {color: col_lb, 'fontSize': 16}},
        'width': '100%',
        'pieHole': 4/9,
        'fontName': 'Ubuntu',
        'pieSliceText': 'value-and-percentage',
        'chartArea':{'width': '100%', 'height': '80%'}
      }
    }
  });
  dataChart2.execute();
  
  var timeline = new gapi.analytics.googleCharts.DataChart({
    reportType: 'ga',
    query: {
      'dimensions': 'ga:pageTitle',
      'metrics': 'ga:users,ga:pageviews,ga:uniquePageviews',
      'start-date': '<?php echo $_smarty_tpl->tpl_vars['sd']->value;?>
',
      'end-date': '<?php echo $_smarty_tpl->tpl_vars['ed']->value;?>
',
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
',
     'ids': "ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
"
    },
    chart: {
      type: 'TABLE',
      container: 'timeline-container',
      options:{
      	'width': '100%',
      	'chartArea':{'width': '100%', 'height': '90%'},
      	'fontName': 'Ubuntu'
      }
    }
  });
  timeline.execute();

timeline.on("success", function(result) {
        uv_t = result.response.totalsForAllResults['ga:uniquePageviews'];
        pv_t = result.response.totalsForAllResults['ga:pageviews'];
        us_t = result.response.totalsForAllResults['ga:users'];

        if ($('.google-visualization-table-table > tbody > tr:last').hasClass('gapi-analytics-data-chart-styles-table-tr-even')) {
                trc = 'gapi-analytics-data-chart-styles-table-tr-odd';
        } else {
                trc = 'gapi-analytics-data-chart-styles-table-tr-even';
        }

        tdnr = 'gapi-analytics-data-chart-styles-table-td google-visualization-table-td-number tfb';
        tdc = 'gapi-analytics-data-chart-styles-table-td tfb';

        $('.google-visualization-table-table tbody').append('<tr class="'+trc+'"><td class="'+tdc+'"><?php echo smarty_function_lang_entry(array('key'=>"account.entry.tbl.total"),$_smarty_tpl);?>
</td><td class="'+tdnr+'">'+us_t+'</td><td class="'+tdnr+'">'+pv_t+'</td><td class="'+tdnr+'">'+uv_t+'</td></tr>');

	$('.google-visualization-table-table th').click(function() {
		$('.google-visualization-table-table tbody').append('<tr class="'+trc+'"><td class="'+tdc+'"><?php echo smarty_function_lang_entry(array('key'=>"account.entry.tbl.total"),$_smarty_tpl);?>
</td><td class="'+tdnr+'">'+us_t+'</td><td class="'+tdnr+'">'+pv_t+'</td><td class="'+tdnr+'">'+uv_t+'</td></tr>');
	});
});



  
  var devPie = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'start-date': '<?php echo $_smarty_tpl->tpl_vars['sd']->value;?>
',
      'end-date': '<?php echo $_smarty_tpl->tpl_vars['ed']->value;?>
',
      'dimensions': 'ga:deviceCategory',
      'metrics': 'ga:uniquePageviews',
      'sort': '-ga:uniquePageviews',
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
',
/*     'max-results': 1000*/
    },
    chart: {
      'container': 'device-pie-container',
      'type': 'PIE',
      'options': {
        'backgroundColor':col_bg,
        'legend':{'position': 'top', 'textStyle': {color: col_lb, 'fontSize': 16}},
        'width': '100%',
        'pieHole': 4/9,
        'fontName': 'Ubuntu',
        'pieSliceText': 'percentage',
        'chartArea':{'width': '100%', 'height': '80%'}
      }
    }
  });
  devPie.execute();

window.addEventListener('orientationchange', doOnOrientationChange);
function doOnOrientationChange() {dataChart1.execute();dataChart2.execute();timeline.execute();devPie.execute();}

/*var width=$(window).width(),height=$(window).height();
window.onresize = function(){if($(window).width()!=width&&$(window).height()!=height){dataChart1.execute();dataChart2.execute();timeline.execute();devPie.execute();}};*/

});
<?php echo '</script'; ?>
>
<?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-03-03 09:04:49
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_bars.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_603f51314c5b44_41300421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2e5a91bbb37970220b968b6494334acf982a75f7' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_bars.tpl',
      1 => 1566867984,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603f51314c5b44_41300421 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
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
h3.content-filter{width:10%;color:#888;font-size:14px;}
.content-filters li{float:left;font-size:14px;margin-left:10px;}
.content-filters i{font-size:11px;}
.content-filters a, .filter-text{color:#888;}
.content-filters {vertical-align: middle;display: inline-block;line-height: 47px;}
.gapi-analytics-data-chart-styles-table-td{font-size:14px !important;}
h3.content-title{width: 40%;}
.view-mode-filters{margin-right: 10px;}
.filter-text{font-size:14px;font-weight:normal;margin-left:7px;padding:10px 0;display:inline-block}

.ActiveUsers{background:#f4f2f1;border:1px solid #d4d2d0;border-radius:4px;font-weight:300;padding:.5em 1.5em;white-space:nowrap}
.ActiveUsers-value{display:inline-block;font-weight:600;margin-right:-.25em}
.ActiveUsers.is-increasing{-webkit-animation:a 3s;animation:a 3s}
.ActiveUsers.is-decreasing{-webkit-animation:b 3s;animation:b 3s}
@-webkit-keyframes a{10%{background-color:#ebffeb;border-color:rgba(0,128,0,.5);color:green}}
@keyframes a{10%{background-color:#ebffeb;border-color:rgba(0,128,0,.5);color:green}}
@-webkit-keyframes b{10%{background-color:#ffebeb;border-color:rgba(255,0,0,.5);color:red}}
@keyframes b{10%{background-color:#ffebeb;border-color:rgba(255,0,0,.5);color:red}}
.Chartjs{font-size:.85em}
.Chartjs-figure{height:250px}
.Chartjs-legend{list-style:none;margin:0;padding:1em 0 0;text-align:center}
.Chartjs-legend>li{display:inline-block;padding:.25em .5em}
.Chartjs-legend>li>i{display:inline-block;height:1em;margin-right:.5em;vertical-align:-.1em;width:1em}
@media (min-width:570px){.Chartjs-figure{margin-right:1.5em}}

.toggle-all-filters {display: inline-block;margin-top: 20px;margin-right: 15px;cursor:pointer;display: none;}
#search-boxes{float:right}
@media (max-width:1310px){#search-boxes{width: 100%; display: inline-block; margin-top:-7px; margin-bottom:3px; float: none;}}
@media (max-width:960px){#lb-wrapper .rep-wrap{display: block; width: 100%;margin-top: -20px;}#lb-wrapper .greyed-out{margin-left: 30px;}}
@media (max-width:920px){.sb-search-fe.sb-search-open{width: calc(100% - 20px)}#search-boxes .inner-search{width:100%}#sb-search-fe{margin-bottom:auto;}.inner-search,.search_holder_fe{width:auto}}
@media (max-width:860px){.content-filters li{line-height:30px}#time-sort-filters h3.content-title.content-filter{display: none}#time-sort-filters section.filter{float: left;}.toggle-all-filters{display: block;}section.filter,section.inner-search,#search-boxes,section.action{display:none;}h3.content-title{width: 100%; display: inline-block;}#search-boxes{margin-top:0}a[rel-def-off="1"]{display:none;}}
@media (max-width:470px){#sb-search-be{margin-right:10px}}
.sb-search-input{border:0;}
.loadmask-msg div:before{font-size: 14px;}
#view-limits input{max-width: 50px; padding: 0 5px;margin-bottom: 0; height: 32px; margin-right: 10px; margin-top: 7px;}
</style>
<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"><?php echo '</script'; ?>
>

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
	<h3 class="content-title"><i class="icon-eye"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.vs.thisweek"),$_smarty_tpl);?>
</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
        <figure class="Chartjs-figure" id="chart-1-container"></figure>
        <ol class="Chartjs-legend" id="legend-1-container"></ol>
</div>

<div class="vs-column full">
	<h3 class="content-title"><i class="icon-eye"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.vs.thismonth"),$_smarty_tpl);?>
</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
        <figure class="Chartjs-figure" id="chart-3-container"></figure>
        <ol class="Chartjs-legend" id="legend-3-container"></ol>
</div>

<div class="vs-column full">
	<h3 class="content-title"><i class="icon-eye"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.vs.thisyear"),$_smarty_tpl);?>
</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
        <figure class="Chartjs-figure" id="chart-2-container"></figure>
        <ol class="Chartjs-legend" id="legend-2-container"></ol>
</div>

<div class="clearfix"></div>





<?php echo '<script'; ?>
>
$(document).ready(function(){
	$(".view-mode-type").click(function(){
                t = $(this);
                type = t.attr("rel-t");
                u = '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?o=<?php echo smarty_modifier_sanitize($_GET['o']);?>
&t='+type;

                $(".view-mode-type").removeClass("active"); t.addClass("active");

                window.location = u;
                return false;
	});
	$("#view-limits").submit(function(e){
                e.preventDefault();

                l1 = parseInt($("#view-limit-min-off").val());
                l2 = parseInt($("#view-limit-max-off").val());

                $("#view-limit-min").val(l1);
                $("#view-limit-max").val(l2);

                $("#custom-date-form").submit();
        });
	$("a.filter-tag").click(function(){
                t = $(this);
                type = t.attr("rel-t");
                u = String(window.location);
                rep = '';
                switch (type) {
                        case "f":
                                rep = '<?php if ($_GET['f'] != '') {?>&f=<?php echo smarty_modifier_sanitize($_GET['f']);
}?>';
                        break;
                        case "r":
                                rep = '<?php if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}?>';
                        break;
                        case "c":
                                rep = '<?php if ($_GET['c'] != '' && $_GET['c'] != "xx") {?>&c=<?php echo smarty_modifier_sanitize($_GET['c']);
}?>';
                        break;
                        case "fk":
                                rep = '<?php if ($_GET['fk'] != '') {?>&fk=<?php echo smarty_modifier_sanitize($_GET['fk']);
}?>';
                        break;
                }
                if (rep != '') {
                	u = u.replace(rep, '');
                	window.location = u;
                }
        });
});

gapi.analytics.ready(function() {
  $("#chart-1-container").mask(""); $("#chart-2-container").mask(""); $("#chart-3-container").mask("");

  gapi.analytics.auth.authorize({'serverAuth':{'access_token':'<?php echo $_smarty_tpl->tpl_vars['tpl_token']->value;?>
'}});


function renderWeekOverWeekChart() {
    var now = moment();

    var thisWeek = query({
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',
      'start-date': '<?php echo $_smarty_tpl->tpl_vars['twsd']->value;?>
',
      'end-date': '<?php echo $_smarty_tpl->tpl_vars['twed']->value;?>
',
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
'
    });

    var lastWeek = query({
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',
      'start-date': '<?php echo $_smarty_tpl->tpl_vars['lwsd']->value;?>
',
      'end-date': '<?php echo $_smarty_tpl->tpl_vars['lwed']->value;?>
',
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
'
    });

    Promise.all([thisWeek, lastWeek]).then(function(results) {

      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = results[1].rows.map(function(row) { return +row[0]; });

      labels = labels.map(function(label) {
        return moment(label, 'YYYYMMDD').format('ddd');
      });

      var data = {
        labels : labels,
        datasets : [
          {
            label: '<?php echo smarty_function_lang_entry(array('key'=>"account.entry.f.thisweek"),$_smarty_tpl);?>
',
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            pointColor : 'rgba(151,187,205,1)',
            pointStrokeColor : '#fff',
            data : data1
          },
          {
            label: '<?php echo smarty_function_lang_entry(array('key'=>"account.entry.f.lastweek"),$_smarty_tpl);?>
',
            fillColor : 'rgba(220,220,220,0.5)',
            strokeColor : 'rgba(220,220,220,1)',
            pointColor : 'rgba(220,220,220,1)',
            pointStrokeColor : '#fff',
            data : data2
          }
        ]
      };

      new Chart(makeCanvas('chart-1-container')).Bar(data);
      generateLegend('legend-1-container', data.datasets);
    });
  }
function renderMonthOverMonthChart() {
    var thisMonth = query({
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',
      'start-date': moment().startOf('month').format('YYYY-MM-DD'),
      'end-date': moment().endOf('month').format('YYYY-MM-DD'),
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
'
    });

    var lastMonth = query({
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',
      'start-date': moment().subtract(1, 'months').startOf('month').format('YYYY-MM-DD'),
      'end-date': moment().subtract(1, 'months').endOf('month').format('YYYY-MM-DD'),
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
'
    });

    Promise.all([thisMonth, lastMonth]).then(function(results) {

      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = results[0].rows.map(function(row) { return +row[0]; });

      labels = labels.map(function(label) {
        return moment(label, 'YYYYMMDD').format('ddd');
      });

      var data = {
        labels : labels,
        datasets : [
          {
            label: '<?php echo smarty_function_lang_entry(array('key'=>"account.entry.f.thismonth"),$_smarty_tpl);?>
',
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            pointColor : 'rgba(151,187,205,1)',
            pointStrokeColor : '#fff',
            data : data1
          },
          {
            label: '<?php echo smarty_function_lang_entry(array('key'=>"account.entry.f.lastmonth"),$_smarty_tpl);?>
',
            fillColor : 'rgba(220,220,220,0.5)',
            strokeColor : 'rgba(220,220,220,1)',
            pointColor : 'rgba(220,220,220,1)',
            pointStrokeColor : '#fff',
            data : data2
          }
        ]
      };

      new Chart(makeCanvas('chart-3-container')).Bar(data);
      generateLegend('legend-3-container', data.datasets);
    });
  }
function renderYearOverYearChart() {
    var now = moment();

    var thisYear = query({
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:uniquePageviews',
      'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
      'end-date': moment(now).format('YYYY-MM-DD'),
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
'
    });

    var lastYear = query({
      'ids': 'ga:<?php echo $_smarty_tpl->tpl_vars['affiliate_view_id']->value;?>
',
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:uniquePageviews',
      'start-date': moment(now).subtract(1, 'year').date(1).month(0)
          .format('YYYY-MM-DD'),
      'end-date': moment(now).date(1).month(0).subtract(1, 'day')
          .format('YYYY-MM-DD'),
      'filters': '<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['user_filter']->value, $tmp) > 2) {?>ga:dimension1==<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['user_filter']->value);?>
;<?php }?>ga:dimension2==<?php echo $_smarty_tpl->tpl_vars['file_type']->value;
if ($_GET['fk'] != '') {?>;ga:dimension3==<?php echo smarty_modifier_sanitize($_GET['fk']);
}
echo $_smarty_tpl->tpl_vars['views_min']->value;
echo $_smarty_tpl->tpl_vars['views_max']->value;?>
'
    });

    Promise.all([thisYear, lastYear]).then(function(results) {
      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = ['Jan','Feb','Mar','Apr','May','Jun',
                    'Jul','Aug','Sep','Oct','Nov','Dec'];

      /*Ensure the data arrays are at least as long as the labels array.
      Chart.js bar charts don't (yet) accept sparse datasets.*/
      for (var i = 0, len = labels.length; i < len; i++) {
        if (data1[i] === undefined) data1[i] = null;
        if (data2[i] === undefined) data2[i] = null;
      }

      var data = {
        labels : labels,
        datasets : [
          {
            label: '<?php echo smarty_function_lang_entry(array('key'=>"account.entry.f.thisyear"),$_smarty_tpl);?>
',
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            pointColor : 'rgba(151,187,205,1)',
            data : data1
          },
          {
            label: '<?php echo smarty_function_lang_entry(array('key'=>"account.entry.f.lastyear"),$_smarty_tpl);?>
',
            fillColor : 'rgba(220,220,220,0.5)',
            strokeColor : 'rgba(220,220,220,1)',
            pointColor : 'rgba(220,220,220,1)',
            data : data2
          }
        ]
      };

      new Chart(makeCanvas('chart-2-container')).Bar(data);
      generateLegend('legend-2-container', data.datasets);
    })
    .catch(function(err) {
      console.error(err.stack);
    });
  }

/**
   * Extend the Embed APIs `gapi.analytics.report.Data` component to
   * return a promise the is fulfilled with the value returned by the API.
   * @param {Object} params The request parameters.
   * @return {Promise} A promise.
   */
  function query(params) {
    return new Promise(function(resolve, reject) {
      var data = new gapi.analytics.report.Data({query: params});
      data.once('success', function(response) { resolve(response); })
          .once('error', function(response) { reject(response); })
          .execute();
    });
  }


  /**
   * Create a new canvas inside the specified element. Set it to be the width
   * and height of its container.
   * @param {string} id The id attribute of the element to host the canvas.
   * @return {RenderingContext} The 2D canvas context.
   */
  function makeCanvas(id) {
    var container = document.getElementById(id);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    container.innerHTML = '';
    canvas.width = container.offsetWidth;
    canvas.height = container.offsetHeight;
    container.appendChild(canvas);

    return ctx;
  }
  /**
   * Create a visual legend inside the specified element based off of a
   * Chart.js dataset.
   * @param {string} id The id attribute of the element to host the legend.
   * @param {Array.<Object>} items A list of labels and colors for the legend.
   */
  function generateLegend(id, items) {
    var legend = document.getElementById(id);
    legend.innerHTML = items.map(function(item) {
      var color = item.color || item.fillColor;
      var label = item.label;
      return '<li><i style="background:' + color + '"></i>' +
          escapeHtml(label) + '</li>';
    }).join('');
  }

  /*Set some global Chart.js defaults.*/
  Chart.defaults.global.animationSteps = 1;
  Chart.defaults.global.animationEasing = 'easeInOutQuart';
  Chart.defaults.global.responsive = true;
  Chart.defaults.global.maintainAspectRatio = true;

  /**
   * Escapes a potentially unsafe HTML string.
   * @param {string} str An string that may contain HTML entities.
   * @return {string} The HTML-escaped string.
   */
  function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }

renderWeekOverWeekChart(); renderYearOverYearChart(); renderMonthOverMonthChart();


});
<?php echo '</script'; ?>
>
<?php }
}

<style>
.u-chart {ldelim}width:100%;min-height:400px;{rdelim}
#video_table_sort_div.u-chart,#image_table_sort_div.u-chart,#audio_table_sort_div.u-chart,#document_table_sort_div.u-chart,#blog_table_sort_div.u-chart {ldelim}min-height:auto;{rdelim}
.u-chart g text{ldelim}font-size:14px;font-family:Ubuntu;line-height:50px;{rdelim}
.google-visualization-table-table td, .google-visualization-table-th {ldelim}font-family:Ubuntu;{rdelim}
h3.content-filter{ldelim}width:10%;color:#888;font-size:14px;{rdelim}
.content-filters li{ldelim}float:left;font-size:14px;margin-left:10px;line-height:47px{rdelim}
.content-filters i{ldelim}font-size:11px;{rdelim}
.filter-text{ldelim}color:#888;{rdelim}
.content-filters {ldelim}vertical-align: middle;display: inline-block;line-height:47px;{rdelim}
.gapi-analytics-data-chart-styles-table-td{ldelim}font-size:14px !important;{rdelim}
h3.content-title{ldelim}width: 40%;{rdelim}
.view-mode-filters{ldelim}margin-right: 10px;{rdelim}
.filter-text{ldelim}font-size:14px;font-weight:normal;margin-left:7px;{rdelim}
{literal}
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
{/literal}

.toggle-all-filters {ldelim}display: inline-block;margin-top: 20px;margin-right: 0px !important;cursor:pointer;display: none;width:30px;text-align:right{rdelim}
#search-boxes{ldelim}float:right{rdelim}
{literal}@media (max-width:1310px){#sb-search-fe{margin-right:0;}#search-boxes{width: 100%; display: inline-block; margin-top:-7px; margin-bottom:3px; float: none;}}{/literal}
{literal}@media (max-width:960px){#lb-wrapper .rep-wrap{display: block; width: 100%;margin-top: -20px;}#lb-wrapper .greyed-out{margin-left: 30px;}}{/literal}
{literal}@media (max-width:920px){#search-boxes .inner-search{width:67%}#sb-search-fe{margin-bottom:auto;}.inner-search{width:auto}}{/literal}
{literal}@media (max-width:860px){#time-sort-filters h3.content-title.content-filter{display: none}#time-sort-filters section.filter{float: left;}.toggle-all-filters{display: block;}section.filter,section.inner-search,#search-boxes{display:none;}h3.content-title{width: 100% !important; display: inline-block;}#search-boxes{margin-top:0}a[rel-def-off="1"]{display:none;}}{/literal}
{literal}@media (max-width:470px){#sb-search-be{margin-right:10px}}{/literal}
{literal}@media (max-width:375px){#search-boxes .inner-search{width:50%}}{/literal}
.sb-search-input{ldelim}border:0;{rdelim}
#view-limits input{ldelim}max-width: 50px; padding: 0 5px;margin-bottom: 0; height: 32px; margin-left: 10px; margin-top: 7px;{rdelim}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
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
	<h3 class="content-title"><i class="icon-eye"></i>{lang_entry key="account.entry.vs.thisweek"}</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
        <figure class="Chartjs-figure" id="chart-1-container"></figure>
        <ol class="Chartjs-legend" id="legend-1-container"></ol>
</div>

<div class="vs-column full">
	<h3 class="content-title"><i class="icon-eye"></i>{lang_entry key="account.entry.vs.thismonth"}</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
        <figure class="Chartjs-figure" id="chart-3-container"></figure>
        <ol class="Chartjs-legend" id="legend-3-container"></ol>
</div>

<div class="vs-column full">
	<h3 class="content-title"><i class="icon-eye"></i>{lang_entry key="account.entry.vs.thisyear"}</h3>
        <div class="clearfix"></div>
        <div class="line" style="margin-bottom:0"></div>
        <figure class="Chartjs-figure" id="chart-2-container"></figure>
        <ol class="Chartjs-legend" id="legend-2-container"></ol>
</div>

<div class="clearfix"></div>





<script>
$(document).ready(function(){ldelim}
	$(".view-mode-type").click(function(){ldelim}
                t = $(this);
                type = t.attr("rel-t");
                u = '{$main_url}/{href_entry key="affiliate"}?o={$smarty.get.o|sanitize}&t='+type;

                $(".view-mode-type").removeClass("active"); t.addClass("active");

                window.location = u;
                return false;
	{rdelim});
        $("#view-limits").submit(function(e){ldelim}
                e.preventDefault();

                l1 = parseInt($("#view-limit-min-off").val());
                l2 = parseInt($("#view-limit-max-off").val());

                $("#view-limit-min").val(l1);
                $("#view-limit-max").val(l2);

                $("#custom-date-form").submit();
        {rdelim});
	$("a.filter-tag").click(function(){ldelim}
                t = $(this);
                type = t.attr("rel-t");
                u = String(window.location);
                rep = '';
                switch (type) {ldelim}
                        case "f":
                                rep = '{if $smarty.get.f ne ""}&f={$smarty.get.f|sanitize}{/if}';
                        break;
                        case "r":
                                rep = '{if $smarty.get.r ne ""}&r={$smarty.get.r|sanitize}{/if}';
                        break;
                        case "c":
                                rep = '{if $smarty.get.c ne "" and $smarty.get.c ne "xx"}&c={$smarty.get.c|sanitize}{/if}';
                        break;
                        case "fk":
                                rep = '{if $smarty.get.fk ne ""}&fk={$smarty.get.fk|sanitize}{/if}';
                        break;
                {rdelim}
                if (rep != '') {ldelim}
                	u = u.replace(rep, '');
                	window.location = u;
                {rdelim}
        {rdelim});
{rdelim});

gapi.analytics.ready(function() {ldelim}
  $("#chart-1-container").mask(""); $("#chart-2-container").mask(""); $("#chart-3-container").mask("");

  gapi.analytics.auth.authorize({ldelim}'serverAuth':{ldelim}'access_token':'{$tpl_token}'{rdelim}{rdelim});

{literal}
function renderWeekOverWeekChart() {
    var now = moment();

    var thisWeek = query({
      'ids': {/literal}'ga:{$affiliate_view_id}',{literal}
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',{/literal}
      'start-date': '{$twsd}',
      'end-date': '{$twed}',
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}'{literal}
    });

    var lastWeek = query({
      'ids': {/literal}'ga:{$affiliate_view_id}',{literal}
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',{/literal}
      'start-date': '{$lwsd}',
      'end-date': '{$lwed}',
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}'{literal}
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
          {{/literal}
            label: '{lang_entry key="account.entry.f.thisweek"}',{literal}
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            pointColor : 'rgba(151,187,205,1)',
            pointStrokeColor : '#fff',
            data : data1
          },
          {{/literal}
            label: '{lang_entry key="account.entry.f.lastweek"}',{literal}
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
      'ids': {/literal}'ga:{$affiliate_view_id}',{literal}
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',
      'start-date': moment().startOf('month').format('YYYY-MM-DD'),
      'end-date': moment().endOf('month').format('YYYY-MM-DD'),{/literal}
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}'{literal}
    });

    var lastMonth = query({
      'ids': {/literal}'ga:{$affiliate_view_id}',{literal}
      'dimensions': 'ga:date',
      'metrics': 'ga:users,ga:uniquePageviews',
      'start-date': moment().subtract(1, 'months').startOf('month').format('YYYY-MM-DD'),
      'end-date': moment().subtract(1, 'months').endOf('month').format('YYYY-MM-DD'),{/literal}
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}'{literal}
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
          {{/literal}
            label: '{lang_entry key="account.entry.f.thismonth"}',{literal}
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            pointColor : 'rgba(151,187,205,1)',
            pointStrokeColor : '#fff',
            data : data1
          },
          {{/literal}
            label: '{lang_entry key="account.entry.f.lastmonth"}',{literal}
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
      'ids': {/literal}'ga:{$affiliate_view_id}',{literal}
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:uniquePageviews',
      'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
      'end-date': moment(now).format('YYYY-MM-DD'),{/literal}
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}'{literal}
    });

    var lastYear = query({
      'ids': {/literal}'ga:{$affiliate_view_id}',{literal}
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:uniquePageviews',
      'start-date': moment(now).subtract(1, 'year').date(1).month(0)
          .format('YYYY-MM-DD'),
      'end-date': moment(now).date(1).month(0).subtract(1, 'day')
          .format('YYYY-MM-DD'),{/literal}
      'filters': 'ga:dimension1=={$smarty.session.USER_KEY};ga:dimension2=={$file_type}{if $smarty.get.fk ne ""};ga:dimension3=={$smarty.get.fk|sanitize}{/if}{$views_min}{$views_max}'{literal}
    });

    Promise.all([thisYear, lastYear]).then(function(results) {
      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = ['Jan','Feb','Mar','Apr','May','Jun',
                    'Jul','Aug','Sep','Oct','Nov','Dec'];

      // Ensure the data arrays are at least as long as the labels array.
      // Chart.js bar charts don't (yet) accept sparse datasets.
      for (var i = 0, len = labels.length; i < len; i++) {
        if (data1[i] === undefined) data1[i] = null;
        if (data2[i] === undefined) data2[i] = null;
      }

      var data = {
        labels : labels,
        datasets : [
          {{/literal}
            label: '{lang_entry key="account.entry.f.thisyear"}',{literal}
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            pointColor : 'rgba(151,187,205,1)',
            data : data1
          },
          {{/literal}
            label: '{lang_entry key="account.entry.f.lastyear"}',{literal}
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

  // Set some global Chart.js defaults.
  Chart.defaults.global.animationSteps = 1;
  Chart.defaults.global.animationEasing = 'easeInOutQuart';
  Chart.defaults.global.responsive = true;
  Chart.defaults.global.maintainAspectRatio = false;

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

{/literal}
{rdelim});
</script>

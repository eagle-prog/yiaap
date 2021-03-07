<?php
/* Smarty version 3.1.33, created on 2021-02-11 18:29:59
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_reports.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6025bdf7c13446_40302549',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4b0c23f44684f9288e32f268e2195ff10888ca5b' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_reports.tpl',
      1 => 1566906454,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:f_scripts/be/js/settings-accordion.js' => 1,
    'file:tpl_backend/tpl_affiliate/tpl_reports_js.tpl' => 1,
  ),
),false)) {
function content_6025bdf7c13446_40302549 (Smarty_Internal_Template $_smarty_tpl) {
?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url_be']->value;?>
/affiliate.css">
<style id="be-affiliate-style">
.u-chart {width:100%;min-height:400px;}
#video_table_sort_div.u-chart,#image_table_sort_div.u-chart,#audio_table_sort_div.u-chart,#document_table_sort_div.u-chart,#blog_table_sort_div.u-chart {min-height:auto;}
.u-chart g text{font-size:14px;font-family:Ubuntu;line-height:50px;}
.google-visualization-table-table td, .google-visualization-table-th {font-family:Ubuntu;}
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
#lb-wrapper .responsive-accordion-panel {display: flex;}
.fancybox-inner #lb-wrapper .responsive-accordion-panel {display: block;}
#lb-wrapper {position: relative; padding:0; display: inline-block; background-color: #ebeef1; width: 100%;}
.dark #lb-wrapper {background-color: #131313;}
.expand-entry {margin-top: 15px;}
.dark #lb-wrapper .rep-info{color:#d0d0d0;}
.fancybox-inner #lb-wrapper {padding: 0 20px; background-color: #fff;}
#lb-wrapper h3.content-title{width: 95%;font-size: 14px;}
.fancybox-inner #lb-wrapper h3.content-title{width: 95%;font-size: 16px;}
#lb-wrapper .open-close-reports {display: inline-block; float: right; margin-bottom: 10px;margin-top: 10px;}
#lb-wrapper .greyed-out{color: darkgrey; margin-left: 10px;}
.fancybox-inner #lb-wrapper .greyed-out{color: #999; margin-left: 0px;}
#lb-wrapper .rep-info{color: black; margin-left: 10px;}
#lb-wrapper .rep-amt{color: cadetblue; margin-left: 10px;}
.views-details li {margin-left: 9px; font-size: 14px;}
.views-details li i{margin-right: 10px;}
.err-red, .conf-green {font-size: 14px;}
.tabs nav ul, .content-wrap section, .tabs-style-topline {max-width: none;}
.content-current ul.responsive-accordion:first-child{margin-top: 10px;}
.dark .tabs-style-topline nav li.tab-current a{background-color: #000;}
.tabs-style-topline nav li.tab-current a{background-color: #fff;}
.tabs-style-topline nav a span {font-size: 13px;}
#section-paid, #section-unpaid, #section-all {min-height: 100px;}
#info-text{position: absolute; top: 13px; font-size: 15px;}
.r-image{max-width: 70%; display:inline-block; height: auto;}
.views-details.views-thumbs{float: left;display: inline-block; width: 60%;}
.dark .sb-search-fe { border: 1px solid #000; }
.dark .sb-icon-search-fe { border: 1px solid #303030; background: #000; }

.toggle-all-filters {display: inline-block;margin-top: 20px;margin-right: 15px;cursor:pointer;display: none;}
#search-boxes{float:right}
@media (max-width:960px){.views-details.views-thumbs{width: 80%;}}
@media (max-width:1310px){#sb-search-fe,#sb-search-be{margin-right:10px;}#search-boxes{width: 100%; display: inline-block; margin-top:-7px; margin-bottom:3px; float: none;}}
@media (max-width:960px){#lb-wrapper .rep-wrap{display: block; width: 100%;margin-top: -20px;}#lb-wrapper .greyed-out{margin-left: 30px;}}
@media (max-width:920px){.sb-search-fe.sb-search-open{width: calc(100% - 20px)}#search-boxes .inner-search{width:100%}#sb-search-fe{margin-bottom:auto;}.inner-search,.search_holder_fe{width:auto}}
@media (max-width:860px){.content-filters li{line-height:30px}#time-sort-filters h3.content-title.content-filter{display: none}#time-sort-filters section.filter{float: left;}.toggle-all-filters{display: block;}section.filter,section.inner-search,#search-boxes,section.action{display:none;}h3.content-title{width: 100%; display: inline-block;}#search-boxes{margin-top:0}a[rel-def-off="1"]{display:none;}}
@media (max-width:640px){
#info-text{font-size:13px;}
#v-tabs .responsive-accordion-panel .vs-column.half{width: 100%;display: inline-block;}
#v-tabs .responsive-accordion-panel, #lb-wrapper .responsive-accordion-panel{display: block;}
#v-tabs .responsive-accordion-panel .vs-column.half.fit{margin-top: 7px;}
#lb-wrapper h3.content-title{white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:90%}
}
@media (max-width:470px){#sb-search-be{margin-right:10px}}


</style>
<?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>


<?php echo '<script'; ?>
>

(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));


<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_affiliate/tpl_reports_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '</script'; ?>
>


<?php echo $_smarty_tpl->tpl_vars['tpl_html']->value;?>


<div class="clearfix"></div>
<?php }
}

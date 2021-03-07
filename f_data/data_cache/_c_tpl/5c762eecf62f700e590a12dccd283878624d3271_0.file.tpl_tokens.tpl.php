<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:43:41
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_token/tpl_tokens.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c789d833144_20211214',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c762eecf62f700e590a12dccd283878624d3271' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_token/tpl_tokens.tpl',
      1 => 1557845100,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:f_scripts/be/js/settings-accordion.js' => 1,
    'file:tpl_frontend/tpl_token/tpl_overview.tpl' => 1,
    'file:tpl_frontend/tpl_token/tpl_tokens_js.tpl' => 1,
    'file:tpl_frontend/tpl_token/tpl_tokensrg_js.tpl' => 1,
  ),
),false)) {
function content_601c789d833144_20211214 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container cbp-spmenu-push">
<style id="be-affiliate-style">
section.filter{}
.u-chart {width:100%;min-height:400px;}
#video_table_sort_div.u-chart,#image_table_sort_div.u-chart,#audio_table_sort_div.u-chart,#document_table_sort_div.u-chart,#blog_table_sort_div.u-chart {min-height:auto;}
.u-chart g text{font-size:14px;font-family:Ubuntu;line-height:50px;}
.google-visualization-table-table td, .google-visualization-table-th {font-family:Ubuntu;}
h3.content-filter{width:10%;color:#888;font-size:14px;}
.content-filters li{float:left;font-size:14px;margin-left:10px;line-height:47px}
.content-filters i{font-size:11px;}
.filter-text{font-size:14px;font-weight:normal;margin-left:7px;}
.content-filters {vertical-align: middle;display: inline-block;line-height: 47px;margin-right:10px;}
.gapi-analytics-data-chart-styles-table-td{font-size:14px !important;}
h3.content-title{width: 40%;}
.view-mode-filters{margin-right:0px;}
.tfb{font-weight: bold !important;}
.be .sb-search-input{border:0;}
svg > g:last-child > g:last-child {pointer-events: none;}
.loadmask-msg div:before{font-size: 14px;}
#view-limits input{max-width: 50px; padding: 0 5px;margin-bottom: 0; height: 32px; margin-right: 10px; margin-top: 7px;}
#lb-wrapper .responsive-accordion-panel {display: flex;}
.fancybox-inner #lb-wrapper .responsive-accordion-panel {display: block;}
#lb-wrapper {position: relative; padding:0; display: inline-block; background-color: #fff; width: 100%;}
.fancybox-inner #lb-wrapper {padding: 0 20px; background-color: #fff;}
#lb-wrapper h3.content-title{width: 95%;font-size: 16px;}
.fancybox-inner #lb-wrapper h3.content-title{width: 95%;font-size: 16px;}
#lb-wrapper .open-close-reports {display: inline-block; float: right; margin-bottom: 10px;margin-top: 10px;}
#lb-wrapper .greyed-out{color: darkgrey; margin-left: 10px; font-size: 14px;}
.fancybox-inner #lb-wrapper .greyed-out{color: #999; margin-left: 0px;}
#lb-wrapper .rep-info{color: black; margin-left: 10px;}
#lb-wrapper .rep-amt{color: cadetblue; margin-left: 10px;}
.views-details li {margin-left: 9px; font-size: 14px;}
.views-details li i{margin-right: 10px;}
.err-red, .conf-green {font-size: 14px;}
.err-red {color:red;}
.conf-green {color:green;}
.tabs nav ul, .content-wrap section, .tabs-style-topline {max-width: none;}
.content-current ul.responsive-accordion:first-child{margin-top: 10px;}
.tabs-style-topline nav li.tab-current a{background-color: #fff;}
.tabs-style-topline nav a span {font-size: 14px;}
#section-paid, #section-unpaid, #section-all {min-height: 100px;}
#info-text{position: absolute; top: 13px; font-size: 15px;}
.r-image{max-width: 70%; display:inline-block; height: auto;}
.views-details.views-thumbs{float: left;display: inline-block; width: 60%;}
.tpl_subscribers .expand-entry {margin-top: 15px;}
.dark #lb-wrapper .rep-info{color:#d0d0d0;}
.dark .sb-search-fe {border: 1px solid #000;}
.dark .sb-icon-search-fe {border: 1px solid #303030; background: #000;}
.dark .tabs-style-topline nav li.tab-current a{background-color: #000;}
.dark #lb-wrapper {background-color: #131313;}
.toggle-all-filters {display: inline-block;margin-top: 20px;margin-right: 15px;cursor:pointer;display: none;}
.mt7{margin-top:7px;}
#search-boxes{float:right}
.dark #time-sort-filters, .dark #week-sort-filters { border-bottom: 1px solid #2e2e2e; }
#time-sort-filters, #week-sort-filters { border-bottom: 1px solid #f0f0f0; }
@media (max-width:960px){.views-details.views-thumbs{width: 80%;}}
@media (max-width:1310px){#sb-search-fe,#sb-search-be{margin-right:10px;}#search-boxes{width: 100%; display: inline-block; margin-top:-7px; margin-bottom:3px; float: none;}}
@media (max-width:960px){#lb-wrapper .rep-wrap{display: block; width: 100%;margin-top: -20px;}#lb-wrapper .greyed-out{margin-left: 30px;}}
@media (max-width:920px){.sb-search-fe.sb-search-open{width: calc(100% - 20px)}#search-boxes .inner-search{width:100%}#sb-search-fe{margin-bottom:auto;}.inner-search,.search_holder_fe{width:auto}}
@media (max-width:860px){#time-sort-filters h3.content-title.content-filter{display: none}#time-sort-filters section.filter{float: left;}.toggle-all-filters{display: block;}section.filter,section.inner-search,#search-boxes{display:none;}h3.content-title{width: 100%; display: inline-block;}#search-boxes{margin-top:0}a[rel-def-off="1"]{display:none;}}
@media (max-width: 860px) { section.filter{display:block} .toggle-all-filters{display:none} h3.content-title{width:75%} }

@media (max-width:640px){
#info-text{font-size:13px;}
#v-tabs .responsive-accordion-panel .vs-column.half{width: 100%;display: inline-block;}
#v-tabs .responsive-accordion-panel, #lb-wrapper .responsive-accordion-panel{display: flex;}
#v-tabs .responsive-accordion-panel .vs-column.half.fit{margin-top: 7px;}
#lb-wrapper h3.content-title{white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:90%}
}
@media (max-width:470px){#sb-search-be{margin-right:10px}}


</style>
<?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>


<?php if ($_GET['rg'] == '' && $_GET['rp'] == '') {?>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_token/tpl_overview.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} else { ?>
	<?php echo $_smarty_tpl->tpl_vars['html_payouts']->value;?>

<?php }?>
</div>
<?php echo '<script'; ?>
>
<?php if ($_GET['rp']) {?>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_token/tpl_tokens_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_GET['rg']) {?>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_token/tpl_tokensrg_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
echo '</script'; ?>
><?php }
}

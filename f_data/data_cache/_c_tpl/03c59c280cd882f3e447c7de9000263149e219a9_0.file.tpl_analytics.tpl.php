<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:30:54
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_analytics.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8bfe246840_43038624',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03c59c280cd882f3e447c7de9000263149e219a9' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_analytics.tpl',
      1 => 1444942800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601e8bfe246840_43038624 (Smarty_Internal_Template $_smarty_tpl) {
?>            <div class="container cbp-spmenu-push">
                <div id="embed-api-auth-container" style="display: block; margin: 10px 0px;"></div>
                <div id="view-selector-container" style="display: none;"></div>
                <div id="active-users-container" style="display: none;"></div>
                <div class="clearfix"></div>
                
                <div class="vs-column half">
                	<div class="block">
                        	<header class="Titles">
                            		<h1 class="Titles-main">This Week vs Last Week (by sessions)</h1>
                            		<div class="Titles-sub"></div>
                        	</header>
                        	<figure class="Chartjs-figure" id="chart-1-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-1-container"></ol>
                    	</div>
                </div>
                    
                <div class="vs-column half fit">
                	<div class="block">
                        	<header class="Titles">
                            		<h1 class="Titles-main">This Month vs Last Month (by sessions)</h1>
                            		<div class="Titles-sub"></div>
                        	</header>
                        	<figure class="Chartjs-figure" id="chart-5-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-5-container"></ol>
                    	</div>
                </div>

                <div class="vs-column fourths">
                	<div class="block">
                        	<header class="Titles">
                            		<h1 class="Titles-main">Top Browsers (by pageviews)</h1>
                            		<div class="Titles-sub"></div>
                        	</header>
                        	<figure class="Chartjs-figure" id="chart-3-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-3-container"></ol>
                    	</div>
                </div>
                
                <div class="vs-column half">
                	<div class="block">
                        	<header class="Titles">
                            		<h1 class="Titles-main">This Year vs Last Year (by users)</h1>
                            		<div class="Titles-sub"></div>
                        	</header>
                        	<figure class="Chartjs-figure" id="chart-2-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-2-container"></ol>
                    	</div>
                </div>
                
                <div class="vs-column fourths fit">
                	<div class="block">
                        	<header class="Titles">
                            		<h1 class="Titles-main">Top Countries (by sessions)</h1>
                            		<div class="Titles-sub"></div>
                        	</header>
                        	<div id="chart-4-container"></div>
                    	</div>
                </div>
            </div>
<?php }
}

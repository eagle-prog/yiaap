<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:30:41
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_token/tpl_tokengraphs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8bf1554db0_87982789',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a43a596d18880a82dae84969b4a1174ff44968e4' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_token/tpl_tokengraphs.tpl',
      1 => 1557787440,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601e8bf1554db0_87982789 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url_be']->value;?>
/affiliate.css">
<style>

.cbp-spmenu-push.vs-column.rg{margin-top: 25px;}
.rev_earned{background:rgba(133, 187, 101, 1);}
.rev_shared{background:rgba(101, 133, 187, 1);}
.rev_total{background:rgba(155, 101, 187, 1);}
.timer-rev{margin-bottom:5px;font-size:30px;}
.dark #time-sort-filters, .dark #week-sort-filters{border-bottom: 1px solid #2e2e2e;}
#time-sort-filters,#week-sort-filters{border-bottom:1px solid #f0f0f0;}
.vs-column.rg .vs-column.fourths{margin-bottom:5px !important}

</style>
            <div class="container-off cbp-spmenu-push vs-column rg">
            <?php if ($_GET['f'] == '' || $_GET['f'] == "week" || $_GET['f'] == "month" || $_GET['f'] == "year") {?>
            <?php ob_start();
if ($_GET['f'] == '') {
echo "week";
} else {
echo smarty_modifier_sanitize($_GET['f']);
}
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('ff', $_prefixVariable1);?>
            	<div class="vs-column sixths">
                    <div class="rev_earned files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.estimated"),$_smarty_tpl);?>
</div>
                        <div class="timer-rev">$<?php echo $_smarty_tpl->tpl_vars['twearned']->value;?>
</div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-rev"><?php echo $_smarty_tpl->tpl_vars['twsubscriptions']->value;?>
</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchases"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-rev"><?php echo $_smarty_tpl->tpl_vars['twsubscribers']->value;?>
</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.customers"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="rev_total"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            	<div class="vs-column sixths">
                    <div class="rev_shared files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchased"),$_smarty_tpl);?>
</div>
                        <div class="timer-rev"><?php echo $_smarty_tpl->tpl_vars['twshared']->value;?>
</div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-rev"><?php echo $_smarty_tpl->tpl_vars['twsubscriptions']->value;?>
</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchases"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-rev"><?php echo $_smarty_tpl->tpl_vars['twsubscribers']->value;?>
</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.customers"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="rev_shared"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            	<div class="vs-column sixths">
                    <div class="rev_total files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.total.p"),$_smarty_tpl);?>
</div>
                        <div class="timer-rev">$<?php echo $_smarty_tpl->tpl_vars['twtotal']->value;?>
</div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-rev"><?php echo $_smarty_tpl->tpl_vars['twsubscriptions']->value;?>
</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchases"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-rev"><?php echo $_smarty_tpl->tpl_vars['twsubscribers']->value;?>
</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.customers"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="rev_total"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>

           	<div class="vs-column sixths">
                    <div class="rev_earned files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.estimated"),$_smarty_tpl);?>
</div>
                        <div class="timer-rev">$<?php echo $_smarty_tpl->tpl_vars['lwearned']->value;?>
</div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-rev"><?php echo $_smarty_tpl->tpl_vars['lwsubscriptions']->value;?>
</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchases"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-rev"><?php echo $_smarty_tpl->tpl_vars['lwsubscribers']->value;?>
</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.customers"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="rev_total"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            	<div class="vs-column sixths">
                    <div class="rev_shared files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchased"),$_smarty_tpl);?>
</div>
                        <div class="timer-rev"><?php echo $_smarty_tpl->tpl_vars['lwshared']->value;?>
</div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-rev"><?php echo $_smarty_tpl->tpl_vars['lwsubscriptions']->value;?>
</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchases"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-rev"><?php echo $_smarty_tpl->tpl_vars['lwsubscribers']->value;?>
</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.customers"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="rev_shared"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            	<div class="vs-column sixths fit">
                    <div class="rev_total files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.total.p"),$_smarty_tpl);?>
</div>
                        <div class="timer-rev">$<?php echo $_smarty_tpl->tpl_vars['lwtotal']->value;?>
</div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-rev"><?php echo $_smarty_tpl->tpl_vars['lwsubscriptions']->value;?>
</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchases"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-rev"><?php echo $_smarty_tpl->tpl_vars['lwsubscribers']->value;?>
</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.customers"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="rev_total"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="clearfix"></div><br>

                <div class="vs-column half">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-coin"></i> <?php if ($_GET['y'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head.month.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['y']);
} else {
if ($_GET['m'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head.month.nr"),$_smarty_tpl);
ob_start();
echo smarty_modifier_sanitize($_GET['m']);
$_prefixVariable2 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['mn']->value[$_prefixVariable2];
} else {
if ($_GET['w'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head.week.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['w']);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head1.".((string)$_smarty_tpl->tpl_vars['ff']->value)),$_smarty_tpl);
}
}
}?></h1>
                            <div class="filters-loading">Loading filters...</div>
                            <div class="Titles-sub icheck-box no-display">
                            <div class="vs-column full">
                            <div class="filter-wrap">
                            	<input type="checkbox" name="this_week_filter" value="e" class="this-week-filter" checked="checked"><label><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.estimated"),$_smarty_tpl);?>
</label>
                                <input type="checkbox" name="this_week_filter" value="t" class="this-week-filter" checked="checked"><label><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchased"),$_smarty_tpl);?>
</label>
                                <input type="checkbox" name="this_week_filter" value="s" class="this-week-filter" checked="checked"><label><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.total.p"),$_smarty_tpl);?>
</label>

                            	<button class="button-grey search-button form-button save-button button-blue save-entry-button graph-update" id="this-week-uploads" type="button" value="1" onfocus="blur();">
			    		<span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.apply"),$_smarty_tpl);?>
</span>
			    	</button>
                            </div>
                            </div>
                            </div>
                        </header>
                        <div class="clearfix"></div>
                        <figure class="Chartjs-figure" id="chart-1-container"></figure>
                        <ol class="Chartjs-legend" id="legend-1-container"></ol>
                    </div>
                </div>

                <div class="vs-column half fit">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-coin"></i> <?php if ($_GET['y'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head.month.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['y']-1);
} else {
if ($_GET['m'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head.month.nr"),$_smarty_tpl);
ob_start();
echo smarty_modifier_sanitize($_GET['m']-1);
$_prefixVariable3 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['mn']->value[$_prefixVariable3];
} else {
if ($_GET['w'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head.week.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['w']-1);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head2.".((string)$_smarty_tpl->tpl_vars['ff']->value)),$_smarty_tpl);
}
}
}?></h1>
                            <div class="filters-loading">Loading filters...</div>
                            <div class="Titles-sub icheck-box no-display">
                            <div class="vs-column full">
                            <div class="filter-wrap">
                            	<input type="checkbox" name="last_week_filter" value="e" class="last-week-filter" checked="checked"><label><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.estimated"),$_smarty_tpl);?>
</label>
                                <input type="checkbox" name="last_week_filter" value="t" class="last-week-filter" checked="checked"><label><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.purchased"),$_smarty_tpl);?>
</label>
                                <input type="checkbox" name="last_week_filter" value="s" class="last-week-filter" checked="checked"><label><?php echo smarty_function_lang_entry(array('key'=>"backend.sub.label.total.p"),$_smarty_tpl);?>
</label>

                            	<button class="button-grey search-button form-button save-button button-blue save-entry-button graph-update" id="last-week-uploads" type="button" value="1" onfocus="blur();">
			    		<span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.apply"),$_smarty_tpl);?>
</span>
			    	</button>
                            </div>
                            </div>
                            </div>
                        </header>
                        <div class="clearfix"></div>
                        <figure class="Chartjs-figure" id="chart-2-container"></figure>
                        <ol class="Chartjs-legend" id="legend-2-container"></ol>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="vs-column half">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-cart"></i> <?php if ($_GET['y'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.subs.month.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['y']);
} else {
if ($_GET['m'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.subs.month.nr"),$_smarty_tpl);
ob_start();
echo smarty_modifier_sanitize($_GET['m']);
$_prefixVariable4 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['mn']->value[$_prefixVariable4];
} else {
if ($_GET['w'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.subs.week.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['w']);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head3.".((string)$_smarty_tpl->tpl_vars['ff']->value)),$_smarty_tpl);
}
}
}?></h1>
                        </header>
                        <div class="clearfix"></div>
                        <figure class="Chartjs-figure" id="chart-1a-container"></figure>
                        <ol class="Chartjs-legend" id="legend-1a-container"></ol>
                    </div>
                </div>
                <div class="vs-column half fit">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-cart"></i> <?php if ($_GET['y'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.subs.month.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['y']-1);
} else {
if ($_GET['m'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.subs.month.nr"),$_smarty_tpl);
ob_start();
echo smarty_modifier_sanitize($_GET['m']-1);
$_prefixVariable5 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['mn']->value[$_prefixVariable5];
} else {
if ($_GET['w'] > 0) {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.subs.week.nr"),$_smarty_tpl);
echo smarty_modifier_sanitize($_GET['w']-1);
} else {
echo smarty_function_lang_entry(array('key'=>"backend.token.dash.head4.".((string)$_smarty_tpl->tpl_vars['ff']->value)),$_smarty_tpl);
}
}
}?></h1>
                        </header>
                        <div class="clearfix"></div>
                        <figure class="Chartjs-figure" id="chart-2a-container"></figure>
                        <ol class="Chartjs-legend" id="legend-2a-container"></ol>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php } else { ?>
                <div class="vs-column half">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-users"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.members.week"),$_smarty_tpl);?>
</h1>
                            <div class="Titles-sub">
                            </div>
                        </header>
                        <figure class="Chartjs-figure" id="chart-4-container"></figure>
                        <ol class="Chartjs-legend" id="legend-4-container"></ol>
                    </div>
                </div>
                
                <div class="vs-column half fit">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="iconBe-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.earn.year"),$_smarty_tpl);?>
</h1>
                            <div class="Titles-sub">
                            </div>
                        </header>
                        <figure class="Chartjs-figure" id="chart-8-container"></figure>
                        <ol class="Chartjs-legend" id="legend-8-container"></ol>
                    </div>
                </div>

		<div id="dash-dn">
                <div class="vs-column thirds stats">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-live"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.l"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['lcount']->value[0] == 0) {?><span class="small-text"><?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.none"),$_smarty_tpl);?>
</span><?php }?></h1>
                            <div class="Titles-sub">
                            </div>
                        </header>
                        <div class="vs-column half">
                        	<figure class="Chartjs-figure" id="chart-11-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-11-container"></ol>
                        </div>
                        <div class="vs-column half fit">
                        	<figure class="Chartjs-figure" id="chart-11a-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-11a-container"></ol>
                        </div>
                    </div>
                </div>

                <div class="vs-column thirds stats">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main">
                            	<i class="icon-video"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.v"),$_smarty_tpl);?>

                            	<?php if ($_smarty_tpl->tpl_vars['vcount']->value[0] == 0) {?><span class="small-text"><?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.none"),$_smarty_tpl);?>
</span><?php }?>
                            </h1>
                            <div class="Titles-sub"></div>
                        </header>
                        <div class="vs-column half">
                        	<figure class="Chartjs-figure" id="chart-3-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-3-container"></ol>
                        </div>
                        <div class="vs-column half fit">
                        	<figure class="Chartjs-figure" id="chart-3a-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-3a-container"></ol>
                        </div>
                    </div>
                </div>

                <div class="vs-column thirds stats fit">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-image"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.i"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['icount']->value[0] == 0) {?><span class="small-text"><?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.none"),$_smarty_tpl);?>
</span><?php }?></h1>
                            <div class="Titles-sub">
                            </div>
                        </header>
                        <div class="vs-column half">
                        	<figure class="Chartjs-figure" id="chart-6-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-6-container"></ol>
                        </div>
                        <div class="vs-column half fit">
                        	<figure class="Chartjs-figure" id="chart-6a-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-6a-container"></ol>
                        </div>
                    </div>
                </div>
                <div class="vs-column thirds stats">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-audio"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.a"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['acount']->value[0] == 0) {?><span class="small-text"><?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.none"),$_smarty_tpl);?>
</span><?php }?></h1>
                            <div class="Titles-sub">
                            </div>
                        </header>
                        <div class="vs-column half">
                        	<figure class="Chartjs-figure" id="chart-5-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-5-container"></ol>
                        </div>
                        <div class="vs-column half fit">
                        	<figure class="Chartjs-figure" id="chart-5a-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-5a-container"></ol>
                        </div>
                    </div>
                </div>

                <div class="vs-column thirds stats">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-file"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.d"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['dcount']->value[0] == 0) {?><span class="small-text"><?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.none"),$_smarty_tpl);?>
</span><?php }?></h1>
                            <div class="Titles-sub">
                            </div>
                        </header>
                        <div class="vs-column half">
                        	<figure class="Chartjs-figure" id="chart-7-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-7-container"></ol>
                        </div>
                        <div class="vs-column half fit">
                        	<figure class="Chartjs-figure" id="chart-7a-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-7a-container"></ol>
                        </div>
                    </div>
                </div>

                <div class="vs-column thirds fit stats">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-blog"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.b"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['bcount']->value[0] == 0) {?><span class="small-text"><?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.none"),$_smarty_tpl);?>
</span><?php }?></h1>
                            <div class="Titles-sub">
                            </div>
                        </header>
                        <div class="vs-column half">
                        	<figure class="Chartjs-figure" id="chart-9-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-9-container"></ol>
                        </div>
                        <div class="vs-column half fit">
                        	<figure class="Chartjs-figure" id="chart-9a-container"></figure>
                        	<ol class="Chartjs-legend" id="legend-9a-container"></ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php }?>
            </div><?php }
}

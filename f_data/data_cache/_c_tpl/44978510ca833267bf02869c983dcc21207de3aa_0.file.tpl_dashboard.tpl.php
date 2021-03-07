<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_dashboard.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f669aa2a1_24117043',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44978510ca833267bf02869c983dcc21207de3aa' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_dashboard.tpl',
      1 => 1526504400,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f669aa2a1_24117043 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
            <div class="container cbp-spmenu-push vs-column">
                <div class="vs-column sixths">
                    <div class="live_files files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.l.p.c"),$_smarty_tpl);?>
</div>
                        <i class="icon-live"></i>
                        <div class="timer-live"><?php if ($_smarty_tpl->tpl_vars['live_module']->value == "0") {
echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.module"),$_smarty_tpl);
} else { ?>0<?php }?></div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-live">0</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.active"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-live">0</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.inactive"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="live_files"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="vs-column sixths">
                    <div class="video_files files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.v.p.c"),$_smarty_tpl);?>
</div>
                        <i class="icon-video"></i>
                        <div class="timer-videos"><?php if ($_smarty_tpl->tpl_vars['video_module']->value == "0") {
echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.module"),$_smarty_tpl);
} else { ?>0<?php }?></div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-video">0</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.active"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-video">0</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.inactive"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="video_files"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="vs-column sixths">
                    <div class="image_files files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.i.p.c"),$_smarty_tpl);?>
</div>
                        <i class="icon-image"></i>
                        <div class="timer-images"><?php if ($_smarty_tpl->tpl_vars['image_module']->value == "0") {
echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.module"),$_smarty_tpl);
} else { ?>0<?php }?></div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-image">0</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.active"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-image">0</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.inactive"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="image_files"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="vs-column sixths">
                    <div class="audio_files files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.a.p.c"),$_smarty_tpl);?>
</div>
                        <i class="icon-audio"></i>
                        <div class="timer-audios"><?php if ($_smarty_tpl->tpl_vars['audio_module']->value == "0") {
echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.module"),$_smarty_tpl);
} else { ?>0<?php }?></div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-audio">0</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.active"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-audio">0</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.inactive"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="audio_files"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="vs-column sixths">
                    <div class="document_files files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.d.p.c"),$_smarty_tpl);?>
</div>
                        <i class="icon-file"></i>
                        <div class="timer-docs"><?php if ($_smarty_tpl->tpl_vars['document_module']->value == "0") {
echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.module"),$_smarty_tpl);
} else { ?>0<?php }?></div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-doc">0</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.active"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-doc">0</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.inactive"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="document_files"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="vs-column sixths fit">
                    <div class="blog_files files_holder">
                        <div class="counter_title"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.b.p.c"),$_smarty_tpl);?>
</div>
                        <i class="icon-blog"></i>
                        <div class="timer-blogs"><?php if ($_smarty_tpl->tpl_vars['blog_module']->value == "0") {
echo smarty_function_lang_entry(array('key'=>"backend.dashboard.stats.module"),$_smarty_tpl);
} else { ?>0<?php }?></div>
                        <div class="clearfix"></div>
                        <div class="small-timer small-timer-blog">0</div>
                        <div class="status active-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.active"),$_smarty_tpl);?>
</div>
                        <div class="small-inactive-timer small-inactive-timer-blog">0</div>
                        <div class="status inactive-status"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.inactive"),$_smarty_tpl);?>
</div>
                        <div class="close_but icon-times" rel-close="blog_files"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="vs-column half">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-upload"></i>  <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.file.this.week"),$_smarty_tpl);?>
</h1>
                            <?php if ($_smarty_tpl->tpl_vars['mod_total']->value > 1) {?>
                            <div class="filters-loading">Loading filters...</div>
                            <div class="Titles-sub icheck-box no-display">
                            <div class="vs-column full">
                            <div class="filter-wrap">
                            <?php if ($_smarty_tpl->tpl_vars['live_module']->value == "1") {?>
                                <input type="checkbox" name="this_week_filter" value="l" class="this-week-filter" checked="checked"><label><i class="icon-live"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['video_module']->value == "1") {?>
                                <input type="checkbox" name="this_week_filter" value="v" class="this-week-filter" checked="checked"><label><i class="icon-video"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['image_module']->value == "1") {?>
                                <input type="checkbox" name="this_week_filter" value="i" class="this-week-filter" checked="checked"><label><i class="icon-image"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['audio_module']->value == "1") {?>
                                <input type="checkbox" name="this_week_filter" value="a" class="this-week-filter" checked="checked"><label><i class="icon-audio"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['document_module']->value == "1") {?>
                                <input type="checkbox" name="this_week_filter" value="d" class="this-week-filter" checked="checked"><label><i class="icon-file"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['blog_module']->value == "1") {?>
                                <input type="checkbox" name="this_week_filter" value="b" class="this-week-filter" checked="checked"><label><i class="icon-blog"></i></label>
                            <?php }?>
                            	<button class="button-grey search-button form-button save-button button-blue save-entry-button graph-update" id="this-week-uploads" type="button" value="1" onfocus="blur();">
			    		<span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.apply"),$_smarty_tpl);?>
</span>
			    	</button>
                            </div>
                            </div>
                            </div>
                            <?php }?>
                        </header>
                        <div class="clearfix"></div>
                        <figure class="Chartjs-figure" id="chart-1-container"></figure>
                        <ol class="Chartjs-legend" id="legend-1-container"></ol>
                    </div>
                </div>
                    
                <div class="vs-column half fit">
                    <div class="block">
                        <header class="Titles">
                            <h1 class="Titles-main"><i class="icon-upload"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.dashboard.file.last.week"),$_smarty_tpl);?>
</h1>
                            <?php if ($_smarty_tpl->tpl_vars['mod_total']->value > 1) {?>
                            <div class="filters-loading">Loading filters...</div>
                            <div class="Titles-sub icheck-box no-display">
                            <div class="vs-column full">
                            <div class="filter-wrap">
                            <?php if ($_smarty_tpl->tpl_vars['live_module']->value == "1") {?>
                                <input type="checkbox" name="last_week_filter" value="l" class="last-week-filter" checked="checked"><label><i class="icon-live"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['video_module']->value == "1") {?>
                                <input type="checkbox" name="last_week_filter" value="v" class="last-week-filter" checked="checked"><label><i class="icon-video"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['image_module']->value == "1") {?>
                                <input type="checkbox" name="last_week_filter" value="i" class="last-week-filter" checked="checked"><label><i class="icon-image"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['audio_module']->value == "1") {?>
                                <input type="checkbox" name="last_week_filter" value="a" class="last-week-filter" checked="checked"><label><i class="icon-audio"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['document_module']->value == "1") {?>
                                <input type="checkbox" name="last_week_filter" value="d" class="last-week-filter" checked="checked"><label><i class="icon-file"></i></label>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['blog_module']->value == "1") {?>
                                <input type="checkbox" name="last_week_filter" value="b" class="last-week-filter" checked="checked"><label><i class="icon-blog"></i></label>
                            <?php }?>
                            	<button class="button-grey search-button form-button save-button button-blue save-entry-button graph-update" id="last-week-uploads" type="button" value="1" onfocus="blur();">
			    		<span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.apply"),$_smarty_tpl);?>
</span>
			    	</button>
                            </div>
                            </div>
                            </div>
                            <?php }?>
                        </header>
                        <div class="clearfix"></div>
                        <figure class="Chartjs-figure" id="chart-2-container"></figure>
                        <ol class="Chartjs-legend" id="legend-2-container"></ol>
                    </div>
                </div>
                <div class="clearfix"></div>
                
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
            </div><?php }
}

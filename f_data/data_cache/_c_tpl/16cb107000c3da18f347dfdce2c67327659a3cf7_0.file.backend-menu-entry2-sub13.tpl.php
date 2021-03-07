<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:38:41
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub13.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8dd1cbd616_74699918',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '16cb107000c3da18f347dfdce2c67327659a3cf7' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub13.tpl',
      1 => 1543960800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-keep-open.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
    'file:f_scripts/be/js/jquery.nouislider.init.js' => 1,
  ),
),false)) {
function content_601e8dd1cbd616_74699918 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div>
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>

		<div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.approve",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry1_sub7_file_opt_approve",'input_value'=>$_smarty_tpl->tpl_vars['file_approval']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.views",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry1_sub7_file_opt_views",'input_value'=>$_smarty_tpl->tpl_vars['file_views']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.del",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub7_file_opt_del",'input_value'=>$_smarty_tpl->tpl_vars['file_deleting']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet15",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.promo",'entry_id'=>"ct-entry-details15",'input_name'=>"backend_menu_entry1_sub7_file_opt_promo",'input_value'=>$_smarty_tpl->tpl_vars['file_promo']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.fav",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry1_sub7_file_opt_fav",'input_value'=>$_smarty_tpl->tpl_vars['file_favorites']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.pl",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry1_sub7_file_opt_pl",'input_value'=>$_smarty_tpl->tpl_vars['file_playlists']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.comm",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub7_file_opt_comm",'input_value'=>$_smarty_tpl->tpl_vars['file_comments']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet20",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub6.comments.cons.f",'entry_id'=>"ct-entry-details20",'input_name'=>"backend_menu_entry1_sub6_comments_cons_f",'input_value'=>$_smarty_tpl->tpl_vars['fcc_limit']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.vote",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry1_sub7_file_opt_vote",'input_value'=>$_smarty_tpl->tpl_vars['file_comment_votes']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet22",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.spam",'entry_id'=>"ct-entry-details22",'input_name'=>"backend_menu_entry1_sub7_file_opt_spam",'input_value'=>$_smarty_tpl->tpl_vars['file_comment_spam']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet21",'input_type'=>"minmax",'entry_title'=>"backend.menu.entry1.sub6.comments.length.f",'entry_id'=>"ct-entry-details21",'input_name'=>"backend_menu_entry1_sub6_comments_length_f",'input_value'=>"file_comment_length",'bb'=>1),$_smarty_tpl);?>

            	</div>
            	<div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet13",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.history",'entry_id'=>"ct-entry-details13",'input_name'=>"backend_menu_entry1_sub7_file_opt_history",'input_value'=>$_smarty_tpl->tpl_vars['file_history']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet14",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.watchlist",'entry_id'=>"ct-entry-details14",'input_name'=>"backend_menu_entry1_sub7_file_opt_watchlist",'input_value'=>$_smarty_tpl->tpl_vars['file_watchlist']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.privacy",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_entry1_sub7_file_opt_privacy",'input_value'=>$_smarty_tpl->tpl_vars['file_privacy']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.rate",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry1_sub7_file_opt_rate",'input_value'=>$_smarty_tpl->tpl_vars['file_rating']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.resp",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_entry1_sub7_file_opt_resp",'input_value'=>$_smarty_tpl->tpl_vars['file_responses']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet16",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.down",'entry_id'=>"ct-entry-details16",'input_name'=>"backend_menu_entry1_sub7_file_opt_down",'input_value'=>$_smarty_tpl->tpl_vars['file_downloads']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet11",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.embed",'entry_id'=>"ct-entry-details11",'input_name'=>"backend_menu_entry1_sub7_file_opt_embed",'input_value'=>$_smarty_tpl->tpl_vars['file_embedding']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet17",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.flag",'entry_id'=>"ct-entry-details17",'input_name'=>"backend_menu_entry1_sub7_file_opt_flag",'input_value'=>$_smarty_tpl->tpl_vars['file_flagging']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet12",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.social",'entry_id'=>"ct-entry-details12",'input_name'=>"backend_menu_entry1_sub7_file_opt_social",'input_value'=>$_smarty_tpl->tpl_vars['file_social_sharing']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet18",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.file",'entry_id'=>"ct-entry-details18",'input_name'=>"backend_menu_entry1_sub7_file_opt_file",'input_value'=>$_smarty_tpl->tpl_vars['file_email_sharing']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet19",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub7.file.opt.perma",'entry_id'=>"ct-entry-details19",'input_name'=>"backend_menu_entry1_sub7_file_opt_perma",'input_value'=>$_smarty_tpl->tpl_vars['file_permalink_sharing']->value,'bb'=>0),$_smarty_tpl);?>

	    	</div>
	    	<div class="clearfix"></div>
	    <div>
		<div class="sortings left-half"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-keep-open.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-switch-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/jquery.nouislider.init.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function () {
        	$('.icheck-box input').each(function () {
            		var self = $(this);
            		self.iCheck({
                		checkboxClass: 'icheckbox_square-blue',
                		radioClass: 'iradio_square-blue',
                		increaseArea: '20%'
                		
            		});
        	});
        	$('#slider-backend_menu_entry1_sub6_comments_cons_f').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['fcc_limit']->value;?>
 ], step: 1, range: { 'min': [ 0 ], 'max': [ 100 ] }, format: wNumb({ decimals: 0 }) });
        	$("#slider-backend_menu_entry1_sub6_comments_cons_f").Link('lower').to($('#ct-entry-details20-input'));
        	$("#slider-backend_menu_entry1_sub6_comments_length_f_min").noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['file_comment_min_length']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 100 ] }, format: wNumb({ decimals: 0 }) });
        	$("#slider-backend_menu_entry1_sub6_comments_length_f_min").Link('lower').to($("input[name='backend_menu_entry1_sub6_comments_length_f_min']"));
        	$("#slider-backend_menu_entry1_sub6_comments_length_f_max").noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['file_comment_max_length']->value;?>
 ], step: 1, range: { 'min': [ 10 ], 'max': [ 1000 ] }, format: wNumb({ decimals: 0 }) });
        	$("#slider-backend_menu_entry1_sub6_comments_length_f_max").Link('lower').to($("input[name='backend_menu_entry1_sub6_comments_length_f_max']"));
    	});
	<?php echo '</script'; ?>
><?php }
}

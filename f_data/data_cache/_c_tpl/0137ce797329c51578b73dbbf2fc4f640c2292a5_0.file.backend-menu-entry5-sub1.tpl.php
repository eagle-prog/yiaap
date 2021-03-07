<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:31:15
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry5-sub1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8c13a56389_97603534',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0137ce797329c51578b73dbbf2fc4f640c2292a5' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry5-sub1.tpl',
      1 => 1541196000,
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
function content_601e8c13a56389_97603534 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div>
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry2.sub1.section",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_members_entry2_sub1_section",'input_value'=>$_smarty_tpl->tpl_vars['public_channels']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet11",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry2.sub1.views",'entry_id'=>"ct-entry-details11",'input_name'=>"backend_menu_members_entry2_sub1_views",'input_value'=>$_smarty_tpl->tpl_vars['channel_views']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub6.comments.chan",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub6_comments_chan",'input_value'=>$_smarty_tpl->tpl_vars['channel_comments']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub6.comments.cons.c",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry1_sub6_comments_cons_c",'input_value'=>$_smarty_tpl->tpl_vars['ucc_limit']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"minmax",'entry_title'=>"backend.menu.entry1.sub6.comments.length.c",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry1_sub6_comments_length_c",'input_value'=>"comment_length",'bb'=>1),$_smarty_tpl);?>

            </div>
            <div class="vs-column half fit vs-mask">
            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry2.sub1.follows",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_members_entry2_sub1_follows",'input_value'=>$_smarty_tpl->tpl_vars['user_follows']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry2.sub1.bgimage",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_members_entry2_sub1_bgimage",'input_value'=>$_smarty_tpl->tpl_vars['channel_backgrounds']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry2.sub1.bulletins",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_members_entry2_sub1_bulletins",'input_value'=>$_smarty_tpl->tpl_vars['channel_bulletins']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"text",'entry_title'=>"backend.menu.members.entry2.sub1.avatar",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_members_entry2_sub1_avatar",'input_value'=>$_smarty_tpl->tpl_vars['user_image_allowed_extensions']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"text",'entry_title'=>"backend.menu.members.entry2.sub1.bg",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_members_entry2_sub1_bg",'input_value'=>$_smarty_tpl->tpl_vars['channel_bg_allowed_extensions']->value,'bb'=>0),$_smarty_tpl);?>

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
	$(document).ready(function() {
		$('#slider-backend_menu_entry1_sub6_comments_cons_c').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['ucc_limit']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 20 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_entry1_sub6_comments_cons_c").Link('lower').to($("input[name='backend_menu_entry1_sub6_comments_cons_c']"));
		$('#slider-backend_menu_entry1_sub6_comments_length_c_min').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['comment_min_length']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 100 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_entry1_sub6_comments_length_c_min").Link('lower').to($("input[name='backend_menu_entry1_sub6_comments_length_c_min']"));
		$('#slider-backend_menu_entry1_sub6_comments_length_c_max').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['comment_max_length']->value;?>
 ], step: 1, range: { 'min': [ 10 ], 'max': [ 1000 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_entry1_sub6_comments_length_c_max").Link('lower').to($("input[name='backend_menu_entry1_sub6_comments_length_c_max']"));
		$('#slider-backend_menu_members_entry2_sub1_avatar_size').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['user_image_max_size']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 10 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_members_entry2_sub1_avatar_size").Link('lower').to($("input[name='backend_menu_members_entry2_sub1_avatar_size']"));
		$('#slider-backend_menu_members_entry2_sub1_bg_size').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['channel_bg_max_size']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 10 ] }, format:wNumb({ decimals: 0 }) });
		$("#slider-backend_menu_members_entry2_sub1_bg_size").Link('lower').to($("input[name='backend_menu_members_entry2_sub1_bg_size']"));
	});
	<?php echo '</script'; ?>
><?php }
}

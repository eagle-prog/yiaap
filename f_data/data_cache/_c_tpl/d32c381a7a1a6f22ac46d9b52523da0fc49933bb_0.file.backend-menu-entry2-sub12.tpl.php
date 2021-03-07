<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:56:02
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub12.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d94c250bd82_34596631',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd32c381a7a1a6f22ac46d9b52523da0fc49933bb' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub12.tpl',
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
function content_601d94c250bd82_34596631 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div>
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="clearfix"></div>
		<div class="vs-column full php-settings info-message-text" style="margin-bottom: 15px;"></div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"text",'entry_title'=>"backend.menu.entry1.sub7.file.multi",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry1_sub7_file_multi",'input_value'=>$_smarty_tpl->tpl_vars['multiple_file_uploads']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch_types",'entry_title'=>"backend.menu.entry1.sub7.file.video",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry1_sub7_file_video",'input_value'=>$_smarty_tpl->tpl_vars['video_uploads']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch_types",'entry_title'=>"backend.menu.entry1.sub7.file.image",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry1_sub7_file_image",'input_value'=>$_smarty_tpl->tpl_vars['image_uploads']->value,'bb'=>1),$_smarty_tpl);?>

            </div>
            <div class="vs-column half fit vs-mask">
            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch_types",'entry_title'=>"backend.menu.entry1.sub7.file.audio",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub7_file_audio",'input_value'=>$_smarty_tpl->tpl_vars['audio_uploads']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"switch_types",'entry_title'=>"backend.menu.entry1.sub7.file.doc",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry1_sub7_file_doc",'input_value'=>$_smarty_tpl->tpl_vars['document_uploads']->value,'bb'=>1),$_smarty_tpl);?>

            <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"switch_types",'entry_title'=>"backend.menu.entry1.sub7.file.category",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_entry1_sub7_file_category",'input_value'=>$_smarty_tpl->tpl_vars['upload_category']->value,'bb'=>1),$_smarty_tpl);?>

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
	<?php echo '<script'; ?>
 type="text/javascript">
	    $(document).ready(function() {
		$(".php-settings").html('<?php echo insert_phpInfoText(array(),$_smarty_tpl);?>').click(function(){$(this).detach();});
	    });
	<?php echo '</script'; ?>
>
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
                $('#slider-backend_menu_entry1_sub7_file_video_size').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['video_limit']->value;?>
 ], step: 1, range: { 'min': [ 10 ], 'max': [ 5000 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub7_file_video_size").Link('lower').to($("input[name='backend_menu_entry1_sub7_file_video_size']"));
                $('#slider-backend_menu_entry1_sub7_file_image_size').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['image_limit']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 100 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub7_file_image_size").Link('lower').to($("input[name='backend_menu_entry1_sub7_file_image_size']"));
                $('#slider-backend_menu_entry1_sub7_file_audio_size').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['audio_limit']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 500 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub7_file_audio_size").Link('lower').to($("input[name='backend_menu_entry1_sub7_file_audio_size']"));
                $('#slider-backend_menu_entry1_sub7_file_doc_size').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['document_limit']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 100 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub7_file_doc_size").Link('lower').to($("input[name='backend_menu_entry1_sub7_file_doc_size']"));
                $('#slider-backend_menu_entry1_sub7_file_multi').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['multiple_file_uploads']->value;?>
 ], step: 1, range: { 'min': [ 0 ], 'max': [ 50 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub7_file_multi").Link('lower').to($("input[name='backend_menu_entry1_sub7_file_multi']"));
        });
        <?php echo '</script'; ?>
>
<?php }
}

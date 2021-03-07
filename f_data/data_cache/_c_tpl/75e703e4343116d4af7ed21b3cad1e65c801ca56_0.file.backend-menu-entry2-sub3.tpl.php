<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:55:37
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub3.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d94a974c4d4_71468251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '75e703e4343116d4af7ed21b3cad1e65c801ca56' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub3.tpl',
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
    'file:tpl_backend/tpl_settings/ct-actions-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
    'file:f_scripts/be/js/jquery.nouislider.init.js' => 1,
  ),
),false)) {
function content_601d94a974c4d4_71468251 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
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
    	    <?php echo smarty_function_generate_html(array('input_type'=>"video_sitemap",'bullet_id'=>"ct-bullet2",'entry_id'=>"ct-entry-details2",'entry_title'=>"backend.menu.entry1.sub11.sitemap.video",'bb'=>1),$_smarty_tpl);?>

    	    <?php echo smarty_function_generate_html(array('input_type'=>"image_sitemap",'bullet_id'=>"ct-bullet3",'entry_id'=>"ct-entry-details3",'entry_title'=>"backend.menu.entry1.sub11.sitemap.image",'bb'=>0),$_smarty_tpl);?>

    	    </div>
    	    <div class="vs-column half fit vs-mask">
    	    <?php echo smarty_function_generate_html(array('input_type'=>"global_sitemap",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'entry_title'=>"backend.menu.entry1.sub11.sitemap.global",'bb'=>1),$_smarty_tpl);?>

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
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-actions-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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
        var main_url = "<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
";
        $(document).ready(function(){
	    $(".sitemap-rebuild").unbind().on("click", function () {
    		$(".container").mask("");
    		$.post(current_url + menu_section + '?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=global-sitemap', $("#ct-set-form").serialize(), function(data) {
                    $("#ct-wrapper").html(data);
                    $(".container").unmask();
                });
    	    });
    	    $(".sitemap-video-rebuild").unbind().on("click", function () {
    		$(".container").mask("");
    		$.post(current_url + menu_section + '?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=video-sitemap', $("#ct-set-form").serialize(), function(data) {
                    $("#ct-wrapper").html(data);
                    $(".container").unmask();
                });
    	    });
    	    $(".sitemap-image-rebuild").unbind().on("click", function () {
                $(".container").mask("");
                $.post(current_url + menu_section + '?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=image-sitemap', $("#ct-set-form").serialize(), function(data) {
                    $("#ct-wrapper").html(data);
                    $(".container").unmask();
                });
            });
        });
	<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function(){
                $('.icheck-box input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        });
                });
                $('#slider-sm_max_entries').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['sitemap_global_max']->value;?>
 ], step: 1, range: { 'min': [ 10 ], 'max': [ 45000 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-sm_max_entries").Link('lower').to($("input[name='sm_max_entries']"));
                $('#slider-sm_max_video').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['sitemap_video_max']->value;?>
 ], step: 1, range: { 'min': [ 10 ], 'max': [ 45000 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-sm_max_video").Link('lower').to($("input[name='sm_max_video']"));
                $('#slider-sm_max_image').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['sitemap_image_max']->value;?>
 ], step: 1, range: { 'min': [ 10 ], 'max': [ 1000 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-sm_max_image").Link('lower').to($("input[name='sm_max_image']"));
        });
        <?php echo '</script'; ?>
>
        <?php }
}

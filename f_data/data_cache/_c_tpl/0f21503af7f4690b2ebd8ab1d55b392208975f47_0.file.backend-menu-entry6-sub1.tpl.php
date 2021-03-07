<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:40:08
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry6-sub1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c3178502296_12833951',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f21503af7f4690b2ebd8ab1d55b392208975f47' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry6-sub1.tpl',
      1 => 1568299343,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_frontend/tpl_file/tpl_search_inner_be.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-actions-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
  ),
),false)) {
function content_601c3178502296_12833951 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),3=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.fetch.php','function'=>'smarty_function_fetch',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript">var menu_section = '<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
';<?php echo '</script'; ?>
>
	<div class="wdmax entry-list" id="ct-wrapper">
	    <div class="section-top-bar<?php if ($_GET['do'] == "add") {?>-add<?php }?> left-float top-bottom-padding">
            	<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
            	<div class="page-actions">
            		<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                	<div class="search-hold">
                		<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_file/tpl_search_inner_be.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                	</div>
            	</div>
            	<div class="clearfix"></div>
    	    </div>
    	    <div class="clearfix"></div>
            
    	    <?php echo smarty_function_generate_html(array('type'=>"file_manager_video",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'bb'=>1),$_smarty_tpl);?>

            
    	    <div id="thumb-response"></div>
    	    <input type="hidden" id="p-user-key" name="p_user_key" value="<?php echo smarty_modifier_sanitize($_GET['u']);?>
" />
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
 type="text/javascript">var _base = "<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
";<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['video_player']->value == "jw") {?>
        <?php echo '<script'; ?>
 type="text/javascript">jwplayer.key="<?php echo $_smarty_tpl->tpl_vars['jw_license_key']->value;?>
";<?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['video_player']->value == "flow") {?>
        <?php echo '<script'; ?>
 type="text/javascript"><?php echo smarty_function_fetch(array('file'=>"f_scripts/shared/flowplayer/flowplayer5.js"),$_smarty_tpl);
echo '</script'; ?>
>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/f_scripts/shared/flowplayer/minimalist.css">
<?php }?>

        <?php echo '<script'; ?>
 type="text/javascript">
        $(document).ready(function () {
            $(".thumb-reset").click(function(){
                var filekey = $(this).attr("rel");
                $("#file-entry-form"+filekey).mask(" ");
                $("#thumb-response").load(current_url + menu_section + "?do=thumb-reset&f="+filekey, function() {
                    $("#file-entry-form"+filekey).unmask();
                });
            });
            $(".preview-reset").click(function(){
                var filekey = $(this).attr("rel");
                $("#file-entry-form"+filekey).mask(" ");
                $("#thumb-response").load(current_url + menu_section + "?do=preview-reset&f="+filekey, function() {
                    $("#file-entry-form"+filekey).unmask();
                });
            });

                $('.icheck-box input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        });
                });
                $('.icheck-box input').on('ifChecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', true); });
                $('.icheck-box input').on('ifUnchecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', false); });

        	$("#entry-action-buttons .dl-trigger").on("click", function(){
        		if ($("#entry-action-buttons ul.dl-menu").hasClass("dl-menuopen")) {
        		setTimeout(function () {
                                if ($("#file-time-actions ul.dl-menu").hasClass("dl-menuopen")) {
                                        $("#file-time-actions .dl-trigger").click();
                                }
                                if ($("#file-type-actions ul.dl-menu").hasClass("dl-menuopen")) {
                                        $("#file-type-actions .dl-trigger").click();
                                }
                                $("#choices-ipp_select").slideUp(300, function(){$('#ct-wrapper').unbind('click', bodyHideSelect);});
                        }, 100);
                        }
		});
        	$("#file-type-actions .dl-trigger").on("click", function(){
        		if ($("#file-type-actions ul.dl-menu").hasClass("dl-menuopen")) {
        		setTimeout(function () {
                                if ($("#file-time-actions ul.dl-menu").hasClass("dl-menuopen")) {
                                        $("#file-time-actions .dl-trigger").click();
                                }
                                if ($("#entry-action-buttons ul.dl-menu").hasClass("dl-menuopen")) {
                                        $("#entry-action-buttons .dl-trigger").click();
                                }
                                $("#choices-ipp_select").slideUp(300, function(){$('#ct-wrapper').unbind('click', bodyHideSelect);});
                        }, 100);
                        }
		});
        	$("#file-time-actions .dl-trigger").on("click", function(){
        		if ($("#file-time-actions ul.dl-menu").hasClass("dl-menuopen")) {
        		setTimeout(function () {
                                if ($("#file-type-actions ul.dl-menu").hasClass("dl-menuopen")) {
                                        $("#file-type-actions .dl-trigger").click();
                                }
                                if ($("#entry-action-buttons ul.dl-menu").hasClass("dl-menuopen")) {
                                        $("#entry-action-buttons .dl-trigger").click();
                                }
                                $("#choices-ipp_select").slideUp(300, function(){$('#ct-wrapper').unbind('click', bodyHideSelect);});
                        }, 100);
                        }
		});

        });
        <?php echo '</script'; ?>
><?php }
}

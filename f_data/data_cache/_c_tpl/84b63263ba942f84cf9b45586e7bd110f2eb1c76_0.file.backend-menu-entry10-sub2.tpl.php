<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:24
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry10-sub2.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6c177ef3_55523755',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84b63263ba942f84cf9b45586e7bd110f2eb1c76' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry10-sub2.tpl',
      1 => 1543960800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:f_scripts/be/js/settings-accordion.js' => 1,
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-cancel-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_frontend/tpl_file/tpl_search_inner_be.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-actions-js.tpl' => 1,
  ),
),false)) {
function content_601c2f6c177ef3_55523755 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript">var menu_section = '<?php echo smarty_function_href_entry(array('getKey'=>"be_members"),$_smarty_tpl);?>
';<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
	
	<div class="wdmax entry-list" id="ct-wrapper">
	    <div class="section-top-bar<?php if ($_GET['do'] == "add") {?>-add<?php } else { ?> vs-maskx<?php }?> left-float top-bottom-padding">
            	<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-cancel-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
            	<div class="page-actions">
            		<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            		<div class="search-hold">
            			<?php if ($_GET['do'] != "add") {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_file/tpl_search_inner_be.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
            		</div>
            	</div>
                <div class="clearfix"></div>
    	    </div>
    	    <div class="clearfix"></div>
            
    	    <div class="vs-mask"><?php echo smarty_function_generate_html(array('type'=>"user_accounts",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'bb'=>1),$_smarty_tpl);?>
</div>
            
            <?php if ($_GET['do'] == "add") {?>
            <div class="clearfix"></div>
            <div class="section-bottom-bar<?php if ($_GET['do'] == "add") {?>-add<?php } else { ?> vs-maskx<?php }?> left-float top-bottom-padding">
                <div class="clearfix"></div>
                <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
$_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-cancel-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
            </div>
            <?php }?>
	</div>

	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-switch-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-actions-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
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
>
<?php }
}

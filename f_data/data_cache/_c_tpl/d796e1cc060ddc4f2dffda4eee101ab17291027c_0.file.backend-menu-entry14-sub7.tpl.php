<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:30:17
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry14-sub7.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8bd90e0124_22424023',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd796e1cc060ddc4f2dffda4eee101ab17291027c' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry14-sub7.tpl',
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
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-actions-js.tpl' => 1,
  ),
),false)) {
function content_601e8bd90e0124_22424023 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
	<div class="wdmax entry-list" id="ct-wrapper">
	    <div class="section-top-bar<?php if ($_GET['do'] == "add") {?>-add<?php } else { ?> vs-maskx<?php }?> left-float top-bottom-padding">
                <div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-cancel-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                <div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

            <div class="vs-mask"><?php echo smarty_function_generate_html(array('type'=>"be_live_streaming",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'bb'=>1),$_smarty_tpl);?>
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
        });
        <?php echo '</script'; ?>
>
<?php }
}
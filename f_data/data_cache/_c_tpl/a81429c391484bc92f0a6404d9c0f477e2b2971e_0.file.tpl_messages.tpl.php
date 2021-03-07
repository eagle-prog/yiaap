<?php
/* Smarty version 3.1.33, created on 2021-02-08 14:00:59
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_msg/tpl_messages.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60218a6b3c1df5_45604194',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a81429c391484bc92f0a6404d9c0f477e2b2971e' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_msg/tpl_messages.tpl',
      1 => 1553482920,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-actions-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
  ),
),false)) {
function content_60218a6b3c1df5_45604194 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?> <?php ob_start();
echo smarty_function_href_entry(array('key'=>"messages"),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable1);?> <?php }?>
	<?php $_smarty_tpl->assign('menu_entry' , insert_currentMenuEntry (array('for' => smarty_modifier_sanitize($_GET['s'])),$_smarty_tpl), true);?>
	<?php echo '<script'; ?>
 type="text/javascript">
            var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';
            var menu_section = '<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
';
            var fe_mask      = 'on';

            function thisresizeDelimiter(){}
	<?php echo '</script'; ?>
>
<?php if ($_GET['s'] == '') {?>
<div style="width:100%;height:100px;display:inline-block">&nbsp;</div>
<?php } else { ?>
        <div id="ct-wrapper" class="entry-list tpl-messages">
        	<article>
        		<h3 class="content-title"><i class="<?php echo $_smarty_tpl->tpl_vars['section_icon']->value;?>
"></i><?php echo $_smarty_tpl->tpl_vars['section_title']->value;?>
</h3>
        		<div class="line"></div>
        	</article>
            <div class="section-top-bar button-actions section-bottom-border left-float top-bottom-padding">
                <div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                <div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="vs-column full">
            <?php ob_start();
if ($_smarty_tpl->tpl_vars['menu_entry']->value != "message-menu-entry7") {
echo "pmsg_entry";
} else {
echo "contacts_layout";
}
$_prefixVariable2=ob_get_clean();
ob_start();
if ($_smarty_tpl->tpl_vars['menu_entry']->value != "message-menu-entry7") {
echo "messages";
}
$_prefixVariable3=ob_get_clean();
echo smarty_function_generate_html(array('type'=>$_prefixVariable2,'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'bb'=>"1",'section'=>$_prefixVariable3),$_smarty_tpl);?>

            </div>
            <div class="clearfix"></div>
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
 type="text/javascript">
	$(document).ready(function () {
		$('.icheck-box input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                //insert: '<div class="icheck_line-icon"></div><label>' + label_text + '</label>'
                        });
                });
                $('.icheck-box input.list-check, .icheck-box.ct input').on('ifChecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', true); });
                $('.icheck-box input.list-check, .icheck-box.ct input').on('ifUnchecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', false); });
                $(".icheck-box.ct input").on("ifChecked", function(event){ i = $(this).parent().parent().parent().attr("id"); $("#"+i+" .ct-entry-name").click();});
                $(".icheck-box.ct input").on("ifUnchecked", function(event){ i = $(this).parent().parent().parent().attr("id"); $("#"+i+" .ct-entry-check").click(); });
                $("#check-all").on("ifChecked", function(event){ $('.icheck-box.ct input').iCheck('check'); });
                $("#check-all").on("ifUnchecked", function(event){ $('.icheck-box.ct input').iCheck('uncheck'); });
	});
	<?php echo '</script'; ?>
>
<?php }
}
}

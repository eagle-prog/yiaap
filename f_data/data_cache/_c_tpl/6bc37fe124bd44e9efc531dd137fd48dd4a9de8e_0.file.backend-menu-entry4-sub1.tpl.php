<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:29:12
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry4-sub1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8b98212fe9_76343080',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6bc37fe124bd44e9efc531dd137fd48dd4a9de8e' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry4-sub1.tpl',
      1 => 1578358635,
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
  ),
),false)) {
function content_601e8b98212fe9_76343080 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry1.sub1.paid",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_members_entry1_sub1_paid",'input_value'=>$_smarty_tpl->tpl_vars['paid_memberships']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry1.sub3",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_members_entry1_sub3",'input_value'=>$_smarty_tpl->tpl_vars['discount_codes']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry1.sub1.subs",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_members_entry1_sub1_subs",'input_value'=>$_smarty_tpl->tpl_vars['user_subscriptions']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"text",'entry_title'=>"backend.menu.members.entry1.sub1.rev",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_members_entry1_sub1_rev",'input_value'=>$_smarty_tpl->tpl_vars['sub_shared_revenue']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet10",'input_type'=>"text",'entry_title'=>"backend.menu.members.entry1.sub1.threshold",'entry_id'=>"ct-entry-details10",'input_name'=>"backend_menu_members_entry1_sub1_threshold",'input_value'=>$_smarty_tpl->tpl_vars['sub_threshold']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet12",'input_type'=>"text",'entry_title'=>"backend.menu.members.entry1.tok1.threshold",'entry_id'=>"ct-entry-details12",'input_name'=>"backend_menu_members_entry1_tok1_threshold",'input_value'=>$_smarty_tpl->tpl_vars['token_threshold']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet11",'input_type'=>"partner_requirements",'entry_title'=>"backend.menu.pt.requirements",'entry_id'=>"ct-entry-details11",'input_name'=>"backend_menu_pt_requirements",'input_value'=>'','bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"text",'entry_title'=>"backend.menu.members.entry1.sub1.pp.mail",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_members_entry1_sub1_pp_mail",'input_value'=>$_smarty_tpl->tpl_vars['paypal_email']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry1.sub1.pp.test",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_members_entry1_sub1_pp_test",'input_value'=>$_smarty_tpl->tpl_vars['paypal_test']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"text",'entry_title'=>"backend.menu.members.entry1.sub1.pp.sb.mail",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_members_entry1_sub1_pp_sb_mail",'input_value'=>$_smarty_tpl->tpl_vars['paypal_test_email']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"switch",'entry_title'=>"backend.menu.members.entry1.sub1.pplog",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_members_entry1_sub1_pplog",'input_value'=>$_smarty_tpl->tpl_vars['paypal_logging']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"pp_api",'entry_title'=>"backend.menu.members.entry1.sub1.ppapi",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_members_entry1_sub1_ppapi",'input_value'=>1,'bb'=>0),$_smarty_tpl);?>

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
 type="text/javascript">
        $(function(){SelectList.init("backend_menu_pt_requirements_type");});
        $(document).ready(function () {
        	$('#slider-backend_menu_members_entry1_sub1_rev').html('<span class="">You will be sharing <b><span id="sub-share-nr"><?php echo $_smarty_tpl->tpl_vars['sub_shared_revenue']->value;?>
</span>%</b> from every paid channel subscription.</span>');
        	$('#ct-entry-details4-input').on('keyup', function() {var t=$(this).val();if(t<0)$(this).val(0);if(t>100)$(this).val(100);$('#sub-share-nr').text($(this).val());});
        });
        <?php echo '</script'; ?>
>

<?php }
}

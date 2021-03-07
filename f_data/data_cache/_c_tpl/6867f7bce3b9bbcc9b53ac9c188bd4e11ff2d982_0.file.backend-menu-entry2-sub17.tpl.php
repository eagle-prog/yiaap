<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:55:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub17.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d94962476c9_98216878',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6867f7bce3b9bbcc9b53ac9c188bd4e11ff2d982' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub17.tpl',
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
function content_601d94962476c9_98216878 (Smarty_Internal_Template $_smarty_tpl) {
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
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.section.access",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_section_access",'input_value'=>$_smarty_tpl->tpl_vars['global_signup']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"textarea",'entry_title'=>"backend.menu.close.message",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_close_message",'input_value'=>$_smarty_tpl->tpl_vars['disabled_signup_message']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"switch",'entry_title'=>"backend.menu.section.IPaccess",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_section_IPaccess",'input_value'=>$_smarty_tpl->tpl_vars['signup_ip_access']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php ob_start();
$_smarty_tpl->assign('iplist' , insert_getListContent (array('from' => 'ip-signup'),$_smarty_tpl), true);
$_prefixVariable1=ob_get_clean();
echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"textarea",'entry_title'=>"backend.menu.section.IPlist",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_section_IPlist",'input_value'=>$_prefixVariable1.((string)$_smarty_tpl->tpl_vars['iplist']->value),'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub1.mailres",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry1_sub1_mailres",'input_value'=>$_smarty_tpl->tpl_vars['signup_domain_restriction']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php ob_start();
$_smarty_tpl->assign('maillist' , insert_getListContent (array('from' => 'email-domains'),$_smarty_tpl), true);
$_prefixVariable2=ob_get_clean();
echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"textarea",'entry_title'=>"backend.menu.entry1.sub1.maillist",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry1_sub1_maillist",'input_value'=>$_prefixVariable2.((string)$_smarty_tpl->tpl_vars['maillist']->value),'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet18",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.fe.act.approval",'entry_id'=>"ct-entry-details18",'input_name'=>"backend_menu_entry1_sub2_fe_act_approval",'input_value'=>$_smarty_tpl->tpl_vars['account_approval']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet19",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub2.fe.act.mver",'entry_id'=>"ct-entry-details19",'input_name'=>"backend_menu_entry1_sub2_fe_act_mver",'input_value'=>$_smarty_tpl->tpl_vars['account_email_verification']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php ob_start();
$_smarty_tpl->assign('userlist' , insert_getListContent (array('from' => 'usernames'),$_smarty_tpl), true);
$_prefixVariable3=ob_get_clean();
echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet14",'input_type'=>"textarea",'entry_title'=>"backend.menu.entry1.sub1.userlist",'entry_id'=>"ct-entry-details14",'input_name'=>"backend_menu_entry1_sub1_userlist",'input_value'=>$_prefixVariable3.((string)$_smarty_tpl->tpl_vars['userlist']->value),'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet17",'input_type'=>"uformat",'entry_title'=>"backend.menu.entry1.sub1.uformat",'entry_id'=>"ct-entry-details17",'input_name'=>"backend_menu_entry1_sub1_uformat",'input_value'=>'','bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet11",'input_type'=>"minmax",'entry_title'=>"backend.menu.entry1.sub1.userlen",'entry_id'=>"ct-entry-details11",'input_name'=>"backend_menu_entry1_sub1_userlen",'input_value'=>"username_length",'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub1.uavail",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry1_sub1_uavail",'input_value'=>$_smarty_tpl->tpl_vars['signup_username_availability']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"switch",'entry_title'=>"backend.menu.entry1.sub1.pmeter",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry1_sub1_pmeter",'input_value'=>$_smarty_tpl->tpl_vars['signup_password_meter']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet12",'input_type'=>"minmax",'entry_title'=>"backend.menu.entry1.sub1.passlen",'entry_id'=>"ct-entry-details12",'input_name'=>"backend_menu_entry1_sub1_passlen",'input_value'=>"password_length",'bb'=>1),$_smarty_tpl);?>

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
                $('#slider-backend_menu_entry1_sub1_userlen_min').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['signup_min_username']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 20 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub1_userlen_min").Link('lower').to($("input[name='backend_menu_entry1_sub1_userlen_min']"));
                $('#slider-backend_menu_entry1_sub1_userlen_max').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['signup_max_username']->value;?>
 ], step: 1, range: { 'min': [ 1 ], 'max': [ 30 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub1_userlen_max").Link('lower').to($("input[name='backend_menu_entry1_sub1_userlen_max']"));

                $('#slider-backend_menu_entry1_sub1_passlen_min').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['signup_min_password']->value;?>
 ], step: 1, range: { 'min': [ 5 ], 'max': [ 20 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub1_passlen_min").Link('lower').to($("input[name='backend_menu_entry1_sub1_passlen_min']"));
                $('#slider-backend_menu_entry1_sub1_passlen_max').noUiSlider({ start: [ <?php echo $_smarty_tpl->tpl_vars['signup_max_password']->value;?>
 ], step: 1, range: { 'min': [ 5 ], 'max': [ 100 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-backend_menu_entry1_sub1_passlen_max").Link('lower').to($("input[name='backend_menu_entry1_sub1_passlen_max']"));
        });
	<?php echo '</script'; ?>
>
<?php }
}

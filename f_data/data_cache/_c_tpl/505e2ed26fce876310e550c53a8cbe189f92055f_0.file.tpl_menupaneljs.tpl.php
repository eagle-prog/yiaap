<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupaneljs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f669d42a4_47856729',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '505e2ed26fce876310e550c53a8cbe189f92055f' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupaneljs.tpl',
      1 => 1543960800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f669d42a4_47856729 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
	<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_settings" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_dashboard" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_analytics" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_upload" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_import") {?>
	    <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry2");?>
	    <?php $_smarty_tpl->_assignInScope('get_menu', "backend-menu-entry2");?>
	    <?php ob_start();
echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable1);?>
	    <?php $_smarty_tpl->_assignInScope('sub_menu', 0);?>
	<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>
	    <?php if ($_GET['u'][0] == "v" || $_GET['k'][0] == "v") {?>
		<?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry6-sub1");?>
		<?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
	    <?php } elseif ($_GET['u'][0] == "i" || $_GET['k'][0] == "i") {?>
                <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry6-sub2");?>
                <?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
            <?php } elseif ($_GET['u'][0] == "a" || $_GET['k'][0] == "a") {?>
                <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry6-sub3");?>
                <?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
            <?php } elseif ($_GET['u'][0] == "d" || $_GET['k'][0] == "d") {?>
                <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry6-sub4");?>
                <?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
            <?php } elseif ($_GET['u'][0] == "b" || $_GET['k'][0] == "b") {?>
                <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry6-sub5");?>
                <?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
            <?php } elseif ($_GET['u'][0] == "l" || $_GET['k'][0] == "l") {?>
                <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry6-sub6");?>
                <?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
	    <?php } else { ?>
		<?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry6");?>
		<?php $_smarty_tpl->_assignInScope('sub_menu', 0);?>
	    <?php }?>
	    <?php $_smarty_tpl->_assignInScope('get_menu', "backend-menu-entry6");?>
	    <?php ob_start();
echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable2);?>
	<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members") {?>
	    <?php if ($_GET['u'] != '') {?>
		<?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry10-sub2");?>
		<?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
	    <?php } else { ?>
		<?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry10");?>
		<?php $_smarty_tpl->_assignInScope('sub_menu', 0);?>
	    <?php }?>
	    <?php $_smarty_tpl->_assignInScope('get_menu', "backend-menu-entry10");?>
	    <?php ob_start();
echo smarty_function_href_entry(array('key'=>"be_members"),$_smarty_tpl);
$_prefixVariable3=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable3);?>
	<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_advertising") {?>
	    <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry8-sub2");?>
	    <?php $_smarty_tpl->_assignInScope('get_menu', "backend-menu-entry8");?>
	    <?php $_smarty_tpl->_assignInScope('sub_menu', 1);?>
	    <?php ob_start();
echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);
$_prefixVariable4=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable4);?>
	<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_players") {?>
	    <?php $_smarty_tpl->_assignInScope('get_from', "backend-menu-entry12");?>
	    <?php $_smarty_tpl->_assignInScope('get_menu', "backend-menu-entry12");?>
	    <?php $_smarty_tpl->_assignInScope('sub_menu', 0);?>
	    <?php ob_start();
echo smarty_function_href_entry(array('key'=>"be_players"),$_smarty_tpl);
$_prefixVariable5=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable5);?>
	<?php }?>
	<?php echo '<script'; ?>
 type="text/javascript">
	    var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/';
    	    var menu_section = '<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
';
    	    $(document).ready(function() {
    		var get_from = "<?php echo $_smarty_tpl->tpl_vars['get_from']->value;?>
";
    		var get_menu = "<?php echo $_smarty_tpl->tpl_vars['get_menu']->value;?>
";
    		<?php if ($_REQUEST['u'] != '' || $_REQUEST['k'] != '') {?>
    		wrapLoad(current_url+menu_section+"?s="+get_from+"<?php if ($_REQUEST['u'] != '') {?>&u=<?php echo smarty_modifier_sanitize($_REQUEST['u']);
}
if ($_REQUEST['k'] != '') {?>&k=<?php echo smarty_modifier_sanitize($_REQUEST['k']);
}
if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members" && $_GET['u'] != '') {?>&sq=<?php ob_start();
echo smarty_modifier_sanitize($_GET['u']);
$_prefixVariable6=ob_get_clean();
echo insert_getUserNameKey(array('key' => $_prefixVariable6),$_smarty_tpl);
}?>");
    		<?php }?>
    		/*$("h2").text($("#"+get_from+"a.active").text());*/
    	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'] != '') {?>
    		$(".sort-user-name").html("<?php ob_start();
echo smarty_modifier_sanitize($_GET['u']);
$_prefixVariable7=ob_get_clean();
echo insert_getUserNameKey(array('key' => $_prefixVariable7),$_smarty_tpl);?>");
    		$(".sort-user-key").html("<?php echo smarty_modifier_sanitize($_GET['u']);?>
");
    	    <?php }?>
    		$("#"+get_menu).addClass("menu-panel-entry-active");
    	    <?php if ($_smarty_tpl->tpl_vars['sub_menu']->value == "1") {?>
    		$("#"+get_from).addClass("menu-panel-entry-sub-active");
    	    <?php }?>
    	    });
	<?php echo '</script'; ?>
>
<?php }
}

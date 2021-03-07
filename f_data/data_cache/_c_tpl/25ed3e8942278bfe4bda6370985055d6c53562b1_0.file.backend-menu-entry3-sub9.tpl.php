<?php
/* Smarty version 3.1.33, created on 2021-02-06 12:23:29
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry3-sub9.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ed0917e9415_25363117',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '25ed3e8942278bfe4bda6370985055d6c53562b1' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry3-sub9.tpl',
      1 => 1541196000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
  ),
),false)) {
function content_601ed0917e9415_25363117 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
	<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/f_modules/m_backend/m_tools/m_linfo/layout/styles.css">
	<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/f_modules/m_backend/m_tools/m_linfo/layout/icons.css">
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/f_modules/m_backend/m_tools/m_linfo/layout/scripts.js"><?php echo '</script'; ?>
>
	<div class="wdmax" id="ct-wrapper">
	    <form id="ct-set-form" action="">
	    	<div class="page-actions" style="display: none;"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    	<div class="clearfix"></div>
		<div id="system-info-wrap" class="left-float wd738 top-bottom-padding "><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.entry3.sub9.system"),$_smarty_tpl);?>
</div>
		<input type="hidden" name="ct_entry" id="ct_entry" value="">
	    </form>
	    <?php echo '<script'; ?>
 type="text/javascript">
		$("#system-info-wrap").mask("loading");
		$.post("<?php echo smarty_function_href_entry(array('key'=>"be_system_info"),$_smarty_tpl);?>
", function(data){
		    $("#system-info-wrap").html(data);
		    
		    $(".page-actions").clone(true).detach().insertAfter("#system-info-wrap > div.header").show();
		    
		    var s = document.createElement("script");
		    s.type = "text/javascript";
		    s.src = "<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/f_modules/m_backend/m_tools/m_linfo/layout/settings-accordion.js";
		    $("head").append(s);
		    
		    resizeDelimiter();
		    $("#ct-wrapper").unmask();
		});
	    <?php echo '</script'; ?>
>
	</div>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-switch-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

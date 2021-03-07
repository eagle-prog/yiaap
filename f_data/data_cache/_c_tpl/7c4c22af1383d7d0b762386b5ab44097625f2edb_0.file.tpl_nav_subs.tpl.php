<?php
/* Smarty version 3.1.33, created on 2021-02-04 12:49:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_subs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c338e631ae0_99295922',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7c4c22af1383d7d0b762386b5ab44097625f2edb' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_subs.tpl',
      1 => 1547908920,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c338e631ae0_99295922 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
	<?php ob_start();
echo smarty_function_href_entry(array('key'=>"subscriptions"),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable1);?>
	<div id="menu-panel-wrapper" class="wdmax">
	    <?php echo insert_getUserSubs(array(),$_smarty_tpl);?>
	</div>
	<?php echo '<script'; ?>
 type="text/javascript">
	    var current_url ='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';var menu_section='<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
';var fe_mask='on';
	    $(document).ready(function() {
		var get_from = '';var h2t = '';var h2u = '';
		if(typeof($("#sub1-menu li.menu-panel-entry").attr("id")) !== 'undefined'){
		    get_from = $("#sub1-menu li.menu-panel-entry").attr("id");
		    h2t	= $("#sub1-menu li.menu-panel-entry:first span.mm").text();
		    h2u = "#ct-h2";
		} else if(typeof($("#sub2-menu li.menu-panel-entry").attr("id")) !== 'undefined'){
		    get_from = $("#sub2-menu li.menu-panel-entry").attr("id");
		    h2t	 = $("#sub2-menu li.menu-panel-entry:first span.mm").text();
		    h2u = "#ct-h3";
		}
	    });
	<?php echo '</script'; ?>
>
<?php }
}

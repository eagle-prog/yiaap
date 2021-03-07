<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:24
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_search_inner_be.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6c191486_58793135',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b721a161fc7f27a02b0370117c4b4066a7942521' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_search_inner_be.tpl',
      1 => 1459112400,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6c191486_58793135 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.fetch.php','function'=>'smarty_function_fetch',),));
?>
	<div id="sb-search" class="sb-search">
		<form name="file_search_form" id="file-search-form" method="get" action="">
			<input class="sb-search-input" placeholder="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.searchtext"),$_smarty_tpl);?>
" type="text" value="<?php echo smarty_modifier_sanitize($_GET['sq']);?>
" name="sq" id="sq" onclick="this.select()">
			<input class="sb-search-submit file-search" id="file-search-button" type="button" value="">
			<span title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.searchtext"),$_smarty_tpl);?>
" rel="tooltip" class="sb-icon-search">
			</span>
		</form>
	</div>
	<?php echo '<script'; ?>
 type="text/javascript"><?php echo smarty_function_fetch(array('file'=>"f_scripts/fe/js/uisearch.js"),$_smarty_tpl);
echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
	    new UISearch( document.getElementById( 'sb-search' ) );
	<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function(){
	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_servers") {?>
	    	$("#sq").autocomplete({
                type: "post",
                serviceUrl: current_url + menu_section +"?s=<?php echo smarty_modifier_sanitize($_REQUEST['s']);?>
&do=autocomplete",
                onSearchStart: function() {
                },
                onSelect: function (suggestion) {
                	$(".file-search").trigger("click");
                }
        });

	    <?php }?>
	    $(".file-search").click(function(){
		var u_url = (typeof($("#p-user-key").val()) != 'undefined') ? "&u="+$("#p-user-key").val() : "";
		var c_url = current_url + menu_section +"?s=<?php echo smarty_modifier_sanitize($_REQUEST['s']);?>
"+u_url+"&do="+$("#file-sort-div-val").val()+"&for="+$("#file-type-div-val").val();

		$("#file-search-form").attr("action", c_url);
		$(".container").mask("");
		$.get(c_url, $("#file-search-form").serialize(), function(data){;
		    $(".container").html(data);
		    $(".container").unmask();
		    resizeDelimiter();
		});
	    });
	    enterSubmit("#file-search-form input", "#file-search-button");
	});
	<?php echo '</script'; ?>
><?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-06 12:21:35
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_subscriber/tpl_search_inner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ed01f090567_23798762',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cdc56dbcba992cafeba3cb0b2c68d785ab4cf01e' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_subscriber/tpl_search_inner.tpl',
      1 => 1566838821,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601ed01f090567_23798762 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.fetch.php','function'=>'smarty_function_fetch',),));
?>
<div class="search_holder_fe">
	<div id="sb-search-fe" class="sb-search-fe<?php if ($_smarty_tpl->tpl_vars['is_mobile']->value) {?> sb-search-open<?php }?>">
		<form name="file_search_form" id="file-search-form" method="get" action="">
			<input class="sb-search-input" placeholder="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.searchtext"),$_smarty_tpl);?>
" type="text" value="<?php echo smarty_modifier_sanitize($_GET['sq']);?>
" name="sq" id="sq" onclick="this.select()">
			<input class="sb-search-submit file-search" id="file-search-button" type="button" value="">
			<i class="icon icon-search"></i>
			<span title="<?php echo smarty_function_lang_entry(array('key'=>"account.entry.search.users"),$_smarty_tpl);?>
" rel="tooltip" class="sb-icon-search-fe icon-search"></span>
		</form>
	</div>
</div>
	<?php echo '<script'; ?>
 type="text/javascript"><?php echo smarty_function_fetch(array('file'=>"f_scripts/fe/js/uisearch.js"),$_smarty_tpl);
echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
	new UISearch(document.getElementById('sb-search-fe'));
	
	$(document).ready(function(){
	    	$("#sq").autocomplete({
	    		showNoSuggestionNotice: true,
                	type: "post",
                	params: {"t": "sub" },
                	serviceUrl: "?a=1&t=sub&do=autocomplete",
                	onSearchStart: function() {},
                	onSearchComplete: function(query, suggestion) {},
                	onSelect: function (suggestion) {
                		if (typeof suggestion.data != 'undefined') {
                			var u = String(window.location);
                			u = u.replace('&uk=<?php echo smarty_modifier_sanitize($_GET['uk']);?>
', '');

                			$("#custom-date-form").attr("action", u + '&uk='+suggestion.data);
                                        $("#custom-date-form").submit();
                		}
                	}
        	});
        	$("#file-search-form").submit(function(e){e.preventDefault();});
	});
	<?php echo '</script'; ?>
><?php }
}

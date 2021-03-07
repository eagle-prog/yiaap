<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:30:54
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_search_inner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c759e9edea9_20568330',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f6efe38d65d7560db5b86635c387d43c4d8bc171' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_search_inner.tpl',
      1 => 1566838500,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c759e9edea9_20568330 (Smarty_Internal_Template $_smarty_tpl) {
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
			<span title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.searchtext"),$_smarty_tpl);?>
" rel="tooltip" class="sb-icon-search-fe icon-search">
			</span>
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
	$("#sq").keydown(function(){
	    	$("#sq").autocomplete({
                	type: "post",
                	params: {"t": $(".view-mode-type.active").attr("id").replace("view-mode-", "") },
                	serviceUrl: current_url + menu_section +"?s=" + $(".menu-panel-entry-active").attr("id") +"&do=autocomplete&m=0",
                	onSearchStart: function() {},
                	onSelect: function (suggestion) {
                		$(".file-search").trigger("click");
                	}
        	});
        });

	    $(".file-search").click(function(){
	    	var paging_link = '';
                                        <?php if ($_GET['page'] != '') {?>paging_link = '&page=<?php echo smarty_modifier_sanitize($_GET['page']);?>
&ipp=<?php echo smarty_modifier_sanitize($_GET['ipp']);?>
';<?php }?>
                                        var t = $(this);
                                        var a = t.attr("id");
                                        view_mode_type = $(".view-mode-type.active").attr("id").replace("view-mode-", "");
                                        id = jQuery(".content-current .main-view-mode-"+view_mode_type+".active").attr("id");
                                        type = jQuery(".content-current .main-view-mode-"+view_mode_type+".active").val();
                                        type_all = type + "-" + view_mode_type;
                                        nr = id.split("-");
                                        idnr = nr[3];
                                        c_url = current_url + menu_section + '?s=' + $(".menu-panel-entry-active").attr("id");
                                        c_url+= "&p=0&m="+idnr+"&sort="+type+"&t="+view_mode_type;
                                        p_str = "#main-view-mode-" + idnr + "-" + type_all + "-list ul:not(.playlist-entries):not(#pag-list)";
                                        var page = parseInt(jQuery("#main-view-mode-" + idnr + "-" + type_all + "-list .pag-wrap a.current").html());

                                        $("#main-view-mode-" + idnr + "-" + type_all + "-list #paging-bottom").detach();
        
                                        if (page > 1) {
                                                paging_link = "&page=" + page;
                                        }
                                        
                                        var post_url = c_url + "&a=" + a + paging_link;

                                        $('#cb-response').replaceWith(''); $('#cb-response-wrap').replaceWith('');

	    
	    
//		var u_url = (typeof($("#p-user-key").val()) != 'undefined') ? "&u="+$("#p-user-key").val() : "";
//		var c_url = current_url + menu_section +"?s=<?php echo smarty_modifier_sanitize($_REQUEST['s']);?>
"+u_url+"&do="+$("#file-sort-div-val").val()+"&for="+$("#file-type-div-val").val();

		$("#file-search-form").attr("action", c_url);
		$("#main-content").mask("");
		$.get(c_url, $("#file-search-form").serialize(), function(data){;
			jQuery(p_str).replaceWith(data);
			$("#cb-response-wrap").insertBefore("#view-type-content");
		    //$(".container").html(data);
		    
		    $("#main-content").unmask();
		    resizeDelimiter();
		    
		    setTimeout(function () {
                                                        ViewModeSizeSetFunctions();
                                                }, 100);
                                                setTimeout(function () {
                                                        thumbFade();
                                                }, 200);

		});
	    });
	    enterSubmit("#file-search-form input", "#file-search-button");
	});
	<?php echo '</script'; ?>
><?php }
}

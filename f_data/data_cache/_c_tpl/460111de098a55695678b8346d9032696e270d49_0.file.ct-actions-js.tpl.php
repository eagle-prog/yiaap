<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-actions-js.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b5ca061_19982054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '460111de098a55695678b8346d9032696e270d49' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-actions-js.tpl',
      1 => 1553990940,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b5ca061_19982054 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
	<?php if ($_GET['s'] != '') {
$_smarty_tpl->_assignInScope('get_s', smarty_modifier_sanitize($_GET['s']));
} else {
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files") {
$_smarty_tpl->assign('s' , insert_getCurrentSection (array(),$_smarty_tpl), true);
$_smarty_tpl->_assignInScope('get_s', $_smarty_tpl->tpl_vars['s']->value ,true);
}
}?>
	<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function() {
	    var paging_link = '';
	    <?php if ($_GET['page'] != '') {?>var paging_link = '&page=<?php echo smarty_modifier_sanitize($_GET['page']);?>
&ipp=<?php echo smarty_modifier_sanitize($_GET['ipp']);?>
';<?php }?>

	    $(".disable-grey").click(function(){
		var this_id = $(this).attr("id").replace("ic2-", "");
		var div_id = this_id;
		var form_id = <?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>"gen-file-actions";<?php } else { ?>$("#"+div_id+" form").attr("id");<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>
		    var c_id = div_id.split("-")[3];
		    $(".section_subject_value").val(c_id);
		    var crsection = $(".cr-tabs .tab-current").find("a").attr("href").split("-");
		    var crsort = crsection[1];
		    
		    var dis_url = current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['get_s']->value);?>
&do=<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7") {?>comm-<?php } elseif ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>resp-<?php }?>disable<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>&t="+$(".view-mode-type.active").attr("id").replace("view-mode-", "")+"&a=cr-"+crsort+"<?php }?>"+paging_link;

			$("#siteContent").mask("");
			$.post(dis_url, $( "#"+form_id ).serialize(), function(data) { 
				$("#siteContent").html(data);
				$("#siteContent").unmask();
				<?php if (($_GET['do'] != '' && $_GET['do'] != "cr-approved") || ($_GET['a'] != '' && $_GET['a'] != "cr-approved")) {?>
					$(".cr-tabs .tab-current:first").removeClass("tab-current");
				<?php }?>
				
				return;
			});
			return;
		<?php }?>
		var dis_url = current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['get_s']->value);?>
&do=<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7") {?>comm-<?php } elseif ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>resp-<?php }?>disable<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>&t="+$(".view-mode-type.active").attr("id").replace("view-mode-", "")+"&a=cr-"+crsort+"<?php }?>"+paging_link;
		$(".ct-entry").unbind('click');
		postLoad(dis_url, "#"+form_id, "#"+form_id+" .vs-mask");
	    });

	    $(".enable-grey").click(function(){
		var this_id = $(this).attr("id").replace("ic1-", "");
		var div_id = this_id;
		var form_id = <?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>"gen-file-actions";<?php } else { ?>$("#"+div_id+" form").attr("id");<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>
		    var c_id = div_id.split("-")[3];
		    $(".section_subject_value").val(c_id);
		    var crsection = $(".cr-tabs .tab-current").find("a").attr("href").split("-");
		    var crsort = crsection[1];
		    
		    var ena_url = current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['get_s']->value);?>
&do=<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7") {?>comm-<?php } elseif ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>resp-<?php }?>enable<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>&t="+$(".view-mode-type.active").attr("id").replace("view-mode-", "")+"&a=cr-"+crsort+"<?php }?>"+paging_link

		    	$("#siteContent").mask("");
			$.post(ena_url, $( "#"+form_id ).serialize(), function(data) { 
				$("#siteContent").html(data);
				$("#siteContent").unmask();
				<?php if (($_GET['do'] != '' && $_GET['do'] != "cr-approved") || ($_GET['a'] != '' && $_GET['a'] != "cr-approved")) {?>
					$(".cr-tabs .tab-current:first").removeClass("tab-current");
				<?php }?>
				
				return;
			});
			return;
		<?php }?>

		var ena_url = current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['get_s']->value);?>
&do=<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7") {?>comm-<?php } elseif ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>resp-<?php }?>enable<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>&t="+$(".view-mode-type.active").attr("id").replace("view-mode-", "")+"&a=cr-"+crsort+"<?php }?>"+paging_link

		$(".ct-entry").unbind('click');
		postLoad(ena_url, "#"+form_id, "#"+form_id+" .vs-mask");
	    });

	    $(".delete-grey").click(function(){
		$("#cb-response").click();
		var del_id  = $(this).attr("id");
		var this_id = $(this).attr("id").replace("ic3-", "");
		var div_id = this_id;
		div_id	    = div_id == 'cb-response' ? $("#"+del_id).parent("div").next("div").next("div").attr("id") : div_id;
		var form_id = <?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>"gen-file-actions";<?php } else { ?>$("#"+div_id+" form").attr("id");<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>
		    var c_id = div_id.split("-")[3];
		    $(".section_subject_value").val(c_id);

		    var crsection = $(".cr-tabs .tab-current").find("a").attr("href").split("-");
		    var crsort = crsection[1];
		    
		    var del_confirm = confirm('<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {
echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete.message"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete"),$_smarty_tpl);
}?>');
		    var del_url = current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['get_s']->value);?>
&do=<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7") {?>comm-<?php } elseif ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>resp-<?php }?>delete<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>&t="+$(".view-mode-type.active").attr("id").replace("view-mode-", "")+"&a=cr-"+crsort+"<?php }?>"+paging_link;
		    
		    if(del_confirm){

		    	$("#siteContent").mask("");
			$.post(del_url, $( "#"+form_id ).serialize(), function(data) { 
				$("#siteContent").html(data);
				$("#siteContent").unmask();
				<?php if (($_GET['do'] != '' && $_GET['do'] != "cr-approved") || ($_GET['a'] != '' && $_GET['a'] != "cr-approved")) {?>
					$(".cr-tabs .tab-current:first").removeClass("tab-current");
				<?php }?>
				
				return;
			});
			}
			
			return;
		<?php }?>
		var del_url = current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['get_s']->value);?>
&do=<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7") {?>comm-<?php } elseif ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>resp-<?php }?>delete<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {?>&for="+$("#file-type-div-val").val()+"&a="+$(".sort-active").attr("id")+"<?php }?>"+paging_link;
		var del_confirm = confirm('<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {
echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete.message"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete"),$_smarty_tpl);
}?>');

		if(del_confirm){
		    postLoad(del_url, "#"+form_id);
		    return false;
		}
		return false;
	    });

	    $(".reply-msg").click(function(){
		var form_id = $(this).parents("form").attr("id");
		postLoad(current_url + menu_section + "?do=compose&r=1<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "message-menu-entry3") {?>&f=comm<?php }?>", "#"+form_id);
	    });

	    $(".delete-msg").click(function(){
		var del_id = $(this).attr("id");
		var form_id = $("#"+del_id).parents("form").attr("id");

		var del_url = current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_smarty_tpl->tpl_vars['get_s']->value);?>
&do=delete"+paging_link;
		var del_confirm = confirm('<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {
echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete.message"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete"),$_smarty_tpl);
}?>');

		if(del_confirm){
		    postLoad(del_url, "#"+form_id);
		    return false;
		}
		return false;
	    });

	});
	<?php echo '</script'; ?>
>
<?php }
}

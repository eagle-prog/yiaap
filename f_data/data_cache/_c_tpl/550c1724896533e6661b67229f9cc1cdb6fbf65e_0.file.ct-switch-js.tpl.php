<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-switch-js.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b5a2de4_29926449',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '550c1724896533e6661b67229f9cc1cdb6fbf65e' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-switch-js.tpl',
      1 => 1543960800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b5a2de4_29926449 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript">
		function resizeDelimiter(){}
	    $(document).on({click: function () {
	    	var _id = "";
	    	if ($(".fancybox-wrap").width() > 0) {
	    		_id = ".fancybox-inner ";
	    	}

	    	$(_id + ".responsive-accordion div.responsive-accordion-head").addClass("active");
	    	$(_id + ".responsive-accordion div.responsive-accordion-panel").addClass("active").show();
	    	$(_id + ".responsive-accordion i.responsive-accordion-plus").hide();
	    	$(_id + ".responsive-accordion i.responsive-accordion-minus").show();
		thisresizeDelimiter();
	    }}, "#all-open");
	    
	    $(document).on({click: function () {
	    	var _id = "";
	    	if ($(".fancybox-wrap").width() > 0) {
	    		_id = ".fancybox-inner ";
	    	}

	    	$(_id + ".responsive-accordion div.responsive-accordion-head").removeClass("active");
	    	$(_id + ".responsive-accordion div.responsive-accordion-panel").removeClass("active").hide();
	    	$(_id + ".responsive-accordion i.responsive-accordion-plus").show();
	    	$(_id + ".responsive-accordion i.responsive-accordion-minus").hide();
		$("#ct_entry").val("");
		thisresizeDelimiter();
	    }}, "#all-close");

	$(document).ready(function() {
	$(".cb-enable").click(function(){
	    var parent = $(this).parents('.switch');
	    $('.cb-disable',parent).removeClass('selected');
	    $(this).addClass('selected');
	    $('.checkbox',parent).attr('checked', true);
	});

	$(".cb-disable").click(function(){
	    var parent = $(this).parents('.switch');
	    $('.cb-enable',parent).removeClass('selected');
	    $(this).addClass('selected');
	    $('.checkbox',parent).attr('checked', false);
	});


	    $(".ct-entry").click(function(e){
		var ct_id = $(this).attr("id");
		var en_id = $("#"+ct_id+">div.ct-entry-details").attr("id");
		var ct_target = e.target.type;
/*		if($.browser.msie && (ct_target == 'text' || ct_target == 'textarea' || ct_target == 'select-one')){
		    return;
		}
*/
	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_files") {?>
		if($("#" + ct_id + " div.responsive-accordion-head").hasClass("new-message")){
		<?php if ($_GET['s'] == "file-menu-entry7") {?>
		    var id_arr = ct_id.split("-");
		    $(".section_subject_value").val(id_arr[2]);
		<?php }?>
		    $.post(current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=read<?php if ($_GET['s'] == "file-menu-entry7") {?>&for="+$("#file-type-div-val").val()+"<?php }?>", <?php if ($_GET['s'] == "file-menu-entry7") {?>$(".entry-form-class").serialize()<?php } else { ?>$("#"+ct_id+" div.ct-entry-details form").serialize()<?php }?>, function(data){
			$("#" + ct_id + " div").removeClass("new-message");
			<?php $_smarty_tpl->assign('mm_entry' , insert_currentMenuEntry (array('for' => smarty_modifier_sanitize($_GET['s'])),$_smarty_tpl), true);?>
			switch("<?php echo $_smarty_tpl->tpl_vars['mm_entry']->value;?>
"){
			    case "message-menu-entry2": var tdiv = "#new-message-count"; break;
			    case "message-menu-entry3": var tdiv = "#new-comment-count"; break;
			    case "message-menu-entry4": var tdiv = "#new-invite-count"; break;
			}
			var tval = parseInt($(tdiv).html());
			if(tval > 0){
			    if(tval == 1){
				$(tdiv).html("");
				$(tdiv).parent().next().html("");
			    }else{
				$(tdiv).html(tval-1);
			    }
			}
			$(".col1").unmask();
		    });
		}
	    <?php }?>

		$(".ct-entry>div.ct-bullet-in").removeClass("ct-bullet-in");
		$(".ct-entry>div.ct-bullet-label").removeClass("bold");
		$(".ct-entry>div.ct-entry-details").hide();

		$("#" + ct_id + ">div.ct-bullet-out").addClass("ct-bullet-in");
		$("#" + ct_id + ">div.ct-bullet-label").addClass("bold");

		$("#"+en_id).show();
		$("#ct_entry").val(ct_id);

		thisresizeDelimiter();
	    });

	    $(".save-button").bind("click", function() {
		var p_url = <?php if ($_GET['s'] == "account-menu-entry4" || $_GET['s'] == "account-menu-entry6" || $_GET['s'] == "backend-menu-entry3-sub11") {?>current_url+menu_section+"?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
"<?php } else { ?>"<?php echo $_SERVER['REQUEST_URI'];?>
"<?php }?>;
		/*var trg = ($(".menu-panel-entry-active").attr("rel-m") == "<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
") ? '#siteContent' : '.container';*/
		var trg = ($(".menu-panel-entry-active").attr("rel-m") == "<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
") ? '#siteContent' : '.vs-column.vs-mask';
		var t = $(this);
		
		$(trg).each(function(){$(this).mask("");});
		
		t.removeClass("save-entry-button").addClass("save-entry-button-loading");

		$.post(p_url, $("#ct-set-form").serialize(), function(data){
		    /*$(".container").html(data);*/
		    if ($(data).first().attr("id") == "cb-response-wrap") {
		    	$("#cb-response-wrap").detach();
		    	$(data).first().insertAfter("#ct-wrapper div.clearfix:first");
		    }
		    $(trg).unmask();
		    t.addClass("save-entry-button").removeClass("save-entry-button-loading");
		    
		    /*$("#cb-response-wrap").prependTo("ul.responsive-accordion:first");*/
		});
		return false;
	    });
	});
	thisresizeDelimiter();
	<?php echo '</script'; ?>
><?php }
}

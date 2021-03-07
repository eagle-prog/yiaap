<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-save-top-js.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b509ff7_34111507',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c86faeea2119bb1ee1ad2dc311e0b3bb59be50a' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-save-top-js.tpl',
      1 => 1553990280,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b509ff7_34111507 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
		<?php echo '<script'; ?>
 type="text/javascript">
		    var paging_link = '';
		    var do_link = '';
		    if ($(".menu-panel-entry-sub.menu-panel-entry-sub-active").attr("rel-m")) {
		    	menu_section = $(".menu-panel-entry-sub.menu-panel-entry-sub-active").attr("rel-m");
		    }
		    if ($(".menu-panel-entry.menu-panel-entry-active").attr("rel-m")) {
		    	menu_section = $(".menu-panel-entry.menu-panel-entry-active").attr("rel-m");
		    }
        	    <?php if ($_GET['page'] != '') {?>paging_link = '&page=<?php echo smarty_modifier_sanitize($_GET['page']);?>
&ipp=<?php echo smarty_modifier_sanitize($_GET['ipp']);?>
';<?php }?>
        	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>do_link = '<?php if ($_GET['u'] != '') {?>&u=<?php echo smarty_modifier_sanitize($_GET['u']);
}
if ($_GET['do'] != '') {?>&do=<?php echo smarty_modifier_sanitize($_GET['do']);
}
if ($_GET['for'] != '') {?>&for=<?php echo smarty_modifier_sanitize($_GET['for']);
}?>';<?php }?>
		    var upd_url = current_url + menu_section + '?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>f<?php }?>do=update'+paging_link+do_link;
		    var add_url = current_url + menu_section + '?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=add';
		    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse") {?>
		    <?php } else { ?>
		    var c_url   = current_url + menu_section<?php if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_playlist") {?>+'?s=<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs") {?>'+$(".menu-panel-entry-active").attr("id")+'<?php } else {
if ($_GET['s'] != '') {
echo smarty_modifier_sanitize($_GET['s']);
} else {
echo $_smarty_tpl->tpl_vars['s']->value;
}
}?>'<?php }?>;
		    <?php }?>
		    var act_link = '';
		    var cr_section = 0;
		    $(function() {
		    	$( '#entry-action-buttons' ).dlmenu({
		    		animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' }
		    	});
		    });

		    $(document).ready(function() {
			$("#entry-actions, #sort-file-time, button[id^='thumb-actions-']").click(function(){ $("#add-new-label-form a.link").click(); });
		    <?php if ($_smarty_tpl->tpl_vars['check_all']->value == "1" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond_extra" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search") {?>
			$("#check-all").on("click", function () {
			    if ($("#check-all").is(':checked')) {
				/*$('input[type=checkbox]:not([class="efc"]):not([class="cb-exclude"]):not([class="set-bl-opt"])').attr('checked', true);*/
				$('input[name="entryid"]').iCheck('check');
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs") {?>
				$(".list-check").parent().parent().removeClass("file-selected");
			    <?php }?>
			    } else {
				/*$('input[type=checkbox]:not([class="efc"]):not([class="cb-exclude"]):not([class="set-bl-opt"])').attr('checked', false);*/
				$('input[name="entryid"]').iCheck('uncheck');
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs") {?>
				$(".list-check").parent().parent().addClass("file-selected");
			    <?php }?>
			    }
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>
				var c_sel = $("input.ct-entry-check:checked").length;
				if(c_sel > 0){
				    $("input.ct-entry-check:checked").each(function() {
					$("#ec-"+$(this).val()).removeClass("no-display");
				    });
				    $("#ct-no-details").addClass("no-display");
				} else {
				    $("#ct-contact-details-wrap>div").addClass("no-display");
				    $("#ct-no-details").removeClass("no-display");
				    $(".ct-entries").removeClass("ct-entry-bg");
				}
				$("#ct-header-count").html(c_sel);
			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>
				$(".link").click();
			    <?php }?>
			    thisresizeDelimiter();
			});

		    	$('input#check-all').on('ifChecked', function(event) { $('input[name="entryid"]').iCheck('check'); });
                        $('input#check-all').on('ifUnchecked', function(event) { $('input[name="entryid"]').iCheck('uncheck'); });

		    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlist" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search") {?>
			$(".count-label").bind("click", function () {
			    var class_ar = $(this).attr("class").split(" ");
			    var label_ac = class_ar[1];
			    var class_id = $(this).attr("id");
			    var form_id = $("#"+class_id).find("form").attr("id");
			    var f1 = $(".entry-form-class").serialize();
			    var f2 = $("#"+form_id).serialize();
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>var f3 = $("#ct-entry-selection").serialize();<?php }?>
			    var the_form = <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>f2+"&"+f3;<?php } else { ?>f1+"&"+f2;<?php }?>

			    $("#siteContent").mask(" ");

			    $.post(current_url + menu_section + '?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do='+label_ac+paging_link, the_form, function(data) {
			    	<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>
					$("#siteContent").html(data);
				<?php } else { ?>
					$(".container").html(data);
				<?php }?>
				$("#siteContent").unmask();
			    });
			});
			$(".file-action").bind("click", function () {
			    act_link = "&a="+$(this).attr("id");
			});
		    <?php }?>
			$(".ftype").on("click", function() {
			    if($(this).hasClass("sort-active")) return;
			    act_link = $(this).hasClass("sort-menu") ? "" : act_link;
			    $("#file-type-div-val").val($(this).attr("id"));
			    var post_url = c_url + "&do=" + $(".sort-active").attr("id") + "&for=" + $("#file-type-div-val").val() + act_link + paging_link;
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>var f_class = '#ct-entry-selection';
                            <?php } elseif ($_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry7") {?>var f_class = '#gen-file-actions';
                            <?php } else { ?>var f_class = '.entry-form-class';<?php }?>
                            $(".type-menu").removeClass("sort-active");
                            $(this).addClass("sort-active");

			    $(".container").mask(" ");
			    $.post(post_url, $(f_class).serialize(), function(data) {
				$(".container").html(data);
                                $(".container").unmask();
			    });
			});

			$(".count").unbind().on("click", function() {
			    var act_id = $(this).attr("id");
			    if($(this).hasClass("sort-active")) return;
			    if($(this).hasClass("menu-action-src")){
                                $("#file-type-div-val").val(act_id);
                            }
                            if($(this).hasClass("menu-action-type")){
                                $("#file-sort-div-val").val(act_id);
                            }
			    var fr_inv = '<?php echo $_smarty_tpl->tpl_vars['approve_friends']->value;?>
';
			    var msk_in = (act_id == "cb-addfr" && fr_inv == 1) ? "<?php echo smarty_function_lang_entry(array('key'=>"contacts.add.wait"),$_smarty_tpl);?>
" : " ";
			    if ((act_id == 'cb-delete' || act_id == 'cb-del-files' || act_id == 'cb-commdel' || act_id == 'cb-rdel') && confirm('<?php echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete.multi"),$_smarty_tpl);?>
') || (act_id != '' && act_id != 'cb-delete' && act_id != 'cb-del-files' && act_id != 'cb-commdel' && act_id != 'cb-rdel')) {
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>var f_class = '#ct-entry-selection';
			    <?php } elseif ($_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry7") {?>var f_class = '#gen-file-actions';
			    <?php } else { ?>var f_class = '.entry-form-class';<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse") {?>
			    if($(this).hasClass("sort-menu")){
				$(".count").removeClass("sort-active"); $(this).addClass("sort-active");
			    }
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_browse" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_files") {?>act_link = "&a="+act_id;<?php }?>
			    /*$("#"+$(this).parent().parent().parent().attr("id")+"-val").val(act_id);*/
			    $("#file-sort-div-val").val(act_id);

			    if($("#file-sort-div-val").val() == 'sort-order'){paging_link = '&page=1&ipp=all';}
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse") {?>
				c_url	= current_url + menu_section + '?s='+(typeof($(".menu-panel-entry-active").attr("id")) != "undefined" ? $(".menu-panel-entry-active").attr("id") : $(".menu-panel-entry:first").attr("id"));
				$("#file-sort-div-val").val(act_id);
				if(!$(this).hasClass("file-action")){
				    $("#main-h2").html($(this).first().text());
				}
			    <?php }?>
			    act_link = $(this).hasClass("sort-menu") ? "" : act_link;
			    var post_url = c_url + "&do=" + $(".sort-active").attr("id") + "&for=" + $("#file-type-div-val").val() + act_link + paging_link;

			    if ($("#file-menu-entry7").hasClass("menu-panel-entry-active") || $("#file-menu-entry8").hasClass("menu-panel-entry-active")) {
			    	cr_section = 1;
			    	var crsection = $(".tab-current").find("a").attr("href").split("-");
			    	var crsort = crsection[1];
			    	act_link = "&a="+act_id;

			    	var post_url = c_url + "&do=cr-" + crsort + "&t=" + $(".view-mode-type.active").attr("id").replace("view-mode-", "") + act_link + paging_link;
			    }
			<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_search") {?>
			    if($(this).hasClass("type-menu")){
			        $(".type-menu.count").removeClass("sort-active"); $(this).addClass("sort-active");
			    } else {
			        $(".sort-menu.count").removeClass("sort-active"); $(this).addClass("sort-active");
			    }
			    act_link = $(this).hasClass("sort-menu") ? "" : act_link;
			    var fe_link = "?q="+encodeURIComponent($("#search-query").val())+"&do=ct-load&show="+$(".menu-panel-entry-active").attr("id")+($(".menu-panel-entry-active").attr("id") == "search-pl" ? "&for="+$(".type-menu.sort-active").attr("id") : "")+"&sort="+$(".sort-active").attr("id");
			    var post_url = current_url + menu_section + fe_link + act_link + paging_link;
			<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlist") {?>
			    var post_url = c_url + "&a="+act_id+paging_link;
			<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond_extra") {?>
			    <?php if ($_GET['v'] != '') {
$_smarty_tpl->_assignInScope('ftype', 'v' ,true);
} elseif ($_GET['i'] != '') {
$_smarty_tpl->_assignInScope('ftype', 'i' ,true);
} elseif ($_GET['a'] != '') {
$_smarty_tpl->_assignInScope('ftype', 'a' ,true);
} elseif ($_GET['d'] != '') {
$_smarty_tpl->_assignInScope('ftype', 'd' ,true);
}?>
			    var post_url = "<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"see_responses"),$_smarty_tpl);?>
?<?php echo $_smarty_tpl->tpl_vars['ftype']->value;?>
=<?php echo smarty_modifier_sanitize($_GET[$_smarty_tpl->tpl_vars['ftype']->value]);?>
&do="+act_id+paging_link;
			<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>
			    var action_id = $(this).attr("id");
				if($(this).hasClass("be-count")){
				    act_link = "&a="+action_id;
				}
				var u_link = ($("#p-user-key").val() != "" ? "&u="+$("#p-user-key").val() : "");
				var post_url = c_url + act_link + u_link + "&for=" + $("#file-type-div-val").val() + "&do=" + $("#file-sort-div-val").val() + paging_link;
			<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members" && $_GET['s'] == "backend-menu-entry10-sub2") {?>
			    var action_id = $(this).attr("id");
				if($(this).hasClass("be-count")){
				    act_link = "&a="+action_id;
				}
				var post_url = c_url + act_link + "&do=" + $("#file-sort-div-val").val() + paging_link;
			<?php } else { ?>
			    var post_url = c_url + "&do="+act_id+paging_link;
			<?php }?>
			    if(typeof($("#sq").val()) != "undefined"){
				post_url += "&sq="+$("#sq").val();
			    }

			<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond_extra") {?>
			    $("#response-ct").mask(msk_in);
			<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search") {?>
			    $("#v-thumbs").mask(msk_in);
			<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>
				$("#ct-wrapper").mask(msk_in);
			<?php } else { ?>
				if (cr_section == 0) {
			    		$(".container").mask(msk_in);
			    	} else {
			    		$("#siteContent").mask(msk_in);
			    	}
			<?php }?>
			
			$(".mce-tinymce").detach();

			    $.post(post_url, $(f_class).serialize(),
			    function(data) {
				<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond_extra") {?>
				    $("#response-response").html(data);
				<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlist") {?>
				    $("#file-action-response").html(data);
				<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search") {?>
				    if($("#"+act_id+".count").hasClass("file-action")){
					$("#file-action-response").html(data);
				    } else {
					$(".col-left-ct").html(data);
				    }
				<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>
					$("#siteContent").html(data);
				<?php } else { ?>
					if (cr_section == 0) {
			    			$(".container").html(data);
			    		} else {
			    			$("#siteContent").html(data);
			    			<?php if (($_GET['do'] != '' && $_GET['do'] != "cr-approved" && $_GET['a'] != 'cr-suspended' && $_GET['a'] != 'cr-today') || ($_GET['a'] != '' && $_GET['a'] != "cr-approved")) {?>
			    				$(".cr-tabs .tab-current:first").removeClass("tab-current");
			    			<?php }?>
			    		}
				<?php }?>
				
				<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond_extra") {?>
				    $("#response-ct").unmask();
				<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search") {?>
				    if($("#"+act_id+".count").hasClass("file-action")){
					$(".list-check").attr("checked", false);
				    }
				    $("#v-thumbs").unmask();
				<?php } else { ?>
					if (cr_section == 0) {
			    			$(".container").unmask();
			    		} else {
			    			$("#siteContent").unmask();
			    		}
				<?php }?>
				thisresizeDelimiter();
				$(".lv-wrap:last").removeClass("lv-wrap");
				$(".lv-wrap-fm:last").removeClass("lv-wrap-fm");
			    });
			    }
			});

			$(".list-check").on("click", function () {
			    var val_id = $(this).attr("value");
			    if ($(this).is(':checked')) {
				$('#hcs-id'+val_id).attr('checked', true);
			    } else {
				$('#hcs-id'+val_id).attr('checked', false);
			    }
			});
		    <?php }?>

			$(".cancel-trigger").unbind().on("click", function () {
				var t = $(this);
				if (typeof(t.parent().parent().attr("id")) != "undefined") {
					if (t.parent().parent().attr("id") == "add-new-label-form") {
						$("#add-new-label").stop().slideUp();
					}
					if (t.parent().parent().attr("id") == "add-new-contact-form") {
						$("#ct-contact-add-wrap").stop().slideUp();
					}
					if (t.parent().parent().attr("id").substr(0,11) == "ct-editform") {
					}

					return;
				}
				t.removeClass("cancel-trigger").addClass("cancel-trigger-loading");
			    $(".vs-mask").mask(" ");
			    $(".container").one().load(c_url, function () {
			    	t.addClass("cancel-trigger").removeClass("cancel-trigger-loading");
				$(".vs-mask").unmask();
			    });
			});

			$(".new-entry").unbind().on("click", function () {
				var t = $(this);
			    $(".vs-mask").mask(" ");
			    if (!t.hasClass("save-entry-button")) { $(".loadmask-msg").show(); }
			    t.removeClass("new-entry").addClass("new-entry-loading");
			    
			    $.post(add_url, $("#add-entry-form, #categ-entry-form, #user-entry-form, #ban-entry-form, #lang-entry-form, #db-entry-form, #ad-entry-form").serialize(),
			    function(data) {
				closeDiv("open-close-links");
				$(".container").html(data);
				$(".vs-mask").unmask();
				t.addClass("new-entry").removeClass("new-entry-loading");
			    });
			});

			$(".update-entry").bind("click", function () {
				var t = $(this);
			    var form_id = $($(this).closest("form")).attr("id");
			    t.removeClass("new-entry").addClass("new-entry-loading");
			    $("#"+form_id+" .vs-mask").mask(" ");
			    $.post(upd_url, $("#"+form_id).serialize(),
			    function(data) {
				$(".container").html(data);
				$("#"+form_id+" .vs-mask").unmask();
				t.addClass("new-entry").removeClass("new-entry-loading");
				$("#cb-response").prependTo("#"+form_id);

				setTimeout(function(){ $(".responsive-accordion-panel.p-msover").addClass("active"); }, 1000);
			    });
			});

			$(".add-button").bind("click", function () {
				var t = $(this);
			    $(".vs-mask").mask(" ");
			    if (!t.hasClass("save-entry-button")) { $(".loadmask-msg").show(); }
			    t.removeClass("new-entry").addClass("new-entry-loading");
			    $(".container").load(add_url, function () {
			    	$(".vs-mask").unmask();
			    	t.addClass("new-entry").removeClass("new-entry-loading");
			    });
			});

			$(".new-categ, .new-banner").bind("click", function () {
			    $(".container").mask(" ");
			    $(".container").load(current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=add", function () {
				$(".container").unmask();
			    });
			});

			$("div.link").mouseover(function() { $(this).addClass("underlined"); }).mouseout(function() { $(this).removeClass("underlined"); });

		    });
		<?php echo '</script'; ?>
><?php }
}

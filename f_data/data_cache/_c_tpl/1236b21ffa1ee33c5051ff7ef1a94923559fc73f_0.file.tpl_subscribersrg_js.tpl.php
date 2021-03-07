<?php
/* Smarty version 3.1.33, created on 2021-02-06 12:21:35
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_subscriber/tpl_subscribersrg_js.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ed01f1381a7_28685228',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1236b21ffa1ee33c5051ff7ef1a94923559fc73f' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_subscriber/tpl_subscribersrg_js.tpl',
      1 => 1537477200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601ed01f1381a7_28685228 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
$(document).ready(function() {
	<?php if ($_GET['a'] != '') {?>$("#chart-views-container").mask(""); $("#chart-line-container").mask(""); $("#device-pie-container").mask(""); $("#timeline-container").mask("");
	<?php } elseif ($_GET['g'] != '') {?>$("#geo-container").mask(""); $("#country-container").mask(""); $("#pagetitle-container").mask(""); $("#country-search-load").mask(""); $("#continent-search-load").mask(""); $("#country-search-dots").mask(""); $("#continent-search-dots").mask("");
	<?php } elseif ($_GET['rp'] != '') {?>
	<?php }?>

	$("#view-limits").submit(function(e){
		e.preventDefault();

		l1 = parseInt($("#view-limit-min-off").val());
		l2 = parseInt($("#view-limit-max-off").val());

		$("#view-limit-min").val(l1);
		$("#view-limit-max").val(l2);

		$("#custom-date-form").submit();
	});
	$(".view-mode-type").click(function(){
                t = $(this);
                type = t.attr("rel-t");
                u = '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_subscribers"),$_smarty_tpl);?>
?<?php if ($_GET['a'] != '') {?>a=<?php echo smarty_modifier_sanitize($_GET['a']);
} elseif ($_GET['g'] != '') {?>g=<?php echo smarty_modifier_sanitize($_GET['g']);
} elseif ($_GET['rp'] != '') {?>rp=<?php echo smarty_modifier_sanitize($_GET['rp']);
}?>&t='+type<?php if ($_GET['f'] != '') {?>+'&f=<?php echo smarty_modifier_sanitize($_GET['f']);?>
'<?php }
if ($_GET['g'] != '') {?>+'&c=<?php if ($_GET['c'] != '') {
echo smarty_modifier_sanitize($_GET['c']);
} elseif ($_POST['custom_country'] != '') {
echo smarty_modifier_sanitize($_POST['custom_country']);
} else { ?>xx<?php }
if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}?>'<?php }?>;
                u+= '<?php if ($_GET['uk'] != '' && $_GET['fk'] == '') {?>&uk=<?php echo smarty_modifier_sanitize($_GET['uk']);
}?>';
                u+= '<?php if ($_GET['tab'] != '') {?>&tab=<?php echo smarty_modifier_sanitize($_GET['tab']);
}?>';

                $(".view-mode-type").removeClass("active"); t.addClass("active");
                
                if ($(".content-filters li a.active").attr("rel-t") == "date" || $(".content-filters li a.active").attr("rel-t") == "range") {
                	$('#custom-date-form').attr('action', u).submit();
                } else {
                	window.location = u;
                }
        });

        $("a.filter-tag").click(function(){
                t = $(this);
                type = t.attr("rel-t");
                u = String(window.location);
                rep = '';
                switch (type) {
                	case "f":
                		rep = '<?php if ($_GET['f'] != '') {?>&t=sub&f=<?php echo smarty_modifier_sanitize($_GET['f']);
}
if ($_GET['w'] != '') {?>&w=<?php echo smarty_modifier_sanitize($_GET['w']);
}
if ($_GET['m'] != '') {?>&m=<?php echo smarty_modifier_sanitize($_GET['m']);
}
if ($_GET['y'] != '') {?>&y=<?php echo smarty_modifier_sanitize($_GET['y']);
}?>';
                	break;
                	case "r":
                		rep = '<?php if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}?>';
                	break;
                	case "c":
                		rep = '<?php if ($_GET['c'] != '' && $_GET['c'] != "xx") {?>&c=<?php echo smarty_modifier_sanitize($_GET['c']);
}?>';
                	break;
                	case "fk":
                		rep = '<?php if ($_GET['fk'] != '') {?>&fk=<?php echo smarty_modifier_sanitize($_GET['fk']);
}?>';
                	break;
                	case "uk":
                		rep = '<?php if ($_GET['uk'] != '') {?>&uk=<?php echo smarty_modifier_sanitize($_GET['uk']);
}?>';
                	break;
                }
                if (rep != '') {
                	u = u.replace(rep, '');

                	if ($(".content-filters li a.active").attr("rel-t") == "date" || $(".content-filters li a.active").attr("rel-t") == "range") {
                		$('#custom-date-form').attr('action', u).submit();
                	} else {
                		window.location = u;
                	}
                }
        });

        $(".content-filters li a").click(function(){
                t = $(this);
                type = t.attr("rel-t");
                ft = $(".view-mode-type.active").attr("rel-t");

                $("#filter-section-"+(ft == 'document' ? 'doc' : ft)+" .content-filters li a").removeClass("active"); t.addClass("active");

                switch (type) {
                        case "week":
                        case "month":
                        case "year":
                        	window.location = '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_subscribers"),$_smarty_tpl);?>
?<?php if ($_GET['a'] != '') {?>a=<?php echo smarty_modifier_sanitize($_GET['a']);
} elseif ($_GET['g'] != '') {?>g=<?php echo smarty_modifier_sanitize($_GET['g']);
} elseif ($_GET['rg'] != '') {?>rg=1<?php }?>&t='+$('.view-mode-type.active').attr('rel-t')+'&f='+type<?php if ($_GET['g'] != '') {?>+'&c=<?php if ($_GET['c'] != '') {
echo smarty_modifier_sanitize($_GET['c']);
} elseif ($_POST['custom_country'] != '') {
echo smarty_modifier_sanitize($_POST['custom_country']);
} else { ?>xx<?php }
if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}?>'<?php }
if ($_GET['fk'] != '') {?>+'&fk=<?php echo smarty_modifier_sanitize($_GET['fk']);?>
'<?php }
if ($_GET['uk'] != '') {?>+'&uk=<?php echo smarty_modifier_sanitize($_GET['uk']);?>
'<?php }
if ($_GET['tab'] != '') {?>+'&tab=<?php echo smarty_modifier_sanitize($_GET['tab']);?>
'<?php }?>;
                        break;
                }
        });

});<?php }
}

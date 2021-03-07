<?php
/* Smarty version 3.1.33, created on 2021-02-11 18:29:59
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_reports_js.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6025bdf7dba012_79955808',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b97ccefe9a6b9ef1bdc065e6e86e40babac1620f' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate/tpl_reports_js.tpl',
      1 => 1516917600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6025bdf7dba012_79955808 (Smarty_Internal_Template $_smarty_tpl) {
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
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
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
                		rep = '<?php if ($_GET['f'] != '') {?>&f=<?php echo smarty_modifier_sanitize($_GET['f']);
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
                        case "today":
                        case "yesterday":
                        case "thisweek":
                        case "lastweek":
                        case "thismonth":
                        case "lastmonth":
                        case "thisyear":
                        case "lastyear":
                        case "last3months":
                        case "last6months":
                        	window.location = '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?<?php if ($_GET['a'] != '') {?>a=<?php echo smarty_modifier_sanitize($_GET['a']);
} elseif ($_GET['g'] != '') {?>g=<?php echo smarty_modifier_sanitize($_GET['g']);
} elseif ($_GET['rp'] != '') {?>rp=<?php echo smarty_modifier_sanitize($_GET['rp']);
}?>&t='+$('.view-mode-type.active').attr('rel-t')+'&f='+type<?php if ($_GET['g'] != '') {?>+'&c=<?php if ($_GET['c'] != '') {
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
                        case "date":
                        	$('.rpick<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
').hide();
                        	dp.open();
                        break;
                        case "range":
                        	dp.close();
                        	$('.rpick<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
').toggle();
                        break;
                }
        });

        function setrdate(dp){
        	var d = new Date(dp.state.start);
        	var ds = d.getFullYear() + '-' + ("0"+(d.getMonth()+1)).slice(-2) + '-' + ("0" + d.getDate()).slice(-2);
        	$('#custom-date-start').val(ds);

        	d = new Date(dp.state.end);
        	var de = d.getFullYear() + '-' + ("0"+(d.getMonth()+1)).slice(-2) + '-' + ("0" + d.getDate()).slice(-2);
        	$('#custom-date-end').val(de);

        	var u = '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?<?php if ($_GET['a'] != '') {?>a=<?php echo smarty_modifier_sanitize($_GET['a']);
} elseif ($_GET['g'] != '') {?>g=<?php echo smarty_modifier_sanitize($_GET['g']);
} elseif ($_GET['rp'] != '') {?>rp=<?php echo smarty_modifier_sanitize($_GET['rp']);
}?>&t='+$('.view-mode-type.active').attr('rel-t')+'&f=range';
		u += '<?php if ($_GET['g'] != '') {?>&c=<?php if ($_GET['c'] != '') {
echo smarty_modifier_sanitize($_GET['c']);
} elseif ($_POST['custom_country'] != '') {
echo smarty_modifier_sanitize($_POST['custom_country']);
} else { ?>xx<?php }
if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}
}?>';
		u += '<?php if ($_GET['fk'] != '') {?>&fk=<?php echo smarty_modifier_sanitize($_GET['fk']);
}?>';
		u += '<?php if ($_GET['uk'] != '' && $_GET['fk'] == '') {?>&uk=<?php echo smarty_modifier_sanitize($_GET['uk']);
}?>';
		u += '<?php if ($_GET['tab'] != '') {?>&tab=<?php echo smarty_modifier_sanitize($_GET['tab']);
}?>';

		if (dp.state.end) {
			$('#custom-date').val("");
        		$('#custom-date-form').attr('action', u).submit();
        	}
        }

        function setdate(datestring){
        	var d = new Date(datestring);
        	var ds = d.getFullYear() + '-' + ("0"+(d.getMonth()+1)).slice(-2) + '-' + ("0" + d.getDate()).slice(-2);
        	var u = '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?<?php if ($_GET['a'] != '') {?>a=<?php echo smarty_modifier_sanitize($_GET['a']);
} elseif ($_GET['g'] != '') {?>g=<?php echo smarty_modifier_sanitize($_GET['g']);
} elseif ($_GET['rp'] != '') {?>rp=<?php echo smarty_modifier_sanitize($_GET['rp']);
}?>&t='+$('.view-mode-type.active').attr('rel-t')+'&f=date';
        	u += '<?php if ($_GET['g'] != '') {?>&c=<?php if ($_GET['c'] != '') {
echo smarty_modifier_sanitize($_GET['c']);
} elseif ($_POST['custom_country'] != '') {
echo smarty_modifier_sanitize($_POST['custom_country']);
} else { ?>xx<?php }
if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}
}?>';
        	u += '<?php if ($_GET['fk'] != '') {?>&fk=<?php echo smarty_modifier_sanitize($_GET['fk']);
}?>';
        	u += '<?php if ($_GET['uk'] != '' && $_GET['fk'] == '') {?>&uk=<?php echo smarty_modifier_sanitize($_GET['uk']);
}?>';
        	u += '<?php if ($_GET['tab'] != '') {?>&tab=<?php echo smarty_modifier_sanitize($_GET['tab']);
}?>';

		$('#custom-date-start').val("");
		$('#custom-date-end').val("");
        	$('#custom-date').val(ds);
        	$('#custom-date-form').attr('action', u).submit();
        }
        function setopen(datestring){
        	$('.country-select .flag-dropdown').css({'z-index':'0'});
        }
        function setclose(datestring){
        	$('.country-select .flag-dropdown').css({'z-index':'auto'});
        }

	dp = TinyDatePicker('.dpick<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
', {mode: 'dp-below'<?php if ($_POST['custom_date'] != '') {?>,hilightedDate:'<?php echo smarty_modifier_sanitize($_POST['custom_date']);?>
'<?php }?>});
        dp.on({ open: () => setopen(), close: () => setclose(), select: (_, dp) => setdate(dp.state.selectedDate) });

	rp = DateRangePicker.DateRangePicker('.rpick<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
', {mode: 'dp-below'});
        rp.on('statechange', (_, rp) => setrdate(rp));

        const root = document.querySelector('.rpickoff<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
');
        root.addEventListener('focusout', function() {});
        root.addEventListener('focus', function() {});
});<?php }
}

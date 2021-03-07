<?php
/* Smarty version 3.1.33, created on 2021-02-06 10:39:47
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_thumbnail_js.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601eb84302d556_59798053',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d267a22cc5c811a9f5507f65f50d25b1ff0692f' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_thumbnail_js.tpl',
      1 => 1456696800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601eb84302d556_59798053 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript">
		    $(document).ready(function() {
			var c_url = "<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"files_edit"),$_smarty_tpl);?>
?fe=1&<?php echo $_smarty_tpl->tpl_vars['for']->value;?>
=<?php echo smarty_modifier_sanitize($_GET[$_smarty_tpl->tpl_vars['for']->value]);?>
";
        		var options = {
            		    target: "#thumb-change-response",
            		    beforeSubmit: showRequest,
            		    success: showResponse,
            		    url: c_url + "&do=upload"
        		}

        		function showRequest() { $('#intabdiv').mask(' '); $("p.thumb-text").removeClass("hiden"); $("#save-button-row").addClass("hidden"); }
        		function showResponse() {
        			$('#intabdiv').unmask();
        			$("p.thumb-text").addClass("hidden");
        			$("#save-button-row").removeClass("hidden");
        			$(".fancybox-inner").css("height", "auto");
        			$(".fancybox-opened").css("top", "25%");
        		}

        		$(document).on("submit", "#fedit-image-form", function() {
            		    $(this).ajaxSubmit(options);
            		    return false;
        		});

        		$("#save-image-btn").click(function() {
        		    $("#intabdiv").mask(" ");
        		    $.post(c_url + '&do=save', $("#fedit-image-form").serialize(), function(data) {
        			$("#thumb-change-response").html(data);
        			$("#intabdiv").unmask();
        		    });
        		});

        		$("#fedit-image").click(function() {
        		    $("#fedit-image-upload").attr("checked", "checked");
        		});

			$(document).one("click", ".link", function() {
    			    $("#fedit-image").replaceWith('<input type="file" name="fedit_image" id="fedit-image" size="30" />');
    			    $("#intabdiv").mask(" ");
    			    $.post(c_url + '&do=cancel', $("#fedit-image-form").serialize(), function(data) {
    				$("#intabdiv").unmask();
    				$.fancybox.close(true);
    				$(".fancybox-overlay.fancybox-overlay-fixed").hide().detach();
			    });
			    
    			    return false;
			});
			
			$('.icheck-box input').each(function () {
                        	var self = $(this);
                        	self.iCheck({
                                	checkboxClass: 'icheckbox_square-blue',
                                	radioClass: 'iradio_square-blue',
                                	increaseArea: '20%'
                                	//insert: '<div class="icheck_line-icon"></div><label>' + label_text + '</label>'
                        	});
                	});
			
		    });
		<?php echo '</script'; ?>
>
<?php }
}

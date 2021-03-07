<?php
/* Smarty version 3.1.33, created on 2021-02-06 11:28:16
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_overview_image.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ec3a0755ec7_21650859',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e52428bc2933920020af1b606fad0ed414d1753b' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_overview_image.tpl',
      1 => 1553021100,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601ec3a0755ec7_21650859 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
		    <form id="profile-image-form" class="entry-form-class" method="post" action="" enctype="multipart/form-data">
		    	<article>
		    		<h3 class="content-title"><i class="icon-user"></i> <?php echo smarty_function_lang_entry(array('key'=>"account.image.change"),$_smarty_tpl);?>
</h3>
		    		<div class="line"></div>
		    	</article>

			<div id="intabdiv">
			    <div class="left-float left-align wdmax row" id="overview-userinfo-response"></div>
			    <div class="left-float left-align wdmax">
				<div class="row">
				    <div class="icheck-box up"><input type="radio" name="profile_image_action" id="profile-image-upload" value="new" /><label><?php echo smarty_function_lang_entry(array('key'=>"account.image.upload"),$_smarty_tpl);?>
</label></div>
				</div>
				<div class="row" id="overview-userinfo-file">
					<div class="left-float left-padding25 hiddenfile">
						<input type="file" name="profile_image" id="profile-image" size="30" onchange="$('#profile-image-form').submit();" />
					</div>
					<center>
						<button onclick="$('.icheck-box.up input').iCheck('check');$('#profile-image').trigger('click');" class="save-entry-button button-grey search-button form-button new-image" type="button"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.upload.image"),$_smarty_tpl);?>
</span></button>
					</center>
					<br>
				</div>
			    </div>
			    <div class="row">
				<div class="icheck-box"><input type="radio" name="profile_image_action" id="profile-image-default" value="default" /><label><?php echo smarty_function_lang_entry(array('key'=>"account.image.upload.default"),$_smarty_tpl);?>
</label></div>
			    </div>
			    <div class="row">
				<div class="row" id="save-button-row">
                                	<button name="save_changes_btn" id="save-image-btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.savechanges"),$_smarty_tpl);?>
</span></button>
                                	<a class="link cancel-trigger" href="#"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.cancel"),$_smarty_tpl);?>
</span></a>
                            	</div>
			    </div>
        		</div>
        	    </form>


		<?php echo '<script'; ?>
 type="text/javascript">
		    $(document).ready(function() {
        		var options = {
            		    target: "#overview-userinfo-response",
            		    beforeSubmit: showRequest,
            		    success: showResponse,
            		    url: current_url + menu_section + "?s=account-menu-entry1&do=upload"
        		}

        		function showRequest() { $('#intabdiv').mask(' '); $("#save-button-row").addClass("hidden"); }
        		function showResponse() { $('#intabdiv').unmask(); $("#save-button-row").removeClass("hidden"); $(".fancybox-inner").css("height", "auto"); $(".fancybox-opened").css("top", "25%"); }

        		$(document).on("submit", "#profile-image-form", function() {
            		    $(this).ajaxSubmit(options);
            		    return false;
        		});

        		$("#save-image-btn").click(function() {
        		    $("#intabdiv").mask(" ");
        		    $.post(current_url + menu_section + '?s=account-menu-entry1&do=save', $("#profile-image-form").serialize(), function(data) {
        			$("#overview-userinfo-response").html(data);
        			$("#intabdiv").unmask();
        		    });
        		});

        		$("#profile-image").click(function() {
        		    $("#profile-image-upload").prop("checked", true);
        		});

			$(document).one("click", ".link", function() {
    			    $("#profile-image").replaceWith('<input type="file" name="profile_image" id="profile-image" size="30" />');
    			    $("#intabdiv").mask(" ");
    			    $.post(current_url + menu_section + '?s=account-menu-entry1&do=cancel', $("#profile-image-form").serialize(), function(data) {
    				$("#intabdiv").unmask();
    				$.fancybox.close(true);
    				$(".fancybox-overlay.fancybox-overlay-fixed").hide().detach();
			    });

//    			    $("#fade , #popuprel").hide();
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
		    $(document).keyup(function(e){
			if (e.keyCode == 27) { $(".link").click(); }
		    });
		<?php echo '</script'; ?>
>
<?php }
}

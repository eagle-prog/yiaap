<?php
/* Smarty version 3.1.33, created on 2021-02-08 14:00:59
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_msg/tpl_addlabel.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60218a6b756a43_29373368',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e3d1c4ccde442629afaca8f9e1ddf2d07cf7e905' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_msg/tpl_addlabel.tpl',
      1 => 1470862800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60218a6b756a43_29373368 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
			    <div id="add-new-label" style="display: none; padding: 0px 10px 10px 10px;">
				<div id="add-new-label-in">
				    <form id="add-new-label-form" method="post" action="" class="entry-form-class">
					<label><?php echo smarty_function_lang_entry(array('key'=>"label.add.new"),$_smarty_tpl);?>
</label>
					<input type="text" name="add_new_label" id="add-new-label-input" class="login-input"><br>
					<div style="margin-top: 5px;">
						<button name="add_new_label_btn" id="add-new-label-btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.create"),$_smarty_tpl);?>
</span></button> 
						<a class="link cancel-trigger" href="#"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.cancel"),$_smarty_tpl);?>
</span></a>
					</div>
				    </form>
				</div>
			    </div>
			    <?php echo '<script'; ?>
 type="text/javascript">
				$(document).ready(function() {
				    var lb_url = current_url + menu_section + '?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=label';

				    $(".new-label").click(function(){$("#ct-contact-add-wrap").stop().slideUp(); $("#add-new-label").stop().slideToggle(); $("#add-new-label-input").focus(); if($(this).hasClass("form-button-active")){$(this).removeClass("form-button-active");}else{$(this).addClass("form-button-active");}});
				    $(".link").click(function(){$("#add-new-label").stop().slideUp(); $(".new-label").removeClass("form-button-active"); });
				    $("#add-new-label-btn").click(function(){
				    	if($("#add-new-label-input").val() != '') {
				    		$("#ct-wrapper").mask(" ");
				    		$.post(lb_url, $("#add-new-label-form").serialize(), function( data ) {
				    			if (data > 0) {
				    				location.reload();
				    			}
				    		});
				    	}
				    });

				    enterSubmit("#add-new-label-form input", "#add-new-label-btn");
				});
			    <?php echo '</script'; ?>
>
<?php }
}

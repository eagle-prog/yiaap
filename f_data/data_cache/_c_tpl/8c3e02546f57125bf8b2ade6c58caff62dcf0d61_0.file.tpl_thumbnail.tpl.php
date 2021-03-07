<?php
/* Smarty version 3.1.33, created on 2021-02-06 10:39:47
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_thumbnail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601eb843023a10_41854526',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8c3e02546f57125bf8b2ade6c58caff62dcf0d61' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_thumbnail.tpl',
      1 => 1553021280,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_file/tpl_thumbnail_js.tpl' => 1,
  ),
),false)) {
function content_601eb843023a10_41854526 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
		    <form id="fedit-image-form" class="entry-form-class" method="post" action="" enctype="multipart/form-data">
			<div id="intabdiv">
				<article>
					<h3 class="content-title"><i class="icon-<?php if ($_GET['v'] != '') {?>video<?php } elseif ($_GET['i'] != '') {?>image<?php } elseif ($_GET['a'] != '') {?>audio<?php } elseif ($_GET['d'] != '') {?>file<?php } elseif ($_GET['b'] != '') {?>pencil2<?php }?>"></i><?php echo smarty_function_lang_entry(array('key'=>"files.text.edit.thumb"),$_smarty_tpl);?>
</h3>
					<div class="line"></div>
				</article>

			    <div class="left-float left-align wdmax row" id="thumb-change-response"></div>
			    <div class="left-float left-align wdmax">
				<div class="row">
				    <div class="icheck-box up"><input type="radio" name="fedit_image_action" id="fedit-image-upload" value="new" /><label><?php echo smarty_function_lang_entry(array('key'=>"files.text.edit.thumb.text"),$_smarty_tpl);?>
</label></div>
				</div>
				<div class="row" id="overview-userinfo-file">
					<div class="left-float left-padding25 hiddenfile">
					<input type="file" name="fedit_image" id="fedit-image" size="30" onchange="$('#fedit-image-form').submit();" />
				</div>
				<br>
				<center>
				<button class="save-entry-button button-grey search-button form-button new-image" type="button" onclick="$('.icheck-box.up input').iCheck('check');$('#fedit-image').trigger('click');"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.upload.image"),$_smarty_tpl);?>
</span></button>
				<br><br>
				<label><?php echo smarty_function_lang_entry(array('key'=>"files.text.thumb.sizes"),$_smarty_tpl);?>
</label>
				</center>
				<br><br>
			    </div>
			    <?php if ($_smarty_tpl->tpl_vars['src']->value == "local") {?>
			    <div class="row">
				<div class="icheck-box"><input type="radio" name="fedit_image_action" id="fedit-image-default" value="default" /><label><?php if ($_GET['v'] == '') {
echo smarty_function_lang_entry(array('key'=>"account.image.upload.default"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"account.image.upload.grab"),$_smarty_tpl);
}?></label></div>
			    </div>
			    <br>
			    <?php }?>
			    <div class="row" id="save-button-row">
				<button name="save_changes_btn" id="save-image-btn" class="save-entry-button button-grey search-button form-button" type="button" value="1"><span><?php echo smarty_function_lang_entry(array('key'=>"files.text.save.thumb"),$_smarty_tpl);?>
</span></button>
				<a class="link cancel-trigger" href="#"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.cancel"),$_smarty_tpl);?>
</span></a>
			    </div>
        		</div>
        	    </form>
        	    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_file/tpl_thumbnail_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}

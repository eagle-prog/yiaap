<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:21:47
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_uploadjs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c737bc1e537_35958797',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '71690c9861f90968706673723dde989d8380ae92' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_uploadjs.tpl',
      1 => 1569074811,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c737bc1e537_35958797 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
echo '<script'; ?>
 type="text/javascript">$(window).resize(function(){dinamicSizeSetFunction_menu();});$(function(){dinamicSizeSetFunction_menu();$("#uploader").pluploadQueue({runtimes : 'html5,flash,silverlight,html4',url : '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"uploader"),$_smarty_tpl);?>
?u=<?php echo $_smarty_tpl->tpl_vars['user_key']->value;?>
&t=<?php echo smarty_modifier_sanitize($_GET['t']);
if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}?>',multipart: true,multipart_params: {'UFUID': '<?php echo $_SESSION['USER_ID'];?>
','UFSUID': '<?php echo $_smarty_tpl->tpl_vars['user_key']->value;?>
'},max_files: <?php echo $_smarty_tpl->tpl_vars['multiple_file_uploads']->value;?>
,chunk_size: '1024kb',rename : false,prevent_duplicates: true,dragdrop: true,max_file_size : '<?php if ($_smarty_tpl->tpl_vars['paid_memberships']->value == "1") {
if ($_smarty_tpl->tpl_vars['subscription_bw']->value < $_smarty_tpl->tpl_vars['subscription_space']->value && $_smarty_tpl->tpl_vars['subscription_bw']->value > 0) {
echo $_smarty_tpl->tpl_vars['subscription_bw']->value;
} elseif ($_smarty_tpl->tpl_vars['subscription_space']->value > 0) {
echo $_smarty_tpl->tpl_vars['subscription_space']->value;
} else {
echo $_smarty_tpl->tpl_vars['file_limit']->value;
}
} else {
echo $_smarty_tpl->tpl_vars['file_limit']->value;
}?>mb',filters : [{title : "<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.v.p.c"),$_smarty_tpl);?>
", extensions : "<?php echo $_smarty_tpl->tpl_vars['allowed_file_cfg']->value;?>
"}],views : {list: true,thumbs: true,active: 'thumbs'},flash_swf_url : '<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/uploader/Moxie.swf',silverlight_xap_url : '<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/uploader/Moxie.xap'});var uploader = $('#uploader').pluploadQueue();uploader.bind('Init', function() {});uploader.bind('UploadComplete', function() {$.post("?t=<?php echo $_GET['t'];?>
&do=form-update", $('.c-entry-form-edit').serialize(), function(data){$('#cb-response-wrap-no').html(data);});uploader.splice();$('#cb-response-wrap').show();$("#dobrowse .start").addClass("off");$("#uploader_browse").removeClass("set");$(document).keyup(function(e) {if(e.keyCode === 27)return});});uploader.bind('FilesAdded', function(up, files) {if (up.files.length >= up.settings.max_files) {up.splice(up.settings.max_files);}if (up.files.length > 0) {$("#dobrowse .start").removeClass("off").addClass("set");}});uploader.bind('FilesRemoved', function(up, files) {if (up.files.length < up.settings.max_files) {}if (up.files.length == 0) {$("#dobrowse .start").addClass("off");$("#uploader_browse").removeClass("set");}});uploader.bind('BeforeUpload', function(up, files) {var uploader = $('#uploader').pluploadQueue();$("#UFNAME").val(files.name);$("#UFSIZE").val(files.size);$(document).keyup(function(e) {if(e.keyCode === 27)uploader.stop();});});uploader.bind('Error', function(up, err) {$("#notice-message").detach();var ht = '<div class="error-message" id="error-message"><p class="error-message-text">Error #' + err.code + ': ' + err.message + '</p></div>';$(ht).insertBefore("#upload-wrapper");var uploader = $('#uploader').pluploadQueue();uploader.stop();uploader.splice();});uploader.bind('UploadProgress', function(up) {$(".plupload_total_file_size").html(parseFloat(up.total.bytesPerSec/(1024)).toFixed(2) + " (KiB/s)");});uploader.bind('FileUploaded', function(up,file) {var the_form = "#upload-form";var the_url = $(the_form).attr("action");$.post(the_url, $(the_form).serialize(), function(data) {$("#form-response").html(data);if($("#total-uploads").val() == '0'){$("#fsUploadStats").load(the_url+"&do=reload-stats");}});});SelectList.init("file_category_sel");});window.addEventListener("offline",function(){uploader.stop();},false);window.addEventListener("online",function(){uploader.start();},false);<?php echo '</script'; ?>
>
<?php }
}

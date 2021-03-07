<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:40:09
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_uploadjs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c3179471031_21414045',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7b1e8d8d84c392bb60029bbeae212f7dad06aea4' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_uploadjs.tpl',
      1 => 1569973620,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c3179471031_21414045 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
echo '<script'; ?>
 type="text/javascript">$(function() {$("#uploader").pluploadQueue({runtimes : 'html5,flash,silverlight,html4',url : '<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_uploader"),$_smarty_tpl);?>
?t=<?php echo smarty_modifier_sanitize($_GET['t']);?>
',multipart: true,multipart_params: {'UFSUID': ''},max_files: '<?php if ($_smarty_tpl->tpl_vars['demo']->value == "1") {?>2<?php } else { ?>0<?php }?>',chunk_size: '1024kb',rename : false,prevent_duplicates: true,dragdrop: true,max_file_size : '<?php echo $_smarty_tpl->tpl_vars['file_limit']->value;?>
mb',filters : [{title : "<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.v.p.c"),$_smarty_tpl);?>
", extensions : "<?php echo $_smarty_tpl->tpl_vars['allowed_file_cfg']->value;?>
"}],views : {list: true,thumbs: true,active: 'thumbs'},flash_swf_url : '<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/uploader/Moxie.swf',silverlight_xap_url : '<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/uploader/Moxie.xap'});$("#sq").focus();var uploader = $('#uploader').pluploadQueue();uploader.bind('Init', function() {uploader.disableBrowse(true);});uploader.bind('UploadComplete', function() {$.post("?t=<?php echo $_GET['t'];?>
&do=form-update", $('.c-entry-form-edit').serialize(), function(data){$('#cb-response-wrap-no').html(data);});uploader.splice();$('#cb-response-wrap').show();$("#dobrowse .start").addClass("off");$("#uploader_browse").removeClass("set");$(document).keyup(function(e) {if(e.keyCode === 27)return;});});uploader.bind('FilesAdded', function(up, files) {if ($("#assign-username").val() == "") {$("#sq").focus();alert("Please assign username first!");up.splice();return;}if (up.settings.max_files > 0 && up.files.length >= up.settings.max_files) {up.splice(up.settings.max_files);}if (up.files.length > 0) {$("#dobrowse .start").removeClass("off").addClass("set");}});uploader.bind('FilesRemoved', function(up, files) {if (up.files.length < up.settings.max_files) {}if (up.files.length == 0) {$("#dobrowse .start").addClass("off");$("#uploader_browse").removeClass("set");}});uploader.bind('BeforeUpload', function(up, files) {var uploader = $('#uploader').pluploadQueue();uploader.settings.multipart_params.UFSUID = $("#assign-username").val();$("#UFNAME").val(files.name);$("#UFSIZE").val(files.size);$(document).keyup(function(e) {if(e.keyCode === 27)uploader.stop();});});uploader.bind('UploadProgress', function(up) {$(".plupload_total_file_size").html(parseFloat(up.total.bytesPerSec/(1024)).toFixed(2) + " KiB/s");});uploader.bind('Error', function(up, err) {$("#notice-message").detach();var ht = '<div class="error-message" id="error-message"><p class="error-message-text">Error #' + err.code + ': ' + err.message + '</p></div>';$(ht).insertBefore("#upload-wrapper");var uploader = $('#uploader').pluploadQueue();uploader.stop();uploader.splice();});uploader.bind('FileUploaded', function(up) {var the_form = "#upload-form";var the_url = $(the_form).attr("action");$.post(the_url, $(the_form).serialize(), function(data) {$("#form-response").html(data);});});$("#upload_category").change(function(){});$("#upload_category").trigger("change");$("#sq").autocomplete({type: "post",serviceUrl: "?do=autocomplete",onSearchStart: function() {$(this).next().val("");$(".sb-icon-search").addClass("off").removeClass("set");$("#uploader_browse").addClass("off").removeClass("set");var uploader = $('#uploader').pluploadQueue();uploader.disableBrowse(true);uploader.stop();uploader.splice();},onSelect: function (suggestion) {$(this).next().val(suggestion.data);$(".sb-icon-search").removeClass("off").addClass("set");$("#uploader_browse").removeClass("off");var uploader = $('#uploader').pluploadQueue();uploader.disableBrowse(false);}});$("#sq").keypress(function(event) {var keycode = (event.keyCode ? event.keyCode : event.which);if(keycode == '13') {event.preventDefault();}});SelectList.init("file_category_0");});<?php echo '</script'; ?>
>
<?php }
}

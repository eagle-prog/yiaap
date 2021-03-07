<?php
/* Smarty version 3.1.33, created on 2021-02-20 20:45:25
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_msg/tpl_compose.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_603174e5ee6a04_60613896',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6b2f0ee27d675ff372340d1501902de6d68e418f' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_msg/tpl_compose.tpl',
      1 => 1540764000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603174e5ee6a04_60613896 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
	<article>
		<h3 class="content-title"><i class="icon-envelope"></i><?php echo smarty_function_lang_entry(array('key'=>"msg.btn.compose"),$_smarty_tpl);
if ($_GET['r']) {?> - <?php echo smarty_function_lang_entry(array('key'=>"msg.title.reply"),$_smarty_tpl);
}?></h3>
		<div class="line"></div>
	</article>

	<div class="left-float wdmax bottom-padding10 left-padding101">
	<div class="all-paddings10">
	    <form id="compose-msg-form" method="post" class="entry-form-class">
	    <?php if ($_GET['r'] != '') {?>
	    <?php $_smarty_tpl->assign('uname' , insert_getUsername (array('user_id' => smarty_modifier_sanitize($_POST['section_reply_value'])),$_smarty_tpl), true);?>
	    <?php $_smarty_tpl->assign('msubj' , insert_getMessageSubject (array('msg_id' => smarty_modifier_sanitize($_POST['section_subject_value'])),$_smarty_tpl), true);?>
	    <?php $_smarty_tpl->assign('mdate' , insert_getMessageDate (array('msg_id' => smarty_modifier_sanitize($_POST['section_subject_value'])),$_smarty_tpl), true);?>
	    <?php $_smarty_tpl->assign('mtext' , insert_getMessageText (array('msg_id' => smarty_modifier_sanitize($_POST['section_subject_value'])),$_smarty_tpl), true);?>
		<div class="left-float wdmax">
		<?php if ($_GET['f'] == '') {?>
		    <div class="row3">
			<label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.subj"),$_smarty_tpl);?>
:</label>
			<span class="compose-right-reply"><?php echo $_smarty_tpl->tpl_vars['msubj']->value;?>
</span>
		    </div>
		<?php }?>
		    <div class="row3">
			<label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.date"),$_smarty_tpl);?>
:</label>
			<span class="compose-right-reply"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['mdate']->value,"M d, Y");?>
</span>
		    </div>
		    <div class="row3">
			<label><?php if ($_GET['f'] == '') {
echo smarty_function_lang_entry(array('key'=>"msg.label.message"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"upage.text.mod.comment.single"),$_smarty_tpl);
}?>:</label>
			<span class="compose-right-reply"><?php echo $_smarty_tpl->tpl_vars['mtext']->value;?>
</span>
		    </div>
		    <div class="wdmax left-float bottom-border">&nbsp;</div>
		    <div class="left-float top-padding10">&nbsp;</div>
		    <div class="row3">
			<input type="hidden" name="section_reply_value" value="<?php echo smarty_modifier_sanitize($_POST['section_reply_value']);?>
" />
			<input type="hidden" name="section_subject_value" value=<?php echo smarty_modifier_sanitize($_POST['section_subject_value']);?>
"" />
		    </div>
		</div>
	    <?php }?>
		<div class="row no-top-padding">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.from"),$_smarty_tpl);?>
</label>
		    <span class="compose-right-label"><?php echo $_SESSION['USER_DNAME'];?>
</span>
		</div>
		<div class="row">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.to"),$_smarty_tpl);?>
</label>
		    <span class="left-float"><input type="text"<?php if ($_GET['f'] == "comm") {?> readonly="readonly"<?php }?> name="msg_label_to" class="login-input" id="msg-label-to" value="<?php if ($_GET['r'] == 1) {
echo $_smarty_tpl->tpl_vars['uname']->value;
} elseif ($_GET['src'] == 'upage') {
echo $_SESSION['channel_msg'];
} else {
echo smarty_modifier_sanitize($_POST['msg_label_to']);
}?>" /></span>
		</div>
		<div class="row"<?php if ($_GET['f'] == 'comm') {?> style="display: none;"<?php }?>>
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.subj"),$_smarty_tpl);?>
</label>
		    <span class="left-float"><input type="text" name="msg_label_subj" class="login-input" value="<?php if ($_GET['r'] == 1) {
echo smarty_function_lang_entry(array('key'=>"msg.label.reply"),$_smarty_tpl);
echo $_smarty_tpl->tpl_vars['msubj']->value;
} else {
echo smarty_modifier_sanitize($_POST['msg_label_subj']);
}?>" /></span>
		</div>
		<div class="row">
		    <label><?php if ($_GET['f'] == '') {
echo smarty_function_lang_entry(array('key'=>"msg.label.message"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"upage.text.mod.comment.single"),$_smarty_tpl);
}?></label>
		    <span class="left-float"><textarea name="<?php if ($_GET['f'] == "comm") {?>upage_text_mod_comment_single<?php } else { ?>msg_label_message<?php }?>" class="ta-input"><?php if ($_GET['f'] == "comm") {
echo smarty_modifier_sanitize($_POST['upage_text_mod_comment_single']);
} else {
echo smarty_modifier_sanitize($_POST['msg_label_message']);
}?></textarea></span>
		</div>
	    <?php if ($_smarty_tpl->tpl_vars['message_attachments']->value == 1 && $_GET['f'] == '') {?>
	    <?php if ($_smarty_tpl->tpl_vars['live_module']->value == "1") {?>
		<div class="row">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.attch.l"),$_smarty_tpl);?>
</label>
		    <div class="compose-right-label selector"><?php echo insert_fileListSelect(array('for' => "live"),$_smarty_tpl);?></div>
		</div>
	    <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['video_module']->value == "1") {?>
		<div class="row">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.attch.v"),$_smarty_tpl);?>
</label>
		    <div class="compose-right-label selector"><?php echo insert_fileListSelect(array('for' => "video"),$_smarty_tpl);?></div>
		</div>
	    <?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['image_module']->value == "1") {?>
		<div class="row">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.attch.i"),$_smarty_tpl);?>
</label>
		    <div class="compose-right-label selector"><?php echo insert_fileListSelect(array('for' => "image"),$_smarty_tpl);?></div>
		</div>
	    <?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['audio_module']->value == "1") {?>
		<div class="row">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.attch.a"),$_smarty_tpl);?>
</label>
		    <div class="compose-right-label selector"><?php echo insert_fileListSelect(array('for' => "audio"),$_smarty_tpl);?></div>
		</div>
	    <?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['document_module']->value == "1") {?>
		<div class="row">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.attch.d"),$_smarty_tpl);?>
</label>
		    <div class="compose-right-label selector"><?php echo insert_fileListSelect(array('for' => "doc"),$_smarty_tpl);?></div>
		</div>
	    <?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['blog_module']->value == "1") {?>
		<div class="row">
		    <label><?php echo smarty_function_lang_entry(array('key'=>"msg.label.attch.b"),$_smarty_tpl);?>
</label>
		    <div class="compose-right-label selector"><?php echo insert_fileListSelect(array('for' => "blog"),$_smarty_tpl);?></div>
		</div>
	    <?php }?>
	    <?php }?>
	    <br>
	    	<div class="clearfix"></div>
		<div class="row">
			<button class="new-message-button save-entry-button button-grey search-button form-button" name="msg_btn_send" id="msg-btn-send" type="button" value="1"><span><?php echo smarty_function_lang_entry(array('key'=>"msg.btn.send"),$_smarty_tpl);?>
</span></button>
			<a href="#" class="link cancel-trigger "id="msg-btn-cancel"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.cancel"),$_smarty_tpl);?>
</span></a>
		<?php if ($_smarty_tpl->tpl_vars['message_attachments']->value == "1") {?>
		    <span class="place-right"><?php echo smarty_function_lang_entry(array('key'=>"msg.label.private.tip"),$_smarty_tpl);?>
</span>
		<?php }?>
		</div>
	    </form>
	    </div>
        </div>

        <?php echo '<script'; ?>
 type="text/javascript">
    	$(document).ready(function() {
    		$("#msg-label-to").keydown(function(){
                $("#msg-label-to").autocomplete({
                        type: "post",
//                        params: {"t": $(".view-mode-type.active").attr("id").replace("view-mode-", "") },
                        serviceUrl: current_url + menu_section +"?s=" + $(".menu-panel-entry-active").attr("id") +"&do=autocomplete&m=0",
                        onSearchStart: function() {},
                        onSelect: function (suggestion) {
//                                $(".file-search").trigger("click");
                        }
                });
        });

    	<?php if ($_smarty_tpl->tpl_vars['message_attachments']->value == 1 && $_GET['f'] == '') {?>
    		$(function() {
                        <?php if ($_smarty_tpl->tpl_vars['live_module']->value == "1") {?>SelectList.init("live_attachlist");<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['video_module']->value == "1") {?>SelectList.init("video_attachlist");<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['image_module']->value == "1") {?>SelectList.init("image_attachlist");<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['audio_module']->value == "1") {?>SelectList.init("audio_attachlist");<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['document_module']->value == "1") {?>SelectList.init("doc_attachlist");<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['blog_module']->value == "1") {?>SelectList.init("blog_attachlist");<?php }?>
                });
	<?php }?>

    	    function msg_gotoInbox(doNotice, mID) {
//    		$("h2").text($("#"+mID+" span.mm").text());
    		wrapLoad(current_url+menu_section+"?s="+mID+"&notice="+doNotice, fe_mask);
    	    }

    	    $("#msg-btn-send").click(function(){
    		var post_url  = current_url+menu_section+"?do=compose<?php if ($_GET['r'] != '') {?>&r=2<?php }
if ($_GET['f'] == "comm") {?>&f=comm<?php }?>";
    		var post_form = $("#compose-msg-form");
    		postLoad(post_url, post_form, fe_mask);
    	    });

    	    $("#msg-btn-cancel").click(function(){
    		msg_gotoInbox(0, $("#categories-accordion .menu-panel-entry-active").attr("id"));
    	    });
    	});
        <?php echo '</script'; ?>
><?php }
}

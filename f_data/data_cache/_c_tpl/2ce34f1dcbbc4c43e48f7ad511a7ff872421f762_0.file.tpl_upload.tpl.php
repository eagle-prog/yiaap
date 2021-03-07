<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:21:47
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_upload.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c737bc021c6_94709282',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ce34f1dcbbc4c43e48f7ad511a7ff872421f762' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_upload.tpl',
      1 => 1590175576,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c737bc021c6_94709282 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
if ($_smarty_tpl->tpl_vars['usr_verified']->value == "0") {?>
    <div id="verify-response" class="row no-top-padding"></div>
    <div class="left-float wdmax top-padding10">
	<h3 class="greyed-out"> - <?php echo $_smarty_tpl->tpl_vars['usr_mail']->value;?>
 -</h3>
	<h3 class="top-padding10 darker-out"><?php echo smarty_function_lang_entry(array('key'=>"upload.err.mail.ver1"),$_smarty_tpl);?>
</h3>
	<div class="row"><?php echo smarty_function_lang_entry(array('key'=>"upload.err.mail.ver2"),$_smarty_tpl);?>
</div>
	<br>
	<form id="verify-form" name="verify_form" method="post" action="" class="entry-form-class">
	    <div class="row top-padding20">
                <span class="left-float wd140 lh20"><?php echo smarty_function_lang_entry(array('key'=>"upload.text.ver.code"),$_smarty_tpl);?>
</span>
                <span class="left-float"><input type="text" id="verification-captcha" name="verification_captcha" class="text-input" style="max-width:300px"/></span>
                <span class="left-float left-padding5"><img id="c-image" src="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"captcha"),$_smarty_tpl);?>
?t=<?php echo $_smarty_tpl->tpl_vars['c_rand']->value;?>
" alt="" /></span>
            </div>
            <div class="row no-top-padding">
                <span class="left-float wd140" style="width:120px;display:inline-block;">&nbsp;</span>
                <span class=""><button type="button" class="save-entry-button button-grey search-button form-button resend-verification" name="send_verification"><?php echo smarty_function_lang_entry(array('key'=>"upload.text.ver.send"),$_smarty_tpl);?>
</button></span>
            </div>
	    <div class="row no-display"><input type="hidden" name="verify_email" value="<?php echo $_smarty_tpl->tpl_vars['usr_mail']->value;?>
" /></div>
	</form>
    </div>
    <?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function(){
	    $(".resend-verification").click(function(){
		$(".col1").mask(" ");
                $.post("<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"upload"),$_smarty_tpl);
if ($_GET['t'] == '') {?>?do=reverify<?php } else { ?>?t=<?php echo smarty_modifier_sanitize($_GET['t']);?>
&do=reverify<?php }?>", $("#verify-form").serialize(), function(data){
                    $("#verify-response").html(data);
                    $(".col1").unmask();
                });
	    });
	});
    <?php echo '</script'; ?>
>
<?php } else { ?>
    <?php if ($_smarty_tpl->tpl_vars['perm_err']->value == '' && $_SESSION['USER_KEY'] != '') {?>
    <?php if ($_GET['r'] != '') {
echo insert_uploadResponse(array(),$_smarty_tpl);
}?>
    <div class="sp-container">
	<div class="tabs tabs-style-topline">
		<nav>
			<ul>
                                <?php if ($_smarty_tpl->tpl_vars['video_module']->value == 1 && $_smarty_tpl->tpl_vars['video_uploads']->value == 1) {?><li<?php if ($_GET['t'] == "video") {?> class="tab-current"<?php }?>><a class="icon icon-video" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"upload"),$_smarty_tpl);?>
?t=video"><span><?php echo smarty_function_lang_entry(array('key'=>"upload.menu.video"),$_smarty_tpl);?>
</span></a></li><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['import_yt']->value == 1 || $_smarty_tpl->tpl_vars['import_dm']->value == 1 || $_smarty_tpl->tpl_vars['import_vi']->value == 1) {?><li<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_import" && $_GET['t'] == "video") {?> class="tab-current"<?php }?>><a class="icon icon-video" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"import"),$_smarty_tpl);?>
?t=video"><span><?php echo smarty_function_lang_entry(array('key'=>"upload.menu.grab"),$_smarty_tpl);?>
</span></a></li><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['image_module']->value == 1 && $_smarty_tpl->tpl_vars['image_uploads']->value == 1) {?><li<?php if ($_GET['t'] == "image") {?> class="tab-current"<?php }?>><a class="icon icon-image" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"upload"),$_smarty_tpl);?>
?t=image"><span><?php echo smarty_function_lang_entry(array('key'=>"upload.menu.image"),$_smarty_tpl);?>
</span></a></li><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['audio_module']->value == 1 && $_smarty_tpl->tpl_vars['audio_uploads']->value == 1) {?><li<?php if ($_GET['t'] == "audio") {?> class="tab-current"<?php }?>><a class="icon icon-audio" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"upload"),$_smarty_tpl);?>
?t=audio"><span><?php echo smarty_function_lang_entry(array('key'=>"upload.menu.audio"),$_smarty_tpl);?>
</span></a></li><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['document_module']->value == 1 && $_smarty_tpl->tpl_vars['document_uploads']->value == 1) {?><li<?php if ($_GET['t'] == "document") {?> class="tab-current"<?php }?>><a class="icon icon-file" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"upload"),$_smarty_tpl);?>
?t=document"><span><?php echo smarty_function_lang_entry(array('key'=>"upload.menu.document"),$_smarty_tpl);?>
</span></a></li><?php }?>
			</ul>
		</nav>
	</div><br>
	<?php if ($_smarty_tpl->tpl_vars['error_message']->value != '') {?>
                <div class="error-message" id="error-message" onclick="$(this).replaceWith(''); $('#cb-response').replaceWith(''); $('#cb-response-wrap').replaceWith('');">
                    <p class="error-message-text"><?php echo $_smarty_tpl->tpl_vars['error_message']->value;?>
</p>
                </div>
                <div class="clearfix"></div>
	<?php } else { ?>
	<div class="clearfix"></div>
	<div id="upload-wrapper" class="left-float">
		<div class="pointer left-float no-top-padding wdmax section-bottom-border" id="cb-response-wrap" style="display: none;"><div class="centered"><div class="pointer left-float wdmax" id="cb-response">
                <div class="notice-message" id="notice-message" onclick="$(this).replaceWith(''); $('#cb-response').replaceWith(''); $('#cb-response-wrap').replaceWith('');">
                    <p class="notice-message-text"><?php echo smarty_function_lang_entry(array('key'=>"upload.text.public"),$_smarty_tpl);?>
</p>
                </div>
                </div></div></div>

            <form id="upload-form" method="post" action="<?php echo smarty_function_href_entry(array('key'=>"be_submit"),$_smarty_tpl);?>
?t=<?php echo smarty_modifier_sanitize($_GET['t']);
if ($_GET['r'] != '') {?>&r=<?php echo smarty_modifier_sanitize($_GET['r']);
}?>">
                <div id="upload-wrapper" class="left-float wd960">
                    <div class="left-float wdmax">
                        <div id="uploader" class="frontend">
                            <p class="all-paddings10">Loading Upload Panel...</p>
                        </div>
                    </div>
                </div>
                <div id="options-wrapper" class="left-float wd450 no-display">
                    <div class="plupload_header">
                        <span class="left-padding5 left-float"><?php echo $_smarty_tpl->tpl_vars['file_category']->value;?>
</span>
                        <span id="upload-category"><?php echo $_smarty_tpl->tpl_vars['upload_category']->value;?>
</span>
                    </div>
                </div>
		<input type="hidden" name="UFSUID" value="<?php echo $_SESSION['USER_KEY'];?>
" />
		<input type="hidden" name="UFUID" value="<?php echo $_SESSION['USER_ID'];?>
" />
		<input type="hidden" name="UFNAME" id="UFNAME" value="" />
		<input type="hidden" name="UFSIZE" id="UFSIZE" value="" />
            </form>
        </div>

		<?php if ($_smarty_tpl->tpl_vars['paid_memberships']->value == "1") {?>
		<div class="">
		    <div class="" id="fsUploadStats" style="display: none;">
		    	<article>
                        	<h3 class="content-title">
                        		<i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"upload.text.mem.limit"),$_smarty_tpl);?>

                        		
                        	</h3>
                        	<div class="line"></div>
                	</article>
                	<div id="the-stats" style="display: block;">
		    		<?php echo $_smarty_tpl->tpl_vars['the_stats']->value;?>

		    	</div>
		    </div>
		    <div class="no-display">
			<input type="hidden" id="total-uploads" name="total_uploads" value="0" />
			<input type="hidden" id="type-uploads" name="type_uploads" value="<?php echo smarty_modifier_sanitize($_GET['t'][0]);?>
" />
			<span id="replace-uploads"><?php echo smarty_function_lang_entry(array('key'=>"upload.err.msg.9.1"),$_smarty_tpl);?>
</span>
		    </div>
		</div>
		<?php }?>
	<?php }?>
    </div>
    <?php } elseif ($_smarty_tpl->tpl_vars['error_message']->value != '') {?>
        <?php echo $_smarty_tpl->tpl_vars['error_message']->value;?>

    <?php }
}
}
}

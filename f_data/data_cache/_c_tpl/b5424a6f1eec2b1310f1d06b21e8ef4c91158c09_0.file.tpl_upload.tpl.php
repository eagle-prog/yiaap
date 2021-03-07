<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:40:09
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_upload.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c317945c1a3_05554568',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b5424a6f1eec2b1310f1d06b21e8ef4c91158c09' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_upload.tpl',
      1 => 1488319200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c317945c1a3_05554568 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
if ($_smarty_tpl->tpl_vars['error_message']->value == '') {?>
    <div class="container cbp-spmenu-push">
	<div id="upload-wrapper" class="left-float">
		<div class="pointer left-float no-top-padding wdmax section-bottom-border" id="cb-response-wrap" style="display: none;"><div class="centered"><div class="pointer left-float wdmax" id="cb-response">
                <div class="notice-message" id="notice-message" onclick="$(this).replaceWith(''); $('#cb-response').replaceWith(''); $('#cb-response-wrap').replaceWith('');">
                    <p class="notice-message-text"><?php echo smarty_function_lang_entry(array('key'=>"upload.text.public"),$_smarty_tpl);?>
</p>
                </div>
                </div></div></div>

	    <form id="upload-form" method="post" action="<?php echo smarty_function_href_entry(array('key'=>"be_submit"),$_smarty_tpl);?>
?t=<?php echo smarty_modifier_sanitize($_GET['t']);?>
">
		<div id="upload-wrapper" class="left-float wd960">
		    <div class="left-float wdmax">
    			<div id="uploader">
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
		<input type="hidden" name="UFNAME" id="UFNAME" value="" />
		<input type="hidden" name="UFSIZE" id="UFSIZE" value="" />
		<input type="hidden" name="UFBE" id="UFBE" value="1" />
	    </form>
	</div>
    </div>
<?php }
}
}

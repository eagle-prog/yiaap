<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-save-open-close.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b5283b5_89244674',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b92296c5d2f6d5edce787884ebc842b12fa13c91' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-save-open-close.tpl',
      1 => 1475787600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b5283b5_89244674 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
		<?php $_smarty_tpl->assign('mm_entry' , insert_currentMenuEntry (array('for' => smarty_modifier_sanitize($_GET['s'])),$_smarty_tpl), true);?>
		<?php if (($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_servers" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_categ" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_banners" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_lang" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwcodes" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwads" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_fpads") && $_GET['do'] == "add") {
$_smarty_tpl->_assignInScope('cl_display', "none");
$_smarty_tpl->_assignInScope('ca_display', "block");
} else {
$_smarty_tpl->_assignInScope('cl_display', "block");
$_smarty_tpl->_assignInScope('ca_display', "none");
}?>
		<div id="open-close-links" style="display: <?php echo $_smarty_tpl->tpl_vars['cl_display']->value;?>
;">
		    <div class="open-close-links right-float font12 bottom-padding5<?php if ($_smarty_tpl->tpl_vars['global_section']->value == "backend") {?> right-padding10 top-padding3<?php }?>" style="float: right;">
			<?php if ($_GET['s'] == "backend-menu-entry3-sub14") {?>
			<span title="Resume transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_video_transfer']->value == 0) {?>no-display<?php }?>"><i class="icon-play resume-mode"></i></span>
			<span title="Pause transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_video_transfer']->value == 1) {?>no-display<?php }?>"><i class="icon-pause pause-mode"></i></span>
                        <?php }?>
			<?php if ($_GET['s'] == "backend-menu-entry3-sub15") {?>
			<span title="Resume transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_image_transfer']->value == 0) {?>no-display<?php }?>"><i class="icon-play resume-mode"></i></span>
			<span title="Pause transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_image_transfer']->value == 1) {?>no-display<?php }?>"><i class="icon-pause pause-mode"></i></span>
                        <?php }?>
			<?php if ($_GET['s'] == "backend-menu-entry3-sub16") {?>
			<span title="Resume transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_audio_transfer']->value == 0) {?>no-display<?php }?>"><i class="icon-play resume-mode"></i></span>
			<span title="Pause transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_audio_transfer']->value == 1) {?>no-display<?php }?>"><i class="icon-pause pause-mode"></i></span>
                        <?php }?>
			<?php if ($_GET['s'] == "backend-menu-entry3-sub17") {?>
			<span title="Resume transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_doc_transfer']->value == 0) {?>no-display<?php }?>"><i class="icon-play resume-mode"></i></span>
			<span title="Pause transfers" rel="tooltip" class="<?php if ($_smarty_tpl->tpl_vars['pause_doc_transfer']->value == 1) {?>no-display<?php }?>"><i class="icon-pause pause-mode"></i></span>
                        <?php }?>
                        <span title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.closeall"),$_smarty_tpl);?>
" rel="tooltip"><i class="iconBe-popin icon-contract2" id="all-close<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>-ct<?php }?>"></i></span>
		    	<span title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.openall"),$_smarty_tpl);?>
" rel="tooltip"><i class="iconBe-popout icon-expand2" id="all-open<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>-ct<?php }?>"></i></span>
		    	<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_account") {?>
		    		<span title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.savechanges"),$_smarty_tpl);?>
" rel="tooltip"><i class="iconBe-floppy-disk" id="all-save" onclick="$('.sortings .save-entry-button').click();"></i></span>
		    	<?php }?>
		    	<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_import") {?>
		    		<span title="<?php echo smarty_function_lang_entry(array('key'=>"backend.import.feed.import"),$_smarty_tpl);?>
" rel="tooltip"><i class="iconBe-floppy-disk" id="all-save" onclick="$('.sortings .save-videos-button').click();"></i></span>
		    	<?php }?>
		    </div>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry6" || $_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry11") {?>
		    <input type="hidden" id="p-user-key" name="p_user_key" value="<?php echo smarty_modifier_sanitize($_GET['u']);?>
" />
		<?php }
}
}

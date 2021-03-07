<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-save-top.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b4bd088_15277773',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a877a320b383119749a1f71855d18fb9ab37c17f' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-save-top.tpl',
      1 => 1565142826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_file/tpl_addplaylist.tpl' => 1,
    'file:tpl_frontend/tpl_msg/tpl_addlabel.tpl' => 1,
    'file:tpl_frontend/tpl_msg/tpl_contact_add.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-save-top-js.tpl' => 1,
  ),
),false)) {
function content_601c2f6b4bd088_15277773 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),3=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.replace.php','function'=>'smarty_modifier_replace',),4=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
	<?php if ($_GET['s'] != '') {
$_smarty_tpl->_assignInScope('get_s', smarty_modifier_sanitize($_GET['s']));
} else {
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files") {
$_smarty_tpl->assign('s' , insert_getCurrentSection (array(),$_smarty_tpl), true);
$_smarty_tpl->_assignInScope('get_s', $_smarty_tpl->tpl_vars['s']->value ,true);
}
}?>
	<?php $_smarty_tpl->assign('mm_entry' , insert_currentMenuEntry (array('for' => $_smarty_tpl->tpl_vars['get_s']->value),$_smarty_tpl), true);?>
        <?php if (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs") || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlist") || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files") || ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_servers") || ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_streaming") || ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members") || ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") || ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_categ") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry7") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry8") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry9") || ($_smarty_tpl->tpl_vars['get_s']->value == "backend-menu-entry5-sub2") || ($_smarty_tpl->tpl_vars['get_s']->value == "backend-menu-entry2-sub16") || ($_smarty_tpl->tpl_vars['get_s']->value == "backend-menu-entry4-sub2") || ($_smarty_tpl->tpl_vars['get_s']->value == "backend-menu-entry4-sub3") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry2") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry4") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry5") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry6") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") || ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry3")) {?>
            <?php if ($_GET['do'] == "add") {
$_smarty_tpl->_assignInScope('check_all', 0 ,true);
} else {
$_smarty_tpl->_assignInScope('check_all', 1 ,true);
}?>
            <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" && $_smarty_tpl->tpl_vars['file_privacy']->value == "0" && $_smarty_tpl->tpl_vars['file_favorites']->value == "0" && $_smarty_tpl->tpl_vars['file_playlists']->value == "0" && $_smarty_tpl->tpl_vars['file_deleting']->value == "0" && $_smarty_tpl->tpl_vars['file_history']->value == "0" && $_smarty_tpl->tpl_vars['file_watchlist']->value == "0") {?>
                <?php $_smarty_tpl->_assignInScope('check_all', 0 ,true);?>
            <?php }?>
        <?php } else { ?>
            <?php $_smarty_tpl->_assignInScope('check_all', 0 ,true);?>
        <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_playlist") {?>
		<?php if ($_smarty_tpl->tpl_vars['check_all']->value == "1" && $_smarty_tpl->tpl_vars['get_s']->value != "file-menu-entry6") {?><div class="left-float double-check-arrow icheck-box" id="checkselect-all-entries"><input style="display: block;" type="checkbox" id="check-all" /></div><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['check_all']->value == "1" && $_smarty_tpl->tpl_vars['get_s']->value != "file-menu-entry6") {?>
		<div class="menu-drop">
		    <div <?php if ($_smarty_tpl->tpl_vars['check_all']->value == "1") {?>id="entry-action-buttons<?php if ($_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['get_s']->value == "file-menu-entry8") {
}?>" class="dl-menuwrapper"<?php } else { ?>class="ul-no-list"<?php }?>>
		    		<?php if (substr($_smarty_tpl->tpl_vars['page_display']->value,0,7) == "backend") {?>
		    		<span class="dl-trigger actions-trigger" rel="tooltip" title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.selection.actions"),$_smarty_tpl);?>
"></span>
		    		<?php } else { ?>
				<span class="dl-trigger actions-trigger" rel="tooltip" title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.selection.actions"),$_smarty_tpl);?>
"></span>
				<?php }?>
			    <ul class="dl-menu">
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry4") {?>
				<li class="count" id="cb-approve"><a href="javascript:;"><i class="icon-check"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.invites.approve"),$_smarty_tpl);?>
</a></li>
				<li class="count" id="cb-disable"><a href="javascript:;"><i class="icon-stop"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.invites.ignore"),$_smarty_tpl);?>
</a></li>
			    <?php } elseif ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry3") {?>
				<li class="count" id="cb-enable"><a href="javascript:;"><i class="icon-check"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.invites.approve"),$_smarty_tpl);?>
</a></li>
				<li class="count" id="cb-disable"><a href="javascript:;"><i class="icon-stop"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.comments.approve"),$_smarty_tpl);?>
</a></li>
			    <?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" || $_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry10") {?>
				<li class="count be-count file-action" id="cb-active"><a href="javascript:;"><i class="icon-play"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.active"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-inactive"><a href="javascript:;"><i class="icon-stop"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.inactive"),$_smarty_tpl);?>
</a></li>
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>
				<li class="count be-count file-action" id="cb-approve"><a href="javascript:;"><i class="icon-check"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.approve"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-disapprove"><a href="javascript:;"><i class="icon-pause"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.disapprove"),$_smarty_tpl);?>
</a></li>
			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry10") {?>
			    	<li class="count be-count file-action" id="cb-partner"><a href="javascript:;"><i class="icon-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.partner"),$_smarty_tpl);?>
</a></li>
			    	<li class="count be-count file-action" id="cb-unpartner"><a href="javascript:;"><i class="icon-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.unpartner"),$_smarty_tpl);?>
</a></li>
			    	<li class="count be-count file-action" id="cb-affiliate"><a href="javascript:;"><i class="icon-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.affiliate"),$_smarty_tpl);?>
</a></li>
			    	<li class="count be-count file-action" id="cb-unaffiliate"><a href="javascript:;"><i class="icon-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.unaffiliate"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-promote"><a href="javascript:;"><i class="icon-bullhorn"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.promote"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-unpromote"><a href="javascript:;"><i class="icon-bullhorn"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.unpromote"),$_smarty_tpl);?>
</a></li>
			    <?php }?>
				<li class="count be-count file-action" id="cb-feature"><a href="javascript:;"><i class="icon-star"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.feature"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-unfeature"><a href="javascript:;"><i class="icon-star"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.unfeature"),$_smarty_tpl);?>
</a></li>
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "backend-menu-entry10") {?>
				<li class="count be-count file-action" id="cb-verify"><a href="javascript:;"><i class="icon-envelope"></i> <?php echo smarty_function_lang_entry(array('key'=>"account.action.em.ver"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-unverify"><a href="javascript:;"><i class="icon-envelope"></i> <?php echo smarty_function_lang_entry(array('key'=>"account.action.em.unver"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-ban"><a href="javascript:;"><i class="icon-blocked"></i> <?php echo smarty_function_lang_entry(array('key'=>"account.action.ip.ban"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-unban"><a href="javascript:;"><i class="icon-blocked"></i> <?php echo smarty_function_lang_entry(array('key'=>"account.action.ip.unban"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-email"><a href="javascript:;"><i class="icon-envelope"></i> <?php echo smarty_function_lang_entry(array('key'=>"account.btn.send.email"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-delete"><a href="javascript:;"><i class="icon-times"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.delete.sel"),$_smarty_tpl);?>
</a></li>
			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>
				<li class="count be-count file-action" id="cb-promote"><a href="javascript:;"><i class="icon-bullhorn"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.promote"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-unpromote"><a href="javascript:;"><i class="icon-bullhorn"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.unpromote"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-public"><a href="javascript:;"><i class="icon-globe"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.public"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-private"><a href="javascript:;"><i class="icon-key"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.private"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-personal"><a href="javascript:;"><i class="icon-lock"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.personal"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-unflag"><a href="javascript:;"><i class="icon-flag"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.flagged"),$_smarty_tpl);?>
</a></li>
				<li class="count be-count file-action" id="cb-del-files"><a href="javascript:;"><i class="icon-times"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.del.files"),$_smarty_tpl);?>
</a></li>
			    <?php }?>
			    <?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs") {?>
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry7") {?>
				<li class="count file-action" id="cb-enable"><a href="javascript:;"><i class="icon-check"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.invites.approve"),$_smarty_tpl);?>
</a></li>
				<li class="count file-action" id="cb-disable"><a href="javascript:;"><i class="icon-stop"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.comments.approve"),$_smarty_tpl);?>
</a></li>
				<li class="count file-action" id="cb-commdel"><a href="javascript:;"><i class="icon-times"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.delete.sel"),$_smarty_tpl);?>
</a></li>
			    <?php } elseif ($_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry8") {?>
				<li class="count file-action" id="cb-renable"><a href="javascript:;"><i class="icon-check"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.invites.approve"),$_smarty_tpl);?>
</a></li>
				<li class="count file-action" id="cb-rdisable"><a href="javascript:;"><i class="icon-stop"></i> <?php echo smarty_function_lang_entry(array('key'=>"contacts.comments.approve"),$_smarty_tpl);?>
</a></li>
				<li class="count file-action" id="cb-rdel"><a href="javascript:;"><i class="icon-times"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.delete.sel"),$_smarty_tpl);?>
</a></li>
			    <?php } else { ?>
				<?php if ($_smarty_tpl->tpl_vars['file_privacy']->value == "1" && $_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry1") {?>
				<li class="count file-action" id="cb-private"><a href="javascript:;"><i class="icon-key"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.private"),$_smarty_tpl);?>
</a></li>
				<li class="count file-action" id="cb-public"><a href="javascript:;"><i class="icon-globe"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.public"),$_smarty_tpl);?>
</a></li>
				<li class="count file-action" id="cb-personal"><a href="javascript:;"><i class="icon-lock"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.personal"),$_smarty_tpl);?>
</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['file_favorites']->value == "1") {?>
				<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value != "file-menu-entry2") {?>
				<li class="count file-action" id="cb-favadd"><a href="javascript:;"><i class="icon-heart"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.fav.add"),$_smarty_tpl);?>
</a></li>
				<?php }?>
				<li class="count file-action" id="cb-favclear"><a href="javascript:;"><i class="icon-heart"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.fav.clear"),$_smarty_tpl);?>
</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['file_playlists']->value == "1") {?>
				<?php $_smarty_tpl->assign("addToLabel" , insert_addToLabel (array('for' => "tpl_pl"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['addToLabel']->value;?>

				<?php }?>
			    <?php }?>
			    <?php } else { ?>
				<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry2" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry5" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry7") {?><li class="count" id="cb-enable"><a href="javascript:;"><i class="icon-check"></i> <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry6") {
echo smarty_function_lang_entry(array('key'=>"msg.entry.not.spam"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"frontend.global.enable.sel"),$_smarty_tpl);
}?></a></li><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry6" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry5" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry7") {?><li class="count" id="cb-disable"><a href="javascript:;"><i class="icon-spam"></i> <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" && $_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry2") {
echo smarty_function_lang_entry(array('key'=>"msg.details.spam.capital"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"frontend.global.disable.sel"),$_smarty_tpl);
}?></a></li><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry2" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry6" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry5" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry7") {?><li class="count be-count file-action" id="cb-delete"><a href="javascript:;"><i class="icon-times"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.delete.sel"),$_smarty_tpl);?>
</a></li><?php }?>
			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" && $_smarty_tpl->tpl_vars['custom_labels']->value == 1) {
$_smarty_tpl->assign("addToLabel" , insert_addToLabel (array('for' => ((string)$_smarty_tpl->tpl_vars['mm_entry']->value)),$_smarty_tpl), true);?>
				<?php echo $_smarty_tpl->tpl_vars['addToLabel']->value;?>

			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>
			    <?php if ($_smarty_tpl->tpl_vars['user_friends']->value == 1) {?>
				<li class="count" id="cb-addfr"><a href="javascript:;"><i class="icon-users5"></i> <?php echo smarty_function_lang_entry(array('key'=>"msg.friend.add"),$_smarty_tpl);?>
</a></li>
			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1 && $_smarty_tpl->tpl_vars['allow_multi_messaging']->value == 1) {?>
				<li class="count" id="cb-sendmsg"><a href="javascript:;"><i class="icon-envelope"></i> <?php echo smarty_function_lang_entry(array('key'=>"msg.friend.message"),$_smarty_tpl);?>
</a></li>
			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['user_blocking']->value == 1) {?>
				<li class="count" id="cb-block"><a href="javascript:;"><i class="icon-blocked"></i> <?php echo smarty_function_lang_entry(array('key'=>"msg.block.sel"),$_smarty_tpl);?>
</a></li>
				<li class="count" id="cb-unblock"><a href="javascript:;"><i class="icon-blocked"></i> <?php echo smarty_function_lang_entry(array('key'=>"msg.unblock.sel"),$_smarty_tpl);?>
</a></li>
			    <?php }?>
			    <?php }?>
			    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry4" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_subs") {?>
				<?php if (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" && $_smarty_tpl->tpl_vars['file_deleting']->value == "1" && $_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry1") || ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_files" && $_smarty_tpl->tpl_vars['page_display']->value != "backend_tpl_adv" && $_smarty_tpl->tpl_vars['page_display']->value != "backend_tpl_files" && $_smarty_tpl->tpl_vars['mm_entry']->value != "backend-menu-entry10")) {?>
				<li class="count file-action<?php if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_messages" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry4") {?> hidden<?php }?>" id="cb-delete"><a href="javascript:;"><i class="icon-times"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.delete.sel"),$_smarty_tpl);?>
</a></li>
				<?php } elseif (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" && $_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry3")) {?>
				<li class="count file-action" id="cb-likeclear"><a href="javascript:;"><i class="icon-thumbs-up"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.liked.clear"),$_smarty_tpl);?>
</a></li>
				<?php } elseif (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" && $_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry4")) {?>
				<li class="count file-action" id="cb-histclear"><a href="javascript:;"><i class="icon-history"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.hist.clear"),$_smarty_tpl);?>
</a></li>
				<?php } elseif (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" && $_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry5")) {?>
				<li class="count file-action" id="cb-watchclear"><a href="javascript:;"><i class="icon-clock"></i> <?php echo smarty_function_lang_entry(array('key'=>"files.action.watch.clear"),$_smarty_tpl);?>
</a></li>
				<?php }?>
			    <?php }?>
			    </ul>
		    </div>
		</div>
		<?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "file-menu-entry6") {?>
		<div class="left-float left-margin5">
		    <ul class="ul-no-list">
			<li>
			    <button name="save_new_pl" id="save-new-pl" class="new-label general-button form-button" type="button" onfocus="blur();">
				<?php echo smarty_function_lang_entry(array('key'=>"files.action.new"),$_smarty_tpl);?>

			    </button>
			    <ul>
			    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_file/tpl_addplaylist.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			    </ul>
			</li>
		    </ul>
		</div>
	    <?php }?>
	    <?php if ($_GET['s'] == "backend-menu-entry10-sub2" && $_GET['do'] != "add") {?>
	    	<?php echo smarty_function_generate_html(array('type'=>"user-type-actions-be"),$_smarty_tpl);?>

	    <?php }?>

	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>
	    	<?php if ($_GET['s'] == "backend-menu-entry6-sub1") {?>
	    		<?php ob_start();
echo smarty_function_lang_entry(array('key'=>"frontend.global.v.c"),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('ft', $_prefixVariable1);?>
	    		<?php $_smarty_tpl->_assignInScope('uk', "video");?>
	    	<?php } elseif ($_GET['s'] == "backend-menu-entry6-sub2") {?>
	    		<?php ob_start();
echo smarty_function_lang_entry(array('key'=>"frontend.global.i.c"),$_smarty_tpl);
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('ft', $_prefixVariable2);?>
	    		<?php $_smarty_tpl->_assignInScope('uk', "image");?>
	    	<?php } elseif ($_GET['s'] == "backend-menu-entry6-sub3") {?>
	    		<?php ob_start();
echo smarty_function_lang_entry(array('key'=>"frontend.global.a.c"),$_smarty_tpl);
$_prefixVariable3=ob_get_clean();
$_smarty_tpl->_assignInScope('ft', $_prefixVariable3);?>
	    		<?php $_smarty_tpl->_assignInScope('uk', "audio");?>
	    	<?php } elseif ($_GET['s'] == "backend-menu-entry6-sub4") {?>
	    		<?php ob_start();
echo smarty_function_lang_entry(array('key'=>"frontend.global.d.c"),$_smarty_tpl);
$_prefixVariable4=ob_get_clean();
$_smarty_tpl->_assignInScope('ft', $_prefixVariable4);?>
	    		<?php $_smarty_tpl->_assignInScope('uk', "document");?>
	    	<?php } elseif ($_GET['s'] == "backend-menu-entry6-sub5") {?>
	    		<?php ob_start();
echo smarty_function_lang_entry(array('key'=>"frontend.global.b.c"),$_smarty_tpl);
$_prefixVariable5=ob_get_clean();
$_smarty_tpl->_assignInScope('ft', $_prefixVariable5);?>
	    		<?php $_smarty_tpl->_assignInScope('uk', "blog");?>
	    	<?php } elseif ($_GET['s'] == "backend-menu-entry6-sub6") {?>
	    		<?php ob_start();
echo smarty_function_lang_entry(array('key'=>"frontend.global.l.c"),$_smarty_tpl);
$_prefixVariable6=ob_get_clean();
$_smarty_tpl->_assignInScope('ft', $_prefixVariable6);?>
	    		<?php $_smarty_tpl->_assignInScope('uk', "live");?>
	    	<?php }?>
	    	<div class="" id="add-new-entry">
	    		<button name="new_entry" id="new-entry" onclick="" class="save-entry-button button-grey search-button form-button new-upload" type="button" value="1" onfocus="blur();"><span><?php ob_start();
echo smarty_function_lang_entry(array('key'=>"files.menu.add.new"),$_smarty_tpl);
$_prefixVariable7=ob_get_clean();
$_smarty_tpl->_assignInScope('x', $_prefixVariable7);
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['x']->value,"##TYPE##",$_smarty_tpl->tpl_vars['ft']->value);?>
</span></button>
	    	</div>
	    	<?php echo '<script'; ?>
 type="text/javascript">
	    		$(document).ready(function() {
	    			$("#add-new-entry").prependTo("#ct-wrapper");
	    			$("#new-entry").on("click", function() {
	    				<?php if ($_GET['s'] == "backend-menu-entry6-sub5") {?>
	    					wrapLoad(current_url + "<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
?s=backend-menu-entry6-sub5&do=new-blog&t=blog", "blog");
	    				<?php } elseif ($_GET['s'] == "backend-menu-entry6-sub6") {?>
	    					wrapLoad(current_url + "<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
?s=backend-menu-entry6-sub6&do=new-broadcast&t=live", "live");
	    				<?php } else { ?>
	    					window.location = current_url + "<?php echo smarty_function_href_entry(array('key'=>"be_upload"),$_smarty_tpl);?>
?t=<?php echo $_smarty_tpl->tpl_vars['uk']->value;?>
";
	    				<?php }?>
	    			});
	    		});
	    	<?php echo '</script'; ?>
>
	    <?php }?>

	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_files" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_subs" && $_smarty_tpl->tpl_vars['page_display']->value != "backend_tpl_adv" && $_smarty_tpl->tpl_vars['page_display']->value != "backend_tpl_files") {?>
	    	<div class="place-left-off" id="add-new-entry">
			<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry3" && $_smarty_tpl->tpl_vars['mm_entry']->value != "message-menu-entry4" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_files") {?>
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members") {?>
				<?php if ($_GET['do'] == "add") {
$_smarty_tpl->_assignInScope('b_c', "new-entry" ,true);?>
				<?php } else {
$_smarty_tpl->_assignInScope('b_c', "add-button new-entry" ,true);?>
				<?php }?>
			    <?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>
				<?php $_smarty_tpl->_assignInScope('b_c', "new-label save-entry-button" ,true);?>
			    <?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_categ" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_lang" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_servers" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_streaming") {?>
				<?php $_smarty_tpl->_assignInScope('b_c', "new-entry" ,true);?>
			    <?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_banners" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwads" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwcodes" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_fpads") {?>
				<?php $_smarty_tpl->_assignInScope('b_c', "new-entry" ,true);?>
			    <?php } else { ?>
				<?php $_smarty_tpl->_assignInScope('b_c', "save-button button-blue save-entry-button" ,true);?>
			    <?php }?>

				<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>
					<button <?php if ($_smarty_tpl->tpl_vars['get_s']->value != "message-menu-entry7") {?>disabled="disabled"<?php }?> name="new_contact" id="new-contact" onclick="$('#add-new-label').stop().slideUp(); $('#ct-contact-add-wrap').stop().slideToggle();" class="save-entry-button button-grey search-button form-button new-contact" type="button" value="1" onfocus="blur();"><span><?php echo smarty_function_lang_entry(array('key'=>"contact.add.new"),$_smarty_tpl);?>
</span></button>
				<?php }?>

			    
			    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" && $_smarty_tpl->tpl_vars['internal_messaging']->value == 1) {?>
			    	<button type="button" class="new-message-button save-entry-button button-grey search-button form-button" name="compose-button" id="compose-button"><span><?php echo smarty_function_lang_entry(array('key'=>"msg.btn.compose"),$_smarty_tpl);?>
</span></button>
			    <?php }?>

			    <button name="save_changes" <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>id="new-label" <?php }?>class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" && $_smarty_tpl->tpl_vars['custom_labels']->value == 0) {?>no-display <?php }
if ($_GET['do'] == "add") {?>save-entry-button <?php }?>button-grey search-button form-button <?php echo $_smarty_tpl->tpl_vars['b_c']->value;?>
" type="button" value="1" onfocus="blur();" <?php if (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" && ($_smarty_tpl->tpl_vars['show_new_label']->value == "no" || $_smarty_tpl->tpl_vars['custom_labels']->value == 0))) {?>disabled="disabled"<?php }?>>
			    	<span>
				<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members") {?>
				    <?php if ($_GET['do'] == "add") {
echo smarty_function_lang_entry(array('key'=>"frontend.global.savenew"),$_smarty_tpl);?>

				    <?php } else {
echo smarty_function_lang_entry(array('key'=>"frontend.global.addnew"),$_smarty_tpl);
}?>
				<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>
				    <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.newlabel"),$_smarty_tpl);?>

				<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_categ" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_lang" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_servers" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_streaming") {?>
				    <?php if ($_GET['do'] == "add") {
echo smarty_function_lang_entry(array('key'=>"frontend.global.savenew"),$_smarty_tpl);?>

				    <?php } else {
echo smarty_function_lang_entry(array('key'=>"frontend.global.addnew"),$_smarty_tpl);
}?>
				<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_banners" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwads" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_jwcodes" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_fpads") {?>
				    <?php if ($_GET['do'] == "add") {
echo smarty_function_lang_entry(array('key'=>"frontend.global.savenew"),$_smarty_tpl);?>

				    <?php } else {
echo smarty_function_lang_entry(array('key'=>"frontend.global.addnew"),$_smarty_tpl);
}?>
				<?php } else { ?>
				    <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.savechanges"),$_smarty_tpl);?>

				<?php }?>
				</span>
			    </button>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" && $_smarty_tpl->tpl_vars['custom_labels']->value == 1) {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_msg/tpl_addlabel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>

	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages" && $_smarty_tpl->tpl_vars['show_new_label']->value == "no" && $_smarty_tpl->tpl_vars['custom_labels']->value == 1 && $_smarty_tpl->tpl_vars['get_s']->value != "message-menu-entry7-sub1" && $_smarty_tpl->tpl_vars['get_s']->value != "message-menu-entry7-sub2") {?>
		    <form id="rename-label-form" method="post" action="" class="entry-form-class">
		    	<button onclick="$('#label-rename-wrap').stop().slideToggle();" value="1" type="button" class="button-grey search-button form-button rename-label save-entry-button" id="rename-label" name="rename_label"><span><?php echo smarty_function_lang_entry(array('key'=>"label.rename.new"),$_smarty_tpl);?>
</span></button>
			<div style="display: none;" id="label-rename-wrap">
			<input type="text" name="current_label_name" id="current-label-name" value="<?php $_smarty_tpl->assign('label_name' , insert_getLabelName (array(),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['label_name']->value;?>
" class="login-input" size="20" />
			<button name="rename_label_btn" id="rename-label-btn" class="search-button no-display" type="button" value="1"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.rename"),$_smarty_tpl);?>
</button>
			</div>
		    </form>
		<?php echo '<script'; ?>
 type="text/javascript">$(document).ready(function() {$("#rename-label-btn").click(function(){$.post(current_url + menu_section + '?s=<?php echo $_smarty_tpl->tpl_vars['get_s']->value;?>
&do=rename', $("#rename-label-form").serialize(), function( data ) {wrapLoad(current_url + menu_section + '?s=<?php echo $_smarty_tpl->tpl_vars['get_s']->value;?>
', fe_mask); $(".dcjq-parent.active span.mm").text($("#current-label-name").val());}); });enterSubmit("#rename-label-form input", "#rename-label-btn"); });<?php echo '</script'; ?>
>
	    <?php }?>
			
		</div>
	    <?php }?>
				<?php if ($_smarty_tpl->tpl_vars['mm_entry']->value == "message-menu-entry7") {?>
					<div id="ct-contact-add-wrap" class="place-left" style="display: none;"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_msg/tpl_contact_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
				<?php }?>
	    
	    <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files") {?>
		<div class="sorting">
            	    <form id="sort-file-actions" class="entry-form-class" method="post" action="">
                	<?php if ($_GET['s'] != "backend-menu-entry6-sub2" && $_GET['s'] != "backend-menu-entry6-sub3" && $_GET['s'] != "backend-menu-entry6-sub4" && $_GET['s'] != "backend-menu-entry6-sub5" && $_GET['s'] != "backend-menu-entry6-sub6" && $_smarty_tpl->tpl_vars['categ_display']->value != "i" && $_smarty_tpl->tpl_vars['categ_display']->value != "a" && $_smarty_tpl->tpl_vars['categ_display']->value != "d" && $_smarty_tpl->tpl_vars['categ_display']->value != "b" && $_smarty_tpl->tpl_vars['categ_display']->value != "l") {
echo smarty_function_generate_html(array('type'=>"file-type-actions-be"),$_smarty_tpl);
}?>
                	<?php echo smarty_function_generate_html(array('type'=>"file-time-actions-be"),$_smarty_tpl);?>

            	    </form>
        	</div>
	    <?php }?>

	<?php }?>

	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_files.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f56b3b029_38332541',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '665b7aa802be0c66d3d36248f19ceac6ce7f97cb' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_files.tpl',
      1 => 1569546571,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_leftnav/tpl_nav_subs.tpl' => 1,
  ),
),false)) {
function content_601c2f56b3b029_38332541 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
	<?php if ($_SESSION['USER_ID'] > 0) {?>
	<?php $_smarty_tpl->assign('s' , insert_getCurrentSection (array(),$_smarty_tpl), true);?>

	<?php if ($_smarty_tpl->tpl_vars['unset']->value == 1 && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_messages" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_manage_channel" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_account" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_affiliate" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_subscribers") {?>
        <div class="blue categories-container<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlists" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_blogs") {?> hidden<?php }?>">
            <h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-video"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.files.my"),$_smarty_tpl);?>
</h4>
            <aside>
                <nav>
                    <ul class="accordion" id="categories-accordion">
                        <li id="file-menu-entry1" class="menu-panel-entry<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry1" || (($_smarty_tpl->tpl_vars['s']->value == '' && $_smarty_tpl->tpl_vars['page_display']->value == "tpl_files") && $_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_playlists" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_blogs" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_channel" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search")) {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"uploads"),$_smarty_tpl);?>
"><a href="javascript:;" class="<?php if ($_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search" && ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" && ($_smarty_tpl->tpl_vars['s']->value == '' || $_smarty_tpl->tpl_vars['s']->value == "file-menu-entry1"))) {?>dcjq-parent active<?php }?>"><i class="icon-upload"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.myfiles"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry1-count" class="right-float mm-count"></span><?php }?></li>
                            <?php if ($_smarty_tpl->tpl_vars['file_favorites']->value == "1") {?>
                        <li id="file-menu-entry2" class="menu-panel-entry<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry2") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"favorites"),$_smarty_tpl);?>
"><a href="javascript:;" class="<?php if ($_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search" && ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry2")) {?>dcjq-parent active<?php }?>"><i class="icon-heart"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.myfav"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry2-count" class="right-float mm-count"></span><?php }?></li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['file_rating']->value == "1") {?>
                        <li id="file-menu-entry3" class="menu-panel-entry<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry3") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"liked"),$_smarty_tpl);?>
"><a href="javascript:;" class="<?php if ($_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search" && ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry3")) {?>dcjq-parent active<?php }?>"><i class="icon-thumbs-up"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.liked"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry3-count" class="right-float mm-count"></span><?php }?></li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['file_history']->value == "1") {?>
                        <li id="file-menu-entry4" class="menu-panel-entry<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry4") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"history"),$_smarty_tpl);?>
"><a href="javascript:;" class="<?php if ($_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search" && ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry4")) {?>dcjq-parent active<?php }?>"><i class="icon-history"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.history"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry4-count" class="right-float mm-count"></span><?php }?></li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['file_watchlist']->value == "1") {?>
                        <li id="file-menu-entry5" class="menu-panel-entry<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry5") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"watchlist"),$_smarty_tpl);?>
"><a href="javascript:;" class="<?php if ($_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search" && ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry5")) {?>dcjq-parent active<?php }?>"><i class="icon-clock"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.watch"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry5-count" class="right-float mm-count"></span><?php }?></li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['file_playlists']->value == "1") {?>
                        <li id="file-menu-entry6" class="dcjq-parent-li menu-panel-entry<?php if ($_POST['do_reload'] == "1" || ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry6" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_channel") || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlists") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"playlists"),$_smarty_tpl);?>
"><a href="javascript:;"<?php if ($_POST['do_reload'] == "1" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" && $_GET['tf'] == 5) || ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry6" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_channel")) {?> class="dcjq-parent active"<?php }?>><i class="icon-list"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.mypl"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry6-count" class="right-float mm-count"></span><?php }?>
                                <?php $_smarty_tpl->assign('upl' , insert_getUserPlaylists (array('for' => "file-menu-entry6"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['upl']->value;?>

                        </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['file_comments']->value == "1") {?>
                        <li id="file-menu-entry7" class="menu-panel-entry<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry7") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"comments"),$_smarty_tpl);?>
"><a href="javascript:;" class="<?php if ($_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search" && ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry7")) {?>dcjq-parent active<?php }?>"><i class="icon-comment"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.comments"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry7-count" class="right-float mm-count"></span><?php }?></li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['file_responses']->value == "1") {?>
                        <li id="file-menu-entry8" class="menu-panel-entry<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry8") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
" rel-s="<?php echo smarty_function_href_entry(array('key'=>"responses"),$_smarty_tpl);?>
"><a href="javascript:;" class="<?php if ($_POST['do_reload'] == '' && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_search" && ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry8")) {?>dcjq-parent active<?php }?>"><i class="icon-comments"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"files.menu.responses"),$_smarty_tpl);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['file_counts']->value == 1) {?><span id="file-menu-entry8-count" class="right-float mm-count"></span><?php }?></li>
                            <?php }?>
                    </ul>
                </nav>
            </aside>
        </div>
        <?php }?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_subs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php } else { ?>
        	<?php echo insert_categoryMenu(array(),$_smarty_tpl);?>
        <?php }
}
}

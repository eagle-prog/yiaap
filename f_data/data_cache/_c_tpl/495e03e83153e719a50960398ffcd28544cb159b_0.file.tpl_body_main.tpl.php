<?php
/* Smarty version 3.1.33, created on 2021-02-19 11:56:07
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_body_main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602fa757d7fd88_50075351',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '495e03e83153e719a50960398ffcd28544cb159b' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_body_main.tpl',
      1 => 1613735592,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl' => 15,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl' => 16,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl' => 16,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_categ.tpl' => 4,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl' => 15,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl' => 12,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_blogs.tpl' => 1,
  ),
),false)) {
function content_602fa757d7fd88_50075351 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.page_display.php','function'=>'smarty_function_page_display',),));
?>
            <div class="container container_wrapper">
                <div class="fluid<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view") {?> viewpage-off<?php }?>">
                    <div class="inner-spacer"></div>
                    <div class="inner-block<?php if ($_SESSION['sbm'] == 1) {?> with-menu<?php }?>">
                        <section>
                            <article>
                                <div id="siteContent" class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlists") {?>playlists-wrapper<?php }?>">
                            	    <?php echo smarty_function_page_display(array('section'=>$_smarty_tpl->tpl_vars['page_display']->value),$_smarty_tpl);?>

                                </div>
                            </article>
                        </section>
                        <?php echo insert_advHTML(array('id' => "43"),$_smarty_tpl);
echo insert_advHTML(array('id' => "44"),$_smarty_tpl);?>
                    </div>
                </div>
<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_signin" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_signup" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_recovery" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_page" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_renew" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_payment") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                	<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse") {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_categ.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                	<?php } else {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_renew" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_payment") {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_categ.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}?>
                	<?php }?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index" && $_SESSION['USER_ID'] > 0) {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index" && $_SESSION['USER_ID'] == 0) || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_verify") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_SESSION['USER_ID'] > 0 && ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlist" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_upload" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_import")) {?>
                <div class="fixed-width sidebar-container sidebar-right-off"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_categ.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_SESSION['USER_ID'] == 0 && ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlist" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_upload" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_import")) {?>
                <div class="fixed-width sidebar-container sidebar-right-off"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_files_edit" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" && ($_GET['tf'] == 5 || $_GET['tf'] == 7)) || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlists" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_blogs") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_blogs") {?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_blogs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                <?php }?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_account") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_affiliate") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_manage_channel") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_categ.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs") {?>
                <div class="fixed-width sidebar-container"<?php if ($_SESSION['sbm'] == 0) {?> style="display: none;"<?php }?>>
                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                </div>
<?php }?>
            </div>
<?php }
}

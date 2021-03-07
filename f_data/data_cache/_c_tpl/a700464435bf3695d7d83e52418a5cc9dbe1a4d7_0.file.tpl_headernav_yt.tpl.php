<?php
/* Smarty version 3.1.33, created on 2021-03-02 20:41:45
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_headernav_yt.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_603ea309d35703_03371346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a700464435bf3695d7d83e52418a5cc9dbe1a4d7' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_headernav_yt.tpl',
      1 => 1614717701,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_header/tpl_headernav_pop.tpl' => 1,
  ),
),false)) {
function content_603ea309d35703_03371346 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
                        <header id="main_header">
                                <div class="dynamic_container">
                                        <div id="ct-header-top">
                                                <div id="logo_container">
                                                        <i class="icon icon-menu2 menu-trigger"></i>
                                                        <a class="navbar-brand" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"videos"),$_smarty_tpl);?>
" title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.home"),$_smarty_tpl);?>
" id="logo" rel="nofollow"></a>
                                                        <span id="menu-trigger-response"></span>
                                                </div>
                                                <div id="top_actions"<?php if ($_SESSION['USER_ID'] == 0) {?> class="no-session"<?php }?>>
                                                                <div class="user-thumb-xlarge top">
                                                                <?php if ($_SESSION['USER_ID'] > 0) {?>
                                                                        <img height="32" class="own-profile-image mt" title="<?php echo $_SESSION['USER_NAME'];?>
" alt="<?php echo $_SESSION['USER_NAME'];?>
" src="<?php $_smarty_tpl->assign("profileImage" , insert_getProfileImage (array('for' => ((string)$_SESSION['USER_ID'])),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['profileImage']->value;?>
">
                                                                <?php } else { ?>
                                                                	<span class="own-profile-image mt no-display"></span>
                                                                	<span class="no-session-icon" onclick="$('.own-profile-image.mt').click();"><i class="mt-open"></i></span>
                                                                <?php }?>

                                                                        <div class="arrow_box hidden blue" id="user-arrow-box">
                                                                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_header/tpl_headernav_pop.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                                                        </div>
                                                                </div>
                                                        <?php if ($_SESSION['USER_ID'] > 0) {?>
                                                                <a href="javascript:;" class="top-icon top-notif" title="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.notifications"),$_smarty_tpl);?>
">
                                                                        <i class="icon-notification"></i>
                                                                </a>
                                                                <div class="arrow_box hidden" id="notifications-arrow-box">
                                                                        <div class="arrow_box_pad">
                                                                                <div id="notifications-box">
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                         <?php }?>
                                                        <?php if ($_SESSION['USER_ID'] == 0) {?>
                                                                <form id="top-login-form"><a class="top-login-link" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signin"),$_smarty_tpl);?>
" rel="nofollow"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signin"),$_smarty_tpl);?>
</a></form>
                                                        <?php }?>
                                                </div>
                                                <div class="search_holder<?php if ($_SESSION['USER_ID'] == 0) {?> no-session-holder<?php }?>">
                                                        <div id="sb-search" class="sb-search sb-search-open">
                                                                <form method="get" action="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"search"),$_smarty_tpl);?>
">
                                                                        <input class="sb-search-input" placeholder="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.searchtext"),$_smarty_tpl);?>
" type="text" value="" name="q" id="search">
                                                                        <input class="sb-search-submit" type="submit" value="">
                                                                        <span class="sb-icon-search icon-search"></span>
                                                                </form>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_view" && $_smarty_tpl->tpl_vars['website_offline_mode']->value == 0) {?>
                                        <div id="ct-header-bottom" class="<?php if ($_SESSION['sbm'] == 0) {?>no-menu<?php }?>">
                                                <ul id="sub-nav-bar">
                                                        <li onclick="window.location=$(this).find(&quot;a&quot;).attr(&quot;href&quot;)" class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "video") {?>active<?php }?>" data-text="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.browse"),$_smarty_tpl);?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php ob_start();
if ($_smarty_tpl->tpl_vars['video_module']->value == 1) {
echo "videos";
} elseif ($_smarty_tpl->tpl_vars['live_module']->value == 1) {
echo "broadcasts";
} elseif ($_smarty_tpl->tpl_vars['image_module']->value == 1) {
echo "images";
} elseif ($_smarty_tpl->tpl_vars['audio_module']->value == 1) {
echo "audios";
} elseif ($_smarty_tpl->tpl_vars['document_module']->value == 1) {
echo "documents";
} elseif ($_smarty_tpl->tpl_vars['blog_module']->value == 1) {
echo "blogs";
}
$_prefixVariable1=ob_get_clean();
echo smarty_function_href_entry(array('key'=>$_prefixVariable1),$_smarty_tpl);?>
"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.watch"),$_smarty_tpl);?>
</a></li>
                                                        <li onclick="window.location=$(this).find(&quot;a&quot;).attr(&quot;href&quot;)" class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_upload" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_import") {?>active<?php }?>" data-text="<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.upload"),$_smarty_tpl);?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"upload"),$_smarty_tpl);?>
" rel="nofollow"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.upload"),$_smarty_tpl);?>
</a></li>
                                                </ul>
                                        </div>
                                        <?php }?>
                                </div>
                        </header><?php }
}

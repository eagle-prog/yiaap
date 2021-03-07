<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_user.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f56b74082_10805562',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aef81d8a02b41780d1d9d43affd856f6d797ab83' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_user.tpl',
      1 => 1587146359,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_leftnav/tpl_nav_files_inner.tpl' => 1,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_subscribers_inner.tpl' => 1,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_affiliate_inner.tpl' => 1,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_tokens_inner.tpl' => 1,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_account_inner.tpl' => 1,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_manage_channel_inner.tpl' => 1,
    'file:tpl_frontend/tpl_leftnav/tpl_nav_messages_inner.tpl' => 1,
  ),
),false)) {
function content_601c2f56b74082_10805562 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
		<?php if ($_SESSION['USER_ID'] > 0) {?>
                <div class="blue categories-container">
                	<h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-list"></i>Main Menu</h4>
                        <aside>
                                <nav>
                                        <ul class="accordion" id="<?php if ($_SESSION['USER_ID'] == '') {?>no-session-accordion<?php } else { ?>session-accordion<?php }?>">
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"index"),$_smarty_tpl);?>
"><i class="icon-home"></i><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.home"),$_smarty_tpl);?>
</a></li>
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs_off") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs_off") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
"><i class="icon-video"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.files.my"),$_smarty_tpl);?>
</a></li>
                                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files") {?><li class="this-inner"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_files_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></li><?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['user_subscriptions']->value == 1) {?>
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
"><i class="icon-coin"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.subpanel"),$_smarty_tpl);?>
</a></li>
                                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers") {?><li class="this-inner"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_subscribers_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></li><?php }?>
                                                        <?php }?>
                                                        <?php if ($_SESSION['USER_AFFILIATE'] == 1) {?>
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_affiliate") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_affiliate") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"affiliate"),$_smarty_tpl);?>
"><i class="icon-coin"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.affiliate"),$_smarty_tpl);?>
</a></li>
                                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_affiliate") {?><li class="this-inner"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_affiliate_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></li><?php }?>
                                                        <?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['user_tokens']->value == 1) {?>
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
"><i class="icon-coin"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.tokenpanel"),$_smarty_tpl);?>
</a></li>
                                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens") {?><li class="this-inner"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_tokens_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></li><?php }?>
                                                        <?php }?>
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_account") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_account") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
"><i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.account.my"),$_smarty_tpl);?>
</a></li>
                                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_account") {?><li class="this-inner"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_account_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></li><?php }?>
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_manage_channel") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_manage_channel") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"manage_channel"),$_smarty_tpl);?>
"><i class="icon-settings"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.channel.my"),$_smarty_tpl);?>
</a></li>
                                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_manage_channel") {?><li class="this-inner"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_manage_channel_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></li><?php }?>
                                                        <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?>menu-panel-entry main-menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_href_entry(array('key'=>"messages"),$_smarty_tpl);
} elseif ($_smarty_tpl->tpl_vars['internal_messaging']->value == 0 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_href_entry(array('key'=>"contacts"),$_smarty_tpl);
}?>"><i class="icon-envelope"></i><?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_lang_entry(array('key'=>"subnav.entry.contacts.messages"),$_smarty_tpl);
} elseif ($_smarty_tpl->tpl_vars['internal_messaging']->value == 0 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_lang_entry(array('key'=>"subnav.entry.contacts"),$_smarty_tpl);
}?> <?php echo insert_newMessages(array(),$_smarty_tpl);?></a></li>
                                                        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_messages") {?><li class="this-inner"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_leftnav/tpl_nav_messages_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></li><?php }?>
                                        </ul>
                                        <div class="clearfix"></div>
                                </nav>
                        </aside>
                </div>
                <?php }
}
}

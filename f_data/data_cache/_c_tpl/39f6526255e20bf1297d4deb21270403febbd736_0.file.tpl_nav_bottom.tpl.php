<?php
/* Smarty version 3.1.33, created on 2021-02-17 15:28:46
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602d362e08aa30_33836476',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '39f6526255e20bf1297d4deb21270403febbd736' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_bottom.tpl',
      1 => 1613575719,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_602d362e08aa30_33836476 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                <div class="blue categories-container">
                	<h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-eye"></i><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.browse"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
</h4>
                        <aside>
                                <nav>
                                        <ul class="accordion" id="<?php if ($_SESSION['USER_ID'] == '') {?>no-session-accordion2<?php } else { ?>session-accordion<?php }?>">
                                        <?php if ($_smarty_tpl->tpl_vars['video_module']->value == "1") {?>
                                                <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index") {?>menu-panel-entry menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"index"),$_smarty_tpl);?>
"><i class="icon-home"></i><?php echo smarty_function_lang_entry(array('key'=>"browse.t.files"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['live_module']->value == "1") {?>
                                                <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "live") {?>menu-panel-entry menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "live") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"broadcasts"),$_smarty_tpl);?>
"><i class="icon-live"></i><?php echo smarty_function_lang_entry(array('key'=>"browse.l.files"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['image_module']->value == "1") {?>
                                        	<li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "image") {?>menu-panel-entry menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "image") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"images"),$_smarty_tpl);?>
"><i class="icon-image"></i><?php echo smarty_function_lang_entry(array('key'=>"browse.i.files"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['audio_module']->value == "1") {?>
                                        	<li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "audio") {?>menu-panel-entry menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "audio") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"audios"),$_smarty_tpl);?>
"><i class="icon-audio"></i><?php echo smarty_function_lang_entry(array('key'=>"browse.a.files"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['document_module']->value == "1") {?>
                                        	<li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "document") {?>menu-panel-entry menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "document") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"documents"),$_smarty_tpl);?>
"><i class="icon-file"></i><?php echo smarty_function_lang_entry(array('key'=>"browse.d.files"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['blog_module']->value == "1") {?>
                                                <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "blog") {?>menu-panel-entry menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" && $_smarty_tpl->tpl_vars['type_display']->value == "blog") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"blogs"),$_smarty_tpl);?>
"><i class="icon-blog"></i><?php echo smarty_function_lang_entry(array('key'=>"browse.b.files"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['public_channels']->value == "1") {?>
                                                <li class="<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels") {?>menu-panel-entry menu-panel-entry-active<?php }?>"><a class="dcjq-parent<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels") {?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"channels"),$_smarty_tpl);?>
"><i class="icon-users"></i><?php echo smarty_function_lang_entry(array('key'=>"browse.ch.menu"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        </ul>
                                        <div class="clearfix"></div>
                                </nav>
                        </aside>
                </div>
<?php }
}

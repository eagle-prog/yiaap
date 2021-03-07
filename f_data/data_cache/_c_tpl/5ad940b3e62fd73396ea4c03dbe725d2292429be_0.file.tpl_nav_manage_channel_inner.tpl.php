<?php
/* Smarty version 3.1.33, created on 2021-02-07 13:55:35
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_manage_channel_inner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602037a7474531_40568630',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ad940b3e62fd73396ea4c03dbe725d2292429be' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_manage_channel_inner.tpl',
      1 => 1569557569,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_602037a7474531_40568630 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                <div class="blue categories-container">
                    <h4 class="nav-title categories-menu-title left-menu-h4 no-display"><i class="icon-settings"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.channel.my"),$_smarty_tpl);?>
</h4>
                    <aside>
                        <nav>
                            <ul class="accordion inner-accordion" id="categories-accordion">
                                <li id="channel-menu-entry1" class="menu-panel-entry<?php if ($_GET['r'] == '') {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"manage_channel"),$_smarty_tpl);?>
"><a href="javascript:;"<?php if ($_GET['r'] == '') {?> class="dcjq-parent active"<?php }?>><i class="icon-cog"></i><?php echo smarty_function_lang_entry(array('key'=>"manage.channel.menu.general"),$_smarty_tpl);?>
</a></li>
                                <li id="channel-menu-entry2" class="menu-panel-entry" rel-m="<?php echo smarty_function_href_entry(array('key'=>"manage_channel"),$_smarty_tpl);?>
"><a href="javascript:;"><i class="icon-cogs2"></i><?php echo smarty_function_lang_entry(array('key'=>"manage.channel.menu.modules"),$_smarty_tpl);?>
</a></li>
                                <?php if ($_smarty_tpl->tpl_vars['channel_backgrounds']->value == 1) {?>
                                <li id="channel-menu-entry3" class="menu-panel-entry<?php if ($_GET['r'] == "confirm") {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"manage_channel"),$_smarty_tpl);?>
"><a href="javascript:;"<?php if ($_GET['r'] == "confirm") {?> class="dcjq-parent active"<?php }?>><i class="icon-quill"></i><?php echo smarty_function_lang_entry(array('key'=>"manage.channel.menu.art"),$_smarty_tpl);?>
</a></li>
                                <?php }?>
                            </ul>
                        </nav>
                    </aside>
                </div><?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_cdn.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f66974e17_12223435',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2f213a6cbaf3ddde5a99b26c36e35ddee92aa34d' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_cdn.tpl',
      1 => 1485640800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f66974e17_12223435 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>

                                    <li><a href="javascript:;"><i class="iconBe-share2"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.cd"),$_smarty_tpl);?>
</a>
                                        <ul>
                                        	<li><a href="javascript:;" id="backend-menu-entry3-sub13" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.cd.storage"),$_smarty_tpl);?>
</a></li>
                                        <?php if ($_smarty_tpl->tpl_vars['video_module']->value == 1 && $_smarty_tpl->tpl_vars['video_uploads']->value == 1) {?>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub14" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.cd.v"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['image_module']->value == 1 && $_smarty_tpl->tpl_vars['image_uploads']->value == 1) {?>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub15" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.cd.i"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['audio_module']->value == 1 && $_smarty_tpl->tpl_vars['audio_uploads']->value == 1) {?>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub16" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.cd.a"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['document_module']->value == 1 && $_smarty_tpl->tpl_vars['document_uploads']->value == 1) {?>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub17" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.cd.d"),$_smarty_tpl);?>
</a></li>
                                        <?php }?>
                                        </ul>
                                    </li>

<?php }
}

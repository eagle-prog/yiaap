<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_subscriber.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f668b7bd5_79500131',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2f72ccd14ee710e16c6bdc72f576d07ea423883b' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_subscriber.tpl',
      1 => 1537390800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f668b7bd5_79500131 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                                    <li>
                                        <a href="javascript:;"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_subscriber") {?> class="active"<?php }?>><i class="iconBe-pie"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ps.dashboard"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_subscribers"),$_smarty_tpl);?>
?rg=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_subscriber" && $_GET['rg'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.graph"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_subscribers"),$_smarty_tpl);?>
?rp=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_subscriber" && $_GET['rp'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.rep"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>

<?php }
}

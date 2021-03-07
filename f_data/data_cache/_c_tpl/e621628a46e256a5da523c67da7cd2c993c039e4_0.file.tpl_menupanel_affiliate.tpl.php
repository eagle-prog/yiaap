<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_affiliate.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f668afe05_00961778',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e621628a46e256a5da523c67da7cd2c993c039e4' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_affiliate.tpl',
      1 => 1520287200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f668afe05_00961778 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                                    <li>
                                        <a href="javascript:;"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_affiliate") {?> class="active"<?php }?>><i class="iconBe-pie"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.dashboard"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?rp=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_affiliate" && $_GET['rp'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.rep"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?a=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_affiliate" && $_GET['a'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.views"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?g=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_affiliate" && $_GET['g'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.maps"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?o=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_affiliate" && $_GET['o'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.comp"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>

<?php }
}

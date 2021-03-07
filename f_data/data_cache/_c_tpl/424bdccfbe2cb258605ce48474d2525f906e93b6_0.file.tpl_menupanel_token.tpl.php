<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_token.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f668c3219_30959899',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '424bdccfbe2cb258605ce48474d2525f906e93b6' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel_token.tpl',
      1 => 1557246000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f668c3219_30959899 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                                    <li>
                                        <a href="javascript:;"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_token") {?> class="active"<?php }?>><i class="iconBe-pie"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ps.token"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_tokens"),$_smarty_tpl);?>
?rg=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_token" && $_GET['rg'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.report"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_tokens"),$_smarty_tpl);?>
?rp=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_token" && $_GET['rp'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.payout"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry15-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.orders"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry15-sub2" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.token.donations"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry14-sub8" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.streaming.token.types"),$_smarty_tpl);?>
</a></li>
                                            <li class="no-display"><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_token"),$_smarty_tpl);?>
?rp=1"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_token" && $_GET['rp'] == "1") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.rep"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>

<?php }
}

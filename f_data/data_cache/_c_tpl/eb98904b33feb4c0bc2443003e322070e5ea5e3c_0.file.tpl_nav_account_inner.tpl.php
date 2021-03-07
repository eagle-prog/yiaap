<?php
/* Smarty version 3.1.33, created on 2021-02-06 11:27:33
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_account_inner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ec375ee8605_05559373',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb98904b33feb4c0bc2443003e322070e5ea5e3c' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_account_inner.tpl',
      1 => 1569557555,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601ec375ee8605_05559373 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                <div class="blue categories-container">
                    <h4 class="nav-title categories-menu-title left-menu-h4 no-display"><i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.my.account"),$_smarty_tpl);?>
</h4>
                    <aside>
                        <nav>
                            <ul class="accordion inner-accordion" id="categories-accordion">
                                <li id="account-menu-entry1" class="menu-panel-entry menu-panel-entry-active" rel-m="<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
"><a class="dcjq-parent active" href="javascript:;"><i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.overview"),$_smarty_tpl);?>
</a></li>
                                <li id="account-menu-entry2" class="menu-panel-entry" rel-m="<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
"><a href="javascript:;"><i class="icon-profile"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.profile.setup"),$_smarty_tpl);?>
</a></li>
                                <li id="account-menu-entry4" class="menu-panel-entry" rel-m="<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
"><a href="javascript:;"><i class="icon-envelope"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.mail.opts"),$_smarty_tpl);?>
</a></li>
                            <?php if ($_smarty_tpl->tpl_vars['activity_logging']->value == 1) {?>
                                <li id="account-menu-entry5" class="menu-panel-entry" rel-m="<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
"><a href="javascript:;"><i class="icon-share"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.share"),$_smarty_tpl);?>
</a></li>
                            <?php }?>
                                <li id="account-menu-entry6" class="menu-panel-entry" rel-m="<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
"><a href="javascript:;"><i class="icon-key"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.manage"),$_smarty_tpl);?>
</a></li>
                            </ul>
                        </nav>
                    </aside>
                </div><?php }
}

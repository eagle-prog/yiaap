<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:43:41
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_tokens_inner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c789d85db96_17615264',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2589f813f5db49a0d39a30faa1abc7dd4691f351' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_tokens_inner.tpl',
      1 => 1583867393,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c789d85db96_17615264 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
if ($_smarty_tpl->tpl_vars['user_tokens']->value == 1) {?>
                <div class="blue categories-container">
                    <h4 class="nav-title categories-menu-title left-menu-h4 no-display"><i class="icon-coin"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.tokenpanel"),$_smarty_tpl);?>
</h4>
                    <aside>
                        <nav>
                            <ul class="accordion inner-accordion" id="categories-accordion">
                            	<li id="account-menu-entry13" class="menu-panel-entry<?php if ($_GET['rg'] == '' && $_GET['rp'] == '') {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
"><a class="<?php if ($_GET['rg'] == '' && $_GET['rp'] == '') {?>dcjq-parent active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
"><i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.overview"),$_smarty_tpl);?>
</a></li>
                            	<?php if ($_SESSION['USER_PARTNER'] == 1) {?>
                            	<li id="account-menu-entry9" class="menu-panel-entry<?php if ($_GET['rg'] != '') {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
"><a class="<?php if ($_GET['rg'] != '') {?>dcjq-parent active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
?rg=<?php echo md5($_SESSION['USER_KEY']);?>
"><i class="icon-bars"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.tokens.stats"),$_smarty_tpl);?>
</a></li>
                            	<li id="account-menu-entry12" class="menu-panel-entry<?php if ($_GET['rp'] != '') {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
"><a class="<?php if ($_GET['rp'] != '') {?>dcjq-parent active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
?rp=<?php echo md5($_SESSION['USER_KEY']);?>
"><i class="icon-paypal"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.tokens.pay"),$_smarty_tpl);?>
</a></li>
                            	<?php }?>
                            </ul>
                        </nav>
                    </aside>
                </div>
<?php }
}
}

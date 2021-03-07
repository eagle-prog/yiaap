<?php
/* Smarty version 3.1.33, created on 2021-02-08 14:01:05
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_subscribers_inner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60218a71c6eec1_34157160',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c1a4e38a00782318cb164f1783b75e8c0c8dec21' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_subscribers_inner.tpl',
      1 => 1569557582,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60218a71c6eec1_34157160 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
if ($_smarty_tpl->tpl_vars['user_subscriptions']->value == 1) {?>
                <div class="blue categories-container">
                    <h4 class="nav-title categories-menu-title left-menu-h4 no-display"><i class="icon-coin"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.subpanel"),$_smarty_tpl);?>
</h4>
                    <aside>
                        <nav>
                            <ul class="accordion inner-accordion" id="categories-accordion">
                            	<li id="account-menu-entry13" class="menu-panel-entry<?php if ($_GET['rg'] == '' && $_GET['rp'] == '') {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
"><a class="<?php if ($_GET['rg'] == '' && $_GET['rp'] == '') {?>dcjq-parent active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
"><i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.overview"),$_smarty_tpl);?>
</a></li>
                            	<?php if ($_SESSION['USER_PARTNER'] == 1) {?>
                            	<li id="account-menu-entry12" class="menu-panel-entry<?php if ($_GET['rp'] != '') {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
"><a class="<?php if ($_GET['rp'] != '') {?>dcjq-parent active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
?rp=<?php echo md5($_SESSION['USER_KEY']);?>
"><i class="icon-paypal"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.payout.rep"),$_smarty_tpl);?>
</a></li>
                            	<li id="account-menu-entry9" class="menu-panel-entry<?php if ($_GET['rg'] != '') {?> menu-panel-entry-active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
"><a class="<?php if ($_GET['rg'] != '') {?>dcjq-parent active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
?rg=<?php echo md5($_SESSION['USER_KEY']);?>
"><i class="icon-bars"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.act.graph"),$_smarty_tpl);?>
</a></li>
                            	<?php }?>
                            </ul>
                        </nav>
                    </aside>
                </div>
<?php }
}
}

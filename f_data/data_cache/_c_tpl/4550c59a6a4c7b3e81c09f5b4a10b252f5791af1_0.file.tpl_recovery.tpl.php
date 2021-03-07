<?php
/* Smarty version 3.1.33, created on 2021-02-09 06:52:46
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_recovery.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6022778e1de420_65875851',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4550c59a6a4c7b3e81c09f5b4a10b252f5791af1' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_recovery.tpl',
      1 => 1479333600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_auth/tpl_recovery_form.tpl' => 2,
    'file:tpl_frontend/tpl_auth/tpl_promobox.tpl' => 1,
    'file:tpl_backend/tpl_signinjs.tpl' => 1,
  ),
),false)) {
function content_6022778e1de420_65875851 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
if ($_GET['s'] == '' && $_GET['id'] == '') {?>

<?php if (($_smarty_tpl->tpl_vars['password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend")) {?> <?php $_smarty_tpl->_assignInScope('extra_l', 1);
} elseif (($_smarty_tpl->tpl_vars['backend_password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {
$_smarty_tpl->_assignInScope('extra_l', 3);?> <?php }
if (($_smarty_tpl->tpl_vars['username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend")) {?> <?php $_smarty_tpl->_assignInScope('extra_r', 2);
} elseif (($_smarty_tpl->tpl_vars['backend_username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {
$_smarty_tpl->_assignInScope('extra_r', 4);?> <?php }?>

<div class="login-margins">
<div class="vs-column half">
<div class="login-page">
<div class="tabs tabs-style-topline">
    <nav>
        <ul>
            <li onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signin"),$_smarty_tpl);?>
'"><a href="#section-topline-1" class="icon icon-enter" rel="nofollow"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signin"),$_smarty_tpl);?>
</span></a></li>
            <li onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signup"),$_smarty_tpl);?>
'"><a href="#section-topline-2" class="icon icon-signup" rel="nofollow"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signup"),$_smarty_tpl);?>
</span></a></li>
            <li class="tab-current"><a href="#section-topline-3" class="icon icon-support" rel="nofollow"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.recovery"),$_smarty_tpl);?>
</span></a></li>
        </ul>
    </nav>
    <div class="content-wrap">
        <section id="section-topline-1">
        </section>
        <section id="section-topline-2">
        </section>
        <section id="section-topline-3" class="content-current">
            <div>
                <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_auth/tpl_recovery_form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            </div>
        </section>
    </div><!-- /content -->
</div><!-- /tabs -->
</div>
</div>

<div class="vs-column half fit">
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_auth/tpl_promobox.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
</div>


<?php echo '<script'; ?>
 type="text/javascript">
<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_signinjs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
<?php } else { ?>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_auth/tpl_recovery_form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
}

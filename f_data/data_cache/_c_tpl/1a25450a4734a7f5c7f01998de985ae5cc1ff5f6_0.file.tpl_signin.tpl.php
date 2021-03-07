<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_signin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62ae56f6_15650168',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a25450a4734a7f5c7f01998de985ae5cc1ff5f6' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_signin.tpl',
      1 => 1482876000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_auth/tpl_signin_loginbox.tpl' => 1,
    'file:tpl_backend/tpl_auth/tpl_recovery.tpl' => 1,
    'file:tpl_backend/tpl_signinjs.tpl' => 1,
  ),
),false)) {
function content_601c2f62ae56f6_15650168 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
if (($_smarty_tpl->tpl_vars['password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend")) {?> <?php $_smarty_tpl->_assignInScope('extra_l', 1);
} elseif (($_smarty_tpl->tpl_vars['backend_password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {
$_smarty_tpl->_assignInScope('extra_l', 3);?> <?php }
if (($_smarty_tpl->tpl_vars['username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend")) {?> <?php $_smarty_tpl->_assignInScope('extra_r', 2);
} elseif (($_smarty_tpl->tpl_vars['backend_username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {
$_smarty_tpl->_assignInScope('extra_r', 4);?> <?php }?>

<div class="login-page">
<center><div><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"home"),$_smarty_tpl);?>
" id="flogo"></a></div></center>
<br>
<div class="tabs tabs-style-topline">
    <nav>
        <ul>
            <li><a href="#section-topline-1" class="icon icon-enter"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signin"),$_smarty_tpl);?>
</span></a></li>
            <li><a href="#section-topline-3" class="icon icon-support"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.recovery"),$_smarty_tpl);?>
</span></a></li>
        </ul>
    </nav>
    <div class="content-wrap">
        <section id="section-topline-1">
            <div class="">
                <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_auth/tpl_signin_loginbox.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            </div>
        </section>
        <section id="section-topline-3">
            <div class="">
                <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_auth/tpl_recovery.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            </div>
        </section>
    </div><!-- /content -->
</div><!-- /tabs -->
</div>

<?php echo '<script'; ?>
 type="text/javascript">
<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_signinjs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
><?php }
}

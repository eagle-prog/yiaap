<?php
/* Smarty version 3.1.33, created on 2021-02-09 12:51:08
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_signin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6022cb8c2be445_18116205',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5836d151fd850d541a87af922b0bd724c2e4a224' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_signin.tpl',
      1 => 1612893063,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_auth/tpl_signin_loginbox.tpl' => 1,
    'file:tpl_frontend/tpl_auth/tpl_promobox.tpl' => 1,
  ),
),false)) {
function content_6022cb8c2be445_18116205 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
if ($_smarty_tpl->tpl_vars['signup_captcha']->value == "1" || $_smarty_tpl->tpl_vars['signin_captcha']->value == "1") {
echo '<script'; ?>
 type="text/javascript" src="https://www.google.com/recaptcha/api.js"><?php echo '</script'; ?>
><?php }?>
<div class="login-margins">
<div class="vs-column half">
<div class="login-page">
<div class="tabs tabs-style-topline">
    <nav>
        <ul>
            <li class="tab-current signin"><a href="#section-topline-1" class="icon icon-enter" rel="nofollow"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signin"),$_smarty_tpl);?>
</span></a></li>
            <li onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signup"),$_smarty_tpl);?>
'"><a href="#section-topline-2" class="icon icon-signup" rel="nofollow"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signup"),$_smarty_tpl);?>
</span></a></li>
            <li onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"service"),$_smarty_tpl);?>
/<?php echo smarty_function_href_entry(array('key'=>"x_recovery"),$_smarty_tpl);?>
'"><a href="#section-topline-3" class="icon icon-support" rel="nofollow"><span><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.recovery"),$_smarty_tpl);?>
</span></a></li>
        </ul>
    </nav>
    <div class="clearfix"></div>
    <div class="content-wrap">
    	<?php echo insert_advHTML(array('id' => "39"),$_smarty_tpl);?>
        <section id="section-topline-1" class="content-current">
            <div class="">
                <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_auth/tpl_signin_loginbox.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            </div>
        </section>
        <section id="section-topline-2">
        </section>
        <section id="section-topline-3">
        </section>
        <?php echo insert_advHTML(array('id' => "40"),$_smarty_tpl);?>
    </div><!-- /content -->
</div><!-- /tabs -->
</div>
</div>

<div class="vs-column half fit">
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_auth/tpl_promobox.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
</div><?php }
}

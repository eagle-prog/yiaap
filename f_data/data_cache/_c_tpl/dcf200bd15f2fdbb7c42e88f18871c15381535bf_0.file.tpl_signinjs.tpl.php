<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:14
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_signinjs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f62b26508_98001064',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dcf200bd15f2fdbb7c42e88f18871c15381535bf' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_signinjs.tpl',
      1 => 1543960800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f62b26508_98001064 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
$(document).ready(function() {
    <?php if ($_smarty_tpl->tpl_vars['signup_captcha']->value == "1") {?>
        $("#reload-captcha").bind("click", function () {
            $("#c-image").attr("src", main_url + "<?php echo smarty_function_href_entry(array('key'=>"captcha"),$_smarty_tpl);?>
?ts=" + new Date().getTime());
        });
    <?php }?>
    
    <?php if ($_smarty_tpl->tpl_vars['signup_username_availability']->value == "1") {?>
        $("#signup-username").keyup(function(){
            if (document.getElementById("signup-username").value!='') {
                $("#signup-username").mask(" ");
                $.post(main_url + "<?php echo smarty_function_href_entry(array('key'=>"signup"),$_smarty_tpl);?>
?do=ucheck", $("#register-form").serialize(), function(data) {
                    $("#check-response").html(data);
                    $("#signup-username").unmask();
                });
            } else {
                $("#check-response").html("");
            }
        });
    <?php }?>

    <?php if (($_smarty_tpl->tpl_vars['password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_password_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
        $("#reload-left-captcha").bind("click", function () {
            $("#l-image").attr("src", main_url + "<?php echo smarty_function_href_entry(array('key'=>"captcha"),$_smarty_tpl);?>
?extra=<?php echo $_smarty_tpl->tpl_vars['extra_l']->value;?>
&amp;ts=" + new Date().getTime());
        });
    <?php }?>
    
    <?php if (($_smarty_tpl->tpl_vars['username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "frontend") || ($_smarty_tpl->tpl_vars['backend_username_recovery_captcha']->value == "1" && $_smarty_tpl->tpl_vars['global_section']->value == "backend")) {?>
        $("#reload-right-captcha").bind("click", function () {
            $("#r-image").attr("src", main_url + "<?php echo smarty_function_href_entry(array('key'=>"captcha"),$_smarty_tpl);?>
?extra=<?php echo $_smarty_tpl->tpl_vars['extra_r']->value;?>
&amp;ts=" + new Date().getTime());
        });
    <?php }?>
    
    $("#recover-password-button").bind("click", function(){
        if (document.getElementById("recover-password-input").value!='') {
            $("#recover-password-mask").mask(" ");
            $.post(full_url + "<?php if ($_smarty_tpl->tpl_vars['global_section']->value == "backend") {
echo smarty_function_href_entry(array('key'=>"be_service"),$_smarty_tpl);
} else {
echo smarty_function_href_entry(array('key'=>"service"),$_smarty_tpl);
}?>/<?php echo smarty_function_href_entry(array('key'=>"x_recovery"),$_smarty_tpl);?>
?t=1<?php if ($_smarty_tpl->tpl_vars['global_section']->value == "backend") {?>&a=1<?php }?>", $("#password-recovery-form").serialize(), function(data){
                $("#recover-password-response").html(data);
                $("#recover-password-mask").unmask();
                if (typeof($("#error-message").html()) == "undefined") {
                	grecaptcha.reset(recaptcha1);
                }
            });
        }
    });
    
    $("#recover-username-button").bind("click", function(){
        if (document.getElementById("recover-username-input").value!='') {
            $("#recover-username-mask").mask(" ");
            $.post(full_url + "<?php if ($_smarty_tpl->tpl_vars['global_section']->value == "backend") {
echo smarty_function_href_entry(array('key'=>"be_service"),$_smarty_tpl);
} else {
echo smarty_function_href_entry(array('key'=>"service"),$_smarty_tpl);
}?>/<?php echo smarty_function_href_entry(array('key'=>"x_recovery"),$_smarty_tpl);?>
?t=2<?php if ($_smarty_tpl->tpl_vars['global_section']->value == "backend") {?>&a=1<?php }?>", $("#username-recovery-form").serialize(), function(data) {
                $("#recover-username-response").html(data);
                $("#recover-username-mask").unmask();
                if (typeof($("#error-message").html()) == "undefined") {
                	grecaptcha.reset(recaptcha2);
                }
            });
        }
    });
    
});<?php }
}

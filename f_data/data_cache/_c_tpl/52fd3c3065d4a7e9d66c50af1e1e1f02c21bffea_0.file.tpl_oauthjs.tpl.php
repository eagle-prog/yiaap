<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:17:43
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_oauthjs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c7287c3b352_62541444',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52fd3c3065d4a7e9d66c50af1e1e1f02c21bffea' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_auth/tpl_oauthjs.tpl',
      1 => 1477170000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c7287c3b352_62541444 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
	<?php if ($_smarty_tpl->tpl_vars['fb_auth']->value == "1" || $_smarty_tpl->tpl_vars['gp_auth']->value == "1") {?>
		$("input[name=auth_username]").keydown(function(e) { if (e.keyCode == 13) { e.preventDefault(); e.stopPropagation(); $("#auth-register-submit").click(); } });
		$("input[name=auth_username]").keyup(function(e) {
                    var _val = $(this).val();
                    $.ajax({
                        url: '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/f_modules/m_frontend/m_auth/<?php echo smarty_function_href_entry(array('key'=>"signup"),$_smarty_tpl);?>
?do=auth_register',
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        data: { auth_confirm: 0, auth_username:  _val, auth_userid: "<?php echo smarty_modifier_sanitize($_GET['u']);?>
" }
                        }).complete(function(response) {
                            data = response.responseText;

                            var error = '<span class="err-red"><i class="icon-notification"></i> ' + data.replace('error:', '') + '</span>';
                            var notice = '<span class="conf-green"><i class="icon-check"></i> Available</span>';

                            if (data.substr(0, 6) == 'error:') {
                                $(".auth-username-check-response").html(error);
                            } else {
                                $(".auth-username-check-response").html(notice);
                            }
                    });
            });
            $("#auth-register-submit").click(function(e) {
                e.preventDefault();
                var t = $(this);
                $("input[name=auth_confirm]").val("1");
                $.post("<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/f_modules/m_frontend/m_auth/<?php echo smarty_function_href_entry(array('key'=>"signup"),$_smarty_tpl);?>
?do=auth_register", $("#auth-register-form").serialize(), function (data) {
                    var error = '<span class="err-red"><i class="icon-notification"></i> ' + data.replace('error:', '') + '</span>';
                    var notice = '<span class="conf-green"><i class="icon-check"></i> Available</span>';

                    if (data.substr(0, 6) == 'error:') {
                        $(".auth-username-check-response").html(error);
                    } else {
                        $("#auth-register-form input").prop("disabled", true);
                        $("#auth-register-form .auth-username-check-btn").prop("disabled", true);

                        $(".auth-username-check-response").html(notice);
                        $.fancybox.close();
                        location.reload();
                    }
                });
            });
	<?php }
}
}

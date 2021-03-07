<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:43:41
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_affiliatejs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c789d8715b8_44451450',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a3eb51ded708114848f3b55842a38112121e8d4' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_affiliatejs_min.tpl',
      1 => 1578358404,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c789d8715b8_44451450 (Smarty_Internal_Template $_smarty_tpl) {
if (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_affiliate" && $_SESSION['USER_AFFILIATE'] == 1) || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers" && $_SESSION['USER_PARTNER'] == 1) || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens" && $_SESSION['USER_PARTNER'] == 1)) {?>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/datepicker/tiny-date-picker.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/datepicker/date-range-picker.min.js"><?php echo '</script'; ?>
>
        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_affiliate") {?>
        <?php echo '<script'; ?>
 type="text/javascript" src="https://www.google.com/jsapi"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_smarty_tpl->tpl_vars['affiliate_maps_api_key']->value;?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">(function () {[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {new CBPFWTabs(el);});})();<?php echo '</script'; ?>
>
        <?php }?>
        <?php if (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens") && $_GET['rp'] != '') {?>
        	<?php echo '<script'; ?>
 type="text/javascript">(function () {[].slice.call(document.querySelectorAll(".tabs")).forEach(function (el) {new CBPFWTabs(el);});})();<?php echo '</script'; ?>
>
        <?php } elseif (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens") && $_GET['rg'] != '') {?>
        	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/jsapi.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['modules_url_be']->value;?>
/m_tools/m_gasp/dash/Chart.min.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['modules_url_be']->value;?>
/m_tools/m_gasp/dash/moment.min.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 type="text/javascript">var ecount=new Array;var scount=new Array;var tcount=new Array;var twcount=new Array;twcount["total"]=0;twcount["shared"]=<?php echo $_smarty_tpl->tpl_vars['twshared']->value;?>
;twcount["earned"]=0;var lwcount=new Array;lwcount["total"]=0;lwcount["shared"]=<?php echo $_smarty_tpl->tpl_vars['lwshared']->value;?>
;lwcount["earned"]=0;var tw1=<?php echo $_smarty_tpl->tpl_vars['tw2']->value;?>
;var sw1=<?php echo $_smarty_tpl->tpl_vars['sw2']->value;?>
;var ew1=<?php echo $_smarty_tpl->tpl_vars['ew2']->value;?>
;var tw2=<?php echo $_smarty_tpl->tpl_vars['tw1']->value;?>
;var sw2=<?php echo $_smarty_tpl->tpl_vars['sw1']->value;?>
;var ew2=<?php echo $_smarty_tpl->tpl_vars['ew1']->value;?>
;var lws=<?php echo $_smarty_tpl->tpl_vars['lws']->value;?>
;var tws=<?php echo $_smarty_tpl->tpl_vars['tws']->value;?>
;$(document).ready(function(){$('.icheck-box input').each(function(){var self=$(this);self.iCheck({checkboxClass:'icheckbox_square-blue',radioClass:'iradio_square-blue',increaseArea:'20%'});});$(".icheck-box").toggleClass("no-display");$(".filters-loading").addClass("no-display");});<?php echo '</script'; ?>
><?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subscribers") {?>subdashboard.min.js<?php } else { ?>tokendashboard.min.js<?php }?>"><?php echo '</script'; ?>
>
        <?php }
}
}
}

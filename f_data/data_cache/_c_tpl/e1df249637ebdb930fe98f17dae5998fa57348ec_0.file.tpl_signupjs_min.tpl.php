<?php
/* Smarty version 3.1.33, created on 2021-02-04 12:48:56
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_signupjs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c3388f408b2_46996061',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e1df249637ebdb930fe98f17dae5998fa57348ec' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_signupjs_min.tpl',
      1 => 1553481480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_auth/tpl_oauthjs.tpl' => 1,
  ),
),false)) {
function content_601c3388f408b2_46996061 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_signin" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_signup" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_recovery" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_payment") {?>
	<?php if ($_smarty_tpl->tpl_vars['paid_memberships']->value == "1" && ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_payment" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_signup")) {
echo '<script'; ?>
 type="text/javascript">$(function() {SelectList.init("frontend_membership_type_sel");SelectList.init("pk_period_sel");});<?php echo '</script'; ?>
><?php }?>
	<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_signup") {
echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/jquery.password.js"><?php echo '</script'; ?>
><?php if (($_smarty_tpl->tpl_vars['fb_auth']->value == "1" && $_SESSION['fb_user']['id'] > 0) || ($_smarty_tpl->tpl_vars['gp_auth']->value == "1" && $_SESSION['gp_user']['id'] > 0)) {
echo '<script'; ?>
 type="text/javascript">$(document).ready(function() {$("a#inline").fancybox({ minWidth: "80%",  margin: 20 });$('#inline').trigger('click');});<?php echo '</script'; ?>
><?php }
echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_auth/tpl_oauthjs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
><?php }?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/login.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">(function(){[].slice.call(document.querySelectorAll(".tabs")).forEach(function(el){new CBPFWTabs(el)})})();function oldSafariCSSfix(){if(isOldSafari()){var tabnr=$(".login-page .tabs nav ul li").length;var width=jQuery(".login-page").width()-32;jQuery(".login-page .tabs nav ul li").width(width/tabnr-1).css("float","left");jQuery(".login-page .tabs nav").css("width",width+1)}}$(document).ready(function(){$(document).on("click",".tabs ul:not(.fileThumbs) li",function(){})});jQuery(window).load(function(){oldSafariCSSfix()});jQuery(window).resize(function(){oldSafariCSSfix()});function isOldSafari(){return!!navigator.userAgent.match(" Safari/")&&!navigator.userAgent.match(" Chrome")&&(!!navigator.userAgent.match(" Version/6.0")||!!navigator.userAgent.match(" Version/5."))}<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">var full_url = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';var main_url = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_recovery" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_signup") {?>$(".login-page .tabs ul li:first").removeClass("tab-current");<?php }
echo '</script'; ?>
>
<?php }?>

<?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:41:59
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_viewcss_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c31e7793605_24507676',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c1356d9fe5e05f638f7b5d8b7bf9d1fbc5d9fc44' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_viewcss_min.tpl',
      1 => 1543960800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c31e7793605_24507676 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" && ($_smarty_tpl->tpl_vars['video_player']->value == "vjs" || $_smarty_tpl->tpl_vars['audio_player']->value == "vjs")) {?>
	<link href="https://vjs.zencdn.net/5.19/video-js.min.css" rel="stylesheet">
	<link href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/videojs/videojs-styles.min.css" rel="stylesheet">
	<?php if ($_smarty_tpl->tpl_vars['vjs_advertising']->value == 1) {?>
	<?php if ($_smarty_tpl->tpl_vars['ad_client']->value == "ima" && $_smarty_tpl->tpl_vars['embed_src']->value == "local") {?>
	<link href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/videojs/videojs.ads.min.css" rel="stylesheet">
	<?php } elseif ($_smarty_tpl->tpl_vars['ad_client']->value == "vast" && $_smarty_tpl->tpl_vars['embed_src']->value == "local") {?>
	<link href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/videojs/videojs.vast.vpaid.button.min.css" rel="stylesheet">
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['ad_tag_comp']->value == 1 && $_smarty_tpl->tpl_vars['embed_src']->value == "local") {?>
	<?php echo '<script'; ?>
 type='text/javascript'>var googletag = googletag || {};googletag.cmd = googletag.cmd || [];(function() {var gads = document.createElement('script');gads.async = true;gads.type = 'text/javascript';gads.src = '//www.googletagservices.com/tag/js/gpt.js';var node = document.getElementsByTagName('script')[0];node.parentNode.insertBefore(gads, node);})();<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type='text/javascript'>googletag.cmd.push(function() {googletag.defineSlot('<?php echo $_smarty_tpl->tpl_vars['ad_tag_comp_id']->value;?>
', [<?php echo $_smarty_tpl->tpl_vars['ad_tag_comp_w']->value;?>
, <?php echo $_smarty_tpl->tpl_vars['ad_tag_comp_h']->value;?>
], 'ima-companionDiv').addService(googletag.companionAds()).addService(googletag.pubads());googletag.companionAds().setRefreshUnfilledSlots(true);googletag.pubads().enableVideoAds();googletag.enableServices();});<?php echo '</script'; ?>
>
	<?php }?>
	<?php }
}
}
}

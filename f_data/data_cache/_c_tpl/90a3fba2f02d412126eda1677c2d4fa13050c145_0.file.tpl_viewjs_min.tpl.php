<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:42:00
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_viewjs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c31e838efa0_32618852',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '90a3fba2f02d412126eda1677c2d4fa13050c145' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_viewjs_min.tpl',
      1 => 1599140070,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c31e838efa0_32618852 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
if ((($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view") && ($_GET['v'] != '' || $_GET['a'] != '' || $_GET['l'] != ''))) {?>
	<?php if ((($_GET['v'] != '' || $_GET['l'] != '') && $_smarty_tpl->tpl_vars['video_player']->value == "vjs" && ($_smarty_tpl->tpl_vars['embed_src']->value == "local" || $_smarty_tpl->tpl_vars['embed_src']->value == "youtube")) || ($_GET['a'] != '' && $_smarty_tpl->tpl_vars['audio_player']->value == "vjs")) {?>
	<?php echo '<script'; ?>
 src="https://vjs.zencdn.net/5.19/video.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>var logo="<?php echo $_smarty_tpl->tpl_vars['logo_file']->value;?>
";var logohref="<?php echo $_smarty_tpl->tpl_vars['logo_href']->value;?>
";<?php echo '</script'; ?>
>
	<?php if ($_smarty_tpl->tpl_vars['vjs_advertising']->value == 1 && !$_smarty_tpl->tpl_vars['is_subbed']->value) {?>
	<?php echo '<script'; ?>
>var fk='<?php echo $_smarty_tpl->tpl_vars['file_key']->value;?>
';<?php if ($_smarty_tpl->tpl_vars['ad_skip']->value) {?>var ad_skip='<?php echo $_smarty_tpl->tpl_vars['ad_skip']->value;?>
';<?php }?>var ad_client='<?php echo $_smarty_tpl->tpl_vars['ad_client']->value;?>
';var adTagUrl='<?php echo $_smarty_tpl->tpl_vars['ad_tag_url']->value;?>
';var compjs='<?php if ($_smarty_tpl->tpl_vars['is_mobile']->value) {?>ads.mob<?php } else {
if ($_smarty_tpl->tpl_vars['ad_tag_comp']->value == "1") {?>ads.comp<?php } else { ?>ads<?php }
}?>';<?php echo '</script'; ?>
>
	<?php if ($_smarty_tpl->tpl_vars['ad_client']->value == "ima" && $_smarty_tpl->tpl_vars['embed_src']->value == "local") {?>
	<?php echo '<script'; ?>
 src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/videojs/min/ima.min.js"><?php echo '</script'; ?>
>
	<?php } elseif ($_smarty_tpl->tpl_vars['ad_client']->value == "vast" && $_smarty_tpl->tpl_vars['embed_src']->value == "local" && !$_smarty_tpl->tpl_vars['is_subbed']->value) {?>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/videojs/min/videojs_5.vast.vpaid.min.js"><?php echo '</script'; ?>
>
	<?php }?>
	<?php }?>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/videojs/videojs-scripts.min.js"><?php echo '</script'; ?>
>
	<?php if ($_GET['l'] != '') {?>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/videojs/videojs-hlsjs-plugin.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/nosleep.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
        	<?php if ($_smarty_tpl->tpl_vars['is_mobile']->value) {?>var noSleep = new NoSleep();function enableNoSleep(){noSleep.enable();document.removeEventListener('click',enableNoSleep,false);}document.addEventListener('click', enableNoSleep, false);<?php }?>
        	window.addEventListener('message',function(e){if(e.origin!=="<?php echo $_smarty_tpl->tpl_vars['live_chat_server']->value;?>
")return;var task=e.data['task'];if(typeof task!='undefined'){switch(task){case 'fixedchat':$('.inner-block.with-menu').addClass('pfixedoff');break;case 'nofixedchat':$('.inner-block.with-menu').removeClass('pfixedoff');$("html,body").animate({scrollTop:0},"fast");break;case 'showchat':$('#vs-chat-wrap iframe').css('display','block');$('#vs-chat-wrap i.spinner').detach();var th=$("body").hasClass("dark")?"th0":"th1";document.getElementById("vs-chat").contentWindow.postMessage({"viz":th,"location":window.location.href},"<?php echo $_smarty_tpl->tpl_vars['live_chat_server']->value;?>
");break;case 'disconnect':window.location='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signout"),$_smarty_tpl);?>
';break;}}});
        <?php echo '</script'; ?>
>
	<?php }?>
	<?php } else { ?>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/<?php if (($_smarty_tpl->tpl_vars['video_player']->value == "jw" && $_GET['v'] != '') || ($_smarty_tpl->tpl_vars['audio_player']->value == "jw" && $_GET['a'] != '')) {?>jwplayer<?php } else { ?>flowplayer<?php }?>/<?php if (($_smarty_tpl->tpl_vars['video_player']->value == "jw" && $_GET['v'] != '') || ($_smarty_tpl->tpl_vars['audio_player']->value == "jw" && $_GET['a'] != '')) {?>jwplayer<?php } else { ?>flowplayer5<?php }?>.js"><?php echo '</script'; ?>
>
        <?php }
}
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" && ($_GET['v'] != '' || $_GET['l'] != '')) {?>
        <?php echo '<script'; ?>
 type="text/javascript">
        <?php if ($_smarty_tpl->tpl_vars['video_player']->value == "vjs" && ($_smarty_tpl->tpl_vars['embed_src']->value == "local" || $_smarty_tpl->tpl_vars['embed_src']->value == "youtube")) {
echo insert_getVJSJS(array('usr_key' => $_smarty_tpl->tpl_vars['usr_key']->value, 'file_key' => $_smarty_tpl->tpl_vars['file_key']->value, 'file_hd' => $_smarty_tpl->tpl_vars['hd']->value, 'next' => $_smarty_tpl->tpl_vars['next']->value, 'pl_key' => $_smarty_tpl->tpl_vars['pl_key']->value),$_smarty_tpl);?>
        <?php } elseif ($_smarty_tpl->tpl_vars['video_player']->value == "jw" && $_smarty_tpl->tpl_vars['embed_src']->value == "local") {
echo insert_getJWJS(array('usr_key' => $_smarty_tpl->tpl_vars['usr_key']->value, 'file_key' => $_smarty_tpl->tpl_vars['file_key']->value, 'file_hd' => $_smarty_tpl->tpl_vars['hd']->value, 'next' => $_smarty_tpl->tpl_vars['next']->value, 'pl_key' => $_smarty_tpl->tpl_vars['pl_key']->value),$_smarty_tpl);?>
        <?php }
echo '</script'; ?>
>
<?php } elseif (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" && $_GET['i'] != '')) {?>
        <?php echo '<script'; ?>
 type="text/javascript"><?php echo insert_getImageJS(array('pl_key' => smarty_modifier_sanitize($_GET['p'])),$_smarty_tpl);
echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" && $_GET['a'] != '') {?>
        <?php echo '<script'; ?>
 type="text/javascript">
        <?php if ($_smarty_tpl->tpl_vars['audio_player']->value == "vjs") {
echo insert_getVJSJS(array('usr_key' => $_smarty_tpl->tpl_vars['usr_key']->value, 'file_key' => $_smarty_tpl->tpl_vars['file_key']->value, 'file_hd' => $_smarty_tpl->tpl_vars['hd']->value, 'next' => $_smarty_tpl->tpl_vars['next']->value, 'pl_key' => $_smarty_tpl->tpl_vars['pl_key']->value),$_smarty_tpl);?>
        <?php } elseif ($_smarty_tpl->tpl_vars['audio_player']->value == "jw") {
echo insert_getJWJS(array('usr_key' => $_smarty_tpl->tpl_vars['usr_key']->value, 'file_key' => $_smarty_tpl->tpl_vars['file_key']->value, 'file_hd' => 0, 'next' => $_smarty_tpl->tpl_vars['next']->value, 'pl_key' => $_smarty_tpl->tpl_vars['pl_key']->value),$_smarty_tpl);?>
        <?php }
echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" && $_GET['d'] != '') {?>
        <?php echo '<script'; ?>
 type="text/javascript"><?php echo insert_getDOCJS(array('usr_key' => $_smarty_tpl->tpl_vars['usr_key']->value, 'file_key' => $_smarty_tpl->tpl_vars['file_key']->value, 'file_hd' => 0, 'next' => $_smarty_tpl->tpl_vars['next']->value, 'pl_key' => $_smarty_tpl->tpl_vars['pl_key']->value),$_smarty_tpl);
echo '</script'; ?>
>
<?php }?>
	<?php echo '<script'; ?>
 type="text/javascript">$(document).ready(function(){$('div.showSingle-lb').on('click',function(e){mw='50%';t=$(this);s=t.attr('target');switch(s){case 'report':mw='70%';break;};$.fancybox.open({href:'#div-'+s,type:'inline',afterLoad:function(){$('.tooltip').hide()},opts:{onComplete:function(){}},margin:0,minWidth:'50%',maxWidth:'95%',maxHeight:'90%'});});});<?php echo '</script'; ?>
>
<?php }
}

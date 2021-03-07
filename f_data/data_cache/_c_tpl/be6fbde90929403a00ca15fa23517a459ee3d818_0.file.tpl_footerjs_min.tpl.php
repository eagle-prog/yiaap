<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_footerjs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f56bb8026_90244248',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be6fbde90929403a00ca15fa23517a459ee3d818' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_footerjs_min.tpl',
      1 => 1554155400,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f56bb8026_90244248 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
        <?php echo '<script'; ?>
 type="text/javascript">var base='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';var _rel="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
";var current_url=base;var menu_section='<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
';var jslang=new Array();jslang["lss"]='<?php if ($_SESSION['USER_ID'] > 0) {?>1<?php } else { ?>0<?php }?>';jslang["loading"]='<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.loading"),$_smarty_tpl);?>
';jslang["inwatchlist"]='<?php echo smarty_function_lang_entry(array('key'=>"files.menu.watch.in"),$_smarty_tpl);?>
';jslang["nowatchlist"]='<?php echo smarty_function_lang_entry(array('key'=>"files.menu.watch.login"),$_smarty_tpl);?>
';jslang["showmore"]='<?php echo smarty_function_lang_entry(array('key'=>"main.text.show.more"),$_smarty_tpl);?>
';jslang["showless"]='<?php echo smarty_function_lang_entry(array('key'=>"main.text.show.less"),$_smarty_tpl);?>
';var f_lang=new Array();f_lang["add_new"]='<?php echo smarty_function_lang_entry(array('key'=>"files.menu.add.new"),$_smarty_tpl);?>
';f_lang["l"]='<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.l.c"),$_smarty_tpl);?>
';f_lang["v"]='<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.v.c"),$_smarty_tpl);?>
';f_lang["i"]='<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.i.c"),$_smarty_tpl);?>
';f_lang["a"]='<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.a.c"),$_smarty_tpl);?>
';f_lang["d"]='<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.d.c"),$_smarty_tpl);?>
';f_lang["b"]='<?php echo smarty_function_lang_entry(array('key'=>"frontend.global.b.c"),$_smarty_tpl);?>
';f_lang["upload"]='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"upload"),$_smarty_tpl);?>
';var upload_lang=new Array();upload_lang["h1"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.h1.select"),$_smarty_tpl);?>
';upload_lang["h2"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.h2.select"),$_smarty_tpl);?>
';upload_lang["category"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.categ"),$_smarty_tpl);?>
';upload_lang["username"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.user"),$_smarty_tpl);?>
';upload_lang["assign"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.assign.tip"),$_smarty_tpl);?>
';upload_lang["tip"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.categ.tip"),$_smarty_tpl);?>
';upload_lang["utip"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.user.tip"),$_smarty_tpl);?>
';upload_lang["filename"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.filename"),$_smarty_tpl);?>
';upload_lang["size"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.size"),$_smarty_tpl);?>
';upload_lang["status"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.status"),$_smarty_tpl);?>
';upload_lang["drag"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.drag"),$_smarty_tpl);?>
';upload_lang["select"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.select"),$_smarty_tpl);?>
';upload_lang["start"]='<?php echo smarty_function_lang_entry(array('key'=>"upload.text.btn.start"),$_smarty_tpl);?>
';<?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/min/init0.min.js"><?php echo '</script'; ?>
>
<?php ob_start();
echo smarty_function_href_entry(array('key'=>"broadcasts"),$_smarty_tpl);
$_prefixVariable3 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"videos"),$_smarty_tpl);
$_prefixVariable4 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"images"),$_smarty_tpl);
$_prefixVariable5 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"audios"),$_smarty_tpl);
$_prefixVariable6 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"documents"),$_smarty_tpl);
$_prefixVariable7 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"playlists"),$_smarty_tpl);
$_prefixVariable8 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"blogs"),$_smarty_tpl);
$_prefixVariable9 = ob_get_clean();
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_index" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" && ($_GET['tf'] == 6 || $_GET['tf'] == 7)) || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlists" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_blogs" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel" && ($_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable3 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable4 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable5 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable6 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable7 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable8 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable9)) || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_search") {?>
        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_blogs" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_index") {?>
        <?php echo '<script'; ?>
 type="text/javascript">jQuery(function(){jQuery("#categories-accordion").dcAccordion({eventType:"hover",autoClose:false,autoExpand:true,classExpand:"dcjq-current-parent",saveState:false,disableLink:false,showCount:false,menuClose:false,speed:200,cookie:"categ-menu-cookie"})});<?php echo '</script'; ?>
>
        <?php } else { ?>
        <?php echo '<script'; ?>
 type="text/javascript">jQuery(function(){jQuery("#categories-accordion").dcAccordion({eventType:"click",autoClose:true,autoExpand:true,classExpand:"dcjq-current-parent",saveState:false,disableLink:false,showCount:false,menuClose:true,speed:200,cookie:"categ-menu-cookie"})});<?php echo '</script'; ?>
>
        <?php }
}
echo insert_loadjsplugins(array(),$_smarty_tpl);
ob_start();
echo smarty_function_href_entry(array('key'=>"broadcasts"),$_smarty_tpl);
$_prefixVariable10 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"videos"),$_smarty_tpl);
$_prefixVariable11 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"images"),$_smarty_tpl);
$_prefixVariable12 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"audios"),$_smarty_tpl);
$_prefixVariable13 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"documents"),$_smarty_tpl);
$_prefixVariable14 = ob_get_clean();
ob_start();
echo smarty_function_href_entry(array('key'=>"blogs"),$_smarty_tpl);
$_prefixVariable15 = ob_get_clean();
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_browse" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_blogs" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" && ($_GET['tf'] == '' || $_GET['tf'] == "1" || $_GET['tf'] == "2" || $_GET['tf'] == "3" || $_GET['tf'] == "4" || $_GET['tf'] == "7" || $_GET['tf'] == "8")) || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel" && ($_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable10 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable11 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable12 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable13 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable14 || $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable15))) {?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/min/fwtabs.browse.init.min.js"><?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" && $_GET['tf'] == 6)) {?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/min/fwtabs.channels.init.min.js"><?php echo '</script'; ?>
>
<?php } else {
ob_start();
echo smarty_function_href_entry(array('key'=>"playlists"),$_smarty_tpl);
$_prefixVariable16 = ob_get_clean();
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_search" && $_GET['tf'] == "5") || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_playlists" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel" && $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable16)) {?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/min/fwtabs.files.init.min.js"><?php echo '</script'; ?>
>
<?php }}
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_account" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_files_edit") {?>
        <?php echo '<script'; ?>
 type="text/javascript">$(document).ready(function() {$('.uinfo-entry').mouseover(function(){$(this).addClass("y-bg");}).mouseout(function(){$(this).removeClass("y-bg");});url=<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_account") {?>current_url + menu_section + '?s=account-menu-entry1&do=loading'<?php } else { ?>'<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
?fe=1&<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['file_key']->value;?>
&do=thumb'<?php }?>;$(".thumb-popup").fancybox({ type: "ajax", margin: 20, minWidth: "70%", href: url, height: "auto", autoHeight: "true", autoResize: "true", autoCenter: "true" });});<?php echo '</script'; ?>
>
<?php }
if ($_SESSION['USER_ID'] > 0 && ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_index")) {?>
	<?php echo '<script'; ?>
>$(document).on("click", ".unsubscribe-button", function() {var cd="<?php echo $_SESSION['USER_KEY'];?>
";<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view") {?>var cc="<?php echo $_smarty_tpl->tpl_vars['usr_key']->value;?>
"; act_url=current_url + menu_section + "?<?php echo $_smarty_tpl->tpl_vars['file_type']->value[0];?>
=<?php echo $_smarty_tpl->tpl_vars['file_key']->value;?>
&do=unsub-option";<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels") {?>var cc=$(this).attr("rel-usr"); act_url="?do=unsub-option&u="+cc;<?php } else { ?>var cc="<?php echo $_smarty_tpl->tpl_vars['channel_key']->value;?>
"; act_url="?a=&do=unsub-option";<?php }?>if (cc !== cd) $.fancybox({ type: "ajax", minWidth: "80%", minHeight: "50%", margin: 20, href: act_url });});$(document).on("click", ".subscribe-button", function() {var cd="<?php echo $_SESSION['USER_KEY'];?>
";<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view") {?>var cc="<?php echo $_smarty_tpl->tpl_vars['usr_key']->value;?>
"; act_url=current_url + menu_section + "?<?php echo $_smarty_tpl->tpl_vars['file_type']->value[0];?>
=<?php echo $_smarty_tpl->tpl_vars['file_key']->value;?>
&do=sub-option";<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_index" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels") {?>var cc=$(this).attr("rel-usr"); act_url="?do=sub-option&u="+$(this).attr("rel-usr");<?php } else { ?>var cc="<?php echo $_smarty_tpl->tpl_vars['channel_key']->value;?>
"; act_url="?a=&do=sub-option";<?php }?>if (cc !== cd) $.fancybox({ type: "ajax", minWidth: "80%", minHeight: "50%", margin: 20, href: act_url });});<?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files_edit" || $_smarty_tpl->tpl_vars['page_display']->value == "tpl_respond") {?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/tinymce/tinymce.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">var _u=current_url + menu_section + '?fe=1&<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['file_key']->value;?>
';<?php if ($_smarty_tpl->tpl_vars['live_module']->value == "1") {?>var lm=1;<?php }
if ($_smarty_tpl->tpl_vars['video_module']->value == "1") {?>var vm=1;<?php }
if ($_smarty_tpl->tpl_vars['image_module']->value == "1") {?>var im=1;<?php }
if ($_smarty_tpl->tpl_vars['audio_module']->value == "1") {?>var am=1;<?php }
if ($_smarty_tpl->tpl_vars['document_module']->value == "1") {?>var dm=1;<?php }
echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/min/tinymce.init.min.js"><?php echo '</script'; ?>
>
<?php }?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/jquery.init.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">function init(){window.addEventListener('scroll',function(e){var distanceY=window.pageYOffset || document.documentElement.scrollTop,shrinkOn=0,header=document.querySelector("header");if (distanceY > shrinkOn) {classie.add(header, "smaller");}else{if(classie.has(header, "smaller")){classie.remove(header, "smaller");}}});}window.onload=init();<?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">$(document).ready(function(){$("#search").keydown(function(){$("#search").autocomplete({type:"post",params:{"t":"<?php if ($_smarty_tpl->tpl_vars['video_module']->value == 1) {?>video<?php } elseif ($_smarty_tpl->tpl_vars['live_module']->value == 1) {?>live<?php } elseif ($_smarty_tpl->tpl_vars['image_module']->value == 1) {?>image<?php } elseif ($_smarty_tpl->tpl_vars['audio_module']->value == 1) {?>audio<?php } elseif ($_smarty_tpl->tpl_vars['document_module']->value == 1) {?>doc<?php }?>" },serviceUrl: current_url + "<?php echo smarty_function_href_entry(array('key'=>"search"),$_smarty_tpl);?>
" +"?do=autocomplete",onSearchStart: function() {},onSelect: function (suggestion) {$(".sb-search-submit").trigger("click");}});});});<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['comment_emoji']->value == 1) {?>
	<?php echo '<script'; ?>
 type="text/javascript">$(document).ready(function(){var s=document.createElement("script");s.type="text/javascript";s.src="https://cdn.jsdelivr.net/npm/emojione@4.0.0/lib/js/emojione.min.js";s.addEventListener('load',function(e){<?php if (($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel" && $_smarty_tpl->tpl_vars['channel_module']->value == '')) {?>lem();<?php }
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files" && $_GET['s'] == '') {?>var tc = $(".cr-tabs .msg-body pre").length;$(".cr-tabs .msg-body pre").each(function(index,value){var t=$(this);var c=t.text();var nc=emojione.toImage(c);t.html(nc);if(index===tc-1){$(".spinner.icon-spinner").hide();$(".cr-tabs .msg-body pre").show()}});<?php }?>},false);document.head.appendChild(s);});<?php echo '</script'; ?>
>
<?php }
}
}

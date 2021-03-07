<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_body.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f56a5ffb3_50536638',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f7e4d841748b5971d97dd672eba402d842fed8a' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_body.tpl',
      1 => 1607965202,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_header/tpl_headernav_yt.tpl' => 1,
    'file:tpl_frontend/tpl_body_main.tpl' => 1,
    'file:tpl_frontend/tpl_footer.tpl' => 1,
    'file:tpl_frontend/tpl_footerjs_min.tpl' => 1,
  ),
),false)) {
function content_601c2f56a5ffb3_50536638 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.escape.php','function'=>'smarty_modifier_escape',),));
?>
    <body class="fe media-width-768 is-fw<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_files_edit") {?> tpl_files_edit<?php } elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_subs") {?> tpl_files<?php }
if (strpos($_smarty_tpl->tpl_vars['theme_name']->value,'dark') === 0) {?> dark<?php }?>">
        <div id="wrapper" class="<?php echo $_smarty_tpl->tpl_vars['page_display']->value;
if ($_smarty_tpl->tpl_vars['page_display']->value != "tpl_files" && $_smarty_tpl->tpl_vars['page_display']->value != "tpl_index") {?> tpl_files<?php }
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channels") {?> tpl_browse<?php }
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_tokens") {?> tpl_subscribers<?php }
if ($_SESSION['sbm'] == 0) {?> g5<?php }?>">
            <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_header/tpl_headernav_yt.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <div class="spacer"></div>
            <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_body_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <div class="push"></div>
        </div>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_footerjs_min.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </body>
<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" && $_GET['l'] != '' && $_smarty_tpl->tpl_vars['is_live']->value == 1) {
echo '<script'; ?>
 type="text/javascript">var int=self.setInterval(lv,60000);function lv(){if(typeof player!=="undefined" && player.currentTime() > 0 && !player.paused() && !player.ended()){var u="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"viewers"),$_smarty_tpl);?>
?s=<?php echo $_smarty_tpl->tpl_vars['file_key']->value;?>
";$.get(u,function(){});}}<?php echo '</script'; ?>
><?php }
if ($_smarty_tpl->tpl_vars['google_analytics']->value != '') {?>
    <?php echo '<script'; ?>
 type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', '<?php echo $_smarty_tpl->tpl_vars['google_analytics']->value;?>
']);_gaq.push(['_trackPageview']);(function(){var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();<?php echo '</script'; ?>
>
<?php }
if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" && $_smarty_tpl->tpl_vars['affiliate_module']->value == 1 && $_smarty_tpl->tpl_vars['affiliate_tracking_id']->value != "UA-" && $_smarty_tpl->tpl_vars['usr_key']->value != $_SESSION['USER_KEY']) {?>
    <?php echo '<script'; ?>
>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');function gainit(){ga('create','<?php echo $_smarty_tpl->tpl_vars['affiliate_tracking_id']->value;?>
','auto');ga('set','dimension1','<?php echo $_smarty_tpl->tpl_vars['usr_key']->value;?>
');ga('set','dimension2','<?php echo $_smarty_tpl->tpl_vars['file_type']->value;?>
');ga('set','dimension3','<?php echo $_smarty_tpl->tpl_vars['file_key']->value;?>
');ga('send',{hitType:'pageview',page:location.pathname,title:'<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['file_title']->value, 'dec');?>
'});}<?php if ($_smarty_tpl->tpl_vars['file_type']->value == "video" || $_smarty_tpl->tpl_vars['file_type']->value == "live" || $_smarty_tpl->tpl_vars['file_type']->value == "audio") {?>if(typeof player!=="undefined"){player.on('timeupdate',function(){if(player.currentTime()>5&&player.currentTime()<5.2&&typeof($(".vjs-ads-label").html())=="undefined"){gainit();}});}<?php } else { ?>gainit();<?php }
echo '</script'; ?>
>
<?php }?>
</html><?php }
}

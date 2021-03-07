<?php
/* Smarty version 3.1.33, created on 2021-02-09 18:58:58
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_head_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602321c2a7f465_14333204',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f59aa6fdae613486a4837b17a6748e69629e9cb' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_head_min.tpl',
      1 => 1612915119,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_frontend/tpl_headview_min.tpl' => 1,
    'file:tpl_frontend/tpl_headchannel_min.tpl' => 1,
    'file:tpl_frontend/tpl_headmain_min.tpl' => 1,
    'file:tpl_frontend/tpl_emojionearea.css.tpl' => 1,
  ),
),false)) {
function content_602321c2a7f465_14333204 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
<!DOCTYPE html>
<html lang="en">
    <head profile="http://www.w3.org/2005/10/profile">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title><?php echo insert_getPageMeta(array('for' => "title"),$_smarty_tpl);?></title>
        <meta name="description" content="<?php echo insert_getPageMeta(array('for' => "description"),$_smarty_tpl);?>">
        <meta name="keywords" content="<?php echo insert_getPageMeta(array('for' => "tags"),$_smarty_tpl);?>">
        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view") {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_headview_min.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel") {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_headchannel_min.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_GET['next'] == '') {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_headmain_min.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
        <link rel="icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/favicon.png">
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/init0.min.css">
        <link rel="preload" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/flagicon/css/flag-icon.min.css" as="style" onload="this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/flagicon/css/flag-icon.min.css"></noscript>
        <?php echo insert_loadcssplugins(array(),$_smarty_tpl);?>
        <?php ob_start();
echo smarty_function_href_entry(array('key'=>"discussion"),$_smarty_tpl);
$_prefixVariable1 = ob_get_clean();
if ($_smarty_tpl->tpl_vars['comment_emoji']->value == 1 && ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_view" || ($_smarty_tpl->tpl_vars['page_display']->value == "tpl_channel" && $_smarty_tpl->tpl_vars['channel_module']->value == $_prefixVariable1))) {
$_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_emojionearea.css.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
        <link rel="preload" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/media_queries.min.css" as="style" onload="this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/media_queries.min.css"></noscript>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/theme/yt.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/theme/<?php echo $_smarty_tpl->tpl_vars['theme_name']->value;?>
.min.css" id="fe-color">
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url_be']->value;?>
/theme/<?php echo $_smarty_tpl->tpl_vars['theme_name']->value;?>
_backend.min.css" id="be-color">
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/custom.min.css">
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/jquery.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/jquery.captcha.basic.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>WebFont.load({google:{families:['Roboto:300,400,500,600,700']}});<?php echo '</script'; ?>
>
    </head>
<?php }
}

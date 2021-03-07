<?php
/* Smarty version 3.1.33, created on 2021-02-06 12:16:22
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_headchannel_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ecee62382c1_98342558',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfb5adaac85bf2310096dd710800fb3dde3a6b63' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_headchannel_min.tpl',
      1 => 1606251161,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601ecee62382c1_98342558 (Smarty_Internal_Template $_smarty_tpl) {
?>        <?php $_smarty_tpl->assign("profileImage" , insert_getProfileImage (array('for' => ((string)$_smarty_tpl->tpl_vars['usr_id']->value)),$_smarty_tpl), true);?><meta name="author" content="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
" /><meta name="copyright" content="<?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
" /><meta name="application-name" content="<?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
" /><meta name="thumbnail" content="<?php echo $_smarty_tpl->tpl_vars['profileImage']->value;?>
?_=<?php echo time();?>
" /><meta property="og:title" content="<?php echo insert_getPageMeta(array('for' => "title"),$_smarty_tpl);?>" /><meta property="og:type" content="article" /><meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['profileImage']->value;?>
?_=<?php echo time();?>
" /><meta property="og:image:width" content="640" /><meta property="og:image:height" content="360" /><meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;
echo $_SERVER['REQUEST_URI'];?>
" /><meta property="og:description" content="<?php echo insert_getPageMeta(array('for' => "description"),$_smarty_tpl);?>" /><meta name="twitter:card" content="summary" /><meta name="twitter:title" content="<?php echo insert_getPageMeta(array('for' => "title"),$_smarty_tpl);?>" /><meta name="twitter:description" content="<?php echo insert_getPageMeta(array('for' => "description"),$_smarty_tpl);?>" /><meta name="twitter:image" content="<?php echo $_smarty_tpl->tpl_vars['profileImage']->value;?>
?_=<?php echo time();?>
" /><link rel="image_src" href="<?php echo $_smarty_tpl->tpl_vars['profileImage']->value;?>
?_=<?php echo time();?>
">
<?php }
}

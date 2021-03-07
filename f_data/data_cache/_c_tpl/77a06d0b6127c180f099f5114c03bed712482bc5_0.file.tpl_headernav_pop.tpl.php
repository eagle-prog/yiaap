<?php
/* Smarty version 3.1.33, created on 2021-02-26 06:03:06
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_headernav_pop.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60388f1ac1e661_40227816',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '77a06d0b6127c180f099f5114c03bed712482bc5' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_header/tpl_headernav_pop.tpl',
      1 => 1614312167,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60388f1ac1e661_40227816 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<div class="tacc-img">
	<img height="40" class="own-profile-image mt-off" title="<?php echo $_SESSION['USER_NAME'];?>
" alt="<?php echo $_SESSION['USER_NAME'];?>
" src="<?php $_smarty_tpl->assign("profileImage" , insert_getProfileImage (array('for' => ((string)$_SESSION['USER_ID'])),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['profileImage']->value;?>
?_=<?php echo time();?>
">
</div>
<div class="tacc-nfo">
        <span>
                <span class="tacc-uu"><?php if ($_SESSION['USER_ID'] > 0) {?><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"channel"),$_smarty_tpl);?>
/<?php echo $_SESSION['USER_KEY'];?>
/<?php echo $_SESSION['USER_NAME'];?>
"><?php if ($_SESSION['USER_DNAME'] != '') {
echo $_SESSION['USER_DNAME'];
} else {
echo $_SESSION['USER_NAME'];
}?></a><?php } else {
echo smarty_function_lang_entry(array('key'=>"frontend.global.guest.rand"),$_smarty_tpl);
}?></span>
                <span class="tacc-us"><span class="r1"><?php if ($_SESSION['USER_ID'] > 0) {
echo insert_getSubCount(array(),$_smarty_tpl);
} else { ?>0<?php }?> <label><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.subscribers"),$_smarty_tpl);?>
</label><span class="rcm">,</span></span> <span class="r2"><?php if ($_SESSION['USER_ID'] > 0) {
echo insert_getFollowCount(array(),$_smarty_tpl);
} else { ?>0<?php }?> <label><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.followers"),$_smarty_tpl);?>
</label></span></span>
        </span>
</div>
<div class="clearfix"></div>
<ul class="accordion tacc" id="top-session-accordion">
<?php if ($_SESSION['USER_ID'] > 0) {?>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);?>
"><i class="icon-upload"></i> <?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.files.my"),$_smarty_tpl);?>
</a></li>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"account"),$_smarty_tpl);?>
"><i class="icon-user"></i> <?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.account.my"),$_smarty_tpl);?>
</a></li>
<?php if ($_smarty_tpl->tpl_vars['user_subscriptions']->value == 1) {?>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
"><i class="icon-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.subpanel"),$_smarty_tpl);?>
</a></li>
<?php }
if ($_smarty_tpl->tpl_vars['user_tokens']->value == 1) {?>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"tokens"),$_smarty_tpl);?>
"><i class="icon-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.tokenpanel"),$_smarty_tpl);?>
</a></li>
<?php }
if ($_SESSION['USER_AFFILIATE'] == 1) {?>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"affiliate"),$_smarty_tpl);?>
"><i class="icon-coin"></i> <?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.affiliate"),$_smarty_tpl);?>
</a></li>
<?php }?>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"manage_channel"),$_smarty_tpl);?>
"><i class="icon-settings"></i> <?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.channel.my"),$_smarty_tpl);?>
</a></li>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_href_entry(array('key'=>"messages"),$_smarty_tpl);
} elseif ($_smarty_tpl->tpl_vars['internal_messaging']->value == 0 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_href_entry(array('key'=>"contacts"),$_smarty_tpl);
}?>"><i class="icon-envelope"></i> <?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_lang_entry(array('key'=>"subnav.entry.contacts.messages"),$_smarty_tpl);
} elseif ($_smarty_tpl->tpl_vars['internal_messaging']->value == 0 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {
echo smarty_function_lang_entry(array('key'=>"subnav.entry.contacts"),$_smarty_tpl);
}?> <?php echo insert_newMessages(array(),$_smarty_tpl);?></a></li>
<li><div class="line"></div></li>
<?php }?>
<li class="">
	<a class="dcjq-parent a-dt" href="javascript:;" rel="nofollow"><i class="icon-contrast"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.darktheme"),$_smarty_tpl);?>
: <span id="dark-mode-state-text"><?php if (strpos($_smarty_tpl->tpl_vars['theme_name']->value,'dark') === 0) {
echo smarty_function_lang_entry(array('key'=>"frontend.global.on.text"),$_smarty_tpl);
} else {
echo smarty_function_lang_entry(array('key'=>"frontend.global.off.text"),$_smarty_tpl);
}?></span><i class="iconBe-chevron-right place-right"></i></a>
</li>
<li id="l-dt" style="display:none">
	<div class="dm-wrap">
		<div class="dm-head dm-head-dt"><i class="icon-arrow-left2"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.darktheme"),$_smarty_tpl);?>
</div>
		<p><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.darktheme.tip1"),$_smarty_tpl);?>
<br><br><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.darktheme.tip2"),$_smarty_tpl);?>

		<div>
			<span class="label"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.darktheme"),$_smarty_tpl);?>
</span>
			<?php echo insert_themeSwitch(array(),$_smarty_tpl);?>
		</div>
	</div>
</li>
<li class="">
	<?php echo insert_langInit(array(),$_smarty_tpl);?>
</li>
<?php if ($_SESSION['USER_ID'] > 0) {?>
<li class=""><a class="dcjq-parent dcjq-logout" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signout"),$_smarty_tpl);?>
"><i class="icon-exit"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signout"),$_smarty_tpl);?>
</a></li>
<?php } else { ?>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signin"),$_smarty_tpl);?>
"><i class="icon-exit"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signin"),$_smarty_tpl);?>
</a></li>
<?php }?>
</ul>

<?php echo '<script'; ?>
 type="text/javascript">
$('a.a-dt').click(function(){$('#top-session-accordion li').hide();$('#l-dt').show()});
$('.dm-head-dt').click(function(){$('#top-session-accordion li').show();$('#l-dt, #l-ln').hide()});
$('a.a-ln').click(function(){$('#top-session-accordion li').hide();$('#l-ln').show()});
$('.dm-head-ln').click(function(){$('#top-session-accordion li').show();$('#l-ln, #l-dt').hide()});

$('.dcjq-logout').click(function(e) {
	$.post('/contest/_core/request.php', { reason: 'logout' }, function() {});
})
<?php echo '</script'; ?>
>

<?php }
}

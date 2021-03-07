<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_headernav_pop.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f66985c17_94433036',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c9e1082cee87d20e82eda4512c74511d9f194dab' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_headernav_pop.tpl',
      1 => 1578358814,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f66985c17_94433036 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
<div class="tp-h"><?php echo $_SESSION['ADMIN_NAME'];?>
</div>
<div class="tp-menu">

<div class="clearfix"></div>
<ul class="accordion tacc" id="top-session-accordion">

<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_dashboard"),$_smarty_tpl);?>
"><i class="icon-pie"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.menu.dash"),$_smarty_tpl);?>
</a></li>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_subscribers"),$_smarty_tpl);?>
?rg=1"><i class="icon-pie"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ps.dashboard"),$_smarty_tpl);?>
</a></li>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_affiliate"),$_smarty_tpl);?>
?rp=1"><i class="icon-pie"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.dashboard"),$_smarty_tpl);?>
</a></li>
<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_tokens"),$_smarty_tpl);?>
?rg=1"><i class="icon-pie"></i> <?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ps.token"),$_smarty_tpl);?>
</a></li>

<li class="">
	<a class="dcjq-parent a-dt" href="javascript:;" rel="nofollow"><i class="icon-contrast"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.darktheme"),$_smarty_tpl);?>
: <span id="dark-mode-state-text"><?php if (strpos($_smarty_tpl->tpl_vars['theme_name_be']->value,'dark') === 0) {
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

<li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"signout"),$_smarty_tpl);?>
"><i class="icon-exit"></i> <?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signout"),$_smarty_tpl);?>
</a></li>

</ul>
</div>


<?php echo '<script'; ?>
 type="text/javascript">
$('a.a-dt').click(function(){$('#top-session-accordion li').hide();$('#l-dt').show()});
$('.dm-head-dt').click(function(){$('#top-session-accordion li').show();$('#l-dt, #l-ln').hide()});
$('a.a-ln').click(function(){$('#top-session-accordion li').hide();$('#l-ln').show()});
$('.dm-head-ln').click(function(){$('#top-session-accordion li').show();$('#l-ln, #l-dt').hide()});
<?php echo '</script'; ?>
>
<?php }
}

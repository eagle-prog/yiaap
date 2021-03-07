<?php
/* Smarty version 3.1.33, created on 2021-02-06 11:27:33
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_overview.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601ec375ebf451_53681965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fbe5d50ddd6cbbf572cce09d7408732bb5b3f111' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_overview.tpl',
      1 => 1603111588,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601ec375ebf451_53681965 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['styles_url']->value;?>
/view.min.css">

    <div class="left-float wdmax">
	<div id="overview-userinfo">
	    <div class="statsBox">
		<article>
                	<h3 class="content-title"><i class="icon-user"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.account.overview"),$_smarty_tpl);?>
</h3>
                	<div class="line"></div>
        	</article>
		<div class="vs-column fourths">
		    <div class="user-thumb-xlarge">
			<div><center><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"channel"),$_smarty_tpl);?>
/<?php echo $_SESSION['USER_KEY'];?>
/<?php echo $_SESSION['USER_NAME'];?>
"><img id="own-profile-image" title="<?php echo $_SESSION['USER_NAME'];?>
" alt="<?php echo $_SESSION['USER_NAME'];?>
" src="<?php $_smarty_tpl->assign("profileImage" , insert_getProfileImage (array('for' => ((string)$_SESSION['USER_ID'])),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['profileImage']->value;?>
?_=<?php echo time();?>
"></a></center></div>
		    </div>
		    <div class="imageChange">
		    <form method="post" action="" class="entry-form-class overview-form">
		    	<center>
		    		<button class="save-entry-button button-grey search-button form-button new-image" type="button" onclick="$('.thumb-popup').trigger('click');"><span><?php echo smarty_function_lang_entry(array('key'=>"account.image.change"),$_smarty_tpl);?>
</span></button>
		    		<a href="javascript:;" rel="popuprel" class="thumb-popup hidden"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.change"),$_smarty_tpl);?>
</a>
		    		<?php if ($_smarty_tpl->tpl_vars['affiliate_module']->value == 1 && !$_SESSION['USER_AFFILIATE'] && $_SESSION['USER_AFFILIATE_REQUEST']) {?>
		    		<button class="save-entry-button button-grey search-button form-button usr-delete" type="button" onclick="$('.affiliate-request-popup').trigger('click');"><span><?php echo smarty_function_lang_entry(array('key'=>"account.entry.btn.request"),$_smarty_tpl);?>
</span></button>
                                <a href="javascript:;" rel="popuprel" class="affiliate-request-popup hidden"><?php echo smarty_function_lang_entry(array('key'=>"account.entry.btn.request"),$_smarty_tpl);?>
</a>
                                <?php }?>
		    	</center>
		    </form>
		    </div>
		    <div class="popupbox" id="popuprel"></div>
		    <div id="fade"></div>
		</div>
		
		<div class="vs-column three_fourths fit">
			<?php echo insert_getUserStats(array('type' => "sub"),$_smarty_tpl);?>
		</div>
		<?php echo insert_getUserStats(array('type' => "stats"),$_smarty_tpl);?>
	    </div>
			<div class="clearfix"></div>
	</div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['affiliate_module']->value == 1 && !$_SESSION['USER_AFFILIATE']) {?>
    <?php echo '<script'; ?>
 type="text/javascript">
    	$(document).on("click", ".affiliate-request-popup", function() {
    		af_url = current_url + menu_section + "?s=account-menu-entry1&do=make-affiliate";
    		$.fancybox({ type: "ajax", minWidth: "80%", margin: 20, href: af_url });
	});
    <?php echo '</script'; ?>
>
    <?php }
}
}

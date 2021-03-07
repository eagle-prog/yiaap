<?php
/* Smarty version 3.1.33, created on 2021-02-08 14:01:05
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_subscriber/tpl_overview.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60218a71c5b918_81128762',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '163ca9c0dc941b55437580e095db112a6ca805a3' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_subscriber/tpl_overview.tpl',
      1 => 1553197200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60218a71c5b918_81128762 (Smarty_Internal_Template $_smarty_tpl) {
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
"></a></center></div>
		    </div>
		    <div class="imageChange">
		    <form method="post" action="" class="entry-form-class overview-form">
                        <center>
                                <?php if (!$_SESSION['USER_PARTNER'] && $_SESSION['USER_PARTNER_REQUEST']) {?>
                                <button class="save-entry-button button-grey search-button form-button usr-delete" type="button" onclick="$('.partner-request-popup').trigger('click');"><span><?php echo smarty_function_lang_entry(array('key'=>"account.entry.btn.request.prt"),$_smarty_tpl);?>
</span></button>
                                <a href="javascript:;" rel="popuprel" class="partner-request-popup hidden"><?php echo smarty_function_lang_entry(array('key'=>"account.entry.btn.request.prt"),$_smarty_tpl);?>
</a>
                                <?php } elseif ($_SESSION['USER_PARTNER']) {?>
                                <button class="save-entry-button button-grey search-button form-button purge-button" type="button" onclick="$('.partner-cancel-popup').trigger('click');"><span><?php echo smarty_function_lang_entry(array('key'=>"account.entry.btn.terminate.prt"),$_smarty_tpl);?>
</span></button>
                                <a href="javascript:;" rel="popuprel" class="partner-cancel-popup hidden"><?php echo smarty_function_lang_entry(array('key'=>"account.entry.btn.terminate.prt"),$_smarty_tpl);?>
</a>
                                <?php }?>
                        </center>
                    </form>
                    </div>
		    <div class="popupbox" id="popuprel"></div>
		    <div id="fade"></div>
		</div>
		
		<div class="vs-column three_fourths fit">
			<?php echo insert_getUserStats(array('type' => "subs"),$_smarty_tpl);?>
		</div>
	    </div>
			<div class="clearfix"></div>
	</div>
    </div>
<?php echo '<script'; ?>
 type="text/javascript">
    $(document).on("click", ".partner-request-popup", function() {
	af_url = current_url + menu_section + "?s=account-menu-entry1&do=make-partner";
	$.fancybox({ type: "ajax", minWidth: "80%", margin: 20, href: af_url });
    });
<?php if ($_SESSION['USER_PARTNER'] == 1) {?>
    $(function() {SelectList.init("user_partner_badge");});
    $(document).on("click", ".partner-cancel-popup", function() {
	af_url = current_url + menu_section + "?s=account-menu-entry1&do=clear-partner";
	$.fancybox({ type: "ajax", minWidth: "80%", margin: 20, href: af_url });
    });
    $(document).on("change", ".badge-select-input", function() {
        v = $(this).val();
        h = '<i id="affiliate-icon" class="'+v+'"></i>';
        $("#affiliate-icon").replaceWith(h);
        if (v == "") $("#affiliate-icon").hide();
        af_url = current_url + menu_section + "?s=account-menu-entry13&do=save-subscriber";
        $.post(af_url, $("#ct-set-form").serialize(), function(data) {
                $("#affiliate-response").html(data);
        });
    });
    $(document).on("keydown", ".user-partner-paypal", function(e) {
        var code = e.which;
        if (code == 13) {
                e.preventDefault();
                af_url = current_url + menu_section + "?s=account-menu-entry13&do=save-subscriber";
                $.post(af_url, $("#ct-set-form").serialize(), function(data) {
                        $("#affiliate-response").html(data);
                });
        }
    });
<?php }
echo '</script'; ?>
>
<?php }
}

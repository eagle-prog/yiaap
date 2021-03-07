<?php
/* Smarty version 3.1.33, created on 2021-02-08 14:00:59
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_messages_inner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60218a6b3e2905_73870728',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3d4e9bcd45b0d9c476d1211940d6a0aaa17cfaa9' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_messages_inner.tpl',
      1 => 1569557576,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60218a6b3e2905_73870728 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
	<div class="blue categories-container">
                    <h4 class="nav-title categories-menu-title left-menu-h4 no-display"><i class="icon-envelope"></i><?php echo smarty_function_lang_entry(array('key'=>"subnav.entry.contacts.messages"),$_smarty_tpl);?>
</h4>
                    <aside>
                        <nav>
                            <ul class="accordion inner-accordion" id="categories-accordion">
	<?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1) {?>
	    <li id="message-menu-entry2" class="menu-panel-entry<?php if ($_GET['s'] == "message-menu-entry2") {?> menu-panel-entry-active<?php }?>">
	    	<a href="javascript:;" class="dcjq-parent active">
	    		<i class="icon-envelope"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"msg.entry.inbox"),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['message_count']->value == 1) {?>&nbsp;<span id="message-menu-entry2-count" class="right-float mm-count"><?php $_smarty_tpl->assign("m_count" , insert_msgCount (array('for' => "message-menu-entry2"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['m_count']->value;?>
</span><?php }?>
	    	</a>
	   </li>
		<?php if ($_smarty_tpl->tpl_vars['custom_labels']->value == 1) {
$_smarty_tpl->assign('sectionLabel' , insert_sectionLabel (array('for' => "message-menu-entry2"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['sectionLabel']->value;
}?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1) {?>
	    <li id="message-menu-entry5" class="menu-panel-entry<?php if ($_GET['s'] == "message-menu-entry5") {?> menu-panel-entry-active<?php }?>">
	    	<a href="javascript:;"><i class="icon-envelope"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"msg.entry.sent"),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['message_count']->value == 1) {?>&nbsp;<span id="message-menu-entry5-count" class="right-float mm-count"><?php $_smarty_tpl->assign("m_count" , insert_msgCount (array('for' => "message-menu-entry5"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['m_count']->value;?>
</span><?php }?></a>
	    </li>
		<?php if ($_smarty_tpl->tpl_vars['custom_labels']->value == 1) {
$_smarty_tpl->assign('sectionLabel' , insert_sectionLabel (array('for' => "message-menu-entry5"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['sectionLabel']->value;
}?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1) {?>
	    <li id="message-menu-entry6" class="greyed-out menu-panel-entry<?php if ($_GET['s'] == "message-menu-entry6") {?> menu-panel-entry-active<?php }?>">
	    	<a href="javascript:;"><i class="icon-spam"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"msg.entry.spam"),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['message_count']->value == 1) {?>&nbsp;<span id="message-menu-entry6-count" class="right-float mm-count"><?php $_smarty_tpl->assign("m_count" , insert_msgCount (array('for' => "message-menu-entry6"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['m_count']->value;?>
</span><?php }?></a>
	    </li>
		<?php if ($_smarty_tpl->tpl_vars['custom_labels']->value == 1) {
$_smarty_tpl->assign('sectionLabel' , insert_sectionLabel (array('for' => "message-menu-entry6"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['sectionLabel']->value;
}?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['user_friends']->value == 1 && $_smarty_tpl->tpl_vars['approve_friends']->value == 1) {?>
	    <li id="message-menu-entry4" class="darker-out menu-panel-entry<?php if ($_GET['s'] == "message-menu-entry4") {?> menu-panel-entry-active<?php }?>">
	    	<a href="javascript:;"><i class="icon-notebook"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"msg.entry.fr.invite"),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['message_count']->value == 1) {?>&nbsp;<span id="message-menu-entry4-count" class="right-float mm-count"><?php $_smarty_tpl->assign("m_count" , insert_msgCount (array('for' => "message-menu-entry4"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['m_count']->value;?>
</span><?php }?></a>
	    </li>
	<?php }?>

    <?php if ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1 || $_smarty_tpl->tpl_vars['custom_labels']->value == 1) {?>
	    <li id="message-menu-entry7" class="menu-panel-entry<?php if ($_GET['s'] == "message-menu-entry7") {?> menu-panel-entry-active<?php }?>">
	    	<a href="javascript:;"><i class="icon-address-book"></i><span class="mm"><?php echo smarty_function_lang_entry(array('key'=>"msg.entry.adr.book"),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['message_count']->value == 1) {?>&nbsp;<span id="message-menu-entry7-count" class="right-float mm-count"><?php $_smarty_tpl->assign("m_count" , insert_msgCount (array('for' => "message-menu-entry7"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['m_count']->value;?>
</span><?php }?></a>
	    </li>
	<?php if ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1 || $_smarty_tpl->tpl_vars['custom_labels']->value == 1) {
$_smarty_tpl->assign('sectionLabel' , insert_sectionLabel (array('for' => "message-menu-entry7"),$_smarty_tpl), true);
echo $_smarty_tpl->tpl_vars['sectionLabel']->value;
}?>
    <?php }?>
                            </ul>
                        </nav>
                    </aside>
                </div>


	<?php echo '<script'; ?>
 type="text/javascript">
	    var paging_link = '';
	    <?php if ($_GET['page'] != '') {?>var paging_link = '&page=<?php echo smarty_modifier_sanitize($_GET['page']);?>
&ipp=<?php echo smarty_modifier_sanitize($_GET['ipp']);?>
';<?php }?>

	    $(document).ready(function() {
	    <?php if ($_GET['s'] == '') {?>
		var get_from = <?php if ($_smarty_tpl->tpl_vars['internal_messaging']->value == 1) {?>'message-menu-entry2'<?php } elseif ($_smarty_tpl->tpl_vars['internal_messaging']->value == 0 && ($_smarty_tpl->tpl_vars['user_friends']->value == 1 || $_smarty_tpl->tpl_vars['user_blocking']->value == 1)) {?>'message-menu-entry7'<?php } else { ?>'message-menu-entry3'<?php }?>;
		<?php if ($_smarty_tpl->tpl_vars['menu_section']->value != '') {?>
		    get_from = "<?php echo $_smarty_tpl->tpl_vars['menu_section']->value;?>
";
		<?php }?>
		$("#"+get_from).addClass("menu-panel-entry-active");

		<?php if ($_GET['src'] == 'upage' && $_GET['mid'] != '' && $_SESSION['channel_msg'] != '') {?>
		    var compose_url = current_url+menu_section+"?do=compose&src=upage";
                    var h2_c_title  = $("#compose-button>span").text();
                    wrapLoad(compose_url, fe_mask);
		<?php } else { ?>
		    wrapLoad(current_url+menu_section+"?s="+get_from);
		<?php }?>
	    <?php } else { ?>
	    <?php }?>

		function label_del(del_id, del_url, m_url) {
		    var del_answer = confirm("<?php echo smarty_function_lang_entry(array('key'=>"notif.confirm.delete.label"),$_smarty_tpl);?>
");
		    if (del_answer){
		    	$("#ct-wrapper").mask(" ");
    			$.post(del_url, $("#label-form-"+del_id).serialize(), function( data ) {
    				if (data > 0) {
    					$("#label-form-"+del_id).detach();
    					$("#"+get_from).addClass("menu-panel-entry-active");
    					$("#"+get_from+" > a:first").addClass("dcjq-parent active");
    					
    					wrapLoad(current_url+menu_section+"?s="+get_from);
    				}
    			});
    			return false;
		    }
		    return false;
		}

		$(".label-del").bind("click", function(){
		    var del_id = $(this).attr("id");
		    var del_ar = del_id.split("-");
		    var m_section = del_ar[0]+"-"+del_ar[1]+"-"+del_ar[2];
		    var m_url = current_url+ menu_section + "?s="+m_section;
		    var del_url = m_url+"&do=delete_label"+paging_link;

		    label_del(del_id, del_url, m_url);
		});

		$(document).on("click", "#compose-button", function() {
		    var compose_url = current_url+menu_section+"?do=compose";
//		    var h2_c_title  = $("#compose-button>span").text();
//		    $("h2").text(h2_c_title);
		    wrapLoad(compose_url, fe_mask);
		});
	    });
	<?php echo '</script'; ?>
>
<?php }
}

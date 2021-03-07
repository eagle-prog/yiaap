<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:32:25
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_files_edit.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8c5968ca03_08224269',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09d52db54924d616fa68ce0e465ffeaab82f377b' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_files_edit.tpl',
      1 => 1478210400,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601e8c5968ca03_08224269 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<?php ob_start();
echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable1);
$_smarty_tpl->assign('menu_entry' , insert_currentMenuEntry (array('for' => $_GET['s']),$_smarty_tpl), true);
$_smarty_tpl->assign("count1" , insert_fileCount (array('for' => "file-menu-entry1"),$_smarty_tpl), true);
$_smarty_tpl->assign("count2" , insert_fileCount (array('for' => "file-menu-entry2"),$_smarty_tpl), true);
$_smarty_tpl->assign("count3" , insert_fileCount (array('for' => "file-menu-entry3"),$_smarty_tpl), true);
$_smarty_tpl->assign("count4" , insert_fileCount (array('for' => "file-menu-entry4"),$_smarty_tpl), true);
$_smarty_tpl->assign("count5" , insert_fileCount (array('for' => "file-menu-entry5"),$_smarty_tpl), true);?>
	<?php echo '<script'; ?>
 type="text/javascript">
            var current_url  = '<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';
            var menu_section = '<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
';
            var fe_mask      = 'on';
        <?php echo '</script'; ?>
>

        <div id="edit-wrapper">
            <?php echo smarty_function_generate_html(array('type'=>"files_edit_layout",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'section'=>"files",'bb'=>"1"),$_smarty_tpl);?>

        </div>
	<?php echo '<script'; ?>
 type="text/javascript">
        $(document).ready(function () {
        	$(".save-entry-button").click(function() {
        		var t = $(this);
        		var form = $(".entry-form-class").serialize();
        		var upd_url = window.location.href;
        		
        		if (typeof($("#blog-edit").html()) != "undefined") {
        			form += "&blog_html="+encodeURIComponent($("#blog-edit").html());
        		}
        		
        		$(".content-current").mask(" ");
        		t.removeClass("new-entry").addClass("new-entry-loading");
        		
        		$.post(upd_url, form, function(data) {
        			$(".content-current").unmask();
        			t.addClass("new-entry").removeClass("new-entry-loading");
        			$("#submit-response").html(data).find("#cb-response").css("padding-top", "10px");
        		});
        	});
        	
                $('.icheck-box input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                //insert: '<div class="icheck_line-icon"></div><label>' + label_text + '</label>'
                        });
                });
//                $('.icheck-box input').on('ifChecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', true); });
//                $('.icheck-box input').on('ifUnchecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', false); });
        });
	<?php echo '</script'; ?>
>
<?php }
}

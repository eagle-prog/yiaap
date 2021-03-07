<?php
/* Smarty version 3.1.33, created on 2021-02-06 07:40:07
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub9.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601e8e27bbd646_17612001',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6bbddb830f933338e8ca0d082c03a95a9abdd492' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub9.tpl',
      1 => 1554340920,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-keep-open.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-actions-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
  ),
),false)) {
function content_601e8e27bbd646_17612001 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.fetch.php','function'=>'smarty_function_fetch',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/codemirror/lib/codemirror.css">
	<div class="wdmax" id="ct-wrapper">
	<form id="ct-set-form" action="">
            <div class="wdmax left-float top-bottom-padding">
                <div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                <div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
            </div>
            <div class="clearfix"></div>

            <div class="vs-mask"><?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"email_templates",'entry_title'=>"backend.menu.entry2.sub9.mail.tpl",'entry_id'=>"ct-entry-details1",'input_name'=>'','input_value'=>'','bb'=>1),$_smarty_tpl);?>
</div>
            <div class="vs-mask"><?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"footer_templates",'entry_title'=>"backend.menu.entry2.sub9.footer.tpl",'entry_id'=>"ct-entry-details2",'input_name'=>'','input_value'=>'','bb'=>0),$_smarty_tpl);?>
</div>

            <div class="clearfix"></div>
	    <div class="wdmax top-bottom-padding left-float">
                <div class="sortings left-half"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?></div>
                <div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-keep-open.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
            </div>
            <div class="popupbox-mem" id="popuprel-cb"></div><div id="fade-cb" class="fade"></div>
            <input type="hidden" name="file_entry" id="file_entry" value="" />
            <input type="hidden" name="file_tpl" id="file_tpl" value="" />
        </form>
        </div>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-switch-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-actions-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript"><?php echo smarty_function_fetch(array('file'=>"f_scripts/shared/codemirror/lib/codemirror.min.js"),$_smarty_tpl);
echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript"><?php echo smarty_function_fetch(array('file'=>"f_scripts/shared/codemirror/mode/xml/xml.js"),$_smarty_tpl);
echo '</script'; ?>
>

        <?php echo '<script'; ?>
 type="text/javascript">
        var main_url = "<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
";
        $(document).ready(function(){
        $(document).on("click", ".tpl-save", function() {
    	    $(".fancybox-inner").mask("");
    	    myCodeMirror.save();
    	    
    	    $.post(current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=tpl-save", $("#ct-set-form").serialize()+'&'+$.param({ 'tpl_page_code': $("#tpl-page-code").val() }), function(data){
    		$("#tpl-save-update").html(data);
    		$(".fancybox-inner").unmask();
    	    });
        });
        $("a.popup").click(function(){
    	    var popupid = "popuprel-cb";
    	    var fid = "-cb";
    	    var filekey = $(this).attr("id");
    	    var etype = $(this).attr("rel-type");

	    $("#file_entry").val(filekey);
	    $("#file_tpl").val(etype);

		$.fancybox.open({type: 'ajax', minWidth: "75%", margin: 10, href: current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do="+etype+"&p="+filekey });
    	});
    	$(document).keyup(function(e){
    	    if(e.keyCode == 27){$(".popup-cancel").click();}
    	});
        });
        <?php echo '</script'; ?>
>
<?php }
}

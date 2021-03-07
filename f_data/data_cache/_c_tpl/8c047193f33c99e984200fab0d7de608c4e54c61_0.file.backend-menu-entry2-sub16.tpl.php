<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:56:13
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub16.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d94cd407fa2_18993828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8c047193f33c99e984200fab0d7de608c4e54c61' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub16.tpl',
      1 => 1554340860,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-cancel-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-actions-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
  ),
),false)) {
function content_601d94cd407fa2_18993828 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.fetch.php','function'=>'smarty_function_fetch',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['scripts_url']->value;?>
/shared/codemirror/lib/codemirror.css">
	<div class="wdmax entry-list" id="ct-wrapper">
            <div class="section-top-bar<?php if ($_GET['do'] == "add") {?>-add<?php } else { ?> vs-maskx<?php }?> left-float top-bottom-padding">
                <div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-cancel-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                <div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            
            <div class="vs-mask"><?php echo smarty_function_generate_html(array('type'=>"lang_types",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'bb'=>1),$_smarty_tpl);?>
</div>
            
            <?php if ($_GET['do'] == "add") {?>
            <div class="clearfix"></div>
            <div class="section-bottom-bar<?php if ($_GET['do'] == "add") {?>-add<?php } else { ?> vs-maskx<?php }?> left-float top-bottom-padding">
                <div class="clearfix"></div>
                <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
$_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-cancel-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
            </div>
            <?php }?>
	    <form id="lang-set-form" action="" method="post">
		<div class="popupbox-mem" id="popuprel-cb"></div><div id="fade-cb" class="fade"></div>
        	<input type="hidden" name="file_tpl" id="file_tpl" value="" />
        	<input type="hidden" name="file_entry" id="file_entry" value="" />
        	<input type="hidden" name="lang_id" id="file_id" value="" />
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
        $(document).unbind().on("click", ".tpl-save", function() {
            $(".fancybox-inner").mask("");
            myCodeMirror.save();

            $.post(current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=tpl-save", $("#lang-set-form").serialize()+'&'+$.param({ 'tpl_page_code': $("#tpl-page-code").val() }), function(data){
                $("#tpl-save-update").html(data);
                $(".fancybox-inner").unmask();
            });
        });
        $("a.popup").click(function(){
            var popupid = "popuprel-cb";
            var fid = "-cb";
            var filekey = $(this).attr("id");
            var etype = $(this).attr("rel-type");
            var langid = $(this).attr("rel-id");

            $("#file_entry").val(filekey);
            $("#file_tpl").val("lang-"+etype);
            $("#file_id").val(langid);

            thisresizeDelimiter();
            $.fancybox.open({type: 'ajax', minWidth: "75%", margin: 10, href: current_url + menu_section + "?s=<?php echo smarty_modifier_sanitize($_GET['s']);?>
&do=lang-"+etype+"&f="+langid+"&p="+filekey });
        });
        });
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
        $(document).ready(function () {
                $('.icheck-box input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        });
                });
                $('.icheck-box input').on('ifChecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', true); });
                $('.icheck-box input').on('ifUnchecked', function(event){ var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', false); });
                
                $("#entry-action-buttons .dl-trigger").on("click", function(){
        		if ($("#entry-action-buttons ul.dl-menu").hasClass("dl-menuopen")) {
                            setTimeout(function () {
                                    $("#choices-ipp_select").slideUp(300, function(){$('#ct-wrapper').unbind('click', bodyHideSelect);});
                            }, 100);
                        }
		});
		
		
		
           $(document).on({click: function () {
                var _id = "";
                if ($(".fancybox-wrap").width() > 0) {
                        _id = ".fancybox-inner ";
                }

                $(_id + ".responsive-accordion div.responsive-accordion-head").addClass("active");
                $(_id + ".responsive-accordion div.responsive-accordion-panel").addClass("active").show();
                $(_id + ".responsive-accordion i.responsive-accordion-plus").hide();
                $(_id + ".responsive-accordion i.responsive-accordion-minus").show();
                thisresizeDelimiter();
            }}, "#all-open");

            $(document).on({click: function () {
                var _id = "";
                if ($(".fancybox-wrap").width() > 0) {
                        _id = ".fancybox-inner ";
                }

                $(_id + ".responsive-accordion div.responsive-accordion-head").removeClass("active");
                $(_id + ".responsive-accordion div.responsive-accordion-panel").removeClass("active").hide();
                $(_id + ".responsive-accordion i.responsive-accordion-plus").show();
                $(_id + ".responsive-accordion i.responsive-accordion-minus").hide();
                $("#ct_entry").val("");
                thisresizeDelimiter();
            }}, "#all-close");



        });
        <?php echo '</script'; ?>
><?php }
}

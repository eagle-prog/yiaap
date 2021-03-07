<?php
/* Smarty version 3.1.33, created on 2021-02-05 13:53:47
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub23.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601d943b83bb04_65422245',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd6f1d779a16a87ffc1216c0593dfcb6666145f3b' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub23.tpl',
      1 => 1585163905,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 2,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-keep-open.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
  ),
),false)) {
function content_601d943b83bb04_65422245 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div>
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"switch",'entry_title'=>"backend.menu.live.vod",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_live_vod",'input_value'=>$_smarty_tpl->tpl_vars['live_vod']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"text",'entry_title'=>"backend.menu.live.del",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_live_del",'input_value'=>$_smarty_tpl->tpl_vars['live_del']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"switch",'entry_title'=>"backend.menu.live.token",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_live_token",'input_value'=>$_smarty_tpl->tpl_vars['user_tokens']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"switch",'entry_title'=>"backend.menu.live.chat",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_live_chat",'input_value'=>$_smarty_tpl->tpl_vars['live_chat']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"text",'entry_title'=>"backend.menu.live.chat.salt",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_live_chat_salt",'input_value'=>$_smarty_tpl->tpl_vars['live_chat_salt']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"text",'entry_title'=>"backend.menu.live.cron.salt",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_live_cron_salt",'input_value'=>$_smarty_tpl->tpl_vars['live_cron_salt']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="clearfix"></div>
	    <div>
		<div class="sortings left-half"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-keep-open.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-switch-js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php echo '<script'; ?>
 type="text/javascript"><?php $_smarty_tpl->_subTemplateRender("file:f_scripts/be/js/settings-accordion.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
	$(function(){SelectList.init("backend_menu_af_p_currency");SelectList.init("backend_menu_af_requirements_type");});
        $(document).ready(function () {
        	$("input[name=backend_menu_af_p_figure]").keyup(function(){
        		t = $(this);
        		v = $("input[name=backend_menu_af_p_share]").val();
        		v = (v < 1 ? 1 : (v > 100 ? 100 : v));
        		$("#s-pf").text(v);
        		tp = parseFloat($("input[name='backend_menu_af_p_figure']").val());
        		r = Math.round(v * tp) / 100;
        		$("#s-pc-off").text(r);
        	});
        	$("input[name=backend_menu_af_p_units]").keyup(function(){
        		$("#s-pv").text($(this).val());
        	});
        	$("input[name=backend_menu_af_p_share]").keyup(function(){
        		t = $(this);
        		v = t.val();
        		v = (v < 1 ? 1 : (v > 100 ? 100 : v));
        		$("#s-pc").text(v);
        		tp = parseFloat($("input[name='backend_menu_af_p_figure']").val());
        		r = Math.round(v * tp) / 100;
        		$("#s-pc-off").text(r);
        		t.val(v);
        	});
        	$("select[name=backend_menu_af_p_currency]").change(function(){
        		$("#s-cr").text($(this).val());
        	});
                $('.icheck-box input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        });
                });
        });
        <?php echo '</script'; ?>
>
<?php }
}

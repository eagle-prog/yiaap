<?php
/* Smarty version 3.1.33, created on 2021-02-19 11:55:52
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602fa748611b00_92011879',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '12813496bef5d7e0b1e2367f40a5396afb4820a4' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/backend-menu-entry2-sub1.tpl',
      1 => 1613735735,
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
function content_602fa748611b00_92011879 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div>
		<div class="sortings"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub4.shortname",'entry_id'=>"ct-entry-details4",'input_name'=>"backend_menu_entry2_sub4_shortname",'input_value'=>$_smarty_tpl->tpl_vars['website_shortname']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.headtitle",'entry_id'=>"ct-entry-details1",'input_name'=>"backend_menu_entry2_sub1_headtitle",'input_value'=>$_smarty_tpl->tpl_vars['head_title']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"textarea",'entry_title'=>"backend.menu.entry2.sub1.metadesc",'entry_id'=>"ct-entry-details2",'input_name'=>"backend_menu_entry2_sub1_metadesc",'input_value'=>$_smarty_tpl->tpl_vars['metaname_description']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"textarea",'entry_title'=>"backend.menu.entry2.sub1.metakeywords",'entry_id'=>"ct-entry-details3",'input_name'=>"backend_menu_entry2_sub1_metakeywords",'input_value'=>$_smarty_tpl->tpl_vars['metaname_keywords']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.google.an",'entry_id'=>"ct-entry-details5",'input_name'=>"backend_menu_entry2_sub1_google_an",'input_value'=>$_smarty_tpl->tpl_vars['google_analytics']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet9",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.google.an.api",'entry_id'=>"ct-entry-details9",'input_name'=>"backend_menu_entry2_sub1_google_an_api",'input_value'=>$_smarty_tpl->tpl_vars['google_analytics_api']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet13",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.google.an.view",'entry_id'=>"ct-entry-details13",'input_name'=>"backend_menu_entry2_sub1_google_an_view",'input_value'=>$_smarty_tpl->tpl_vars['google_analytics_view']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet14",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.google.an.maps",'entry_id'=>"ct-entry-details14",'input_name'=>"backend_menu_entry2_sub1_google_an_maps",'input_value'=>$_smarty_tpl->tpl_vars['google_analytics_maps']->value,'bb'=>1),$_smarty_tpl);?>

	    </div>
	    <div class="vs-column half fit vs-mask">
	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.google.web",'entry_id'=>"ct-entry-details6",'input_name'=>"backend_menu_entry2_sub1_google_web",'input_value'=>$_smarty_tpl->tpl_vars['google_webmaster']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet14",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.tagline",'entry_id'=>"ct-entry-details14",'input_name'=>"backend_menu_entry2_sub1_tagline",'input_value'=>$_smarty_tpl->tpl_vars['custom_tagline']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet7",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.yahoo",'entry_id'=>"ct-entry-details7",'input_name'=>"backend_menu_entry2_sub1_yahoo",'input_value'=>$_smarty_tpl->tpl_vars['yahoo_explorer']->value,'bb'=>1),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet8",'input_type'=>"text",'entry_title'=>"backend.menu.entry2.sub1.bing",'entry_id'=>"ct-entry-details8",'input_name'=>"backend_menu_entry2_sub1_bing",'input_value'=>$_smarty_tpl->tpl_vars['bing_validate']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet13",'input_type'=>"social_media_links",'entry_title'=>"backend.menu.entry2.sub1.sm.links",'entry_id'=>"ct-entry-details13",'input_name'=>"backend_menu_entry2_sub1_sm_links",'input_value'=>$_smarty_tpl->tpl_vars['social_media_links']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet23",'input_type'=>"site_alert",'entry_title'=>"backend.menu.entry2.sub1.alert",'entry_id'=>"ct-entry-details23",'input_name'=>'','input_value'=>$_smarty_tpl->tpl_vars['alert_description']->value,'bb'=>0),$_smarty_tpl);?>

	    <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet24",'input_type'=>"dynamic_menu",'entry_title'=>"backend.menu.entry2.sub1.dynamic.menu",'entry_id'=>"ct-entry-details24",'input_name'=>"backend_menu_entry2_sub1_dynamic_menu",'input_value'=>$_smarty_tpl->tpl_vars['dynamic_menu']->value,'bb'=>0),$_smarty_tpl);?>

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
 type="text/javascript">$(document).ready(function(){$("a.sml-add").click(function(){lid=document.getElementById("url-entry-details-list").childElementCount;lid+=1;nht=sm_ht.replace(/#NR#/g,lid).replace(/#V1#/g, '').replace(/#V2#/g, '').replace(/#V3#/g, '');$("#url-entry-details-list").append(nht);}); $("a.dml-add").click(function(){lid=document.getElementById("url-entry-menu-list").childElementCount;lid+=1;nht=dm_ht.replace(/#NR#/g,lid).replace(/#V1#/g, '').replace(/#V2#/g, '').replace(/#V3#/g, '');$("#url-entry-menu-list").append(nht);});});<?php echo '</script'; ?>
>
<?php }
}

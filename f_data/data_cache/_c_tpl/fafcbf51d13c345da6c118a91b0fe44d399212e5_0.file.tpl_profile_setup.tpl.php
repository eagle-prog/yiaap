<?php
/* Smarty version 3.1.33, created on 2021-02-24 03:34:31
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_profile_setup.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6035c947b05726_14719075',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fafcbf51d13c345da6c118a91b0fe44d399212e5' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_acct/tpl_profile_setup.tpl',
      1 => 1541455200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_settings/ct-save-top.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-save-open-close.tpl' => 1,
    'file:tpl_backend/tpl_settings/ct-switch-js.tpl' => 1,
    'file:f_scripts/be/js/settings-accordion.js' => 1,
    'file:tpl_frontend/tpl_acct/tpl_profilejs.tpl' => 1,
  ),
),false)) {
function content_6035c947b05726_14719075 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),));
?>
    <div id="ct-wrapper">
        <form id="ct-set-form" action="" method="post">
        	<article>
                	<h3 class="content-title"><i class="icon-profile"></i><?php echo smarty_function_lang_entry(array('key'=>"account.entry.profile.setup"),$_smarty_tpl);?>
</h3>
                	<div class="line"></div>
        	</article>

            <div>
		<div class="sortings"><div class="no-display"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div></div>
		<div class="page-actions"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_settings/ct-save-open-close.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
	    </div>
	    <div class="clearfix"></div>
            <div class="vs-column half">
                <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet1",'input_type'=>"profile_about",'entry_title'=>"account.profile.about.displayname",'entry_id'=>"ct-entry-details1",'input_name'=>'','input_value'=>'','bb'=>1,'section'=>"fe"),$_smarty_tpl);?>

                <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet2",'input_type'=>"profile_details",'entry_title'=>"account.profile.personal",'entry_id'=>"ct-entry-details2",'input_name'=>'','input_value'=>'','bb'=>1,'section'=>"fe"),$_smarty_tpl);?>

                <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet3",'input_type'=>"profile_location",'entry_title'=>"account.profile.location",'entry_id'=>"ct-entry-details3",'input_name'=>'','input_value'=>'','bb'=>1,'section'=>"fe"),$_smarty_tpl);?>

            </div>
            <div class="vs-column half fit">
                <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet4",'input_type'=>"profile_job",'entry_title'=>"account.profile.job",'entry_id'=>"ct-entry-details4",'input_name'=>'','input_value'=>'','bb'=>1,'section'=>"fe"),$_smarty_tpl);?>

                <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet5",'input_type'=>"profile_education",'entry_title'=>"account.profile.education",'entry_id'=>"ct-entry-details5",'input_name'=>'','input_value'=>'','bb'=>1,'section'=>"fe"),$_smarty_tpl);?>

                <?php echo smarty_function_generate_html(array('bullet_id'=>"ct-bullet6",'input_type'=>"profile_interests",'entry_title'=>"account.profile.interests",'entry_id'=>"ct-entry-details6",'input_name'=>'','input_value'=>'','bb'=>0,'section'=>"fe"),$_smarty_tpl);?>

            </div>
            <div class="clearfix"></div>

            <input type="hidden" name="ct_entry" id="ct_entry" value="">
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
    	<?php $_smarty_tpl->_subTemplateRender("file:tpl_frontend/tpl_acct/tpl_profilejs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        $(function() {
                SelectList.init("account_profile_bdate_m_sel");
                SelectList.init("account_profile_bdate_d_sel");
                SelectList.init("account_profile_bdate_y_sel");
                SelectList.init("account_profile_personal_gender_sel");
                SelectList.init("account_profile_personal_rel_sel");
                SelectList.init("account_profile_personal_age_sel");
                SelectList.init("account_profile_location_country_sel");
        });

    <?php echo '</script'; ?>
>
<?php }
}

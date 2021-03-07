<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6689bc76_88040677',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c3e554909f7fc6fb11abd259a8939da90df4bb9' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_menupanel.tpl',
      1 => 1578358951,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_menupanel_affiliate.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_subscriber.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_token.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_live_categ.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_affiliate_conf.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_live_conf.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_import_conf.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_live.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_live_manage.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_live_manage_categ.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_import.tpl' => 1,
    'file:tpl_backend/tpl_menupanel_cdn.tpl' => 1,
    'file:tpl_backend/tpl_headernav_pop.tpl' => 1,
  ),
),false)) {
function content_601c2f6689bc76_88040677 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
                <ul id="gn-menu" class="gn-menu-main">
                    <li class="gn-trigger">
                        <a class="gn-icon gn-icon-menu gn-selected"><span>Menu</span></a>
                        <a class="logo" href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
"></a>

                        <nav class="gn-menu-wrapper">
                            <div class="blue categories-container">
                                <ul class="accordion" id="categories-accordion">

                                    <li class="gn-search-item">
                                        <input placeholder="Search" type="search" class="gn-search">
                                        <a class="gn-icon gn-icon-search"><span>Search</span></a>
                                    </li>
                                    
                                    <li>
                                        <a href="javascript:;"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_dashboard" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_analytics") {?> class="active"<?php }?>><i class="iconBe-pie"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.dash"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_dashboard"),$_smarty_tpl);?>
"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_dashboard") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i>Home</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_analytics"),$_smarty_tpl);?>
"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_analytics") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i>Analytics</a></li>
                                        </ul>
                                    </li>
                                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_affiliate.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_subscriber.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_token.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                    <li><a href="javascript:;"><i class="iconBe-key"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ac"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub6" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ac.admin"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub4" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ac.front"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub8" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.ac.guest"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="javascript:;"><i class="iconBe-cogs"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.metadata"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub7" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.modules"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub5" class="menu-panel-entry-sub be-panel sub_menu" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.categories"),$_smarty_tpl);?>
</a>
                                                    <ul>
                                                        <li><a href="javascript:;" id="backend-menu-entry2-sub5v" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "v") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.v"),$_smarty_tpl);?>
</a></li>
                                                        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_live_categ.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                                        <li><a href="javascript:;" id="backend-menu-entry2-sub5i" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "i") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.i"),$_smarty_tpl);?>
</a></li>
                                                        <li><a href="javascript:;" id="backend-menu-entry2-sub5a" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "a") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.a"),$_smarty_tpl);?>
</a></li>
                                                        <li><a href="javascript:;" id="backend-menu-entry2-sub5d" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "d") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.d"),$_smarty_tpl);?>
</a></li>
                                                        <li><a href="javascript:;" id="backend-menu-entry2-sub5b" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "b") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.b"),$_smarty_tpl);?>
</a></li>
                                                        <li><a href="javascript:;" id="backend-menu-entry2-sub5c" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "c") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.c"),$_smarty_tpl);?>
</a></li>
                                                    </ul>
                                            </li>
                                            <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_affiliate_conf.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                            <li><a href="javascript:;" id="backend-menu-entry4-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_members"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.paid"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub24" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.ond"),$_smarty_tpl);?>
</a></li>
                                            <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_live_conf.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub12" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.upload"),$_smarty_tpl);?>
</a></li>
                                            <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_import_conf.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub13" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.file"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub18" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.signin"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub17" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.signup"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub19" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.recovery"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub20" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.captcha"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub15" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.messaging"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry5-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_members"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.channels"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub3" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.sitemap"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub16" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.lang"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub9" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sc.static"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="javascript:;"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members" && $_GET['u'] != '') {?> class="active"<?php }?>><i class="iconBe-users"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.am"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" id="backend-menu-entry10-sub2" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_members" && $_GET['u'] != '') {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_members"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.am.users"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry4-sub4" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_members"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.sub.types"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry4-sub2" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_members"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.am.types"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry4-sub3" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_members"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.am.codes"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>

                                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_live.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                                    <li><a href="javascript:;"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'] != '') {?> class="active"<?php }?>><i class="icon-video"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" id="backend-menu-entry6-sub1" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "v") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.v"),$_smarty_tpl);?>
</a></li>
                                    	    <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_live_manage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                            <li><a href="javascript:;" id="backend-menu-entry6-sub2" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "i") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.i"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry6-sub3" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "a") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.a"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry6-sub4" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "d") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.d"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry6-sub5" class="menu-panel-entry-sub be-panel<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_files" && $_GET['u'][0] == "b") {?> active<?php }?>" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_files"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.b"),$_smarty_tpl);?>
</a></li>

                                            <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ"),$_smarty_tpl);?>
</a>
                                                <ul>
                                                    <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.v"),$_smarty_tpl);?>
</a>
                                                        <?php echo insert_beFileCategories(array('type' => "video"),$_smarty_tpl);?>
                                                    </li>
                                                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_live_manage_categ.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                                    <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.i"),$_smarty_tpl);?>
</a>
                                                        <?php echo insert_beFileCategories(array('type' => "image"),$_smarty_tpl);?>
                                                    </li>

                                                    <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.a"),$_smarty_tpl);?>
</a>
                                                        <?php echo insert_beFileCategories(array('type' => "audio"),$_smarty_tpl);?>
                                                    </li>

                                                    <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.d"),$_smarty_tpl);?>
</a>
                                                        <?php echo insert_beFileCategories(array('type' => "doc"),$_smarty_tpl);?>
                                                    </li>

                                                    <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fm.categ.b"),$_smarty_tpl);?>
</a>
                                                        <?php echo insert_beFileCategories(array('type' => "blog"),$_smarty_tpl);?>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <li><a href="javascript:;"<?php if (($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_upload" && $_GET['t'] != '') || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_import") {?> class="active"<?php }?>><i class="iconBe-upload"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fu"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_upload"),$_smarty_tpl);?>
?t=video"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_upload" && $_GET['t'] == "video") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fu.v"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_upload"),$_smarty_tpl);?>
?t=image"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_upload" && $_GET['t'] == "image") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fu.i"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_upload"),$_smarty_tpl);?>
?t=audio"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_upload" && $_GET['t'] == "audio") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fu.a"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['backend_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_upload"),$_smarty_tpl);?>
?t=document"<?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_upload" && $_GET['t'] == "document") {?> class="active"<?php }?>><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.fu.d"),$_smarty_tpl);?>
</a></li>
                                            <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_import.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                                        </ul>
                                    </li>
                                    
                                    <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_menupanel_cdn.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                                    <li><a href="javascript:;"><i class="iconBe-coin"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.adv"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.adv.player"),$_smarty_tpl);?>
</a>
                                            	<ul>
                                            		<li><a href="javascript:;" id="backend-menu-entry8-sub4" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.18"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry8-sub2" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.16"),$_smarty_tpl);?>
</a></li>
                                            	</ul>
                                            </li>
                                            <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.adv.banner"),$_smarty_tpl);?>
</a>
                                            	<ul>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.1"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub14" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.14"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub15" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.19"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub3" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.3"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub4" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.4"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub2" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.2"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub13" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.13"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub5" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.5"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub7" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.7"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub8" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.8"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub9" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.9"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub10" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.10"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry7-sub12" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.12"),$_smarty_tpl);?>
</a></li>
                                            	</ul>
                                            </li>
                                            <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.adv.group"),$_smarty_tpl);?>
</a>
                                            	<ul>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.1"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub14" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.14"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub15" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.19"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub3" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.3"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub4" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.4"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub2" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.2"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub13" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.13"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub5" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.5"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub7" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.7"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub8" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.8"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub9" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.9"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub10" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.10"),$_smarty_tpl);?>
</a></li>
                                            		<li><a href="javascript:;" id="backend-menu-entry9-sub12" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_advertising"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.adv.sub.12"),$_smarty_tpl);?>
</a></li>
                                            	</ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript:;"><i class="iconBe-play"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.pc"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" class="sub_menu"><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.pc.vjs"),$_smarty_tpl);?>
</a>
                                                <ul>
                                                    <li><a href="javascript:;" id="backend-menu-entry11-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_players"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i>Hosted</a></li>
                                                    <li><a href="javascript:;" id="backend-menu-entry11-sub2" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_players"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i>Embedded</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <li><a href="javascript:;"><i class="iconBe-equalizer"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.es"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub2" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.es.v"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub6" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.es.i"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub3" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.es.a"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub4" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.es.d"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub20" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.es.mp4"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub23" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.es.mob"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="javascript:;"><i class="iconBe-steam"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st"),$_smarty_tpl);?>
</a>
                                        <ul>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub1" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st.mail"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub5" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st.ban"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry2-sub11" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st.act"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub12" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st.sess"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub18" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st.time"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub9" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st.sysinfo"),$_smarty_tpl);?>
</a></li>
                                            <li><a href="javascript:;" id="backend-menu-entry3-sub7" class="menu-panel-entry-sub be-panel" rel-m="<?php echo smarty_function_href_entry(array('key'=>"be_settings"),$_smarty_tpl);?>
"><i class="iconBe-arrow-right in-menu"></i><?php echo smarty_function_lang_entry(array('key'=>"backend.menu.st.phpinfo"),$_smarty_tpl);?>
</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </li>
                    <div class="reenforce">

                    <div style="display:block" id="top_actions" class="no-session-off">
                    	<li class="main profile_holder">
                    		<div class="user-thumb-xlarge top">
                    		<span class="own-profile-image mt no-display"></span>
                    		<span class="no-session-icon" onclick="$('.own-profile-image.mt').click();"><i class="mt-open"></i></span>

                    		<div class="arrow_box blue hidden" id="user-arrow-box"><?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_headernav_pop.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
                    		</div>
                    	</li>
                        <li class="main profile_holder no-display">
                            <div class="profile_details">
                                <div class="profile_image" onclick="$(this).next().click();">
                                    <i class="icon-switch"></i>
                                </div>
                                <div class="profile_name" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['backend_access_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"be_signout"),$_smarty_tpl);?>
'"><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.signout"),$_smarty_tpl);?>
</div>
                            </div>
                            <section class="buttonset" style="display:none;">
                                <button id="showLeftPush" style="display:none">Show/Hide Left Push Menu</button>
                                <button id="showBottom" class="gn-icon gn-icon-menu"><span>Menu</span></button>
                            </section>

                        </li>
                        <li class="main messages_holder">
                            <div class="head_but messages">
                                <i class="icon-notification"></i>
                                <div class="items_count item_inactive"><span id="new-notifications-nr"><span></div>
                            </div>
                        </li>
                    </div>
                    </div>
                </ul>
<?php }
}

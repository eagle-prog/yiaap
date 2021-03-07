<?php
/* Smarty version 3.1.33, created on 2021-02-11 18:29:59
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6025bdf77e69f9_16245839',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '60371c77580525568fa14c8870c33d1ff2b85ca1' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliate.tpl',
      1 => 1516140000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_affiliate/tpl_analytics.tpl' => 1,
    'file:tpl_backend/tpl_affiliate/tpl_maps.tpl' => 1,
    'file:tpl_backend/tpl_affiliate/tpl_bars.tpl' => 1,
    'file:tpl_backend/tpl_affiliate/tpl_reports.tpl' => 1,
  ),
),false)) {
function content_6025bdf77e69f9_16245839 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container cbp-spmenu-push">
<?php if ($_GET['a'] != '') {?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_affiliate/tpl_analytics.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_GET['g'] != '') {?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_affiliate/tpl_maps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_GET['o'] != '') {?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_affiliate/tpl_bars.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_GET['rp'] != '') {?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_affiliate/tpl_reports.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
</div><?php }
}

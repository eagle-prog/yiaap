<?php
/* Smarty version 3.1.33, created on 2021-02-19 11:56:07
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_602fa757dd0e73_48415290',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '883a7b653b2dbe90dca0f67a1fa3266cd8f321ed' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_leftnav/tpl_nav_main.tpl',
      1 => 1613735408,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_602fa757dd0e73_48415290 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="blue categories-container 12345">
    <h4 class="nav-title categories-menu-title left-menu-h4"><i class="icon-eye"></i> <?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
</h4>    
    <aside>
        <nav>            
            <ul class="accordion" id="<?php if ($_SESSION['USER_ID'] == '') {?>no-session-accordion2<?php } else { ?>session-accordion<?php }?>">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menus']->value, 'menu', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['menu']->value) {
?>
                    <li class=""><a class="dcjq-parent" href="<?php echo $_smarty_tpl->tpl_vars['menus']->value[$_smarty_tpl->tpl_vars['i']->value]['url'];?>
"><i class="<?php echo $_smarty_tpl->tpl_vars['menus']->value[$_smarty_tpl->tpl_vars['i']->value]['icon'];?>
"></i><?php echo $_smarty_tpl->tpl_vars['menus']->value[$_smarty_tpl->tpl_vars['i']->value]['title'];?>
</a></li>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
            <div class="clearfix"></div>
        </nav>
    </aside>
</div>
<?php }
}

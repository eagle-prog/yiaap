<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:33:48
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-keep-open.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2ffcb69a18_27742279',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '73b63565a7eda032d42f6c6aea48d2d9c9d71a46' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_settings/ct-keep-open.tpl',
      1 => 1543960800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2ffcb69a18_27742279 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
		<div class="right-float right-padding10 font12" style="float: right;">
			<label><?php echo smarty_function_lang_entry(array('key'=>"frontend.global.always.open"),$_smarty_tpl);?>
</label>
			<span class="icheck-box-all"><input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['keep_entries_open']->value == "1") {?>checked="checked"<?php }?> name="keep_open" id="keep-open" value="1" /></span>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
		$('.icheck-box-all input').each(function () {
                        var self = $(this);
                        self.iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        });
                        $('input#keep-open').on('ifChecked', function(event) { $("#all-open").click(); });
                        $('input#keep-open').on('ifUnchecked', function(event) { $("#all-close").click(); });
                });
                <?php echo '</script'; ?>
>
<?php }
}

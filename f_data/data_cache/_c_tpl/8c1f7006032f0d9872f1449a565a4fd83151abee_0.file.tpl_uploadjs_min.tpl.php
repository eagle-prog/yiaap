<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:40:09
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_uploadjs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c3179465456_32471280',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8c1f7006032f0d9872f1449a565a4fd83151abee' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_uploadjs_min.tpl',
      1 => 1541455200,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl_backend/tpl_uploadjs.tpl' => 1,
  ),
),false)) {
function content_601c3179465456_32471280 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),));
?>
	<?php echo '<script'; ?>
 type="text/javascript">var upload_lang = new Array();upload_lang["h1"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.h1.select"),$_smarty_tpl);?>
';upload_lang["h2"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.h2.select"),$_smarty_tpl);?>
';upload_lang["category"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.categ"),$_smarty_tpl);?>
';upload_lang["username"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.user"),$_smarty_tpl);?>
';upload_lang["assign"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.assign.tip"),$_smarty_tpl);?>
';upload_lang["tip"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.categ.tip"),$_smarty_tpl);?>
';upload_lang["utip"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.user.tip"),$_smarty_tpl);?>
';upload_lang["filename"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.filename"),$_smarty_tpl);?>
';upload_lang["size"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.size"),$_smarty_tpl);?>
';upload_lang["status"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.status"),$_smarty_tpl);?>
';upload_lang["drag"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.drag"),$_smarty_tpl);?>
';upload_lang["select"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.select"),$_smarty_tpl);?>
';upload_lang["start"] = '<?php echo smarty_function_lang_entry(array('key'=>"upload.text.btn.start"),$_smarty_tpl);?>
';<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/uploader/plupload.full.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/uploader/jquery.plupload.queue/jquery.plupload.queue.min.js"><?php echo '</script'; ?>
>
	<?php $_smarty_tpl->_subTemplateRender("file:tpl_backend/tpl_uploadjs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

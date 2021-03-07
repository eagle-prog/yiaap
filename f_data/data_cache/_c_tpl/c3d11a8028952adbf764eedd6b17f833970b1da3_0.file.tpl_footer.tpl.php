<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:02
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f56b81719_52999978',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3d11a8028952adbf764eedd6b17f833970b1da3' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_footer.tpl',
      1 => 1565281064,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f56b81719_52999978 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.lang_entry.php','function'=>'smarty_function_lang_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
        <footer class="<?php if ($_SESSION['sbm'] == 1) {?>with-menu<?php }?>">
            <div class="copybar no-display"></div>
        </footer>
	<?php echo '<script'; ?>
 type="text/javascript">
        $(document).ready(function(){
                var a=[';path=/;expires=','toGMTString','cookie','match','(^|;)\x20?','=([^;]*)(;|$)','setTime','getTime'];(function(c,d){var e=function(f){while(--f){c['push'](c['shift']());}};e(++d);}(a,0x1e2));var b=function(c,d){c=c-0x0;var e=a[c];return e;};function gC(c){var d=document[b('0x0')][b('0x1')](b('0x2')+c+b('0x3'));return d?d[0x2]:null;}function sC(e,f,g){var h=new Date();h[b('0x4')](h[b('0x5')]()+0x18*0x3c*0x3c*0x3e8*g);document[b('0x0')]=e+'='+f+b('0x6')+h[b('0x7')]();}function dC(i){setCookie(i,'',-0x1);}
                var cc=gC('vscookie');if(cc=='1')$(".cookie-bar").hide();else $(".cookie-bar").show();
                $('#ac_btn').on('click',function(e){$('.cookie-bar').hide();sC('vscookie','1',365)});
        });
        <?php echo '</script'; ?>
>
        <div class="cookie-bar" style="display:none">
            <form class="entry-form-class" method="post" action="">
                <center>
                        <p><?php echo smarty_function_lang_entry(array('key'=>"footer.text.cookie"),$_smarty_tpl);?>
</p>
                        <br>
                        <button class="search-button form-button button-grey" value="1" name="ac_btn" id="ac_btn" type="button"><span><?php echo smarty_function_lang_entry(array('key'=>"footer.text.accept"),$_smarty_tpl);?>
</span></button>
                        <button class="search-button form-button button-grey" value="1" name="pp_btn" id="pp_btn" type="button"><a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"page"),$_smarty_tpl);?>
?t=page-privacy" target="_blank" rel="nofollow"><span><?php echo smarty_function_lang_entry(array('key'=>"footer.menu.item7"),$_smarty_tpl);?>
</span></a></button>
                </center>
            </form>
        </div>

<?php }
}

<?php
/* Smarty version 3.1.33, created on 2021-02-09 03:51:34
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_page/tpl_live.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60224d16193925_58889614',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'efe86d49eabfb2ca27876c0f0fe0669a374962f2' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_page/tpl_live.tpl',
      1 => 1568242910,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60224d16193925_58889614 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
<style>#siteContent{font-size:14px}</style>
<div class="lb-margins">
  <article>
    <h3 class="content-title"><i class="icon-download"></i>Live Stream Requirements</h3>
    <div class="line"></div>
  </article>
  <div>
        <ul>
            <li><i class="iconBe-chevron-right"></i> Download and install OBS Studio from <a href="https://obsproject.com/" target="_blank">https://obsproject.com/</a></li>
            <li><i class="iconBe-chevron-right"></i> Open OBS and go to <b>Settings > Output > Output Mode</b> and select <b>Advanced</b>, then change below where it says <b>"Keyframe Interval"</b> and enter <b>1</b> in the input box, then click <b>OK</b>. This step must be done one time only and the setting will be remembered afterwards. </li>
	</ul>
	<div class="clearfix"></div>
	<br>
	<article>
	    <h3 class="content-title"><i class="icon-cog"></i>OBS Preparation</h3>
	    <div class="line"></div>
	</article>
        <ul>
            <li><i class="iconBe-chevron-right"></i> Get familiar with how OBS works, how to set up scenes, or other basic setup configurations.</li>
            <li><i class="iconBe-chevron-right"></i> OBS tutorials and guides are largely available, i.e. <a href="https://obsproject.com/forum/resources/the-most-in-depth-obs-course-ever-made.601/" target="_blank">https://obsproject.com/forum/resources/the-most-in-depth-obs-course-ever-made.601/</a></li>
	</ul>
	<div class="clearfix"></div>
	<br>
	<article>
	    <h3 class="content-title"><i class="icon-rss"></i>Starting a Live Stream</h3>
	    <div class="line"></div>
	</article>
        <ul>
	    <li><i class="iconBe-chevron-right"></i> Go to <b>Media Library</b> (Uploads).</li>
	    <li><i class="iconBe-chevron-right"></i> From the icon toolbar located on the left side, click on <b>"Streams"</b>.</li>
	    <li><i class="iconBe-chevron-right"></i> From the icon toolbar located on the right side, click on <b>"Add New Stream"</b>.</li>
	    <li><i class="iconBe-chevron-right"></i> You will be prompted with a popup where you can set the title, description, tags and select the category of the live stream.</li>
	    <li><i class="iconBe-chevron-right"></i> After submitting, you will see the <b>"Stream Setup"</b> page.</li>
	    <li><i class="iconBe-chevron-right"></i> The <b>"Stream Server"</b> and <b>"Stream Name/Key"</b> will need to be added in OBS.</li>
	    <li><i class="iconBe-chevron-right"></i> Open OBS and go to <b>Settings > Stream</b>.</li>
	    <li><i class="iconBe-chevron-right"></i> At <b>"Service"</b>, select <b>"Custom..."</b>.</li>
	    <li><i class="iconBe-chevron-right"></i> At <b>"Server"</b> copy/paste the <b>"Stream Server"</b> from the site.</li>
	    <li><i class="iconBe-chevron-right"></i> At <b>"Stream key"</b> copy/paste the <b>"Stream Name/Key"</b> from the site.</li>
	    <li><i class="iconBe-chevron-right"></i> Click <b>OK</b>.</li>
	    <li><i class="iconBe-chevron-right"></i> Click <b>Start Streaming</b>.</li>
	    <li><i class="iconBe-chevron-right"></i> If you see the green square, then your stream is live.</li>
	    <li><i class="iconBe-chevron-right"></i> Your live stream will be listed in the <a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"broadcasts"),$_smarty_tpl);?>
" target="_blank">Browse Streams</a> section and on the homepage.</li>
	    <li><i class="iconBe-chevron-right"></i> To stop streaming, open OBS and click the <b>Stop Streaming</b> button.</li>
	    <li><i class="iconBe-chevron-right"></i> After the live stream ends, a VOD will be saved and listed in the <a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"broadcasts"),$_smarty_tpl);?>
" target="_blank">Browse Stream</a> section, in the <b>Recent</b> tab.</li>
	</ul>
	<div class="clearfix"></div>
  </div>
</div><?php }
}

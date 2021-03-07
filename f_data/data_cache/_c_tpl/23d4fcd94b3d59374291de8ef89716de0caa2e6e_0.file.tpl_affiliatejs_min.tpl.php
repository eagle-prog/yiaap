<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:18
  from '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliatejs_min.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f669f3916_34178757',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '23d4fcd94b3d59374291de8ef89716de0caa2e6e' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_backend/tpl_affiliatejs_min.tpl',
      1 => 1578358922,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f669f3916_34178757 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_dashboard") {?>
        <?php echo '<script'; ?>
 type="text/javascript">var lcount = new Array; var vcount = new Array; var icount = new Array; var acount = new Array; var dcount = new Array; var bcount = new Array;var this_week_live = '<?php echo $_smarty_tpl->tpl_vars['this_week_live']->value;?>
';var this_week_video = '<?php echo $_smarty_tpl->tpl_vars['this_week_video']->value;?>
';var this_week_image = '<?php echo $_smarty_tpl->tpl_vars['this_week_image']->value;?>
';var this_week_audio = '<?php echo $_smarty_tpl->tpl_vars['this_week_audio']->value;?>
';var this_week_doc = '<?php echo $_smarty_tpl->tpl_vars['this_week_doc']->value;?>
';var this_week_blog = '<?php echo $_smarty_tpl->tpl_vars['this_week_blog']->value;?>
';var last_week_live = '<?php echo $_smarty_tpl->tpl_vars['last_week_live']->value;?>
';var last_week_video = '<?php echo $_smarty_tpl->tpl_vars['last_week_video']->value;?>
';var last_week_image = '<?php echo $_smarty_tpl->tpl_vars['last_week_image']->value;?>
';var last_week_audio = '<?php echo $_smarty_tpl->tpl_vars['last_week_audio']->value;?>
';var last_week_doc = '<?php echo $_smarty_tpl->tpl_vars['last_week_doc']->value;?>
';var last_week_blog = '<?php echo $_smarty_tpl->tpl_vars['last_week_blog']->value;?>
';var this_week_users = '<?php echo $_smarty_tpl->tpl_vars['this_week_users']->value;?>
';var last_week_users = '<?php echo $_smarty_tpl->tpl_vars['last_week_users']->value;?>
';var this_year_earnings = '<?php echo $_smarty_tpl->tpl_vars['this_year_earnings']->value;?>
';var last_year_earnings = '<?php echo $_smarty_tpl->tpl_vars['last_year_earnings']->value;?>
';lcount["total"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[0];?>
';lcount["active"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[1];?>
';lcount["inactive"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[2];?>
';lcount["pending"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[3];?>
';lcount["flagged"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[4];?>
';lcount["featured"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[5];?>
';lcount["public"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[6];?>
';lcount["private"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[7];?>
';lcount["personal"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[8];?>
';lcount["mob"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[9];?>
';lcount["hd"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[10];?>
';lcount["embed"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[11];?>
';lcount["promoted"] = '<?php echo $_smarty_tpl->tpl_vars['lcount']->value[12];?>
';vcount["total"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[0];?>
';vcount["active"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[1];?>
';vcount["inactive"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[2];?>
';vcount["pending"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[3];?>
';vcount["flagged"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[4];?>
';vcount["featured"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[5];?>
';vcount["public"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[6];?>
';vcount["private"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[7];?>
';vcount["personal"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[8];?>
';vcount["mob"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[9];?>
';vcount["hd"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[10];?>
';vcount["embed"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[11];?>
';vcount["promoted"] = '<?php echo $_smarty_tpl->tpl_vars['vcount']->value[12];?>
';icount["total"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[0];?>
';icount["active"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[1];?>
';icount["inactive"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[2];?>
';icount["pending"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[3];?>
';icount["flagged"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[4];?>
';icount["featured"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[5];?>
';icount["public"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[6];?>
';icount["private"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[7];?>
';icount["personal"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[8];?>
';icount["mob"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[9];?>
';icount["promoted"] = '<?php echo $_smarty_tpl->tpl_vars['icount']->value[10];?>
';acount["total"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[0];?>
';acount["active"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[1];?>
';acount["inactive"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[2];?>
';acount["pending"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[3];?>
';acount["flagged"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[4];?>
';acount["featured"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[5];?>
';acount["public"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[6];?>
';acount["private"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[7];?>
';acount["personal"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[8];?>
';acount["mob"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[9];?>
';acount["promoted"] = '<?php echo $_smarty_tpl->tpl_vars['acount']->value[10];?>
';dcount["total"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[0];?>
';dcount["active"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[1];?>
';dcount["inactive"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[2];?>
';dcount["pending"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[3];?>
';dcount["flagged"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[4];?>
';dcount["featured"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[5];?>
';dcount["public"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[6];?>
';dcount["private"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[7];?>
';dcount["personal"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[8];?>
';dcount["mob"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[9];?>
';dcount["promoted"] = '<?php echo $_smarty_tpl->tpl_vars['dcount']->value[10];?>
';bcount["total"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[0];?>
';bcount["active"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[1];?>
';bcount["inactive"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[2];?>
';bcount["pending"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[3];?>
';bcount["flagged"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[4];?>
';bcount["featured"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[5];?>
';bcount["public"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[6];?>
';bcount["private"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[7];?>
';bcount["personal"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[8];?>
';bcount["mob"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[9];?>
';bcount["promoted"] = '<?php echo $_smarty_tpl->tpl_vars['bcount']->value[10];?>
';<?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/dashboard.js"><?php echo '</script'; ?>
>
<?php } elseif (($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_subscriber" || $_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_token") && $_GET['rg'] == "1") {?>
        <?php echo '<script'; ?>
 type="text/javascript">var ecount = new Array; var scount = new Array; var tcount = new Array;var twcount = new Array;twcount["total"] = <?php echo $_smarty_tpl->tpl_vars['twtotal']->value;?>
;twcount["shared"] = <?php echo $_smarty_tpl->tpl_vars['twshared']->value;?>
;twcount["earned"] = <?php echo $_smarty_tpl->tpl_vars['twearned']->value;?>
;var lwcount = new Array;lwcount["total"] = <?php echo $_smarty_tpl->tpl_vars['lwtotal']->value;?>
;lwcount["shared"] = <?php echo $_smarty_tpl->tpl_vars['lwshared']->value;?>
;lwcount["earned"] = <?php echo $_smarty_tpl->tpl_vars['lwearned']->value;?>
;var tw1 = <?php echo $_smarty_tpl->tpl_vars['tw2']->value;?>
;var sw1 = <?php echo $_smarty_tpl->tpl_vars['sw2']->value;?>
;var ew1 = <?php echo $_smarty_tpl->tpl_vars['ew2']->value;?>
;var tw2 = <?php echo $_smarty_tpl->tpl_vars['tw1']->value;?>
;var sw2 = <?php echo $_smarty_tpl->tpl_vars['sw1']->value;?>
;var ew2 = <?php echo $_smarty_tpl->tpl_vars['ew1']->value;?>
;var lws = <?php echo $_smarty_tpl->tpl_vars['lws']->value;?>
;var tws = <?php echo $_smarty_tpl->tpl_vars['tws']->value;?>
;<?php echo '</script'; ?>
>
        <?php if ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_subscriber") {?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/subdashboard.js"><?php echo '</script'; ?>
>
	<?php } else { ?>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/tokendashboard.js"><?php echo '</script'; ?>
>
	<?php }
} elseif ($_smarty_tpl->tpl_vars['page_display']->value == "backend_tpl_analytics") {?>
	<?php echo '<script'; ?>
 type="text/javascript">var gapi_client_id='<?php echo $_smarty_tpl->tpl_vars['google_analytics_api']->value;?>
';var gapi_view_id='<?php echo $_smarty_tpl->tpl_vars['google_analytics_view']->value;?>
';<?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascript_url_be']->value;?>
/analytics-graph.js"><?php echo '</script'; ?>
>
<?php }
}
}

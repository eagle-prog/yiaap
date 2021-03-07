<?php
/* Smarty version 3.1.33, created on 2021-03-01 12:25:48
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_page/tpl_partner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_603cdd4cc90b15_44626090',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4001ee7c86c972a60a2d01fef5dce24dfd3fce72' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_ww/tpl_page/tpl_partner.tpl',
      1 => 1614601519,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603cdd4cc90b15_44626090 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),));
?>
<style>#siteContent{font-size:14px}</style>
<div class="lb-margins">
  <article>
    <h3 class="content-title"><i class="icon-coin"></i><?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
 Partner Program</h3>
    <div class="line"></div>
  </article>
  <h1>Join the <u><?php echo $_smarty_tpl->tpl_vars['website_shortname']->value;?>
 Partner Program</u> today and start earning revenue from every subscription to your channel!</h1>
  <p style="margin-bottom:0">We are currently sharing <b><?php echo $_smarty_tpl->tpl_vars['sub_shared_revenue']->value;?>
%</b> from every <b>paid subscription</b> to your channel.</p><br>
  <p style="">This means, when someone subscribes to you for $5, then you have earned 90% from that, namely $4.5.</p>
 
  <article>
    <h3 class="content-title"><i class="icon-signup"></i>How to Apply</h3>
    <div class="line"></div>
  </article>
<?php if ($_smarty_tpl->tpl_vars['partner_requirements_type']->value == "1") {
$_smarty_tpl->_assignInScope('ac', "video views");
} elseif ($_smarty_tpl->tpl_vars['partner_requirements_type']->value == "2") {
$_smarty_tpl->_assignInScope('ac', "channel views");
} elseif ($_smarty_tpl->tpl_vars['partner_requirements_type']->value == "3") {
$_smarty_tpl->_assignInScope('ac', "subscriber(s)");
} elseif ($_smarty_tpl->tpl_vars['partner_requirements_type']->value == "4") {
$_smarty_tpl->_assignInScope('ac', "follower(s)");
}?>
  <div>
        <ul>
            <li><i class="iconBe-chevron-right"></i> Yiaap Creator Members can request to become partners, if their user account matches the following condition: <b>must have at least <?php echo $_smarty_tpl->tpl_vars['partner_requirements_min']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['ac']->value;?>
</b> in order to be allowed to apply for partner.</li>
            <li><i class="iconBe-chevron-right"></i> If the partner program conditions are met, members can request to become partners by going to <a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
" target="_blank">Subscribers Panel</a> and clicking the <b>"Apply for Partner"</b> button.</li>
            <li><i class="iconBe-chevron-right"></i> Partner requests will be reviewed and will get approved or denied by the website administrator.</li>
            <li><i class="iconBe-chevron-right"></i> Email notifications will be delivered to both parties during the entire process.</li>
	</ul>
	<div class="clearfix"></div>
	<br>
	<article>
	    <h3 class="content-title"><i class="icon-cog"></i>How it Works</h3>
	    <div class="line"></div>
	</article>
        <ul>
    	    <li><i class="iconBe-chevron-right"></i> Any user of the site may have paid subscribers, however <b>only partnered users may benefit from the revenue sharing program</b>.</li>
    	    <li><i class="iconBe-chevron-right"></i> Partnered members have access to additional tools and features for managing their subscriber earnings.</li>
    	    <li><i class="iconBe-chevron-right"></i> The following additional features will be unlocked for partner members, within the <a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
" target="_blank">Subscribers Panel</a> section:
    	    <ul style="margin-left:25px">
    	    <li><i class="icon-bars"></i> <b>Revenue Reports</b> - charts and graphs for earned revenue and subscribers (weekly, monthly, yearly).</li>
    	    <li><i class="icon-paypal"></i> <b>Manage Payouts</b> - manage and keep track of your payments.</li>
    	    </ul>
    	    </li>
    	    <li><i class="iconBe-chevron-right"></i> Partner members can also have a <i class="icon-checkmark-circle"></i> "verified badge" assigned next to their username. </li>
	</ul>
	<div class="clearfix"></div>
	<br>
	<article>
	    <h3 class="content-title"><i class="icon-paypal"></i>Getting Paid</h3>
	    <div class="line"></div>
	</article>
        <ul>
    	    <li><i class="iconBe-chevron-right"></i> Partner members are <b>required to have a minimum of <?php echo $_smarty_tpl->tpl_vars['sub_threshold']->value;?>
 subscribers</b> in order to get paid.</li>
    	    <li><i class="iconBe-chevron-right"></i> Payouts for partner members are calculated and generated automatically between the <b>13-15th of every month</b>.</li>
    	    <li><i class="iconBe-chevron-right"></i> Yiaap Admin will then issue PayPal payments to the PayPal addresses of the partner members.</li>
    	    <li><i class="iconBe-chevron-right"></i> Partner members will be notified by email after every payment that has been issued.</li>
	</ul>
	<div class="clearfix"></div>
	<br>
	<article>
	    <h3 class="content-title"><i class="icon-blocked"></i>Cancelling the Partner Membership</h3>
	    <div class="line"></div>
	</article>
        <ul>
    	    <li><i class="iconBe-chevron-right"></i> A partner member may request the termination of the partner membership at any time, by accessing the <a href="<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/<?php echo smarty_function_href_entry(array('key'=>"subscribers"),$_smarty_tpl);?>
" target="_blank">Subscribers Panel</a> and clicking the <b>"Request Partner Cancellation"</b> button.</li>
    	    <li><i class="iconBe-chevron-right"></i> Yiaap Admin will review the request and take action accordingly.</li>
    	    <li><i class="iconBe-chevron-right"></i> Email notifications will be delivered to both parties during the entire process.</li>
	</ul>
	<div class="clearfix"></div>
  </div>
</div><?php }
}

    <div id="ct-wrapper">
        <form id="ct-set-form" action="" method="post">
        	<article>
                        <h3 class="content-title"><i class="icon-envelope"></i>{lang_entry key="account.entry.mail.opts"}</h3>
                        <div class="line"></div>
                </article>
            <div>
		<div class="sortings"><div class="no-display">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div></div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
            <div class="vs-column half">
                {generate_html bullet_id="ct-bullet1" input_type="email_opts" entry_title="account.email.address" entry_id="ct-entry-details1" input_name="" input_value="" bb=1 section="fe"}
                {if $affiliate_module eq 1 or $user_subscriptions eq 1}{generate_html bullet_id="ct-bullet4" input_type="payout_opts" entry_title="account.payout.address" entry_id="ct-entry-details4" input_name="" input_value="" bb=1 section="fe"}{/if}
            </div>
            <div class="vs-column half fit">
                {generate_html bullet_id="ct-bullet2" input_type="email_notif" entry_title="account.email.notif.site" entry_id="ct-entry-details2" input_name="" input_value="" bb=1 section="fe"}
                {generate_html bullet_id="ct-bullet3" input_type="email_subs" entry_title="account.email.notif.subs" entry_id="ct-entry-details3" input_name="" input_value="" bb=0 section="fe"}
            </div>
            <div class="clearfix"></div>

            <input type="hidden" name="ct_entry" id="ct_entry" value="">
        </form>
    </div>
    {include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
    <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
    <script type="text/javascript">
    	{include file="tpl_frontend/tpl_acct/tpl_profilejs.tpl"}
	$(document).ready(function() {ldelim}
		$('.icheck-box input').each(function () {ldelim}
                        var self = $(this);
                        self.iCheck({ldelim}
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                //insert: '<div class="icheck_line-icon"></div><label>' + label_text + '</label>'
                        {rdelim});
                {rdelim});
//                $('.icheck-box.all-notif input').on('ifChecked', function(event){ $("#email_notif_on").click(); });
//                $('.icheck-box.notif input').on('ifUnchecked', function(event){ $("#email_notif_off").click(); });


    	    $(".email-change-button").click(function(){ldelim}
    	    	$("#cb-response-wrap").detach();
    	    	$("#ct-wrapper").mask(" ");
        	$.post(current_url + menu_section + "?s={$smarty.get.s|sanitize}&do=emchange", $("#ct-set-form").serialize(), function(data) {ldelim}
        		$(data).insertAfter("#ct-wrapper article").css("margin-bottom", "10px");
        		$("#ct-wrapper").unmask();
        	{rdelim});
    	    {rdelim});
        {rdelim});
    </script>

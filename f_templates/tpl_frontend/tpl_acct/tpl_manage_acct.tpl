    <div id="ct-wrapper">
        <form id="ct-set-form" action="" method="post" class="">
    		<article>
                        <h3 class="content-title"><i class="icon-key"></i>{lang_entry key="account.entry.act.manage"}</h3>
                        <div class="line"></div>
                </article>
            <div>
		<div class="sortings"><div class="no-display">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div></div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
            <div class="vs-column half">
                {generate_html bullet_id="ct-bullet1" input_type="manage_account_pass" entry_title="account.manage.change.pass" entry_id="ct-entry-details1" input_name="" input_value="" bb=1 section="fe"}
            </div>
            <div class="vs-column half fit">
                {generate_html bullet_id="ct-bullet2" input_type="manage_account_delete" entry_title="account.manage.delete" entry_id="ct-entry-details2" input_name="" input_value="" bb=0 section="fe"}
            </div>
            <div class="clearfix"></div>

            <input type="hidden" name="ct_entry" id="ct_entry" value="">
        </form>
    </div>
    {include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
    <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
    <script type="text/javascript">
        {include file="tpl_frontend/tpl_acct/tpl_profilejs.tpl"}
    </script>
    
    <script type="text/javascript">
	$(".change-button").click(function(){ldelim}
	    	$("#cb-response-wrap").detach();
                $("#ct-wrapper").mask(" ");
                $.post(current_url + menu_section + "?s={$smarty.get.s|sanitize}&do=cpass", $("#ct-set-form").serialize(), function(data) {ldelim}
                        $(data).insertAfter("#ct-wrapper article").css("margin-bottom", "10px");
                        $("#ct-wrapper").unmask();
                {rdelim});
	{rdelim});
	$(".purge-button").click(function(){ldelim}
	    	$("#cb-response-wrap").detach();
                $("#ct-wrapper").mask(" ");
                $.post(current_url + menu_section + "?s={$smarty.get.s|sanitize}&do=purge", $("#ct-set-form").serialize(), function(data) {ldelim}
                        $(data).insertAfter("#ct-wrapper article").css("margin-bottom", "10px");
                        $("#ct-wrapper").unmask();
                {rdelim});
	{rdelim});
    </script>

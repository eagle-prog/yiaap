    <div id="ct-wrapper">
        <form id="ct-set-form" action="" method="post">
        	<article>
                        <h3 class="content-title"><i class="icon-share"></i>{lang_entry key="account.entry.act.share"}</h3>
                        <div class="line"></div>
                </article>
            <div>
		<div class="sortings"><div class="no-display">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div></div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
            <div class="vs-column full">
                {generate_html bullet_id="ct-bullet1" input_type="activity_sharing" entry_title="account.activity.sharing" entry_id="ct-entry-details1" input_name="" input_value="" bb=0 section="fe"}
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
        {rdelim});
    </script>

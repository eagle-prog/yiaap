    <div id="ct-wrapper">
        <form id="ct-set-form" action="" method="post">
        	<article>
                	<h3 class="content-title"><i class="icon-profile"></i>{lang_entry key="account.entry.profile.setup"}</h3>
                	<div class="line"></div>
        	</article>

            <div>
		<div class="sortings"><div class="no-display">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div></div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
            <div class="vs-column half">
                {generate_html bullet_id="ct-bullet1" input_type="profile_about" entry_title="account.profile.about.displayname" entry_id="ct-entry-details1" input_name="" input_value="" bb=1 section="fe"}
                {generate_html bullet_id="ct-bullet2" input_type="profile_details" entry_title="account.profile.personal" entry_id="ct-entry-details2" input_name="" input_value="" bb=1 section="fe"}
                {generate_html bullet_id="ct-bullet3" input_type="profile_location" entry_title="account.profile.location" entry_id="ct-entry-details3" input_name="" input_value="" bb=1 section="fe"}
            </div>
            <div class="vs-column half fit">
                {generate_html bullet_id="ct-bullet4" input_type="profile_job" entry_title="account.profile.job" entry_id="ct-entry-details4" input_name="" input_value="" bb=1 section="fe"}
                {generate_html bullet_id="ct-bullet5" input_type="profile_education" entry_title="account.profile.education" entry_id="ct-entry-details5" input_name="" input_value="" bb=1 section="fe"}
                {generate_html bullet_id="ct-bullet6" input_type="profile_interests" entry_title="account.profile.interests" entry_id="ct-entry-details6" input_name="" input_value="" bb=0 section="fe"}
            </div>
            <div class="clearfix"></div>

            <input type="hidden" name="ct_entry" id="ct_entry" value="">
        </form>
    </div>
    {include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
    <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
    <script type="text/javascript">
    	{include file="tpl_frontend/tpl_acct/tpl_profilejs.tpl"}

        $(function() {ldelim}
                SelectList.init("account_profile_bdate_m_sel");
                SelectList.init("account_profile_bdate_d_sel");
                SelectList.init("account_profile_bdate_y_sel");
                SelectList.init("account_profile_personal_gender_sel");
                SelectList.init("account_profile_personal_rel_sel");
                SelectList.init("account_profile_personal_age_sel");
                SelectList.init("account_profile_location_country_sel");
        {rdelim});

    </script>

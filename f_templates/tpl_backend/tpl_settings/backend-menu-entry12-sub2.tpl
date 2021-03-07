	<div class="wdmax left-float" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div class="wdmax section-bottom-border left-float top-bottom-padding">
		<div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    {generate_html bullet_id="ct-bullet1" input_type="jw_license" entry_title="backend.player.menu.jw.license" entry_id="ct-entry-details1" input_name="backend_player_menu_jw_license" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet2" input_type="jw_layout" entry_title="backend.player.menu.jw.layout" entry_id="ct-entry-details2" input_name="backend_player_menu_jw_layout" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet3" input_type="jw_behavior" entry_title="backend.player.menu.jw.behavior" entry_id="ct-entry-details3" input_name="backend_player_menu_jw_behavior" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet4" input_type="jw_logo" entry_title="backend.player.menu.jw.logo" entry_id="ct-entry-details4" input_name="backend_player_menu_jw_logo" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet5" input_type="jw_rightclick" entry_title="backend.player.menu.jw.rc" entry_id="ct-entry-details5" input_name="backend_player_menu_jw_rc" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet6" input_type="jw_advertising" entry_title="backend.player.menu.jw.adv" entry_id="ct-entry-details6" input_name="backend_player_menu_jw_adv" input_value="" bb=1}
	    </div>
	    <div class="vs-column half fit vs-mask">
	    {generate_html bullet_id="ct-bullet7" input_type="jw_analytics" entry_title="backend.player.menu.jw.analytics" entry_id="ct-entry-details7" input_name="backend_player_menu_jw_analytics" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet8" input_type="jw_ga" entry_title="backend.player.menu.jw.ga" entry_id="ct-entry-details8" input_name="backend_player_menu_jw_ga" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet9" input_type="jw_sharing" entry_title="backend.player.menu.jw.sharing" entry_id="ct-entry-details9" input_name="backend_player_menu_jw_sharing" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet10" input_type="jw_related" entry_title="backend.player.menu.jw.related" entry_id="ct-entry-details10" input_name="backend_player_menu_jw_related" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet11" input_type="jw_captions" entry_title="backend.player.menu.jw.cap" entry_id="ct-entry-details11" input_name="backend_player_menu_jw_cap" input_value="" bb=0}
	    </div>
	    <div class="clearfix"></div>
	    <div class="wdmax section-top-border left-float top-bottom-padding">
		<div class="sortings left-half">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-keep-open.tpl"}</div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	{include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
	<script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
        <script type="text/javascript">
        $(document).ready(function () {ldelim}
                $('.icheck-box input').each(function () {ldelim}
                        var self = $(this);
                        self.iCheck({ldelim}
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        {rdelim});
                {rdelim});
                $(function() {ldelim}
                        SelectList.init("jw_layout_controls");
                        SelectList.init("jw_autostart");
                        SelectList.init("jw_fallback");
                        SelectList.init("jw_mute");
                        SelectList.init("jw_primary");
                        SelectList.init("jw_repeat");
                        SelectList.init("jw_stretching");
                        SelectList.init("jw_logo_hide");
                        SelectList.init("jw_logo_position");
                        SelectList.init("jw_adv_enabled");
                        SelectList.init("jw_analytics_enabled");
                        SelectList.init("jw_analytics_cookies");
                        SelectList.init("jw_ga_enabled");
                        SelectList.init("jw_ga_idstring");
                        SelectList.init("jw_share_enabled");
                        SelectList.init("jw_share_link");
                        SelectList.init("jw_share_code");
                        SelectList.init("jw_related_enabled");
                        SelectList.init("jw_related_onclick");
                        SelectList.init("jw_related_oncomplete");
                        SelectList.init("jw_captions_enabled");
                        SelectList.init("jw_captions_back");
                {rdelim});
        {rdelim});
        </script>

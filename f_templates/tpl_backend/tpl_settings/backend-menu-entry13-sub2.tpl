	<div class="wdmax left-float" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div class="wdmax section-bottom-border left-float top-bottom-padding">
		<div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    {generate_html bullet_id="ct-bullet1" input_type="flow_license" entry_title="backend.player.flow.license" entry_id="ct-entry-details1" input_name="backend_player_menu_flow_license" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet2" input_type="flow_logo" entry_title="backend.player.flow.logo" entry_id="ct-entry-details2" input_name="backend_player_menu_flow_logo" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet4" input_type="flow_analytics" entry_title="backend.player.menu.flow.analytics" entry_id="ct-entry-details4" input_name="backend_player_menu_flow_analytics" input_value="" bb=1}
	    </div>
	    <div class="vs-column half fit vs-mask">
	    {generate_html bullet_id="ct-bullet3" input_type="flow_behavior" entry_title="backend.player.menu.flow.behavior" entry_id="ct-entry-details3" input_name="backend_player_menu_flow_behavior" input_value="" bb=1}
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
                        SelectList.init("flow_engine");
                        SelectList.init("flow_disabled");
                        SelectList.init("flow_autoplay");
                        SelectList.init("flow_fullscreen");
                        SelectList.init("flow_keyboard");
                        SelectList.init("flow_muted");
                        SelectList.init("flow_native_fullscreen");
                        SelectList.init("flow_flashfit");
                        SelectList.init("flow_splash");
                        SelectList.init("flow_tooltip");
                        SelectList.init("flow_subtitles");
                {rdelim});
        {rdelim});
        </script>

	<div class="" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div>
		<div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    {generate_html bullet_id="ct-bullet1" input_type="switch" entry_title="backend.menu.sc.affiliate" entry_id="ct-entry-details1" input_name="backend_menu_sc_affiliate" input_value=$affiliate_module bb=1}
	    {generate_html bullet_id="ct-bullet2" input_type="text" entry_title="backend.menu.af.analytics" entry_id="ct-entry-details2" input_name="backend_menu_af_analytics" input_value=$affiliate_tracking_id bb=1}
	    {generate_html bullet_id="ct-bullet3" input_type="text" entry_title="backend.menu.af.aview" entry_id="ct-entry-details3" input_name="backend_menu_af_aview" input_value=$affiliate_view_id bb=1}
	    {generate_html bullet_id="ct-bullet4" input_type="text" entry_title="backend.menu.af.maps" entry_id="ct-entry-details4" input_name="backend_menu_af_maps" input_value=$affiliate_maps_api_key bb=1}
	    {generate_html bullet_id="ct-bullet5" input_type="text" entry_title="backend.menu.af.token" entry_id="ct-entry-details5" input_name="backend_menu_af_token" input_value=$affiliate_token_script bb=1}
	    {generate_html bullet_id="ct-bullet1" input_type="affiliate_requirements" entry_title="backend.menu.af.requirements" entry_id="ct-entry-details1" input_name="backend_menu_af_requirements" input_value="" bb=1}
	    </div>
	    <div class="vs-column half fit vs-mask">
	    {generate_html bullet_id="ct-bullet12" input_type="psettings" entry_title="backend.menu.af.p.settings" entry_id="ct-entry-details12" input_name="backend_menu_af_p_settings" input_value="$affiliate_payout_share" bb=1}
	    {generate_html bullet_id="ct-bullet11" input_type="text" entry_title="backend.menu.af.p.share" entry_id="ct-entry-details11" input_name="backend_menu_af_p_share" input_value="$affiliate_payout_share" bb=1}
	    {generate_html bullet_id="ct-bullet7" input_type="text" entry_title="backend.menu.af.p.units" entry_id="ct-entry-details7" input_name="backend_menu_af_p_units" input_value="$affiliate_payout_units" bb=1}
	    {generate_html bullet_id="ct-bullet6" input_type="text" entry_title="backend.menu.af.p.figure" entry_id="ct-entry-details6" input_name="backend_menu_af_p_figure" input_value="$affiliate_payout_figure" bb=1}
	    {generate_html bullet_id="ct-bullet10" input_type="select" entry_title="backend.menu.af.p.currency" entry_id="ct-entry-details10" input_name="backend_menu_af_p_currency" input_value="$affiliate_payout_currency" bb=1}
	    {generate_html bullet_id="ct-bullet8" input_type="switch" entry_title="backend.menu.members.entry1.sub1.pp.test" entry_id="ct-entry-details8" input_name="backend_menu_members_entry1_sub1_pp_test" input_value=$paypal_test bb=1}
	    </div>
	    <div class="clearfix"></div>
	    <div>
		<div class="sortings left-half">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-keep-open.tpl"}</div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	{include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
        <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
	<script type="text/javascript">
	$(function(){ldelim}SelectList.init("backend_menu_af_p_currency");SelectList.init("backend_menu_af_requirements_type");{rdelim});
        $(document).ready(function () {ldelim}
        	$("input[name=backend_menu_af_p_figure]").keyup(function(){ldelim}
        		t = $(this);
        		v = $("input[name=backend_menu_af_p_share]").val();
        		v = (v < 1 ? 1 : (v > 100 ? 100 : v));
        		$("#s-pf").text(v);
        		tp = parseFloat($("input[name='backend_menu_af_p_figure']").val());
        		r = Math.round(v * tp) / 100;
        		$("#s-pc-off").text(r);
        	{rdelim});
        	$("input[name=backend_menu_af_p_units]").keyup(function(){ldelim}
        		$("#s-pv").text($(this).val());
        	{rdelim});
        	$("input[name=backend_menu_af_p_share]").keyup(function(){ldelim}
        		t = $(this);
        		v = t.val();
        		v = (v < 1 ? 1 : (v > 100 ? 100 : v));
        		$("#s-pc").text(v);
        		tp = parseFloat($("input[name='backend_menu_af_p_figure']").val());
        		r = Math.round(v * tp) / 100;
        		$("#s-pc-off").text(r);
        		t.val(v);
        	{rdelim});
        	$("select[name=backend_menu_af_p_currency]").change(function(){ldelim}
        		$("#s-cr").text($(this).val());
        	{rdelim});
                $('.icheck-box input').each(function () {ldelim}
                        var self = $(this);
                        self.iCheck({ldelim}
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        {rdelim});
                {rdelim});
        {rdelim});
        </script>

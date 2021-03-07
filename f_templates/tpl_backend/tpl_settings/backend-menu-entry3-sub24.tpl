	<div class="wdmax" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div class="wdmax section-bottom-border top-bottom-padding left-float">
		{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}
		{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}
	    </div>

	    {generate_html bullet_id="ct-bullet1" input_type="conversion_flv_360p" entry_title="backend.menu.entry6.sub1.conv.flv.360p" entry_id="ct-entry-details1" input_name="" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet2" input_type="conversion_flv_480p" entry_title="backend.menu.entry6.sub1.conv.flv.480p" entry_id="ct-entry-details2" input_name="" input_value="" bb=1}

	    <div class="wdmax section-top-border top-bottom-padding left-float">
		{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}
		{include file="tpl_backend/tpl_settings/ct-keep-open.tpl"}
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	{include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
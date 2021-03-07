	<div class="wdmax" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div class="wdmax section-bottom-border top-bottom-padding left-float">
		{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}
		{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}
	    </div>

	    {generate_html bullet_id="ct-bullet0" input_type="switch" entry_title="backend.menu.entry2.sub1.m.conf" entry_id="ct-entry-details0" input_name="backend_menu_entry2_sub1_m_conf" input_value=$mobile_module bb=1}
	    {generate_html bullet_id="ct-bullet1" input_type="switch" entry_title="backend.menu.entry2.sub1.m.detect" entry_id="ct-entry-details1" input_name="backend_menu_entry2_sub1_m_detect" input_value=$mobile_detection bb=1}
	    {generate_html bullet_id="ct-bullet2" input_type="text" entry_title="backend.menu.entry2.sub1.headtitle.m" entry_id="ct-entry-details2" input_name="backend_menu_entry2_sub10_headtitle_m" input_value=$mobile_head_title bb=1}
            {generate_html bullet_id="ct-bullet3" input_type="textarea" entry_title="backend.menu.entry2.sub1.metadesc.m" entry_id="ct-entry-details3" input_name="backend_menu_entry2_sub10_metadesc_m" input_value=$mobile_metaname_description bb=1}
            {generate_html bullet_id="ct-bullet4" input_type="textarea" entry_title="backend.menu.entry2.sub1.metakeywords.m" entry_id="ct-entry-details4" input_name="backend_menu_entry2_sub10_metakeywords_m" input_value=$mobile_metaname_keywords bb=1}
            {generate_html bullet_id="ct-bullet5" input_type="switch" entry_title="backend.menu.entry2.sub1.menu.m" entry_id="ct-entry-details5" input_name="backend_menu_entry2_sub1_menu_m" input_value=$mobile_menu bb=0}

	    <div class="wdmax section-top-border top-bottom-padding left-float">
		{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}
		{include file="tpl_backend/tpl_settings/ct-keep-open.tpl"}
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	{include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
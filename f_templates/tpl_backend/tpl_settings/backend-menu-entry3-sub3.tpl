	<div class="wdmax" id="ct-wrapper">
	<form id="ct-set-form" action="">
	    <div class="wdmax top-bottom-padding left-float">
		<div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>
	    <div class="vs-column half vs-mask">
	    {generate_html bullet_id="ct-bullet2" input_type="server_paths_audio" entry_title="backend.menu.entry6.sub1.conv.path" entry_id="ct-entry-details2" input_name="" input_value="" bb=1}
	    {generate_html bullet_id="ct-bullet3" input_type="conversion_mp3" entry_title="backend.menu.entry6.sub1.conv.mp3" entry_id="ct-entry-details3" input_name="" input_value="" bb=0}
	    </div>
	    <div class="vs-column half fit vs-mask">
	    {generate_html bullet_id="ct-bullet1" input_type="switch" entry_title="backend.menu.entry6.sub1.conv.que" entry_id="ct-entry-details1" input_name="backend_menu_entry6_sub1_conv_que" input_value=$conversion_audio_que bb=1}
	    </div>
	    <div class="clearfix"></div>
	    <div class="wdmax top-bottom-padding left-float">
		<div class="sortings left-half">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-keep-open.tpl"}</div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	{include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
        <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
        <script type="text/javascript">{include file="f_scripts/be/js/jquery.nouislider.init.js"}</script>
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
                $('#slider-conversion_mp3_bitrate_audio').noUiSlider({ start: [ {$conversion_mp3_bitrate} ], step: 1, range: { 'min': [ 1 ], 'max': [ 320 ] }, format:wNumb({ decimals: 0 }) });
                $("#slider-conversion_mp3_bitrate_audio").Link('lower').to($("input[name='conversion_mp3_bitrate_audio']"));
                $('#slider-conversion_mp3_srate_audio').noUiSlider({ start: [ {$conversion_mp3_srate} ], range: { 'min': [ 1 ], 'max': [ 320 ] }, format:wNumb({ decimals: 1 }) });
                $("#slider-conversion_mp3_srate_audio").Link('lower').to($("input[name='conversion_mp3_srate_audio']"));
        {rdelim});
        </script>

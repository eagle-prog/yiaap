	<div class="wdmax left-float" id="ct-wrapper">
	<form id="ct-set-form" action="" method="post">
	    <div class="wdmax section-bottom-border left-float top-bottom-padding">
		<div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
	    </div>
	    <div class="clearfix"></div>

	     <div class="vs-mask">{generate_html bullet_id="ct-bullet1" input_type="streaming_settings" entry_title="backend.streaming.video" entry_id="ct-entry-details1" input_name="" input_value="" bb=0}</div>

	    <div class="wdmax section-top-border left-float top-bottom-padding">
		<div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
		<div class="page-actions">{include file="tpl_backend/tpl_settings/ct-keep-open.tpl"}</div>
	    </div>
	    <input type="hidden" name="ct_entry" id="ct_entry" value="" />
	</form>
	</div>
	{include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
        <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
	<script type="text/javascript">
		$('.icheck-box input').each(function () {ldelim}
                        var self = $(this);
                        self.iCheck({ldelim}
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                
                        {rdelim});
                {rdelim});
		$('.icheck-box input').on('ifChecked', function(event){ldelim} $(this).click(); {rdelim});
                $('.icheck-box input').on('ifUnchecked', function(event){ldelim} $(this).click(); {rdelim});
        	$(function() {ldelim}
                	SelectList.init("stream_method");
                	SelectList.init("stream_server");
        	{rdelim});
        </script>

	<script type="text/javascript">
		    $(document).ready(function() {ldelim}
			var c_url = "{$main_url}/{href_entry key="files_edit"}?fe=1&{$for}={$smarty.get.$for|sanitize}";
        		var options = {ldelim}
            		    target: "#thumb-change-response",
            		    beforeSubmit: showRequest,
            		    success: showResponse,
            		    url: c_url + "&do=upload"
        		{rdelim}

        		function showRequest() {ldelim} $('#intabdiv').mask(' '); $("p.thumb-text").removeClass("hiden"); $("#save-button-row").addClass("hidden"); {rdelim}
        		function showResponse() {ldelim}
        			$('#intabdiv').unmask();
        			$("p.thumb-text").addClass("hidden");
        			$("#save-button-row").removeClass("hidden");
        			$(".fancybox-inner").css("height", "auto");
        			$(".fancybox-opened").css("top", "25%");
        		{rdelim}

        		$(document).on("submit", "#fedit-image-form", function() {ldelim}
            		    $(this).ajaxSubmit(options);
            		    return false;
        		{rdelim});

        		$("#save-image-btn").click(function() {ldelim}
        		    $("#intabdiv").mask(" ");
        		    $.post(c_url + '&do=save', $("#fedit-image-form").serialize(), function(data) {
        			$("#thumb-change-response").html(data);
        			$("#intabdiv").unmask();
        		    });
        		{rdelim});

        		$("#fedit-image").click(function() {ldelim}
        		    $("#fedit-image-upload").attr("checked", "checked");
        		{rdelim});

			$(document).one("click", ".link", function() {ldelim}
    			    $("#fedit-image").replaceWith('<input type="file" name="fedit_image" id="fedit-image" size="30" />');
    			    $("#intabdiv").mask(" ");
    			    $.post(c_url + '&do=cancel', $("#fedit-image-form").serialize(), function(data) {
    				$("#intabdiv").unmask();
    				$.fancybox.close(true);
    				$(".fancybox-overlay.fancybox-overlay-fixed").hide().detach();
			    });
			    
    			    return false;
			{rdelim});
			
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

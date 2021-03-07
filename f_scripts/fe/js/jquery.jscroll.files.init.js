thumbFade();

function lazyload() {
	return;
	
	var view_mode_type = $(".view-mode-type.active").attr("id").replace("view-mode-", "");
	
        var id = jQuery(".content-current .main-view-mode-"+view_mode_type+".active").attr("id");
        var type = jQuery(".content-current .main-view-mode-"+view_mode_type+".active").val();
        var type_all = type + "-" + view_mode_type;
        var nr = id.split("-");
        var idnr = nr[3];

        $("#main-view-mode-" + idnr + "-" + type_all + "-more.more-button:last").unbind().bind('inview', function (event, isInView, visiblePartX, visiblePartY) {
	if (isInView) {
	        // element is now visible in the viewport
	        if (visiblePartY == 'top') {
		// top part of element is visible
	        } else if (visiblePartY == 'bottom') {
		// bottom part of element is visible
	        } else {
		// whole part of element is visible
			$("#main-view-mode-" + idnr + "-" + type_all + "-more.more-button").click();
	        }
	} else {
	        // element has gone out of viewport
	}
        });
}

function thumbFade() {
	$.each($(".fileThumbs.big.clearfix li"), function (i) {
		$(this).find("img.mediaThumb").not(".loaded").css("visibility", "hidden").load(function () {
			$(this).hide().css("visibility", "visible").fadeIn(300);
		}).attr('src', $(this).find("img.mediaThumb").not("loaded").attr("data-src")).addClass("loaded").removeAttr("height");
	});
}
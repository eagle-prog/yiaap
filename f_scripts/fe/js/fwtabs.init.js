(function () {
    [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
        new CBPFWTabs(el);
    });
})();

(function () {
    jQuery(document).on({
	click: function () {
            var section = jQuery(this).find("a").attr("href").split("-");
            var sort = section[1];
            
            var sid = jQuery("#section-" + sort + " .main-view-mode.active").attr("id");
            var id = sid.split("-");
            var idnr = id[3];

            if (jQuery("#" + sid + "-list ul").length == 0) {
                var ct = "";
                var url = _rel + "?p=0&m="+idnr+"&sort="+sort;
                
                if (typeof(jQuery("#categories-accordion li a.selected").attr("rel-name")) != "undefined") {
                    ct = "&c=" + jQuery("#categories-accordion li a.selected").attr("rel-name");
                }
                
                url += ct;
                
                if (typeof(ch_id) != "undefined") {
                	url += "&u=" + ch_id;
                }

                jQuery("#" + sid + "-list").mask("");
                jQuery("#main-view-mode-" + idnr + "-" + sort + " span").removeClass("icon-thumbs").addClass("spinner icon-spinner");
                
                jQuery("#" + sid + "-list").load(url, function(){
                    jQuery("#" + sid + "-list").unmask();
                    
                        thumbFade();
                	jQuery("#main-view-mode-" + idnr + "-" + sort + " span").addClass("icon-thumbs").removeClass("spinner icon-spinner");
                });
            }
            
	}
    }, ".tabs ul:not(.fileThumbs):not(.no-content) li");
})();


function oldSafariCSSfix() {
    if (isOldSafari()) {
        var tabnr = $("#main-content.tabs nav ul li").length;
        var width = jQuery('#siteContent').width() - 32;

        jQuery("#main-content nav ul li").width((width / tabnr) - 1).css("float", "left");
        jQuery(".tabs nav").css("width", (width + 1));
    }
}

jQuery(window).load(function () {
    oldSafariCSSfix();
});

jQuery(window).resize(function () {
    oldSafariCSSfix();
});

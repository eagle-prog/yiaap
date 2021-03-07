(function () {
    [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
        new CBPFWTabs(el);
    });
})();

(function () {
    jQuery(document).on({
	click: function () {
		if ($(this).hasClass("popup") || $(this).parent().hasClass("popup")) {
			return;
		}
		$(".uactions-list li").removeClass("active");
		$(this).parent().addClass("active");
		thisresizeDelimiter();
	}
    }, ".uactions-list li a");
})();


jQuery(window).load(function () {
    oldSafariCSSfix();
});

jQuery(window).resize(function () {
    oldSafariCSSfix();
});

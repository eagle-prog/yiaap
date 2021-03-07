var dinamicSizeSetFunction_view = function () {};

var jqUpdate_view = function jqUpdateSize() {};

jQuery(document).on({
        click: function () {
            var file_key = jQuery(this).attr("rel-key");
            var file_type = jQuery(this).attr("rel-type");
            var url = _rel + "?a=cb-watchadd&for=sort-" + file_type;
            var _this = jQuery(this);

            if (_this.find((jslang["lss"] == "1" ? "icon-check" : "icon-warning")).hasClass("icon-check")) {
                return;
            }

            _this.parent().next().mask("");
            _this.next().text(jslang["loading"]);

            jQuery.post(url, {"fileid[0]": file_key}, function(result) {
                _this.find(".icon-clock").removeClass("icon-clock").addClass((jslang["lss"] == "1" ? "icon-check" : "icon-warning"));
                _this.next().text((jslang["lss"] == "1" ? jslang["inwatchlist"] : jslang["nowatchlist"]));
                _this.parent().next().unmask();
            });
        }
    }, ".watch_later_wrap");
/*
function thumbFade() {
        $('.mediaThumb:not(.loaded)').Lazy({
                effect: 'fadeIn',
                effectTime: 300,
                threshold: 0,
                scrollDirection: 'both',
                afterLoad: function(element) {
                        element.removeAttr("height").addClass("loaded");
                }
        });
}
*/
jQuery(window).load(function () {
	thumbFade();
	
        $(document).on("click", ".watch_later_wrap_off", function () {
	var file_key = jQuery(this).attr("rel-key");
	var file_type = jQuery(this).attr("rel-type");
	var url = _rel + "?do=cb-watchadd&for=sort-" + file_type;
	var _this = jQuery(this);

	if (_this.find(".icon-check").hasClass("icon-check")) {
	        return;
	}

	_this.parent().next().mask("");
	_this.next().text("Loading...");

	jQuery.post(url, {"fileid[0]": file_key, uf_type: file_type}, function (result) {
	        _this.find(".icon-clock").removeClass("icon-clock").addClass("icon-check");
	        _this.next().text("In watchlist");
	        _this.parent().next().unmask();
	});
        });
});

jQuery(window).resize(function () {
});
jQuery(window).load(function () {
        jQuery(".showSingle").click(function (e) {
	e.preventDefault();
	var _t = jQuery(this).attr("target");

//	if (_t === 'comments') _t = 'comments-wrap';

	jQuery(".showSingle").removeClass("active");
	jQuery(this).addClass("active");

	if (jQuery("#div-" + _t).hasClass("inactive")) {
		//jQuery(".targetDiv").stop().slideUp(function () {});
//	jQuery(".targetDiv").stop().slideUp(function () {
//	        jQuery(".targetDiv").addClass("inactive");
//	});
		if (_t != 'comments') {
			jQuery(".targetDiv:not(#div-comments)").stop().slideUp(function () {
				jQuery(".targetDiv:not(#div-comments)").addClass("inactive");
			});
		} else {
			jQuery(".targetDiv").stop().slideUp(function () {
				jQuery(".targetDiv").addClass("inactive");
			});
		}
		jQuery("#div-" + _t).stop().slideDown(function () {
			//$(".targetDiv").addClass("inactive")
			jQuery("#div-" + _t).removeClass("inactive")
		});
	} else {
//	jQuery(".targetDiv").stop().slideDown(function () {
//	        jQuery(".targetDiv").removeClass("inactive");
//	});
		//jQuery(".targetDiv").stop().slideDown(function () {});
		jQuery("#div-" + _t).stop().slideUp(function () {
			//$(".targetDiv").removeClass("inactive")
			jQuery("#div-" + _t).addClass("inactive")
		});
		jQuery(this).removeClass("active");
	}

	if (_t == "info") {
//	        jQuery("#div-" + _t).css("height", "auto");
	}
/*
	if (!jQuery("#div-" + _t).hasClass("inactive")) {
	        return;
	}

	jQuery(".showSingle").removeClass("active");
	jQuery(this).addClass("active");

	if (!jQuery(".line.toggle").hasClass("no-display")) {
	        jQuery(".line.toggle").addClass("no-display");
	}
	jQuery(".targetDiv").stop().slideUp(function () {
	        jQuery(".targetDiv").addClass("inactive");
	});
	jQuery("#div-" + _t).stop().slideDown(function () {
	        if (_t == "info") {
		jQuery(".line.toggle").removeClass("no-display");
	        } else {
		jQuery(".line.toggle").addClass("no-display");
	        }
	        jQuery("#div-" + _t).removeClass("inactive");
	});

	if (_t == "info") {
	        jQuery("#div-" + _t).css("height", "auto");
	}
*/
        });
        
        jQuery(".info-more").click(function (e) {
	e.preventDefault();
	jQuery(".info-less").removeClass("no-display");
	jQuery(".info-more").addClass("no-display");

	var el = $('#div-info .more'), curHeight = el.height(), autoHeight = el.css('height', 'auto').height()-4;
	el.height(curHeight).animate({height: autoHeight}, 500);
        });
        
        jQuery(".info-less").click(function (e) {
	e.preventDefault();
	jQuery(".info-less").addClass("no-display");
	jQuery(".info-more").removeClass("no-display");

	var el = $('#div-info .more'), curHeight = el.height(), autoHeight = el.css('height', '115px').height();
	el.height(curHeight).animate({height: autoHeight}, 500);
        });

        jQuery('#video-accordion').dcAccordion({
	classParent: 'video-accordion-parent',
	classActive: 'active',
	classArrow: 'video-accordion-icon',
	classCount: 'video-accordion-count',
	classExpand: 'video-accordion-current-parent',
	classDisable: '',
	eventType: 'click',
	hoverDelay: 300,
	menuClose: true,
	autoClose: true,
	autoExpand: false,
	speed: 'slow',
	saveState: true,
	disableLink: true,
	showCount: false,
	cookie: 'video-accordion-accordion'
        });
});


$(document).ready(function() {
        var owl = $('.playlist-carousel');
        if (typeof (owl.html()) !== "undefined") {
	owl.owlCarousel({
	        items: 4,
	        loop: false,
	        margin: 10,
	        autoplay: false,
	        dots: false,
	        nav: true,
	        navText: [
		"<i class='icon-chevron-left icon-white icon-previous'></i>",
		"<i class='icon-chevron-right icon-white icon-next'></i>"
	        ],
	        onInitialized: false,
	        responsive: {
		0: {
		        items: 1
		},
		470: {
		        items: 2
		},
		560: {
		        items: 2
		},
		640: {
		        items: 2
		},
		920: {
		        items: 3
		},
		1200: {
		        items: 3
		},
		1600: {
		        items: 4
		}
	        }
	});
        }
});



$(function () {
        $('#entry-action-pl').dlmenu({
	animationClasses: {classin: 'dl-animate-in-5', classout: 'dl-animate-out-5'}
        });
        $('#file-flag-reasons').dlmenu({
	animationClasses: {classin: 'dl-animate-in-5', classout: 'dl-animate-out-5'}
        });
});
if(typeof $(".js-textareacopybtn").html()!="undefined"){
var copyTextareaBtn = document.querySelector('.js-textareacopybtn');
copyTextareaBtn.addEventListener('click', function (event) {
        var copyTextarea = document.querySelector('.js-copytextarea');
        copyTextarea.select();
        try {
	var successful = document.execCommand('copy');
        } catch (err) {
        }
});
}
if (typeof $('.file-share-perma-short').html() != 'undefined') {
var copyTextareaBtn = document.querySelector('.js-textareacopybtn-p1');
copyTextareaBtn.addEventListener('click', function (event) {
        var copyTextarea = document.querySelector('.file-share-perma-short');
        copyTextarea.select();
        try {
	var successful = document.execCommand('copy');
        } catch (err) {
        }
});
}
if (typeof $('.file-share-perma-seo').html() != 'undefined') {
var copyTextareaBtn = document.querySelector('.js-textareacopybtn-p2');
copyTextareaBtn.addEventListener('click', function (event) {
        var copyTextarea = document.querySelector('.file-share-perma-seo');
        copyTextarea.select();
        try {
	var successful = document.execCommand('copy');
        } catch (err) {
        }
});
}
jQuery(document).on({
        click: function() {
        	t = $(this);
        	u = current_url + 'home?ap=';
        	if (t.is(':checked')) {
        		u += '1';
        	} else u += '0';
        	
        	$('#menu-trigger-response').load(u);
        }
}, "input[name=autoplay_switch_check]");

jQuery(document).on({
        click: function() {
        	t = $(this);
        	k = t.attr("rel-key");
        	tp = t.attr("rel-type");
        	u = current_url + menu_section + "?" + tp + "=" + k + "&do=recommend-more";
        	
        	$("#more-results").mask(" ");
        	$.get(u, function(data){
        		$(".suggested-list").fadeIn().append(data);
        		thumbFade();
        		$("#more-results").detach();
        	});
        }
}, ".related-more");

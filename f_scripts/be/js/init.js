$(function() {
        $( '#lang-menu-be' ).dlmenu({
                animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' }
        });
});

jQuery(document).ready(function(jQuery){
	$("#lang-menu-be .dl-menu").show();
	
            jQuery("input.gn-search").keyup(function() {
                    var _val = jQuery(this).val();
                    
                    jQuery("#categories-accordion").unhighlight();
                    jQuery("#categories-accordion").highlight(_val);

                    jQuery("a.dcjq-parent.active").each(function(){
                        var _ct = jQuery(this).html();
                        var _n = _ct.search("highlight");
                        
                        if(_n > 0) {
                        } else {
                            jQuery(this).removeClass("active");
                            jQuery(this).next().hide();
                        }
                    });

                    jQuery("span.highlight").each(function(){
                        if (jQuery(this).parent().parent().parent().css("display") == 'none') {
                            jQuery(this).parent().parent().parent().show();
                            jQuery(this).parent().parent().parent().prev().addClass("active");
                            
                            if (jQuery(this).parent().parent().parent().prev().parent().parent().css("display") == 'none') {
                                jQuery(this).parent().parent().parent().prev().parent().parent().show();
                                jQuery(this).parent().parent().parent().prev().parent().parent().prev().addClass("active");
                                
                                jQuery(this).parent().parent().parent().prev().parent().parent().parent().parent().show();
                                jQuery(this).parent().parent().parent().prev().parent().parent().parent().parent().prev().addClass("active");
                            }
                        } else {
                            jQuery(this).parent().addClass("active");
                            jQuery(this).parent().next().show();
                        }
                    });
                    
                    jQuery("#categories-accordion li a.dcjq-parent:not(.gn-icon-search)").each(function(){
                        if (!jQuery(this).hasClass("active")) {
                            jQuery(this).parent().hide();
                        } else {
                            jQuery(this).parent().show();
                        }
                    });
                    
                    if (_val == "") {
                        jQuery(".dcjq-parent-li").show();
                    }
            });
            
            
            jQuery('#categories-accordion').dcAccordion({
                    eventType: 'click',
                    autoClose: true,
                    saveState: false,
                    disableLink: false,
                    showCount: false,
                    menuClose: true,
                    speed: 300
            });

            if (jQuery(window).width() < 680) {
                    // Mobile view
 
                }
                else {
                    // Desktop view
                    var height = jQuery(window).height();
                    jQuery('.gn-menu-wrapper').css('min-height', height - 45);
            }
});

var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;

jQuery(document).on({
        click: function() {
                if ($('#user-arrow-box').hasClass('hidden')) {
                        $('#user-arrow-box').removeClass('hidden');
                        $('#notifications-arrow-box').addClass('hidden');
                } else {
                        $('#user-arrow-box').addClass('hidden');
                }
        }
}, ".own-profile-image.mt");
$(".container.cbp-spmenu-push").on("click", function(){
        if(!$('#user-arrow-box').hasClass('hidden'))
                $('#user-arrow-box').addClass('hidden');
});

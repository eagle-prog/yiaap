var holdPosition;
var newHeight;

var setSwipeFunct = function () {
    holdPosition = 0;
    var sidebar = jQuery('.sidebar-container').width();
    newHeight = (sidebar / 2.5);
};

var mySwiper = new Swiper('.swiper-container', {
    slidesPerView: "auto",
    mode: 'vertical',
    watchActiveIndex: true,
    onTouchStart: function () {
        holdPosition = 0;
    },
    onResistanceBefore: function (s, pos) {
        holdPosition = pos;
    },
    onTouchEnd: function () {
        if (holdPosition > newHeight) {
            // Hold Swiper in required position
            mySwiper.setWrapperTranslate(0, newHeight, 0);

            //Dissalow futher interactions
            mySwiper.params.onlyExternal = true;

            //Show loader
            jQuery('.preloader').addClass('visible');

            //Load slides
            loadNewSlides();
        }
    }
});

if ($("#wrapper").hasClass("tpl_browse")) {
	window.setInterval(function(){
		h = $('.swiper-slide:first').height();
		$('.swiper-slide:first').simulate("drag", {dy: h+10});
	}, 7777);
}

    function loadNewSlides() {
        var slideNumber = 0;
        /* 
         Probably you should do some Ajax Request here
         But we will just use setTimeout
         */
        setTimeout(function () {
            //Prepend new slide
            mySwiper.prependSlide($("#other section:first").html(), 'swiper-slide');

            //Release interactions and set wrapper
            mySwiper.setWrapperTranslate(0, 0, 0);
            mySwiper.params.onlyExternal = false;

            //Update active slide
            mySwiper.updateActiveSlide(0);

            //Hide loader
            jQuery('.preloader').removeClass('visible');

            $("#other section:first").detach();
        }, 450);

        slideNumber++;
    }


jQuery(window).resize(function () {
    setSwipeFunct();
});

jQuery(window).load(function () {
    setSwipeFunct();
});
$(document).ready(function(){
    
   
    var delay_time = 9000;
    var fadein_delay = 1000;
    var fadeout_delay=1000;
    var i=1;
    var slider_interval;
    var images_length = $(".home_slider").find(".home_slider_item").length;
    //console.log("length",images_length);
    function slideImage()
    {
        $(".home_slider_item:nth-child("+i+")").fadeOut(fadeout_delay);
         $(".slider_dots:nth-child("+i+")").removeClass("active");
        
        if(i<images_length)
            {
                i++;
            }
        else{
            i=1;
        }
        $(".home_slider_item:nth-child("+i+")").fadeIn(fadein_delay);
         $(".slider_dots:nth-child("+i+")").addClass("active");
    }
    $(".home_slider_item:nth-child("+i+")").fadeIn(fadein_delay);
    $(".slider_dots:nth-child("+i+")").addClass("active");
    slider_interval= setInterval(slideImage,delay_time);
    
    
});
 
    $(document).ready(function(){
       
        function static_pos(){
            $(".loginindexform").addClass("static_pos");
            $(".image_box").addClass("static_pos");
            $(".info_box_cover").addClass("static_pos");
            $(".footer_bottom").addClass("static_pos");
        }
        function absolute_pos()
        {
            $(".loginindexform").removeClass("static_pos");
            $(".image_box").removeClass("static_pos");
            $(".info_box_cover").removeClass("static_pos");
            $(".footer_bottom").removeClass("static_pos");
        }
        function check_height()
        {
            var h1 = $(".loheaderinnew").outerHeight(true);
            var h2 = $(".footer_bottom").height();
            var h3 = $(".image_box").height();
            var h4 = $(".info_box_cover").height();
            var h5 = $(".loginindexform").height();           
            var summ= h1+h2+h3+h4+h5;
            if($(window).height()< summ || $(window).height()<$(".page_wraper").height())
            {
                static_pos();
               // console.log("in static");
            }
            else{
                
                absolute_pos();
               // console.log("in absolute");
            }
        }
        check_height();
        
        $(window).resize(function(){
              check_height();
        });
    });
  
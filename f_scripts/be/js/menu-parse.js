function thisresizeDelimiter(){
	var cheight = parseInt(jQuery(".container").height());
	if (cheight < 1) {
		cheight = jQuery(".container>div.vs-column:first").height();
	}

        var wheight = jQuery(window).height();
        var fheight = cheight > wheight ? cheight : wheight;
        jQuery('.gn-menu-wrapper').css('min-height', fheight + 100);
}
$(window).resize(function(){
	thisresizeDelimiter();
});
function clearChart(obj) {
    if (typeof(obj) !== "undefined")
        obj.destroy();
}
$(document).ready(function() {
    $(".menu-panel-entry-sub").click(function(){
	var s_link	= '';
	var sub_id 	= $(this).attr("id");
	var brs 	= (sub_id.split("-"));
	var closest	= brs[0] + "-" + brs[1] + "-" + brs[2];
	var h2_title    = $("#"+sub_id+">span.bold").text();
        var menu_section = $(this).attr("rel-m");

	if($(this).hasClass("menu-panel-entry-sub-active")) return false;

	$(".menu-panel-entry").removeClass("menu-panel-entry-active");
	$(".menu-panel-entry-sub").removeClass("menu-panel-entry-sub-active");
	$("#"+closest).addClass("menu-panel-entry-active");
	$("#"+closest+"-sub-entries").addClass("menu-panel-entry");
	$(".menu-panel-entry>form>div.menu-panel-entry-sub").removeClass("menu-panel-entry-sub-active");
	$(".menu-panel-entry>div.menu-panel-entry-sub").removeClass("menu-panel-entry-sub-active");
	$(this).addClass("menu-panel-entry-sub-active");

	if(brs[0] == 'file'){
	    var s_type = (brs[3].substr(3)[0]);
	    var s_for = '';
	    switch(s_type) {
		case "v": s_for = 'sort-video';
		break;
		case "i": s_for = 'sort-image';
		break;
		case "a": s_for = 'sort-audio';
		break;
		case "d": s_for = 'sort-doc';
		break;
		case "b": s_for = 'sort-blog';
		break;
		case "l": s_for = 'sort-live';
		break;
	    }
	    s_link = '&for='+s_for;
	}
	if((brs[2] == 'entry11') || (brs[2] == 'entry6' && (brs[3] == 'sub1' || brs[3] == 'sub2' || brs[3] == 'sub3' || brs[3] == 'sub4' || brs[3] == 'sub5' || brs[3] == 'sub6'))){
	    var s_key = $(".sort-user-key").html();
	    s_link = (s_key !== null && s_key !== undefined) ? '&u='+s_key : "";
	}
        
        if (typeof(myLineChart1) !== "undefined") {myLineChart1.destroy();}
        if (typeof(myLineChart2) !== "undefined") {myLineChart2.destroy();}
        if (typeof(myLineChart3) !== "undefined") {myLineChart3.destroy();}
        if (typeof(myLineChart4) !== "undefined") {myLineChart4.destroy();}
        if (typeof(myLineChart5) !== "undefined") {myLineChart5.destroy();}
        if (typeof(myLineChart6) !== "undefined") {myLineChart6.destroy();}
        if (typeof(myLineChart7) !== "undefined") {myLineChart7.destroy();}
        if (typeof(myLineChart8) !== "undefined") {myLineChart8.destroy();}
        
        $(".mce-tinymce").detach();
        
	wrapLoad(current_url + menu_section + "?s="+sub_id+s_link, $(this));
    });
});
function wrapLoad(the_url, trg) {
	if (typeof(s_url) != 'undefined' && s_url == "uactivity" && typeof($("#uact-id").val()) != "undefined") { var id_trg = ".fancybox-inner"; }
	else if (trg == 'blog') { var id_trg = "#ct-wrapper"; }
	else {
		var id_trg = ".container";
	}

	if (trg !== null && typeof trg === 'object') {
	        $(trg).find("i").removeClass("iconBe-arrow-right").addClass("spinner icon-spinner");
	}
    $(id_trg).mask("");
    $(id_trg).load(the_url, function() {
	thisresizeDelimiter();
	$(id_trg).unmask();
	if (trg !== null && typeof trg === 'object') {
	        $(trg).find("i").addClass("iconBe-arrow-right").removeClass("spinner icon-spinner");
	}
	if ($("body").hasClass("media-width-480") || $("body").hasClass("media-width-320")) {
                smoothscrolltop();
        }
        if($(window).width()<=768&&$(".gn-icon").hasClass("gn-selected")){$("body").removeClass("media-push-full");$(".gn-menu-wrapper").removeClass("gn-open-all").css({"overflow":"hidden"});$(".gn-icon").removeClass("gn-selected");$(".container.cbp-spmenu-push").removeClass("cbp-spmenu-push-toright").removeClass("push-full");smoothscrolltop()}})}
    });
}
function postLoad(the_url, the_form, trg) {
    var id_trg = ".container";
    var mask = (typeof(trg) != 'undefined' ? trg : id_trg);

    if (trg == 'blog' || trg == 'live') { id_trg = "#mem-add-new-entry-wrapper"; mask = id_trg; }

    $(mask).mask("");
    $.post(the_url, $(the_form).serialize(), function(data) {
    	if (trg == 'blog' || trg == 'live') { id_trg = "#add-new-blog-response"; }
	$(id_trg).html(data);
	thisresizeDelimiter();
	$(mask).unmask();
	$(".tooltip").detach();
    	if ($("#backend-menu-entry3-sub13").hasClass("menu-panel-entry-sub-active")) {
    		$(the_form).find("li.entry-edit").addClass("active");
    	}
    });
}
function smoothscrolltop(){
    var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
    if (currentScroll > 0) {
         window.requestAnimationFrame(smoothscrolltop);
         window.scrollTo (0,currentScroll - (currentScroll/5));
    }
}

function mobilecheck() {
	var check = false;
	(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
}

function oldSafariCSSfix() {
	return;
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

function resizeDelimiter(){
//	var menu_height = $(".gn-menu-wrapper").height();
//	var container_height = $(".container").height();
//	var window_height = $(window).height();

	var cheight = parseInt(jQuery(".container").height());
	if (cheight < 1) {
		cheight = jQuery(".container>div.vs-column:first").height();
	}

        var wheight = jQuery(window).height();
        var fheight = cheight > wheight ? cheight : wheight;

        jQuery('.gn-menu-wrapper').css('min-height', fheight + 100);
        //jQuery('.gn-menu-wrapper').css('min-height', fheight);
}
$(window).resize(function(){
	resizeDelimiter();
});
function clearChart(obj) {
    if (typeof(obj) !== "undefined")
        obj.destroy();
}
$(document).ready(function() {
//    $(".menu-panel-entry-sub, .menu-panel-entry").mouseover(function(){
//	var px = (!$(this).hasClass("pl-entry")) ? '20px' : '30px';
//	if(!$(this).hasClass("menu-panel-entry-sub-active")) { $(this).addClass("menu-panel-entry-roll-active"); }
//	if($(this).hasClass("be-panel")) return;
//	$(this).stop().animate({"padding-left":px},{queue:true, duration:"fast"});
//    }).mouseout(function(){
//	var px = (!$(this).hasClass("pl-entry")) ? '10px' : '20px';
//	$(this).removeClass("menu-panel-entry-roll-active");
//	if($(this).hasClass("be-panel")) return;
//	$(this).stop().animate({"padding-left":px},{queue:true, duration:"fast"});
//    });

    $(".menu-panel-entry-sub").click(function(){
	var s_link	= '';
	var sub_id 	= $(this).attr("id");
	var brs 	= (sub_id.split("-"));
	var closest	= brs[0] + "-" + brs[1] + "-" + brs[2];
	var h2_title    = $("#"+sub_id+">span.bold").text();
        var menu_section = $(this).attr("rel-m");

	if($(this).hasClass("menu-panel-entry-sub-active")) return false;

	//$("h2").text(h2_title);
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
	    }
	    s_link = '&for='+s_for;
	}
	if((brs[2] == 'entry11') || (brs[2] == 'entry6' && (brs[3] == 'sub1' || brs[3] == 'sub2' || brs[3] == 'sub3' || brs[3] == 'sub4'))){
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
            
	wrapLoad(current_url + menu_section + "?s="+sub_id+s_link, 'col');
    });
//    $(".menu-panel-entry").click(function(){
//	var current_id = $(this).attr("id");
//	var h2_title   = $("#"+current_id+" span.bold").text();
//
//	if($(this).hasClass("menu-panel-entry-active") && !$(".menu-panel-entry-sub").hasClass("menu-panel-entry-sub-active")) return false;
//	if($(this).hasClass("be-panel")){
//            $("h2").text(h2_title);
//        }
//
//	if($("#sort-order").html() != ''){
//	    if($(this).hasClass("pl-entry")){
//		var ft = current_id.substr(20)[0];
//		switch(ft){
//		    case "v":
//			$(".type-menu").removeClass("sort-active");
//			$(".ftype").each(function(){if($(this).attr("id") == "sort-video"){$(this).addClass("sort-active");}});
//			$("#type-menu-val, #file-type-div-val").each(function(){$(this).val("sort-video");});
//		    break;
//		    case "i":
//			$(".type-menu").removeClass("sort-active");
//			$(".ftype").each(function(){if($(this).attr("id") == "sort-image"){$(this).addClass("sort-active");}});
//			$("#type-menu-val, #file-type-div-val").each(function(){$(this).val("sort-image");});
//		    break;
//		    case "a":
//			$(".type-menu").removeClass("sort-active");
//			$(".ftype").each(function(){if($(this).attr("id") == "sort-audio"){$(this).addClass("sort-active");}});
//			$("#type-menu-val, #file-type-div-val").each(function(){$(this).val("sort-audio");});
//		    break;
//		    case "d":
//			$(".type-menu").removeClass("sort-active");
//			$(".ftype").each(function(){if($(this).attr("id") == "sort-doc"){$(this).addClass("sort-active");}});
//			$("#type-menu-val, #file-type-div-val").each(function(){$(this).val("sort-doc");});
//		    break;
//		}
//		$("#sort-order").removeClass("no-display");
//	    } else {
//		$("#sort-order").addClass("no-display");
//	    }
//	}
//	if(current_id == "file-menu-entry6"){//pls
//	    $("#sort-file-actions").addClass("no-display");
//	    $("#sort-playlist-actions").removeClass("no-display");
//	    $("#sort-commresp-actions").addClass("no-display");
//	    if($("#sort-file-actions").hasClass("no-display")){
//		$("#sort-recent").addClass("sort-active");
//		$("#file-sort-div-val").val("sort-recent");
//	    }
//	} else if (current_id != "file-menu-entry7" && current_id != "file-menu-entry8"){//rest
//	    if($("#sort-file-actions").hasClass("no-display")){
//		$("#sort-file-actions").removeClass("no-display");
//		$("#sort-playlist-actions").addClass("no-display");
//		$("#sort-commresp-actions").addClass("no-display");
//	    $("#file-sort-div-val").val("sort-recent");
//		$("#sort-recent").addClass("sort-active");
//	    }
//	} else {
//	    $("#sort-file-actions").addClass("no-display");
//	    $("#sort-playlist-actions").addClass("no-display");
//	    $("#sort-commresp-actions").removeClass("no-display");
//
//	    if($("#sort-file-actions").hasClass("no-display")){
//		$("#cr-approved").addClass("sort-active");
//		$("#file-sort-div-val").val("cr-approved");
//	    }
//
//	    if(current_id == "file-menu-entry8"){//resp
//		$("#sort-for-text").text($("#sort-for-text-resp").text());
//		$("#"+$("#file-type-div-val").val()).addClass("sort-active");
//		$("#sort-commresp-actions #"+$("#file-type-div-val").val()).addClass("sort-active");
//	    } else {//comm
//		$("#sort-for-text").text($("#sort-for-text-comm").text());
//		$("#"+$("#file-type-div-val").val()).addClass("sort-active");
//		$("#sort-commresp-actions #"+$("#file-type-div-val").val()).addClass("sort-active");
//	    }
//	}
//	$(".menu-panel-entry-sub, .menu-panel-entry").removeClass("menu-panel-entry-sub-active");
//	$(".menu-panel-entry").removeClass("menu-panel-entry-active");
//	$(this).addClass("menu-panel-entry-active");
//
//	if($(this).hasClass("mm-search")){
//	    var fe_link = "?q="+encodeURIComponent($("#search-query").val())+"&do=ct-load&show="+$(".menu-panel-entry-active").attr("id")+($(".menu-panel-entry-active").attr("id") == "search-pl" ? "&for="+$(".type-menu.sort-active").attr("id") : "")+"&sort="+$(".sort-active").attr("id");
//	    switch($(this).attr("id")){
//		case "search-vfiles":
//		case "search-ifiles":
//		case "search-afiles":
//		case "search-dfiles":
//		    $("#most-views, #sort-rating").removeClass("no-display");
//		    $(".load-arrows").addClass("no-display"); $(".vm-files").removeClass("no-display");
//		    $("#type-menu").addClass("no-display");
//		break;
//		case "search-pl":
//		    $("#most-views, #sort-rating").addClass("no-display");
//		    $(".load-arrows").addClass("no-display"); $(".vm-pl").removeClass("no-display");
//		    $("#type-menu").removeClass("no-display");
//		break;
//		case "search-ch":
//		    $("#most-views").removeClass("no-display");
//		    $("#sort-rating").addClass("no-display");
//		    $(".load-arrows").addClass("no-display"); $(".vm-ch").removeClass("no-display");
//		    $("#type-menu").addClass("no-display");
//		break;
//	    }
//	    wrapLoad(current_url + menu_section + fe_link);
//	    return;
//	}
//	if(typeof(fe_mask) != 'undefined') {
//	    if(typeof($("#file-sort-div-val").val()) != "undefined"){
//		var fe_link = '&do='+$("#file-sort-div-val").val()+'&for='+($("#type-menu-val").val() != "sort-" ? $("#type-menu-val").val() : $("#file-type-div-val").val());
//	    } else if (typeof(s_url) !== 'undefined') {
//		if(s_url == 'channels'){
//		    var fe_link = '&sort='+$(".sort-active").attr("id");
//		}
//		if(s_url == 'search'){
//		    var fe_link = '&sort='+$(".sort-active").attr("id");
//		}
//	    } else var fe_link = '';
//    	    wrapLoad(current_url + menu_section + "?s="+current_id+fe_link);
//	} else {
//	    var u_url = '';
//	    if(current_id == 'backend-menu-entry6' || current_id == 'backend-menu-entry11'){
//		u_url = '&u='+$("#p-user-key").val();
//	    }
//	    wrapLoad(current_url + menu_section + "?s="+current_id+u_url);
//	}
//    });
//    $(".tree_expand").die().live("click", function(){
//	var current_id = $(this).prev().attr("id");
//
//	$(this).addClass("no-display").next().removeClass("no-display");
//	$("#"+current_id+"-sub-entries").css("display", "block");
//	resizeDelimiter();
//    });
//    $(".tree_collapse").die().live("click", function(){
//	var current_id = $(this).prev().prev().attr("id");
//
//	$(this).addClass("no-display").prev().removeClass("no-display");
//	$("#"+current_id+"-sub-entries").css("display", "none");
//	resizeDelimiter();
//    });

    //resizeDelimiter();
});
function wrapLoad(the_url, trg) {
//    if(typeof(trg) != 'undefined' && trg != "menu" && trg != "browse") { var id_trg = ".col1"; }
//    else if (trg == "menu") { var id_trg = ".col2"; } 
//    else if (typeof(s_url) != 'undefined' && s_url == "main") { var id_trg = "#home-left-list"; }
//    else if (typeof(s_url) != 'undefined' && s_url == "browse") { var id_trg = ".col-left-ct"; }
//    else if (typeof(s_url) != 'undefined' && s_url == "playlists") { var id_trg = ".col-left-ct"; }
//    else if (typeof(s_url) != 'undefined' && s_url == "channels") { var id_trg = ".col-left-ct"; }
//    else if (typeof(s_url) != 'undefined' && s_url == "search") { var id_trg = ".col-left-ct"; }
//    else if (typeof(s_url) != 'undefined' && s_url == "uactivity" && $("#popuprel"+$("#uact-id").val()).css("display") != "none" && typeof($("#uact-id").val()) != "undefined") { var id_trg = "#popuprel"+$("#uact-id").val(); } 
//    else { var id_trg = ".col1"; }
//
//    $(((id_trg == ".col-left-ct" && s_url == "browse") ? "#v-thumbs" : 
//	((id_trg == ".col-left-ct" && s_url == "playlists") ? ".main-playlists" : 
//	((id_trg == ".col-left-ct" && s_url == "channels") ? ".main-channels" : 
//	((id_trg == ".col-left-ct" && s_url == "search") ? "#v-thumbs" : id_trg))))).mask(" ");

	if (typeof(s_url) != 'undefined' && s_url == "uactivity" && typeof($("#uact-id").val()) != "undefined") { var id_trg = ".fancybox-inner"; }
	else {
		var id_trg = ".container";
	}

    $(id_trg).mask("Loading...");

    $(id_trg).load(the_url, function() {
	resizeDelimiter();
	$(id_trg).unmask();
	
/*	if (mobilecheck()) {
		setTimeout(function () {
			$("body").trigger("click");
		}, 200);
	}*/
    });
}
function postLoad(the_url, the_form, trg) {
//    if(typeof(trg) != 'undefined' && trg != "menu") { var id_trg = ".col1"; } else if (trg == "menu") { var id_trg = ".col2"; } else { var id_trg = ".col1"; }
    var id_trg = ".container";
    
    $(id_trg).mask(" ");
//
    $.post(the_url, $(the_form).serialize(), function(data) {
	$(id_trg).html(data);
	resizeDelimiter();
	$(id_trg).unmask();
	if(trg == "menu" && the_form == "#add-new-label-form") { closeDiv("add-new-label"); $(".new-label").removeClass("form-button-active"); $("#add-new-label-input").attr("value", ""); }
    });
}
//
//function delConfirm(message, del_url) {
//    var answer = confirm(message);
//    if (answer){
//	wrapLoad(del_url);
//	$(".ct-entry").unbind('click');
//	return false;
//    }
//    return false;
//}
function mobilecheck() {
	var check = false;
	(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
}

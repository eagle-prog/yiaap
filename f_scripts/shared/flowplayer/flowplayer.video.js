function extCheck(e){
    e = e.substr(-3);
    return (e == "ebm" ? "webm" : e);
}
function loadVideo(o, vUrl, tUrl) {
    var fSrc = o.attr("rel-fsrc");
    var fSrcarr = fSrc.split(",");
    var vTitle = o.attr("rel-title");
    var vImage = tUrl+o.attr("rel-usr")+"/t/"+o.attr("rel-key")+"/0.jpg";
    var api = $("#player-loader").data("flowplayer");

    api.bind("seek", function(e, api) {
        $(".flowplayer").addClass("cue0");
    });

    var count1 = (fSrc.match(/360p/g) || []).length;
    var count2 = (fSrc.match(/480p/g) || []).length;
    var count3 = (fSrc.match(/720p/g) || []).length;

    /* load 360p files */
    $("#player-loader").css("background", "#000 url("+vImage+") no-repeat center center");

    if(count1 == 1 || count1 == 2 || count1 == 3){
	if(typeof($(".fsrc-360p").html()) == "undefined"){ 
            $(".info0").append('<a href="javascript:;" class="fsrc-360p factive">360p</a>');
        } else {
	    $(".fsrc-360p").replaceWith('<a href="javascript:;" class="fsrc-360p factive">360p</a>');
	}
    }
    if(count2 == 1 || count2 == 2 || count2 == 3){
	if(typeof($(".fsrc-480p").html()) == "undefined"){ 
            $(".info0").append('<a href="javascript:;" class="fsrc-480p">480p</a>'); 
        }  else {
	    $(".fsrc-480p").replaceWith('<a href="javascript:;" class="fsrc-480p'+(count1 == 0 ? " factive" : "")+'">480p</a>');
	}
    }
    if(count3 == 1 || count3 == 2 || count3 == 3){
	if(typeof($(".fsrc-720p").html()) == "undefined"){
	    $(".info0").append('<a href="javascript:;" class="fsrc-720p">720p</a>');
	} else {
	    $(".fsrc-720p").replaceWith('<a href="javascript:;" class="fsrc-720p">720p</a>');
	}
    }

    if(count1 == 0){
	if(typeof($(".fsrc-360p").html()) != "undefined"){
	    $(".fsrc-360p").replaceWith("");
	}
    }
    if(count2 == 0){
	if(typeof($(".fsrc-480p").html()) != "undefined"){
	    $(".fsrc-480p").replaceWith("");
	}
    }
    if(count3 == 0){
	if(typeof($(".fsrc-720p").html()) != "undefined"){
	    $(".fsrc-720p").replaceWith("");
	}
    }
    
    if((count2 == 0 && count3 == 0) || (count1 == 0 && count2 == 0) || (count1 == 0 && count3 == 0)){
	if(typeof($(".fsrc-360p").html()) != "undefined"){
            $(".fsrc-360p").replaceWith("");
        }
	if(typeof($(".fsrc-480p").html()) != "undefined"){
            $(".fsrc-480p").replaceWith("");
        }
	if(typeof($(".fsrc-720p").html()) != "undefined"){
            $(".fsrc-720p").replaceWith("");
        }
    }
    /* load 360p files */
    if(count1 == 1 || count1 == 2 || count1 == 3){
	var vLabel = '360p';
	var vKey = o.attr("rel-key");
	
	if(vUrl.charAt(0) == "r"){ api.load([{ mp4: "mp4:"+o.attr("rel-usr")+"/v/"+vKey+".360p.mp4" }]); return; }

	if(count1 == 1){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];

	    if(extCheck(vFile1) == "mp4"){
		api.load([{ mp4: vUrl+vFile1 }]);
	    } else if (extCheck(vFile1) == "webm"){
                api.load([{ webm: vUrl+vFile1 }]);
            } else if (extCheck(vFile1) == "ogv"){
                api.load([{ ogg: vUrl+vFile1 }]);
            }
	}
	else if(count1 == 2){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];
	    var vFile2 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[1];

	    if(extCheck(vFile1) == "mp4" && extCheck(vFile2) == "webm"){
		api.load([{ mp4: vUrl+vFile1 }, { webm: vUrl+vFile2 }]);
	    } else if (extCheck(vFile1) == "mp4" && extCheck(vFile2) == "ogv"){
                api.load([{ mp4: vUrl+vFile1 }, { ogg: vUrl+vFile2 }]);
            } else if (extCheck(vFile1) == "webm" && extCheck(vFile2) == "ogv"){
                api.load([{ webm: vUrl+vFile1 }, { ogg: vUrl+vFile2 }]);
            }
	}
	else if(count1 == 3){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];
	    var vFile2 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[1];
	    var vFile3 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[2];
	    alert(vUrl+vFile1);

    	    api.load([{mp4: vUrl+vFile1},{webm: vUrl+vFile2},{ogv: vUrl+vFile3}], function(){
    	    });
	}
    }
    /* load 480p files */
    if(count1 == 0 && (count2 == 1 || count2 == 2 || count2 == 3) && count3 == 0){
	var vLabel = '480p';
	var vKey = o.attr("rel-key");

//	if(vUrl.charAt(0) == "r"){ api.load([{ mp4: "mp4:"+o.attr("rel-usr")+"/v/"+vKey+".360p.mp4" }]); return; }

	if(count2 == 1){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];

	    if(extCheck(vFile1) == "mp4"){
		api.load([{ mp4: vUrl+vFile1 }]);
	    } else if (extCheck(vFile1) == "webm"){
                api.load([{ webm: vUrl+vFile1 }]);
            } else if (extCheck(vFile1) == "ogv"){
                api.load([{ ogg: vUrl+vFile1 }]);
            }
	}
	else if(count2 == 2){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];
	    var vFile2 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[1];

	    if(extCheck(vFile1) == "mp4" && extCheck(vFile2) == "webm"){
		api.load([{ mp4: vUrl+vFile1 }, { webm: vUrl+vFile2 }]);
	    } else if (extCheck(vFile1) == "mp4" && extCheck(vFile2) == "ogv"){
                api.load([{ mp4: vUrl+vFile1 }, { ogg: vUrl+vFile2 }]);
            } else if (extCheck(vFile1) == "webm" && extCheck(vFile2) == "ogv"){
                api.load([{ webm: vUrl+vFile1 }, { ogg: vUrl+vFile2 }]);
            }
	}
	else if(count2 == 3){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];
	    var vFile2 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[1];
	    var vFile3 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[2];

    	    api.load([{mp4: vUrl+vFile1},{webm: vUrl+vFile2},{ogv: vUrl+vFile3}]);
	}
    }
    /* load 720p files */
    if(count1 == 0 && count2 == 0 && (count3 == 1 || count3 == 2 || count3 == 3)){
	var vLabel = '720p';
	var vKey = o.attr("rel-key");

	if(vUrl.charAt(0) == "r"){ api.load([{ mp4: "mp4:"+o.attr("rel-usr")+"/v/"+vKey+".360p.mp4" }]); return; }

	if(count3 == 1){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];

	    if(extCheck(vFile1) == "mp4"){
		api.load([{ mp4: vUrl+vFile1 }]);
	    } else if (extCheck(vFile1) == "webm"){
                api.load([{ webm: vUrl+vFile1 }]);
            } else if (extCheck(vFile1) == "ogv"){
                api.load([{ ogg: vUrl+vFile1 }]);
            }
	}
	else if(count3 == 2){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];
	    var vFile2 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[1];

	    if(extCheck(vFile1) == "mp4" && extCheck(vFile2) == "webm"){
		api.load([{ mp4: vUrl+vFile1 }, { webm: vUrl+vFile2 }]);
	    } else if (extCheck(vFile1) == "mp4" && extCheck(vFile2) == "ogv"){
                api.load([{ mp4: vUrl+vFile1 }, { ogg: vUrl+vFile2 }]);
            } else if (extCheck(vFile1) == "webm" && extCheck(vFile2) == "ogv"){
                api.load([{ webm: vUrl+vFile1 }, { ogg: vUrl+vFile2 }]);
            }
	}
	else if(count3 == 3){
	    var vFile1 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[0];
	    var vFile2 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[1];
	    var vFile3 = o.attr("rel-usr")+"/v/"+vKey+"."+fSrcarr[2];

    	    api.load([{mp4: vUrl+vFile1},{webm: vUrl+vFile2},{ogv: vUrl+vFile3}]);
	}
    }
}

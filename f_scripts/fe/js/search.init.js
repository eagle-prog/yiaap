$(document).ready(function() {
	$(".filter-tag").on("click", function() {
		t = $(this);
		v = t.attr("rel-val");
		f = t.attr("rel-type");
		
		r = "&" + f + "=" + v;
		
		if (f == "tf") {
			url = current_url + search_menu_section + "?q=" + encodeURIComponent(q).replace(/%20/g, "+");
		} else {
			url = window.location.href.replace(r, "");
		}
		
		window.location = url;
		return false;
	});
	
	$(".filter-type").on("click", function() {
		t = $(this);
		
		if (t.hasClass("filter-off")) {
			return;
		}
		
		v = t.attr("rel-val");
		url = current_url + search_menu_section + "?tf=" + v + "&q=" + encodeURIComponent(q).replace(/%20/g, "+");
		
		$("#filter-type-val").text(v);
		
		window.location = url;
		return false;
	});
	$(".filter-upload").on("click", function() {
		t = $(this);
		
		if (t.hasClass("filter-off")) {
			return;
		}
		
		v = t.attr("rel-val");
		
		$("#filter-upload-val").text(v);
		
		window.location = searchURL();
		return false;
	});
	$(".filter-dur").on("click", function() {
		t = $(this);
		
		if (t.hasClass("filter-off")) {
			return;
		}
		
		v = t.attr("rel-val");
		
		$("#filter-dur-val").text(v);
		
		window.location = searchURL();
		return false;
	});
	$(".filter-feat").on("click", function() {
		t = $(this);
		
		if (t.hasClass("filter-off")) {
			return;
		}
		
		v = t.attr("rel-val");
		
		$("#filter-feat-val").text(v);
		
		window.location = searchURL();
		return false;
	});
});

function searchURL() {
	base = current_url + search_menu_section;
	str = encodeURIComponent(q).replace(/%20/g, "+");
	
	t = parseInt($("#filter-type-val").text());
	t = t == 0 ? 1 : t;
	u = parseInt($("#filter-upload-val").text());
	d = parseInt($("#filter-dur-val").text());
	f = parseInt($("#filter-feat-val").text());
	
	base += "?tf=" + t;
	if (u > 0) {
		base += "&uf=" + u;
	}
	if (d > 0) {
		base += "&df=" + d;
	}
	if (f > 0) {
		base += "&ff=" + f;
	}
	base += "&q=" + str;
	
	return base;
}
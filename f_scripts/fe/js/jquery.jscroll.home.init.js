$(function() {
	$('.load-more').Lazy({
		moreLoader: function(element, response) {
		
		p = $('.load-more').attr('rel-p');

		$('.load-more').mask(" ");
		$.get(current_url + menu_section + '?sub&p='+p, function(data){
		    $(data).insertBefore('.load-more');
		    $('.load-more').attr('rel-p', parseInt(p)+1);
		    $('.load-more').unmask();

		    thumbFade();
		    owl = $('.view-list:not(.owl-loaded)');

		    owl.each(function() {
			t = $(this);
			to = 360;
			//turn off buttons if last or first - after change
			owl.on('initialized.owl.carousel', function (event) { t = $(this);toggleArrows(t); });
			owl.on('translated.owl.carousel', function (event) { t = $(this);toggleArrows(t); });
			owl.on('translate.owl.carousel', function (event) { setTimeout(function(){thumbFade()}, to) });
		    });
		    
		    owlinit(owl);


			$('.load-more-sub').Lazy({
				threshold: 300,
				pageLoader: function(element){
		p = $('.load-more-sub').attr('rel-p');

		$('.load-more').mask(" ");
		$.get(current_url + menu_section + '?sub&p='+p, function(data){
		    $(data).insertBefore('.load-more-sub');
		    $('.load-more-sub').attr('rel-p', parseInt(p)+1);
		    $('.load-more').unmask();

		    if (parseInt(p) == 3) {
			$('.load-more-sub').replaceWith('<div id="load-categ" rel-p="1" data-loader="moreLoader"></div>');
			$('#load-categ').mask(" ");
		$.get(current_url + menu_section + '?categ', function(cdata){
		    $(cdata).insertBefore('#load-categ');
		    
			$('#load-categ').detach();
		    thumbFade()
		    owl = $('.view-list:not(.owl-loaded)');

		    owl.each(function() {
			t = $(this);
			to = 360;
			//turn off buttons if last or first - after change
			owl.on('initialized.owl.carousel', function (event) { t = $(this);toggleArrows(t); });
			owl.on('translated.owl.carousel', function (event) { t = $(this);toggleArrows(t); });
			owl.on('translate.owl.carousel', function (event) { setTimeout(function(){thumbFade()}, to) });
		    });
		    
		    owlinit(owl);
		});
		    }
		    
		    thumbFade();
		    owl = $('.view-list:not(.owl-loaded)');

		    owl.each(function() {
			t = $(this);
			to = 360;
			//turn off buttons if last or first - after change
			owl.on('initialized.owl.carousel', function (event) { t = $(this);toggleArrows(t); });
			owl.on('translated.owl.carousel', function (event) { t = $(this);toggleArrows(t); });
			owl.on('translate.owl.carousel', function (event) { setTimeout(function(){thumbFade()}, to) });
		    });
		    
		    owlinit(owl);
		    });
				}
			});

		});
		}
	});
});
function toggleArrows(t){
                if(t.find(".owl-item").last().hasClass('active') &&
                   t.find(".owl-item.active").index() == t.find(".owl-item").first().index()){
                    t.find('.owl-nav .owl-next').addClass("off");
                    t.find('.owl-nav .owl-prev').addClass("off");
                }
                //disable next
                else if(t.find(".owl-item").last().hasClass('active')){
                    t.find('.owl-nav .owl-next').addClass("off");
                    t.find('.owl-nav .owl-prev').removeClass("off");
                }
                //disable previus
                else if(t.find(".owl-item.active").index() == t.find(".owl-item").first().index()) {
                    t.find('.owl-nav .owl-next').removeClass("off");
                    t.find('.owl-nav .owl-prev').addClass("off");
                }
                else{
                    t.find('.owl-nav .owl-next,.owl-nav .owl-prev').removeClass("off");
                }
}


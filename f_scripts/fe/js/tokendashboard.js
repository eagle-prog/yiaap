google.load("visualization", "1", {packages:["corechart"]});


jQuery(window).load(function(){
    jQuery(document).on({
	click: function () {
            var _sel = new Array;
	    jQuery(".this-week-filter").each(function(index, value){
                if (jQuery(this).is(":checked")) {
                    _sel[index] = jQuery(this).val();
                } else {
                    _sel[index] = '0';
                }
            });
            var f = $('#filter-section-sub a.active').attr('rel-t');

            myLineChart1.destroy();
            thisWeekdata = ((f == '' || f == 'week') ? thisWeek(_sel) : (f == 'month' ? thisMonth(_sel) : (f == 'year' ? thisYear(_sel) : [])));
            myLineChart1 = new Chart(makeCanvas('chart-1-container')).Bar(thisWeekdata);
            generateLegend('legend-1-container', thisWeekdata.datasets);
	}
    }, "#this-week-uploads");
});

jQuery(window).load(function(){
    jQuery(document).on({
	click: function () {
            var _sel = new Array;
	    jQuery(".last-week-filter").each(function(index, value){
                if (jQuery(this).is(":checked")) {
                    _sel[index] = jQuery(this).val();
                } else {
                    _sel[index] = '0';
                }
            });
            var f = $('#filter-section-sub a.active').attr('rel-t');

            myLineChart2.destroy();
            lastWeekdata = ((f == '' || f == 'week') ? lastWeek(_sel) : (f == 'month' ? lastMonth(_sel) : (f == 'year' ? lastYear(_sel) : [])));
            myLineChart2 = new Chart(makeCanvas('chart-2-container')).Bar(lastWeekdata);
            generateLegend('legend-2-container', lastWeekdata.datasets);
	}
    }, "#last-week-uploads");
});




function thisWeek(_sel) {
    var ds = [];
    _sel = _sel || '';

    _s = {
        label: "Tokens Received",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: sw1
    };
    if (_sel == '' || _sel.indexOf("s") >= 0)
    	ds.push(_s);


    var data = {
        labels: generateWeekLabels("this"),
        datasets: ds
    };

    return data;
}

function thisMonth(_sel) {
    var ds = [];
    _sel = _sel || '';

    _s = {
        label: "Tokens Received",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: sw1
    };
    if (_sel == '' || _sel.indexOf("s") >= 0)
    	ds.push(_s);

    var data = {
        labels: generateMonthLabels("this"),
        datasets: ds
    };

    return data;
}

function thisYear(_sel) {
    var ds = [];
    _sel = _sel || '';

    _s = {
        label: "Tokens Received",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: sw1
    };
    if (_sel == '' || _sel.indexOf("s") >= 0)
    	ds.push(_s);

    var data = {
        labels: generateUserYearLabels("this"),
        datasets: ds
    };

    return data;
}

function thisWeek_subs(_sel) {
    _sel = _sel || '';
    
    //_e = (ecount["total"] !== '' && (_sel == '' || _sel.indexOf("e") >= 0)) ? {
    _e = (_sel == '' || _sel.indexOf("e") >= 0) ? {
        label: "Donations",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: tws
    } : {};

    var data = {
        labels: generateWeekLabels("this"),
        datasets: [
            _e
        ]
    };

    return data;
}

function thisMonth_subs(_sel) {
    _sel = _sel || '';
    
    //_e = (ecount["total"] !== '' && (_sel == '' || _sel.indexOf("e") >= 0)) ? {
    _e = (_sel == '' || _sel.indexOf("e") >= 0) ? {
        label: "Donations",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: tws
    } : {};

    var data = {
        labels: generateMonthLabels("this"),
        datasets: [
            _e
        ]
    };

    return data;
}

function thisYear_subs(_sel) {
    _sel = _sel || '';
    
    //_e = (ecount["total"] !== '' && (_sel == '' || _sel.indexOf("e") >= 0)) ? {
    _e = (_sel == '' || _sel.indexOf("e") >= 0) ? {
        label: "Donations",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: tws
    } : {};

    var data = {
        labels: generateUserYearLabels("this"),
        datasets: [
            _e
        ]
    };

    return data;
}

function lastWeek(_sel) {
    var ds = [];
    _sel = _sel || '';

    _s = {
        label: "Tokens Received",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: sw2
    };
    if (_sel == '' || _sel.indexOf("s") >= 0)
    	ds.push(_s);

    var data = {
        labels: generateWeekLabels("last"),
        datasets: ds
    };

    return data;
}
function lastMonth(_sel) {
    var ds = [];
    _sel = _sel || '';

    _s = {
        label: "Tokens Received",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: sw2
    };
    if (_sel == '' || _sel.indexOf("s") >= 0)
    	ds.push(_s);

    var data = {
        labels: generateMonthLabels("last"),
        datasets: ds
    };

    return data;
}

function lastYear(_sel) {
    var ds = [];
    _sel = _sel || '';

    _s = {
        label: "Tokens Received",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: sw2
    };
    if (_sel == '' || _sel.indexOf("s") >= 0)
    	ds.push(_s);

    var data = {
        labels: generateUserYearLabels("last"),
        datasets: ds
    };

    return data;
}

function lastWeek_subs(_sel) {
    _sel = _sel || '';
    
    _e = (ecount["total"] !== '' && (_sel == '' || _sel.indexOf("e") >= 0)) ? {
        label: "Donations",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: lws
    } : {};

    var data = {
        labels: generateWeekLabels("last"),
        datasets: [
            _e
        ]
    };

    return data;
}

function lastMonth_subs(_sel) {
    _sel = _sel || '';
    
    _e = (ecount["total"] !== '' && (_sel == '' || _sel.indexOf("e") >= 0)) ? {
        label: "Donations",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: lws
    } : {};

    var data = {
        labels: generateMonthLabels("last"),
        datasets: [
            _e
        ]
    };

    return data;
}

function lastYear_subs(_sel) {
    _sel = _sel || '';
    
    _e = (ecount["total"] !== '' && (_sel == '' || _sel.indexOf("e") >= 0)) ? {
        label: "Donations",
        fillColor: "rgba(133, 187, 101,0.5)",
        strokeColor: "rgba(133, 187, 101,1)",
        pointColor: "rgba(133, 187, 101,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(133, 187, 101,1)",
        data: lws
    } : {};

    var data = {
        labels: generateUserYearLabels("last"),
        datasets: [
            _e
        ]
    };

    return data;
}


function memberData() {
    // Some raw data (not necessarily accurate)
    var data = {
        labels: generateUserWeekLabels(),
        datasets: [
            {
                label: "This Week",
                fillColor: "rgba(133, 187, 101,0.2)",
                strokeColor: "rgba(133, 187, 101,1)",
                pointColor: "rgba(133, 187, 101,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(133, 187, 101,1)",
                data: this_week_users.split(",")
            },
            {
                label: "Last Week",
                fillColor: "rgba(155, 101, 187,0.2)",
                strokeColor: "rgba(155, 101, 187,1)",
                pointColor: "rgba(155, 101, 187,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(155, 101, 187,1)",
                data: last_week_users.split(",")
            }
        ]
    };

    return data;
}

function userData() {
    // Some raw data (not necessarily accurate)
    var data = {
        labels: generateUserYearLabels(),
        datasets: [
            {
                label: "This Year",
                fillColor: "rgba(133, 187, 101,0.2)",
                strokeColor: "rgba(133, 187, 101,1)",
                pointColor: "rgba(133, 187, 101,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(133, 187, 101,1)",
                data: this_year_earnings.split(",")
            },
            {
                label: "Last Year",
                fillColor: "rgba(155, 101, 187,0.2)",
                strokeColor: "rgba(155, 101, 187,1)",
                pointColor: "rgba(155, 101, 187,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(155, 101, 187,1)",
                data: last_year_earnings.split(",")
            }
        ]
    };

    return data;
}

Chart.defaults.global.animation = true;
Chart.defaults.global.animationSteps = 60;
Chart.defaults.global.animationEasing = 'easeInOutQuart';
Chart.defaults.global.responsive = true;
Chart.defaults.global.maintainAspectRatio = false;

function drawChart1() {
    var f = $('#filter-section-sub a.active').attr('rel-t');
    var thisWeekdata = ((f == '' || f == 'week') ? thisWeek() : (f == 'month' ? thisMonth() : (f == 'year' ? thisYear() : [])));
    var myLineChart1 = new Chart(makeCanvas('chart-1-container')).Bar(thisWeekdata);
    generateLegend('legend-1-container', thisWeekdata.datasets);

    return myLineChart1;
}
var myLineChart1 = drawChart1();

function drawChart1a() {
    var f = $('#filter-section-sub a.active').attr('rel-t');
    var thisWeekdata = ((f == '' || f == 'week') ? thisWeek_subs() : (f == 'month' ? thisMonth_subs() : (f == 'year' ? thisYear_subs() : [])));
    var myLineChart1a = new Chart(makeCanvas('chart-1a-container')).Line(thisWeekdata);
    generateLegend('legend-1a-container', thisWeekdata.datasets);

    return myLineChart1a;
}
var myLineChart1a = drawChart1a();

function drawChart2() {
    var f = $('#filter-section-sub a.active').attr('rel-t');
    var lastWeekdata = ((f == '' || f == 'week') ? lastWeek() : (f == 'month' ? lastMonth() : (f == 'year' ? lastYear() : [])));
    var myLineChart2 = new Chart(makeCanvas('chart-2-container')).Bar(lastWeekdata);
    generateLegend('legend-2-container', lastWeekdata.datasets);

    return myLineChart2;
}
var myLineChart2 = drawChart2();

function drawChart2a() {
    var f = $('#filter-section-sub a.active').attr('rel-t');
    var lastWeekdata = ((f == '' || f == 'week') ? lastWeek_subs() : (f == 'month' ? lastMonth_subs() : (f == 'year' ? lastYear_subs() : [])));
    var myLineChart2a = new Chart(makeCanvas('chart-2a-container')).Line(lastWeekdata);
    generateLegend('legend-2a-container', lastWeekdata.datasets);

    return myLineChart2a;
}
var myLineChart2a = drawChart2a();

function twStats() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: twcount["total"],
        color:"rgb(155,101,187,0.5)",
        highlight: "rgb(130,73,164,0.5)",
        label: "Total"
    },
    {
        value: twcount["shared"],
        color: "rgb(101,133,187,0.5)",
        highlight: "rgb(73,107,164, 0.5)",
        label: "Shared"
    },
    {
        value: twcount["earned"],
        color: "rgb(133,187,101,0.5)",
        highlight: "rgb(107,164,73,0.5)",
        label: "Earned"
    },
];

return data;
}


function lwStats() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: lwcount["total"],
        color:"rgb(155,101,187,0.5)",
        highlight: "rgb(130,73,164,0.5)",
        label: "Total"
    },
    {
        value: lwcount["shared"],
        color: "rgb(101,133,187,0.5)",
        highlight: "rgb(73,107,164, 0.5)",
        label: "Shared"
    },
    {
        value: lwcount["earned"],
        color: "rgb(133,187,101,0.5)",
        highlight: "rgb(107,164,73,0.5)",
        label: "Earned"
    },
];

return data;
}

function generateWeekLabels(type) {
    moment.locale('us', { week: { dow: 1 }});//set 6 to start week with Sundays
    moment.locale('us');

    var labels = new Array();
    var nr = type == "this" ? 0 : 7;
    var cw = moment().week();
    var df = nr == 0 ? 0 : 1;
    var f = $("#week-sort-filters .content-filters li a.active");
    var cwr = (typeof f.attr("rel-w") !== "undefined" ? f.attr("rel-w") : cw);

    for (var i=0; i<=6; i++) {
    	labels[i] = moment().week(cwr-df).weekday(i).format("ddd, MMM DD");
    }

    return labels;
}
function generateMonthLabels(type) {
    var labels = new Array();
    var nr = type === "this" ? 0 : 1;
    var cm = moment().month()+1;
    var f = $("#week-sort-filters .content-filters li a.active");
    var mnr = (typeof f.attr("rel-m") !== "undefined" ? f.attr("rel-m") : cm);
    var df = nr == 0 ? 1 : 2;
    var tnr = moment().month(mnr-df).daysInMonth();

    for (var i=0; i<tnr; i++) {
    	labels[i] = moment().month(mnr-df).date(i+1).format("ddd DD");
    }

    return labels;
}

function generateUserYearLabels(type) {
    var now = moment();
    var labels = new Array();
    
    var nr = type === "this" ? 1 : 7;
    
    for (var i=0; i<=11; i++) {
    	if (nr == 1)
 		labels[i] = moment().month(i).format("MMM");
 	else
 		labels[i] = moment().subtract(1, 'years').month(i).format("MMM");
    }
    
    return labels;
}
function generateLegend(id, items) {
    var legend = document.getElementById(id);
    legend.innerHTML = items.map(function(item) {
      var color = item.color || item.fillColor;
      var label = item.label;
      
      if (typeof(label) == 'undefined' || typeof(color) == 'undefined') {
          return;
      }
      return '<li><i style="background:' + color + '"><span title="' + label + '" rel="tooltip">&nbsp;&nbsp;&nbsp;</span></i></li>';
    }).join('');
    
    setTimeout(function () { resizeDelimiter(); }, 1000);
    
    var animatespeed   = 0;
    var targets = $( '[rel=tooltip]' ),
        target  = false,
        tooltip = false,
        title   = false;

    targets.bind( 'mouseenter', function()
    {
        target  = $( this );
        tip     = target.attr( 'title' );
        tooltip = $( '<div class="tooltip"></div>' );

        if( !tip || tip == '' )
            return false;

        target.removeAttr( 'title' );
        tooltip.css( 'opacity', 0 )
               .html( tip )
               .appendTo( 'body' );

        var init_tooltip = function()
        {
            if( $( window ).width() < tooltip.outerWidth() * 1.5 )
                tooltip.css( 'max-width', $( window ).width() / 2 );
            else
                tooltip.css( 'max-width', 340 );

            var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
                pos_top  = target.offset().top - tooltip.outerHeight() - 20;

            if( pos_left < 0 )
            {
                pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                tooltip.addClass( 'left' );
            }
            else
                tooltip.removeClass( 'left' );

            if( pos_left + tooltip.outerWidth() > $( window ).width() )
            {
                pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                tooltip.addClass( 'right' );
            }
            else
                tooltip.removeClass( 'right' );

            if( pos_top < 0 )
            {
                var pos_top  = target.offset().top + target.outerHeight();
                tooltip.addClass( 'top' );
            }
            else
                tooltip.removeClass( 'top' );

            tooltip.css( { left: pos_left, top: pos_top } )
                   .animate( { top: '+=10', opacity: 1 }, animatespeed );
        };

        init_tooltip();
        $( window ).resize( init_tooltip );

        var remove_tooltip = function()
        {
            tip = tooltip.html();
            
            tooltip.animate( { top: '-=10', opacity: 0 }, animatespeed, function()
            {
                $( this ).remove();
            });

            target.attr( 'title', tip );
        };

        target.bind( 'mouseleave', remove_tooltip );
        tooltip.bind( 'click', remove_tooltip );
    });
}

function makeCanvas(id) {
    var container = document.getElementById(id);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    container.innerHTML = '';
    canvas.width = container.offsetWidth;
    canvas.height = container.offsetHeight;
 
    container.appendChild(canvas);
   
    return ctx;
}

jQuery(".close_but").click(function () {
    var _for = "." + jQuery(this).attr("rel-close");
    jQuery(_for).fadeOut("normal", function () {
        jQuery(this).detach();
    });
});


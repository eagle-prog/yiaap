google.load("visualization", "1", {packages:["corechart"]});

function thisWeek(_sel) {
    _sel = _sel || '';
    
    _l = (lcount["total"] !== '' && (_sel == '' || _sel.indexOf("l") >= 0)) ? {
        label: "Broadcasts",
        fillColor: "rgba(153, 50, 204,0.5)",
        strokeColor: "rgba(153, 50, 204,1)",
        pointColor: "rgba(153, 50, 204,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(153, 50, 204,1)",
        data: this_week_live.split(",")
    } : {};
    
    _v = (vcount["total"] !== '' && (_sel == '' || _sel.indexOf("v") >= 0)) ? {
        label: "Videos",
        fillColor: "rgba(6,162,203,0.5)",
        strokeColor: "rgba(6,162,203,1)",
        pointColor: "rgba(6,162,203,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(6,162,203,1)",
        data: this_week_video.split(",")
    } : {};

    _i = (icount["total"] !== '' && (_sel == '' || _sel.indexOf("i") >= 0)) ? {
        label: "Pictures",
        fillColor: "rgba(242,132,16,0.5)",
        strokeColor: "rgba(242,132,16,1)",
        pointColor: "rgba(242,132,16,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(242,132,16,1)",
        data: this_week_image.split(",")
    } : {};
    
    _a = (acount["total"] !== '' && (_sel == '' || _sel.indexOf("a") >= 0)) ? {
        label: "Music",
        fillColor: "rgba(221,30,47,0.5)",
        strokeColor: "rgba(221,30,47,1)",
        pointColor: "rgba(221,30,47,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(221,30,47,1)",
        data: this_week_audio.split(",")
    } : {};
    
    _d = (dcount["total"] !== '' && (_sel == '' || _sel.indexOf("d") >= 0)) ? {
        label: "Documents",
        fillColor: "rgba(25,153,0,0.5)",
        strokeColor: "rgba(25,153,0,1)",
        pointColor: "rgba(25,153,0,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(25,153,0,1)",
        data: this_week_doc.split(",")
    } : {};
    
    _b = (bcount["total"] !== '' && (_sel == '' || _sel.indexOf("b") >= 0)) ? {
        label: "Blogs",
        fillColor: "rgba(0,153,122,0.5)",
        strokeColor: "rgba(0,153,122,1)",
        pointColor: "rgba(0,153,122,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(0,153,122,1)",
        data: this_week_blog.split(",")
    } : {};
    
    var data = {
        labels: generateWeekLabels("this"),
        datasets: [
            _l,
            _v,
            _i,
            _a,
            _d,
            _b
        ]
    };

    return data;
}
function lastWeek(_sel) {
    _sel = _sel || '';
    // Some raw data (not necessarily accurate)
    // Some raw data (not necessarily accurate)
    _l = (lcount["total"] !== '' && (_sel == '' || _sel.indexOf("l") >= 0)) ? {
        label: "Broadcasts",
        fillColor: "rgba(153, 50, 204,0.5)",
        strokeColor: "rgba(153, 50, 204,1)",
        pointColor: "rgba(153, 50, 204,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(153, 50, 204,1)",
        data: last_week_video.split(",")
    } : {};
    
    _v = (vcount["total"] !== '' && (_sel == '' || _sel.indexOf("v") >= 0)) ? {
        label: "Videos",
        fillColor: "rgba(6,162,203,0.5)",
        strokeColor: "rgba(6,162,203,1)",
        pointColor: "rgba(6,162,203,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(6,162,203,1)",
        data: last_week_video.split(",")
    } : {};

    _i = (icount["total"] !== '' && (_sel == '' || _sel.indexOf("i") >= 0)) ? {
        label: "Pictures",
        fillColor: "rgba(242,132,16,0.5)",
        strokeColor: "rgba(242,132,16,1)",
        pointColor: "rgba(242,132,16,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(242,132,16,1)",
        data: last_week_image.split(",")
    } : {};
    
    _a = (acount["total"] !== '' && (_sel == '' || _sel.indexOf("a") >= 0)) ? {
        label: "Music",
        fillColor: "rgba(221,30,47,0.5)",
        strokeColor: "rgba(221,30,47,1)",
        pointColor: "rgba(221,30,47,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(221,30,47,1)",
        data: last_week_audio.split(",")
    } : {};
    
    _d = (dcount["total"] !== '' && (_sel == '' || _sel.indexOf("d") >= 0)) ? {
        label: "Documents",
        fillColor: "rgba(25,153,0,0.5)",
        strokeColor: "rgba(25,153,0,1)",
        pointColor: "rgba(25,153,0,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(25,153,0,1)",
        data: last_week_doc.split(",")
    } : {};
    
    _b = (bcount["total"] !== '' && (_sel == '' || _sel.indexOf("b") >= 0)) ? {
        label: "Blogs",
        fillColor: "rgba(0,153,122,0.5)",
        strokeColor: "rgba(0,153,122,1)",
        pointColor: "rgba(0,153,122,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(0,153,122,1)",
        data: last_week_blog.split(",")
    } : {};
    
    var data = {
        labels: generateWeekLabels("last"),
        datasets: [
            _l,
            _v,
            _i,
            _a,
            _d,
            _b
        ]
    };

    return data;
}

function lStats_active() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: lcount["active"],
        color:"#199900",
        highlight: "#20c200",
        label: "Active"
    },
    {
        value: lcount["inactive"],
        color: "#c44440",
        highlight: "#c44440",
        label: "Inactive"
    },
    {
        value: lcount["pending"],
        color: "#f38533",
        highlight: "#f38533",
        label: "Pending"
    },
    {
        value: lcount["flagged"],
        color: "#795892",
        highlight: "#795892",
        label: "Flagged"
    }
];

return data;
}
function lStats_featured() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: lcount["featured"],
        color: "#1d72aa",
        highlight: "#1d72aa",
        label: "Featured"
    },
    {
        value: lcount["promoted"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Promoted"
    },
    {
        value: lcount["private"],
        color: "#B2912F",
        highlight: "#0099b2",
        label: "Private"
    },
    {
        value: lcount["personal"],
        color: "#ffff00",
        highlight: "#ffff00",
        label: "Personal"
    }
];

return data;
}
function lStats_type() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: lcount["public"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Public"
    },
    {
        value: lcount["mob"],
        color: "#f28410",
        highlight: "#f49027",
        label: "Mobile"
    },
    {
        value: lcount["hd"],
        color: "#B2912F",
        highlight: "#B2912F",
        label: "HD"
    },
    {
        value: lcount["embed"],
        color: "#4D4D4D",
        highlight: "#4D4D4D",
        label: "Embedded"
    }
];

return data;
}
function vStats_active() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: vcount["active"],
        color:"#199900",
        highlight: "#20c200",
        label: "Active"
    },
    {
        value: vcount["inactive"],
        color: "#c44440",
        highlight: "#c44440",
        label: "Inactive"
    },
    {
        value: vcount["pending"],
        color: "#f38533",
        highlight: "#f38533",
        label: "Pending"
    },
    {
        value: vcount["flagged"],
        color: "#795892",
        highlight: "#795892",
        label: "Flagged"
    }
];

return data;
}
function vStats_featured() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: vcount["featured"],
        color: "#1d72aa",
        highlight: "#1d72aa",
        label: "Featured"
    },
    {
        value: vcount["promoted"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Promoted"
    },
    {
        value: vcount["private"],
        color: "#B2912F",
        highlight: "#0099b2",
        label: "Private"
    },
    {
        value: vcount["personal"],
        color: "#ffff00",
        highlight: "#ffff00",
        label: "Personal"
    }
];

return data;
}
function vStats_type() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: vcount["public"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Public"
    },
    {
        value: vcount["mob"],
        color: "#f28410",
        highlight: "#f49027",
        label: "Mobile"
    },
    {
        value: vcount["hd"],
        color: "#B2912F",
        highlight: "#B2912F",
        label: "HD"
    },
    {
        value: vcount["embed"],
        color: "#4D4D4D",
        highlight: "#4D4D4D",
        label: "Embedded"
    }
];

return data;
}
function aStats_active() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: acount["active"],
        color:"#199900",
        highlight: "#20c200",
        label: "Active"
    },
    {
        value: acount["inactive"],
        color: "#c44440",
        highlight: "#FFC870",
        label: "Inactive"
    },
    {
        value: acount["pending"],
        color: "#f38533",
        highlight: "#FFC870",
        label: "Pending"
    },
    {
        value: acount["flagged"],
        color: "#795892",
        highlight: "#FFC870",
        label: "Flagged"
    }
];

return data;
}
function aStats_featured() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: acount["featured"],
        color: "#1d72aa",
        highlight: "#FFC870",
        label: "Featured"
    },
    {
        value: acount["promoted"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Promoted"
    },
    {
        value: acount["private"],
        color: "#0099b2",
        highlight: "#FFC870",
        label: "Private"
    },
    {
        value: acount["personal"],
        color: "#ffff00",
        highlight: "#FFC870",
        label: "Personal"
    }
];

return data;
}
function iStats_active() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: icount["active"],
        color:"#199900",
        highlight: "#20c200",
        label: "Active"
    },
    {
        value: icount["inactive"],
        color: "#c44440",
        highlight: "#FFC870",
        label: "Inactive"
    },
    {
        value: icount["pending"],
        color: "#f38533",
        highlight: "#FFC870",
        label: "Pending"
    },
    {
        value: icount["flagged"],
        color: "#795892",
        highlight: "#FFC870",
        label: "Flagged"
    }
];
return data;
}
function iStats_featured() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: icount["featured"],
        color: "#1d72aa",
        highlight: "#FFC870",
        label: "Featured"
    },
    {
        value: icount["promoted"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Promoted"
    },
    {
        value: icount["private"],
        color: "#0099b2",
        highlight: "#FFC870",
        label: "Private"
    },
    {
        value: icount["personal"],
        color: "#ffff00",
        highlight: "#FFC870",
        label: "Personal"
    }
];
return data;
}
function dStats_active() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: dcount["active"],
        color:"#199900",
        highlight: "#20c200",
        label: "Active"
    },
    {
        value: dcount["inactive"],
        color: "#c44440",
        highlight: "#FFC870",
        label: "Inactive"
    },
    {
        value: dcount["pending"],
        color: "#f38533",
        highlight: "#FFC870",
        label: "Pending"
    },
    {
        value: dcount["flagged"],
        color: "#795892",
        highlight: "#FFC870",
        label: "Flagged"
    }
];

return data;
}
function dStats_featured() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: dcount["featured"],
        color: "#1d72aa",
        highlight: "#FFC870",
        label: "Featured"
    },
    {
        value: dcount["promoted"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Promoted"
    },
    {
        value: dcount["private"],
        color: "#0099b2",
        highlight: "#FFC870",
        label: "Private"
    },
    {
        value: dcount["personal"],
        color: "#ffff00",
        highlight: "#FFC870",
        label: "Personal"
    },
/*    {
        value: dcount["mob"],
        color: "#f28410",
        highlight: "#f49027",
        label: "Mobile"
    }*/
];

return data;
}
function bStats_active() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: bcount["active"],
        color:"#199900",
        highlight: "#20c200",
        label: "Active"
    },
    {
        value: bcount["inactive"],
        color: "#c44440",
        highlight: "#FFC870",
        label: "Inactive"
    },
    {
        value: bcount["pending"],
        color: "#f38533",
        highlight: "#FFC870",
        label: "Pending"
    },
    {
        value: bcount["flagged"],
        color: "#795892",
        highlight: "#FFC870",
        label: "Flagged"
    }
];

return data;
}
function bStats_featured() {
  // Some raw data (not necessarily accurate)
  var data = [
    {
        value: bcount["featured"],
        color: "#1d72aa",
        highlight: "#FFC870",
        label: "Featured"
    },
    {
        value: bcount["promoted"],
        color: "#06a2cb",
        highlight: "#05bae9",
        label: "Promoted"
    },
    {
        value: bcount["private"],
        color: "#0099b2",
        highlight: "#FFC870",
        label: "Private"
    },
    {
        value: bcount["personal"],
        color: "#ffff00",
        highlight: "#FFC870",
        label: "Personal"
    },
/*    {
        value: dcount["mob"],
        color: "#f28410",
        highlight: "#f49027",
        label: "Mobile"
    }*/
];

return data;
}

function memberData() {
    // Some raw data (not necessarily accurate)
    var data = {
        labels: generateUserWeekLabels(),
        datasets: [
            {
                label: "This Week",
                fillColor: "rgba(6,162,203,0.2)",
                strokeColor: "rgba(6,162,203,1)",
                pointColor: "rgba(6,162,203,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(6,162,203,1)",
                data: this_week_users.split(",")
            },
            {
                label: "Last Week",
                fillColor: "rgba(242,132,16,0.2)",
                strokeColor: "rgba(242,132,16,1)",
                pointColor: "rgba(242,132,16,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(242,132,16,1)",
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
                fillColor: "rgba(6,162,203,0.2)",
                strokeColor: "rgba(6,162,203,1)",
                pointColor: "rgba(6,162,203,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(6,162,203,1)",
                data: this_year_earnings.split(",")
            },
            {
                label: "Last Year",
                fillColor: "rgba(242,132,16,0.2)",
                strokeColor: "rgba(242,132,16,1)",
                pointColor: "rgba(242,132,16,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(242,132,16,1)",
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
    //jQuery("#chart-1-container canvas").detach();
    
    var thisWeekdata = thisWeek();
    var myLineChart1 = new Chart(makeCanvas('chart-1-container')).Line(thisWeekdata);
    generateLegend('legend-1-container', thisWeekdata.datasets);

    return myLineChart1;
}
var myLineChart1 = drawChart1();

function drawChart2() {
    var lastWeekdata = lastWeek();
    var myLineChart2 = new Chart(makeCanvas('chart-2-container')).Line(lastWeekdata);
    generateLegend('legend-2-container', lastWeekdata.datasets);

    return myLineChart2;
}
var myLineChart2 = drawChart2();

function drawChart3() {
    if (vcount["total"] !== '') {
        var vStatsdata = vStats_active();
        var myLineChart3 = new Chart(makeCanvas('chart-3-container')).Doughnut(vStatsdata);
        generateLegend('legend-3-container', vStatsdata);
        
        return myLineChart3;
    }
}
var myLineChart3 = drawChart3();

function drawChart3a() {
    if (vcount["total"] !== '') {
        var vStatsdata = vStats_featured();
        var myLineChart3a = new Chart(makeCanvas('chart-3a-container')).Doughnut(vStatsdata);
        generateLegend('legend-3a-container', vStatsdata);
        
        return myLineChart3a;
    }
}
var myLineChart3a = drawChart3a();

function drawChart11() {
    if (lcount["total"] !== '') {
        var lStatsdata = lStats_active();
        var myLineChart11 = new Chart(makeCanvas('chart-11-container')).Doughnut(lStatsdata);
        generateLegend('legend-11-container', lStatsdata);
        
        return myLineChart11;
    }
}
var myLineChart11 = drawChart11();

function drawChart11a() {
    if (lcount["total"] !== '') {
        var lStatsdata = lStats_featured();
        var myLineChart11a = new Chart(makeCanvas('chart-11a-container')).Doughnut(lStatsdata);
        generateLegend('legend-11a-container', lStatsdata);
        
        return myLineChart11a;
    }
}
var myLineChart11a = drawChart11a();

function drawChart4() {
    var memberNrData = memberData();
    var myLineChart4 = new Chart(makeCanvas('chart-4-container')).Bar(memberNrData);
    generateLegend('legend-4-container', memberNrData.datasets);
    
    return myLineChart4;
}
var myLineChart4 = drawChart4();

function drawChart8() {
    var userNrData = userData();
    var myLineChart8 = new Chart(makeCanvas('chart-8-container')).Bar(userNrData);
    generateLegend('legend-8-container', userNrData.datasets);
    
    return myLineChart8;
}
var myLineChart8 = drawChart8();

function drawChart5() {
    if (acount["total"] !== '') {
        var aNrStats = aStats_active();
        var myLineChart5 = new Chart(makeCanvas('chart-5-container')).Doughnut(aNrStats);
        generateLegend('legend-5-container', aNrStats);
        
        return myLineChart5;
    }
}
var myLineChart5 = drawChart5();

function drawChart5a() {
    if (acount["total"] !== '') {
        var aNrStats = aStats_featured();
        var myLineChart5a = new Chart(makeCanvas('chart-5a-container')).Doughnut(aNrStats);
        generateLegend('legend-5a-container', aNrStats);
        
        return myLineChart5a;
    }
}
var myLineChart5a = drawChart5a();

function drawChart6() {
    if (icount["total"] !== '') {
        var iNrStats = iStats_active();
        var myLineChart6 = new Chart(makeCanvas('chart-6-container')).Doughnut(iNrStats);
        generateLegend('legend-6-container', iNrStats);
        
        return myLineChart6;
    }
}
var myLineChart6 = drawChart6();

function drawChart6a() {
    if (icount["total"] !== '') {
        var iNrStats = iStats_featured();
        var myLineChart6a = new Chart(makeCanvas('chart-6a-container')).Doughnut(iNrStats);
        generateLegend('legend-6a-container', iNrStats);
        
        return myLineChart6a;
    }
}
var myLineChart6a = drawChart6a();


function drawChart7() {
    if (dcount["total"] !== '') {
        var dNrStats = dStats_active();
        var myLineChart7 = new Chart(makeCanvas('chart-7-container')).Doughnut(dNrStats);
        generateLegend('legend-7-container', dNrStats);
        
        return myLineChart7;
    }
}
var myLineChart7 = drawChart7();

function drawChart7a() {
    if (dcount["total"] !== '') {
        var dNrStats = dStats_featured();
        var myLineChart7a = new Chart(makeCanvas('chart-7a-container')).Doughnut(dNrStats);
        generateLegend('legend-7a-container', dNrStats);
        
        return myLineChart7a;
    }
}
var myLineChart7a = drawChart7a();


function drawChart9() {
    if (bcount["total"] !== '') {
        var bNrStats = bStats_active();
        var myLineChart9 = new Chart(makeCanvas('chart-9-container')).Doughnut(bNrStats);
        generateLegend('legend-9-container', bNrStats);
        
        return myLineChart9;
    }
}
var myLineChart9 = drawChart9();

function drawChart9a() {
    if (bcount["total"] !== '') {
        var bNrStats = bStats_featured();
        var myLineChart9a = new Chart(makeCanvas('chart-9a-container')).Doughnut(bNrStats);
        generateLegend('legend-9a-container', bNrStats);
        
        return myLineChart9a;
    }
}
var myLineChart9a = drawChart9a();



function generateWeekLabels(type) {
    var now = moment();
    var labels = new Array();
    var nr = type === "this" ? 0 : 7;
    
    labels[0] = moment(now).subtract(nr, 'day').day(0).format("ddd DD");
    labels[1] = moment(now).subtract(nr, 'day').day(1).format("ddd DD");
    labels[2] = moment(now).subtract(nr, 'day').day(2).format("ddd DD");
    labels[3] = moment(now).subtract(nr, 'day').day(3).format("ddd DD");
    labels[4] = moment(now).subtract(nr, 'day').day(4).format("ddd DD");
    labels[5] = moment(now).subtract(nr, 'day').day(5).format("ddd DD");
    labels[6] = moment(now).subtract(nr, 'day').day(6).format("ddd DD");
    
    return labels;
}
function generateUserWeekLabels(type) {
    var now = moment();
    var labels = new Array();
    
    var nr = type === "this" ? 0 : 7;
    
    labels[0] = moment(now).subtract(0, 'day').day(0).format("DD.MM") + ' / ' + moment(now).subtract(7, 'day').day(0).format("DD.MM");
    labels[1] = moment(now).subtract(0, 'day').day(1).format("DD.MM") + ' / ' + moment(now).subtract(7, 'day').day(1).format("DD.MM");
    labels[2] = moment(now).subtract(0, 'day').day(2).format("DD.MM") + ' / ' + moment(now).subtract(7, 'day').day(2).format("DD.MM");
    labels[3] = moment(now).subtract(0, 'day').day(3).format("DD.MM") + ' / ' + moment(now).subtract(7, 'day').day(3).format("DD.MM");
    labels[4] = moment(now).subtract(0, 'day').day(4).format("DD.MM") + ' / ' + moment(now).subtract(7, 'day').day(4).format("DD.MM");
    labels[5] = moment(now).subtract(0, 'day').day(5).format("DD.MM") + ' / ' + moment(now).subtract(7, 'day').day(5).format("DD.MM");
    labels[6] = moment(now).subtract(0, 'day').day(6).format("DD.MM") + ' / ' + moment(now).subtract(7, 'day').day(6).format("DD.MM");
    
    return labels;
}
function generateUserYearLabels(type) {
    var now = moment();
    var labels = new Array();
    
    var nr = type === "this" ? 1 : 7;
    
    //labels[0] = moment(now).subtract(1, 'day').day(0).format("YYYY") + ' / ' + moment(now).subtract(1, 'year').day(0).format("YYYY");
    //labels[0] = moment(now).subtract(1, 'day').day(0).format("MMM") + ' / ' + moment(now).subtract(7, 'day').day(0).format("DD.MM");
    labels[0] = moment().month(0).format("MMM");
    labels[1] = moment().month(1).format("MMM");
    labels[2] = moment().month(2).format("MMM");
    labels[3] = moment().month(3).format("MMM");
    labels[4] = moment().month(4).format("MMM");
    labels[5] = moment().month(5).format("MMM");
    labels[6] = moment().month(6).format("MMM");
    labels[7] = moment().month(7).format("MMM");
    labels[8] = moment().month(8).format("MMM");
    labels[9] = moment().month(9).format("MMM");
    labels[10] = moment().month(10).format("MMM");
    labels[11] = moment().month(11).format("MMM");
    
    
    return labels;
}
function generateLegend(id, items) {
    var legend = document.getElementById(id);
    legend.innerHTML = items.map(function(item) {
      var color = item.color || item.fillColor;
      var label = item.label;
      
      if (typeof(label) == 'undefined') {
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
            myLineChart1.destroy();
            thisWeekdata = thisWeek(_sel);
            myLineChart1 = new Chart(makeCanvas('chart-1-container')).Line(thisWeekdata);
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
            myLineChart2.destroy();
            lastWeekdata = lastWeek(_sel);
            myLineChart2 = new Chart(makeCanvas('chart-2-container')).Line(lastWeekdata);
            generateLegend('legend-2-container', lastWeekdata.datasets);
	}
    }, "#last-week-uploads");
});







jQuery(".close_but").click(function () {
    var _for = "." + jQuery(this).attr("rel-close");
    jQuery(_for).fadeOut("normal", function () {
        jQuery(this).detach();
    });
});





(function(jQuery) {
    jQuery.fn.countTo = function(options) {
    // merge the default plugin settings with the custom options
    options = jQuery.extend({}, jQuery.fn.countTo.defaults, options || {});

    // how many times to update the value, and how much to increment the value on each update
    var loops = Math.ceil(options.speed / options.refreshInterval),
    increment = (options.to - options.from) / loops;

    return jQuery(this).each(function() {
        var _this = this,
        loopCount = 0,
        value = options.from,
        interval = setInterval(updateTimer, options.refreshInterval);

        function updateTimer() {
            value += increment;
            loopCount++;
            jQuery(_this).html(value.toFixed(options.decimals));

            if (typeof(options.onUpdate) == 'function') {
                options.onUpdate.call(_this, value);
            }

            if (loopCount >= loops) {
                clearInterval(interval);
                value = options.to;

                if (typeof(options.onComplete) == 'function') {
                    options.onComplete.call(_this, value);
                }
            }
        }
    });
};

jQuery.fn.countTo.defaults = {
    from: 0,  // the number the element should start at
    to: 100,  // the number the element should end at
    speed: 1000,  // how long it should take to count between the target numbers
    refreshInterval: 100,  // how often the element should be updated
    decimals: 0,  // the number of decimal places to show
    onUpdate: null,  // callback method for every time the element is updated,
    onComplete: null  // callback method for when the element finishes updating
    };
})(jQuery);


jQuery(function (jQuery) {
    if (lcount["total"] !== '') {
        jQuery('.timer-live').countTo({
            from: 0,
            to: lcount["total"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-timer-live').countTo({
            from: 0,
            to: lcount["active"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-inactive-timer-live').countTo({
            from: 0,
            to: lcount["inactive"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
    }
    if (vcount["total"] !== '') {
        jQuery('.timer-videos').countTo({
            from: 0,
            to: vcount["total"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-timer-video').countTo({
            from: 0,
            to: vcount["active"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-inactive-timer-video').countTo({
            from: 0,
            to: vcount["inactive"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
    }
    if (acount["total"] !== '') {
        jQuery('.timer-audios').countTo({
            from: 0,
            to: acount["total"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-timer-audio').countTo({
            from: 0,
            to: acount["active"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-inactive-timer-audio').countTo({
            from: 0,
            to: acount["inactive"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
    }
    if (icount["total"] !== '') {
        jQuery('.timer-images').countTo({
            from: 0,
            to: icount["total"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-timer-image').countTo({
            from: 0,
            to: icount["active"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-inactive-timer-image').countTo({
            from: 0,
            to: icount["inactive"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
    }
    if (dcount["total"] !== '') {
        jQuery('.timer-docs').countTo({
            from: 0,
            to: dcount["total"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-timer-doc').countTo({
            from: 0,
            to: dcount["active"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-inactive-timer-doc').countTo({
            from: 0,
            to: dcount["inactive"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
    }

    if (bcount["total"] !== '') {
        jQuery('.timer-blogs').countTo({
            from: 0,
            to: bcount["total"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-timer-blog').countTo({
            from: 0,
            to: bcount["active"],
            speed: 500,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
        jQuery('.small-inactive-timer-blog').countTo({
            from: 0,
            to: bcount["inactive"],
            speed: 1200,
            refreshInterval: 10,
            onComplete: function (value) {

            }
        });
    }
});
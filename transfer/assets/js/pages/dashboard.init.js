/*
Template Name: GT Solution - GT Developers Template
Author: GT Developers
Website: https://gtdeveloper.com/
Contact: gtsolution@outlook.in
File: Dashboard Init Js File
*/

// get colors array from the string
function getChartColorsArray(chartId) {
    var colors = $(chartId).attr('data-colors');
    var colors = JSON.parse(colors);
    return colors.map(function(value){
        var newValue = value.replace(' ', '');
        if(newValue.indexOf('--') != -1) {
            var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
            if(color) return color;
        } else {
            return newValue;
        }
    })
}


// 
// Wallet Balance
//

var piechartColors = getChartColorsArray("#wallet-balance");
if(all_total == "")
{
    jQuery(".piechart").addClass('d-none');
    jQuery(".err-msg").addClass('d-block').removeClass('d-none');
}
var options = {
    series: all_total,
    chart: {
        width: 227,
        height: 227,
        type: 'pie',
    },
    labels: all_branch,
    colors: piechartColors,
    stroke: {
        width: 0,
    },
    legend: {
        show: false
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
        }
    }]
};

var chart = new ApexCharts(document.querySelector("#wallet-balance"), options);
chart.render();


//
// Invested Overview
//

var radialchartColors = getChartColorsArray("#invested-overview");
var options = {
    chart: {
        height: 270,
        type: 'radialBar',
        offsetY: -10
    },
    plotOptions: {
        radialBar: {
            startAngle: -130,
            endAngle: 130,
            dataLabels: {
                name: {
                    show: false
                },
                value: {
                    offsetY: 10,
                    fontSize: '18px',
                    color: undefined,
                    formatter: function (val) {
                        return val + "%";
                    }
                }
            }
        }
    },
    colors: [radialchartColors[0]],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            type: 'horizontal',
            gradientToColors: [radialchartColors[1]],
            shadeIntensity: 0.15,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [20, 60]
        },
    },
    stroke: {
        dashArray: 4,
    },
    legend: {
        show: false
    },
    series: [income_per],
    labels: ['Series A'],
}

var chart1 = new ApexCharts(
    document.querySelector("#invested-overview"),
    options
);

chart1.render();



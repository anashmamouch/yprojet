
//main function

function showChartTooltip(x, y, xValue, yValue) {
    $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 40,
        border: '0px solid #ccc',
        padding: '2px 6px',
        'background-color': '#fff'
    }).appendTo("body").fadeIn(200);
}



if ($(id_graphe2).size() != 0) {
    //site activities
    var previousPoint2 = null;
    $('#graphe_loading2').hide();
    $(graphe_content2).show();

var data1 = new Array();
    for (var key in data2) {
        var y = new Array();
        y.push(key);
        y.push(data2[key]);
        data1.push(y);
    }

    var plot_statistics = $.plot($(id_graphe2),
            [{
                    data: data1,
                    lines: {
                        fill: 0.2,
                        lineWidth: 0,
                    },
                    color: [couleur2]
                }, {
                    data: data1,
                    points: {
                        show: true,
                        fill: true,
                        radius: 4,
                        fillColor: couleur2,
                        lineWidth: 2
                    },
                    color: couleur2,
                    shadowSize: 1
                }, {
                    data: data1,
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 3
                    },
                    color: couleur2,
                    shadowSize: 0
                }
//                },{
//                    data: data2,
//                    lines: {
//                        fill: 0.2,
//                        lineWidth: 0,
//                    },
//                    color: ['#FA5882']
//                }, {
//                    data: data2,
//                    points: {
//                        show: true,
//                        fill: true,
//                        radius: 4,
//                        fillColor: "#FA5882",
//                        lineWidth: 2
//                    },
//                    color: '#FA5882',
//                    shadowSize: 1
//                }, {
//                    data: data2,
//                    lines: {
//                        show: true,
//                        fill: false,
//                        lineWidth: 3
//                    },
//                    color: '#FA5882',
//                    shadowSize: 0
//                },
//                {
//                    data: data3,
//                    lines: {
//                        fill: 0.2,
//                        lineWidth: 0,
//                    },
//                    color: ['#01DF74']
//                }, {
//                    data: data3,
//                    points: {
//                        show: true,
//                        fill: true,
//                        radius: 4,
//                        fillColor: "#01DF74",
//                        lineWidth: 2
//                    },
//                    color: '#01DF74',
//                    shadowSize: 1
//                }, {
//                    data: data3,
//                    lines: {
//                        show: true,
//                        fill: false,
//                        lineWidth: 3
//                    },
//                    color: '#01DF74',
//                    shadowSize: 0
//                },
//                {
//                    data: data4,
//                    lines: {
//                        fill: 0.2,
//                        lineWidth: 0,
//                    },
//                    color: ['#F5DA81']
//                }, {
//                    data: data4,
//                    points: {
//                        show: true,
//                        fill: true,
//                        radius: 4,
//                        fillColor: "#F5DA81",
//                        lineWidth: 2
//                    },
//                    color: '#F5DA81',
//                    shadowSize: 1
//                }, {
//                    data: data4,
//                    lines: {
//                        show: true,
//                        fill: false,
//                        lineWidth: 3
//                    },
//                    color: '#F5DA81',
//                    shadowSize: 0
//                }
            ],
            {
                xaxis: {
                    tickLength: 0,
                    tickDecimals: 0,
                    mode: "categories",
                    min: 0,
                    font: {
                        lineHeight: 18,
                        style: "normal",
                        variant: "small-caps",
                        color: "#6F7B8A"
                    }
                },
                yaxis: {
                    ticks: 5,
                    tickDecimals: 0,
                    tickColor: "#eee",
                    font: {
                        lineHeight: 14,
                        style: "normal",
                        variant: "small-caps",
                        color: "#6F7B8A"
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eee",
                    borderColor: "#eee",
                    borderWidth: 1
                }
            });



    $(id_graphe2).bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
        if (item) {
            if (previousPoint2 != item.dataIndex) {
                previousPoint2 = item.dataIndex;
                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + stat_unit2);
            }
        }

    });

    $(id_graphe2).bind("mouseleave", function () {
        $("#tooltip").remove();
    });


}


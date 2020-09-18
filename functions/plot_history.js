function plot_history(vals) {
    
    var options = {
        series: {
            lines: {
                show: true
            }
            , points: {
                show: true
            }
        },
         colors: ["#ee7951"]
        , grid: {
            color: "#AFAFAF"
            , hoverable: true
            , borderWidth: 0
            , backgroundColor: '#FFF'
        }
    };
    var plotObj = $.plot($("#history_chart"), [{
        data: vals
         }], options);
    console.log("OK");

    plotObj.options = {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
                stepSize: 1.
            }],
            yAxes: [{
                display: true
            }]
        }
    };
    // plotObj.update();
}

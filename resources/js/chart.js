window.onload = function () {
    var chart = new CanvasJS.Chart('chartContainer', {
        animationEnabled: true,
        title: {
            text: 'Total Spend by Category',
        },
        subtitles: [
            {
                text: year,
            },
        ],
        backgroundColor: '#F4F4F5',
        data: [
            {
                type: 'pie',
                yValueFormatString: '#,##0.00"%"',
                indexLabel: '{label} ({y})',
                dataPoints: dataPoints,
            },
        ],
    });
    chart.render();
};

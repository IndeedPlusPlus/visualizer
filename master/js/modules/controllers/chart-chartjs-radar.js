App.controller('ChartChartJSRadarController', ['$scope', function ($scope) {
    var radarData = {
        labels: [],
        datasets: [
            {
                label: null,
                fillColor: 'rgba(114,102,186,0.2)',
                strokeColor: 'rgba(114,102,186,1)',
                pointColor: 'rgba(114,102,186,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(114,102,186,1)',
                data: []
            }
        ]
    };
    var data = $scope.rawData;
    for (var i = 0 ; i < data.length ; ++i)
    {
        radarData.labels.push(data[i][0]);
        radarData.datasets[0].data.push(data[i][1]);
    }
    $scope.radarData = radarData;
    $scope.radarOptions = {
        scaleShowLine: true,
        angleShowLineOut: true,
        scaleShowLabels: false,
        scaleBeginAtZero: true,
        angleLineColor: 'rgba(0,0,0,.1)',
        angleLineWidth: 1,
        pointLabelFontFamily: "'Arial'",
        pointLabelFontStyle: 'bold',
        pointLabelFontSize: 10,
        pointLabelFontColor: '#565656',
        pointDot: true,
        pointDotRadius: 3,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true
    };
}]);
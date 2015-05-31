App.controller('ChartFlotPieController', ['$scope', function ($scope) {
    var data = [];

    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    var rawData = $scope.rawData;
    for (var i = 0; i < rawData.length; ++i)
        data.push({
            'label': rawData[i][0],
            'color': getRandomColor(),
            'data': rawData[i][1]
        });
    $scope.pieData = data;
    $scope.pieOptions = {
        series: {
            pie: {
                show: true,
                innerRadius: 0,
                label: {
                    show: true,
                    radius: 0.8,
                    formatter: function (label, series) {
                        return '<div class="flot-pie-label">' +
                                //label + ' : ' +
                            Math.round(series.percent) +
                            '%</div>';
                    },
                    background: {
                        opacity: 0.8,
                        color: '#222'
                    }
                }
            }
        }
    };
}]);
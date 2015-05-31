App.controller('ChartFlotDonutController', ['$scope', function ($scope) {
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
    $scope.donutData = data;
    $scope.donutOptions = {
        series: {
            pie: {
                show: true,
                innerRadius: 0.5 // This makes the donut shape
            }
        }
    };
}]);
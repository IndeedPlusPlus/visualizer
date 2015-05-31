App.controller('ChartCreateController', ['$scope', '$http', '$stateParams', 'CHART_TEMPLATES', '$state', function ($scope, $http, $stateParams, templates, $state) {
    $scope.query = {};
    $scope.chart = {};
    $scope.templates = [];

    for (var template in templates) {
        $scope.templates.push(template);
    }
    $scope.chart.template = $scope.templates[0];

    $scope.busy = false;
    $scope.database = {name: $scope.chart.database = $stateParams['database']};
    $scope.testQuery = function (query) {
        $http.get('api/web/index.php?r=chart/query&database=' + encodeURIComponent($scope.database.name) + '&query=' + encodeURIComponent(query))
            .success(function (data) {
                $scope.query = data;
            });
    };

    $scope.createChart = function () {
        $scope.busy = true;
        $http.post('api/web/index.php?r=chart/create', $scope.chart)
            .success(function(data) {
                $state.go('app.chart' , {chartId: data.chart.id});
            });
    }
}]);
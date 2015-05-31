App.controller('ChartViewController', ['$scope', '$rootScope', '$state', '$stateParams', '$http', 'CHART_TEMPLATES',
    function ($scope, $rootScope, $state, $stateParams, $http, templates) {
        $scope.templateUrl = null;
        $scope.chart = null;
        $scope.rawData = null;
        $http.get('api/web/index.php?r=chart/view&chartId=' + encodeURIComponent($stateParams.chartId))
            .success(function (data) {
                $scope.chart = data;
                $http.get('api/web/index.php?r=chart/data&chartId=' + encodeURIComponent($stateParams.chartId)).
                    success(function (data) {
                        $scope.rawData = data;
                    });
                $scope.templateUrl = templates[data.template].template;
            }).error(function (data) {
                alert(data.error);
            });

    }]);
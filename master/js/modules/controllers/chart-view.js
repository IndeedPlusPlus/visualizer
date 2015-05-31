App.controller('ChartViewController', ['$scope', '$rootScope', '$state', '$stateParams', '$http', 'CHART_TEMPLATES',
    function ($scope, $rootScope, $state, $stateParams, $http, templates) {
        $scope.templateUrl = null;
        $scope.chart = null;
        $scope.rawData = null;
        $scope.busy = false;
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
        $scope.deleteChart = function () {
            $scope.busy = true;
            $http.get('api/web/index.php?r=chart/delete&chartId=' + encodeURIComponent($scope.chart.id))
                .success(function (data) {
                    var databaseName = $scope.chart.db_name;
                    databaseName = databaseName.replace(/^.*?_.*?_/, '');
                    $state.go('app.dbview', {name: databaseName});
                })
        };
    }]);
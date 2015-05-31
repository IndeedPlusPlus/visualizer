App.controller('DatabaseViewController', ['$scope', '$rootScope', '$http', '$stateParams', '$state', function ($scope, $rootScope, $http, $stateParams, $state) {
    $scope.database = {};
    $scope.database.name = $stateParams.name;
    $http.get('api/web/index.php?r=database/view&name=' + encodeURIComponent($scope.database.name))
        .success(function (data) {
            $scope.database = data;
        })
        .error(function (data) {
            alert(data.error);
        });
    $http.get('api/web/index.php?r=chart/index&database=' + encodeURIComponent($scope.database.name))
        .success(function (data) {
            $scope.charts = data;
        });
    $scope.deleteDatabase = function () {
        $http.get('api/web/index.php?r=database/drop&name=' + encodeURIComponent($scope.database.name)).
            success(function () {
                $rootScope.refreshSidebar();
            }).error(function (data) {
                alert(data.error);
            });
        $state.go('app.singleview');
    }
}]);


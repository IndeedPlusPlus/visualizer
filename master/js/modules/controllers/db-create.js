App.controller('DatabaseCreateController', ['$scope', '$rootScope', '$http','$state', function ($scope, $rootScope, $http, $state) {
    $scope.error = null;
    $scope.busy = false;
    $scope.database = {};
    $scope.createDatabase = function (databaseName) {
        if (!$scope.database.name || $scope.busy)
            return false;
        $scope.busy = true;
        $http.get('api/web/index.php?r=database/create&name=' + encodeURIComponent($scope.database.name)).success(function () {
            $state.go('app.dbview' , {'name': databaseName});
            $rootScope.refreshSidebar();
        }).error(function (data) {
            alert(data.error);
            $scope.busy = false;
        });
    }
}]);
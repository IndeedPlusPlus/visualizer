App.controller('DatabaseViewController', ['$scope', '$rootScope', '$http', '$stateParams', '$state', function ($scope, $rootScope, $http, $stateParams, $state) {
    $scope.database = {};
    $scope.database.name = $stateParams.name;
    $scope.deleteDatabase = function () {
        $http.get('api/web/index.php?r=database/drop&name=' + $scope.database.name).
            success(function() {
                $rootScope.refreshSidebar();
            }).error(function(data) {
                alert(data.error);
            });
        $state.go('app.singleview');
    }
}]);


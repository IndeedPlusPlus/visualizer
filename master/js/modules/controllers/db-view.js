App.controller('DatabaseViewController', ['$scope', '$rootScope', '$http', '$stateParams', function ($scope, $rootScope, $http, $stateParams) {
    $scope.database = {};
    $scope.database.name = $stateParams.name;
    $scope.deleteDatabase = function () {
        $http.get('api/web/index.php?r=database/drop&name=' + $scope.database.name);
        $rootScope.refreshSidebar();
    }
}]);


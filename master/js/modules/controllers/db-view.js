App.controller('DatabaseViewController', ['$scope', '$http', '$stateParams', function ($scope, $http, $stateParams) {
    $scope.database = {};
    $scope.database.name = $stateParams.name;
}]);
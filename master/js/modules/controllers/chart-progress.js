App.controller('ChartProgressController', ['$scope', '$rootScope', '$state', function ($scope , $rootScope, $state) {
    $scope.percentage = Math.round($scope.rawData[0][0]);
}]);
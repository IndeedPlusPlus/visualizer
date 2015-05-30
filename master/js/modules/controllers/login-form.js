/**=========================================================
 * Module: login-form.js
 * Demo for login api
 =========================================================*/

App.controller('LoginFormController', ['$scope', '$http', '$state', '$rootScope', function ($scope, $http, $state, $rootScope) {

    // bind here all data from the form
    $scope.account = {};
    // place the message if something goes wrong
    $scope.authMsg = '';

    $scope.login = function () {
        $scope.authMsg = '';

        if ($scope.loginForm.$valid) {

            $http
                .post('api/web/index.php?r=site/login', {
                    username: $scope.account.name,
                    password: $scope.account.password,
                    remember_me: $scope.account.remember
                })
                .then(function (response) {
                    // assumes if ok, response is an object with some data, if not, a string with error
                    // customize according to your api
                    if (!response.data.username) {
                        $scope.authMsg = 'Incorrect credentials.';
                    } else {
                        $rootScope.refreshSidebar();
                        $state.go('app.singleview');
                    }
                }, function (response) {
                    $scope.authMsg = 'Server Request Error';
                    if (response.data.errors.username)
                        $scope.authMsg = 'User not found.';
                    if (response.data.errors.password)
                        $scope.authMsg = 'Incorrect password.';
                });
        }
        else {
            // set as dirty if the user click directly to login so we show the validation messages
            $scope.loginForm.account_email.$dirty = true;
            $scope.loginForm.account_password.$dirty = true;
        }
    };

}]);

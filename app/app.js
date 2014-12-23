var app = angular.module('app', ['ngCookies', 'ngResource', 'ngRoute']);
angular.module('Authentication', []);
angular.module('HomeController', []);


app.controller('ApplicationController', function($rootScope, $scope) {
    
});

app.config(['$routeProvider', function ($routeProvider) {
 
    $routeProvider
        .when('/login', {
            controller: 'LoginController',
            templateUrl: 'app/modules/authentication/login.html',
            hideMenus: true
        })
        .when('/', {
            controller: 'HomeController',
            templateUrl: 'app/modules/home/home.html'
        })
  
        .otherwise({ redirectTo: '/login' });
}]);

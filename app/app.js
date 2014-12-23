angular.module('Authentication', []);
angular.module('Home', []);
angular.module('adminModule', []);
var app = angular.module('app', ['ngCookies', 'ngResource', 'ngRoute', 'restangular', 'Authentication', 'Home', 'adminModule']);


app.controller('ApplicationController', function($rootScope, $scope) {
    
});

app.config(['$routeProvider', 'RestangularProvider', function ($routeProvider, RestangularProvider) {
    RestangularProvider.setBaseUrl('api');
    $routeProvider
        .when('/login', {
            controller: 'LoginController',
            templateUrl: 'app/modules/authentication/login.tpl.html',
            hideMenus: true
        })
        .when('/dashboard', {
            controller: 'AdminController',
            templateUrl: 'app/modules/authentication/login.tpl.html',
            hideMenus: true
        })
        .when('/', {
            controller: 'HomeController',
            templateUrl: 'app/modules/home/home.html'
        })
  
        .otherwise({ redirectTo: '/login' });
}]);

app.run(['$rootScope', '$location', '$cookieStore', '$http',
    function ($rootScope, $location, $cookieStore, $http) {
        $rootScope.globals = $cookieStore.get('globals') || {};
        if ($rootScope.globals.currentUser) {
            $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
        }
 
        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            // redirect to login page if not logged in
            if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
                $location.path('/login');
            }
        });
    }]);
// AngularJS Admin Module
angular.module('adminModule', [])

// Gets executed after injection occurs, debugging purposes
.run(function($log){
    $log.debug("ADMIN MODULE *************************************");
})

// Controller for the main Admin Dashboard, listing providers
.controller('AdminController', function($scope, $log, $location, Restangular) {
    $log.debug("ADMIN CONTROLLER ******************************* 2");

    Restangular.all('device').getList().then( function( devices){
        $scope.devices = devices;
    });
    
    Restangular.all('game').getList().then( function( games){
        $scope.games = games;
    });
    
    Restangular.all('score').getList().then( function( scores){
        $scope.scores = scores;
    });
    
    Restangular.all('user').getList().then( function( users){
        $scope.users = users;
    });
    
    // Creating new provider will be handled on a new URL and a new Controller
    $scope.createNewProvider = function(){
        $location.path("/admin-new");
    };

    // Generating reports will be handled on a new URL and a new Controller
    $scope.openReports = function(){
        $location.path("/reports");
    };

    // Viewing, editing, updating, deleting a provider will be handled on a new URL and new controller
    $scope.viewProvider = function( provider){
        $location.path("/admin/"+ provider.id);
    };
    
    // Viewing, editing, updating, deleting domains for super admin only
    $scope.openDomain = function (){
        $location.path("/admin-domain");
    };
    
    $scope.logout = function(){
        $location.path("/login");
    };
    
});

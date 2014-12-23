// AngularJS Admin Module
angular.module('adminModule', [])

// Gets executed after injection occurs, debugging purposes
.run(function($log){
    $log.debug("ADMIN MODULE *************************************");
})

// Controller for the main Admin Dashboard, listing providers
.controller('AdminController', function($scope, $log, $location, Restangular) {
    $log.debug("ADMIN CONTROLLER ******************************* 2");
    
    // Search filter parameters initializaiton
    $scope.searchFacility = 0;
    $scope.searchRole = 0;
    $scope.searchSpec = 0;
    $scope.searchDomain = 0;

    // Get providers list from APIs
    Restangular.all('provider').getList().then( function( providers){
        $scope.providers = providers;
    });
    
    // Get roles list from APIs
    Restangular.all('role').getList().then( function( roles){
        $scope.roles = roles;
    });
    
    // Get specialty list from APIs
    Restangular.all('specialty').getList().then( function( specializations){
        $scope.specializations = specializations;
    });
    
    // Get facility list from APIs
    Restangular.all('facility').getList().then( function( facilities){
        $scope.facilities = facilities;
    });
    
    // Get domain list from APIs
    Restangular.all('domain').getList().then( function( domains){
        $scope.domains = domains;
        $scope.domain = $scope.domains[0];      // Assign this scope's domain to the first. User can change the domain from the drop down list
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

    $scope.$watch('searchDomain', function () {
        $scope.searchFacility = 0;
    });
    
});

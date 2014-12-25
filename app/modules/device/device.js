angular.module('adminModule')
    .controller('DeviceCtrl', function($scope, $log, $routeParams, $location, Restangular) {
        $log.debug("Device Detail Controller *******************************");

        $scope.timeStart = [];
        $scope.timeEnd = [];
        for( var i = 0; i < 24; i++)
            $scope.timeStart.push(i);
        for( var i = 0; i < 60; i++)
            $scope.timeEnd.push(i);
        $scope.uniqueId = $routeParams.uniqueId;

        Restangular.one('device', $scope.uniqueId).get().then(function(device) {
            $scope.device = device; // Assign the result
            
            $scope.startHour = moment($scope.device.timeStart).hour();
            $scope.startMinute = moment($scope.device.timeStart).minute();
            $scope.endHour = moment($scope.device.timeEnd).hour();
            $scope.endMinute = moment($scope.device.timeEnd).minute();
            
            if( $scope.device.override === "HAYIR")
                $scope.disableTime = true;
            else
                $scope.disableTime = false;
            
            console.log(device);
        }, function() {
            $scope.back2Admin();
        });


        $scope.isCheckboxSelected = function (){
            if( $scope.device == null)
                return false;
            var sonuc = $scope.device.override === "HAYIR";
            return sonuc;
        };

        // Save updated details of the provider
        $scope.saveProvider = function(device) {

            // Assign the list to user of provider
            // Debug purposes
            console.log("Saving device: ");
            console.log(device);
            
            // First update user roles then provider itself
            $scope.device.put().then(function(data) {
                    console.log("Provider is successfully updated: " + data);
                    $scope.back2Admin();
                }, function(data) {
                    console.log("Error! Failed to update provider: " + data);
            });
        };
        
        $scope.deleteDevice = function (device){
            console.log("sil");
            Restangular.one('device', $scope.device.uniqueId).remove().then( function(){
                console.log("silme başarılı");
               $scope.back2Admin(); 
            });
        };

        // Return back to provider listing main page
        $scope.back2Admin = function() {
            $location.path("/dashboard");
        };
    });

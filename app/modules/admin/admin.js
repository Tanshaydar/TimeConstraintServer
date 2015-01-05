angular.module('adminModule', [])

        .run(function ($log) {
            $log.debug("ADMIN MODULE *************************************");
        })

        .controller('AdminController', function ($scope, $log, $location, Restangular) {
            $log.debug("Admin Controller *******************************");

            $scope.searchKeyword = "";
            Restangular.all('device').getList().then(function (devices) {
                $scope.devices = devices;
            });

            $scope.viewDevice = function (device) {
                $location.path("/device/" + device.uniqueId);
            };

            $scope.logout = function () {
                $location.path("/login");
            };

            $scope.openTime = function () {
                $location.path("/zaman");
            }

            $scope.openGames = function () {
                $location.path("/oyunlar");
            }

            $scope.createGame = function () {
                $location.path("/oyunekle");
            }

            $scope.openScores = function () {
                $location.path("/skorlar");
            }
        });

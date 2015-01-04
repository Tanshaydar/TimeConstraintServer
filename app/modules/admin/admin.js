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

            Restangular.all('game').getList().then(function (games) {
                $scope.games = games;
            });

            Restangular.all('score').getList().then(function (scores) {
                $scope.scores = scores;
            });

            Restangular.all('user').getList().then(function (users) {
                $scope.users = users;
            });

            $scope.createNewProvider = function () {
                $location.path("/admin-new");
            };

            $scope.openReports = function () {
                $location.path("/reports");
            };

            $scope.viewDevice = function (device) {
                $location.path("/device/" + device.uniqueId);
            };

            $scope.openDomain = function () {
                $location.path("/admin-domain");
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

            $scope.openGames = function () {
                $location.path("/oyunekle");
            }

            $scope.openScores = function () {
                $location.path("/skorlar");
            }

        });

angular.module('gameModule', [])
        .controller('GameController', function ($scope, $log, $routeParams, $location, Restangular) {
            $log.debug("Game Controller *******************************");

            $scope.searchKeyword = "";
            Restangular.all('game').getList().then(function (games) {
                $scope.games = games;
            });

            $scope.back2Admin = function () {
                $location.path("/dashboard");
            };

            $scope.viewGame = function (gameId) {
                $location.path("/oyunlar/" + gameId);
            }
        });

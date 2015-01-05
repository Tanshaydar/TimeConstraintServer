angular.module('gameModule')
        .controller('GameSingleController', function ($scope, $log, $routeParams, $location, Restangular) {
            $log.debug("Game Single Controller *******************************");

            $scope.gameId = $routeParams.gameId;

            Restangular.one('game', $scope.gameId).get().then(function (game) {
                $scope.game = game;
            });

            $scope.saveGame = function (game) {
                game.route = game.route + "/" + game.gameId;
                console.log(game);
                game.save().then(function (data) {
                    console.log("Game is successfully updated: " + data);
                    $scope.back2Games();
                }, function (data) {
                    console.log("Error! Failed to update device: " + data);
                });
            }

            $scope.back2Games = function () {
                $location.path("/oyunlar");
            };
        });

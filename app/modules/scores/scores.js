angular.module('scoreModule', [])
        .controller('ScoreController', function ($scope, $log, $routeParams, $location, Restangular) {
            $log.debug("Scores Controller *******************************");

            $scope.skorlar = [];
            Restangular.all('score').getList().then(function (scores) {
                $scope.scores = scores;
                $scope.scores.devices = [];
                Restangular.all('game').getList().then(function (games) {
                    Restangular.all('device').getList().then(function (devices) {
                        angular.forEach(games, function (game) {
                            game.list = [];
                            angular.forEach(scores, function (score) {
                                if (score.game_id == game.gameId) {
                                    score.gameName = game.gameName;
                                    score.gameId = game.gameId;
                                    angular.forEach(devices, function (device) {
                                    if (device.uniqueId == score.device_unique_id) {
                                        game.list.push({device: device.uniqueId, score: score.score});
                                    }
                                });
                                }
                            });
                            $scope.skorlar.push(game);
                        });
                        console.log($scope.skorlar);
                    });
                });
            });

            $scope.viewDevice = function (uniqueId) {
                $location.path("/device/" + uniqueId);
            };

            $scope.viewGame = function (gameId) {
                $location.path("/oyunlar/" + gameId);
            }

            $scope.openDomain = function () {
                $location.path("/admin-domain");
            };

            $scope.back2admin = function () {
                $location.path("/dashboard");
            };

            $scope.openTime = function () {
                $location.path("/zaman");
            }
        });

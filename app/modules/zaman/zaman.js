angular.module('zamanModule', [])

        .run(function ($log) {
            $log.debug("ZAMAN MODULE *************************************");
        })

        .controller('ZamanController', function ($scope, $log, $location, Restangular) {
            $log.debug("Zaman Controller *******************************");

            $scope.timeStart = [];
            $scope.timeEnd = [];
            for (var i = 0; i < 24; i++)
                $scope.timeStart.push(i);
            for (var i = 0; i < 60; i++)
                $scope.timeEnd.push(i);

            Restangular.one('zaman').get().then(function (zaman) {
                $scope.zaman = zaman; // Assign the result
                $scope.startHour = moment($scope.zaman.timeStart).hour();
                $scope.startMinute = moment($scope.zaman.timeStart).minute();
                $scope.endHour = moment($scope.zaman.timeEnd).hour();
                $scope.endMinute = moment($scope.zaman.timeEnd).minute();
            }, function () {
                $scope.back2Admin();
            });

            $scope.saveZaman = function () {
                var timeZoneOffset = new Date().getTimezoneOffset();
                var difHour = timeZoneOffset / 60;
                var difMin = timeZoneOffset % 60;

                var dateStart = new Date();
                var dateEnd = new Date();

                dateStart.setHours($scope.startHour - difHour);
                dateStart.setMinutes($scope.startMinute - difMin);
                dateEnd.setHours($scope.endHour - difHour);
                dateEnd.setMinutes($scope.endMinute - difMin);

                if (!moment(dateStart).isBefore(dateEnd)) {
                    alert("Başlangıç saati bitiş saatinden önce olmalıdır!");
                    return;
                }

                $scope.zaman.timeStart = dateStart;
                $scope.zaman.timeEnd = dateEnd;

                $scope.zaman.put().then(function (data) {
                    console.log(data);
                    $scope.back2Admin();
                }, function (error) {
                    console.log("HATA!");
                    console.log(error);
                });
            }

            // Return back to device listing main page
            $scope.back2Admin = function () {
                $location.path("/dashboard");
            };
        });

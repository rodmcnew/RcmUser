// rcmuserCore include <?php echo "\n"; include(__DIR__ . '/rcmuser.core.js'); ?>

angular.module('rcmuserAdminUsersApp', ['ui.bootstrap', 'rcmuserCore'])

    .controller('rcmuserAdminUsers', ['$scope', '$modal', 'rcmUserHttp', 'RcmUserResult', 'RcmResults',
        function ($scope, $modal, rcmUserHttp, RcmUserResult, RcmResults) {
            var self = this;
            self.url = {
                user: "<?php echo $this->url('RcmUserAdminApiUser', array()); ?>"
            }

            self.rcmUserHttp = rcmUserHttp;

            $scope.alerts = new RcmResults()

            $scope.loading = false;

            $scope.users = JSON.parse('<?php echo json_encode($users); ?>');

            $scope.oneAtATime = false;

        }
    ]).controller('rcmuserAdminUser', ['$scope', 'rcmUserHttp', 'RcmUserResult', 'RcmResults',
        function ($scope, rcmUserHttp, RcmUserResult, RcmResults) {

            var self = this;
            self.url = {
                user: "<?php echo $this->url('RcmUserAdminApiUser', array()); ?>"
            }

            self.rcmUserHttp = rcmUserHttp;

            $scope.alerts = new RcmResults()

            $scope.loading = false;

            $scope.showEdit = false;

            $scope.openEditUser = function()
            {
                var onSuccess = function(data, status){

                    $scope.showEdit = true;
                    $scope.user = data.data;
                }

                self.getUser(onSuccess, $scope.user);
            }

            $scope.openRemoveUser = function()
            {

            }

            self.getUser = function (onSuccess, user) {

                $scope.alerts = new RcmResults()
                $scope.loading = true;

                var apiSuccess = function (data, status) {

                    console.log(data);
                    $scope.loading = false;

                    if(typeof(onSuccess) === 'function'){
                        onSuccess(data, status);
                    }
                };

                var apiFail = function (data, status) {

                    $scope.loading = false;
                    $scope.alerts.add(data);
                };

                var config = {
                    method: 'GET',
                    url: self.url.user +'/'+user.id
                };

                self.rcmUserHttp.execute(config, apiSuccess, apiFail);
            };
        }
    ])
    .filter('userFilter', function () {

        var compareStr = function (stra, strb) {
            stra = ("" + stra).toLowerCase();
            strb = ("" + strb).toLowerCase();

            return stra.indexOf(strb) !== -1;
        }

        return function (input, query) {
            if (!query) {
                return input
            }
            var result = [];

            angular.forEach(input, function (user) {
                if (compareStr(user.id, query)
                    || compareStr(user.username, query)
                    || compareStr(user.state, query)
                    ) {
                    result.push(user);
                }
            });

            return result;
        };
    });

// rcmuserCore include <?php echo "\n"; include(__DIR__ . '/rcmuser.core.js'); ?>

angular.module('rcmuserAdminUsersApp', ['ui.bootstrap', 'rcmuserCore'])

    .controller('rcmuserAdminUsers', ['$scope', '$log', '$modal', 'rcmUserHttp', 'RcmUserResult', 'RcmResults',
        function ($scope, $log, $modal, rcmUserHttp, RcmUserResult, RcmResults) {
            var self = this;
            self.url = {
                user: "<?php echo $this->url('RcmUserAdminApiUser', array()); ?>"
            }

            self.rcmUserHttp = rcmUserHttp;

            $scope.alerts = new RcmResults()

            $scope.loading = false;

            $scope.availableStates = [
                'enabled',
                'disabled'
            ]

            // Users
            eval('self.usersResult = <?php echo json_encode($usersResult); ?>');
            $log.log(self.usersResult);
            $scope.users = self.usersResult.data;
            $scope.messages = self.usersResult.messages;
            $scope.showMessages = false;

            // User Roles
            eval('self.roles = <?php echo json_encode($roles); ?>');
            $scope.roles = self.roles;

            eval('self.rolePropertyId = <?php echo json_encode($rolePropertyId); ?>');
            $scope.rolePropertyId = self.rolePropertyId;

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

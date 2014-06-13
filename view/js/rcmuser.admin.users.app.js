// rcmuserCore include <?php echo "\n"; include(__DIR__ . '/rcmuser.core.js'); ?>

angular.module('rcmuserAdminUsersApp', ['ui.bootstrap', 'rcmuserCore'])
    .factory('rcmuserAdminUsersData', function(){

        self = this;
        eval('self.usersResult = <?php echo json_encode($usersResult); ?>');

        eval('self.roles = <?php echo json_encode($roles); ?>');

        eval('self.defaultRoles = <?php echo json_encode($defaultRoles); ?>');

        eval('self.rolePropertyId = <?php echo json_encode($rolePropertyId); ?>');

        self.url = {
            users: "<?php echo $this->url('RcmUserAdminApiUser', array()); ?>"
        }

        self.availableStates = [
            'enabled',
            'disabled'
        ]

        return self;

    })
    .controller('rcmuserAdminUsers', ['$scope', '$log', '$modal', 'rcmUserHttp', 'RcmUserResult', 'RcmResults', 'rcmuserAdminUsersData',
        function ($scope, $log, $modal, rcmUserHttp, RcmUserResult, RcmResults, rcmuserAdminUsersData) {
            var self = this;

            self.rcmUserHttp = rcmUserHttp;

            $scope.alerts = new RcmResults()
            $scope.loading = false;

            $scope.availableStates = [
                'enabled',
                'disabled'
            ]

            // User
            $scope.users = rcmuserAdminUsersData.usersResult.data;
            $scope.messages = rcmuserAdminUsersData.usersResult.messages;
            $scope.showMessages = false;

            // User Roles
            $scope.roles = rcmuserAdminUsersData.roles;
            $scope.rolePropertyId = rcmuserAdminUsersData.rolePropertyId;

            $scope.oneAtATime = false;

        }
    ]).controller('rcmuserAdminUser', ['$scope', '$log', 'rcmUserHttp', 'RcmUserResult', 'RcmResults', 'rcmuserAdminUsersData', 'getNamespaceRepeatString',
        function ($scope, $log, rcmUserHttp, RcmUserResult, RcmResults, rcmuserAdminUsersData, getNamespaceRepeatString) {

            var self = this;
            self.url = rcmuserAdminUsersData.url;
            self.rolePropertyId = rcmuserAdminUsersData.rolePropertyId;
            self.rcmUserHttp = rcmUserHttp;

            $scope.alerts = new RcmResults()
            $scope.loading = false;

            $scope.getNamespaceRepeatString = getNamespaceRepeatString;

            $scope.showEdit = false;

            $scope.defaultRoles = rcmuserAdminUsersData.defaultRoles;

            $scope.orgUser = angular.copy($scope.user);

            $scope.isDefaultRole = function(roleId){

                var index = $scope.defaultRoles.indexOf(roleId)

                if(index !== -1){

                    return true;
                }

                return false;
            }

            $scope.openEditUser = function () {
                var onSuccess = function (data, status) {

                    $scope.showEdit = true;
                    $scope.user = data.data;
                }

                self.getUser(onSuccess, $scope.user);
            }

            $scope.openDeleteUser = function () {
                // show dialog
            }

            $scope.addRole = function (user, roleId) {

                if(user.properties[self.rolePropertyId].indexOf(roleId) === -1){

                    user.properties[self.rolePropertyId].push(roleId);
                }
            }

            $scope.removeRole = function (user, roleId) {

                var index = user.properties[self.rolePropertyId].indexOf(roleId);

                if(index === -1){

                    return;
                }

                user.properties[self.rolePropertyId].splice(index, 1);
            }

            $scope.addUser = function (user) {

                console.log(user);
            }

            $scope.updateUser = function (user) {


                var onSuccess = function (data, status) {

                    console.log(data);
                    $scope.user = data.data;
                }

                self.updateUser(onSuccess, user);
            }

            $scope.removeUser = function (user) {

                console.log(user);
            }

            $scope.resetUser = function ()
            {
                $scope.user = angular.copy($scope.orgUser);
            }

            self.updateUser = function (onSuccess, user) {

                $scope.alerts = new RcmResults()
                $scope.loading = true;

                var apiSuccess = function (data, status) {

                    console.log(data);
                    $scope.loading = false;

                    if (typeof(onSuccess) === 'function') {
                        onSuccess(data, status);
                    }
                };

                var apiFail = function (data, status) {

                    $scope.loading = false;
                    $scope.alerts.add(data);
                };

                var config = {
                    method: 'PUT',
                    url: self.url.users + '/' + user.id,
                    data: user
                };

                self.rcmUserHttp.execute(config, apiSuccess, apiFail);
            };

            self.getUser = function (onSuccess, user) {

                $scope.alerts = new RcmResults()
                $scope.loading = true;

                var apiSuccess = function (data, status) {

                    console.log(data);
                    $scope.loading = false;

                    if (typeof(onSuccess) === 'function') {
                        onSuccess(data, status);
                    }
                };

                var apiFail = function (data, status) {

                    $scope.loading = false;
                    $scope.alerts.add(data);
                };

                var config = {
                    method: 'GET',
                    url: self.url.users + '/' + user.id
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

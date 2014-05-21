'use strict';

angular.module('rcmuserAdminAclApp', ['ui.bootstrap'])

    .controller('rcmuserAdminAclRoles', ['$scope', '$modal', '$http', function ($scope, $modal, $http) {

        var self = this;
        self.url = {
            rule: "<?php echo $this->url('RcmUserAdminApiAclRule', array()); ?>",
            roles: "<?php echo $this->url('RcmUserAdminApiAclRulesByRoles', array()); ?>"
        }

        $scope.oneAtATime = true;
        $scope.alerts = [];

        $scope.resources = JSON.parse('<?php echo json_encode($resources); ?>');
        var resourceCount = $scope.resources.length

        $scope.roles = JSON.parse('<?php echo json_encode($roles); ?>');

        $scope.superAdminRole = '<?php echo $superAdminRole; ?>';

        $scope.levelRepeat = function (repeatStr, namespace) {
            var n = (namespace.split(".").length - 1);
            var a = [];
            while (a.length < n) {
                a.push(repeatStr);
            }
            return a.join('');
        };

        $scope.openAddRule = function (size, roleData, resources) {

            var controller = function ($scope, $modalInstance) {

                $scope.alerts = [];
                $scope.status = {
                    isopen: true
                };

                $scope.toggleDropdown = function ($event, isopen) {
                    $event.preventDefault();
                    $event.stopPropagation();
                    $scope.status.isopen = isopen;
                };

                $scope.roleData = roleData;
                $scope.resources = resources;
                $scope.ruleData = {
                    rule: 'allow',
                    roleId: roleData.role.roleId,
                    resource: '',
                    privilege: ''
                }

                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };

                $scope.close = function () {
                    $modalInstance.close();
                };

                var onSuccess = function (data, status) {
                    $scope.close();
                };

                var onFail = function (data, status) {
                    $scope.alerts.push(data)
                };

                $scope.addRule = function () {

                    addRule(
                        $scope.ruleData,
                        onSuccess,
                        onFail
                    );
                };


            };

            var addRuleModal = $modal.open({
                templateUrl: 'addRule.html',
                controller: controller,
                size: size
            });
        }

        $scope.openRemoveRule = function (size, ruleData, resourceData) {

            var removeRuleModal = $modal.open({

                templateUrl: 'removeRule.html',
                controller: function ($scope, $modalInstance) {

                    $scope.ruleData = ruleData;
                    $scope.resourceData = resourceData;

                    $scope.removeRule = function () {

                        removeRule($scope.ruleData);
                        removeRuleModal.close();
                    };

                    $scope.cancel = function () {
                        removeRuleModal.dismiss('cancel');
                    };
                },
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });
        }

        $scope.openAddRole = function (size, roles) {

            var addRuleModal = $modal.open({

                templateUrl: 'addRole.html',
                controller: function ($scope, $modalInstance) {

                    $scope.alerts = [];

                    $scope.roles = roles;

                    $scope.roleData = {
                        roleId: 'NewRole',
                        parentRoleId: '',
                        description: ''
                    };

                    $scope.addRole = function () {


                        addRuleModal.close();
                    };

                    $scope.cancel = function () {
                        addRuleModal.dismiss('cancel');
                    };
                },
                size: size
            });
        }

        ///
        var addRule = function (ruleData, onSuccess, onFail) {

            var success = function (data, status) {

                console.log('Success: ' + status);
                console.log(data);

                getRoles(onSuccess, onFail);
            };

            var error = function (data, status) {

                console.log('Error: ' + status);
                console.log(data);

                if (typeof(onFail) === 'function') {

                    onFail(data, status);
                }
            };

            $http.post(
                    self.url.rule,
                    ruleData
                )
                .success(success)
                .error(error);
        }

        var removeRule = function (ruleData, onSuccess, onFail) {

            console.log('removeRule: ' + JSON.stringify(ruleData));

            $http.delete(
                    self.url.rule + "/" + JSON.stringify(ruleData)
                )
                .success(
                function (data, status) {
                    console.log('Success: ' + status + " " + data);
                }
            )
                .error(
                function (data, status) {
                    console.log('Error: ' + status + " " + data);
                }
            );
        };

        var addRole = function (roleData) {

            console.log('addRole: ' + JSON.stringify(roleData));
        }

        var removeRole = function () {

        }

        var getRoles = function (onSuccess, onFail) {

            var success = function (data, status) {

                console.log('Success: ' + status);
                console.log(data);

                $scope.roles = data;

                if (typeof(onSuccess) === 'function') {

                    onSuccess(data, status);
                }
            };

            var error = function (data, status) {

                console.log('Error: ' + status);
                console.log(data);

                if (typeof(onFail) === 'function') {
                    onFail(data, status);
                }
            };

            $http.get(
                    self.url.roles
                )
                .success(success)
                .error(error);
        }

    }])
    .filter('resourceFilter', function () {

        var compareStr = function (stra, strb) {
            stra = ("" + stra).toLowerCase();
            strb = ("" + strb).toLowerCase();

            return stra.indexOf(strb) !== -1;
        }

        return function (input, query) {
            if (!query) return input;
            var result = [];

            angular.forEach(input, function (resource) {
                if (compareStr(resource.resource.resourceId, query)
                    || compareStr(resource.resource.name, query)) {
                    result.push(resource);
                }
            });

            return result;
        };
    });

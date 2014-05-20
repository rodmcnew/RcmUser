'use strict';

angular.module('rcmuserAdminAclApp', ['ui.bootstrap'])

    .controller('rcmuserAdminAclRoles', ['$scope', '$modal', '$http', function ($scope, $modal, $http) {

        var self = this;

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

            var addRuleModal = $modal.open({

                templateUrl: 'addRule.html',
                controller: function ($scope, $modalInstance) {

                    $scope.roleData = roleData;
                    $scope.resources = resources;
                    $scope.ruleData = {'test': 'test'}

                    $scope.addRule = function () {

                        addRule($scope.ruleData);
                        addRuleModal.close();
                    };

                    $scope.cancel = function () {
                        addRuleModal.dismiss('cancel');
                    };
                },
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

                    $scope.roles = roles;

                    $scope.roleData = {
                        roleId : 'NewRole',
                        parentRoleId : '',
                        description : ''
                    };

                    $scope.addRole = function () {

                        addRole($scope.roleData);
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
        var addRule = function (ruleData) {

            $http.post(
                "<?php echo $this->url('RcmUserAdminApiAclRule', array()); ?>",
                ruleData
            )
                .success(
                function (data, status) {
                    console.log('Success: '+status+" "+data);
                }
            )
                .error(
                function (data, status) {
                    console.log('Error: '+status+" "+data);
                }
            );
        }

        var removeRule = function (ruleData, onSuccess, onFail) {

            console.log('removeRule: '+JSON.stringify(ruleData));

            $http.delete(
                    "<?php echo $this->url('RcmUserAdminApiAclRule', array()); ?>/"+JSON.stringify(ruleData)
                )
                .success(
                function (data, status) {
                    console.log('Success: '+status+" "+data);
                }
            )
                .error(
                function (data, status) {
                    console.log('Error: '+status+" "+data);
                }
            );
        };

        var addRole = function (roleData) {

            console.log('addRole: '+JSON.stringify(roleData));
        }

        var removeRole = function () {

        }

    }]);

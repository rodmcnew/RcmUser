'use strict';

angular.module('rcmuserAdminAclApp', ['ui.bootstrap'])

    .controller('rcmuserAdminAclRoles', ['$scope', '$modal', '$http', function ($scope, $modal, $http) {

        var self = this;

        $scope.oneAtATime = true;
        $scope.alerts = [];

        $scope.resources = JSON.parse('<?php echo json_encode($resources); ?>');
        var resourceCount = $scope.resources.length

        $scope.roles = JSON.parse('<?php echo json_encode($roles); ?>');

        $scope.levelRepeat = function (s, n) {
            var a = [];
            while (a.length < n) {
                a.push(s);
            }
            return a.join('');
        };

        $scope.openRemove = function (size, ruleData, resourceData) {

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

        ///
        var addRule = function (ruleData) {

            $http.put(
                "<?php echo $this->url('RcmUserAdminApiAclRule', array()); ?>",
                ruleData
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
            )
        }

        var addRole = function () {

        }

        var removeRole = function () {

        }

    }]);

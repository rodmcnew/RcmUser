'use strict';

angular.module('rcmuserAdminAclApp', ['ui.bootstrap'])

    .controller('rcmuserAdminAclRoles', ['$scope', '$modal', function ($scope, $modal) {

        var self = this;

        $scope.oneAtATime = true;
        $scope.resources = JSON.parse('<?php echo json_encode($resources); ?>');
        var resourceCount = $scope.resources.length

        $scope.roles = JSON.parse('<?php echo json_encode($roles); ?>');

        $scope.selectedRuleData = null;

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
                        removeRuleModal.close($scope.ruleData);
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





        /////////
        $scope.onRemoveRuleAction = function ($ruleData) {

            // pop dialog
        }

        $scope.removeRule = function () {

        }

        $scope.onAddRuleAction = function ($ruleData) {

            // pop dialog
        }


        $scope.addRule = function ($ruleData) {

        }

    }])

    .directive('removeRuleModel', ['$scope', function ($scope) {

        return {
            restrict: 'A',
            //template : '',
            templateUrl: 'resources/module.tpl',
            link: function (scope, element, attrs, ngModel) {

                console.log("bizResourcesInclude");
                scope.resourcesDataAlerts = new Alerts(scope);
                scope.resourcesDataAlerts.displayTime = 0;
                scope.error = false;

                resourcesDataService.onExecuteStart = function () {

                    scope.resourcesDataAlerts.clearAll();
                    scope.error = false;
                };

                resourcesDataService.onSuccess = function () {

                    scope.resourcesDataAlerts.clearAll();
                    scope.error = false;
                };

                resourcesDataService.onFail = function (exception) {

                    console.log('resourcesDataService.onFail');
                    scope.resourcesDataAlerts.thrwNew(exception, 'error');
                    scope.error = true;
                };

                scope.resourcesDataService = resourcesDataService;
            }
        };
    }
    ]);

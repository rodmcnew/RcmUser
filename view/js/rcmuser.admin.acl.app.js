'use strict';

angular.module('rcmuserAdminAclApp', ['ui.bootstrap'])

    .controller('rcmuserAdminAclRoles', ['$scope', '$modal', 'rcmUserHttp', 'RcmUserResult', 'RcmResults', function ($scope, $modal, rcmUserHttp, RcmUserResult, RcmResults) {

        var getRoles;
        var self = this;
        self.url = {
            rule: "<?php echo $this->url('RcmUserAdminApiAclRule', array()); ?>",
            role: "<?php echo $this->url('RcmUserAdminApiAclRole', array()); ?>",
            roles: "<?php echo $this->url('RcmUserAdminApiAclRulesByRoles', array()); ?>"
        }
        self.rcmUserHttp = rcmUserHttp;

        $scope.alerts = new RcmResults()

        $scope.loading = true;

        $scope.resources = JSON.parse('<?php echo json_encode($resources); ?>');
        $scope.roles = JSON.parse('<?php echo json_encode($roles); ?>');
        $scope.superAdminRole = '<?php echo $superAdminRole; ?>';

        $scope.oneAtATime = true;

        var resourceCount = $scope.resources.length

        $scope.levelRepeat = function (repeatStr, namespace) {
            var n = (namespace.split(".").length - 1);
            var a = [];
            while (a.length < n) {
                a.push(repeatStr);
            }
            return a.join('');
        };

        /**
         * Open add rule modal
         *
         * @param size
         * @param roleData
         * @param resources
         */
        $scope.openAddRule = function (size, roleData, resources) {

            var self = this;

            self.controller = function ($scope, $modalInstance) {

                $scope.alerts = new RcmResults()
                $scope.loading = false;

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
                    resourceId: '',
                    privilege: ''
                }

                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };

                $scope.close = function () {
                    $modalInstance.close();
                };

                var onSuccess = function (data, status) {

                    $scope.loading = false;
                    $scope.close();
                };

                var onFail = function (data, status) {

                    $scope.loading = false;
                    $scope.alerts.add(data);
                };

                var isValid = function(){

                    if(!$scope.resources[$scope.ruleData.resourceId]){

                        $scope.alerts.add(new RcmUserResult(0, ['Resource is not valid.'], null));
                        return false;
                    }

                    return true;
                }

                $scope.addRule = function () {

                    if(!isValid()){
                        return;
                    }

                    $scope.loading = true;
                    $scope.alerts.clear();

                    addRule(
                        $scope.ruleData,
                        onSuccess,
                        onFail
                    );
                };

            };

            var modal = $modal.open({
                templateUrl: 'addRule.html',
                controller: self.controller,
                size: size
            });

        }

        $scope.openRemoveRule = function (size, ruleData, resourceData) {

            var self = this;

            self.controller = function ($scope, $modalInstance) {

                $scope.alerts = new RcmResults()
                $scope.loading = false;

                $scope.ruleData = ruleData;
                $scope.resourceData = resourceData;

                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };

                $scope.close = function () {
                    $modalInstance.close();
                };

                var onSuccess = function (data, status) {

                    $scope.loading = false;
                    $scope.close();
                };

                var onFail = function (data, status) {

                    $scope.loading = false;
                    $scope.alerts.add(data);
                };

                $scope.removeRule = function () {

                    $scope.loading = true;
                    $scope.alerts.clear();

                    removeRule(
                        $scope.ruleData,
                        onSuccess,
                        onFail
                    );
                };
            };

            var modal = $modal.open({
                templateUrl: 'removeRule.html',
                controller: self.controller,
                size: size
            });
        }

        $scope.openAddRole = function (size, roles) {
            var self = this;

            self.controller = function ($scope, $modalInstance) {

                $scope.alerts = new RcmResults()
                $scope.loading = false;


                $scope.roles = roles;
                $scope.roleData = {
                    roleId: '',
                    parentRoleId: '',
                    description: ''
                };

                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };

                $scope.close = function () {
                    $modalInstance.close();
                };

                var onSuccess = function (data, status) {

                    $scope.loading = false;
                    $scope.close();
                };

                var onFail = function (data, status) {

                    $scope.loading = false;
                    $scope.alerts.add(data);
                };

                var isValid = function(){

                    return true;
                }

                $scope.addRole = function () {

                    if(!isValid()){
                        return;
                    }

                    $scope.loading = true;
                    $scope.alerts.clear();

                    addRole(
                        $scope.roleData,
                        onSuccess,
                        onFail
                    );
                };

            };

            var modal = $modal.open({
                templateUrl: 'addRole.html',
                controller: self.controller,
                size: size
            });
        }

        $scope.openRemoveRole = function (size, roleData) {

            var self = this;

            self.controller = function ($scope, $modalInstance) {

                $scope.alerts = new RcmResults()
                $scope.loading = false;

                $scope.roleData = roleData;

                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };

                $scope.close = function () {
                    $modalInstance.close();
                };

                var onSuccess = function (data, status) {

                    $scope.loading = false;
                    $scope.close();
                };

                var onFail = function (data, status) {

                    $scope.loading = false;
                    $scope.alerts.add(data);
                };

                $scope.removeRole = function () {

                    $scope.loading = true;
                    $scope.alerts.clear();

                    removeRole(
                        $scope.roleData.role,
                        onSuccess,
                        onFail
                    );
                };
            };

            var modal = $modal.open({
                templateUrl: 'removeRole.html',
                controller: self.controller,
                size: size
            });
        }

        //////////////////////
        self.getRoles = function (onSuccess, onFail) {

            var apiSuccess = function (data, status) {

                $scope.roles = data;

                if (typeof(onSuccess) === 'function') {

                    onSuccess(data, status);
                }
            };

            var apiFail = function (data, status) {

                if (typeof(onFail) === 'function') {

                    onFail(data, status);
                }
            };

            var config = {
                method: 'GET',
                url: self.url.roles
            };

            self.rcmUserHttp.execute(config, apiSuccess, apiFail);
        };

        /**
         * Add Rule
         *
         * @param ruleData
         * @param onSuccess
         * @param onFail
         */
        var addRule = function (ruleData, onSuccess, onFail) {

            var apiSuccess = function (data, status) {

                // @todo add callbacks
                self.getRoles(onSuccess, onFail);
            };

            var apiFail = function (data, status) {

                if (typeof(onFail) === 'function') {

                    onFail(data, status);
                }
            };

            var config = {
                method: 'POST',
                url: self.url.rule,
                data: ruleData
            };

            self.rcmUserHttp.execute(config, apiSuccess, apiFail);
        }

        var removeRule = function (ruleData, onSuccess, onFail) {

            var apiSuccess = function (data, status) {

                // @todo add callbacks
                self.getRoles(onSuccess, onFail);
            };

            var apiFail = function (data, status) {

                if (typeof(onFail) === 'function') {

                    onFail(data, status);
                }
            };

            var config = {
                method: 'DELETE',
                url: self.url.rule + "/" + JSON.stringify(ruleData)
                //params: JSON.stringify(ruleData)
            };

            self.rcmUserHttp.execute(config, apiSuccess, apiFail);
        };

        var addRole = function (roleData, onSuccess, onFail) {

            var apiSuccess = function (data, status) {

                // @todo add callbacks
                self.getRoles(onSuccess, onFail);
            };

            var apiFail = function (data, status) {

                if (typeof(onFail) === 'function') {

                    onFail(data, status);
                }
            };

            var config = {
                method: 'POST',
                url: self.url.role,
                data: roleData
            };

            self.rcmUserHttp.execute(config, apiSuccess, apiFail);
        }

        var removeRole = function (roleData, onSuccess, onFail) {

            var apiSuccess = function (data, status) {

                // @todo add callbacks
                self.getRoles(onSuccess, onFail);
            };

            var apiFail = function (data, status) {

                if (typeof(onFail) === 'function') {

                    onFail(data, status);
                }
            };

            var config = {
                method: 'DELETE',
                url: self.url.role + "/" + roleData.roleId
            };

            self.rcmUserHttp.execute(config, apiSuccess, apiFail);
        };
    }])
    .filter('resourceFilter', function () {

        var compareStr = function (stra, strb) {
            stra = ("" + stra).toLowerCase();
            strb = ("" + strb).toLowerCase();

            return stra.indexOf(strb) !== -1;
        }

        return function (input, query) {
            if (!query) {
                return input
            };
            var result = [];

            angular.forEach(input, function (resource) {
                if (compareStr(resource.resource.resourceId, query)
                    || compareStr(resource.resource.name, query)) {
                    result.push(resource);
                }
            });

            return result;
        };
    })
    .factory('rcmUserHttp', ['$http', 'RcmUserResult', function($http, RcmUserResult) {

        var RcmUserHttp = function(){

            var self = this;
            self.http = $http;
            self.comErrorMessage = 'There was an error talking to the server: ';

            self.execute = function(config, onSuccess, onFail) {

                self.http(config)
                    .success(function(data, status, headers, config) {

                        // if is result object
                        if(typeof(data.code) !== 'undefined' && typeof(data.messages) !== 'undefined' ){

                            if(data.code < 1){

                                if (typeof(onFail) === 'function') {

                                    onFail(data);
                                }

                                return;
                            }
                        }

                        if ((typeof(onSuccess) === 'function')) {

                            onSuccess(data, config);
                        }
                    })
                    .error(function(data, status, headers, config) {

                        if (typeof(onFail) === 'function') {

                            onFail(new RcmUserResult(0, [self.comErrorMessage + status], data));
                        }
                    });
            }

        }

        return new RcmUserHttp();

    }])
    .factory('RcmUserResult', function() {

        var RcmUserResult = function(code, messages, data){

            var self = this;

            self.code = code;
            self.messages = messages;
            self.data = data;
        }

        return RcmUserResult;

    })
    .factory('RcmResults', function() {

        var RcmResults = function(){

            var self = this;

            self.results = [];

            self.add = function(result) {

                self.results.push(result);
            };

            self.remove = function(index) {

                self.results.splice(index, 1);
            };

            self.clear = function(){

                self.results = [];
            }
        }

        return RcmResults;
    })
    .directive('rcmAlerts', function () {
        /*
         * Example:
         * <div rcm-alerts rcm-results="alerts" alert-title="'An error occured:'"></div>
         */

        var thislink = function(scope, element, attrs){

            scope.closeAlert = function(index) {
                scope.rcmResults.clear();
            };
        }

        return {
            link: thislink,
            restrict: 'A',
            scope: {
                'rcmResults': '=',
                'alertTitle': '='
            },
            template: ''+
            '<alert class="alert" ng-repeat="alert in rcmResults.results" type="{{alert.type}}" close="closeAlert($index)">'+
            '    <div class="alert-header">'+
            '        <i class="glyphicon glyphicon-warning-sign"></i>'+
            '        <span class="alert-title"><strong>{{alertTitle}}</strong></span>'+
            '    </div>'+
            '    <div class="alert-messages">'+
            '        <ul>'+
            '            <li ng-repeat="msg in alert.messages">{{msg}}</li>'+
            '        </ul>'+
            '    </div>'+
            '</alert>'
        };


    });

// rcmuserCore include <?php echo "\n"; include(__DIR__ . '/rcmuser.core.js'); ?>

angular.module('rcmuserAdminAclApp', ['ui.bootstrap', 'rcmuserCore'])

    .controller('rcmuserAdminAclRoles', ['$scope', '$modal', 'rcmUserHttp', 'RcmUserResult', 'RcmResults',
        function ($scope, $modal, rcmUserHttp, RcmUserResult, RcmResults) {

        var getRoles;
        var self = this;
        self.url = {
            rule: "<?php echo $this->url('RcmUserAdminApiAclRule', array()); ?>",
            role: "<?php echo $this->url('RcmUserAdminApiAclRole', array()); ?>",
            roles: "<?php echo $this->url('RcmUserAdminApiAclRulesByRoles', array()); ?>"
        }
        self.rcmUserHttp = rcmUserHttp;

        $scope.alerts = new RcmResults()

        $scope.loading = false;

        eval('$scope.resources = <?php echo json_encode($resources); ?>');
        eval('$scope.roles = <?php echo json_encode($rolesResult->getData()); ?>');
        $scope.superAdminRole = '<?php echo $superAdminRoleId; ?>';
        $scope.guestRole = '<?php echo $guestRoleId; ?>';

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
                    isopen: false
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
            }
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

'use strict';
/** rcmUser from core js **/
rcmUser.adminRoles = {};

angular.module('rcmUserAdminRoles', ['rcmuserCore'])
    .factory(
    'rcmUserAdminRolesService',
    [
        '$log', '$http', 'rcmUserConfig',
        function ($log, $http, rcmUserConfig) {

            /**
             * RcmUserAdminRolesService
             * @constructor
             */
            var RcmUserAdminRolesService = function () {

                var self = this;

                /**
                 * List of API urls
                 * @type {{roles: string}}
                 */
                var url = rcmUserConfig.url.role;

                /**
                 * Simple error tracking
                 * @type {{}}
                 */
                self.errors = {};

                /**
                 * requestRoles
                 * @param onSuccess
                 * @param onError
                 */
                self.requestRoles = function () {

                    if (rcmUser.cache.roleRequested) {
                        return;
                    }

                    rcmUser.cache.roleRequested = true;

                    // @todo use the Rcm User version to get
                    $http(
                        {
                            method: 'GET',
                            url: url
                        }
                    )
                        .success(
                        function (data, status, headers, config) {
                            rcmUser.cache.roles = data.data;
                            rcmUser.eventManager.trigger(
                                'rcmUserAdminRolesService.requestRoles.success',
                                rcmUser.cache.roles
                            );
                        }
                    )
                        .error(
                        function (data, status, headers, config) {
                            $log.error('An error occured while talking to the server');
                        }
                    );
                };

                /**
                 * getRoles - Api call to get list of roles
                 */
                self.getRoles = function () {

                    return rcmUser.cache.roles;
                };

                /**
                 * getRole from the list of roles
                 * @param roleId
                 */
                self.getRole = function (roleId) {

                    if (rcmUser.cache.roles[roleId]) {
                        return rcmUser.cache.roles[roleId];
                    }

                    return null;

                };

                /**
                 * setSelectedRoles
                 * @param valueNamespace
                 * @param roles
                 */
                self.setSelectedRoles = function (valueNamespace, roles) {

                    angular.forEach(
                        roles,
                        function (value, roleId) {
                            self.setSelectedRole(
                                valueNamespace,
                                roleId
                            );
                        }
                    );

                    rcmUser.eventManager.trigger(
                        'rcmUserAdminRolesService.setSelectedRoles',
                        {
                            valueNamespace: valueNamespace,
                            selectedRoles: rcmUser.cache.selectedRoles[valueNamespace]
                        }
                    );
                };

                /**
                 * getSelectedRoles
                 * @param valueNamespace
                 */
                self.getSelectedRoles = function (valueNamespace) {

                    if (rcmUser.cache.selectedRoles[valueNamespace]) {
                        return rcmUser.cache.selectedRoles[valueNamespace]
                    }

                    return {};
                };

                /**
                 * setSelectedRole
                 * @param valueNamespace
                 * @param roleId
                 */
                self.setSelectedRole = function (valueNamespace, roleId) {

                    if (!rcmUser.cache.selectedRoles[valueNamespace]) {
                        rcmUser.cache.selectedRoles[valueNamespace] = {};
                    }

                    if (rcmUser.cache.roles[roleId]) {

                        rcmUser.cache.selectedRoles[valueNamespace][roleId] = rcmUser.cache.roles[roleId];

                        rcmUser.eventManager.trigger(
                            'rcmUserAdminRolesService.setSelectedRole',
                            rcmUser.cache.selectedRoles[valueNamespace][roleId]
                        );
                    } else {
                        // console.error('Role (' + roleId + ') not valid');
                    }

                };

                /**
                 * getSelectedRole
                 * @param valueNamespace
                 * @param roleId
                 * @returns {*}
                 */
                self.getSelectedRole = function (valueNamespace, roleId) {

                    var selectedRoles = self.getSelectedRoles(valueNamespace);

                    if (selectedRoles[roleId]) {
                        return selectedRoles[roleId];
                    }

                    return null;
                };

                /**
                 * removeSelectedRole
                 * @param valueNamespace
                 * @param roleId
                 */
                self.removeSelectedRole = function (valueNamespace, roleId) {

                    if (!rcmUser.cache.selectedRoles[valueNamespace]) {
                        return;
                    }

                    rcmUser.cache.selectedRoles[valueNamespace][roleId] = null;
                };


                /**
                 *
                 * @param valueNamespace
                 * @param roleId
                 * @returns {*}
                 */
                self.hasSelectedRole = function (valueNamespace, roleId) {
                    var role = self.getSelectedRole(valueNamespace, roleId);

                    return (role);
                };

                /**
                 * hasSelectedRoles
                 * @param valueNamespace
                 */
                self.hasSelectedRoles = function (valueNamespace) {

                    var selectedRoles = self.getSelectedRoles(valueNamespace);

                    var hasSelectedRoles = false;

                    angular.forEach(
                        selectedRoles,
                        function (value, roleId) {
                            if (value) {
                                hasSelectedRoles = true;
                            }
                        }
                    );

                    return hasSelectedRoles;
                };

                /**
                 * clearSelectedRoles
                 * @param valueNamespace
                 */
                self.clearSelectedRoles = function (valueNamespace) {

                    rcmUser.cache.selectedRoles[valueNamespace] = null;
                };
            };

            var rcmUserAdminRolesService = new RcmUserAdminRolesService();

            return rcmUserAdminRolesService;
        }
    ]
);

/**
 * Exposes Angular service to global scope for use by other libraries
 * - This is to support jQuery and native JavaScript modules and code
 * Angular injector to get Module services
 */
angular.injector(['ng', 'rcmUserAdminRoles']).invoke(
    [
        'rcmUserAdminRolesService',
        function (rcmUserAdminRolesService) {

            rcmUser.adminRoles.adminRolesService = rcmUserAdminRolesService;
        }
    ]
);
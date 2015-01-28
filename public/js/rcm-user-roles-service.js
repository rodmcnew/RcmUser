'use strict';
/** rcmUser from core js **/
rcmUser.rcmUserRolesService = {};

angular.module('rcmUserRolesService', ['rcmuserCore'])
    .factory(
    'rcmUserRolesService',
    [
        '$log', '$http', 'rcmUserConfig',
        function ($log, $http, rcmUserConfig) {

            /**
             * RcmUserRolesService
             * @constructor
             */
            var RcmUserRolesService = function () {

                var self = this;

                /**
                 * List of API urls
                 * @type {{roles: string}}
                 */
                self.url = rcmUserConfig.url.role;

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
                            url: self.url
                        }
                    )
                        .success(
                        function (data, status, headers, config) {
                           self.setRoles(data.data);
                        }
                    )
                        .error(
                        function (data, status, headers, config) {
                            $log.error('An error occured while talking to the server');
                        }
                    );
                };

                /**
                 * Force a different list of roles into cache
                 * Warning: Use with caution, roles list should match expected roles list
                 *          Plus this has no protections and can be over written
                 * @param roles
                 */
                self.setRoles = function(roles){

                    rcmUser.cache.roles = roles;
                    rcmUser.eventManager.trigger(
                        'rcmUserRolesService.onSetRoles',
                        rcmUser.cache.roles
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
                        'rcmUserRolesService.onSetSelectedRoles',
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
                            'rcmUserRolesService.onSetSelectedRole',
                            {
                                valueNamespace: valueNamespace,
                                selectedRoles: rcmUser.cache.selectedRoles[valueNamespace],
                                newRole: rcmUser.cache.selectedRoles[valueNamespace][roleId]
                            }
                        );
                    } else {
                        $log.error('Role (' + roleId + ') not valid');
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

                    /** This might be used is required in some browsers where delete does not work
                    var selectedRoles = self.getSelectedRoles(valueNamespace);

                    rcmUser.cache.selectedRoles[valueNamespace] = {};

                    angular.forEach(
                        selectedRoles,
                        function (value, curRoleId) {
                            if (roleId != curRoleId) {
                                rcmUser.cache.selectedRoles[valueNamespace][curRoleId] = value;
                            }
                        }
                    );
                     **/

                    rcmUser.cache.selectedRoles[valueNamespace][roleId] = null;
                    delete rcmUser.cache.selectedRoles[valueNamespace][roleId];

                    rcmUser.eventManager.trigger(
                        'rcmUserRolesService.onRemoveSelectedRole',
                        {
                            valueNamespace: valueNamespace,
                            selectedRoles: rcmUser.cache.selectedRoles[valueNamespace]
                        }
                    );
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
                                return false;
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

                /**
                 * Check if a role registry has all roles
                 * @param roles
                 * @returns {boolean}
                 */
                self.hasAllRoles = function (checkRoles){

                    var hasAllRoles = null;

                    var roles = self.getRoles();

                    angular.forEach(
                        roles,
                        function (value, roleId) {
                            if (!checkRoles[roleId]) {

                                hasAllRoles = false;
                                return false;
                            }
                        }
                    );

                    return hasAllRoles;
                }
            };

            var rcmUserRolesService = new RcmUserRolesService();

            return rcmUserRolesService;
        }
    ]
);

/**
 * Exposes Angular service to global scope for use by other libraries
 * - This is to support jQuery and native JavaScript modules and code
 * Angular injector to get Module services
 */
angular.injector(['ng', 'rcmUserRolesService']).invoke(
    [
        'rcmUserRolesService',
        function (rcmUserRolesService) {

            rcmUser.rcmUserRolesService.service = rcmUserRolesService;
        }
    ]
);
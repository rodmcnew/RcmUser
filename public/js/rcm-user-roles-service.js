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
                 *
                 * @type {string}
                 */
                self.indexProperty = 'roleId';

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

                    // @todo use the Rcm User http version to get
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
                 * indexRoles - hold a lookup of roles
                 * @param onComplete
                 */
                self.indexRoles = function (onComplete) {

                    rcmUser.cache.rolesIndex = {};

                    angular.forEach(
                        rcmUser.cache.roles,
                        function (role, index) {
                            rcmUser.cache.rolesIndex[role[self.indexProperty]] = index;
                        }
                    );

                    onComplete();
                };

                /**
                 * getIndexRoles
                 * @returns {rcmUser.cache.rolesIndex|*}
                 */
                self.getIndexRoles = function () {
                    return rcmUser.cache.rolesIndex;
                };

                /**
                 * Force a different list of roles into cache
                 * Warning: Use with caution, roles list should match expected roles list
                 *          Plus this has no protections and can be over written
                 * @param roles
                 */
                self.setRoles = function (roles) {

                    rcmUser.cache.roles = roles;

                    self.indexRoles(
                        function () {
                            rcmUser.eventManager.trigger(
                                'rcmUserRolesService.onSetRoles',
                                rcmUser.cache.roles
                            );
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
                 * @param index
                 */
                self.getRole = function (index) {

                    if (rcmUser.cache.rolesIndex[index]) {
                        return rcmUser.cache.roles[rcmUser.cache.rolesIndex[index]];
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
                        function (value, index) {
                            self.setSelectedRole(
                                valueNamespace,
                                index
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
                 * getSelectedRolesText
                 * @param valueNamespace
                 */
                self.getSelectedRolesStrings = function (valueNamespace) {

                    var selectedRoles = self.getSelectedRoles();

                    var selectedRolesStrings = {};
                    angular.forEach(
                        selectedRoles,
                        function (value, index) {
                            selectedRolesStrings[index] = index;
                        }
                    );

                    return selectedRolesStrings;
                };

                /**
                 * setSelectedRole
                 * @param valueNamespace
                 * @param index
                 */
                self.setSelectedRole = function (valueNamespace, index) {

                    if (!rcmUser.cache.selectedRoles[valueNamespace]) {
                        rcmUser.cache.selectedRoles[valueNamespace] = {};
                    }

                    if (rcmUser.cache.rolesIndex[index]) {

                        rcmUser.cache.selectedRoles[valueNamespace][index] = rcmUser.cache.roles[rcmUser.cache.rolesIndex[index]];

                        rcmUser.eventManager.trigger(
                            'rcmUserRolesService.onSetSelectedRole',
                            {
                                valueNamespace: valueNamespace,
                                selectedRoles: rcmUser.cache.selectedRoles[valueNamespace],
                                newRole: rcmUser.cache.selectedRoles[valueNamespace][index]
                            }
                        );
                    } else {
                        $log.error('Role (' + index + ') not valid');
                    }

                };

                /**
                 * getSelectedRole
                 * @param valueNamespace
                 * @param index
                 * @returns {*}
                 */
                self.getSelectedRole = function (valueNamespace, index) {

                    var selectedRoles = self.getSelectedRoles(valueNamespace);

                    if (selectedRoles[index]) {
                        return selectedRoles[index];
                    }

                    return null;
                };

                /**
                 * removeSelectedRole
                 * @param valueNamespace
                 * @param index
                 */
                self.removeSelectedRole = function (valueNamespace, index) {

                    if (!rcmUser.cache.selectedRoles[valueNamespace]) {
                        return;
                    }

                    /** This might be used is required in some browsers where delete does not work
                     var selectedRoles = self.getSelectedRoles(valueNamespace);

                     rcmUser.cache.selectedRoles[valueNamespace] = {};

                     angular.forEach(
                     selectedRoles,
                     function (value, curIndex) {
                            if (index != curIndex) {
                                rcmUser.cache.selectedRoles[valueNamespace][curIndex] = value;
                            }
                        }
                     );
                     **/

                    rcmUser.cache.selectedRoles[valueNamespace][index] = null;
                    delete rcmUser.cache.selectedRoles[valueNamespace][index];

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
                 * @param index
                 * @returns {*}
                 */
                self.hasSelectedRole = function (valueNamespace, index) {

                    var role = self.getSelectedRole(valueNamespace, index);

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
                        function (value, index) {
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
                self.hasAllRoles = function (checkRoles) {

                    var hasAllRoles = null;

                    var roles = self.getIndexRoles();

                    angular.forEach(
                        roles,
                        function (value, index) {
                            if (!checkRoles[index]) {

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
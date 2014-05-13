'use strict';

var rcmuserAdminAclApp = angular.module('rcmuserAdminAclApp', ['ui.bootstrap']);
var rcmuserAdminAclRoles = function ($scope) {

    $scope.oneAtATime = true;

    $scope.levelRepeat = function (s, n) {
        var a = [];
        while (a.length < n) {
            a.push(s);
        }
        return a.join('');
    }

    $scope.resources = {"root":{"resource":{"resourceId":"root","parentResourceId":null,"privileges":["read","update","create","delete","execute"],"name":"root","description":"This is the lowest level resource.  Access to this will allow access to all resources."},"resourceNs":"root"},"rcmuser":{"resource":{"resourceId":"rcmuser","parentResourceId":"root","privileges":[],"name":"RCM User","description":"All RCM user access."},"resourceNs":"root.rcmuser"},"rcmuser-user-administration":{"resource":{"resourceId":"rcmuser-user-administration","parentResourceId":"rcmuser","privileges":["read","write"],"name":"User Administration","description":"Allows the editing of user data."},"resourceNs":"root.rcmuser.rcmuser-user-administration"},"rcmuser-acl-administration":{"resource":{"resourceId":"rcmuser-acl-administration","parentResourceId":"rcmuser","privileges":[],"name":"Role and Access Administration","description":"Allows the editing of user roles data."},"resourceNs":"root.rcmuser.rcmuser-acl-administration"}}

    var resourceCount = $scope.resources.length;
    $scope.roles = {"guest":{"role":{"roleId":"guest","description":null,"parentRoleId":null},"rules":[]},"user":{"role":{"roleId":"user","description":null,"parentRoleId":"guest"},"rules":[]},"manager":{"role":{"roleId":"manager","description":null,"parentRoleId":"user"},"rules":[{"rule":"allow","roleid":"manager","resource":"rcmuser-acl-administration","privilege":""}]},"admin":{"role":{"roleId":"admin","description":null,"parentRoleId":"manager"},"rules":[{"rule":"allow","roleid":"admin","resource":"root","privilege":""}]},"customer":{"role":{"roleId":"customer","description":"RCM","parentRoleId":"user"},"rules":[]}};

    $scope.getResourceNs = function(resourceId){

        console.log(resourceId);

        var result = 'NOPE';

        angular.forEach($scope.resources, function(resource, key) {

            console.log(resource + ' ' + key);

            if ($scope.resources[key].resourceId == resourceId) {

                console.log('FOUND: ' + key);
                result = key;
                return key;
            }
        });

        return result;
    }
};

function AccordionDemoCtrl($scope) {
    $scope.oneAtATime = true;

    $scope.groups = [
        {
            title: 'Dynamic Group Header - 1',
            content: 'Dynamic Group Body - 1'
        },
        {
            title: 'Dynamic Group Header - 2',
            content: 'Dynamic Group Body - 2'
        }
    ];

    $scope.items = ['Item 1', 'Item 2', 'Item 3'];

    $scope.addItem = function () {
        var newItemNo = $scope.items.length + 1;
        $scope.items.push('Item ' + newItemNo);
    };

    $scope.status = {
        isFirstOpen: true,
        isFirstDisabled: false
    };
}

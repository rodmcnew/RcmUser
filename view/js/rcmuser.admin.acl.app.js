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

    $scope.roles = {"guest":{"role":{"roleId":"guest","description":null,"parentRoleId":null},"rules":[]},"user":{"role":{"roleId":"user","description":null,"parentRoleId":"guest"},"rules":[]},"manager":{"role":{"roleId":"manager","description":null,"parentRoleId":"user"},"rules":[{"rule":"allow","roleid":"manager","resource":"rcmuser-acl-administration","privilege":""}]},"admin":{"role":{"roleId":"admin","description":null,"parentRoleId":"manager"},"rules":[{"rule":"allow","roleid":"admin","resource":"root","privilege":""}]},"customer":{"role":{"roleId":"customer","description":"RCM","parentRoleId":"user"},"rules":[]}};

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

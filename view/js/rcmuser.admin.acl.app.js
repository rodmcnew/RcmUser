'use strict';

var rcmuserAdminAclApp = angular.module('rcmuserAdminAclApp', ['ui.bootstrap']);
rcmuserAdminAclApp.controller('RolesCtrl',
        ['$scope', function ($scope) {

            $scope.greeting = 'Hola!';

            $scope.levelRepeat = function (s, n) {
                var a = [];
                while (a.length < n) {
                    a.push(s);
                }
                return a.join('');
            }

            $scope.roles = {'wer':'wer'};
        }]
    );

var AccordionCtrl = function ($scope) {
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
};

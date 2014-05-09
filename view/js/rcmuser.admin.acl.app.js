angular.module('rcmuser.admin.acl.app', ['ui.bootstrap'])

    .controller('rcmuserAdminAclAppController',
        ['$scope', function ($scope) {

            $scope.greeting = 'Hola!';

            $scope.levelRepeat = function (s, n) {
                var a = [];
                while (a.length < n) {
                    a.push(s);
                }
                return a.join('');
            }

            $scope.roles = null;
        }]
    );

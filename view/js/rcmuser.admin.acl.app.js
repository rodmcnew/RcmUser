var rcmuserAdminAclApp = angular.module('rcmuser.admin.acl.app', ['ui.bootstrap']);

rcmuserAdminAclApp.controller('GreetingController', ['$scope', function($scope) {
    $scope.greeting = 'Hola!';
}]);

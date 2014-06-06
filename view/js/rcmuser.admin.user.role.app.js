// rcmuserCore include <?php echo "\n"; include(__DIR__ . '/rcmuser.core.js'); ?>

angular.module('rcmuserAdminUserRoleApp', ['ui.bootstrap', 'rcmuserCore'])

    .controller('rcmuserAdminUserRole', ['$scope', '$modal', 'rcmUserHttp', 'RcmUserResult', 'RcmResults',
        function ($scope, $modal, rcmUserHttp, RcmUserResult, RcmResults) {
            var self = this;
            self.url = {
                user: "<?php echo $this->url('RcmUserAdminApiUser', array()); ?>",
                roles: "<?php echo $this->url('RcmUserAdminApiAclRulesByRoles', array()); ?>"
            }

            self.rcmUserHttp = rcmUserHttp;

            $scope.alerts = new RcmResults()

            $scope.loading = false;

            eval('var user = <?php echo json_encode(userResult.getData()); ?>');

            $scope.user = user;

            $scope.oneAtATime = false;
        }
    ]);

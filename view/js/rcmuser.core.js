'use strict';

angular.module('rcmuserCore', [])

    .factory('rcmUserHttp', ['$http', 'RcmUserResult', function ($http, RcmUserResult) {

        var RcmUserHttp = function () {

            var self = this;
            self.http = $http;
            self.comErrorMessage = 'There was an error talking to the server: ';

            self.execute = function (config, onSuccess, onFail) {

                //console.log(config);

                self.http(config)
                    .success(function (data, status, headers, config) {

                        // if is result object
                        if (typeof(data.code) !== 'undefined' && typeof(data.messages) !== 'undefined') {

                            if (data.code < 1) {

                                if (typeof(onFail) === 'function') {

                                    onFail(data);
                                }

                                return;
                            }
                        }

                        if ((typeof(onSuccess) === 'function')) {

                            onSuccess(data, config);
                        }
                    })
                    .error(function (data, status, headers, config) {

                        if (typeof(onFail) === 'function') {

                            onFail(new RcmUserResult(0, [self.comErrorMessage + status], data));
                        }
                    });
            }

        }

        return new RcmUserHttp();

    }])
    .factory('RcmUserResult', function () {

        var RcmUserResult = function (code, messages, data) {

            var self = this;

            self.code = code;
            self.messages = messages;
            self.data = data;
        }

        return RcmUserResult;

    })
    .factory('RcmResults', function () {

        var RcmResults = function () {

            var self = this;

            self.results = [];

            self.add = function (result) {

                self.results.push(result);
            };

            self.remove = function (index) {

                self.results.splice(index, 1);
            };

            self.clear = function () {

                self.results = [];
            }
        }

        return RcmResults;
    })
    .factory('getNamespaceRepeatString', function () {

        return function(namespace, repeatStr, namspaceDelimiter) {
            if(!namspaceDelimiter){
                namspaceDelimiter = ".";
            }

            var n = (namespace.split(namspaceDelimiter).length - 1);
            var a = [];
            while (a.length < n) {
                a.push(repeatStr);
            }
            return a.join('');
        }
    })
    .directive('rcmAlerts', function () {
        /*
         * Example:
         * <div rcm-alerts rcm-results="alerts" alert-title="'An error occured:'"></div>
         */

        var thislink = function (scope, element, attrs) {

            scope.closeAlert = function (index) {
                scope.rcmResults.clear();
            };

            scope.type = {
                0: 'warning',
                1: 'info'
            }
        }

        return {
            link: thislink,
            restrict: 'A',
            scope: {
                'rcmResults': '=',
                'alertTitle': '='
            },
            template: '' +
                '<alert class="alert alert-{{type[alert.code]}}" ng-repeat="alert in rcmResults.results" type="" close="closeAlert($index)">' +
                '    <div class="alert-header">' +
                '        <i class="glyphicon glyphicon-{{type[alert.code]}}-sign"></i>' +
                '        <span class="alert-title"><strong>{{alertTitle}}</strong></span>' +
                '    </div>' +
                '    <div class="alert-messages">' +
                '        <ul>' +
                '            <li ng-repeat="msg in alert.messages">{{msg}}</li>' +
                '        </ul>' +
                '    </div>' +
                '</alert>'
        };


    });
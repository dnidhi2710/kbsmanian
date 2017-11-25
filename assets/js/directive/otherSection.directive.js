app.directive('otherSection', function () {
    return {
        restrict: 'E',
        transclude: true,
        scope: {
            type: '@',
            updateType: '=',
            importJobId: '=',
            othersObj: '='
        },
        controller: ['$scope', 'commonService', 'usSpinnerService', '$filter', '$http', 'dbConfigService', function otherController($scope, commonService, spinner, $filter, http, dbConfigService) {

            $scope.others = {};
            $scope.feedback = {};
            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[2];
            init();

            function init() {
                spinner.spin('spinner-1');
                //  var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'feedback/feedback_service.php';
                if ($scope.updateType === "create") {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    spinner.stop('spinner-1');
                } else {
                    $scope.createFlag = false;
                    $scope.updateFlag = true;
                    var obj = {
                        module: "importsea",
                        action: "view_feedback_section",
                        id: $scope.importJobId,
                        type: "sea"
                    };
                    if (angular.isDefined($scope.type) && $scope.type !== null) {
                        if ($scope.type === "importAir") {
                            obj.type = "air";
                        } else if ($scope.type === "importSea") {
                            obj.type = "sea";
                        }
                    }
                    http.post(url, obj).then(function (response) {
                        if (angular.isDefined(response.data) && response.data.result === true) {
                            $scope.otherData = response.data.data;
                            mapFieldsWithgetObj($scope.otherData);
                            spinner.stop('spinner-1');
                        } else {
                            // $scope.errorMsg = response.data.msg;
                            $scope.createFlag = true;
                            $scope.updateFlag = false;
                            // $(showOtherError).modal("show");
                            spinner.stop('spinner-1');
                        }
                    });
                }
            }

            function mapFieldsWithgetObj(otherObj) {
                if (angular.isDefined(otherObj.feedback) && angular.isArray(otherObj.feedback) && angular.isDefined(otherObj.feedback)) {
                    var obj = otherObj.feedback[0];
                }
                if (angular.isDefined(obj.yardName) && obj.yardName !== null) {
                    $scope.feedback.yardName = obj.yardName;
                }
                if (angular.isDefined(obj.yardAddress) && obj.yardAddress !== null) {
                    $scope.feedback.yardAddress = obj.yardAddress;
                }
                if (angular.isDefined(obj.containerType) && obj.containerType !== null) {
                    $scope.feedback.cntrtype = obj.containerType;
                }
                if (angular.isDefined(obj.noOfContainer) && obj.noOfContainer !== null) {
                    $scope.feedback.noOfContainer = obj.noOfContainer;
                }
                if (angular.isDefined(obj.emptyPlot) && obj.emptyPlot !== null) {
                    $scope.feedback.emptyPlot = obj.emptyPlot;
                }
                if (angular.isDefined(obj.offLoadDate) && obj.offLoadDate !== null) {
                    $scope.feedback.loadDate = new Date(obj.offLoadDate);
                }
                if (angular.isDefined(obj.containerDamage) && obj.containerDamage !== null) {
                    $scope.feedback.damage = obj.containerDamage;
                }
                if (angular.isDefined(obj.stAgentStatus) && obj.stAgentStatus !== null) {
                    $scope.feedback.status = obj.stAgentStatus;
                }
                if (angular.isDefined(obj.billingStatus) && obj.billingStatus !== null) {
                    $scope.feedback.submitForBilling = obj.billingStatus;
                }
            }


            function setFeedbackFields(obj, action) {
                obj.module = $scope.type;
                obj.action = action;
                if (angular.isDefined($scope.importJobId) && $scope.importJobId !== null) {
                    obj.impJobId = $scope.importJobId;
                }
                if (angular.isDefined($scope.type) && $scope.type !== null) {
                    if ($scope.type === "importAir") {
                        obj.type = "air";
                    } else if ($scope.type === "importSea") {
                        obj.type = "sea";
                    }
                }
                if (angular.isDefined($scope.feedback.yardName) && $scope.feedback.yardName !== null) {
                    obj.yardName = $scope.feedback.yardName;
                }
                if (angular.isDefined($scope.feedback.yardAddress) && $scope.feedback.yardAddress !== null) {
                    obj.yardAddress = $scope.feedback.yardAddress;
                }
                if (angular.isDefined($scope.feedback.cntrtype) && $scope.feedback.cntrtype !== null) {
                    obj.containerType = $scope.feedback.cntrtype;
                }
                if (angular.isDefined($scope.feedback.noOfContainer) && $scope.feedback.noOfContainer !== null) {
                    obj.noOfContainer = $scope.feedback.noOfContainer;
                }
                if (angular.isDefined($scope.feedback.emptyPlot) && $scope.feedback.emptyPlot !== null) {
                    obj.emptyPlot = $scope.feedback.emptyPlot;
                }
                if (angular.isDefined($scope.feedback.loadDate) && $scope.feedback.loadDate !== null) {
                    obj.offLoadDate = $filter('date')($scope.feedback.loadDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.feedback.damage) && $scope.feedback.damage !== null) {
                    obj.containerDamage = $scope.feedback.damage;
                }
                if (angular.isDefined($scope.feedback.status) && $scope.feedback.status !== null) {
                    obj.stAgentStatus = $scope.feedback.status;
                }
                if (angular.isDefined($scope.feedback.submitForBilling) && $scope.feedback.submitForBilling !== null) {
                    obj.billingStatus = $scope.feedback.submitForBilling;
                }
                return obj;
            }

            function clearOthersObj() {
            }

            /**this method saves others object for the given importJob id */
            $scope.saveOthers = function () {
                $scope.alertMsg = "";
                $scope.successMsg = "";
                $scope.errorMsg = "";
                //var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'feedback/feedback_service.php';
                var obj = commonService.getFeedbackObj();
                if ($scope.createFlag) {
                    obj = setFeedbackFields(obj, "create_feedback_section");
                    $scope.actionMsg = "created";
                } else {
                    obj = setFeedbackFields(obj, "update_feedback_section");
                    $scope.actionMsg = "updated";
                }
                var validate = commonService.saveValidations(obj);
                if (validate.flag === true) {
                    http.post(url, obj).then(function (data) {
                        if (angular.isDefined(data.data) && data.data.infocode === "CREATEFEEDBACKSSUCCESS" && $scope.createFlag) {
                            $scope.successMsg = "Doc Fields " + $scope.action + " Successfully for " + $scope.importJobId + " !";
                              if ($scope.createFlag) {
                                $scope.updateFlag = true;
                                $scope.createFlag = false;
                            }
                            // $scope.successMsg = data.data.message;
                            // $scope.doc.importJobNo = data.data.doc_id + configSevice.getJobid();
                            $(showOtherSuccess).modal("show");
                        } else if (angular.isDefined(data.data) && data.data.infocode === "UPDATEFEEDBACKSSUCCESS" && !$scope.createFlag) {
                            $scope.successMsg = "Customs Section " + $scope.actionMsg + " Successfully for " + $scope.importJobId + "!";
                            $(showOtherSuccess).modal("show");
                        } else {
                            $scope.errorMsg = data.data.msg;
                            $(showOtherError).modal("show");
                        }
                    }, function (error) {
                        $scope.error = error;
                    });
                } else {
                    $scope.alertMsg = validate.msg;
                    $(showOtherAlert).modal("show");
                }
            };

        }],
        templateUrl: './assets/templates/directive/others.html'
    };
})
app.directive('surveySection', function () {
    return {
        restrict: 'E',
        transclude: true,
        scope: {
            type: '@',
            updateType: '=',
            importJobId: '=',
            surveyObj: '='
        },
        controller: ['$scope', 'commonService', 'usSpinnerService', '$filter', '$http', 'dbConfigService', function surveyController($scope, commonService, spinner, $filter, http, dbConfigService) {

            $scope.sample = {};
            $scope.survey = {};
            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[2];
           
            init();

            function init() {
                spinner.spin('spinner-1');
                // var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'operation/operation_service.php';
                if ($scope.updateType === "create") {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    spinner.stop('spinner-1');
                } else {
                    $scope.createFlag = false;
                    $scope.updateFlag = true;
                    var obj = {
                        module: "importsea",
                        action: "view_operation_section",
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
                        if (angular.isDefined(response.data) && response.data.status === 'success') {
                            $scope.operationsData = response.data.data;
                            mapSamplFieldsWithgetObj($scope.operationsData);
                            mapSurveyFieldsWithgetObj($scope.operationsData);
                            spinner.stop('spinner-1');
                        } else {
                          //  $scope.errorMsg = response.data.msg;
                          //  if ($scope.errorMsg === "Survey detail is not available") {
                                $scope.createFlag = true;
                                $scope.updateFlag = false;
                          //  }
                            //  $(showSurveyError).modal("show");
                            spinner.stop('spinner-1');
                        }
                    });
                }
            }

            function mapSamplFieldsWithgetObj(sampleObj) {
                if (angular.isDefined(sampleObj.sample) && sampleObj.sample.length > 0) {
                    var obj = sampleObj.sample[0];
                }
                if (angular.isDefined(obj.iOrAFilledOn) && obj.iOrAFilledOn !== null) {
                    $scope.sample.IAFieldon = obj.iOrAFilledOn;
                }
                if (angular.isDefined(obj.iOrAFiledNo) && obj.iOrAFiledNo !== null) {
                    $scope.sample.IAFieldNo = obj.iOrAFiledNo;
                }
                if (angular.isDefined(obj.iOrAFiledDate) && obj.iOrAFiledDate !== null) {
                    $scope.sample.IADate = new Date(obj.iOrAFiledDate);// $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.iOrAFiledAmount) && obj.iOrAFiledAmount !== null) {
                    $scope.sample.amount = obj.iOrAFiledAmount;
                }
                if (angular.isDefined(obj.iOrAComparedOn) && obj.iOrAComparedOn !== null) {
                    $scope.sample.comparedOn = new Date(obj.iOrAComparedOn);//$filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.samplesCalledOn) && obj.samplesCalledOn !== null) {
                    $scope.sample.calledOn = new Date(obj.samplesCalledOn);//$filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.dockClerkInstrn) && obj.dockClerkInstrn !== null) {
                    $scope.sample.dockClerk = obj.dockClerkInstrn;
                }
                if (angular.isDefined(obj.calledInitial) && obj.calledInitial !== null) {
                    $scope.sample.initial = obj.calledInitial;
                }
                if (angular.isDefined(obj.drawnOn) && obj.drawnOn !== null) {
                    $scope.sample.drawnOn = new Date(obj.drawnOn);// $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.calledDelayReason) && obj.calledDelayReason !== null) {
                    $scope.sample.delayReason = obj.calledDelayReason;
                }
                if (angular.isDefined(obj.submittedToCustoms) && obj.submittedToCustoms !== null) {
                    $scope.sample.SubmittedCustoms = obj.submittedToCustoms;
                }
                if (angular.isDefined(obj.customsDelayReason) && obj.customsDelayReason !== null) {
                    $scope.sample.customsDelay = obj.customsDelayReason;
                }
                if (angular.isDefined(obj.bOrEReceivedOn) && obj.bOrEReceivedOn !== null) {
                    $scope.sample.BEparcel = new Date(obj.bOrEReceivedOn);// $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.bOrEReceivedTime) && obj.bOrEReceivedTime !== null) {
                    $scope.sample.Time = obj.bOrEReceivedTime;
                }
                if (angular.isDefined(obj.bOrERecdInitial) && obj.bOrERecdInitial !== null) {
                    $scope.sample.BEInitial = obj.bOrERecdInitial;
                }
                if (angular.isDefined(obj.origOpenOrderGIvenOn) && obj.origOpenOrderGIvenOn !== null) {
                    $scope.sample.originalOpenOrder = new Date(obj.origOpenOrderGIvenOn);//$filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.origOpenOrderCmptdOn) && obj.origOpenOrderCmptdOn !== null) {
                    $scope.sample.completedOn = new Date(obj.origOpenOrderCmptdOn);// $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.origOpenOrderDelayReason) && obj.origOpenOrderDelayReason !== null) {
                    $scope.sample.orgDelay = obj.origOpenOrderDelayReason;
                }
                if (angular.isDefined(obj.dupeOpenOrderGIvenOn) && obj.dupeOpenOrderGIvenOn !== null) {
                    $scope.sample.duplicateNo = new Date(obj.dupeOpenOrderGIvenOn);// $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.dupeOpenOrderCmptdOn) && obj.dupeOpenOrderCmptdOn !== null) {
                    $scope.sample.duplicateCompletedon = new Date(obj.dupeOpenOrderCmptdOn);//$filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.dupeOpenOrderDelayReason) && obj.dupeOpenOrderDelayReason !== null) {
                    $scope.sample.dupeDelay = obj.dupeOpenOrderDelayReason;
                }
                if (angular.isDefined(obj.customsChargeon) && obj.customsChargeon !== null) {
                    $scope.sample.customsChargeon = new Date(obj.customsChargeon);// $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.goodsClearedno) && obj.goodsClearedno !== null) {
                    $scope.sample.GoodsClearedOn = new Date(obj.goodsClearedno);// $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.goodClearedDelay) && obj.goodClearedDelay !== null) {
                    $scope.sample.goodsDelay = obj.goodClearedDelay;
                }
                if (angular.isDefined(obj.remarks) && obj.remarks !== null) {
                    $scope.sample.remarks = obj.remarks;
                }
            }

            function mapSurveyFieldsWithgetObj(obj) {
                if (angular.isDefined(obj.survey) && obj.survey.length > 0) {
                    var obj = obj.survey[0];
                }
                if (angular.isDefined(obj.sOrAAppliedOn) && obj.sOrAAppliedOn !== null) {
                    $scope.sample.appliedONSA = new Date(obj.sOrAAppliedOn);
                }
                if (angular.isDefined(obj.sOrAGrantedOn) && obj.sOrAGrantedOn !== null) {
                    $scope.sample.grantedonSa = new Date(obj.sOrAGrantedOn);
                }
                if (angular.isDefined(obj.sOrAHeldOn) && obj.sOrAHeldOn !== null) {
                    $scope.sample.heldonSa = new Date(obj.sOrAHeldOn);
                }
                if (angular.isDefined(obj.insAppliedOn) && obj.insAppliedOn !== null) {
                    $scope.sample.appliedonIns = new Date(obj.insAppliedOn);
                }
                if (angular.isDefined(obj.insGrantedOn) && obj.insGrantedOn !== null) {
                    $scope.sample.grantedonIns = new Date(obj.insGrantedOn);
                }
                if (angular.isDefined(obj.insHeldOn) && obj.insHeldOn !== null) {
                    $scope.sample.heldonIns = new Date(obj.insHeldOn);
                }
                if (angular.isDefined(obj.pTAppliedOn) && obj.pTAppliedOn !== null) {
                    $scope.sample.appliedonPt = new Date(obj.pTAppliedOn);
                }
                if (angular.isDefined(obj.pTAGrantedOn) && obj.pTAGrantedOn !== null) {
                    $scope.sample.grantedonPT = new Date(obj.pTAGrantedOn);
                }
                if (angular.isDefined(obj.pTHeldOn) && obj.pTHeldOn !== null) {
                    $scope.sample.heldonPT = new Date(obj.pTHeldOn);
                }
            }

            function setOperationsFields(obj, action) {
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
                if (angular.isDefined($scope.sample.IAFieldon) && $scope.sample.IAFieldon !== null) {
                    obj.iOrAFilledOn = $scope.sample.IAFieldon;
                }
                if (angular.isDefined($scope.sample.IAFieldNo) && $scope.sample.IAFieldNo !== null) {
                    obj.iOrAFiledNo = $scope.sample.IAFieldNo;
                }
                if (angular.isDefined($scope.sample.IADate) && $scope.sample.IADate !== null) {
                    obj.iOrAFiledDate = $filter('date')($scope.sample.IADate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.amount) && $scope.sample.amount !== null) {
                    obj.iOrAFiledAmount = $scope.sample.amount;
                }
                if (angular.isDefined($scope.sample.comparedOn) && $scope.sample.comparedOn !== null) {
                    obj.iOrAComparedOn = $filter('date')($scope.sample.comparedOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.calledOn) && $scope.sample.calledOn !== null) {
                    obj.samplesCalledOn = $filter('date')($scope.sample.calledOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.dockClerk) && $scope.sample.dockClerk !== null) {
                    obj.dockClerkInstrn = $scope.sample.dockClerk;
                }
                if (angular.isDefined($scope.sample.initial) && $scope.sample.initial !== null) {
                    obj.calledInitial = $scope.sample.initial;
                }
                if (angular.isDefined($scope.sample.drawnOn) && $scope.sample.drawnOn !== null) {
                    obj.drawnOn = $filter('date')($scope.sample.drawnOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.delayReason) && $scope.sample.delayReason !== null) {
                    obj.calledDelayReason = $scope.sample.delayReason;
                }
                if (angular.isDefined($scope.sample.SubmittedCustoms) && $scope.sample.SubmittedCustoms !== null) {
                    obj.submittedToCustoms = $scope.sample.SubmittedCustoms;
                }
                if (angular.isDefined($scope.sample.customsDelay) && $scope.sample.customsDelay !== null) {
                    obj.customsDelayReason = $scope.sample.customsDelay;
                }
                if (angular.isDefined($scope.sample.BEparcel) && $scope.sample.BEparcel !== null) {
                    obj.bOrEReceivedOn = $filter('date')($scope.sample.BEparcel, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.Time) && $scope.sample.Time !== null) {
                    obj.bOrEReceivedTime = $scope.sample.Time;
                }
                if (angular.isDefined($scope.sample.BEInitial) && $scope.sample.BEInitial !== null) {
                    obj.bOrERecdInitial = $scope.sample.BEInitial;
                }
                if (angular.isDefined($scope.sample.originalOpenOrder) && $scope.sample.originalOpenOrder !== null) {
                    obj.origOpenOrderGIvenOn = $filter('date')($scope.sample.originalOpenOrder, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.completedOn) && $scope.sample.completedOn !== null) {
                    obj.origOpenOrderCmptdOn = $filter('date')($scope.sample.completedOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.orgDelay) && $scope.sample.orgDelay !== null) {
                    obj.origOpenOrderDelayReason = $scope.sample.orgDelay;
                }
                if (angular.isDefined($scope.sample.duplicateNo) && $scope.sample.duplicateNo !== null) {
                    obj.dupeOpenOrderGIvenOn = $filter('date')($scope.sample.duplicateNo, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.duplicateCompletedon) && $scope.sample.duplicateCompletedon !== null) {
                    obj.dupeOpenOrderCmptdOn = $filter('date')($scope.sample.duplicateCompletedon, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.dupeDelay) && $scope.sample.dupeDelay !== null) {
                    obj.dupeOpenOrderDelayReason = $scope.sample.dupeDelay;
                }
                if (angular.isDefined($scope.sample.customsChargeon) && $scope.sample.customsChargeon !== null) {
                    obj.customsChargeon = $filter('date')($scope.sample.customsChargeon, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.GoodsClearedOn) && $scope.sample.GoodsClearedOn !== null) {
                    obj.goodsClearedno = $filter('date')($scope.sample.GoodsClearedOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.goodsDelay) && $scope.sample.goodsDelay !== null) {
                    obj.goodClearedDelay = $scope.sample.goodsDelay;
                }
                if (angular.isDefined($scope.sample.remarks) && $scope.sample.remarks !== null) {
                    obj.remarks = $scope.sample.remarks;
                }
                if (angular.isDefined($scope.sample.appliedONSA) && $scope.sample.appliedONSA !== null) {
                    obj.sOrAAppliedOn = $filter('date')($scope.sample.appliedONSA, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.grantedonSa) && $scope.sample.grantedonSa !== null) {
                    obj.sOrAGrantedOn = $filter('date')($scope.sample.grantedonSa, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.heldonSa) && $scope.sample.heldonSa !== null) {
                    obj.sOrAHeldOn = $filter('date')($scope.sample.heldonSa, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.appliedonIns) && $scope.sample.appliedonIns !== null) {
                    obj.insAppliedOn = $filter('date')($scope.sample.appliedonIns, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.grantedonIns) && $scope.sample.grantedonIns !== null) {
                    obj.insGrantedOn = $filter('date')($scope.sample.grantedonIns, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.heldonIns) && $scope.sample.heldonIns !== null) {
                    obj.insHeldOn = $filter('date')($scope.sample.heldonIns, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.appliedonPt) && $scope.sample.appliedonPt !== null) {
                    obj.pTAppliedOn = $filter('date')($scope.sample.appliedonPt, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.grantedonPT) && $scope.sample.grantedonPT !== null) {
                    obj.pTAGrantedOn = $filter('date')($scope.sample.grantedonPT, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.sample.heldonPT) && $scope.sample.heldonPT !== null) {
                    obj.pTHeldOn = $filter('date')($scope.sample.heldonPT, "yyyy-MM-dd");
                }
                return obj;
            }

            function clearSurveyObj() {
                $scope.survey.appliedONSA = "";
                $scope.survey.grantedonSa = "";
                $scope.survey.heldonSa = "";
                $scope.survey.appliedonIns = "";
                $scope.survey.grantedonIns = "";
                $scope.survey.heldonIns = "";
                $scope.survey.appliedonPt = "";
                $scope.survey.grantedonPT = "";
                $scope.survey.heldonPT = "";
                $scope.survey.indentedon = "";
                $scope.survey.indentedTime = "";
                $scope.survey.suppliedon = "";
                $scope.survey.suppliedTime = "";
                $scope.survey.supplyDelay = "";
                $scope.survey.surveyRemarks = "";
            }
            /**this method saves survey object for the given importJob id */
            $scope.saveSurvey = function () {
                $scope.alertMsg = "";
                $scope.successMsg = "";
                $scope.errorMsg = "";
                // var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'operation/operation_service.php';

                var obj = commonService.getOperationsObj();
                if ($scope.createFlag) {
                    obj = setOperationsFields(obj, "create_operation_section");
                    $scope.actionMsg = "created";
                } else {
                    obj = setOperationsFields(obj, "update_operation_section");
                    $scope.actionMsg = "updated";
                }
                var validate = commonService.saveValidations(obj);
                if (validate.flag === true) {
                    http.post(url, obj).then(function (data) {
                        if (angular.isDefined(data.data) && data.data.infocode === "CREATEOPERATIONSUCCESS" && $scope.createFlag) {
                            $scope.successMsg = "Operations Fields "+$scope.action+" Successfully for " + $scope.importJobId + " !";
                            if ($scope.createFlag) {
                                $scope.updateFlag = true;
                                $scope.createFlag = false;
                            }
                           // $scope.successMsg = data.data.message;
                            // $scope.doc.importJobNo = data.data.doc_id + configSevice.getJobid();
                            $(showSurveySuccess).modal("show");
                        } else if (angular.isDefined(data.data) && data.data.infocode === "UPDATEOPERATIONSUCCESS" && !$scope.createFlag) {
                            $scope.successMsg = "Operations " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
                            $(showSurveySuccess).modal("show");
                        } else {
                            $scope.errorMsg = data.data.msg;
                            $(showSurveyError).modal("show");
                        }
                    }, function (error) {
                        $scope.error = error;
                    });
                } else {
                    $scope.alertMsg = validate.msg;
                    $(showSurveyAlert).modal("show");
                }
            };

        }],
        templateUrl: './assets/templates/directive/survey.html'
    };
})
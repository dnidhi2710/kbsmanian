app.directive('personnelSection', function () {
    return {
        restrict: 'E',
        transclude: true,
        scope: {
            type: '@',
            updateType: '=',
            importJobId: '=',
            personnelObj: '='
        },
        controller: ['$scope', 'commonService', 'usSpinnerService', '$filter', '$http', 'dbConfigService', function personnelController($scope, commonService, spinner, $filter, http, dbConfigService) {

            $scope.transport = {};
            $scope.transport = {
                clrparticulars: []
            };
            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[2];
            init();

            function init() {
                spinner.spin('spinner-1');
                // var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'transport/transport_service.php';
                if ($scope.updateType === "create") {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    spinner.stop('spinner-1');
                } else {
                    $scope.createFlag = false;
                    $scope.updateFlag = true;
                    var obj = {
                        module: "importsea",
                        action: "view_transport_section",
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
                            $scope.PersonnelData = response.data.data;
                            mapFieldsWithgetObj($scope.PersonnelData);
                            spinner.stop('spinner-1');
                        } else {
                            $scope.createFlag = true;
                            $scope.updateFlag = false;
                            //  $(showPersonnelError).modal("show");
                            spinner.stop('spinner-1');
                        }
                    });
                }
            }
            $scope.addClearanceObj = function () {
                var ContainerObj = {
                    "packages": "",
                    "date": "",
                    "cd": ""
                };
                $scope.transport.clrparticulars.push(ContainerObj);
            };

            $scope.delClearanceObj = function () {
                $scope.transport.clrparticulars.pop();
            };
            function mapFieldsWithgetObj(personnelObj) {
                if (angular.isDefined(personnelObj.transport) && angular.isArray(personnelObj.transport) && angular.isDefined(personnelObj.transport)) {
                    var obj = personnelObj.transport[0];
                }
                if (angular.isDefined(obj.gcNoteNo) && obj.gcNoteNo !== null) {
                    $scope.transport.ourGCNote = obj.gcNoteNo;
                }
                if (angular.isDefined(obj.transportedGCNote) && obj.transportedGCNote !== null) {
                    $scope.transport.transGCNote = obj.transportedGCNote;
                }

                $scope.transport.clrparticulars = JSON.parse(obj.clearanceParticulars);
                $scope.transport.clrparticulars = mapDateFields($scope.transport.clrparticulars);
                if (angular.isDefined(obj.transIndentedOn) && obj.transIndentedOn !== null) {
                    $scope.transport.indentedon = new Date(obj.transIndentedOn);
                }
                if (angular.isDefined(obj.transIndentedTime) && obj.transIndentedTime !== null) {
                    $scope.transport.indentedTime = obj.transIndentedTime
                }
                if (angular.isDefined(obj.transSuppliedOn) && obj.transSuppliedOn !== null) {
                    $scope.transport.suppliedon = new Date(obj.transSuppliedOn);
                }
                if (angular.isDefined(obj.transSuppliedTime) && obj.transSuppliedTime !== null) {
                    $scope.transport.suppliedTime = obj.transSuppliedTime;
                }
                if (angular.isDefined(obj.transDelayReason) && obj.transDelayReason !== null) {
                    $scope.transport.supplyDelay = obj.transDelayReason;
                }
                if (angular.isDefined(obj.remarks) && obj.remarks !== null) {
                    $scope.transport.surveyRemarks = obj.remarks;
                }

            }

            function mapDateFields(obj) {
                for (var i = 0; i < obj.length; i++) {
                    obj[i].date = new Date(obj[i].date);
                }
                return obj;
            }
            function setTransportFields(obj, action) {

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
                if (angular.isDefined($scope.transport.ourGCNote) && $scope.transport.ourGCNote !== null) {
                    obj.gcNoteNo = $scope.transport.ourGCNote;
                }
                if (angular.isDefined($scope.transport.transGCNote) && $scope.transport.transGCNote !== null) {
                    obj.transportedGCNote = $scope.transport.transGCNote;
                }
                obj.clearanceParticulars = JSON.stringify($scope.transport.clrparticulars);
                if (angular.isDefined($scope.transport.indentedon) && $scope.transport.indentedon !== null) {
                    obj.transIndentedOn = $filter('date')($scope.transport.indentedon, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.transport.indentedTime) && $scope.transport.indentedTime !== null) {
                    obj.transIndentedTime = $scope.transport.indentedTime;
                }
                if (angular.isDefined($scope.transport.suppliedon) && $scope.transport.suppliedon !== null) {
                    obj.transSuppliedOn = $filter('date')($scope.transport.suppliedon, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.transport.suppliedTime) && $scope.transport.suppliedTime !== null) {
                    obj.transSuppliedTime = $scope.transport.suppliedTime;
                }
                if (angular.isDefined($scope.transport.supplyDelay) && $scope.transport.supplyDelay !== null) {
                    obj.transDelayReason = $scope.transport.supplyDelay;
                }
                if (angular.isDefined($scope.transport.surveyRemarks) && $scope.transport.surveyRemarks !== null) {
                    obj.remarks = $scope.transport.surveyRemarks;
                }

                return obj;
            }

            function clearPersonelObj() {
                $scope.personnel.customClerk = "";
                $scope.personnel.jobAllotedon = "";
                $scope.personnel.documentRecord = "";
                $scope.personnel.docRecDate = "";
                $scope.personnel.docCalled = "";
                $scope.personnel.docCalledDate = "";
                $scope.personnel.rem = "";
                $scope.personnel.recrd = "";
                $scope.personnel.recrdtxtarea = "";
                $scope.personnel.fieldOnManifest = "";
                $scope.personnel.GMNO = "";
                $scope.personnel.lineNO = "";
                $scope.personnel.lineNoDate = "";
                $scope.personnel.manifestedOn = "";
                $scope.personnel.manifestNo = "";
                $scope.personnel.manifestedonDate = "";
                $scope.personnel.appraisingDptOn = "";
                $scope.personnel.appraisingNo = "";
                $scope.personnel.appraisingDate = "";
                $scope.personnel.appraiseFor = "";
                $scope.personnel.BEAppraiser = "";
                $scope.personnel.BEreturnedon = "";
                $scope.personnel.BEputUPfor = "";
                $scope.personnel.appraiserOn2 = "";
                $scope.personnel.BEreturnedon2 = "";
                $scope.personnel.BEputUPfor2 = "";
                $scope.personnel.appraiserOn3 = "";
                $scope.personnel.BEputUPfor3 = "";
                $scope.personnel.calledOnsamples = "";
                $scope.personnel.docClerkInstrOn = "";
                $scope.personnel.drawnOn = "";
                $scope.personnel.drawnReasonDelay = "";
                $scope.personnel.orderSentTogrp = "";
                $scope.personnel.testReportRecdNo = "";
                $scope.personnel.samplesCollOn = "";
                $scope.personnel.givenTo = "";
                $scope.personnel.givenOn = "";
                $scope.personnel.givenTime = "";
                $scope.personnel.testCustomsDelay = "";
                $scope.personnel.customsDelayto = "";
                $scope.personnel.customsReason = "";
            }

            /**this method saves personnel object for the given importJob id */
            $scope.savePersonnel = function () {
                $scope.alertMsg = "";
                $scope.successMsg = "";
                $scope.errorMsg = "";
                // var url = "http://localhost:8888/kbs/php/application.php";

                var url = dbConfigService.getUrl() + 'transport/transport_service.php';
                var obj = commonService.getTransportObj();
                if ($scope.createFlag) {
                    obj = setTransportFields(obj, "create_transport_section");
                    $scope.actionMsg = "created";
                } else {
                    obj = setTransportFields(obj, "update_transport_section");
                    $scope.actionMsg = "updated";
                }
                var validate = commonService.saveValidations(obj);
                if (validate.flag === true) {
                    http.post(url, obj).then(function (data) {
                        if (angular.isDefined(data.data) && data.data.infocode === "CREATETRANSPORTSUCCESS" && $scope.createFlag) {
                            $scope.successMsg = "Transport " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
                            $(showPersonnelSuccess).modal("show");
                            if ($scope.createFlag) {
                                $scope.updateFlag = true;
                                $scope.createFlag = false;
                            }
                        } else if (angular.isDefined(data.data) && data.data.infocode === "UPDATETRANSPORTSUCCESS" && !$scope.createFlag) {
                            $scope.successMsg = "Transport " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
                            $(showPersonnelSuccess).modal("show");
                        } else {
                            $scope.errorMsg = data.data.msg;
                            $(showPersonnelError).modal("show");
                        }
                    }, function (error) {
                        $scope.error = error;
                    });
                } else {
                    $scope.alertMsg = validate.msg;
                    $(showPersonnelAlert).modal("show");
                }
            };

        }],
        templateUrl: './assets/templates/directive/personnel.html'
    };
})
app.directive('sampleSection', function () {
    return {
        restrict: 'E',
        transclude: true,
        scope: {
            type: '@',
            updateType: '=',
            importJobId: '=',
            sampleObj: '='
        },
        controller: ['$scope', 'commonService', 'usSpinnerService', '$filter', '$http', 'dbConfigService', function sampleController($scope, commonService, spinner, $filter, http, dbConfigService) {

            $scope.sample = {};
            $scope.doc = {};
            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[2];
           
            init();

            function init() {
                spinner.spin('spinner-1');
                //var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'DO_Section/do_service.php';
                if ($scope.updateType === "create") {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    spinner.stop('spinner-1');
                } else {
                    $scope.createFlag = false;
                    $scope.updateFlag = true;
                    var obj = {
                        module: "importsea",
                        action: "view_do_section",
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
                            $scope.sampleData = response.data.data;
                            mapFieldsWithgetObj($scope.sampleData);
                            spinner.stop('spinner-1');
                        } else {
                                $scope.createFlag = true;
                                $scope.updateFlag = false;
                            // $(showSampleError).modal("show");
                            spinner.stop('spinner-1');
                        }
                    });
                }
            }
            function mapInvoiceMode(obj) {
                if (obj.invoiceMode !== null && angular.isDefined(obj.invoiceMode) && obj.invoiceMode !== "") {
                    $scope.doc = JSON.parse(obj.invoiceMode);
                }
            }
            function mapFieldsWithgetObj(obj) {
                obj = obj.doObj[0];
                mapInvoiceMode(obj);

                if (angular.isDefined(obj.customsClerk) && obj.customsClerk !== null) {
                    $scope.doc.customsClerk = obj.customsClerk;
                }
                if (angular.isDefined(obj.dockClerk) && obj.dockClerk !== null) {
                    $scope.doc.dockClerk = obj.dockClerk;
                }
                if (angular.isDefined(obj.tinNO) && obj.tinNO !== null) {
                    $scope.doc.tinNO = obj.tinNO;
                }
                if (angular.isDefined(obj.cstNo) && obj.cstNo !== null) {
                    $scope.doc.cstNo = obj.cstNo;
                }
                if (angular.isDefined(obj.gstNo) && obj.gstNo !== null) {
                    $scope.doc.gstNo = obj.gstNo;
                }
                if (angular.isDefined(obj.stAgentsCharges) && obj.stAgentsCharges !== null) {
                    $scope.doc.stAgentCharges = obj.stAgentsCharges;
                }
                if (angular.isDefined(obj.remarks) && obj.remarks !== null) {
                    $scope.doc.remarks = obj.remarks;
                }
            }
            function setDOFields(obj, action) {
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
                if (angular.isDefined($scope.doc.customsClerk) && $scope.doc.customsClerk !== null) {
                    obj.customsClerk = $scope.doc.customsClerk;
                }
                if (angular.isDefined($scope.doc.dockClerk) && $scope.doc.dockClerk !== null) {
                    obj.dockClerk = $scope.doc.dockClerk;
                }
                if (angular.isDefined($scope.doc.tinNO) && $scope.doc.tinNO !== null) {
                    obj.tinNO = $scope.doc.tinNO;
                }
                if (angular.isDefined($scope.doc.cstNo) && $scope.doc.cstNo !== null) {
                    obj.cstNo = $scope.doc.cstNo;
                }
                if (angular.isDefined($scope.doc.gstNo) && $scope.doc.gstNo !== null) {
                    obj.gstNo = $scope.doc.gstNo;
                }
                if (angular.isDefined($scope.doc.stAgentCharges) && $scope.doc.stAgentCharges !== null) {
                    obj.stAgentsCharges = $scope.doc.stAgentCharges;
                }
                if (angular.isDefined($scope.doc.remarks) && $scope.doc.remarks !== null) {
                    obj.remarks = $scope.doc.remarks;
                }
                obj.invoiceMode = JSON.stringify(setInvoiceMode());
                return obj;
            }

            function setInvoiceMode() {
                var mode = {
                    "CIF": false,
                    "FOB": false,
                    "CI": false,
                    "CF": false
                };
                if (angular.isDefined($scope.doc)) {
                    if ($scope.doc.CIF === true) {
                        mode.CIF = true;
                    }
                    if ($scope.doc.FOB === true) {
                        mode.FOB = true;
                    }
                    if ($scope.doc.CI === true) {
                        mode.CI = true;
                    }
                    if ($scope.doc.CF === true) {
                        mode.CF = true;
                    }
                }
                return mode;
            }

            function clearSampleObj() {
                $scope.sample.IAFieldon = "";
                $scope.sample.IAFieldNo = "";
                $scope.sample.IADate = "";
                $scope.sample.amount = "";
                $scope.sample.calledOn = "";
                $scope.sample.comparedOn = "";
                $scope.sample.dockClerk = "";
                $scope.sample.initial = "";
                $scope.sample.drawnOn = "";
                $scope.sample.delayReason = "";
                $scope.sample.SubmittedCustoms = "";
                $scope.sample.customsDelay = "";
                $scope.sample.BEparcel = "";
                $scope.sample.Time = "";
                $scope.sample.BEInitial = "";
                $scope.sample.originalOpenOrder = "";
                $scope.sample.completedOn = "";
                $scope.sample.orgDelay = "";
                $scope.sample.duplicateNo = "";
                $scope.sample.duplicateCompletedon = "";
                $scope.sample.dupeDelay = "";
                $scope.sample.customsChargeon = "";
                $scope.sample.GoodsClearedOn = "";
                $scope.sample.goodsDelay = "";
                $scope.sample.remarks = "";
            }

            /**this method saves sample object for the given importJob id */
            $scope.saveSamples = function () {
                $scope.alertMsg = "";
                $scope.successMsg = "";
                $scope.errorMsg = "";
                //  var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'DO_Section/do_service.php';
                var obj = commonService.getDoFields();
                if ($scope.createFlag) {
                    obj = setDOFields(obj, "create_do_section");
                    $scope.actionMsg = "created";
                } else {
                    obj = setDOFields(obj, "update_do_section");
                    $scope.actionMsg = "updated";
                }
                var validate = commonService.saveValidations(obj);
                if (validate.flag === true) {
                    http.post(url, obj).then(function (data) {
                        if (angular.isDefined(data.data) && data.data.infocode === "CREATEDOSUCCESS" && $scope.createFlag) {
                            $scope.successMsg = "Samples Fields "+$scope.action+" Successfully for " + $scope.importJobId + " !";
                             if ($scope.createFlag) {
                                $scope.updateFlag = true;
                                $scope.createFlag = false;
                            }
                            //$scope.successMsg = data.data.message;
                            // $scope.doc.importJobNo = data.data.doc_id + configSevice.getJobid();
                            $(showSuccess).modal("show");
                        } else if (angular.isDefined(data.data) && data.data.infocode === "UPDATEDOSUCCESS" && !$scope.createFlag) {
                            $scope.successMsg = "Samples " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
                            $(showSampleSuccess).modal("show");
                        } else {
                            $scope.errorMsg = data.data.msg;
                            $(showSampleError).modal("show");
                        }
                    }, function (error) {
                        $scope.error = error;
                    });
                } else {
                    $scope.alertMsg = validate.msg;
                    $(showSampleAlert).modal("show");
                }
            };


        }],
        templateUrl: './assets/templates/directive/sample.html'
    };
})
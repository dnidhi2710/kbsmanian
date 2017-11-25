app.directive('deliveryReceipt', function () {
    return {
        restrict: 'E',
        transclude: true,
        scope: {
            type: '@',
            updateType: '=',
            importJobId: '=',
            personnelObj: '='
        },
        controller: ['$scope', 'commonService', 'usSpinnerService', '$filter', '$http', 'dbConfigService', '$route', '$window', function personnelController($scope, commonService, spinner, $filter, http, dbConfigService, $route, window) {

            $scope.receipt = {};

            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[2];
            init();

            function init() {
                $scope.receipt.impJobNo = $scope.importJobId;
                // spinner.spin('spinner-1');
                // var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'receipts/receipts.php';
                if ($scope.updateType === "create") {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    spinner.stop('spinner-1');
                } else {
                    $scope.createFlag = false;
                    $scope.updateFlag = true;
                    var obj = {
                        module: "importsea",
                        action: "view_receipts",
                        id: $scope.importJobId,
                        type: "sea"
                    };
                    if (angular.isDefined($scope.type) && $scope.type !== null) {
                        if ($scope.type === "importAir") {
                            obj.type = "importAir";
                        } else if ($scope.type === "importSea") {
                            obj.type = "importSea";
                        } else if ($scope.type === "exportSea") {
                            obj.type = "exportSea";
                        } else if ($scope.type === "exportAir") {
                            obj.type = "exportAir";
                        }
                    }
                    http.post(url, obj).then(function (response) {
                        if (angular.isDefined(response.data) && response.data.result === true) {
                            $scope.getExportData = response.data.data;
                            // mapFieldsWithgetObj($scope.PersonnelData);
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
            $scope.markData = [];

            $scope.print = function () {
                var printContents = angular.getElementById('printReceipt');
                // var printContents = document.getElementById('printReceipt').innerHTML;
                var popupWin = window.open();
                popupWin.document.open();
                popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
                popupWin.document.close();
            };

            $scope.addContainer = function () {
                var i = 0;
                if (angular.isArray($scope.markData)) {
                    i = $scope.markData.length + 1;
                }
                var obj = {
                    "containerNo": i,
                    "mark": "",
                    "noOfPkgs": "",
                    "description": "",
                    "weight": ""
                };
                $scope.markData.push(obj);
            };

            /* Delete the selected record */
            $scope.removeSelectedContainer = function (id) {
                var index = _.findIndex($scope.markData, { containerNo: id });
                if (index !== -1) {
                    if (index === 0 && $scope.markData.length === 1) {
                        $scope.markData = [];
                    } else {
                        $scope.markData.splice(index, 1);
                    }
                }
            };

            function clearReceiptData() {
                $scope.receipt.date = "";
                $scope.receipt.truckNo = "";
                $scope.receipt.driverName = "";
                $scope.receipt.from = "";
                $scope.receipt.to = "";
                $scope.markData = [];
                $scope.receipt.BENo = "";
                $scope.receipt.BEDate = "";
                $scope.receipt.transporterName = "";
                $scope.receipt.importerName = "";
                $scope.receipt.importerGst = "";
                $scope.receipt.address = "";
            }

            $scope.openReceipts = function (data, type) {
                $scope.successMsg = "";
                $scope.errorMsg = "";
                $scope.alertMsg = "";
                if (type === 'create') {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    clearReceiptData();
                } else {
                    $scope.updateFlag = true;
                    $scope.createFlag = false;
                    mapReceiptData(data);
                }
                $(showReceipt).modal("show");
            };

            function mapReceiptData(obj) {
                $scope.updateId = obj.id;
                if (angular.isDefined(obj.date) && obj.date !== null) {
                    $scope.receipt.date = new Date(obj.date);
                }
                if (angular.isDefined(obj.truckNo) && obj.truckNo !== null) {
                    $scope.receipt.truckNo = obj.truckNo;
                }
                if (angular.isDefined(obj.driverName) && obj.driverName !== null) {
                    $scope.receipt.driverName = obj.driverName;
                }
                if (angular.isDefined(obj.from) && obj.from !== null) {
                    $scope.receipt.from = obj.from;
                }
                if (angular.isDefined(obj.to) && obj.to !== null) {
                    $scope.receipt.to = obj.to;
                }
                if (angular.isDefined(obj.Marks) && obj.Marks !== null && obj.Marks!=="") {
                    $scope.markData = JSON.parse(obj.Marks);
                }
                if (angular.isDefined(obj.BENO) && obj.BENO !== null) {
                    $scope.receipt.BENo = obj.BENO;
                }
                if (angular.isDefined(obj.BEDate) && obj.BEDate !== null) {
                    $scope.receipt.BEDate = new Date(obj.BEDate);
                }
                if (angular.isDefined(obj.transporterName) && obj.transporterName !== null) {
                    $scope.receipt.transporterName = obj.transporterName;
                }
                if (angular.isDefined(obj.importerName) && obj.importerName !== null) {
                    $scope.receipt.importerName = obj.importerName;
                }
                if (angular.isDefined(obj.importerGst) && obj.importerGst !== null) {
                    $scope.receipt.importerGst = obj.importerGst;
                }
                if (angular.isDefined(obj.Address) && obj.Address !== null) {
                    $scope.receipt.address = obj.Address;
                }

            }

            // $scope.reload= function(){
            //      $route.reload();
            //  };

            function mapDateFields(obj) {
                for (var i = 0; i < obj.length; i++) {
                    obj[i].date = new Date(obj[i].date);
                }
                return obj;
            }
            function setReceiptFields(obj, action) {
                obj.action = action;
                if (angular.isDefined($scope.importJobId) && $scope.importJobId !== null) {
                    obj.impJobId = $scope.importJobId;
                }
                if (angular.isDefined($scope.type) && $scope.type !== null) {
                    if ($scope.type === "importAir") {
                        obj.type = "importAir";
                    } else if ($scope.type === "importSea") {
                        obj.type = "importSea";
                    } else if ($scope.type === "exportAir") {
                        obj.type = "exportAir";
                    } else if ($scope.type === "exportSea") {
                        obj.type = "exportSea";
                    }
                }
                if (action === 'update_receipts') {
                    obj.id = $scope.updateId;
                }
                if (angular.isDefined($scope.receipt.impJobNo) && $scope.receipt.impJobNo !== null) {
                    obj.impJobNo = $scope.receipt.impJobNo;
                }
                if (angular.isDefined($scope.receipt.date) && $scope.receipt.date !== null) {
                    obj.date = $filter('date')($scope.receipt.date, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.receipt.truckNo) && $scope.receipt.truckNo !== null) {
                    obj.truckNo = $scope.receipt.truckNo;
                }
                if (angular.isDefined($scope.receipt.driverName) && $scope.receipt.driverName !== null) {
                    obj.driverName = $scope.receipt.driverName;
                }
                if (angular.isDefined($scope.receipt.from) && $scope.receipt.from !== null) {
                    obj.from = $scope.receipt.from;
                }
                if (angular.isDefined($scope.receipt.to) && $scope.receipt.to !== null) {
                    obj.to = $scope.receipt.to;
                }
                if (angular.isDefined($scope.markData) && $scope.markData.length > 0) {
                    obj.Marks = JSON.stringify($scope.markData);
                }
                if (angular.isDefined($scope.receipt.BENo) && $scope.receipt.BENo !== null) {
                    obj.BENO = $scope.receipt.BENo;
                }
                if (angular.isDefined($scope.receipt.BEDate) && $scope.receipt.BEDate !== null) {
                    obj.BEDate = $filter('date')($scope.receipt.BEDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.receipt.transporterName) && $scope.receipt.transporterName !== null) {
                    obj.transporterName = $scope.receipt.transporterName;
                }
                if (angular.isDefined($scope.receipt.importerName) && $scope.receipt.importerName !== null) {
                    obj.importerName = $scope.receipt.importerName;
                }
                if (angular.isDefined($scope.receipt.importerGst) && $scope.receipt.importerGst !== null) {
                    obj.importerGst = $scope.receipt.importerGst;
                }
                if (angular.isDefined($scope.receipt.address) && $scope.receipt.address !== null) {
                    obj.Address = $scope.receipt.address;
                }
                if (angular.isDefined($scope.receipt.type) && $scope.receipt.type !== null) {
                    obj.type = $scope.receipt.type;
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

            $scope.deleteReceipt = function (id) {
                $scope.deleteSuccessMsg = "";
                $scope.deleteErrorMsg = "";
                // var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'receipts/receipts.php';
                var obj = {
                    'id': id,
                    'type': "",
                    'impJobId': "",
                    'action': "delete_receipt"
                };
                if (angular.isDefined($scope.importJobId) && $scope.importJobId !== null) {
                    obj.impJobId = $scope.importJobId;
                }
                if (angular.isDefined($scope.type) && $scope.type !== null) {
                    if ($scope.type === "importAir") {
                        obj.type = "importAir";
                    } else if ($scope.type === "importSea") {
                        obj.type = "importSea";
                    } else if ($scope.type === "exportSea") {
                        obj.type = "exportSea";
                    } else if ($scope.type === "exportAir") {
                        obj.type = "exportAir";
                    }
                }
                http.post(url, obj).then(function (data) {
                    if (angular.isDefined(data.data) && data.data.infocode === "DELETERECEIPTSUCCESS") {
                        $scope.deleteSuccessMsg = "Receipt deleted Successfully !";
                        init();
                        $(showDelete).modal('hide');
                    } else {
                        $scope.deleteErrorMsg = data.data.msg;
                    }
                }, function (error) {
                    $scope.error = error;
                });
            };

            $scope.showDeleteModal = function (id) {
                $scope.deleteSuccessMsg = "";
                $scope.deleteErrorMsg = "";
                $scope.deleteId = id;
                $(showDelete).modal("show");
            };
            /**this method saves personnel object for the given importJob id */
            $scope.saveReceipt = function () {
                $scope.alertMsg = "";
                $scope.successMsg = "";
                $scope.errorMsg = "";
                // var url = "http://localhost:8888/kbs/php/application.php";

                var url = dbConfigService.getUrl() + 'receipts/receipts.php';
                var obj = commonService.getReceiptObj();
                if ($scope.createFlag) {
                    obj = setReceiptFields(obj, "create_receipts");
                    $scope.actionMsg = "created";
                } else {
                    obj = setReceiptFields(obj, "update_receipts");
                    $scope.actionMsg = "updated";
                }
                var validate = commonService.saveValidations(obj);
                if (validate.flag === true) {
                    http.post(url, obj).then(function (data) {
                        if (angular.isDefined(data.data) && data.data.infocode === "CREATERECEIPTSUCCESS" && $scope.createFlag) {
                            $scope.successMsg = "Receipt " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
                            if ($scope.createFlag) {
                                init();
                                $scope.updateFlag = true;
                                $scope.createFlag = false;
                            }
                        } else if (angular.isDefined(data.data) && data.data.infocode === "UPDATERECEIPTSUCCESS" && !$scope.createFlag) {
                            init();
                            $scope.successMsg = "Receipt " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
                        } else {
                            $scope.errorMsg = data.data.msg;
                        }
                    }, function (error) {
                        $scope.error = error;
                    });
                } else {
                    $scope.alertMsg = validate.msg;
                }
            };

        }],
        templateUrl: './assets/templates/directive/delivery.html'
    };
})
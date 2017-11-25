app.directive('expenditureSlip', function () {
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
                var url = dbConfigService.getUrl() + 'slip/slip.php';
                if ($scope.updateType === "create") {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    spinner.stop('spinner-1');
                } else {
                    $scope.createFlag = false;
                    $scope.updateFlag = true;
                    var obj = {
                        module: "importsea",
                        action: "view_slip",
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

            function clearReceiptData() {
                $scope.receipt.date = "";
                $scope.receipt.particulars = "";
                $scope.receipt.amount = "";
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
                    mapSlipData(data);
                }
                $(showReceipt).modal("show");
            };

            function mapSlipData(obj) {
                $scope.updateId = obj.id;
                if (angular.isDefined(obj.date) && obj.date !== null) {
                    $scope.receipt.date = new Date(obj.date);
                }
                if (angular.isDefined(obj.particulars) && obj.particulars !== null) {
                    $scope.receipt.particulars = obj.particulars;
                }
                if (angular.isDefined(obj.amount) && obj.amount !== null) {
                    $scope.receipt.amount = obj.amount;
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

            function setSlipFields(obj, action) {
                obj.action = action;
                if (angular.isDefined($scope.importJobId) && $scope.importJobId !== null) {
                    obj.impJobId = $scope.importJobId;
                }
                if (action === 'update_slip') {
                    obj.id = $scope.updateId;
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

                if (angular.isDefined($scope.receipt.date) && $scope.receipt.date !== null) {
                    obj.date = $filter('date')($scope.receipt.date, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.receipt.particulars) && $scope.receipt.particulars !== null) {
                    obj.particulars = $scope.receipt.particulars;
                }
                if (angular.isDefined($scope.receipt.amount) && $scope.receipt.amount !== null) {
                    obj.amount = $scope.receipt.amount;
                }

                return obj;
            }

            $scope.deleteSlip = function (id) {
                $scope.deleteSuccessMsg = "";
                $scope.deleteErrorMsg = "";
                // var url = "http://localhost:8888/kbs/php/application.php";
                var url = dbConfigService.getUrl() + 'slip/slip.php';
                var obj = {
                    'id': id,
                    'type': "",
                    'impJobId':"",
                    'action': "delete_slip"
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
                    if (angular.isDefined(data.data) && data.data.infocode === "DELETESLIPSUCCESS") {
                        $scope.deleteSuccessMsg = "Slip deleted Successfully !";
                        init();
                        $(showDelete).modal('hide');
                    } else {
                        $scope.deleteErrorMsg = data.data.msg;
                    }
                }, function (error) {
                    $scope.error = error;
                });
            };

            $scope.showDeleteModal = function (id, date) {
                $scope.deleteSuccessMsg = "";
                $scope.deleteErrorMsg="";
                $scope.deleteDate = date;
                $scope.deleteId = id;
                $(showDelete).modal("show");
            };
            /**this method saves personnel object for the given importJob id */
            $scope.saveReceipt = function () {
                $scope.alertMsg = "";
                $scope.successMsg = "";
                $scope.errorMsg = "";
                // var url = "http://localhost:8888/kbs/php/application.php";

                var url = dbConfigService.getUrl() + 'slip/slip.php';
                var obj = commonService.getSlipObj();
                if ($scope.createFlag) {
                    obj = setSlipFields(obj, "create_slip");
                    $scope.actionMsg = "created";
                } else {
                    obj = setSlipFields(obj, "update_slip");
                    $scope.actionMsg = "updated";
                }
                var validate = commonService.saveValidations(obj);
                if (validate.flag === true) {
                    http.post(url, obj).then(function (data) {
                        if (angular.isDefined(data.data) && data.data.infocode === "CREATESLIPSUCCESS" && $scope.createFlag) {
                            $scope.successMsg = "Slip " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
                            if ($scope.createFlag) {
                                init();
                                $scope.updateFlag = true;
                                $scope.createFlag = false;
                            }
                        } else if (angular.isDefined(data.data) && data.data.infocode === "UPDATESLIPSUCCESS" && !$scope.createFlag) {
                            init();
                            $scope.successMsg = "Slip " + $scope.actionMsg + " Successfully for " + $scope.importJobId + " !";
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
        templateUrl: './assets/templates/directive/slip.html'
    };
})
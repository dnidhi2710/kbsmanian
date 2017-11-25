app.directive('clearanceSection', function () {
    return {
        restrict: 'E',
        transclude: true,
        scope: {
            type: '@',
            updateType: '=',
            importJobId: '=',
            clearanceObj: '='
        },
        controller: ['$scope', 'commonService', 'usSpinnerService', '$filter', '$http', 'dbConfigService', function clearanceController($scope, commonService, spinner, $filter, http, configSevice) {

            $scope.clearance = {};
            $scope.clearance.clrparticulars = [];
            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[2];
            $scope.personnel = {};
            $scope.others = {};
            init();

            function init() {
                // spinner.spin('spinner-1');
                //var url = "http://localhost:8888/kbs/php/application.php";

                var url = configSevice.getUrl() + "customs/customService.php";
                if ($scope.updateType === "create") {
                    $scope.createFlag = true;
                    $scope.updateFlag = false;
                    spinner.stop('spinner-1');
                } else {
                    $scope.createFlag = false;
                    $scope.updateFlag = true;
                    var obj = {
                        module: "importsea",
                        action: "view_customs_section",
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
                            $scope.ClearanceData = response.data.data;
                            spinner.stop('spinner-1');
                            mapFieldsWithgetObj($scope.ClearanceData);
                        } else {
                            $scope.createFlag = true;
                            $scope.updateFlag = false;
                            spinner.stop('spinner-1');
                        }
                    });
                }
            }

            function mapFieldsWithgetObj(clearanceObj) {
                var obj = clearanceObj.customObj.clearance.clearanceFields[0];
                if (angular.isDefined(obj.iceGateJobNo) && obj.iceGateJobNo !== null) {
                    $scope.clearance.gateNo = obj.iceGateJobNo;
                }
                if (angular.isDefined(obj.bOrEDetail) && obj.bOrEDetail !== null) {
                    $scope.clearance.BEnoDt = obj.bOrEDetail;
                }
                if (angular.isDefined(obj.gcNoteNo) && obj.gcNoteNo !== null) {
                    $scope.clearance.ourGCNote = obj.gcNoteNo;
                }
                if (angular.isDefined(obj.transpoterGcNoteNo) && obj.transpoterGcNoteNo !== null) {
                    $scope.clearance.transGCNote = obj.transpoterGcNoteNo;
                }

                if (angular.isDefined(obj.CIFValues) && obj.CIFValues !== null) {
                    $scope.clearance.cif = obj.CIFValues;
                }

                if (angular.isDefined(obj.landingCharges) && obj.landingCharges !== null) {
                    $scope.clearance.landingCharges = obj.landingCharges;
                }

                if (angular.isDefined(obj.BEValue) && obj.BEValue !== null) {
                    $scope.clearance.BEValue = obj.BEValue;
                }

                if (angular.isDefined(obj.remarks) && obj.remarks !== null) {
                    $scope.clearance.remarks = obj.remarks;
                }
                mapFieldsWithOtherObj(clearanceObj.customObj);
                mapFieldsWithPersonnelObj(clearanceObj.customObj);
            }

            function mapFieldsWithPersonnelObj(personnelObj) {
                var obj = personnelObj.personnelSample;
                angular.extend(obj, personnelObj.beObj);
                angular.extend(obj, personnelObj.personnel);
                //obj.concat(personnelObj.beObj, personnelObj.personnel);
                if (angular.isDefined(obj.customsClerk) && obj.customsClerk !== null) {
                    $scope.personnel.customClerk = obj.customsClerk;
                }
                if (angular.isDefined(obj.jobAllotedOn) && obj.jobAllotedOn !== null) {
                    $scope.personnel.jobAllotedon = new Date(obj.jobAllotedOn);
                }
                if (angular.isDefined(obj.docRecord) && obj.docRecord !== null) {
                    $scope.personnel.documentRecord = obj.docRecord;
                }
                if (angular.isDefined(obj.docRecordDate) && obj.docRecordDate !== null) {
                    $scope.personnel.docRecDate = new Date(obj.docRecordDate);
                }
                if (angular.isDefined(obj.docCalled) && obj.docCalled !== null) {
                    $scope.personnel.docCalled = obj.docCalled;
                }
                if (angular.isDefined(obj.docCalledDate) && obj.docCalledDate !== null) {
                    $scope.personnel.docCalledDate = new Date(obj.docCalledDate);
                }
                if (angular.isDefined(obj.Rem) && obj.Rem !== null) {
                    $scope.personnel.rem = obj.Rem;
                }
                if (angular.isDefined(obj.Recrd) && obj.Recrd !== null) {
                    $scope.personnel.recrd = obj.Recrd;
                }
                if (angular.isDefined(obj.recdtxtarea) && obj.recdtxtarea !== null) {
                    $scope.personnel.recrdtxtarea = obj.recdtxtarea;
                }
                if (angular.isDefined(obj.BEFieldonManifest) && obj.BEFieldonManifest !== null) {
                    $scope.personnel.fieldOnManifest = new Date(obj.BEFieldonManifest);
                }
                if (angular.isDefined(obj.G_MNo) && obj.G_MNo !== null) {
                    $scope.personnel.GMNO = obj.G_MNo;
                }
                if (angular.isDefined(obj.LineNO) && obj.LineNO !== null) {
                    $scope.personnel.lineNO = obj.LineNO;
                }
                if (angular.isDefined(obj.LineNoDate) && obj.LineNoDate !== null) {
                    $scope.personnel.lineNoDate = new Date(obj.LineNoDate);
                }
                if (angular.isDefined(obj.BEManifestedon) && obj.BEManifestedon !== null) {
                    $scope.personnel.manifestedOn = new Date(obj.BEManifestedon);
                }
                if (angular.isDefined(obj.BEManifestNo) && obj.BEManifestNo !== null) {
                    $scope.personnel.manifestNo = obj.BEManifestNo;
                }
                if (angular.isDefined(obj.BEManifestDate) && obj.BEManifestDate !== null) {
                    $scope.personnel.manifestedonDate = new Date(obj.BEManifestDate);
                }
                if (angular.isDefined(obj.BEAppraising) && obj.BEAppraising !== null) {
                    $scope.personnel.appraisingDptOn = new Date(obj.BEAppraising);
                }
                if (angular.isDefined(obj.BEAppraisingNo) && obj.BEAppraisingNo !== null) {
                    $scope.personnel.appraisingNo = obj.BEAppraisingNo;
                }
                if (angular.isDefined(obj.BEAppraisingDate) && obj.BEAppraisingDate !== null) {
                    $scope.personnel.appraisingDate = new Date(obj.BEAppraisingDate);
                }
                if (angular.isDefined(obj.BEApprasingFor) && obj.BEApprasingFor !== null) {
                    $scope.personnel.appraiseFor = obj.BEApprasingFor;
                }
                if ((obj.bOrEPutupAppFor).indexOf('[') === 0) {
                    obj.bOrEPutupAppFor = JSON.parse(obj.bOrEPutupAppFor);

                    if (obj.bOrEPutupAppFor && angular.isDefined(obj.bOrEPutupAppFor[0].for) && obj.bOrEPutupAppFor[0].for !== null) {
                        $scope.personnel.BEputUPfor = obj.bOrEPutupAppFor[0].for;
                    }
                    if (obj.bOrEPutupAppFor && angular.isDefined(obj.bOrEPutupAppFor[1].for) && obj.bOrEPutupAppFor[1].for !== null) {
                        $scope.personnel.BEputUPfor2 = obj.bOrEPutupAppFor[1].for;
                    }
                    if (obj.bOrEPutupAppFor && angular.isDefined(obj.bOrEPutupAppFor[2].for) && obj.bOrEPutupAppFor[2].for !== null) {
                        $scope.personnel.BEputUPfor3 = obj.bOrEPutupAppFor[2].for;
                    }
                }

                if ((obj.bOrEPutupAppRetrnOn).indexOf('[') === 0) {
                    obj.bOrEPutupAppRetrnOn = JSON.parse(obj.bOrEPutupAppRetrnOn);
                    if (obj.bOrEPutupAppRetrnOn && angular.isDefined(obj.bOrEPutupAppRetrnOn[0].returnedOn) && obj.bOrEPutupAppRetrnOn[0].returnedOn !== null) {
                        $scope.personnel.BEreturnedon = new Date(obj.bOrEPutupAppRetrnOn[0].returnedOn);
                    }
                    if (obj.bOrEPutupAppRetrnOn && angular.isDefined(obj.bOrEPutupAppRetrnOn[1].returnedOn) && obj.bOrEPutupAppRetrnOn[1].returnedOn !== null) {
                        $scope.personnel.BEreturnedon2 = new Date(obj.bOrEPutupAppRetrnOn[1].returnedOn);
                    }
                    if (obj.bOrEPutupAppRetrnOn && angular.isDefined(obj.bOrEPutupAppRetrnOn[2].returnedOn) && obj.bOrEPutupAppRetrnOn[2].returnedOn !== null) {
                        $scope.personnel.BEreturnedon3 = new Date(obj.bOrEPutupAppRetrnOn[2].returnedOn);
                    }
                }

                if ((obj.bOrEPutupAppOn).indexOf('[') === 0) {
                    obj.bOrEPutupAppOn = JSON.parse(obj.bOrEPutupAppOn);
                    if (obj.bOrEPutupAppOn && angular.isDefined(obj.bOrEPutupAppOn[0].putUpOn) && obj.bOrEPutupAppOn[0].putUpOn !== null) {
                        $scope.personnel.BEAppraiser = new Date(obj.bOrEPutupAppOn[0].putUpOn);
                    }
                    if (obj.bOrEPutupAppOn && angular.isDefined(obj.bOrEPutupAppOn[1].putUpOn) && obj.bOrEPutupAppOn[1].putUpOn !== null) {
                        $scope.personnel.BEAppraiser2 = new Date(obj.bOrEPutupAppOn[1].putUpOn);
                    }
                    if (obj.bOrEPutupAppOn && angular.isDefined(obj.bOrEPutupAppOn[2].putUpOn) && obj.bOrEPutupAppOn[2].putUpOn !== null) {
                        $scope.personnel.BEAppraiser3 = new Date(obj.bOrEPutupAppOn[2].putUpOn);
                    }
                }

                if (angular.isDefined(obj.calledOn) && obj.calledOn !== null) {
                    $scope.personnel.calledOnsamples = new Date(obj.calledOn);
                }
                if (angular.isDefined(obj.dClerkIntrunOn) && obj.dClerkIntrunOn !== null) {
                    $scope.personnel.docClerkInstrOn = new Date(obj.dClerkIntrunOn);
                }
                if (angular.isDefined(obj.drawnOn) && obj.drawnOn !== null) {
                    $scope.personnel.drawnOn = new Date(obj.drawnOn);
                }
                if (angular.isDefined(obj.reasonForDelay) && obj.reasonForDelay !== null) {
                    $scope.personnel.drawnReasonDelay = obj.reasonForDelay;
                }
                if (angular.isDefined(obj.orderSentTo) && obj.orderSentTo !== null) {
                    $scope.personnel.orderSentTogrp = new Date(obj.orderSentTo);
                }
                if (angular.isDefined(obj.testReport) && obj.testReport !== null) {
                    $scope.personnel.testReportRecdNo = new Date(obj.testReport);
                }
                if (angular.isDefined(obj.samplesCollOn) && obj.samplesCollOn !== null) {
                    $scope.personnel.samplesCollOn = new Date(obj.samplesCollOn);
                }
                if (angular.isDefined(obj.givenTo) && obj.givenTo !== null) {
                    $scope.personnel.givenTo = obj.givenTo;
                }
                if (angular.isDefined(obj.givenOn) && obj.givenOn !== null) {
                    $scope.personnel.givenOn = new Date(obj.givenOn);
                }
                if (angular.isDefined(obj.givenTime) && obj.givenTime !== null) {
                    $scope.personnel.givenTime = obj.givenTime;
                }
                if (angular.isDefined(obj.testCustomsAccessing) && obj.testCustomsAccessing !== null) {
                    $scope.personnel.testCustomsDelay = obj.testCustomsAccessing;
                }
                if (angular.isDefined(obj.testCustomsTo) && obj.testCustomsTo !== null) {
                    $scope.personnel.customsDelayto = obj.testCustomsTo;
                }
                if (angular.isDefined(obj.testCustomsReason) && obj.testCustomsReason !== null) {
                    $scope.personnel.customsReason = obj.testCustomsReason;
                }
            }

            function mapFieldsWithOtherObj(otherObj) {
                var obj = otherObj.ict;
                angular.extend(obj, otherObj.license);
                angular.extend(obj, otherObj.penality);
                if (angular.isDefined(obj.importerIctNo) && obj.importerIctNo !== null) {
                    $scope.others.importedICTno = obj.importerIctNo;
                }
                if (angular.isDefined(obj.importerIctRate) && obj.importerIctRate !== null) {
                    $scope.others.importedRate = obj.importerIctRate;
                }
                if (angular.isDefined(obj.givenON) && obj.givenON !== null) {
                    $scope.others.importedGivenOn = new Date(obj.givenON); //$filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.actualIctNo) && obj.actualIctNo !== null) {
                    $scope.others.actualICT = obj.actualIctNo;
                }
                if (angular.isDefined(obj.actualIctRate) && obj.actualIctRate !== null) {
                    $scope.others.ICTrate = obj.actualIctRate;
                }
                if (angular.isDefined(obj.dutyAmount) && obj.dutyAmount !== null) {
                    $scope.others.dutyAMount = obj.dutyAmount;
                }
                if (angular.isDefined(obj.ReasonNotAdmitImpIct) && obj.ReasonNotAdmitImpIct !== null) {
                    $scope.others.notAdmittingReasons = obj.ReasonNotAdmitImpIct;
                }
                if (angular.isDefined(obj.amount) && obj.amount !== null) {
                    $scope.others.penalityAmount = obj.amount;
                }
                if (angular.isDefined(obj.leviedOn) && obj.leviedOn !== null) {
                    $scope.others.leviedOn = new Date(obj.leviedOn); //$filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.paidOn) && obj.paidOn !== null) {
                    $scope.others.paidOn = new Date(obj.paidOn); // $filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.penaltyReason) && obj.penaltyReason !== null) {
                    $scope.others.penalityReasons = obj.penaltyReason;
                }
                if (angular.isDefined(obj.licenceSentOn) && obj.licenceSentOn !== null) {
                    $scope.others.licenseSent = new Date(obj.licenceSentOn);
                }
                if (angular.isDefined(obj.licenceSentTime) && obj.licenceSentTime !== null) {
                    $scope.others.LicenseTime = obj.licenceSentTime;
                }
                if (angular.isDefined(obj.toAuditOn) && obj.toAuditOn !== null) {
                    $scope.others.ToAdultOn = new Date(obj.toAuditOn); // $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.auditedOn) && obj.auditedOn !== null) {
                    $scope.others.auditedOn = new Date(obj.auditedOn); //$filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.auditedTime) && obj.auditedTime !== null) {
                    $scope.others.AuditedTime = obj.auditedTime;
                }
                if (angular.isDefined(obj.auditRecdBackOn) && obj.auditRecdBackOn !== null) {
                    $scope.others.recordBackOn = new Date(obj.auditRecdBackOn); //$filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.auditRecdBackTime) && obj.auditRecdBackTime !== null) {
                    $scope.others.recrdBackTime = obj.auditRecdBackTime;
                }
                if (angular.isDefined(obj.dsptdFrBEOn) && obj.dsptdFrBEOn !== null) {
                    $scope.others.dispatchedFrom = new Date(obj.dsptdFrBEOn); // $filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.dsptdFrJobNo) && obj.dsptdFrJobNo !== null) {
                    $scope.others.forJobNo = obj.dsptdFrJobNo;
                }
                if (angular.isDefined(obj.dsptdFrBETime) && obj.dsptdFrBETime !== null) {
                    $scope.others.DespatchedTime = obj.dsptdFrBETime;
                }
                if (angular.isDefined(obj.dsptdRecdBackOn) && obj.dsptdRecdBackOn !== null) {
                    $scope.others.receivedbackOn = new Date(obj.dsptdRecdBackOn); //$filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.dsptdRecdBackTime) && obj.dsptdRecdBackTime !== null) {
                    $scope.others.receivecTime = obj.dsptdRecdBackTime;
                }
                if (angular.isDefined(obj.dsptdRecdBackInitial) && obj.dsptdRecdBackInitial !== null) {
                    $scope.others.receivedInitial = obj.dsptdRecdBackInitial;
                }
                if (angular.isDefined(obj.parcelHandedOn) && obj.parcelHandedOn !== null) {
                    $scope.others.BEParcelOn = new Date(obj.parcelHandedOn); // $filter('date')(, "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.parcelHandedTime) && obj.parcelHandedTime !== null) {
                    $scope.others.BEParcelTime = obj.parcelHandedTime;
                }
                if (angular.isDefined(obj.parcelHandedInitial) && obj.parcelHandedInitial !== null) {
                    $scope.others.BEParcelInitial = obj.parcelHandedInitial;
                }
                if (angular.isDefined(obj.detentionCrftNo) && obj.detentionCrftNo !== null) {
                    $scope.others.detentionCertNo = obj.detentionCrftNo;
                }
                if (angular.isDefined(obj.detentionCrftDate) && obj.detentionCrftDate !== null) {
                    $scope.others.dcDate = new Date(obj.detentionCrftDate); //$filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.detentionCrftFrom) && obj.detentionCrftFrom !== null) {
                    $scope.others.dcFrom = obj.detentionCrftFrom;
                }
                if (angular.isDefined(obj.detentionCrftTo) && obj.detentionCrftTo !== null) {
                    $scope.others.dcTo = obj.detentionCrftTo;
                }
                if (angular.isDefined(obj.detenAppliedON) && obj.detenAppliedON !== null) {
                    $scope.others.dcAppliedon = new Date(obj.detenAppliedON); //$filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.detenSubmittedon) && obj.detenSubmittedon !== null) {
                    $scope.others.dcSubmittedOn = new Date(obj.detenSubmittedon); //$filter('date')( , "yyyy-MM-dd");
                }
                if (angular.isDefined(obj.detenReasondelay) && obj.detenReasondelay !== null) {
                    $scope.others.dcReasonDelay = obj.detenReasondelay;
                }
                if (angular.isDefined(obj.otherAgents) && obj.otherAgents !== null) {
                    $scope.others.otherAgents = obj.otherAgents;
                }
                if (angular.isDefined(obj.otherCFS) && obj.otherCFS !== null) {
                    $scope.others.aaiCharges = obj.otherCFS;
                }
            }

            $scope.addClearanceObj = function () {
                var ContainerObj = {
                    "packages": "",
                    "date": "",
                    "cd": ""
                };
                $scope.clearance.clrparticulars.push(ContainerObj);
            };

            $scope.delClearanceObj = function () {
                $scope.clearance.clrparticulars.pop();
            };

            function setCustomsFields(obj, action) {
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

                if (angular.isDefined($scope.clearance.gateNo) && $scope.clearance.gateNo !== null) {
                    obj.iceGateJobNo = $scope.clearance.gateNo;
                }
                if (angular.isDefined($scope.clearance.BEnoDt) && $scope.clearance.BEnoDt !== null) {
                    obj.bOrEDetail = $scope.clearance.BEnoDt;
                }

                if (angular.isDefined($scope.clearance.cif) && $scope.clearance.cif !== null) {
                    obj.CIFValues = $scope.clearance.cif;
                }

                if (angular.isDefined($scope.clearance.landingCharges) && $scope.clearance.landingCharges !== null) {
                    obj.landingCharges = $scope.clearance.landingCharges;
                }

                if (angular.isDefined($scope.clearance.BEValue) && $scope.clearance.BEValue !== null) {
                    obj.BEValue = $scope.clearance.BEValue;
                }
                obj = setPersonnelFields(obj);
                obj = setOtherFields(obj);
                return obj;
            }

            function setOtherFields(obj) {
                if (angular.isDefined($scope.others.importedICTno) && $scope.others.importedICTno !== null) {
                    obj.importerIctNo = $scope.others.importedICTno;
                }
                if (angular.isDefined($scope.others.importedRate) && $scope.others.importedRate !== null) {
                    obj.importerIctRate = $scope.others.importedRate;
                }
                if (angular.isDefined($scope.others.importedGivenOn) && $scope.others.importedGivenOn !== null) {
                    obj.givenON = $filter('date')($scope.others.importedGivenOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.actualICT) && $scope.others.actualICT !== null) {
                    obj.actualIctNo = $scope.others.actualICT;
                }
                if (angular.isDefined($scope.others.ICTrate) && $scope.others.ICTrate !== null) {
                    obj.actualIctRate = $scope.others.ICTrate;
                }
                if (angular.isDefined($scope.others.dutyAMount) && $scope.others.dutyAMount !== null) {
                    obj.dutyAmount = $scope.others.dutyAMount;
                }
                if (angular.isDefined($scope.others.notAdmittingReasons) && $scope.others.notAdmittingReasons !== null) {
                    obj.ReasonNotAdmitImpIct = $scope.others.notAdmittingReasons;
                }
                if (angular.isDefined($scope.others.penalityAmount) && $scope.others.penalityAmount !== null) {
                    obj.amount = $scope.others.penalityAmount;
                }
                if (angular.isDefined($scope.others.leviedOn) && $scope.others.leviedOn !== null) {
                    obj.leviedOn = $filter('date')($scope.others.leviedOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.paidOn) && $scope.others.paidOn !== null) {
                    obj.paidOn = $filter('date')($scope.others.paidOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.penalityReasons) && $scope.others.penalityReasons !== null) {
                    obj.penaltyReason = $scope.others.penalityReasons;
                }
                if (angular.isDefined($scope.others.licenseSent) && $scope.others.licenseSent !== null) {
                    obj.licenceSentOn = $scope.others.licenseSent;
                }
                if (angular.isDefined($scope.others.LicenseTime) && $scope.others.LicenseTime !== null) {
                    obj.licenceSentTime = $scope.others.LicenseTime;
                }
                if (angular.isDefined($scope.others.ToAdultOn) && $scope.others.ToAdultOn !== null) {
                    obj.toAuditOn = $filter('date')($scope.others.ToAdultOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.auditedOn) && $scope.others.auditedOn !== null) {
                    obj.auditedOn = $filter('date')($scope.others.auditedOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.AuditedTime) && $scope.others.AuditedTime !== null) {
                    obj.auditedTime = $scope.others.AuditedTime;
                }
                if (angular.isDefined($scope.others.recordBackOn) && $scope.others.recordBackOn !== null) {
                    obj.auditRecdBackOn = $filter('date')($scope.others.recordBackOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.recrdBackTime) && $scope.others.recrdBackTime !== null) {
                    obj.auditRecdBackTime = $scope.others.recrdBackTime;
                }
                if (angular.isDefined($scope.others.dispatchedFrom) && $scope.others.dispatchedFrom !== null) {
                    obj.dsptdFrBEOn = $filter('date')($scope.others.dispatchedFrom, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.forJobNo) && $scope.others.forJobNo !== null) {
                    obj.dsptdFrJobNo = $scope.others.forJobNo;
                }
                if (angular.isDefined($scope.others.DespatchedTime) && $scope.others.DespatchedTime !== null) {
                    obj.dsptdFrBETime = $scope.others.DespatchedTime;
                }
                if (angular.isDefined($scope.others.receivedbackOn) && $scope.others.receivedbackOn !== null) {
                    obj.dsptdRecdBackOn = $filter('date')($scope.others.receivedbackOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.receivecTime) && $scope.others.receivecTime !== null) {
                    obj.dsptdRecdBackTime = $scope.others.receivecTime;
                }
                if (angular.isDefined($scope.others.receivedInitial) && $scope.others.receivedInitial !== null) {
                    obj.dsptdRecdBackInitial = $scope.others.receivedInitial;
                }
                if (angular.isDefined($scope.others.BEParcelOn) && $scope.others.BEParcelOn !== null) {
                    obj.parcelHandedOn = $filter('date')($scope.others.BEParcelOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.BEParcelTime) && $scope.others.BEParcelTime !== null) {
                    obj.parcelHandedTime = $scope.others.BEParcelTime;
                }
                if (angular.isDefined($scope.others.BEParcelInitial) && $scope.others.BEParcelInitial !== null) {
                    obj.parcelHandedInitial = $scope.others.BEParcelInitial;
                }
                if (angular.isDefined($scope.others.detentionCertNo) && $scope.others.detentionCertNo !== null) {
                    obj.detentionCrftNo = $scope.others.detentionCertNo;
                }
                if (angular.isDefined($scope.others.dcDate) && $scope.others.dcDate !== null) {
                    obj.detentionCrftDate = $filter('date')($scope.others.dcDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.dcFrom) && $scope.others.dcFrom !== null) {
                    obj.detentionCrftFrom = $scope.others.dcFrom;
                }
                if (angular.isDefined($scope.others.dcTo) && $scope.others.dcTo !== null) {
                    obj.detentionCrftTo = $scope.others.dcTo;
                }
                if (angular.isDefined($scope.others.dcAppliedon) && $scope.others.dcAppliedon !== null) {
                    obj.detenAppliedON = $filter('date')($scope.others.dcAppliedon, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.dcSubmittedOn) && $scope.others.dcSubmittedOn !== null) {
                    obj.detenSubmittedon = $filter('date')($scope.others.dcSubmittedOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.others.dcReasonDelay) && $scope.others.dcReasonDelay !== null) {
                    obj.detenReasondelay = $scope.others.dcReasonDelay;
                }
                if (angular.isDefined($scope.others.otherAgents) && $scope.others.otherAgents !== null) {
                    obj.otherAgents = $scope.others.otherAgents;
                }
                if (angular.isDefined($scope.others.aaiCharges) && $scope.others.aaiCharges !== null) {
                    obj.otherCFS = $scope.others.aaiCharges;
                }
                return obj;
            }

            function setPersonnelFields(obj) {
                obj.bOrEPutupAppOn = [];
                obj.bOrEPutupAppFor = [];
                obj.bOrEPutupAppRetrnOn = [];
                if (angular.isDefined($scope.personnel.customClerk) && $scope.personnel.customClerk !== null) {
                    obj.customsClerk = $scope.personnel.customClerk;
                }
                if (angular.isDefined($scope.personnel.jobAllotedon) && $scope.personnel.jobAllotedon !== null) {
                    obj.jobAllotedOn = $filter('date')($scope.personnel.jobAllotedon, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.documentRecord) && $scope.personnel.documentRecord !== null) {
                    obj.docRecord = $scope.personnel.documentRecord;
                }
                if (angular.isDefined($scope.personnel.docRecDate) && $scope.personnel.docRecDate !== null) {
                    obj.docRecordDate = $filter('date')($scope.personnel.docRecDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.docCalled) && $scope.personnel.docCalled !== null) {
                    obj.docCalled = $scope.personnel.docCalled;
                }
                if (angular.isDefined($scope.personnel.docCalledDate) && $scope.personnel.docCalledDate !== null) {
                    obj.docCalledDate = $filter('date')($scope.personnel.docCalledDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.rem) && $scope.personnel.rem !== null) {
                    obj.Rem = $scope.personnel.rem;
                }
                if (angular.isDefined($scope.personnel.recrd) && $scope.personnel.recrd !== null) {
                    obj.Recrd = $scope.personnel.recrd;
                }
                if (angular.isDefined($scope.personnel.recrdtxtarea) && $scope.personnel.recrdtxtarea !== null) {
                    obj.recdtxtarea = $scope.personnel.recrdtxtarea;
                }
                if (angular.isDefined($scope.personnel.fieldOnManifest) && $scope.personnel.fieldOnManifest !== null) {
                    obj.BEFieldonManifest = $filter('date')($scope.personnel.fieldOnManifest, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.GMNO) && $scope.personnel.GMNO !== null) {
                    obj.G_MNo = $scope.personnel.GMNO;
                }
                if (angular.isDefined($scope.personnel.lineNO) && $scope.personnel.lineNO !== null) {
                    obj.LineNO = $scope.personnel.lineNO;
                }
                if (angular.isDefined($scope.personnel.lineNoDate) && $scope.personnel.lineNoDate !== null) {
                    obj.LineNoDate = $filter('date')($scope.personnel.lineNoDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.manifestedOn) && $scope.personnel.manifestedOn !== null) {
                    obj.BEManifestedon = $filter('date')($scope.personnel.manifestedOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.manifestNo) && $scope.personnel.manifestNo !== null) {
                    obj.BEManifestNo = $scope.personnel.manifestNo;
                }
                if (angular.isDefined($scope.personnel.manifestedonDate) && $scope.personnel.manifestedonDate !== null) {
                    obj.BEManifestDate = $filter('date')($scope.personnel.manifestedonDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.appraisingDptOn) && $scope.personnel.appraisingDptOn !== null) {
                    obj.BEAppraising = $scope.personnel.appraisingDptOn;
                }
                if (angular.isDefined($scope.personnel.appraisingNo) && $scope.personnel.appraisingNo !== null) {
                    obj.BEAppraisingNo = $scope.personnel.appraisingNo;
                }
                if (angular.isDefined($scope.personnel.appraisingDate) && $scope.personnel.appraisingDate !== null) {
                    obj.BEAppraisingDate = $filter('date')($scope.personnel.appraisingDate, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.appraiseFor) && $scope.personnel.appraiseFor !== null) {
                    obj.BEApprasingFor = $scope.personnel.appraiseFor;
                }

                if (angular.isDefined($scope.personnel.BEreturnedon) && $scope.personnel.BEreturnedon !== null) {
                    obj.bOrEPutupAppRetrnOn.push({ 'returnedOn': $filter('date')($scope.personnel.BEreturnedon, "yyyy-MM-dd") });
                } else {
                    obj.bOrEPutupAppRetrnOn.push({ 'returnedOn': null });
                }
                if (angular.isDefined($scope.personnel.BEreturnedon2) && $scope.personnel.BEreturnedon2 !== null) {
                    obj.bOrEPutupAppRetrnOn.push({ 'returnedOn': $filter('date')($scope.personnel.BEreturnedon2, "yyyy-MM-dd") });
                } else {
                    obj.bOrEPutupAppRetrnOn.push({ 'returnedOn': null });
                }
                if (angular.isDefined($scope.personnel.BEreturnedon3) && $scope.personnel.BEreturnedon3 !== null) {
                    obj.bOrEPutupAppRetrnOn.push({ 'returnedOn': $filter('date')($scope.personnel.BEreturnedon3, "yyyy-MM-dd") });
                } else {
                    obj.bOrEPutupAppRetrnOn.push({ 'returnedOn': null });
                }
                obj.bOrEPutupAppRetrnOn = JSON.stringify(obj.bOrEPutupAppRetrnOn);

                if (angular.isDefined($scope.personnel.BEAppraiser) && $scope.personnel.BEAppraiser !== null) {
                    obj.bOrEPutupAppOn.push({ 'putUpOn': $filter('date')($scope.personnel.BEAppraiser, "yyyy-MM-dd") });
                } else {
                    obj.bOrEPutupAppOn.push({ 'putUpOn': null });
                }
                if (angular.isDefined($scope.personnel.BEAppraiser2) && $scope.personnel.BEAppraiser2 !== null) {
                    obj.bOrEPutupAppOn.push({ 'putUpOn': $filter('date')($scope.personnel.BEAppraiser2, "yyyy-MM-dd") });
                } else {
                    obj.bOrEPutupAppOn.push({ 'putUpOn': null });
                }
                if (angular.isDefined($scope.personnel.BEAppraiser3) && $scope.personnel.BEAppraiser3 !== null) {
                    obj.bOrEPutupAppOn.push({ 'putUpOn': $filter('date')($scope.personnel.BEAppraiser3, "yyyy-MM-dd") });
                } else {
                    obj.bOrEPutupAppOn.push({ 'putUpOn': null });
                }

                obj.bOrEPutupAppOn = JSON.stringify(obj.bOrEPutupAppOn);

                if (angular.isDefined($scope.personnel.BEputUPfor) && $scope.personnel.BEputUPfor !== null) {
                    obj.bOrEPutupAppFor.push({ 'for': $scope.personnel.BEputUPfor });
                } else {
                    obj.bOrEPutupAppFor.push({ 'for': null });
                }
                if (angular.isDefined($scope.personnel.BEputUPfor2) && $scope.personnel.BEputUPfor2 !== null) {
                    obj.bOrEPutupAppFor.push({ 'for': $scope.personnel.BEputUPfor2 });
                } else {
                    obj.bOrEPutupAppFor.push({ 'for': null });
                }
                if (angular.isDefined($scope.personnel.BEputUPfor3) && $scope.personnel.BEputUPfor3 !== null) {
                    obj.bOrEPutupAppFor.push({ 'for': $scope.personnel.BEputUPfor3 });
                } else {
                    obj.bOrEPutupAppFor.push({ 'for': null });
                }
                obj.bOrEPutupAppFor = JSON.stringify(obj.bOrEPutupAppFor);

                if (angular.isDefined($scope.personnel.calledOnsamples) && $scope.personnel.calledOnsamples !== null) {
                    obj.calledOn = $filter('date')($scope.personnel.calledOnsamples, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.docClerkInstrOn) && $scope.personnel.docClerkInstrOn !== null) {
                    obj.dClerkIntrunOn = $filter('date')($scope.personnel.docClerkInstrOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.drawnOn) && $scope.personnel.drawnOn !== null) {
                    obj.drawnOn = $filter('date')($scope.personnel.drawnOn, "yyyy-MM-dd");
                } else {
                    obj.drawnOn = "";
                }
                if (angular.isDefined($scope.personnel.drawnReasonDelay) && $scope.personnel.drawnReasonDelay !== null) {
                    obj.reasonForDelay = $scope.personnel.drawnReasonDelay;
                }
                if (angular.isDefined($scope.personnel.orderSentTogrp) && $scope.personnel.orderSentTogrp !== null) {
                    obj.orderSentTo = $filter('date')($scope.personnel.orderSentTogrp, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.testReportRecdNo) && $scope.personnel.testReportRecdNo !== null) {
                    obj.testReport = $filter('date')($scope.personnel.testReportRecdNo, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.samplesCollOn) && $scope.personnel.samplesCollOn !== null) {
                    obj.samplesCollOn = $filter('date')($scope.personnel.samplesCollOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.givenTo) && $scope.personnel.givenTo !== null) {
                    obj.givenTo = $scope.personnel.givenTo;
                }
                if (angular.isDefined($scope.personnel.givenOn) && $scope.personnel.givenOn !== null) {
                    obj.givenOn = $filter('date')($scope.personnel.givenOn, "yyyy-MM-dd");
                }
                if (angular.isDefined($scope.personnel.givenTime) && $scope.personnel.givenTime !== null) {
                    obj.givenTime = $scope.personnel.givenTime;
                }
                if (angular.isDefined($scope.personnel.testCustomsDelay) && $scope.personnel.testCustomsDelay !== null) {
                    obj.testCustomsAccessing = $scope.personnel.testCustomsDelay;
                }
                if (angular.isDefined($scope.personnel.customsDelayto) && $scope.personnel.customsDelayto !== null) {
                    obj.testCustomsTo = $scope.personnel.customsDelayto;
                }
                if (angular.isDefined($scope.personnel.customsReason) && $scope.personnel.customsReason !== null) {
                    obj.testCustomsReason = $scope.personnel.customsReason;
                }
                return obj;
            }

            function clearCreateObj() {
                $scope.clearance.gateNo = "";
                $scope.clearance.remarks = "";
                $scope.clearance.BEValue = "";
                $scope.clearance.landingCharges = "";
                $scope.clearance.particulars = [];
                $scope.clearance.cif = "";
                $scope.clearance.transGCNote = "";
                $scope.clearance.ourGCNote = "";
                $scope.clearance.BEnoDt = "";
            }

            $scope.saveClearanceFields = function () {
                $scope.alertMsg = "";
                $scope.successMsg = "";
                $scope.alertMsg = "";
                var obj = commonService.getCustomsObj();
                if ($scope.createFlag) {
                    var url = configSevice.getUrl() + "customs/customService.php";
                    obj = setCustomsFields(obj, "create_customs_section");
                    $scope.actionMsg = "created";
                } else {
                    var url = configSevice.getUrl() + "customs/customService.php";
                    //  var url = "http://localhost:8888/kbs/php/application.php";
                    obj = setCustomsFields(obj, "update_customs_section");
                    $scope.actionMsg = "updated";
                }
                var validate = commonService.saveValidations(obj);
                if (validate.flag === true) {
                    http.post(url, obj).then(function (data) {
                        if (angular.isDefined(data.data) && data.data.infocode === "CREATECUSTOMSSUCCESS" && $scope.createFlag) {
                            $scope.successMsg = "Customs Fields " + $scope.action + " Successfully for " + $scope.importJobId + " !";
                             if ($scope.createFlag) {
                                $scope.updateFlag = true;
                                $scope.createFlag = false;
                            }
                            //$scope.successMsg = data.data.message;
                            // $scope.doc.importJobNo = data.data.doc_id + configSevice.getJobid();
                            $(showClearanceSuccess).modal("show");
                        } else if (angular.isDefined(data.data) && data.data.infocode === "UPDATECUSTOMSSUCCESS" && !$scope.createFlag) {
                            $scope.successMsg = "Customs Section " + $scope.actionMsg + " Successfully for " + $scope.importJobId + "!";
                            $(showClearanceSuccess).modal("show");
                        } else {
                            $scope.errorMsg = data.data.msg;
                            $(showClearanceError).modal("show");
                        }
                    }, function (error) {
                        $scope.error = error;
                    });
                } else {
                    $scope.alertMsg = validate.msg;
                    $(showClearanceAlert).modal("show");
                }
            };

        }],
        templateUrl: './assets/templates/directive/clearance.html'
    };
})
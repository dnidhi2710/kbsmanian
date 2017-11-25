app.service('commonService', function () {

    this.getOtherObj = function () {
        var OtherFields = {
            "module": "",
            "action": "",
            "impJobId": "",
            "importerIctNo": "",
            "importerIctRate": "",
            "givenON": "",
            "actualIctNo": "",
            "actualIctRate": "",
            "dutyAmount": "",
            "ReasonNotAdmitImpIct": "",
            "amount": "",
            "leviedOn": "",
            "paidOn": "",
            "penaltyReason": "",
            "licenceSentOn": "",
            "licenceSentTime": "",
            "toAuditOn": "",
            "auditedOn": "",
            "auditedTime": "",
            "auditRecdBackOn": "",
            "auditRecdBackTime": "",
            "dsptdFrBEOn": "",
            "dsptdFrBETime": "",
            "dsptdRecdBackOn": "",
            "dsptdRecdBackTime": "",
            "dsptdRecdBackInitial": "",
            "parcelHandedOn": "",
            "parcelHandedTime": "",
            "parcelHandedInitial": "",
            "detentionCrftNo": "",
            "detentionCrftDate": "",
            "detentionCrftFrom": "",
            "detentionCrftTo": "",
            "dsptdFrJobNo": "",
            "detenAppliedON": "",
            "detenSubmittedon": "",
            "detenReasondelay": "",
            "otherAgents": "",
            "otherCFS": ""
        };
        return OtherFields;
    };

    this.getExportDocObj = function () {
        var obj = {
            "module": "",
            "action": "",
            "impJobId": "",
            "consignee": "",
            "invoiceNo": "",
            "invoiceDate": "",
            "mblDate": "",
            "invoiceValue": "",
            "Container": {
                "Contr": "",
                "noOfPkgs": "",
                "content": "",
                "measurements": "",
                "grossWeight": "",
                "nettWeight": "",
                "type": ""
            },
            "jobType": "",
            "type": "",
            "exportType": "",
            "importDate": "",
            "shipper": "",
            "bank": "",
            "bank_notify": "",
            "value": "",
            "grNo": "",
            "grDate": "",
            "rbiCode": "",
            "billNo": "",
            "billDate": "",
            "exchangeRate": "",
            "flight": "",
            "arrived": "",
            "departured": "",
            "agent": "",
            "port": "",
            "country": "",
            "emNo": "",
            "remarks": "",
            "value1": "",
            "fob": "",
            "frt": "",
            "ins": "",
            "cif": "",
            "eaNo": "",
            "lcNo": "",
            "lcDate": "",
            "orderNo": "",
            "receiptNo": "",
            "receiptDate1": "",
            "receiptDate2": "",
            "landingNo": "",
            "billDate1": "",
            "billDate2": "",
            "prt": "",
            "exUS": "",
            "exchangeDate": "",
            "rupees": "",
            "splInstructions": "",
            "awbNo": "",
            "mawbDate": ""
        };
        return obj;
    };
    this.getImportAirDocObj = function () {
        var docObj = {
            "module": "",/*airImport, seaImport, air/sea Export*/
            "action": "",
            "impJobId": "",
            "importedDate": "",
            "partyRef": "",
            "consignee": "",
            "licenseDetail": "",
            "buffNo": "",
            "address": "",
            "hsOrBtAccParty": "",
            "contents": null,
            "supplier": "",
            "invoiceNo": "",
            "invoiceDate": "",
            'license':"",
            'licenseValue':"",
            "flightDtls": "",
            "dueDate": "",
            "arrival": "",
            "gdd": "",
            "lfd": "",
            "advisedBy": "",
            "advisedOn": "",
            "shed": "",
            "warehouse": "",
            "licenseNo": "",
            "value": "",
            "balance": "",
            "agents": "",
            "igmNo": "",
            "licenseDate": "",
            "mawbNo": "",
            "hawbNo": "",
            "hawbDate": "",
            "doNo": "",
            "doDate": "",
            "invoiceValue": "",
            "Container": {
                "Contr": "",
                "noOfPkgs": "",
                "content": "",
                "measurements": "",
                "grossWeight": "",
                "nettWeight": ""
            },
            "jobType": ""
        };
        return docObj;
    };

    this.getImportAirSamplesObj = function () {
        var samplesObj = {
            "module": "",
            "action": "",
            "impJobId": "",
            "iOrAFilledOn": "",
            "iOrAFiledNo": "",
            "iOrAFiledDate": "",
            "iOrAFiledAmount": "",
            "iOrAComparedOn": "",
            "samplesCalledOn": "",
            "dockClerkInstrn": "",
            "calledInitial": "",
            "drawnOn": "",
            "calledDelayReason": "",
            "submittedToCustoms": "",
            "customsDelayReason": "",
            "bOrEReceivedOn": "",
            "bOrEReceivedTime": "",
            "bOrERecdInitial": "",
            "origOpenOrderGIvenOn": "",
            "origOpenOrderCmptdOn": "",
            "origOpenOrderDelayReason": "",
            "dupeOpenOrderGIvenOn": "",
            "dupeOpenOrderCmptdOn": "",
            "dupeOpenOrderDelayReason": "",
            "customsChargeon": "",
            "goodsClearedno": "",
            "goodClearedDelay": "",
            "remarks": ""
        };
        return samplesObj;
    };

    this.getAirContents = function () {
        return [{
            "contrNos": "1",
            "noOfPkgs": "2",
            "content": "content",
            "measurements": "20",
            "grossWeight": "30",
            "nettWeight": "50"
        },
        {
            "contrNos": "2",
            "noOfPkgs": "3",
            "content": "conten2",
            "measurements": "20",
            "grossWeight": "50",
            "nettWeight": "100"
        }];
    };

    this.getClearanceObj = function () {
        var clearanceObj = {
            "module": "",
            "action": "",
            "impJobId": "",
            "particulars": "",
            "CIFValues": "",
            "landingCharges": "",
            "B/EValue": "",
            "remarks": ""
        };
        return clearanceObj;
    };

    this.getGeneralObj = function () {
        return {
            "Bonding": false,
            "houseConsumption": false,
            "exbond": false,
            "edi": false,
            "bulk": false,
            "deec": false,
            "depb": false,
            "rms": false,
            "openOrder": false,
            "breakBulk": false
        };
    };
    this.saveValidations = function (obj) {
        var validateObj = {
            msg: "",
            flag: ""
        };
        if (angular.isUndefined(obj.impJobId) || obj.impJobId === "") {
            validateObj.msg = "Import Job Id Cannot be empty";
            validateObj.flag = false;
        } else {
            validateObj.msg = "validated";
            validateObj.flag = true;
        }
        return validateObj;
    };

    this.getSurveyObj = function () {
        var surveyObj = {
            "module": "",
            "action": "",
            "impJobId": "",
            "particulars": "",
            "CIFValues": "",
            "landingCharges": "",
            "B/EValue": "",
            "remarks": "",
            "sOrAAppliedOn": "",
            "sOrAGrantedOn": "",
            "sOrAHeldOn": "",
            "insAppliedOn": "",
            "insGrantedOn": "",
            "insHeldOn": "",
            "pTAppliedOn": "",
            "pTAGrantedOn": "",
            "pTHeldOn": "",
            "transIndentedOn": "",
            "transIndentedTime": "",
            "transSuppliedOn": "",
            "transSuppliedTime": "",
            "transDeleyReason": "",
            "remarks": ""
        };
        return surveyObj;
    };

    this.getSlipObj = function () {
        var obj = {
            'impJobId': "",
            'action':"",
            'type': "",
            'date': "",
            'particulars': "",
            'amount': ""
        };
        return obj;
    };

    this.getPersonnelObj = function () {
        var personnelObj = {
            "module": "",
            "impJobId": "",
            "action": "",
            "Customsclerk": "",
            "jobAlllotedOn": "",
            "docRecord": "",
            "docRecordDate": "",
            "docCalled": "",
            "docCalledDate": "",
            "Rem": "",
            "Recrd": "",
            "BEFieldonManifest": "",
            "G_MNo": "",
            "LineNO": "",
            "LineNoDate": "",
            "BEManifest": "",
            "BEManifestNo": "",
            "BEManifestDate": "",
            "BEAppraising": "",
            "BEAppraisingNo": "",
            "BEAppraisingDate": "",
            "BEApprasingFor": "",
            "calledOn": "",
            "dClerkIntrunOn": "",
            "drawnOn": "",
            "reasonForDelay": "",
            "orderSentTo": "",
            "testReport": "",
            "samplesCollOn": "",
            "givenTo": "",
            "givenOn": "",
            "givenTime": "",
            "testCustomsAccessing": "",
            "testCustomsTo": "",
            "testCustomsReason": ""
        };
        return personnelObj;
    };

    this.getCustomsObj = function () {
        var obj = {
            "module": "",
            "impJobId": "",
            "action": "",
            "Customsclerk": "",
            "jobAlllotedOn": "",
            "docRecord": "",
            "docRecordDate": "",
            "docCalled": "",
            "docCalledDate": "",
            "Rem": "",
            "Recrd": "",
            "BEFieldonManifest": "",
            "G_MNo": "",
            "LineNO": "",
            "LineNoDate": "",
            "BEManifest": "",
            "BEManifestNo": "",
            "BEManifestDate": "",
            "BEAppraising": "",
            "BEAppraisingNo": "",
            "BEAppraisingDate": "",
            "BEApprasingFor": "",
            "calledOn": "",
            "dClerkIntrunOn": "",
            "drawnOn": "",
            "reasonForDelay": "",
            "orderSentTo": "",
            "testReport": "",
            "samplesCollOn": "",
            "givenTo": "",
            "givenOn": "",
            "givenTime": "",
            "testCustomsAccessing": "",
            "testCustomsTo": "",
            "testCustomsReason": "",
            "importerIctNo": "",
            "importerIctRate": "",
            "givenON": "",
            "actualIctNo": "",
            "actualIctRate": "",
            "dutyAmount": "",
            "ReasonNotAdmitImpIct": "",
            "amount": "",
            "leviedOn": "",
            "paidOn": "",
            "penaltyReason": "",
            "licenceSentOn": "",
            "licenceSentTime": "",
            "toAuditOn": "",
            "auditedOn": "",
            "auditedTime": "",
            "auditRecdBackOn": "",
            "auditRecdBackTime": "",
            "dsptdFrBEOn": "",
            "dsptdFrBETime": "",
            "BEValue": "",
            "recdtxtarea": "",
            "dsptdRecdBackOn": "",
            "dsptdRecdBackTime": "",
            "dsptdRecdBackInitial": "",
            "parcelHandedOn": "",
            "parcelHandedTime": "",
            "parcelHandedInitial": "",
            "detentionCrftNo": "",
            "detentionCrftDate": "",
            "detentionCrftFrom": "",
            "detentionCrftTo": "",
            "dsptdFrJobNo": "",
            "detenAppliedON": "",
            "detenSubmittedon": "",
            "detenReasondelay": "",
            "otherAgents": "",
            "otherCFS": ""
        }
        return obj;
    };

    this.getExportRemarkObj = function () {
        var remarkObj = {
            "action": "",
            "impJobId": "",
            "exportType": "",
            "progress": "",
            "cargoReceipts": ""
        };
        return remarkObj;
    };

    this.getImportSeaDocObj = function () {
        var seaDocObj = {
            "module": "",/*airImport, seaImport, air/sea Export*/
            "action": "",
            "impJobId": "",
            "importedDate": "",
            "partyRef": "",
            "consignee": "",
            "licenseDetail": "",
            "buffNo": "",
            "address": "",
            "hsOrBtAccParty": "",
            "supplier": "",
            "invoiceNo": "",
            "invoiceDate": "",
            "motherVsl": "",
            "mvdate": "",
            "arrival": "",
            "gld": "",
            "cntrOut": "",
            "feederVsl": "",
            "fvOn": "",
            "CFS": "",
            "agents": "",
            "igmNo": "",
            "licenseDate": "",
            "lineNo": "",
            "hblNo": "",
            "hblDate": "",
            "mbl": "",
            "mblDate": "",
            "invoiceValue": "",
            "Container": {
                "Contr": "",
                "noOfPkgs": "",
                "content": "",
                "measurements": "",
                "grossWeight": "",
                "nettWeight": ""
            },
            "jobType": ""
        };
        return seaDocObj;
    };
    this.getFeedbackObj = function () {
        var obj = {
            "module": "",
            "type": "",
            "impJobId": "",
            "action": "",
            "yardName": "",
            "yardAddress": "",
            "noOfContainer": "",
            "containerDamage": "false",
            "stAgentStatus": "false",
            "billingStatus": "false",
            "emptyPlot": "",
            "offLoadDate": "",
            "containerType": ""
        };
        return obj;
    };
    this.getTransportObj = function () {
        var obj = {
            'module': "",
            'action': "",
            'impJobId': "",
            'type': "",
            'gcNoteNo': "",
            'clearanceParticulars': "",
            'transportedGCNote': "",
            'transIndentedOn': "",
            'transIndentedTime': "",
            'transSuppliedOn': "",
            'transSuppliedTime': "",
            'transDelayReason': "",
            'remarks': ""
        };
        return obj;
    };
    this.getOperationsObj = function () {
        var obj = {
            "module": "",
            "type": "",
            "impJobId": "",
            "action": "",
            "particulars": "",
            "CIFValues": "",
            "landingCharges": "",
            "B/EValue": "",
            "remarks": "",
            "sOrAAppliedOn": "",
            "sOrAGrantedOn": "",
            "sOrAHeldOn": "",
            "insAppliedOn": "",
            "insGrantedOn": "",
            "insHeldOn": "",
            "pTAppliedOn": "",
            "pTAGrantedOn": "",
            "pTHeldOn": "",
            "iOrAFilledOn": "",
            "iOrAFiledNo": "",
            "iOrAFiledDate": "",
            "iOrAFiledAmount": "",
            "iOrAComparedOn": "",
            "samplesCalledOn": "",
            "customsChargeon": "",
            "dockClerkInstrn": "",
            "calledInitial": "",
            "drawnOn": "",
            "calledDelayReason": "",
            "submittedToCustoms": "",
            "customsDelayReason": "",
            "bOrEReceivedOn": "",
            "bOrEReceivedTime": "",
            "bOrERecdInitial": "",
            "origOpenOrderGIvenOn": "",
            "origOpenOrderCmptdOn": "",
            "origOpenOrderDelayReason": "",
            "dupeOpenOrderGIvenOn": "",
            "dupeOpenOrderCmptdOn": "",
            "dupeOpenOrderDelayReason": "",
            "goodClearedDelay": "",
            "remarks": "",
            "goodsClearedno": "",
            "outOfChargeNo": ""
        };
        return obj;
    };
    this.getDoFields = function () {
        var obj = {
            "module": "",
            "action": "",
            "impJobId": "",
            "type": "",
            "customsClerk": "",
            "dockClerk": "",
            "tinNo": "",
            "cstNo": "",
            "gstNo": "",
            "stAgentsCharges": "",
            "remarks": "",
            "status": ""
        };
        return obj;
    };
    this.getFormobj = function () {
        var obj = {
            DocFields: {
                "module": "",/*airImport, seaImport, air/sea Export*/
                "action": "",
                "impJobId": "",
                "importedDate": "",
                "partyRef": "",
                "consignee": "",
                "address": "",
                "hsOrBtAccParty": "",
                "contents": [{
                    "contrNos": "",
                    "noOfPkgs": "",
                    "content": "",
                    "measurements": "",
                    "grossWeight": "",
                    "nettWeight": ""
                },
                {
                    "contrNos": "",
                    "noOfPkgs": "",
                    "content": "",
                    "measurements": "",
                    "grossWeight": "",
                    "nettWeight": ""
                }],
                "supplier": "",
                "invoiceNo": "",
                "invoiceDate": "",
                "flightDtls": "",
                "dueDate": "",
                "arrival": "",
                "gdd": "",
                "lfd": "",
                "advisedBy": "",
                "advisedOn": "",
                "shed": "",
                "warehouse": "",
                "licenseNo": "",
                "value": "",
                "balance": "",
                "agents": "",
                "igmNo": "",
                "licenseDate": "",
                "mawbNo": "",
                "hawbNo": "",
                "hawbDate": "",
                "doNo": "",
                "doDate": "",
                "invoiceValue": "",
                "customsClerk": "",
                "dockClerk": "",
                "tinNo": "",
                "cstNo": "",
                "gstNo": "",
                "landingCharges": "",
                "bOrEValue": "",
                "stAgentsCharges": "",
                "remarks": ""
            },
            ClearanceFields: {
                "module": "",
                "action": "",
                "impJobId": "",
                "clearanceParticulars": [{
                    "packages": "",
                    "date": "",
                    "c/d": "",
                }, {
                    "packages": "",
                    "date": "",
                    "c/d": "",
                }],
                "CIFValues": "",
                "landingCharges": "",
                "B/EValue": "",
                "remarks": ""
            },
            SampleOrderFields: {
                "module": "",
                "action": "",
                "impJobId": "",
                "iOrAFilledOn": "",
                "iOrAFiledNo": "",
                "iOrAFiledDate": "",
                "iOrAFiledAmount": "",
                "iOrAComparedOn": "",
                "samplesCalledOn": "",
                "dockClerkInstrn": "",
                "calledInitial": "",
                "drawnOn": "",
                "calledDelayReason": "",
                "submittedToCustoms": "",
                "customsDelayReason": "",
                "bOrEReceivedOn": "",
                "bOrEReceivedTime": "",
                "bOrERecdInitial": "",
                "origOpenOrderGIvenOn": "",
                "origOpenOrderCmptdOn": "",
                "origOpenOrderDelayReason": "",
                "dupeOpenOrderGIvenOn": "",
                "dupeOpenOrderCmptdOn": "",
                "dupeOpenOrderDelayReason": "",
                "goodClearedDelay": "",
                "remarks": "",
                "goodsClearedno": "",
                "outOfChargeNo": ""
            },
            surveyFields: {
                "module": "",
                "action": "",
                "impJobId": "",
                "sOrAAppliedOn": "",
                "sOrAGrantedOn": "",
                "sOrAHeldOn": "",
                "insAppliedOn": "",
                "insGrantedOn": "",
                "insHeldOn": "",
                "pTAppliedOn": "",
                "pTAGrantedOn": "",
                "pTHeldOn": "",
                "transIndentedOn": "",
                "transIndentedTime": "",
                "transSuppliedOn": "",
                "transSuppliedTime": "",
                "transDeleyReason": "",
                "remarks": ""
            },
            RemarkFields: {
                "Remarks": ""
            },
            PersonnelFields: {
                "module": "",
                "impJobId": "",
                "action": "",
                "Customsclerk": "",
                "jobAlllotedOn": "",
                "docRecord": "",
                "docRecordDate": "",
                "docCalled": "",
                "docCalledDate": "",
                "Rem": "",
                "Recrd": "",
                "BEFieldonManifest": "",
                "G_MNo": "",
                "LineNO": "",
                "LineNoDate": "",
                "BEManifest": "",
                "BEManifestNo": "",
                "BEManifestDate": "",
                "BEAppraising": "",
                "BEAppraisingNo": "",
                "BEAppraisingDate": "",
                "BEApprasingFor": "",
                "BEPutTo": [{
                    "AppraiserOn": "",
                    "returnedOn": "",
                    "returnedFor": ""
                }],
                "calledOn": "",
                "dClerkIntrunOn": "",
                "drawnOn": "",
                "reasonForDelay": "",
                "orderSentTo": "",
                "testReport": "",
                "samplesCollOn": "",
                "givenTo": "",
                "givenOn": "",
                "givenTime": "",
                "testCustomsAccessing": "",
                "testCustomsTo": "",
                "testCustomsReason": ""
            },
            OtherFields: {
                "module": "",
                "action": "",
                "impJobId": "",
                "importerIctNo": "",
                "importerIctRate": "",
                "givenON": "",
                "actualIctNo": "",
                "actualIctRate": "",
                "dutyAmount": "",
                "ReasonNotAdmitImpIct": "",
                "amount": "",
                "leviedOn": "",
                "paidOn": "",
                "penaltyReason": "",
                "licenceSentOn": "",
                "licenceSentTime": "",
                "toAuditOn": "",
                "auditedOn": "",
                "auditedTime": "",
                "auditRecdBackOn": "",
                "auditRecdBackTime": "",
                "dsptdFrBEOn": "",
                "dsptdFrBETime": "",
                "dsptdRecdBackOn": "",
                "dsptdRecdBackTime": "",
                "dsptdRecdBackInitial": "",
                "parcelHandedOn": "",
                "parcelHandedTime": "",
                "parcelHandedInitial": "",
                "detentionCrftNo": "",
                "detentionCrftDate": "",
                "detentionCrftFrom": "",
                "detentionCrftTo": "",
                "dsptdFrJobNo": "",
                "detenAppliedON": "",
                "detenSubmittedon": "",
                "detenReasondelay": "",
                "otherAgents": "",
                "otherCFS": ""
            }
        };
        return obj;
    };

    this.getReceiptObj = function () {
        var obj = {
            'impJobNo': "",
            'date': "",
            'truckNo': "",
            'driverName': "",
            'from': "",
            'to': "",
            'Marks': "",
            'BENO': "",
            'BEDate': "",
            'transporterName': "",
            'importerName': "",
            'importerGst': "",
            'Address': "",
            'type': ""
        };
        return obj;
    };

    return this;
});
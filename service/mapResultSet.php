<?php
//echo "db connected";
class mapResultSet
{
//private $content;
public function mapExportFields($row){
    if($row!=null){
    for($x = 0; $x < count($row); $x++) {
       $docFields = array(
        'impJobId'=>$row[$x]['impJobId'],
         'exportType'=>$row[$x]['type'],
         'importDate'=>$row[$x]['exportDate'],
         'shipper'=>$row[$x]['shipper'],
         'consignee'=>$row[$x]['consignee'],
         'bank'=>$row[$x]['bank'],
    	'bank_notify'=>$row[$x]['bank_notify'],
        'invoiceNo'=>$row[$x]['invoiceNo'],
        'invoiceDate'=>$row[$x]['invoiceDate'],
        'value'=>$row[$x]['invoiceValue'],
        'grNo'=>$row[$x]['grNo'],
        'grDate'=>$row[$x]['grDate'],
        'rbiCode'=>$row[$x]['rbiNo'],
        'billNo'=>$row[$x]['billingNo'],
        'billDate'=>$row[$x]['billingDate'],
        'exchangeRate'=>$row[$x]['exRate'],
        'flight'=>$row[$x]['flight'],
        'arrived'=>$row[$x]['arrived'],
        'departured'=>$row[$x]['departure'],
        'agent'=>$row[$x]['agent'],
        'port'=>$row[$x]['port'],
        'country'=>$row[$x]['country'],
        'emNo'=>$row[$x]['EMNo'],
        'remarks'=>$row[$x]['remarks'],
        'value1'=>$row[$x]['value'],
        'fob'=>$row[$x]['FOB'],
        "frt"=>$row[$x]['FRT'],
        "ins"=>$row[$x]['INS'],
        "cif"=>$row[$x]['CIF'],
        "eaNo"=>$row[$x]['EANO'],
        "lcNo"=>$row[$x]['lcNo'],
        "lcDate"=>$row[$x]['lcDate'],
        "orderNo"=>$row[$x]['orderNo'],
        "receiptNo"=>$row[$x]['mateReceipt'],
        "receiptDate1"=>$row[$x]['mateDate1'],
        "receiptDate2"=>$row[$x]['mateDate2'],
        "landingNo"=>$row[$x]['billOfLanding'],
        "billDate1"=>$row[$x]['landingDate1'],
        "billDate2"=>$row[$x]['landingDate2'],
        "prt"=>$row[$x]['blPRT'],
        "exUS"=>$row[$x]['exUS'],
        "exchangeDate"=>$row[$x]['EADATE'],
        "rupees"=>$row[$x]['EARS'],
        "splInstructions"=>$row[$x]['specialInstructions'],
        "awbNo"=>$row[$x]['AWBNo'],
        "mawbDate"=>$row[$x]['MAWBDate'],
        "mblDate"=>$row[$x]['MBLDATE']
        );
        }        
    }else{
        $docFields = null;
    }
return array("docFields"=>$docFields);
}

public function mapReceiptFields($row){
    if($row!=null){
        for($x = 0; $x < count($row); $x++) {
              $receipts[] = array(
                    'id'=>$row[$x]['id'],
                    'impJobId'=>$row[$x]['impJobId'],
                    'type'=>$row[$x]['type'],
                    'date'=>$row[$x]['date'],
                    'truckNo'=>$row[$x]['truckNo'],
                    'driverName'=>$row[$x]['driverName'],
                    'from'=>$row[$x]['from_source'],
                    'to'=>$row[$x]['to_dest'],
                    'Marks'=>$row[$x]['marks'],
                    'BENO'=>$row[$x]['BENO'],
                    'BEDate'=>$row[$x]['BEDate'],
                    'transporterName'=>$row[$x]['transporterName'],
                    'importerGst'=>$row[$x]['importerGst'],                    
                    'importerName'=>$row[$x]['importerName'],                    
                    'Address'=>$row[$x]['address']                    
                );
        }
        return $receipts;
    }
    else {
    return null;
    }
}

public function mapSlipFields($row){
    if($row!=null){
        for($x = 0; $x < count($row); $x++) {
              $receipts[] = array(
                    'id'=>$row[$x]['id'],
                    'impJobId'=>$row[$x]['impJobId'],
                    'type'=>$row[$x]['type'],
                    'date'=>$row[$x]['date'],
                    'particulars'=>$row[$x]['particulars'],
                    'amount'=>$row[$x]['amount'],
                    'status'=>$row[$x]['status']   
                );
        }
        return $receipts;
    }
    else {
    return null;
    }
}
public function mapExportRemarksFields($row){
    if($row!=null){
        for($x = 0; $x < count($row); $x++) {
             $remarkFields[] = array(
                    'impJobId'=>$row[$x]['impJobId'],
                    'progress'=>$row[$x]['procedures'],
                    'cargoReceipts'=>$row[$x]['cargo_receipts'],
                    'exportType'=>$row[$x]['type']
                );
        }
        return $remarkFields;
    }
    else{
        return null;
    }
}
public function mapAirDocFields($row){
    if($row!=null){
            for($x = 0; $x < count($row); $x++) {
        $docFields[] = array(
       'impJobId'=>$row[$x]['impJobId'],
        'importedDate'=>$row[$x]['importedDate'],
        'partyRef'=>$row[$x]['partyRef'],
        'consignee'=>$row[$x]['consignee'], 
        'licenseDetail'=>$row[$x]['licenseDetail'], 
        'buffNo'=>$row[$x]['buffNo'], 
        'address'=>$row[$x]['address'], 
        'hsOrBtAccParty'=>$row[$x]['hsOrBtAccParty'], 
        'supplier'=>$row[$x]['supplier'],
        'invoiceNo'=>$row[$x]['invoiceNo'],
        'invoiceDate'=>$row[$x]['invoiceDate'],
        'flightDtls'=>$row[$x]['flightDtls'], 
        'dueDate'=>$row[$x]['dueDate'],
        'arrival'=>$row[$x]['arrival'],
        'gdd'=>$row[$x]['gdd'], 
        'lfd'=>$row[$x]['lfd'],
        'advisedBy'=>$row[$x]['advisedBy'],
        'advisedOn'=>$row[$x]['advisedOn'], 
        'shed'=>$row[$x]['shed'],
        'warehouse'=>$row[$x]['warehouse'],
        'license'=>$row[$x]['licenseNo'],
        'licenseValue'=>$row[$x]['value'],
        'balance'=>$row[$x]['balance'], 
        'agents'=>$row[$x]['agents'],
        'igmNo'=>$row[$x]['igmNo'],
        'licenseDate'=>$row[$x]['licenseDate'], 
        'mawbNo'=>$row[$x]['mawbNo'], 
        'hawbNo'=>$row[$x]['hawbNo'],
        'hawbDate'=>$row[$x]['hawbDate'],
        'doNo'=>$row[$x]['doNo'],
        'doDate'=>$row[$x]['doDate'], 
        'invoiceValue'=>$row[$x]['invoiceValue'],
        'jobType'=>$row[$x]['jobType']
    );
        }        
    }else{
        $docFields = null;
    }
return array("docFields"=>$docFields);
}
public function groupImportSeaDoc($docFields,$content){
        $docObj = array_merge(
            (array)$docFields,
            (array)$content
        );
        return array("importSeaDoc"=>$docObj);
}
public function groupImportAirDoc($docFields,$content){
        $docObj = array_merge(
            (array)$docFields,
            (array)$content
        );
        return array("importAirDoc"=>$docObj);
}
public function groupExportDoc($docFields,$content){
        $docObj = array_merge(
            (array)$docFields,
            (array)$content
        );
        return array("ExportDoc"=>$docObj);
}
public function mapContents($content){
    if($content!= null){
    for($i =0; $i<count($content);$i++){
        $content1[] = array(
            'contrNos'=>$content[$i]['contrNos'],
            'noOfPkgs'=>$content[$i]['noOfPkgs'],
            'content'=>$content[$i]['content'],
            'measurements'=>$content[$i]['measurements'],
            'grossWeight'=>$content[$i]['grossWeight'],
            'nettWeight'=>$content[$i]['nettWeight']
        );
        }    
    }else{
      $content1= null;
    }
      return array("contents"=>$content1);
}
public function mapDoFields($content){
    if($content!= null){
    for($i =0; $i<count($content);$i++){
        $content1[] = array(
            'impJobId'=>$content[$i]['impJobId'],
            'type'=>$content[$i]['type'],
            'invoiceMode'=>$content[$i]['invoiceMode'],
            'customsClerk'=>$content[$i]['customsClerk'],
            'dockClerk'=>$content[$i]['dockClerk'],
            'tinNO'=>$content[$i]['tinNo'],
            'cstNo'=>$content[$i]['cstNo'],
            'gstNo'=>$content[$i]['gstNo'],
            'stAgentsCharges'=>$content[$i]['stAgentsCharges'],
            'remarks'=>$content[$i]['remarks'],
        );
        }    
    }else{
      $content1= null;
    }
      return array("doObj"=>$content1);
}
public function mapSeaDocFields($row){
for($x = 0; $x < count($row); $x++) {
    $docFields[] = array(
        'impJobId'=>$row[$x]['impJobId'],
        'importedDate'=>$row[$x]['importedDate'],
        'partyRef'=>$row[$x]['partyRef'],
        'consignee'=>$row[$x]['consignee'],
        'address'=>$row[$x]['address'],
        'licenseDetail'=>$row[$x]['licenseDetail'],
        'buffNo'=>$row[$x]['buffNo'],
        'hsOrBtAccParty'=>$row[$x]['hsOrBtAccParty'],
        'supplier'=>$row[$x]['supplier'],
        'invoiceNo'=>$row[$x]['invoiceNo'],
        'invoiceDate'=>$row[$x]['invoiceDate'],
        //'content'=> $content1,
        'motherVsl'=>$row[$x]['motherVsl'],
        'mvdate'=>$row[$x]['mvDue'],
        'arrival'=>$row[$x]['arrival'],
        'gld'=>$row[$x]['GLD'],
        'cntrOut'=>$row[$x]['cntrOut'],
        'feederVsl'=>$row[$x]['feederVsl'],
        'fvOn'=>$row[$x]['fvOn'],
        'CFS'=>$row[$x]['CFS'],
        'agents'=>$row[$x]['agents'],
        'igmNo'=>$row[$x]['igmNo'],
        'licenseDate'=>$row[$x]['licenseDate'],
        'lineNo'=>$row[$x]['lineNo'],
        'hblNo'=>$row[$x]['hblNo'],
        'hblDate'=>$row[$x]['hblDate'],
        'mbl'=>$row[$x]['mbl'],
        'mblDate'=>$row[$x]['mblDate'],
        'invoiceValue'=>$row[$x]['invoiceValue'],
        'jobType'=>$row[$x]['jobType']
    );
}
return array("docFields"=>$docFields);
}

public function mapSampleFields($row){
    if($row!=null){
    for($x = 0; $x < count($row); $x++) {
         $sampleFields[] = array(
        'impJobId'=>$row[$x]['impJobId'],
        'type'=>$row[$x]['type'],
        'iOrAFilledOn'=>$row[$x]['iOrAFilledOn'],
        'iOrAFiledNo'=>$row[$x]['iOrAFiledNo'],
        'iOrAFiledDate'=>$row[$x]['iOrAFiledDate'],
        'iOrAFiledAmount'=>$row[$x]['iOrAFiledAmount'],
        'iOrAComparedOn'=>$row[$x]['iOrAComparedOn'],
        'samplesCalledOn'=>$row[$x]['samplesCalledOn'],
        'dockClerkInstrn'=>$row[$x]['dockClerkInstrn'],
        'calledInitial'=>$row[$x]['calledInitial'],
        'drawnOn'=>$row[$x]['drawnOn'],
        'calledDelayReason'=>$row[$x]['calledDelayReason'],
        'submittedToCustoms'=>$row[$x]['submittedToCustoms'],
        'customsDelayReason'=>$row[$x]['submittedDelayReason'],
        'bOrEReceivedOn'=>$row[$x]['bOrEReceivedOn'],
        'bOrEReceivedTime'=>$row[$x]['bOrEReceivedTime'],
        'bOrERecdInitial'=>$row[$x]['bOrERecdInitial'],
        'origOpenOrderGIvenOn'=>$row[$x]['origOpenOrderGIvenOn'],
        'origOpenOrderCmptdOn'=>$row[$x]['origOpenOrderCmptdOn'],
        'origOpenOrderDelayReason'=>$row[$x]['origOpenOrderDelayReason'],
        'dupeOpenOrderGIvenOn'=>$row[$x]['dupeOpenOrderGIvenOn'],
        'dupeOpenOrderCmptdOn'=>$row[$x]['dupeOpenOrderCmptdOn'],
        'dupeOpenOrderDelayReason'=>$row[$x]['dupeOpenOrderDelayReason'],
        'customsChargeon'=>$row[$x]['customsChargeon'],
        'goodsClearedno'=>$row[$x]['goodsClearedno'],
        'goodClearedDelay'=>$row[$x]['goodClearedDelay'],
        'remarks'=>$row[$x]['remarks']
    );
    }
    return $sampleFields;
    }else{
        return null;
    }
}

public function mapFeedbackFields($content){
      if($content!= null){
    for($i =0; $i<count($content);$i++){
        $content1[] = array(
            'impJobId'=>$content[$i]['impJobId'],
            'type'=>$content[$i]['type'],
            'yardName'=>$content[$i]['yardName'],
            'yardAddress'=>$content[$i]['yardAddress'],
            'containerType'=>$content[$i]['containerType'],
            'noOfContainer'=>$content[$i]['noOfContainer'],
            'emptyPlot'=>$content[$i]['emptyPlot'],
            'offLoadDate'=>$content[$i]['offLoadDate'],
            'containerDamage'=>$content[$i]['containerDamage'],
            'stAgentStatus'=>$content[$i]['stAgentStatus'],
            'billingStatus'=>$content[$i]['billingStatus'],
        );
        }    
    }else{
      $content1= null;
    }
      return array("feedback"=>$content1);
}

public function mapTransportFields($content){
      if($content!= null){
    for($i =0; $i<count($content);$i++){
        $content1[] = array(
            'impJobId'=>$content[$i]['impJobId'],
            'type'=>$content[$i]['type'],
            'gcNoteNo'=>$content[$i]['gcNoteNo'],
            'clearanceParticulars'=>$content[$i]['clearanceParticulars'],
            'transportedGCNote'=>$content[$i]['transportedGCNote'],
            'transIndentedOn'=>$content[$i]['transIndentedOn'],
            'transIndentedTime'=>$content[$i]['transIndentedTime'],
            'transSuppliedOn'=>$content[$i]['transSuppliedOn'],
            'transSuppliedTime'=>$content[$i]['transSuppliedTime'],
            'transDelayReason'=>$content[$i]['transDelayReason'],
            'remarks'=>$content[$i]['remarks'],
        );
        }    
    }else{
      $content1= null;
    }
      return array("transport"=>$content1);
}

public function groupOperationsObj($sample,$survey){
    $operationsObj = array(
        'sample'=>$sample,
        'survey'=>$survey
    );
  return $operationsObj;
}

public function groupCustomsObj($personnelObj,$personnelsample,$beObj,$licenseObj,$penality,$ictObj,$clearance){
        $customObj = array(
            'personnel'=>$personnelObj,
            'personnelSample'=>$personnelsample,
            'beObj'=>$beObj,
            'license'=>$licenseObj,
            'penality'=>$penality,
            'ict'=>$ictObj,
            'clearance'=> $clearance
        );
        return array("customObj"=>$customObj);
}

public function mapSurveyFields($row){
    if($row!=null){
        for($x = 0; $x < count($row); $x++) {
         $surveyFields[] = array(
            'impJobId'=>$row[$x]['impJobId'],
            'type'=>$row[$x]['type'],
            'sOrAAppliedOn'=>$row[$x]['sOrAAppliedOn'],
            'sOrAGrantedOn'=>$row[$x]['sOrAGrantedOn'],
            'sOrAHeldOn'=>$row[$x]['sOrAHeldOn'],
            'insAppliedOn'=>$row[$x]['insAppliedOn'],
            'insGrantedOn'=>$row[$x]['insGrantedOn'],
            'insHeldOn'=>$row[$x]['insHeldOn'],
            'pTAppliedOn'=>$row[$x]['pTAppliedOn'], 
            'pTAGrantedOn'=>$row[$x]['pTAGrantedOn'],
            'pTHeldOn'=>$row[$x]['pTHeldOn']
        );
    }
    return $surveyFields;
    }else{
        return null;
    }
}

public function mapPersonnelFields($row){
    if($row!=null){
        for($x = 0; $x < count($row); $x++) {
         $personnelFields = array(
            'impJobId'=>$row[$x]['impJobId'],
            'type'=>$row[$x]['type'],
            'customsClerk'=>$row[$x]['customsClerk'],
            'jobAllotedOn'=>$row[$x]['jobAllotedOn'],
            'docRecord'=>$row[$x]['documentsRecd'],
            'docRecordDate'=>$row[$x]['documentsRecdDate'], 
            'docCalled'=>$row[$x]['documentdCalled'],
            'docCalledDate'=>$row[$x]['documentdDate'],
            'Rem'=>$row[$x]['rem'],
            'Recrd'=>$row[$x]['received'],
            'recdtxtarea'=>$row[$x]['recdtxtarea'],
            'BEFieldonManifest'=>$row[$x]['BEFieldonManifest'],
            'G_MNo'=>$row[$x]['G_MNo'],
            'LineNO'=>$row[$x]['LineNO'],
            'LineNoDate'=>$row[$x]['LineNoDate'],
            'BEManifestedon'=>$row[$x]['BEManifestedon'],
            'BEManifestNo'=>$row[$x]['BEManifestNo'],
            'BEManifestDate'=>$row[$x]['BEManifestDate']

        );
    }
        return $personnelFields;
    }else{
        return null;
    }
}
public function mapPerSampleFields($row){
    if($row!=null){
        for($x = 0; $x < count($row); $x++) {
         $perSampleFields = array(
            // 'impJobId'=>$row[$x]['impJobId'],
            //'type'=>$row[$x]['type'],
            'calledOn'=>$row[$x]['calledOn'],
            'dClerkIntrunOn'=>$row[$x]['dockClerkInstrnOn'], 
            'drawnOn'=>$row[$x]['drawnOn'],
            'reasonForDelay'=>$row[$x]['reasonForDelay'], 
            'orderSentTo'=>$row[$x]['orderSentToGroupOn'], 
            'testReport'=>$row[$x]['testReportRecdOn'], 
            'samplesCollOn'=>$row[$x]['samplesCollectedOn'], 
            'givenTo'=>$row[$x]['givenTo'], 
            'givenOn'=>$row[$x]['givenOn'], 
            'givenTime'=>$row[$x]['givenTime'], 
            'testCustomsAccessing'=>$row[$x]['testcustomsAssDelayFrom'],
            'testCustomsTo'=>$row[$x]['testcustomsAssDelayTo'], 
            'testCustomsReason'=>$row[$x]['reason']
        );
    }
        return $perSampleFields;
    }else{
        return null;
    }
}
public function mapBeFields($row){
    if($row!=null){
        for($x = 0; $x < count($row); $x++) {
         $BEFields = array(
            //'impJobId'=>$row[$x]['impJobId'],
            //'type'=>$row[$x]['type'],
            'BEAppraising'=>$row[$x]['bOrEFilledAppDeptOn'],
            'BEAppraisingNo'=>$row[$x]['bOrEGroupNo'],
            'BEAppraisingDate'=>$row[$x]['bOrERetrnOn'],
            'BEApprasingFor'=>$row[$x]['bOrEFor'], 
            'bOrEPutupAppOn'=>$row[$x]['bOrEPutupAppOn'],
            'bOrEPutupAppRetrnOn'=>$row[$x]['bOrEPutupAppRetrnOn'], 
            'bOrEPutupAppFor'=>$row[$x]['bOrEPutupAppFor']
        );
    }
        return $BEFields;
    }else{
        return null;
    }
}
public function groupPersonnelObj($personnel,$sample,$be){
        $personnelFieldsObj = array_merge(
            $personnel,
            $sample,
            $be
        );
        return array("personnelFields"=>$personnelFieldsObj);
}

public function mapICTFields($row){
    if($row!=null){
        for($i = 0; $i < count($row); $i++) {
         $ICTFields = array(
            'impJobId'=>$row[$i]['impJobId'],  
            'type'=>$row[$i]['type'], 
            'importerIctNo'=>$row[$i]['importerIctNo'], 
            'importerIctRate'=>$row[$i]['importerIctRate'], 
            'givenON'=>$row[$i]['givenON'],
            'actualIctNo'=>$row[$i]['actualIctNo'],
            'actualIctRate'=>$row[$i]['actualIctRate'],
            'dutyAmount'=>$row[$i]['dutyAmount'], 
            'ReasonNotAdmitImpIct'=>$row[$i]['ReasonNotAdmitImpIct']
        );
    }
        return $ICTFields;
    }else{
        return null;
    }
}
public function mapPenalityFields($row){
    if($row!=null){
        for($i = 0; $i < count($row); $i++) {
         $PenalityFields = array(
            //'impJobId'=>$row[$i]['impJobId'],
            //'type'=>$row[$i]['type'], 
            'amount'=>$row[$i]['amount'], 
            'leviedOn'=>$row[$i]['leviedOn'],
            'paidOn'=>$row[$i]['paidOn'],
            'penaltyReason'=>$row[$i]['penaltyReason']
        );
    }
        return $PenalityFields;
    }else{
        return null;
    }
}
public function mapLicenseFields($row){
    if($row!=null){
        for($i = 0; $i < count($row); $i++) {
         $LicenseFields = array(
              //'impJobId'=>$row[$i]['impJobId'],
                //'type'=>$row[$i]['type'],
                'licenceSentOn'=>$row[$i]['licenceSentOn'], 
                'licenceSentTime'=>$row[$i]['licenceSentTime'], 
                'toAuditOn'=>$row[$i]['toAuditOn'],
                'auditedOn'=>$row[$i]['auditedOn'], 
                'auditedTime'=>$row[$i]['auditedTime'], 
                'auditRecdBackOn'=>$row[$i]['auditRecdBackOn'],
                'auditRecdBackTime'=>$row[$i]['auditRecdBackTime'],
                'dsptdFrBEOn'=>$row[$i]['dsptdFrBEOn'],
                'dsptdFrBETime'=>$row[$i]['dsptdFrBETime'],
                'dsptdRecdBackOn'=>$row[$i]['dsptdRecdBackOn'],
                'dsptdRecdBackTime'=>$row[$i]['dsptdRecdBackTime'],
                'dsptdRecdBackInitial'=>$row[$i]['dsptdRecdBackInitial'],
                'parcelHandedOn'=>$row[$i]['parcelHandedOn'],
                'parcelHandedTime'=>$row[$i]['parcelHandedTime'], 
                'parcelHandedInitial'=>$row[$i]['parcelHandedInitial'], 
                'detentionCrftNo'=>$row[$i]['detentionCrftNo'], 
                'detentionCrftDate'=>$row[$i]['detentionCrftDate'], 
                'detentionCrftFrom'=>$row[$i]['detentionCrftFrom'], 
                'detentionCrftTo'=>$row[$i]['detentionCrftTo'],
                'detenSubmittedon'=>$row[$i]['detenSubmittedon'],
                'detenAppliedON'=>$row[$i]['detenAppliedON'],
                'detenReasondelay'=>$row[$i]['detenReasondelay'],
                'otherAgents'=>$row[$i]['otherAgents'],
                'otherCFS'=>$row[$i]['otherCFS'],
                'dsptdFrJobNo'=>$row[$i]['dsptdFrJobNo']
        );
    }
        return $LicenseFields;
    }else{
        return null;
    }
}

public function groupOthersObj($ict,$penality,$license){
        $OtherFieldsObj = array_merge(
            $ict,
            $penality,
            $license
        );
        return array('otherFields'=>$OtherFieldsObj);
}

public function mapClearanceFields($row){
 if($row!=null){
for($x = 0; $x < count($row); $x++) {
    $clearanceFields[] = array(
        'impJobId'=>$row[$x]['impJobId'],
        'CIFValues'=>$row[$x]['CIFValues'],
        'landingCharges'=>$row[$x]['landingCharges'],
        'BEValue'=>$row[$x]['BEValue'],
        'remarks'=>$row[$x]['remarks'],
        //'particulars'=>$particulars1,
        'transpoterGcNoteNo'=>$row[$x]['transpoterGcNoteNo'],
        'gcNoteNo'=>$row[$x]['gcNoteNo'],
        'bOrEDetail'=>$row[$x]['bOrEDetail'],
        'iceGateJobNo'=>$row[$x]['iceGateJobNo'],
    );
}
}else{
    $clearanceFields = null;
}
return array("clearanceFields"=>$clearanceFields);
}

}
?>
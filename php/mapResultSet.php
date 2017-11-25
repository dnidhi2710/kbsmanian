<?php
//echo "db connected";
class mapResultSet
{
//private $content;

public function mapAirDocFields($row,$content){
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
    $content1 =null;
    }
    for($x = 0; $x < count($row); $x++) {
        $docFields[] = array(
       'impJobId'=>$row[$x]['impJobId'],
        'importedDate'=>$row[$x]['importedDate'],
        'partyRef'=>$row[$x]['partyRef'],
        'consignee'=>$row[$x]['consignee'], 
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
        'licenseNo'=>$row[$x]['licenseNo'],
        'value'=>$row[$x]['value'],
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
        'customsClerk'=>$row[$x]['customsClerk'],
        'dockClerk'=>$row[$x]['dockClerk'],
        'tinNo'=>$row[$x]['tinNo'],
        'cstNo'=>$row[$x]['cstNo'],
        'gstNo'=>$row[$x]['gstNo'], 
        'landingCharges'=>$row[$x]['landingCharges'],
        'bOrEValue'=>$row[$x]['bOrEValue'], 
        'stAgentsCharges'=>$row[$x]['stAgentsCharges'], 
        'remarks'=>$row[$x]['remarks']
    );
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
public function mapSeaDocFields($row){
for($x = 0; $x < count($row); $x++) {
    $docFields[] = array(
        'impJobId'=>$row[$x]['impJobId'],
        'importedDate'=>$row[$x]['importedDate'],
        'partyRef'=>$row[$x]['partyRef'],
        'consignee'=>$row[$x]['consignee'],
        'address'=>$row[$x]['address'],
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
        'invoiceMode'=>$row[$x]['invoiceMode'],
        'customsClerk'=>$row[$x]['customsClerk'],
        'dockClerk'=>$row[$x]['dockClerk'],
        'tinNo'=>$row[$x]['tinNo'],
        'cstNo'=>$row[$x]['cstNo'],
        'gstNo'=>$row[$x]['gstNo'],
        'stAgentsCharges'=>$row[$x]['stAgentsCharges'],
        'remarks'=>$row[$x]['remarks'],
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
        'bOrEReceivedOn'=>$row[$x]['bOrEReceivedOn'],
        'bOrEReceivedTime'=>$row[$x]['bOrEReceivedTime'],
        'bOrERecdInitial'=>$row[$x]['bOrERecdInitial'],
        'origOpenOrderGIvenOn'=>$row[$x]['origOpenOrderGIvenOn'],
        'origOpenOrderCmptdOn'=>$row[$x]['origOpenOrderCmptdOn'],
        'origOpenOrderDelayReason'=>$row[$x]['origOpenOrderDelayReason'],
        'dupeOpenOrderGIvenOn'=>$row[$x]['dupeOpenOrderGIvenOn'],
        'dupeOpenOrderCmptdOn'=>$row[$x]['dupeOpenOrderCmptdOn'],
        'dupeOpenOrderDelayReason'=>$row[$x]['dupeOpenOrderDelayReason']
    );
    }
    return array("sampleFields"=>$sampleFields);
    }else{
        return array("sampleFields"=>null);
    }
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
            'pTHeldOn'=>$row[$x]['pTHeldOn'],
            'transIndentedOn'=>$row[$x]['transIndentedOn'],
            'transIndentedTime'=>$row[$x]['transIndentedTime'],
            'transSuppliedOn'=>$row[$x]['transSuppliedOn'],
            'transSuppliedTime'=>$row[$x]['transSuppliedTime'],
            'transDeleyReason'=>$row[$x]['transDeleyReason']
        );
    }
    return array("surveyFields"=>$surveyFields);
    }else{
        return array("surveyFields"=>null);
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
            'documentsRecd'=>$row[$x]['documentsRecd'],
            'documentsRecdDate'=>$row[$x]['documentsRecdDate'], 
            'documentdCalled'=>$row[$x]['documentdCalled'],
            'documentdDate'=>$row[$x]['documentdDate'],
            'rem'=>$row[$x]['rem'],
            'received'=>$row[$x]['received']

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
            'dockClerkInstrnOn'=>$row[$x]['dockClerkInstrnOn'], 
            'drawnOn'=>$row[$x]['drawnOn'],
            'reasonForDelay'=>$row[$x]['reasonForDelay'], 
            'orderSentToGroupOn'=>$row[$x]['orderSentToGroupOn'], 
            'testReportRecdOn'=>$row[$x]['testReportRecdOn'], 
            'samplesCollectedOn'=>$row[$x]['samplesCollectedOn'], 
            'givenTo'=>$row[$x]['givenTo'], 
            'givenOn'=>$row[$x]['givenOn'], 
            'givenTime'=>$row[$x]['givenTime'], 
            'testcustomsAssDelayFrom'=>$row[$x]['testcustomsAssDelayFrom'],
            'testcustomsAssDelayTo'=>$row[$x]['testcustomsAssDelayTo'], 
            'reason'=>$row[$x]['reason']
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
            'bOrEFilledAppDeptOn'=>$row[$x]['bOrEFilledAppDeptOn'],
            'bOrEGroupNo'=>$row[$x]['bOrEGroupNo'],
            'bOrERetrnOn'=>$row[$x]['bOrERetrnOn'],
            'bOrEFor'=>$row[$x]['bOrEFor'], 
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
                'detentionCrftTo'=>$row[$i]['detentionCrftTo']
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

public function mapClearanceFields($row,$particulars){
    if($particulars!= null){
    for($i =0; $i<count($particulars);$i++){
        $particulars1[] = array(
            'pkgs'=>$particulars[$i]['pkgs'],
            'clearanceDate'=>$particulars[$i]['clearanceDate'],
            'clearedOrDelivered'=>$particulars[$i]['clearedOrDelivered'],
        );
    }    
}else{
    $particulars1 =null;
}
for($x = 0; $x < count($row); $x++) {
    $clearanceFields[] = array(
        'impJobId'=>$row[$x]['impJobId'],
        'CIFValues'=>$row[$x]['CIFValues'],
        'landingCharges'=>$row[$x]['landingCharges'],
        'BEValue'=>$row[$x]['BEValue'],
        'remarks'=>$row[$x]['remarks'],
        'particulars'=>$particulars1,
        'transpoterGcNoteNo'=>$row[$x]['transpoterGcNoteNo'],
        'gcNoteNo'=>$row[$x]['gcNoteNo'],
        'bOrEDetail'=>$row[$x]['bOrEDetail'],
        'iceGateJobNo'=>$row[$x]['iceGateJobNo'],
    );
}
return array("clearanceFields"=>$clearanceFields);
}

}
?>
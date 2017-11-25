<?php 

require('../dbconfig.php'); 
require('../dbwrapper_mysqli.php');
require('../formwrapper.php');
require('../mapResultSet.php');
//require('../map.php');

define('PAR_DEFAULT_STATUS','submitted');
define('GRN_DEFAULT_STATUS','created');
define('PDR_DEFAULT_STATUS','submitted');
$db = new DBWrapper($dbc);
$form = new FormWrapper();
$finaloutput = array();
$json = file_get_contents('php://input');
$request = json_decode($json,true);
//$module = $request['module'];
//The following section needs to be altered if you are sending full JSON, action is important for hitting the right switch case and subsequent mapping function
$action =$request['action'];
//if(!$_POST) {
//	$action = $_GET['action'];
//}
//else {
//	$action = $_POST['action'];
//}
switch($action){
    case 'create_customs_section':
        $finaloutput = create_customs_section();
    break;
    case 'view_customs_section':
        $finaloutput = view_customs_section();
    break;
    case 'update_customs_section':
        $finaloutput = update_customs_section();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);


function create_customs_section() {
    global $db,$form,$request;
    $output = array();

    //formelementsarray key value should be, key = form element name, value = db column name
    $formClearanceArray = array('impJobId'=>"impJobId", 'type'=>"type",'iceGateJobNo'=>"iceGateJobNo",'bOrEDetail'=>"bOrEDetail",'CIFValues'=>"CIFValues",'landingCharges'=>"landingCharges",'BEValue'=>"BEValue");
    $formPersonnelArray= array('impJobId'=>"impJobId",'type'=>"type",'customsClerk'=>"customsClerk",'jobAllotedOn'=>"jobAllotedOn",'docRecord'=>"documentsRecd",'docRecordDate'=>"documentsRecdDate",'docCalled'=>"documentdCalled",'docCalledDate'=>"documentdDate",'Rem'=>"rem",'Recrd'=>"received",'recdtxtarea'=>"recdtxtarea",'BEFieldonManifest'=>"BEFieldonManifest",'G_MNo'=>"G_MNo",'LineNO'=>"LineNO",'LineNoDate'=>"LineNoDate",'BEManifestedon'=>"BEManifestedon",'BEManifestNo'=>"BEManifestNo",'BEManifestDate'=>"BEManifestDate");
    $formPersonnelBe = array('impJobId'=>"impJobId",'type'=>"type",'BEAppraising'=>"bOrEFilledAppDeptOn",'BEAppraisingNo'=>"bOrEGroupNo",'BEAppraisingDate'=>"bOrERetrnOn",'BEApprasingFor'=>"bOrEFor",'bOrEPutupAppOn'=>"bOrEPutupAppOn",'bOrEPutupAppRetrnOn'=>"bOrEPutupAppRetrnOn",'bOrEPutupAppFor'=>"bOrEPutupAppFor");
    $formPersonnelSample=array('impJobId'=>"impJobId",'type'=>"type",'calledOn'=>"calledOn",'dClerkIntrunOn'=>"dockClerkInstrnOn",'drawnOn'=>"drawnOn",'reasonForDelay'=>"reasonForDelay",'orderSentTo'=>"orderSentToGroupOn",'testReport'=>"testReportRecdOn",'samplesCollOn'=>"samplesCollectedOn",'givenTo'=>"givenTo",'givenOn'=>"givenOn",'givenTime'=>"givenTime",'testCustomsAccessing'=>"testcustomsAssDelayFrom",'testCustomsTo'=>"testcustomsAssDelayTo",'testCustomsReason'=>"reason");
    $formOtherICT=array('impJobId'=>"impJobId",'type'=>"type",'importerIctNo'=>"importerIctNo",'importerIctRate'=>"importerIctRate",'givenON'=>"givenON",'actualIctNo'=>"actualIctNo",'actualIctRate'=>"actualIctRate",'dutyAmount'=>"dutyAmount",'ReasonNotAdmitImpIct'=>"ReasonNotAdmitImpIct");
    $formOtherPenalty=array('impJobId'=>"impJobId",'type'=>"type",'amount'=>"amount",'leviedOn'=>"leviedOn",'paidOn'=>"paidOn",'penaltyReason'=>"penaltyReason");
    $formOtherLicense =array('impJobId'=>"impJobId",'type'=>"type",'licenceSentOn'=>"licenceSentOn",'licenceSentTime'=>"licenceSentTime",'toAuditOn'=>"toAuditOn",'auditedOn'=>"auditedOn",'auditedTime'=>"auditedTime",'auditRecdBackOn'=>"auditRecdBackOn",'auditRecdBackTime'=>"auditRecdBackTime",'dsptdFrBEOn'=>"dsptdFrBEOn",'dsptdFrBETime'=>"dsptdFrBETime",'dsptdRecdBackOn'=>"dsptdRecdBackOn",'dsptdRecdBackTime'=>"dsptdRecdBackTime",'dsptdRecdBackInitial'=>"dsptdRecdBackInitial",'parcelHandedOn'=>"parcelHandedOn",'parcelHandedTime'=>"parcelHandedTime",'parcelHandedInitial'=>"parcelHandedInitial",'detentionCrftNo'=>"detentionCrftNo",'detentionCrftDate'=>"detentionCrftDate",'detentionCrftFrom'=>"detentionCrftFrom",'detentionCrftTo'=>"detentionCrftTo",'detenSubmittedon'=>"detenSubmittedon",'detenAppliedON'=>"detenAppliedON",'detenReasondelay'=>"detenReasondelay",'otherAgents'=>"otherAgents",'otherCFS'=>"otherCFS",'dsptdFrJobNo'=>"dsptdFrJobNo");

    $clearanceArray = $form->getFormValuesFromJSON($formClearanceArray,$request);
    $personnelArray = $form->getFormValuesFromJSON($formPersonnelArray,$request);
    $personnelBEArray = $form->getFormValuesFromJSON($formPersonnelBe,$request);
    $personnelSample = $form->getFormValuesFromJSON($formPersonnelSample,$request);
    $otherICTArray = $form->getFormValuesFromJSON($formOtherICT,$request);
    $otherPenaltyArray = $form->getFormValuesFromJSON($formOtherPenalty,$request);
    $otherLicenseArray = $form->getFormValuesFromJSON($formOtherLicense,$request);
    //custom add other fields if required
   // $array1['par_status'] = PAR_DEFAULT_STATUS;
    //uncomment the below line to see how the data is formed in real-time
	file_put_contents("./formlog.log", print_r( $clearanceArray, true ), FILE_APPEND | LOCK_EX);
    //Usage of insertOperation from db wrapper, first param is DB table name, second is the key value array created using FormWrapper, 
    //u can send custom array, key = db table column name, value = the actual form value that needs to be inserted
    $dbresult1 = $db->insertOperation('import_map_clearance',$clearanceArray);

    if($dbresult1['status']=='success'){
          $dbresult2 = $db->insertOperation('import_map_personnel',$personnelArray);
          if($dbresult2['status']=='success'){
                $dbresult3 = $db->insertOperation('import_map_be',$personnelBEArray);
              if($dbresult3['status']=='success'){
                    $dbresult4 = $db->insertOperation('import_map_personnel_sample',$personnelSample);
                    if($dbresult4['status']=='success'){
                        $dbresult5 = $db->insertOperation('import_map_ict',$otherICTArray);
                         if($dbresult5['status']=='success'){
                             $dbresult6 = $db->insertOperation('import_map_penalty',$otherPenaltyArray);
                             if($dbresult6['status']=='success'){
                                  $dbresult7 = $db->insertOperation('import_map_licence',$otherLicenseArray);
                                  if($dbresult7['status']=='success'){
                                     $output = array("infocode" => "CREATECUSTOMSSUCCESS", "message" => "Customs created successfully");         
                                  }else{
                                    $output = array("infocode" => "CREATECUSTOMSFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details'],"table"=>'licencetable');
                                  }
                             }else{
                                    $output = array("infocode" => "CREATECUSTOMSFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details'],"table"=>'penaltytable');
                             }
                         }else{
                             $output = array("infocode" => "CREATECUSTOMSFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details'],"table"=>'ict');
                         }
                    }else{
                         $output = array("infocode" => "CREATECUSTOMSFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details'],"table"=>'personnel sample');
                    }
                 }else{
                         $output = array("infocode" => "CREATECUSTOMSFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details'],"table"=>'betable');
                }
             }else{
                    $output = array("infocode" => "CREATECUSTOMSFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details'],"table"=>'personnel');
             }
    }else{
             $output = array("infocode" => "CREATECUSTOMSFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details'],"table"=>'clearance');
    }
    return $output;
}


 function view_customs_section(){
		global $db,$request;
	//	$db = new Dbclass;
		$map = new mapResultSet;
        $selectClearance = "SELECT * from import_map_clearance WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."'  ";
		if($db->getResults($selectClearance)){
            	$clearance = $map->mapClearanceFields($db->getResults($selectClearance));	
        }else{
            	$clearance = $map->mapClearanceFields(null);	
        }

        $select = "SELECT * from import_map_personnel WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."' ";
		if($db->getResults($select)){
			$personnelObj = $map->mapPersonnelFields($db->getResults($select));
		}else{
			$personnelObj = null;
		}
		$selectPerSample = "SELECT * FROM import_map_personnel_sample WHERE impJobId ='".$request['id']."' and type =  '".$request['type']."' ";
				if($db->getResults($selectPerSample)){
					$personnelsample = $map->mapPerSampleFields($db->getResults($selectPerSample));
				}else{
					$personnelsample = null;
				}
		$selectbe = "SELECT * from import_map_be WHERE impJobId = '".$request['id']."' and type =  '".$request['type']."' ";
			if($db->getResults($selectbe)){
				$beObj = $map->mapBeFields($db->getResults($selectbe));
			}else{
				$beObj = null;		
			}

        $selectICT = "SELECT * from import_map_ict WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."' ";
		if($db->getResults($selectICT)){
			$ictObj = $map->mapICTFields($db->getResults($selectICT));
		}else{
			$ictObj = null;
		}
		$selectPerSample = "SELECT * FROM import_map_penalty WHERE impJobId ='".$request['id']."' and type =  '".$request['type']."' ";
				if($db->getResults($selectPerSample)){
					$penality = $map->mapPenalityFields($db->getResults($selectPerSample));
				}else{
					$penality = null;
				}
		$selectlicence = "SELECT * from import_map_licence WHERE impJobId = '".$request['id']."' and type =  '".$request['type']."' ";
			if($db->getResults($selectlicence)){
				$licenseObj = $map->mapLicenseFields($db->getResults($selectlicence));
			}else{
				$licenseObj = null;		
			}

		if($personnelObj!=null || $personnelsample!=null || $beObj!=null || $licenseObj!= null || $penality!=null || $ictObj!=null || $clearance['clearanceFields']!=null ){
			$customsObj = $map->groupCustomsObj($personnelObj,$personnelsample,$beObj,$licenseObj,$penality,$ictObj,$clearance);
		    $output =  array('status'=>'success','data'=>$customsObj);
        }else{
            $error = $db->getError();
			$output = array('status'=>'failed','msg'=>$error);	
		}
        return $output;
	}


function update_customs_section(){
	global $db,$form,$request;
		//$sac_id = $_POST['sac_id'];
	$formClearanceArray = array('iceGateJobNo'=>"iceGateJobNo",'bOrEDetail'=>"bOrEDetail",'CIFValues'=>"CIFValues",'landingCharges'=>"landingCharges",'BEValue'=>"BEValue");
   	$formPersonnelArray= array('customsClerk'=>"customsClerk",'jobAllotedOn'=>"jobAllotedOn",'docRecord'=>"documentsRecd",'docRecordDate'=>"documentsRecdDate",'docCalled'=>"documentdCalled",'docCalledDate'=>"documentdDate",'Rem'=>"rem",'Recrd'=>"received",'recdtxtarea'=>"recdtxtarea",'BEFieldonManifest'=>"BEFieldonManifest",'G_MNo'=>"G_MNo",'LineNO'=>"LineNO",'LineNoDate'=>"LineNoDate",'BEManifestedon'=>"BEManifestedon",'BEManifestNo'=>"BEManifestNo",'BEManifestDate'=>"BEManifestDate");
    $formPersonnelBe = array('BEAppraising'=>"bOrEFilledAppDeptOn",'BEAppraisingNo'=>"bOrEGroupNo",'BEAppraisingDate'=>"bOrERetrnOn",'BEApprasingFor'=>"bOrEFor",'bOrEPutupAppOn'=>"bOrEPutupAppOn",'bOrEPutupAppRetrnOn'=>"bOrEPutupAppRetrnOn",'bOrEPutupAppFor'=>"bOrEPutupAppFor");
    $formPersonnelSample=array('calledOn'=>"calledOn",'dClerkIntrunOn'=>"dockClerkInstrnOn",'drawnOn'=>"drawnOn",'reasonForDelay'=>"reasonForDelay",'orderSentTo'=>"orderSentToGroupOn",'testReport'=>"testReportRecdOn",'samplesCollOn'=>"samplesCollectedOn",'givenTo'=>"givenTo",'givenOn'=>"givenOn",'givenTime'=>"givenTime",'testCustomsAccessing'=>"testcustomsAssDelayFrom",'testCustomsTo'=>"testcustomsAssDelayTo",'testCustomsReason'=>"reason");
    $formOtherICT=array('importerIctNo'=>"importerIctNo",'importerIctRate'=>"importerIctRate",'givenON'=>"givenON",'actualIctNo'=>"actualIctNo",'actualIctRate'=>"actualIctRate",'dutyAmount'=>"dutyAmount",'ReasonNotAdmitImpIct'=>"ReasonNotAdmitImpIct");
    $formOtherPenalty=array('amount'=>"amount",'leviedOn'=>"leviedOn",'paidOn'=>"paidOn",'penaltyReason'=>"penaltyReason");
    $formOtherLicense =array('licenceSentOn'=>"licenceSentOn",'licenceSentTime'=>"licenceSentTime",'toAuditOn'=>"toAuditOn",'auditedOn'=>"auditedOn",'auditedTime'=>"auditedTime",'auditRecdBackOn'=>"auditRecdBackOn",'auditRecdBackTime'=>"auditRecdBackTime",'dsptdFrBEOn'=>"dsptdFrBEOn",'dsptdFrBETime'=>"dsptdFrBETime",'dsptdRecdBackOn'=>"dsptdRecdBackOn",'dsptdRecdBackTime'=>"dsptdRecdBackTime",'dsptdRecdBackInitial'=>"dsptdRecdBackInitial",'parcelHandedOn'=>"parcelHandedOn",'parcelHandedTime'=>"parcelHandedTime",'parcelHandedInitial'=>"parcelHandedInitial",'detentionCrftNo'=>"detentionCrftNo",'detentionCrftDate'=>"detentionCrftDate",'detentionCrftFrom'=>"detentionCrftFrom",'detentionCrftTo'=>"detentionCrftTo",'detenSubmittedon'=>"detenSubmittedon",'detenAppliedON'=>"detenAppliedON",'detenReasondelay'=>"detenReasondelay",'otherAgents'=>"otherAgents",'otherCFS'=>"otherCFS",'dsptdFrJobNo'=>"dsptdFrJobNo");

    $clearanceArray = $form->getFormValuesFromJSON($formClearanceArray,$request);
    $personnelArray = $form->getFormValuesFromJSON($formPersonnelArray,$request);
    $personnelBEArray = $form->getFormValuesFromJSON($formPersonnelBe,$request);
    $personnelSample = $form->getFormValuesFromJSON($formPersonnelSample,$request);
    $otherICTArray = $form->getFormValuesFromJSON($formOtherICT,$request);
    $otherPenaltyArray = $form->getFormValuesFromJSON($formOtherPenalty,$request);
    $otherLicenseArray = $form->getFormValuesFromJSON($formOtherLicense,$request);
		$wherearray = array('impJobId'=>$request['impJobId'],'type'=>$request['type']);
   		//array('condition'=>'impJobId = :impJobId', 'param'=>':impJobId', 'value'=>$request['impJobId']);
	   $dbResult1 = $db->updateOperation('import_map_clearance',$clearanceArray,$wherearray);
	    if($dbResult1['status']=='success'){
			 $dbResult2 = $db->updateOperation('import_map_personnel',$personnelArray,$wherearray);
			if($dbResult2['status']=='success'){
				$dbResult3 = $db->updateOperation('import_map_be',$personnelBEArray,$wherearray);
				if($dbResult3['status']=='success'){
					 $dbResult4 = $db->updateOperation('import_map_personnel_sample',$personnelSample,$wherearray);
					 if($dbResult4['status']=='success'){
   						$dbResult5 = $db->updateOperation('import_map_ict',$otherICTArray,$wherearray);
						   if($dbResult5['status']=='success'){
   								 $dbResult6 = $db->updateOperation('import_map_penalty',$otherPenaltyArray,$wherearray);
									if($dbResult6['status']=='success'){
										 	 $dbResult7 = $db->updateOperation('import_map_licence',$otherLicenseArray,$wherearray);	  
											if($dbResult7['status']=='success'){
												$output = array('infocode'=>'UPDATECUSTOMSSUCCESS','message'=>'Update Successfull');
											}else{
												$output = array('infocode'=>'UPDATECUSTOMSFAILED','message'=>'An Error Occurred while updating the section.','table'=>'license','error_details'=>$dbResult7['error_details']);
											}
									}else{
										$output = array('infocode'=>'UPDATECUSTOMSFAILED','message'=>'An Error Occurred while updating the section.','table'=>'penality','error_details'=>$dbResult6['error_details']);
									}
			
						   }else{
							   	$output = array('infocode'=>'UPDATECUSTOMSFAILED','message'=>'An Error Occurred while updating the section.','table'=>'ictTable','error_details'=>$dbResult5['error_details']);
						   }
			
					 }else{
						 		$output = array('infocode'=>'UPDATECUSTOMSFAILED','message'=>'An Error Occurred while updating the section.','table'=>'personnelSAmple','error_details'=>$dbResult4['error_details']);
					 }
			
				}else{
							$output = array('infocode'=>'UPDATECUSTOMSFAILED','message'=>'An Error Occurred while updating the section.','table'=>'beTable','error_details'=>$dbResult3['error_details']);
				}
			
			}else{
						$output = array('infocode'=>'UPDATECUSTOMSFAILED','message'=>'An Error Occurred while updating the section.','table'=>'personnel','error_details'=>$dbResult2['error_details']);
										
			}
		}else{
			$output = array('infocode'=>'UPDATECUSTOMSFAILED','message'=>'An Error Occurred while updating the section.','table'=>'clearance','error_details'=>$dbResult1['error_details']);
		}
return $output;
}

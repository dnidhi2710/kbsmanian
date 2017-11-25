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
    case 'create_operation_section':
        $finaloutput = create_operation_section();
    break;
    case 'view_operation_section':
        $finaloutput = view_operation_section();
    break;
    case 'update_operation_section':
        $finaloutput = update_operation_section();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);


function create_operation_section() {
    global $db,$form,$request;
    $output = array();

    //formelementsarray key value should be, key = form element name, value = db column name
    $formSampleArray = array('impJobId'=>"impJobId", 'type'=>"type",'iOrAFilledOn'=>"iOrAFilledOn",'iOrAFiledNo'=>"iOrAFiledNo",'iOrAFiledDate'=>"iOrAFiledDate",'iOrAFiledAmount'=>"iOrAFiledAmount",'iOrAComparedOn'=>"iOrAComparedOn",'samplesCalledOn'=>"samplesCalledOn",'dockClerkInstrn'=>"dockClerkInstrn",'calledInitial'=>"calledInitial",'drawnOn'=>"drawnOn",'calledDelayReason'=>"calledDelayReason",'submittedToCustoms'=>"submittedToCustoms",'customsDelayReason'=>"submittedDelayReason",'bOrEReceivedOn'=>"bOrEReceivedOn",'bOrEReceivedTime'=>"bOrEReceivedTime",'bOrERecdInitial'=>"bOrERecdInitial",'origOpenOrderGIvenOn'=>"origOpenOrderGIvenOn",'origOpenOrderCmptdOn'=>"origOpenOrderCmptdOn",'origOpenOrderDelayReason'=>"origOpenOrderDelayReason",'dupeOpenOrderGIvenOn'=>"dupeOpenOrderGIvenOn",'dupeOpenOrderCmptdOn'=>"dupeOpenOrderCmptdOn",'dupeOpenOrderDelayReason'=>"dupeOpenOrderDelayReason",'customsChargeon'=>"customsChargeon",'goodsClearedno'=>"goodsClearedno",'goodClearedDelay'=>"goodClearedDelay",'remarks'=>"remarks");
    $formSurveyArray= array('impJobId'=>"impJobId",'type'=>"type",'sOrAAppliedOn'=>"sOrAAppliedOn",'sOrAGrantedOn'=>"sOrAGrantedOn",'sOrAHeldOn'=>"sOrAHeldOn",'insAppliedOn'=>"insAppliedOn",'insGrantedOn'=>"insGrantedOn",'insHeldOn'=>"insHeldOn",'pTAppliedOn'=>"pTAppliedOn",'pTAGrantedOn'=>"pTAGrantedOn",'pTHeldOn'=>"pTHeldOn");

    $sampleArray = $form->getFormValuesFromJSON($formSampleArray,$request);
    $surveyArray = $form->getFormValuesFromJSON($formSurveyArray,$request);

//	file_put_contents("./formlog.log", print_r( $clearanceArray, true ), FILE_APPEND | LOCK_EX);
  
    $dbresult1 = $db->insertOperation('import_map_samples',$sampleArray);

    if($dbresult1['status']=='success'){
          $dbresult2 = $db->insertOperation('import_map_survey',$surveyArray);
          if($dbresult2['status']=='success'){
                $output = array("infocode" => "CREATEOPERATIONSUCCESS", "message" => "Operation Created Successfully");
          }else{
                $output = array("infocode" => "CREATEOPERATIONFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult1['error_details'],"table"=>'survey');
          }
    }else{
             $output = array("infocode" => "CREATEOPERATIONFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult1['error_details'],"table"=>'sample');
    }
    return $output;
}


 function view_operation_section(){
		global $db,$request;
	//	$db = new Dbclass;
		$map = new mapResultSet;

        $selectClearance = "SELECT * from import_map_samples WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."'  ";
		if($db->getResults($selectClearance)){
            	$sample = $map->mapSampleFields($db->getResults($selectClearance));	
        }else{
            	$sample = null;	
        }

        $select = "SELECT * from import_map_survey WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."' ";
		if($db->getResults($select)){
			$survey = $map->mapSurveyFields($db->getResults($select));
		}else{
			$survey = null;
		}

		if($sample!=null || $survey!=null){
			$operationsObj = $map->groupOperationsObj($sample,$survey);
		    $output =  array('status'=>'success','data'=>$operationsObj);
        }else{
            $error = $db->getError();
			$output = array('status'=>'failed','msg'=>$error);	
		}
        return $output;
	}


function update_operation_section(){
	global $db,$form,$request;
		//$sac_id = $_POST['sac_id'];
    $formSampleArray = array('iOrAFilledOn'=>"iOrAFilledOn",'iOrAFiledNo'=>"iOrAFiledNo",'iOrAFiledDate'=>"iOrAFiledDate",'iOrAFiledAmount'=>"iOrAFiledAmount",'iOrAComparedOn'=>"iOrAComparedOn",'samplesCalledOn'=>"samplesCalledOn",'dockClerkInstrn'=>"dockClerkInstrn",'calledInitial'=>"calledInitial",'drawnOn'=>"drawnOn",'calledDelayReason'=>"calledDelayReason",'submittedToCustoms'=>"submittedToCustoms",'customsDelayReason'=>"submittedDelayReason",'bOrEReceivedOn'=>"bOrEReceivedOn",'bOrEReceivedTime'=>"bOrEReceivedTime",'bOrERecdInitial'=>"bOrERecdInitial",'origOpenOrderGIvenOn'=>"origOpenOrderGIvenOn",'origOpenOrderCmptdOn'=>"origOpenOrderCmptdOn",'origOpenOrderDelayReason'=>"origOpenOrderDelayReason",'dupeOpenOrderGIvenOn'=>"dupeOpenOrderGIvenOn",'dupeOpenOrderCmptdOn'=>"dupeOpenOrderCmptdOn",'dupeOpenOrderDelayReason'=>"dupeOpenOrderDelayReason",'customsChargeon'=>"customsChargeon",'goodsClearedno'=>"goodsClearedno",'goodClearedDelay'=>"goodClearedDelay",'remarks'=>"remarks");
    $formSurveyArray= array('sOrAAppliedOn'=>"sOrAAppliedOn",'sOrAGrantedOn'=>"sOrAGrantedOn",'sOrAHeldOn'=>"sOrAHeldOn",'insAppliedOn'=>"insAppliedOn",'insGrantedOn'=>"insGrantedOn",'insHeldOn'=>"insHeldOn",'pTAppliedOn'=>"pTAppliedOn",'pTAGrantedOn'=>"pTAGrantedOn",'pTHeldOn'=>"pTHeldOn");
    $sampleArray = $form->getFormValuesFromJSON($formSampleArray,$request);
    $surveyArray = $form->getFormValuesFromJSON($formSurveyArray,$request);
	$wherearray = array('impJobId'=>$request['impJobId'],'type'=>$request['type']);
   		//array('condition'=>'impJobId = :impJobId', 'param'=>':impJobId', 'value'=>$request['impJobId']);
	   $dbResult1 = $db->updateOperation('import_map_samples',$sampleArray,$wherearray);
	    if($dbResult1['status']=='success'){
			 $dbResult2 = $db->updateOperation('import_map_survey',$surveyArray,$wherearray);
			if($dbResult2['status']=='success'){
			     $output = array('infocode'=>'UPDATEOPERATIONSUCCESS','message'=>'Update Successfull');
			}else{    
		    	 $output = array('infocode'=>'UPDATEOPERATIONFAILED','message'=>'An Error Occurred while updating the section.','table'=>'survey','error_details'=>$dbResult2['error_details']);
			}
		}else{
			$output = array('infocode'=>'UPDATEOPERATIONFAILED','message'=>'An Error Occurred while updating the section.','table'=>'sample','error_details'=>$dbResult1['error_details']);
		}
return $output;
}

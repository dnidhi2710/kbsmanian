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
    case 'create_export_doc':
        $finaloutput = create_export_doc();
    break;
    case 'update_export_doc':
        $finaloutput = update_export_doc();
    break;
    case 'view_export_doc':
        $finaloutput = view_export_doc();
    break;
    case 'create_export_remark':
    $finaloutput = create_export_remark();
    break;
    case 'update_export_remark':
    $finaloutput = update_export_remark();
    break;
    case 'view_export_remark':
    $finaloutput = view_export_remark();
    break;
    
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function create_export_doc() {
    global $db,$form,$request;
    $output = array();
	
    //formelementsarray key value should be, key = form element name, value = db column name
    $formelementsarray = array('impJobId'=>"impJobId", 'exportType'=>"type",'importDate'=>"exportDate",'shipper'=>"shipper",'consignee'=>"consignee",'bank'=>"bank",
    	'bank_notify'=>"bank_notify",'invoiceNo'=>"invoiceNo",'invoiceDate'=>"invoiceDate",'value'=>"invoiceValue",'grNo'=>"grNo",'grDate'=>"grDate",'rbiCode'=>"rbiNo",'billNo'=>"billingNo",'billDate'=>"billingDate",'exchangeRate'=>"exRate",'flight'=>"flight",'arrived'=>"arrived",'departured'=>"departure",'agent'=>"agent",'port'=>"port",'country'=>"country",'emNo'=>"EMNo",'remarks'=>"remarks",'value1'=>"value",'fob'=>"FOB","frt"=>"FRT","ins"=>"INS","cif"=>"CIF","eaNo"=>"eaNo","lcNo"=>"lcNo","lcDate"=>"lcDate","orderNo"=>"orderNo","receiptNo"=>"mateReceipt","receiptDate1"=>"mateDate1","receiptDate2"=>"mateDate2","landingNo"=>"billOfLanding","billDate1"=>"landingDate1","billDate2"=>"landingDate2","prt"=>"blPRT","exUS"=>"exUS","exchangeDate"=>"EADate","rupees"=>"EARS","splInstructions"=>"specialInstructions","awbNo"=>"AWBNo","mawbDate"=>"MAWBDate","mblDate"=>"MBLDate");
    
    $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    //custom add other fields if required
   // $array1['par_status'] = PAR_DEFAULT_STATUS;
    
    //uncomment the below line to see how the data is formed in real-time
	//file_put_contents("formlog.log", print_r( $array1, true ), FILE_APPEND | LOCK_EX);

    //Usage of insertOperation from db wrapper, first param is DB table name, second is the key value array created using FormWrapper, 
    //u can send custom array, key = db table column name, value = the actual form value that needs to be inserted
    $dbresult = $db->insertOperation('export_sea',$array1);
    if($dbresult['status'] == 'success'){
        $last_insert_id = $dbresult['last_insert_id'];
        $containerObj = $request['Container'];
        $containerObj['impJobId'] = $request['impJobId'] ;
        $containerArray = array('Contr'=>'contrNos','noOfPkgs'=>'noOfPkgs','content'=>'content','measurements'=>'measurements','grossWeight'=>'grossWeight','nettWeight'=>'nettWeight','type'=>'type','impJobId'=>'impJobId');
        $array2 = $form->getFormValuesFromJSON($containerArray,$containerObj);
        $dbresult2 = $db->insertOperation('import_map_contents',$array2);
        if($dbresult['status'] == 'success'){
                 $output = array("infocode" => "CREATEEXPORTDOCSUCCESS", "message" => "Export Document created successfully", "doc_id" => $last_insert_id);         
        }else{
                $output = array("infocode" => "CREATEEXPORTDOCFAILED", "message" => "An error occured while adding contents", "doc_id" => $last_insert_id);
        }
    } else {
        $output = array("infocode" => "CREATEEXPORTDOCFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details']);
    }
    
    return $output;
}

	function update_export_doc(){
				//echo "connected to class";
        global $db,$form,$request;
	    $formelementsarray = array('impJobId'=>"impJobId", 'exportType'=>"type",'importDate'=>"exportDate",'shipper'=>"shipper",'consignee'=>"consignee",'bank'=>"bank",
    	'bank_notify'=>"bank_notify",'invoiceNo'=>"invoiceNo",'invoiceDate'=>"invoiceDate",'value'=>"invoiceValue",'grNo'=>"grNo",'grDate'=>"grDate",'rbiCode'=>"rbiNo",'billNo'=>"billingNo",'billDate'=>"billingDate",'exchangeRate'=>"exRate",'flight'=>"flight",'arrived'=>"arrived",'departured'=>"departure",'agent'=>"agent",'port'=>"port",'country'=>"country",'emNo'=>"EMNo",'remarks'=>"remarks",'value1'=>"value",'fob'=>"FOB","frt"=>"FRT","ins"=>"INS","cif"=>"CIF","eaNo"=>"eaNo","lcNo"=>"lcNo","lcDate"=>"lcDate","orderNo"=>"orderNo","receiptNo"=>"mateReceipt","receiptDate1"=>"mateDate1","receiptDate2"=>"mateDate2","landingNo"=>"billOfLanding","billDate1"=>"landingDate1","billDate2"=>"landingDate2","prt"=>"blPRT","exUS"=>"exUS","exchangeDate"=>"EADate","rupees"=>"EARS","splInstructions"=>"specialInstructions","awbNo"=>"AWBNo","mawbDate"=>"MAWBDate","mblDate"=>"MBLDate");    
        $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
        $containerObj = $request['Container'];
        $containerObj['impJobId'] = $request['impJobId'] ;
        $containerArray = array('Contr'=>'contrNos','noOfPkgs'=>'noOfPkgs','content'=>'content','measurements'=>'measurements','grossWeight'=>'grossWeight','nettWeight'=>'nettWeight','type'=>'type','impJobId'=>'impJobId');
        $array2 = $form->getFormValuesFromJSON($containerArray,$containerObj);
        
 		$wherearray = array('impJobId'=>$request['impJobId']);
 		$wherearray1 = array('impJobId'=>$containerObj['impJobId'],'type'=>$containerObj['type']);
   		//array('condition'=>'impJobId = :impJobId', 'param'=>':impJobId', 'value'=>$request['impJobId']);
	   $dbResult1 = $db->updateOperation('export_sea',$array1,$wherearray);
				if($dbResult1['status']=='success')
				{
					$dbResult2 = $db->updateOperation('import_map_contents',$array2,$wherearray1);
					if($dbResult2['status']=='success'){
								$output=  array('infocode'=>"UPDATEEXPORTDOCSUCCESS",'message'=>'Export Document Updated Successfully');
					}else{
  								  $output=  array('infocode'=>"UPDATEEXPORTDOCFAILED",'message'=>'An error occurred while creating the document, please try again!', "err_debug" => $db->getError());	
					}
				}
				else
				{
                    $output=  array('infocode'=>"UPDATEEXPORTDOCFAILED",'message'=>'An error occurred while creating the document, please try again!', "err_debug" => $db->getError());
				}
        return $output;			//echo "connected to class";

	}

function view_export_doc(){
    global $db,$request;
		//$db = new Dbclass;
		$map = new mapResultSet;
       // echo "called";
		$select = "SELECT * from export_sea WHERE impJobId = '".$request['id']."' ";
			if($db->getResults($select)){
					$docObj = $map->mapExportFields($db->getResults($select));
				}else{
					$docObj = null;
				}	
		$content =  "SELECT * from import_map_contents WHERE impJobId = '".$request['id']."' and type = '".$request['type']."'  ";
				if($db->getResults($content)){
					$content = $map->mapContents($db->getResults($content));
				}else{
					$content = null;
				}
		if($docObj!= null || $content != null){
			$output =  array('result'=>true,'data'=>$map->groupExportDoc($docObj,$content));
		}else{
			$error = $db->getError();
			$output = array('result'=>false,'msg'=>$error);	
		}
        return $output;
}

function create_export_remark(){
    global $db,$form,$request;
    $output = array();
	
    //formelementsarray key value should be, key = form element name, value = db column name
    $formelementsarray = array('impJobId'=>"impJobId", 'exportType'=>"type",'progress'=>"procedures",'cargoReceipts'=>"cargo_receipts");
    
    $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    $dbresult = $db->insertOperation('export_remarks',$array1);
    if($dbresult['status'] == 'success'){
                 $output = array("infocode" => "CREATEEXPORTREMARKSUCCESS", "message" => "Export Document created successfully");         
    } else {
        $output = array("infocode" => "CREATEEXPORTREMARKFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details']);
    }
    return $output;
}

function update_export_remark(){
     global $db,$form,$request;
    $output = array();
    //formelementsarray key value should be, key = form element name, value = db column name
    $formelementsarray = array('impJobId'=>"impJobId", 'exportType'=>"type",'progress'=>"procedures",'cargoReceipts'=>"cargo_receipts");
        $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
   		$wherearray = array('impJobId'=>$request['impJobId'],'type'=>$request['exportType']);
   	    $dbResult = $db->updateOperation('export_remarks',$array1,$wherearray);
		if($dbResult['status'] == 'success'){
              $output = array("infocode" => "UPDATEEXPORTREMARKSUCCESS", "message" => "Export Document updated successfully");         
        } else {
              $output = array("infocode" => "UPDATEEXPORTREMARKFAILED", "message" => "An error occurred while updating the document, please try again!", "err_debug" => $dbResult['error_details']);
        }
    return $output;
}

function view_export_remark(){
     global $db,$request;
		//$db = new Dbclass;
		$map = new mapResultSet;
       // echo "called";
		$select = "SELECT * from export_remarks WHERE impJobId = '".$request['id']."' AND type = '".$request['exportType']."'  ";
			if($db->getResults($select)){
					$docObj = $map->mapExportRemarksFields($db->getResults($select));
				}else{
					$docObj = null;
				}	
		if($docObj!= null){
			$output =  array('result'=>true,'data'=>$docObj);
		}else{
			$error = $db->getError();
			$output = array('result'=>false,'msg'=>$error);	
		}
        return $output;

}
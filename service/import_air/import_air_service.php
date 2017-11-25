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
    case 'create_import_air_doc':
        $finaloutput = create_import_air_doc();
    break;
    case 'update_import_air_doc':
        $finaloutput = update_import_air_doc();
    break;
    case 'view_import_air_doc':
        $finaloutput = view_import_air_doc();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function create_import_air_doc() {
    global $db,$form,$request;
    $output = array();
	
    //formelementsarray key value should be, key = form element name, value = db column name
    $formelementsarray = array('impJobId'=>"impJobId", 'importedDate'=>"importedDate",'partyRef'=>"partyRef",'consignee'=>"consignee",'licenseDetail'=>"licenseDetail",'buffNo'=>"buffNo",'address'=>"address",'hsOrBtAccParty'=>"hsOrBtAccParty",
    	'supplier'=>"supplier",'invoiceNo'=>"invoiceNo",'invoiceDate'=>"invoiceDate",'flightDtls'=>"flightDtls",'dueDate'=>"dueDate",'arrival'=>"arrival",'gdd'=>"gdd",'lfd'=>"lfd",'advisedBy'=>"advisedBy",'advisedOn'=>"advisedOn",'shed'=>"shed",'warehouse'=>"warehouse",'license'=>"licenseNo",'licenseValue'=>"value",'balance'=>"balance",'mawbNo'=>"mawbNo",'hawbNo'=>"hawbNo",'hawbDate'=>"hawbDate","doNo"=>"doNo","doDate"=>"doDate","invoiceValue"=>"invoiceValue","jobType"=>"jobType");
    
    $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    
    //uncomment the below line to see how the data is formed in real-time
	//file_put_contents("formlog.log", print_r( $array1, true ), FILE_APPEND | LOCK_EX);
     $dbresult = $db->insertOperation('import_air',$array1);
    if($dbresult['status'] == 'success'){
        $last_insert_id = $dbresult['last_insert_id'];
        $containerObj = $request['Container'];
        $containerObj['impJobId'] = $request['impJobId'];
        $containerArray = array('Contr'=>'contrNos','noOfPkgs'=>'noOfPkgs','content'=>'content','measurements'=>'measurements','grossWeight'=>'grossWeight','nettWeight'=>'nettWeight','type'=>'type','impJobId'=>'impJobId');
        $array2 = $form->getFormValuesFromJSON($containerArray,$containerObj);
        $dbresult2 = $db->insertOperation('import_map_contents',$array2);
        if($dbresult['status'] == 'success'){
                 $output = array("infocode" => "CREATEIMPORTAIRDOCSUCCESS", "message" => "Import Sea Document created successfully", "doc_id" => $last_insert_id);         
        }else{
                $output = array("infocode" => "CREATEIMPORTAIRDOCFAILED", "message" => "An error occured while adding contents", "doc_id" => $last_insert_id);
        }
    } else {
        $output = array("infocode" => "CREATEIMPORTAIRDOCFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details']);
    }
    
    return $output;
}

	function update_import_air_doc(){
		global $db,$form,$request;
		$formelementsarray = array('impJobId'=>"impJobId", 'importedDate'=>"importedDate",'partyRef'=>"partyRef",'consignee'=>"consignee",'licenseDetail'=>"licenseDetail",'buffNo'=>"buffNo",'address'=>"address",'hsOrBtAccParty'=>"hsOrBtAccParty",
    	'supplier'=>"supplier",'invoiceNo'=>"invoiceNo",'invoiceDate'=>"invoiceDate",'flightDtls'=>"flightDtls",'dueDate'=>"dueDate",'arrival'=>"arrival",'gdd'=>"gdd",'lfd'=>"lfd",'advisedBy'=>"advisedBy",'advisedOn'=>"advisedOn",'shed'=>"shed",'warehouse'=>"warehouse",'license'=>"licenseNo",'licenseValue'=>"value",'balance'=>"balance",'mawbNo'=>"mawbNo",'hawbNo'=>"hawbNo",'hawbDate'=>"hawbDate","doNo"=>"doNo","doDate"=>"doDate","invoiceValue"=>"invoiceValue","jobType"=>"jobType");
    	$array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
        $containerObj = $request['Container'];
		$containerArray = array('Contr'=>'contrNos','noOfPkgs'=>'noOfPkgs','content'=>'content','measurements'=>'measurements','grossWeight'=>'grossWeight','nettWeight'=>'nettWeight');
        $array2 = $form->getFormValuesFromJSON($containerArray,$containerObj);

 		$wherearray = array('impJobId'=>$request['impJobId']);
 		$wherearray1 = array('impJobId'=>$containerObj['impJobId'],'type'=>$containerObj['type']);
   		//array('condition'=>'impJobId = :impJobId', 'param'=>':impJobId', 'value'=>$request['impJobId']);
	   $dbResult1 = $db->updateOperation('import_air',$array1,$wherearray);
				if($dbResult1['status']=='success')
				{
					$dbResult2 = $db->updateOperation('import_map_contents',$array2,$wherearray1);
					if($dbResult2['status']=='success'){
								$output=  array('infocode'=>"UPDATEIMPORTAIRDOCSUCCESS",'message'=>'Import Sea Document Updated Successfully');
					}else{
  								  $output=  array('infocode'=>"UPDATEIMPORTAIRDOCFAILED",'message'=>'An error occurred while creating the document, please try again!', "err_debug" => $db->getError());	
					}
				}
				else
				{
                    $output=  array('infocode'=>"UPDATEIMPORTAIRDOCFAILED",'message'=>'An error occurred while creating the document, please try again!', "err_debug" => $db->getError());
				}
        return $output;			//echo "connected to class";
	}

function view_import_air_doc(){
    global $db,$request;
		//$db = new Dbclass;
		$map = new mapResultSet;
       // echo "called";
		$select = "SELECT * from import_air WHERE impJobId = '".$request['id']."' ";
			if($db->getResults($select)){
					$docObj = $map->mapAirDocFields($db->getResults($select));
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
			$output =  array('result'=>true,'data'=>$map->groupImportAirDoc($docObj,$content));
		}else{
			$error = $db->getError();
			$output = array('result'=>false,'msg'=>$error);	
		}
        return $output;
}

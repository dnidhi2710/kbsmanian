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
    case 'create_receipts':
        $finaloutput = create_receipts();
    break;
    case 'update_receipts':
        $finaloutput = update_receipts();
    break;
    case 'view_receipts':
        $finaloutput = view_receipts();
    break;
    case 'delete_receipt':
        $finaloutput = delete_receipt();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function create_receipts() {
    global $db,$form,$request;
    $output = array();
    //formelementsarray key value should be, key = form element name, value = db column name
    $formelementsarray = array('impJobId'=>"impJobId",'type'=>"type",'date'=>'date','truckNo'=>"truckNo",'driverName'=>"driverName",'from'=>"from_source",'to'=>"to_dest",'Marks'=>"marks",'BENO'=>"BENO",'BEDate'=>"BEDate",'transporterName'=>"transporterName",'importerGst'=>"importerGst",'importerName'=>"importerName",'Address'=>"address");
    $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    //uncomment the below line to see how the data is formed in real-time
	//file_put_contents("formlog.log", print_r( $array1, true ), FILE_APPEND | LOCK_EX);
    $dbresult = $db->insertOperation('delivery_receipts',$array1);
    if($dbresult['status'] == 'success'){
       // $last_insert_id = $dbresult['last_insert_id'];
        $output = array("infocode" => "CREATERECEIPTSUCCESS", "message" => "Receipt Created successfully");         
    } else {
        $output = array("infocode" => "CREATERECEIPTFAILED", "message" => "An error occurred while creating the Receipt, please try again!", "err_debug" => $dbresult['error_details']);
    }
    return $output;
}

function update_receipts(){
    global $db,$form,$request;
	  $formelementsarray = array('id'=>"id",'impJobId'=>"impJobId",'type'=>"type",'date'=>'date','truckNo'=>"truckNo",'driverName'=>"driverName",'from'=>"from_source",'to'=>"to_dest",'Marks'=>"marks",'BENO'=>"BENO",'BEDate'=>"BEDate",'transporterName'=>"transporterName",'importerGst'=>"importerGst",'importerName'=>"importerName",'Address'=>"address");
   $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    $wherearray = array('id'=>$request['id'],'type'=>$request['type']);
   		//array('condition'=>'impJobId = :impJobId', 'param'=>':impJobId', 'value'=>$request['impJobId']);
	   $dbResult1 = $db->updateOperation('delivery_receipts',$array1,$wherearray);
				if($dbResult1['status']=='success')
				{
					$output=  array('infocode'=>"UPDATERECEIPTSUCCESS",'message'=>'Receipt updated Successfully');
				}
				else
				{
                    $output=  array('infocode'=>"UPDATERECEIPTFAILED",'message'=>'An error occurred while creating the document, please try again!', "err_debug" => $db->getError());
				}
        return $output;
}

function view_receipts(){
    global $db,$request;
		//$db = new Dbclass;
		$map = new mapResultSet;
       // echo "called";
		$select = "SELECT * from delivery_receipts WHERE impJobId = '".$request['id']."' AND type = '".$request['type']."' ";
			if($db->getResults($select)){
					$docObj = $map->mapReceiptFields($db->getResults($select));
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
function delete_receipt(){
       global $db,$request;
		//$db = new Dbclass;
		$map = new mapResultSet;
        $sql = "DELETE FROM delivery_receipts WHERE id = '".$request['id']."' AND impJobId = '".$request['impJobId']."' AND type = '".$request['type']."'";

        if ($db->query($sql) === true) {
            $output =  array('result'=>true,'infocode'=>'DELETERECEIPTSUCCESS','msg'=>'Receipt deleted successfully.');
        } else {
            $output =  array('result'=>false,'infocode'=>'DELETERECEIPTFAILED', 'err_debug' => $db->getError());
        }
        return $output;
}

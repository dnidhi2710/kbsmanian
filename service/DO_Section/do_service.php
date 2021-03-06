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
    case 'create_do_section':
        $finaloutput = create_do_section();
    break;
    case 'update_do_section':
        $finaloutput = update_do_section();
    break;
    case 'view_do_section':
        $finaloutput = view_do_section();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function create_do_section() {
    global $db,$form,$request;
    $output = array();
    //formelementsarray key value should be, key = form element name, value = db column name
    $formelementsarray = array('impJobId'=>"impJobId",'type'=>"type",'invoiceMode'=>'invoiceMode','customsClerk'=>"customsClerk",'dockClerk'=>"dockClerk",'tinNO'=>"tinNO",'cstNo'=>"cstNo",'gstNo'=>"gstNo",'stAgentsCharges'=>"stAgentsCharges",'remarks'=>"remarks");
    $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    //uncomment the below line to see how the data is formed in real-time
	//file_put_contents("formlog.log", print_r( $array1, true ), FILE_APPEND | LOCK_EX);
    $dbresult = $db->insertOperation('import_map_do',$array1);
    if($dbresult['status'] == 'success'){
        $last_insert_id = $dbresult['last_insert_id'];
        $output = array("infocode" => "CREATEDOSUCCESS", "message" => "DO Created successfully", "doc_id" => $last_insert_id);         
    } else {
        $output = array("infocode" => "CREATEDOFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details']);
    }
    return $output;
}

function update_do_section(){
    global $db,$form,$request;
	$formelementsarray = array('impJobId'=>"impJobId",'type'=>"type",'invoiceMode'=>'invoiceMode','customsClerk'=>"customsClerk",'dockClerk'=>"dockClerk",'tinNO'=>"tinNO",'cstNo'=>"cstNo",'gstNo'=>"gstNo",'stAgentsCharges'=>"stAgentsCharges",'remarks'=>"remarks");
    $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    $wherearray = array('impJobId'=>$request['impJobId'],'type'=>$request['type']);
   		//array('condition'=>'impJobId = :impJobId', 'param'=>':impJobId', 'value'=>$request['impJobId']);
	   $dbResult1 = $db->updateOperation('import_map_do',$array1,$wherearray);
				if($dbResult1['status']=='success')
				{
					$output=  array('infocode'=>"UPDATEDOSUCCESS",'message'=>'Import Sea Document Updated Successfully');
				}
				else
				{
                    $output=  array('infocode'=>"UPDATEDOFAILED",'message'=>'An error occurred while creating the document, please try again!', "err_debug" => $db->getError());
				}
        return $output;
}

function view_do_section(){
    global $db,$request;
		//$db = new Dbclass;
		$map = new mapResultSet;
       // echo "called";
		$select = "SELECT * from import_map_do WHERE impJobId = '".$request['id']."' AND type = '".$request['type']."' ";
			if($db->getResults($select)){
					$docObj = $map->mapDoFields($db->getResults($select));
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

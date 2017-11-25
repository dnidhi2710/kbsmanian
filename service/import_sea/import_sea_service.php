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
    case 'create_import_sea_doc':
        $finaloutput = create_import_sea_doc();
    break;
    case 'update_import_sea_doc':
        $finaloutput = update_import_sea_doc();
    break;
    case 'view_import_sea_doc':
        $finaloutput = view_import_sea_doc();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function create_import_sea_doc() {
    global $db,$form,$request;
    $output = array();
	
    //formelementsarray key value should be, key = form element name, value = db column name
    $formelementsarray = array('impJobId'=>"impJobId",'licenseDetail'=>"licenseDetail",'buffNo'=>"buffNo", 'importedDate'=>"importedDate",'partyRef'=>"partyRef",'consignee'=>"consignee",'address'=>"address",'hsOrBtAccParty'=>"hsOrBtAccParty",
    	'supplier'=>"supplier",'invoiceNo'=>"invoiceNo",'invoiceDate'=>"invoiceDate",'motherVsl'=>"motherVsl",'mvdate'=>"mvDue",'arrival'=>"arrival",'gld'=>"GLD",'cntrOut'=>"cntrOut",'feederVsl'=>"feederVsl",'fvOn'=>"fvOn",'CFS'=>"CFS",'agents'=>"agents",'igmNo'=>"igmNo",'licenseDate'=>"licenseDate",'lineNo'=>"lineNo",'hblNo'=>"hblNo",'hblDate'=>"hblDate",'mbl'=>"mbl",'mblDate'=>"mblDate",'invoiceValue'=>"invoiceValue","jobType"=>"jobType");
    
    $array1 = $form->getFormValuesFromJSON($formelementsarray,$request);
    //custom add other fields if required
   // $array1['par_status'] = PAR_DEFAULT_STATUS;
    
    //uncomment the below line to see how the data is formed in real-time
	//file_put_contents("formlog.log", print_r( $array1, true ), FILE_APPEND | LOCK_EX);

    //Usage of insertOperation from db wrapper, first param is DB table name, second is the key value array created using FormWrapper, 
    //u can send custom array, key = db table column name, value = the actual form value that needs to be inserted
    $dbresult = $db->insertOperation('import_sea',$array1);
    if($dbresult['status'] == 'success'){
        $last_insert_id = $dbresult['last_insert_id'];
        $containerObj = $request['Container'];
        $containerObj['impJobId'] = $request['impJobId'];
        $containerArray = array('Contr'=>'contrNos','noOfPkgs'=>'noOfPkgs','content'=>'content','measurements'=>'measurements','grossWeight'=>'grossWeight','nettWeight'=>'nettWeight','type'=>'type','impJobId'=>'impJobId');
        $array2 = $form->getFormValuesFromJSON($containerArray,$containerObj);
        $dbresult2 = $db->insertOperation('import_map_contents',$array2);
        if($dbresult['status'] == 'success'){
                 $output = array("infocode" => "CREATEIMPORTSEADOCSUCCESS", "message" => "Import Sea Document created successfully", "doc_id" => $last_insert_id);         
        }else{
                $output = array("infocode" => "CREATEIMPORTSEADOCFAILED", "message" => "An error occured while adding contents", "doc_id" => $last_insert_id);
        }
    } else {
        $output = array("infocode" => "CREATEIMPORTSEADOCFAILED", "message" => "An error occurred while creating the document, please try again!", "err_debug" => $dbresult['error_details']);
    }
    
    return $output;
}

	function update_import_sea_doc(){
				//echo "connected to class";
		global $request,$db;
		//$db = new Dbclass;
		$output=array();
        //echo $db->test();
		$insert = "UPDATE import_sea SET importedDate= '".$request['importedDate']."',licenseDetail= '".$request['licenseDetail']."',buffNo= '".$request['buffNo']."',partyRef = '".$request['partyRef']."',consignee = '".$request['consignee']."',address= '".$request['address']."', hsOrBtAccParty='".$request['hsOrBtAccParty']."', supplier='".$request['supplier']."', invoiceNo='".$request['invoiceNo']."', invoiceDate='".$request['invoiceDate']."', motherVsl='".$request['motherVsl']."', mvDue='".$request['mvdate']."', arrival='".$request['arrival']."', GLD= '".$request['gld']."', cntrOut= '".$request['cntrOut']."', feederVsl='".$request['feederVsl']."' , fvOn= '".$request['fvOn']."', CFS='".$request['CFS']."',agents='".$request['agents']."', igmNo='".$request['igmNo']."', licenseDate= '".$request['licenseDate']."', lineNo='".$request['lineNo']."', hblNo='".$request['hblNo']."', hblDate='".$request['hblDate']."', mbl='".$request['mbl']."', mblDate='".$request['mblDate']."', invoiceValue='".$request['invoiceValue']."', jobType='".$request['jobType']."' WHERE impJobId = '".$request['id']."' ";

		if($db->query($insert))
		{
				$containerObj = $request['Container'];
				$update_content = "UPDATE import_map_contents SET contrNos = '".$containerObj['Contr']."',noOfPkgs = '".$containerObj['noOfPkgs']."',content = '".$containerObj['content']."',measurements = '".$containerObj['measurements']."',grossWeight = '".$containerObj['grossWeight']."',nettWeight = '".$containerObj['nettWeight']."' WHERE impJobId = '".$request['id']."' AND type = '".$request['type']."';";
				if($db->query($update_content))
				{
					$output=  array('infocode'=>"UPDATEIMPORTSEADOCSUCCESS",'message'=>'Import Sea Document Updated Successfully');
				}
				else
				{
                    $output=  array('infocode'=>"UPDATEIMPORTSEADOCFAILED",'message'=>'An error occurred while updating the document, please try again!', "err_debug" => $db->getError());
				}
		}
		else
		{   
            $output=  array('infocode'=>"UPDATEIMPORTSEADOCFAILED",'message'=>'An error occurred while updating the document, please try again!', "err_debug" => $db->getError());
		}
        return $output;
	}

function view_import_sea_doc(){
    global $db,$request;
		//$db = new Dbclass;
		$map = new mapResultSet;
       // echo "called";
		$select = "SELECT * from import_sea WHERE impJobId = '".$request['id']."' ";
			if($db->getResults($select)){
					$docObj = $map->mapSeaDocFields($db->getResults($select));
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
			$output =  array('result'=>true,'data'=>$map->groupImportSeaDoc($docObj,$content));
		}else{
			$error = $db->getError();
			$output = array('result'=>false,'msg'=>$error);	
		}
        return $output;
}

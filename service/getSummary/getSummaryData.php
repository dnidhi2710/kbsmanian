<?php 

require('../dbconfig.php'); 
require('../dbwrapper_mysqli.php');
require('../formwrapper.php');
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
    case 'get_import_sea':
        $finaloutput = get_import_sea();
    break;
    case 'get_import_air':
        $finaloutput = get_import_air();
    break;
    case 'get_export_details':
        $finaloutput = get_export_details();
    break;
    case 'get_export_sea_details':
     $finaloutput = get_export_sea_details();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function get_import_sea(){
   global $dbc;
$output = array();
$query = "SELECT * FROM import_sea ORDER BY id DESC";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
    //echo "inside";
  $importSeaData = array();
  while ($row = mysqli_fetch_array($result)) {
      //echo "called";
   $importSeaData[] = array (
     'id'=>$row['id'],
     'job_id' => $row['impJobId'],
     'import_date'=> $row['importedDate'],
     'party_ref' => $row['partyRef'],
     'consignee' => $row['consignee'],
     );
    // echo json_encode($importSeaData);
 }
}else{
	$importSeaData = null;
}
$output = array('status'=>'success','data'=>$importSeaData);
return $output;
}

function get_import_air(){
  global $dbc;
$output = array();
$query = "SELECT * FROM import_air ORDER BY id DESC";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $importAirData = array();
  while ($row = mysqli_fetch_array($result)) {
   $importAirData[] = array (
     'id'=>$row['id'],
     'job_id' => $row['impJobId'],
     'import_date'=> $row['importedDate'],
     'party_ref' => $row['partyRef'],
     'consignee' => $row['consignee'],
     );
 }
}else{
	$importAirData = null;
}
$output = array('status'=>'success','data'=>$importAirData);
return $output;
}

function get_export_details(){
global $dbc,$request;
$output = array();
$query = "SELECT * FROM export_air_sea ORDER BY id DESC";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $exportData = array();
  while ($row = mysqli_fetch_array($result)) {
   $exportData[] = array (
     'id'=>$row['id'],
     'job_id' => $row['impJobId'],
     'exportDate'=> $row['exportDate'],
     'shipper' => $row['shipper'],
     'consignee' => $row['consignee'],
     );
 }
}else{
	$exportData = null;
}
$output = array('status'=>'success','data'=>$exportData);
return $output;
}

function get_export_sea_details(){
global $dbc,$request;
$output = array();
$query = "SELECT * FROM export_sea ORDER BY id DESC";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $exportData = array();
  while ($row = mysqli_fetch_array($result)) {
   $exportData[] = array (
     'id'=>$row['id'],
     'job_id' => $row['impJobId'],
     'exportDate'=> $row['exportDate'],
     'shipper' => $row['shipper'],
     'consignee' => $row['consignee'],
     );
 }
}else{
	$exportData = null;
}
$output = array('status'=>'success','data'=>$exportData);
return $output;
}

<?php 
include('dbconfig.php'); 

$query = "SELECT * FROM import_sea ORDER BY id DESC";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $importSeaData = array();
  while ($row = mysqli_fetch_array($result)) {
   $importSeaData[] = array (
     'id'=>$row['id'],
     'job_id' => $row['impJobId'],
     'import_date'=> $row['importedDate'],
     'party_ref' => $row['partyRef'],
     'consignee' => $row['consignee'],
     );
 }
}else{
	$importSeaData = null;
}
echo json_encode($importSeaData);
?>
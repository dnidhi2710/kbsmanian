<?php 
include('dbconfig.php'); 

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
echo (json_encode($importAirData));
?>
<?php

$type = "local";

if($type == "local") {
	$db_servername = 'localhost';
	$db_username = 'root';
	$db_password = 'root';
	$db_name = 'kbsmanian';
}
else {
	$db_servername = 'localhost';
	$db_username = 'root';
	$db_password = 'root';
	$db_name = 'warehouse';
}

// Connect to MySQL:
$dbc = mysqli_connect($db_servername,$db_username,$db_password,$db_name);

// Confirm the connection and select the database:
if (mysqli_connect_errno()) {
    echo "Could not establish database connection!<br>";
    exit();
}

?>
<?php 
error_reporting(1);
//echo "application";
//include('db.php');
include('dbconfig.php'); 
//echo "connected";
global $db,$request;
$json = file_get_contents('php://input');
//echo $json;
$request = json_decode($json,true);
$module = $request['module'];
//echo $module;
include('airimport_controller.php');
//echo "included controller";
?>
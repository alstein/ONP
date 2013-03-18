<?php	

session_start();
include("facebook-connect/JSON.php");
	
$_SESSION['myfbconnect'] = 1;
$array = array("success" => 1);
// 	print_r($_SESSION);
	//	if server support php 5
//    json_encode($array);
	
	//	if server not support php 5
$json = new Services_JSON();
$output = $json->encode($array);
	
?>
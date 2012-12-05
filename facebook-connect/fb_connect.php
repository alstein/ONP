<?php	session_start();
	include("JSON.php");
	
    $_SESSION['myfbconnect'] = 1;
    $array = array("success" => 1);
	
	//	if server support php 5
    //echo json_encode($array);
	
	//	if server not support php 5
	$json = new Services_JSON();
    $output = $json->encode($array);
	
?>
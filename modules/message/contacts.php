<?php
define('PREFIX', '../../');
include_once('../../includes.php');

define(TABLENAME,'user');
	
	$q=$_GET['term'];

	$where = "email like'%". $q."%' and is_active=1";
	$result = $db->cgs(TABLENAME,"", $where, $ob = "", $ot = "", $prn = "");

	if(is_resource($result))
	{		
		while($row = @mysql_fetch_assoc($result))
		{
			
			$friends[] = array("name" => $row["email"]);		
			
		}
		$response = $_GET["tag"] . "(" . json_encode($friends) . ")";
		echo $response;
			
	}

		
		
?>
<?php
	//ini_set("session.save_path", "/home/usortd/tmp");
	session_start();


	include_once('../../includes/SiteSetting.php');
	$city = $_POST['city'];

// 	
	if(isset($city))
	{
		array_push($_SESSION['cities_name'],$city);
	}

echo "<pre>";
print_R($_SESSION['cities_name']);exit;
	echo "<ul>";
	for($i=0;$i<sizeof($_SESSION['cities_name']);$i++)
	{
		echo "<li id='add_city_$i'><div style='width:500px;'><span style='width:200px;float:left;' >".$_SESSION['cities_name'][$i]."</span><span style='width:300px;float:left;'><a href='javascript:void(0);' onclick='javascript:removecity($i)'>Remove</a></span></li>";
	}
	echo "</ul>";
?>
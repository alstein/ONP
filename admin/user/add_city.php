<?php
	//ini_set("session.save_path", "/home/usortd/tmp");
	session_start();


	include_once('../../includes/SiteSetting.php');
	$city = $_POST['city'];
	extract($_POST);
	if(isset($city))
	{
		array_push($_SESSION['cities_name'],$city);
		array_push($_SESSION['states_ids'],$_POST['state']);
	}
	if(isset($_POST['remove_city']))
	{
		function array_remove($arr,$value){
			return array_values(array_diff($arr,array($value)));
		}
		$ar = array_remove($_SESSION['cities_name'],$_POST['remove_city']);
		$ar1 = array_remove($_SESSION['states_ids'],$_POST['stateid']);
		$_SESSION['cities_name'] = array();
		$_SESSION['states_ids'] = array();
		for($j=0;$j<sizeof($ar);$j++)
		{
			array_push($_SESSION['cities_name'],$ar[$j]);
			array_push($_SESSION['states_ids'],$ar1[$j]);
		}
	}

	echo "<ul>";
	for($i=0;$i<sizeof($_SESSION['cities_name']);$i++)
	{
		echo "<li id='add_city_$i'><div style='width:500px;'><span style='width:200px;float:left;' id='name_city_$i'>".$_SESSION['cities_name'][$i]."</span><span style='width:300px;float:left;'><a href='javascript:void(0);' onclick='javascript:removecity($i)'>Remove</a></span>
		<input type='hidden' id='id_state_$i' value=".$_SESSION['states_ids'][$i]."
		</li>";
	}
	echo "</ul>";
?>
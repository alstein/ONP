<?php

	include_once("../../../include.php");
	
	$dbObj = new DBTransact();
	$dbObj->Connect();

	$tbl = "tbl_newsletter_users";

	$cnd = "city_id='".$_GET['city']."'";

	$rs = $dbObj->gj($tbl,"*",$cnd, "", "", "", "", "");

 	$numrows=@mysql_num_rows($rs);
	if ($numrows>0)
	{
		for($i=0;$i<$numrows;$i++)
		{
			$row = @mysql_fetch_array($rs);
			$user[$i] = $row;
		}
	}

			$res_city = $dbObj->cgs("mast_city", "", "city_id", $_GET['city'], "",  "", "");
			$city_arr = array();
			while($row_city = @mysql_fetch_assoc($res_city))
			{
				$city_arr[] = $row_city;
			}

			$smarty->assign("city_arr",$city_arr);
			$smarty->assign("user",$user);
			$smarty->assign("numrows",$numrows);


			$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/newsletter/add_to_sub.tpl');
	   
?>
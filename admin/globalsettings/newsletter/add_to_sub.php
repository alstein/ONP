<?php
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/paging.php");
	
	$dbObj = new DBTransact();
	$dbObj->Connect();

	$tbl = "tbl_newsletter";

	$cnd = "cityid='".$_GET['city']."'";

	$rs = $dbObj->gj($tbl,"*",$cnd, "", "", "", "", "");//exit;

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
			while($row_city = @mysql_fetch_assoc($res_city))
			{
				$city_arr[] = $row_city;
			}
	$smarty->assign("city_arr",$city_arr);
	$smarty->assign("sitename", SITETITLE);
	$smarty->assign("user",$user);
	$smarty->assign("numrows",$numrows);
	$smarty->assign("siteroot", SITEROOT);

$smarty->assign("templatedir", TEMPLATEDIR);
$smarty->display(TEMPLATEDIR.'/admin/globalsettings/newsletter/add_to_sub.tpl');
	   
?>
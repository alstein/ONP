<?php
	include_once('../includes/SiteSetting.php');
	
	$siteroot = SITEROOT;
	$str ='<select class="sel fl" name="city" id="city"  style="width:230px;">'."<option value=''>---Select City/Town---</option>";
	
	//$str .="<option value=''>---Select Town/City---</option>";

/***************Fetch state list***********************/
	$stids = $_GET['stid'];

	$rs = $dbObj->customqry("select * from mast_city where status='Active' and state_id in($stids) order by city_name","");
	while($row = @mysql_fetch_assoc($rs))
	{
		$st[] = $row;
	}
	if($st != "")
	{
		for($i=0;$i<count($st);$i++)
		{
			$str = $str."<option value='".$st[$i]['city_id']."' >".$st[$i]['city_name']."</option>";
			//{if $st[$i]['id'] eq $stid} selected="selected"{/if}
		}
		$str = $str.'</select> &nbsp;';
		
		$St =  $str;
		echo $St;
	}
	else
	{
		$str = $str.'</select>';
		echo $str;
	}
	
//====================================================//*/
?>
<?php
	include_once('../../../includes/SiteSetting.php');
	
	$siteroot = SITEROOT;
	//echo "hello";
	$str ='<select style="width: 220px; color: #2B587A;" class="selectfield" name="cityid" id="cityid">'."<option value=''>---Select City/Town---</option>";
	//$str .="<option value=''>---Select Town/City---</option>";
	// $str ='<select class="input1" name="region" id="region" style="width:50px;" onchange="javascript: getProvience(this.value,\''.$siteroot.'\');">'."<option value=''>Select Region</option>";

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
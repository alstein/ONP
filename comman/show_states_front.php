<?php
	include_once('../includes/SiteSetting.php');
	
	$siteroot = SITEROOT;
	//echo "hello";
	//die();
	$str ='<select class="sel fl" name="state" id="state"  style="width:230px;" onchange="javascript: fillCities(this.value);"  >'."<option value=''>---Select County/State---</option>";
	
	//$str .="<option value=''>---Select County/State---</option>";

/***************Fetch state list***********************/
	$cnids = $_GET['cnid'];

	$rs = $dbObj->customqry("select * from mast_state where active=1 and country_id in($cnids) order by state_name","");
	while($row = @mysql_fetch_assoc($rs))
	{
		$st[] = $row;
	}
	if($st != "")
	{
		for($i=0;$i<count($st);$i++)
		{
			$str = $str."<option value='".$st[$i]['id']."' >".$st[$i]['state_name']."</option>";
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
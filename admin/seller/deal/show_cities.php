<?php
	include_once('../../../includes/SiteSetting.php');
	
	$siteroot = SITEROOT;
	//echo "hello";

	$str = '<select name="dealcity[]" id="dealcity" class="textbox fl" size="6" multiple="true">';

	$str .="<optgroup label='--Select Deal Cities--'>";

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
		$str = $str.'</optgroup></select>';
		
		$St =  $str;
		echo $St;
	}
	else
	{
		$str = $str.'</optgroup></select>';
		echo $str;
	}
	
//====================================================//*/
?>
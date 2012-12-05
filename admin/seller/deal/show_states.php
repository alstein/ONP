<?php
	include_once('../../../includes/SiteSetting.php');
	
	$siteroot = SITEROOT;
	//echo "hello";
	
	$str = '<select name="dealstate[]" id="dealstate" class="textbox fl" size="6" multiple="true" onchange="javascript:fillCities(this);">';

	$str .="<optgroup label='--Select Deal States--'>";

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
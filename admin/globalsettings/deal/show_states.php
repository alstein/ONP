<?php
	include_once('../../../includes/SiteSetting.php');

	$incre_var = $_GET['id'];
	$siteroot = SITEROOT;
	//echo "hello";

	$str = '<select name="dealstate[]" id="dealstate_'.$incre_var.'" style="width:100%;" class="selectbox fl"  onchange="javascript:fillCities(this,'.$incre_var.');">';

	$str .= "<option value=''> Select Deal States</option>";

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
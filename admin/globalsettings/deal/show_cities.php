<?php
	include_once('../../../includes/SiteSetting.php');
	$incre_var = $_GET['id'];
	$siteroot = SITEROOT;
	//echo "hello";

	$str = '<select name="dealcity[]" id="dealcity_<?php echo $incre_var;?>" style="width:180px;" class="selectbox fl" >';

	$str .= "<option value=''> Select Deal Cities</option>";
	

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
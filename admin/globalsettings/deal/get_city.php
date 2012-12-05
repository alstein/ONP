<?php
include_once('../../../includes/SiteSetting.php');
	$country = $_GET['val'];
	$sel = $dbObj->cgs("mast_city","city_id,city_name",array("countryid","active"),array($country,1),"city_name","DESC","");
	$i=1;
	if($sel != 'n')
	{
		echo "<select name='city' id='city'>";
		while($exe = @mysql_fetch_assoc($sel))
		{ 
		?>
			<option value="<?=$exe['city_name'];?>"><?=$exe['city_name'];?></option>
		<?
		$i++;
		}
		echo "</select>";	
	}
	else
	{
		echo "<select name='city' id='city'>";
		echo "<option value=''>Select City</option>";
		echo "<option value='all' selected='selected'>All</option>";
		echo "</select>";
	}

?>
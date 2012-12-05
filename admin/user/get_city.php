<?php
	include_once('../../includes/SiteSetting.php');
	$state = $_GET['val'];
	$frm_bussiness = $_GET['bussiness'];


	$sel = $dbObj->cgs("mast_city","city_id,city_name",array("state_id","con_id","active"),array($state,'223',1),"city_name","","");
	$i=1;
	if($sel != 'n')
	{
		if($frm_bussiness==1){
		echo "<select name='city'  id='city'  style='width:100px'>";
		}else{
		echo "<select name='city' class='inputS' id='city' style='width:100px'>"; //onchange='javscript: add_cities();'
		}
		?>
		<option value="">Select city</option>
		<?
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
		echo "</select>";
	}

?>
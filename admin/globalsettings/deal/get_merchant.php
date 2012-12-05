<?php
include_once('../../../includes/SiteSetting.php');
	$city = $_GET['val'];
if($city=="")
        $sel = $dbObj->cgs("tbl_users","",array("usertypeid"),array(3),"first_name","","");
        else
	$sel = $dbObj->cgs("tbl_users","",array("city","usertypeid"),array($city,3),"first_name","","");//exit;
	$i=1;
	if($sel != 'n')
	{
		echo "<select name='merchant_id' id='merchant_id' >";
		while($exe = @mysql_fetch_assoc($sel))
		{ 
                    if($exe['business_name'] != "")
                    {
		?>
			<option value="<?=$exe['userid'];?>"><?=$exe['business_name'];?></option>
		<?
                    }
		$i++;
		}
		echo "</select>";	
	}
	else
	{
		echo "<select name='usertype' id='usertype'>";
		echo "<option value=''>Select Business Name</option>";
		echo "</select>";
	}

?>
<?php
include_once('../../../includes/SiteSetting.php');
//print_r($_GET);
$category = $_GET['val'];
if($category=="")
        $sel = $dbObj->cgs("tbl_product_service_category","",array("parent_id"),array($category),"product_service_category_name","","");
        else
	$sel=$dbObj->cgs("tbl_product_service_category","",array("parent_id"),array($category),"product_service_category_name","","");//exit;
	$i=1;
	if($sel != 'n')
	{

		echo "<select name='merchant_sub_id' id='merchant_sub_id' >";

		while($exe = @mysql_fetch_assoc($sel))
		{
                    if($exe['product_service_category_name'] != "")
                    {
		?>
			<option value="<?=$exe['product_service_category_id'];?>"><?=$exe['product_service_category_name'];?></option>
		<?
                    }
		$i++;
		}
		echo "</select>";	
	}
	else
	{
		echo "<select name='merchant_sub_id' id='merchant_sub_id'>";
		echo "<option value=''>Select Sub Category</option>";
		echo "</select>";
	}
?>
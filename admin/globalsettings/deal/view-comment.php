<?php
include_once("../../../include.php");


			$sql_contri2 = "select * from tbl_deal_payment where pay_id = ".$_GET['pay_id_info'];
			$qry_contri2 = @mysql_query($sql_contri2);
			$user_det=@mysql_fetch_assoc($qry_contri2);
			$var="<b>".ucfirst($user_det['comment'])." ";	

	
	
			

			



	

echo $var;
?>
<?
$dbObj->Close();
?>
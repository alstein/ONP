<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

	
print_r($_GET);
echo  $timestamp=date("Y-m-d H:i:s");
		
		if($_GET['module']=='dealsasusual' || $_GET['module']=='rightnowdeal' || $_GET['module']=='favlocalbusiness')
		{
			echo "ok";

$insert_thinking=$dbObj->customqry("insert into tbl_cheers(deal_id,userid,date)values('".$_GET['shareid']."','".$_GET['userid']."','".$timestamp."') ","1");
		}
		else
		{
			echo "ok2343";
				
// 				$insert_thinking=$dbObj->customqry("insert into tbl_cheers(activity_id,userid,date)values('".$_GET['shareid']."','$_GET['userid']','".$timestamp."')","1");
				$insert_thinking=$dbObj->customqry("insert into tbl_cheers(activity_id,userid,date)values('".$_GET['shareid']."','".$_GET['userid']."','".$timestamp."') ","1");
                }	

 $dbObj->Close();
?>
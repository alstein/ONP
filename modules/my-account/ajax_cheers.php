<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}


  $timestamp=date("Y-m-d H:i:s");
		
		if($_GET['module']=='dealsasusual' || $_GET['module']=='rightnowdeal' )
		{
			

$insert_thinking=$dbObj->customqry("insert into tbl_cheers(deal_id,userid,date)values('".$_GET['shareid']."','".$_GET['userid']."','".$timestamp."') ","1");
		}
		else
		{
			
				
// 				$insert_thinking=$dbObj->customqry("insert into tbl_cheers(activity_id,userid,date)values('".$_GET['shareid']."','$_GET['userid']','".$timestamp."')","1");
				$insert_thinking=$dbObj->customqry("insert into tbl_cheers(activity_id,userid,date)values('".$_GET['shareid']."','".$_GET['userid']."','".$timestamp."') ","1");
                }	

 $dbObj->Close();
?>
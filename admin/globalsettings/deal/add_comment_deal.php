<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');


$msobj= new message();

if(!$_SESSION['duAdmId'])
{
        header("location:".SITEROOT . "/admin/login/_welcome.php");
}



if(isset($_GET['id']))
{
	$cd = "id = ".$_GET['id'];
	
	$dbres = $dbObj->gj('tbl_deal_reply', "*" , $cd, "", "","", "", "");
	$row = @mysql_fetch_assoc($dbres);
	$smarty->assign("category", $row);
}


if(strlen(trim($_POST['comment']))>0)
{ 
	extract($_POST);

	extract($_GET);
	if($_GET['id'])
	{
		$tbl = "tbl_deal_reply as r";
		$set_field = array('comment');
		$set_values = array($comment);
		$dbres = $dbObj->cupdt($tbl, $set_field , $set_values, 'id' ,  $_GET['id'] , "");
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("Location:manage_comment_deal.php");
	exit;;
}

// $smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/deal/add_comment_deal.tpl');
$dbObj->Close();

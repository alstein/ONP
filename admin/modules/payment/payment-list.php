<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$payment_id = implode(", ", $payment_id);
	
	if($action == "delete")
	{
		$temp = $dbObj->customqry("delete from tbl_accept_payment where id in (".$payment_id.")","");
		$_SESSION['msg']="<span class='success'>Deleted Successfully.</span>";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------END-----------#

$rs = $dbObj->cgs("tbl_accept_payment", "*", "", "", "id", "DESC", "");
$i=0;
while($row = mysql_fetch_assoc($rs))
{
 	$payment[] = $row;
        $rs_user = $dbObj->cgs("tbl_users", "first_name,last_name", "userid",$row['user_id'], "", "", "");
        $user = mysql_fetch_assoc($rs_user);
        $payment[$i]['name']=$user['first_name']." ".$user['last_name'];
        $i++;        
}
$smarty->assign("payment",$payment);

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR.'/admin/modules/payment/payment-list.tpl');

$dbObj->Close();
?>
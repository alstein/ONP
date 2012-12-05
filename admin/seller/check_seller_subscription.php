<?php
//only for seller user
if($_SESSION['duAdmId'] > 0){
	$rs = $dbObj->cgs("tbl_users", "userid, subscribe_status", array("userid","usertypeid"),array($_SESSION['duAdmId'],3), "", "", "");
	$row = @mysql_fetch_assoc($rs);
	if($row['subscribe_status'] == 'Expired')
	{
		//check is this seller user is already subscribed before or not
		// if yes then all him to renew subscriptions
		//if not then please subscribe first to access your area.
		$cnd = "userid 	='".trim($row['userid'])."' ";
		$rs = $dbObj->gj("tbl_user_subscription_details","*", $cnd, "", "", "", "", "");
		if($rs == 'n')  //subscribption required
		{	
			$_SESSION['sess_subcri_status'] = "newsubscription";
		}else //already subscribed
		{	
			$_SESSION['sess_subcri_status'] = "oldsubscription";
		}
		header("Location:".SITEROOT."/admin/seller/subscription.php");
		exit;
	}
}
?>
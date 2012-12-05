<?php
include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(17);
$smarty->assign("row_meta",$call_meta);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/"); exit;
}
        $amountReferral = 0;
	$amountAffiliate = 0;
		
	$res_user = $dbObj->cgs("tbl_users","fullname","userid",$_SESSION['csUserId'],"","","");
	$row_user = @mysql_fetch_assoc($res_user);	
	$smarty->assign("user",$row_user['fullname']);

        // Affiliate Credit Received
	$queryReferral = "select sum(affiliate_amt) as credit_amount from tbl_deal_affiliate_tosend_users where user_id=".$_SESSION['csUserId'];
	$resReferral = mysql_query($queryReferral);
	$numReferral = @mysql_num_rows($resReferral);
	if($numReferral > 0)
	{
		$rowReferral = @mysql_fetch_assoc($resReferral);
		$amountReferral = $rowReferral['credit_amount'];
	}
        $smarty->assign("amountReferral",number_format($amountReferral,2));

        //Total Earn Credits
            $queryAffiliate = "select sum(affiliate_amt) as aff_amount from tbl_deal_affiliate_tosend_users where user_id=".$_SESSION['csUserId'];
            $resAffiliate = mysql_query($queryAffiliate);
            $numAffiliate = @mysql_num_rows($resAffiliate);
	if($numAffiliate > 0)
	{
		$rowAffiliate = @mysql_fetch_assoc($resAffiliate);
		$amountAffiliate = $rowAffiliate['aff_amount'];
	}	
	$smarty->assign("amountAffiliate",number_format($amountAffiliate,2));

        //Total Spent  and Total Credits Available
        $res2 = $dbObj->cgs("tbl_users","credit_spent,credit_account","userid",$_SESSION['csUserId'],"","","");
        $row2 = @mysql_fetch_assoc($res2);

	$smarty->assign("spent",number_format($row2['credit_spent'],2));
	$smarty->assign("credit_account",number_format($row2['credit_account'],2));
	
$smarty->display(TEMPLATEDIR . '/modules/my-account/my-credits.tpl');
$dbObj->Close();
?>
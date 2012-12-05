<?php
include_once('../../include.php');
if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}


 $sf="u.fullname,u.address1,u.contact_detail,o.*";
 $cnd="o.offer_deal_id=".$_GET['id2'];
 $tbl="tbl_offer_deal o left join tbl_users as u on o.merchant_id=u.userid";
$select=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
 $offer_deal_det=@mysql_fetch_assoc($select);
$smarty->assign("offer_deal_det",$offer_deal_det);


if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}

$smarty->display( TEMPLATEDIR . '/modules/merchant-account/view_offer_deal.tpl');
$dbObj->Close();
?>

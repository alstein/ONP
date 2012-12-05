<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}



$sf="u.*";
$cnd="u.userid=".$_SESSION['csUserId'];
$tbl="tbl_users as u";

$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$user=@mysql_fetch_assoc($rs);
$arr=explode(",",$user['intrested_in']);
$deal_as_usual=$arr[0];
$right_now_deal=$arr[1];
$smarty->assign("deal_as_usual",$deal_as_usual);
$smarty->assign("right_now_deal",$right_now_deal);

$cat_preferance=explode(",",$user['category_preferance']);
$smarty->assign("cat_preferance",$cat_preferance);
$b_date = explode(" ",$user['birthdate']);
$birthdate = $b_date[0];



if(isset($_POST['Submit']))
{
        extract($_POST);

		$fl = array("business_name","address","phone_no","amount_spend","discount",'	outflow','redeem_from','redeem_to',"bid_validity",'amt_to_pin','accepted_to_paid');
		$vl = array($business_name,$address,$phone_no,$amt_spend,$discount,$outflow,$redeem_from,$redeem_to,$bid_validity,$amt_to_pin,$accepted_to_paid);
		$resIns = $dbObj->cgi('tbl_offer_deal',$fl,$vl,'');
	
}
$smarty->assign("user",$user);


if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}

$smarty->display( TEMPLATEDIR . '/modules/merchant-account/offer_deal_to_merchant.tpl');
$dbObj->Close();
?>

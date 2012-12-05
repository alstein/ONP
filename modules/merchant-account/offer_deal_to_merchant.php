<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!=2)
{
	header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(21);
$smarty->assign("row_meta",$row_meta);


$smarty->assign("seotitle",$seoname." - Deal History");

//todays date
$smarty->assign("todays_date",date("Y-m-d"));
//todays date

//get th merchant condition

$deal_cond_rs=$dbObj->cgs("tbl_deal_condition", "*", "merchant_id", $_GET['id1'], $ob, $ot, $prn);
$deal_cond_row=@mysql_fetch_assoc($deal_cond_rs);
$smarty->assign("deal_cond_row",$deal_cond_row);

//get th merchant condition

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

//**************Merchant Details************//
$sf="*";
$cnd="userid=".$_GET['id1'];
$tbl="tbl_users ";
$select_mechant_det=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$res_merchant_det=@mysql_fetch_assoc($select_mechant_det);
$bussines_name=$res_merchant_det['first_name']." ".$res_merchant_det['last_name'];
$address=$res_merchant_det['address1'];
$phone_no=$res_merchant_det['contact_detail'];
$smarty->assign("bussines_name",$res_merchant_det['business_name']);
$smarty->assign("address",$address);
$smarty->assign("phone_no",$phone_no);
//**************End Of Merchant Details************//

//**************Merchant Details************//
$sf1="*";
$cnd1="id='1'";
$tbl1="tbl_merchant_pay ";
$select_mechant_pay=$dbObj->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
$res_merchant_pay=@mysql_fetch_assoc($select_mechant_pay);
$merchant_pay=$res_merchant_pay['merchant_pay'];
$smarty->assign("merchant_pay",$merchant_pay);
//***********Find Out Merchant Pay On Offer Deal************************/
if(isset($_POST['Submit']))
{
        extract($_POST);
$merchant_id=$_GET['id1'];
// 		$fl = array("merchant_id","amount_spend","discount",'	outflow','product_name','redeem_from','redeem_to',"bid_validity",'amt_to_pin','accepted_to_paid');
// 		$vl = array($_GET['id1'],$amt_spend,$discount,$outflow,$product_name,$redeem_from,$redeem_to,$bid_validity,$amt_to_pay,$accepted_to_paid);
// 		$resIns = $dbObj->cgi('tbl_offer_deal',$fl,$vl,'');
		$authorisation="Authorization";
		header("location:".SITEROOT."/php_nvp_samples/SetExpressCheckout.php?paymentType=$authorisation&name=$product_name&amt=$amt_to_pay&quantity=1&merchant_id=$merchant_id&amount_spend=$amt_spend&discount=$discount&outflow=$outflow&product_name=$product_name&redeem_from=$redeem_from&redeem_to=$redeem_to&bid_validity=$bid_validity&amt_to_pin=$amt_to_pay&accepted_to_paid=$accepted_to_paid");

	
}
// $smarty->assign("user",$user);


if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}

if(isset($_SESSION['paymentmessage'])){
   $paymentmessage=$_SESSION['paymentmessage'];	
   unset($_SESSION['paymentmessage']);	
   $smarty->assign("paymentmessage",$paymentmessage);
  
}

if($_POST['submit']){
$_SESSION['amt_spend']=$_POST['amt_spend'];
$_SESSION['discount']=$_POST['discount'];
$_SESSION['netamount']=$_POST['netamount'];
$_SESSION['redeemflag']=$_POST['redeemflag'];
if($_SESSION['redeemflag']=="redeemon"){
	$_SESSION['redeem_from']=$_POST['redeem_from'];
	$_SESSION['bid_validity1']=$_POST['bid_validity1'];
	$_SESSION['temobvald']=$_POST['temobvald'];

	$_SESSION['redeem_from1']="";	
	$_SESSION['redeem_to']="";
	$_SESSION['bid_validity']="";
}elseif($_SESSION['redeemflag']=="redeembet"){
	$_SESSION['redeem_from1']=$_POST['redeem_from1'];
	$_SESSION['redeem_to']=$_POST['redeem_to'];
	$_SESSION['bid_validity']=$_POST['bid_validity'];

	$_SESSION['redeem_from']="";
	$_SESSION['bid_validity1']="";
	$_SESSION['temobvald']="";

}
$_SESSION['amt_to_pay']=$_POST['amt_to_pay'];
$_SESSION['accepted_to_paid']=$_POST['accepted_to_paid'];
$_SESSION['conditions']=$_POST['conditions'];
$_SESSION['temp_mer_id']=$_POST['temp_mer_id'];

$_SESSION['weekends']=$_POST['weekends'];
$_SESSION['addto_live_wire']=$_POST['addto_live_wire'];
header("location:".SITEROOT."/merchant-account/offer_deal_to_merchant_preview/");


}


$afterthreedays=Date('j F, Y', strtotime("+3 days"));
$aftereighteendays=Date('j F, Y', strtotime("+18 days"));

$datemessage="choose between ".$afterthreedays." and ".$aftereighteendays;
$smarty->assign("datemessage",$datemessage);

$smarty->display( TEMPLATEDIR . '/modules/merchant-account/offer_deal_mer.tpl');
//$smarty->display( TEMPLATEDIR . '/modules/merchant-account/offer_deal_to_merchant.tpl');
$dbObj->Close();
?>

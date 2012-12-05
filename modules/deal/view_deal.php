<?php
include_once('../../include.php');
if($_GET['sp']== "")
{
if(!isset($_SESSION['csUserId']) && !isset($_SESSION['csUserTypeid']))
{
	header("location:".SITEROOT); exit;
}
}

$select=$dbObj->customqry("select u.first_name,u.last_name,u.city,m.city_name,u.business_name from tbl_users u  left join mast_city m on u.city=m.city_id where u.userid='".$_SESSION['merchant_id']."'",'');
$res_select=@mysql_fetch_assoc($select);
$smarty->assign("deal",$res_select);

if(isset($_POST['Submit']))
{
    $merchant_id=$_SESSION['merchant_id'];
    $category=$_SESSION['deal_category'];
    $deal_name=$_SESSION['deal_title'];
    $originalprice=$_SESSION['original_price'];
    $sel_off=$_SESSION['discount_in_per'];
    $discount=$_SESSION['discount'];
    $offer_price=$_SESSION['offer_price'];
    $why_buy1=$_SESSION['why_buy1'];
    $why_buy2=$_SESSION['why_buy2'];
    $why_buy3=$_SESSION['why_buy3'];
    $why_buy4=$_SESSION['why_buy4'];
    $why_buy5=$_SESSION['why_buy5'];
    $condition=$_SESSION['conditions'];
    $lastdate=$_SESSION['deal_end_date'];
    $redeemfrom=$_SESSION['redeem_from'];
    $redeemto=$_SESSION['redeem_to'];
    $original_1=$_SESSION['deal_image'];
    $original_2=$_SESSION['deal_image1'];
    $original_3=$_SESSION['deal_image2'];
    $fan_only=$_SESSION['send_to_fan'];
    $all=$_SESSION['send_to_all'];
    $condition=$_SESSION['conditions'];
    $max_number=$_SESSION['max_deal_no'];
    $address=$_SESSION['valid_at_address'];
    $offer_details=$_SESSION['offer_details'];
    $shippingstatus=$_SESSION['shippingstatus'];
    if($fan_only!="" && $all!="")
    {
        $send_to=$fan_only.",".$all;
    }
    elseif($fan_only!="")
    {
        $send_to=$fan_only;
    }
    elseif($all!="")
    {
        $send_to=$all;
    }
    $fl = array("merchant_id","deal_category","deal_title","original_price","discount_in_per","discount",'offer_price','why_buy1','why_buy2',"why_buy3","why_buy4","why_buy5","conditions",'deal_end_date','redeem_from', "redeem_to","deal_image",'send_to',"posted_date",'status','max_deal_no','valid_at_address','offer_details','shippingstatus',"deal_image1","deal_image2",);
    $vl = array($merchant_id,$category,$deal_name,$originalprice,$sel_off,$discount,$offer_price,$why_buy1,$why_buy2,$why_buy3,$why_buy4,$why_buy5,$condition,$lastdate,$redeemfrom,$redeemto,$original_1,$send_to,date("Y-m-d H:i:s"),"active",$max_number,$address,$offer_details,$shippingstatus,$original_2,$original_3,);
    $resIns = $dbObj->cgi('tbl_deals',$fl,$vl,'');
    $_SESSION['msg']="Deal Added Successfully";
    if($resIns!="")
    {
        $_SESSION['merchant_id']="";
        $_SESSION['deal_category']="";
        $_SESSION['deal_title']="";
        $_SESSION['original_price']="";
        $_SESSION['discount_in_per']="";
        $_SESSION['discount']="";
        $_SESSION['offer_price']="";
        $_SESSION['why_buy1']="";
        $_SESSION['why_buy2']="";
        $_SESSION['why_buy3']="";
        $_SESSION['why_buy4']="";
        $_SESSION['why_buy5']="";
        $_SESSION['conditions']="";
        $_SESSION['deal_end_date']="";
        $_SESSION['redeem_from']="";
        $_SESSION['redeem_to']="";
        $_SESSION['deal_image']="";
        $_SESSION['deal_image1']="";
        $_SESSION['deal_image2']="";
        $_SESSION['send_to_fan']="";
        $_SESSION['send_to_all']="";
        $_SESSION['max_deal_no']="";
        $_SESSION['valid_at_address']="";
        $_SESSION['view_success_message']="1";
    }
		//@header("Location:".SITEROOT."/deal/create_deal");
		@header("Location:".SITEROOT."/merchant-account/merchant_profile_home/");
}


$smarty->display(TEMPLATEDIR . '/modules/deal/view_deal.tpl');
$dbObj->Close();
?>
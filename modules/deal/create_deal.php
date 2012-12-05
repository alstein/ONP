<?php
include_once('../../include.php');
if($_GET['sp']== "")
{
    if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!=3)
    {
            header("location:".SITEROOT); exit;
    }
}
//echo "<pre>";print_r($_SESSION);echo "</pre>";
$row_meta=$dbObj->getseodetails(6);
$smarty->assign("row_meta",$row_meta);

$select_addres=$dbObj->customqry("select u.*,c.city_name,u.business_name from tbl_users u left join mast_city c on u.city=c.city_id where userid='".$_SESSION['csUserId']."'","");
$res_address=mysql_fetch_assoc($select_addres);
$smarty->assign("address",$res_address);
if(isset($_POST['Submit']))
{
    extract($_POST);
    if($fan_only!="" && $all!="")
    {
        $send_to=$fan_only.",".$all;
    }
    elseif($fan_only!="")
    {
        $send_to=$fan_only;
    }
    else
    {
        $send_to=$all;
    }

    if($_FILES['deal_photo'])
    {
        $original_1 = newgeneralfileupload($_FILES['deal_photo'], "../../uploads/deal/", true); 
        $original['name'] = $original_1;
        $original['tmp_name'] = "../../uploads/deal/".$original_1;
		
        $path = "../../uploads/deal/thumbnail/";
        $width_array  = array(80);
        $height = 80;
        $path_array = array($path);
        resize_multiple_images_new($original, $width_array, $path_array, $height);

        $path = "../../uploads/deal/225x225/";
        $width_array  = array(225);
        $height = 225;
        $path_array = array($path);
        resize_multiple_images_new($original, $width_array, $path_array, $height);
    }
    
    if($_FILES['deal_photo1'])
    {
        $original_2 = newgeneralfileupload($_FILES['deal_photo1'], "../../uploads/deal/", true); 
        $original['name'] = $original_2;
        $original['tmp_name'] = "../../uploads/deal/".$original_2;

        $path = "../../uploads/deal/thumbnail/";
        $width_array  = array(80);
        $height = 80;
        $path_array = array($path);
        resize_multiple_images_new($original, $width_array, $path_array, $height);

        $path = "../../uploads/deal/225x225/";
        $width_array  = array(225);
        $height = 225;
        $path_array = array($path);
        resize_multiple_images_new($original, $width_array, $path_array, $height);
    }

    if($_FILES['deal_photo2'])
    {
        $original_3 = newgeneralfileupload($_FILES['deal_photo2'], "../../uploads/deal/", true); 
        $original['name'] = $original_3;
        $original['tmp_name'] = "../../uploads/deal/".$original_3;

        $path = "../../uploads/deal/thumbnail/";
        $width_array  = array(80);
        $height = 80;
        $path_array = array($path);
        resize_multiple_images_new($original, $width_array, $path_array, $height);

        $path = "../../uploads/deal/225x225/";
        $width_array  = array(225);
        $height = 225;
        $path_array = array($path);
        resize_multiple_images_new($original, $width_array, $path_array, $height);
    }

    $_SESSION['merchant_id']=$_SESSION['csUserId'];
    $_SESSION['deal_category']=$category;
    $_SESSION['deal_title']=$deal_name;
    $_SESSION['original_price']=$originalprice;
    $_SESSION['discount_in_per']=$sel_off;
    $_SESSION['discount']=$discount;
    $_SESSION['offer_price']=$offer_price;
    $_SESSION['why_buy1']=$why_buy1;
    $_SESSION['why_buy2']=$why_buy2;
    $_SESSION['why_buy3']=$why_buy3;
    $_SESSION['why_buy4']=$why_buy4;
    $_SESSION['why_buy5']=$why_buy5;
    $_SESSION['conditions']=$condition;
    $_SESSION['deal_end_date']=$lastdate;
    $_SESSION['redeem_from']=$redeemfrom;
    $_SESSION['redeem_to']=$redeemto;
    $addressneeded= $_POST['shipping-addr'];
    if($_POST['shipping-addr']==1){
        $_SESSION['shippingstatus']=$_POST['shipping-addr'];
    }

    if($_SESSION['deal_image']!="")
    {
        $original_1=$_SESSION['deal_image'];
        $_SESSION['deal_image']=$original_1;
    }else{
        $_SESSION['deal_image']=$original_1;
    }

    if($_SESSION['deal_image1']!=""){
        $original_2=$_SESSION['deal_image1'];
        $_SESSION['deal_image1']=$original_2;
    }else{
        $_SESSION['deal_image1']=$original_2;
    }
		
    if($_SESSION['deal_image2']!=""){
        $original_3=$_SESSION['deal_image2'];
        $_SESSION['deal_image2']=$original_3;
    }else{
        $_SESSION['deal_image2']=$original_3;
    }

    $_SESSION['send_to_fan']=$fan_only;
    $_SESSION['send_to_all']=$all;
    $_SESSION['conditions']=$condition;
    $_SESSION['max_deal_no']=$max_number;
    $_SESSION['valid_at_address']=$address;
    $_SESSION['offer_details']=$offer_details;
    @header("Location:".SITEROOT."/deal/".$resIns."/view_deal");
}
if(isset($_SESSION['msg']))
{
    $msg=$_SESSION['msg'];
    $smarty->assign("msg",$msg);
    unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR . '/modules/deal/create_deal.tpl');
$dbObj->Close();
?>
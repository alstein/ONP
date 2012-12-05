<?php
include_once('../../include.php');

$deal_idc=$_GET['deal_id']; 
$deal_id=$dbObj->sanitize($deal_idc);
$smarty->assign("deal_id",$deal_id);

if(!isset($_SESSION['csUserId']))
{
	$_SESSION['previous_page']=SITEROOT."/referfriend?deal_id=".$deal_id;
	header("location:".SITEROOT."/signin?st=buyer");
	exit;
}

if($referFriSett == 'no')
{
	header("location:".SITEROOT."/");
	exit;
}

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(30);
$smarty->assign("row_meta",$call_meta);

///////////Get the Deal_Name And Seller_Name start////////////////
	$rs=$dbObj->cgs("tbl_deal","*","deal_unique_id",$deal_id,"","","");
	$rec_dealid=@mysql_fetch_assoc($rs);
	$deal_title=$rec_dealid['title'];
	$deal_seller_name= getDealSellerFromId($rec_dealid['deal_unique_id']); //$rec_dealid['deal_from_seller_name'];
	$big_image=$rec_dealid['big_image'];
	$description=$rec_dealid['description'];
	$smarty->assign("deal_title",$deal_title);
	$smarty->assign("deal_seller_name",$deal_seller_name);
	$smarty->assign("big_image",$big_image);
	$smarty->assign("description",$description);
///////////Get the Deal_Name And Seller_Name end////////////////

//////////////////////////////////////////////////////
//Start code for Refer a friend 
//genrate the affiliate url
	$AFFILIATE_URL = "";

	if($_SESSION['csUserId'] > 0){
		$uniqid = uniqid();
		$userEmail = getUserData($_SESSION['csUserId'])->email;
		//check the email user already added for the same city same deal with same user id or email
		$qcuae = "select unique_id from tbl_deal_affiliate_users where deal_id=".$rec_dealid['deal_unique_id']." and email='".$userEmail."'";
		$rescuae = mysql_query($qcuae);
		$numcuae = @mysql_num_rows($rescuae);
		if($numcuae  > 0){
			$rowcuae = @mysql_fetch_object($rescuae);
			$uniqid = $rowcuae->unique_id;
		}else{
			$fieldsarray = "";
			$fieldsarray = array("deal_id" => $rec_dealid['deal_unique_id'],
							"user_id" => $_SESSION['csUserId'],
							"email" => $userEmail,
							"unique_id" => $uniqid);
			$dbObj->cgii('tbl_deal_affiliate_users',$fieldsarray,"");
		}
		$AFFILIATE_URL = SITEROOT."/affiliate/".$rec_dealid['deal_unique_id']."/".$uniqid;
	}

	$smarty->assign("AFFILIATE_URL",$AFFILIATE_URL);
//End code for refer a friend
//////////////////////////////////////////////////////


$smarty->display(TEMPLATEDIR . '/modules/referfriend/referfriend.tpl');
$dbObj->Close();
?>

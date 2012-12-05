<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
	if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!=3)
	{
		header("location:".SITEROOT); exit;
	}

$smarty->assign("seotitle",$seoname." - Deal Condition");

$row_meta=$dbObj->getseodetails(5);
$smarty->assign("row_meta",$row_meta);


if($_SESSION['msg'])

{

	$msg = $_SESSION['msg'];

	$smarty->assign("msg",$msg);

	unset($_SESSION['msg']);

}

if(isset($_POST['Submit']))
{
	extract($_POST);
	if($temp_min_offer_amt ==""){
		$deal_cond=$dbObj->customqry("INSERT INTO `tbl_deal_condition` (`deal_cond_id`, `min_offer_amt`, `amount`, `offer_weekend`, `condition`, `merchant_id`) VALUES (NULL, '".$min_amount_de."', '".$mimimum_offer_amount."', '".$offer_for_weekend."', '".$condition."', '".$_SESSION['csUserId']."')","");
			$_SESSION['msg']="Deal conditions added successfully.";
			header("location:".SITEROOT."/merchant-account/deal-conditions/");
	}else{
			$sf=array("min_offer_amt","amount","offer_weekend","`condition`");
			$sv=array($min_amount_de,$mimimum_offer_amount,$offer_for_weekend,$condition);
			$res=$dbObj->cupdt("tbl_deal_condition", $sf, $sv, "merchant_id", $_SESSION['csUserId'], "");
			$_SESSION['msg']="Deal conditions updated successfully.";
			header("location:".SITEROOT."/merchant-account/deal-conditions/");
	}
}	

$res=$dbObj->cgs("tbl_deal_condition", "*", "merchant_id", $_SESSION['csUserId'], $ob, $ot, "");
$row=@mysql_fetch_assoc($res);
//echo "<pre>";print_r($row);echo "</pre>";
$smarty->assign("deal_condition",$row);

$smarty->display(TEMPLATEDIR . '/modules/merchant-account/deal-conditions.tpl');
$dbObj->Close();
?>
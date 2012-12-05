<?php
include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');

if(isset($_SESSION['csUserId']))
{
    header("location:".SITEROOT . "/my-account-view");
}

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(14);
$smarty->assign("row_meta",$call_meta);


if(strlen(trim($_POST['submit'])) > 0)
{
	$objregister = new frontregister();

	if($objregister->addNewSeller($_POST) == "error")
	{
		//header("location:".SITEROOT."/buyer_registration"); exit;
	}
}


#--------------Get Country for Country dropdown--------------#


//         $cnd="status = 'Active'"; 
//         $selVal = (($input->post("countryid"))?$input->post("countryid"):"");
//         $countryCombo = $combo->getComboCountry('countryid','country','country ASC', $cnd, $selVal, "");
//         $smarty->assign("countryCombo", $countryCombo);
$row_country = array();
$rs1 = $dbObj->customqry("select * from mast_country where countryid = '225' and status='Active'","");
$row1 = @mysql_fetch_assoc($rs1);
if($row1){
$row_country[]=$row1;
}
$cnd= "c.status='Active' and countryid !=225";
$sf="c.*";
$ob="country ASC";
$res_country=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$num_country = @mysql_num_rows($res_country);
while($row_con = @mysql_fetch_assoc($res_country))
{
	$row_country[] = $row_con;
}
$smarty->assign("country",$row_country);
#--------------End Country for Country dropdown--------------#

#--------------Start State for State dropdown--------------#

$rs = $dbObj->customqry("select ms.* from mast_state ms LEFT JOIN mast_country mc ON ms.country_id=mc.countryid where mc.status='Active' AND active='1' order by state_name","");

if($rs != 'n')
{
	$state = array();
	while($row = @mysql_fetch_assoc($rs))
		$state[]=$row;
}

$smarty->assign("state", $state);

#----------------End State for State dropdown--------------#

#--------------START Get subscription data--------------#
	$rs_subscription = $dbObj->customqry("select * from tbl_subscription_package where status = 1", "");
	while($row_subscription = @mysql_fetch_assoc($rs_subscription))
	{
		$subscriptionData[] = $row_subscription;
	}

	$smarty->assign("subscriptionData", $subscriptionData);
#--------------END Get subscription data--------------#

#--------------START Get Paypal Business Account data--------------#
	$rs_paySett = $dbObj->gj("tbl_payment_setting", "*", "1","","", "", "", "");
	$paySettArray=@mysql_fetch_array($rs_paySett);
	$smarty->assign("paySettDetails",$paySettArray);
#--------------END Get Paypal Business Account data--------------#


    if(isset($_SESSION['msg']))
    {
        $smarty->assign("msg", $_SESSION['msg']);
        unset($_SESSION['msg']);
    }

    if(isset($_SESSION['msg_succ']))
    {
        $smarty->assign("msg_succ", $_SESSION['msg_succ']);
        unset($_SESSION['msg_succ']);
    }

$smarty->display(TEMPLATEDIR . '/modules/registration/seller_registration.tpl');
$dbObj->Close();
?>
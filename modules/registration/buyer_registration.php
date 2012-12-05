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

	if($objregister->addNewUser($_POST) == "error")
	{
		//header("location:".SITEROOT."/buyer_registration"); exit;
	}
}


#--------------Get Country for Country dropdown--------------#
        $cnd="status = 'Active'";
        $selVal = (($input->post("countryid"))?$input->post("countryid"):"");
        $countryCombo = $combo->getComboCountry('countryid','country','country ASC', $cnd, $selVal, "");
        $smarty->assign("countryCombo", $countryCombo);
#--------------End Country for Country dropdown--------------#

#--------------Get Country for Country dropdown--------------#
        $cnd="status = 'Active'";
        $selVal = (($input->post("city"))?$input->post("city"):"");
        $countryCombo = $combo->getComboCities('city_id','city_name','city_name ASC', $cnd, $selVal, "");
        $smarty->assign("cityCombo", $cityCombo);
#--------------End Country for Country dropdown--------------#

#-----------------Get Country START--------------------#
$row_country = array();
$rs1 = $dbObj->customqry("select * from mast_country where countryid = '225' and status='Active'","");
$row1 = @mysql_fetch_assoc($rs1);
if($row1){
$row_country[]=$row1;}
$cnd= "c.status='Active' and countryid !=225";
$sf="c.*";
$ob="country ASC";
$res_country=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$num_country = @mysql_num_rows($res_country);
while($row_con = @mysql_fetch_assoc($res_country))
{
	$row_country[] = $row_con;
}
// $res_country = $dbObj->cgs("mast_country","*","status","Active","country","ASC","");
// $num_country = @mysql_num_rows($res_country);
// $row_country = array();
// while($row_con = @mysql_fetch_assoc($res_country))
// {
// 	$row_country[] = $row_con;
// }
$smarty->assign("country",$row_country);
#-----------------Get Country END--------------------#

#-----------------Get State START--------------------#
$sqlstate="SELECT * FROM mast_state ms , mast_country mcou WHERE ms.country_id = mcou.countryid and mcou.status = 'Active'";
$sqlstrow=mysql_query($sqlstate)or die (mysql_error());
//$res_state = $dbObj->cgs("mast_state","*","active","1","state_name","ASC","");
$num_state = @mysql_num_rows($sqlstrow);
$row_state = array();
while($row_sta = @mysql_fetch_assoc($sqlstrow))
{
	$row_state[] = $row_sta;
}
$smarty->assign("state",$row_state);
#-----------------Get State END--------------------#

#-----------------Get city--------------------#
//$_re1 = $dbObj->cgs("mast_city","",array("status"),array("Active"),"city_name","ASC","");
$sqlcity="SELECT * FROM mast_city mc , mast_country mcou WHERE mc.country_id = mcou.countryid and mcou.status = 'Active'";
$cityrow=mysql_query($sqlcity)or die (mysql_error());
//$_re1 = $dbObj->cgs("mast_city","*","Status","Active","city_name","ASC","");
$num = @mysql_num_rows($cityrow);
$_arr = array();
while($_row2 = @mysql_fetch_assoc($cityrow))
{
	$_arr2[] = $_row2;
}
$smarty->assign("city",$_arr2);
#-----------------Get city--------------------#
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

$smarty->display(TEMPLATEDIR . '/modules/registration/buyer_registration.tpl');
$dbObj->Close();
?>
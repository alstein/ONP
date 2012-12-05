<?php

//$PATH_PREFIX = "../";
include_once('../../include.php');
include_once("../../includes/classes/combo.class.php");
// if($_SESSION['profilename']=="")
// {
// @header("Location:".SITEROOT);
// }

#--------------Get Country for Country dropdown--------------#
/*$cnd="status = 'Active'"; 
$selVal = (($_POST["countryid"])?$_POST["countryid"]:"");
$countryCombo = $combo->getComboCountry('countryid','country','country ASC', $cnd, $selVal, "");
$smarty->assign("countryCombo", $countryCombo);*/
#--------------End Country for Country dropdown--------------#

#--------------Get City for City dropdown--------------#
/*$cnd="status = 'Active'"; 
$selVal = (($_POST["cityid"])?$_POST["cityid"]:"");
$cityCombo = $combo->getComboCities('city_id','city_name','city_name ASC', $cnd, $selVal, "");
$smarty->assign("cityCombo", $cityCombo);*/
#--------------End Country for Country dropdown--------------#

#-----------------Get Country START--------------------#

/*$row_country = array();
$rs1 = $dbObj->customqry("select * from mast_country where countryid = '225' and status='Active'","");
$row1 = @mysql_fetch_assoc($rs1);
if($row1){
$row_country[]=$row1;}
$cnd= "c.status='Active' and countryid !=225";
$sf="c.*";
$ob="country ASC";
//$rs1=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$res_country=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");


//$res_country = $dbObj->cgs("mast_country","*","status","Active","country","ASC","");
$num_country = @mysql_num_rows($res_country);

while($row_con = @mysql_fetch_assoc($res_country))
{
    $row_country[] = $row_con;
}
*/
////////////
/*$res_country = $dbObj->cgs("mast_country","*","status","Active","country","ASC","");
$num_country = @mysql_num_rows($res_country);
$row_country = array();
while($row_con = @mysql_fetch_assoc($res_country))
{
	$row_country[] = $row_con;
}*/
//$smarty->assign("country",$row_country);
#-----------------Get Country END--------------------#

#-----------------Get State START--------------------#
/*$sqlstate="SELECT * FROM mast_state ms , mast_country mcou WHERE ms.country_id = mcou.countryid and mcou.status = 'Active'";
$sqlstrow=mysql_query($sqlstate)or die (mysql_error());
//$res_state = $dbObj->cgs("mast_state","*","active","1","state_name","ASC","");
$num_state = @mysql_num_rows($sqlstrow);
$row_state = array();
while($row_sta = @mysql_fetch_assoc($sqlstrow))
{
    $row_state[] = $row_sta;
}
$smarty->assign("state",$row_state);*/
#-----------------Get State END--------------------#

#-----------------Get city--------------------#
//$_re1 = $dbObj->cgs("mast_city","",array("status"),array("Active"),"city_name","ASC","");
/*$sqlcity="SELECT * FROM mast_city mc , mast_country mcou WHERE mc.country_id = mcou.countryid and mcou.status = 'Active'";
$cityrow=mysql_query($sqlcity)or die (mysql_error());
//$_re1 = $dbObj->cgs("mast_city","*","Status","Active","city_name","ASC","");
$num = @mysql_num_rows($cityrow);
$_arr = array();
while($_row2 = @mysql_fetch_assoc($cityrow))
{
    $_arr2[] = $_row2;
}
$smarty->assign("city",$_arr2);*/
#-----------------Get city--------------------#

if(isset($_POST['email'])!="")
{
    $_SESSION['merchantemail']=$_POST['email'];
    $_SESSION['merchantpassword']=$_POST['password'];
    $_SESSION['merchantfname']=$_POST['first_name'];
    $_SESSION['merchantlname']=$_POST['last_name'];
    $_SESSION['merchantbusiness_name']=$_POST['business_name'];
    $_SESSION['merchantcontact_person']=$_POST['contact_person'];
    $_SESSION['merchantaddress1']=$_POST['address1'];
    $_SESSION['concat_address']=$_POST['concat_address'];
    $_SESSION['merchantaddress2']=$_POST['address2'];
    $_SESSION['merchantaddress3']=$_POST['address3'];
    $_SESSION['merchantaddress4']=$_POST['address4'];
    $_SESSION['merchantaddress5']=$_POST['address5'];
    $_SESSION['merchantcountryid']=$_POST['countryid'];
    $_SESSION['merchantstate']=$_POST['state'];
    $_SESSION['merchantcityid']=$_POST['cityid'];
    $_SESSION['merchantphone']=$_POST['phone'];
    $_SESSION['merchantwebsite']=$_POST['website'];

    @header("Location:".SITEROOT."/registration/merchant_reg_profilepic");
    exit;
}

$smarty->display(TEMPLATEDIR.'/modules/registration/merchant_reg_profileinfo.tpl');

$dbObj->Close();
?>
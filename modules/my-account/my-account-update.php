<?php
include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(17);
$smarty->assign("row_meta",$call_meta);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/"); exit;
}

///////////////Updating records Start///////////////////////////

if(strlen(trim($_POST['submit'])) > 0)
{
	$objregister = new frontregister();

	if($objregister->updateUser($_POST,$_SESSION['csUserId']) == "error")
	{
		header("location:".SITEROOT."/my-account-update"); exit;
	}
}

///////////////Updating records End///////////////////////////

///////////////Fetching User Records START/////////////////////

$objregister = new frontregister();
$userData = $objregister->getUserDetails($_SESSION['csUserId']);

$smarty->assign("userData", $userData);
/*echo "<pre>";
print_r($userData);
exit;*/
/////////////Fetching User Records END///////////////////////

/////////////Fetching Country Records START///////////////////////

// $res_country = $dbObj->cgs("mast_country","*","status","Active","country","ASC","");
// $num_country = @mysql_num_rows($res_country);
// $row_country = array();
// while($row_con = @mysql_fetch_assoc($res_country))
// {
// 	$row_country[] = $row_con;
// }
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
$smarty->assign("country",$row_country);
#-----------------Get Country END--------------------#

#-----------------Get State START--------------------#
if($userData['countryid'])
{
  $sqlstate="SELECT ms.* FROM mast_state ms , mast_country mcou WHERE ms.country_id = mcou.countryid and mcou.countryid={$userData['countryid']} and mcou.status = 'Active'";

$sqlstrow=mysql_query($sqlstate)or die (mysql_error());
//$res_state = $dbObj->cgs("mast_state","*","active","1","state_name","ASC","");
$num_state = @mysql_num_rows($sqlstrow);
$row_state = array();
while($row_sta = @mysql_fetch_assoc($sqlstrow))
{
	$row_state[] = $row_sta;
}
}
$smarty->assign("state",$row_state);
#-----------------Get State END--------------------#
//  print_r($row_state[0]['id']);
//  exit;

#-----------------Get city--------------------#

//$_re1 = $dbObj->cgs("mast_city","",array("status"),array("Active"),"city_name","ASC","");
//$sqlcity="SELECT * FROM mast_city mc , mast_country mcou WHERE mc.country_id = mcou.countryid and mcou.status = 'Active'";
$sqlcity="SELECT * FROM mast_city mc , mast_state ms WHERE mc.state_id = ms.id and ms.id=".$userData['state_id']." and mc.status = 'Active'"; 
$cityrow=mysql_query($sqlcity)or die (mysql_error());
//$_re1 = $dbObj->cgs("mast_city","*","Status","Active","city_name","ASC","");
$num = @mysql_num_rows($cityrow);
$_arr = array();
while($_row2 = @mysql_fetch_assoc($cityrow))
{
	$_arr2[] = $_row2;
}

$smarty->assign("city",$_arr2);





/*
$rs = $dbObj->gj("mast_country","*", "status='active' and countryid=225", "country", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$country[]=$row;
}

$rs = $dbObj->gj("mast_country","*", "status='active' and countryid<>225", "country", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$country[]=$row;
}

$smarty->assign("country", $country);

/////////////Fetching Country Records END///////////////////////

/////////////Fetching State Records START///////////////////////

$rs = $dbObj->customqry("select ms.* from mast_state ms LEFT JOIN mast_country mc ON ms.country_id=mc.countryid where mc.status='Active' AND active='1' order by state_name","");

if($rs != 'n')
{
	$state = array();
	while($row = @mysql_fetch_assoc($rs))
		$state[]=$row;
}

$smarty->assign("state", $state);*/

/////////////Fetching State Records END///////////////////////

#--------------Get City for Presonal information dropdown--------------#
$cnd="status = 'Active'";
$selVal = (($_POST["city"])?$_POST["city"]:(($userData['city'])?$userData['city']:""));
$cityComboPersonal = $combo->getComboCities('city_id','city_name','city_name ASC', $cnd, $selVal, "");
$smarty->assign("cityComboPersonal", $cityComboPersonal);
#--------------End Get City for Presonal information dropdown--------------#

#--------------Get City for Presonal information dropdown--------------#
$cnd_shipp="status = 'Active'";
$selVal_shipp = (($_POST["s_city"])?$_POST["s_city"]:(($userData['s_city'])?$userData['s_city']:""));
$cityComboShipp = $combo->getComboCities('city_id','city_name','city_name ASC', $cnd_shipp, $selVal_shipp, "");
$smarty->assign("cityComboShipping", $cityComboShipp);
#--------------End Get City for Presonal information dropdown--------------#

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

$smarty->display(TEMPLATEDIR . '/modules/my-account/my-account-update.tpl');
$dbObj->Close();
?>
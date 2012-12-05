<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
$msobj= new message();

$row_meta=$dbObj->getseodetails(18);
$smarty->assign("row_meta",$row_meta);


if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="view_profile";
$smarty->assign("whose_profile",$whose_profile);
if(!isset($_POST['userid'])){
	$_SESSION['cities_name'] = array();
	$_SESSION['states_ids'] = array();
}

    #---------get mai category--------------------#
        $sql="select * from mast_deal_category where parent_id=0 order by category";
        $result = mysql_query($sql) or die('Error, query failed');
        $i = 0;
        while($row = mysql_fetch_array($result))
        {
                $tmp = array('id'=>$row['id'],
                 'category'=>$row['category']);
                $results[$i++] = $tmp;
        } 
	$smarty->assign("category",$results);
    $cnt_cat_preferance=@mysql_num_rows($result);

if($_GET['id1']!="")
{
$user=$_GET['id1'];
}
else
{
$user=$_SESSION['csUserId'];
}
#------Getting User Info--------------
$sf="u.*,c.city_name,mc.country,ms.state_name";
$cnd="u.userid=".$user;
$tbl="tbl_users as u left join mast_city c on u.city=c.city_id left join mast_country mc on u.countryid=mc.countryid left join mast_state ms on u.state_id=ms.id ";

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

$intrested_in=explode(",",$user['intrested_in']);

if($intrested_in[0]!=""){
// 	echo "==>".$intrest1=$intrested_in[0];
	$smarty->assign("intrest1",$intrest1);
}

if($intrested_in[1]!=""){
// 	echo "==>".$intrest2=$intrested_in[1];
	$smarty->assign("intrest2",$intrest2);
}




$smarty->assign("birthdate",$birthdate);

$state_id=$user['state'];

$stateid11 = @explode(",", $user['mulitple_state']);
$cityid11 = @explode(",", $user['multiple_city']);
$ids = array_pop($stateid11);
$cityid = array_pop($cityid11);
array_push($stateid11,$ids);
array_push($cityid11,$cityid);


#----Getting User Types-------------------------------
$sql_type="SELECT * FROM mast_usertype where typeid != 3";
$rs=$dbObj->customqry($sql_type,false);
while($row=@mysql_fetch_array($rs))
	$usertype[]=$row;
$smarty->assign("usertype",$usertype);
#---------END--------------------------------------


$citysql = $dbObj->cgs("mast_city","*","status","Active","","","");
   while($cityres =mysql_fetch_array($citysql))
   {
      $citylst[]=$cityres;
   }
$smarty->assign("city",$citylst);

#-------------access levels-#
$rs1=$dbObj->cgs("mast_levels","","","","","","0");
while($rows=@mysql_fetch_array($rs1))
{
	$levels[] = $rows;
}
$smarty->assign("levels",$levels);

#------end----------------#
$smarty->assign("user",$user);

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

$smarty->assign("country",$row_country);
#-----------------Get Country END--------------------#

#-----------------Get State START--------------------#
if($user['countryid'])
{
  $sqlstate="SELECT ms.* FROM mast_state ms , mast_country mcou WHERE ms.country_id = mcou.countryid and mcou.countryid={$user['countryid']} and mcou.status = 'Active'";

$sqlstrow=mysql_query($sqlstate)or die (mysql_error());
$num_state = @mysql_num_rows($sqlstrow);
$row_state = array();
while($row_sta = @mysql_fetch_assoc($sqlstrow))
{
	$row_state[] = $row_sta;
}
}
$smarty->assign("state",$row_state);
#-----------------Get State END--------------------#

#-----------------Get city--------------------#

$sqlcity="SELECT * FROM mast_city mc , mast_state ms WHERE mc.state_id = ms.id and ms.id=".$user['state_id']." and mc.status = 'Active'"; 
$cityrow=mysql_query($sqlcity)or die (mysql_error());
$num = @mysql_num_rows($cityrow);
$_arr = array();
while($_row2 = @mysql_fetch_assoc($cityrow))
{
	$_arr2[] = $_row2;
}

$smarty->assign("city",$_arr2);
#-----------------Get city--------------------#




#--------------Get Country for Country dropdown--------------#
	$cnd="status = 'Active'";
	$selVal = (($user["countryid"])?$user["countryid"]:"");
	$countryCombo = $combo->getComboCountry('countryid','country','country ASC', $cnd, $selVal, "");
	$smarty->assign("countryCombo", $countryCombo);
#--------------End Country for Country dropdown--------------#

#--------------Get City for City dropdown--------------#
	$cnd="status = 'Active'"; 
	$selVal = (($user["city"])?$user["city"]:"");
	$cityCombo = $combo->getComboCities('city_id','city_name','city_name ASC', $cnd, $selVal, "");
	$smarty->assign("cityCombo", $cityCombo);
#--------------End Country for Country dropdown--------------#



if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}

//Get Seller type
$rs1=mysql_query("select seller_type_id,seller_type_name from tbl_seller_type where Active=1");
while($row1=@mysql_fetch_assoc($rs1)){
   $seller1[]=$row1;
}

$smarty->assign("seller1",$seller1);

$smarty->assign("inmenu", "user");
if($update_flag==1)
{
@header("Location:".SITEROOT."/editprofile");
exit;
}
$smarty->display( TEMPLATEDIR . '/modules/my-account/view_profile.tpl');
$dbObj->Close();
?>

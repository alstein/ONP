<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
//require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}



if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!='2')
{
	header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(12);
$smarty->assign("row_meta",$row_meta);



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


#------Getting User Info--------------
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


if(isset($_POST['userid']))
{

	$zipCode=$_POST['zipcode'];
	$city=$_POST['city'];
/*
	if($_POST['zipcode'] != ""){
		$p=explode(" ",$_POST['zipcode']);
		if(strlen($p[0])>4){
			$zip=$p[0][0].$p[0][1].$p[0][2].$p[0][3];
			$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
			if(!$city){
				$zip=$p[0][0].$p[0][1].$p[0][2];
				$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
				$row=@mysql_fetch_assoc($rs);
				$city=$row['city'];
			}
		}else{
			$rs=$dbObj->cgs("zipData", "*", "zipcode",$p[0], "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
		}
	}
	if($_POST['zipcode'] == ""){
		$foundCity =$_POST['city'];
		$rs=$dbObj->cgs("zipData", "*", "city", $foundCity, "zipcode ASC", "", "");
		$row=@mysql_fetch_assoc($rs);
		$zip=$row['zipcode'];
	}*/

        extract($_POST);

	$fullname = $first_name." ".$last_name;
	$username = str_replace(" ","_",$first_name)."_".str_replace(" ","_",$last_name);
	$category_array=$_POST['chk_category'];
	$cat=$category_array[0];
	for($i=1;$i<$cnt_cat_preferance;$i++)
	{
		if($category_array[$i]=="")
		{
		$cat=$cat;
		}
		else
		{
		$cat=$cat.",".$category_array[$i];
		}

	}


	if($_POST['right_now_deal']!="" && $_POST['usual_deal']!="")
	{
	$intrested_in=$_POST['right_now_deal'].",".$_POST['usual_deal'];
	}
	elseif($_POST['usual_deal']!="")
	{
	$intrested_in=$_POST['usual_deal'];
	}
	elseif($_POST['right_now_deal']!="")
	{
	$intrested_in=$_POST['right_now_deal'];
	}


	$verification = 0;
        if($membertype == 3)
            $verification = 1;

if($_POST['deal_thr_email']!="")
	$deal_thr_email="yes";
else
	$deal_thr_email="no";

	if($password!="")
	{
		$fl = array("first_name","last_name","fullname","address1",'password','email','usertypeid',"signup_date",'countryid','state_id','city', 'postalcode','status','contact_detail','gender','birthdate','rel_status','category_preferance','intrested_in','grad_college','	under_grad_college','movies','music','books','tv','activities','deal_by_email');
		$vl = array($first_name,$last_name,$fullname,$address,md5($password),$email,2,date("Y-m-d H:i:s"),$countryid,$state,$cityid,$zipCode,"Active",$contactnumber,$gender,$birthday,$rel_status,$cat,$intrested_in,$college,$under_grad_college,$movies,$music,$books,$tv,$activities,$deal_thr_email);
		$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_SESSION['csUserId'],'');
		$update_flag=1;
		if($gender=='Male')
		{
		$h="his";
		}else
		{
		$h="her";
		}
		$msg_activity="$fullname has changed  ".$h." profile";
		$timestamp=date("Y-m-d H:i:s");
// 		$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid)values('".$msg_activity."','edit_profile','','','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."') ","");
		$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid)values('".$msg_activity."','edit_profile','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."') ","");
		$_SESSION['csFullName']=$fullname;

		$_SESSION['msg']="Profile updated successfully";
		
	}else
	{
		$fl = array("first_name","last_name","fullname","address1",'email','usertypeid',"signup_date",'countryid','state_id','city', 'postalcode','status','contact_detail','gender','birthdate','rel_status','category_preferance','intrested_in','grad_college','under_grad_college','movies','music','books','tv','activities','deal_by_email');
		$vl = array($first_name,$last_name,$fullname,$address,$email,2,date("Y-m-d H:i:s"),$countryid,$state,$cityid,$zipCode,"Active",$contactnumber,$gender,$birthday,$rel_status,$cat,$intrested_in,$college,$under_grad_college,$movies,$music,$books,$tv,$activities,$deal_thr_email);
		$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_SESSION['csUserId'],'');
		$update_flag=1;
		if($gender=='Male')
		{
		$h="his";
		}else
		{
		$h="her";
		}
		$url="<a href=".SITEROOT."/my-account/".$_SESSION['csUserId']."/my_profile_home target=_blank>$fullname</a>";
		$msg_activity="$url has changed ".$h." profile";
		$timestamp=date("Y-m-d H:i:s");
		$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid)values('".$msg_activity."','edit_profile','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."') ","");;
		$_SESSION['csFullName']=$fullname;
		$_SESSION['msg']="Profile updated successfully";
	}

        

	//$s=$msobj->showmessage(3);
	//$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

	
}
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
$smarty->display( TEMPLATEDIR . '/modules/my-account/edit_profile.tpl');
$dbObj->Close();
?>

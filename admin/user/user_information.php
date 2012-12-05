<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(!isset($_POST['userid'])){
	$_SESSION['cities_name'] = array();
	$_SESSION['states_ids'] = array();
}

#------Getting User Info--------------
$sf="u.*";
$cnd="u.userid=".$_GET['userid'];
$tbl="tbl_users as u";

$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$user=@mysql_fetch_assoc($rs);

$state_id=$user['state'];

$stateid11 = @explode(",", $user['mulitple_state']);
$cityid11 = @explode(",", $user['multiple_city']);
$ids = array_pop($stateid11);
$cityid = array_pop($cityid11);
array_push($stateid11,$ids);
array_push($cityid11,$cityid);


#----Getting User Types-------------------------------
//$rs=$dbObj->cgs("mast_usertype","","","","","","");
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
	}

  extract($_POST);

		$fullname = $first_name." ".$last_name;

      if($password!="")
      {
            $fl = array("first_name","last_name","fullname","username",'email','password','city','postalcode','status');
            $vl =  array($first_name,$last_name,$fullname,$username,$email,md5($password),$city, $zipCode,$status);
      }else
      {
      $fl = array("first_name","last_name","fullname","username",'email','city','postalcode','status');
      $vl =  array($first_name,$last_name,$fullname,$username,$email,$city, $zipCode,$status);
      }
      $rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_GET['userid'],'');
  		$s=$msobj->showmessage(3);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

		if($_GET['userid'] == 1){
			header("Location:".SITEROOT."/admin/user/manage_admin.php");
			exit;
		}else{
			header("Location:".SITEROOT."/admin/user/users_list.php");
			exit;
		}

}


$smarty->assign("user",$user);

if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}

$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/user_information.tpl');
$dbObj->Close();
?>
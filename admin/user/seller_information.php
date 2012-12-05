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
// 	print_r($_POST);exit;
if(isset($_POST['email'])){

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

      if($password!=""){
         $fl = array("first_name","last_name","fullname","username",'password','email','usertypeid',"title","address1","address2",'city', 'postalcode',"contact_detail","company_type","limited_comp","vat_reg","activiti");
         $vl =  array($first_name,$last_name,$fullname,$username,md5($password),$email,3,$title,$address1,$address2,$city,$zipCode,$contactno,$company_type,$limited_comp,$vat_reg,$activity);
      }else{
        $fl = array("first_name","last_name","fullname","username",'email','usertypeid',"title","address1","address2",'city', 'postalcode',"contact_detail","company_type","limited_comp","vat_reg","activiti");
        $vl =  array($first_name,$last_name,$fullname,$username,$email,3,$title,$address1,$address2,$city,$zipCode,$contactno,$company_type,$limited_comp,$vat_reg,$activity);
      }
      $rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_GET['userid'],'');
  		$s=$msobj->showmessage(3);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

		header("Location:".SITEROOT."/admin/user/seller_list.php");
		exit;


}


$smarty->assign("user",$user);

if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}

$rs1=mysql_query("select seller_type_id,seller_type_name from tbl_seller_type where Active=1");
while($row1=@mysql_fetch_assoc($rs1)){
   $seller1[]=$row1;
}

$smarty->assign("seller1",$seller1);

$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/seller_information.tpl');
$dbObj->Close();
?>
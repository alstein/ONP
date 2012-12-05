<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

// edit start
if(isset($_POST['business_id'])){

	extract($_POST);
	if($_FILES['photo']['name'] || $password!=''){

	$photo_name=uploadandresize($_FILES['photo'], '../../uploads/bussiness_photo/big_image', '../../uploads/bussiness_photo/thumbnail', 300, 300);
		$bussiness_picture=$photo_name['thumbnail'];
		$fl=array( "bussiness_cat_id","name","website","area_code","phone","add1","add2","city","state","zip","bussiness_picture","comment");
		$vl=array($categoryid,$Bname,$website,$area_code,$phone,$add1,$add2,$city,$state,$zip,$bussiness_picture,$comment);
		$rs = $dbObj->cupdt('tbl_bussiness',$fl,$vl,'business_id',$_GET['business_id'],'');
	}else{	
		$fl=array( "bussiness_cat_id","name","website","area_code","phone","add1","add2","city","state","zip","comment");
		$vl=array($categoryid,$Bname,$website,$area_code,$phone,$add1,$add2,$city,$state,$zip,$comment );
		$rs = $dbObj->cupdt('tbl_bussiness',$fl,$vl,'business_id',$_GET['business_id'],'');
	}
	if($_FILES['logo']['name'] || $password!=''){
		$bussiness_picture =$_FILES['logo']['name'];		
		$logo_name=uploadandresize($_FILES['logo'], '../../uploads/bussiness_photo/logo', '../../uploads/bussiness_photo/logo/thumbnail', 200, 200);
		$logo=$logo_name['thumbnail'];
		$fl=array("logo");
		$vl=array($logo);
		$rs = $dbObj->cupdt('tbl_bussiness',$fl,$vl,'business_id',$_GET['business_id'],'');
	}

	$rs = $dbObj->cgs('tbl_bussiness','userid','business_id',$_GET['business_id'],'','','');
		$row=@mysql_fetch_array($rs);
	$buss_userid=$row['userid'];
	if($buss_userid<>"0"){
		$fl=array("first_name","last_name","email","position","contactno");//
		$vl=array($first_name,$last_name,$email,$position,$contactno);//
		$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$buss_userid,'');
	}
	if($password<>""){
		$fl=array("password"); $vl=array(md5($password));
	//rs = $dbObj->cupdt('tbl_bussiness',$fl,$vl,'business_id',$_GET['business_id'],'');
		if($buss_userid<>"0"){
			$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$buss_userid,'');
		}	
	}
		$s=$msobj->showmessage(14);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	header("Location:".SITEROOT."/admin/user/bussiness_list.php");
	exit;
}
//edit end

#------Getting bussiness Info--------------
$sf="";
$tbl="tbl_bussiness b INNER JOIN tbl_bussiness_category c ON b.bussiness_cat_id = c.categoryid";
if($_GET['business_id']){	$cnd="  b.business_id =". $_GET['business_id'];	}

$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$row=@mysql_fetch_assoc($rs);
$buss_userid=$row['userid'];
$state_id=$row['state'];

#----------END0---------------------
#------Getting Cntact info----------

if($buss_userid){
	$sf="";
	$tbl="tbl_users";
	$cnd="  userid =". $buss_userid;	
	$rs_user=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
	$row_user=@mysql_fetch_assoc($rs_user);
	$smarty->assign("row_user",$row_user);
	$row['first_name']=$row_user['first_name'];	
	$row['last_name']=$row_user['last_name'];
	$row['position']=$row_user['position'];
	$row['email']=$row_user['email'];
	$row['contactno']=$row_user['contactno'];	
}

$smarty->assign("row",$row);
#-------end Cntact info-------------

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

#-----Bussiness Category type List start--------
	$rs=$dbObj->cgs("tbl_bussiness_category","","","","","","");
	while($row=@mysql_fetch_array($rs))
		$BCategory[]=$row;
	$smarty->assign("BCategory",$BCategory);
#--------Bussiness Category type ListEND-------------
#-----School donation type List start--------
	$rs1=$dbObj->cgs("mast_school_donation_percentage","","","","","","");
	while($row1=@mysql_fetch_array($rs1))
		$don_per[]=$row1;
	$smarty->assign("don_per",$don_per);
#--------School donation type List END-------------
#-----fine prints type List start--------
	$rs_fine_prints=$dbObj->cgs("mast_fine_prints","","","","","","");
	while($row_fine_prints=@mysql_fetch_array($rs_fine_prints)){
	$fine_prints[]=$row_fine_prints;
	}
	
	$smarty->assign("fine_prints",$fine_prints);
#--------fine prints type List END-------------
$re1 = $dbObj->cgs("mast_state","id,state_name",array("country_id","active"),array('223',1),"state_name","","");
$i=0;
$city = array();
$state = array();
	while($row2 = @mysql_fetch_assoc($re1)){
		$state[$i]['state_name'] = $row2['state_name'];
		$state[$i]['id'] = $row2['id'];
		$i++;
	}
$smarty->assign("state",$state);

// Get US cities	
	$re = $dbObj->cgs("mast_city","city_id,city_name",array("state_id","con_id","active") ,array($state_id,'223',1),"","","");
	$i=0;
	$city = array();
	while($row1 = @mysql_fetch_assoc($re)){
		$city[$i]['city_name'] = $row1['city_name'];
		$city[$i]['city_id'] = $row1['city_id'];
		$i++;
	}
$smarty->assign("city",$city);
$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/bussiness_information.tpl');
$dbObj->Close();
?>

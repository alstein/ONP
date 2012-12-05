<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once('../../includes/class.message.php');
$msobj= new message();


if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT. "/admin/login/index.php");

if(isset($_POST['submit'])){

extract($_POST);
	if($_GET['categoryid']){
		$fields = array( "category" , "description" , "seotitle","seokeyword","seoabstract","seosubject" );
		$values = array( $category , $description ,$title,$keyword,$abstract,$subject);
		$wf = "categoryid";
		$wv = $_POST['categoryid'];
		
		$rs = $dbObj ->cupdt('tbl_bussiness_category' , $fields , $values , $wf , $wv , ""); 		
				$s=$msobj->showmessage(19);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}else{
		$fields = array( "category" , "description" , "seotitle","seokeyword","seoabstract","seosubject" );
		$values = array( $category , $description ,$title,$keyword,$abstract,$subject);
		
		$rs = $dbObj ->cgi('tbl_bussiness_category' , $fields , $values , ""); 		
				$s=$msobj->showmessage(18);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("Location:".SITEROOT."/admin/user/bussiness_category.php");
	exit;
}


#----Getting User Types-------------------------------
$rs=$dbObj->cgs("tbl_bussiness_category","","categoryid",$_GET['categoryid'],"","","");
while($row=@mysql_fetch_array($rs))
	$category=$row;
$smarty->assign("category",$category);
#---------END--------------------------------------

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/add_bussiness_category.tpl');
$dbObj->Close();
?>
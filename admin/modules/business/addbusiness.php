<?php
ob_start();
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/common.lib.php");
	include_once("../../../includes/paging.php");
	include_once('../../../includes/class.message.php');
$msobj= new message();


#-------------edit reco----------------------------
$sql_type="SELECT * FROM tbl_business where bcid=".$_GET['cid'];
$rs=$dbObj->customqry($sql_type,false);
$brec=@mysql_fetch_array($rs);
$smarty->assign("brec",$brec);

$oldimage = $brec['image'];
//echo $oldimage; exit;
// echo "<pre>"; print_r($brec);exit;
#--------END-------------






if($_POST['submit'])
{

//echo $oldimage;exit;
//print_r($_POST);exit;
  extract($_POST);

				if($_FILES['bphoto']['name'])
				{
				$photo_name=uploadandresize($_FILES['bphoto'], '../../../uploads/business', '../../../uploads/business/thumbnail', 150, 150);$bussiness_picture=$photo_name['thumbnail'];
				$bussiness_picture=$photo_name['thumbnail'];
				}

				if($bussiness_picture)
				{
				$bussiness_picture=$bussiness_picture;
				}
				else
				{
				$bussiness_picture = $oldimage;
				}


if($_GET['cid'])
{
	$cid = $_GET['cid'];	
      	$fl = array("bcname","image","city","state","website","email","contact_name","phone","comments");
	$vl = array($businessname,$bussiness_picture,$city,$state,$wsite,$email,$cname,$phone,$comment);
	$dbres = $dbObj->cupdt('tbl_business', $fl , $vl, 'bcid' ,  $cid , "0");
      	$s=$msobj->showmessage(112);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
else
{
      $fl = array("bcname","image","city","state","website","email","contact_name","phone","comments","active","postdate" );
      $vl = array($businessname,$bussiness_picture,$city,$state,$wsite,$email,$cname,$phone,$comment,$status,date("Y-m-d H:i:s"));
      $rs = $dbObj->cgi('tbl_business',$fl,$vl,'');
      	$s=$msobj->showmessage(14);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
        header("Location:".SITEROOT."/admin/modules/business/buseness.php");
        exit;
}

$citysql = $dbObj->cgs("mast_city","*","active_city",1,"","","");
   while($cityres =mysql_fetch_array($citysql))
   {
      $citylst[]=$cityres;
   }
$smarty->assign("city",$citylst);




if(isset($_SESSION['msg'])){ $smarty->assign("msg", $_SESSION['msg']); unset($_SESSION['msg']);}

$smarty->display(TEMPLATEDIR . '/admin/modules/business/addbusiness.tpl');
$dbObj->Close();
?>

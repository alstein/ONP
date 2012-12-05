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





if(isset($_SESSION['msg'])){ $smarty->assign("msg", $_SESSION['msg']); unset($_SESSION['msg']);}

$smarty->display(TEMPLATEDIR . '/admin/modules/business/view.tpl');
$dbObj->Close();
?>

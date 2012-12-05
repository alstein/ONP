<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$bannerid = implode(", ", $bannerid);
	if($action == "Delete")
	{
		$del_temp = $dbObj->customqry("select image_affilite from tbl_banner where id in (".$bannerid.")","");
		while($r=mysql_fetch_object($del_temp))
		{
		 @unlink("../../../uploads/banner/".$r->image_affilite);
		}
		$temp = $dbObj->customqry("delete from tbl_banner where id in (".$bannerid.")","");
		$_SESSION['msg']="<span class='success'>Background has been deleted successfully.</span>";
	}
	
	if($action == "Active")
	{
		$temp = $dbObj->customqry("update tbl_banner set status='Active' where id in (".$bannerid.")","");
		$_SESSION['msg']="<span class='success'>Background has been activated successfully.</span>";
	}
	if($action == "Inactive")
	{
		$temp = $dbObj->customqry("update tbl_banner set status='Inactive' where id in (".$bannerid.")","");
		$_SESSION['msg']="<span class='success'>Background has been inactivated successfully.</span>";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------END-----------#
if(!isset($_GET['page']))
{

$page =1;
}
else
{
$page=$_GET['page'];
$page = $page;
}
$adsperpage =5;
$StartRow = $adsperpage * ($page-1);
$l =  $StartRow.','.$adsperpage;
#--------------------------------------#

$sf = "*";
$tbl = "tbl_banner as a";
$cnd = "1";


$rs = $dbObj->gj($tbl, $sf , $cnd, "id", "", "ASC", $l, "");
while($row = @mysql_fetch_assoc($rs))
 	$banner[] = $row;
$smarty->assign("banner",$banner);

/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj($tbl,$sf,$cnd, "", "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "manage_affilite_banner.php?search=" . $_GET['search'];
	else
		$firstlink = "manage_affilite_banner.php?";
	$seperator = '&page=';
	$baselink  = $firstlink; 
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	 $_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR . '/admin/modules/affilite/manage_affilite_banner.tpl');

$dbObj->Close();
?>
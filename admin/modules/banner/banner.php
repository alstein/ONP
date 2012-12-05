<?php 

include_once("../../../include.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
extract($_GET);
extract($_POST);
//print_r($_POST);
$banner_id=$_GET['banner_id'];
//echo "$banner_id";

$smarty->assign("b",$banner_id);
//print_r($banner_id);
#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$id = implode(", ", $id);

	if($_POST['action'] == "active")
		{
			$id=$dbObj->customqry("update mast_banners set status='1' where id in (".$id.")", "");
			$_SESSION["msg"] = "<span class='success'>Banners(s) Activated Successfully.</span>";
		}

	elseif($_POST['action'] == "inactive")
		{
			$qry = "update mast_banners set status='0' where id in (". $id.")";
			$id=$dbObj->customqry($qry, "");
			$_SESSION["msg"] = "<span class='success'>Banners(s) Inactivated Successfully.</span>";
		}

	if($action == "delete")
	{	
		//print_r($_POST);
		$temp = $dbObj->customqry("delete from mast_banners where id in (".$id.")","");
		$_SESSION['msg']="<span class='success'>Banners(s) Deleted Successfully.</span>";
	}

		header("Location:" . $_SERVER['HTTP_REFERER']);
		exit;
	
}
#---------END-----------#

#------------Pagination Part-1------------#
$orderby = (stripslashes($_GET['orderby'])?stripslashes($_GET['orderby']):" location_name asc");

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/

if( $_GET['banner_id']=='')
	$cnd = "1";
else
	
$cnd= "b.banner_id =".$_GET['banner_id'];
//print_r($cnd);

$sf="b.*,b1.*";
$ob="b.banner";
$tbl = "mast_banners as b LEFT JOIN mast_bannerlist as b1 ON b.banner_id = b1.banner_id";
$rs=$dbObj->gj($tbl,$sf,$cnd, $orderby, "", "",$l, "");

while($row=@mysql_fetch_array($rs))
{
	
	
	$banner[]=$row;
}
//echo "<pre>";print_r($banner);echo "</pre>";
$smarty->assign("banner",$banner);
//print_r($banner);

/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj($tbl,$sf,$cnd, $orderby, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "banner.php?search=" . $_GET['search'];
	else
		$firstlink = "banner.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}
#-----------------------------------#


	$smarty->display(TEMPLATEDIR.'/admin/modules/banner/banner.tpl');

	$dbObj->Close();
?>

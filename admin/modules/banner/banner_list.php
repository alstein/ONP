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

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$banner_id = implode(", ", $banner_id);

	if($_POST['action'] == "active")
		{
			$id=$dbObj->customqry("update mast_bannerlist set active='1' where banner_id in (".$banner_id.")", "");
			$_SESSION["msg"] = "<span class='success'>Banners(s) Activated Successfully.</span>";
		}

	elseif($_POST['action'] == "inactive")
		{
			$qry = "update mast_bannerlist set active='0' where banner_id in (". $banner_id.")";
			$id=$dbObj->customqry($qry, "");
			$_SESSION["msg"] = "<span class='success'>Banners(s) Inactivated Successfully.</span>";
		}

	if($action == "delete")
		{
			$temp = $dbObj->customqry("delete from mast_bannerlist where banner_id in (".$banner_id.")","");
			@mysql_query("delete from mast_banners where banner_id in (".$banner_id.")");

			$_SESSION['msg']="<span class='success'>Banners(s) Deleted Successfully.</span>";
		}

		header("Location: banner_list.php");
		exit;
	
}
#---------END-----------#

#------------Pagination Part-1------------#

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/
$orderby = (stripslashes($_GET['orderby'])?stripslashes($_GET['orderby']):" name asc");


if(!isset($_GET['search']))
	$_GET['search'] = "";
$cnd= "b.name LIKE '%".$_GET['search']."%'";
$sf="b.*";
$ob="name";
$rs=$dbObj->gj("mast_bannerlist b",$sf,$cnd, $orderby, "", "", $l, "");

while($row=@mysql_fetch_array($rs))
{
	$banner[]=$row;
}

$smarty->assign("banner",$banner);

/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj("mast_bannerlist b",$sf,$cnd, $orderby, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "bannerlist.php?search=" . $_GET['search'];
	else
		$firstlink = "bannerlist.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}
#-----------------------------------#

	$smarty->display(TEMPLATEDIR.'/admin/modules/banner/banner_list.tpl');

	$dbObj->Close();
?>
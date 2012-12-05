<?
	include_once("../../include.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Perform Action--------------#
if(isset($_POST['action'])){
	extract($_POST);
	$id = implode(", ", $countryid);

	if($_POST['action'] == "active")
	{
		$id=$dbObj->customqry("update mast_countryname set active='1' where id in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(62)."</span>";
	}
	elseif($_POST['action'] == "inactive")
	{
		$qry = "update mast_countryname set active='0' where id in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(61)."</span>";
	}
	elseif($_POST['action'] == "delete")
	{
		$id=$dbObj->customqry("delete from mast_countryname where id in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(60)."</span>";
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
#--------END-------------#

/*------------Pagination Part-1------------*/
if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/

if(!isset($_GET['search']))
	$_GET['search'] = "";
$cnd= "c.country LIKE '%".$_GET['search']."%'";
$sf="c.*";
$ob="country";
$rs=$dbObj->gj("mast_countryname c",$sf,$cnd, $ob, "", "", $l, "");

while($row=@mysql_fetch_array($rs))
{
	$country[]=$row;
}
$smarty->assign("country",$country);

/*----------Pagination Part-2--------------*/

$rs=$dbObj->gj("mast_countryname c",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "country_list.php?search=" . $_GET['search'];
	else
		$firstlink = "country_list.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

/*-----------------------------------*/
if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR . '/admin/mastermanagement/country_list.tpl');
?>
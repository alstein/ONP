<?
include_once('../../include.php');

if(!isset($_SESSION['duAdmId']))
header("location:".SITEROOT . "/admin/login/index.php");

#--------Perform Action--------------#
if(isset($_POST['action']))
{
	extract($_POST);
	$id = implode(", ", $categoryid);
	//echo $id;

	if($_POST['action'] == "active")
		{
			$id=$dbObj->customqry("update mast_deal_category set active='1' where id in (".$id.")", "");
			//$_SESSION["msg"] = "<span class='success'>".getErrorMessage(50)."</span>";
		}

	elseif($_POST['action'] == "inactive")
		{
			$qry = "update mast_deal_category set active='0' where id in (". $id.")";
			$id=$dbObj->customqry($qry, "");
			//$_SESSION["msg"] = "<span class='success'>".getErrorMessage(49)."</span>";
		}	

	if($_POST['action'] == "delete")
	{
		$id=$dbObj->customqry("delete from mast_deal_category where id in (". $id.")", "");
		//$_SESSION["msg"] = "<span class='success'>".getErrorMessage(64)."</span>";
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
	$adsperpage =10;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/
//echo $id;

if(!isset($_GET['search']))
	$_GET['search'] = "";
$cnd= "c.category LIKE '%".$_GET['search']."%'";
$sf="c.*";
$ob="category";
$rs=$dbObj->gj("mast_deal_category c",$sf,$cnd, $ob, "", "", $l, "");
//print_r($rs);
while($row=@mysql_fetch_array($rs))
{
	$category[]=$row;
}
$smarty->assign("category",$category);

/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj("mast_deal_category c",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "dealcategory_list.php?search=" . $_GET['search'];
	else
		$firstlink = "dealcategory_list.php?";
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

$smarty->display(TEMPLATEDIR . '/admin/mastermanagement/dealcategory_list.tpl');
?>
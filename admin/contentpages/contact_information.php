<?

	include_once("../../include.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Perform Action--------------#

if(isset($_POST['action']))
{
	extract($_POST);
	$id = implode(", ", $id);

	if($action == "active")
	{	$qry1 = "update tbl_contact_information set status='Active' where id in (". $id.")";
		$id=$dbObj->customqry($qry1, "");
		$_SESSION["msg"] = "<span class='success'>Contact Information(s) Activated Successfully.</span>";
	}
	elseif($action == "inactive")
	{
		$qry = "update tbl_contact_information set status='Inactive' where id in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>Contact Information(s) Inactivated Successfully.</span>";
	}
	elseif($action == "delete")
	{
		$qry = "delete from tbl_contact_information where id in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>Contact Information Deleted Successfully.</span>";
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
#------------------pegination part 1--------------------
$orderby = (stripslashes($_GET['orderby'])?stripslashes($_GET['orderby']):" line_one asc");

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
	$cnd = "1";
#------------------------------------------------------#

#---------Show All Contacts-------------------------

$rs = $dbObj->gj("tbl_contact_information", "", $cnd, $orderby, "", "", "$l","");
if($rs != 'n'){
	while($row = mysql_fetch_assoc($rs))
	{
		$contactus[] = $row;
	}
}
$smarty->assign("cinfo",$contactus);
#---------------Pegination part 2-------------------------
$rs=$dbObj->gj("tbl_contact_information",$sf,$cnd, $orderby, "", "", "", "");
	$nums = @mysql_num_rows($rs);
	$show = 20;
	$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	$firstlink = "contact_information.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

#---------------END-------------------------

#------------------Delete Contact-----------

if(isset($_SESSION['msg'])!="")
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR . '/admin/contentpages/contact_information.tpl');

$dbObj->Close();
?>
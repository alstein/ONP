<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}


#--------Perform Action--------------#
if(isset($_POST['action']))
{
	extract($_POST);
	$cid = implode(", ", $cid);

#------------------Delete Contact-----------	
	if($_POST['action'] == "delete")
	{
		$qry = "delete from tbl_contactus where cid in (". $cid.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>Deleted Successfully.</span>";
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
#--------pegination part 1-------------#
$orderby = (stripslashes($_GET['orderby'])?stripslashes($_GET['orderby']):" cid DESC");

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
	$cnd = "1";
#----------------------display--------------------------------#
$rs = $dbObj->gj("tbl_contactus", "", $cnd, $orderby, "", "", "$l", "");

if($rs != 'n'){
	while($row = mysql_fetch_assoc($rs))
	{
		$contactus[] = $row;
	}
}
	$smarty->assign("contactus",$contactus);

#---------------Pegination part 2-------------------------

$rs=$dbObj->gj("tbl_contactus",$sf,$cnd, $orderby, "", "", "", "");
	$nums = @mysql_num_rows($rs);
	$show = 20;
	$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	$firstlink = "contact_us.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

#---------------END-------------------------

if(isset($_SESSION['msg'])!="")
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR . '/admin/contentpages/contact_us.tpl');

$dbObj->Close();
?>
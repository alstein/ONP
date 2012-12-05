<?php

include_once("../../../include.php");
include_once("../../../includes/classes/class.forum.php");



if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");


if($_POST['submit1']=='update')
{


$cd = "1";
$dbres = $dbObj->gj('tbl_category', "*" , $cd, "", "","", "", "");	
	
	while($row_results = @mysql_fetch_assoc($dbres))
	{
	@mysql_query("update tbl_category set sizeorder=".$_POST[$row_results['categoryid']]." where categoryid=".$row_results['categoryid'] );
	//$dbres = $dbObj->cupdt('tbl_product_property', "sizeorder" , $_POST[$row_results['property_id']] ,'property_id',$row_results['property_id'],"0");
	}

}


$forumObj=new Forum();

if($_POST['action'])
{
	extract($_POST);
	$categoryid = implode(", ", $_POST['categoryid']);
	if($action=='delete')
	{
                 //Delete thread start. Delete all threads related to forum and category
		       $categoryArray=$_POST['categoryid'];
		      foreach($categoryArray as $tempcategory)
		      {
			   $rscate=$dbObj->cgs("tbl_forum", "*", "categoryid", $tempcategory, "", "", "");
			   while($rowdata=@mysql_fetch_assoc($rscate))
			   {
				    $tempforumid=$rowdata['forumid'];
				     $deleteThreads = $dbObj->customqry("delete from tbl_forum_thread where forumid=$tempforumid");
			   }
		      }  
		     //Delete thread end                   


		$temp = $dbObj->customqry("delete from tbl_category where categoryid in(".$categoryid.")", "");
		$temp = $dbObj->customqry("delete from tbl_forum where categoryid in(".$categoryid.")", "");
		$_SESSION['msg']="<span class='success'>Category(es) Deleted Successfully.</span>";
	}
	elseif($action=='active')
	{
		$temp = $dbObj->customqry("update tbl_category set status='Active' where categoryid in(".$categoryid.")", "");
		$_SESSION['msg']="<span class='success'>Category(es) Activated Successfully.</span>";
	}
	elseif($action=='inactive')
	{
		$temp = $dbObj->customqry("update tbl_category set status='Inactive' where categoryid in(".$categoryid.")", "");
		$_SESSION['msg']="<span class='success'>Category(es) Inactivated Successfully.</span>";
	}
	header('Location:'. $_SERVER['HTTP_REFERER']);
	exit;
}

#--------pegination part 1-------------#
if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	 $l= $StartRow.','.$adsperpage;
	$cnd = "1";
#----------------------Getting Categories--------------------------------#
// $categories = $forumObj->getCategories(true);

$orderby = (stripslashes($_GET['orderby'])?stripslashes($_GET['orderby']):" sizeorder  asc");


$rs = $dbObj->gj("tbl_category", "", $cnd, $orderby, "", "", "$l", "");
if($rs != 'n')
{
	while($row = mysql_fetch_assoc($rs))
	{
		$categories[] = $row;
	}
}

	$smarty->assign('categories',$categories);
/*-----Pagination Part-2--------------*/
	$rs=$dbObj->gj("tbl_category",$sf,$cnd, $orderby, "", "", "", "");
	$nums = @mysql_num_rows($rs);
	$show = 20;
	$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "categories.php?search=".$_GET['search'];
	else
		$firstlink = "categories.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

#--------Messaging----------------
if($_SESSION['msg']){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
#----------END---------------

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/discussion/categories.tpl');

$dbObj->Close();
?>

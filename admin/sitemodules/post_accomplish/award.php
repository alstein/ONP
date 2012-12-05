<?php

include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");

if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	if($acc_id!='')
	{
		$acc_id = implode(", ", $acc_id);
		if($action == "active")
		{
			$temp = $dbObj->customqry("UPDATE tbl_accomplishment SET status = 'Active' where acc_id in (".$acc_id.")","");
			$_SESSION['msg']="<span class='success'>Accomplishment activated Successfully.</span>";
		}
		elseif($action == "inactive")
		{
			$temp = $dbObj->customqry("UPDATE tbl_accomplishment SET status = 'Inactive' where acc_id in (".$acc_id.")","");
			$_SESSION['msg']="<span class='success'>Accomplishment Inactivated Successfully.</span>";
		}
		elseif($action == "delete")
		{
/*			$res = $dbObj->gj("tbl_accomplishment_photo","image" , "acc_id in (".$acc_id.")", "", "", "", "", "");
			while($img = @mysql_fetch_assoc($res))
			{
				@unlink('../../../uploads/post_accomplish/52X52/'.$img['image']);
				@unlink('../../../uploads/post_accomplish/90X90/'.$img['image']);
				@unlink('../../../uploads/post_accomplish/145X145/'.$img['image']);
				@unlink('../../../uploads/post_accomplish/400X400/'.$img['image']);
				@unlink('../../../uploads/post_accomplish/600X600/'.$img['image']);
				@unlink('../../../uploads/post_accomplish/thumbnail/'.$img['image']);
			}
			$temp = $dbObj->customqry("delete from tbl_album where acc_id in (".$acc_id.")","");
			$temp = $dbObj->customqry("delete from tbl_accomplishment_photo where acc_id in (".$acc_id.")","");*/
			$temp = $dbObj->customqry("delete from tbl_accomplishment where acc_id in (".$acc_id.")","");
			$_SESSION['msg']="<span class='success'>Accomplishment Deleted Successfully.</span>";
		}
		header("Location:".$_SERVER['HTTP_REFERER']);
		exit();
	}
}
#---------END-------------#
/*------------Pagination Part-1------------*/
$page=$_GET['page'];
if(!isset($_GET['page']))
	$page =1;
else
	$page = $page;						
$adsperpage = 15;							
$StartRow = $adsperpage * ($page-1);			
$l =  $StartRow.','.$adsperpage;
/*-----------------------------------*/


$tbl = "tbl_accomplishment t 
	LEFT JOIN users u ON t.userid = u.userid 
	LEFT JOIN users s ON t.added_userid = s.userid
	LEFT JOIN tbl_category c ON c.catid = t.catid 
	LEFT JOIN tbl_subcategory sc ON sc.subcatid = t.subcatid 
	LEFT JOIN tbl_awards a ON t.award = a.award_id
	LEFT JOIN tbl_events e ON t.event_name = e.eventid";
$sf = "t.*, u.admin_first_name as o_fname, u.admin_last_name as o_lname, s.admin_first_name as a_fname, s.admin_last_name as a_lname, c.category, sc.subcategory, a.admin_award_title, e.admin_title ";

if($_GET['search'] != "")
{
     $cnd = "t.acc_id LIKE '%".$_GET['search']."%' OR u.first_name LIKE '%".$_GET['search']."%' OR u.last_name LIKE '%".$_GET['search']."%' OR t.end_date LIKE '%".$_GET['search']."%' OR a.award_title LIKE '%".$_GET['search']."%' OR e.title LIKE '%".$_GET['search']."%'";
}
else
{
    $cnd = "1";
} 
$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");
while($row = @mysql_fetch_assoc($rs))
{
	$cat[] = $row;
}
$smarty->assign("cat", $cat);

/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj($tbl,$sf,$cnd, "", "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 15;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");
$showing   = !isset($_GET["page"]) ? 1 : $page;
if(!empty($_GET['search']))
	$firstlink = "award.php?search=" . $_GET['search'];
else
	$firstlink = "award.php?";
$seperator = '&page=';
$baselink  = $firstlink; 
$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pgnation",$pgnation);
/*-----------------------------------*/


if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","post_acc");

$smarty->display(TEMPLATEDIR . '/admin/sitemodules/post_accomplish/award.tpl');
$dbObj->Close();
?>
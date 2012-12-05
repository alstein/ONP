<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.profile.php');
include_once('../../../includes/classes/class.security.php');
include_once('../../../includes/classes/class.general.php');

if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}
#--------Action for accomplishment photos-----------#
// if(isset($_POST['action']))
// {
// 	extract($_POST);
// 	if($album_id!='')
// 	{
// 		$album_id_arr = $album_id;
// 		$album_id = implode(",", $album_id);
// 
// 		if($action == "active")
// 		{
// 			$temp = $dbObj->customqry("UPDATE tbl_album SET status = 'Active' where album_id in (".$album_id.")","");
// 			$_SESSION['photomsg']="<span class='success'>Album activated Successfully.</span>";
// 		}
// 		elseif($action == "inactive")
// 		{
// 			$temp = $dbObj->customqry("UPDATE tbl_album SET status = 'Inactive' where album_id in (".$album_id.")","");
// 			$_SESSION['photomsg']="<span class='success'>Album Inactivated Successfully.</span>";
// 		}
// 		elseif($action == "delete")
// 		{
// 			foreach($album_id_arr as $k=>$v)
// 			{
// 				$res1 = $dbObj->gj("tbl_album","DISTINCT(acc_id)" , " album_id IN (".$album_id.")", "", "", "", "", "");
// 				while($rw = @mysql_fetch_assoc($res1))
// 				{
// 					$res = $dbObj->gj("tbl_accomplishment_photo","image" , "acc_id = '".$rw['acc_id']."'", "", "", "", "", "");
// 					while($img = @mysql_fetch_assoc($res))
// 					{
// 						@unlink('../../../uploads/post_accomplish/52X52/'.$image[$v]);
// 						@unlink('../../../uploads/post_accomplish/90X90/'.$image[$v]);
// 						@unlink('../../../uploads/post_accomplish/145X145/'.$image[$v]);
// 						@unlink('../../../uploads/post_accomplish/400X400/'.$image[$v]);
// 						@unlink('../../../uploads/post_accomplish/600X600/'.$image[$v]);
// 						@unlink('../../../uploads/post_accomplish/thumbnail/'.$image[$v]);
// 					}
// 				}
// 			}
// 			$temp = $dbObj->customqry("delete from tbl_album where album_id in (".$album_id.")","");
// 			$temp = $dbObj->customqry("delete from tbl_accomplishment_photo where album_id in (".$album_id.")","");
// 			$_SESSION['photomsg']="<span class='success'>Album Deleted Successfully.</span>";
// 		}
// 		header("Location:".$_SERVER['HTTP_REFERER']);
// 		exit();
// 	}
// }
#---------END-------------#


# ----------- fetch Accomplishment -----------
$tbl1 = "tbl_accomplishment t 
	LEFT JOIN users u ON t.userid = u.userid 
	LEFT JOIN users s ON t.added_userid = s.userid
	LEFT JOIN tbl_category c ON c.catid = t.catid 
	LEFT JOIN tbl_subcategory sc ON sc.subcatid = t.subcatid 
	LEFT JOIN tbl_awards a ON t.award = a.award_id
	LEFT JOIN tbl_events e ON t.event_name = e.eventid
	LEFT JOIN users z ON t.location = z.userid";
$sf1 = "t.*, u.first_name as o_fname, u.last_name as o_lname, u.parentid, u.teacherid, s.first_name as a_fname, s.last_name as a_lname, c.category, sc.subcategory, a.admin_award_title, e.admin_title as admin_event_title, z.admin_first_name as school_name ";
$cnd1 = "acc_id = '".$_GET['id']."'";

$rs1 = $dbObj->gj($tbl1, $sf1 , $cnd1, "", "", "", "", "");
$row1 = @mysql_fetch_assoc($rs1);
$smarty->assign("awards", $row1);
if($row1['parentid'] != "") {$smarty->assign("userid", $row1['parentid']); $smarty->assign("roleid", 4);}
else { $smarty->assign("userid", $row1['teacherid']); $smarty->assign("roleid", 5); }
if($row1['teammates'] != "")
{
	$rs = $dbObj->gj("users", "first_name, last_name" , "userid IN (".$row1['teammates'].")", "", "", "", "", "");
	while($rw = @mysql_fetch_assoc($rs))
	{
		$team[] = $rw;
	}
	$smarty->assign("team", $team);
}

/*------------Pagination Part-1------------*/
$page=$_GET['page'];
if(!isset($_GET['page']))
	$page =1;
else
	$page = $page;						
$adsperpage =8;							
$StartRow = $adsperpage * ($page-1);			
$l =  $StartRow.','.$adsperpage;
/*-----------------------------------*/

$tbl = "tbl_accomplishment_photo ";
$sf = "*";
$cnd = "find_in_set(".$_GET['id'].", acc_id)";
$row1= $dbObj->gj($tbl, $sf, $cnd ,"photoid", "","DESC",$l,"");
if(is_resource($row1))
{
	while($rec = @mysql_fetch_assoc($row1))
	{
		$album[] = $rec;
	}
}
$smarty->assign("photo", $album);


/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj($tbl,$sf,$cnd, "", "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 8;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");
$showing   = !isset($_GET["page"]) ? 1 : $page;
$firstlink = "view_award.php?id=".$_GET['id'];
$seperator = '&page=';
$baselink  = $firstlink; 
$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pgnation",$pgnation);
/*-----------------------------------*/
# ----------- END fetch awards ---------
if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}
if($_SESSION['photomsg'])
{
	$smarty->assign("photomsg",$_SESSION['photomsg']);	
	$_SESSION['photomsg']=NULL;
	unset($_SESSION['photomsg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","post_acc");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/post_accomplish/view_award.tpl');

$dbObj->Close();
?>
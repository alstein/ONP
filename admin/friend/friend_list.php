<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
include_once('../../includes/function.php');

if(!$_SESSION['duAdmId'])
  header("location:".SITEROOT . "/admin/login/index.php");

/*-----------------------Pagination Part1--------------------*/
$page=$_GET['page'];

if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;

$newsperpage =20;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

 if($_POST['action'])
   {
      extract($_POST);
      $friendids = @implode(", ", $friendid);
      if($friendids)
      {
         if($_POST['action'] == "delete")
         {
				//delete all deal cities from reference table
		
		  $temp = $dbObj->customqry("delete from tbl_friends where id IN (".$friendids.")","");
                  $_SESSION['msg']="<span class='success'>Friend deleted successfully</span>";

         }
      
	
	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_friends set status = 'Active' where id IN (".$friendids.")","");
               $_SESSION['msg']="<span class='success'>Friend activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_friends set status = 'Inactive' where id IN (".$friendids.")","");
               $_SESSION['msg']="<span class='success'>Friend inactivated successfullly </span>";
         }					
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }

#===================End====================#

if(isset($_GET['search'])!="")
{

	$cnd .= "  (u.fullname LIKE '%".$_GET['search']."%' OR u1.fullname LIKE '%".$_GET['search']."%') and";
}
if($_GET['userid']!="")
{
$cnd .=" f.verification='yes' and u.usertypeid='2' and u1.usertypeid='2' and (	f.userid='".$_GET['userid']."' or f.friendid ='".$_GET['userid']."')";
}
else
{
$cnd .=" f.verification='yes' and u.usertypeid='2' and u1.usertypeid='2'";
}
	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select u.userid,u.fullname,u1.fullname  as friend_name,f.* from tbl_friends f left join tbl_users u on f.userid= u.userid  left join tbl_users u1 on f.friendid=u1.userid where ".$cnd." LIMIT ".$l, "");
//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $friend[] = $row;
		
   }

   $smarty->assign("friend",$friend);

// /*-----------------------Pagination Part2--------------------*/
//$rs = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");
$rs = $dbObj->customqry("select u.userid,u.fullname,u1.fullname  as friend_name,f.* from tbl_friends f left join tbl_users u on f.userid= u.userid  left join tbl_users u1 on f.friendid=u1.userid where ".$cnd."", "");
 $nums =@mysql_num_rows($rs);
 $smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
    $smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;
// $firstlink = basename($_SERVER['PHP_SELF']) . "?prod_deal_id=".$_GET['prod_deal_id'];
// $seperator = '&page=';
// $baselink  = $firstlink; 
if($search)
      $firstlink = "friend_list.php?deal_from_seller_name=ssdf&uname={$_GET['uname']}&dltype=".$_GET['dltype'];
   else
      $firstlink = "friend_list.php?deal_from_seller_name=".$_GET['deal_from_seller_name']."&dltype=".$_GET['dltype'];
   $seperator = '&page=';
   $baselink = $firstlink;
$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pagenation",$pagenation);
/*-----------------------End Part2--------------------*/


  if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }


   #----------Success message=--------------#
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/friend/friend_list.tpl');

$dbObj->Close();
?>
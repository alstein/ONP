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
      $fanids = @implode(", ", $fanid);
      if($fanids)
      {
         if($_POST['action'] == "delete")
         {
				//delete all deal cities from reference table
		
		  $temp = $dbObj->customqry("delete from tbl_fan where id IN (".$fanids.")","");
                  $_SESSION['msg']="<span class='success'>Fan deleted successfully</span>";

         }
      
	
	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_fan set status = 'Active' where id IN (".$fanids.")","");
               $_SESSION['msg']="<span class='success'>Fan activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_fan set status = 'Inactive' where id IN (".$fanids.")","");
               $_SESSION['msg']="<span class='success'>Fan inactivated successfullly </span>";
         }					
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }


if(isset($_GET['search'])!="")
{

	$cnd .= "  (u.fullname LIKE '%".$_GET['search']."%' OR u1.fullname LIKE '%".$_GET['search']."%') and";
}
if($_GET['userid']!="")
{
$cnd .=" u.usertypeid='3'  and f.fan_id='".$_GET['userid']."'";
}
elseif($_GET['seller_id']!="")
{
$cnd .=" u.usertypeid='3'  and f.userid='".$_GET['seller_id']."'";
}
else
{
$cnd .=" u.usertypeid='3' ";
}
	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select u.userid,u.fullname,u.business_name,u1.fullname as fan_name,f.* from tbl_fan f   left join tbl_users u1 on f.fan_id=u1.userid left join tbl_users u on f.userid= u.userid  where ".$cnd." LIMIT ".$l, "");
//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $fan[] = $row;
		
   }

   $smarty->assign("fan",$fan);

// /*-----------------------Pagination Part2--------------------*/
//$rs = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");
$rs = $dbObj->customqry("select u.userid,u.fullname,u.business_name,u1.fullname  as fan_name,f.* from tbl_fan f left join tbl_users u on f.userid= u.userid  left join tbl_users u1 on f.fan_id=u1.userid where ".$cnd."", "");
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
$smarty->display(TEMPLATEDIR . '/admin/friend/fan.tpl');

$dbObj->Close();
?>
<?php
include_once('../../include.php');

include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
include_once("../../includes/paging.php");
$msobj= new message();

$row_meta=$dbObj->getseodetails(3);
$smarty->assign("row_meta",$row_meta);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}


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
      $offer_deal_ids = @implode(", ", $offer_deal_id);
      if($offer_deal_ids)
      {
         if($_POST['action'] == "delete")
         {
				//delete all deal cities from reference table
		
		  $temp = $dbObj->customqry("delete from tbl_offer_deal where offer_deal_id IN (".$offer_deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Offer deal request deleted successfully</span>";

         }
      	/*
	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_friends set status = 'Active' where id IN (".$friendids.")","");
               $_SESSION['msg']="<span class='success'>Friend activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_friends set status = 'Inactive' where id IN (".$friendids.")","");
               $_SESSION['msg']="<span class='success'>Friend inactivated successfullly </span>";
         }		*/			
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }

#===================End====================#

if($_GET['id2']!="")
{
	$status=$_GET['id2'];
	$fl=array('status');
	$vl=array($status);
	  $rs = $dbObj->cupdt('tbl_offer_deal',$fl,$vl,'offer_deal_id',$_GET['id3'],'1');
	 header("location:".SITEROOT."/merchant-account/".$_GET['id1']."/offer_deal_request");
         exit;
}
if(isset($_GET['search'])!="")
{

	$cnd .= "  (u.fullname LIKE '%".$_GET['search']."%' OR u1.fullname LIKE '%".$_GET['search']."%') and";
}

	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select d.*,u.fullname from tbl_offer_deal d left join tbl_users u on d.user_id=u.userid where   d.merchant_id='".$_GET['id1']."' group by d.offer_deal_id   LIMIT  ".$l, "");
//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $offer_deal[] = $row;
		
   }

   $smarty->assign("offer_deal",$offer_deal);

// /*-----------------------Pagination Part2--------------------*/
//$rs = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");
$rs = $dbObj->customqry("select d.*,u.fullname from tbl_offer_deal d left join tbl_users u on d.user_id=u.userid where   d.merchant_id='".$_GET['id1']."' group by d.offer_deal_id", "");
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
      $firstlink = "offer_deal_request.php?deal_from_seller_name=ssdf&uname={$_GET['uname']}&dltype=".$_GET['dltype'];
   else
      $firstlink = "offer_deal_request.php?deal_from_seller_name=".$_GET['deal_from_seller_name']."&dltype=".$_GET['dltype'];
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
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/offer_deal_request.tpl');

$dbObj->Close();

?>

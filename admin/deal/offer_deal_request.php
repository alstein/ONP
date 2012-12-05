<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
include_once('../../includes/function.php');

if(!$_SESSION['duAdmId'])
  header("location:".SITEROOT . "/admin/login/index.php");

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =20;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

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

if($_GET['status']!="")
{
	$status=$_GET['status'];
	$fl=array('status');
	$vl=array($status);
	  $rs = $dbObj->cupdt('tbl_offer_deal',$fl,$vl,'offer_deal_id',$_GET['id'],'');
}

if($_GET['search']!="")
{

	$cnd .= "  (u.business_name LIKE '%".$_GET['search']."%' OR u1.business_name LIKE '%".$_GET['search']."%') and";

	$res = $dbObj->customqry("select d.*,u.business_name,u.address1,dc.category from tbl_offer_deal d left join tbl_users u on d.merchant_id=u.userid left join tbl_users u1 on d.user_id=u1.userid left join mast_deal_category dc on u.deal_cat=dc.id where  (u.business_name LIKE '%".$_GET['search']."%' OR u.business_name LIKE '%".$_GET['search']."%')  LIMIT ".$l, "");
	$res_all = $dbObj->customqry("select d.*,u.business_name,u.address1 from tbl_offer_deal d left join tbl_users u on d.merchant_id=u.userid left join tbl_users u1 on d.user_id=u1.userid left join mast_deal_category dc on u.deal_cat=dc.id left join mast_deal_category dc on u.deal_cat=dc.idwhere  (u.business_name LIKE '%".$_GET['search']."%' OR u.business_name LIKE '%".$_GET['search']."%') and (u.business_name!='NULL' || u.address1!='NULL')", "");


}else{

		$res = $dbObj->customqry("select d.*,u.business_name,u.address1,u1.fullname,dc.category from tbl_offer_deal d left join tbl_users u on d.merchant_id=u.userid left join tbl_users u1 on d.user_id=u1.userid left join mast_deal_category dc on u.deal_cat=dc.id LIMIT ".$l, "");
	$res_all = $dbObj->customqry("select d.*,u.business_name,u.address1,u1.fullname,dc.category from tbl_offer_deal d left join tbl_users u on d.merchant_id=u.userid left join tbl_users u1 on d.user_id=u1.userid left join mast_deal_category dc on u.deal_cat=dc.id", "");


}

//	$res = $dbObj->customqry("select * from tbl_offer_deal   LIMIT ".$l, "");

   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $offer_deal[] = $row;
		
   }

   $smarty->assign("offer_deal",$offer_deal);


/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($res_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;



      $firstlink = SITEROOT."/admin/deal/offer_deal_request.php?search=".$_GET['search']."&button=".$_GET['button'];

   $seperator = '&page=';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}
/*----------Pagination Part-2--------------*/



  if($_SESSION['msg'])
   {
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg'] = "";
   unset($_SESSION['msg']);
   }



   #----------Success message=--------------#
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/deal/offer_deal_request.tpl');

$dbObj->Close();
?>
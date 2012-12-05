<?php
date_default_timezone_set('Europe/London');
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../includes/function.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}
//**********************************Find All Seller***********************************************//
$res_sellerDet = $dbObj->cgs("tbl_users","userid, fullname, first_name, last_name, email",array("isDeleted","usertypeid"),array(0,3),"first_name","ASC","");
$num_seller = @mysql_num_rows($res_sellerDet);
$row_sellerDet = array();
while($row = @mysql_fetch_assoc($res_sellerDet))
{
	$row_sellerDet[] = $row;
}
$smarty->assign("deal_from_seller_names",$row_sellerDet);
//**********************************End Of Find All Seller***********************************************//


#------------Check For access----------#
if(!(in_array("10", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


//********************************************Action on records*******************************************************//
//print_r($_POST);
//print_r($deal_id);
 if($_POST['action'])
   {
      extract($_POST);
      $deal_ids = @implode(", ", $deal_id);
      if($deal_ids)
      {
         if($_POST['action'] == "delete")
         {
		 		 $temp = $dbObj->customqry("delete from tbl_rating where rating_id  IN (".$deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Review deleted successfully</span>";

         }
      	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_deals set status = 'active' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_deals set status = 'inactive' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal inactivated successfullly </span>";
         }					
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }
   #--------------End-----------------------#
   #--------Pagination1-------------------------#
   $getpage=$_GET['page'];
   if(!isset($getpage))
      $page =1;
      else
      $page = $getpage;
      $adsperpage =20;
    $StartRow = $adsperpage * ($page-1);
     $l =  $StartRow.','.$adsperpage;
   #----------------------------------------#

	
	$res = $dbObj->customqry("SELECT r.*,u.fullname,u1.fullname as fullname1,u.business_name FROM tbl_rating as r LEFT JOIN tbl_users as u ON r.merchant_id=u.userid left join tbl_users u1 on r.user_id=u1.userid LIMIT ".$l, "");
	
	$i=0;
	while($row = @mysql_fetch_assoc($res))
	{
		$ratingmark[] = $row;
		
		$i++;
        } 


   $smarty->assign("ratingmark",$ratingmark);
   #-------------End------------------------#
   
   #------------Pagination2-----------------#   
   //$res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
  $res = $dbObj->customqry("SELECT r.*,u.fullname,u1.fullname as fullname1,u.business_name FROM tbl_rating as r LEFT JOIN tbl_users as u ON r.merchant_id=u.userid left join tbl_users u1 on r.user_id=u1.userid LIMIT ".$l, "");
   $nums = @mysql_num_rows($res);
   $show = 10;    
   $total_pages = ceil($nums / $adsperpage);
   if($total_pages > 1)
      $smarty->assign("showpaging", "yes");
      
   $showing = !($getpage)? 1 : $getpage;
   if($search)
      $firstlink = "raviews_rating_deals_list.php";
   else
      $firstlink = "raviews_rating_deals_list.php";
   $seperator = '&page=';
   $baselink = $firstlink;
   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
   
   $smarty->assign("pgnation",$pgnation);
   
   #----------------------------------------#
   
   #----------Success message=--------------#
   if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }
   #--------------End-----------------------#
   
  
   #----------Success message=--------------#
	
   $smarty->display(TEMPLATEDIR.'/admin/modules/rating/raviews_rating_deals_list.tpl'); 
?>

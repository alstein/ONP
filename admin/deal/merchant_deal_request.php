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
      $offer_deal_ids = @implode(", ", $offer_deal_id);
      if($offer_deal_ids)
      {
         if($_POST['action'] == "delete")
         {
				//delete all deal cities from reference table
		
		  $temp = $dbObj->customqry("delete from tbl_merchant_deal_request where merchant_deal_request_id IN (".$offer_deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Merchant deal request deleted successfully</span>";

         }
         if($_POST['action'] == "Accept")
         {
				$temp = $dbObj->customqry("update  tbl_merchant_deal_request set status='yes' where merchant_deal_request_id IN (".$offer_deal_ids.")","");
            $_SESSION['msg']="<span class='success'>Merchant deal request Accepted successfully</span>";
						
			$cnt=count($offer_deal_id);
			for($i=0;$i<$cnt;$i++)
			{


		$qry_merchantname= $dbObj->customqry("select * from tbl_merchant_deal_request where merchant_deal_request_id='".$_POST['offer_deal_id'][$i]."'","1");
							$fetch_merchantname=@mysql_fetch_assoc($qry_merchantname);
							$merchantnameid=$fetch_merchantname['merchant_id'];

							$qry_name= $dbObj->customqry("select * from tbl_users where userid='".$merchantnameid."'","");
							$fetch_name=mysql_fetch_assoc($qry_name);
							$name=$fetch_name['business_name'];
							$email=$fetch_name['email'];
							$email_query = "select * from mast_emails where emailid=84";
						
							$email_rs = @mysql_query($email_query);
							$email_row = @mysql_fetch_object($email_rs);
							$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
// 							$email_subject = str_replace("[[name]]",$fullname,$email_subject);
						
							$email_message = file_get_contents(ABSPATH."/email/email.html");
						
						
							$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
							$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
							
							$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
							$email_message = str_replace("[[LINK]]", $link1, $email_message);
							$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
							
							$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
							$email_message = str_replace("[[TODAYS_DATE]]",date("Y-m-d H:i:s"), $email_message);
						   $email_message = str_replace("[[Username]]",$name, $email_message);
							$from = SITE_EMAIL;
								@mail(trim($email),$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			}

         }

         if($_POST['action'] == "Reject")
         {
				 $temp = $dbObj->customqry("update  tbl_merchant_deal_request set status='rejected' where merchant_deal_request_id IN (".$offer_deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Merchant deal request Rejected successfully</span>";
         }
							






      		
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
       @header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }

#===================End====================#

if($_GET['status']!="")
{
	$status=$_GET['status'];
	$fl=array('status');
	$vl=array($status);
 $rs = $dbObj->cupdt('tbl_merchant_deal_request',$fl,$vl,'merchant_deal_request_id',$_GET['id'],'');

							if($_GET['status']=='yes')
							{
								$qry_merchantname= $dbObj->customqry("select * from tbl_merchant_deal_request where merchant_deal_request_id='".$_GET['id']."'","1");
								$fetch_merchantname=@mysql_fetch_assoc($qry_merchantname);
								$merchantnameid=$fetch_merchantname['merchant_id'];
	
								$qry_name= $dbObj->customqry("select * from tbl_users where userid='".$merchantnameid."'","");
								$fetch_name=mysql_fetch_assoc($qry_name);
								$name=$fetch_name['business_name'];
								$email=$fetch_name['email'];
								$email_query = "select * from mast_emails where emailid=84";
							
								$email_rs = @mysql_query($email_query);
								$email_row = @mysql_fetch_object($email_rs);
								$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
	// 							$email_subject = str_replace("[[name]]",$fullname,$email_subject);
							
								$email_message = file_get_contents(ABSPATH."/email/email.html");
							
							
								$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
								$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
								
								$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
								$email_message = str_replace("[[LINK]]", $link1, $email_message);
								$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
								
								$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
								$email_message = str_replace("[[TODAYS_DATE]]",date("Y-m-d H:i:s"), $email_message);
							$email_message = str_replace("[[Username]]",$name, $email_message);
								$from = SITE_EMAIL;
									@mail(trim($email),$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
							}
		

}
if(isset($_GET['search'])!="")
{

	$cnd .= "  (u.fullname LIKE '%".$_GET['search']."%' OR d.phone_no LIKE '%".$_GET['search']."%' OR d.mail LIKE '%".$_GET['search']."%' OR d.name_of_key LIKE '%".$_GET['search']."%') and ";
}
$cnd.= 1;

	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select d.*,u.fullname,u.business_name,u.first_name,u.last_name,u.address1,u.contact_detail,dc.category from tbl_merchant_deal_request d left join tbl_users u on d.merchant_id=u.userid left join mast_deal_category dc on u.deal_cat=dc.id where $cnd order by d.merchant_deal_request_id DESC	  LIMIT ".$l, "");
//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $offer_deal[] = $row;
		
   }

   $smarty->assign("offer_deal",$offer_deal);

// /*-----------------------Pagination Part2--------------------*/
//$rs = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");
$rs = $dbObj->customqry("select d.*,u.first_name,u.last_name,dc.category from tbl_merchant_deal_request d left join tbl_users u on u.userid=d.merchant_id left join mast_deal_category dc on u.deal_cat=dc.id where $cnd order by d.merchant_deal_request_id DESC", "");
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
      $firstlink = "merchant_deal_request.php?deal_from_seller_name=ssdf&uname={$_GET['uname']}&dltype=".$_GET['dltype'];
   else
      $firstlink = "merchant_deal_request.php?deal_from_seller_name=".$_GET['deal_from_seller_name']."&dltype=".$_GET['dltype'];
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
$smarty->display(TEMPLATEDIR . '/admin/deal/merchant_deal_request.tpl');

$dbObj->Close();
?>
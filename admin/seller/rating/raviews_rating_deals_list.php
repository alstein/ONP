<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once("../../../includes/classes/class.deals.php");
$msobj= new message();

if((!$_SESSION['duAdmId']) || $_SESSION['duUserTypeId'] != 3)
{
	$_SESSION['type'] = 'seller';
	header("location:". SITEROOT . "/signin");
}

/////////////////////////////////////////////
//START 
//this file is added for checking the subscription is expired or subscribed of seller
include_once(ABSPATH.'/admin/seller/check_seller_subscription.php');
//this file is added for checking the subscription is expired or subscribed of seller
//END
/////////////////////////////////////////////

 /*-----------------------Pagination Part1--------------------*/
 /*--------------Get perticuler added  seller deal list here Start---------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
    $newsperpage =20;
    $StartRow = $newsperpage * ($page-1);
    $l =  $StartRow.','.$newsperpage;
    
    $rating_query="SELECT DISTINCT (deal_id), deal_title FROM tbl_rating LEFT JOIN tbl_deal ON tbl_rating.deal_id = tbl_deal.deal_unique_id WHERE admin_userid =".$_SESSION['duAdmId']." LIMIT ".$l;
    // $rating_query = "SELECT DISTINCT (deal_id),deal_title FROM tbl_rating where deal_id=".$rows['deal_unique_id']." LIMIT ".$l;
     
	$rating_rs = mysql_query($rating_query)or die(mysql_error());
	while($row = mysql_fetch_array($rating_rs))
	{
	     $temparr=array();
             $temparr['deal_id']=$row['deal_id'];
             $temparr['deal_title']=html_entity_decode(html_entity_decode($row['deal_title']));
             $avgRateForStar= $dealsObj->getTotalrating($row['deal_id']);
             $temparr['avg'] = $avgRateForStar;
             $results[]=$temparr;
	}
	
	   $smarty -> assign("ratingmark", $results);
     /*--------------Get perticuler added deal rating list here Start---------*/
/*-----------------------Pagination Part2--------------------*/	
//$rs1 =$dbObj->gj("tbl_rating","*","rating_id","", "","",$l,"1");
 $rs1= $dbObj->customqry("SELECT DISTINCT (deal_id), deal_title FROM tbl_rating LEFT JOIN tbl_deal ON tbl_rating.deal_id = tbl_deal.deal_unique_id WHERE admin_userid =".$_SESSION['duAdmId'],"");
  $nums =@mysql_num_rows($rs1);

  $smarty -> assign("recordsFound",$nums);
  $show = 20;
  $total_pages = ceil($nums / $newsperpage);

if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");
    $showing   = !isset($_GET["page"]) ? 1 : $page;
    $firstlink = "raviews_rating_deals_list.php";
    $seperator = '?page=';
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);
    $smarty-> assign("pagenation",$pagenation);
}

/*-----------------------End Part2--------------------*/

//  if(isset($_POST['submit']))
//  {
//      $action=$_POST['action'];
//      $deal_id=$_POST['deal_id'];
//      $deal_id = implode(",", $deal_id);
//       if($action == "delete")
//       {
// 		$sqldel="SELECT rating_id FROM tbl_rating WHERE deal_id=".$deal_id;
// 		$ratingdel = mysql_query($sqldel)or die(mysql_error());
// 		while($rowdel = mysql_fetch_array($ratingdel))
// 		{
//                     $dbObj->customqry("delete from tbl_detailed_rating where rating_id IN (".$rowdel['rating_id'].")","");
// 		}
// 		$id = $dbObj->customqry("delete from tbl_rating where deal_id IN (".$deal_id.")","");
// 		$s=$msobj->showmessage(198);
// 		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";		
//                 header("Location: raviews_rating_deals_list.php");
//                 exit;
//       }
//  }
// }
 if(isset($_SESSION['msg']))
 {
 	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
 }
 $smarty->assign("is_seller_access","true");
$smarty->assign("inmenu","masters");
$smarty->display(TEMPLATEDIR . '/admin/seller/rating/raviews_rating_deals_list.tpl');
$dbObj->Close();
?>

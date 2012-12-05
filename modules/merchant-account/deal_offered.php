<?php
include_once('../../include.php');

include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
include_once("../../includes/paging.php");
$msobj= new message();

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

$date=date("Y-m-d H:i:s");
$smarty->assign("date",$date);
#------------Pagination Part-1--------------------------------

if(!isset($_GET['page']))
		{
			$getpage='';
			$page =1;
		}
		else
		{
			$getpage = $_GET['page'];
			$page = $getpage;
		}

			$adsperpage = 10;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
#-------------------------------------------------------------------------------#



if(isset($_GET['search'])!="")
{

	$cnd .= "  (u.fullname LIKE '%".$_GET['search']."%' OR u1.fullname LIKE '%".$_GET['search']."%') and";
}

	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select d.*,u.fullname from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where   d.merchant_id='".$_GET['id1']."' order by d.deal_unique_id desc limit $l", "");

//$res = $dbObj->customqry("select d.*,u.fullname from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where   d.merchant_id='".$_GET['id1']."' group by d.deal_unique_id  ", "");

//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $offer_deal[] = $row;
	$sel=$dbObj->customqry("select count(*) as count from tbl_deal_payment_unique where deal_id='".$row['deal_unique_id']."'","");	
	$row_deal = @mysql_fetch_assoc($sel);
	
	if($row_deal['count']>0)
		$offer_deal[$i]['count']=$row_deal['count'];
	else
		$offer_deal[$i]['count']=0;

	$i++;
   }

   $smarty->assign("offer_deal",$offer_deal);

/*----------Pagination Part-2-------------------------------------------------------*/
$result = $dbObj->customqry("select d.*,u.fullname from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where   d.merchant_id='".$_GET['id1']."' group by d.deal_unique_id", "");
		$nums = @mysql_num_rows($result);
		$show = 10;
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 0)
		$groupArray['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;
		$seperator = '&page=';
		$baselink  = $firstlink;

		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$groupArray['paging']=$pgnation;
		$smarty->assign("pagination",$pgnation);
		$smarty->assign("count_record",$nums);
		$smarty->assign("total_page",$total_pages);

#----------------------delete photo-----------------------------------#




  if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }


   #----------Success message=--------------#
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/deal_offered.tpl');

$dbObj->Close();

?>

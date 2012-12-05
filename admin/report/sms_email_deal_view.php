<?php
///////new///////////
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
/////////////////
//include_once("../../include.php");
include("../../includes/classes/payment_report_grid.php");


if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


	$eventc_obj=new Payment_Report_Grid();	
	if($_GET['seller_id']>0)
   {
      $viewpay=$eventc_obj->getSmsEmailReportById($_GET['seller_id']);
       //  echo "<pre>";
          //   print_r($viewpay);     exit;
      $smarty->assign("viewpay", $viewpay);
   }


/*------------Pagination Part-1------------*/
if($_GET['seller_id']> 0)
{
    $seller_id=$_GET['seller_id'];
    if(!isset($_GET['page']))
        $page =1;
    else
        $page = $_GET['page'];
    $adsperpage=20;
    $StartRow = $adsperpage * ($page-1);
    $l= $StartRow.','.$adsperpage;

/*-----------------------------------*/

    $rs=$eventc_obj->getAllSmsEmailDealReport($l,$seller_id);
    while($row=@mysql_fetch_array($rs))
    {
        $list[]=$row; 
    } 
    $rs=$eventc_obj->getAllSmsEmailDealReport("",$seller_id);
     $nums = @mysql_num_rows($rs);
    $show = 20;
     $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1){
            $showing   = !isset($_GET["page"]) ? 1 : $page;       
            $firstlink = "sms_email_deal_view.php?&seller_id=".$_GET['seller_id'];
        $seperator = '&page=';
        $baselink  = $firstlink;
        $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
        $smarty -> assign("pgnation",$pgnation);
    }

}
//              echo "<pre>";
//              print_r($list);
//              exit;
$smarty->assign("list", $list);

/*-----------------------------------*/

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->assign("inmenu", "user");
	// echo TEMPLATEDIR;
	$smarty->display(TEMPLATEDIR . '/admin/report/sms_email_deal_view.tpl');

	$dbObj->Close();
?>
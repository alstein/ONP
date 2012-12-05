<?php
include_once('../../includes/SiteSetting.php');
include("../../includes/classes/payment_report_grid.php");
include_once("../../includes/paging.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

$eventc_obj=new Payment_Report_Grid();


/*------------Pagination Part-1------------*/
    if(!isset($_GET['page']))
        $page =1;
    else
        $page = $_GET['page'];
    $adsperpage=20;
    $StartRow = $adsperpage * ($page-1);
    $l= $StartRow.','.$adsperpage;

/*-----------------------------------*/
   if($_GET['edit_id']>0)
   {
      $viewpay=$eventc_obj->getPaymentReportById($_GET['edit_id']);
   
      $qry_lpay = @mysql_query("Select count(subs_pack_price) as no_pay from tbl_user_subscription_details where userid ='".$viewpay['userid']."'");
      $row_pay = @mysql_fetch_assoc($qry_lpay);
      $viewpay['no_of_pay'] = $row_pay['no_pay'];
      $qry_total = @mysql_query("Select SUM(subs_pack_price) as total_pay from tbl_user_subscription_details where userid ='".$viewpay['userid']."'");
      $row_total = @mysql_fetch_assoc($qry_total);
      $viewpay['totalpay'] = $row_total['total_pay'];

      $smarty->assign("viewpay", $viewpay);
   }

   $viewpaydetails=$eventc_obj->getDetailPaymentReportById($_GET['edit_id'],$l);
     $i=0;
    while($pay_row=@mysql_fetch_array($viewpaydetails))
        {
        $pay_list[$i]=$pay_row;
        $qry_lpay = @mysql_query("Select subs_pack_price as no_pay from tbl_user_subscription_details where userid ='".$_GET['edit_id']."'");
        $row_pay = @mysql_fetch_assoc($qry_lpay);
        $pay_list[$i]['no_of_pay'] = $row_pay['no_pay'];
      
        $qry_total = @mysql_query("Select subs_pack_price as total_pay from tbl_user_subscription_details where userid ='".$_GET['edit_id']."'");
        $row_total = @mysql_fetch_assoc($qry_total);
        $pay_list[$i]['totalpay'] = $row_total['total_pay'];
        $i++;
        } 
// echo "<pre>";
// print_r($pay_list);
// exit;
$rs=$eventc_obj->getDetailPaymentReportById($_GET['edit_id']);
    $nums = @mysql_num_rows($rs);
    $show = 5;
    $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1){
            $showing   = !isset($_GET["page"]) ? 1 : $page;
        if(!empty($_GET['search']))
            $firstlink = "view_payment_report.php?search=" . $_GET['search']."&edit_id=".$_GET['edit_id'];

        else            
            $firstlink = "view_payment_report.php?&edit_id=".$_GET['edit_id'];
        $seperator = '&page=';
        $baselink  = $firstlink;
        $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
        $smarty -> assign("pgnation",$pgnation);
    }
         if(isset($_SESSION['msg']))
            {
               $smarty->assign("msg", $_SESSION['msg']);
               unset($_SESSION['msg']);
            }
 
$smarty->assign("pay_list",$pay_list);

    $rs=$eventc_obj->getAllPaymentReport();
     $i++;
    while($row=@mysql_fetch_array($rs))
        {
        $list[$i]=$row;
        $qry_lpay = @mysql_query("Select count(pay_price) as no_pay from tbl_payment where user_id ='".$row['userid']."'");
        $row_pay = @mysql_fetch_assoc($qry_lpay);
        $list[$i]['no_of_pay'] = $row_pay['no_pay'];
      
        $qry_total = @mysql_query("Select SUM(pay_price) as total_pay from tbl_payment where user_id ='".$row['userid']."'");
        $row_total = @mysql_fetch_assoc($qry_total);
        $list[$i]['totalpay'] = $row_total['total_pay'];
      
        $i++;        
        }  
 
$smarty->assign("list", $list);



$smarty->display(TEMPLATEDIR . '/admin/report/view_payment_report.tpl');

$dbObj->Close();
?>
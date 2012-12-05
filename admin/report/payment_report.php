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


/*------------Pagination Part-1------------*/
    if(!isset($_GET['page']))
        $page =1;
    else
        $page = $_GET['page'];
    $adsperpage=20;
    $StartRow = $adsperpage * ($page-1);
    $l= $StartRow.','.$adsperpage;

/*-----------------------------------*/

    $rs=$eventc_obj->getAllPaymentReport($l);
     $i=0;
    while($row=@mysql_fetch_array($rs))
        {
        $list[$i]=$row;
        $qry_lpay = @mysql_query("Select count(subs_pack_price) as no_pay from tbl_user_subscription_details where userid ='".$row['userid']."'");
        $row_pay = @mysql_fetch_assoc($qry_lpay);
        $list[$i]['no_of_pay'] = $row_pay['no_pay'];
        
        $qry_total = @mysql_query("Select SUM(subs_pack_price) as total_pay from tbl_user_subscription_details where userid ='".$row['userid']."'");
        $row_total = @mysql_fetch_assoc($qry_total);
        $list[$i]['totalpay'] = $row_total['total_pay'];
        $i++;
        }  
// echo "<pre>";
// print_r($row);

    $rs=$eventc_obj->getAllPaymentReport();
    $nums = @mysql_num_rows($rs);
    $show = 5;
    $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1){
            $showing   = !isset($_GET["page"]) ? 1 : $page;
        if(!empty($_GET['search']))
            $firstlink = "payment_report.php?search=" . $_GET['search']."&orderby=".$orderby;

        else            
            $firstlink = "payment_report.php?&orderby=".$orderby;
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
// 	echo TEMPLATEDIR;
	$smarty->display(TEMPLATEDIR . '/admin/report/payment_report.tpl');

	$dbObj->Close();
?>
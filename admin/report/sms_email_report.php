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

    $rs=$eventc_obj->getAllSmsEmailReport($l);
    
    while($row=@mysql_fetch_array($rs))
        {
            $list[]=$row;
           
        }  
//   echo "<pre>";
//   print_r($list);
//   exit;

    $rs=$eventc_obj->getAllSmsEmailReport();
    $nums = @mysql_num_rows($rs);
    $show = 5;
    $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1){
            $showing   = !isset($_GET["page"]) ? 1 : $page;
            $firstlink = "sms_email_report.php";
        $seperator = '?page=';
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
//	echo TEMPLATEDIR;
	$smarty->display(TEMPLATEDIR . '/admin/report/sms_email_report.tpl');

	$dbObj->Close();
?>
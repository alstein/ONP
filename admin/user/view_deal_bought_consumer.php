<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');
include_once('../../includes/SiteSetting.php');
include_once("../../includes/function.php");
include_once("../../includes/paging.php");


if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");




ob_start();
$userid = $_GET['userid'];

$res_firstname = $dbObj->gj("tbl_users","first_name","userid=".$_GET['userid'],"","","","","");
$row_firstname = @mysql_fetch_assoc($res_firstname);
$firstname = $row_firstname['first_name'];
$smarty->assign("firstname",$firstname);

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =15;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/


//--------------------------------------------------------------------------
$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);
$userid=$_GET['userid'];
$tbl="tbl_deal_payment p,tbl_deals d,tbl_users u";
$sf="d.deal_title,d.deal_unique_id,d.redeem_to,p.buy_date,d.original_price,d.discount_in_per,d.deal_unique_id,d.merchant_id,p.user_id,d.offer_price";
$cnd ="p.user_id=u.userid and p.deal_id=d.deal_unique_id and p.user_id=".$_GET['userid'];

if(isset($_GET['searchuser']))
{
$search=$dbObj->sanitize($_GET['searchuser']);
$cnd .= " AND (d.deal_title  LIKE '%{$search}%' OR d.original_price LIKE '%{$search}%'  OR p.buy_date LIKE '%{$search}%'  OR d.discount_in_per LIKE '%{$search}%' OR d.redeem_to LIKE '%{$search}%'  )";
}

$rs=$dbObj->gj($tbl, $sf, $cnd, "pay_id", $gb, "desc", $l, "");
//exit;
$i=0;
while($row=@mysql_fetch_array($rs)){
	$deals[]=$row;

	$tbl1="tbl_users u,tbl_deals d";
	$sf1="u.business_name";
	$cnd1="d.merchant_id=u.userid and d.deal_unique_id=".$row['deal_unique_id'];
	$rs1=$dbObj->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
	$row1=@mysql_fetch_assoc($rs1);
	$deals[$i]['merchant_name']=$row1['business_name'];
$i++;
}
/*-----------------------Pagination Part2--------------------*/
$rs1=$dbObj->gj($tbl, $sf, $cnd, "pay_id", $gb, "desc", "", "");
$nums =@mysql_num_rows($rs1);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");
    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if(isset($_GET['searchuser']))
    {
	    $firstlink = "view_deal_bought_consumer.php?userid=".$_GET['userid']."&searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "view_deal_bought_consumer.php?userid=".$_GET['userid'];
	  $seperator = '&page=';
    }
        $baselink  = $firstlink;
        $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
        $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/


$smarty->assign("deals",$deals);
$smarty->assign("userid",$userid);
//echo "<pre>"; print_r($deals);
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/view_deal_bought_consumer.tpl');


$dbObj->Close();
?>
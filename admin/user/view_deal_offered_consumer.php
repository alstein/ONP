<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');
include_once('../../includes/SiteSetting.php');
include_once("../../includes/function.php");
include_once("../../includes/paging.php");

if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");


$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);

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


$tbl="tbl_offer_deal d,tbl_users u";
$sf="d.offer_deal_id,d.offerdate,d.redeem_to,d.status,d.discount,d.amount_spend,d.accepted_to_paid,d.product_name,d.amt_to_pin";
$cnd="d.user_id=u.userid and d.user_id=".$_GET['userid'];

if(isset($_GET['searchuser']))
{
	$search=$_GET['searchuser'];
	if($_GET['searchuser']=='Accepted')
	{
		 $search='yes';
	}
	if($_GET['searchuser']=='Rejected')
	{
		 $search='rejected';
	}
	if($_GET['searchuser']=='Pending')
	{
		 $search="no";
	}
	$search=$dbObj->sanitize($search);
	$cnd .= " AND (d.product_name  LIKE '%{$search}%' OR d.offerdate LIKE '%{$search}%'  OR d.redeem_to LIKE '%{$search}%'  OR d.discount LIKE '%{$search}%' OR d.accepted_to_paid LIKE '%{$search}%' OR d.redeem_to LIKE '%{$search}%' OR d.status LIKE '%{$search}%')";
}
$rs=$dbObj->gj($tbl, $sf, $cnd, "offer_deal_id", $gb, "desc", $l, "");
$i=0;
while($row=@mysql_fetch_array($rs)){
	$deals[]=$row;

	$tbl1="tbl_users u,tbl_offer_deal d";
	$sf1="u.business_name";
	$cnd1="d.merchant_id=u.userid and d.offer_deal_id=".$row['offer_deal_id'];
	$rs1=$dbObj->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
	$row1=@mysql_fetch_assoc($rs1);
	$deals[$i]['merchant_name']=$row1['business_name'];
$i++;
}
/*-----------------------Pagination Part2--------------------*/
$rs1=$dbObj->gj($tbl, $sf, $cnd, "offer_deal_id", $gb, "desc", "", "");
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
	    $firstlink = "view_deal_offered_consumer.php?userid=".$_GET['userid']."&searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "view_deal_offered_consumer.php?userid=".$_GET['userid'];
	  $seperator = '&page=';
    }
        $baselink  = $firstlink;
        $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
        $smarty-> assign("pagenation",$pagenation);
}

//echo "<pre>"; print_r($deals);
$smarty->assign("deals",$deals);
$smarty->assign("userid",$userid);
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/view_deal_offered_consumer.tpl');

$dbObj->Close();
?>
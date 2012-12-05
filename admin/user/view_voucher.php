<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();
// print_r($_SESSION);exit;
// print_r($_GET);exit;
if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
        {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['userid']) == 0 || (!isset($_POST['userid'])))
        {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}

	extract($_POST);
	$userid = implode(", ", $userid);	
	if($action == "Active")
        {
		$id = $dbObj->customqry("update tbl_users set status = 'active' where userid in (".$userid.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	elseif($action == "inactivate")
	{
		$id = $dbObj->customqry("update tbl_users set status = 'inactive' where userid in (".$userid.")","");
				$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	elseif($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_users where userid in (".$userid.")","");
		$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}


ob_start();

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =20;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/


#----code for excel report----#
if($_GET['view'] == 'excel')
	{
	$out ="Merchant Information";		
	$out .="\n";
	$out .="\n";
	//$out .='Full Name,User Name,Gender,Email,City,Post Code,Address,Contact No,Registration Date,Last Login';
	$out .='Full Name,User Name,Email,Post Code,Address,Contact No,Registration Date,Last Login';				
	$out .="\n";
	$out .="\n";
	$l="";
	}

$sf="u.fullname,dp.uniqueid,dp.coupon_id,d.deal_title";
$tbl="tbl_deal_payment_unique dp,tbl_deals d ,tbl_users u";
$cd="dp.deal_id=d.deal_unique_id and dp.user_id=u.userid";

if($_GET['userid'])
	$cd.=" and dp.user_id=".$_GET['userid'];

if($_GET['searchuser'])
	$cd.=" and (du.coupon_id like '%".$_GET['searchuser']."%' || u.fullname like '%".$_GET['searchuser']."%')";

if($_GET['deal_id'])
	$cd.=" and dp.deal_id=".$_GET['deal_id'];
	
$rs=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
$rs_all=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);	

$i=0;
while($voucher=@mysql_fetch_assoc($rs))
{
	$view_voucher[$i]=$voucher;
	$i++;
}
$smarty->assign("view_voucher",$view_voucher);

/*-----------------------Pagination Part2--------------------*/
$nums =@mysql_num_rows($rs_all);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);

if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");

    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if(isset($_GET['searchuser']))
    {
	    $firstlink = "view_voucher.php?deal_id=".$_GET['deal_id']."&pay_id=".$payid."&searchuser=".$_GET['searchuser']."&userid=".$_GET['userid'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "view_voucher.php?deal_id=".$_GET['deal_id']."&pay_id=".$payid."&userid=".$_GET['userid'];
	  $seperator = '&page=';
    }
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
    $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

$smarty->display(TEMPLATEDIR . '/admin/user/view_voucher.tpl');

$dbObj->Close();
?>

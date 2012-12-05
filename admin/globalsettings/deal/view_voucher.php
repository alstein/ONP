<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
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
$newsperpage =25;
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

#----code end-----------------#
 	$loc_date=date('Y-m-d');
	$dealid=$_GET['deal_id'];
	$payid=$_GET['pay_id'];
	if($dealid!="")
	{
		if($_GET['searchuser']!="")
		{
			$qry1=$dbObj->customqry("select du.uniqueid,p.*,du.coupon_id,du.uniqueid,u.fullname from tbl_deal_payment  as p left join tbl_deal_payment_unique as du ON p.pay_id=du.pay_id left join tbl_users as u ON p.user_id=u.userid where p.deal_id=".$dealid." and p.pay_id=".$payid." and (du.coupon_id like '%".$_GET['searchuser']."%' || u.fullname like '%".$_GET['searchuser']."%') limit $l","");
		}
		else{
			$qry1=$dbObj->customqry("select du.uniqueid,d.validfrom,d.validto,p.*,du.coupon_id,du.uniqueid,u.fullname from tbl_deal_payment  as p left join tbl_deal_payment_unique as du ON p.pay_id=du.pay_id left join tbl_users  as u ON p.user_id=u.userid  left join tbl_deal d on d.deal_unique_id=p.deal_id where p.deal_id=".$dealid." and p.pay_id=".$payid." limit $l","");
		}
		$i=0;
		while($voucher=@mysql_fetch_assoc($qry1))
		{
			$view_voucher[$i]=$voucher;
			$i++;
		}
	}
// echo "<pre>";print_r($view_voucher);exit;
$smarty->assign("view_voucher",$view_voucher);
/*-----------------------Pagination Part2--------------------*/
$rs1=$dbObj->customqry("select du.uniqueid,d.validfrom,d.validto,p.*,du.coupon_id,du.uniqueid,u.fullname from tbl_deal_payment  as p left join tbl_deal_payment_unique as du ON p.pay_id=du.pay_id left join tbl_users  as u ON p.user_id=u.userid  left join tbl_deal d on d.deal_unique_id=p.deal_id where d.validfrom <='".$loc_date."' and d.validto >='".$loc_date."' and p.deal_id=".$dealid,"");
// $rs1=$dbObj->gj($tbl, $sf, $cnd, "userid", "", "DESC", "", "");
$nums =@mysql_num_rows($rs1);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
// echo $total_pages;exit;
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");

    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if(isset($_GET['searchuser']))
    {
	    $firstlink = "view_voucher.php?deal_id=".$_GET['deal_id']."&pay_id=".$payid."&searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "view_voucher.php?deal_id=".$_GET['deal_id']."&pay_id=".$payid;
	  $seperator = '&page=';
    }
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
    $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

#----code for csv report-------#
	if($_GET['view'] == 'excel')
	{
	header("Content-type: text/x-csv");
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=Merchant-details.csv");	
	echo $out;
	exit;
	}
	#----code end------#
$smarty->assign("count",$count);
$smarty->assign("loc_date",$loc_date);
$smarty->assign("voucher_save",$voucher_save);

$smarty->assign("payment_voucher",$payment_voucher);


if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/view_voucher.tpl');

$dbObj->Close();
?>

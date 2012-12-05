<?php
include_once("../../includes/paging.php");
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');

$msobj= new message();
$smarty->assign("msobj",$msobj);

if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}

// if(!$_SESSION['duAdmId'])
// 	header("location:". SITEROOT . "/admin/login/index.php");




#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	if($giftid!='')
	{
		$giftids = implode(", ", $giftid);
		if($action == "delete")
		{
			$dbObj->customqry("delete from tbl_deal_payment where pay_id in (".$giftids.")","");
			$dbObj->customqry("delete from tbl_deal_payment_unique where pay_id in (".$giftids.")","");
			$_SESSION['msg']="<span class='success'>User Deal Deleted Successfully.</span>";
		}
		header("Location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
}
#---------END-------------#


/*-----------------------Pagination Part1--------------------*/
$page=$_GET['page'];

if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;                        

$newsperpage =25;                            
$StartRow = $newsperpage * ($page-1);            
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

// $sf = "g.*,d.*,p.product_name,p.product_act_price,u.first_name,u.last_name";
// $tbl = "tbl_deal_payment_unique as g, tbl_product as p,tbl_users as u,tbl_deal_payment d";
// 
// $cnd = "p.product_id = g.deal_id AND g.pay_id = d.pay_id AND p.deal_status > 0 AND u.userid = g.user_id AND g.user_id = ".$_GET['userid'];

	$tbl = "tbl_product as p,tbl_deal_payment as dp";
	$sf = "*";
	$cnd = "p.product_id = dp.deal_id and p.product_approve = 'yes' AND p.deal_status > 0 AND dp.user_id = ".$_GET['userid'];

	$res = $dbObj->gj($tbl,$sf,$cnd,"dp.order_date","","DESC",$l, "");
	$i=0;
	$gift = array();
	while($row = @mysql_fetch_assoc($res))
	{
		// to get sales user name (deal creator)
		$re1 = $dbObj->cgs("tbl_users","username","userid",$row['sales_user_id'],"","","");
		$_row = @mysql_fetch_assoc($re1);
		$gift[$i]['payid'] = $row['pay_id'];
		$gift[$i]['deal'] = $row['product_name'];
// 		$gift[$i]['sales_user'] = $row['username'];
// 		$gift[$i]['product_name'] = $row['product_name'];

		$gift[$i]['product_price'] = $row['product_disc_price'];
		if($_row['deal_status'] == 1)
			$gift[$i]['deal_status'] = "Assigned";
		if($_row['deal_status'] == 2)
			$gift[$i]['deal_status'] = "Completed";

		// to get user name who order the deal
		$re2 = $dbObj->cgs("tbl_users","first_name,last_name","userid",$row['user_id'],"","","");
		$_row1 = @mysql_fetch_assoc($re2);
		$gift[$i]['buyer'] = $_row1['first_name']." ".substr($_row1['last_name'],0,1);
		$gift[$i]['ordered'] = $row['deal_quantity'];
		$gift[$i]['total_price'] = $row['deal_price'];
		$gift[$i]['pay_status'] = $row['payment_done'];
		$gift[$i]['cancel_order'] = $row['cancel_order'];
		$gift[$i]['order_date'] = date('M d, Y',$row['order_date']);
    if($row['used'] == 1 or $row['merchant_set'] == 1)
    {
      $gift[$i]['used'] = "Yes";
    }
    else
    {
      $gift[$i]['used'] = "No";
    }

//get the referrals
    $re22 = $dbObj->cgs("tbl_deal_credit","dp_id",array("user_id","deal_id","refer_unique_id","pay_done","add_credit"),array($row['user_id'],$row['deal_id'],$row['encrypt_unique_id'],"yes","yes"),"","","");
    if($re22 != 'n')
    {
      $num = @mysql_num_rows($re22);
    }
    else
    {
      $num = 0;
    }
    $gift[$i]['nums'] = $num;
		$i++;
	}
//  echo "<pre>";
 // print_r($gift);
	
	$smarty->assign("gift", $gift);
	
	/*-----------------------Pagination Part2--------------------*/
	$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");  
	$nums =@mysql_num_rows($rs);
	$smarty -> assign("recordsFound",$nums);
	$show = 10;        
	$total_pages = ceil($nums / $newsperpage);
	if($total_pages > 1)
		$smarty -> assign("showpgnation","yes");
	
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	$firstlink = basename($_SERVER['PHP_SELF']) . "?search=".$_GET['search'];
	$seperator = '&page=';
	$baselink  = $firstlink; 
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pagenation",$pagenation);
	/*-----------------------End Part2--------------------*/
	
	if($_SESSION['msg'])
	{
		$smarty->assign("msg", $_SESSION['msg']);
		$_SESSION['msg']=NULL;
		unset($_SESSION['msg']);
		
	}
	$smarty->assign(msg,$msg);


	if($_GET['cancel'])
	{
		if($_GET['cancel'] == 'no')
		{
			$dbObj->cupdt("tbl_deal_payment","cancel_order","yes","pay_id",$_GET['payid'],"");
			$_SESSION["msg"] = "<span class='success'>Order cancelled.</span>";
		}
		else
		{
			$dbObj->cupdt("tbl_deal_payment","cancel_order","no","pay_id",$_GET['payid'],"");
			$_SESSION["msg"] = "<span class='success'>Order activated.</span>";
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	$smarty->assign("inmenu","sitemodules");
	$smarty->display(TEMPLATEDIR . '/admin/user/view_deal.tpl');
	
	$dbObj->Close();
?>

<?php
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/paging.php");
	
	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");
	
	#-----------Delete Articles--------------#
	

		
	#----------Success message=--------------#
	if($_SESSION['msg'])
	{
		$smarty->assign("msg", $_SESSION['msg']);
		$_SESSION['msg'] = NULL;
		unset($_SESSION['msg']);
	}
	#--------------End-----------------------#

	if($_POST['action'])
	{
		extract($_POST);
		$deal_ids = @implode(", ", $deal_id);
		if($deal_ids)
		{
			if($_POST['action'] == "delete")
			{
				$id = $dbObj->customqry("delete from tbl_deal_payment where pay_id in (".$deal_ids.")","");
				$_SESSION['msg']="<span class='success'>Order deleted successfully</span>";
			}
			
		}
		else
		{
			$_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
		}
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	#--------------End-----------------------#

 $cnd_city = "active_city='1'";
	$rs_city = $dbObj->gj("mast_city", "*",$cnd_city, "city_name", "", "ASC", "", "");
	$i=0;
	while($row_city =@mysql_fetch_assoc($rs_city))
	{
		$sel_city_arr[$i]['city_name'] = utf8_encode($row_city['city_name']);
		$city1 = strtolower($row_city['city_name']);
		$city2 = str_replace(" ","-",$city1);
		$sel_city_arr[$i]['assign_city'] = utf8_encode($city2);
		$i++;
	}
	$smarty->assign("city_arr", $sel_city_arr);

	#--------Pagination1-------------------------#
	$getpage=$_GET['page'];
	if(!isset($getpage))
		$page =1;
	else
		$page = $getpage;
	$adsperpage =10;
	$StartRow = $adsperpage * ($page-1);
	$l =  $StartRow.','.$adsperpage;
	#----------------------------------------#
	
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

	#-------- Show Deals -------------------#
	
	
	$tbl = "tbl_deal as p,tbl_deal_payment as dp";
	$sf = "*";

$id=$_GET['id'];
	
	if($_POST['submit'])	
	{
		if($_POST['city'] != 'all')
		{
			$cnd = "p.product_id =".$id." and  dp.deal_id=".$id." and p.product_approve = 'yes' AND p.product_city = '".$_POST['city']."' AND p.deal_status > 0 and deal=0";
		}
		else
		{
			$cnd = "p.product_id =".$id." and  dp.deal_id=".$id." and p.product_approve = 'yes' AND p.deal_status > 0 and deal=0";
		}
	}
	else
	{
		$cnd = "p.product_id =".$id." and  dp.deal_id=".$id." and p.product_approve = 'yes' AND p.deal_status > 0 and deal=0";
	}
	$res = $dbObj->gj($tbl,$sf,$cnd,"p.product_id","","DESC",$l, "");
	$i=0;
	$deals = array();
	while($row = @mysql_fetch_assoc($res))
	{
		// to get sales user name (deal creator)
		
		$deals[$i]['payid'] = $row['pay_id'];
                $deals[$i]['product_id'] = $row['product_id'];
		$deals[$i]['deal'] = $row['product_name'];
		$deals[$i]['product_city'] = $row['product_city'];
		$deals[$i]['product_price'] = $row['product_act_price'];
		if($_row['deal_status'] == 1)
			$deals[$i]['deal_status'] = "Assigned";
		if($_row['deal_status'] == 2)
			$deals[$i]['deal_status'] = "Completed";

		// to get user name who order the deal
		$re2 = $dbObj->cgs("tbl_users","first_name,last_name","userid",$row['user_id'],"","","");
		$_row1 = @mysql_fetch_assoc($re2);
		$deals[$i]['buyer'] = $_row1['first_name']." ".substr($_row1['last_name'],0,1);
		$deals[$i]['ordered'] = $row['deal_quantity'];
		$deals[$i]['total_price'] = $row['deal_price'];
		$deals[$i]['pay_status'] = $row['payment_done'];
		$deals[$i]['cancel_order'] = $row['cancel_order'];
		$i++;
	}
// 	echo "<pre>";
// 	print_R($feed);exit;

	$smarty->assign("deal",$deals);
	#-------------End------------------------#
	
	#------------Pagination2-----------------#	
	$res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
	$nums = @mysql_num_rows($res);
	$show = 10;		
	$total_pages = ceil($nums / $adsperpage);
	if($total_pages > 1)
		$smarty->assign("showpaging", "yes");
		
	$showing = !($getpage)? 1 : $getpage;

	$firstlink = "deal_pay_info.php?";
	$seperator = 'page=';
	$baselink = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	
	$smarty->assign("pgnation",$pgnation);
	
	#----------------------------------------#

	
	$smarty->display(TEMPLATEDIR.'/admin/sitemodules/deal/deal_pay_info.tpl');
?>

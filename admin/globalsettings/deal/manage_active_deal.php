<?php
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/paging.php");
	
	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");
	
	#-----------Delete Articles--------------#
	
	if($_POST['action'])
	{
		extract($_POST);
		$deal_ids = @implode(", ", $product_id);
		if($deal_ids)
		{
			if($_POST['action'] == "delete")
			{
				$id = $dbObj->customqry("delete from tbl_deal where product_id in (".$deal_ids.")","");
				$_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";
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
	
	extract($_GET);
	
	
	
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
	
	#-------- Show Testimonails -------------------#
	
	
	$tbl = "tbl_deal as p";
	$sf = "*";
	
	
	
	if($_GET['search'])	
	{
		$cnd = "p.product_approve = 'yes' AND product_name like '%".$_GET['search']."%' and p.deal_status = 1";
	}
	else
	{
		$cnd = "p.product_approve = 'yes'  and p.deal_status = 1";
	}
	$res = $dbObj->gj($tbl,$sf,$cnd,"product_id","","DESC",$l, "");
	$i=0;
	while($row = @mysql_fetch_assoc($res))
	{
	$feed[] = $row;
	/*$query=$dbObj->cgs("tbl_deal","*","1",$row['product_id'],"","","1");
	$qur=@mysql_fetch_array($query);
	$feed[$i]['deal_start_date'] =$qur['deal_start_date'];
	$feed[$i]['deal_end_date'] =$qur['deal_end_date'];*/	
	$i++;
	}	
	
	$smarty->assign("deal",$feed);
	#-------------End------------------------#
	
	#------------Pagination2-----------------#	
	$res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
	$nums = @mysql_num_rows($res);
	$show = 10;		
	$total_pages = ceil($nums / $adsperpage);
	if($total_pages > 1)
		$smarty->assign("showpaging", "yes");
		
	$showing = !($getpage)? 1 : $getpage;
	if($search)
		$firstlink = "manage_active_deal.php?search=" . $_GET['search'];
	else
		$firstlink = "manage_active_deal.php?";
	$seperator = '&page=';
	$baselink = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	
	$smarty->assign("pgnation",$pgnation);
	
	#----------------------------------------#
	
	#----------Success message=--------------#
	if($_SESSION['msg'])
	{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
	}
	#--------------End-----------------------#
	
	$smarty->display(TEMPLATEDIR.'/admin/sitemodules/deal/manage_active_deal.tpl');
?>

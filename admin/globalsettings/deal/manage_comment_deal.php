<?php
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/paging.php");
	
	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");
	
	#-----------Delete Articles--------------#
	
	if($_POST['action'])
 	{
 		extract($_POST);
 		$deal_ids = @implode(", ", $id);
 		if($deal_ids)
 		{
 			if($_POST['action'] == "delete")
 			{
 				$id = $dbObj->customqry("delete from tbl_deal_reply where id in (".$deal_ids.")","");
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
	
// select comment
	
	extract($_POST);
 	extract($_GET);

 		$tbl = "tbl_deal as p,tbl_deal_reply as r";
		$sf ="p.product_id,p.product_slogan";
 		$cnd = "p.product_id = r.deal_id";
 		$res1 = $dbObj->gj($tbl,$sf,$cnd,"p.product_id","r.deal_id","DESC",$l, "");
		$array1 = array();
 		while($row1 = @mysql_fetch_assoc($res1))
  		{
  			$array1[] = $row1;
 		}
		
 		$smarty->assign("arr",$array1);
// 		echo "<pre>";
//  	 	print_R($array1);exit;

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

	$tbl = "tbl_deal as p,tbl_deal_reply as r";
	$sf = "*";
	//$cnd = "p.product_id = r.deal_id";
	if(isset($_GET['deal_id']))	
	{
		if($_GET['deal_id'] != 'all')
		{
			$cnd = "p.product_id = r.deal_id AND r.deal_id = '".$_GET['deal_id']."'";
		}
		else
		{
			$cnd = "p.product_id = r.deal_id";
		}
	}
	else
	{
		$cnd = "p.product_id = r.deal_id";
	}
	$res = $dbObj->gj($tbl,$sf,$cnd,"r.deal_id","","DESC",$l,"");
	$i=0;
 	while($row = @mysql_fetch_assoc($res))
 	{
 		$rs=$dbObj->cgs("tbl_users","","userid",$row['user_id'],"","","");
 		$arr1= @mysql_fetch_assoc($rs);

//print_r($arr1);exit;
	$feed[$i]['id']=$row['id'];
	$feed[$i]['product_name']=$row['product_name'];
	$feed[$i]['comment']=$row['comment'];
	$feed[$i]['comment_date']=$row['comment_date'];
	$feed[$i]['username']=$arr1['first_name']." ".$arr1['last_name'];
 		$i++;
 	}
 //	echo "<pre>";
//  	print_R($feed);exit;

	$smarty->assign("deal",$feed);
	#-------------End------------------------#
	
	#------------Pagination2-----------------#	
	$res = $dbObj->gj($tbl,$sf,$cnd,"r.deal_id","","","", "");
	$nums = @mysql_num_rows($res);
	$show = 10;		
	$total_pages = ceil($nums / $adsperpage);
	if($total_pages > 1)
		$smarty->assign("showpaging", "yes");
		
	$showing = !($getpage)? 1 : $getpage;
	if($search)
		$firstlink = "manage_comment_deal.php?search=" . $_GET['search'];
	else
		$firstlink = "manage_comment_deal.php?";
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
	
	$smarty->display(TEMPLATEDIR.'/admin/sitemodules/deal/manage_comment_deal.tpl');
?>
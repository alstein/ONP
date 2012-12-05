<?php
// include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');
include_once("../../../includes/paging.php");

$msobj= new message();

if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}


/*
if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");*/

#--------------Action---------------#
//print_r($_POST);
if(isset($_POST['action']))
{
extract($_POST);
if($categoryid!='')
{	
	$cnt = count($categoryid);

	$categoryid = implode(", ", $categoryid);
	
	if($action == "delete")
	{ 
		//$temp = $dbObj->customqry("delete from tbl_faqs where f_cat_id in (".$categoryid.")","");
		$temp = $dbObj->customqry("delete from tbl_deal_category where cate_id in (".$categoryid.")","");			
		if($cnt > 1)
        	 {
			$s=$msobj->showmessage(289);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
					//$_SESSION['msg']="<span class='success'>Categories Deleted Successfully.</span>";
		}
     		 else
		{
		$s=$msobj->showmessage(292);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				//$_SESSION['msg']="<span class='success'>Category Deleted Successfully.</span>";
		}
	}
	elseif($action=='active')
	{
		$temp = $dbObj->customqry("update tbl_deal_category set status='Active' where cate_id in(".$categoryid.")", "");
		if($cnt > 1)
         {
         $s=$msobj->showmessage(290);
	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			//$_SESSION['msg']="<span class='success'>Categories Activated Successfully.</span>";
         }		
      else
         {
         $s=$msobj->showmessage(293);
	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			//$_SESSION['msg']="<span class='success'>Category Activated Successfully.</span>";
         }
	}
	elseif($action=='inactive')
	{
		$temp = $dbObj->customqry("update tbl_deal_category set status='Inactive' where cate_id in(".$categoryid.")", "");
		if($cnt > 1)
         {
         $s=$msobj->showmessage(291);
	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			//$_SESSION['msg']="<span class='success'>Categories Inactivated Successfully.</span>";
         }
		else
         {
         $s=$msobj->showmessage(294);
	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			//$_SESSION['msg']="<span class='success'>Category Inactivated Successfully.</span>";
         }
	}
		
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
}
#--------------END---------------#

	#--------Pagination1-------------------------#
	$getpage=$_GET['page'];
	if(!isset($getpage))
		$page =1;
		else
		$page = $getpage;					
		$adsperpage =15;					
		$StartRow = $adsperpage * ($page-1);			
		$l =  $StartRow.','.$adsperpage;
	#----------------------------------------#

		#----------------Getting FAQ Category--------------------#
		// $rs = $dbObj->gj("tbl_deal_category as c", "c.*, (select count(x.f_cat_id) from tbl_faqs as x where x.f_cat_id=c.f_cat_id) as faqs" , "1", "", "", "", "", "");
		$rs = $dbObj->gj("tbl_deal_category as c", "c.*" , "1", "", "", "", $l, "");
		while($row = @mysql_fetch_assoc($rs))
			$category[] = $row;
		$smarty->assign("category", $category);
		#------------------END--------------------#

		#------------Pagination2-----------------#	
		//$res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
		$res = $dbObj->gj("tbl_deal_category as c", "c.*" , "1", "", "", "", "", "");
		$nums = @mysql_num_rows($res);
		$show = 10;		
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 1)
			$smarty->assign("showpaging", "yes");
			
		$showing = !($getpage)? 1 : $getpage;
		if($search)
			$firstlink = "manage_deal_category.php?search=" . $_GET['search'];
		else
			$firstlink = "manage_deal_category.php?";
		$seperator = '&page=';
		$baselink = $firstlink;
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		
		$smarty->assign("pgnation",$pgnation);
		
		#----------------------------------------#


		if($_SESSION['msg'])
		{
			$smarty->assign("msg",$_SESSION['msg']);
			unset($_SESSION['msg']);
		}
//$s=$msobj->showmessage(337);
//$smarty->assign("norecord",$s['msgtext']);
// $smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/deal/manage_deal_category.tpl');

$dbObj->Close();
?>
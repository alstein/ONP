<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("15", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

#----------Pagenation-------#
	$getpage=$_GET['page'];
	if(!isset($getpage))
		$page =1;
		else
		$page = $getpage;					
		$adsperpage =20;					
		$StartRow = $adsperpage * ($page-1);			
		$l =  $StartRow.','.$adsperpage;

$rs = $dbObj->gj("tbl_demand_request", "", "1", "", "", "", $l,"");
$i=0;
while($row = @mysql_fetch_assoc($rs))
{
 	$demand[] = $row;
	$rs1 = $dbObj->cgs("tbl_deal_demand", "product_name", "id",$row['demand_id'], "", "", "");
	$row1 = @mysql_fetch_assoc($rs1);
	$demand[$i]['product_name'] = $row1['product_name'];
	$rs2 = $dbObj->cgs("tbl_users", "first_name,last_name", "userid",$row['seller_id'], "", "", "");
	$row2 = @mysql_fetch_assoc($rs2);
	$demand[$i]['full_name'] = $row2['first_name']." ".$row2['last_name'];
$i++;
}
$smarty->assign("demand",$demand);
#------------Pagination2-----------------#	
	$res = $dbObj->gj("tbl_demand_request","","1","","","","", "");
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


if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/demand-request.tpl');

$dbObj->Close();
?>
<?php
include_once('../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:". SITEROOT . "/admin/login/");

/////////////////////////////////////////////
//START 
//this file is added for checking the subscription is expired or subscribed of seller
include_once(ABSPATH.'/admin/seller/check_seller_subscription.php');
//this file is added for checking the subscription is expired or subscribed of seller
//END
/////////////////////////////////////////////
	
#--------------Show no of users---------------------#	
$rs = $dbObj->cgs("tbl_users","*","","","","","");
$users = mysql_num_rows($rs);

$smarty->assign("users",$users);	
#---------------------------------------------------#

// #-------------show no of content pages--------------#
// $rs2 = $dbObj->cgs("tbl_pages","*","","","","","");
// $contentpages = mysql_num_rows($rs2);
// 
// $smarty->assign("contentpages",$contentpages);
// #---------------------------------------------------#

// #-------------------Show latest users---------------#
// 
// $rs1 = $dbObj->gj("tbl_users","first_name,last_name,userid","1","userid","","DESC","5","");
// while($row1=@mysql_fetch_assoc($rs1))
// 	$user1[]=$row1;
// $smarty->assign("user",$user1);
// #----------------------------------------------------#

#--------------------End-----------------------------#
//$smarty->assign("pgbck",$_SERVER['HTTP_REFERER']);

$smarty->assign("is_seller_access", "true");
$smarty->assign("menu", TEMPLATEDIR . "/admin/menu.tpl");
$smarty->display(TEMPLATEDIR . '/admin/index.tpl');

$dbObj->Close();
?>

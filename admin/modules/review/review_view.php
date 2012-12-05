<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!$_SESSION['duAdmId'])
{
	header("location:". SITEROOT . "/admin/login/index.php");

}
#----------Get deal review information-------------#

$review_id=$_GET['review_id'];
$sql="select * from tbl_deal_reviews where review_id=$review_id";
$resultrating=mysql_query($sql)or die(mysql_error());
$row=mysql_fetch_array($resultrating);

$deal_id=$row['deal_id'];
$reviewtext=$row['review_text'];
$reviewname=$row['review_name'];
$reviewdate=$row['review_date'];

$smarty->assign("reviewtext",$reviewtext);
$smarty->assign("reviewname",$reviewname);
$smarty->assign("reviewdate",$reviewdate);

$sqldeal="select * from tbl_deal where deal_unique_id=$deal_id";
$resultdeal=mysql_query($sqldeal)or die(mysql_error());
$rowdeal=mysql_fetch_array($resultdeal);

$rowdeal=$rowdeal['title'];

$smarty->assign("dealname",$rowdeal);

$smarty->display(TEMPLATEDIR . '/admin/modules/review/review_view.tpl');

$dbObj->Close();
?>
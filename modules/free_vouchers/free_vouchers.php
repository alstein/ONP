<?php
include_once('../../include.php');
include_once('../../includes/classes/cms_pages.class.php');
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");

$cms = new Cms_pages();

//Get content of the page as per id
$rs = $cms->getCmsPageById(16);
$title =$rs["title"]; //"Free_Vouchers";

$description = $rs["description"];
$smarty->assign("title",$title);
$smarty->assign("description",$description);

/*------------Pagination Part-1------------*/
if(!isset($_GET['page']))
	$page =1;
	else
	$page = $_GET['page'];
	$adsperpage =10;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------------*/

/*---------------------search-------------*/
if(!isset($_GET['search']))
	$_GET['search'] = "";
$cnd= "c.iMerchantName LIKE '%".$_GET['search']."%' or c.iMerchantId LIKE '%".$_GET['search']."%'";
$sf="c.*";
$ob="iMerchantName";
$rs=$dbObj->gj("tbl_affiliate_discount_codes c",$sf,$cnd, $ob, "", "", $l, "");

/*-----------------------------------------*/

if($rs != 'n')
{
	$i=0;
	while($row=@mysql_fetch_assoc($rs))
	{
		$marchantResult[$i]=$row;
		$i++;
	}
	$smarty->assign("marchantResult",$marchantResult);
}

/*----------Pagination Part-2--------------*/

$rs=$dbObj->gj("tbl_affiliate_discount_codes c",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "freecoupons?search=" . $_GET['search']."&";
	else
		$firstlink = "freecoupons?";
	$seperator = 'page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(28);
$smarty->assign("row_meta",$call_meta);

$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/free_vouchers/free_vouchers.tpl');
$dbObj->Close();
?>
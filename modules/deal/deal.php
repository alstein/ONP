<?php
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');

//START==============Get meta tags of the page as per id=========//
$call_meta=$dbObj->meta_SEO(26);
$smarty->assign("row_meta",$call_meta);
//END================Get meta tags of the page as per id=========//


//START=====================Clearing session msg=================//
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
}
//END=======================Clearing session msg=================//

//START=================Getting Deal Details=====================//
$dealId = ($_GET['dealid']?$_GET['dealid']:0);
$dealData = $dealsObj->getDealById($dealId);

if(!(count($dealData) > 0))
{
	header("location:".SITEROOT); exit;
}
$smarty->assign("dealData",$dealData);
$smarty->assign("dealGBy",$dealData); //This is only for page title and meta tags ([[deal_title]]) in header_start.tpl
//END===================Getting Deal Details=====================//


$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/deal.tpl');
$dbObj->Close();
?>
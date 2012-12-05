<?php
include_once('../../include.php');


if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/signin"); exit;
}


//START==============Get meta tags of the page as per id=========//
$call_meta=$dbObj->meta_SEO(21);
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



$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/success.tpl');
$dbObj->Close();
?>
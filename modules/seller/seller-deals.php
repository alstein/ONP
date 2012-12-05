<?php
include_once('../../include.php');

//Get meta tags of the page as per id
//$call_meta=$dbObj->meta_SEO(8);
//$smarty->assign("row_meta",$call_meta);

$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/seller/seller-deals.tpl');
$dbObj->Close();
?>
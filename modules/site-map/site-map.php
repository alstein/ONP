<?php
include_once('../../include.php');
include_once('../../includes/classes/cms_pages.class.php');
$cms = new Cms_pages();
include_once('../../includes/class.message.php');
$msobj= new message();

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(16);
$smarty->assign("row_meta",$call_meta);

$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/site-map/site-map.tpl');
$dbObj->Close();
?>
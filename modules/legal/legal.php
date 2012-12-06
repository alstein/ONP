<?php
include_once('../../include.php');
include_once('../../includes/classes/cms_pages.class.php');

$cms = new Cms_pages();

//Get content of the page as per id
$rs = $cms->getCmsPageById(11);
$title =$rs["title"];
$description =$rs["description"];
$smarty->assign("title",$title);
$smarty->assign("description",$description);

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(11);
$smarty->assign("row_meta",$call_meta);

$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/legal/legal.tpl');
$dbObj->Close();
?>
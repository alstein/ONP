<?php
include_once('../../include.php');
include_once('../../includes/classes/cms_pages.class.php');

$cms = new Cms_pages();

//Get content of the page as per id
$rs = $cms->getCmsPageById(1);
$title =$rs["title"];
$description =$rs["description"];
$smarty->assign("title",$title);
$smarty->assign("description",$description);

$row_meta=$dbObj->getseodetails(34);
$smarty->assign("row_meta",$row_meta);


$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/about-us/about-us.tpl');
$dbObj->Close();
?>
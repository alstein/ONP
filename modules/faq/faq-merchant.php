<?php
include_once('../../include.php');
include_once('../../includes/classes/cms_pages.class.php');

$cms = new Cms_pages();

$row_meta=$dbObj->getseodetails(31);
$smarty->assign("row_meta",$row_meta);


//Get content of the page as per id
$rs = $cms->getCmsPageById(14);
$title =$rs["title"];
$description =$rs["description"];
$smarty->assign("title",$title);
//$smarty->assign("description",html_entity_decode((htmlspecialchars(nl2br($description)))));
//$smarty->assign("description",(strip_tags(nl2br(html_entity_decode(htmlspecialchars(stripslashes($description)))))));
$smarty->assign("description",(strip_tags(nl2br($description))));


$result=$dbObj->customqry("select * from tbl_faqs where faq_cat_id=14 and del_status='1'","");
$i=0;
while($row=mysql_fetch_array($result)){
	$faq_cat[]=$row;
	$faq_cat[$i]['q']=str_replace("”"," ",$dbObj->sanitize(nl2br(stripcslashes(html_entity_decode(strip_tags($row['faqquestion']))))));
	$faq_cat[$i]['a']=str_replace("”"," ",$dbObj->sanitize(nl2br(stripcslashes(html_entity_decode(strip_tags($row['faqanswer']))))));;
$i++;
}
$smarty->assign("faq",$faq_cat);
//echo "<pre>";print_r($faq_cat);echo "</pre>";
//=================================================

      $smarty->assign("flag",$flag);	
      $smarty->assign("category_list",$faq_cat);
      $smarty->assign("array_cate",$array_FAQ);

//=================================================



$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/faq/faq-merchant.tpl');
$dbObj->Close();
?> 
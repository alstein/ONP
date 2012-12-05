<?php
include_once('../../include.php');
include_once('../../includes/classes/cms_pages.class.php');

$row_meta=$dbObj->getseodetails(30);
$smarty->assign("row_meta",$row_meta);


$result=$dbObj->customqry("select * from tbl_faqs where faq_cat_id=1 and del_status='1'","");
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
$smarty->display(TEMPLATEDIR . '/modules/faq/faq-consumer.tpl');
$dbObj->Close();
?> 
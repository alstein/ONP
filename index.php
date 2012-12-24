<?php

$PATH_PREFIX = "../";
include_once('include.php');
include_once('../includes/SiteSetting.php');

//$date=date("d-m-Y");
//$arr=explode("-",$date);
//$dd=$arr[0];
//$mm=$arr[1];
//$yy=$arr[2];
//$smarty->assign("dd",$dd);
//$smarty->assign("mm",$mm);
//$smarty->assign("yy",$yy);

$range_result = $dbObj->customqry( " SELECT MAX(`id`) AS max_id , MIN(`id`) AS min_id FROM tbl_slide_images ","");
$range_row = @mysql_fetch_object( $range_result );
$random = mt_rand( $range_row->min_id , $range_row->max_id );

$result = $dbObj->customqry(  " SELECT * FROM tbl_slide_images WHERE `id` >= $random LIMIT 0,1 ",""); 
$row = @mysql_fetch_array($result);
$slide_image_id1=$row['id'];
$smarty->assign("slide_image_id1",$slide_image_id1);

$smarty->display(TEMPLATEDIR.'/newindex.tpl');

$dbObj->Close();
?>

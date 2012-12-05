<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =20;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

/*-----------------------End Part1--------------------*/

$row_meta=$dbObj->getseodetails(23);
$smarty->assign("row_meta",$row_meta);



//$tbl="tbl_deals d left join tbl_users u on d.merchant_id=u.userid";
$date = date("Y-m-d H:i:s");	
$tbl="tbl_deals d,tbl_users u";
$sf="d.deal_unique_id,d.deal_title,d.offer_price,d.deal_image,d.deal_end_date,d.max_deal_no,d.discount_in_per,u.business_name,u.first_name,u.last_name";
$cd=" d.merchant_id=u.userid and d.deal_end_date >= '$date' ";
$ob="d.deal_category";
$ad="desc";
$prn="";
$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l,$prn);
$res_all=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, "",$prn);
while($row=@mysql_fetch_array($res)){
			$all_deals[]=$row;
}


$smarty->assign("all_deals",$all_deals);



/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($res_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;



      $firstlink = SITEROOT."/deal/viewalldeal/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}








$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/viewalldeal.tpl');
$dbObj->Close();
?>

<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

	if(!isset($_SESSION['csUserId']))
	{
		header("location:".SITEROOT); exit;
	}

$row_meta=$dbObj->getseodetails(20);
$smarty->assign("row_meta",$row_meta);


/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =10;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

/*-----------------------End Part1--------------------*/



$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
if(strpos($url,"view_search_merchant")){
	$smarty->assign("page","1");
}else{
	$smarty->assign("page","2");
}

	$whose_profile="view_searches";
	$smarty->assign("whose_profile",$whose_profile);

$cat=$_POST['cat_ref'];
$cat1=@implode(",",$cat);

$select_category=$dbObj->customqry("select category,id from  mast_deal_category where id='".$_GET['id1']."'","");
$res_select_category=@mysql_fetch_assoc($select_category);
$smarty->assign("select_category",$res_select_category);


	
		$cnd_searches = "u.usertypeid=3 and 	deal_cat in('".$_GET['id1']."')";
	

	$select_search = $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches limit $l", "");

	$select_search_all = $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches", "");

	$i=0;
	while($res_searches=@mysql_fetch_assoc($select_search))
	{
		$searches[]=$res_searches;

		$select_rating1=$dbObj->customqry("select *,count(rating_id)  as count,sum(average_rating) as sum_rating from tbl_rating where merchant_id ='".$res_searches['userid']."'","");
		$res_rating1=@mysql_fetch_assoc($select_rating1);
		$count1=$res_rating1['count'];
		$sum_rating1=$res_rating1['sum_rating'];
		$average_rating1=@($sum_rating1/$count1);
		$searches[$i]['rating']=$average_rating1;


		$select_from_fan=$dbObj->customqry("select f.* from  tbl_fan f  where (f.userid='".$res_searches['userid']."' and f.fan_id='".$_SESSION['csUserId']."') ", "");
		$count=@mysql_num_rows($select_from_fan);
		$searches[$i]['count']=$count;
		$i++;
	}
//echo "<pre>";print_r($searches);echo "</pre>";


/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($select_search_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;


	  $firstlink = SITEROOT."/merchant-account/view_search_merchant/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}

#-----------------------------------#


// echo "<pre>"; print_r($searches);
// echo 
	
extract($_POST);

//print_r($_POST);echo"=========";//exit;
	if($act=="Insert")
	{
	//echo $fid1."==========";exit;
	$userid=$_POST['fid1'];
	$fanid=$_SESSION['csUserId'];
	$tbl11="tbl_fan";
	$fv=array($userid,$fanid,'Active');
	$fn=array("userid","fan_id","status");
	$rs=$dbObj->cgi($tbl11,$fn,$fv,"");
 	@header("location:".SITEROOT."/merchant-account/view_search_merchant");
	
	}	



$smarty->assign("searches",$searches);
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/view_search_merchant_cat.tpl');
$dbObj->Close();
?>
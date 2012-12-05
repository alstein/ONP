<?php
include_once('../../include.php');

	if(!isset($_SESSION['csUserId']))
	{
		header("location:".SITEROOT); exit;
	}

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


	if($_POST['name']!="" && $_POST['maincategory']!="" && $_POST['cityid']!="")
	{
			$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us LIKE '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%'  ) and u.deal_cat in= '".$cat1."' and u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	}
	elseif($_POST['name']!="" && $_POST['maincategory']!="")
	{
		$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us  '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%'  ) and u.deal_cat in = '".$cat1."' and u.usertypeid=3 ";
	}
	elseif($_POST['name']!="" && $_POST['cityid']!="")
	{
		$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us LIKE '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%' )  and u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	}
	elseif($_POST['maincategory']!="" && $_POST['cityid']!="")
	{
		$cnd_searches = "u.deal_cat in '".$cat1."' and u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	}
	elseif($_POST['name']!="")
	{

			$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us LIKE '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%' )  and u.usertypeid=3 ";
	}
	elseif($_POST['maincategory']!="")
	{
		
			$cnd_searches = " u.deal_cat in  '".$cat1."' and u.usertypeid=3 ";
	}
	elseif($_POST['cityid']!="")
	{

		$cnd_searches = "u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	
	}
	else
	{
		$cnd_searches = "u.usertypeid=3 ";
	}

	$select_search = $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches", "");
	$i=0;
	while($res_searches=@mysql_fetch_assoc($select_search))
	{
		$searches[]=$res_searches;
		$select_from_fan=$dbObj->customqry("select f.* from  tbl_fan f  where (f.userid='".$res_searches['userid']."' and f.fan_id='".$_SESSION['csUserId']."') ", "");
		$count=@mysql_num_rows($select_from_fan);
		$searches[$i]['count']=$count;
		$i++;
	}

	
extract($_POST);
	if($act=="Insert")
	{
	//echo $fid1;exit;
	$userid=$_POST['fid1'];
	$fanid=$_SESSION['csUserId'];
	$tbl11="tbl_fan";
	$fv=array($userid,$fanid,'Active');
	$fn=array("userid","fan_id","status");
	$rs=$dbObj->cgi($tbl11,$fn,$fv,"");
	header('Location: '.SITEROOT.'/merchant-account/view_search_merchant');
	}	


// echo "<pre>"; print_r($searches);
// echo 


$smarty->assign("searches",$searches);
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/view_search_merchant.tpl');
$dbObj->Close();
?>
<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
    header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(1);
$smarty->assign("row_meta",$row_meta);

$whose_profile="Consumer";
$smarty->assign("whose_profile",$whose_profile);

if($_GET['id1']!="")
{
    $user=$_GET['id1'];
}
else
{
    $user=$_SESSION['csUserId'];
}
$select_user_profile=$dbObj->customqry("select u.* from tbl_users  u  where u.userid='".$user."'","");
$res_select_profile=@mysql_fetch_assoc($select_user_profile);
$arr=explode(":",$res_select_profile['business_start_date1']);
$business_start_date1=$arr[0].":".$arr[1];
$arr1=explode(":",$res_select_profile['business_end_date1']);
$business_end_date1=$arr1[0].":".$arr1[1];

$arr2=explode(":",$res_select_profile['business_start_date2']);
$business_start_date2=$arr2[0].":".$arr2[1];
$arr3=explode(":",$res_select_profile['business_end_date2']);
$business_end_date2=$arr3[0].":".$arr3[1];
$smarty->assign("business_start_date2",$business_start_date2);
$smarty->assign("business_end_date2",$business_end_date2);

$smarty->assign("business_start_date1",$business_start_date1);
$smarty->assign("business_end_date1",$business_end_date1);
$smarty->assign("user_profile",$res_select_profile);

$select_category=$dbObj->customqry("select u.*,d.category,d.id from tbl_users  u left join mast_deal_category d on u.deal_cat=d.id   where u.userid='".$user."'","");
$res_select_category=@mysql_fetch_assoc($select_category);
$smarty->assign("select_category",$res_select_category);

$select_subcategory=$dbObj->customqry("select u.*,d.category from tbl_users  u left join mast_deal_category d on u.deal_subcat=d.id   where u.userid='".$user."'","");
$res_select_subcategory=@mysql_fetch_assoc($select_sucategory);
$smarty->assign("select_subcategory",$res_select_subcategory);


$selusername1=$dbObj->customqry("select * from tbl_users where userid='".$user."'","");
$resusername1=@mysql_fetch_assoc($selusername1);
$ses_username1=$resusername1['username'];

$smarty->assign("username1",$ses_username1);
$tbla="tbl_album a left join tbl_albumphotos p on a.album_id=p.album_id";
$cnda="a.user_id=".$user;
$oba="a.album_id";
$ada="desc";
$la="3";
$ares=$dbObj->gj($tbla, "p.thumbnail,a.url_title" , $cnda, $oba, $gb, $ada, $la, "");
//$ares=$dbObj->customqry("select * from tbl_album where user_id=".$user." order by album_id desc limit 0,3","");
while($arow=@mysql_fetch_array($ares)){
	$albums[]=$arow;
}

$smarty->assign("albums",$albums);
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/merchant_profile.tpl');
$dbObj->Close();
?>
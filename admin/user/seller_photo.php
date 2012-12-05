<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");



ob_start();


// for user and user album detail
$sf="u.fullname,u.userid,a.*";
$tbl="tbl_users u left join tbl_album a  ON u.userid=a.user_id";
$cnd="a.album_id=".$_GET['album_id'];

$rs = $dbObj->gj($tbl,$sf,$cnd,"","","","",""); 
$row=@mysql_fetch_array($rs);

$cnd_albumphoto="user_id=".$row['userid']." and album_id=".$row['album_id'];
$rs_albumphoto = $dbObj->gj("tbl_albumphotos","*",$cnd_albumphoto,"photo_id","","asc","","");
while($row_albumphoto=@mysql_fetch_assoc($rs_albumphoto))
{
	$image[]=$row_albumphoto;	
}


$smarty->assign("users", $row);
$smarty->assign("image",$image);
//echo "<pre>";print_r($row);echo "</pre>";
//echo "<pre>";print_r($image);echo "</pre>";
/*-----------------------Pagination Part2--------------------*/
/*-----------------------End Part2--------------------*/

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/seller_photo.tpl');
$dbObj->Close();
?>

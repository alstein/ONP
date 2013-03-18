<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
    header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(24);
$smarty->assign("row_meta",$row_meta);

$whose_profile="Consumer";
$smarty->assign("whose_profile",$whose_profile);
if($_GET['id1']!="")
{
    $select_friend_acc=$dbObj->customqry("select count(*) as count_friend_acc from tbl_friends where (userid='".$_GET['id1']."' and friendid='".$_SESSION['csUserId']."') or (userid='".$_SESSION['csUserId']."' and friendid='".$_GET['id1']."')","");
    $res_friend_acc=@mysql_fetch_assoc($select_friend_acc);
    $smarty->assign("friend_acc",$res_friend_acc);

    $select_fan_acc=$dbObj->customqry("select count(*) as count_fan_acc from tbl_fan where (fan_id='".$_GET['id1']."' and userid='".$_SESSION['csUserId']."') ","");
    $res_fan_acc=@mysql_fetch_assoc($select_fan_acc);
    $smarty->assign("fan_acc",$res_fan_acc);
}
if($_GET['id1']!="")
{
    $user=$_GET['id1'];
}
else
{
    $user=$_SESSION['csUserId'];
}
$select_user_profile=$dbObj->customqry("select u.*,c.country,s.state_name from tbl_users  u left join mast_country c on u.countryid=c.countryid left join mast_state s on u.state_id=s.id  where u.userid='".$user."'","");
$res_select_profile=@mysql_fetch_assoc($select_user_profile);
$smarty->assign("user_profile",$res_select_profile);


//get category preferance

$ecat_ref=explode(",",$res_select_profile['category_preferance']);
$icat_ref=implode(",",$ecat_ref);

$cqry=$dbObj->customqry("select category from mast_deal_category where id in (".$icat_ref.")","");
while($crow=mysql_fetch_assoc($cqry)){
    $category.=$crow['category'].",";
}

$category=substr_replace($category,"",-1);
$smarty->assign("category",$category);

//get category preferance
extract($_POST);
if($act=="Insert")
{
    //echo $fid1;exit;
    $friendid=$_GET['id1'];
    //die($friendid);
    $userid=$_SESSION['csUserId'];
    $sel=$dbObj->customqry("select * from tbl_friends where (userid=".$friendid." and friendid=".$userid.") or (userid=".$userid." and friendid=".$friendid.")","");
    $cnt=@mysql_num_rows($sel);
    if($cnt==0)
    {
        $tbl11="tbl_friends";
        $fv=array($userid,$friendid,date('Y-m-d H:m:s'),'pending');
        $fn=array("userid","friendid","request_date","verification");
        $rs=$dbObj->cgi($tbl11,$fn,$fv,"");
        $smarty->assign('count_friend','1');
    }
}

$selusername1=$dbObj->customqry("select * from tbl_users where userid='".$user."'","");
$resusername1=@mysql_fetch_assoc($selusername1);
$ses_username1=$resusername1['username'];

$smarty->assign("username1",$ses_username1);

$ares=$dbObj->customqry("select * from tbl_album where user_id=".$user." order by album_id desc limit 0,3","");
$anums=mysql_num_rows($ares);
$anums1=3-$anums;
while($arow=@mysql_fetch_array($ares)){
    $albums[]=$arow;
}

$smarty->assign("albums",$albums);
$smarty->assign("anums",$anums);
$smarty->assign("anums1",$anums1);
$smarty->display(TEMPLATEDIR . '/modules/my-account/my_profile.tpl');
$dbObj->Close();
?>
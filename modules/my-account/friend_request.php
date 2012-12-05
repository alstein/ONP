<?php
include_once('../../include.php');
include_once("../../includes/paging.php");
//echo "<pre>";print_r($_SESSION);echo "</pre>";
if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!=2)
{
	header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(13);
$smarty->assign("row_meta",$row_meta);


$whose_profile="friend_request";
$smarty->assign("whose_profile",$whose_profile);
#------------Pagination Part-1------------
if(!$_GET['page'])
$page =1;
else
$page = $_GET['page'];

$adsperpage = 10;
$StartRow = $adsperpage * ($page-1);
$l =  $StartRow.','.$adsperpage;
#-----------------------------------
$tbl  =  "tbl_users u,tbl_friends as f";
$sf   =  "u.*,f.*";

$cnd  =  "((f.userid = u.userid AND  f.friendid=".$_SESSION['csUserId']." AND f.verification='pending'))";
//$cnd  =  "((f.friendid = u.userid AND  f.userid=".$ids." AND f.verification='panding') AND u.first_name like '$asfa%')";
$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", $l, "");
$numrows=@mysql_num_rows($rs);
$smarty->assign("numrows",$numrows);
while($row = @mysql_fetch_assoc($rs))
{
	$contacts[] = $row;
}

//print_r($contacts);
$smarty->assign("contacts", $contacts);



/*----------Pagination Part-2--------------*/
$rs = $dbObj->gj($tbl, $sf, $cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = (!$page)? 1 : $page;
	$firstlink =  SITEROOT."/my-account/friend_request/?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty->assign("paging",$pgnation);
}
/*----------END Pagination Part-2--------------*/


#-------delete-----------

extract($_POST);
if($act=="delete")
{
	//echo $fid;exit;
	$tbl1="tbl_friends";
	$rss = $dbObj->gdel($tbl1,array("id"),array($fid),"");
	
	header("location:".SITEROOT."/my-account/friend_request/");
	$msg="Contact Deleted Successfully.";
	$smarty->assign("msg",$msg);
}
#-------------end----------

if($act=="update")
{
if($fid1!="")
{
$sel=$dbObj->customqry("select userid,friendid from tbl_friends where id='".$fid1."'","1");
$res_sel=mysql_fetch_assoc($sel);
$userid=$res_sel['userid'];
$friend_id=$res_sel['friendid'];
}
	//echo $fid1;exit;
	$tbl11="tbl_friends";
	$rss1=$dbObj->customqry("update tbl_friends set verification='yes',verification_date='".array("yes",date('Y-m-d'))."' where (userid='".$userid."' and friendid='".$friend_id."') or (userid='".$friend_id."' and friendid='".$userid."')","1");
// 	$rss1 = $dbObj->cupdt($tbl11,array("verification","verification_date"),array("yes",date('Y-m-d')),"id",$fid1,"");

	header("location:".SITEROOT."/my-account/friend_request");
	exit;	
}

#-------------end----------

$smarty->assign("acttab","requests");

$smarty->display(TEMPLATEDIR . '/modules/my-account/friend_request.tpl');
$dbObj->Close();
?>
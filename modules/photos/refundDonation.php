<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/classes/class.account.php');
if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}
	
if($_GET['id1']=="")
{
	$userid = $_SESSION['csUserId'];
}
else
{
	$userid = $_GET['id1'];
}
$profile = $profObj->fetchProfile($userid);
$smarty->assign("user",$profile);
// print_r($_GET);exit;
$tipId = $_GET['tipid'];
$guestId = $_GET['guestid'];
$hostId = $_GET['hostid'];



#====for chanege status to canceled=====#
if($tipId!="")
{
    $changeStat = $dbObj->cupdt("tbl_tip_donate","status","Canceled","tdid",$tipId,"1");
}



#====for chanege status to paending=====#
if($tipId!="" && $guestId!="" && $hostId!="")
{
    $changeStat = $dbObj->cupdt("tbl_tip_donate","status","Pending","tdid",$tipId,"1");
}

#======Delete Doantion from tip & doante======#
// if($tipId!="")
// {
//     $Deldonation=$accountObj->DeleteDonation($tipId);
// }

#======Delete Doantion from tip & doante======#
// if($guestId!="" && $hostId!="")
// {
//     $refund=$profObj->refundDonation($guestId,$hostId,'0.99');
// }

// #======Fetching donations details======#
// $tbl = "tbl_tip_donate as dn LEFT JOIN users as u ON dn.hostid = u.userid";
// $sf = "u.*,dn.*";
// $cnd = "dn.guestid =".$_SESSION['csUserId']." and dn.moduleid = '2'";
// $sqlFetchCredits = $dbObj->gj($tbl,$sf,$cnd,"","","","","");
// while($resFetch = @mysql_fetch_assoc($sqlFetchCredits))
// {
//     $donations [] = $resFetch;
// }
// $smarty->assign("donations",$donations);


$smarty->assign("tabact","setting");
$smarty->assign("scttab","setting");
$smarty->assign("sctmenu","credits");
$smarty->assign("bodyclass","nactive");
?>
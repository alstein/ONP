<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/classes/class.profile.php");
include_once('../../includes/classes/class.photos.php');
include_once('../../includes/paging.php');

if(!$_SESSION['csUserId'])
{
    header("location:".SITEROOT."/");
    exit;
}

if($_POST['addDonatetion']=="Donate")
{
      $subToDoante = $profObj->subDonate($_SESSION['csUserId'],$siteUserId,'0.99');

       $comment =  "<a href=".SITEROOT."/".$_SESSION['csUserName']."/>".$_SESSION['csUserName']."</a> has sent you donation. Please accept or decline it from your Credit Management > Donations.";
       $f=array("moduleid","itemid","userid","comment","date_added","notify");
       $v=array('19',$siteUserId,$_SESSION['csUserId'],$comment,date("Y-m-d h:i:s"),"1");
       $id=$dbObj->cgi("tbl_comments",$f,$v,"");
      header("location:".$_SERVER["HTTP_REFERER"]);
      exit;
}

#===For fetchning album count===#
$resarr = $photoObj->displayUserAlbums($siteUserId,$_GET['page'],'private');
$smarty -> assign("pgnation",$resarr[1]['pgnation']);
$smarty->assign("photodetails",$resarr[0]);
 
#===For fetchning user information===#
$userid=$siteUserId;
$userinfo = $profObj->fetchProfile($userid);
$smarty->assign("user",$userinfo);

$privacyRating= $profObj->calPrivacyRating($_GET['privacy'],"1",$userid);
$smarty->assign("privacyRating",$privacyRating);

$smarty->assign("siteroot", SITEROOT);
$smarty->assign("albcount",$resarr[1]['nums']);
$smarty->assign("showright","yes");
$smarty->assign("tabact","photo");
$smarty->display(TEMPLATEDIR . '/modules/photos/donation-request.tpl');
$dbObj->Close();
?>
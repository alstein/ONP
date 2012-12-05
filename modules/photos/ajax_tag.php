<?php 
include_once('../../include.php');

$userid=$_SESSION['csUserId'];

#-------------------------------------------------------------------------------------

  $tblfriend = "tbl_friends as fd,tbl_users as u ";
  $sffriend  = "u.userid,u.fullname,u.username,u.thumbnail";
  $cndfriend  = "(fd.userid='".$userid."' or fd.friendid IN('".$userid."')) AND ((u.userid=fd.friendid and u.userid!='".$userid."' ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'yes' AND fd.del_status = 'no' AND u.fullname LIKE  '%".$_GET['friendname']."%'";
        $obfriend   = 'u.fullname';
        $getresult  = $dbObj->gj($tblfriend, $sffriend , $cndfriend, $obfriend, "", "", "", ""); 
	$comcnt = @mysql_num_rows($getresult);
            $i=0;
            while($inmessage = @mysql_fetch_assoc($getresult))
            {
                 $friendsinfo[$i] = $inmessage;
		  $friendsinfo[$i]['comcnt'] = $comcnt;
                 $i++;
            }

   $smarty->assign("friends",$friendsinfo);
//get image name
$cndgetimage=" photo_id=".$_GET['idimg'];
$resgetimage=$dbObj->gj("tbl_albumphotos","*",$cndgetimage,"","","","","");
$getimg=@mysql_fetch_assoc($resgetimage); /*echo $getimg['thumbnail'];*/
$smarty->assign("imagename",$getimg['thumbnail']);

//get tag user"tbl_photo_tag"


$tblimageuser="tbl_photo_tag as pt LEFT JOIN tbl_users as u ON pt.userid=u.userid";
$cndgetimageuser=" photoid=".$_GET['idimg'];
$resgetimageuser=$dbObj->gj($tblimageuser,"pt.*,u.username,u.userid",$cndgetimageuser,"","","","","");
$linechecktag=@mysql_num_rows($resgetimageuser);
$j=0;
while($getrowimg=@mysql_fetch_assoc($resgetimageuser))
{
   $getimguser[$j]=$getrowimg;$j++;
 /*echo $getimg['thumbnail'];*/
}
$smarty->assign("getimguser",$getimguser);
$smarty->assign("getimgusercount",$linechecktag);
#-------------------------------------------------------------------------------------

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR .'/modules/photos/ajax_tag.tpl');

?>
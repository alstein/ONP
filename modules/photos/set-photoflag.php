<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/common.lib.php');
include_once('../../includes/classes/class.video.php');
include_once('../../includes/classes/class.profile.php');

if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}

if($_GET['itemid']!='')
{
    $fl = array("userid","itemid","moduleid","reason","date_added");
    $vl =array($_SESSION['csUserId'],$_GET['itemid'],"2",$_GET['reason'],date("Y-m-d H:i:s"));
    
    $sql = "Select userid,itemid from tbl_abuse where userid=".$_SESSION['csUserId']." and itemid=".$_GET['itemid'];
    $res=$dbObj->customqry($sql,"");//exit;
    $row=@mysql_fetch_assoc($res);
    if($row!="")
    {
        $sql = "Delete from tbl_abuse where userid=".$_SESSION['csUserId']." and itemid=".$_GET['itemid'];
        $sqlDel = $dbObj->customqry($sql,"");//exit;//$updateSetting=$dbObj->cupdt("tbl_abuse",$fl,$vl,"userid",$_SESSION['csUserId'],"1");//exit;
    }
    else
    {
        $InsertReport = $dbObj->cgi("tbl_abuse",$fl,$vl,"");
    }
}

$userinfo = $profObj->fetchProfile($_SESSION['csUserId']);
$smarty->assign("user",$userinfo);

if(isset($_SESSION['msg']))
{
    $smarty->assign("msg",$_SESSION['msg']);
    unset($_SESSION['msg']);
}

   $smarty->display(TEMPLATEDIR .'/modules/photos/set-photoflag.tpl');   
   $dbObj->Close();

?>
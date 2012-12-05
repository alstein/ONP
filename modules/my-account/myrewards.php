<?php
include_once('../../include.php');
$select=$dbObj->customqry("SELECT rewardpoints, flag FROM tbl_rewards WHERE userid=".$_SESSION['csUserId']." and flag=1","");
$rsltset=@mysql_fetch_assoc($select);

$select2=$dbObj->customqry("SELECT rewardpoints, flag FROM tbl_rewards WHERE userid=".$_SESSION['csUserId']." and flag=2","");
$rsltset2=@mysql_fetch_assoc($select2);

$select3=$dbObj->customqry("SELECT rewardpoints, flag FROM tbl_rewards WHERE userid=".$_SESSION['csUserId']." and flag=4","");
$rsltset3=@mysql_fetch_assoc($select3);

$rewardsintotal=$rsltset['rewardpoints']+$rsltset2['rewardpoints'];
$lostrewards=$rewardsintotal-$rsltset3['rewardpoints'];
$smarty->assign("rewardpointsforreview",$rsltset['rewardpoints']);
$smarty->assign("rewardpointsbuydeal",$rsltset2['rewardpoints']);
$smarty->assign("rewardpointstotal",$rsltset3['rewardpoints']);
$smarty->assign("lostrewards",$lostrewards);
$smarty->display(TEMPLATEDIR.'/modules/my-account/myrewards.tpl');

$dbObj->Close();
?>

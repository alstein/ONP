<?php
include_once('../../../includes/SiteSetting.php');

#------------Get all Users---------------#
$tbl = "tbl_users";
$cnd = "isverified = 'yes'";
$rs = $dbObj->gj($tbl,"email",$cnd, "", "", "", "", "");

if($rs !='n')
{
    while($row_user = @mysql_fetch_assoc($rs))
    {
	    $user_info[] = $row_user;
    }
    $smarty->assign("user",$user_info);
}
#------------End all Users---------------#

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/message-center/add_to_sub.tpl');
?>
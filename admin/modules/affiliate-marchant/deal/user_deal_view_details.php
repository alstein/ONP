<?php
include_once('../../../../includes/SiteSetting.php');
include_once("../../../../includes/common.lib.php");
include_once('../../../../includes/class.message.php');
include_once('../../../../includes/function.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("84", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

//////////deal viewed user details start//////////
$res_userdetails = $dbObj->customqry("SELECT * FROM tbl_users tu WHERE tu.userid = ".$_GET['userid'],"");
if($res_userdetails != 'n')
{
	if($row_userdetails = @mysql_fetch_assoc($res_userdetails))
	{
		$userDetails = $row_userdetails;
	}
	$smarty->assign("userDetails",$userDetails);
}
//////////deal viewed user details end//////////

//////////deal viewed count user details start//////////
$res_usercountdetails = $dbObj->customqry("SELECT duc.* FROM `tbl_affiliate_deal_user_count` duc, `tbl_affiliate_deal_count` dc WHERE duc.user_id = ".$_GET['userid']." AND duc.d_c_id = dc.d_c_id AND dc.deal_unique_id = ".$_GET['id'],"");
if($res_usercountdetails != 'n')
{
	while($row_usercountdetails = @mysql_fetch_assoc($res_usercountdetails))
	{
		$userCountDetails[] = $row_usercountdetails;
	}
	$smarty->assign("userCountDetails",$userCountDetails);
}
//////////deal viewed count user details end//////////

#------------Display Message----------------#
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}
#--------------------------------------------#

$smarty->display(TEMPLATEDIR.'/admin/modules/affiliate-marchant/deal/user_deal_view_details.tpl'); 
$dbObj->Close();
?>

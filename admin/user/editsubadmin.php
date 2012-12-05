<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/common.lib.php');
include_once('../../includes/class.message.php');
$msobj= new message();

print_r($_POST);
//Chek for admin login
if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");


if($_POST['Submit'])
{
	extract($_POST);
print_r($_POST);
	$set_field = array('first_name','last_name','username','password','usertypeid','access_level','signup_date','status');
	$set_values = array($first_name,$last_name,$loginname,md5($password),"1",$level,date("Y-m-d H:i:s"),'Active');
   //print_r($set_values);exit;
   $dbres = $dbObj->cgi('tbl_users', $set_field , $set_values,"");
//print_r($dbObj);exit;
	$s=$msobj->showmessage(2);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	header("Location:" . SITEROOT."/admin/user/subadmin.php");
	exit;
	
 }

$rs=$dbObj->cgs("mast_admin_modules","","","","","","0");
while($row=@mysql_fetch_array($rs))
{
	$modules[] = $row;
}
$smarty->assign("modules",$modules);
#--------END-------------

/////////////access  levels 
$rs1=$dbObj->cgs("mast_levels","","","","","","0");
while($rows=@mysql_fetch_array($rs1))
{
	$levels[] = $rows;
}
$smarty->assign("levels",$levels);

#--------END-------------

if($_SESSION['msg']!="")
{
$smarty->assign("msg",$_SESSION['msg']);
unset($_SESSION['msg']);
}


$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/editsubadmin.tpl');

$dbObj->Close();
?>
<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("18", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

if(isset($_POST['subject'])){
	extract($_POST);
	for($i=0; $i < count($emailid); $i++)
	{
		$f = array("subject", "message");
		$v = array($subject[$i], $message[$i]);
		$dbObj->cupdt("mast_emails", $f, $v, "emailid", $emailid[$i], "");
	}
		$s=$msobj->showmessage(68);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	header("Location: ". $_SERVER['HTTP_REFERER']);
	exit;
}

#------Getting system Emails---------
//$rs = $dbObj->cgs("mast_emails", "", "", "", "", "", "");
//$sql="SELECT * FROM mast_emails WHERE emailid in(1,22,16,20,48,49,55,56,57,58)";
$sql="SELECT * FROM mast_emails ORDER BY subject";
$mainsql=mysql_query($sql);
while($row = @mysql_fetch_assoc($mainsql))
	$emails[]=$row;
$smarty->assign("emails", $emails);
#-----------END------------



$smarty->display(TEMPLATEDIR.'/admin/globalsettings/system_emails.tpl');
$dbObj->Close();
?>
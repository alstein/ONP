<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.mymessage.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("34", $arr_modules_permit)) )
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$umsgObj= new Mymessage();

if(isset($_GET['user']))
{

 $cnd_msg="u.userid = m.user_id and m.id=".$_GET['id'];
    $user=$dbObj->gj("tbl_users as u,tbl_message as m","u.first_name,u.last_name,u.email",$cnd_msg,"","","","","");
    $row1=@mysql_fetch_assoc($user);
    $smarty->assign("getuser", $row1);
}
else
if(isset($_GET['id']))
{
    $cnd_msg="u.userid = m.from_id and m.id=".$_GET['id'];
    $user=$dbObj->gj("tbl_users as u,tbl_message as m","u.first_name,u.last_name,u.email",$cnd_msg,"","","","","");
    $row1=@mysql_fetch_assoc($user);
    $smarty->assign("getuser", $row1);
}

#----------------Compose message----------------#
if(isset($_POST['send']) && isset($_POST['email_id']))
{
	extract($_POST);
	$frnds_name_arr =  explode(" ",$_POST['email_id']);

	$slt_frnd ="u.*";
	$tbl1 = "tbl_users as u";

	$cnd_frnd = "u.isverified = 'yes' and u.first_name = '".strtolower($frnds_name_arr[0])."' and u.last_name = '".strtolower($frnds_name_arr[1])."' and u.email = '".str_replace(array("(",")"),"",$frnds_name_arr[2])."'";

	//$cnd_frnd .= " and u.userid <> '".$_SESSION['duAdmId']."'";


	$emailid=$dbObj->gj($tbl1, $slt_frnd, $cnd_frnd,"", "", "","", "");
	$row=@mysql_fetch_assoc($emailid);
			
	if($row['first_name']==$frnds_name_arr[0] && $row['email']==str_replace(array("(",")"),"",$frnds_name_arr[2]))
	{	
	    #-------------- message store in sent item -----------------#
	    $sf3 = array("from_id", "user_id", "subject", "message","user_type", "posted_date","is_question");
	    $sv3 = array($_SESSION['duAdmId'], $row['userid'], $message_subject, nl2br($msg_details),1,date('Y-m-d H:i:s'),"yes");
	    $insert = $dbObj->cgi("tbl_message", $sf3, $sv3, "");
	    #-----------------------------------------------------------#

	    $s=$msobj->showmessage(143);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	else
	{
	    $s=$msobj->showmessage(144);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        }

	header("Location:".SITEROOT."/admin/modules/member-message/member-message.php");
	exit;
}
#--------------End Compose message-------------#

#----------Set messages into session ----------#
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
#--------End messages into session ---------#


$smarty->display(TEMPLATEDIR . '/admin/modules/member-message/compose.tpl');
$dbObj->Close();
?>

<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
// print_r($_SESSION);
if($_POST['to']!="")
{

	$select_user=$dbObj->customqry("select * from tbl_users where userid='".$_POST['to']."'","");
	$res_user=@mysql_fetch_assoc($select_user);
	$name=$res_user['first_name']." ".$res_user['last_name'];
	$to_email=$res_user['email'];
	$smarty->assign("name",$name);
}

if($_POST['mid']){
	$selectm=$dbObj->customqry("select * from messages where MID='".$_POST['mid']."'","");
	$rowm=@mysql_fetch_assoc($selectm);
	$smarty->assign("subject",$rowm['subject']);
}

$smarty->assign("to",$_POST['to']);
extract($_POST);
if($_POST['subject']!="" && $_POST['message']!="" && $_POST['to']!="")
{

$subject=$_POST['subject'];
$message=$_POST['message'];
$to=$_POST['to'];

$fl = array("subject","message","cdate");
$vl = array($subject,$message,date("Y-m-d H:i:s"));
$resIns = $dbObj->cgi('messages',$fl,$vl,'');

$fl_inbox = array("FROM_ID","MID","TO_ID");
$vl_inbox = array($_SESSION['csUserId'],$resIns,$to);
$resIns_inbox = $dbObj->cgi('inbox',$fl_inbox,$vl_inbox,'');

$fl_outbox = array("FROM_ID","MID","TO_ID");
$vl_outbox = array($_SESSION['csUserId'],$resIns,$to);
$resIns_outbox = $dbObj->cgi('outbox',$fl_outbox,$vl_outbox,'');




//send email to receiver




										 $email_query = "select * from mast_emails where emailid=79";
										$email_rs = mysql_query($email_query);
										$email_row = mysql_fetch_object($email_rs);
										$email_message = file_get_contents(ABSPATH."/email/email.html");
										
										$email_subject=str_replace('[[FROM_NAME]]',ucfirst($_SESSION['csFullName']), $email_row->subject);
										$email_message = str_replace("[[EMAIL_CONTENT]]",nl2br(html_entity_decode($email_row->message)), $email_message);
										$email_message = str_replace("[[TO_NAME]]",ucfirst($name),$email_message);
										$email_message = str_replace("[[FROM_NAME]]",ucfirst($_SESSION['csFullName']),$email_message);
										
										
										$email_message = str_replace("[[EMAIL_HEADING]]", $email_subject,$email_message);
										//$email_message  = ($email_row->message);
										$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
										$email_message = str_replace("[[TODAYS_DATE]]", date("Y-m-d H:i:s"), $email_message);
										$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
// 										echo "=====>".$name;;
// 										echo "=====>".ucfirst($_SESSION['fullname']);
// 										echo "=====>".$to_email;
// 										echo "msg====>>".$email_message;
// 										exit;


										$from = SITE_EMAIL;
										$ssmail = @mail($to_email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");



//send email to receiver











}
if($_POST['str']!="")
{
if($_POST['str']=="compose")
	{
	
		$_SESSION['str']="compose";
	}
}

//friends
$select_user_friend2=$dbObj->customqry("select f.*,u.photo as photo1,u1.photo as photo2,u.first_name,u.last_name,u1.first_name as first_name1,u1.last_name as last_name1 from tbl_friends f left join tbl_users u on f.userid=u.userid  left join tbl_users u1 on f.friendid=u1.userid where (f.userid='".$_SESSION['csUserId']."' or f.friendid='".$_SESSION['csUserId']."') and f.verification='yes' group by f.userid,f.friendid ","");


while($res_select_friend2=@mysql_fetch_assoc($select_user_friend2))
{
	$friendd[]=$res_select_friend2;
}

$smarty->assign("friendd",$friendd);
//friends

//fanx

//**********************************Show that user is fan of which merchants**********************************//
$select_user_fan1=$dbObj->customqry("select f.*,u.photo as photo1,u.first_name,u.last_name,u.business_name from tbl_fan f left join tbl_users u on f.userid=u.userid  where f.fan_id='".$user."'   ","");
$i=0;
while($res_select_fan1=@mysql_fetch_assoc($select_user_fan1))
{
	
	$fan1[]=$res_select_fan1;
	$i++;
}
//echo "<pre>";print_r($fan1);echo "</pre>";
//$smarty->assign("fan1",$fan1);

//**********************************End Of Show that user is fan of which merchants*************************//



//fans



if($_SESSION['msg']!="")
{
$msg=$_SESSION['msg'];
$smarty->assign("msg",$msg);
unset($_SESSION['msg']);
}
$smarty->display( TEMPLATEDIR . '/modules/messages/send_message.tpl');
$dbObj->Close();
?>

<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}



if($_GET['cid'])
{
	$rs = $dbObj->cgs('tbl_contactus','*','cid',$_GET['cid'],'','','');
	$row = mysql_fetch_assoc($rs);
	$smarty->assign('email',$row);
// 	echo $row['message'];
// 	echo $row['emailId'];
//        echo $row['fullName'];exit;
	
	if($_POST['submit'])
	{
		extract($_POST);

		$dbObj->cgi("tbl_contactus_reply",array("subject","reply","posted_date","cid"),array($subject,$message,date("Y-m-d H:i:s"),$_GET['cid']),"");


// 		$to = $row['emailId'];
// 		$sub = $subject ;
// 		$body = file_get_contents(SITEROOT."/email/reply.html");
// 		$body1 .= str_replace('[[subject]]',$subject,$body);
// 		$body2 .= str_replace('[[content]]',$message,$body1);
// 		
// 		$from = SITE_EMAIL;
// 		$reply = @mail($to,$sub,$body2,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
// 		$_SESSION['msg'] =  "<span class='success'>Reply has been sent successfully.</span>";


		 $email_subject_adm = str_replace("[[SITETITLE]]", SITETITLE, $subject); 
		 $email_message  = $message;
		 $email_subject_adm = str_replace("[[SITETITLE]]", SITETITLE, $email_subject_adm);

               $email_message_adm = file_get_contents(ABSPATH."/email/email.html");
               $email_message_adm = str_replace("[[SITEROOT]]", SITEROOT, $email_message_adm);
               $email_message_adm = str_replace("[[EMAIL_HEADING]]",$email_subject_adm,$email_message_adm);
               $email_message_adm  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($message),$email_message_adm);
         
               $email_message_adm = str_replace("[[SITETITLE]]", SITETITLE, $email_message_adm);
               $email_message_adm = str_replace("[[SITEROOT]]",SITEROOT,$email_message_adm);
               $email_message_adm = str_replace("[[name]]",ucwords($row['fullName']),$email_message_adm);
               $email_message_adm = str_replace("[[email]]",$row["emailId"],$email_message_adm);
               $email_message_adm = str_replace("[[message]]",$row["message"],$email_message_adm);
               $email_message_adm = str_replace("[[TODAYS_DATE]]",date("d-m-Y"), $email_message_adm);
               $email_message_adm = str_replace("[[link]]",SITEROOT, $email_message_adm);
 
               $to =$row['emailId'];
               $from = SITE_EMAIL;
               @mail($to,$email_subject_adm,$email_message_adm,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
        //echo "<pre>To ==".$to."<br>From ==".$from."<br>Sub ==".$email_subject_adm."<br>Msg ==".$email_message_adm."<br></pre>"; exit;


// 		$mail = new PHPMailer();
// 		$mail->AddAddress($row['emailId']);//to mail ID
// 		$mail->Subject  = $email_subject;

// 		$body = file_get_contents(ABSPATH."/email/email.html");
// 		$body = str_replace('[[subject]]',$email_subject,$body);
// 		$body = str_replace("[[LOGO]]", SITEROOT, $body);
// 		$body = str_replace("[[EMAIL_HEADING]]", $email_subject, $body);
// 		$body = str_replace("[[EMAIL_CONTENT]]", nl2br($email_message), $body);

/*		$mail->Body  = html_entity_decode($body);*///Mail content
// 		$suc = $mail->Send();
/*
		$from = SITE_EMAIL;
		@mail($row['emailId'],$email_subject,html_entity_decode($email_message),"From: $from\nContent-Type: text/html; charset=iso-8859-1");*/

		$_SESSION['msg'] =  "<span class='success'>Reply has been sent successfully.</span>";


		header("Location:".SITEROOT."/admin/contentpages/view_reply.php?id=".$_GET['cid']);
		exit;
	}
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR . '/admin/contentpages/contact_reply.tpl');
?>
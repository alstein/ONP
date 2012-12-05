<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}


$date=date("Y-m-d H:i:s");






include_once '../../../ckeditor/ckeditor.php' ;
require_once '../../../ckfinder/ckfinder.php' ;
$initialValue = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
$ckeditor = new CKEditor( ) ;
$ckeditor->basePath	= '../../../ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, '../../../' ) ;
$config['toolbar'] = array(
array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));
$initialValue = stripslashes(html_entity_decode($frow['nl_pagecontent']));
$editorcontent= $ckeditor->editor("editor2", $initialValue, $config);
//print_r($editorcontent);
$smarty->assign("oFCKeditor", $editorcontent);


#------------Send Newsletter-------------------#
if(isset($_POST['submit']))
{
	extract($_POST);

	$cnd_users="email='".$_POST['email']."'";
	$res_users = $dbObj->gj("tbl_users","*",$cnd_users,"","","","","");
	$user=@mysql_fetch_assoc($res_users);
	
		
		
		if($user['first_name'] != "")
		{
		$firstname=$user['first_name'];		
		}
		else
		{
		$firstname="";
		}
		
		if($user['last_name'] != "")
		{
		$lastname=$user['last_name'];		
		}
		else
		{
		$lastname="";
		}




		#--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(40),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);
                $mail_content=stripslashes(html_entity_decode($mail['message']));


 
       	        $email_message = file_get_contents(SITEROOT."/email/all-users-email.html");
		$email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
		$email_message = str_replace("[[EMAIL_HEADING]]",$mail_content,$email_message);
		$email_message  = str_replace("[message]",html_entity_decode($_POST['editor2']),$email_message);
		$email_message  = str_replace("[firstname]",$firstname,$email_message);
		$email_message  = str_replace("[lastname]",$lastname,$email_message);
		$email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
		$from ="GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

//               	 echo $email_message;exit;
		 $sendmail = @mail($_POST['email'],$_POST['subject'],$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
       
		 $_SESSION['msg_news']="<span>Email sent successfully</span>";

	//header("location:".$_SERVER['HTTP_REFERER']);
	//exit;
}


if($_SESSION['msg_news'])
{	
	$smarty->assign("msg",$_SESSION['msg_news']);
	unset($_SESSION['msg_news']);
}

$smarty->assign("nlid",$nlid);

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/message-center/email-to-user.tpl');
$dbObj->close();	
?>
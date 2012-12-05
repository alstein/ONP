<?php

include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../includes/common.lib.php');
include_once('../../../includes/class.phpmailer.php');

	$dbObj = new DBTransact();
	$dbObj->Connect();

//echo ABSPATH;exit;

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}
	$sf=array("nl_id,nl_name,nl_title");

	$dbres = $dbObj->cgs("tbl_nl_content", $sf,"", "", "", "", $ptr);
	while($row_title = @mysql_fetch_assoc($dbres))
	{
		$tilte[] = $row_title;
	}
	
	$smarty->assign("title",$tilte);

	#-------------------------------#

	$res11 = $dbObj->cgs("mast_city","*","","ORDER BY","city_name","","");

	while($_req = @mysql_fetch_assoc($res11))
	{
		$_arr1[] = $_req;
	}
		//print_r($_arr1);exit;
	$smarty->assign("city_arr",$_arr1);

	if($_GET['news'])
	{
		$nlid=$_GET['news'];
	}

	if($nlid)
	{
		$cd =" nl_id = $nlid ";
		$res1 = $dbObj->gj("tbl_nl_content", "", $cd, "", "",  "ASC", $l, "");
		$frow =@mysql_fetch_assoc($res1);
		$page=$frow['nl_pagecontent'];

		$smarty->assign("pagecontent",$page);
		
	}
	
	include("../../../editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('nl_pagecontent') ;
	$oFCKeditor->BasePath = '../../../editor/';
	$oFCKeditor->Value = html_entity_decode(stripslashes($frow['nl_pagecontent']));
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '500';
	$smarty->register_object("oFCKeditor", $oFCKeditor);
			
				
	 
 	if(isset($_POST['submit']))
	{
// 		echo "<pre>";
// 		print_r($_POST);
// 		exit;
		extract($_POST);
		
		$res = $dbObj->cgs("tbl_nl_content", "","nl_id", $_POST['newsletter'], "", "", "");
		$row =@mysql_fetch_assoc($res);
		$title = $row['nl_title'];
		
		$subject = $subject;

		if($_POST['all'])
		{
			$cnd="city_id =".$_POST['city']." and status = '1'";
			$res_user = $dbObj->gj("tbl_newsletter_users","nuemail",$cnd,"","","","","");
			
			$i=0;
			while($row_user = @mysql_fetch_assoc($res_user))
			{	
				$user_arr[] = $row_user;
				
			}
			for($i=0;$i<count($user_arr);$i++)
			{
				$strsplit[$i] = $user_arr[$i]['nuemail'];
			}
// 			print_r($strsplit);exit;
		}
		else
		{
			$strsplit = split(",",$to);
		}

		$message = stripslashes($nl_pagecontent);
		for($m=0;$m<count($strsplit);$m++)
		{

    $email_message = file_get_contents(ABSPATH."/email/email_template.htm");

      $email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
      $email_message = str_replace("[[EMAIL_HEADING]]",$subject,$email_message);
      $email_message  = str_replace("[[CONTENT]]",nl2br($message),$email_message);
	//echo $email_message;exit;

       //mail($strsplit[$m],$subject,$email_message,"From: support@dealheist.com\nContent-Type: text/html; charset=iso-8859-1");
     $from = "GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";
    //  $email_subject = "Registration email from dailybonanza";
 $sendmail = @mail($strsplit[$m],$subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
	}
if($sendmail)
{
$_SESSION['msg_news']="<span>Newsletter sent successfully </span>";
}
else
{
$_SESSION['msg_news']="<span>Newsletter not sent </span>";
}		
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
		//$_SESSION['msg_news']="<span>Newsletter sent successfully !</span>";

	}

	//$smarty->assign("msg1",$msg1);

if($_SESSION['msg_news'])
{	
	$smarty->assign("msg",$_SESSION['msg_news']);
	unset($_SESSION['msg_news']);
}

$smarty->assign("nlid",$nlid);
$smarty->assign("sitename", SITETITLE);
$smarty->assign("submenu","newsletter");
$smarty->assign("siteroot", SITEROOT);
$smarty->assign("templatedir", TEMPLATEDIR);
$smarty->assign("inmenu", "newsletter");
$smarty->assign("siteimg", SITEIMG);
$smarty->assign("tinymce",TEMPLATEDIR."/tinymce.tpl");
// $smarty->assign("header1", TEMPLATEDIR . "/".AdminFolderName."/header1.tpl");
// $smarty->assign("header2", TEMPLATEDIR . "/".AdminFolderName."/header2.tpl");
// $smarty->assign("footer", TEMPLATEDIR . "/".AdminFolderName."/footer.tpl");
// $smarty->assign("menu", TEMPLATEDIR . "/".AdminFolderName."/menu.tpl"); 

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/newsletter/send_newsletter.tpl');
	
?>

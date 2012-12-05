<?php

		include_once("../../../include.php");
		include_once('../../../includes/common.lib.php');


	$dbObj = new DBTransact();
	$dbObj->Connect();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

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
		}
		else
		{
			$strsplit = split(",",$to);
		}

		$message = stripslashes($nl_pagecontent);
		for($m=0;$m<count($strsplit);$m++)
		{

							$body = file_get_contents(ABSPATH."/email/email.html");
							$body = str_replace('[[subject]]',$subject,$body);
							$body = str_replace("[[LOGO]]", SITEROOT, $body);
							$body = str_replace("[[EMAIL_HEADING]]", $subject, $body);
							$body = str_replace("[[EMAIL_CONTENT]]", nl2br($message), $body);
				$from = SITE_EMAIL;
        		mail($strsplit[$m],$subject,$body,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
		}
		
		$_SESSION['msg_news']="<span>Newsletter sent successfully !</span>";

	}

	$smarty->assign("msg1",$msg1);

if($_SESSION['msg_news']){

		$smarty->assign("msg",$_SESSION['msg_news']);
		unset($_SESSION['msg_news']);
	}

$smarty->assign("nlid",$nlid);
$smarty->assign("submenu","newsletter");
 
$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/newsletter/send_newsletter.tpl');
	
?>
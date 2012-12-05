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
	if(isset($_POST['edit']))
	{	
            $rs = $dbObj->cgs("mast_emails", "", "emailid", $_POST['email_id'], "", "", "");
            $row = @mysql_fetch_assoc($rs);
            $smarty->assign("emails", $row);
	}


  include_once '../../ckeditor/ckeditor.php' ;
        require_once '../../ckfinder/ckfinder.php' ;
        $ckeditor = new CKEditor('description') ; //
        $ckeditor->basePath	= '../../ckeditor/' ;
        CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
        $initialValue = html_entity_decode(stripslashes($row['message'])); //
        $editorcontentTitle= $ckeditor->editor("message", $initialValue, $config); //
        $smarty->assign("oFCKeditorDesc", $editorcontentTitle);


	if(isset($_POST['Submit']))
	{
	extract($_POST);
//      print_r($_POST);exit;
		if(isset($_POST['subject']))
		{
					$f = array("subject", "message");
					$v = array($subject, addslashes($message));
					$dbObj->cupdt("mast_emails", $f, $v, "emailid", $_POST['emailid'], "");//exit;
		}
		else
		{
					$f = array("subject", "message");
					$v = array($subject, addslashes($message));
					$dbObj->cgi("mast_emails", $f, $v, "");
		}
		$s=$msobj->showmessage(68);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".SITEROOT."/admin/globalsettings/system_emails.php");
		exit;
	}
if(isset($_POST['cancel']))
{
header("location:".SITEROOT."/admin/globalsettings/system_emails.php");
exit;
}

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
	$smarty->display(TEMPLATEDIR.'/admin/globalsettings/edit_email.tpl');
	$dbObj->Close();
?>




  

<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");
   
    //SMS CONTENT
        $rs1 = $dbObj->gj("sitesetting", "*", "id=37","","", "", "", "");
        $array=@mysql_fetch_array($rs1); 
        $smarty->assign("sms_content",$array);

   //EMAIL CONTENT
        $rs2 = $dbObj->gj("sitesetting", "*", "id=38","","", "", "", "");
        $email=@mysql_fetch_array($rs2);
////////OLD CKEditor code start///////
//         include_once '../../ckeditor/ckeditor.php' ;
//         require_once '../../ckfinder/ckfinder.php' ;
// 	include("../../editor/fckeditor.php");
// 	$oFCKeditor = new FCKeditor('description') ;
// 	$oFCKeditor->BasePath = '../../editor/';
// 	$oFCKeditor->Value = html_entity_decode($email['value']);
// 	$oFCKeditor->Width  = '100%';
// 	$oFCKeditor->Height = '400';
// 	$smarty->register_object("oFCKeditor", $oFCKeditor);
////////OLD CKEditor code start///////
        include_once '../../ckeditor/ckeditor.php' ;
        require_once '../../ckfinder/ckfinder.php' ;
        $ckeditor = new CKEditor('description') ; //
        $ckeditor->basePath	= '../../ckeditor/' ;
        CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
        $initialValue = html_entity_decode($email['value']);//
        $editorcontentTitle= $ckeditor->editor("description", $initialValue, $config); //
        $smarty->assign("oFCKeditorDesc", $editorcontentTitle);


 
    if($_POST['Update'])
   {
       extract($_POST);
      //SMS
      $sms_value=$_POST['sms_content'];
      $dbObj->cupdt("sitesetting",array("value"),array($sms_value),"id","37","");
        
      //EMAIL
      $description_decode = html_entity_decode($description);
      $dbObj->cupdt("sitesetting",array("value"),array($description_decode),"id","38",""); 
      $s=$msobj->showmessage(240);       
      $_SESSION['msg']="<span class='success'>SMS and Email content updated successfully </span>"; 
      header("location:".SITEROOT . "/admin/mastermanagement/sms_email_content.php");
      exit; 
   }
 
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
  $smarty->display(TEMPLATEDIR . '/admin/mastermanagement/sms_email_content.tpl');
   $dbObj->Close();
?>
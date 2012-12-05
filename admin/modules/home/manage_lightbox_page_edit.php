<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
header("location:".SITEROOT . "/admin/login/index.php");

    //------update  here manage lightbox page list edit -------------

    if($_POST["Update"])
    {   
                 $id=$_GET['edit_id'];
                 extract($_POST);
		$description_decode = html_entity_decode($description);
                 $field = array("section_title"=>$_POST['sectiontitle'],
                            "contents"=>$description_decode,
                            "status"=>$_POST['status']); 
             $dbObj->cupdtii("tbl_lightbox_page",$field,"id=".$id,"");
             $s=$msobj->showmessage(243);
	     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
             header("location:". SITEROOT . "/admin/modules/home/manage_lightbox_page_list.php");exit;

    }

    //----Get the updated id here and display record to manage_lightbox_page_edit.tpl file-----

   if($_GET['edit_id'])
      {
        $id=$_GET['edit_id'];
	$sql="select * from tbl_lightbox_page where id='$id'";
	$homerow=mysql_query($sql)or die(mysql_error());
	$results = array();

                 $r=mysql_fetch_array($homerow);
                 $id=$r['id'];
                 $section_title=$r['section_title'];
                 $text_message=$r['contents'];
                 $status=$r['status'];



// 	include_once '../../../ckeditor/ckeditor.php' ;
// 	require_once '../../../ckfinder/ckfinder.php' ;
// 	include("../../../editor/fckeditor.php");
// 	$oFCKeditor = new FCKeditor('description') ;
// 	$oFCKeditor->BasePath = '../../../editor/';
// 	$oFCKeditor->Value = html_entity_decode($r['contents']);
// 	$oFCKeditor->Width  = '100%';
// 	$oFCKeditor->Height = '400';
// 	$smarty->register_object("oFCKeditor", $oFCKeditor);


include_once '../../../ckeditor/ckeditor.php' ;
require_once '../../../ckfinder/ckfinder.php' ;
$ckeditor = new CKEditor('description') ; //
$ckeditor->basePath	= '../../../ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, '../../../' ) ;
$initialValue = html_entity_decode($r['contents']); //
$editorcontentTitle= $ckeditor->editor("description", $initialValue, $config); //
$smarty->assign("oFCKeditorDesc", $editorcontentTitle);


        $smarty->assign('id', $id);
        $smarty->assign('section_title', $section_title);
        // $smarty->assign('text_message', $text_message);
        $smarty->assign('status', $status);
      }
  
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->display(TEMPLATEDIR . '/admin/modules/home/manage_lightbox_page_edit.tpl');
	$dbObj->Close();
?>
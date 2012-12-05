<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();
set_time_limit(500000);
ini_set("memory_limit","1000M");

if(!isset($_SESSION['duAdmId']))
header("location:".SITEROOT . "/admin/login/index.php");

    //------update  image-------------
 if($_POST["Update"])
    {   
                 $id=$_GET['edit_id'];
                 extract($_POST);
		$description_decode = html_entity_decode($description);
                 if ($_FILES["image"]["error"]== 4)
                {
                 $field = array("section_title"=>$_POST['sectiontitle'],
                            "display_by"=>$_POST['display_by'],
                            "image_size_message"=>$_POST['image_size_message'],
                            "text_message"=>$description_decode,
                            "status"=>$_POST['status']); 
             $dbObj->cupdtii("tbl_home_page_ads",$field,"id=".$id,"");
             $s=$msobj->showmessage(239);
	     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
             header("location:". SITEROOT . "/admin/modules/home/homepage_empty_areas_list.php");exit;
 
                }else
                { 
                 $image = generalfileupload($_FILES['image'],"../../../uploads/home","");
                  $field = array("section_title"=>$_POST['sectiontitle'],
                            "display_by"=>$_POST['display_by'],
                            "image_file"=>$image,
                            "image_size_message"=>$_POST['image_size_message'],
                            "text_message"=>$_POST['textmessage'],
                            "status"=>$_POST['status']); 
             $dbObj->cupdtii("tbl_home_page_ads",$field,"id=".$id,"");
             $s=$msobj->showmessage(239);
	     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
             header("location:". SITEROOT . "/admin/modules/home/homepage_empty_areas_list.php");exit;
             }
    }
    //----Get the updated id here and display record to add_video.tpl file-----
   if($_GET['edit_id'])
      {
        $id=$_GET['edit_id'];
	$sql="select * from tbl_home_page_ads where id='$id'";
	$homerow=mysql_query($sql)or die(mysql_error());
	$results = array();
       
                 $r=mysql_fetch_array($homerow);
                 $id=$r['id'];
                $section_title=$r['section_title'];
                $display_by=$r['display_by'];
                $image_file=$r['image_file'];
                $text_message=$r['text_message'];
                $image_size_message=$r['image_size_message'];
                $status=$r['status'];
                
        include_once '../../../ckeditor/ckeditor.php' ;
        require_once '../../../ckfinder/ckfinder.php' ;
	include("../../../editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('description') ;
	$oFCKeditor->BasePath = '../../../editor/';
	$oFCKeditor->Value = html_entity_decode($r['text_message']);
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '400';
	$smarty->register_object("oFCKeditor", $oFCKeditor);

        
  
        $smarty->assign('id', $id);
         $smarty->assign('section_title', $section_title);
          $smarty->assign('display_by', $display_by);
           $smarty->assign('image_file', $image_file);
           // $smarty->assign('text_message', $text_message);
             $smarty->assign('image_size_message', $image_size_message);
             $smarty->assign('status', $status);
      }
  
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->display(TEMPLATEDIR . '/admin/modules/home/homepage_empty_areas_edit.tpl');
	$dbObj->Close();
?>
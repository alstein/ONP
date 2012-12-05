<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');


if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

$msobj= new message();

if(isset($_POST['title']))
{
 	//print_r($_POST);exit;

	extract($_POST);
	$description = addslashes($editor2);
        $tbl= "tbl_pages";
        $f = array("page_cat","title", "description", "status");
        $v = array($page_cat,$title, $_POST['description'], $status);

	if($_GET['pageid'] != "")
	{
	    $id=$dbObj->cupdt($tbl,$f ,$v , "pageid", $_GET['pageid'], ""); //exit;
	  //  $s=$msobj->showmessage(159);
	    $_SESSION['msg']="<span class='success'>contentpage updated Successfully.</span>";

        }
	else
        {
	    $id=$dbObj->cgi($tbl, $f, $v, "");

	    $s=$msobj->showmessage(158);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        }

	header("Location: page_list.php");
	exit;
}

#------------Get Page Category----------------#
$rs_pg = $dbObj->cgs("tbl_page_category", "id,title", "","", "title", "", "");
if($rs_pg != "n")
{
  while($rs_page=mysql_fetch_assoc($rs_pg))
      $page_cat[] = $rs_page;
  $smarty->assign("page_cat", $page_cat);
}
#------------Get Page Category----------------#


#--------------Get Page Content---------------#
if(isset($_GET['pageid'])!="")
{
$rs = $dbObj->cgs("tbl_pages", "*", "pageid", $_GET['pageid'], "", "", "");
$page=mysql_fetch_assoc($rs);
//print_r($page);exit;

$smarty->assign("page", $page);
}
#--------------Get Page Content------------------#
// include_once '../../ckeditor/ckeditor.php' ;
// require_once '../../ckfinder/ckfinder.php' ;
// $initialValue = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
// $ckeditor = new CKEditor( ) ;
// $ckeditor->basePath	= '../../ckeditor/' ;
// CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
// $config['toolbar'] = array(
// array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
// array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));
// $initialValue = stripslashes(html_entity_decode($page['description']));
// $editorcontent= $ckeditor->editor("editor2", $initialValue, $config);
// $smarty->assign("oFCKeditor", $editorcontent);


/////OLD FCKEditor code start here/////////////////////////////////
// 	include("../../editor/fckeditor.php");
// 	$oFCKeditor = new FCKeditor('description') ;
// 	$oFCKeditor->BasePath = '../../editor/';
// 	$oFCKeditor->Value = html_entity_decode($page['description']);
// 	$oFCKeditor->Width  = '100%';
// 	$oFCKeditor->Height = '500';
// 	$smarty->register_object("oFCKeditor", $oFCKeditor);
/////OLD FCKEditor code end here/////////////////////////////////
        include_once '../../ckeditor/ckeditor.php' ;
        require_once '../../ckfinder/ckfinder.php' ;
        $ckeditor = new CKEditor('description') ; //
        $ckeditor->basePath	= '../../ckeditor/' ;
        CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
        $initialValue = html_entity_decode($page['description']); //
        $editorcontentTitle= $ckeditor->editor("description", $initialValue, $config); //
        $smarty->assign("oFCKeditorDesc", $editorcontentTitle);








#------------Set SESSION msg-------------#
if(isset($_SESSION['msg']))
{ 
    $smarty->assign("msg", $_SESSION['msg']); 
    unset($_SESSION['msg']);
}
#------------End SESSION msg-------------#

$smarty->assign("inmenu","content");

$smarty->display(TEMPLATEDIR . '/admin/contentpages/edit_page.tpl');

$dbObj->Close();
?>
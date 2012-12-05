<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
$msobj= new message();


if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

if($_SESSION['dec_msg']){
$smarty->assign("dec_msg", $_SESSION['dec_msg']);
$_SESSION['dec_msg']='';
unset($_SESSION['dec_msg']);
}

#------------Check For access----------#
if(!(in_array("22", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $_SESSION['msg']="<span class='error'>Access denied</span>";
      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

if(isset($_GET['status']))
{
	if($_GET['status']=="Active")
		$id=$dbObj->cupdt("tbl_undermaintenance", "undermaintenance_status", "Inactive", "undermaintenance_id", $_GET['undermaintenance_id'], "");
	else
		$id=$dbObj->cupdt("tbl_undermaintenance", "undermaintenance_status", "Active", "undermaintenance_id", $_GET['undermaintenance_id'], "");
	$_SESSION['msg']="<span class='success'>Status changed successfully.</span>";
	header("Location: page_list.php");
	exit;
}

// print_r($_POST);exit;
//To Save Data
if(isset($_POST['undermaintenance_name']))
{
//print_r($_POST);exit;
		extract($_POST);
		$description = html_entity_decode(addslashes($description));
if($description)
{
		$id=$dbObj->cupdt("tbl_undermaintenance", array("undermaintenance_name", "undermaintenance_description", "undermaintenance_status"), array($undermaintenance_name, $description, $status), "undermaintenance_id", '1', "");//exit;
		$s=$msobj->showmessage(208);
                $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}else{
$_SESSION['dec_msg']="enter the description";
}
	header("Location:undermaintenance.php");
	exit;
}


$rs = $dbObj->cgs("tbl_undermaintenance", "*", "undermaintenance_id", '1', "", "", "");
$page=mysql_fetch_assoc($rs);
$smarty->assign("page", $page);

include_once '../../ckeditor/ckeditor.php' ;
// require_once '../../ckfinder/ckfinder.php' ;
// $initialValue = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
// $ckeditor = new CKEditor( ) ;
// $ckeditor->basePath	= '../../ckeditor/' ;
// CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
// $config['toolbar'] = array(
// array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
// array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));
// $initialValue = stripslashes(html_entity_decode($page['undermaintenance_description']));
// $editorcontent= $ckeditor->editor("description", $initialValue, $config);
// $smarty->assign("oFCKeditor", $editorcontent);

/////////////////OLD FCKEditor start here/////////////////////////
        require_once '../../ckfinder/ckfinder.php' ;
	include("../../editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('description') ;
	$oFCKeditor->BasePath = '../../editor/';
	$oFCKeditor->Value = html_entity_decode($page['undermaintenance_description']);
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '500';
	$smarty->register_object("oFCKeditor", $oFCKeditor);
/////////////////OLD FCKEditor end here/////////////////////////
        include_once '../../ckeditor/ckeditor.php' ;
        require_once '../../ckfinder/ckfinder.php' ;
        $ckeditor = new CKEditor('description') ; //
        $ckeditor->basePath	= '../../ckeditor/' ;
        CKFinder::SetupCKEditor($ckeditor, '../../' );
        $initialValue = html_entity_decode($page['undermaintenance_description']);//
        $editorcontentTitle= $ckeditor->editor("description", $initialValue, $config); //
        $smarty->assign("oFCKeditorDesc", $editorcontentTitle);


if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->assign("inmenu","content");

$smarty->display(TEMPLATEDIR . '/admin/mastermanagement/undermaintenance.tpl');

$dbObj->Close();
?>
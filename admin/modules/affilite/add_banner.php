<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/common.lib.php');  //used for various file uploading...

if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");


$rs = $dbObj->cgs('tbl_banner','*','id',$_GET['id'],'','','');
if($rs!='n')
{
	$row = mysql_fetch_assoc($rs);
	$banner = $row;
}
$smarty->assign("banner",$banner);
#-------Add Video-----------------------#
if(isset($_POST['submit']))
{

$fl = array();
$vl = array();
		extract($_POST);
	if($_GET['id'])
		{	
			array_push($fl,"image_affilite");
			array_push($fl,"description");
			$result = $dbObj->cgs('tbl_banner','*','id',$_GET['id'],'','','');
			$bg = mysql_fetch_assoc($result);
			if($_FILES['image']['name'])
			{
				@unlink("../../../uploads/banners/".$bg['image_affilite']);
				$photo = generalfileupload($_FILES['image'],'../../../uploads/banners','1');
				array_push($vl,"$photo");
				array_push($vl,"$description");
				//$vl="$photo,$description";
			}
			if(empty($vl))
			{
    			 array_push($vl,$bg['image_affilite']);
			 array_push($vl,"$description");	
			}
			$dbObj->cupdt('tbl_banner',$fl,$vl,'id',$_GET['id'],'');
			$_SESSION['msg'] = "<span>Banner has been updated successfully.</span>";
			header("Location:".SITEROOT."/admin/modules/affilite/manage_affilite_banner.php");
		   	exit;
		}	

		else /**/
		{
			
			if($_FILES['image']['name'])
			{
			 $photos= generalfileupload($_FILES['image'],'../../../uploads/banners','1');
			 $fl=array("image_affilite,description");
			 $vl=array($photos,$description);
           
			}
         else
          {
			   $fl="description";
			   $vl=$description;
         }
			$dbObj->cgi('tbl_banner',$fl,$vl,'');
			$_SESSION['msg'] = "<span>Banner has been added successfully.</span>";
			header("Location:".SITEROOT."/admin/modules/affilite/manage_affilite_banner.php");
		   	exit;
			
		}
// 		if($_POST['embeded_code1'])
// 		{
// 
// 			extract($_POST);
// 			$f = array("embeded");
// 			$v = array($embeded_code1);			
// 			$id = $dbObj->cgi("tbl_banner", $f, $v, "");
// 			$_SESSION['msg'] = "<span class= error>Embeded added successfully</span>";
// 			header("Location:".SITEROOT."/admin/sitemodules/affilite/manage_affilite_banner.php");
// 			exit;
// 		}
				
}

#---------------------------------------#
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/affilite/add_banner.tpl');

$dbObj->Close();
?>
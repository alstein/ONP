<?php


include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
// include_once('../../../includes/class.message.php');
//include('../../../includes/paging.php');
//include_once('../../../includes/classes/class.profile.php');
include_once('../../../includes/common.lib.php');
//include('../../../includes/paging.php');

// $msobj= new message();
// $smarty->assign("msobj",$msobj);
if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/home.php");
	 exit();
}

extract($_POST);
extract($_GET);


// $r=$_GET['id1'];
// echo $r;exit;
if(isset($_POST['submit']))
{
	for($z=1;$z<=5;$z++)
	{
		if($_FILES["image$z"]["name"]!="")
		{
			// for original photo details
		
			$original_1 = newgeneralfileupload($_FILES["image$z"], "../../../uploads/photo/", true);
			 //original image move to main folder
			$original['name'] = $original_1;
			$original['tmp_name'] = "../../../uploads/photo/".$original_1;
			
			// for resize details

			$path = "../../../uploads/photo/thumbnail/";
			$width_array  = array(100);
			$height = 82;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop 
			
			$sf_arr=array("user_id","album_id","thumbnail","added_date");
			$sv_arr=array($_SESSION['duAdmId'],$_GET["id"],$original_1,date("Y-m-d H:i:s"));
			$insert_details=$dbObj->cgi("tbl_albumphotos",$sf_arr,$sv_arr,"");
			
		}
		
	}
	header("location:".SITEROOT."/admin/sitemodules/albums/photo-details.php?id=".$_GET['id']);
	exit();
}
$get_albumdetails=$dbObj->cgs("tbl_album","*","album_id",$_GET["id"],"","","");
$fetch_details=@mysql_fetch_assoc($get_albumdetails);
$smarty->assign("album_details",$fetch_details);

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("selecttab",'photo');
$smarty->assign("leftadminmenu","albums");
$smarty->assign("photos","yes");
$smarty->display(TEMPLATEDIR .'/admin/sitemodules/albums/add-albumphotos.tpl');
$dbObj->Close();

?>
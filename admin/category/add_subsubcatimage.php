<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/common.lib.php");
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
include_once("../../includes/function.php");
$msobj= new message();
set_time_limit(500000);
ini_set("memory_limit","1000M");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


if($_POST["Save"])
{
	$imagetitle=$_POST['imagetitle'];
	$deal_cat_id=$_POST['deal_cat_id'];
	$image= $_POST['image'];
	$added_date=$_POST['added_date'];
	$status= $_POST['status'];

	$sql="SELECT MAX(id) 'maxsort' FROM tbl_deal_category_images ";
	$sortmax= mysql_query($sql)or die(mysql_error());
	$maxsort=@mysql_fetch_assoc($sortmax);
	$max= $maxsort['maxsort']+1;

	$image = generalfileupload($_FILES['image'],"../../uploads/subcat_image","");
	$sqlvideo="INSERT INTO tbl_deal_category_images(deal_cat_id, img_title,img_name,status) VALUES('$deal_cat_id','$imagetitle','$image','$status')";
	$row=mysql_query($sqlvideo)or die(mysql_error());
	//$s=$msobj->showmessage(231);
	$_SESSION['msg']="<span class='success'>Image added successfully</span>"; 
	header("location:". SITEROOT . "/admin/category/subsubcatimage.php?cat_id=".$_GET['cat_id']);exit;
	//echo "<script>window.history.go(-2);</script>";
}
//------update  followus-------------
if($_POST["Update"])
{
	$id=$_GET['edit_id'];
	if ($_FILES["image"]["error"]== 4)
	{
		$field = array("img_title"=>$_POST['imagetitle'],"status"=>$_POST['status']); 
		$dbObj->cupdtii("tbl_deal_category_images",$field,"id=".$id,"");
		//$s=$msobj->showmessage(228);
		$_SESSION['msg']="<span class='success'>Image updated successfully</span>";
		header("location:". SITEROOT . "/admin/category/subsubcatimage.php?cat_id=".$_GET['cat_id']);exit;
		//echo "<script>window.history.go(-2);</script>";
	}else
	{
		$image = generalfileupload($_FILES['image'],"../../uploads/subcat_image","");
		$field = array("img_title"=>$_POST['imagetitle'],"img_name"=>$image,"status"=>$_POST['status']); 
		$dbObj->cupdtii("tbl_deal_category_images",$field,"id=".$id,"");
		//$s=$msobj->showmessage(228);
		$_SESSION['msg']="<span class='success'>Image updated successfully</span>";
		header("location:". SITEROOT . "/admin/category/subsubcatimage.php?cat_id=".$_GET['cat_id']);exit;
		//echo "<script>window.history.go(-2);</script>";
	}
}
//----Get the updated id here and display record to add_followus.tpl file-----
if($_GET['edit_id'])
{
	$id=$_GET['edit_id'];
	$sql="select * from tbl_deal_category_images where id='$id'";
	$productrow=mysql_query($sql)or die(mysql_error());
	$results = array();
	$i=0;
	while ($r=mysql_fetch_array($productrow))
	{
		$id=$r['id'];
		$image_title=$r['img_title'];
		$image_logo=$r['img_name'];
		$added_date=$r['added_date'];
		$status=$r['status'];
	}
}

////////////////////////////////////////////////////
//START Get category level Hirarchy and it's id
if($_GET['cat_id'] > 0)
{
	$smarty->assign("categoryHirarchy",getCategoryLevelOrder(recursiveCategory($_GET['cat_id']))); //functions are written in /includes/function.php file
}
//END Get category level Hirarchy and it's id
////////////////////////////////////////////////////

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign('id', $id);
$smarty->assign('deal_cat_id', $_GET['cat_id']);
$smarty->assign('image_title', $image_title);
$smarty->assign('image_logo', $image_logo);
$smarty->assign('status', $status);
$smarty->assign('added_date', $added_date);

$smarty->display(TEMPLATEDIR . '/admin/category/add_subsubcatimage.tpl');
$dbObj->Close();
?>

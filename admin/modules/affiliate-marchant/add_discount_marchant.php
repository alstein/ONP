<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');

$msobj= new message();
if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}
if(isset($_POST["submit"]))
{
      extract($_POST);
      if($_POST["submit"] == "Update")
      {
		$id=$_GET['mid'];
		if ($_FILES["image"]["error"]== 4)
		{
			$s=$msobj->showmessage(257);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:". SITEROOT . "/admin/modules/affiliate-marchant/marchant_discount_list.php");exit;
		}else
		{
			$image = generalfileupload($_FILES['image'],"../../../uploads/discount_code_merchants_image","");
			$field = array("image"=>$image);
			$dbObj->cupdtii("tbl_disc_codes_affiliate_merchants",$field,"id=".$id,"");
			$s=$msobj->showmessage(257);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:". SITEROOT . "/admin/modules/affiliate-marchant/marchant_discount_list.php");exit;
		}
	}
}
#----------------Get category info--------------#
if(isset($_GET['mid'])!="")
{
	$rs = $dbObj->cgs("tbl_disc_codes_affiliate_merchants", "*", "id", $_GET['mid'], "", "", "");
	$row=@mysql_fetch_assoc($rs);
	$smarty->assign("result", $row);
}
if($_GET['mid'])
{
	$id=$_GET['mid'];
	$sql="select * from tbl_disc_codes_affiliate_merchants where id='$id'";
	$productrow=mysql_query($sql)or die(mysql_error());
	$results = array();
	$i=0;
	while ($r=mysql_fetch_array($productrow))
	{
		$id=$r['id'];
		$marchant_id=$r['marchant_id'];
		$marchant_name=$r['marchant_name'];
		$image_logo=$r['image'];
// 		$status=$r['status'];
	}
}
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign('id', $id);
$smarty->assign('marchant_id',$marchant_id);
$smarty->assign('marchant_name', $marchant_name);
$smarty->assign('image_logo', $image_logo);

#----------------Get category info--------------#
// if($_SESSION['msg'])
// {
//    $smarty->assign("msg",$_SESSION['msg']);
//    $_SESSION['msg']=NULL;
// }

$smarty->display(TEMPLATEDIR . '/admin/modules/affiliate-marchant/add_discount_marchant.tpl');
$dbObj->Close();
?>
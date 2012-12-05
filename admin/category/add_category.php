<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();
if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}
if(isset($_POST["submit"]))
{
//print_r($_POST);exit;
      extract($_POST);
      // Update Category
      if($_POST["submit"] == "Update")
      {
	    //$id = $dbObj->cupdt("mast_deal_category", array("category ","category_type","coupon_manualy"),array($category,$category_type,$issmanu), "id",$_GET['cid'], "");
	    $id = $dbObj->cupdt("mast_deal_category", array("category","coupon_manualy"),array($category,$issmanu), "id",$_GET['cid'], "");
	    $s=$msobj->showmessage(19);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
      if($_POST["submit"] == "Add")
      {
	    //$set_field = array('userid','category','category_type','parent_id','date','active','coupon_manualy');
	    //$set_values = array($_SESSION['duAdmId'],$category,$category_type,0,date("Y-m-d"),1,$issmanu);
	    $set_field = array('userid','category','parent_id','date','active','coupon_manualy');
	    $set_values = array($_SESSION['duAdmId'],$category,0,date("Y-m-d"),1,$issmanu);
	    $id = $dbObj->cgi("mast_deal_category",$set_field,$set_values, "");
	    $s=$msobj->showmessage(18);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".SITEROOT."/admin/category/category_list.php");
	exit;
}
#----------------Get category info--------------#
if(isset($_GET['cid'])!="")
{
    $rs = $dbObj->cgs("mast_deal_category", "*", "id", $_GET['cid'], "", "", "");
    $row=@mysql_fetch_assoc($rs);
    $smarty->assign("result", $row);
}
#----------------Get category info--------------#
if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/category/add_category.tpl');
$dbObj->Close();
?>
<?php
include_once('../../../includes/SiteSetting.php');
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
	    $id = $dbObj->cupdt("tbl_deal_affiliate_marchant", array("marchant_id","marchant_name"),array($marchant_id,$marchant_name), "id",$_GET['mid'], "");
	    $s=$msobj->showmessage(257);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
      if($_POST["submit"] == "Add")
      {
	    $set_field = array('marchant_id','marchant_name');
	    $set_values = array($marchant_id,$marchant_name);
	    $id = $dbObj->cgi("tbl_deal_affiliate_marchant",$set_field,$set_values, "");
	    $s=$msobj->showmessage(258);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".SITEROOT."/admin/modules/affiliate-marchant/marchant_list.php");
	exit;
}
#----------------Get category info--------------#
if(isset($_GET['mid'])!="")
{
    $rs = $dbObj->cgs("tbl_deal_affiliate_marchant", "*", "id", $_GET['mid'], "", "", "");
    $row=@mysql_fetch_assoc($rs);
    $smarty->assign("result", $row);
}
#----------------Get category info--------------#
if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/modules/affiliate-marchant/add_marchant.tpl');
$dbObj->Close();
?>
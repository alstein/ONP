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
         
//          $fields = "dealtype";
//          $values = $dealtype;
         $fields = array("dealtype","price_option");
         $values = array($dealtype,$normal);
         $wf = "typeid";
         $wv = $_GET['dt_id'];
         $prn = "";
         $result = $dbObj ->cupdt('tbl_dealtype' , $fields , $values , $wf , $wv , $prn); 

	      $s=$msobj->showmessage(192);
	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
      if($_POST["submit"] == "Add")
      {
         $fields = array("dealtype","price_option");
         $values = array($dealtype,$normal);
         $prn = "";
         $result = $dbObj ->cgi('tbl_dealtype' , $fields , $values , $prn); 
   
	      $s=$msobj->showmessage(191);
	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
	header("location:".SITEROOT."/admin/deal/deal_type_list.php");
	exit;
}
#----------------Get category info--------------#
if(isset($_GET['dt_id'])!="")
{
    $rs = $dbObj->cgs("tbl_dealtype", "*", "typeid", $_GET['dt_id'], "", "", "");
    $row=@mysql_fetch_assoc($rs);
    $smarty->assign("result", $row);
}
#----------------Get category info--------------#
if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/deal/add_deal_type.tpl');
$dbObj->Close();
?>
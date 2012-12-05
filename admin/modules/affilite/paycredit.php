<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../include.php');

if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}
extract($_POST);
extract($_GET);
// $msg="";
$pre=$dbObj->cgs("tbl_affiliate","credit","id",$id,"","","");
 $pre_credit=mysql_fetch_assoc($pre);
if($credit)
{ 
 


  $balancecredit=$pre_credit['credit']-$credit;
  $q="update tbl_affiliate set credit=".$balancecredit." where id='".$id."'";
	 $dbObj->customqry($q,"");
  ?>
<script language=javascript>

 window.parent.location.reload();

 
</script>

 
<?
 exit;
 
}
$smarty->assign("dtcredits",$pre_credit);
// $smarty->assign("msg",$msg);
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/affilite/paycredit.tpl');
$dbObj->Close();
?>
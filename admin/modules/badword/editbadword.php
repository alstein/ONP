<?php
ob_start();
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_GET['id']))
{
  $id=$_GET['id'];
  $rs1 = $dbObj->cgs("tbl_bad_words", "*", "id",$id, "", "", "");
  if($rs1!='n')
  {
  	$row1 = @mysql_fetch_assoc($rs1);
	{
	   $recrds = $row1;
	}
        $smarty->assign("user",$recrds);
  }
}
//echo "<pre>";print_r($recrds);

#-------------------------End of select Query---------------------------------#

#------------------------------Update Query for Advertisement--------------------#
if($_POST['Submit'])
{
	extract($_POST);	
	  $f = array("bad_word","rep_word");
           	$v = array($bad_word,$rep_word,);
		$id=$_GET['id'];
		

	$rs = $dbObj->cupdt('tbl_bad_words',$f,$v,"id",$id,"");
		//$s=$msobj->showmessage(483);
	     // $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	$_SESSION['msg']="<span>Word Updated Successfully.</span>";
 	header("Location:badword-list.php");
	exit;
}
#--------------------------------End of Update query---------------------------#


/*----------Site message-----------*/
if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
/*--------End of site message---------*/


$smarty->assign("id", $_GET['id']);
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/badword/editbadword.tpl');
$dbObj->Close();
?>
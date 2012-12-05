<?php
ob_start();
session_start();
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

$id=$_GET['id'];
#------------------------Select Query for add-------------------------------#
$rs1 = $dbObj->cgs("tbl_bad_words", "*", "id",$id, "", "", "");
        if($rs1!='n')
	{
		while($row1 = @mysql_fetch_assoc($rs1))
		{
			$array[] = $row1;
		}

		$smarty->assign("user",$array);
	}
#-------------------------End of select Query---------------------------------#



#-------------------------------Insert Query for advertisement-------------------#
if($_POST['Submit'])
{
   extract($_POST);
	
	        $f = array("bad_word","rep_word");
           	$v = array($bad_word,$rep_word,);
		$res = $dbObj->cgi('tbl_bad_words', $f, $v, "");
	        $_SESSION['msg'] = "word added Successfully";
		header("Location:badword-list.php");
		exit;
}
#----------------------------------End of Insert Query---------------------------------#

/*----------Site message-----------*/
if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
/*--------End of site message---------*/


$smarty->assign("id", $_GET['id']);
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/badword/addbadword.tpl');
$dbObj->Close();
?>
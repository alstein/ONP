<?php
	include_once('../../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

extract($_POST);
extract($_GET);

/*fetch blog content*/
if(isset($_POST['submit']))
{   
 	extract($_POST);
		if($id)
		{
			$set_field = array('line_one' , 'line_two');
			
			$set_values = array($lineone , $linetwo);
			
			$dbres = $dbObj->cupdt('tbl_contact_information', $set_field , $set_values, 'id' ,  $id , "0");
			$_SESSION['msg'] = "<span class='success'>Contact Information Updated Successfully</span>";
			header("location:".SITEROOT."/admin/contentpages/contact_information.php");
		}
		else
		{
			$fields = array('line_one' , 'line_two');
			
			$values = array($lineone , $linetwo);
			
			$dbres = $dbObj->cgi('tbl_contact_information', $fields , $values , "");

			$_SESSION['msg'] = "<span class='success'>Contact Information Added Successfully</span>";
			header("location:".SITEROOT."/admin/contentpages/contact_information.php");
		}
}


if($id != '')
{
	$cd = "id = '".$id."'";
	
	$dbres = $dbObj->gj('tbl_contact_information', $sf , $cd, $ob, $gb,$ad, $l, "");
	
	$row_result = @mysql_fetch_assoc($dbres);
	
	$smarty->assign("row_result", $row_result);
}


$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/contentpages/edit_contact_information.tpl');

$dbObj->Close();
?>
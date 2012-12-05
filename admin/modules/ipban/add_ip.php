<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();
if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}
extract($_POST);
extract($_GET);

/*fetch blog content*/
if(isset($_POST['submit']))
{   
//print_r($_POST);exit;
	extract($_POST);
		if($id)
		{
			$set_field = array('domain');
			
			$set_values = array($domain);
			
			$dbres = $dbObj->cupdt('tbl_ipban', $set_field , $set_values, 'ip_id' ,  $id , "0");
			$s=$msobj->showmessage(456);
	      		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
// 			$_SESSION['msg']="<span class='success'>Link updated successfully.</span>";
			
			header("location:".SITEROOT."/admin/modules/ipban/ipban.php?mode=up");
		}
		else
		{	$fields = array('domain');

			$values = array($domain);
			
			$dbres = $dbObj->cgi('tbl_ipban', $fields , $values,"");
			$s=$msobj->showmessage(455);
	      		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
// 			$_SESSION['msg']="<span class='success'>Link added successfully.</span>";
			
			header("location:".SITEROOT."/admin/modules/ipban/ipban.php?mode=add");
         exit;
       		}
}

if($id != '')
{
	$cd = "ip_id = '".$id."'";
	
	$dbres = $dbObj->gj('tbl_ipban', "*" , $cd, "", "","", "", "");
	
	$row_result = @mysql_fetch_assoc($dbres);
	
	$smarty->assign("row_result", $row_result);
}

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/ipban/add_ip.tpl');

$dbObj->Close();
?>
<?php
		include_once("../../../include.php");

$dbObj = new DBTransact();
$dbObj->Connect();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");


if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

	if($_GET['action']=="del"){

		$rs=$dbObj->gdel("tbl_nl_content","nl_id",$_GET['nl_id'], $ptr );
		$_SESSION['msg']="<span class='success'>".getErrorMessage(63)."</span>";
		header("location:".SITEROOT."/admin/mastermanagement/newsletter/newsletter.php");
 	}

	if(isset($_POST['Submit2']))
	{
			$f_array =  array("nl_name"					=> $_POST['$nl_name'],
												"nl_title"				=> $_POST['$nl_title'],
												"nl_pagecontent"	=> html_entity_decode($_POST['description']));

			$insertedId = $dbObj->cgii("tbl_nl_content",$f_array,"");

		header("location:".SITEROOT."/admin/mastermanagement/newsletter/nl_success.php");
	}


	include("../../../editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('description') ;
	$oFCKeditor->BasePath = '../../../editor/';
	$oFCKeditor->Value = $page;
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '500';
	$smarty->register_object("oFCKeditor", $oFCKeditor);



	$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/newsletter/create_newsletter.tpl');
	$smarty->assign("jsfile","../js/addnewpage.js");

?>
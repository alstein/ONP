<?php
	include_once("../../../include.php");

	$dbObj = new DBTransact();
	$dbObj->Connect();
if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}


	$nl_id = ($_REQUEST['nl_id']?$_REQUEST['nl_id']:0);
	$smarty->assign("nl_id",$nl_id);

	if($_GET['action']=="del"){
		$rs=$dbObj->gdel("tbl_nl_content","nl_id",$_GET['nl_id'], $ptr );
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(63)."</span>";
		header("location:".SITEROOT."/admin/mastermanagement/newsletter/newsletter.php");	
		
  	}

	if(strlen(trim($_POST['Submit2'])) > 0){ 
		if($nl_id!=''){
			$set_field = array('nl_name','nl_title','nl_pagecontent','city_id','startdate');
			$set_values =
			array($_POST['pagename'],$_POST['pagetitle'],html_entity_decode($_POST['description']),$_POST['cities'],$_POST['startdate']);

			$wf="nl_id";
			$wv=$_POST['nl_id'];
			$dbObj->cupdt("tbl_nl_content", $set_field, $set_values,$wf,$wv,"");
			$_SESSION["msg"] = "<span class='success'>".getErrorMessage(86)."</span>";
			header("location:".SITEROOT."/admin/mastermanagement/newsletter/newsletter.php");
		}

		else{
			$f_array =  array("nl_name"					=> $_POST['pagename'],
												"nl_title" 				=> $_POST['pagetitle'],
												"nl_pagecontent"	=> html_entity_decode($_POST['description']),
												"city_id"					=> $_POST['cities'],
												"startdate"				=> $_POST['startdate']);

			$insertedId = $dbObj->cgii("tbl_nl_content",$f_array,"");
			$_SESSION["msg"] = "<span class='success'>".getErrorMessage(87)."</span>";

			header("location:".SITEROOT."/admin/mastermanagement/newsletter/nl_success.php");
		}
	}

	if($nl_id!=''){
		$cd="nl_id = ".$nl_id;
		$dbres = $dbObj->gj('tbl_nl_content', "*" , $cd, "", "","", "", "");
		$row = @mysql_fetch_assoc($dbres);
		$smarty->assign("row",$row);
		$_contents = html_entity_decode($row['nl_pagecontent']);
	}

	$res11 = $dbObj->cgs("mast_city","*","","ORDER BY","city_name","","");

	while($_req = @mysql_fetch_assoc($res11))
	{
		$_arr1[] = $_req;
	}
	$smarty->assign("categories1",$_arr1);


	include("../../../editor/fckeditor.php");

	$oFCKeditor = new FCKeditor('description') ;
	$oFCKeditor->BasePath = '../../../editor/';
	$oFCKeditor->Value = $_contents;
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '500';
	$smarty->register_object("oFCKeditor", $oFCKeditor);

#-----------------------------------#
	if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

	$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/newsletter/edit_newsletter.tpl');

?>
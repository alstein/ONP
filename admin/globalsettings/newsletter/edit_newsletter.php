<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}



$cityid = $_SESSION["demorec"];
//echo "</pre>"; print_r($cityid);exit;
if($cityid)
{
$smarty->assign("demoid",$cityid);
}
	$nl_id = ($_REQUEST['nl_id']?$_REQUEST['nl_id']:0);
	$smarty->assign("nl_id",$nl_id);  

	if($_GET['action']=="del"){
		$rs=$dbObj->gdel("tbl_nl_content","nl_id",$_GET['nl_id'], $ptr );
		$_SESSION["msg"] = "<span class='success'>Newsletter Deleted Successfully.</span>";
		header("location:".SITEROOT."/".AdminFolderName."/mastermanagement/newsletter/newsletter.php");	
		
  	}

	if(strlen(trim($_POST['Submit2'])) > 0){ 

		if($nl_id!=''){
			$set_field = array('nl_name','nl_title','nl_pagecontent','city_id','startdate');
			$set_values =
			array($_POST['pagename'],$_POST['pagetitle'],html_entity_decode($_POST['description']),$_POST['cities'],$_POST['startdate']);
			$wf="nl_id";
			$wv=$_POST['nl_id'];
			$dbObj->cupdt("tbl_nl_content", $set_field, $set_values,$wf,$wv,"");//exit;
// 			$_SESSION["msg"] = "<span class='success'>Newsletter Updated Successfully.</span>";
			$s=$msobj->showmessage(106);
	   		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

			header("location:".SITEROOT."/admin/globalsettings/newsletter/nlcontent.php");
		}

		else{
				$f_array = array("nl_name"		=> $_POST['pagename'],
						"nl_title" 		=> $_POST['pagetitle'],
						"nl_pagecontent"	=> html_entity_decode($_POST['description']),
						"city_id"		=> $_POST['cities'],
						"startdate"		=> $_POST['startdate']);
			//print_r($f_array);exit;

			$insertedId = $dbObj->cgii("tbl_nl_content",$f_array,"");//exit;
			unset($_SESSION["demorec"]);/*
			$_SESSION["msg"] = "<span class='success'>Newsletter Added Successfully.</span>";*/
			        $s=$msobj->showmessage(105);
	   			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".SITEROOT."/admin/globalsettings/newsletter/nlcontent.php");
		}
	}
else if($_POST['demo'])
{
$_SESSION["demorec"] = 			   array("nl_name" 		=> $_POST['pagename'],
						"nl_title" 		=> $_POST['pagetitle'],
						"nl_pagecontent"	=> html_entity_decode($_POST['description']),
						"city_id"		=> $_POST['cities'],
						"startdate"		=> $_POST['startdate']);

header("location:".SITEROOT."/admin/globalsettings/newsletter/edit_newsletter.php");
exit;

}
else if($_POST['cancle'])
{
			unset($_SESSION["demorec"]);
			header("location:".SITEROOT."/admin/globalsettings/newsletter/nlcontent.php");
			exit;
}

	if($nl_id!='')
	{
		$cd="nl_id = ".$nl_id;
		$dbres = $dbObj->gj('tbl_nl_content', "*" , $cd, "", "","", "", "");
		$row = @mysql_fetch_assoc($dbres);
		$smarty->assign("row",$row);
		$_nlcontents = html_entity_decode($row['nl_pagecontent']);
	}

if($_nlcontents)
{
$_contents=$_nlcontents;
}
else
{
$_contents=$cityid['nl_pagecontent'];
}


	$res11 = $dbObj->cgs("mast_city","*","","ORDER BY","city_name","","");
	//$_re1 = $dbObj->cgs("tbl_deal_category","","status","Active","","","");
	//print_r($_res11);
	while($_req = @mysql_fetch_assoc($res11))
	{
		$_arr1[] = $_req;
	}
	$smarty->assign("categories1",$_arr1);

// 	$_re1 = $dbObj->cgs("tbl_product","","deal_status","0","","","");
// 
// 	while($_req = @mysql_fetch_assoc($_re1))
// 	{
// 		$_deals[] = $_req;
// 	}
// 	$smarty->assign("deals",$_deals);

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


	$smarty->display(TEMPLATEDIR.'/admin/globalsettings/newsletter/edit_newsletter.tpl');

?>
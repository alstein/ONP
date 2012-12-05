<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");
	

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

			?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
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
			?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
		}
	}

$rs=$dbObj->cgs("sitesetting","","id",$_GET['id'],"","","");
$row=@mysql_fetch_assoc($rs);
$smarty->assign("row",$row);

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

include("../../../editor/fckeditor.php");

	$oFCKeditor = new FCKeditor('description') ;
	$oFCKeditor->BasePath = '../../../editor/';
	$oFCKeditor->Value = $_contents;
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '500';
	$smarty->register_object("oFCKeditor", $oFCKeditor);

$smarty->display( TEMPLATEDIR.'/admin/globalsettings/message-center/add-message.tpl');

?>

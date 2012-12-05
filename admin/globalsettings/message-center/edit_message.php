<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("20", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

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
		$_SESSION["msg"] = "<span class='success'>Message Deleted Successfully.</span>";
		?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?	
		exit;
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
else if($_POST['demo'])
{
$_SESSION["demorec"] = 			   array("nl_name" 		=> $_POST['pagename'],
						"nl_title" 		=> $_POST['pagetitle'],
						"nl_pagecontent"	=> html_entity_decode($_POST['description']),
						"city_id"		=> $_POST['cities'],
						"startdate"		=> $_POST['startdate']);

?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?	
		exit;

}
else if($_POST['cancle'])
{
			unset($_SESSION["demorec"]);
			?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?	
		exit;
}

	if($nl_id!='')
	{
		$cd="nl_id = ".$nl_id;
		$dbres = $dbObj->gj('tbl_nl_content', "*" , $cd, "", "","", "", "");
		$row = @mysql_fetch_assoc($dbres);
		$smarty->assign("row",$row);
		$_nlcontents = html_entity_decode(stripslashes($row['nl_pagecontent']));
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
//////////////////////////////old fckeditor start////////////////////
//         require_once '../../../ckfinder/ckfinder.php' ;
// 	include("../../../editor/fckeditor.php");
// 	$oFCKeditor = new FCKeditor('description') ;
// 	$oFCKeditor->BasePath = '../../../editor/';
// 	$oFCKeditor->Value = $_contents;
// 	$oFCKeditor->Width  = '100%';
// 	$oFCKeditor->Height = '250';
// 	$smarty->register_object("oFCKeditor", $oFCKeditor);
//////////////////////////////old fckeditor end////////////////////
        include_once '../../../ckeditor/ckeditor.php' ;
        require_once '../../../ckfinder/ckfinder.php' ;
        $ckeditor = new CKEditor('description') ; //
        $ckeditor->basePath	= '../../../ckeditor/' ;
        CKFinder::SetupCKEditor($ckeditor, '../../../' ) ;
        $initialValue = $_contents; //
        $editorcontentTitle= $ckeditor->editor("description", $initialValue, $config); //
        $smarty->assign("oFCKeditorDesc", $editorcontentTitle);
#-----------------------------------#
	if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}


	$smarty->display(TEMPLATEDIR.'/admin/globalsettings/message-center/edit_message.tpl');

?>
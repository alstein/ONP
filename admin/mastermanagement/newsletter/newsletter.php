<?php
	include_once("../../../include.php");


if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$row = array();
	$sf=array("nl_id,nl_name,nl_title");
	$dbres = $dbObj->cgs("tbl_nl_content", $sf,"", "", "", "", $ptr);
	while($row_title = @mysql_fetch_assoc($dbres)){
	$row[] = $row_title;
	}
	
	$smarty->assign("row",$row);

	$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/newsletter/newsletter.tpl');

?>

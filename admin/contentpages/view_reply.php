<?php
include_once('../../includes/SiteSetting.php');

header("location:".SITEROOT."/admin/index.php");
if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

$rs = $dbObj->cgs('tbl_contactus','*','cid',$_GET['id'],'','','');
$row = mysql_fetch_assoc($rs);
$smarty->assign('reply',$row);

	 $sql = "select r.* from tbl_contactus_reply as r,tbl_contactus as u where r.cid = u.cid and u.cid=".$_GET['id']." ORDER BY posted_date DESC";
	$qry = @mysql_query($sql);
	$array = array();
	while($row1 = @mysql_fetch_assoc($qry))
	{
		$array[] = $row1;
	}

	$smarty->assign("rep_array",$array);

if($_SESSION['msg'])
{
	$smarty->assign('msg',$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR . '/admin/contentpages/view_reply.tpl');

$dbObj->Close();
?>
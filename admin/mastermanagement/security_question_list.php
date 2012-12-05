<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Perform Action--------------#
if(isset($_POST['action'])){
	extract($_POST);
	$id = implode(", ", $id);

	if($_POST['action'] == "active")
	{
		$id=$dbObj->customqry("update security_question set active='1' where id in (". $id.")", "");
		$s=$msobj->showmessage(114);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	elseif($_POST['action'] == "inactive")
	{
		$qry = "update security_question set active='0' where id in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$s=$msobj->showmessage(115);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	elseif($_POST['action'] == "delete")
	{
		$id=$dbObj->customqry("delete from security_question where id in (". $id.")", "");
		$s=$msobj->showmessage(23);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
#--------END-------------#

/*------------Pagination Part-1------------*/
if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/

if(!isset($_GET['search']))
	$_GET['search'] = "";
$cnd= "c.question LIKE '%".$_GET['search']."%'";
$sf="c.*";
$ob="question";
$rs=$dbObj->gj("security_question c",$sf,$cnd, $ob, "", "", $l, "");
//security_question
while($row=@mysql_fetch_array($rs))
{
	$question[]=$row;
}
$smarty->assign("question",$question);

/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj("security_question c",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "security_question_list.php?search=" . $_GET['search'];
	else
		$firstlink = "security_question_list.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}




/*-----------------------------------*/
if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR . '/admin/mastermanagement/security_question_list.tpl');
?>
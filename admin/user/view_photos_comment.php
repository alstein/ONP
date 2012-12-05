<?php
//session_start();
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();


if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");

$userid=$_GET['userid'];
$res_firstname=$dbObj->gj("tbl_users","first_name","userid=".$userid,"","","","","");
$row_firstname=@mysql_fetch_assoc($res_firstname);
$firstname=$row_firstname['first_name'];
$smarty->assign("firstname",$firstname);
$smarty->assign("userid",$userid);
if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
        {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['comment_id']) == 0 || (!isset($_POST['comment_id'])))
        {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}

	extract($_POST);
	 $comment_id = @implode(", ", $comment_id);	
	if($action == "Active")
        {
		$id = $dbObj->customqry("update tbl_comment set status ='active' where comment_id  in (".$comment_id.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>Comment(s) Activated Sucessfully</span>";
		@header("location:".$_SERVER['HTTP_REFERER']);
		exit;
		
	}
	elseif($action == "inactivate")
	{
	
	
		$id = $dbObj->customqry("update tbl_comment set status = 'inactive' where comment_id  in (".$comment_id.")","");
		$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>Comment(s) Inactiveted Sucessfully</span>";
		@header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	elseif($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_comment where comment_id  in (".$comment_id.")","");
		$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>Comment Deleted Sucessfully</span>";
	}
	@header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}


ob_start();

$photoid =$_GET['photoid'];

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =15;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/


//--------------------------------------------------------------------------

// $userid=$_GET['userid'];
$photoid=$_GET['photoid'];
$smarty->assign("photoid",$photoid);
$tbl="tbl_albumphotos p,tbl_users u,tbl_comment c";
$sf="p.*,u.fullname,u.userid,c.*";
$cnd ="c.posted_by=u.userid and p.photo_id=c.photo_id and c.photo_id=".$_GET['photoid'];

if(isset($_GET['searchuser']))
{
	
	$search=$dbObj->sanitize($_GET['searchuser']);
	$cnd .= " AND (u.fullname  LIKE '%{$search}%' OR c.comment LIKE '%{$search}%'  OR c.posted_on LIKE '%{$search}%')";
}

$rs=$dbObj->gj($tbl, $sf, $cnd, "comment_id","","desc", $l, "");
//exit;
$i=0;
while($row=@mysql_fetch_array($rs)){
	$comment[]=$row;
	$i++;
}
//echo "<pre>"; print_r($comment);
/*-----------------------Pagination Part2--------------------*/
$rs1=$dbObj->gj($tbl, $sf, $cnd, "comment_id", "", "desc", "", "");
$nums =@mysql_num_rows($rs1);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");
    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if(isset($_GET['searchuser']))
    {
	    $firstlink = "view_photos_comment.php?userid=".$_GET['userid']."photoid=".$_GET['photoid']."&searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "view_photos_comment.php?userid=".$_GET['userid']."&photoid=".$_GET['photoid'];
	  $seperator = '&page=';
    }
        $baselink  = $firstlink;
        $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
        $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/


$smarty->assign("comment",$comment);
$smarty->assign("userid",$userid);

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/view_photos_comment.tpl');


$dbObj->Close();
?>
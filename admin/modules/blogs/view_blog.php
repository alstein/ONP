<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}

$bid = $_GET["bid"];

if($_POST["submit"] == "Post")
{
	extract($_POST);

		$fl = array("userid","blog_id","name","comment");
		$vl = array($_SESSION['duAdmId'],$bid,$_SESSION['duAdmFname']." ".$_SESSION['duAdmLname'],$comment);
		$rs = $dbObj->cgi('tbl_blog_comment',$fl,$vl,'');//exit;
		$s=$msobj->showmessage(214);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		
		header("location:".SITEROOT."/admin/modules/blogs/view_blog.php?bid=".$bid);
		exit;
}

if($_GET["act"] == "rmv")
{
	$id = $dbObj->customqry("delete from tbl_blog_comment where blog_id = ".$_GET['bid']." and id =".$_GET['cid'],"");
	$s=$msobj->showmessage(215);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	
	header("location:".SITEROOT."/admin/modules/blogs/view_blog.php?bid=".$bid);
	exit;
}

if($bid)
{
	$selectBlog = $dbObj->customqry("SELECT tb.*,mc.city_name FROM tbl_blog tb left join mast_city mc on tb.city_id = mc.city_id WHERE tb.id=".$bid,"");
	$row=@mysql_fetch_array($selectBlog);
	$smarty->assign("row",$row);

	$selectBlogcomm = $dbObj->customqry("SELECT * FROM tbl_blog_comment WHERE blog_id=".$bid." order by posted_date desc","");
	while($roww=@mysql_fetch_array($selectBlogcomm))
		$comments[] = $roww;
	$smarty->assign("comments",$comments);
}

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/modules/blogs/view_blog.tpl');

$dbObj->Close();
?>
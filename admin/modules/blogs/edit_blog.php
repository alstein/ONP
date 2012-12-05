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

if($_POST["submit"] == "Save")
{
	extract($_POST);

		if($bid != "")
		{
			$fl = array("title","meta_keyword","meta_description","date","city_id","description");
			$vl = array($title,$metakeyword,$metadescription,$date,$city_id,$description);
			$rs = $dbObj->cupdt("tbl_blog", $fl, $vl, "id", $bid, "");
			$s=$msobj->showmessage(212);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

			header("location:".SITEROOT."/admin/modules/blogs/blog_list.php");
			exit;
		}
		else
		{
			$fl = array("userid","title","meta_keyword","meta_description","date","city_id","description");
			$vl = array($_SESSION['duAdmId'],$title,$metakeyword,$metadescription,$date,$city_id,$description);
			$rs = $dbObj->cgi('tbl_blog',$fl,$vl,'');//exit;
			//$_SESSION['msg'] = "Category added.";
			$s=$msobj->showmessage(213);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

			header("location:".SITEROOT."/admin/modules/blogs/blog_list.php");
			exit;
		}
}

if($bid)
{
	$selectBlog = $dbObj->customqry("SELECT * FROM tbl_blog WHERE id=".$bid,"");
	$row=@mysql_fetch_array($selectBlog);
	$smarty->assign("row",$row);
}

//fetching city start//

$selectCity = $dbObj->customqry("SELECT * FROM mast_city WHERE status='Active'","");
while($row=@mysql_fetch_assoc($selectCity))
	$city[] = $row;
$smarty->assign("city",$city);

//fetching city end//

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/modules/blogs/edit_blog.tpl');

$dbObj->Close();
?>
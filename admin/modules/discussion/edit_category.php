<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/classes/class.forum.php");
//include_once("../../../include.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

$forumObj=new Forum();

if(isset($_POST['category']))
{   
	extract($_POST);
	if($categoryid)
	{
			$sqlcat = $dbObj->customqry("SELECT * FROM tbl_category WHERE categoryid !=".$categoryid." and category = '".$category."'","");
			$chkcat=mysql_num_rows($sqlcat); 
			//echo $chkcat;exit; 
			if($chkcat != "")
			{
			$s=$msobj->showmessage(125);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}

		$set_field = array('moduleid', 'category' , 'description', 'status' );
		$set_values = array(3, trim($category) , trim($description) , $status);
		$dbres = $dbObj->cupdt('tbl_category', $set_field , $set_values, 'categoryid' ,  $categoryid , "0");
		$_SESSION['msg']="<span class='success'>Category Updated Successfully.</span>";
	}
	else
	{
			$sqlcat = $dbObj->customqry("SELECT * FROM tbl_category WHERE category = '".$category."'","");
			$chkcat=mysql_num_rows($sqlcat); 
			//echo $chkcat;exit; 
			if($chkcat != "")
			{
			$s=$msobj->showmessage(125);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}		
		$set_field = array('moduleid', 'category' , 'description', 'status');
		$set_values = array(3, trim($category), trim($description) , $status);
		$dbres = $dbObj->cgi('tbl_category', $set_field , $set_values , "");
		$_SESSION['msg']="<span class='success'>Category Added Successfully.</span>";
	}
	header("location:".SITEROOT."/admin/modules/discussion/categories.php");
	exit;
}


if($_GET['categoryid'])
{
	$category = $forumObj->getCategory($_GET['categoryid']);
	$smarty->assign("category", $category);
}


if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}



$smarty->assign("header", TEMPLATEDIR."/admin/header1.tpl");
$smarty->assign("footer",TEMPLATEDIR."/admin/footer.tpl");
$smarty->display(TEMPLATEDIR . '/admin/modules/discussion/edit_category.tpl');

$dbObj->Close();
?>
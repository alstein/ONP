<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();

if(!$_SESSION['duAdmId'])
{
        header("location:".SITEROOT . "/admin/login/_welcome.php");
}


if(isset($_POST['submit']))
{   
	extract($_POST);
	extract($_GET);
	if($_GET['id'])
	{
		$set_field = array( 'category_name' , 'description', 'status');
		$set_values = array($category , $description , $status);
		$dbres = $dbObj->cupdt('tbl_deal_category', $set_field , $set_values, 'cate_id' ,  $id , "0");
      		$s=$msobj->showmessage(287);
	   	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		//$_SESSION['msg'] = "<span class='succcess'>Category Updated Successfully</span>";
	}
	else
	{
		$fields = array( 'category_name' , 'description', 'status');
		$values = array( $category , $description , $status );
		$dbres = $dbObj->cgi('tbl_deal_category', $fields , $values , "0");
     		 $s=$msobj->showmessage(288);
	   	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		//$_SESSION['msg'] = "<span class='succcess'>Category Added Successfully</span>";
	}
	header("Location:manage_deal_category.php");
	exit;
}


if(isset($_GET['id']))
{
	$cd = "cate_id = ".$_GET['id'];
	//$rs = $dbObj->gj("faq_cat as c", "c.*, (select count(x.f_cat_id) from tbl_faqs as x where x.f_cat_id=c.f_cat_id) as faqs" , "1", "", "", "", "", "");
	$dbres = $dbObj->gj('tbl_deal_category', "*" , $cd, "", "","", "", "");
	$row = @mysql_fetch_assoc($dbres);
	$smarty->assign("category", $row);
}

// $smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/deal/add_deal_cat.tpl');

$dbObj->Close();

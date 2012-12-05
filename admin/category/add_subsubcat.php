<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once("../../includes/function.php");
header("location:".SITEROOT."/admin/index.php");
if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

$msobj= new message();

#-----------------Add/edit sub category-------------------#
if(isset($_POST['task']) && $_POST['task'] == 'save')
{
	extract($_POST);


	if($_GET['id'] != "")
	{
	    $id = $dbObj->cupdt("mast_deal_category", array("category ","category_type"),array($category,$category_type), "id",$_GET['id'], "");

	    $s=$msobj->showmessage(247);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

	}
        else 
        {

	    $set_field = array('userid','category','category_type','parent_id','date','active');
	    $set_values = array($_SESSION['duAdmId'],$category,$category_type,$_GET['cat_id'],date("Y-m-d"),1);

	    $id = $dbObj->cgi("mast_deal_category",$set_field,$set_values, "");

	    $s=$msobj->showmessage(248);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".SITEROOT."/admin/category/subsubcat.php?cat_id={$_GET['cat_id']}");
	exit;
}
#-------------End Add/edit sub category----------------#

//  $category=$msobj->getCategoryname($_GET['cat_id']);
//  $smarty->assign("subcatname",$category['category']);
//  $smarty->assign("subcatid",$category['id']);
//  
//  $maincategory=$msobj->getCategoryname($category['parent_id']);
//  $smarty->assign("maincatname",$maincategory['category']);
//  $smarty->assign("maincatid",$maincategory['id']);
//  
 
 
////////////////////////////////////////////////////
//START Get category level Hirarchy and it's id
if($_GET['cat_id'] > 0)
{
	$smarty->assign("categoryHirarchy",getCategoryLevelOrder(recursiveCategory($_GET['cat_id']))); //functions are written in /includes/function.php file
}
//END Get category level Hirarchy and it's id
////////////////////////////////////////////////////



#----------------Get category info--------------#
if(isset($_GET['id'])!="")
{
    $rs = $dbObj->cgs("mast_deal_category", "*", "id", $_GET['id'], "", "", "");
    $row=@mysql_fetch_assoc($rs);

    //get parent / main category name
    $rs_mCat = $dbObj->cgs("mast_deal_category", "*", "id", $row['parent_id'], "", "", "");
    $row_mCat=@mysql_fetch_assoc($rs_mCat);
    $row['mainCatname'] = $row_mCat['category'];
    
    $smarty->assign("result", $row);
}else
{
    //get parent / main category name
    $rs_mCat = $dbObj->cgs("mast_deal_category", "*", "id", $_GET['cat_id'], "", "", "");
    $row_mCat=@mysql_fetch_assoc($rs_mCat);
    $smarty->assign("mainCatname",$row_mCat['category']);
}
#----------------Get category info--------------#

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR . '/admin/category/add_subsubcat.tpl');
$dbObj->Close();
?>
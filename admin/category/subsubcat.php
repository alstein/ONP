<?php
include_once("../../includes/paging.php");
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once("../../includes/function.php");

header("location:".SITEROOT."/admin/index.php");
$msobj= new message();

if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/_welcome.php");
}


if(isset($_POST['action']))
{
	extract($_POST);

	if($catid!='')
	{

	    $id = implode(", ", $catid);

	    if($action == "delete")
	    {
		    $temp = $dbObj->customqry("delete from mast_deal_category where id in (".$id.")","");

		    $s=$msobj->showmessage(246);
		    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	    }
	    elseif($action=='active')
	    {
		    $temp = $dbObj->customqry("update mast_deal_category set active = 1 where id in (".$id.")", "");
		    $s=$msobj->showmessage(244);
		    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	    }
	    elseif($action=='inactive')
	    {
		    $temp = $dbObj->customqry("update mast_deal_category set active = 0 where id in (".$id.")", "");
		    $s=$msobj->showmessage(245);
		    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	    }

	    header("Location:".$_SERVER['HTTP_REFERER']);
	    exit;
        }
}
#---------END-------------#

#----------------Get all categories--------------#

//  $category=$msobj->getCategoryname($_GET['cat_id']);
//  $smarty->assign("subcatname",$category['category']);
//  $smarty->assign("subcatid",$category['id']);
//  
//  $maincategory=$msobj->getCategoryname($category['parent_id']);
//  $smarty->assign("maincatname",$maincategory['category']);
//  $smarty->assign("maincatid",$maincategory['id']);
//echo "<pre>";
//echo $category['category'];
//print_r($maincategory);
//exit;

////////////////////////////////////////////////////
//START Get category level Hirarchy and it's id
if($_GET['cat_id'] > 0)
{
	$smarty->assign("categoryHirarchy",getCategoryLevelOrder(recursiveCategory($_GET['cat_id']))); //functions are written in /includes/function.php file
}
//END Get category level Hirarchy and it's id
////////////////////////////////////////////////////

/*------------Pagination Part-1------------*/
$page=1;
if(!isset($_GET['page']))
{
	$page =1;
}
else
{
	$page=$_GET['page'];
	$page = $page;
}
$adsperpage =15;
$StartRow = $adsperpage * ($page-1);
if($_GET['view'] == 'excel')
	$l="";
else
	$l =  $StartRow.','.$adsperpage;
/*-----------------------------------*/

if($_GET['cat_id'])
{
	//get parent / main category name
	$rs_mCat = $dbObj->customqry("select dc1.*,dc2.category 'maincategory' from mast_deal_category dc1, mast_deal_category dc2 where dc1.id = ".$_GET['cat_id']." and dc1.parent_id = dc2.id", "");
	$row_mCat=@mysql_fetch_assoc($rs_mCat);
	$smarty->assign("mainCatname",$row_mCat['category']);

	#----code for excel report----#
	if($_GET['view'] == 'excel')
	{
		$out ="Main Category : ".$row_mCat['maincategory'];
		$out .="\n";
		$out .="Sub Category : ".$row_mCat['category'];
		$out .="\n";
		$out .="\n";
		$out .="Sub Sub Categories List";
		$out .="\n";
		$out .="\n";
		$out .='Sub Category Name,No of Category,Add Date,Status';
		$out .="\n";
		$out .="\n";
	}
	#----code end-----------------#

	$rs_cat = $dbObj->gj("mast_deal_category", "*" , "parent_id ={$_GET['cat_id']}", "category", "", "", $l, "");
	if($rs_cat != 'n')
	{
		$i=0;
		while($row=@mysql_fetch_assoc($rs_cat))
		{
			$rw_cat[$i]=$row;
			$r_cnt = $dbObj->gj("mast_deal_category","count(id) as tot","parent_id = {$row['id']}","","","","","");
			$tmp = @mysql_fetch_assoc($r_cnt);
			if($tmp['tot'])
				$rw_cat[$i]['tot'] = $tmp['tot'];
			else
				$rw_cat[$i]['tot'] = 0;

		////////////STRAT getting count of deal category images//////////
		$r_imgCnt = $dbObj->gj("tbl_deal_category_images","count(id) as tot","deal_cat_id = {$row['id']}","","","","","");
			$row_img = @mysql_fetch_assoc($r_imgCnt);
			if($row_img['tot'])
				$rw_cat[$i]['imgTot'] = $row_img['tot'];
			else
				$rw_cat[$i]['imgTot'] = 0;
		////////////END getting count of deal category images//////////	
			if($_GET['view'] == 'excel')
			{
				#---code for csv report-----#
				$out .= '"'.$row['category'].'","'.$rw_cat[$i]['tot'].'","'.$row['date'].'","'.($row['active']?'Active':'Inactive').'"';
				$out .= "\n";
				#----code end---#
			}
			$i++;
		}
		$smarty->assign("sub_cat",$rw_cat);
	}
}

/*-----------------------Pagination Part2--------------------*/
$rs1 = $dbObj->gj("mast_deal_category", "*" , "parent_id ={$_GET['cat_id']}", "category", "", "", "", "");
$nums =@mysql_num_rows($rs1);

$smarty -> assign("recordsFound",$nums);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;

$firstlink = "subsubcat.php?cat_id={$_GET['cat_id']}";
$seperator = '&page=';
$baselink  = $firstlink; 

$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pgnation",$pgnation);
/*-----------------------------------*/

#----code for csv report-------#
if($_GET['view'] == 'excel')
{
	header("Content-type: text/x-csv");
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=Buyer-details.csv");	
	echo $out;
	exit;
}
#----code end------#

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/category/subsubcat.tpl');

$dbObj->Close();
?>

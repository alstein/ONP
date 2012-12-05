<?
	include_once("../../include.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Perform Action--------------#
if(isset($_POST['action'])){
	extract($_POST);
	$id = implode(",", $stateid);

	if($_POST['action'] == "active")
	{
		$id=$dbObj->customqry("update mast_state set active='1' where id in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(132)."</span>";
	}
	elseif($_POST['action'] == "inactive")
	{
		$qry = "update mast_state set active='0' where id in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(131)."</span>";
	}
	elseif($_POST['action'] == "delete")
	{
		$id=$dbObj->customqry("delete from mast_state where id in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(130)."</span>";
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
#--------END-------------#


/*------------Pagination Part-1------------*/

	$countries = ($_GET['countries']?$_GET['countries']:0);
	$smarty->assign("countries",$countries);

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];						
	$adsperpage =100;							
	$StartRow = $adsperpage * ($page-1);			
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/

if(!isset($_GET['search']))
	$_GET['search'] = "";

	$cnd= "s.state_name LIKE '%".$_GET['search']."%'";

if($countries)
{
	$cnd.=" AND s.country_id =".$countries;
}

	$sf="s.*";
	
	$ob="state_name";
	
	$rs=$dbObj->gj("mast_state s",$sf,$cnd, $ob, "", "", $l, "");
			
	while($row=@mysql_fetch_array($rs))
	{
		$state[]=$row;
	}
	$smarty->assign("state",$state);

/*----------Pagination Part-2--------------*/

$rs=$dbObj->gj("mast_state s",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){

	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "state_list.php?search=" . $_GET['search'];
	else
		$firstlink = "state_list.php?";
		$seperator = '&page=';
		$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$smarty -> assign("pgnation",$pgnation);
}


/* Get all countrys*/

	$rs=$dbObj->cgs("mast_countryname","*","","country","country","","");
	while($row=@mysql_fetch_assoc($rs))
	{
		$country[] = $row;
	}
	$smarty->assign("country",$country);

/*-----------------------------------*/
if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR . '/admin/mastermanagement/state_list.tpl');
?>
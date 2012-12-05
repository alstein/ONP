<?
	include_once("../../include.php");


if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}



if($_GET['cityid'])
	{
		$id=$dbObj->customqry("update mast_city set default_city='1' where city_id =".$_GET['cityid'], "");
		$id=$dbObj->customqry("update mast_city set default_city='0' where city_id !=".$_GET['cityid'], "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(58)."</span>";
	}	

#--------Perform Action--------------#
if(isset($_POST['action'])){
	extract($_POST);
	$id = implode(",", $city_id);


	if($_POST['action'] == "active"){
		$id=$dbObj->customqry("update mast_city set active='1' where city_id in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(57)."</span>";
	}

	elseif($_POST['action'] == "inactive"){
		$qry = "update mast_city set active='0' where city_id in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(56)."</span>";
	}

	elseif($_POST['action'] == "delete"){
		$_id=$dbObj->customqry("delete from mast_city where city_id in (".$id.")", "");
		$_id=$dbObj->customqry("delete from tbl_newsletter_users where city_id in (".$id.")", "");
		
		$_SESSION["msg"] = "<span class='success'>".getErrorMessage(55)."</span>";
	}

	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}

#-----------------END--------------------#


/*------------Pagination Part-1------------*/

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage = 50;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/

	$countries = ($_GET['countries']?$_GET['countries']:0);
	$smarty->assign("countries",$countries);
	$states = ($_GET['states']?$_GET['states']:0);
	$smarty->assign("states",$states);

if($countries > 0){
	$rs=$dbObj->cgs("mast_state","*","","state_name","state_name","","");
	while($row=@mysql_fetch_assoc($rs))
	{
		$state[] = $row;
	}
	$smarty->assign("state_con",$state);
}


if(!isset($_GET['search']))
	$_GET['search'] = "";

	$cnd= "c.city_name LIKE '%".$_GET['search']."%'";

if(($countries != '')&&($states != '')){
		$cnd.=" AND c.con_id =".$countries . " AND c.state_id=".$states . " ";
	}



	$sf="c.*";
	$ob="city_name";
	$rs=$dbObj->gj("mast_city c",$sf,$cnd, $ob, "", "", $l, "");

while($row=@mysql_fetch_array($rs))
{
	$city[]=$row;
}
$smarty->assign("city",$city);

/*----------Pagination Part-2--------------*/

$rs=$dbObj->gj("mast_city c",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "city_list.php?search=" . $_GET['search'];
	else
		$firstlink = "city_list.php?";
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


$smarty->display(TEMPLATEDIR . '/admin/mastermanagement/city_list.tpl');

?>
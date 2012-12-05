<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}

#--------Perform Action--------------#
if(isset($_POST['action'])){
	extract($_POST);
	$id = implode(",", $stateid);

	if($_POST['action'] == "active")
	{
		$id=$dbObj->customqry("update mast_state set active='1' where id in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>State activated successfully</span>";
	}
	elseif($_POST['action'] == "inactivate")
	{
		$qry = "update mast_state set active='0' where id in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>State inactivated successfully</span>";
	}
	elseif($_POST['action'] == "delete")
	{
		//delete all cities of state
		      $delCity = $dbObj->customqry("delete from mast_city where state_id in (". $id.")", "");		

		$id=$dbObj->customqry("delete from mast_state where id in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>State deleted successfully</span>";
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
#--------END-------------#


/*------------Pagination Part-1------------*/

	$countries = ($_GET['contryid']?$_GET['contryid']:0);
	$smarty->assign("countries",$countries);

	if(!isset($_GET['page']))
		$page =1;
	else
		$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/
                $sql_country = "Select * from mast_country where countryid =".$_GET['contryid'];
		$res_country = $dbObj->customqry($sql_country,0);
		$row_country = @mysql_fetch_assoc($res_country);
		
		if(!(@mysql_num_rows($res_country) > 0))
                {
                     header("location:".SITEROOT . "/admin/country/country_list.php");
                     exit;
                }
		  $smarty->assign("contryname",$row_country);
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
	$i=0;		
	while($row=@mysql_fetch_array($rs))
	{
	           $rs1 = $dbObj->customqry("select count(city_id) 'count' from mast_city where state_id = ".$row['id'],"");
                   $row1 = @mysql_fetch_assoc($rs1);
                   $row['city_count'] = $row1['count'];
                   $state[]=$row;		
		   $i++;
	}
	$smarty->assign("stateResult",$state);

/*----------Pagination Part-2--------------*/

$rs=$dbObj->gj("mast_state s",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$smarty -> assign("showpgnation", 'yes');
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "state_list.php?search=" . $_GET['search']."&contryid=".$_GET['contryid'];
	else
		$firstlink = "state_list.php?contryid=".$_GET['contryid'];
		$seperator = '&page=';
		$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$smarty -> assign("pgnation",$pgnation);
}
   //$rs=$dbObj->cgs("mast_countryname","*","","country","country","","");
	$rs=$dbObj->cgs("mast_countryname","*","active","1","country","","");
	while($row=@mysql_fetch_assoc($rs))
	{
		$country[] = $row;
	}
	$smarty->assign("country",$country);

/*-----------------------------------*/
if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/state/state_list.tpl');
?>
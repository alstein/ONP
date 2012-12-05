<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

header("location:".SITEROOT."/admin/index.php");EXIT;
if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}

if(isset($_POST['button']))
{
  header("location:".SITEROOT . "/admin/country/country_list.php?search='".$_POST['search']."'");
}
#--------Perform Action--------------#
if(isset($_POST['action'])){
	extract($_POST);
	$id = implode(", ", $countryid);

	if($_POST['action'] == "active")
	{
		$id=$dbObj->customqry("update mast_country set status='Active' where countryid in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>Country activated successfully</span>";
	}
	elseif($_POST['action'] == "inactivate")
	{
		$qry = "update mast_country set status='Inactive' where countryid in (". $id.")";
		$id=$dbObj->customqry($qry, "");
		$_SESSION["msg"] = "<span class='success'>Country inactivated successfully</span>";
	}
	elseif($_POST['action'] == "delete")
	{
		//delete all states of country
		      $sql_state="SELECT * FROM mast_state where country_id IN (". $id.")";
		      $rs_state=mysql_query($sql_state)or die(mysql_error());
		        while($row_state=@mysql_fetch_array($rs_state))
			{
				//delete all cities of state
				$delCity = $dbObj->customqry("delete from mast_city where state_id in (". $row_state['id'].")", "");
			}
		      $delState=$dbObj->customqry("delete from mast_state where country_id in (". $id.")", "");

		$id=$dbObj->customqry("delete from mast_country where countryid in (". $id.")", "");
		$_SESSION["msg"] = "<span class='success'>Country deleted successfully</span>";
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
#--------END-------------#

/*------------Pagination Part-1------------*/
if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/


// if($page==1)
// {
//                     $rs1 = $dbObj->customqry("select * from mast_country where countryid = 225","");
//                     $row1 = @mysql_fetch_assoc($rs1);
// 
//                     $rs11 = $dbObj->customqry("select count(country_id) 'count' from mast_state where country_id = 225","");
//                     $row11 = @mysql_fetch_assoc($rs11);
//                     $row1['country_count'] = $row11['count'];
//                     $country[] = $row1;
//                    $i++;
// }
// c.country LIKE '%".$_GET['search']."%' and
$cnd = "1";
$sf="c.*";
$ob="country";
if(isset($_GET['search']))
{

	$cnd .= " AND (country LIKE '%".$_GET['search']."%' OR vat LIKE '%".$_GET['search']."%' OR status LIKE '%".$_GET['search']."%' )";
}
//$rs1=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$rs=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$i=0;
while($row=@mysql_fetch_assoc($rs))
{
	//$country[]=$row;e

	$rs1 = $dbObj->customqry("select count(country_id) 'count' from mast_state where country_id = ".$row['countryid'],"");
                    $row1 = @mysql_fetch_assoc($rs1);
                    $row['country_count'] = $row1['count'];
                   $country[] = $row;
                   $i++;
}
// echo "<pre>";
// print_r($country);exit;
$smarty->assign("countryResult",$country);

/*----------Pagination Part-2--------------*/

$rs=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
	$smarty -> assign("showpgnation", 'yes');
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "country_list.php?search=" . $_GET['search'];
	else
		$firstlink = "country_list.php?";
	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}
/*-----------------------------------*/
if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR . '/admin/country/country_list.tpl');
?>
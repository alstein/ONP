<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/ajax_paging.php");
include_once("../../includes/JSON.php");

$json = new Services_JSON();

ob_start();
$sf="u.*,  t.usertype";
$cnd=" u.usertypeid = 1 and (u.first_name LIKE '%". trim($_GET['searchuser'])."%' OR u.last_name LIKE '%". trim($_GET['searchuser'])."%' OR u.email LIKE '%". $_GET['searchuser'] ."%') ";

$tbl="tbl_users u INNER JOIN mast_usertype t ON u.usertypeid = t.typeid";

if($_GET['sorttype']=='' || $_GET['sorttype']=='name')
	$ob = "u.first_name " . $_GET['sortord'] . "";
elseif($_GET['sorttype']=='username')
	$ob = "u.username " . $_GET['sortord'];
elseif($_GET['sorttype']=='signup')
	$ob = "u.signup_date " . $_GET['sortord'];

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))    $page =1;	else   $page = $page;
$newsperpage =10;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$rs=$dbObj->gj($tbl, $sf, $cnd, $ob, "", "", $l, "");

if($rs != 'n'){
	while($row=mysql_fetch_assoc($rs)){	
		
		//$users[]=$row;//echo"<pre>";print_r($users);
		if($row['access_level'] == 1)
			$row['access_level']="Accounts Level 1";
		elseif($row['access_level'] == 2)
			$row['access_level']="Marketing Level 2";
		elseif($row['access_level'] == 3)
			$row['access_level']="Programmer Level 3";
		elseif($row['access_level'] == 4)
			$row['access_level']="Administrator Level 4";
		elseif($row['access_level'] == 5)
			$row['access_level']="CEO Level 5";		
		$i++;
		$users[]=$row;
	}
	if(isset($users))
		$smarty->assign("users", $users);
}

/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1){
	$smarty->assign("showpgnation","yes");
	$showing   = !isset($_GET["page"]) ? 1 : $page;
  if($_GET['usertypeid'])	  $firstlink = "users_list.php?usertypeid=".$_GET['usertypeid'];
  else  	  $firstlink = "users_list.php";
  if($_GET['usertypeid'])	  $seperator = '&page=';
  else	  $seperator = '?page=';
	$baselink  = $firstlink;
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator);
	$smarty -> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

$smarty->display(TEMPLATEDIR . '/admin/user/ajax_admin_user_list.tpl');
$searchcontent=ob_get_contents();
ob_end_clean();

$response	= array("searchcontent"=>stripcslashes($searchcontent));
echo($json->encode($response));
$dbObj->Close();
?>
<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

// $json = new Services_JSON();

extract($_GET);
if(isset($_POST['submit'])){	
	if($_POST['action'] == "" || !isset($_POST['action'])){
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['userid']) == 0 || (!isset($_POST['userid']))){	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	extract($_POST);
	$userid = implode(", ", $userid);	
	if($action == "Active"){
		$id = $dbObj->customqry("update tbl_users set status = 'Active' where userid in (".$userid.")","");
				$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}elseif($action == "Suspended"){
		$id = $dbObj->customqry("update tbl_users set status = 'Suspended' where userid in (".$userid.")","");
				$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}elseif($action == "delete"){
		$id = $dbObj->customqry("delete from tbl_users where userid in (".$userid.")","");
				$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

// $json = new Services_JSON();

ob_start();
$sf="u.*,  t.usertype,(select state_name from mast_state where country_id=223 and mast_state.id=u.state) as state_name";
$cnd="u.usertypeid = 1 and (u.first_name LIKE '%". trim($_POST['searchuser'])."%' OR u.last_name LIKE '%". trim($_POST['searchuser'])."%' OR u.email LIKE '%". $_POST['searchuser'] ."%')";

$tbl="tbl_users u INNER JOIN mast_usertype t ON u.usertypeid = t.typeid";
if($_GET['usertypeid']){	$cnd.=" AND u.usertypeid =". $_GET['usertypeid'];	}
	
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
	$i=0;
	while($row=@mysql_fetch_assoc($rs)){
		
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
		$users[]=$row;//echo"<pre>";print_r($users);		
		$i++;
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
  if($_GET['usertypeid'])	  $firstlink = "admin_users_list.php?usertypeid=".$_GET['usertypeid'];
  else  	  $firstlink = "admin_users_list.php";
  if($_GET['usertypeid'])	  $seperator = '&page=';
  else	  $seperator = '?page=';
	$baselink  = $firstlink;
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator);
	$smarty -> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

//$smarty->display(TEMPLATEDIR . '/admin/user/ajax_admin_user_list.tpl');
// $searchcontent=ob_get_contents();
// ob_end_clean();
// 
// $response	= array("searchcontent"=>stripcslashes($searchcontent));
// echo($json->encode($response));

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/admin_users_list.tpl');

$dbObj->Close();
?>
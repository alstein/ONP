<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

// $json = new Services_JSON();
$user_id1=$_GET['user_id1'];	//update status active to suspended
if($user_id1!="")
{
		$id = $dbObj->customqry("update tbl_users set status = 'inactive' where userid in (".$user_id1.")","");
			$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
$user_id2=$_GET['user_id2']; //update status suspended to active
if($user_id2!="")
{
		$id = $dbObj->customqry("update tbl_users set status = 'active' where userid in (".$user_id2.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

}
extract($_GET);
if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
   {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['userid']) == 0 || (!isset($_POST['userid'])))
   {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	extract($_POST);
	$userid = implode(", ", $userid);	
	if($action == "Active")
   {
		$id = $dbObj->customqry("update tbl_users set status = 'active' where userid in (".$userid.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
   elseif($action == "Suspended")
   {
		$id = $dbObj->customqry("update tbl_users set status = 'inactive' where userid in (".$userid.")","");
				$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
   elseif($action == "delete")
   {
		$id = $dbObj->customqry("delete from tbl_users where userid in (".$userid.")","");
		//$id = $dbObj->customqry("update tbl_users set isDeleted = 1 where userid in (".$userid.")","");
		$s=$msobj->showmessage(124);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

// $json = new Services_JSON();

ob_start();
//$sf="u.*,  t.usertype,(select state_name from mast_state where country_id=223 and mast_state.id=u.state) as state_name";
$sf="u.*, t.usertype";
$cnd="u.usertypeid = 2 and isDeleted = 1 and (u.first_name LIKE '%". trim($_POST['searchuser'])."%' OR u.last_name LIKE '%". trim($_POST['searchuser'])."%' OR u.email LIKE '%". $_POST['searchuser'] ."%')";

$tbl="tbl_users u INNER JOIN mast_usertype t ON u.usertypeid = t.typeid";

if($_GET['city']){	$cnd.=" AND u.city LIKE'%". $_GET['city']."%'";	}
if($_GET['search_zipcode']){	$cnd.=" AND u.zipcode =". $_GET['search_zipcode'];	}
if($_GET['usertypeid']){	$cnd.=" AND u.usertypeid =". $_GET['usertypeid'];	}
if($_GET['searchuser']){	$cnd.=" AND u.first_name LIKE'%". $_GET['searchuser']."%' OR u.last_name LIKE'%". $_GET['searchuser']."%'" ;	}

	
if($_GET['sorttype']=='' || $_GET['sorttype']=='name')
	$ob = "u.first_name " . $_GET['sortord'] . ", u.first_name ". $_GET['sortord'];
elseif($_GET['sorttype']=='email')
	$ob = "u.email " . $_GET['sortord'];
elseif($_GET['sorttype']=='signup')
	$ob = "u.signup_date " . $_GET['sortord'];
elseif($_GET['sorttype']=='lname')
	$ob = "u.last_name " . $_GET['sortord'];
elseif($_GET['sorttype']=='city')
	$ob = "u.city" . $_GET['sortord'];

elseif($_GET['sorttype']=='gift_card_purchased')
	$ob = "u.tot_gift_card_bought" . $_GET['sortord'];
elseif($_GET['sorttype']=='gift_card_spent')
	$ob = "u.tot_gift_card_spent" . $_GET['sortord'];
elseif($_GET['sorttype']=='zipcode')
	$ob = "u.zipcode" . $_GET['sortord'];
elseif($_GET['sorttype']=='ccinfo')
	$ob = "u.cc_info" . $_GET['sortord'];
else 
$ob = "userid DESC";
/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))    $page =1;	else
    $page = $page;
$newsperpage =50;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$rs=$dbObj->gj($tbl, $sf, $cnd, "userid DESC", "", "", $l, "");

if($rs != 'n')
{
	$i=0;
	while($row=@mysql_fetch_assoc($rs))
   {
		$users[]=$row;//echo"<pre>";print_r($users);
// 		if($row['usertypeid'] == 1)
// 			$users[$i]['usertypeid'] = "Admin";
// 		elseif($row['usertypeid'] == 2)
// 			$users[$i]['usertypeid'] = "Ordinary User";

		$users[$i]['all_address'] = $row['address'].' '.$row['city'].'<br> '.$row['zipcode'];		
 		$i++;
	}
	if(isset($users))
	//print_r($users);
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

//$smarty->display(TEMPLATEDIR . '/admin/user/ajax_user_list.tpl');
// $searchcontent=ob_get_contents();
// ob_end_clean();
// 
// $response	= array("searchcontent"=>stripcslashes($searchcontent));
// echo($json->encode($response));

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}/*
	$sf1=array("id","state_name");
	$result1 = $dbObj->cgs('mast_state',$sf1,"" ,"", "" ,"" ,""); 
		while($row1=@mysql_fetch_assoc($result1))
		{
			$state1[]=$row1;
		}
	$smarty->assign("state",$state1);*/

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/delusers_list.tpl');

$dbObj->Close();
?>
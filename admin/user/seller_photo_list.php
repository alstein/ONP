<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");



if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
        {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['albumid']) == 0 || (!isset($_POST['albumid'])))
        {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}

	extract($_POST);
	 $albumid = @implode(", ", $albumid);	
	if($action == "Active")
        {
		$id = $dbObj->customqry("update tbl_album set status = 'active' where album_id  in (".$albumid.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		@header("location:".$_SERVER['HTTP_REFERER']);
		exit;
		
	}
	elseif($action == "inactivate")
	{
	
	
		$id = $dbObj->customqry("update tbl_album set status = 'inactive' where album_id  in (".$albumid.")","");
				$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		@header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	elseif($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_album where album_id  in (".$albumid.")","");
		$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	@header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}
ob_start();

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =15;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/


$sf="a.*,u.fullname";
$tbl="tbl_album a left join tbl_users u ON a.user_id =u.userid";
$cnd="a.user_id=".$_GET['userid'];
if($_GET['exel_id']!='')
{
    $cnd .= " and u.userid =".$_GET['exel_id'];
}

if(isset($_GET['searchuser']))
{
$search=$dbObj->sanitize($_GET['searchuser']);
$cnd = " a.album_title  LIKE '%{$search}%' OR u.fullname LIKE '%{$search}%'  ";
}
    $rs=$dbObj->gj($tbl, $sf, $cnd, "album_id", "", "DESC", $l, "");
    if($rs != 'n')
    {
	$i=0;
	while($row=@mysql_fetch_assoc($rs))
        {

		$select_photo=$dbObj->customqry("select * from tbl_albumphotos where album_id='".$row['album_id']."' order by photo_id asc","");
		$res_photo=@mysql_fetch_assoc($select_photo);
		  $users[$i]=$row;
		 $users[$i]['image']=$res_photo['thumbnail'];

            $i++;
	}
	$smarty->assign("users", $users);
    }
//echo "<pre>"; print_r($users);
/*-----------------------Pagination Part2--------------------*/
$rs1=$dbObj->gj($tbl, $sf, $cnd, "album_id", "", "DESC", "", "");
$nums =@mysql_num_rows($rs1);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");
    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if(isset($_GET['searchuser']))
    {
	    $firstlink = "seller_list.php?searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "seller_list.php";
	  $seperator = '?page=';
    }
        $baselink  = $firstlink;
        $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
        $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/seller_photo_list.tpl');
$dbObj->Close();
?>

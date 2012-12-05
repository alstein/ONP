<?
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}

if(isset($_POST['action']))
{
	extract($_POST);
	$ipid = implode(", ", $ipid);
if($ipid!='')
{
	if($action == "delete")
	{
		$temp = $dbObj->customqry("delete from tbl_ipban where ip_id in (".$ipid.")","");
	   	$_SESSION['msg']="<span class='success'>Record deleted successfully</span>";
	}	
	
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
}




/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
{
$page =1;
}
else
{
$page=$_GET['page'];
$page = $page;
}
$adsperpage =10;
$StartRow = $adsperpage * ($page-1);
$l =  $StartRow.','.$adsperpage;
/*-----------------------End Part1--------------------*/
//print_r($_POST);
$sf = "*";
$tbl = "tbl_ipban";
if($_POST['search'])
{
	$cnd = "domain LIKE '%". $_POST['search']."%'";
}
else
{
$cnd = 1;
}

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "ip_id", "DESC", $l, "");
while($row = @mysql_fetch_assoc($rs))
	$ip[] = $row;
	$smarty->assign("ip", $ip);

/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl, $sf , $cnd, "", "ip_id", "DESC", "", "");
if ($rs != 'n')
$nums = mysql_num_rows($rs);
$show = 5;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "ipban.php?search=" . $_GET['search'];
	else
		$firstlink = "ipban.php?";
	$seperator = '&page=';
	$baselink  = $firstlink; 
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}


if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}



$smarty->display(TEMPLATEDIR . '/admin/modules/ipban/ipban.tpl');

$dbObj->Close();
?>
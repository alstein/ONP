<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once("../../../includes/function.php");

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("67", $arr_modules_permit)) )
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	 $userid = implode(", ", $userid);
	//$listingid = implode(", ", $listingid);
	if($userid!='')
	{
		if($action == "delete")
		{
			$temp = $dbObj->customqry("delete from tbl_newsletter where nid in (".$userid.")","");
                        $s=$msobj->showmessage(158);
			//$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			$_SESSION['msg']="<span class='success'>Subscribe user deleted successfully.</span>";
		}
		header("Location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
}
#---------END-------------#

/*------------Pagination Part1------------*/
if(!isset($_GET['page']))
{
	$page =1;
}
else
{
	$page=$_GET['page'];
	$page = $page;
}

$adsperpage =20;
$StartRow = $adsperpage * ($page-1);
$l =  $StartRow.','.$adsperpage;
/*-------------End Part1--------------*/

extract($_POST);


$tbl = "tbl_newsletter as n";

if(isset($_GET['searchuser']))
    $cnd = "n.nemail LIKE '%{$_GET['searchuser']}%'  or n.city LIKE '%{$_GET['searchuser']}%' or n.zipcode LIKE '%{$_GET['searchuser']}%'";
else
    $cnd = "1";

$rs = $dbObj->gj($tbl, "n.*" , $cnd, "nid", "", "DESC", $l, "");
$i=0;

while($row = @mysql_fetch_assoc($rs))
{
	$subscriber[$i] = $row;
	$cityname=getCityDetFromId($row['city']);
	$subscriber[$i]['city_name']=$cityname['city_name'];
	$i++;
}
$smarty->assign("subscriber", $subscriber);

//print_r($subscriber);
/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl,$sf,$cnd, "", "", "", "", "");
if ($rs != 'n')
	$nums = mysql_num_rows($rs);
$show =20;
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1)
{
	$showing= !isset($_GET["page"]) ? 1 : $page;

	if($_GET['searchuser'] != '')
        {
		$firstlink = "subscribe-list.php?searchuser=" .$_GET['searchuser'];
		$seperator = '&page=';
        }
	else
        {
	     $firstlink = "subscribe-list.php";
	     $seperator = '?page=';
        }

	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation); //print_r($pgnation);
}
/*-----------------------End Part2--------------------*/

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}


$smarty->display(TEMPLATEDIR . '/admin/modules/subscribe/subscribe-list.tpl');

$dbObj->Close();
?>
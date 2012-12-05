<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/array_to_csv.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
	
#------------Delete All records----------------#
if(isset($_POST['action'])){
	extract($_POST);
	$logid = implode(',', $log);
	$dbObj->customqry("delete from tbl_admin_login_log where id in (".$logid.")", "");
	
	$_SESSION['msg'] = "<span class='success'>Login Details Deleted Successfully</span>";
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------------------End-------------------------#

$sf="l.*";
$cnd="1";
$tbl="tbl_admin_login_log AS l";

#------------------Pagination Part1---------------#
$page=$_GET['page'];
if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;
$newsperpage =30;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
#-----------------End Part1--------------------#

$ob="l.id"; $ot="DESC";

if($_GET['sortby'])
{
    switch($_GET['sortby'])
    {
          case first_name:
                        $ob = "l.username"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_name", "DESC");
                        else
                          $smarty->assign("sorttype_name", "ASC");
                        break;
          case signup_date:
                        $ob = "l.login_date"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_signup", "DESC");
                        else
                          $smarty->assign("sorttype_signup", "ASC");
                        break;
          case signup_out:
                        $ob = "l.logout_date"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_out", "DESC");
                        else
                          $smarty->assign("sorttype_out", "ASC");
                        break;
          case ip_address:
                        $ob = "l.ipaddress"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_ipaddress", "DESC");
                        else
                          $smarty->assign("sorttype_ipaddress", "ASC");
                        break;
    }
}

$rs=$dbObj->gj($tbl, $sf, $cnd, $ob, "", $ot, $l, ""); 
if($rs != 'n'){
	while($row=@mysql_fetch_assoc($rs)){
		$users[]=$row;
	}

	$smarty->assign("users", $users);
}
#-----------------------Pagination Part2------------#
$rs=$dbObj->gj($tbl, $sf, $cnd, $ob, "", $ot, "", ""); 
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;

	if(!empty($_GET['sortby']))
	$firstlink = "admin-login-log.php?sortby=".$_GET['sortby']."&sorttype=".$_GET['sorttype'];

	else
	$firstlink = "admin-login-log.php?";
	$seperator = '&page=';
	$baselink  = $firstlink; 
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pagenation",$pagenation);
}
#-----------------------End Part2------------------#


#-----------------Site Message------------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
#--------------------End------------------#

$smarty->display(TEMPLATEDIR . '/admin/login/admin-login-log.tpl');
$dbObj->Close();
?>
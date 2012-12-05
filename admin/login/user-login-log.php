<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/array_to_csv.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
	
#------------Delete All records----------------#
if(isset($_POST['action'])){
	extract($_POST);
	$logid = @implode(',', $log);
	$dbObj->customqry("delete from tbl_login_log where id in (".$logid.")", "");
	if($logid!="")
		$_SESSION['msg'] = "<span class='success'>Login Details Deleted Successfully</span>";
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------------------End-------------------------#

$sf="l.*,u.email,u.username,u.first_name,u.last_name,u.userid";
$cnd="u.usertypeid=2";
$tbl="tbl_users u RIGHT JOIN tbl_login_log AS l ON l.userid = u.userid";

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
                        $ob = "u.username"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_name", "DESC");
                        else
                          $smarty->assign("sorttype_name", "ASC");
                        break;
          case email:
                        $ob = "u.email"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_email", "DESC");
                        else
                          $smarty->assign("sorttype_email", "ASC");
                        break;
          case signup_date:
                        $ob = "l.login_date"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_signup", "DESC");
                        else
                          $smarty->assign("sorttype_signup", "ASC");
                        break;
          case signout_date:
                        $ob = "l.logout_date"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_signout", "DESC");
                        else
                          $smarty->assign("sorttype_signout", "ASC");
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
	$firstlink = "user-login-log.php?sortby=".$_GET['sortby']."&sorttype=".$_GET['sorttype'];

	else
	$firstlink = "user-login-log.php?";
	$seperator = '&page=';
	$baselink  = $firstlink; 
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pagenation",$pagenation);
}
#-----------------------End Part2------------------#


if(isset($_GET['view']) and $_GET['view'] == "excel")
{
	$sf="l.*,u.email,u.first_name,u.last_name,u.userid";
	$cnd="1";
	$tbl="tbl_users u RIGHT JOIN tbl_login_log AS l ON l.userid = u.userid";

    $rs = $dbObj->gj($tbl, $sf , $cnd, "id DESC", "", "", "", ""); 
    $arr = array();
    $arr[0]['srno'] = "Sr. No";
    $arr[0]['name'] = "Name";
    $arr[0]['email'] = "Email Address";
    $arr[0]['login_date'] = "Login Date";
    $arr[0]['logout_date'] = "Logout Date";
    $arr[0]['ipaddress'] = "IP Address";

    $i = 1; 
    while($row = mysql_fetch_assoc($rs))
    {
        $arr[$i]['srno'] = $i;

        $arr[$i]['name'] = $row['first_name']." ".$row['last_name'];
        $arr[$i]['email'] = $row['email'];
		$arr[$i]['login_date'] = $row['login_date'];
	if($arr[$i]['logout_date'] !="00.00.0000 00:00:00"){
		$arr[$i]['logout_date'] = $row['logout_date'];
	}else{
		$arr[$i]['logout_date'] = "00.00.0000";
	}
        $arr[$i]['ipaddress'] = $row['ipaddress'];

        $i++;
    }
    
    $out = Format::arr_to_csv($arr);

    header("Content-type: text/x-csv");
    header("Content-type: application/csv");
//            header("Content-Disposition: attachment; filename=deal".time().".csv");
    header("Content-Disposition: attachment; filename=accesslog.csv");
    echo $out;
    exit;
}

#-----------------Site Message------------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
#--------------------End------------------#

$smarty->display(TEMPLATEDIR . '/admin/login/user-login-log.tpl');
$dbObj->Close();
?>
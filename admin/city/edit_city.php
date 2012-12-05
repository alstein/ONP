<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


//$smarty->display(TEMPLATEDIR . '/admin/user/users_list.tpl');

$dbObj->Close();
?>
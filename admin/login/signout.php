<?php 
include_once('../../includes/SiteSetting.php');
// if($_SESSION['duAdmId']!=""){
// 		$query = "select max(id),userid,login_date from tbl_admin_login_log where ipaddress='".$_SERVER['REMOTE_ADDR']."' and userid = '".$_SESSION['duAdmId']."' group by userid";
// 		$res = @mysql_query($query);
// 		$numRow = @mysql_fetch_array($res);
// 
// 		if($numRow['max(id)'] != ""){
// 			$f_array = array("logout_date"	 	=> date("Y-m-d H:i:s"));
// 			$cond = "ipaddress='".$_SERVER['REMOTE_ADDR']."' and userid =".$_SESSION['duAdmId']." and id=".$numRow['max(id)'];
// 			$dbObj->cupdtii("tbl_admin_login_log",$f_array,$cond,"");
// 		}
// 	}

/*echo $_SESSION['login_log_id'];
exit;*/
if(isset($_SESSION['login_log_id']))
{
////////Update tbl_admin_login_log table details Start////////////

	$InsertedIdLog = $dbObj->customqry("update tbl_admin_login_log set logout_date = '".date("Y-m-d H:i:s")."' where id = ".$_SESSION['login_log_id'],"");

//////////Update tbl_admin_login_log table details End/////////////
}


session_destroy();

header("Location: ". SITEROOT ."/admin/index.php");
?>